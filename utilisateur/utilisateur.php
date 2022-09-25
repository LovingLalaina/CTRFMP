<!DOCTYPE html>
<html>
    <?php require_once( "../Vues/head.php" ); ?>
    <body>
        <?php
            require_once( "../Modeles/ouverture.php" ); //CE FICHIER INCLU LA CONNEXION ET LA SESSION POUR NE PLUS DEVOIR LA RAPPELLER
            
            if( isset( $_GET["edit"] ) || isset( $_GET["delete"] ) )
            {
                $idUtilisateur = ( isset( $_GET["edit"] ) ) ? $_GET["edit"] : $_GET["delete"];
                $requeteSQL = "SELECT * FROM utilisateur WHERE id='$idUtilisateur'";

                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );
                //CAS OU L'ON FAIT UN BACKSPACE APRES SUPPRESSION OU MODIFICATION ET QUE L'IDENTIFIANT N'EXISTE PLUS
                if( $resultatSELECT->num_rows <= 0 ) header( "location:./utilisateur.php" );
                $resultatSELECT = $resultatSELECT->fetch_assoc();

                $nomUtilisateur = $resultatSELECT["nom_utilisateur"];
                $motDePasse = $resultatSELECT["mot_de_passe"];
                $typeUtilisateur = $resultatSELECT["type_utilisateur"];
            }
            else if( isset( $_SESSION["idUtilisateur"] ) ) // EN CAS D'ECHEC DE MODIFICATION
            {
                $idUtilisateur = $_SESSION["idUtilisateur"];
                unset( $_SESSION["idUtilisateur"] );
                $requeteSQL = "SELECT * FROM utilisateur WHERE id='$idUtilisateur'";
            }
            else //CAS PAR DEFAUT : AFFICHER LES 100 DERNIERS PENSIONNAIRES MANIPULES
                $requeteSQL = "SELECT * FROM utilisateur ORDER BY id DESC LIMIT 100";

            require_once( "../Vues/nav.php" );
            require_once( "../Vues/divMessage.php" );

        ?>

        <section class="container">
            <!-- 1) BARRE DE RECHERCHE ET BOUTON AJOUTER PENSIONNAIRE -->
            <div class="row" style="margin-bottom:15px;">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6"><!-- <input name="RecherchePensionnaire" id="RecherchePensionnaire" class="couleur-blancCasse form-control" type="text" placeholder="Numéro ou Nom..." maxlength="50"/> --></div>
                    </div>
                </div>
                <div class="col-md-2"><a id="OuvrirModalAjouter" href="#ModalAjouterUtilisateur" class="form-control btn btn-success" data-toggle="modal"><span style="position:relative; top:4px;"><i class="fas fa-plus text-white"></i>AJOUTER<i style="position:relative;top:2px;right:1px" class="ni ni-single-02 text-white"></i></span></a></div>
            </div>
            <!-- 1) FIN BARRE DE RECHERCHE ET BOUTON AJOUTER UTILISATEUR -->

            <!-- 2) TABLEAU DES PENSIONNAIRES -->
            <div class="row div-table div-table-utilisateur">
                <table id="TablePensionnaire" class="table">
                    <thead>
                        <tr>
                            <!-- EMPLACEMENT DES STYLES DE TABLEAU OBLIGATOIRE A CAUSE DE BOOTSTRAP-->
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Identifiant</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Nom d'utilisateur</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Section</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;" colspan="2">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                    
                        //LA REQUETE SQL VARIE SELON LES CONDITIONS IF DONNEE EN HAUT ♠ 
                        $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );
                    
                        while( $ligne = $resultatSELECT->fetch_assoc() ) : ?>
                        <tr class="ligne-utilisateur">
                            <td style="font-size: 14px;">U<?=$ligne["id"]?></td>
                            <td style="font-size: 14px;"><?=$ligne["nom_utilisateur"]?></td>
                            <td style="font-size: 14px;text-transform:uppercase;"><?php if( $ligne["type_utilisateur"] == "user" ) echo "delivrance"; else if( $ligne["type_utilisateur"] == "admin" ) echo "administrateur"; else echo $ligne["type_utilisateur"]; ?></td>
                            <td style="font-size: 14px;">
                                <a href="utilisateur.php?edit=<?=$ligne["id"]?>" class="btn btn-info btn-sm"><i class='fas fa-edit'></i> Modifier</a>
                                <a href="utilisateur.php?delete=<?=$ligne["id"]?>" class="btn btn-danger btn-sm"><i class='fas fa-trash'></i> Supprimer</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- 2) FIN TABLEAU DES UTILISATEURS -->
            <br/><br/><br/>
        </section>

        <?php
            require_once( "ajouterUtilisateurModal.php" );
            if( isset( $_GET["edit"] ) ) require_once( "modifierUtilisateurModal.php" );
            if( isset( $_GET["delete"] ) ) require_once( "supprimerUtilisateurModal.php" );
        ?>
        
        <!-------------------------------- SCRIPTS NECESSAIRES AU FICHIER UTILISATEUR.PHP -------------------------------------->

        <script type="text/javascript" src="../Controleurs/validerUtilisateur.js"></script>
    </body>
</html>