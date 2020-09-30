<?php
///////////pdf_transito//////////////////
require 'fpdf_js.php';
require 'include/database.php';
require 'include/java.php';
//
$data=$_GET["data"];
$alla_data=addrizza("",$data);
////////////////////////////////////////////////////
//class PDF extends FPDF_Javascript
class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=false)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
    $param=($dialog ? 'true' : 'false');
//	
}
//Page header 
function Header()
{
//
$num_pag=$this->PageNo();
//
$this->SetTopMargin(0);
$this->SetFont('Times','',7);
//
}

function Footer()
{
}

} //fine class
////////////////////////////////////////////////stampa
$pdf=new PDF_AutoPrint('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
//
$pdf->SetFont('Times','',9);
$mm=10;
$a=4;
$pdf->SetXY(6,10);
//
//
//$qr="SELECT * FROM `movmag` WHERE mov_causale='02' AND mov_clifor LIKE '9%' AND mov_data_fattura='0000-00-00' AND mov_data BETWEEN  '2020-01-01' AND '2020-07-31' AND mov_doc > '' AND NOT mov_doc LIKE '00900%' AND NOT mov_dep='12' AND NOT mov_dep='13' GROUP BY mov_clifor, mov_doc ORDER BY mov_clifor, mov_data, mov_doc";
$prec_doc="";
$totale=0;
$pdf->SetFont('Times','B',9);
$pdf->SetXY(10,$mm);
$pdf->Cell(0,4,"Merci in Transito alla data $data",0,0,'L');
$pdf->SetFont('Times','',9);
$mm+=$a;
$mm+=$a;
//   	 
$qr="SELECT * FROM `movmag` WHERE mov_causale='02' AND mov_clifor LIKE '9%' AND mov_data_fattura='0000-00-00' AND mov_data BETWEEN  '2020-01-01' AND '$alla_data' AND mov_doc > '' AND NOT mov_doc LIKE '00900%' AND NOT mov_dep='12' AND NOT mov_dep='13' ORDER BY mov_clifor, mov_data, mov_doc";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
  	 extract($row);
  	 $data=addrizza($mov_data,"");
     $cf_ragsoc="";
     $qc="SELECT cf_ragsoc FROM clienti WHERE cf_cod='$mov_clifor'";
     $rsc = mysql_query($qc, $con);
     while($roc = mysql_fetch_array($rsc)) {
  	    extract($roc);
	    }
     $art_descrizione="";
     $qa="SELECT art_descrizione FROM articoli WHERE art_codice='$mov_codart'";
     $rsa = mysql_query($qa, $con);
     while($roa = mysql_fetch_array($rsa)) {
  	    extract($roa);
	    }
	 if($prec_doc=="")
       {
	   	$prec_doc=$mov_doc;
	   }	    
     if($mov_doc!=$prec_doc)
       {
	   	$prec_doc=$mov_doc;
        $mm+=$a;
	   }
	 $totale+=$mov_totale;
     $z_tot=number_format($mov_totale,2,",",".");     
     $pdf->SetXY(10,$mm);
   	 $pdf->Cell(6,4,$mov_dep,0,0,'L');
   	 $pdf->Cell(20,4,$data,0,0,'L');
   	 $pdf->Cell(20,4,$mov_doc,0,0,'L');
   	 $pdf->Cell(20,4,$mov_codart,0,0,'L');
   	 $pdf->Cell(90,4,$art_descrizione,0,0,'L');
   	 $pdf->Cell(15,4,$z_tot,0,0,'R');
   	 $pdf->Cell(20,4,$mov_clifor,0,0,'L');
   	 $pdf->Cell(50,4,$cf_ragsoc,0,0,'L');
     $mm+=$a;

   if($mm>190) { 
      $pdf->AddPage();
      $pdf->SetXY(6,10);
      $mm=10;
	  }
	}	   
//  
   $pdf->SetFont('Times','B',9);
   $z_tot=number_format($totale,2,",",".");     
   $mm+=$a;
   $mm+=$a;
   $pdf->SetXY(146,$mm);
   $pdf->Cell(20,4,"TOTALE",0,0,'R');
   $pdf->SetXY(166,$mm);
   $pdf->Cell(15,4,$z_tot,0,0,'R');
   $pdf->SetFont('Times','',9);
//
////stampa automatica////////////////////////////////////////
//$pdf->IncludeJS("pp=getPrintParams(); print(pp);");
$pdf->AutoPrint(false);
//
$pdf->Output();
?>
