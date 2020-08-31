<?php
///////////fattura differita//////////////////
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
////////////////////////////////////////////////////
$tot_rig=33;
$num_pag=1;
$tot_pag=1;
//
$idt=0;
$tipo=0;
if(isset($_GET["idt"]))
  {
  $idt=$_GET["idt"];
  }
if(isset($_GET["tipo"]))
  {
  $tipo=$_GET["tipo"];
  }
switch ($tipo) {
    case "7":
        $tipodoc="Fattura";
        break;
    case "8":
        $tipodoc="Nota di Credito";
        break;
    case "4":
        $tipodoc="Buono di Acquisto";
        break;
    case "5":
        $tipodoc="Fattura";
        break;
    case "9":
        $tipodoc="Nota di Debito";
        break;
}
//legge documento
  $qr="SELECT * FROM documtes LEFT JOIN clienti ON DOCT_CLIENTE=cf_cod WHERE DOCT_ID=$idt";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi documento) " . mysql_error();
	mysql_close($con);
	exit;
	}
  if(mysql_num_rows($rst)==0) {
     echo "documento non trovato";
	 exit;
     }
  $row = mysql_fetch_array($rst);
  $righe=json_decode($row["DOCT_RIGHE"],true);
  $scadenze=json_decode($row["DOCT_SCADENZE"],true);
  
  $nrighe=count($righe["desc"]);
  
$ragsoc=$row["cf_ragsoc"];
$indirizzo=$row["cf_indirizzo"];
$cap=$row["cf_cap"];
$localita=$row["cf_localita"];
$prov=$row["cf_prov"];
$partiva=$row["cf_piva"];
$banca=$row["cf_banca"];

  $data_doc=$row["DOCT_DATA_DOC"];
  $data_doc=substr($data_doc,8,2) . "/" . substr($data_doc,5,2) . "/" . substr($data_doc,0,4);
  $num_doc=$row["DOCT_NUM_DOC"];
  $cliente=$row["DOCT_CLIENTE"];

  $modpag=$row["DOCT_COD_PAG"];
  $des_pag=leggi_tabelle("T66$modpag","DESCRIZ_PAGAMENTO");

  $agente=$row["cf_agente"];
  $des_agente=substr(leggi_tabelle("T42$agente","NOME_AGENTE"),0,7);
	   
//////////////////////////////////////////////////
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
global $tipodoc;
global $cliente;
global $ragsoc;
global $ragsoc2;
global $indirizzo;
global $cap;
global $localita;
global $prov;
global $banca;
global $pagamento;
global $agente;
global $des_agente;
global $des_pag;
global $codcom;
global $banca;
global $partiva;
global $codfisc;
global $data_doc;
global $num_doc;
global $impon1;
global $impon2;
global $impon3;
global $iva1;
global $iva2;
global $iva3;
global $totese;
global $ali1;
global $ali2;
global $ali3;
global $totale;
global $des1;
global $des2;
global $des3;
global $spese;
global $num_pag;
global $tot_pag;
global $tot_rig;
global $nrighe;
global $copia;
//
$num_pag=$this->PageNo();
$var_int=($nrighe / $tot_rig);
if (is_int($var_int)) {
   $tot_pag=intval($var_int);
   }
else {
   $tot_pag=intval($var_int) + 1;
   }
