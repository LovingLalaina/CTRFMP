<!DOCTYPE html>
<html>
    <?php require_once( "../Vues/head.php" ); ?>

    <body>
        <?php
            require_once( "../Modeles/ouverture.php" ); //CE FICHIER INCLU LA CONNEXION ET LA SESSION POUR NE PLUS DEVOIR LA RAPPELLER
            require_once( "../Fonctions/formatArgent.php" ); //Fonction qui delivre la chaine "Ar 500.000" au lieu de 500000

            //A L'OUVERTURE NE RIEN AFFICHER SAUF EN CAS PARTICULIER SELON LES METHODES GET
            $numeroPensionAfficher = "";
            $nomCompletPensionnaire = "";
            $adressePensionnaire = "";
            $numeroTelephone = "";
            $numeroDossierAfficher = "";
            $anneeDossierAfficher = "";
            $requeteSQL = "SELECT id FROM dossier WHERE num_pens='0'";

            if( isset( $_GET["numPens"] ) )
            {
                $etatDossier = ( isset( $_GET["EtatDossier"] ) ) ? $_GET["EtatDossier"] : "tout";
                if( ( isset( $_GET["critereRecherche"] ) ) && $_GET["critereRecherche"] == "FM" )
                {
                    $numeroDossierAfficher = $_GET["numDossier"];
                    $anneeDossierAfficher = $_GET["anneeRecep"];

                    if( $etatDossier != "tout" )                                                                //R4-35-BIS-2021-P
                        $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM dossier WHERE ( TRIM( 'R4-' FROM TRIM( '-BIS' FROM TRIM( '-$anneeDossierAfficher' FROM TRIM( '-P' FROM num_dossier ) )))='$numeroDossierAfficher' AND year(date_recep)='$anneeDossierAfficher' AND etat='$etatDossier' )" ) or die( mysqli_error( $connexionMySQLi ) );
                    else
                        $resultatSELECT = $connexionMySQLi->query( "SELECT num_pens FROM dossier WHERE ( TRIM( 'R4-' FROM TRIM( '-BIS' FROM TRIM( '-$anneeDossierAfficher' FROM TRIM( '-P' FROM num_dossier ) )))='$numeroDossierAfficher' AND year(date_recep)='$anneeDossierAfficher' )" ) or die( mysqli_error( $connexionMySQLi ) );
                    
                    if( $resultatSELECT->num_rows >= 1 )
                    {
                        $resultatSELECT = $resultatSELECT->fetch_assoc();
                        $numeroPensionAfficher = $resultatSELECT["num_pens"];
                        
                    }
                    else $numeroPensionAfficher = "";
                }
                else    $numeroPensionAfficher = $_GET["numPens"];
                

                //RECHERCHE DES INFORMATIONS A AFFICHER
                $resultatSELECT = $connexionMySQLi->query( "SELECT nom_et_prenom, adresse, num_tel FROM pensionnaire WHERE num_pens='$numeroPensionAfficher'" ) or die( mysqli_error( $connexionMySQLi ) );
                if( $resultatSELECT->num_rows >= 1 )
                {
                    $resultatSELECT = $resultatSELECT->fetch_assoc();
                    $nomCompletPensionnaire = $resultatSELECT["nom_et_prenom"];
                    $adressePensionnaire = $resultatSELECT["adresse"];
                    $numeroTelephone = $resultatSELECT["num_tel"];
                }

                //MISE A JOUR DU PENSIONNAIRE CONSULTE
                require_once( "../Fonctions/pensionnaireSuivant.php" );
                $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens='$numeroPensionAfficher'" ) or die( "Doublon de Pensionnaire Trouvé : ".$numeroPensionAfficher );

                if( $etatDossier != "tout" )
                    $requeteSQL = ( isset( $_GET["critereRecherche"] ) && $_GET["critereRecherche"] == "FM") ? "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE ( TRIM( 'R4-' FROM TRIM( '-BIS' FROM TRIM( '-$anneeDossierAfficher' FROM TRIM( '-P' FROM num_dossier ) )))='$numeroDossierAfficher' AND year(date_recep)='$anneeDossierAfficher' AND etat='$etatDossier' )" : "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE ( num_pens='$numeroPensionAfficher' AND etat='$etatDossier' ) ORDER BY etat, annee_recep DESC, num_dossier DESC";
                else
                    $requeteSQL = ( isset( $_GET["critereRecherche"] ) && $_GET["critereRecherche"] == "FM") ? "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE ( TRIM( 'R4-' FROM TRIM( '-BIS' FROM TRIM( '-$anneeDossierAfficher' FROM TRIM( '-P' FROM num_dossier ) )))='$numeroDossierAfficher' AND year(date_recep)='$anneeDossierAfficher' )" : "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE ( num_pens='$numeroPensionAfficher' ) ORDER BY etat, annee_recep DESC, num_dossier DESC";
                
                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );

                if( $resultatSELECT->num_rows == 0 )
                {
                    $_SESSION["message"] = "Aucun résultat correspondant à la recherche";
                    $_SESSION["typeMessage"] = "danger";
                }
                else
                {
                    $nombreBC = $connexionMySQLi->query( "SELECT count(bon_de_caisse.id) AS nombre_BC FROM bon_de_caisse WHERE num_engag IN ( SELECT num_engag FROM dossier WHERE num_pens='$numeroPensionAfficher' )" ) or die( mysqli_error( $connexionMySQLi ) );
                    $nombreBC = ( $nombreBC->fetch_assoc() )["nombre_BC"];
                    $nombreBCArrivee = $connexionMySQLi->query( "SELECT count(bon_de_caisse.id) AS nombre_BC_Arrivee FROM bon_de_caisse WHERE num_engag IN (SELECT num_engag FROM dossier WHERE (num_pens='$numeroPensionAfficher' AND etat='arrivee') )" ) or die( mysqli_error( $connexionMySQLi ) );
                    $nombreBCArrivee = ( $nombreBCArrivee->fetch_assoc() )["nombre_BC_Arrivee"];
                    $nombreBCDelivre = $nombreBC - $nombreBCArrivee;
                    $_SESSION["message"] = "_ Il y a $resultatSELECT->num_rows dossier(s) dont :<br/>_ $nombreBC Bon(s) de Caisse :  $nombreBCArrivee en attente et $nombreBCDelivre déjà délivrés";
                    $_SESSION["typeMessage"] = "success";
                }

                //CETTE CONDITION DOIT SE TROUVER DANS LA CONDITION NUMPENS ETANT VRAI
                if( isset( $_GET["deliv"] ) )
                    $requeteSQL = "SELECT *, bon_de_caisse.id AS idBC, year(date_recep) AS annee_recep , dossier.id AS idDossier, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE (num_pens='$numeroPensionAfficher' AND etat='arrivee')";
                
            }
            else if( isset( $_GET["numChe"] ) )
            {
                //AFFICHAGE DES DOSSIERS ET BON DE CAISSE DANS UNE CHEMISE EN PaRTICULIER ET NON PAR PENSIONNAIRE
                $numeroPensionAfficher = "";
                $numeroChemiseAfficher = $_GET["numChe"];
                $anneeExerciceAfficher = $_GET["anneeEx"];

                $requeteSQL = "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ( num_chemise='$numeroChemiseAfficher' AND annee_exercice='$anneeExerciceAfficher' ) ORDER BY etat, annee_recep DESC, num_dossier DESC";
                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );

                if( $resultatSELECT->num_rows == 0 )
                {
                    $_SESSION["message"] = "Aucun dossier n'a été trouvé";
                    $_SESSION["typeMessage"] = "danger";
                }
                else
                {
                    $_SESSION["message"] = "Il y a $resultatSELECT->num_rows bon de caisse trouvé(s). Ci-dessous aussi leur dossier(s) respectif(s)";
                    $_SESSION["typeMessage"] = "success";
                }
            }
            else if( isset( $_GET["editDossier"] ) || isset( $_GET["deleteDossier"] ) )
            {
                $idDossier = ( isset( $_GET["editDossier"] ) ) ? $_GET["editDossier"] : $_GET["deleteDossier"];
                $requeteSQL = "SELECT dossier.id AS idDossier , bon_de_caisse.id AS idBC, num_dossier, date_recep, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE dossier.id='$idDossier' ORDER BY etat, annee_recep DESC, num_dossier DESC";

                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( $connexionMySQLi->error );
                //CAS OU L'ON FAIT UN BACKSPACE APRES SUPPRESSION OU MODIFICATION ET QUE L'IDENTIFIANT N'EXISTE PLUS
                if( $resultatSELECT->num_rows <= 0 ) header( "location:./dossierRemboursement.php" );
                $resultatSELECT = $resultatSELECT->fetch_assoc();

                $dateReception = $resultatSELECT["date_recep"];
                $anneeReception = $resultatSELECT["annee_recep"]; 
                $numeroDossier = $resultatSELECT["num_dossier"];//NUMERO COMPLET
                $tableauNumero = explode( "-" , $numeroDossier );
                $numeroDossierAbrege = $tableauNumero[1];
                $bis = ( $tableauNumero[2] == "BIS" ) ? true : false;
                $numeroPension = $resultatSELECT["num_pens"];
                $montantProvisoire = formatArgent( $resultatSELECT["montant_prov"] );
                $sigleComptable = $resultatSELECT["sigle_compt"];

                $etatDossier = $resultatSELECT["etat"];
                $montantDefinitif = formatArgent( $resultatSELECT["montant_dossier"] );
                $numeroEngagement = ( $etatDossier == "recu" || $etatDossier == "etudie" ) ? "ENG0000000000000000" : $resultatSELECT["num_engag"];
            }
            else if( isset( $_SESSION["idDossier"] ) ) // CAS D'ECHEC DE MODIFICATION DE DOSSIER
            {
                $idDossier = $_SESSION["idDossier"];
                $requeteSQL = "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, date_recep, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE dossier.id='$idDossier' ORDER BY etat, annee_recep DESC, num_dossier DESC";
                unset( $_SESSION["idDossier"] );
            }
            else if( isset( $_GET["editBC"] ) || isset( $_GET["deleteBC"] ) )
            {
                $idBC = ( isset( $_GET["editBC"] ) ) ? $_GET["editBC"] : $_GET["deleteBC"];
                $requeteSQL = "SELECT dossier.id AS idDossier , bon_de_caisse.id AS idBC, num_dossier, date_recep, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE bon_de_caisse.id='$idBC' ORDER BY etat, annee_recep DESC, num_dossier DESC";
                $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( $connexionMySQLi->error );
                
                //CAS OU L'ON FAIT UN BACKSPACE APRES SUPPRESSION OU MODIFICATION ET QUE L'IDENTIFIANT N'EXISTE PLUS
                if( $resultatSELECT->num_rows <= 0 ) header( "location:./dossierRemboursement.php" );

                $resultatSELECT = $resultatSELECT->fetch_assoc();
                $numeroDossier = $resultatSELECT["num_dossier"]; // NUMERO COMPLET
                $anneeReception = $resultatSELECT["annee_recep"];
                $numeroPension = $resultatSELECT["num_pens"];
                $numeroChemise = $resultatSELECT["num_chemise"];
                $anneeExercice = $resultatSELECT["annee_exercice"];
                $numeroOrdreBC = $resultatSELECT["num_ordre_BC"];
                $numeroEngagement = $resultatSELECT["num_engag"];
                $anneeEngagement = substr( $numeroEngagement , 3 , 4 );
                $numeroBordereau = $resultatSELECT["num_bord"];
                $anneeBordereau = substr( $numeroBordereau , 0 , 4 );
                $montantBC = formatArgent( $resultatSELECT["montant_BC"] );
                $dateArrivee = $resultatSELECT["date_arrivee"];
                $etatDossier = $resultatSELECT["etat"];
                //MEME SI LA DATE DE DELIVRANCE EST DONNEE ELLE NE CHANGERA PAS GRACE A L'ETAT DU DOSSIER QUI L'EN EMPECHE
                $dateDelivrance = ( $etatDossier == "delivre" ) ? $resultatSELECT["date_delivrance"] : "2000-01-01";
            }
            else if( isset( $_SESSION["idBC"] ) )
            {
                $idBC = $_SESSION["idBC"];
                $requeteSQL = "SELECT dossier.id  AS idDossier , bon_de_caisse.id AS idBC, num_dossier, date_recep, year(date_recep) AS annee_recep, num_pens, montant_prov, dossier.montant_def AS montant_dossier, bon_de_caisse.montant_def AS montant_BC, etat, dossier.num_engag, sigle_compt, num_chemise, annee_exercice, num_ordre_BC, num_bord, date_arrivee, date_delivrance FROM dossier LEFT OUTER JOIN bon_de_caisse ON dossier.num_engag=bon_de_caisse.num_engag WHERE bon_de_caisse.id='$idBC' ORDER BY etat ASC, annee_recep DESC,num_dossier DESC";
                unset( $_SESSION["idBC"] );
            }
            else if( isset( $_GET["etude"] ) )
            {
                $anneeReception = $_GET["anneeRecep"];
                $numeroDossierDebut = $_GET["numDeb"];//Numero SIMPLE
                $numeroDossierFin = $_GET["numFin"];//Numero SIMPLE
                $requeteSQL = "SELECT *, id AS idDossier, year(date_recep) AS annee_recep, montant_def AS montant_dossier FROM dossier WHERE (etat='recu' AND year(date_recep)='$anneeReception' AND ( TRIM( 'R4-' FROM TRIM( '-BIS' FROM TRIM( '-$anneeDossierAfficher' FROM TRIM( '-P' FROM num_dossier ) ))) BETWEEN $numeroDossierDebut AND $numeroDossierFin)) ";
            }
            // else if( isset( $_GET["engag"] ) )
            // {
            //     $anneeReception = $_GET["anneeRecep"];
            //     $numeroDossierDebut = $_GET["numDeb"];
            //     $numeroDossierFin = $_GET["numFin"];
            //     $requeteSQL = "SELECT *, id AS idDossier, year(date_recep) AS annee_recep , montant_def AS montant_dossier FROM dossier WHERE (etat='etudie' AND year(date_recep)='$anneeReception' AND (num_dossier BETWEEN $numeroDossierDebut AND $numeroDossierFin))";
            // }
            else if( isset( $_GET["bilan"] ) )
            {
                $mois = $_GET["mois"];
                $annee = $_GET["annee"];
                require_once( "../Fonctions/trimestriel.php" );
                $requeteSQL = ( $_GET["bilan"] == "mens" ) ? "SELECT *, dossier.id AS idDossier , bon_de_caisse.id AS idBC, year(date_recep) AS annee_recep, dossier.montant_def AS montant_dossier , bon_de_caisse.montant_def AS montant_BC FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ((year(date_arrivee)='$annee' AND month(date_arrivee)=$mois) OR (year(date_delivrance)='$annee' AND month(date_delivrance)=$mois))" : "SELECT *, dossier.id AS idDossier , bon_de_caisse.id AS idBC, year(date_recep) AS annee_recep, dossier.montant_def AS montant_dossier , bon_de_caisse.montant_def AS montant_BC FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ((year(date_arrivee)='$annee' AND month(date_arrivee) IN ".trimestriel( $mois ).") OR (year(date_delivrance)='$annee' AND month(date_delivrance) IN ".trimestriel( $mois )."))";
            }
            else if( isset( $_GET["pdf"] ) )
            {
                
                $dateDebut = $_GET["deb"];
                $dateFin = $_GET["fin"];
                $requeteSQL = "SELECT *, dossier.id AS idDossier , bon_de_caisse.id AS idBC, year(date_recep) AS annee_recep, dossier.montant_def AS montant_dossier , bon_de_caisse.montant_def AS montant_BC FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag WHERE ( etat='arrivee' AND ( date_arrivee BETWEEN '$dateDebut' AND '$dateFin' ) )";
            }
            
            require_once( "../Vues/nav.php" );
            require_once( "../Vues/aside.php" );
            require_once( "../Vues/divMessage.php" );
        ?>

        <section style="position:absolute;top:145px;z-index:-1" class="container" id="main-content">
            <?php require_once( "../Vues/divRechercheDossier.php" ); ?>

            <!---------------------------DEBUT DOSSIER DE REMBOURSEMENT -------------------------------->
            <!---------------------------DEBUT DOSSIER DE REMBOURSEMENT -------------------------------->
            <!---------------------------DEBUT DOSSIER DE REMBOURSEMENT -------------------------------->
            <!---------------------------DEBUT DOSSIER DE REMBOURSEMENT -------------------------------->
            <!---------------------------DEBUT DOSSIER DE REMBOURSEMENT -------------------------------->

            <h3 style="margin-top:20px;"><span style="text-decoration:underline;">Dossier de Remboursement :</span><?php if( isset( $_GET["etude"] ) ) echo mb_strtoupper("<br/>(en cours d'étude)"); else if( isset( $_GET["engag"] ) ) echo "<br/>(en cours d'engagement)"; else if( isset( $_GET["deliv"] ) ) echo "<br/>(en cours de délivrance)"; ?></h3>
            
            <!-- FORMULAIRE DANS LES CAS SPECIAUX -->
            <?php if( isset( $_GET["etude"] ) ) : ?>
                <form name="formTable" action="etudierDossier.php" method="POST">
                <button id="BoutonEtudierDossier" name="BoutonEtudierDossier" class="btn btn-lg btn-success" type="submit"><i class="fa fa-cogs text-grey"></i> Confirmer Etude</button>
            <?php //elseif( isset( $_GET["engag"] ) ) : ?>
                <!-- <form name="formTable" action="engagerDossier.php" method="POST">
                <button id="BoutonEngagerDossier" name="BoutonEngagerDossier" class="btn btn-lg btn-success" type="submit"><i class="fa fa-cogs text-grey"></i> Confirmer Engagement</button> -->
            <?php elseif( isset( $_GET["pdf"] ) ) : ?>
                <a id="LienTelechargementPdf" href="genererPdf.php?pdf=<?=$_GET["pdf"]?>&deb=<?=$_GET["deb"]?>&fin=<?=$_GET["fin"]?>" style="display:none;">Telecharger Pdf</a>
                <button onclick="document.getElementById( 'LienTelechargementPdf' ).click();" id="BoutonGenererPdf" name="BoutonGenererPdf" class="btn btn-lg btn-success" type="submit"><i class="fa fa-download text-grey"></i> Exporter</button>
            <?php endif; ?>

            <div class="row div-table div-table-dossier" style="margin-top:15px;">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- EMPLACEMENT DU STYLE OBLIGATOIRE A CAUSE BOOTSTRAP -->
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">FM</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N°Pension</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Montant Prov</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Montant Déf</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;"><div style="text-align:center">Etat Dossier</div></th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N°Engag</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Sigle Compt</th>

                            <?php if( isset( $_GET["etude"] ) ) : ?>
                                <th style="background-color: rgb(226, 226, 226);font-size: 15px;"> <input checked="checked" name="TousSelectionner" type="checkbox"/> Tout Etudier</th>
                            <?php //elseif( isset( $_GET["engag"] ) ) : ?>
                                
                                <!-- <th style="background-color: rgb(226, 226, 226);font-size: 15px;"> <input checked="checked" name="TousSelectionner" type="checkbox"/> Tout Engager</th> -->
                            <?php elseif( isset( $_GET["deliv"] ) ) : ?>
                            <?php elseif( $_SESSION["connexion"] == "admin" ) : ?>
                                <th style="background-color: rgb(226, 226, 226);font-size: 15px;" colspan="2">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                        //CES INFORMATIONS SERONT UTILISES DANS LES CAS D'ETUDE OU D'ENGAGEMENT
                        $tableauIdDossier = array();
                        $i = 0;

                        $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( $connexionMySQLi->error );

                        while( $ligne = $resultatSELECT->fetch_assoc() ) : ?>
                        <tr class="ligne-dossier">
                            <td style="font-size: 16px;"><?=$ligne["num_dossier"]?><br/><b><?php if( $ligne["montant_prov"] >= 1500000 ) echo "<span style=\"color:red;\">(+1.500.000Ar)</span>"; else echo "<span style=\"color:green;\">CHED</span>"; ?></b></td>
                            <td style="font-size: 16px;"><?=$ligne["num_pens"]?></td>
                            <td style="font-size: 16px;"><?=formatArgent( $ligne["montant_prov"] )?></td>
                            <?php if( isset( $_GET["etude"] ) ) : ?>
                                <td style="font-size: 16px;"><input type="text" name="MontantDefinitif_<?=$ligne["idDossier"]?>" data-type="currency" class="w3-input w3-border w3-round-large" maxLength="13" placeholder="(si nécessaire)" style="background-color:rgb(255, 237, 196);"/></td>
                            <?php else : ?>
                                <td style="font-size: 16px;"><?php if( $ligne["etat"] != "recu"){ echo formatArgent( $ligne["montant_dossier"] )."<br/>"; if( $ligne["montant_prov"] == $ligne["montant_dossier"]) echo "<b>(inchangé)</b>"; } else echo "(à etudier)"; ?></td>
                            <?php endif; ?>
                            <td style="font-size: 16px;"><p class="chemise couleur-<?php switch( $ligne["etat"] ){ case "recu" : echo "rouge"; break; case "etudie" : echo "orange"; break; case "engage" : echo "jaune"; break; case "liquide" : case "arrivee" : echo "vert"; break; case "delivre" : echo "bleu"; } ?>"><?php switch( $ligne["etat"] ){ case "recu" : echo "Reçu/à étudier"; break; case "etudie" : echo "étudié/à engager"; break; case "engage" : echo "engagé/à liquider"; break; case "liquide" :  echo "liquidé/BC en attente"; break; case "arrivee" : echo "BC arrivé/à délivrer"; break; case "delivre" : echo "BC délivré !!"; } ?></p></td>
                            <?php //if( isset( $_GET["engag"] ) ) : ?>
                                <!-- <td style="font-size: 16px;"><input type="text" name="NumeroEngagement_<?=$ligne["idDossier"]?>" maxlength="16" class="w3-input w3-border w3-round-large" placeholder="(Obligatoire)" style="background-color:rgb(255, 237, 196);"/> -->
                            <?php //else : ?>
                                <td style="font-size: 16px;"><?php if( $ligne["etat"] == "recu" )   echo "(à etudier)"; else if( $ligne["etat"] == "etudie" ) echo "(à engager)"; else echo $ligne["num_engag"]; ?></td>
                            <?php //endif; ?>
                            <td style="font-size: 16px;"><?=$ligne["sigle_compt"]?></td>
                            <?php if( isset( $_GET["etude"] ) /*|| isset( $_GET["engag"] )*/ ) : ?>
                                <td style="font-size: 16px;"> <input checked="checked" name="Check_<?=$ligne["idDossier"]?>" class="CheckClass" type="checkbox"/></td>
                            <?php elseif( !isset( $_GET["deliv"] ) && $_SESSION["connexion"] == "admin" ) : ?>
                                <td style="font-size: 16px;">
                                    <a href="dossierRemboursement.php?editDossier=<?=$ligne["idDossier"]?>" class="btn btn-info btn-sm"><i class='fas fa-edit'></i> Modifier</a>
                                    <a href="dossierRemboursement.php?deleteDossier=<?=$ligne["idDossier"]?>" class="btn btn-danger btn-sm"><i class='fas fa-trash'></i> Supprimer</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php $tableauIdDossier[$i] = $ligne["idDossier"]; ++$i; endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php if( isset( $_GET["etude"] ) /*|| isset( $_GET["engag"] )*/ ) : ?>
                <!-- FIN DU FORMULAIRE DANS LE CAS D'ETUDE (OU D'ENGAGEMENT) -->
                <input name="TableauIdDossier" type="hidden" value="<?=implode( "," , $tableauIdDossier )?>"/>
                </form>
            <?php endif; ?>
            <!------------------ FIN DOSSIER DE REMBOURSEMENT -------------------------------->
            <!------------------ FIN DOSSIER DE REMBOURSEMENT -------------------------------->
            <!------------------ FIN DOSSIER DE REMBOURSEMENT -------------------------------->
            <!------------------ FIN DOSSIER DE REMBOURSEMENT -------------------------------->

            <h3 style="margin-top:20px;"><span style="text-decoration:underline;">Bon de caisse associé : </span><?php if( isset( $_GET["deliv"] ) ) echo "<br/>(en cours de delivrance)"; ?></h3>

            <!-- FORMULAIRE DANS LE CAS DE DELIVRANCE -->
            <?php if( isset( $_GET["deliv"] ) ) : ?>
                <form name="formTable" action="delivrerBC.php" method="POST">
                <button id="BoutonDelivrerBC" name="BoutonDelivrerBC" class="btn btn-lg btn-success" type="submit"><i class="fas fa-file-export" style="position:relative;top:0px;left:2px"></i>DELIVRER BON DE CAISSE <i style="position:relative;top:0px;right:0px" class="ni ni-single-02"></i></button>
            <?php endif; ?>

            <div class="row div-table div-table-BC" style="margin-top:15px;">
                <table id="TableBC" class="table">
                    <thead>
                        <tr>
                            <!-- EMPLACEMENT DU STYLE OBLIGATOIRE A CAUSE BOOTSTRAP -->
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Num/Che</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N°Ordre</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N°Pension</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N°Engag</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">N°Bord</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Montant</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Date Arr</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Date Deliv</th>
                            <th style="background-color: rgb(226, 226, 226);font-size: 15px;">Sigle Compt</th>
                            <?php if( isset( $_GET["deliv"] ) ) : ?>
                                <th style="background-color: rgb(226, 226, 226);font-size: 15px;"> <input checked="checked" name="TousSelectionner" type="checkbox"/> Tout Délivrer</th>
                            <?php elseif( $_SESSION["connexion"] == "admin" ) : ?>
                                <th style="background-color: rgb(226, 226, 226);font-size: 15px;" colspan="2">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $tableauIdBC = array();
                        $i = 0;
                    
                        $resultatSELECT = $connexionMySQLi->query( $requeteSQL ) or die( mysqli_error( $connexionMySQLi ) );

                        while( $ligne = $resultatSELECT->fetch_assoc() ) : ?>
                            <?php if( $ligne["etat"] == "arrivee" || $ligne["etat"] == "delivre" ) : ?>
                                <tr class="ligne-BC">
                                    <td style="font-size: 16px;"><p class="chemise couleur-<?php $numChe = $ligne["num_chemise"]; $anneeEx = $ligne["annee_exercice"]; $couleurChemise = $connexionMySQLi->query( "SELECT * FROM chemise WHERE (num_chemise='$numChe' AND annee_exercice='$anneeEx')" ) or die( mysqli_error( $connexionMySQLi ) ); $booleenBlanc=false; if($couleurChemise->num_rows >= 1 ){ $couleurChemise = $couleurChemise->fetch_assoc(); echo $couleurChemise["couleur"]; } else{ $booleenBlanc = true; echo "blanc"; } ?>"><?php echo $ligne["num_chemise"]."/".$ligne["annee_exercice"]; if( $booleenBlanc ) echo "<br/><b><a href=\"../chemise/chemise.php\">(Non Enregistré)</a></b>"; ?></p></td>
                                    <td style="font-size: 16px;"><?=$ligne["num_ordre_BC"]?></td>
                                    <td style="font-size: 16px;"><?=$ligne["num_pens"]?></td>
                                    <td style="font-size: 16px;"><?=$ligne["num_engag"]?></td>
                                    <td style="font-size: 16px;"><?=$ligne["num_bord"]?></td>
                                    <td style="font-size: 16px;"><?php echo formatArgent( $ligne["montant_BC"] ); if( $ligne["montant_dossier"] != $ligne["montant_BC"] ) echo "<br/><b style=\"color:red;\">(Non correspondant<br/>FM ".$ligne["num_dossier"].")</b>"; ?></td>
                                    <td style="font-size: 16px;"><?=$ligne["date_arrivee"]?></td>
                                    <?php if( isset( $_GET["deliv"] ) ) : ?>
                                        <td style="font-size: 16px;"><input value="<?=date("Y-m-d", time() )?>" type="date" name="DateDelivrance_<?=$ligne["idBC"]?>" required="required" class="w3-input w3-border w3-round-large" style="background-color:rgb(255, 237, 196);"/></td>
                                    <?php else : ?>
                                        <td style="font-size: 16px;"><?php if( $ligne["etat"] == "arrivee" ) echo "(à délivrer)"; else echo $ligne["date_delivrance"]; ?></td>
                                    <?php endif; ?>
                                    <td style="font-size: 16px;"><?=$ligne["sigle_compt"]?></td>
                                    <?php if( isset( $_GET["deliv"] ) ) : ?>
                                        <td style="font-size: 16px;"> <input checked="checked" name="Check_<?=$ligne["idBC"]?>" class="CheckClass" type="checkbox"/></td>
                                    <?php elseif( $_SESSION["connexion"] == "admin" ) : ?>
                                        <td style="font-size: 16px;">
                                            <a href="dossierRemboursement.php?editBC=<?=$ligne["idBC"]?>" class="btn btn-info btn-sm"><i class='fas fa-edit'></i></a>
                                            <a href="dossierRemboursement.php?deleteBC=<?=$ligne["idBC"]?>" class="btn btn-danger btn-sm"><i class='fas fa-trash'></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php $tableauIdBC[$i] = $ligne["idBC"]; ++$i; endif; ?>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div><br/>
            <?php if( isset( $_GET["deliv"] ) ) : ?>
                <input name="TableauIdBC" type="hidden" value="<?=implode( "," , $tableauIdBC )?>"/>
                </form>
            <?php elseif( isset( $_GET["bilan"] ) ) : ?>
                <div><img style="box-shadow: 0 5px 10px #a8a8a8;" src="grapheBC.php?annee=<?=$_GET["annee"]?>"/></div>
            <?php endif; ?>
            <br/><br/><br/>
        </section>

    <?php
        //MODAL CRUD
        require_once( "ajouterDossierModal.php" );
        require_once( "ajouterBCModal.php" );
        if( isset( $_GET["editDossier"] ) ) require_once( "modifierDossierModal.php" );
        if( isset( $_GET["editBC"] ) ) require_once( "modifierBCModal.php" );
        if( isset( $_GET["deleteDossier"] ) ) require_once( "supprimerDossierModal.php" );
        if( isset( $_GET["deleteBC"] ) ) require_once( "supprimerBCModal.php" );
        require_once( "../Authentification/ModalDemanderMdp.php" );
        require_once( "../Authentification/ModalDemanderMdpReception.php" );
        require_once( "../Authentification/ModalDemanderMdpEtude.php" );

        //MODAL ETUDIER, ENGAGER, DELIVRANCE, BILAN
        require_once( "etudierDossierModal.php" );
        require_once( "engagerDossierModal.php" );
        //if( isset( $_SESSION["messageModal"] ) ) require_once( "echecEngagementModal.php" );
        if( !( isset( $_GET["numPens"] ) || isset( $_GET["deliv"] ) ) ) require_once( "echecDelivranceModal.php");
        require_once( "bilanBCModal.php" );
        require_once( "genererPdfModal.php" );
    ?>

        <!-------------------------------- SCRIPTS NECESSAIRES AU FICHIER DOSSIERREMBOURSEMENT.PHP -------------------------------------->

        <script type="text/javascript" src="../Modeles/exprReg.js"></script>
        <script type="text/javascript" src="../Controleurs/dynamiserAnneeReception.js"></script>
        <script type="text/javascript" src="../Controleurs/inputArgentIntelligent.js"></script>
        <script type="text/javascript" src="../Controleurs/validationAjoutDossier.js"></script>
        <script type="text/javascript" src="../Controleurs/validerModifierDossier.js"></script>
        <script type="text/javascript" src="../Controleurs/validationBC.js"></script>
        <script type="text/javascript" src="../Controleurs/validationEtudeEngagement.js"></script> <!-- ETUDE SEULEMENT A PRESENT-->
        <?php if( isset( $_GET["etude"] ) || isset( $_GET["engag"] ) || isset( $_GET["deliv"] ) ) : ?>
            <script type="text/javascript" src="../Modeles/tousSelectionner.js"></script>
        <?php endif; ?>
    </body>
</html>