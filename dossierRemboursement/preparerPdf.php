<?php
    session_start();
    require_once( "../Modeles/connexion.php");
    

    if( isset( $_POST["BoutonPreparerPdf"]) )
    {
        $dateDebut = $_POST["DateDebut"];
        $dateFin = $_POST["DateFin"];
        $typePdf = $_POST["typePdf"];

        if( $typePdf == "DerniereSemaine" )
        {
            $dateFin = date( "Y-m-d" , time() );
            $dateDebut = date( "Y-m-d" , strtotime( $dateFin. "- 7 days" ) );

            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ( etat='arrivee' AND ( date_arrivee BETWEEN '$dateDebut' AND '$dateFin' ) )" ) or die( $connexionMySQLi->error );
            $nombreBCArriveeNonDelivre = $resultatSELECT->num_rows;

            $_SESSION["message"] = "_ $nombreBCArriveeNonDelivre Bon(s) de caisse arrivé(s) la semaine dernière (Non délivré)";
            $_SESSION["typeMessage"] = "success";
        }
        else
        {
            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ( etat='arrivee' AND ( date_arrivee BETWEEN '$dateDebut' AND '$dateFin' ) )" ) or die( $connexionMySQLi->error );
            $nombreBCArriveeNonDelivre = $resultatSELECT->num_rows;

            $_SESSION["message"] = "_ $nombreBCArriveeNonDelivre Bon(s) de caisse arrivé(s) entre $dateDebut et $dateFin (Non délivré)";
            $_SESSION["typeMessage"] = "success";
        }

        header( "location:dossierRemboursement.php?pdf=$typePdf&deb=$dateDebut&fin=$dateFin" );
    }
?>