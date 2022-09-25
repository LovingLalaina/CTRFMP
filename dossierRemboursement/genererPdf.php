<?php
	require_once( "../Modeles/connexion.php" );
	require_once( "fpdf/fpdf.php" );
	

	class myPDF extends FPDF{
		function header(){
			$this->SetFont('Arial','B',20);
								/* ICI GRAND TITRE */
			$this->Cell(276,30, iconv( 'UTF-8', 'windows-1252', 'Liste des Bons de Caisses arrivés' ),0,0,'C');
			$this->Ln(10);
			$this->SetFont('Times','',19);
								/* PETIT SOUS-TITRE */
			$this->Cell( 276,40, "de ".$_GET["deb"].iconv( 'UTF-8', 'windows-1252', ' à ' ).$_GET["fin"] ,0,0,'C' );
			$this->Ln( 40 );
		}
		function footer(){
			$this->SetY(-15);
			$this->SetFont('Arial','B',8);
			$this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');
		}
		function headerTable(){
			$this->SetFont('Times','B',12);
			$this->Cell( 30,10,'Numero FM',1,0,'C');
			$this->Cell( 40,10,'Numero Pension',1,0,'C');
			$this->Cell( 150,10,'Nom et Prenoms',1,0,'C');
			$this->Cell( 40,10,'Montant',1,0,'C');
			$this->Ln();
		}
		function viewTable( $connexionMySQLi ){
			$this->SetFont('Times','',15);
			$dateDebut = $_GET["deb"];
			$dateFin = $_GET["fin"];
			$resultatSELECT = $connexionMySQLi->query( "SELECT num_dossier, dossier.num_pens , nom_et_prenom , bon_de_caisse.montant_def AS montant_BC FROM bon_de_caisse JOIN dossier ON bon_de_caisse.num_engag=dossier.num_engag JOIN pensionnaire ON pensionnaire.num_pens=dossier.num_pens WHERE ( etat='arrivee' AND ( date_arrivee BETWEEN '$dateDebut' AND '$dateFin' ) )" ) or die( $connexionMySQLi->error );
			
			while ( $ligne = $resultatSELECT->fetch_assoc() ) {
				$this->Cell( 30,10, $ligne['num_dossier'] ,1,0,'C');
				$this->Cell( 40,10, $ligne['num_pens'] ,1,0,'C');
				$this->Cell( 150,10, iconv( 'UTF-8', 'windows-1252', $ligne['nom_et_prenom'] ) ,1,0,'C');
                require_once( "../Fonctions/formatArgent.php" );
				$this->Cell( 40,10, formatArgent( $ligne['montant_BC'] ),1,0,'C');
				$this->Ln();
			}
		}
	}

	$pdf = new myPDF();
	$pdf->AliasNbPages();
	$pdf->AddPage('L');
	$pdf->headerTable();
	$pdf->viewTable( $connexionMySQLi );
	$pdf->Output();
	
?>