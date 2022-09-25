<?php
    session_start();
    require_once( "../Modeles/connexion.php" );

    if( isset( $_POST["BoutonSupprimerUtilisateur"] ) )
    {
        $idUtilisateur = $_POST["IdUtilisateur"];

        $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM utilisateur WHERE id='$idUtilisateur'" ) or die( $connexionMySQLi->error );
        $resultatSELECT = $resultatSELECT->fetch_assoc();

        $nomUtilisateur = $resultatSELECT["nom_utilisateur"];
        $typeUtilisateur = $resultatSELECT["type_utilisateur"];

        if( $typeUtilisateur == "admin" )
        {
            $_SESSION["message"] = "Impossible de supprimer l'administrateur";
            $_SESSIOn["typeMessage"] = "danger";

            header( "location:utilisateur.php" );
        }
        else
        {
            $connexionMySQLi->query( "DELETE FROM utilisateur WHERE id='$idUtilisateur'" ) or die( $connexionMySQLi->error );
            
            $_SESSION["message"] = "L'utilisateur $nomUtilisateur a bien été supprimé";
            $_SESSIOn["typeMessage"] = "success";

            header( "location:utilisateur.php" );
        }
    }

?>