//
$this->SetTopMargin(0);
$this->SetLineWidth(0.05);
$this->Image("images/logop_GI.jpg",10,8,31);
$this->SetFont('Times','B',12);
$this->SetXY(10,29);
$this->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');
$this->SetFont('Times','',7.5);
$this->SetXY(10,34);
$this->Cell(0,4,"Cap.Soc. € 650.010,00 i.v.",0,0,'L');
$this->SetXY(10,37);
$this->Cell(0,4,"C.F. 01089330581 P.IVA 00960221000",0,0,'L');
$this->SetXY(10,40);
$this->Cell(0,4,"Sede Legale e Vendita:",0,0,'L');
$this->SetXY(37,40);
$this->Cell(0,4,"00178 ROMA - Via R.B.Bandinelli, 54",0,0,'L');
$this->SetXY(37,43);
$this->Cell(0,4,"Tel 06 7932301 - Fax 06 79326161",0,0,'L');
$this->SetXY(10,46);
$this->Cell(0,4,"Show Room e Vendita:",0,0,'L');
$this->SetXY(37,46);
$this->Cell(0,4,"00138 ROMA - Via Fosso di Settebagni, 10",0,0,'L');
$this->SetXY(37,49);
$this->Cell(0,4,"Tel 06 8887526 - Fax 06 8887475",0,0,'L');
//
$this->SetXY(10,52);
$this->Cell(0,4,"Mega Store:",0,0,'L');
$this->SetXY(37,52);
$this->Cell(0,4,"00165 ROMA - Via Gregorio VII 200/208",0,0,'L');
$this->SetXY(37,55);
$this->Cell(0,4,"Tel 06 6386078 - Fax 06 6381317",0,0,'L');
//
$this->SetXY(37,58);
$this->Cell(0,4,"web: www.gallinnocenti.it   mail: info@gallinnocenti.it",0,0,'L');
//
$this->SetFillColor(220);
$this->SetFont('Times','I',7);
//destinatario
	$this->Line(110,38,114,38);
	$this->Line(110,38,110,42);
	$this->Line(196,38,200,38);
	$this->Line(200,38,200,42);
	$this->Line(110,59,114,59);
  	$this->Line(110,59,110,54);
	$this->Line(196,59,200,59);
	$this->Line(200,59,200,54);
	
//agente-num.fat-data fat
    $this->Rect(10,73,26,10);
    $this->Rect(36,73,26,10);
    $this->Rect(62,73,26,10);
	$this->SetXY(10,75);
    $this->Cell(0,0,"Agente",0,0,'L');	
	$this->SetXY(36,75);
    $this->Cell(0,0,"Documento N.",0,0,'L');
	$this->SetXY(62,75);
    $this->Cell(0,0,"Data",0,0,'L');
//par.iva-cod.cliente-pagamento-banca
    $this->Rect(10,83,40,10);
    $this->Rect(50,83,26,10);
    $this->Rect(76,83,62,10);
    $this->Rect(138,83,62,10);
	$this->SetXY(10,85);
    $this->Cell(0,0,"Partita IVA o C.F. Cliente",0,0,'L');	
	$this->SetXY(50,85);
    $this->Cell(0,0,"Codice Cliente",0,0,'L');
	$this->SetXY(76,85);
    $this->Cell(0,0,"Condizioni di Pagamento",0,0,'L');
	$this->SetXY(138,85);
    $this->Cell(0,0,"Banca di Appoggio",0,0,'L');

//articolo-descri-um-qua-pre-sco-imp-iva
    $this->Rect(10,95,20,5,"DF");
    $this->Rect(30,95,87,5,"DF");
    $this->Rect(117,95,8,5,"DF");
    $this->Rect(125,95,17,5,"DF");
    $this->Rect(142,95,20,5,"DF");
    $this->Rect(162,95,10,5,"DF");
    $this->Rect(172,95,22,5,"DF");
    $this->Rect(194,95,6,5,"DF");
    $this->Rect(10,100,20,133);
    $this->Rect(30,100,87,133);
    $this->Rect(117,100,8,133);
    $this->Rect(125,100,17,133);
    $this->Rect(142,100,20,133);
    $this->Rect(162,100,10,133);
    $this->Rect(172,100,22,133);
    $this->Rect(194,100,6,133);
    $this->SetXY(11,96);
    $this->Cell(0,4,"Codice Articolo",0,0,'L');
    $this->SetXY(31,96);
    $this->Cell(0,4,"Descrizione",0,0,'L');
    $this->SetXY(118,96);
    $this->Cell(0,4,"um",0,0,'L');
    $this->SetXY(126,96);
    $this->Cell(0,4,"Quantità",0,0,'L');
    $this->SetXY(143,96);
    $this->Cell(0,4,"Prezzo Un.",0,0,'L');
    $this->SetXY(163,96);
    $this->Cell(0,4,"% Sc",0,0,'L');
    $this->SetXY(173,96);
    $this->Cell(0,4,"Importo",0,0,'L');
    $this->SetXY(195,96);
    $this->Cell(0,4,"Iva",0,0,'L');	

//scadenze
    $this->Rect(10,235,50,5,"DF");
    $this->Rect(10,240,50,25);
    $this->SetXY(10,236);
    $this->Cell(0,4,"Scadenze",0,0,'L');

