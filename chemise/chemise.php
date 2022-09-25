<!DOCTYPE html>
<html>
    <?php require_once( "../Vues/head.php" ); ?>
    <body>
        <?php
            require_once( "../Modeles/ouverture.php" ); //CE FICHIER INCLU LA CONNEXION ET LA SESSION POUR NE PLUS DEVOIR LA RAPPELLER

            //A L'OUVERTURE AFFICHER LA CHEMISE D'ANNEE ACTUEL
            $anneeExercice = date( "Y" , time() );
            $numeroChemiseDebut = "";
            $numeroChemiseFin = "";
            $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE chemise.annee_exercice='$anneeExercice' GROUP BY chemise.id ORDER BY num_chemise ASC";

            if( isset( $_GET["affiChem"] ) )
            {
                $anneeExercice = $_GET["anneeEx"];
                $numeroChemiseDebut = $_GET["numDeb"];
                $numeroChemiseFin = $_GET["numFin"];

                if( $numeroChemiseDebut == "" && $numeroChemiseFin == "" )
                    $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE chemise.annee_exercice='$anneeExercice' GROUP BY chemise.id ORDER BY num_chemise ASC";
                else if( $numeroChemiseDebut == "" && $numeroChemiseFin != "" )
                    $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE (chemise.annee_exercice='$anneeExercice' AND chemise.num_chemise<=$numeroChemiseFin) GROUP BY chemise.id ORDER BY num_chemise ASC";
                else if( $numeroChemiseDebut != "" && $numeroChemiseFin == "" )
                    $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE (chemise.annee_exercice='$anneeExercice' AND chemise.num_chemise='$numeroChemiseDebut') GROUP BY chemise.id ORDER BY num_chemise ASC";
                else
                    $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE (chemise.annee_exercice='$anneeExercice' AND (chemise.num_chemise BETWEEN $numeroChemiseDebut AND $numeroChemiseFin)) GROUP BY chemise.id ORDER BY num_chemise ASC";


                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );

                if( $resultatSELECT->num_rows == 0 )
                {
                    $_SESSION["message"] = "Aucune chemise n'a été trouvée";
                    $_SESSION["typeMessage"] = "danger";
                }
                else
                {
                    $_SESSION["message"] = "Il y a $resultatSELECT->num_rows chemise(s) trouvée(s)";
                    $_SESSION["typeMessage"] = "success";
                }
                
            }
            else if( isset( $_GET["edit"] ) || isset( $_GET["delete"] ) )
            {
                $idChemise = ( isset( $_GET["edit"] ) ) ? $_GET["edit"] : $_GET["delete"];
                $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE chemise.id='$idChemise' GROUP BY chemise.id";
                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( $connexionMySQLi->error );
                //CAS OU L'ON FAIT UN BACKSPACE APRES SUPPRESSION OU MODIFICATION ET QUE L'IDENTIFIANT N'EXISTE PLUS
                if( $resultatSELECT->num_rows <= 0 ) header( "location:./chemise.php" );
                $resultatSELECT = $resultatSELECT->fetch_assoc();

                $anneeExercice = $resultatSELECT["annee_exercice"];
                $numeroChemise = $resultatSELECT["num_chemise"];
                $couleurChemise = $resultatSELECT["couleur"];
            }
            else if( isset( $_SESSION["idChemise"] ) ) // EN CAS D'ECHEC DE MODIFICATION
            {
                $idChemise = $_SESSION["idChemise"];
                $requeteSQL = "SELECT chemise.id AS idChemise, chemise.num_chemise, chemise.annee_exercice, couleur , count(bon_de_caisse.id) AS totalBC FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.annee_exercice=bon_de_caisse.annee_exercice AND chemise.num_chemise=bon_de_caisse.num_chemise) WHERE chemise.id='$idChemise' GROUP BY chemise.id";
                unset( $_SESSION["idChemise"] );
            }

            require_once( "../Vues/nav.php" );
            require_once( "../Vues/divMessage.php" );

        ?>

        <section class="container">
            <!-- 1) FORMULAIRE DE RECHERCHE ET BOUTON CREER(AJOUTER) CHEMISE -->
            <div class="row">
                <form class="col-md-9" method="GET">
                    <fieldset class="couleur-blancCasse" style="padding:10px 20px;box-shadow: 0 5px 10px #a8a8a8;">
                        <legend>Rechercher</legend>
                            <label for="anneeEx">Annee d'exercice : </label>
                            <input value="<?=$anneeExercice?>" type="number" name="anneeEx" required="required" min="0"/>
                            <br/><br/>
                            <label for="numDeb">N° Chemise : </label>
                            <input value="<?=$numeroChemiseDebut?>" type="number" name="numDeb" min="1" placeholder="(facultatif)"/>
 
                            <label for="numFin">Jusqu'à </label>
                            <input value="<?=$numeroChemiseFin?>" type="number" name="numFin" min="1" placeholder="(facultatif)"/>

                            <button name="affiChem" class="btn btn-primary" type="submit" value="true"><i class="fas fa-search"></i> Afficher</button>
                    </fieldset>
                </form>
                <div class="col-md-3"><a id="OuvrirModalAjouter" style="float:right;position:relative;top:40px;" href="#" class="btn btn-success" data-toggle="modal" data-target="<?php if( $_SESSION["connexion"] == "admin" ) echo "#ModalAjouterChemise"; else echo "#ModalDemanderMdp" ?>"><span style="position:relative; top:1px;"><i class="fas fa-plus text-white"></i>CREER<i style="position:relative;top:1px;right:1px" class="fas fa-folder-open"></i></span></a></div>
            </div>
            <!-- 1) FIN FORMULAIRE DE RECHERCHE ET BOUTON CREER(AJOUTER) CHEMISE -->

            <!-- 2) TABLEAU DES CHEMISES -->
            <div class="row div-table div-table-chemise" style="margin-top:15px;">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- EMPLACEMENT DU STYLE OBLIGATOIRE A CAUSE BOOTSTRAP -->
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Numero/Chemise</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Couleur</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">BC Présents</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">BC délivrés</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Total</th>
                            <?php if( $_SESSION["connexion"] == "admin" ) : ?>
                                <th style="background-color: rgb(226, 226, 226);font-size: 15px;" colspan="2">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                        $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );
                        while( $ligne = $resultatSELECT->fetch_assoc() ) : ?>
                        <tr class="ligne-chemise">
                            <td style="font-size: 16px;"><a class="LienVersDossier" href="../dossierRemboursement/dossierRemboursement.php?numChe=<?=$ligne["num_chemise"]?>&anneeEx=<?=$ligne["annee_exercice"]?>"><?=$ligne["num_chemise"]."/".$ligne["annee_exercice"]?></a></td>
                            <td style="font-size: 16px;"><p class="chemise couleur-<?=$ligne["couleur"]?>"><?php if( $ligne["couleur"] != "blanc" ) echo strtoupper( $ligne["couleur"] ); ?></p></td>
                            <td style="font-size: 16px;">
                                <?php // ICI ON RCHERCHE LE NOMBRE DE BC ARRIVEE ET NON DELIVRE
                                    $numChe = $ligne["num_chemise"];
                                    $anneeEx = $ligne["annee_exercice"];
                                    $nombreBCArrivee = $connexionMySQLi->query( "SELECT count(bon_de_caisse.id) AS nombre_BC_arrivee FROM chemise LEFT OUTER JOIN bon_de_caisse ON (chemise.num_chemise=bon_de_caisse.num_chemise AND chemise.annee_exercice=bon_de_caisse.annee_exercice) WHERE (chemise.num_chemise='$numChe' AND chemise.annee_exercice='$anneeEx' AND date_delivrance='0000-00-00')" ) or die( mysqli_error( $connexionMySQLi ) );
                                    $nombreBCArrivee = ( $nombreBCArrivee->fetch_assoc() )["nombre_BC_arrivee"];
                                    echo $nombreBCArrivee;
                                ?>
                            </td>
                            <td style="font-size: 16px;"><?=( $ligne["totalBC"] - $nombreBCArrivee )?></td>
                            <td style="font-size: 16px;"><?=$ligne["totalBC"]?></td>
                            <?php if( $_SESSION["connexion"] == "admin" ) : ?>
                                <td style="font-size: 16px;">
                                    <a href="chemise.php?edit=<?=$ligne["idChemise"]?>" class="btn btn-info btn-sm"><i class='fas fa-edit'></i> Modifier</a>
                                    <a href="chemise.php?delete=<?=$ligne["idChemise"]?>" class="btn btn-danger btn-sm"><i class='fas fa-trash'></i> Supprimer</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- 2) FIN TABLEAU DES CHEMISES -->
            <br/><br/><br/>
        </section>

        <?php
            require_once( "ajouterChemiseModal.php" );
            if( isset( $_GET["edit"] ) )   require_once( "modifierChemiseModal.php" );
            if( isset( $_GET["delete"] ) ) require( "supprimerChemiseModal.php" );
            if( !( isset( $_GET["edit"] ) || isset( $_GET["delete"] ) ) ) require_once( "chemiseAbsent.php" );
            require_once( "../Authentification/ModalDemanderMdp.php" );
        ?>

        <!-------------------------------- SCRIPTS NECESSAIRES AU FICHIER CHEMISE.PHP -------------------------------------->
        <script type="text/javascript" src="../Modeles/lienVersDossier.js"></script>
    </body>
</html>