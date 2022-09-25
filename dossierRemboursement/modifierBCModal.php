


<div class="modal fade" id="ModalModifierBC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">MODIFICATION DE BON DE CAISSE </h4>
            </div>
            <form method="POST" action="modifierBC.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <input value="<?=$idBC?>" type="hidden" name="IdBC"/>
                        <input value="<?=$etatDossier?>" type="hidden" name="EtatDossier"/>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3"><label for="NumeroChemise" class="w3-label w3-left">N°Chemise</label></div>
                                <div class="col-md-4"><input value="<?=$numeroChemise?>" type="number" name="NumeroChemise" required="required" class="w3-input w3-border w3-round-large" min="1" placeholder="1"/></div>
                                <div class="col-md-1"><label for="AnneeExercice" class="w3-label w3-left">-</label></div>
                                <div class="col-md-4"><input value="<?=$anneeExercice?>" type="number" name="AnneeExercice" required="required" class="w3-input w3-border w3-round-large" min="0" placeholder="<?=date( "Y" , time() )?>"/></div>
                            </div>
                        </div>

                        <label for="NumeroOrdreBC" class="w3-label w3-left">Numero d'ordre : </label>
                        <input value="<?=$numeroOrdreBC?>" type="number" name="NumeroOrdreBC" required="required" class="w3-input w3-border w3-round-large" min="1" placeholder="1"/><br/>

                        <div class="row">
                            <div class="col-md-2"><label for="NumeroEngagement" class="w3-label w3-left">ENG </label></div>
                            <div class="col-md-5"><input value="<?=$anneeEngagement?>" type="number" name="AnneeEngagement" required="required" class="w3-input w3-border w3-round-large"/></div>
                            <div class="col-md-5"><input value="<?=substr( $numeroEngagement , 7 , 16 )?>" type="number" name="NumeroEngagement" required="required" class="w3-input w3-border w3-round-large" placeholder="12345678"/></div>
                        </div><br/>

                        <div class="row">
                            <div class="col-md-2"><label for="NumeroBordereau" class="w3-label w3-left">BORD </label></div>
                            <div class="col-md-5"><input value="<?=$anneeBordereau?>" type="number" name="AnneeBordereau" required="required" class="w3-input w3-border w3-round-large"/></div>
                            <div class="col-md-5"><input value="<?=substr( $numeroBordereau , 4 , 16 )?>" type="number" name="NumeroBordereau" required="required" class="w3-input w3-border w3-round-large" placeholder="12345678"/></div>
                        </div><br/>

                        <!-- NUMERO PENSION INUTIL-->
                        <div style="display:none;">
                            <label for="NumeroPensionBC" class="w3-label w3-left">Numéro de Pension : </label>
                            <input value="0a11111" type="text" name="NumeroPension" required="required" maxlength="7" class="NumeroPensionBC w3-input w3-border w3-round-large" placeholder="0A12345"/>
                            <span class="NumeroPensionBC_message"></span><br/>
                        </div>

                        <label for="MontantBC" class="w3-label w3-left">Montant : </label>
                        <input type="text" name="MontantBC" value="<?=$montantBC?>" data-type="currency" required="required" class="w3-input w3-border w3-round-large" maxLength="13" placeholder="Ar 100.000"/><br/>

                        <label for="DateArrivee" class="w3-label w3-left">Date d' Arrivée :</label>
                        <input value="<?=$dateArrivee?>" type="date" name="DateArrivee" required="required" class="w3-input w3-border w3-round-large"/><br/>

                        <div <?php if( $etatDossier == "arrivee" ) echo "style=\"display:none;\""; ?> class="container-fluid">
                            <label for="DateDelivrance" class="w3-label w3-left">Date de Delivrance :</label>
                            <input value="<?=$dateDelivrance?>" type="date" name="DateDelivrance" required="required" class="w3-input w3-border w3-round-large"/><br/>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <a href="dossierRemboursement.php" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Annuler</a>
                    <button type="submit" name="BoutonModifierBC" class="BoutonBC btn btn-warning"><span class="glyphicon glyphicon-floppy-disk"></span> Modifier</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET A CHAQUE REACTUALISATION SI GET EDITBC EST DONNEE -->
<a class="OuvrirModalBC" href="#ModalModifierBC" data-toggle="modal">Ouvrir Modal Modifier BC</a>
<script src="../Modeles/ouvrirModalBC.js"></script>