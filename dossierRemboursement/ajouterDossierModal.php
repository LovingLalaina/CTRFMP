
    
<div class="modal fade" id="ModalAjouterDossier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">RÉCEPTION DE DOSSIER</h4>
            </div>
            <form method="POST" action="ajouterDossier.php" enctype="multipart/form-data" name="FormAjoutDossier">
                <div class="modal-body">
                    <div class="container-fluid">
                        <label for="DateReception" class="w3-label w3-left">Date de Réception :</label>
                        <input value="<?php if( isset( $_SESSION["ajoutDossier"] ) ) echo $_SESSION["dateReception"]; else echo date("Y-m-d", time() ); ?>" type="date" name="DateReception"  required="required" class="DateReception InputADesactiver w3-input w3-border w3-round-large"/><br/>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-3" style="padding-top:5px;padding-left:25px;"><label for="NumeroDossier" class="w3-label w3-left">FM : R4 - </label></div>
                                <div class="col-md-3"><input value="<?php if( isset( $_SESSION["ajoutDossier"] ) ) echo explode( "-" , $_SESSION["numeroDossier"] )[1]; else{ $dernierNumero = $connexionMySQLi->query( "SELECT num_dossier AS dernier_numero FROM dossier WHERE year(date_recep)=year(now()) ORDER BY id DESC LIMIT 1") or die( $connexionMySQLi->error ); $dernierNumero = $dernierNumero->fetch_assoc(); echo ( ( explode( "-" , $dernierNumero["dernier_numero"] )[1] ) + 1 ); } ?>" type="number" name="NumeroDossier" required="required" class="InputADesactiver w3-input w3-border w3-round-large" min="1" placeholder="1"/></div>-
                                <div class="col-md-3"><input value="<?php if( isset( $_SESSION["ajoutDossier"] ) ) echo $_SESSION["anneeReception"]; else echo date( "Y" , time() ); ?>" type="number" name="AnneeReception" required="required" class="AnneeReception InputADesactiver w3-input w3-border w3-round-large" min="0"/></div>
                                <div class="col-md-1"  style="padding-top:5px;"><input type="checkbox" name="Bis" class="InputADesactiver w3-input w3-border w3-round-large" <?php if( isset( $_SESSION["ajoutDossier"] ) && $_SESSION["bis"] ) echo "checked"; ?>/></div>BIS
                                <span class="AnneeReception_message"></span><br/>
                            </div>
                        </div>
                        
                        <label for="NumeroPension" class="w3-label w3-left">Numéro de Pension : </label>
                        <input id="NumeroPension" value="<?php if( isset( $_SESSION["ajoutDossier"] ) ) echo $_SESSION["numeroPension"]; else if( isset( $_GET["numPens"] ) )   echo $_GET["numPens"]; ?>" type="text" name="NumeroPension" required="required" maxlength="13" class="NumeroPension InputADesactiver w3-input w3-border w3-round-large" placeholder="0A12345"/>
                        <span class="NumeroPension_message"></span><br/>

                        <label for="MontantProvisoire" class="w3-label w3-left">Montant Provisoire : </label>
                        <input id="MontantProvisoire" type="text" name="MontantProvisoire" value="<?php if( isset( $_SESSION["ajoutDossier"] ) ) echo $_SESSION["montantProvisoire"]; ?>" data-type="currency" required="required" class="InputADesactiver w3-input w3-border w3-round-large" maxLength="13" placeholder="Ar 100.000"/><br/>

                        <label for="SigleComptable" class="w3-label w3-left">Comptable traitant le dossier : </label>
                        <input value="<?php if( isset( $_SESSION["ajoutDossier"] ) ) echo $_SESSION["sigleComptable"]; ?>" type="text" name="SigleComptable" class="InputADesactiver w3-input w3-border w3-round-large" maxLength="5" placeholder="LLA"/><br/>

                        <p class="container-fluid chemise alert alert-warning">NB : Ou bien <span id="BoutonImporterDossier" class="btn btn-danger">importer</span> une liste de frais médicaux SIGRFM (*.csv)<br/>La base de données doit avoir la structure suivante: |numero FM|Etat Dossier|num pension|nom|montant prov|montant def|contact</p>

                        <div class="row">
                            <div class="col-md-4"><label for="FichierDossier" class="w3-label w3-left">Choisir fichier:</label></div>
                            <div class="col-md-8" id="DivFichierDossier"><input disabled id="FichierDossier" type="file" name="FichierDossier" accept=".csv" class="w3-input w3-border w3-round-large"/><br/></div>
                        </div>
                        
                        <?php unset( $_SESSION["ajoutDossier"] ); ?>

                    </div> 
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonAjouterDossier" class="BoutonDossier btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById("BoutonImporterDossier").addEventListener( "click", function()
    {
        var NumPens = document.getElementById("NumeroPension");
        NumPens.value = "0a11111";
        var MontantProv = document.getElementById("MontantProvisoire");
        MontantProv.value = "Ar 140.000";

        var inputADesactiver = $( ".InputADesactiver" );
        $( ".InputADesactiver" ).css( "color" , "rgb(226, 226, 226)" );
        $( ".InputADesactiver" ).css( "background-color" , "rgb(226, 226, 226)" );
        $( ".InputADesactiver" ).attr( "disabled" , true );

        document.getElementById("FichierDossier").disabled = false;
        document.getElementById("FichierDossier").click();
    });
</script>