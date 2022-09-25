
<div class="modal fade" id="ModalModifierPensionnaire" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">MODIFICATION DE PENSIONNAIRE</h4>
            </div>
            <form method="POST" action="modifierPensionnaire.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input value="<?=$idPensionnaire?>" type="hidden" name="IdPensionnaire"/>

                        <label for="NumeroPension" class="w3-label w3-left">Numéro de Pension :</label>
                        <input value="<?=$numeroPension?>" type="text" name="NumeroPension" required="required" maxlength="13" class="NumeroPension w3-input w3-border w3-round-large"/>
                        <span class="NumeroPension_message"></span><br/>

                        <label for="NomPensionnaire" class="w3-label w3-left">Nom :</label>
                        <input value="<?=$nomPensionnaire?>" type="text" name="NomPensionnaire" required="required" maxlength="50" class="NomPensionnaire w3-input w3-border w3-round-large"/>
                        <span class="NomPensionnaire_message"></span><br/>

                        <label for="PrenomPensionnaire" class="w3-label w3-left">Prénom(s) :</label>
                        
                        <input value="<?=$prenomPensionnaire?>" type="text" name="PrenomPensionnaire" maxlength="50" class="PrenomPensionnaire w3-input w3-border w3-round-large"/>
                        <span class="PrenomPensionnaire_message"></span><br/>

                        <label for="AdressePensionnaire" class="w3-label w3-left">Adresse :</label>
                        <input value="<?=$adressePensionnaire?>" type="text" name="AdressePensionnaire" maxlength="25" class="w3-input w3-border w3-round-large"/><br/>

                        <label for="NumeroTelephone" class="w3-label w3-left">Numéro Téléphone :</label>
                        <input value="<?=$numeroTelephone;?>" type="text" name="NumeroTelephone" maxlength="10" class="NumeroTelephone w3-input w3-border w3-round-large"/>
                        <span class="NumeroTelephone_message"></span><br/>

                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <a href="pensionnaire.php" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button type="submit" name="BoutonModifierPensionnaire" class="BoutonPensionnaire btn btn-warning"><i class="fas fa-user-check"></i> Modifier</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET EDIT EST DONNEE -->
<a class="OuvrirModal" href="#ModalModifierPensionnaire" data-toggle="modal">Ouvrir Modal Modifier Pensionnaire</a>
<script src="../Modeles/ouvrirModal.js"></script>