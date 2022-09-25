
<?php

    $resultatSELECT = $connexionMySQLi->query( "SELECT * FROM chemise_absent" ) or die( $connexionMySQLi->error );
    if( $resultatSELECT->num_rows >= 1 ) :
        
    $resultatSELECT = $resultatSELECT->fetch_assoc();
    $_SESSION["ajoutChemise"] = "important";
    $_SESSION["numeroChemise"] = $numeroChemise = $resultatSELECT["num_chemise"];
    $_SESSION["anneeExercice"] = $anneeExercice = $resultatSELECT["annee_exercice"];
    $_SESSION["couleurChemise"] = "blanc";
?>

>
<div id="ModalChemiseAbsent" class="modal fade">
    <div class="modal-Dialog modal-dialog modal-confirm">
        <div class="modal-Content modal-content">
            <div class="modal-Header modal-header" style="background-color:rgb(255, 166, 0);">
                <div class="icon-box" style="background-color:rgb(255, 81, 0);">
                    <i class="fas fa-folder-open"></i>
                </div>				
                <h4 style="position:relative; bottom:15px;" class="modal-title w-100">Attention!!</h4>	
            </div>
            <div class="modal-body">
                <p class="text-center" style="color:rgb(37, 37, 37);">La chemise N° <?=$numeroChemise." - ".$anneeExercice?> n'est pas enregistrée. Voulez-vous l'ajouter?</p>
            </div>
            <div class="modal-Footer modal-footer">
                <button id="BoutonEnregistrer" class="btn btn-primary btn-block" data-dismiss="modal"><span style="position:relative; top:1px;"><i class="fas fa-plus text-white"></i>Enregistrer<i style="position:relative;top:2px;right:1px" class="fas fa-folder-open text-white"></i></span></button>
            </div>
        </div>
    </div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET REDIRECTION SI BOUTON ENREGISTRER EST CLICKE -->
<a class="OuvrirModal" href="#ModalChemiseAbsent" data-toggle="modal">Ouvrir Chemise Absent</a>
<script type="text/javascript" src="../Modeles/ouvrirModal.js"></script>
<script type="text/javascript" src="../Modeles/ouvrirModalEnregistrer.js"></script>

<?php endif; ?>