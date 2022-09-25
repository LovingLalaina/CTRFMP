<?php

function pensionnaireSuivant( $connexionMySQLi )
{
    $dernierPensionnaire = $connexionMySQLi->query( "SELECT max(id) AS dernier_id FROM pensionnaire" ) or die( $connexionMySQLi->error );
    return ( $dernierPensionnaire->fetch_assoc() )["dernier_id"] + 1;
}
?>