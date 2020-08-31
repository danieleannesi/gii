<?php
require 'fpdf_js.php';
require 'include/database.php';
//
function leggi_articolo($articolo, $fornitore)
{
	global $con;
    $qr="SELECT * FROM mgforn WHERE mgf_codart='$articolo' AND mgf_codfor='$fornitore'";
    
    file_put_contents("testf.txt",$qr);
    
    $rst = mysql_query($qr, $con);
	while($row = mysql_fetch_array($rst)) { 
  	  $ret=$row;
  	  }
  	return $ret;
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
//$idt=3392;
//
$spese_rae=0;
$spese_tra=0;
$spese_ins=0;
$spese_col=0;
//
//legge documento
  $qr="SELECT * FROM ordinifo LEFT JOIN clienti ON ORDI_FORNITORE=cf_cod WHERE ORDI_ID=$idt";
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
  $fornitore=$row["ORDI_FORNITORE"];
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

//leggi tabella porto
$porto=$row["cf_porto"];
$des_porto="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't52$porto'";
$rsp = mysql_query($qr, $con);
while($rop = mysql_fetch_array($rsp)) {
     $tab_resto=json_decode($rop["tab_resto"],true);
     $des_porto=$tab_resto["DESCRIZIONE"];
	 }
$data_doc=substr($data_doc,8,2) . "/" . substr($data_doc,5,2) . "/" . substr($data_doc,0,4);
$ragsoc=$row["cf_ragsoc"];
$indirizzo=$row["cf_indirizzo"];
$cap=$row["cf_cap"];
$localita=$row["cf_localita"];
$prov=$row["cf_prov"];
$partiva=$row["cf_piva"];
$banca=$row["cf_banca"];
$spese_tra=$row["ORDI_TRASPORTO"];
$spese_ins=$row["ORDI_INSTALLAZ"];
$spese_col=$row["ORDI_COLLAUDO"];
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
$des_spedizione=$row["ORDI_DES_SPEDIZIONE"];
$des_trasporto=$row["ORDI_DES_TRASPORTO"];
$des_imballo=$row["ORDI_DES_IMBALLO"];
$data_consegna=$row["ORDI_DATA_CONS"];
$data_consegna=substr($data_consegna,8,2) . "/" . substr($data_consegna,5,2) . "/" . substr($data_consegna,0,4);
$note=stripcslashes($row["ORDI_NOTE"]);
//$caparra=$row["ORDI_ACC_SCALATO"];
$caparra=0;
$acconto=$row["ORDI_ACCONTO"];
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
global $fornitore;
global $ragsoc;
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
global $des_loc;
global $des_cap;
global $des_spedizione;
global $trasporto;
global $banca;
global $des_pag;
global $des_porto;
global $des_imballo;
global $des_trasporto;
global $data_consegna;
global $note;
global $email;
//
$tot_rig=24;
$depdes="";
if($deposito=="02") { $depdes="Via R.B.Bandinelli"; }
if($deposito=="03") { $depdes="Via del Fosso di Settebagni"; }
//
$this->SetTopMargin(0);
$this->SetLineWidth(0.05);
$this->Image("images/logop_GI.jpg",05,10,31);
$this->SetFont('Times','B',12);
$this->SetXY(5,31);
$this->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');
$this->SetFont('Times','',8);

if($sw_allegati==0) {

$this->SetXY(5,37);
$this->Cell(0,4,"Ufficio e Vendita:",0,0,'L');
$this->SetXY(32,37);
$this->Cell(0,4,"00178 ROMA - Via R.B.Bandinelli, 54",0,0,'L');
$this->SetXY(32,41);
$this->Cell(0,4,"Tel 06 7932301 - Fax 06 79326161",0,0,'L');
$this->SetXY(5,45);
$this->Cell(0,4,"Show Room e Vendita:",0,0,'L');
$this->SetXY(32,45);
$this->Cell(0,4,"00138 ROMA - Via Fosso di Settebagni, 10",0,0,'L');
$this->SetXY(32,49);
$this->Cell(0,4,"Tel 06 8887526 - Fax 06 8887475",0,0,'L');
$this->SetXY(32,53);
$this->Cell(0,4,"web: www.gallinnocenti.it   mail: info@gallinnocenti.it",0,0,'L');
//
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

//art_forni-articolo-descri-um-qua-pre-sco-imp
    $this->Rect(5,116,25,5,"DF");
    $this->Rect(30,116,16,5,"DF");
    $this->Rect(46,116,90,5,"DF");
    $this->Rect(136,116,9,5,"DF");
    $this->Rect(145,116,14,5,"DF");
    $this->Rect(159,116,18,5,"DF");
    $this->Rect(177,116,8,5,"DF");
    $this->Rect(185,116,20,5,"DF");

    $this->Rect(5,121,25,100);
    $this->Rect(30,121,16,100);
    $this->Rect(46,121,90,100);
    $this->Rect(136,121,9,100);
    $this->Rect(145,121,14,100);
    $this->Rect(159,121,18,100);
    $this->Rect(177,121,8,100);
    $this->Rect(185,121,20,100);

//Totali
    $this->Rect(05,223,28,5,"DF");
    $this->Rect(33,223,28,5,"DF");
    $this->Rect(61,223,28,5,"DF");
    $this->Rect(89,223,28,5,"DF");
    $this->Rect(117,223,28,5,"DF");
    $this->Rect(145,223,29,5,"DF");
    $this->Rect(174,223,31,5,"DF");
    $this->Rect(05,228,28,6);
    $this->Rect(33,228,28,6);
    $this->Rect(61,228,28,6);
    $this->Rect(89,228,28,6);
    $this->Rect(117,228,28,6);
    $this->Rect(145,228,29,6);
    $this->Rect(174,228,31,6);

//note
    $this->Rect(5,238,200,4,"DF");
    $this->Rect(5,242,200,30);

//didascalie
    $this->SetFont('Times','I',9);
	$this->SetXY(6,84);
    $this->Cell(0,4,"Data Spedizione Richiesta",0,0,'L');
    $this->SetXY(46,84);
    $this->Cell(0,4,"Destinazione Merce",0,0,'L');
    $this->SetXY(194,84);
    $this->Cell(0,4,"Pagina",0,0,'L');
	
    $this->SetXY(6,95);
    $this->Cell(0,4,"Spedizione",0,0,'L');
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
    $this->SetXY(31,117);
    $this->Cell(0,4,"C.Interno",0,0,'L');
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

    $this->SetXY(06,223.5);
    $this->Cell(0,4,"Totale Merce",0,0,'L');
    $this->SetXY(34,223.5);
    $this->Cell(0,4,"Raee",0,0,'L');
    $this->SetXY(62,223.5);
    $this->Cell(0,4,"Spese Trasporto",0,'L');
    $this->SetXY(90,223.5);
    $this->Cell(0,4,"Spese Installazione",0,0,'L');
    $this->SetXY(118,223.5);
    $this->Cell(0,4,"Spese Collaudo",0,0,'L');
    $this->SetXY(146,223.5);
    $this->Cell(0,4,"Imposta",0,0,'L');
    $this->SetXY(175,223.5);
    $this->Cell(0,4,"TOTALE ORDINE",0,0,'L');

	$this->SetFont('Times','I',9);
    $this->SetXY(7,238.5);
    $this->Cell(0,4,"Note",0,0,'L');

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
$this->SetXY(183,38);
$this->Cell(0,0,$fornitore,0,0,'L');
$this->SetFont('Times','B',10);
$this->SetXY(113,42);
$this->Cell(0,0,$ragsoc,0,0,'L');
$this->SetFont('Times','',10);
$this->SetXY(113,49);
$this->Cell(0,0,$indirizzo,0,0,'L');
$this->SetXY(113,53);
$ccc=$cap . " - " . trim($localita) . " " . $prov;
$this->Cell(0,0,$ccc,0,0,'L');
//Altri dati
$desti=$des_ragsoc ." - " . $des_indi . " - " . $des_cap . " - " . $des_loc;
$this->SetFont('Times','B',10);
$this->SetXY(6,91);
$this->Cell(0,0,$data_consegna,0,0,'L');
$this->SetFont('Times','',9);
$this->SetXY(46,91);
$this->Cell(0,0,$desti,0,0,'L');
$this->SetXY(202,91);
$this->Cell(0,0,$this->PageNo().'/{nb}',0,0,'C');
//
$this->SetFont('Times','',10);
$this->SetXY(6,252);
$this->MultiCell(180,3.5,$note,0,'L');
//
$this->SetFont('Times','',9);
$this->SetXY(6,102);
$this->Cell(0,0,$des_spedizione,0,0,'L');
$this->SetFont('Times','',8);
$this->SetXY(72,102);
$this->Cell(0,0,$des_trasporto,0,0,'L');
$this->SetFont('Times','',9);
$this->SetXY(139,102);
$this->Cell(0,0,$des_imballo,0,0,'L');
//
$this->SetFont('Times','',9);
$this->SetXY(6,113);
$this->Cell(0,0,$des_porto,0,0,'L');
$this->SetXY(72,113);
$this->Cell(0,0,$banca,0,0,'L');
$this->SetXY(139,113);
$this->Cell(0,0,$des_pag,0,0,'L');
//
$this->SetXY(6,245);
$this->Cell(0,0,"Vi preghiamo darci conferma per accettazione",0,0,'L');
$this->SetXY(6,249);
$this->Cell(0,0,"Per lo scarico contattare M.Colonna - 067932301 - m.colonna@gallinnocenti.it",0,0,'L');
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
global $spedizione;
global $trasporto;
global $banca;
global $porto;
global $imballo;
global $data_consegna;
global $note;
global $spese_rae;
global $spese_tra;
global $spese_ins;
global $spese_col;
global $impon1;
global $impon2;
global $iva1;
global $iva2;
global $totpre;
global $caparra;
//
$tot_impo= $impon1 + $impon2 - $spese_rae - $spese_tra - $spese_ins - $spese_col;
$tot_iva= $iva1 + $iva2;
$tot_impo=number_format($tot_impo, 2, ',', '.');
$tot_iva=number_format($tot_iva, 2, ',', '.');
$impon1=number_format($impon1, 2, ',', '.');
$impon2=number_format($impon2, 2, ',', '.');
$iva1=number_format($iva1, 2, ',', '.');
$iva2=number_format($iva2, 2, ',', '.');
$totpre=number_format($totpre, 2, ',', '.');
$caparra=number_format($caparra, 2, ',', '.');
//
$spese_rae=number_format($spese_rae, 2, ',', '.');
$spese_tra=number_format($spese_tra, 2, ',', '.');
$spese_ins=number_format($spese_ins, 2, ',', '.');
$spese_col=number_format($spese_col, 2, ',', '.');
//
$this->SetFont('Times','',10);
$num_pag=$this->PageNo();
$var_int=($tot_rec / $tot_rig);
if (is_int($var_int)) {
   $tot_pag=intval($var_int);
   }
else {
   $tot_pag=intval($var_int) + 1;
   }
if ($num_pag==$tot_pag){

    $this->Rect(05,228,28,6);
    $this->Rect(33,228,28,6);
    $this->Rect(61,228,28,6);
    $this->Rect(89,228,28,6);
    $this->Rect(117,228,28,6);
    $this->Rect(145,228,29,6);
    $this->Rect(174,228,31,6);
	
	$this->SetXY(06,231);
	$this->Cell(22,0,$tot_impo,0,0,'R');
	$this->SetXY(34,231);
	$this->Cell(22,0,$spese_rae,0,0,'R');
	$this->SetXY(62,231);
	$this->Cell(22,0,$spese_tra,0,0,'R');
	$this->SetXY(90,231);
	$this->Cell(22,0,$spese_ins,0,0,'R');
	$this->SetXY(118,231);
	$this->Cell(22,0,$spese_col,0,0,'R');
	$this->SetXY(146,231);
	$this->Cell(22,0,$tot_iva,0,0,'R');
	$this->SetXY(175,231);
	$this->Cell(22,0,"€",0,0,'L');
	$this->SetFont('Times','B',12);
	$this->SetXY(177,231);
	$this->Cell(22,0,$totpre,0,0,'R');
    }
else {
    if($sw_allegati==0) {
       $this->SetXY(177,231);
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

$pdf->SetFont('Times','',8);
$k=1;
$pdf->SetXY(5.5,122);
$tot_rec=count($righe["desc"]) + 1;
//
for($j=0;$j<count($righe["desc"]);$j++)
     {
     $articolo=$righe["cod"][$j];
     $art=leggi_articolo($articolo,$fornitore);
     $codfor=$art["mgf_codprod"];
     $descri=$righe["desc"][$j];
     $quantita=number_format($righe["qta"][$j], 2, ',', '.');
     $prezzo=number_format($righe["uni"][$j], 4, ',', '.');
     $sconto=$righe["sco"][$j];
     $totale=number_format($righe["tot"][$j], 2, ',', '.');
     $raee=$righe["raee"][$j];
     $spese_rae+=$raee;
     //$umis=$row["umis"][$j];
     $umis="";
     $aliq=$righe["iva"][$j];     	
//
/////////////divide descri in righe///////////////////////
     $pdf->SetFont('Times','',8);
	 unset ($riga);
     $le=$pdf->GetStringWidth($descri);
     $parole=explode(" ",$descri);
     $cp=count($parole);
     if($le>91&&$cp>1) {
        $r=0;
        $off=0;
        while($r<$cp) {
		  $des="";
	      for($j=$off;$j<count($parole);$j++) {
		      $des=$des . $parole[$j] . " ";
              $lu=$pdf->GetStringWidth($des);
			  if($lu>91) { break; }
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
	       $pdf->Cell(24.5,4,$codfor,0,0,'L');
	       $pdf->Cell(15.5,4,$articolo,0,0,'L');
           $pdf->Cell(91,4,$riga[0],0,0,'L');
   		   $pdf->Cell(9,4,$umis,0,0,'L');
		   if($totale>0||$quantita>0) {
   		     $pdf->Cell(13,4,$quantita,0,0,'R');
   		     $pdf->Cell(18,4,$prezzo,0,0,'R');
   		     $pdf->Cell(8.5,4,$sconto,0,0,'R');
   		     $pdf->Cell(19,4,$totale,0,1,'R');
			 }
		   else {
   		     $pdf->Cell(19,4,"",0,1,'R');
		     }
           $k=$k+1;
		   }
		 else {
    	   $pdf->SetX(5.5);
           $pdf->SetFont('Times','',8);
	       $pdf->Cell(24.5,4,$codfor,0,0,'L');
	       $pdf->Cell(15.5,4,$articolo,0,0,'L');
           for($j=0;$j<$conta;$j++) {
              $pdf->SetX(45.5);
              $pdf->Cell(91,4,$riga[$j],0,1,'L');
              $k=$k+1;
              if($k>$tot_rig) { 
      		    $k=1;
      		    $pdf->AddPage(); 
      		    $pdf->SetXY(5.5,122);
			    }
              }
      	   $y=$pdf->GetY();
		   $y=$y-4;
           $pdf->SetXY(122.5,$y);
           $pdf->SetFont('Times','',8);
   		   $pdf->Cell(9,4,$umis,0,0,'L');
		   if($totale>0||$quantita>0) {
                     $pdf->Cell(13,4,$quantita,0,0,'R');
   		     $pdf->Cell(18,4,$prezzo,0,0,'R');
   		     $pdf->Cell(8.5,4,$sconto,0,0,'R');
   		     $pdf->Cell(19,4,$totale,0,1,'R');
			 }
             else {
   		       $pdf->Cell(19,4,"",0,1,'R');
		       }
		   }

   		if($k>$tot_rig) { 
      		$k=1;
      		$pdf->AddPage(); 
      		$pdf->SetXY(5.5,122);
			}
   }
//
////stampa automatica////////////////////////////////////////
//$pdf->AutoPrint(true);
//
$pdf->Output();
//
/*
exec("cp /tmp/$numid.pdf /usr1/tmp/ORDINIFO/$nome_file.pdf");
//if($sw_mail=="1" && strlen(trim($email))>0) {
if($sw_mail!="0") {
   system("mandamail /tmp/$numid.pdf $sw_mail $nome_file");
   }
*/
?>
