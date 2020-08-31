<?php
///////////fattura accompagnatoria ddt ecc.//////////////////
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
require 'fpdf_js.php';
require 'include/database.php';
require 'include/java.php';////////////////////////////////////////////////////
//   
if(isset($_GET["idt"]))
  {
  $idt=$_GET["idt"];
  }
if(isset($_GET["tipo"]))
  {
  $tipo=$_GET["tipo"];
  }
  
switch ($tipo) {
    case "1":
        $tipodoc="Doc.di Trasporto";
        break;
    case "2":
        $tipodoc="Fattura Accompagnatoria";
        break;
    case "4":
        $tipodoc="Buono di Acquisto";
        break;
    case "A":
        $tipodoc="Documento Interno";
        break;
    default:
        $tipodoc="";
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
  $codfisc=$row["cf_codfisc"];
  $banca=$row["cf_banca"];

  $dragsoc=$row["DOCT_DES_RAG_SOC"];
  $dindirizzo=$row["DOCT_DES_INDIRIZZO"];
  $dcap=$row["DOCT_DES_CAP"];
  $dlocalita=$row["DOCT_DES_LOC"];
  $dprov=$row["DOCT_DES_PR"];
  $deposito=$row["DOCT_DEPOSITO"];
  $codcom=$row["DOCT_COMMESSO_VEND"];

  $data_doc=$row["DOCT_DATA_DOC"];
  $data_doc=substr($data_doc,8,2) . "/" . substr($data_doc,5,2) . "/" . substr($data_doc,0,4);
  $num_doc=$row["DOCT_NUM_DOC"];
  $cliente=$row["DOCT_CLIENTE"];

  $modpag=$row["DOCT_COD_PAG"];
  $des_pag=leggi_tabelle("T66$modpag","DESCRIZ_PAGAMENTO");

  $agente=$row["cf_agente"];
  $des_agente=substr(leggi_tabelle("T42$agente","NOME_AGENTE"),0,7);

  $cod_cau=$row["DOCT_CAUSALE"];
  $des_cau=substr(leggi_tabelle("T40$cod_cau","DESCRIZIONE_CAUSALE"),0,7);
  
//
$depdes="";
if($deposito=="02") { $depdes="Roma, Via R.B.Bandinelli 54"; }
if($deposito=="03") { $depdes="Roma, Via del Fosso di Settebagni 10"; }
if($deposito=="05") { $depdes="Roma, Via Gregorio VII 202/208"; }
//
//////////////////////////////////////////////////
//class PDF extends FPDF_Javascript
class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=true)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
//    $param=($dialog ? 'true' : 'false');
    $script="var pp=this.getPrintParams();pp.NumCopies=3;this.print(pp);";
    $this->IncludeJS($script);
