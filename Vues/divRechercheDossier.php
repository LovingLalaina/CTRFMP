
<?php
    $manipulationCRUD = false;
    if( isset( $_GET["editDossier"] ) || isset( $_GET["deleteDossier"] ) )
    {
        $idPensionAfficher = ( isset( $_GET["editDossier"] ) ) ? $_GET["editDossier"] : $_GET["deleteDossier"];
        $numeroPensionAfficher = $connexionMySQLi->query( "SELECT num_pens FROM dossier WHERE id='$idPensionAfficher'" ) or die( mysqli_error( $connexionMySQLi ) );
        $numeroPensionAfficher = ( $numeroPensionAfficher->fetch_assoc() )["num_pens"];
        $manipulationCRUD = true;
    }
    else if( isset( $_GET["editBC"] ) || isset( $_GET["deleteBC"] ) )
    {
        $idPensionAfficher = ( isset( $_GET["editBC"] ) ) ? $_GET["editBC"] : $_GET["deleteBC"];
        $numeroPensionAfficher = $connexionMySQLi->query( "SELECT num_pens FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE bon_de_caisse.id='$idPensionAfficher'" ) or die( mysqli_error( $connexionMySQLi ) );
        $numeroPensionAfficher = ( $numeroPensionAfficher->fetch_assoc() )["num_pens"];
        $manipulationCRUD = true;
    }

    if( $manipulationCRUD )
    {
        $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM pensionnaire_absent WHERE num_pens='$numeroPensionAfficher'" ) or die( mysqli_error( $connexionMySQLi ) );
        if( $resultatSELECT->num_rows >= 1 )  $nomCompletPensionnaire = "(Retraité non enregistré)";
        else
        {
            $resultatSELECT = $connexionMySQLi->query( "SELECT nom_et_prenom, adresse, num_tel FROM pensionnaire WHERE num_pens='$numeroPensionAfficher'" ) or die( mysqli_error( $connexionMySQLi ) );
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            $nomCompletPensionnaire = $resultatSELECT["nom_et_prenom"];
            $adressePensionnaire = $resultatSELECT["adresse"];
            $numeroTelephone = $resultatSELECT["num_tel"];
        }
    }
?>

<div id="divRechercheDossier" class="row">
    <form class="row col-md-11" method="GET">
        <fieldset class="row couleur-blancCasse" style="padding:10px 20px;box-shadow: 0 5px 10px #a8a8a8;">
            <legend>RECHERCHE PAR :</legend>

            <div class="row container-fluid col-md-9">
                <div class="col-md-3"><input checked type="radio" value="Numero" id="critereNumero" name="critereRecherche"/> <label for="critereNumero">Numéro de Pension</label></div>
                <div class="col-md-2"><input type="radio" value="FM" id="critereFM" name="critereRecherche"/> <label for="critereFM">FM</label></div>
                <div class="col-md-2"><label for="EtatDossier">Etat Dossier :</label></div>
                <div class="col-md-3">
                    <select name="EtatDossier" class="w3-select w3-left">
                        <option value="tout" <?php if( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "tout" ) echo "selected"; ?>>Tout</option>
                        <option value="recu" <?php if( isset( $_GET["etude"] ) || ( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "recu" ) ) echo "selected"; ?>>Reçu</option>
                        <option value="etudie" <?php if( isset( $_GET["engag"] ) || ( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "etudie" ) ) echo "selected"; ?>>Etudié</option>
                        <option value="engage" <?php if( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "engage" ) echo "selected"; ?>>Engagé</option>
                        <option value="liquide" <?php if( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "liquide" ) echo "selected"; ?>>Liquidé</option>
                        <option value="arrivee" <?php if( isset( $_GET["deliv"] ) || ( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "arrivee" ) ) echo "selected"; ?>>BC en attente</option>
                        <option value="delivre" <?php if( isset( $_GET["EtatDossier"] ) && $_GET["EtatDossier"] == "delivre" ) echo "selected"; ?>>Délivré</option>
                    </select>
                </div>
                <div class="col-md-1"><button name="BoutonAfficherDossier" class="BoutonNumeroPension btn btn-primary" type="submit" value="true"><i class="fas fa-search"></i> Afficher</button></div>
            </div><br/><br/>

            <div class="row">
                <div class="col-md-6">

                    <div id="rechercheParNumero">
                        <label for="numPens">N° Pension : </label>
                        <input value="<?=$numeroPensionAfficher?>" type="text" name="numPens" class="numPens" maxLength="13"/>
                    </div>

                    <div id="rechercheParFM" class="row">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="row">
                                    <div class="col-md-1"><label for="numDossier" style="position:relative;top:2px;">FM</label></div>
                                    <div class="col-md-5"><input value="<?=$numeroDossierAfficher?>" type="number" name="numDossier" min="1" placeholder="Numero Dossier"/></div>
                                    <div class="col-md-1"><label for="anneeRecep" style="position:relative;top:2px;left:10px;">-</label></div>
                                    <div class="col-md-5"><input value="<?=$anneeDossierAfficher?>" type="number" name="anneeRecep" min="0" placeholder="Annee Reception"/></div>
                                </div>
                            </div>
                        </div>
                    </div><br/>
                    <label>Nom et prénom(s) : <?=$nomCompletPensionnaire?></label>
                </div>
                <div class="col-md-5">
                    <label>Numéro Téléphone : <?=$numeroTelephone?></label><br/><br/>
                    <label>Adresse : <?=$adressePensionnaire?></label>
                </div>
            </div>
            
        </fieldset>
    </form>
</div>

<style>
    #rechercheParNumero
    {
        display: block;
    }
    #rechercheParFM
    {
        display:none;
    }
</style>

<script type="text/javascript" src="../Controleurs/modeRecherche.js"></script>

<?php if( isset( $_GET["critereRecherche"] ) && $_GET["critereRecherche"] == "FM" ) : ?>
    <script>
        critereFM.click();
        rechercheParFM.style.display = "block";
        rechercheParNumero.style.display = "none";
    </script>
<?php endif; ?>