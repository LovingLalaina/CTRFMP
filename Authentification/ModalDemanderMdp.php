
<div id="ModalDemanderMdp" class="modal fade">
	<div class="modal-Dialog modal-dialog modal-confirm">
		<div class="modal-Content modal-content">
			<div class="modal-Header modal-header" style="background-color:rgb(255, 166, 0);">
				<div class="icon-box" style="background-color:rgb(255, 81, 0);">
					<i class="fa fa-user"></i>
				</div>				
				<h4 style="position:relative; bottom:15px;" class="modal-title w-100">Droit d'accès</h4>	
			</div>
			<form name="FormulaireLogin" method="POST" action="../Authentification/donnerDroit.php">
				<div class="modal-body">
					<p class="text-center" style="color:rgb(37, 37, 37);">Veuillez confirmer le mot de passe administrateur</p><br/>
					<div class="row">
						<div class="col-md-11"><input type="password" class="w3-input w3-border w3-round-large" name="MotDePasse" placeholder="Mot de Passe" required="true"/></div>
						<div class="col-md-1" style="position:relative;top:10px;right:10px;"><i id="AfficherMdp" class="fas fa-eye-slash text-purple"></i></div>
					</div>
				</div>
				<div class="modal-Footer modal-footer">
					<input type="submit" name="BoutonConfirmerMdp" value="OK" class="btn btn-primary btn-block"/>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="../Modeles/dynamiserMdp.js" ></script>