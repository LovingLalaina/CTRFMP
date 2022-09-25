
    
<div class="modal fade" id="ModalEtudierDossier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">ÉTUDE DE DOSSIER</h4>
            </div>
            <form method="POST" action="preparerEtudeDossier.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <p class="container-fluid chemise alert alert-success">Veuillez donner les Dossiers qui obtiendront leur montant définitif</p>

                        <label for="AnneeReception" class="w3-label w3-left">Année de Réception :</label>
                        <input value="<?php if( isset( $_SESSION["etudeDossier"] ) ) echo $_SESSION["anneeReception"]; else echo date("Y", time() ); ?>" type="number" name="AnneeReception" required="required" min="0" class="w3-input w3-border w3-round-large"/><br/>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1"><label for="NumeroDossierDebut" class="w3-label w3-left">N° </label></div>
                                <div class="col-md-4"><input <?php if( isset( $_SESSION["etudeDossier"] ) ){ $numDeb=$_SESSION["numeroDossierDebut"]; echo "value=\"$numDeb\""; } ?> type="number" name="NumeroDossierDebut" required="required" class="NumeroDebut w3-input w3-border w3-round-large" min="1" placeholder="1"/></div>
                                <div class="col-md-2"><label for="NumeroDossierFin" class="w3-label w3-left">Jusqu'à</label></div>
                                <div class="col-md-4"><input <?php if( isset( $_SESSION["etudeDossier"] ) ){ $numFin=$_SESSION['numeroDossierFin']; echo "value=\"$numFin\""; } ?> type="number" name="NumeroDossierFin" required="required" class="NumeroFin w3-input w3-border w3-round-large" min="1" placeholder="20"/></div>
                            </div>
                            <div style="text-align:center;" class="NumeroPreparer_message"></div>
                        </div>
                        <?php unset( $_SESSION["etudeDossier"] ); ?>
                    </div>
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonPreparerEtude" class="BoutonPreparer btn btn-success"> Continuer <i class="fas fa-angle-double-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

