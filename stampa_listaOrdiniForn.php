<?php
require 'fpdf.php';
require 'include/database.php';

function AutoPrint($dialog=false)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

$deposito = $_GET["deposito"];
$evasi = $_GET["evaso"];
$utente = $_GET["utente"];
$fornitore = $_GET["fornitore"];
$data_da = date_format(date_create_from_format('d/m/Y', $_GET["data_da"]), 'Y-m-d');
$data_a =  date_format(date_create_from_format('d/m/Y', $_GET["data_a"]), 'Y-m-d');
 
$sql="SELECT * FROM ordinifo INNER JOIN clienti ON cf_cod = ORDI_FORNITORE ";
$where = " WHERE `ORDI_DEPOSITO` =  ".$deposito."  and `ORDI_DATA_DOC` BETWEEN '".$data_da."' AND '".$data_a."' ";
if($evasi == "E"){
    $where = $where." AND ORDI_EVASO LIKE 'E' ";
} else {
    $where = $where." AND (ORDI_EVASO IS NULL OR ORDI_EVASO = '') ";
}
if($fornitore){
    $where = $where. " AND ORDI_FORNITORE LIKE '".$fornitore."' ";
}
if($utente){
    $where = $where. " AND ORDI_UTENTE LIKE '".$utente."' ";
}
$sql = $sql.$where;
//echo $sql; 
$today = date("d-m-Y");
$rst=mysql_query($sql,$con);
  
$pdf = new FPDF();
$pdf->AddPage("L");  
$pdf->SetFont('Arial','',10);
$pdf->SetTopMargin(10);
$pdf->SetLineWidth(0.05);   
$pdf->SetXY(5,10);
$pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L'); 
$pdf->SetXY(250,10);
$pdf->Cell(0,4,$today,0,0,'L'); 
$pdf->SetXY(105,15);
$pdf->Cell(0,4,"STAMPA ORDINI FORNITORI",0,0,'L'); 
    