//impo-iva-ali
    $this->Rect(60,235,140,5,"DF");
    $this->Rect(60,240,140,25);
    $this->SetXY(65,236);
    $this->Cell(0,4,"Aliquota",0,0,'L');
    $this->SetXY(125,236);
    $this->Cell(0,4,"Imponibile",0,0,'L');
    $this->SetXY(153,236);
    $this->Cell(0,4,"Imposta",0,0,'L');

//Totale Merce-trasporto-spese-bollo-raee-totale-iva-totale fat
    $this->Rect(10,265,22,10);
    $this->Rect(32,265,22,10);
    $this->Rect(54,265,22,10);
    $this->Rect(76,265,22,10);
    $this->Rect(98,265,22,10);
    $this->Rect(120,265,22,10);
    $this->Rect(142,265,22,10);
	$this->Rect(164,265,36,10);

    $this->SetXY(10,265);
    $this->Cell(0,4,"Totale Merce",0,0,'L');
    $this->SetXY(32,265);
    $this->Cell(0,4,"Trasporto e Imballo",0,0,'L');
    $this->SetXY(54,265);
    $this->Cell(0,4,"Spese Inc./Amm.ve",0,0,'L');
    $this->SetXY(76,265);
    $this->Cell(0,4,"Bollo Effetti",0,0,'L');
    $this->SetXY(98,265);
    $this->Cell(0,4,"RAEE",0,0,'L');
	$this->SetXY(120,265);
    $this->Cell(0,4,"Totale",0,0,'L');
    $this->SetXY(142,265);
    $this->Cell(0,4,"IVA o Bollo",0,0,'L');
    $this->SetFont('Times','B',6.5);
    $this->SetXY(166,265);
    $this->Cell(0,4,"TOTALE $tipodoc",0,0,'L');

//destinatario
$this->SetFont('Times','',11);
$this->SetXY(113,42);
$this->Cell(0,0,$ragsoc,0,0,'L');
//$this->SetXY(113,46);
//$this->Cell(0,0,$ragsoc2,0,0,'L');
$this->SetXY(113,50);
$this->Cell(0,0,$indirizzo,0,0,'L');
$this->SetXY(113,54);
$ccc=$cap . "  " . trim($localita) . "     " . $prov;
$this->Cell(0,0,$ccc,0,0,'L');
//
$this->SetXY(10,79);
$this->Cell(0,0,$agente . "/" . $des_agente,0,0,'L');
$this->SetXY(40,79);
$this->Cell(0,0,sprintf("%08d", $num_doc),0,0,'L');
$this->SetXY(63,79);
$this->Cell(0,0,$data_doc,0,0,'L');

$this->SetFont('Times','B',12);
$this->SetXY(100,79);
$this->Cell(0,0,$tipodoc,0,0,'L');
$this->SetFont('Times','',11);

$this->SetXY(180,79);
$this->Cell(0,0,"Pag. $num_pag/$tot_pag",0,0,'L');

$this->SetXY(10,89);
$this->Cell(0,0,$partiva,0,0,'L');
$this->SetXY(50,89);
$this->Cell(0,0,$cliente,0,0,'L');

$this->SetFont('Times','',9);
$this->SetXY(76,89);
$this->Cell(0,0,$des_pag,0,0,'L');
$this->SetXY(138,89);
$this->Cell(0,0,$banca,0,0,'L');
//
/*
$this->SetFont('Times','',6);
$this->SetXY(10,280);
$this->Cell(0,0,$copia,0,0,'L');
*/
$this->SetXY(80,280);
$this->Cell(0,0,"CONTRIBUTO AMBIENTALE CONAI ASSOLTO",0,0,'L');
//
$this->SetFont('Times','',9);

if ($num_pag!=$tot_pag)
   {
   $this->SetXY(174,250);
   $this->Cell(22,0,"SEGUE ===>",0,0,'L');
   }
//
}

