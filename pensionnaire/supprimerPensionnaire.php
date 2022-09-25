<?php
    session_start();
    require_once( "../Modeles/connexion.php" );

    if( isset( $_POST["BoutonSupprimerPensionnaire"] ) )
    {
        $idPensionnaire = $_POST["IdPensionnaire"];

        $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens , nom_et_prenom FROM pensionnaire WHERE id=$idPensionnaire" ) or die( $connexionMySQLi->error );
        $resultatSELECT = $resultatSELECT->fetch_assoc();
        $numeroPension = $resultatSELECT["num_pens"];
        $nomCompletPensionnaire = $resultatSELECT["nom_et_prenom"];

        if( isset( $_POST["TousSupprimer"] ) )
        {
            $connexionMySQLi->query( "DELETE FROM bon_de_caisse WHERE num_engag IN (SELECT num_engag FROM dossier WHERE num_pens ='$numeroPension')" ) or die( $connexionMySQLi->error );
            $connexionMySQLi->query( "DELETE FROM dossier WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
        }
        else
        {
            $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM dossier WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );
            if( $resultatSELECT->num_rows >= 1 ) $connexionMySQLi->query( "INSERT INTO pensionnaire_absent (num_pens) VALUES ('$numeroPension')" ) or die( $connexionMySQLi->error );
        }
        $connexionMySQLi->query( "DELETE FROM pensionnaire WHERE id=$idPensionnaire" ) or die( $connexionMySQLi->error );
        
        $_SESSION["message"] = "Le pensionnaire N° $numeroPension $nomCompletPensionnaire a bien été supprimé!";
        $_SESSION["typeMessage"] = "danger";

        header( "location:pensionnaire.php" );
    }

?>