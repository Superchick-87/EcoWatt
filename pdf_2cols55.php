<?php
$file = 'datas/datas.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
$obj = json_decode($data); 
// accéder à l'élément approprié

//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('TCPDF-master/tcpdf.php');

// create new PDF document
$pageLayout = array(96.5,55); //  or array($height, $width) 
$pdf = new TCPDF('F', 'mm', $pageLayout, true, 'UTF-8', false);
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicolas Peyrebrune');
$pdf->SetTitle('Infographie EcoWatt');
$pdf->SetSubject('Infographie');
$pdf->SetKeywords('Infographie, SUDOUEST, EcoWatt');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(0,0,0,0);
// $pdf->SetPaddings(0,0,0,0);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(FALSE,0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/fra.php')) {
    require_once(dirname(__FILE__).'/lang/fra.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// add a page
$pdf->AddPage();
// get esternal file content
// $utf8text = file_get_contents('TCPDF-master/examples/data/utf8test.txt', false);

$border=0;
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

/**
 * Permet d'ajouter des "h" aux heures
 *
 * @param [string] $x
 * @return void
 */
	function remplaceLegend($x) {
		if ($x == '0') {
			$x = '0h';
			return $x;
		}
		if ($x == '4') {
			$x = '4h';
			return $x;
		}
		if ($x == '8') {
			$x = '8h';
			return $x;
		}
		if ($x == '12') {
			$x = '12h';
			return $x;
		}
		if ($x == '16') {
			$x = '16h';
			return $x;
		}
		if ($x == '20') {
			$x = '20h';
			return $x;
		}
		if ($x == '23') {
			$x = '23h';
			return $x;
		}
		else{
			$x = '';
			return $x;
		}
	};

/**
 * Permet de déplacer une heure en x
 *
 * @param [$string] $x
 * @return void
 */
	function posX($x) {
		if ($x == '0h') {
			$z = -3;
			return $z;
		}
		else{
			$z = -4;
			return $z;
		}
	};

/**
 * Changer le libélé du jour 
 * suivant le numéro du noeux traité
 *
 * @param [int] $x -> numéro du noeux
 * @param [str] $y -> date
 * @return void
 */
	function affichDay($x,$y) {
		if ($x == 1) {
			$x = 'Aujourd\'hui';
			// $x = $y;
			return $x;
		}
		if ($x == 2) {
			$x = 'Demain';
			// $x = $y;
			return $x;
		}
		if ($x == 3) {
			$x = $y;
			return $x;
		}
	};


$pdf->ImageSVG('images/FondEcoWatt_2cols.svg',0,0,96,55,'','','', 0,false);

$titre = "La météo de l'électricité avec EcoWatt";
echo '<h3 style="font-family: sans-serif; text-align: center;">Page génération de pdf</h3>
<h1 style="font-family: sans-serif; text-align: center;">'.$titre."</h1>";

$borderTitre = 0;
$pdf->SetTextColor(0,0,0,100);
// $pdf->SetFillColor(0,0,0,100);
$pdf->setCellPaddings(0,0,0,0);
$pdf->SetFont('arial','', 13);
$pdf->SetXY(0,0);
$pdf->Cell(95,'',$titre,$borderTitre, 0, 'C', 0, '', 1, false, '', 'T');

setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
$maj = 'Mise à jour hier à '.ucfirst(strftime('%R',strtotime($obj->signals[1]->GenerationFichier)));
// echo $maj."</br>";
$borderMaj = 0;
$pdf->SetTextColor(0,0,0,0);
$pdf->SetFillColor(0,0,0,100);
$pdf->setCellPaddings(0,0,0,0);
$pdf->SetFont('ariali','', 7);
$pdf->SetXY(55,7);
$pdf->Cell(30,'',$maj, $borderMaj, 0, 'C', 1, '', 1, false, '', 'T');

/**
 * Affiche et positionne un module
 * picto, date, indicateurs et légende (heures)
 *
 * @param [int] $posX -> position x en mm
 * @param [int] $posY -> position y en mm
 * @param [int] $numDay -> numéro jour à traiter
 * @param [class] $pdf
 * @return void
 */
function afficheIndicateur($posX,$posY,$numDay,$pdf){
	$obj ='';
	$file = 'datas/datas.json'; 
	$data = file_get_contents($file); 
	$obj = json_decode($data);  
	
	$font_C = 'ariali';
	$fontSize_C = 7;
	
	$border_style = array('all' => array('width' => 0.25, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0, 'color' => array(0, 0, 0, 0)));	
	
	$width = 1.9;
	$height = 4;
	
	for ($i=0; $i < count($obj->signals); $i++) { 
		if ($i == $numDay) {
			// echo date("l")."</br>";
			// echo $obj->signals[$i]->message."</br>";
			// echo count($obj->signals[$i]->values)."</br>";

			$border = 1;
			$day = affichDay($numDay,ucfirst(strftime('%A',strtotime($obj->signals[$i]->jour))));
			// echo $day.'</br>';
			
			$pdf->SetFillColor(0, 0, 0, 20);
			// $pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

			$pdf->RoundedRect($posX+1,$posY-3.8, 45,4, 2.5, '1000', 'F');
			
			$borderC = 0;
				$pdf->SetTextColor(0,0,0,100);
				$pdf->setCellPaddings(0,0,0,0);
				$pdf->SetFont('arial','', 9);
				$pdf->SetXY($posX+4,$posY-3.8);
				$pdf->Cell(40,4.5,$day, $borderC, 0, 'L', 0, '', 1, false, '', 'T');
				
				/**
				 * Affiche les pastilles et la légende (heures)
				 */
				
				 for ($n=0; $n < count($obj->signals[$i]->values); $n++) {
					if ($obj->signals[$i]->values[$n]->hvalue == 3) {
						$pdf->SetFillColor(0, 100, 100, 0);
					}
					if ($obj->signals[$i]->values[$n]->hvalue == 2) {
						$pdf->SetFillColor(0, 40, 100, 0);
					}
					if ($obj->signals[$i]->values[$n]->hvalue == 1) {
						$pdf->SetFillColor(70, 0, 100, 0);
					}
					$pdf->Rect($posX+(0.4+($n*$width)), $posY, $width, $height,'DF',$border_style);
					
					$html = '<span style="letter-spacing:-0.5;">'.remplaceLegend($obj->signals[$i]->values[$n]->pas).'</span>';
					$pdf->SetFont($font_C,'L',$fontSize_C);
					$pdf->SetTextColor(0,0,0,100);
					$pdf->writeHTMLCell(10, 0, $posX+(($n*$width)+posX($n*$width)-0.5), $posY+4, $html, 0, 1, 0, true, 'C', false);
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
				}
				/**
				 * Fin Affiche les pastilles et la légende (heures)
				 */
				
				/**
				 * Affiche le picto à côté de la date
				 * seule le picto dont la valeur est 
				 * la plus élevée est affichée
				 * 3 = Red
				 * 2 = Orange
				 * 1 = Green
				 */

				for ($n=0; $n < count($obj->signals[$i]->values); $n++) {
					if ($obj->signals[$i]->values[$n]->hvalue == 3) {
						$pdf->ImageSVG('images/pictoRed.svg',$posX,$posY-4,4,4,'','','', $borderC,false);
						break 2;
					}
				}
				for ($n=0; $n < count($obj->signals[$i]->values); $n++) {
					if ($obj->signals[$i]->values[$n]->hvalue == 2) {
						$pdf->ImageSVG('images/pictoOrange.svg',$posX,$posY-4,4,4,'','','', $borderC,false);
						break 2;
					}
				}
				for ($n=0; $n < count($obj->signals[$i]->values); $n++) {
					if ($obj->signals[$i]->values[$n]->hvalue == 1) {
						$pdf->ImageSVG('images/pictoGreen.svg',$posX,$posY-4,4,4,'','','', $borderC,false);
						break 2;
					}
				}
				/**
				 * Affiche le picto à côté de la date
				 */
			
		}
	}
}


afficheIndicateur(1,10,1,$pdf);
afficheIndicateur(1,21,2,$pdf);
afficheIndicateur(1,32,3,$pdf);
// close and output PDF document
$pdf->Output('ProductionPdf/Infog_.pdf','F');

//============================================================+
// END OF FILE
//============================================================+