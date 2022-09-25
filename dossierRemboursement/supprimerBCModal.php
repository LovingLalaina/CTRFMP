


<div class="modal fade" id="ModalSupprimerBC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #cd5d7d;">
                <h4 class="modal-title" id="myModalLabel" style="color: white;">SUPPRIMER UN BON DE CAISSE</h4>
            </div>
            <form method="POST" action="supprimerBC.php">
                <div class="modal-body" style="background-color: white;">	
                    <p class="text-center">Etes-vous sûre de vouloir supprimer ce Bon de caisse?</p>
                    <input name="IdBC" type="hidden" value="<?=$idBC?>"/>
                    <h2 class="text-center"><?="FM $numeroDossier ($numeroPension)"?></h2>
                </div>
                <div class="modal-footer" style="background: #cd5d7d;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button name="BoutonSupprimerBC" type="submit" class="btn btn-danger"><i class="fas fa-folder-minus"></i> Oui</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET DELETEBC EST DONNEE -->
<a class="OuvrirModalBC" href="#ModalSupprimerBC" data-toggle="modal">Ouvrir Modal Supprimer BC</a>
<script src="../Modeles/ouvrirModalBC.js"></script>