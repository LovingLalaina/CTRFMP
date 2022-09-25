<?php

function formatFM( $numeroDossier , $bis , $anneeReception , $montant )
{
    $chaineFM = "R4-$numeroDossier";
    if( $bis ) $chaineFM .= "-BIS";
    $chaineFM .= "-".$anneeReception;
    if( $montant >= 1500000 ) $chaineFM .= "-P";
    return $chaineFM;
}

?>