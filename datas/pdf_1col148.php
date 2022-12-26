<?php
// $ville = $_GET['ville'];
// echo $ville.'</br>';
// $format = '1 col x 148';

// include (dirname(__FILE__).'/includes/ddc.php');
// include (dirname(__FILE__).'/includes/date.php');
// include (dirname(__FILE__).'/includes/visuPrint.php');

$file = 'datas/datas.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
$obj = json_decode($data); 
// accéder à l'élément approprié

// echo count($csv).'</br></br>';
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
$pageLayout = array(46.5,148); //  or array($height, $width) 
$pdf = new TCPDF('F', 'mm', $pageLayout, true, 'UTF-8', false);
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicolas Peyrebrune');
$pdf->SetTitle('Infographie Flux carburants');
$pdf->SetSubject('Infographie');
$pdf->SetKeywords('Infographie, SUDOUEST, flux, carburants, match');

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

	function affichDay($x,$y) {
		if ($x == 1) {
			$x = 'Aujourd\'hui';
			return $x;
		}
		if ($x == 2) {
			$x = 'Demain';
			return $x;
		}
		if ($x == 3) {
			$x = $y;
			return $x;
		}
	};

// $fontname = TCPDF_FONTS::addTTFfont('/TCPDF-master/fonts/ArialNarrowItalic.ttf', 'TrueTypeUnicode', '', 96);
// $pdf->SetFont($fontname, '', 14, '', false);
$border_style = array('all' => array('width' => 0.25, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'phase' => 0, 'color' => array(0, 0, 0, 0)));	

$width = 1.9;
$height = 4;
$posY = 10;

$font_C = 'ariali';
$fontSize_C = 7;

$numDay = 3;
setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
for ($i=0; $i < count($obj->signals); $i++) { 
	if ($i == $numDay) {
		// echo ucfirst(strftime('%A',strtotime($obj->signals[$i]->jour)))."</br>";
		echo date("l")."</br>";
		echo $obj->signals[$i]->message."</br>";
        echo count($obj->signals[$i]->values)."</br>";
		$border = 1;
		$time = affichDay($numDay,ucfirst(strftime('%A',strtotime($obj->signals[$i]->jour))));
		echo $time.'</br>';
		$pdf->SetTextColor(0,0,0,100);
			// $pdf->setCellPaddings(0,0,0,0);
			$pdf->SetFont('arial','', 9);
			$pdf->SetXY(-46.5,$posY-5);
			$pdf->SetFillColor(0, 0, 0, 20);
			$pdf->Cell(46.5,4.9,$time,  $border, 0, 'L', 1, '', 1, false, '', 'T');
       
		for ($n=0; $n < count($obj->signals[$i]->values); $n++) { 
			if ($obj->signals[$i]->values[$n]->hvalue == 1) {
				$pdf->SetFillColor(70, 0, 100, 0);
			}
			if ($obj->signals[$i]->values[$n]->hvalue == 2) {
				$pdf->SetFillColor(0, 40, 100, 0);
			}
			if ($obj->signals[$i]->values[$n]->hvalue == 3) {
				$pdf->SetFillColor(0, 100, 100, 0);
			}
			$pdf->Rect(0.4+($n*$width), $posY, $width, $height,'DF',$border_style);
			
			$html = '<span style="letter-spacing:-0.5;">'.remplaceLegend($obj->signals[$i]->values[$n]->pas).'</span>';
			// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
			$pdf->SetFont($font_C,'L',$fontSize_C);
			$pdf->SetTextColor(0,0,0,100);
			$pdf->writeHTMLCell(10, 0, ($n*$width)+posX($n*$width), $posY+4, $html, 0, 1, 0, true, 'C', false);
        }
    }
}

// $pdf->ImageSVG('images/Fond_148.svg',0,0,46.5,148,'','','', $border,false);
// $fitbox='R';	
// $counter = -1;

// while ($counter < (count($csv)-1)) {
//     $counter += 1;
// 	$interLigne = 7.25;
// 	$startY = 41.4;
// 	if ($counter % 2 == 1) {
//         // echo "On saute $counter qui est un numéro pair.</br>";
// 		if ($counter == 9) {
// 			$interLigne = 8.07;

			// $pdf->SetTextColor(0,0,0,100);
			// $pdf->setCellPaddings(0,0,0,0);
			// $pdf->SetFont('arial','', 9);
			// $pdf->SetXY(6.9,($startY+($interLigne *$counter)));
			// $pdf->Cell(39.6,'', $csv[$counter][1],  $border, 0, 'L', 0, '', 1, false, '', 'M');
			
// 			$pdf->SetTextColor(0,0,0,0);
			
// 			$pdf->SetFont('arialb','', 9);
// 			$pdf->SetXY(7.5,(($startY+($interLigne *$counter))+3.75));
// 			$pdf->Cell(28.5,'', $csv[$counter][2],  $border, 0, 'L', 0, '', 1, false, '', 'M');

// 			$pdf->SetXY(36,(($startY+($interLigne *$counter))+3.75));
// 			$pdf->Cell(10,'', $csv[$counter][3],  $border, 0, 'R', 0, '', 1, false, '', 'M');

// 			// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
// 			$pdf->Image('images/logos/'.ddc(marques($csv[$counter][2])).'.png', 0, (($startY+($interLigne *$counter))+1.45), 6.5, 10, 'PNG', '', '', false, 300, 'M', false, false, 0,'B', false, false);
// 				// echo $csv[$counter][1].'</br>';
// 				// echo $csv[$counter][2].' | '.$csv[$counter][3].'</br>';
// 			}
//         continue;
//     }
// 	$pdf->SetTextColor(0,0,0,100);
// 			$pdf->setCellPaddings(0,0,0,0);
// 			$pdf->SetFont('arial','', 9);
// 			$pdf->SetXY(6.9,($startY+($interLigne *$counter)));
// 			$pdf->Cell(39.6,'', $csv[$counter][1],  $border, 0, 'L', 0, '', 1, false, '', 'M');
			
// 			$pdf->SetTextColor(0,0,0,0);
// 			if ($counter == 0){
// 				$pdf->SetTextColor(0,0,0,100);
// 			}else {};
			
// 			$pdf->SetFont('arialb','', 9);
// 			$pdf->SetXY(7.5,(($startY+($interLigne *$counter))+3.85));
// 			$pdf->Cell(28.5,'', $csv[$counter][2],  $border, 0, 'L', 0, '', 1, false, '', 'M');

// 			$pdf->SetXY(36,(($startY+($interLigne *$counter))+3.85));
// 			$pdf->Cell(10,'', $csv[$counter][3],  $border, 0, 'R', 0, '', 1, false, '', 'M');
// 			$pdf->Image('images/logos/'.ddc(marques($csv[$counter][2])).'.png', 0, (($startY+($interLigne *$counter))+1.4), 6.5, 10, 'PNG', '', '', false, 300, 'M', false, false, 0,'B', false, false);
// 	// echo "Execution - counter vaut $counter</br>";
// 	// echo $csv[$counter][1].'</br>';
// 	// echo $csv[$counter][2].' | '.$csv[$counter][3].'</br>';
// }
// close and output PDF document
$pdf->Output('ProductionPdf/Infog_.pdf','F');

//============================================================+
// END OF FILE
//============================================================+