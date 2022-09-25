


<div class="modal fade" id="ModalModifierDossier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">MODIFICATION DE DOSSIER </h4>
            </div>
            <form method="POST" action="modifierDossier.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input value="<?=$idDossier?>" type="hidden" name="IdDossier"/>
                        <input value="<?=$etatDossier?>" type="hidden" name="EtatDossier"/>

                        <label for="DateReception" class="w3-label w3-left">Date de réception : </label>
                        <input value="<?=$dateReception?>" type="date" name="DateReception" required="required" class="DateReception DateReceptionModif w3-input w3-border w3-round-large"/><br/>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3" style="padding-top:5px;padding-left:25px;"><label for="NumeroDossier" class="w3-label w3-left">FM : R4 - </label></div>
                                <div class="col-md-3"><input value="<?=$numeroDossierAbrege?>" type="number" name="NumeroDossier" required="required" class="w3-input w3-border w3-round-large" min="1" placeholder="1"/></div>-
                                <div class="col-md-3"><input value="<?=$anneeReception?>" type="number" name="AnneeReception" required="required" class="AnneeReception AnneeReceptionModif w3-input w3-border w3-round-large" min="0"/></div>
                                <div class="col-md-1"  style="padding-top:5px;"><input type="checkbox" name="Bis" class="w3-input w3-border w3-round-large" <?php if( $bis ) echo "checked"; ?>/></div>BIS
                                <span class="AnneeReceptionModif_message"></span><br/>
                            </div>
                        </div>

                        <label for="NumeroPensionModif" class="w3-label w3-left">Numéro de Pension : </label>
                        <input value="<?=$numeroPension?>" type="text" name="NumeroPensionModif" required="required" maxlength="13" class="NumeroPensionModif w3-input w3-border w3-round-large" placeholder="0A12345"/>
                        <span class="NumeroPensionModif_message"></span><br/>

                        <label for="MontantProvisoire" class="w3-label w3-left">Montant Provisoire : </label>
                        <input type="text" name="MontantProvisoire" value="<?=$montantProvisoire?>" data-type="currency" required="required" class="w3-input w3-border w3-round-large" maxLength="13" placeholder="Ar 100.000"/><br/>

                        <label for="SigleComptable" class="w3-label w3-left">Comptable traitant le dossier : </label>
                        <input value="<?=$sigleComptable?>" type="text" name="SigleComptable" class="w3-input w3-border w3-round-large" maxLength="5" placeholder="LLA"/><br/>

                        <div <?php if( $etatDossier == "recu" ) echo "style=\"display:none;\""; ?> class="container-fluid">
                            <label for="MontantDefinitif" class="w3-label w3-left">Montant Définitif : </label>
                            <input type="text" name="MontantDefinitif" value="<?=$montantDefinitif;?>" data-type="currency" required="required" class="w3-input w3-border w3-round-large" maxLength="13" placeholder="Ar 100.000"/><br/>
                        </div>
                        <div <?php if( $etatDossier == "etudie" || $etatDossier == "recu" ) echo "style=\"display:none;\""; ?> class="container-fluid">
                            <div class="row">
                                <div class="col-md-2"><label for="NumeroEngagement" class="w3-label w3-left">ENG </label></div>
                                <div class="col-md-5"><input value="<?=substr( $numeroEngagement , 3 , 4 )?>" type="number" name="AnneeEngagement" required="required" class="w3-input w3-border w3-round-large"/></div>
                                <div class="col-md-5"><input value="<?=substr( $numeroEngagement , 8 , 16 )?>" type="number" name="NumeroEngagement" required="required" class="w3-input w3-border w3-round-large" placeholder="12345678"/></div>
                            </div><br/>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonModifierDossier" class="BoutonModifierDossier btn btn-warning"><span class="glyphicon glyphicon-floppy-disk"></span> Modifier</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET EDITDOSSIER EST DONNEE -->
<a class="OuvrirModal" href="#ModalModifierDossier" data-toggle="modal">Ouvrir Modal Modifier Dossier</a>
<script src="../Modeles/ouvrirModal.js"></script>