<?php
    session_start();
    require_once( "../Modeles/connexion.php");

    if( isset( $_POST["BoutonAjouterUtilisateur"] ) )
    {
        require_once( "../Fonctions/securisation.php" );
        $nomUtilisateur = $_POST["NomUtilisateur"];
        $motDePasse = $_POST["MotDePasse"];
        $motDePasseConfirmation = $_POST["MotDePasseConfirmation"];
        $typeUtilisateur = $_POST["TypeUtilisateur"];

        //TEST SI L'UTILISATEUR EXISTE DEJA 
        $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM utilisateur WHERE ( nom_utilisateur='$nomUtilisateur' AND type_utilisateur='$typeUtilisateur' )" ) or die( $connexionMySQLi->error );

        if( $resultatSELECT->num_rows >= 1 )
        {
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            
            $_SESSION["message"] = "L' utilisateur $nomUtilisateur existe déja !!!<br/>Veuillez réessayer s'il vous plait";
            $_SESSION["typeMessage"] = "danger";

            //POUR LE MODAL AJOUTER 
            $_SESSION["ajoutUtilisateur"] = "echec";
            $_SESSION["nomUtilisateur"] = $nomUtilisateur;
            $_SESSION["typeUtilisateur"] = $typeUtilisateur;
            $_SESSION["motDePasse"] = $motDePasse;
            $_SESSION["motDePasseConfirmation"] = $motDePasseConfirmation;

            header( "location:utlisateur.php" );
        }
        else
        {
            $_SESSION["message"] = "L'utilisateur $nomUtilisateur a bien été ajouté! ($typeUtilisateur)";
            $_SESSION["typeMessage"] = "success";

            if( $typeUtilisateur == "admin" )
                $connexionMySQLi->query( "UPDATE utilisateur SET type_utilisateur='user' WHERE type_utilisateur='admin'" ) or die( $connexionMySQLi->error );

            
            //ADDSLASH EMPECHE LES PROBLEMES D'APOSTROPHE
            $nomUtilisateur = addslashes( $nomUtilisateur );
            $motDePasse = addslashes( $motDePasse );
            $connexionMySQLi->query( "INSERT INTO utilisateur ( nom_utilisateur , mot_de_passe , type_utilisateur ) VALUES( '$nomUtilisateur' , '$motDePasse' , '$typeUtilisateur' )" ) or die( $connexionMySQLi->error );

            header( "location:utilisateur.php" );
        }
    }
   

?>