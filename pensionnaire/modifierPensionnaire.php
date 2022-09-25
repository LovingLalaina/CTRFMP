<?php
    session_start();
    require_once("../Modeles/connexion.php");
    
    
    if( isset( $_POST["BoutonModifierPensionnaire"] ) )
    {
        $idPensionnaire = $_POST["IdPensionnaire"];
        require_once("../Fonctions/securisation.php");
        $numeroPension = securisation( $_POST["NumeroPension"] , "typeNumero");
        $nomPensionnaire = securisation( $_POST["NomPensionnaire"] , "typeNom" );
        $prenomPensionnaire = securisation( $_POST["PrenomPensionnaire"] , "typePrenom" );
        $nomCompletPensionnaire = $nomPensionnaire." ".$prenomPensionnaire;
        $adressePensionnaire = securisation( $_POST["AdressePensionnaire"] , "typeAdresse" );
        $numeroTelephone = securisation( $_POST["NumeroTelephone"] , "typeNumero" );

        //RECHERCHE DE PENSIONNAIRE AYANT LE MEME NUMERO DE PENSION
        $resultatSELECT = $connexionMySQLi->query( "SELECT nom_et_prenom FROM pensionnaire WHERE (num_pens='$numeroPension' AND id!='$idPensionnaire')" ) or die( $connexionMySQLi->error );

        if( $resultatSELECT->num_rows >= 1 )
        {
            // TROUVE DONC MODIFICATIONS IMPOSSIBLES
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            
            $_SESSION["message"] = "Le Numero de pension $numeroPension existe déja : ".$resultatSELECT["nom_et_prenom"];
            $_SESSION["typeMessage"] = "danger";
            $_SESSION["idPensionnaire"] = $idPensionnaire;

            header( "location:pensionnaire.php" );
        }
        else
        {
            // NUM PENSION NON TROUVE DONC MODIFICATION VALIDE
            //UPDATER LES NUMEROS DE PENSIONS DANS DOSSIER DE REMBOURSEMENT
            $connexionMySQLi->query( "UPDATE dossier SET num_pens='$numeroPension' WHERE num_pens=(SELECT num_pens FROM pensionnaire WHERE id='$idPensionnaire')" ) or die( $connexionMySQLi->error );
            
            //LA FONCTION ADDSLASH EMPECHE LES ERREURS SI LES ENTREES CONTIENNENT APOSTROPHES
            $nomCompletPensionnaire = addslashes( $nomCompletPensionnaire );
            $adressePensionnaire = addslashes( $adressePensionnaire );
            require_once( "../Fonctions/pensionnaireSuivant.php" );
            $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' , num_pens='$numeroPension' , nom_et_prenom='$nomCompletPensionnaire', adresse='$adressePensionnaire' , num_tel='$numeroTelephone' WHERE id='$idPensionnaire'" ) or die( $connexionMySQLi->error );

            //AU CAS OU LE NUMERO DE PENSION AYANT DES DOSSIERS N'ETAIT PAS ENREGISTRE AVANT 
            $connexionMySQLi->query( "DELETE FROM pensionnaire_absent WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );

            $_SESSION['message'] = "Le pensionnaire N° $numeroPension $nomCompletPensionnaire a bien été modifié!";
            $_SESSION['typeMessage'] = "warning";
            
            header( "location:pensionnaire.php" );
        }
    }

?>