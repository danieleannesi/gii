<?php
require 'fpdf_js.php';
require 'include/database.php';
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
  $qr="SELECT * FROM ordini LEFT JOIN clienti ON ORDI_CLIENTE=cf_cod WHERE ORDI_ID=$idt";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi ordini) " . mysql_error();
	mysql_close($con);
	exit;
	}
  if(mysql_num_rows($rst)==0) {
     echo "ordine non trovato";
	 exit;
     }
  $row = mysql_fetch_array($rst);
  $righe=json_decode($row["ORDI_RIGHE"],true);
  $deposito=$row["ORDI_DEPOSITO"];
  $data_doc=$row["ORDI_DATA_DOC"];
  $num_doc=$row["ORDI_NUM_DOC"];
  $num_doc=substr($data_doc,2,2) . "/" . sprintf("%06d", $num_doc);
  $cliente=$row["ORDI_CLIENTE"];
  $des_pag="";
  $modpag=$row["ORDI_COD_PAG"];
  $qt="SELECT * FROM tabelle WHERE tab_key='t66$modpag'";
  $rtt = mysql_query($qt, $con);
  while($rot = mysql_fetch_array($rtt)) { 
     $tabpag=json_decode($rot["tab_resto"],true);
     $des_pag=$tabpag["DESCRIZ_PAGAMENTO"];
	 }
  //$agente=$row["ORDI_AGENTE"];
  $agente=$row["cf_agente"];
  $des_agente="";
  $qt="SELECT * FROM tabelle WHERE tab_key='t42$agente'";
  $rtt = mysql_query($qt, $con);
  while($rot = mysql_fetch_array($rtt)) { 
     $tabage=json_decode($rot["tab_resto"],true);
     $des_agente=$tabage["NOME_AGENTE"];
	 }
/*
  $sconto=$row["sconto"];
  $iva=$row["ORDI_TRAT_IVA"];
  $totalerae=$row["ORDI_IMPORTO_RAE"];
  $flag_foto=$row["ORDI_FOTO"];
  $flag_scheda=$row["ORDI_SCHEDA"];
*/
  $data_doc=substr($data_doc,8,2) . "/" . substr($data_doc,5,2) . "/" . substr($data_doc,0,4);
