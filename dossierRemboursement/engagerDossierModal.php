
    
<div class="modal fade" id="ModalEngagerDossier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">ENGAGEMENT DE DOSSIER</h4>
            </div>
            <form method="POST" action="preparerEngagementDossier.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="container-fluid">
                        <p class="container-fluid chemise alert alert-success">Veuillez donner la liste d'engagement (*.csv)<br/>La base de données doit avoir la structure suivante: |numero FM|Ref Engag|num pension|date recep|montant def|contact</p>

                        <div class="row">
                            <div class="col-md-4"><label for="FichierEngagement" class="w3-label w3-left">Choisir fichier:</label></div>
                            <div class="col-md-8"><input type="file" name="FichierEngagement" accept=".csv" class="w3-input w3-border w3-round-large" required="required"/><br/></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonPreparerEngagement" class="BoutonPreparer btn btn-success"> Importer <i class="fas fa-angle-double-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

