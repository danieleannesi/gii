<?php
//ob_start();
//session_start();
require 'fpdf_js.php';
require 'include/database.php';
//
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
$idt=0;
if(isset($_GET["idt"]))
  {
  $idt=$_GET["idt"];
  }
if(isset($_POST["idt"]))
  {
  $idt=$_POST["idt"];
  }
//  
//legge documento
  $qr="SELECT * FROM preventivi LEFT JOIN clienti ON PREV_CLIENTE=cf_cod WHERE PREV_ID=$idt";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi preventivi) $qr" . mysql_error();
	mysql_close($con);
	exit;
	}
  if(mysql_num_rows($rst)==0) {
     echo "preventivo non trovato";
	 exit;  
     }
  $row = mysql_fetch_array($rst);
  $righe=json_decode($row["PREV_RIGHE"],true);
  $deposito=$row["PREV_DEPOSITO"];
  $codage=sprintf("%03.0d",$row["PREV_COMMESSO_VEND"]);
  $desage=leggi_tabelle("t63$codage","NOME_COMMESSO");
  $data_doc=$row["PREV_DATA_DOC"];
  $num_doc=$row["PREV_NUM_DOC"];
  $cliente=$row["PREV_CLIENTE"];
  $codpag=$row["PREV_COD_PAG"];
  $ragsoc=$row["cf_ragsoc"];
  $modpag=$row["cf_codpag"];
  $codice_agente=$row["cf_agente"];
  $nome_agente=leggi_tabelle("t42$codice_agente","NOME_AGENTE");
  $agente = $codice_agente." ".$nome_agente. " / " .$codage;  
  $sconto=$row["sconto"];
  $iva=$row["PREV_TRAT_IVA"];
  $totalerae=$row["PREV_IMPORTO_RAE"];
  $flag_foto=$row["PREV_FOTO"];
  $flag_scheda=$row["PREV_SCHEDA"];
  $note=$row["PREV_NOTE"];
  $data_doc=substr($data_doc,8,2) . "/" . substr($data_doc,5,2) . "/" . substr($data_doc,0,4);
$indirizzo=$row["cf_indirizzo"];
$cap=$row["cf_cap"];
$localita=$row["cf_localita"];
$prov=$row["cf_prov"];
$partiva=$row["cf_piva"];
$codfisc=$row["cf_codfisc"];
$impon1=$row["PREV_IMPONIBILE_1"];
$impon2=$row["PREV_IMPONIBILE_2"];
$iva1=$row["PREV_IMPOSTA_1"];
$iva2=$row["PREV_IMPOSTA_2"];
$ali1=$row["PREV_ALIQUOTA_1"];
$ali2=$row["PREV_ALIQUOTA_2"];
$totpre=$row["PREV_TOT_PREVENT"];
if(strlen(trim($indirizzo))==0) 
  {
  $ragsoc=$row["PREV_DES_RAG_SOC"];
  $indirizzo=$row["PREV_DES_INDIRIZZO"];
  $localita=$row["PREV_DES_LOC"];
  $cap=$row["PREV_DES_CAP"];
  $prov=$row["PREV_DES_PR"];
  }
$tot_impo= $impon1 + $impon2;
$tot_iva= $iva1 + $iva2;
$tot_impo=number_format($tot_impo, 2, ',', '.');
$tot_iva=number_format($tot_iva, 2, ',', '.');
$impon1=number_format($impon1, 2, ',', '.');
$impon2=number_format($impon2, 2, ',', '.');
$iva1=number_format($iva1, 2, ',', '.');
$iva2=number_format($iva2, 2, ',', '.');
$totpre=number_format($totpre, 2, ',', '.');
$totalerae=number_format($totalerae, 2, ',', '.');
//
$desiva=leggi_tabelle("T44$ali1","TITOLO_ESENZIONE");
$desiva2=leggi_tabelle("T44$ali2","TITOLO_ESENZIONE");
$despag=leggi_tabelle("T66$codpag","DESCRIZ_PAGAMENTO");
$sw_allegati=0;
$tot_rec=0;
//////////////////////////////////////////////////