$ragsoc=$row["cf_ragsoc"];
$indirizzo=$row["cf_indirizzo"];
$cap=$row["cf_cap"];
$localita=$row["cf_localita"];
$prov=$row["cf_prov"];
$partiva=$row["cf_piva"];
$spese=$row["ORDI_TRASPORTO"];
$impon1=$row["ORDI_IMPONIBILE_1"];
$impon2=$row["ORDI_IMPONIBILE_2"];
$iva1=$row["ORDI_IMPOSTA_1"];
$iva2=$row["ORDI_IMPOSTA_2"];
$ali1=$row["ORDI_ALIQUOTA_1"];
$ali2=$row["ORDI_ALIQUOTA_2"];
$totpre=$row["ORDI_TOT_ORDINE"];
$des_ragsoc=$row["ORDI_DES_RAG_SOC"];
$des_indi=$row["ORDI_DES_INDIRIZZO"];
$des_loc=$row["ORDI_DES_LOC"];
$des_cap=$row["ORDI_DES_CAP"];
$des_pr=$row["ORDI_DES_PR"];
$data_consegna=$row["ORDI_DATA_CONS"];
$note=stripcslashes($row["ORDI_NOTE"]);
//$caparra=$row["ORDI_ACC_SCALATO"];
$caparra=0;
$acconto=$row["ORDI_ACCONTO"];
$tot_impo= $impon1 + $impon2;
$tot_iva= $iva1 + $iva2;
$tot_impo=number_format($tot_impo, 2, ',', '.');
$spese=number_format($spese, 2, ',', '.');
$tot_iva=number_format($tot_iva, 2, ',', '.');
$impon1=number_format($impon1, 2, ',', '.');
$impon2=number_format($impon2, 2, ',', '.');
$iva1=number_format($iva1, 2, ',', '.');
$iva2=number_format($iva2, 2, ',', '.');
$totpre=number_format($totpre, 2, ',', '.');
$totalerae=number_format($totalerae, 2, ',', '.');
$caparra=number_format($caparra, 2, ',', '.');
$data_consegna=substr($data_consegna,8,2) . "/" . substr($data_consegna,5,2) . "/" . substr($data_consegna,0,4);
//
/*
$riferimento=substr($note,0,35);
$data_riferimento=substr($note,35,10);
$data_riferimento=substr($data_riferimento,8,2) . "/" . substr($data_riferimento,5,2) . "/" . substr($data_riferimento,0,4);
$data_consegna=substr($note,45,10);
$data_consegna=substr($data_consegna,8,2) . "/" . substr($data_consegna,5,2) . "/" . substr($data_consegna,0,4);
$des_agente=substr($note,55,25);
$des_pag=substr($note,80,30);
$note=substr($note,110,strlen($note)-110);
$kr=strlen($note)/80;
for($j=0;$j<$kr;$j++)
    {
	$riga_note[]=substr($note,$j*80,80);
	}
//
//$notes=$riferimento(12) . $data_riferimento(10) . $data_consegna(10) . $des_agente(25) . $des_pag(30) . $notes(80);
//
$qr="SELECT tabdes FROM tabelle WHERE tabcod='T44' AND tabele='$iva'";
$rtt = mysql_query($qr, $con);
if (!$rtt) {
   echo "(leggi tabelle) " . mysql_error();
   mysql_close($con);
   exit;
   }
if(mysql_num_rows($rtt)==0) {
   echo "tabella iva non trovata ($iva)";
   exit;  
   }
$rtw = mysql_fetch_array($rtt);
$desiva=$rtw["tabdes"];
*/
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
global $cliente;
global $ragsoc;
global $riferimento;
global $data_riferimento;
global $indirizzo;
global $cap;
global $localita;
global $prov;
global $modpag;
global $partiva;
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
global $des_ragsoc;
global $des_indi;
global $des_cap;
global $des_loc;
global $des_pr;
global $des_pag;
global $des_agente;
global $spedizione;
global $trasporto;
global $banca;
global $porto;
global $imballo;
global $data_consegna;
global $note;
//
$tot_rig=24;
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
$this->Cell(0,4,"00178 ROMA - Via R.B.Bandinelli, 54",0,0,'L');
$this->SetXY(32,40);
$this->Cell(0,4,"Tel 06 7932301 - Fax 06 79326161",0,0,'L');
$this->SetXY(5,43);
$this->Cell(0,4,"Show Room e Vendita:",0,0,'L');
$this->SetXY(32,43);
$this->Cell(0,4,"00138 ROMA - Via Fosso di Settebagni, 10",0,0,'L');
$this->SetXY(32,46);
$this->Cell(0,4,"Tel 06 8887526 - Fax 06 8887475",0,0,'L');
/*
$this->SetXY(32,49);
$this->Cell(0,4,"00171 ROMA - Via Tor de' Schiavi, 360A",0,0,'L');
$this->SetXY(32,52);
$this->Cell(0,4,"Tel 06 2156556 - Fax 06 2156058",0,0,'L');
*/
//
$this->SetXY(5,55);
$this->Cell(0,4,"Mega Store:",0,0,'L');
$this->SetXY(32,55);
$this->Cell(0,4,"00165 ROMA - Via Gregorio VII 200/208",0,0,'L');
$this->SetXY(32,58);
$this->Cell(0,4,"Tel 06 6386078 - Fax 06 6381317",0,0,'L');
//
$this->SetXY(32,62);
$this->Cell(0,4,"web: www.gallinnocenti.it   mail: info@gallinnocenti.it",0,0,'L');

$this->Rect(25,71,150,8);
$this->SetFillColor(220);
$this->Rect(26.5,69,150,1.5,"F");
$this->Rect(175.5,69,1.5,8,"F");
$this->SetFont('Times','B',14);
$this->SetXY(32,75);
$this->Cell(0,0,"ORDINE MATERIALI",0,0,'L');
$this->SetFont('Times','',8);
$this->SetXY(130,75);
$this->Cell(0,0,"Del",0,0,'L');

