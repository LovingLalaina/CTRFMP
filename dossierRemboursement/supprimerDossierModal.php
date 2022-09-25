
<div class="modal fade" id="ModalSupprimerDossier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #cd5d7d;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">SUPPRIMER UN DOSSIER DE REMBOURSEMENT</h4>
            </div>
            <form method="POST" action="supprimerDossier.php">
                <div class="modal-body" style="background-color:white;">	
                    <p class="text-center">Etes-vous sûre de vouloir supprimer ce Dossier de Remboursement de Frais Médicaux?</p>
                    <input name="IdDossier" type="hidden" value="<?=$idDossier?>"/>
                    <input name="NumeroEngagement" type="hidden" value="<?=$numeroEngagement?>"/>
                    <h2 class="text-center"><?="FM $numeroDossier"?></h2>
                    <p class="alert alert-danger">NB : le Bon de Caisse associé à ce dossier sera aussi supprimé</p>
                </div>
                <div class="modal-footer" style="background:#cd5d7d;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button name="BoutonSupprimerDossier" type="submit" class="btn btn-danger"><i class="fas fa-folder-minus"></i> Oui</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET DELETEDOSSIER EST DONNEE -->
<a class="OuvrirModal" href="#ModalSupprimerDossier" data-toggle="modal">Ouvrir Modal Supprimer Dossier</a>
<script src="../Modeles/ouvrirModal.js"></script>