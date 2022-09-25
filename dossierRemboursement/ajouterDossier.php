<?php
    session_start();
    require_once( "../Modeles/connexion.php" );
    
    if( isset( $_POST["BoutonAjouterDossier"]) )
    {
        $cheminFichier = $_FILES["FichierDossier"]["tmp_name"];

        if( $cheminFichier == "" ) //CAS D'INSERTION MANUEL SANS FICHIER
        {
            $dateReception = $_POST["DateReception"];
            $numeroDossier = $_POST["NumeroDossier"];
            $anneeReception = $_POST["AnneeReception"];
            $bis = isset( $_POST["Bis"] );
            require_once( "../Fonctions/securisation.php" );
            $numeroPension = securisation( $_POST["NumeroPension"] , "typeNumero");
            $montantProvisoire = securisation( $_POST["MontantProvisoire"] , "typeMontant" );
            $sigleComptable = securisation( $_POST["SigleComptable"] , "typeSigle" );
            require_once( "../Fonctions/formatFM.php" );
            $numeroDossier = formatFM( $numeroDossier , $bis , $anneeReception , $montantProvisoire );

            //VERIFICATION SI LE NUMERO DE DOSSIER EST DEJA PRIS
            $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM dossier WHERE (num_dossier='$numeroDossier' AND year(date_recep)='$anneeReception')" ) or die( $connexionMySQLi->error );

            if( $resultatSELECT->num_rows >= 1 )
            {
                $resultatSELECT = $resultatSELECT->fetch_assoc();
                $_SESSION["message"] = "Le Dossier FM $numeroDossier existe déja (N° ".$resultatSELECT["num_pens"].") !!!";
                $_SESSION["typeMessage"] = "danger";

                $_SESSION["ajoutDossier"] = "echec";
                $_SESSION["dateReception"] = $dateReception;
                $_SESSION["numeroDossier"] = $numeroDossier;
                $_SESSION["bis"] = $bis;
                $_SESSION["anneeReception"] = $anneeReception;
                $_SESSION["numeroPension"] = $numeroPension;
                require_once( "../Fonctions/formatArgent.php" );
                $_SESSION["montantProvisoire"] = formatArgent( $montantProvisoire );
                $_SESSION["sigleComptable"] = $sigleComptable;

                header( "location:dossierRemboursement.php" );
            }
            else
            {
                //AJOUT VALIDE
                $requeteSQL = "SELECT num_pens FROM pensionnaire WHERE num_pens='$numeroPension'";
                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( "2" );
                
                if( $resultatSELECT->num_rows <= 0 )
                {
                    $_SESSION["message"] = "Le dossier FM $numeroDossier a bien été reçu mais le pensionnaire N° $numeroPension n'est pas enregistré!";
                    $_SESSION["typeMessage"] = "danger";

                    $pensionnaireDejaAbsent = $connexionMySQLi->query( "SELECT num_pens FROM pensionnaire_absent WHERE num_pens='$numeroPension'" ) or die( "hjgfhj");
                    if( $pensionnaireDejaAbsent->num_rows <= 0 ) $connexionMySQLi->query( "INSERT INTO pensionnaire_absent ( num_pens ) VALUES ( '$numeroPension' )" ) or die( "3" );

                    $_SESSION["ajoutPensionnaire"] = "important";
                    $_SESSION["numeroPension"] = $numeroPension;
                    $_SESSION["nomPensionnaire"] = "";
                    $_SESSION["prenomPensionnaire"] = "";
                    $_SESSION["adressePensionnaire"] = "";

                    $sigleComptable = addslashes( $sigleComptable );
                    $connexionMySQLi->query( "INSERT INTO dossier ( num_dossier , date_recep , num_pens , montant_prov , sigle_compt, etat ) VALUES( '$numeroDossier' , '$dateReception' , '$numeroPension' , '$montantProvisoire' , '$sigleComptable' , 'recu' )" ) or die( "azeze" );

                    header( "location:../pensionnaire/pensionnaire.php" );
                }
                else
                {
                    $sigleComptable = addslashes( $sigleComptable );
                    $connexionMySQLi->query( "INSERT INTO dossier ( num_dossier , date_recep , num_pens , montant_prov , sigle_compt, etat ) VALUES( '$numeroDossier' , '$dateReception' , '$numeroPension' , '$montantProvisoire' , '$sigleComptable' , 'recu' )" ) or die( "azeffrfdrf" );

                    require_once( "../Fonctions/pensionnaireSuivant.php" );
                    $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens='$numeroPension'" ) or die( mysqli_error( $connexionMySQLi ) );

                    $_SESSION["message"] = "Le dossier FM $numeroDossier a bien été reçu! ($numeroPension)";
                    $_SESSION["typeMessage"] = "success";

                    header( "location:dossierRemboursement.php" );
                }
            }
        }
        else //CAS D'INSERTION DE FICHIER SIGRFM
        {
            if( $_FILES["FichierDossier"]["size"] > 0 )
            {
                $monFichierDossier = fopen( $cheminFichier , "r" );
                $importation = 0;
                ini_set('max_execution_time', 0);
                while( ( $ligne = fgetcsv( $monFichierDossier , 10000 , ";" ) ) !== FALSE )
                {
                    $numeroDossier =$ligne[0];
                    require_once( "../Fonctions/formatEtatDossier.php" );
                    $etatDossier = formatEtatDossier( $ligne[1] );

                    if( $etatDossier == "undefined" )   continue;
                    else
                    {
                        $numeroPension = $ligne[2];
                        $nomPensionnaire = addslashes( $ligne[3] );
                        $dateReception = explode( " " , $ligne[4] )[0]; //FORMAT ACTUEL 24/09/2016
                        $dateReception = explode( "/" , $dateReception );// tableau contenant 24   09     et   2016
                        $anneeReception = $dateReception[2];
                        $dateReception = $dateReception[2]."-".$dateReception[1]."-".$dateReception[0];
                        $montantProvisoire = preg_replace( '/\s/' , '' , preg_replace( '/\.00/' , '' , $ligne[5] ) );
                        $montantDefinitif = preg_replace( '/\s/' , '' , preg_replace( '/\.00/' , '' , $ligne[6] ) );
                        $numeroTelephone = $ligne[7];
    
                        $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM pensionnaire WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
                        if( $resultatSELECT->num_rows <= 0 )
                            $connexionMySQLi->query( "INSERT INTO pensionnaire ( num_pens , nom_et_prenom , num_tel ) VALUES ( '$numeroPension' , '$nomPensionnaire' , '$numeroTelephone' )" ) or die( $connexionMySQLi->error );
                        else
                            $connexionMySQLi->query( "UPDATE pensionnaire SET nom_et_prenom='$nomPensionnaire' , num_tel='$numeroTelephone' WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
        
                        $resultatSELECT = $connexionMySQLi->query( "SELECT * , year( date_recep ) FROM dossier WHERE ( num_dossier='$numeroDossier' )" ) or die( $connexionMySQLi->error );
                        if( $resultatSELECT->num_rows >= 1 )
                        {
                            require_once( "../Fonctions/chiffre.php" );
                            $ancienEtat = chiffre( ( $resultatSELECT->fetch_assoc() )["etat"] );
                            $nouveauEtat = chiffre( $etatDossier );

                            if( $nouveauEtat >= $ancienEtat )
                                $connexionMySQLi->query( "UPDATE dossier SET etat='$etatDossier' , montant_prov='$montantProvisoire' , montant_def='$montantDefinitif' WHERE ( num_dossier='$numeroDossier' AND year( date_recep )='$anneeReception' )" ) or die( $connexionMySQLi->error );
                            else
                                $connexionMySQLi->query( "UPDATE dossier SET montant_prov='$montantProvisoire' , montant_def='$montantDefinitif' WHERE ( num_dossier='$numeroDossier' AND year( date_recep )='$anneeReception' )" ) or die( $connexionMySQLi->error );
                        }
                        else
                            $connexionMySQLi->query( "INSERT INTO dossier ( num_dossier , etat , num_pens , date_recep , montant_prov , montant_def ) VALUES ( '$numeroDossier' , '$etatDossier' , '$numeroPension' , '$dateReception' , '$montantProvisoire' , '$montantDefinitif' )" ) or die( $connexionMySQLi->error );
        
                        ++$importation;
                    }
                }
    
                $_SESSION["message"] = ( $importation != 0 ) ? "Importation de $importation Numéros(s) réussie" : "Aucun Numero n'a été importé";
                $_SESSION["typeMessage"] = ( $importation != 0 ) ? "success" : "danger";
    
                header( "location:dossierRemboursement.php" );
            }
        }

        
    }
   

?>