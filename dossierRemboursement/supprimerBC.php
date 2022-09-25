<?php
    session_start();
    require_once( "../Modeles/connexion.php" );

    if( isset( $_POST["BoutonSupprimerBC"] ) )
    {
        $idBC = $_POST["IdBC"];

        $resultatSELECT = $connexionMySQLi->query( "SELECT num_dossier, year(date_recep) AS annee_recep, num_pens FROM dossier JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE bon_de_caisse.id='$idBC'" ) or die( $connexionMySQLi->error );
        $resultatSELECT = $resultatSELECT->fetch_assoc();
        $numeroDossier = $resultatSELECT["num_dossier"];
        $anneeReception = $resultatSELECT["annee_recep"];
        $numeroPension = $resultatSELECT["num_pens"];
        
        $connexionMySQLi->query( "DELETE FROM bon_de_caisse WHERE id=$idBC" ) or die( $connexionMySQLi->error );
        $connexionMySQLi->query( "UPDATE dossier SET etat='liquide' WHERE num_engag='$numeroEngagement'" ) or die( $connexionMySQLi->error );

        //REVERIFICATION CHEMISE ABSENT
        $resultatSELECT = $connexionMySQLi->query( "SELECT chemise_absent.num_chemise, chemise_absent.annee_exercice FROM chemise_absent JOIN bon_de_caisse ON ( chemise_absent.num_chemise=bon_de_caisse.num_chemise AND chemise_absent.annee_exercice=bon_de_caisse.annee_exercice ) WHERE ( chemise_absent.num_chemise='$numeroChemise' AND chemise_absent.annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
        if( $resultatSELECT->num_rows <= 0 )    $connexionMySQLi->query( "DELETE FROM chemise_absent WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
        
        $_SESSION["message"] = "Le Bon de caisse du dossier FM $numeroDossier a bien été supprimé ($numeroPension)";
        $_SESSION["typeMessage"] = "danger";

        //MISE A JOUR DU PENSIONNAIRE
        require_once( "../Fonctions/pensionnaireSuivant.php" );
        $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens='$numeroPension'" ) or die( mysqli_error( $connexionMySQLi ) );

        header( "location:dossierRemboursement.php" );
    }

?>