//class PDF extends FPDF_Javascript
class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=false)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}
//Page header 
function Header()
{
global $utente;
global $deposito;
global $agente;
global $desage;
global $cliente;
global $ragsoc;
global $indirizzo;
global $cap;
global $localita;
global $prov;
global $despag;
global $partiva;
global $codfisc;
global $data_doc;
global $num_doc;
global $impon1;
global $impon2;
global $iva1;
global $iva2;
global $ali1;
global $ali2;
global $totpre;
global $tot_rig;
global $sw_allegati;
//
$tot_rig=34;
$depdes="";
if($deposito=="02") { $depdes="Via R.B.Bandinelli"; }
if($deposito=="03") { $depdes="Via del Fosso di Settebagni"; }
if($deposito=="04") { $depdes="Via Tor de' Schiavi"; }
//
$this->SetTopMargin(0);
$this->SetLineWidth(0.05);
$this->Image("images/logop_GI.jpg",05,10,31);
$this->SetFont('Times','B',12);
$this->SetXY(5,31);
$this->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');
$this->SetFont('Times','',7.5);

if($sw_allegati==0) {

$this->SetXY(5,37);
$this->Cell(0,4,"Ufficio e Vendita:",0,0,'L');
$this->SetXY(32,37);
$this->Cell(0,4,"00178 ROMA - Via R.B.bandinelli, 54",0,0,'L');
$this->SetXY(32,40);
$this->Cell(0,4,"Tel 06 7932301 - Fax 06 79326161",0,0,'L');
$this->SetXY(5,43);
$this->Cell(0,4,"Show Room e Vendita:",0,0,'L');
$this->SetXY(32,43);
$this->Cell(0,4,"00138 ROMA - Via Fosso di Settebagni, 10",0,0,'L');
$this->SetXY(32,46);
$this->Cell(0,4,"Tel 06 8887526 - Fax 06 8887475",0,0,'L');
//
$this->SetXY(5,49);
$this->Cell(0,4,"Mega Store:",0,0,'L');
$this->SetXY(32,49);
$this->Cell(0,4,"00165 ROMA - Via Gregorio VII 200/208",0,0,'L');
$this->SetXY(32,52);
$this->Cell(0,4,"Tel 06 631911 - Fax 06 6381317",0,0,'L');
//
$this->SetXY(32,55);
$this->Cell(0,4,"web: www.gallinnocenti.it   mail: info@gallinnocenti.it",0,0,'L');

//destinatario
//  $this->Rect(110,31,95,27);
	$this->Line(110,31,114,31);
	$this->Line(110,31,110,35);
	$this->Line(201,31,205,31);
	$this->Line(205,31,205,35);

	$this->Line(110,58,114,58);
  	$this->Line(110,58,110,54);
	$this->Line(201,58,205,58);
	$this->Line(205,58,205,54);
	
//tipo-riferimenti-pagina
    $this->SetFillColor(220);
    $this->Rect(5,68,50,5,"DF");
    $this->Rect(55,68,65,5,"DF");
    $this->Rect(120,68,73,5,"DF");
    $this->Rect(193,68,12,5,"DF");
    $this->Rect(5,73,50,6);
    $this->Rect(55,73,65,6);
    $this->Rect(120,73,73,6);
    $this->Rect(193,73,12,6);

//numero-data-codcli-par.iva-cod.fisc.-pagamento
    $this->Rect(5,79,25,5,"DF");
    $this->Rect(30,79,25,5,"DF");
    $this->Rect(55,79,20,5,"DF");
    $this->Rect(75,79,27,5,"DF");
    $this->Rect(102,79,43,5,"DF");
    $this->Rect(145,79,60,5,"DF");
    $this->Rect(5,84,25,6);
    $this->Rect(30,84,25,6);
    $this->Rect(55,84,20,6);
    $this->Rect(75,84,27,6);
    $this->Rect(102,84,43,6);
    $this->Rect(145,84,60,6);

//articolo-descri-um-qua-pre-sco-imp-iva

    $this->Rect(5,91,25,5,"DF");
    $this->Rect(30,91,93,5,"DF");
    $this->Rect(123,91,9,5,"DF");
    $this->Rect(132,91,17,5,"DF");
    $this->Rect(149,91,22,5,"DF");
    $this->Rect(171,91,9,5,"DF");
    $this->Rect(180,91,25,5,"DF");

    $this->Rect(5,96,25,140);
    $this->Rect(30,96,93,140);
    $this->Rect(123,96,9,140);
    $this->Rect(132,96,17,140);
    $this->Rect(149,96,22,140);
    $this->Rect(171,96,9,140);
    $this->Rect(180,96,25,140);

//rettangolo piede
    $this->Rect(5,239,200,50);

//impo-iva-ali
    $this->Rect(7,240,102,5,"DF");
    $this->Rect(7,245,102,20);

//Totale Imponibile-Totale Iva-Totale Merce
    $this->Rect(111,240,30,5,"DF");
    $this->Rect(141,240,30,5,"DF");
    $this->Rect(171,240,32,5,"DF");
    $this->Rect(111,245,30,6);
    $this->Rect(141,245,30,6);
    $this->Rect(171,245,32,6);
	
//totale
    $this->Rect(157,253,46,5,"DF");
    $this->Rect(157,258,46,7);

//note
    $this->Rect(7,267,196,4,"DF");
    $this->Rect(7,271,196,16);

//didascalie
    $this->SetFont('Times','I',9);
	$this->SetXY(6,69);
    $this->Cell(0,4,"Tipo Documento",0,0,'L');
    $this->SetXY(56,69);
    $this->Cell(0,4,"Sede",0,0,'L');
    $this->SetXY(121,69);
    $this->Cell(0,4,"Agente",0,0,'L');
    $this->SetXY(194,69);
    $this->Cell(0,4,"Pagina",0,0,'L');
	
    $this->SetXY(6,80);
    $this->Cell(0,4,"N.Documento",0,0,'L');
    $this->SetXY(31,80);
    $this->Cell(0,4,"Data Documento",0,0,'L');
    $this->SetXY(56,80);
    $this->Cell(0,4,"Cod.Cliente",0,0,'L');
    $this->SetXY(76,80);
    $this->Cell(0,4,"Partita Iva",0,0,'L');
    $this->SetXY(103,80);
    $this->Cell(0,4,"Codice Fiscale",0,0,'L');
    $this->SetXY(146,80);
	$this->Cell(0,4,"Pagamento",0,0,'L');

    $this->SetXY(6,92);
    $this->Cell(0,4,"Codice Articolo",0,0,'L');
    $this->SetXY(31,92);
    $this->Cell(0,4,"Descrizione",0,0,'L');
    $this->SetXY(124,92);
    $this->Cell(0,4,"um",0,0,'L');
    $this->SetXY(133,92);
    $this->Cell(0,4,"Quantit�",0,0,'L');
    $this->SetXY(150,92);
    $this->Cell(0,4,"Prezzo Un.",0,0,'L');
    $this->SetXY(171,92);
    $this->Cell(0,4,"% Sc",0,0,'L');
    $this->SetXY(184,92);
    $this->Cell(0,4,"Importo",0,0,'L');

    $this->SetXY(7,241);
    $this->Cell(0,4,"Imponibile",0,0,'L');
    $this->SetXY(32,241);
    $this->Cell(0,4,"Aliquota",0,0,'L');
    $this->SetXY(82,241);
    $this->Cell(0,4,"Imposta",0,0,'L');

    $this->SetXY(112,241);
    $this->Cell(0,4,"Totale Raee",0,0,'L');
    $this->SetXY(142,241);
    $this->Cell(0,4,"Totale Imponibile",0,0,'L');
    $this->SetXY(172,241);
    $this->Cell(0,4,"Totale Imposta",0,0,'L');

    $this->SetXY(7,267);
//  $this->Cell(0,4,"Note",0,0,'L');
    $this->Cell(0,4,'Il preventivo � valido 15 giorni dalla data di emissione.',0,0,'L');

    $this->SetXY(165,253.5);
    $this->Cell(0,4,"TOTALE PREVENTIVO",0,0,'L');

//
//Destinatario
$this->SetFont('Times','',10);
$this->SetXY(113,34);
$this->Cell(0,0,"Alla Cortese Att.ne:",0,0,'L');
$this->SetFont('Times','B',10);

$this->SetXY(113,38);
$this->Cell(0,0,$ragsoc,0,0,'L');
$this->SetFont('Times','',10);
$this->SetXY(113,49);
$this->Cell(0,0,$indirizzo,0,0,'L');
$this->SetXY(113,53);
$ccc=$cap . " - " . trim($localita) . " " . $prov;
$this->Cell(0,0,$ccc,0,0,'L');

//Altri dati
$this->SetFont('Times','B',12);
$this->SetFont('Times','B',12);
$this->SetXY(6,76);
$this->Cell(0,0,"PREVENTIVO",0,0,'L');
$this->SetFont('Times','',12);
$this->SetXY(56,76);
$this->Cell(0,0,$depdes,0,0,'L');
$this->SetXY(121,76);
$this->Cell(0,0,$agente,0,0,'L');
$this->SetXY(202,76);
$this->Cell(0,0,$this->PageNo().'/{nb}',0,0,'C');

$this->SetFont('Times','B',12);
$this->SetXY(10,87);
$this->Cell(0,0,sprintf("%8d", $num_doc),0,0,'L');
$this->SetXY(31,87);
$this->Cell(0,0,$data_doc,0,0,'L');
$this->SetFont('Times','',12);
$this->SetXY(56,87);
$this->Cell(0,0,$cliente,0,0,'L');
$this->SetXY(76,87);
$this->Cell(0,0,$partiva,0,0,'L');
$this->SetXY(103,87);
$this->Cell(0,0,$codfisc,0,0,'L');
$this->SetXY(146,87);
$this->Cell(0,0,$despag,0,0,'L');
$this->SetFont('Times','I',9);
$this->SetXY(16,98);
$this->Cell(0,0,' ',0,0,'L');
 }
}