//	
}
//Page header 
function Header()
{
global $tot_rig;
global $tipodoc;
global $cliente;
global $ragsoc;
global $ragsoc2;
global $indirizzo;
global $cap;
global $localita;
global $prov;
global $des_pag;
global $codcom;
global $agente;
global $des_agente;
global $banca;
global $abi;
global $cab;
global $locbanca;
global $partiva;
global $codfisc;
global $rife1;
global $data_doc;
global $num_doc;
global $impon1;
global $impon2;
global $iva1;
global $iva2;
global $totese;
global $ali1;
global $ali2;
global $totale;
global $des1;
global $des2;
global $spese;
global $dragsoc;
global $dindirizzo;
global $dindirizzo2;
global $dcap;
global $dlocalita;
global $dprov;
global $cod_cau;
global $des_cau;
//
$tot_rig=28;
//
$this->SetTopMargin(0);
$this->SetLineWidth(0.05);
$this->Image("images/logop_GI.jpg",5,8,31);
$this->SetFont('Times','B',12);
$this->SetXY(5,29);
$this->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');
$this->SetFont('Times','',7.5);
$this->SetXY(5,34);
$this->Cell(0,4,"Cap.Soc. € 650.010,00 i.v.",0,0,'L');
$this->SetXY(5,37);
$this->Cell(0,4,"C.F. 01089330581 P.IVA 00960221000",0,0,'L');
$this->SetXY(5,40);
$this->Cell(0,4,"Sede Legale e Vendita:",0,0,'L');
$this->SetXY(32,40);
$this->Cell(0,4,"00178 ROMA - Via R.B.bandinelli, 54",0,0,'L');
$this->SetXY(32,43);
$this->Cell(0,4,"Tel 06 7932301 - Fax 06 79326161",0,0,'L');
$this->SetXY(5,46);
$this->Cell(0,4,"Show Room e Vendita:",0,0,'L');
$this->SetXY(32,46);
$this->Cell(0,4,"00138 ROMA - Via Fosso di Settebagni, 10",0,0,'L');
$this->SetXY(32,49);
$this->Cell(0,4,"Tel 06 8887526 - Fax 06 8887475",0,0,'L');
//
$this->SetXY(5,52);
$this->Cell(0,4,"Mega Store:",0,0,'L');
$this->SetXY(32,52);
$this->Cell(0,4,"00165 ROMA - Via Gregorio VII 200/208",0,0,'L');
$this->SetXY(32,55);
$this->Cell(0,4,"Tel 06 6386078 - Fax 06 6381317",0,0,'L');
//
$this->SetXY(32,58);
$this->Cell(0,4,"web: www.gallinnocenti.it   mail: info@gallinnocenti.it",0,0,'L');
//
//destinatario-destinazione
    $this->Rect(100,12,105,25);
    $this->Rect(100,40,105,25);
	
//tipo-causale-pagamento-pagina
    $this->SetFillColor(230);
    $this->Rect(5,68,50,5,"DF");
    $this->Rect(55,68,38,5,"DF");
    $this->Rect(93,68,100,5,"DF");
    $this->Rect(193,68,12,5,"DF");
    $this->Rect(5,73,50,6);
    $this->Rect(55,73,38,6);
    $this->Rect(93,73,100,6);
    $this->Rect(193,73,12,6);

//numero-data-codcli-par.iva-cod.fiscale
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
    $this->Rect(5,95,25,5,"DF");
    $this->Rect(30,95,87,5,"DF");
    $this->Rect(117,95,8,5,"DF");
    $this->Rect(125,95,17,5,"DF");
    $this->Rect(142,95,22,5,"DF");
    $this->Rect(164,95,10,5,"DF");
    $this->Rect(174,95,25,5,"DF");
    $this->Rect(199,95,6,5,"DF");

    $this->Rect(5,100,25,113);
    $this->Rect(30,100,87,113);
    $this->Rect(117,100,8,113);
    $this->Rect(125,100,17,113);
    $this->Rect(142,100,22,113);
    $this->Rect(164,100,10,113);
    $this->Rect(174,100,25,113);
    $this->Rect(199,100,6,113);

//rettangolo piede
    $this->Rect(5,215,200,70);

//trasporto-vettore
    $this->Rect(7,244,45,5,"DF");
    $this->Rect(52,244,57,5,"DF");
    $this->Rect(7,249,45,6);
    $this->Rect(52,249,57,6);

//aspetto-colli-peso
    $this->Rect(111,244,55,5,"DF");
    $this->Rect(166,244,20,5,"DF");
    $this->Rect(186,244,17,5,"DF");
    $this->Rect(111,249,55,6);
    $this->Rect(166,249,20,6);
    $this->Rect(186,249,17,6);

//firma-vettore-desti
    $this->Rect(7,255,45,5,"DF");
    $this->Rect(52,255,57,5,"DF");
    $this->Rect(7,260,45,6);
    $this->Rect(52,260,57,6);

//date ora trasporto
    $this->Rect(111,255,32,5,"DF");
    $this->Rect(111,260,32,6);

//luogo del ritiro
    $this->Rect(143,255,60,5,"DF");
    $this->Rect(143,260,60,6);

//annotazioni
    $this->Rect(7,266,196,5,"DF");
    $this->Rect(7,271,196,10);

//impo-iva-ali
    $this->Rect(7,217,102,5,"DF");
    $this->Rect(7,222,102,20);

//Totale Imponibile-Totale Iva-Totale Merce
    $this->Rect(111,217,30,5,"DF");
    $this->Rect(141,217,30,5,"DF");
    $this->Rect(171,217,32,5,"DF");
    $this->Rect(111,222,30,6);
    $this->Rect(141,222,30,6);
    $this->Rect(171,222,32,6);
	
//totale
    $this->Rect(157,230,46,5,"DF");
    $this->Rect(157,235,46,7);

//didascalie
    $this->SetFont('Times','I',9);
	$this->SetXY(101,13);
    $this->Cell(0,4,"Spett.le",0,0,'L');
	$this->SetXY(101,41);
    $this->Cell(0,4,"Destinazione Merce",0,0,'L');
	$this->SetXY(6,69);
    $this->Cell(0,4,"Tipo Documento",0,0,'L');
    $this->SetXY(56,69);
    $this->Cell(0,4,"Causale Trasporto",0,0,'L');
    $this->SetXY(94,69);
    $this->Cell(0,4,"Pagamento",0,0,'L');
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
	$this->Cell(0,4,"Agente",0,0,'L');

    $this->SetXY(6,96);
    $this->Cell(0,4,"Codice Articolo",0,0,'L');
    $this->SetXY(32,96);
    $this->Cell(0,4,"Descrizione",0,0,'L');
    $this->SetXY(118,96);
    $this->Cell(0,4,"um",0,0,'L');
    $this->SetXY(126,96);
    $this->Cell(0,4,"Quantità",0,0,'L');
    $this->SetXY(143,96);
    $this->Cell(0,4,"Prezzo Un.",0,0,'L');
    $this->SetXY(165,96);
    $this->Cell(0,4,"% Sc",0,0,'L');
    $this->SetXY(175,96);
    $this->Cell(0,4,"Importo",0,0,'L');
    $this->SetXY(199,96);
    $this->Cell(0,4,"Iva",0,0,'L');
    $this->SetXY(8,245);
    $this->Cell(0,4,"Trasporto a cura del",0,0,'L');
    $this->SetXY(53,245);
    $this->Cell(0,4,"Vettore conducente",0,0,'L');
    $this->SetXY(112,245);
    $this->Cell(0,4,"Aspetto dei beni",0,0,'L');
    $this->SetXY(167,245);
    $this->Cell(0,4,"Colli",0,0,'L');
    $this->SetXY(187,245);
    $this->Cell(0,4,"Peso",0,0,'L');
    $this->SetXY(8,256);
    $this->Cell(0,4,"Firma del vettore o conducente",0,0,'L');
    $this->SetXY(53,256);
    $this->Cell(0,4,"Firma del destinatario",0,0,'L');
    $this->SetXY(112,256);
    $this->Cell(0,4,"Inizio trasporto",0,0,'L');
    $this->SetXY(144,256);
    $this->Cell(0,4,"Luogo del Ritiro",0,0,'L');	
    $this->SetXY(8,267);
    $this->Cell(0,4,"Annotazioni",0,0,'L');
    $this->SetXY(95,267);

    $this->SetXY(7,218);
    $this->Cell(0,4,"Imponibile",0,0,'L');
    $this->SetXY(32,218);
    $this->Cell(0,4,"Aliquota",0,0,'L');
    $this->SetXY(82,218);
    $this->Cell(0,4,"Imposta",0,0,'L');

    $this->SetXY(112,218);
    $this->Cell(0,4,"Totale Merce",0,0,'L');
    $this->SetXY(142,218);
    $this->Cell(0,4,"Totale Imponibile",0,0,'L');
    $this->SetXY(172,218);
    $this->Cell(0,4,"Totale Iva",0,0,'L');

    $this->SetXY(165,231);
    $this->Cell(0,4,"TOTALE DOCUMENTO",0,0,'L');

//destinatario
$this->SetFont('Times','B',12);
$this->SetXY(101,19);
$this->Cell(0,0,$ragsoc,0,0,'L');
$this->SetFont('Times','',12);
$this->SetXY(101,23);
/*
$this->Cell(0,0,$ragsoc2,0,0,'L');
$this->SetXY(101,28);
*/
$this->Cell(0,0,$indirizzo,0,0,'L');
$this->SetXY(101,33);
$ccc=$cap . "  " . trim($localita) . "     " . $prov;
//$ccc=$cap . " - " . trim($localita);
$this->Cell(0,0,$ccc,0,0,'L');

//destinazione merce
$this->SetXY(101,48);
$this->Cell(0,0,$dragsoc,0,0,'L');
$this->SetXY(101,53);
$this->Cell(0,0,$dindirizzo,0,0,'L');
/*
$this->SetXY(101,57);
$this->Cell(0,0,$dindirizzo2,0,0,'L');
*/
$this->SetXY(101,62);
if(strlen(trim($dcap))>0)
  {
  $ccc=$dcap . "  " . trim($dlocalita) . "      " . $dprov;
  }
else
  {
  $ccc=trim($dlocalita) . "      " . $dprov;
  }
//$ccc=$dcap . " - " . trim($dlocalita);
$this->Cell(0,0,$ccc,0,0,'L');

$this->SetFont('Times','B',12);
$this->SetXY(6,76);
$this->Cell(0,0,$tipodoc,0,0,'L');
$this->SetFont('Times','',9);
$this->SetXY(56,76);
$this->Cell(0,0,substr($des_cau,0,20),0,0,'L');
$this->SetFont('Times','',12);
$this->SetXY(94,76);
$this->Cell(0,0,$des_pag,0,0,'L');
$this->SetXY(202,76);
$this->Cell(0,0,$this->PageNo().'/{nb}',0,0,'C');

$this->SetFont('Times','B',12);
$this->SetXY(6,87);
$this->Cell(0,0,sprintf("%08d", $num_doc),0,0,'L');
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
$this->Cell(0,0,$agente . "/" . $codcom,0,0,'L');
}

