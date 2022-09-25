<?php
    session_start();
    require_once( "../Modeles/connexion.php");

    if( isset( $_POST["BoutonPreparerEtude"]) )
    {
        $anneeReception = $_POST["AnneeReception"];
        $numeroDossierDebut = $_POST["NumeroDossierDebut"];
        $numeroDossierFin = $_POST["NumeroDossierFin"];

        $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM dossier WHERE ( etat='recu' AND year(date_recep)='$anneeReception' AND ( TRIM( 'R4-' FROM TRIM( '-BIS' FROM TRIM( '-$anneeDossierAfficher' FROM TRIM( '-P' FROM num_dossier ) ))) BETWEEN $numeroDossierDebut AND $numeroDossierFin ) )" ) or die( $connexionMySQLi->error );
        $nombreDossierEtudiable = $resultatSELECT->num_rows;

        if( $nombreDossierEtudiable <= 0 )
        {
            //AUCUN DOSSIER RECU N'A ETE TROUVE
            $_SESSION["message"] = "Désolé, Nous n'avons pas trouvé de dossier uniquement reçu entre FM $numeroDossierDebut et $numeroDossierFin<br/>Veuillez réessayer";
            $_SESSION["typeMessage"] = "danger";
            $_SESSION["etudeDossier"] = "echec";
            $_SESSION["anneeReception"] = $anneeReception;
            $_SESSION["numeroDossierDebut"] = $numeroDossierDebut;
            $_SESSION["numeroDossierFin"] = $numeroDossierFin;

            header( "location:dossierRemboursement.php" );
        }
        else 
        {
            $_SESSION["message"] = "Il y a $nombreDossierEtudiable Dossier(s) reçu en attente d'étude<br/>Veuillez rentrer les montants définitifs si nécessaire";
            $_SESSION["typeMessage"] = "success";
            header( "location:dossierRemboursement.php?etude=true&anneeRecep=$anneeReception&numDeb=$numeroDossierDebut&numFin=$numeroDossierFin" );
        }
    }

?>