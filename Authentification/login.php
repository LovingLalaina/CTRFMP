<!DOCTYPE html>
<html>
    <?php require_once( "../Vues/head.php" ); ?>
    <link rel="stylesheet" href="../StyleS/login.scss"/>
    <body class="couleur-blancCasse">
        <div class="wrapper chemise couleur-blancCasse" style="margin-left:400px;padding:20px 20px;text-align:center; width:500px;"><br/>
            <form action="authentification.php" name="FormulaireLogin" method="POST" class=" container form-signin" style="box-shadow: 0 5px 10px #a8a8a8;">       
            <h2 class="form-signin-heading">CONNEXION</h2><br/>
                <div class="row">
                    <div class="col-md-11"><input type="text" class="form-control" name="Utilisateur" placeholder="Utilisateur" required="true" autofocus="" <?php if( isset( $_GET["error"] ) && $_GET["error"] == "mdp" ) echo "value=\"".$_GET["user"]."\""; ?>/><br/></div>
                    <div class="col-md-1" style="position:relative;top:10px;right:10px;"><i class="fa fa-user text-purple" onclick="document.FormulaireLogin.Utilisateur.focus();"></i></div>
                </div>
                <div class="row">
                    <div class="col-md-11"><input type="password" class="form-control" name="MotDePasse" placeholder="Mot de Passe" required="true"/></div>
                    <div class="col-md-1" style="position:relative;top:10px;right:10px;"><i id="AfficherMdp" class="fas fa-eye-slash text-purple"></i></div>
                </div>
                <label class="checkbox container">
                    <!-- <input type="checkbox" value="SeSouvenirUtilisateur" id="SeSouvenirUtilisateur" name="SeSouvenirUtilisateur" style="position:relative;top:2px;right:2px;"/> Se souvenir à la prochaine connexion  -->
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="BoutonSeConnecter">Se connecter</button>
                <div><br/></div>
            </form>
        </div>

        <script src="../Modeles/dynamiserMdp.js" ></script>

        <?php
            if( isset( $_GET["error"] ) )
            {
                if( $_GET["error"] == "user" )  require_once( "ModalErreurUtilisateur.php" );
                else                            require_once( "ModalErreurMdp.php" );
            }
        ?>
    </body>
</html>