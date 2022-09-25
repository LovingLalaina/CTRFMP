<?php
    require_once( "../Modeles/connexion.php" );
    
    if( isset( $_GET["getRecherchePensionnaire"] ) )
    {
        $recherchePensionnaire = addslashes( $_GET["getRecherchePensionnaire"] );
        $requeteSQL = "SELECT * FROM pensionnaire WHERE ( num_pens LIKE '%$recherchePensionnaire' or num_pens LIKE '$recherchePensionnaire%' or num_pens LIKE '%$recherchePensionnaire%' or num_pens = '$recherchePensionnaire' or nom_et_prenom LIKE '%$recherchePensionnaire' or nom_et_prenom LIKE '$recherchePensionnaire%' or nom_et_prenom LIKE '%$recherchePensionnaire%' or nom_et_prenom = '$recherchePensionnaire')  LIMIT 100";
    }
?>

<table id="TablePensionnaire" class="table">
    <thead>
        <tr>
            <!-- EMPLACEMENT DES STYLES DE TABLEAU OBLIGATOIRE A CAUSE DE BOOTSTRAP-->
            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N° Pension</th>
            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Nom et Prénom(s)</th>
            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Adresse</th>
            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Numéro Téléphone </th>
            <th style="background-color: rgb(226, 226, 226);font-size: 15px;" colspan="2">Action</th>
        </tr>
    </thead>
    
    <tbody>
    <?php
        $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );
    
        while( $ligne = $resultatSELECT->fetch_assoc() ) : ?>
        <tr class="ligne-pensionnaire">
            <td style="font-size: 14px;"><a class="LienVersDossier" href="../dossierRemboursement/dossierRemboursement.php?numPens=<?=$ligne["num_pens"]?>"><?=$ligne["num_pens"]?></a></td>
            <td style="font-size: 14px;"><?=$ligne["nom_et_prenom"]?></td>
            <td style="font-size: 14px;"><?=$ligne["adresse"]?></td>
            <td style="font-size: 14px;"><?=$ligne["num_tel"]?></td>
            <td style="font-size: 14px;">
                <a href="pensionnaire.php?edit=<?=$ligne["id"]?>" class="btn btn-info btn-sm"><i class='fas fa-edit'></i> Modifier</a>
                <a href="pensionnaire.php?delete=<?=$ligne["id"]?>" class="btn btn-danger btn-sm"><i class='fas fa-trash'></i> Supprimer</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<!--      RECHARGEMENT NECESSAIRE A CAUSE DE L'AJAX MAIS JQUERY NE PEUT PAS TOTALEMENT FONCTIONNER        -->
<script type="text/javascript" src="../Modeles/lienVersDossier.js"></script>
<script type="text/javascript" src="../Styles/tableauRecherche.js"></script>