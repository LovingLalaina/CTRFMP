<?php

function formatEtatDossier( $leurEtatDossier )
{
    $etatDossier = "";

    switch ( $leurEtatDossier )
    {
        case "Saisie" :
        case "Attente Comptable" : $etatDossier = "recu"; break;
        case "Attente vérificateur" : 
        case "Validé" :
        case "Attente engagement" :
        case "Envoyé pour engagement" : $etatDossier = "etudie"; break;
        case "Engagé" : $etatDossier = "engage"; break;
        case "Liquidé" : $etatDossier = "liquide"; break;
        default : $etatDossier = "undefined";
    }

    return $etatDossier;
}

?>