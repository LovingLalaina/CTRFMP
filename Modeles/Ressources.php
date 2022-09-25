<?php

    function racineSelonFichier()
    {
        if( $_SERVER["SCRIPT_NAME"] != "/CTRFMP/index.php" )    return "..";
        return ".";
    }

?>

<!-- Ressources CSS -->
<!-- Favicon -->
<link rel="icon" href="<?=racineSelonFichier()?>/Ressources/ImageS/iconeMFE.png" type="image/png"/>
<!-- Bootstrap core CSS OBLIGATOIRE POUR AFFICHER LES SPAN GLYPHICONES CAR LES AUTRES VERSIONS DE BOOTSTRAP NE PEUVENT PAS LES CHARGER-->
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/lib/bootstrap/css/bootstrap.min.css"/>
<!-- Styles OBLIGATOIRE POUR LE ASIDE ET QUELQUES MODIFICATIONS DES LABELS -->
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/css/styles.css">
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/css/style-responsive.css">
<!-- Styles OBLIGATOIRE POUR AFFICHER LES ICONES -->
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/assets/vendor/nucleo/css/nucleo.css" type="text/css"/>
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css"/>
<!-- Argon CSS OBLIGATOIRE POUR LES API MODAL  -->
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/assets/css/argon.css?v=1.2.0" type="text/css"/>
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/assets/css/w3.css" type="text/css"/>
<!-- BOOTSTRAP CSS 5.0.0 POUR MODIFIER LES COULEURS-->
<link rel="stylesheet" href="<?=racineSelonFichier()?>/Ressources/StyleS/bootstrap.min.css"/>

<!-- Ressources JS -->
<!-- ORDRE DES 4 SCRIPTS OBLIGATOIRE POUR LE FONCTIONNEMENT DU MODAL -->
<script type="text/javascript" src="<?=racineSelonFichier()?>/Ressources/assets/vendor/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?=racineSelonFichier()?>/Ressources/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?=racineSelonFichier()?>/Ressources/lib/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?=racineSelonFichier()?>/Ressources/lib/bootstrap/js/bootstrap.min.js"></script>