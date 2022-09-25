<?php

function securisation( $monPost , $typeDonnee = "" )
{
    $resultat = trim( $monPost );
    $resultat = strip_tags( $resultat );
    $resultat = stripslashes( $resultat );

    switch( $typeDonnee )
    {
        case "typePrenom" : $resultat = mb_strtolower( $resultat , "UTF-8" ); $resultat = ucwords( $resultat ); break;
        case "typeNumero" :
        case "typeNom"    :
        case "typeSigle"  :
        case "typeAdresse": $resultat = mb_strtoupper( $resultat , "UTF-8" ); break;
        case "typeMontant": $resultat = intval( preg_replace( '/[^0-9]/', '', $monPost ) );
    }
    
    return $resultat;
}

?>