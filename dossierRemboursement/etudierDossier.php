<?php
    session_start();
    require_once( "../Modeles/connexion.php" );
    
    if( isset( $_POST["BoutonEtudierDossier"] ) )
    {
        $tableauIdDossier = explode( "," , $_POST["TableauIdDossier"] );
        $nombreDossierChecked = 0;
        require_once( "../Fonctions/securisation.php" );
        require_once( "../Fonctions/pensionnaireSuivant.php" );
        foreach( $tableauIdDossier as $idDossier )
        {
            if( isset( $_POST["Check_$idDossier"] ) )
            {
                ++$nombreDossierChecked;
                $montantDefinitif = securisation( $_POST["MontantDefinitif_$idDossier"] , "typeMontant" );
                if( $montantDefinitif != 0 ) $connexionMySQLi->query( "UPDATE dossier SET montant_def='$montantDefinitif', etat='etudie' WHERE id='$idDossier'" ) or die( $connexionMySQLi->error );
                else                         $connexionMySQLi->query( "UPDATE dossier SET montant_def=montant_prov, etat='etudie' WHERE id='$idDossier'" ) or die( $connexionMySQLi->error );
                
                //MISE A JOUR DU PENSIONNAIRE
                $connexionMySQLi->query( "UPDATE pensionnaire SET id='".pensionnaireSuivant( $connexionMySQLi )."' WHERE num_pens=( SELECT num_pens FROM dossier WHERE id='$idDossier' )" ) or die( mysqli_error( $connexionMySQLi ) );

            }
        }

        switch( $nombreDossierChecked )
        {
            case 0 :
                $_SESSION["message"] =  "Aucun Dossier n'a été étudié";
                $_SESSION["typeMessage"] = "danger";
                break;
            case 1 :
                $_SESSION["message"] =  "1 Dossier a bien été étudié";
                $_SESSION["typeMessage"] = "success";
                break;
            default :
                $_SESSION["message"] =  "$nombreDossierChecked Dossiers ont bien été étudiés";
                $_SESSION["typeMessage"] = "success";
        }
        header( "location:dossierRemboursement.php" );
    }
?>