function Footer()
{
global $tot_pag;
global $num_pag;
//
if ($num_pag==$tot_pag)
    {
	$this->SetFont('Times','',10);
	}
}
}
////////////////////////////////////////////////stampa
$pdf=new PDF_AutoPrint();
$pdf->AliasNbPages();
$pdf->AddPage();
//
$pdf->SetFont('Times','',10);
$k=1;
$mm=101;
$pdf->SetXY(6,101);
//
$tot_merce=0;
$tot_raee=0;
for($j=0;$j<count($righe["desc"]);$j++)
     {
     $articolo=$righe["cod"][$j];
     if($articolo=="9999999999")
       {
	   	$articolo="";
	   }
     $descri=$righe["desc"][$j];
     $quantita=$righe["qta"][$j];
     $prezzo=$righe["uni"][$j];
     $sconto=$righe["sco"][$j];
     $totale=$righe["tot"][$j];
     $tot_merce+=$totale;
     $raee=$righe["raee"][$j];
     //$umis=$row["umis"][$j];
     $umis="";
     $aliq=$righe["iva"][$j];
     if($articolo=="" && $totale==0)
       {
	   	$aliq="";
	   }
     if($aliq=="00" || $articolo=="")
       {
	   	$aliq="";
	   }
     if(trim($sconto)=="0") { $sconto=""; }
	 $quantita=number_format($quantita, 2, ',', '.');
	 $prezzo=number_format($prezzo, 4, ',', '.');
	 $totale=number_format($totale, 2, ',', '.');
	 $sconto=number_format($sconto, 2, ',', '.');
     if($quantita=="0,00") { $quantita=""; }
     if($prezzo=="0,0000") { $prezzo=""; }
     if($totale=="0,00") { $totale=""; }
     $mm1=$mm;
     $pdf->SetFont('Times','',9);
     $pdf->SetXY(29.5,$mm);
     $pdf->MultiCell(87,4,$descri,0,'L');
     $y=$pdf->GetY();
     $a=$y-$mm;
     $pdf->SetFont('Times','',10);
     $pdf->SetXY(10,$mm1);
     $pdf->SetFont('Times','',10);
	 $pdf->Cell(18.5,4,$articolo,0,0,'L');
     $pdf->SetXY(116.5,$mm);
   	 $pdf->Cell(9,4,$umis,0,0,'L');
   	 $pdf->Cell(17,4,$quantita,0,0,'R');
   	 $pdf->Cell(20.3,4,$prezzo,0,0,'R');
   	 $pdf->Cell(9,4,$sconto,0,0,'R');
   	 $pdf->Cell(22.5,4,$totale,0,0,'R');
     $pdf->Cell(5,4,$aliq,0,1,'R');
     $k=$k+1;
     $tot_rec++;
     $mm+=$a;

        if($raee>0)
          {
           $tot_rec++;
           $totale=$raee*$righe["qta"][$j];
           $tot_raee+=$totale;
	       $prezzo=number_format($raee, 4, ',', '.');
	       $totale=number_format($totale, 2, ',', '.');
    	   $pdf->SetXY(10,$mm);
           $pdf->SetFont('Times','',9);
           $pdf->SetXY(29.5,$mm);
           $pdf->Cell(87,4,"ECO CONTRIBUTO RAEE",0,0,'L');
           $pdf->SetFont('Times','',10);
	       $pdf->Cell(18.5,4,"",0,0,'L');
           $pdf->SetXY(116.5,$mm);
   		   $pdf->Cell(9,4,$umis,0,0,'L');
   		   $pdf->Cell(17,4,$quantita,0,0,'R');
   		   $pdf->Cell(20.3,4,$prezzo,0,0,'R');
   		   $pdf->Cell(9,4,"",0,0,'R');
   		   $pdf->Cell(22.5,4,$totale,0,0,'R');
           $pdf->Cell(5,4,$aliq,0,1,'R');
           $k=$k+1;
           $mm+=4;
		  }
   if($mm>230) { 
      $pdf->AddPage();
      $pdf->SetXY(6,101);
      $mm=101;
	}
		
}


		   
if($tipo=="7" || $tipo=="5")
  {
	
	
	  
  $pdf->SetFont('Times','',10);
  $mm=244;
  for($j=0;$j<count($scadenze["data"]);$j++)
     {
     $pdf->SetXY(10,$mm);
     $data=addrizza($scadenze["data"][$j],"");
     $importo=$scadenze["importo"][$j];
	 $impo=number_format($importo, 2, ',', '.');
	 $pdf->Cell(25,0,$data,0,0,'L');
	 $pdf->Cell(20,0,$impo,0,0,'R');
     $mm+=4;     
     }     
  }

    $ali1=$row["DOCT_ALIQUOTA_1"];
    $ali2=$row["DOCT_ALIQUOTA_2"];
    $ali3=$row["DOCT_ALIQUOTA_3"];
    $impon1=$row["DOCT_IMPONIBILE_1"];
    $impon2=$row["DOCT_IMPONIBILE_2"];
    $impon3=$row["DOCT_IMPONIBILE_3"];
    $iva1=$row["DOCT_IMPOSTA_1"];
    $iva2=$row["DOCT_IMPOSTA_2"];
    $iva3=$row["DOCT_IMPOSTA_3"];
    $tot_impo=$row["DOCT_TOT_IMPONIBILE"];
    $tot_iva=$row["DOCT_TOT_IMPOSTA"];
    $totale=$row["DOCT_TOT_FATTURA"];
	$trasporto=$row["DOCT_TRASPORTO"];
    $spese=$row["DOCT_ADDVARI"] + $row["DOCT_COLLAUDO"] + $row["DOCT_INSTALLAZ"] + $row["DOCT_JOLLY"] + $row["DOCT_EUROPALLET"] + $row["DOCT_NOLEGGIO"] + $row["DOCT_SPESE_INCASSO"];
    $effetti=$row["DOCT_BOLLI_ESIVA"];
    //$raee=$row["DOCT_IMPORTO_RAEE"];

    $tot_impo=number_format($tot_impo, 2, ',', '.');
    $tot_iva=number_format($tot_iva, 2, ',', '.');
    $impon1=number_format($impon1, 2, ',', '.');
    $impon2=number_format($impon2, 2, ',', '.');
    $impon3=number_format($impon3, 2, ',', '.');
    $iva1=number_format($iva1, 2, ',', '.');
    $iva2=number_format($iva2, 2, ',', '.');
    $iva3=number_format($iva3, 2, ',', '.');
    $tot_merce=number_format($tot_merce, 2, ',', '.');
    $spese=number_format($spese, 2, ',', '.');
    $trasporto=number_format($trasporto, 2, ',', '.');
    $effetti=number_format($effetti, 2, ',', '.');
    $tot_raee=number_format($tot_raee, 2, ',', '.');
    if($ali2=="00") { $ali2=""; }
    if($ali3=="00") { $ali3=""; }
    if($impon2=="0,00") { $impon2=""; }
    if($impon3=="0,00") { $impon3=""; }
    if($iva2=="0,00") { $iva2=""; }
    if($iva3=="0,00") { $iva3=""; }
    
    $des1=leggi_tabelle("T44$ali1","TITOLO_ESENZIONE");
    $des2=leggi_tabelle("T44$ali2","TITOLO_ESENZIONE");
    $des3=leggi_tabelle("T44$ali3","TITOLO_ESENZIONE");

