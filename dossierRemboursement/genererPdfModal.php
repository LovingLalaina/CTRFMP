
    
<div class="modal fade" id="ModalGenererPdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">BONS DE CAISSE ARRIVÉS</h4>
            </div>
            <form method="POST" action="preparerPdf.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <p class="container-fluid chemise alert alert-success">Veuillez spécifier les Bons de Caisses arrivés entre : </p>
                        <div class="container-fluid">
                            <div class="row container col-md-12">
                            <div class="col-md-7">
                                <input checked type="radio" name="typePdf" id="DerniereSemaine" value="DerniereSemaine"/>
                                <label for="DerniereSemaine" class="w3-label"> La semaine dernière</label>
                            </div><br/><br/>

                            <div class="row">
                                <div style="position:relative;top:10px;" class="col-md-1">
                                    <input type="radio" name="typePdf" id="Entre2Date" value="Entre2Date" class="w2-radio"/>
                                    <label for="Entre2Date" class="w3-label"></label>
                                </div>
                                <div class="col-md-11">
                                    <div class="row">
                                        <div class="col-md-6"><input value="<?=date("Y-m-d", time() )?>" type="date" name="DateDebut" class="w3-input w3-border w3-round-large"/></div>
                                        <div class="col-md-6"><input value="<?=date("Y-m-d", time() )?>" type="date" name="DateFin" class="w3-input w3-border w3-round-large"/></div>
                                    </div><br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonPreparerPdf" class="BoutonPreparerPdf btn btn-success"><i class="fas fa-task"></i> Afficher</button>
                </div>
            </form>
        </div>
    </div>
</div>
