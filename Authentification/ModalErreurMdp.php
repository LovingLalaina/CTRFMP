
<div id="ModalErreurMdp" class="modal fade">
	<div class="modal-Dialog modal-dialog modal-confirm">
		<div class="modal-Content modal-content">
			<div class="modal-Header modal-header" style="background-color:rgb(255, 166, 0);">
				<div class="icon-box" style="background-color:rgb(255, 81, 0);">
					<i class="fa fa-user"></i>
				</div>				
				<h4 style="position:relative; bottom:15px;" class="modal-title w-100">Erreur!!</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center" style="color:rgb(37, 37, 37);">Mot de passe Incorrect</p>
			</div>
			<div class="modal-Footer modal-footer">
				<button onclick="document.FormulaireLogin.MotDePasse.focus();" data-dismiss="modal" class="btn btn-primary btn-block">Réessayer</button>
			</div>
		</div>
	</div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL -->
<a id="OuvrirModalErreurMdp" class="OuvrirModal" href="#ModalErreurMdp" data-toggle="modal">Ouvrir Erreur Mdp</a>
<script>

    window.addEventListener( "load", function()
    {
        document.getElementById( "OuvrirModalErreurMdp" ).click();
    });

</script>