function Footer()
{
global $tot_rec;
global $tot_rig;
global $trasporto;
global $aspetto;
global $note;
global $codage;
global $colli;
global $datait;
global $orait;
global $impon1;
global $impon2;
global $iva1;
global $iva2;
global $totese;
global $ali1;
global $ali2;
global $totale;
global $des1;
global $des2;
global $spese;
global $tot_merce;
global $tot_impo;
global $tot_iva;
global $depdes;
global $tot_rig;	

global $nrighe;
global $tot_pag;
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
if ($num_pag==$tot_pag)
    {
	$this->SetFont('Times','',10);

	}
}
//
}
////////////////////////////////////////////////stampa corpo
//$pdf=new PDF_AutoPrint("P","mm","a4");
$pdf=new PDF_AutoPrint();
$pdf->AliasNbPages();
$pdf->AddPage();

//$pdf->SetAutoPageBreak(1,98);
$pdf->SetFont('Times','',10);
$k=1;
$mm=101;
$pdf->SetXY(6,101);

$tot_merce=0;
$tot_raee=0;
$old_ord=0;
//
//CIG E CUP
if($row["DOCT_CIG"]>"" || $row["DOCT_CUP"]>"") {
           $des="CIG: " . $row["DOCT_CIG"] . " CUP: " . $row["DOCT_CUP"];
           $pdf->SetXY(29.5,$mm);
           $pdf->MultiCell(87,4,$des,0,'L');
           $y=$pdf->GetY();
           $a=$y-$mm;
           $mm+=$a;
   }
