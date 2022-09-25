

<aside style="z-index:2">
    <div id="sidebar" class="nav-collapse">
        <ul style="margin-top:130px;" class="sidebar-menu" id="nav-accordion">
            <li><a href="<?php if( $_SESSION["connexion"] == "admin" || $_SESSION["connexion"] == "accueil" ) echo "#ModalAjouterDossier"; else echo "#ModalDemanderMdpReception"; ?>" data-toggle="modal" style="font-size:14px;"><i class="fas fa-plus text-grey"></i>RÉCEPTION DE DOSSIER<i style="position:relative;top:4px;left:4px" class="ni ni-bullet-list-67"></i></a></li>
            <li><a href="<?php if( $_SESSION["connexion"] == "admin" || $_SESSION["connexion"] == "comptable" ) echo "#ModalEtudierDossier"; else echo "#ModalDemanderMdpEtude"; ?>" data-toggle="modal" style="font-size:14px;"><i class="fa fa-cogs text-grey"></i>ETUDE DE DOSSIER <i class="fa fa-tasks text-grey"></i></a></li>
            <li><a href="<?php if( $_SESSION["connexion"] == "admin" ) echo "#ModalEngagerDossier"; else echo "#ModalDemanderMdp"; ?>" data-toggle="modal" style="font-size:14px;"><i class="fa fa-cogs text-grey"></i>ENTRER NUM ENGAG <i class="fa fa-tasks text-grey"></i></a></li>
            <li><a href="#ModalAjouterBC" data-toggle="modal" style="font-size:14px;"><i class="fas fa-file-export" style="position:relative;top:0px;left:2px"></i>AJOUT BON DE CAISSE <i class="fas fa-folder-open"></i></a></li>
            <?php if( isset( $_GET["numPens"] ) && !isset( $_GET["deliv"] ) ) : ?>
                <li><a onclick="alert('Delivrance en cours !!!');" href="dossierRemboursement.php?numPens=<?=$_GET["numPens"]?>&deliv=true" style="font-size:14px;"><i class="fas fa-file-export" style="position:relative;top:0px;left:2px"></i>DELIVRANCE <i style="position:relative;top:0px;right:0px" class="ni ni-single-02"></i></a></li>  
            <?php else : ?>
                <li><a id="OuvrirModalEchecBC" href="#ModalEchecDelivrerBC" data-toggle="modal" style="font-size:14px;"><i class="fas fa-file-export" style="position:relative;top:0px;left:2px"></i>DELIVRANCE <i style="position:relative;top:0px;right:0px" class="ni ni-single-02"></i></a></li>
            <?php endif; ?>
            <li><a href="#ModalBilanBC" data-toggle="modal" style="font-size:14px;"><i class="fas fa-search"></i>BILAN BON DE CAISSE <i class="fas fa-file"></i></a></li>  
            <li><a href="#ModalGenererPdf" data-toggle="modal" style="font-size:14px;"><i class="fas fa-download"></i>GÉNERER PDF BC <i class="fas fa-file"></i></a></li>
        </ul>
    </div>
</aside>