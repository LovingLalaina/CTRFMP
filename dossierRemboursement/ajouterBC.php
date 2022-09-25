<?php
    session_start();
    require_once( "../Modeles/connexion.php");
    
    if( isset( $_POST["BoutonAjouterBC"] ) )
    {
        $numeroChemise = $_POST["NumeroChemise"];
        $anneeExercice = $_POST["AnneeExercice"];
        $numeroOrdreBC = $_POST["NumeroOrdreBC"];
        require_once( "../Fonctions/formatEngag.php" );
        $numeroEngagement = formatEngag( $_POST["AnneeEngagement"] , $_POST["NumeroEngagement"] );
        require_once( "../Fonctions/securisation.php" );
        $numeroPension = securisation( $_POST["NumeroPension"] , "typeNumero");
        $numeroBordereau = substr( formatEngag( $_POST["AnneeBordereau"] , $_POST["NumeroBordereau"] ) , 3 , 16 );
        $montantBC = securisation( $_POST["MontantBC"] , "typeMontant" );
        $dateArrivee = $_POST["DateArrivee"];

        $resultatSELECT = $connexionMySQLi->query( "SELECT num_chemise, annee_exercice, num_ordre_BC, num_engag FROM bon_de_caisse WHERE (num_engag='$numeroEngagement' OR (num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' AND num_ordre_BC='$numeroOrdreBC') )" ) or die( $connexionMySQLi->error );

        if( $resultatSELECT->num_rows >= 1 )
        {
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            $numeroChemise = $resultatSELECT["num_chemise"];
            $anneeExercice = $resultatSELECT["annee_exercice"];
            $numeroOrdreBC = $resultatSELECT["num_ordre_BC"];
            $numeroEngagement = $resultatSELECT["num_engag"];
            
            $_SESSION["message"] = "Le Bon de Caisse de N° d'engagement $numeroEngagement existe déja (Chemise : $numeroChemise - $anneeExercice, N°Ordre $numeroOrdreBC ) !!!";
            $_SESSION["typeMessage"] = "danger";

            $_SESSION["ajoutBC"] = "echec";
            $_SESSION["numeroChemise"] = $_POST["NumeroChemise"];
            $_SESSION["anneeExercice"] = $_POST["AnneeExercice"];
            $_SESSION["numeroOrdreBC"] = $numeroOrdreBC;
            $_SESSION["numeroEngagement"] = $numeroEngagement;
            $_SESSION["numeroPension"] = securisation( $_POST["NumeroPension"] , "typeNumero");
            $_SESSION["numeroBordereau"] = $numeroBordereau;
            $_SESSION["montantBC"] = $_POST["MontantBC"];
            $_SESSION["dateArrivee"] = $dateArrivee;

            header( "location:dossierRemboursement.php" );
        }
        else
        {
            // TEST SI LE DOSSIER CORRESPONDANT AU NUMERO D'ENGAGEMENT EXISTE REELEMENT
            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM dossier WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );

            if( $resultatSELECT->num_rows <= 0 )
            {
                $_SESSION["message"] = "Désolé le dossier de réference $numeroEngagement n'est pas enregistré !!! Veuillez reajouter le Bon de caisse";
                $_SESSION["typeMessage"] = "danger";

                $_SESSION["ajoutBC"] = "echec";
                $_SESSION["numeroChemise"] = $numeroChemise;
                $_SESSION["anneeExercice"] = $anneeExercice;
                $_SESSION["numeroOrdreBC"] = $numeroOrdreBC;
                $_SESSION["numeroEngagement"] = $numeroEngagement;
                $_SESSION["numeroPension"] = securisation( $numeroPension , "typeNumero");
                $_SESSION["numeroBordereau"] = $numeroBordereau;
                $_SESSION["montantBC"] = $_POST["MontantBC"];
                $_SESSION["dateArrivee"] = $dateArrivee;

                header( "location:dossierRemboursement.php" );
            }
            else
            {
                //LE NUMERO D'ENGAGEMENT EXISTE
                //TEST SI LA CHEMISE EXISTE SINON INSERTION DANS CHEMISE ABSENT
                $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM chemise WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( "3" );
                
                require_once( "../Fonctions/pensionnaireSuivant.php" );

                if( $resultatSELECT->num_rows <= 0 )
                {
                    $_SESSION["message"] = "Le Bon de Caisse a bien été reçu mais la chemise $numeroChemise - $anneeExercice n'est pas enregistrée!";
                    $_SESSION["typeMessage"] = "danger";

                    $chemiseDejaAbsent = $connexionMySQLi->query( "SELECT id FROM chemise_absent WHERE (num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice')" ) or die( $connexionMySQLi->error );
                    if( $chemiseDejaAbsent->num_rows <= 0 ) $connexionMySQLi->query( "INSERT INTO chemise_absent ( num_chemise , annee_exercice ) VALUES ( '$numeroChemise' , '$anneeExercice' )" ) or die( $connexionMySQLi->error );

                    $_SESSION["ajoutChemise"] = "important";
                    $_SESSION["numeroChemise"] = $numeroChemise;
                    $_SESSION["anneeExercice"] = $anneeExercice;
                    $_SESSION["couleurChemise"] = "blanc";

                    $connexionMySQLi->query( "INSERT INTO bon_de_caisse ( num_chemise , annee_exercice , num_ordre_BC , num_engag , num_bord , montant_def , date_arrivee ) VALUES( '$numeroChemise' , '$anneeExercice' , '$numeroOrdreBC' , '$numeroEngagement' , '$numeroBordereau' , '$montantBC' , '$dateArrivee' )" ) or die( $connexionMySQLi->error );

                    //CHANGEMENT D'ETAT DU DOSSIER CORRESPONDANT
                    $connexionMySQLi->query( "UPDATE dossier SET etat='arrivee' WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );

                    $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier WHERE num_engag='$numeroEngagement' )" ) or die( mysqli_error( $connexionMySQLi ) );
                    
                    header( "location:../chemise/chemise.php" );
                }
                else
                {
                    $connexionMySQLi->query( "INSERT INTO bon_de_caisse ( num_chemise , annee_exercice , num_ordre_BC , num_engag , num_bord , montant_def , date_arrivee ) VALUES( '$numeroChemise' , '$anneeExercice' , '$numeroOrdreBC' , '$numeroEngagement' , '$numeroBordereau' , '$montantBC' , '$dateArrivee' )" ) or die( $connexionMySQLi->error );
    
                    //CHANGEMENT D'ETAT DU DOSSIER CORRESPONDANT
                    $connexionMySQLi->query( "UPDATE dossier SET etat='arrivee' WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );
    
                    //ON GET LA COULEUR
                    $couleurChemise = $connexionMySQLi->query( "SELECT couleur FROM chemise WHERE ( annee_exercice='$anneeExercice' AND num_chemise='$numeroChemise' )" ) or die( $connexionMySQLi->error );
                    $couleurChemise = ( $couleurChemise->fetch_assoc() )["couleur"];
    
                    $_SESSION["message"] = $couleurChemise != "blanc" ? "Le Bon de Caisse de $numeroPension est bien arrivé! N° Ordre : $numeroOrdreBC, chemise : N° $numeroChemise - $anneeExercice <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span>" : "Le Bon de Caisse de $numeroPension est bien arrivé! N° Ordre : $numeroOrdreBC, chemise : N° $numeroChemise - $anneeExercice";
                    $_SESSION["typeMessage"] = "success";

                    $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier WHERE num_engag='$numeroEngagement' )" ) or die( mysqli_error( $connexionMySQLi ) );
                    
                    header( "location:dossierRemboursement.php" );
                } 
            }
        }
    }
   

?>