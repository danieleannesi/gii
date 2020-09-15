<?php
require_once('fpdf.php');
require_once('fpdi.php');
//
$pdf = new FPDI();
//
$f = glob('tmp/FATT_EMAIL/F*.pdf');
foreach ($f as $filename) {
  $pagecount = $pdf->setSourceFile($filename);
  for ($i = 1; $i <= $pagecount; $i++) 
    { 
    $tplidx = $pdf->ImportPage($i); 
    $s = $pdf->getTemplatesize($tplidx); 
    $pdf->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h'])); 
    $pdf->useTemplate($tplidx);
    } 
  }
//
$nome="tmp/FATT_EMAIL/tutti_documenti.pdf";
$pdf->Output($nome);
//
exit;
?>
