
<div class="modal fade" id="ModalAjouterChemise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">CRÉATION DE CHEMISE</h4>
            </div>
            <form method="POST" action="ajouterChemise.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        
                        <label for="AnneeExercice" class="w3-label w3-left">Année d'Exercice :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutChemise"] ) ) echo $_SESSION["anneeExercice"]; else echo date( "Y" , time() ); ?>" type="number" name="AnneeExercice" required="required" class="w3-input w3-border w3-round-large" min="0" placeholder="<?php echo date("Y", time()); ?>"/><br/>

                        <label for="NumeroChemise" class="w3-label w3-left">Numéro de Chemise :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutChemise"] ) ) echo $_SESSION["numeroChemise"]; else{ $dernierNumero = $connexionMySQLi->query( "SELECT max(num_chemise) AS dernier_numero FROM chemise WHERE annee_exercice=year(now())") or die( $connexionMySQLi->error ); $dernierNumero = $dernierNumero->fetch_assoc(); echo ( $dernierNumero["dernier_numero"] + 1 ); } ?>" type="number" name="NumeroChemise" required="required" class="w3-input w3-border w3-round-large" min="1" placeholder="1"/><br/>

                        <label for="CouleurChemise" class="w3-label w3-left">Couleur de Chemise :</label>
                        <select name="CouleurChemise" class="w3-select w3-left">
                            <option class="couleur-blanc" value="blanc" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="blanc") echo "selected"; ?>></option>
                            <option class="couleur-bleu" value="bleu" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="bleu") echo "selected"; ?>>BLEU</option>
                            <option class="couleur-jaune" value="jaune" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="jaune") echo "selected"; ?>>JAUNE</option>
                            <option class="couleur-rose" value="rose" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="rose") echo "selected"; ?>>ROSE</option>
                            <option class="couleur-beige" value="beige" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="beige") echo "selected"; ?>>BEIGE</option>
                            <option class="couleur-vert" value="vert" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="vert") echo "selected"; ?>>VERT</option>
                            <option class="couleur-rouge" value="rouge" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="rouge") echo "selected"; ?>>ROUGE</option>
                            <option class="couleur-violet" value="violet" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="violet") echo "selected"; ?>>VIOLET</option>
                            <option class="couleur-orange" value="orange" <?php if( isset( $_SESSION["ajoutChemise"] ) && $_SESSION["couleurChemise"] =="orange") echo "selected"; ?>>ORANGE</option>
                        </select><br/>

                        <?php unset( $_SESSION["ajoutChemise"] ); ?>
                    </div>
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonAjouterChemise" class="btn btn-success"><i class="fas fa-folder-plus"></i> Créer</a>
                </div>
            </form>
        </div>
    </div>
</div>