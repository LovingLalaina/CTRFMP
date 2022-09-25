<?php

function chiffre( $etatDossier )
{
    switch( $etatDossier )
    {
        case "recu" : return 0; break;
        case "etudie" : return 1; break;
        case "engage" : return 2; break;
        case "liquide" : return 3; break;
        case "arrivee" : return 4; break;
        case "delivre" : return 5; break;
        default : return -1;
    }
}

?>