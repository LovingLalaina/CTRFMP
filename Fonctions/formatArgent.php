<?php

function formatArgent( $montant )
{
    return "Ar ".preg_replace( '/\B(?=(\d{3})+(?!\d))/' , "." , preg_replace( '/\D/', "", $montant ) );
}

?>