// Rect(x,y,larg,alt)
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
	
//data consegna-destinazione merce-pagina
    $this->SetFillColor(220);
    $this->Rect(5,83,40,5,"DF");
    $this->Rect(45,83,148,5,"DF");
    $this->Rect(193,83,12,5,"DF");
    $this->Rect(5,88,40,6);
    $this->Rect(45,88,148,6);
    $this->Rect(193,88,12,6);

//spedizione-trasporto-imballo
    $this->Rect(5,94,66,5,"DF");
    $this->Rect(71,94,67,5,"DF");
    $this->Rect(138,94,67,5,"DF");
    $this->Rect(5,99,66,6);
    $this->Rect(71,99,67,6);
    $this->Rect(138,99,67,6);

//porto-banca-pagamento
    $this->Rect(5,105,66,5,"DF");
    $this->Rect(71,105,67,5,"DF");
    $this->Rect(138,105,67,5,"DF");
    $this->Rect(5,110,66,6);
    $this->Rect(71,110,67,6);
    $this->Rect(138,110,67,6);

//articolo-descri-um-qua-pre-sco-imp
    $this->Rect(5,116,18,5,"DF"); //codice
    $this->Rect(23,116,113,5,"DF"); //descri
    $this->Rect(136,116,9,5,"DF"); //um
    $this->Rect(145,116,14,5,"DF"); //qua
    $this->Rect(159,116,18,5,"DF"); //prezzo
    $this->Rect(177,116,8,5,"DF"); //sconto
    $this->Rect(185,116,20,5,"DF"); //importo

    $this->Rect(5,121,18,100);
    $this->Rect(23,121,113,100);
    $this->Rect(136,121,9,100);
    $this->Rect(145,121,14,100);
    $this->Rect(159,121,18,100);
    $this->Rect(177,121,8,100);
    $this->Rect(185,121,20,100);

//note
    $this->Rect(5,223,200,4,"DF");
    $this->Rect(5,227,200,16);

//Totale Merce-Spese Trasporto-Totale iva
    $this->Rect(83,245,30,5,"DF");
    $this->Rect(113,245,30,5,"DF");
    $this->Rect(143,245,30,5,"DF");
    $this->Rect(173,245,32,5,"DF");
    $this->Rect(83,250,30,6);
    $this->Rect(113,250,30,6);
    $this->Rect(143,250,30,6);
    $this->Rect(173,250,32,6);

//totale
    $this->Rect(159,258,46,5,"DF");
    $this->Rect(159,263,46,7);

//didascalie
    $this->SetFont('Times','I',9);
	$this->SetXY(6,84);
    $this->Cell(0,4,"Data Consegna Richiesta",0,0,'L');
    $this->SetXY(46,84);
    $this->Cell(0,4,"Destinazione Merce",0,0,'L');
    $this->SetXY(194,84);
    $this->Cell(0,4,"Pagina",0,0,'L');
	
    $this->SetXY(6,95);
    $this->Cell(0,4,"Agente",0,0,'L');
    $this->SetXY(72,95);
    $this->Cell(0,4,"Trasporto",0,0,'L');
    $this->SetXY(139,95);
    $this->Cell(0,4,"Imballo",0,0,'L');
	
    $this->SetXY(6,106);
    $this->Cell(0,4,"Porto",0,0,'L');
    $this->SetXY(72,106);
    $this->Cell(0,4,"Banca",0,0,'L');
    $this->SetXY(139,106);
    $this->Cell(0,4,"Pagamento",0,0,'L');

    $this->SetFont('Times','I',8);
	$this->SetXY(6,117);
    $this->Cell(0,4,"Codice",0,0,'L');
