
<?php

	$numeroPension = $connexionMySQLi->query( "SELECT num_pens FROM pensionnaire_absent" ) or die( $connexionMySQLi->error );
	if( $numeroPension->num_rows >= 1 ) :

	$_SESSION["ajoutPensionnaire"] = "important";
	$_SESSION["numeroPension"] = $numeroPension = ( $numeroPension->fetch_assoc() )["num_pens"];
	$_SESSION["nomPensionnaire"] = "";
	$_SESSION["prenomPensionnaire"] = "";
	$_SESSION["adressePensionnaire"] = "";
?>

<div id="ModalPensionnaireAbsent" class="modal fade">
	<div class="modal-Dialog modal-dialog modal-confirm">
		<div class="modal-Content modal-content">
			<div class="modal-Header modal-header" style="background-color:rgb(255, 166, 0);">
				<div class="icon-box" style="background-color:rgb(255, 81, 0);">
					<i class="fa fa-user"></i>
				</div>				
				<h4 style="position:relative; bottom:15px;" class="modal-title w-100">Attention!!</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center" style="color:rgb(37, 37, 37);">Le numero de pension <?=strtoupper($numeroPension)?> n'est pas enregistré. Voulez-vous l'ajouter?</p>
			</div>
			<div class="modal-Footer modal-footer">
				<button id="BoutonEnregistrer" class="btn btn-primary btn-block" data-dismiss="modal"><span style="position:relative; top:1px;"><i class="fas fa-plus text-white"></i>Enregistrer<i style="position:relative;top:2px;right:1px" class="ni ni-single-02 text-white"></i></span></button>
			</div>
		</div>
	</div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL ET REDIRECTION SI BOUTON ENREGISTRER EST CLICKE -->
<a class="OuvrirModal" href="#ModalPensionnaireAbsent" data-toggle="modal">Ouvrir Pensionnaire Absent</a>
<script type="text/javascript" src="../Modeles/ouvrirModal.js"></script>
<script type="text/javascript" src="../Modeles/ouvrirModalEnregistrer.js"></script>

<?php endif; ?>