//impo-iva-ali
	$pdf->SetXY(65,244);
	$pdf->Cell(6,0,$ali1,0,0,'L');
	$pdf->Cell(45,0,$des1,0,0,'L');
	$pdf->Cell(26,0,$impon1,0,0,'R');
	$pdf->Cell(26,0,$iva1,0,0,'R');
	$pdf->SetXY(65,248);
	$pdf->Cell(6,0,$ali2,0,0,'L');
	$pdf->Cell(45,0,$des2,0,0,'L');
	$pdf->Cell(26,0,$impon2,0,0,'R');
	$pdf->Cell(26,0,$iva2,0,0,'R');
	$pdf->SetXY(65,252);
	$pdf->Cell(6,0,$ali3,0,0,'L');
	$pdf->Cell(45,0,$des3,0,0,'L');
	$pdf->Cell(26,0,$impon3,0,0,'R');
	$pdf->Cell(26,0,$iva3,0,0,'R');

	
//ultima riga
	$pdf->SetXY(10,271);
	$pdf->Cell(22,0,$tot_merce,0,0,'R');
	$pdf->Cell(22,0,$trasporto,0,0,'R');
	$pdf->Cell(22,0,$spese,0,0,'R');
	$pdf->Cell(22,0,$effetti,0,0,'R');
	$pdf->Cell(22,0,$tot_raee,0,0,'R');
	$pdf->Cell(22,0,$tot_impo,0,0,'R');
	$pdf->Cell(22,0,$tot_iva,0,0,'R');
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(26,0,$totale,0,0,'R');
	   
////stampa automatica////////////////////////////////////////
//$pdf->IncludeJS("pp=getPrintParams(); print(pp);");
$pdf->AutoPrint(false);
//
$pdf->Output();
?>
