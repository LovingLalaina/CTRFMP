<?php

    function titreSelon( $nomDuScript )
    {
        switch( $nomDuScript )
        {
            case "/CTRFMP/pensionnaire/pensionnaire.php" : return( "Gestion des Pensionnaires" );
            case "/CTRFMP/dossierRemboursement/dossierRemboursement.php" : return( "Gestion des Dossiers et Bon de Caisse" );
            case "/CTRFMP/chemise/chemise.php" : return( "Gestion des Chemises de Bon de caisse" );
            default : return( "Gestion de Bon de Caisse et Delivrance" );
        }
    }

?>

<head>
    <title><?=titreSelon( $_SERVER["SCRIPT_NAME"] )?></title>
    
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <?php
        if( $_SERVER["SCRIPT_NAME"] != "/CTRFMP/index.php" ) require_once( "../Modeles/Ressources.php" ); //CE FICHIER INCLU LES RESSOURCES CSS ET JS NECESSAIRES
        else require_once( "./Modeles/Ressources.php" );
    ?>
    
    <!-- STYLES ET DYNAMISME DE L'APPLICATION WEB -->
    <link rel="stylesheet" href="<?=racineSelonFichier()?>/StyleS/styleGeneral.css"/>
    <link rel="stylesheet" href="<?=racineSelonFichier()?>/StyleS/styleTableau.css"/>
    <link rel="stylesheet" href="<?=racineSelonFichier()?>/StyleS/couleurs.css"/>
    <link rel="stylesheet" href="<?=racineSelonFichier()?>/StyleS/styleModalConfirmer.css"/>
    <link rel="stylesheet" href="<?=racineSelonFichier()?>/StyleS/navigation.css"/>
    <script type="text/javascript" src="<?=racineSelonFichier()?>/StyleS/barreNavigation.js"></script>
    <script type="text/javascript" src="<?=racineSelonFichier()?>/StyleS/tableau.js"></script>
</head>