
<div class="modal fade" id="ModalModifierChemise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">MODIFICATION DE CHEMISE </h4>
            </div>
            <form method="POST" action="modifierChemise.php">
                <div class="modal-body">
                    <div class="container-fluid">

                        <input value="<?=$idChemise?>" type="hidden" name="IdChemise"/>

                        <label for="AnneeExercice" class="w3-label w3-left">Année d'Execrice :</label>
                        <input value="<?=$anneeExercice?>" type="number" name="AnneeExercice" required="required" class="w3-input w3-border w3-round-large" min="0"/><br/>

                        <label for="NumeroChemise" class="w3-label w3-left">Numéro de Chemise :</label>
                        <input value="<?=$numeroChemise?>" type="number" name="NumeroChemise" required="required" class="w3-input w3-border w3-round-large" min="1"/><br/>

                        <label for="CouleurChemise" class="w3-label w3-left">Couleur de Chemise :</label>
                        <select class="w3-select w3-left" name="CouleurChemise">
                            <option class="couleur-bleu" value="bleu" <?php if( $couleurChemise == "bleu" ) echo "selected"; ?>>BLEU</option>
                            <option class="couleur-jaune" value="jaune" <?php if( $couleurChemise == "jaune" ) echo "selected"; ?>>JAUNE</option>
                            <option class="couleur-rose" value="rose" <?php if( $couleurChemise == "rose" ) echo "selected"; ?>>ROSE</option>
                            <option class="couleur-beige" value="beige" <?php if( $couleurChemise == "beige" ) echo "selected"; ?>>BEIGE</option>
                            <option class="couleur-vert" value="vert" <?php if( $couleurChemise == "vert" ) echo "selected"; ?>>VERT</option>
                            <option class="couleur-rouge" value="rouge" <?php if( $couleurChemise == "rouge" ) echo "selected"; ?>>ROUGE</option>
                            <option class="couleur-violet" value="violet" <?php if( $couleurChemise == "violet" ) echo "selected"; ?>>VIOLET</option>
                            <option class="couleur-orange" value="orange" <?php if( $couleurChemise == "orange" ) echo "selected"; ?>>ORANGE</option>

                        </select><br/>
                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <a href="chemise.php" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button type="submit" name="BoutonModifierChemise" class="btn btn-warning"><span class="glyphicon glyphicon-floppy-disk"></span> Modifier</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET EDIT EST DONNEE -->
<a class="OuvrirModal" href="#ModalModifierChemise" data-toggle="modal">Ouvrir Modal Modifier Chemise</a>
<script src="../Modeles/ouvrirModal.js"></script>