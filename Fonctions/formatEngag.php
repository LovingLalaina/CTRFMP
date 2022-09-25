<?php

function formatEngag( $anneeEngagement , $numeroEngagement )
{
    $chaine = "ENG".$anneeEngagement;
    $longueurReste = 12 - strlen( $numeroEngagement );

    for( $i = 0 ; $i < $longueurReste ; ++$i )
        $chaine .= "0";

    return $chaine.$numeroEngagement;
}

?>


