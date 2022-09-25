<?php
    session_start();
    require_once("../Modeles/connexion.php");
    
    
    if( isset( $_POST["BoutonModifierUtilisateur"] ) )
    {
        $idUtilisateur = $_POST["IdUtilisateur"];
        $nomUtilisateur = $_POST["NomUtilisateur"];
        $motDePasse = $_POST["MotDePasse"];
        $motDePasseConfirmation = $_POST["MotDePasseConfirmation"];
        $typeUtilisateur = $_POST["TypeUtilisateur"];

        //RECHERCHE D'UTILISATEUR AYANT LE MEME NOM ET DANS LA MEME SECTION
        $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM utilisateur WHERE ( nom_utilisateur='$nomUtilisateur' AND id!='$idUtilisateur')" ) or die( $connexionMySQLi->error );

        if( $resultatSELECT->num_rows >= 1 )
        {
            // TROUVE DONC MODIFICATIONS IMPOSSIBLES
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            
            $_SESSION["message"] = "L'Utilisateur $nomUtilisateur existe déjà ($typeUtilisateur)";
            $_SESSION["typeMessage"] = "danger";
            $_SESSION["idUtilisateur"] = $idUtilisateur;

            header( "location:utilisateur.php" );
        }
        else
        {
            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM utilisateur WHERE ( id='$idUtilisateur' )" ) or die( $connexionMySQLi->error );

            $ancienType = ( $resultatSELECT->fetch_assoc() )["type_utilisateur"];
            if( $ancienType == "admin" && $typeUtilisateur != "admin" )
            {
                $_SESSION['message'] = "Modification Impossible, Il doit y avoir au moins un administrateur";
                $_SESSION['typeMessage'] = "danger";

                header( "location:utilisateur.php" );
            }
            else
            {
                //LA FONCTION ADDSLASH EMPECHE LES ERREURS SI LES ENTREES CONTIENNENT APOSTROPHES
                $nomUtilisateur = addslashes( $nomUtilisateur );
                $motDePasse = addslashes( $motDePasse );

                $connexionMySQLi->query( "UPDATE utilisateur SET nom_utilisateur='$nomUtilisateur' , mot_de_passe='$motDePasse' , type_utilisateur='$typeUtilisateur' WHERE id='$idUtilisateur'" )or die( $connexionMySQLi->error );

                //L'ANCIEN ADMIN DEVIENT USER NORMAL
                $connexionMySQLi->query( "UPDATE utilisateur SET type_utilisateur='user' WHERE ( type_utilisateur='admin' AND id!='$idUtilisateur' )" )or die( $connexionMySQLi->error );

                $_SESSION['message'] = "L'utilisateur $nomUtilisateur a bien été modifié! ($typeUtilisateur)";
                $_SESSION['typeMessage'] = "warning";

                header( "location:utilisateur.php" );
            }
            
        }
    }

?>