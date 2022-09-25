<?php

function chaine( $numeroPension )
{
    $tableauNumero = array();
    $i = 0;
    while( $ligne = $numeroPension->fetch_assoc() )
    {
        $tableauNumero[$i] = "'".$ligne["num_pens"]."'";
        ++$i;
    }

    if( $i!= 0 ) return implode( "," , $tableauNumero );
    return "0000000";
}

?>