function Footer()
{
global $tot_rec;
global $tot_rig;
global $impon1;
global $impon2;
global $iva1;
global $iva2;
global $totese;
global $ali1;
global $ali2;
global $totpre;
global $spese;
global $note;
global $note1;
global $totalerae;
global $tot_impo;
global $tot_iva;
global $desiva;
global $desiva2;
global $sw_allegati;
//
if ($impon1=="0,00") { $impon1=""; }
if ($impon2=="0,00") { $impon2=""; }
if ($iva1=="0,00") { $iva1=""; }
if ($iva2=="0,00") { $iva2=""; }
if ($ali1=="0") { $ali1=""; }
if ($ali2=="0") { $ali2=""; }
//
$num_pag=$this->PageNo();
$var_int=($tot_rec / $tot_rig);
if (is_int($var_int)) {
   $tot_pag=intval($var_int);
   }
else {
   $tot_pag=intval($var_int) + 1;
   }
if ($num_pag==$tot_pag){
	$this->SetFont('Times','',10);
	$this->SetXY(8,248);
	$this->Cell(22,0,$impon1,0,0,'R');
	$this->SetXY(32,248);
	$this->Cell(0,0,$ali1,0,0,'L');
	$this->SetXY(38,248);
	$this->Cell(0,0,$desiva,0,0,'L');
	$this->SetXY(70,248);
	$this->Cell(22,0,$iva1,0,0,'R');

	$this->SetXY(8,252);
	$this->Cell(22,0,$impon2,0,0,'R');
	$this->SetXY(32,252);
	$this->Cell(0,0,$ali2,0,0,'L');
	$this->SetXY(38,252);
	$this->Cell(0,0,$desiva2,0,0,'L');
	$this->SetXY(70,252);
	$this->Cell(22,0,$iva2,0,0,'R');

	$this->SetXY(115,248);
	$this->Cell(22,0,$totalerae,0,0,'R');
	$this->SetXY(145,248);
	$this->Cell(22,0,$tot_impo,0,0,'R');
	$this->SetXY(175,248);
	$this->Cell(22,0,$tot_iva,0,0,'R');
	$this->SetXY(170,262);
	$this->Cell(22,0,"�",0,0,'L');
	$this->SetFont('Times','B',12);
	$this->SetXY(176,262);
	$this->Cell(22,0,$totpre,0,0,'L');
	$this->SetFont('Times','',9);
    $this->SetXY(9,273);
	$this->Multicell(180,3,$note);
//  $this->Cell(22,0,'Il preventivo � valido 30 giorni dalla data di emissione.',0,0,'L');
    }
else {
    if($sw_allegati==0) {
       $this->SetXY(180,262);
	   $this->Cell(22,0,"SEGUE ===>",0,0,'L');
	   }
    }
}  //fine Footer
} //fine class PDF
////////////////////////////////////////////////stampa corpo
//$pdf=new PDF_AutoPrint("P","mm","a4");
$pdf=new PDF_AutoPrint();
$pdf->AliasNbPages();
$pdf->AddPage();

