
<div class="modal fade" id="ModalSupprimerUtilisateur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #cd5d7d;">
                <h4 class="modal-title" id="myModalLabel" style="color: white;">RETIRER UN UTILISATEUR</h4>
            </div>
            <form method="POST" action="supprimerUtilisateur.php">
                <div class="modal-body" style="background-color: white;">
                    <p class="text-center">Êtes-vous sûre de vouloir retirer cet utilisateur ?</p>
                    <input name="IdUtilisateur" type="hidden" value="<?=$idUtilisateur?>"/>
                    <h2 class="text-center"><?="$nomUtilisateur ($typeUtilisateur)"?></h2>
                </div>
                <div class="modal-footer" style="background: #cd5d7d;">
                    <a href="utilisateur.php" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button type="submit" name="BoutonSupprimerUtilisateur" class="btn btn-danger"><i class="fas fa-user-times"></i> Oui</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET DELETE EST DONNEE -->
<a class="OuvrirModal" href="#ModalSupprimerUtilisateur" data-toggle="modal">Ouvrir Modal Supprimer Utilisateur</a>
<script type="text/javascript" src="../Modeles/ouvrirModal.js"></script>