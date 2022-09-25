<?php
    session_start();
    require_once( "../Modeles/connexion.php" );

    if( isset( $_POST["BoutonSupprimerChemise"] ) )
    {
        $idChemise = $_POST["IdChemise"];

        $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM chemise WHERE id='$idChemise'" ) or die( $connexionMySQLi->error );
        $resultatSELECT = $resultatSELECT->fetch_assoc();
        $numeroChemise = $resultatSELECT["num_chemise"];
        $anneeExercice = $resultatSELECT["annee_exercice"];
        $couleurChemise = $resultatSELECT["couleur"];

        if( isset( $_POST["TousSupprimer"] ) )
        {
            //REVERIFICATION DU PENSIONNAIRE_ABSENT SI LA SUPPRESSION DE DOSSIER A EU IMPACT
            $numeroPension = $connexionMySQLi->query( "SELECT num_pens FROM dossier WHERE num_engag IN ( SELECT num_engag FROM bon_de_caisse WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' ) )" ) or die( $connexionMySQLi->error );
            $connexionMySQLi->query( "DELETE FROM dossier WHERE num_engag IN ( SELECT num_engag FROM bon_de_caisse WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' ) )" ) or die( $connexionMySQLi->error );
            require_once( "../Fonctions/chaine.php" );
            $resultatSELECT = $connexionMySQLi->query( "SELECT pensionnaire_absent.num_pens FROM pensionnaire_absent JOIN dossier ON pensionnaire_absent.num_pens=dossier.num_pens WHERE pensionnaire_absent.num_pens IN ( ".chaine( $numeroPension )." )" ) or die( $connexionMySQLi->error );
            if( $resultatSELECT->num_rows <= 0 )    $connexionMySQLi->query( "DELETE FROM pensionnaire_absent WHERE num_pens IN ( ".chaine( $numeroPension )." )" ) or die( $connexionMySQLi->error );
            
            $connexionMySQLi->query( "DELETE FROM bon_de_caisse WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
        }
        else
        {
            $resultatSELECT = $connexionMySQLi->query( "SELECT id FROM bon_de_caisse WHERE ( num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice' )" ) or die( $connexionMySQLi->error );
            if( $resultatSELECT->num_rows >= 1 ) $connexionMySQLi->query( "INSERT INTO chemise_absent ( num_chemise , annee_exercice ) VALUES ( '$numeroChemise' , '$anneeExercice' )" ) or die( $connexionMySQLi->error );
        }

        $connexionMySQLi->query( "DELETE FROM chemise WHERE id='$idChemise'" ) or die( $connexionMySQLi->error );

        $_SESSION["message"] = $couleurChemise != "blanc" ? "La chemise N° $numeroChemise-$anneeExercice <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span> a bien été supprimée!" :"La chemise N° $numeroChemise-$anneeExercice a bien été supprimée!";
        $_SESSION["typeMessage"] = "danger";

        header( "location:chemise.php" );
    }

?>