//$pdf->SetAutoPageBreak(1,98);
$pdf->SetFont('Times','',10);
$k=1;
$mm=97;
$pdf->SetXY(6,97);

for($j=0;$j<count($righe["desc"]);$j++)
     {
     $articolo=$righe["cod"][$j];
     $descri=$righe["desc"][$j];
     $quantita=$righe["qta"][$j];
     $prezzo=$righe["uni"][$j];
     $sconto=$righe["sco"][$j];
     $totale=$righe["tot"][$j];
     $raee=$righe["raee"][$j];
     //$umis=$row["umis"][$j];
     $umis="";
     $aliq=$righe["iva"][$j];
     if(trim($sconto)=="0") { $sconto=""; }
	 $quantita=number_format($quantita, 2, ',', '.');
	 $prezzo=number_format($prezzo, 4, ',', '.');
	 $totale=number_format($totale, 2, ',', '.');
	 $sconto=number_format($sconto, 2, ',', '.');

     $mm1=$mm;
     $pdf->SetFont('Times','',9);
     $pdf->SetXY(29.5,$mm);
     $pdf->MultiCell(92,4,$descri,0,'L');
     $y=$pdf->GetY();
     $a=$y-$mm;
     $pdf->SetFont('Times','',10);
     $pdf->SetXY(6,$mm1);
     $pdf->SetFont('Times','',10);
	 $pdf->Cell(23.5,4,$articolo,0,0,'L');
     $pdf->SetXY(122.5,$mm);
   	 $pdf->Cell(9,4,$umis,0,0,'L');
   	 $pdf->Cell(17,4,$quantita,0,0,'R');
   	 $pdf->Cell(22.6,4,$prezzo,0,0,'R');
   	 $pdf->Cell(9,4,$sconto,0,0,'R');
   	 $pdf->Cell(25,4,$totale,0,1,'R');
     $k=$k+1;
     $tot_rec++;
     $mm+=$a;			

        if($raee>0)
          {
           $tot_rec++;
           $totale=$raee*$righe["qta"][$j];
	       $prezzo=number_format($raee, 4, ',', '.');
	       $totale=number_format($totale, 2, ',', '.');
    	   $pdf->SetXY(6,$mm);
           $pdf->SetFont('Times','',10);
	       $pdf->Cell(23.5,4,"",0,0,'L');
           $pdf->SetFont('Times','',9);
           $pdf->Cell(93,4,"ECO CONTRIBUTO RAEE",0,0,'L');
           $pdf->SetFont('Times','',10);
   		   $pdf->Cell(9,4,$umis,0,0,'L');
   		   $pdf->Cell(17,4,$quantita,0,0,'R');
   		   $pdf->Cell(22.6,4,$prezzo,0,0,'R');
   		   $pdf->Cell(9,4,"",0,0,'R');
   		   $pdf->Cell(25,4,$totale,0,1,'R');
           $k=$k+1;
           $mm+=4;
		  }
   if($mm>220) { 
      $pdf->AddPage();
      $pdf->SetXY(6,97);
      $mm=97;
	  }
		
		}

