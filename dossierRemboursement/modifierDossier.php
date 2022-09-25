<?php
    session_start();
    require_once("../Modeles/connexion.php");
    
    if( isset( $_POST["BoutonModifierDossier"] ) )
    {
        $idDossier = $_POST["IdDossier"];
        $dateReception = $_POST["DateReception"];
        $numeroDossier = $_POST["NumeroDossier"];
        $anneeReception = $_POST["AnneeReception"];
        $bis = isset( $_POST["Bis"] );
        
        require_once("../Fonctions/securisation.php");
        $numeroPension = securisation( $_POST["NumeroPensionModif"] , "typeNumero");
        $montantProvisoire = securisation( $_POST["MontantProvisoire"] , "typeMontant" );
        $sigleComptable = securisation( $_POST["SigleComptable"] , "typeSigle" );

        $etatDossier = $_POST["EtatDossier"];
        $montantDefinitif = securisation( $_POST["MontantDefinitif"] , "typeMontant" );

        require_once("../Fonctions/formatEngag.php");
        $numeroEngagement = formatEngag( $_POST["AnneeEngagement"] , $_POST["NumeroEngagement"] );

        require_once( "../Fonctions/formatFM.php" );
        $numeroDossier = formatFM( $numeroDossier , $bis , $anneeReception , $montantProvisoire );
        
        //VERIFICATION SI LE DOSSIER EXISTE DEJA PAR NUMERO ET ANNEE DE RECEPTION
        
        $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens, montant_prov FROM dossier WHERE (num_dossier='$numeroDossier' AND year(date_recep)='$anneeReception' AND id!='$idDossier')" ) or die( $connexionMySQLi->error );
        
        if( $resultatSELECT->num_rows >= 1 )
        {
            //LE DOSSIER EXISTE DEJA DONC MODIFICATION IMPOSSIBLE
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            $numeroPension = $resultatSELECT["num_pens"];
            require_once( "../Fonctions/formatArgent.php" );
            $montantProvisoire = formatArgent( $resultatSELECT["montant_prov"] );
            
            $_SESSION["message"] = "Le dossier FM $numeroDossier existe déja, N°Pension : $numeroPension et Montant : $montantProvisoire";
            $_SESSION["typeMessage"] = "danger";
            $_SESSION["idDossier"] = $idDossier;

            header( "location:dossierRemboursement.php" );
        }
        else
        {
            //VERIFICATION SI LE NUMERO D'ENGAGEMENT ENTRE EXISTE DANS LA BASE DE DONNEE DONC MODIFICATION IMPOSSIBLE
            //MAINTENANT VERIFIONS SI LE NUMERO D'ENGAGEMENT ENTRE EST DEJA ASSIGNE A UN AUTRE DOSSIER
            $resultatSELECT = $connexionMySQLi->query( "SELECT num_dossier, year(date_recep) AS annee_recep FROM dossier WHERE (num_engag='$numeroEngagement' AND id!='$idDossier')" ) or die( $connexionMySQLi->error );

            if( $resultatSELECT->num_rows >= 1 )
            {
                //NUMERO D'ENGAGEMENT DEJA ASSIGNE DONC MODIFICATION IMPOSSIBLE
                $resultatSELECT->fetch_assoc();
                $numeroDossier = $resultatSELECT["num_dossier"];
                $anneeReception = $resultatSELECT["annee_recep"];
                $_SESSION["message"] = "Désolé, Le numero d'engagement $numeroEngagement est déjà assigné (FM $numeroDossier)";
                $_SESSION["typeMessage"] = "danger";
                $_SESSION["idDossier"] = $idDossier;

                header( "location:dossierRemboursement.php" );
            }
            else
            {
                //NUMERO D'ENGAGEMENT NON ASSIGNE OU LE MEME QUE LE NUMERO DU DOSSIER A MODIFIER DONC MODIFICAITON VALIDEE
                $ancienInformation = $connexionMySQLi->query( "SELECT num_engag, num_pens FROM dossier WHERE id='$idDossier'" ) or die( $connexionMySQLi->error );
                $ancienInformation = $ancienInformation->fetch_assoc();
                $sigleComptable = addslashes( $sigleComptable );
                
                switch( $etatDossier )
                {
                    case "recu"   : $requeteSQL = "UPDATE dossier SET num_pens='$numeroPension' , date_recep='$dateReception', num_dossier='$numeroDossier', montant_prov='$montantProvisoire' , sigle_compt='$sigleComptable' WHERE id='$idDossier'"; break;
                    case "etudie" : $requeteSQL = "UPDATE dossier SET num_pens='$numeroPension' , date_recep='$dateReception', num_dossier='$numeroDossier', montant_prov='$montantProvisoire' , montant_def='$montantDefinitif' , sigle_compt='$sigleComptable' WHERE id='$idDossier'"; break;
                    case "engage" :
                    case "liquide":
                    case "arrivee":
                    case "delivre":
                        $ancienNumeroEngagement = $ancienInformation["num_engag"];
                        //MODIFICATION DU BON DE CAISSE ASSOCIE AUSSI
                        $connexionMySQLi->query( "UPDATE bon_de_caisse SET num_engag='$numeroEngagement' WHERE num_engag='$ancienNumeroEngagement'" ) or die( $connexionMySQLi->error );
                        $requeteSQL = "UPDATE dossier SET num_pens='$numeroPension' , date_recep='$dateReception', num_dossier='$numeroDossier', montant_prov='$montantProvisoire' , montant_def='$montantDefinitif' , num_engag='$numeroEngagement' , sigle_compt='$sigleComptable' WHERE id='$idDossier'";
                }
                
                $connexionMySQLi->query( $requeteSQL ) or die( $connexionMySQLi->error );
                //MODIFICATION EFFECTUEE DONC REVERIFICATION DU PENSIONNAIRE_ABSENT
                $ancienNumeroPension = $ancienInformation["num_pens"];
                
                $resultatSELECT = $connexionMySQLi->query( "SELECT pensionnaire_absent.num_pens FROM pensionnaire_absent JOIN dossier ON pensionnaire_absent.num_pens=dossier.num_pens WHERE pensionnaire_absent.num_pens='$ancienNumeroPension'" ) or die( $connexionMySQLi->error );
                if( $resultatSELECT->num_rows <= 0 ) //CELA VEUT DIRE QUE SI LE NUMERO ETAIT DEJA DANS ABSENT MAIS APRES MODIFICATION, LE NUMERO NE SE TROUVE PLUS DANS DOSSIER DONC ON SUPPRIME DE ABSENT
                    $connexionMySQLi->query( "DELETE FROM pensionnaire_absent WHERE num_pens='$ancienNumeroPension'" ) or die( $connexionMySQLi->error );

                //VERIFICATION SI LE NOUVEAU NUMERO DE PENSION EST ENREGISTRE OU NON
                $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM pensionnaire WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
                if( $resultatSELECT->num_rows <= 0 )
                {
                    $_SESSION["message"] = "Le dossier FM $numeroDossier a bien été modifié mais Le numero de Pension $numeroPension n'est pas enregistré";
                    $_SESSION["typeMessage"] = "danger";
                    $_SESSION["ajoutPensionnaire"] = "important";
                    $_SESSION["numeroPension"] = $numeroPension;
                    $_SESSION["nomPensionnaire"] = "";
                    $_SESSION["prenomPensionnaire"] = "";
                    $_SESSION["adressePensionnaire"] = "";

                    $pensionnaireDejaAbsent = $connexionMySQLi->query( "SELECT num_pens FROM pensionnaire_absent WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
                    if( $pensionnaireDejaAbsent->num_rows <= 0 ) $connexionMySQLi->query( "INSERT INTO pensionnaire_absent (num_pens) VALUES ( '$numeroPension' )" ) or die( $connexionMySQLi->error );

                    header( "location:../pensionnaire/pensionnaire.php" );
                }
                else
                {
                    $_SESSION['message'] = "Le dossier FM $numeroDossier a bien été modifié!";
                    $_SESSION['typeMessage'] = "warning";

                    //MISE A JOUR DU PENSIONNAIRE
                    require_once( "../Fonctions/pensionnaireSuivant.php" );
                    $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens='$numeroPension'" ) or die( mysqli_error( $connexionMySQLi ) );

                    header( "location:dossierRemboursement.php" );
                }
            }
        }
    }

?>