
<div id="ModalErreurUtilisateur" class="modal fade">
	<div class="modal-Dialog modal-dialog modal-confirm">
		<div class="modal-Content modal-content">
			<div class="modal-Header modal-header" style="background-color:rgb(255, 166, 0);">
				<div class="icon-box" style="background-color:rgb(255, 81, 0);">
					<i class="fa fa-user"></i>
				</div>				
				<h4 style="position:relative; bottom:15px;" class="modal-title w-100">Erreur!!</h4>	
			</div>
			<div class="modal-body">
				<p class="text-center" style="color:rgb(37, 37, 37);">L'utilisateur entré n'existe pas</p>
			</div>
			<div class="modal-Footer modal-footer">
				<a href="login.php" class="btn btn-primary btn-block">Réessayer</a>
			</div>
		</div>
	</div>
</div>

<!-- OUVERTURE DIRECTE DU MODAL -->
<a id="OuvrirModalErreurUtilisateur" class="OuvrirModal" href="#ModalErreurUtilisateur" data-toggle="modal">Ouvrir Erreur Utilisateur</a>
<script>

    window.addEventListener( "load", function()
    {
        document.getElementById( "OuvrirModalErreurUtilisateur" ).click();
    });

</script>