//    $this->SetXY(31,117);
//    $this->Cell(0,4,"C.Interno",0,0,'L');
    $this->SetXY(47,117);
    $this->Cell(0,4,"Descrizione",0,0,'L');
    $this->SetXY(137,117);
    $this->Cell(0,4,"um",0,0,'L');
    $this->SetXY(146,117);
    $this->Cell(0,4,"Quantità",0,0,'L');
    $this->SetXY(160,117);
    $this->Cell(0,4,"Prezzo Un.",0,0,'L');
    $this->SetXY(177.4,117);
    $this->Cell(0,4,"%Sc",0,0,'L');
    $this->SetXY(186,117);
    $this->Cell(0,4,"Importo",0,0,'L');
    
	$this->SetFont('Times','I',9);
    $this->SetXY(7,223);
    $this->Cell(0,4,"Note",0,0,'L');

    $this->SetXY(84,246);
    $this->Cell(0,4,"Totale Merce",0,0,'L');
    $this->SetXY(114,246);
    $this->Cell(0,4,"Acconto",0,0,'L');
    $this->SetXY(144,246);
    $this->Cell(0,4,"Caparra",0,0,'L');
    $this->SetXY(174,246);
    $this->Cell(0,4,"Imposta",0,0,'L');

    $this->SetXY(167,259);
    $this->Cell(0,4,"TOTALE ORDINE",0,0,'L');
//
$this->SetFont('Times','B',12);
$this->SetXY(94,75);
$this->Cell(0,0,$num_doc,0,0,'L');
$this->SetXY(145,75);
$this->Cell(0,0,$data_doc,0,0,'L');
//
//Destinatario
$this->SetFont('Times','',10);
$this->SetXY(113,34);
$this->Cell(0,0,"Spett.le",0,0,'L');
$this->SetFont('Times','B',10);
$this->SetXY(113,38);
$this->Cell(0,0,$ragsoc,0,0,'L');
$this->SetXY(113,42);
if($data_riferimento!="00/00/2000")
  {
  $this->Cell(0,0,$riferimento . " del " . $data_riferimento,0,0,'L');
  }
else
  {
  $this->Cell(0,0,$riferimento,0,0,'L');
  }
//////////////
$this->SetFont('Times','',10);
$this->SetXY(113,49);
$this->Cell(0,0,$indirizzo,0,0,'L');
$this->SetXY(113,53);
$ccc=$cap . " - " . trim($localita) . " " . $prov;
$this->Cell(0,0,$ccc,0,0,'L');
//Altri dati
$desti=$des_indi . " - " . $des_cap . " - " . $des_loc . " - " . $des_pr;
$this->SetFont('Times','B',10);
$this->SetXY(6,91);
$this->Cell(0,0,$data_consegna,0,0,'L');
$this->SetFont('Times','',9);
$this->SetXY(46,91);
$this->Cell(0,0,$desti,0,0,'L');
$this->SetXY(202,91);
$this->Cell(0,0,$this->PageNo().'/{nb}',0,0,'C');
//
$this->SetFont('Times','',9);
$this->SetXY(6,102);
$this->Cell(0,0,$des_agente,0,0,'L');
$this->SetFont('Times','',8);
$this->SetXY(72,102);
$this->Cell(0,0,$trasporto,0,0,'L');
$this->SetFont('Times','',9);
$this->SetXY(139,102);
$this->Cell(0,0,$imballo,0,0,'L');
//
$this->SetFont('Times','',9);
$this->SetXY(6,113);
$this->Cell(0,0,$porto,0,0,'L');
$this->SetXY(72,113);
$this->Cell(0,0,$banca,0,0,'L');
$this->SetXY(139,113);
$this->Cell(0,0,$des_pag,0,0,'L');
//
//$this->SetFont('Times','',10);
//$this->SetXY(6,228);
//$this->MultiCell(180,3.5,$note,0,'L');
//
$this->SetFont('Times','',7);
$this->SetXY(6,286);
$this->Cell(0,0,"Galli Innocenti & C. S.p.A. - Via R.B.Bandinelli, 54 - 00178 ROMA - P.Iva 00960221000 - C.F. 01089330581 - C.C.I.A.A. 381995 - Cap.Soc. 650.010,00 i.v.",0,0,'C');
//
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
global $sw_allegati;
global $des_ragsoc;
global $des_indi;
global $des_cap;
global $des_loc;
global $des_pr;
global $spedizione;
global $trasporto;
global $banca;
global $porto;
global $imballo;
global $data_consegna;
global $note;
global $kr;
global $caparra;
global $acconto;
//
$this->SetFont('Times','',10);
$num_pag=$this->PageNo();
$var_int=(($tot_rec + $kr)/ $tot_rig);
if (is_int($var_int)) {
   $tot_pag=intval($var_int);
   }
