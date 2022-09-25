<?php
    session_start();
    require_once( "../Modeles/connexion.php");
    

    if( isset( $_POST["BoutonPreparerBilan"]) )
    {
        $annee = $_POST["Annee"];
        $mois = $_POST["Mois"];
        $mode = "mens";

        if( isset( $_POST["Trimestriel"] ) )
        {
            $mode="trim";
            require_once( "../Fonctions/trimestriel.php");
            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE year(date_arrivee)='$annee' AND month(date_arrivee) IN ".trimestriel( $mois ) ) or die( mysqli_error( $connexionMySQLi ) );
            $nombreBCArrivee = $resultatSELECT->num_rows;

            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE year(date_delivrance)='$annee' AND month(date_delivrance) IN ".trimestriel( $mois ) ) or die( mysqli_error( $connexionMySQLi ) );
            $nombreBCDelivre = $resultatSELECT->num_rows;   
        }
        else
        {
            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE year(date_arrivee)='$annee' AND month(date_arrivee)=$mois" ) or die( mysqli_error( $connexionMySQLi ) );
            $nombreBCArrivee = $resultatSELECT->num_rows;

            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE year(date_delivrance)='$annee' AND month(date_delivrance)=$mois" ) or die( mysqli_error( $connexionMySQLi ) );
            $nombreBCDelivre = $resultatSELECT->num_rows;

        }

        $_SESSION["message"] = "_ $nombreBCArrivee Bon(s) de caisse arrivé(s) et chemisé(s)<br/>_ $nombreBCDelivre Bon de caisse délivré(s)";
        $_SESSION["typeMessage"] = "success";

        header( "location:dossierRemboursement.php?bilan=$mode&annee=$annee&mois=$mois" );
    }
   
?>