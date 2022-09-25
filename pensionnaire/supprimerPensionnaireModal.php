
<div class="modal fade" id="ModalSupprimerPensionnaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #cd5d7d;">
                <h4 class="modal-title" id="myModalLabel" style="color: white;">RETIRER UN PENSIONNAIRE</h4>
            </div>
            <form method="POST" action="supprimerPensionnaire.php">
                <div class="modal-body" style="background-color: white;">
                    <p class="text-center">Êtes-vous sûre de vouloir retirer ce pensionnaire ?</p>
                    <input name="IdPensionnaire" type="hidden" value="<?=$idPensionnaire?>"/>
                    <h2 class="text-center"><?="N° ".$numeroPension." ".$nomCompletPensionnaire?></h2>
                    <p class="alert alert-danger"><input name="TousSupprimer" type="checkbox" checked/> Cochez si vous voulez supprimer tous les dossiers et Bon de Caisse de ce pensionnaire</p>
                </div>
                <div class="modal-footer" style="background: #cd5d7d;">
                    <a href="pensionnaire.php" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button type="submit" name="BoutonSupprimerPensionnaire" class="btn btn-danger"><i class="fas fa-user-times"></i> Oui</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET DELETE EST DONNEE -->
<a class="OuvrirModal" href="#ModalSupprimerPensionnaire" data-toggle="modal">Ouvrir Modal Supprimer Pensionnaire</a>
<script type="text/javascript" src="../Modeles/ouvrirModal.js"></script>