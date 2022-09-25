
    
<div class="modal fade" id="ModalEchecDelivrerBC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">DÉLIVRANCE DE BON DE CAISSE</h4>
            </div>
            <form method="GET" action="dossierRemboursement.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <p class="container-fluid chemise alert alert-success">Veuillez rentrer le numero de pension des bons de caisse à délivrer</p>

                        <label for="numPens" class="w3-label w3-left">Numéro de Pension :</label>
                        <input id="NumPensDeliv" type="text" name="numPens" required="required" maxlength="13" class="numPens w3-input w3-border w3-round-large" placeholder="0A12345"/>
                        <span class="numPens_message"></span><br/>
                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="deliv" class="BoutonNumeroPension btn btn-success" value="true"> Continuer <i class="fas fa-angle-double-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.addEventListener( "load" , function()
    {
        // CE LIEN SE TROUVE DANS LE ASIDE
        document.getElementById( "OuvrirModalEchecBC" ).addEventListener( "click" , function()
        {
            document.getElementById( "NumPensDeliv" ).value = document.getElementById( "numPens" ).value;
        });
    });
</script>