//           
for($j=0;$j<count($righe["desc"]);$j++)
     {
     $articolo=$righe["cod"][$j];
     $descri=$righe["desc"][$j];
     $quantita=$righe["qta"][$j];
     $prezzo=$righe["uni"][$j];
     $sconto=$righe["sco"][$j];
     $totale=$righe["tot"][$j];
     $tot_merce+=$totale;
     $aliq=$righe["iva"][$j];
     $raee=$righe["raee"][$j];
     $ordine=$righe["ordine"][$j];
     $pdf->SetFont('Times','',9);
     if($ordine>0 && $old_ord!=$ordine)
       {
	   	$old_ord=$ordine;
	   	$qo="SELECT * FROM ordini WHERE ordi_id='$ordine'";
        $rso=mysql_query($qo, $con);
        while($roo=mysql_fetch_array($rso)) {
           $des="ORDINE " . $roo["ORDI_NUM_DOC"] . " del " . addrizza($roo["ORDI_DATA_DOC"],"") . " Rif:" . $roo["ORDI_RIFE"];
           $pdf->SetXY(29.5,$mm);
           $pdf->MultiCell(87,4,$des,0,'L');
           $y=$pdf->GetY();
           $a=$y-$mm;
           $mm+=$a;
		   }
	   }
     //$umis=$row["umis"][$j];
     $umis="";
     $aliq=$righe["iva"][$j];
     if(trim($sconto)=="0") { $sconto=""; }
	 $quantita=number_format($quantita, 2, ',', '.');
	 $prezzo=number_format($prezzo, 4, ',', '.');
	 $totale=number_format($totale, 2, ',', '.');
	 $sconto=number_format($sconto, 2, ',', '.');
     $mm1=$mm;
     $pdf->SetXY(29.5,$mm);
     $pdf->MultiCell(87,4,$descri,0,'L');
     $y=$pdf->GetY();
     $a=$y-$mm;
     $pdf->SetFont('Times','',10);
     $pdf->SetXY(6,$mm1);
     $pdf->SetFont('Times','',10);
	 $pdf->Cell(18.5,4,$articolo,0,0,'L');
     $pdf->SetXY(116.5,$mm);
   	 $pdf->Cell(9,4,$umis,0,0,'L');
     $pdf->Cell(17,4,$quantita,0,0,'R');
     if($tipo=="2" || $tip=="4")
       {
   	   $pdf->Cell(22,4,$prezzo,0,0,'R');
   	   $pdf->Cell(9,4,$sconto,0,0,'R');
   	   $pdf->Cell(25.5,4,$totale,0,0,'R');
       $pdf->Cell(5,4,$aliq,0,1,'R');
	   }
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
           if($tipo=="2" || $tip=="4")
             {
   		     $pdf->Cell(22,4,$prezzo,0,0,'R');
   		     $pdf->Cell(9,4,"",0,0,'R');
   		     $pdf->Cell(25.5,4,$totale,0,0,'R');
             $pdf->Cell(5,4,$aliq,0,1,'R');
		     }
           $k=$k+1;
           $mm+=4;
		  }
   if($mm>205) { 
      $pdf->AddPage();
      $pdf->SetXY(6,101);
      $mm=101;
      $pagina++;
	  }
		
		}
	
	  
    $mdv=$row["DOCT_MDV"];
    $acura="MITTENTE";
    if($mdv=="D") { $acura="DESTINATARIO"; }
    if($mdv=="V") { $acura="VETTORE"; }
    $vettore=trim($row["DOCT_VETTORE"]) . " " . $row["DOCT_IND_VETTORE"];
    $aspetto=$row["DOCT_ASPETTO"];
    $colli=$row["DOCT_COLLI"];
    $peso=$row["DOCT_PESO"];
    $peso=number_format($peso, 2, ',', '.');
    $note=$row["DOCT_NOTE"];
    $data_ritiro=addrizza($row["DOCT_DATA_RITIRO"],"") . "  " . $row["DOCT_ORA_RIT"];

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
    //spese accessorie
	$trasporto=$row["DOCT_TRASPORTO"];
    $spese=$row["DOCT_ADDVARI"];
    $effetti=$row["DOCT_BOLLI_ESIVA"];
    //$raee=$row["DOCT_IMPORTO_RAEE"];
	$installazione=$row["DOCT_INSTALLAZ"];	
	$jolly=$row["DOCT_JOLLY"];
	$noleggio=$row["DOCT_NOLEGGIO"];
	$collaudo=$row["DOCT_COLLAUDO"];
	$europallet=$row["DOCT_EUROPALLET"]; 
	$spese_incasso=$row["DOCT_SPESE_INCASSO"]; 
	


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
	$collaudo=number_format($collaudo, 2, ',', '.');
	$noleggio=number_format($noleggio, 2, ',', '.');
	$europallet=number_format($europallet, 2, ',', '.');

	$jolly=number_format($jolly, 2, ',', '.');
    $tot_raee=number_format($tot_raee, 2, ',', '.');
	$installazione=number_format($installazione, 2, ',', '.');
    if($impon2=="0,00") { $impon2=""; }
    if($impon3=="0,00") { $impon3=""; }
    if($iva2=="0,00") { $iva2=""; }
    if($iva3=="0,00") { $iva3=""; }
    
    $des1=leggi_tabelle("T44$ali1","TITOLO_ESENZIONE");
    $des2=leggi_tabelle("T44$ali2","TITOLO_ESENZIONE");
    $des3=leggi_tabelle("T44$ali3","TITOLO_ESENZIONE");
	
	
	

