<?php
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
require 'cellfit.php';
//
require 'include/database.php';
require 'include/java.php';
require 'calcola_medio.php';
//
foreach ($_GET as $key => $value) 
  { 
  $$key=$value;
  }
$incremento=floatval($incremento);  
//
//lettura causali magazzino
unset($codcaus);
unset($descaus);
unset($causali);
$codcaus[]="";
$descaus[]="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't40%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
echo mysql_error();
while($row = mysql_fetch_array($rst)) {
     $tabcaus=json_decode($row["tab_resto"],true);
     $codcaus[]=substr($row["tab_key"],3,2);
     $descaus[]=substr($row["tab_key"],3,3) . " " . $tabcaus["DESCRIZIONE_CAUSALE"];
     $a=trim(substr($row["tab_key"],3,2));
     $tipo=$tabcaus["CAR_SCAR_INV_TRASF"];
     $causali[$a]=$tipo;     
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
     $pdf->SetFont('Times','B',7.5);
     $pdf->SetXY(3,$mm);
   	 $pdf->Cell(17,4,"Articolo",0,0,'L');
   	 $pdf->Cell(90,4,"Descrizione",0,0,'L');
   	 $pdf->Cell(35,4,"Fornitore",0,0,'L');
   	 $pdf->Cell(11,4,"Acquisti",0,0,'R');
   	 $pdf->Cell(11,4,"Vendite",0,0,'R');
   	 $pdf->Cell(11,4,"Giac.  ",0,0,'R');
   	 $pdf->Cell(11,4,"Giac.02",0,0,'R');
   	 $pdf->Cell(11,4,"Giac.03",0,0,'R');
   	 $pdf->Cell(11,4,"Sco.min.",0,0,'R');
   	 $pdf->Cell(11,4,"Or.Cli",0,0,'R');	
   	 $pdf->Cell(11,4,"Or.C.02",0,0,'R');	
   	 $pdf->Cell(11,4,"Or.C.03",0,0,'R');	
   	 $pdf->Cell(11,4,"Or.For",0,0,'R');	
   	 $pdf->Cell(11,4,"Or.F.02",0,0,'R');	
   	 $pdf->Cell(11,4,"Or.F.03",0,0,'R');	
     $mm+=$a;
     $pdf->SetFont('Times','',8);
}
/////////////////INIZIO PROGRAMMA///////////////////////////
$pdf=new FPDF_CellFit('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
//
$pdf->SetFont('Times','',8);
$mm=10;
$a=4;
//$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
$oggi=date("Y-m-d");
//
$pdf->SetXY(3,10);
testata();
//
mysql_select_db($DB_NAME, $con);
$aord=g_ordini_per_articolo($dal,$al,$sessanta);
$aordfo=g_ordinifo_per_articolo($dal,$al);
//  
/*
if(trim($fornitore)>"")
  {
  $qr="SELECT * FROM mgforn LEFT JOIN articoli ON art_codice=mgf_codart WHERE mgf_codfor='$fornitore' AND mgf_codart BETWEEN '$da_artgi' AND '$a_artgi' ORDER BY mgf_codart";
  }
else
*/
$q1="";
if(trim($fornitore)>"")
  {
  $q1="AND art_fornitore='$fornitore'";
  }
if(trim($fornitore)>"" && trim($afornitore)>"")
  {
  $q1="AND art_fornitore BETWEEN '$fornitore' AND '$afornitore'";
  }
  {
  $qr="SELECT * FROM articoli WHERE art_codice BETWEEN '$da_artgi' AND '$a_artgi' $q1 ORDER BY art_codice";
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
	 
	 if($incremento>0)
	   {
	   	$art_scorta_min=$art_scorta_min + $art_scorta_min * $incremento / 100;
	   }

     $valori=calcola_valore_medio($art_codice,$deposito,$dal,$al,"S");


     $z_giacenza=number_format($valori["tqta"],2,",",".");
     $z_giacenza2=number_format($valori["depo_val"]["02"]["qta"]+$valori["depo_val"]["12"]["qta"],2,",",".");
     $z_giacenza3=number_format($valori["depo_val"]["03"]["qta"]+$valori["depo_val"]["13"]["qta"],2,",",".");
     
     $z_acquisti=number_format($valori["acquisti"],2,",",".");
     $z_vendite=number_format($valori["vendite"],2,",",".");
     
     $ord=0;
     if(isset($aord["$art_codice"]["00"]))
       {
	   	$ord=$aord["$art_codice"]["00"];
	   }
     $z_ordini=number_format($ord,2,",",".");
     $ord2=0;
     if(isset($aord["$art_codice"]["2"]))
       {
	   	$ord2=$aord["$art_codice"]["2"];
	   }
     $z_ordini2=number_format($ord2,2,",",".");     
     $ord3=0;
     if(isset($aord["$art_codice"]["3"]))
       {
	   	$ord3=$aord["$art_codice"]["3"];
	   }
     $z_ordini3=number_format($ord3,2,",",".");     

     $ordfo=0;
     if(isset($aordfo["$art_codice"]["00"]))
       {
	   	$ordfo=$aordfo["$art_codice"]["00"];
	   }
     $z_ordinifo=number_format($ordfo,2,",",".");     
     $ordfo2=0;
     if(isset($aordfo["$art_codice"]["2"]))
       {
	   	$ordfo2=$aordfo["$art_codice"]["2"];
	   }
     $z_ordinifo2=number_format($ordfo2,2,",",".");     
     $ordfo3=0;
     if(isset($aordfo["$art_codice"]["3"]))
       {
	   	$ordfo3=$aordfo["$art_codice"]["3"];
	   }
     $z_ordinifo3=number_format($ordfo3,2,",",".");     

     $sta=0;
     if($valori["tqta"]<$art_scorta_min)
       {
	   $sta=1;
	   }
//
     if($omette=="true" && $ordfo>0) //Omette gli articoli in ordine a Fornitore
       {
       $sta=0;
	   }
//
     if($inordine=="true" && $ord>0) //Stampa materiale in ordine anche se non sottoscorta
       {
       $sta=1;
	   }
//
     if($codici=="true") //Stampa tutti gli articoli compresi tra i codici
       {
       $sta=1;
	   }
	   
     if($ocodici=="true" && $art_scorta_min==0 && $ord==0 && $valori["vendite"]==0 && $valori["acquisti"]==0) 
     //Stampa tutti gli articoli compresi tra i codici omettendo art. a zero scorta, ord. e movim.
       {
       $sta=0;
	   }	   

     if($sta==1)
       {
//	 
     $z_scorta_min=number_format($art_scorta_min,2,",",".");

     $pdf->SetXY(3,$mm);
   	 $pdf->Cell(17,4,$art_codice,0,0,'L');
   	 $pdf->Cell(90,4,$art_descrizione,0,0,'L');
   	 //$pdf->CellFit(50,4,$cf_ragsoc,0,0,'L',false,'',true,false);
   	 $pdf->Cell(35,4,substr($cf_ragsoc,0,20),0,0,'L');
   	 $pdf->Cell(11,4,$z_acquisti,0,0,'R');
   	 $pdf->Cell(11,4,$z_vendite,0,0,'R');
   	 $pdf->Cell(11,4,$z_giacenza,0,0,'R');
   	 $pdf->Cell(11,4,$z_giacenza2,0,0,'R');
   	 $pdf->Cell(11,4,$z_giacenza3,0,0,'R');
   	 $pdf->Cell(11,4,$z_scorta_min,0,0,'R');
   	 $pdf->Cell(11,4,$z_ordini,0,0,'R');
   	 $pdf->Cell(11,4,$z_ordini2,0,0,'R');
   	 $pdf->Cell(11,4,$z_ordini3,0,0,'R');
   	 $pdf->Cell(11,4,$z_ordinifo,0,0,'R');
   	 $pdf->Cell(11,4,$z_ordinifo2,0,0,'R');
   	 $pdf->Cell(11,4,$z_ordinifo3,0,0,'R');

     $mm+=$a;
	   	
	   }

//////////////////////////////////////////
   if($mm>190) { 
      $pdf->AddPage();
      $pdf->SetXY(3,10);
      $mm=10;
      testata();
	  }
	}	   
//
$pdf->Output();
?>
