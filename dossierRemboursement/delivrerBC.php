<?php
    session_start();
    require_once( "../Modeles/connexion.php" );

    if( isset( $_POST["BoutonDelivrerBC"] ) )
    {
        $tableauIdBC = explode( "," , $_POST["TableauIdBC"] );
        $nombreBCChecked = 0;
        foreach( $tableauIdBC as $idBC )
        {
            if( isset( $_POST["Check_$idBC"] ) )
            {
                ++$nombreBCChecked;
                $dateDelivrance = $_POST["DateDelivrance_$idBC"];
                $connexionMySQLi->query( "UPDATE bon_de_caisse SET date_delivrance='$dateDelivrance' WHERE id='$idBC'" ) or die( $connexionMySQLi->error );
                $connexionMySQLi->query( "UPDATE dossier SET etat='delivre' WHERE num_engag IN ( SELECT num_engag FROM bon_de_caisse WHERE id='$idBC' )" ) or die( $connexionMySQLi->error );

                //MISE A JOUR DU PENSIONNAIRE
                require_once( "../Fonctions/pensionnaireSuivant.php" );
                $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE bon_de_caisse.id='$idBC' )" ) or die( mysqli_error( $connexionMySQLi ) );
            }
        }

        switch( $nombreBCChecked )
        {
            case 0 :
                $_SESSION["message"] =  "Aucun Bon de caisse n'a été délivré";
                $_SESSION["typeMessage"] = "danger";
                break;
            case 1 :
                $_SESSION["message"] =  "1 Bon de caisse a bien été délivré";
                $_SESSION["typeMessage"] = "success";
                break;
            default :
                $_SESSION["message"] =  "$nombreBCChecked Bons de Caisse ont bien été délivrés";
                $_SESSION["typeMessage"] = "success";
        }

        header( "location:dossierRemboursement.php" );

    }

?>