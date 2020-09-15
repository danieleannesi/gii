<?php
///////////lisforn//////////////////
function leggi_tabelle($codice,$descri)
{
	global $con;
	$descrizione="";
	$qr="SELECT * FROM tabelle WHERE tab_key = '$codice'";
    $rsi = mysql_query($qr, $con);
    while($roi = mysql_fetch_array($rsi)) {
       $tabresto=json_decode($roi["tab_resto"],true);
       $descrizione=$tabresto["$descri"];
	   }
return $descrizione;
}
//
set_time_limit(1200);
//
//require 'fpdf_js.php';
require 'fpdf.php';
//
require 'include/database.php';
require 'include/java.php';
require 'calcola_medio.php';
//
foreach ($_GET as $key => $value) 
  { 
  $$key=$value;
  }
//
////////////////////////////////////////////////////
/*
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
*/
function testata()
{
global $pdf;
global $mm;
global $a;
     $pdf->SetFont('Times','B',10);
     $pdf->SetXY(10,$mm);
   	 $pdf->Cell(20,4,"Articolo",0,0,'L');
   	 $pdf->Cell(115,4,"Descrizione",0,0,'L');
   	 $pdf->Cell(50,4,"Fornitore",0,0,'L');
   	 $pdf->Cell(15,4,"Acquisti",0,0,'R');
   	 $pdf->Cell(15,4,"Vendite",0,0,'R');
   	 $pdf->Cell(15,4,"Giacenza",0,0,'R');
   	 $pdf->Cell(15,4,"Sco.min.",0,0,'R');
   	 $pdf->Cell(15,4,"Ord.Cli",0,0,'R');	
   	 $pdf->Cell(15,4,"Ord.For",0,0,'R');	
     $mm+=$a;
     $pdf->SetFont('Times','',10);
}
/////////////////INIZIO PROGRAMMA///////////////////////////
$pdf=new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage("L","A4");
//
$pdf->SetFont('Times','',10);
$mm=10;
$a=4;
$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
$oggi=date("Y-m-d");
//
$pdf->SetXY(6,10);
testata();
//
mysql_select_db($DB_NAME, $con);
$aord=g_ordini_per_articolo($dal,$al);
$aordfo=g_ordinifo_per_articolo($dal,$al);
//  
if(trim($fornitore)>"")
  {
  $qr="SELECT * FROM mgforn LEFT JOIN articoli ON art_codice=mgf_codart WHERE mgf_codfor='$fornitore' AND mgf_codart BETWEEN '$da_artgi' AND '$a_artgi' ORDER BY mgf_codart";
  }
else
  {
  $qr="SELECT * FROM articoli WHERE art_codice BETWEEN '$da_artgi' AND '$a_artgi' AND art_scorta_min > 0 ORDER BY art_codice";
  }
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
  	 extract($row);
     //leggi fornitore
     $cf_ragsoc="";
     $qf="SELECT cf_ragsoc FROM clienti WHERE cf_cod='$art_fornitore'";
     $rsf=mysql_query($qf, $con);
     while($rof=mysql_fetch_array($rsf)) {
	   $cf_ragsoc=$rof["cf_ragsoc"];
	   }
	 //fine leggi fornitore

     $valori=calcola_valore_medio($art_codice,0,$dal,$al,"S");
     $z_giacenza=number_format($valori["tqta"],2,",",".");
     $z_acquisti=number_format($valori["acquisti"],2,",",".");
     $z_vendite=number_format($valori["vendite"],2,",",".");
     
     $ord=0;
     if(isset($aord["$art_codice"]))
       {
	   	$ord=$aord["$art_codice"];
	   }
     $z_ordini=number_format($ord,2,",",".");

     $ordfo=0;
     if(isset($aordfo["$art_codice"]))
       {
	   	$ordfo=$aordfo["$art_codice"];
	   }
     $z_ordinifo=number_format($ordfo,2,",",".");     

     if($valori["tqta"]<$art_scorta_min)
       {
//	 
     $z_scorta_min=number_format($art_scorta_min,2,",",".");

     $pdf->SetXY(10,$mm);
   	 $pdf->Cell(20,4,$art_codice,0,0,'L');
   	 $pdf->Cell(115,4,$art_descrizione,0,0,'L');
   	 //$pdf->CellFit(50,4,$cf_ragsoc,0,0,'L',false,'',true,false);
   	 $pdf->Cell(50,4,substr($cf_ragsoc,0,20),0,0,'L');
   	 $pdf->Cell(15,4,$z_acquisti,0,0,'R');
   	 $pdf->Cell(15,4,$z_vendite,0,0,'R');
   	 $pdf->Cell(15,4,$z_giacenza,0,0,'R');
   	 $pdf->Cell(15,4,$z_scorta_min,0,0,'R');
   	 $pdf->Cell(15,4,$z_ordini,0,0,'R');
   	 $pdf->Cell(15,4,$z_ordinifo,0,0,'R');

     $mm+=$a;
	   	
	   }

//////////////////////////////////////////
   if($mm>190) { 
      $pdf->AddPage("L","A4");
      $pdf->SetXY(6,10);
      $mm=10;
      testata();
	  }
	}	   
//
$pdf->Output();
?>
