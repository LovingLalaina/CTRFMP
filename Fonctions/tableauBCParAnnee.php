<?php

    function tableauBCParAnnee( $connexionMySQLi , $etatBC )
    {
        $tableauBC = array();
        for( $i = 1 ; $i <= 12 ; ++$i )
        {
            if( $etatBC == "arrivee" )
                $nombreBC = $connexionMySQLi->query( "SELECT count(id) AS nombre_BC FROM bon_de_caisse WHERE ( year(date_arrivee)=".$_GET["annee"]." AND month(date_arrivee)=$i )" ) or die( mysqli_error( $connexionMySQLi ) );
            else
                $nombreBC = $connexionMySQLi->query( "SELECT count(bon_de_caisse.id) AS nombre_BC FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ( etat='delivre' AND year(date_delivrance)=".$_GET["annee"]." AND month(date_delivrance)=$i )" ) or die( mysqli_error( $connexionMySQLi ) );
            $tableauBC[$i-1] = ( $nombreBC->fetch_assoc() )["nombre_BC"];
        }
        return $tableauBC;
    }

?>