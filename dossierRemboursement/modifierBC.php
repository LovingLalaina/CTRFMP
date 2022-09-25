<?php
    session_start();
    require_once("../Modeles/connexion.php");
    
    if( isset( $_POST["BoutonModifierBC"] ) )
    {
        $idBC = $_POST["IdBC"];
        $numeroChemise = $_POST["NumeroChemise"];
        $anneeExercice = $_POST["AnneeExercice"];
        $numeroOrdreBC = $_POST["NumeroOrdreBC"];
        require_once( "../Fonctions/formatEngag.php" );
        $numeroEngagement = formatEngag( $_POST["AnneeEngagement"] , $_POST["NumeroEngagement"] );
        $numeroBordereau = substr( formatEngag( $_POST["AnneeBordereau"] , $_POST["NumeroBordereau"] ) , 3 , 16 );
        require_once("../Fonctions/securisation.php");
        $montantBC = securisation( $_POST["MontantBC"] , "typeMontant" );
        $dateArrivee = $_POST["DateArrivee"];

        $etatDossier = $_POST["EtatDossier"];
        $dateDelivrance = $_POST["DateDelivrance"];
        
        $resultatSELECT = $connexionMySQLi->query( "SELECT num_engag, montant_def FROM bon_de_caisse WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' AND num_ordre_BC='$numeroOrdreBC' AND id!='$idBC' )" ) or die( $connexionMySQLi->error );

        //TEST RAHA EFA AO LE NUMERO TELO
        if( $resultatSELECT->num_rows >= 1 )
        {
            $resultatSELECT = $resultatSELECT->fetch_assoc();

            require_once( "../Fonctions/formatArgent.php" );
            $_SESSION["message"] = "Le bon de caisse N° $numeroOrdreBC de la chemise ($numeroChemise-$anneeExercice) existe déja<br/>N° Engagement : ".$resultatSELECT["num_engag"]." et Montant : ".formatArgent( $resultatSELECT["montant_def"] );
            $_SESSION["typeMessage"] = "danger";
            $_SESSION["idBC"] = $idBC;

            header( "location:dossierRemboursement.php" );
        }
        else
        {
            //METY LE NUMERO TELO
            //TESTONS LE NUMERO D'ENGAGEMENT
            $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM dossier WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );
            if( $resultatSELECT->num_rows <= 0 )
            {
                $_SESSION["message"] = "Désolé, Le numero d'Engagement $numeroEngagement n'existe pas";
                $_SESSION["typeMessage"] = "danger";
                $_SESSION["idBC"] = $idBC;
    
                header( "location:dossierRemboursement.php" );
            }
            else 
            {
                //LE NUMERO D'engagement EXISTE !!!!
                $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM dossier WHERE ( num_engag='$numeroEngagement' AND ( etat IN ('engage','liquide') ) )" ) or die( $connexionMySQLi->error );
                if( $resultatSELECT->num_rows >= 1 )
                {
                    //LE NUMERO EXISTE UN SEUL ET PAS DE BON CAISSE ASSOCIE DONC MODIFICATION VALIDEE ET DOSSIER CHANGE AUSSI
                    $ancienInformation = $connexionMySQLi->query( "SELECT num_chemise, annee_exercice, num_engag FROM bon_de_caisse WHERE id='$idBC'" ) or die( $connexionMySQLi->error );
                    $ancienInformation = $ancienInformation->fetch_assoc();

                    switch( $etatDossier )
                    {
                        case "arrivee" : 
                            $connexionMySQLi->query( "UPDATE bon_de_caisse SET num_chemise='$numeroChemise' , annee_exercice='$anneeExercice' , num_ordre_BC='$numeroOrdreBC' , num_engag='$numeroEngagement' , num_bord='$numeroBordereau' , montant_def='$montantBC' , date_arrivee='$dateArrivee' WHERE id='$idBC'" ) or die( $connexionMySQLi->error );
                            $connexionMySQLi->query( "UPDATE dossier SET etat='arrivee' WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );
                            $ancienNumeroEngagement = $ancienInformation["num_engag"];
                            $connexionMySQLi->query( "UPDATE dossier SET etat='liquide' WHERE num_engag='$ancienNumeroEngagement'" ) or die( $connexionMySQLi->error );
                            break;
                        case "delivre" :
                            $connexionMySQLi->query( "UPDATE bon_de_caisse SET num_chemise='$numeroChemise' , annee_exercice='$anneeExercice' , num_ordre_BC='$numeroOrdreBC' , num_engag='$numeroEngagement' , num_bord='$numeroBordereau' , montant_def='$montantBC' , date_arrivee='$dateArrivee' , date_delivrance='$dateDelivrance' WHERE id='$idBC'" ) or die( $connexionMySQLi->error );
                            $connexionMySQLi->query( "UPDATE dossier SET etat='delivre' WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );
                            $ancienNumeroEngagement = $ancienInformation["num_engag"];
                            $connexionMySQLi->query( "UPDATE dossier SET etat='liquide' WHERE num_engag='$ancienNumeroEngagement'" ) or die( $connexionMySQLi->error ); 
                    }

                    //MODIFICATION ACHEVE DONC REVERIFICATION DU CHEMISE_ABSENT SI LA CHEMISE N'EST PLUS UTILE
                    $ancienNumeroChemise = $ancienInformation["num_chemise"];
                    $ancienAnneeExercice = $ancienInformation["annee_exercice"];

                    $resultatSELECT = $connexionMySQLi->query( "SELECT chemise_absent.num_chemise, chemise_absent.annee_exercice FROM chemise_absent JOIN bon_de_caisse ON ( chemise_absent.num_chemise=bon_de_caisse.num_chemise AND chemise_absent.annee_exercice=bon_de_caisse.annee_exercice ) WHERE (chemise_absent.num_chemise='$ancienNumeroChemise' AND chemise_absent.annee_exercice='$ancienAnneeExercice')" ) or die( $connexionMySQLi->error );
                    if( $resultatSELECT->num_rows <= 0 )//CELA VEUT DIRE QUE SI LA CHEMISE ETAIT DEJA ABSENTE MAIS APRES MODIFICATION, ELLE NE SE TROUVE PLUS DANS BON DE CAISSE DONC ON SUPPRIME LA CHEMISE DE ABSENT
                        $connexionMySQLi->query( "DELETE FROM chemise_absent WHERE ( num_chemise='$ancienNumeroChemise' AND annee_exercice='$ancienAnneeExercice' )" ) or die( $connexionMySQLi->error );

                    //MISE A JOUR DU PENSIONNAIRE
                    require_once( "../Fonctions/pensionnaireSuivant.php" );
                    $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier WHERE num_engag='$numeroEngagement' )" ) or die( mysqli_error( $connexionMySQLi ) );

                    //VERIFICATION SI LA NOUVELLE CHEMISE EST ENREGISTREE OU NON
                    $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM chemise WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$annee_exercice' )" ) or die( $connexionMySQLi->error );
                    if( $resultatSELECT->num_rows <= 0 )
                    {
                        $_SESSION["message"] = "Le Bon de caisse a bien été modifié mais la chemise $numeroChemise - $anneeExercice n'est pas enregistrée";
                        $_SESSION["typeMessage"] = "danger";
                        $_SESSION["ajoutChemise"] = "important";
                        $_SESSION["numeroChemise"] = $numeroChemise;
                        $_SESSION["anneeExercice"] = $anneeExercice;
                        $_SESSION["couleurChemise"] = "blanc";

                        $chemiseDejaAbsente = $connexionMySQLi->query( "SELECT id FROM chemise_absent WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
                        if( $chemiseDejaAbsente->num_rows <= 0 ) $connexionMySQLi->query( "INSERT INTO chemise_absent ( num_chemise , annee_exercice ) VALUES ( '$numeroChemise' , '$anneeExercice' )" ) or die( $connexionMySQLi->error );

                        header( "location:../chemise/chemise.php" );
                    }
                    else
                    {
                        $_SESSION['message'] = "Le Bon de Caisse N° $numeroOrdreBC Chemise N° $numeroChemise-$anneeExercice a bien été modifié!";
                        $_SESSION['typeMessage'] = "warning";

                        header( "location:dossierRemboursement.php" );
                    }
                }
                else
                {
                    //LE NUMERO EXISTE ET UN SEUL MAIS LE NUM D'ENGAGEMENT EST ARRIVEE OU DELIVRE
                    //VERIFIONS SI CE NUM D'ENGAGEMENT EST LE BC ACTUEL EN MODIFICATION OU NON
                    $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM bon_de_caisse WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );
                    $resultatSELECT = ( $resultatSELECT->fetch_assoc() )["id"];
                    if( $resultatSELECT != $idBC )
                    {
                        //LE NUMERO D'ENGAGEMENT EST UN AUTRE DOSSIER DONC MODIFICATION IMPOSSIBLE
                        $_SESSION["typeMessage"] = "danger";
                        $_SESSION["message"] = "Désolé, Le numero d'Engagement $numeroEngagement correspond déjà à un autre Bon de caisse<br/>Veuillez réessayer";
                        $_SESSION["idBC"] = $idBC;
            
                        header( "location:dossierRemboursement.php" );
                    }
                    else
                    {
                        //LE NUMERO ENTRE EST EXACTEMENT LE MEME QUE CELUI DU BC QUE JE MODIFIE DONC MODIFICATION VALIDEE

                        $ancienInformation = $connexionMySQLi->query( "SELECT num_chemise, annee_exercice FROM bon_de_caisse WHERE id='$idBC'" ) or die( $connexionMySQLi->error );
                        $ancienInformation = $ancienInformation->fetch_assoc();

                        switch( $etatDossier )
                        {
                            case "arrivee" : 
                                $connexionMySQLi->query( "UPDATE bon_de_caisse SET num_chemise='$numeroChemise' , annee_exercice='$anneeExercice' , num_ordre_BC='$numeroOrdreBC' , num_bord='$numeroBordereau' , montant_def='$montantBC' , date_arrivee='$dateArrivee' WHERE id='$idBC'" ) or die( $connexionMySQLi->error );
                            break;
                            case "delivre" :
                                $connexionMySQLi->query( "UPDATE bon_de_caisse SET num_chemise='$numeroChemise' , annee_exercice='$anneeExercice' , num_ordre_BC='$numeroOrdreBC' , num_bord='$numeroBordereau' , montant_def='$montantBC' , date_arrivee='$dateArrivee' , date_delivrance='$dateDelivrance' WHERE id='$idBC'" ) or die( $connexionMySQLi->error );                          
                        }

                        //ATTENTION !!!!!!!!!!!!!!!!!!
                        //REPETITION DE CODE !!!!!!!!!!!!!!!!!!
                        //MODIFICATION ACHEVE DONC REVERIFICATION DU CHEMISE_ABSENT SI LA CHEMISE N'EST PLUS UTILE
                        $ancienNumeroChemise = $ancienInformation["num_chemise"];
                        $ancienAnneeExercice = $ancienInformation["annee_exercice"];
                        $resultatSELECT = $connexionMySQLi->query( "SELECT chemise_absent.num_chemise, chemise_absent.annee_exercice FROM chemise_absent JOIN bon_de_caisse ON ( chemise_absent.num_chemise=bon_de_caisse.num_chemise AND chemise_absent.annee_exercice=bon_de_caisse.annee_exercice ) WHERE (chemise_absent.num_chemise='$ancienNumeroChemise' AND chemise_absent.annee_exercice='$ancienAnneeExercice')" ) or die( $connexionMySQLi->error );
                        if( $resultatSELECT->num_rows <= 0 )//CELA VEUT DIRE QUE SI LA CHEMISE ETAIT DEJA ABSENTE MAIS APRES MODIFICATION, ELLE NE SE TROUVE PLUS DANS BON DE CAISSE DONC ON SUPPRIME LA CHEMISE DE ABSENT
                            $connexionMySQLi->query( "DELETE FROM chemise_absent WHERE ( num_chemise='$ancienNumeroChemise' AND annee_exercice='$ancienAnneeExercice' )" ) or die( $connexionMySQLi->error );

                        //MISE A JOUR DU PENSIONNAIRE
                        require_once( "../Fonctions/pensionnaireSuivant.php" );
                        $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier WHERE num_engag='$numeroEngagement' )" ) or die( mysqli_error( $connexionMySQLi ) );
                        
                        //VERIFICATION SI LA NOUVELLE CHEMISE EST ENREGISTREE OU NON
                        $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM chemise WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
                        if( $resultatSELECT->num_rows <= 0 )
                        {
                            $_SESSION["message"] = "Le Bon de caisse a bien été modifié mais la chemise $numeroChemise - $anneeExercice n'est pas enregistrée";
                            $_SESSION["typeMessage"] = "danger";
                            $_SESSION["ajoutChemise"] = "important";
                            $_SESSION["numeroChemise"] = $numeroChemise;
                            $_SESSION["anneeExercice"] = $anneeExercice;
                            $_SESSION["couleurChemise"] = "blanc";
                            
                            $chemiseDejaAbsente = $connexionMySQLi->query( "SELECT id FROM chemise_absent WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
                            if( $chemiseDejaAbsente->num_rows <= 0 ) $connexionMySQLi->query( "INSERT INTO chemise_absent ( num_chemise , annee_exercice ) VALUES ( '$numeroChemise' , '$anneeExercice' )" ) or die( $connexionMySQLi->error );

                            header( "location:../chemise/chemise.php" );
                        }
                        else
                        {
                            $_SESSION['message'] = "Le Bon de Caisse N° $numeroOrdreBC Chemise N° $numeroChemise-$anneeExercice a bien été modifié!";
                            $_SESSION['typeMessage'] = "warning";

                            header( "location:dossierRemboursement.php" );
                        }
                    }
                }
            }
        }
    }

?>