else {
   $tot_pag=intval($var_int) + 1;
   }
if ($num_pag==$tot_pag){
    $this->SetXY(40,267);
    $this->Cell(0,0,"FIRMA DEL CLIENTE PER ACCETTAZIONE",0,0,'L');

	$this->SetXY(85,253);
	$this->Cell(22,0,$tot_impo,0,0,'R');
	$this->SetXY(115,253);
	$this->Cell(22,0,$acconto,0,0,'R');
	$this->SetXY(145,253);
	$this->Cell(22,0,$caparra,0,0,'R');
	$this->SetXY(175,253);
	$this->Cell(22,0,$tot_iva,0,0,'R');
	
	$this->SetXY(170,267);
	$this->Cell(22,0,"€",0,0,'L');
	$this->SetFont('Times','B',12);
	$this->SetXY(176,267);
	$this->Cell(22,0,$totpre,0,0,'L');
    }
else {
    if($sw_allegati==0) {
       $this->SetXY(180,267);
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
$pdf->SetFont('Times','',8);
$k=1;
$pdf->SetXY(5.5,122);
/*
//legge righe
  $prog=0; 
  $qr="SELECT * FROM documrig LEFT JOIN articoli ON DOCR_ARTICOLO=Codice WHERE DOCR_ID=$idt ORDER BY DOCR_PROG";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi documrig) " . mysql_error();
	mysql_close($con);
	exit;
	}
  $tot_rec=mysql_num_rows($rst);
  while($row = mysql_fetch_array($rst)) { 
*/
$tot_rec=count($righe["desc"]) + 1;
//
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
     	
/*
     $codfor=$row["DOCR_ARTICOLO_FO"];
     $articolo=$row["DOCR_ARTICOLO"];
     $descri=$row["DOCR_DESCRI"];
     $quantita=$row["DOCR_QUANTITA"];
     $prezzo=$row["DOCR_IMPORTO_EU"];
     $sconto=$row["DOCR_SCONTO"];
     $totale=$row["DOCR_TOTALE_EU"];
     $rae=$row["DOCR_RAE"];
     $umis=$row["umis"];
     $umis1=$row["DOCR_UM"];
	 if(strlen(trim($umis))==0) { $umis=$umis1; }
     $aliq=$row["DOCR_IVA"];
     $estesa=$row["DOCR_ESTESA"];
	 $desestesa=$row["desestesa"];
     if($estesa==1 && strlen(trim($desestesa))>0) {
	    $descri=$desestesa;
        }
*/        
     if(trim($sconto)=="0") { $sconto=""; }
	 $quantita=number_format($quantita, 2, ',', '.');
	 $prezzo=number_format($prezzo, 4, ',', '.');
	 $totale=number_format($totale, 2, ',', '.');
	 $sconto=number_format($sconto, 2, ',', '.');
	 
	 $dicitura = "CONSEGNA BORDO CAMION AL NUMERO CIVICO.";
	 $dicitura_2 = "LA DATA DI CONSEGNA NON PUO' ESSERE GARANTITA, E' PURAMENTE INDICATIVA ESSENDO SUBORDINATA ALLE SPEDIZIONI DELLE SINGOLE CASE PRODUTTRICI E POTREBBE CAMBIARE A SECONDA DELLE DISPONIBILITA'";
//
/////////////divide descri in righe///////////////////////
     $pdf->SetFont('Times','',8);
	 unset ($riga);
     $le=$pdf->GetStringWidth($descri);
     if($le>91) {
        $parole=explode(" ",$descri);
        $r=0;
        $off=0;
        while($r<count($parole)) {
		  $des="";
	      for($j=$off;$j<count($parole);$j++) {
		      $des=$des . $parole[$j] . " ";
              $lu=$pdf->GetStringWidth($des);
			  if($lu>113) { break; }
		      }
		  $des="";	
		  $y=$j;
	      for($j=$off;$j<$y;$j++) {
		      $des=$des . $parole[$j] . " ";
              }
		  $riga[]=$des;
		  $r=$j;
		  $off=$j;
	      }
	    }	  
	 else {
	    $riga[]=$descri;
	    }	
/////////fine divide descri in righe///////////////////////
//
        $conta=count($riga);
        $tot_rec=$tot_rec + $conta - 1;
        if($conta==1) {
    	   $pdf->SetX(5.5);
           $pdf->SetFont('Times','',8);
	       $pdf->Cell(17.5,4,$articolo,0,0,'L');
           $pdf->Cell(114,4,$riga[0],0,0,'L');
   		   $pdf->Cell(9,4,$umis,0,0,'L');
   		   $pdf->Cell(13,4,$quantita,0,0,'R');
   		   $pdf->Cell(18,4,$prezzo,0,0,'R');
   		   $pdf->Cell(8.5,4,$sconto,0,0,'R');
   		   $pdf->Cell(19,4,$totale,0,1,'R'); 
           $k=$k+1;
		    
			   
 		} else {
    	   $pdf->SetX(5.5);
           $pdf->SetFont('Times','',8);
	       $pdf->Cell(17.5,4,$articolo,0,0,'L');
           $pdf->SetFont('Times','',9);
           for($j=0;$j<$conta;$j++) {
              $pdf->SetX(29.5);
              $pdf->Cell(114,4,$riga[$j],0,1,'L');
              $k=$k+1;
              if($k>$tot_rig) { 
      		    $k=1;
      		    $pdf->AddPage(); 
      		    $pdf->SetXY(5.5,122);
			    }
              }
      	   $y=$pdf->GetY();
		   $y=$y-4;
           $pdf->SetXY(136.5,$y);
           $pdf->SetFont('Times','',8);
   		   $pdf->Cell(9,4,$umis,0,0,'L');
   		   $pdf->Cell(13,4,$quantita,0,0,'R');
   		   $pdf->Cell(18,4,$prezzo,0,0,'R');
   		   $pdf->Cell(8.5,4,$sconto,0,0,'R');
   		   $pdf->Cell(19,4,$totale,0,1,'R');
		  
	   }
		
   		if($k>$tot_rig) { 
      		$k=1;
      		$pdf->AddPage(); 
      		$pdf->SetXY(5.5,122);
			}
   }
		
		$pdf->Ln();
		$y=$pdf->GetY(); 
		$pdf->SetX(23,$y);
		$pdf->SetFont('Times','',6);
	    $pdf->Multicell(110,2,$dicitura,0,'L');   
		$y=$y+10;
		$pdf->SetX(23,$y);
		$pdf->Multicell(110,2,$dicitura_2,0,'L');   
		
////////////////////////////////////////////   
//stampa righe note
   $pdf->SetXY(6,228);
   $pdf->MultiCell(180,3.5,$note,0,'L');   
/*
$j1=0;
if(isset($riga_note)&&substr($riga_note[0],0,6)=="C.I.G.")
  {
   $pdf->SetX(22.9);
   $pdf->Cell(114,4,$riga_note[0],0,1,'L');
   $j1=1;
  }
$pdf->SetFont('Times','B',5.7);
for($j=$j1;$j<$kr;$j++)
   {
   $pdf->SetX(22.9);
   $pdf->Cell(114,4,$riga_note[$j],0,1,'L');
   $k=$k+1;   
   if($k>$tot_rig) { 
      $k=1;
      $pdf->AddPage(); 
      $pdf->SetXY(22.9,122);
	  }
    }
*/
/////////////////////////////////////////////
////stampa automatica////////////////////////////////////////
//$pdf->AutoPrint(true);
//
//ob_end_flush();
//$pdf->Output("/tmp/$numid.pdf");
$pdf->Output();
?>
