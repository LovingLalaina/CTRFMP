<?php

function trimestriel( $mois )
{
    $tableauTrimestriel = array();
    $moisActuel = $mois - 1; // -1 et MODULO 12 CAR 13%13 DONNE 0 et NON 1

    for( $i = 0 ; $i < 3 ; ++$i , ++$moisActuel )
        $tableauTrimestriel[$i] = ( $moisActuel % 12 ) + 1;

    return "(".implode( "," , $tableauTrimestriel ).")";
}

?>