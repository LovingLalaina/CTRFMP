
<div class="modal fade" id="ModalAjouterPensionnaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">AJOUT DE PENSIONNAIRE</h4>
            </div>
            <form method="POST" action="ajouterPensionnaire.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <label for="NumeroPension" class="w3-label w3-left">Numéro de Pension :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutPensionnaire"] ) ) echo $_SESSION["numeroPension"]; ?>" type="text" name="NumeroPension" required="required" maxlength="13" class="NumeroPension w3-input w3-border w3-round-large" placeholder="0A12345"/>
                        <span class="NumeroPension_message"></span><br/>

                        <label for="NomPensionnaire" class="w3-label w3-left">Nom :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutPensionnaire"] ) ) echo $_SESSION["nomPensionnaire"]; ?>" type="text" name="NomPensionnaire" required="required" maxlength="50" class="NomPensionnaire w3-input w3-border w3-round-large" placeholder="RAKOTO"/>
                        <span class="NomPensionnaire_message"></span><br/>

                        <label for="PrenomPensionnaire" class="w3-label w3-left">Prénom(s) :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutPensionnaire"] ) ) echo $_SESSION["prenomPensionnaire"]; ?>" type="text" name="PrenomPensionnaire" maxlength="50" class="PrenomPensionnaire w3-input w3-border w3-round-large" placeholder="Rabe Michel"/>
                        <span class="PrenomPensionnaire_message"></span><br/>

                        <label for="AdressePensionnaire" class="w3-label w3-left">Adresse :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutPensionnaire"] ) ) echo $_SESSION["adressePensionnaire"]; ?>" type="text" name="AdressePensionnaire" maxlength="25" class="w3-input w3-border w3-round-large" placeholder="Ambohidahy"/><br/>

                        <label for="NumeroTelephone" class="w3-label w3-left">Numéro Téléphone :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutPensionnaire"] ) ) echo $_SESSION["numeroTelephone"]; ?>" type="text" name="NumeroTelephone" maxlength="10" class="NumeroTelephone w3-input w3-border w3-round-large" placeholder="0332135620"/>
                        <span class="NumeroTelephone_message"></span><br/>

                        <?php unset( $_SESSION["ajoutPensionnaire"] ); ?>
                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonAjouterPensionnaire" class="BoutonPensionnaire btn btn-success"><i class="fas fa-user-plus"></i> Ajouter</a>
                </div>
            </form>
        </div>
    </div>
</div>