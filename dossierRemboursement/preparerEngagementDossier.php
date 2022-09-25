<?php
    session_start();
    require_once( "../Modeles/connexion.php");

    if( isset( $_POST["BoutonPreparerEngagement"]) )
    {
        $cheminFichier = $_FILES["FichierEngagement"]["tmp_name"];

        if( $_FILES["FichierEngagement"]["size"] > 0 )
        {
            $monFichierEngagement = fopen( $cheminFichier , "r" );
            $importation = 0;
            
            while( ( $ligne = fgetcsv( $monFichierEngagement , 10000 , ";" ) ) !== FALSE )
            {
                $numeroDossier =$ligne[0];

                $numeroEngagement = $ligne[1];

                $numeroPension = $ligne[2];

                $dateReception = explode( " " , $ligne[3] )[0]; //FORMAT ACTUEL 24/09/2016
                $dateReception = explode( "/" , $dateReception );// tableau contenant 24   09     et   2016
                $anneeReception = $dateReception[2];
                $dateReception = $dateReception[2]."-".$dateReception[1]."-".$dateReception[0];

                $montantDefinitif = preg_replace( '/\s/' , '' , preg_replace( '/\.00/' , '' , $ligne[4] ) );
                $numeroTelephone = $ligne[5];

                $resultatSELECT = $connexionMySQLi->query( "SELECT * , year( date_recep ) FROM dossier WHERE (num_dossier='$numeroDossier')" ) or die( $connexionMySQLi->error );

                $connexionMySQLi->query( "UPDATE pensionnaire SET num_tel='$numeroTelephone' WHERE num_pens='$numeroPension'" ) or die( $connexionMySQLi->error );

                if( $resultatSELECT->num_rows >= 1 )
                {
                    require_once( "../Fonctions/chiffre.php" );
                    $ancienEtat = chiffre( ( $resultatSELECT->fetch_assoc() )["etat"] );

                    if( $ancienEtat <= 2 )
                        $connexionMySQLi->query( "UPDATE dossier SET num_engag='$numeroEngagement' , etat='engage' , montant_def='$montantDefinitif' WHERE ( num_dossier='$numeroDossier' AND year( date_recep )='$anneeReception' )" ) or die( $connexionMySQLi->error );
                    else
                        $connexionMySQLi->query( "UPDATE dossier SET num_engag='$numeroEngagement' , montant_def='$montantDefinitif' WHERE ( num_dossier='$numeroDossier' AND year( date_recep )='$anneeReception' )" ) or die( $connexionMySQLi->error );
                } 
                else
                    $connexionMySQLi->query( "INSERT INTO dossier ( num_dossier , date_recep , num_pens , num_engag , montant_prov , montant_def , etat ) VALUES ( '$numeroDossier' , '$dateReception' , '$numeroPension' , '$numeroEngagement' , '$montantDefinitif' , '$montantDefinitif' , 'engage' )" ) or die( $connexionMySQLi->error );

                ++$importation;
            }

            $_SESSION["message"] = "Importation de $importation Numéros(s) réussie";
            $_SESSION["typeMessage"] = "success";

            header( "location:dossierRemboursement.php" );
        }
    }
   

?>