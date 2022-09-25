<?php
    session_start();
    require_once( "../Modeles/connexion.php");

    if( isset( $_POST["BoutonAjouterChemise"]) )
    {
        $numeroChemise = $_POST["NumeroChemise"];
        $anneeExercice = $_POST["AnneeExercice"];
        $couleurChemise = $_POST["CouleurChemise"];

        //VERIFICATION SI LA CHEMISE EXISTE DEJA
        $resultatSELECT = $connexionMySQLi->query( "SELECT couleur FROM chemise WHERE (num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice')" ) or die( $connexionMySQLi->error() );

        if( $resultatSELECT->num_rows >= 1 )
        {
            //TROUVE DONC AJOUT IMPOSSIBLE MAIS LEGERE MODIFICATION SELON COULEUR BLANCHE
            $couleurChemise = ( $resultatSELECT->fetch_assoc() )["couleur"];

            if( $couleurChemise == "blanc" && $_POST["CouleurChemise"] == "blanc" )
                $_SESSION["message"] = "La Chemise N° $numeroChemise-$anneeExercice existe déja !!! ";
            else if( $couleurChemise == "blanc" && $_POST["CouleurChemise"] != "blanc" )
            {
                $couleurChemise = $_POST["CouleurChemise"];
                $connexionMySQLi->query( "UPDATE chemise SET couleur='$couleurChemise' WHERE (annee_exercice='$anneeExercice' AND num_chemise='$numeroChemise')" ) or die( $connexionMySQLi->error() );
                $_SESSION["message"] = "La Chemise N° $numeroChemise-$anneeExercice existe déja mais sa couleur est désormais <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span> !!! ";
            }
            else
                $_SESSION["message"] = "La Chemise N° $numeroChemise-$anneeExercice existe déja de couleur : <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span> !!! ";


            $_SESSION["typeMessage"] = "danger";

            $_SESSION["ajoutChemise"] = "echec";
            $_SESSION["anneeExercice"] = $anneeExercice;
            $_SESSION["numeroChemise"] = $numeroChemise;
            $_SESSION["couleurChemise"] = $_POST["CouleurChemise"];

            header( "location:chemise.php" );
        }
        else
        {
            //NON TROUVE DONC AJOUT VALIDE
            $connexionMySQLi->query( "INSERT INTO chemise ( num_chemise , annee_exercice , couleur ) VALUES( '$numeroChemise' , '$anneeExercice' , '$couleurChemise' )" ) or die( $connexionMySQLi->error );

            $_SESSION["message"] = $couleurChemise != "blanc" ? "La Chemise N° $numeroChemise-$anneeExercice a bien été créée <span class=\"chemise couleur-$couleurChemise\">".strtoupper( $couleurChemise )."</span> !" : "La Chemise N° $numeroChemise-$anneeExercice a bien été créée !";
            $_SESSION["typeMessage"] = "success";

            $connexionMySQLi->query( "DELETE FROM chemise_absent WHERE (num_chemise='$numeroChemise' AND annee_exercice='$anneeExercice')" ) or die( $connexionMySQLi->error );

            header( "location:chemise.php" );
        }
    }

?>