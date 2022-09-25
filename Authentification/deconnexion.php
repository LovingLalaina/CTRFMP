<?php

    session_start();
    session_destroy();
    require_once( "../Modeles/connexion.php" );

    /*  CODE POUBELLE A CAUSE DE LENTEUR D'EXECUTION
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

    trierIdentifiantPensionnaire( $connexionMySQLi );*/

    header( "location:login.php" );

?>