while($row = mysql_fetch_assoc($rst)) {

  $deposito=$row["ORDI_DEPOSITO"];
  $data_doc=$row["ORDI_DATA_DOC"];
  $num_doc=$row["ORDI_NUM_DOC"];
  $num_doc=substr($data_doc,2,2) . "/" . sprintf("%06d", $num_doc);
  $cliente=$row["ORDI_CLIENTE"];
  $des_pag="";
  $stato= $row["ORDI_EVASO"];
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
    $tot_impo=$row["TOT_IMPONIBILE"];
    $tot_iva=$row["TOT_IMPOSTA"];
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
    $tot_rig=24;
    $y = $pdf->getY();
    $pdf->SetXY(5,$y+5);
    $pdf->Cell(0,4,"DEPOSITO: ".$deposito,0,0,'L'); 
    $pdf->SetXY(5,$y+15);
    $pdf->Cell(0,4,"FORNITORE:".$ragsoc,0,0,'L'); 
    $pdf->SetXY(5,$y+20);
    $pdf->Cell(0,4,"ORDINE N. ".$num_doc,0,0,'L'); 
    $pdf->SetXY(55,$y+20);
    $pdf->Cell(0,4,"del ".$data_doc,0,0,'L'); 
    $pdf->SetXY(155,$y+20);
    $pdf->Cell(0,4,"Data di consegna ".$data_consegna,0,0,'L'); 
    $pdf->SetXY(5,$y+25);
    $pdf->Cell(0,4,"Luogo di consegna: ".$des_indi."  ".$des_loc."   ".$des_cap,0,0,'L'); 
    $pdf->SetXY(5,$y+30);
    $pdf->Cell(0,4,"Agente: ".$agente." - ".$des_agente,0,0,'L'); 
    $pdf->SetXY(105,$y+30);
    $pdf->Cell(0,4,"Pagamento: ".$modpag." ".$des_pag,0,0,'L'); 
    $pdf->SetXY(5,$y+35);
    $pdf->Cell(0,4,"Articolo",0,0,'L'); 
    $pdf->SetXY(35,$y+35);
    $pdf->Cell(0,4,"Descrizione",0,0,'L'); 
    $pdf->SetXY(35,$y+35);
    $pdf->Cell(0,4,"Descrizione",0,0,'L'); 
    $pdf->SetXY(140,$y+35);
    $pdf->Cell(0,4,"Um",0,0,'L');  
    $pdf->SetXY(150,$y+35);
    $pdf->Cell(0,4,"Qta",0,0,'L');   
    $pdf->SetXY(162,$y+35);
    $pdf->Cell(0,4,"Prezzo",0,0,'L');   
    $pdf->SetXY(178,$y+35);
    $pdf->Cell(0,4,"Sconto",0,0,'L');  
    $pdf->SetXY(192,$y+35);
    $pdf->Cell(0,4,"Tot riga",0,0,'L');  
    $pdf->SetXY(210,$y+35);
    $pdf->Cell(0,4,"IVA",0,1,'L'); 
 
    $righe=json_decode($row["ORDI_RIGHE"],true);
    // INIZIO STAMPA RIGHE ORDINE
    for($j=0;$j<count($righe["desc"]);$j++)    { 
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
        
    
        $y = $pdf->getY(); 
        $pdf->SetXY(5,$y); 
        $pdf->Cell(22,4,$articolo,0,0,'L');
        $pdf->Cell(110,4, $descri,0,0,'L');
        $pdf->Cell(10,4,$umis,0,0,'R');
        $pdf->Cell(12,4,$quantita,0,0,'R');
        $pdf->Cell(18,4,$prezzo,0,0,'R');
        $pdf->Cell(13,4,$sconto,0,0,'R');
        $pdf->Cell(20,4,$totale,0,0,'R'); 
        $pdf->Cell(10,4,$aliq,0,0,'L');  
        if($stato == "E"){
            $pdf->Cell(8,4,"EV",0,1,'L');  
        } else {
            $pdf->Cell(8,4," ",0,1,'L');  
        }
 
        
    }
 
         $y = $pdf->getY(); 
        
        $pdf->SetXY(195,$y); 
        $pdf->Cell(0,4,"---------",0,0,'L'); 
        $pdf->SetXY(180,$y+3); 
        $pdf->Cell(0,4,"Totale: ",0,0,'L'); 
        $pdf->SetXY(195,$y+3); 
        $pdf->Cell(0,4,$tot_impo,0,0,'L'); 
        $pdf->SetXY(180,$y+8); 
        $pdf->Cell(0,4,"IVA: ",0,0,'L'); 
        $pdf->SetXY(195,$y+8); 
        $pdf->Cell(0,4,$tot_iva,0,0,'L');
        $pdf->SetXY(195,$y+12); 
        $pdf->Cell(0,4,"---------",0,0,'L');  
        $pdf->SetXY(180,$y+15); 
        $pdf->Cell(0,4,"TOT. ",0,0,'L'); 
        $pdf->SetXY(195,$y+15); 
        $pdf->Cell(0,4,$totpre,0,0,'L'); 
  
     
    //fine righe ordine
   
  
    $y = $pdf->getY();
    $pdf->SetXY(5,$y+4);
    $pdf->Cell(0,4,"***************************************************************************************************************************************************************************************",0,0,'L'); 
    $pdf->SetTopMargin(15);
    $y = $pdf->getY();
    if($y>=150){
        $pdf->AddPage("L"); 
        $pdf->SetFont('Arial','',10);
        $pdf->SetTopMargin(15);
        $pdf->SetLineWidth(0.05);   
        $pdf->SetXY(5,10);
        $pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L'); 
        $pdf->SetXY(250,10);
        $pdf->Cell(0,4,$depdes,0,0,'L'); 
    }
}


$pdf->Output();



?>