if($tipo=="2" || $tip=="4")
  {
	$y=$pdf->GetY();  
	if($trasporto>0){ 
		$pdf->SetXY(29.5,$y); 
		$pdf->Cell(87,4,"TRASPORTO",0,0,'L');
		$pdf->SetXY(189,$y);
		$pdf->Cell(10,4,$trasporto,0,0,'R'); 
		$y= $y+4;
	}
	if($spese>0){ 
		$pdf->SetXY(29.5,$y); 
		$pdf->Cell(87,4,"ADDEBITI VARI",0,0,'L');
		$pdf->SetXY(189,$y);
		$pdf->Cell(10,4,$spese,0,0,'R'); 
		$y= $y+4;
	}
	if($installazione>0){ 
		$pdf->SetXY(29.5,$y); 
		$pdf->Cell(87,4,"INSTALLAZIONE",0,0,'L');
		$pdf->SetXY(189,$y);
		$pdf->Cell(10,4,$installazione,0,0,'R'); 
		$y= $y+4;
	}
	
	if($jolly>0){ 
		$pdf->SetXY(29.5,$y); 
		$pdf->Cell(87,4,"LAVORAZIONE JOLLY",0,0,'L');
		$pdf->SetXY(189,$y);
		$pdf->Cell(10,4,$jolly,0,0,'R'); 
		$y= $y+4;
	}
	if($collaudo>0){ 
		$pdf->SetXY(29.5,$y); 
		$pdf->Cell(87,4,"COLLAUDO",0,0,'L');
		$pdf->SetXY(189,$y);
		$pdf->Cell(10,4,$collaudo,0,0,'R'); 
		$y= $y+4;
	}
	if($europallet>0){ 
		$pdf->SetXY(29.5,$y); 
		$pdf->Cell(87,4,"EUROPALLET",0,0,'L');
		$pdf->SetXY(189,$y);
		$pdf->Cell(10,4,$europallet,0,0,'R'); 
		$y= $y+4;
	}
	
	 
//impo-iva-ali
	$pdf->SetXY(6,225);
	$pdf->Cell(26,0,$impon1,0,0,'R');
	$pdf->Cell(6,0,$ali1,0,0,'L');
	$pdf->Cell(40,0,$des1,0,0,'L');
	$pdf->Cell(26,0,$iva1,0,0,'R');

	$pdf->SetXY(6,229);
	$pdf->Cell(26,0,$impon2,0,0,'R');
	$pdf->Cell(6,0,$ali2,0,0,'L');
	$pdf->Cell(40,0,$des2,0,0,'L');
	$pdf->Cell(26,0,$iva2,0,0,'R');

	$pdf->SetXY(6,233);
	$pdf->Cell(26,0,$impon3,0,0,'R');
	$pdf->Cell(6,0,$ali3,0,0,'L');
	$pdf->Cell(40,0,$des3,0,0,'L');
	$pdf->Cell(26,0,$iva3,0,0,'R');

//
	$pdf->SetXY(108,225);
	$pdf->Cell(30,0,$tot_merce,0,0,'R');
	$pdf->Cell(30,0,$tot_impo,0,0,'R');
	$pdf->Cell(30,0,$tot_iva,0,0,'R');
	$pdf->SetXY(176,239);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(26,0,$totale,0,0,'R');

  }

	$pdf->SetFont('Times','',9);
	$pdf->SetXY(7,253);
	$pdf->Cell(45,0,$acura,0,0,'L');
	$pdf->Cell(45,0,$vettore,0,0,'L');

	$pdf->SetXY(111,253);
	$pdf->Cell(50,0,$aspetto,0,0,'L');
	$pdf->Cell(20,0,$colli,0,0,'R');
	$pdf->Cell(20,0,$peso,0,0,'R');

	$pdf->SetXY(111,263);
	$pdf->Cell(50,0,$data_ritiro,0,0,'L');
	
	$pdf->SetXY(144,263);
	$pdf->Cell(50,0,"ROMA",0,0,'L');
	
	$pdf->SetXY(7,275);
	$pdf->Cell(50,0,$note,0,0,'L');	

/*
	$pdf->Cell(22,0,$trasporto,0,0,'R');
	$pdf->Cell(22,0,$spese,0,0,'R');
	$pdf->Cell(22,0,$effetti,0,0,'R');
	$pdf->Cell(22,0,$tot_raee,0,0,'R');
*/	
////stampa automatica////////////////////////////////////////
$pdf->IncludeJS("pp=getPrintParams(); print(pp);");
$pdf->AutoPrint(true);
//
//ob_end_flush();
$pdf->Output();
//$pdf->Output("/tmp/$numid.pdf");
?>
