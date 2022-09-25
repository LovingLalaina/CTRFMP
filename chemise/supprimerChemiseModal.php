

<div class="modal fade" id="ModalSupprimerChemise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #cd5d7d;">
                <h4 class="modal-title" id="myModalLabel" style="color: white;">SUPPRIMER UNE CHEMISE</h4>
            </div>
            <form method="POST" action="supprimerChemise.php">
                <div class="modal-body" style="background-color: white;">	
                    <p class="text-center">Etes-vous sûre de vouloir supprimer cette Chemise ?</p>
                    <input name="IdChemise" type="hidden" value="<?=$idChemise?>"/>
                    <h2 class="text-center"><?php echo "N° ".$numeroChemise."-".$anneeExercice; if( $couleurChemise != "blanc" ) : ?> <span style="position:relative;bottom:4px;" class="chemise couleur-<?=$couleurChemise?>"><?=strtoupper($couleurChemise)?></span><?php endif; ?></h2>
                    <p class="alert alert-danger"><input name="TousSupprimer" type="checkbox" checked/> Cochez si vous voulez supprimer tous les Bons de Caisse Contenus dans cette chemise</p>
                </div>
                <div class="modal-footer" style="background: #cd5d7d;">
                <a href="chemise.php" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button name="BoutonSupprimerChemise" type="submit" class="btn btn-danger"><i class="fas fa-folder-minus"></i> Oui</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET DELETE EST DONNEE -->
<a class="OuvrirModal" href="#ModalSupprimerChemise" data-toggle="modal">Ouvrir Modal Supprimer Chemise</a>
<script src="../Modeles/ouvrirModal.js"></script>