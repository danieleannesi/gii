<?php
///////////lisforn//////////////////
function leggi_tabelle($codice,$descri)
{
	global $con;
	$qr="SELECT * FROM tabelle WHERE tab_key = '$codice'";
    $rsi = mysql_query($qr, $con);
    while($roi = mysql_fetch_array($rsi)) {
       $tabresto=json_decode($roi["tab_resto"],true);
       $descrizione=$tabresto["$descri"];
	   }
return $descrizione;
}
//
require 'fpdf_js.php';
require 'include/database.php';
require 'include/java.php';
require 'calcola_medio.php';
//
$data_for=addrizza("",$_GET["data_for"]);
$data_ven=addrizza("",$_GET["data_ven"]);
$fornitore=$_GET["fornitore"];
//
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
$pdf=new PDF_AutoPrint();
$pdf->AliasNbPages();
$pdf->AddPage("L","A4");
//
$pdf->SetFont('Times','',9);
$mm=10;
$a=4;
$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
$pdf->SetXY(6,10);
//
mysql_select_db($DB_NAME, $con);
$qr="SELECT * FROM clienti WHERE cf_cod='$fornitore'";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
   $clienti=$row;   
   }
$cf_porto=$clienti["cf_porto"];
//
$qr="SELECT * FROM mgforn LEFT JOIN articoli ON art_codice=mgf_codart WHERE mgf_codfor='$fornitore' ORDER BY mgf_codart";
//$qr="SELECT * FROM mgforn LEFT JOIN articoli ON art_codice=mgf_codart WHERE mgf_codfor='$fornitore' AND mgf_codart='0130345650' ORDER BY mgf_codart";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
  	 extract($row);
     $trasp=leggi_tabelle("t52$cf_porto","ADDEBITO_IN_PERCENT");
     if($art_trasporto>0)
       {
	   	$trasp=$art_trasporto;
	   }
	 if($trasp==99.99)
	   {
	   	$trasp=0.00;
	   }
     $ztrasp=number_format($trasp,2,",",".");
     if($ztrasp=="0,00")
       {
	   	$ztrasp="";
	   }
     $valori=calcola_valore_medio($mgf_codart,0,$dal,$al,"N");
     $nw_medio=$valori["nw_medio"];
     $zgiacenza=number_format($valori["tqta"],2,",",".");
     if($zgiacenza=="0,00")
       {
	   	$zgiacenza="";
	   }
     $val_medio=$valori["nw_medio"];
     
     $vendita=$art_listino1;
     if($art_data_listino<$data_ven && $art_data_listino!="2000-00-00")
       {
	   $vendita=$art_listino2;
	   }
	 $zvendita=number_format($vendita,4,",",".");
     if($zvendita=="0,0000")
       {
	   	$zvendita="";
	   }
     $prezzo=$mgf_pr_listino;
     if($mgf_data_listino<$data_for && $mgf_data_listino!="2000-00-00")
       {
	   $prezzo=$mgf_pr_listino2;
	   }
     $netto=$mgf_pr_netto;
     if($mgf_data_listino<$data_for && $mgf_data_listino!="2000-00-00")
       {
	   $netto=$mgf_pr_netto2;
	   }
     if($netto>0)
       {
	   	$prezzo=$netto;
	   }
	 $zprezzo=number_format($prezzo,4,",",".");
     if($zprezzo=="0,0000")
       {
	   	$zprezzo="";
	   }
     $sconto=$mgf_sconto;
     if($mgf_data_sconto<$data_for && $mgf_data_sconto!="2000-00-00")
       {
	   $sconto=$mgf_sconto2;
	   }	 
	 $zsconto=number_format($sconto,2,",",".");
     if($zsconto=="0,00")
       {
	   	$zsconto="";
	   }
     $netto=$prezzo - $prezzo*$sconto/100;
     $netto=$netto*(100+$trasp)/100;
     $netto=round($netto,4);
	 $znetto=number_format($netto,4,",",".");
     if($znetto=="0,0000")
       {
	   	$znetto="";
	   }
     //COMPUTE RICARICA ROUNDED =
     //        (PREVEN-EU / CORRETTIVO - PRENET-EU) *
     //                              100 / PRENET-EU
     $ricarica=($vendita/1.43 - $netto) * 100 / $netto;
     $ricarica=round($ricarica,2);
	 $zricarica=number_format($ricarica,2,",",".");
     if($zricarica=="0,00")
       {
	   	$zricarica="";
	   }

     //COMPUTE RIC2 ROUNDED =
     //             (PREVEN-EU / CORRETTIVO - MAG-21-EU) *
     //                      100 / MAG-21-EU.
     $ricarica2=0;
     if($netto>0)
       {
       $ricarica2=($vendita/1.43 - $val_medio) * 100 / $val_medio;
       $ricarica2=round($ricarica2,2);
	   }
	 $zricarica2=number_format($ricarica2,2,",",".");
     if($zricarica2=="0,00")
       {
	   	$zricarica2="";
	   }
     
     $pdf->SetXY(10,$mm);
   	 $pdf->Cell(30,4,$mgf_codprod,0,0,'L');
   	 $pdf->Cell(20,4,$mgf_codart,0,0,'L');
   	 $pdf->Cell(110,4,$art_descrizione,0,0,'L');
   	 $pdf->Cell(13,4,$zprezzo,0,0,'R');
   	 $pdf->Cell(13,4,$zsconto,0,0,'R');
   	 $pdf->Cell(10,4,$ztrasp,0,0,'R');
   	 $pdf->Cell(13,4,$znetto,0,0,'R');
   	 $pdf->Cell(13,4,$zvendita,0,0,'R');
   	 $pdf->Cell(13,4,$zricarica,0,0,'R');
   	 $pdf->Cell(13,4,$zricarica2,0,0,'R');
   	 $pdf->Cell(13,4,$zgiacenza,0,0,'R');
   	 
     $mm+=$a;

   if($mm>190) { 
      $pdf->AddPage("L","A4");
      $pdf->SetXY(6,10);
      $mm=10;
	  }
	}	   
////stampa automatica////////////////////////////////////////
//$pdf->IncludeJS("pp=getPrintParams(); print(pp);");
$pdf->AutoPrint(false);
//
$pdf->Output();
?>
