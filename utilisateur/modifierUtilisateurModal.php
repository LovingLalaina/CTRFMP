
<div class="modal fade" id="ModalModifierUtilisateur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">MODIFICATION D' UTILISATEUR</h4>
            </div>
            <form method="POST" action="modifierUtilisateur.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input value="<?=$idUtilisateur?>" type="hidden" name="IdUtilisateur"/>

                        <label for="NomUtilisateur" class="w3-label w3-left">Nom :</label>
                        <input value="<?=$nomUtilisateur?>" type="text" name="NomUtilisateur" required="required" maxlength="50" class="NomUtilisateur w3-input w3-border w3-round-large"/>
                        <span class="NomUtilisateur_message"></span><br/>

                        <label for="MotDePasse" class="w3-label w3-left">Mot de passe :</label>
                        <input value="<?=$motDePasse?>" type="password" name="MotDePasse" maxlength="50" class="MotDePasse w3-input w3-border w3-round-large"/>
                        <span class="MotDePasse_message"></span><br/>

                        <label for="MotDePasseConfirmation" class="w3-label w3-left">Confirmer mot de passe :</label>
                        <input value="<?=$motDePasse?>" type="password" name="MotDePasseConfirmation" maxlength="50" class="MotDePasseConfirmation w3-input w3-border w3-round-large"/>
                        <span class="MotDePasseConfirmation_message"></span><br/>

                        <label for="MotDePasseConfirmation" class="w3-label w3-left">Section :</label>
                        <select name="TypeUtilisateur" class="w3-select w3-left">
                            <option value="accueil" <?php if( $typeUtilisateur =="accueil" ) echo "selected"; ?>>Acceuil (Réception)</option>
                            <option value="comptable" <?php if( $typeUtilisateur =="comptable" ) echo "selected"; ?>>Comptable (Etude)</option>
                            <option value="user" <?php if( $typeUtilisateur =="user" ) echo "selected"; ?>>Délivrance</option>
                            <option value="admin" <?php if( $typeUtilisateur =="admin" ) echo "selected"; ?>>Administrateur</option>
                        </select><br/><br/><br/>
                        <div class="chemise alert alert-danger">NB : Il ne peut y avoir qu'un seul administrateur</div>

                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <a href="utilisateur.php" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button type="submit" name="BoutonModifierUtilisateur" class="BoutonUtilisateur btn btn-warning"><i class="fas fa-user-check"></i> Modifier</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET EDIT EST DONNEE -->
<a class="OuvrirModal" href="#ModalModifierUtilisateur" data-toggle="modal">Ouvrir Modal Modifier Utilisateur</a>
<script src="../Modeles/ouvrirModal.js"></script>