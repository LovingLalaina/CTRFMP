<?php

    session_start();
    if( isset( $_POST["BoutonConfirmerMdp"] ) )
    {
        $motDePasse = $_POST["MotDePasse"];
        require_once( "../Modeles/connexion.php" );
        $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM utilisateur WHERE ( mot_de_passe='$motDePasse' AND type_utilisateur='admin' )" ) or die( $connexionMySQLi->error );
        
        if( $resultatSELECT->num_rows <= 0 )
            echo "<script>alert( 'Mot de Passe Incorrect!! Accès refusé' );window.history.back();</script>";
        else
        {
            $_SESSION["connexion"] = "admin";
            echo "<script>window.history.back();</script>";
        }
    }

?>
