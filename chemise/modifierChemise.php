<?php
    session_start();
    require_once("../Modeles/connexion.php");
    
    if( isset( $_POST["BoutonModifierChemise"] ) )
    {
        $idChemise = $_POST["IdChemise"];
        $anneeExercice = $_POST["AnneeExercice"];
        $numeroChemise = $_POST["NumeroChemise"];
        $couleurChemise = $_POST["CouleurChemise"];

        //VERIFICATION SI CHEMISE DEJA EXISTANT
        $resultatSELECT = $connexionMySQLi->query( "SELECT couleur FROM chemise WHERE (annee_exercice='$anneeExercice' AND num_chemise='$numeroChemise' AND id!='$idChemise')" ) or die( $connexionMySQLi->error() );

        if( $resultatSELECT->num_rows >= 1 )
        {
            //TROUVE DONC MODIFICATION IMPOSSIBLE MAIS TOLEREE DANS UN CERTAIN SELON LA COULEUR NON DONNEE
            $couleurChemise = ( $resultatSELECT->fetch_assoc() )["couleur"];
            
            //SESSION MESSAGE SELON LA COULEUR BLANCHE OU NON ET CAS DE MODIFICATION TOLEREE
            if( $couleurChemise == "blanc" && $_POST["CouleurChemise"] == "blanc" )
                $_SESSION["message"] = "La Chemise N° $numeroChemise-$anneeExercice existe déja";
            else if( $couleurChemise == "blanc" && $_POST["CouleurChemise"] != "blanc" )
            {
                $couleurChemise = $_POST["CouleurChemise"];
                $anneeExercice = $resultatSELECT["annee_exercice"];
                $numeroChemise = $resultatSELECT["num_chemise"];
                $connexionMySQLi->query( "UPDATE chemise SET couleur='$couleurChemise' WHERE (annee_exercice='$anneeExercice' AND num_chemise='$numeroChemise'" ) or die( $connexionMySQLi->error() );

                $_SESSION["message"] = "La Chemise N° $numeroChemise-$anneeExercice existe déja mais sa couleur est désormais <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span>";
            }
            else
                $_SESSION["message"] = "La Chemise N° $numeroChemise-$anneeExercice existe déja de couleur : <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span>";
                
            $_SESSION["typeMessage"] = "danger";
            $_SESSION["idChemise"] = $idChemise;

            header( "location:chemise.php" );
        }
        else
        {
            //NON TROUVE DONC MODIFICATION VALIDEE
            //MODIFICATION AUSSI DES BONS DE CAISSE
            $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM chemise WHERE id='$idChemise'" ) or die( $connexionMySQLi->error );
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            $ancienNumeroChemise = $resultatSELECT["num_chemise"];
            $ancienAnneeExercice = $resultatSELECT["annee_exercice"];
            $connexionMySQLi->query( "UPDATE bon_de_caisse SET annee_exercice='$anneeExercice' , num_chemise='$numeroChemise' WHERE (annee_exercice='$ancienAnneeExercice' AND num_chemise='$ancienNumeroChemise')" ) or die( $connexionMySQLi->error );

            $connexionMySQLi->query( "UPDATE chemise SET annee_exercice='$anneeExercice' , num_chemise='$numeroChemise' , couleur='$couleurChemise' WHERE id='$idChemise'" ) or die( $connexionMySQLi->error );

            $connexionMySQLi->query( "DELETE FROM chemise_absent WHERE (num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice')" ) or die( $connexionMySQLi->error );

            $_SESSION['message'] = "La Chemise N° $numeroChemise-$anneeExercice a bien été modifiée!! couleur : <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span>";//NB : MODIFICATION EN BLANC IMPOSSIBLE SELON LA BALISE HTML SELECT
            $_SESSION['typeMessage'] = "warning";

            header( "location:chemise.php" );
        }
    }

?>