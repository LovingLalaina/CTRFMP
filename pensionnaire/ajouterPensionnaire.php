<?php
    session_start();
    require_once( "../Modeles/connexion.php");

    if( isset( $_POST["BoutonAjouterPensionnaire"]) )
    {
        require_once( "../Fonctions/securisation.php" );
        $numeroPension = securisation( $_POST["NumeroPension"] , "typeNumero");
        $nomPensionnaire = securisation( $_POST["NomPensionnaire"] , "typeNom" );
        $prenomPensionnaire = securisation( $_POST["PrenomPensionnaire"] , "typePrenom" );
        $nomCompletPensionnaire = $nomPensionnaire." ".$prenomPensionnaire;
        $adressePensionnaire = securisation( $_POST["AdressePensionnaire"] , "typeAdresse" );
        $numeroTelephone = securisation( $_POST["NumeroTelephone"] , "typeNumero" );

        //TEST SI LE NUMERO DE PENSION EXISTE DEJA 
        $resultatSELECT = $connexionMySQLi->query( "SELECT nom_et_prenom FROM pensionnaire WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );

        if( $resultatSELECT->num_rows >= 1 )
        {
            $resultatSELECT = $resultatSELECT->fetch_assoc();
            
            $_SESSION["message"] = "Le Numero de pension $numeroPension existe déja : ".$resultatSELECT["nom_et_prenom"]." !!!<br/>Veuillez réessayer s'il vous plait";
            $_SESSION["typeMessage"] = "danger";

            //POUR LE MODAL AJOUTER 
            $_SESSION["ajoutPensionnaire"] = "echec";
            $_SESSION["numeroPension"] = $numeroPension;
            $_SESSION["nomPensionnaire"] = $nomPensionnaire;
            $_SESSION["prenomPensionnaire"] = $prenomPensionnaire;
            $_SESSION["adressePensionnaire"] = $adressePensionnaire;
            $_SESSION["numeroTelephone"] = $numeroTelephone;

            header( "location:pensionnaire.php" );
        }
        else
        {
            $_SESSION["message"] = "Le pensionnaire N° $numeroPension, $nomCompletPensionnaire a bien été ajouté!";
            $_SESSION["typeMessage"] = "success";
            
            //ADDSLASH EMPECHE LES PROBLEMES D'APOSTROPHE
            $nomCompletPensionnaire = addslashes( $nomCompletPensionnaire );
            $adressePensionnaire = addslashes( $adressePensionnaire );
            $connexionMySQLi->query( "INSERT INTO pensionnaire ( num_pens , nom_et_prenom , adresse , num_tel ) VALUES( '$numeroPension' , '$nomCompletPensionnaire' , '$adressePensionnaire' , '$numeroTelephone' )" ) or die( $connexionMySQLi->error );

            //SI LE NUMERO DE PENSION N'ETAIT PAS ENREGISTRE MAIS AVAIT DES DOSSIERS
            $connexionMySQLi->query( "DELETE FROM pensionnaire_absent WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );

            header( "location:pensionnaire.php" );
        }
    }
   

?>