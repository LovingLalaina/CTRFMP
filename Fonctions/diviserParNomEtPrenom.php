<?php

function diviserParNomEtPrenom( $nomComplet )
{
    $tableauNomComplet = explode( " " , $nomComplet );

    $chaineNom = "";
    $chainePrenom = "";
    $stopNom = false;
    

    foreach( $tableauNomComplet as $elementActuel )
    {
        if( !$stopNom && $elementActuel == mb_strtoupper( $elementActuel , "UTF-8" ) )
            $chaineNom = $chaineNom.$elementActuel." ";
        else
        {
            $stopNom = true;
            $chainePrenom = $chainePrenom.$elementActuel." ";
        }
    }

    $tableauResultat;

    $tableauResultat[0] = trim( $chaineNom );
    $tableauResultat[1] = trim( $chainePrenom );

    return $tableauResultat;

}

?>