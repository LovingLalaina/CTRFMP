
<nav <?php if( $_SERVER["SCRIPT_NAME"] == "/CTRFMP/dossierRemboursement/dossierRemboursement.php" ) echo "style=\"position:fixed;top:0px;z-index:4;\""; ?>>
    <ul>
        <li class="liPensionnaire"><a href="/CTRFMP/pensionnaire/pensionnaire.php"><i style="position:relative;top:1px;right:4px" class="ni ni-single-02"></i>PENSIONNAIRES</a></li>
        <li class="liDossier"><a href="/CTRFMP/dossierRemboursement/dossierRemboursement.php"><i style="position:relative;top:2px;right:5px" class="ni ni-bullet-list-67"></i>DOSSIERS ET BONS DE CAISSE</a></li>
        <li class="liChemise"><a href="/CTRFMP/chemise/chemise.php"><i style="position:relative;top:1px;right:5px" class="fas fa-folder-open"></i>CHEMISE</a></li>
        <li class="liUtilisateur"><a <?php if( $_SESSION["connexion"] == "admin" ) echo "href=\"/CTRFMP/utilisateur/utilisateur.php\""; else{ echo "href=\"#ModalDemanderMdp\" data-toggle=\"modal\""; } ?> ><i style="position:relative;top:1px;right:5px" class="fas fa-users"></i>UTILISATEURS</a></li>
        <li class="liDeconnexion" style="float:right"><a href="/CTRFMP/Authentification/deconnexion.php"><i class="fa fa-power-off"></i></a></li>
    </ul>
</nav>