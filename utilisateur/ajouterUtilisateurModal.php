
<div class="modal fade" id="ModalAjouterUtilisateur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">AJOUT D'UN UTILISATEUR</h4>
            </div>
            <form method="POST" action="ajouterUtilisateur.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <label for="NomUtilisateur" class="w3-label w3-left">Nom :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutUtilisateur"] ) ) echo $_SESSION["nomUtilisateur"]; ?>" type="text" name="NomUtilisateur" required="required" maxlength="50" class="NomUtilisateur w3-input w3-border w3-round-large"/>
                        <span class="NomUtilisateur_message"></span><br/>

                        <label for="MotDePasse" class="w3-label w3-left">Mot de passe :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutUtilisateur"] ) ) echo $_SESSION["motDePasse"]; ?>" type="password" name="MotDePasse" maxlength="50" class="MotDePasse w3-input w3-border w3-round-large"/>
                        <span class="MotDePasse_message"></span><br/>

                        <label for="MotDePasseConfirmation" class="w3-label w3-left">Confirmer mot de passe :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutUtilisateur"] ) ) echo $_SESSION["motDePasseConfirmation"]; ?>" type="password" name="MotDePasseConfirmation" maxlength="50" class="MotDePasseConfirmation w3-input w3-border w3-round-large"/>
                        <span class="MotDePasseConfirmation_message"></span><br/>

                        <label for="TypeUtilisateur" class="w3-label w3-left">Section :</label>
                        <select name="TypeUtilisateur" class="w3-select w3-left">
                            <option value="accueil" <?php if( isset( $_SESSION["ajoutUtilisateur"] ) && $_SESSION["typeUtilisateur"] =="accueil" ) echo "selected"; ?>>Acceuil (Réception)</option>
                            <option value="comptable" <?php if( isset( $_SESSION["ajoutUtilisateur"] ) && $_SESSION["typeUtilisateur"] =="comptable" ) echo "selected"; ?>>Comptable (Etude)</option>
                            <option value="user" <?php if( isset( $_SESSION["ajoutUtilisateur"] ) && $_SESSION["typeUtilisateur"] =="user" ) echo "selected"; ?>>Délivrance</option>
                            <option value="admin" <?php if( isset( $_SESSION["ajoutUtilisateur"] ) && $_SESSION["typeUtilisateur"] =="admin" ) echo "selected"; ?>>Administrateur</option>
                        </select><br/><br/><br/>
                        <div class="chemise alert alert-danger">NB : Il ne peut y avoir qu'un seul administrateur</div>

                        <?php unset( $_SESSION["ajoutUtilisateur"] ); ?>
                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonAjouterUtilisateur" class="BoutonUtilisateur btn btn-success"><i class="fas fa-user-plus"></i> Ajouter</a>
                </div>
            </form>
        </div>
    </div>
</div>