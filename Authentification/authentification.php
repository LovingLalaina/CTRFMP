<?php
session_start();
require_once( "../Modeles/connexion.php" );

function trierIdentifiantPensionnaire( $connexionMySQLi )
{
    $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM pensionnaire" ) or die( $connexionMySQLi->error );
    $tableauId = array();

    for( $i = 0 ; $i < $resultatSELECT->num_rows ; ++$i )
        $tableauId[$i] = ( $resultatSELECT->fetch_assoc() )["id"];

    for( $i = 1 ; $i <= $resultatSELECT->num_rows ; ++$i )
    {
        $connexionMySQLi->query( "UPDATE pensionnaire SET id=$i WHERE id='".min( $tableauId )."'" ) or die( $connexionMySQLi->error );
        unset( $tableauId[array_search( min( $tableauId ) , $tableauId )] );
    }
}


if( isset( $_POST["BoutonSeConnecter"] ) )
{
    
    $utilisateur = $_POST["Utilisateur"];
    $motDePasse = $_POST["MotDePasse"];
    $booleenSeSouvenir = isset( $_POST["SeSouvenirUtilisateur"] );//INUTIL JUSQU'ICI

    $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM utilisateur WHERE ( nom_utilisateur='$utilisateur' )" ) or die( $connexionMySQLi->error );

    if( $resultatSELECT->num_rows <= 0 )
    {
        unset( $_SESSION["connexion"] );
        header( "location:login.php?error=user" );
    }
    else
    {
        $resultatSELECT = $resultatSELECT->fetch_assoc();
        if( $motDePasse != $resultatSELECT["mot_de_passe"] )
        {
            unset( $_SESSION["connexion"] );
            header( "location:login.php?error=mdp&user=$utilisateur" );
        }
        else
        {
            //trierIdentifiantPensionnaire( $connexionMySQLi );
            $_SESSION["connexion"] = $resultatSELECT["type_utilisateur"];
            header( "location:../dossierRemboursement/dossierRemboursement.php" );
        }
    }
}





?>