/*
if($flag_foto==1 || $flag_scheda==1) {
  $sw_allegati=1;
  $qr="SELECT * FROM documrig LEFT JOIN articoli ON DOCR_ARTICOLO=Codice WHERE DOCR_ID=$idt ORDER BY DOCR_PROG";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(stampa allegati) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) { 
     $foto=$row["Foto"];
     $immf="/usr1/tmp/immagini/" . $foto;
     $scheda=$row["Download"];
     $imms="/usr1/tmp/immagini/" . $scheda;
     $articolo=$row["DOCR_ARTICOLO"];
     $descri=$row["DOCR_DESCRI"];
	 $p1=0;
	 $p2=0;
	 if(strlen(trim($foto)) > 0 && file_exists($immf)) { $p1=1; }
	 if(strlen(trim($scheda)) > 0 && file_exists($imms)) { $p2=1; }
     if($p1!=0||$p2!=0) {
       $pdf->AddPage();
	   }
	 if($p1==1) {
       list($width, $height, $type, $attr) = getimagesize($immf);
       $m=98;
	   if($width<$m) { $m=$width; }
	   $rapp=$m/$width;
	   $y=(297-$height*$rapp)/2;
       $pdf->Image($immf,1,$y,$m);
       $pdf->SetXY(1,$y-14);
       $pdf->Cell(0,4,$articolo,0,0,'L');
       $pdf->SetXY(1,$y-10);
       $pdf->Cell(0,4,$descri,0,0,'L');
       }
	 if($p2==1) {
       list($swidth, $sheight, $stype, $sattr) = getimagesize($imms);
       $m=98;
	   if($swidth<$m) { $m=$swidth; }
	   $rapp=$m/$swidth;
	   $y=(297-$sheight*$rapp)/2;
       $pdf->Image($imms,102,$y,$m);
	   if($p1!=1) {
          $pdf->SetXY(102,$y-14);
          $pdf->Cell(0,4,$articolo,0,0,'L');
          $pdf->SetXY(102,$y-10);
          $pdf->Cell(0,4,$descri,0,0,'L');
		  }
       }
	 }
   }
*/   
////stampa automatica////////////////////////////////////////
//$pdf->AutoPrint(true);
//
//ob_end_flush();
//$pdf->Output("/tmp/$numid.pdf");
$pdf->Output();
?>
