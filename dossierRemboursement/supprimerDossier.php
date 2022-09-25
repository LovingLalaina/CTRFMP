<?php
    session_start();
    require_once( "../Modeles/connexion.php" );

    if( isset( $_POST["BoutonSupprimerDossier"] ) )
    {
        $idDossier = $_POST["IdDossier"];
        $numeroEngagement = $_POST["NumeroEngagement"];

        $connexionMySQLi->query( "DELETE FROM bon_de_caisse WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error ); 

        $resultatSELECT = $connexionMySQLi->query( "SELECT num_dossier, year(date_recep) AS annee_recep, num_pens FROM dossier WHERE id='$idDossier'" ) or die( $connexionMySQLi->error );
        $resultatSELECT = $resultatSELECT->fetch_assoc();
        $numeroDossier = $resultatSELECT["num_dossier"];
        $anneeReception = $resultatSELECT["annee_recep"];
        $numeroPension = $resultatSELECT["num_pens"];
        
        $connexionMySQLi->query( "DELETE FROM dossier WHERE id='$idDossier'" ) or die( $connexionMySQLi->error );

        //REVERIFICATION DU PENSIONNAIRE_ABSENT
        $resultatSELECT = $connexionMySQLi->query( "SELECT pensionnaire_absent.num_pens FROM pensionnaire_absent JOIN dossier ON pensionnaire_absent.num_pens=dossier.num_pens WHERE pensionnaire_absent.num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
        if( $resultatSELECT->num_rows <= 0 )    $connexionMySQLi->query( "DELETE FROM pensionnaire_absent WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
        
        $_SESSION["message"] = "Le dossier FM $numeroDossier a bien été supprimé ($numeroPension)";
        $_SESSION["typeMessage"] = "danger";

        require_once( "../Fonctions/pensionnaireSuivant.php" );
        $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier WHERE num_engag='$numeroEngagement' )" ) or die( mysqli_error( $connexionMySQLi ) );
        
        header( "location:dossierRemboursement.php" );
    }

?>