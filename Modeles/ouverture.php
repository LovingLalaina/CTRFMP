<?php
    session_start();
    require_once( "connexion.php" ); //LE CHEMIN PEUT OU NON ETRE RELATIF SELON CE FICHIER

    if( !isset( $_SESSION["connexion"] ) )
        header( "location:../Authentification/login.php" );
    
?>