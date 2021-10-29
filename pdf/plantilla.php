<?php 
	require 'fpdf/fpdf.php';

	class PDF extends FPDF{
		Function Header(){
			$this->Image('logo.png',5,5,50);
			$this->SetFont('Arial','BU',15);
			$this->cell(30);
			$this->SetXY(40,20);
			$this->cell(120,10,'Factura',0,0,'C');

			$this->Ln(20);

		}

		Function Footer(){
			$this->setY(-15);
			$this->SetFont('Arial','I',8);
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}

 ?>