<!DOCTYPE html>
<html>
    <?php require_once( "../Vues/head.php" ); ?>
    <body>
        <?php
            require_once( "../Modeles/ouverture.php" ); //CE FICHIER INCLU LA CONNEXION ET LA SESSION POUR NE PLUS DEVOIR LA RAPPELLER
            
            if( isset( $_GET["edit"] ) || isset( $_GET["delete"] ) )
            {
                $idPensionnaire = ( isset( $_GET["edit"] ) ) ? $_GET["edit"] : $_GET["delete"];
                $requeteSQL = "SELECT * FROM pensionnaire WHERE id='$idPensionnaire'";

                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );
                //CAS OU L'ON FAIT UN BACKSPACE APRES SUPPRESSION OU MODIFICATION ET QUE L'IDENTIFIANT N'EXISTE PLUS
                if( $resultatSELECT->num_rows <= 0 ) header( "location:./pensionnaire.php" );
                $resultatSELECT = $resultatSELECT->fetch_assoc();
                
                require_once("../Fonctions/diviserParNomEtPrenom.php");
                $numeroPension = $resultatSELECT["num_pens"];
                $nomCompletPensionnaire = $resultatSELECT["nom_et_prenom"];
                $nomPensionnaire = diviserParNomEtPrenom( $nomCompletPensionnaire )[0];
                $prenomPensionnaire = diviserParNomEtPrenom( $nomCompletPensionnaire )[1];
                $adressePensionnaire = $resultatSELECT["adresse"];
                $numeroTelephone = $resultatSELECT["num_tel"];
            }
            else if( isset( $_SESSION["idPensionnaire"] ) ) // EN CAS D'ECHEC DE MODIFICATION
            {
                $idPensionnaire = $_SESSION["idPensionnaire"];
                unset( $_SESSION["idPensionnaire"] );
                $requeteSQL = "SELECT * FROM pensionnaire WHERE id='$idPensionnaire'";
            }
            else //CAS PAR DEFAUT : AFFICHER LES 100 DERNIERS PENSIONNAIRES MANIPULES
                $requeteSQL = "SELECT * FROM pensionnaire ORDER BY id DESC LIMIT 100";

            require_once( "../Vues/nav.php" );
            require_once( "../Vues/divMessage.php" );

        ?>

        <section class="container">
            <!-- 1) BARRE DE RECHERCHE ET BOUTON AJOUTER PENSIONNAIRE -->
            <div class="row" style="margin-bottom:15px;">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6"><input name="RecherchePensionnaire" id="RecherchePensionnaire" class="couleur-blancCasse form-control" type="text" placeholder="Numéro ou Nom..." maxlength="50"/></div>
                    </div>
                </div>
                <div class="col-md-2"><a id="OuvrirModalAjouter" href="<?php if( $_SESSION["connexion"] == "admin" ) echo "#ModalAjouterPensionnaire"; else echo "#ModalDemanderMdp" ?>" class="form-control btn btn-success" data-toggle="modal"><span style="position:relative; top:4px;"><i class="fas fa-plus text-white"></i>AJOUTER<i style="position:relative;top:2px;right:1px" class="ni ni-single-02 text-white"></i></span></a></div>
            </div>
            <!-- 1) FIN BARRE DE RECHERCHE ET BOUTON AJOUTER PENSIONNAIRE -->

            <!-- 2) TABLEAU DES PENSIONNAIRES -->
            <div class="row div-table div-table-pensionnaire">
                <table id="TablePensionnaire" class="table">
                    <thead>
                        <tr>
                            <!-- EMPLACEMENT DES STYLES DE TABLEAU OBLIGATOIRE A CAUSE DE BOOTSTRAP-->
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N° Pension</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Nom et Prénom(s)</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Adresse</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Numero Téléphone</th>
                            <?php if( $_SESSION["connexion"] == "admin" ) : ?>
                                <th style="background-color: rgb(226, 226, 226);font-size: 15px;" colspan="2">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                    
                        //LA REQUETE SQL VARIE SELON LES CONDITIONS IF DONNEE EN HAUT ♠ 
                        $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );
                    
                        while( $ligne = $resultatSELECT->fetch_assoc() ) : ?>
                        <tr class="ligne-pensionnaire">
                            <td style="font-size: 14px;"><a class="LienVersDossier" href="../dossierRemboursement/dossierRemboursement.php?numPens=<?=$ligne["num_pens"]?>"><?=$ligne["num_pens"]?></a></td>
                            <td style="font-size: 14px;"><?=$ligne["nom_et_prenom"]?></td>
                            <td style="font-size: 14px;"><?=$ligne["adresse"]?></td>
                            <td style="font-size: 14px;"><?=$ligne["num_tel"]?></td>
                            <?php if( $_SESSION["connexion"] == "admin" ) : ?>
                                <td style="font-size: 14px;">
                                    <a href="pensionnaire.php?edit=<?=$ligne["id"]?>" class="btn btn-info btn-sm"><i class='fas fa-edit'></i> Modifier</a>
                                    <a href="pensionnaire.php?delete=<?=$ligne["id"]?>" class="btn btn-danger btn-sm"><i class='fas fa-trash'></i> Supprimer</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- 2) FIN TABLEAU DES PENSIONNAIRES -->
            <br/><br/><br/>
        </section>

        <?php
            require_once( "ajouterPensionnaireModal.php" );
            if( isset( $_GET["edit"] ) ) require_once( "modifierPensionnaireModal.php" );
            if( isset( $_GET["delete"] ) ) require_once( "supprimerPensionnaireModal.php" );
            if( !( isset( $_GET["edit"] ) || isset( $_GET["delete"] ) ) ) require_once( "pensionnaireAbsent.php" );
            require_once( "../Authentification/ModalDemanderMdp.php" );
        ?>
        
        <!-------------------------------- SCRIPTS NECESSAIRES AU FICHIER PENSIONNAIRE.PHP -------------------------------------->

        <script type="text/javascript" src="../Modeles/exprReg.js"></script>
        <script type="text/javascript" src="../Controleurs/validerRetraite.js"></script>
        <script type="text/javascript" src="../Modeles/lienVersDossier.js"></script>
        <script type="text/javascript" src="rechercherPensionnaireAjax.js"></script>
    </body>
</html>