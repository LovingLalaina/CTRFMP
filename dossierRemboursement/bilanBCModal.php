
    
<div class="modal fade" id="ModalBilanBC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #1687a7;">
                <h4 class="modal-title" id="myModalLabel" style="color:white;">FILTRER BON DE CAISSE</h4>
            </div>
            <form method="POST" action="preparerBilanBC.php">
                <div class="modal-body">
                    <div class="container-fluid">
                        <p class="container-fluid chemise alert alert-success">Veuillez entrer le mois et l'année à étudier</p>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="col-md-6">
                                        <input checked type="radio" name="ModeMois" id="Mensuel" class="Mensuel w2-radio"/>
                                        <label for="Mensuel" class="w3-label">Mensuel</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="radio" name="ModeMois" id="Trimestriel" class="Trimestriel w2-radio"/>
                                        <label for="Trimestriel" class="w3-label">Trimestriel</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="Mois" name="Mois">            
                                        <option value="1" <?php if( Date("m" , time() ) == 1 ) echo "selected"; ?>>Janvier</option>
                                        <option value="2" <?php if( Date("m" , time() ) == 2 ) echo "selected"; ?>>Fevrier</option>               
                                        <option value="3" <?php if( Date("m" , time() ) == 3 ) echo "selected"; ?>>Mars</option>
                                        <option value="4" <?php if( Date("m" , time() ) == 4 ) echo "selected"; ?>>Avril</option>
                                        <option value="5" <?php if( Date("m" , time() ) == 5 ) echo "selected"; ?>>Mai</option>
                                        <option value="6" <?php if( Date("m" , time() ) == 6 ) echo "selected"; ?>>Juin</option>
                                        <option value="7" <?php if( Date("m" , time() ) == 7 ) echo "selected"; ?>>Juillet</option>
                                        <option value="8" <?php if( Date("m" , time() ) == 8 ) echo "selected"; ?>>Aout</option>
                                        <option value="9" <?php if( Date("m" , time() ) == 9 ) echo "selected"; ?>>Septembre</option>
                                        <option value="10" <?php if( Date("m" , time() ) == 10 ) echo "selected"; ?>>Octobre</option>
                                        <option value="11" <?php if( Date("m" , time() ) == 11 ) echo "selected"; ?>>Novembre</option>
                                        <option value="12" <?php if( Date("m" , time() ) == 12 ) echo "selected"; ?>>Decembre</option>
                                    </select>
                                </div>
                            </div><br/>
                            <div class="row container-fluid">
                                <div class="col-md-2"><label style="position:relative;top:5px;" for="Annee" class="w3-label w3-left">Année:</label></div>
                                <div class="col-md-6"><input value="<?=date("Y", time() )?>" type="number" name="Annee" id="Annee" required="required" min="0" class="Annee w3-input w3-border w3-round-large"/></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #1687a7;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annuler</button>
                    <button type="submit" name="BoutonPreparerBilan" class="BoutonPreparerBilan btn btn-success"> Filtrer <i class="fas fa-angle-double-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
