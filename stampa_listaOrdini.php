<?php
require 'fpdf.php';
require 'cellfit.php';
require 'include/database.php';
require 'calcola_medio.php';
//
function AutoPrint($dialog=false)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}

$deposito = $_GET["deposito"];
$cliente = $_GET["cliente"];
$evaso = $_GET["evaso"];
$agente1 = $_GET["agente"];
$data_da = date_format(date_create_from_format('d/m/Y', $_GET["data_da"]), 'Y-m-d');
$data_a =  date_format(date_create_from_format('d/m/Y', $_GET["data_a"]), 'Y-m-d');
/*
if($deposito=="02") { $depdes="Via R.B.Bandinelli"; }
    if($deposito=="03") { $depdes="Via del Fosso di Settebagni"; }
    if($deposito=="04") { $depdes="Via Tor de' Schiavi"; }
*/
$totale_impo=0;    
$totale_iva=0;    
$totale_tot=0;    
$dal="2020-01-01";
$al="2020-12-31";
$aord=g_ordini_per_articolo($dal,$al,"false");
$aordfo=g_ordinifo_per_articolo($dal,$al);
//
$q1="";
if($cliente>""){
  $q1="AND ORDI_CLIENTE='$cliente'";
  }   
$sql="SELECT * FROM ordini INNER JOIN clienti ON cf_cod = ordi_cliente ";
$where = " WHERE `ORDI_DEPOSITO` =  ".$deposito."  and `ORDI_DATA_DOC` BETWEEN '".$data_da."' AND '".$data_a."' $q1 ORDER BY ORDI_DATA_DOC, ORDI_NUM_DOC";
$sql = $sql.$where;
//echo $sql; 
$today = date("d-m-Y");
$rst=mysql_query($sql,$con);
  
$pdf = new FPDF_CellFit();
$pdf->AddPage("L","A4"); 
$pdf->SetFont('Arial','',10);
$pdf->SetTopMargin(5);
$pdf->SetLineWidth(0.05);   
$pdf->SetXY(5,10);
$pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L'); 
$pdf->SetXY(250,10);
$pdf->Cell(0,4,$today,0,0,'L'); 
$pdf->SetXY(105,15);
$pdf->Cell(0,4,"STAMPA ORDINI",0,0,'L'); 
    
while($row = mysql_fetch_assoc($rst)) {

  $righe=json_decode($row["ORDI_RIGHE"],true);
  $totresto=0;
  for($j=0;$j<count($righe["qta"]);$j++)
     {
	 $resto=$righe["qta"][$j]-$righe["qta_sca"][$j];
	 $totresto+=$resto;
	 }
    //file_put_contents("testord.txt","$agente1 - " . $row["ORDI_AGENTE"] . " - " . $row["cf_agente"] . "\n", FILE_APPEND);
    $salta=0;
    if($agente1>"" && $row["ORDI_AGENTE"]=="")
      {
	  if($row["cf_agente"]!=$agente1)
	    {
		$salta=1;
		}
	  }
    if($agente1>"" && $row["ORDI_AGENTE"]>"")
      {
	  if($row["ORDI_AGENTE"]!=$agente1)
	    {
		$salta=1;
		}
	  }
    if($evaso=="N" && ($totresto==0 || $row["ORDI_EVASO"]=="S"))
      {
      $salta=1;	  	
	  }
    if($evaso=="E" && $totresto>0)
      {
      $salta=2;
	  }
    if($evaso=="E" && $row["ORDI_EVASO"]=="S")
      {
      $salta=3;
	  }
	  
    if($salta==0)
      {

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
    $tot_impo= $impon1 + $impon2;
    $tot_iva= $iva1 + $iva2;
    $totale_impo+=$tot_impo;
    $totale_iva+=$tot_iva;
    $totale_tot+=$totpre;
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
    
    if($y>=150){
        $pdf->AddPage("L","A4"); 
        $pdf->SetFont('Arial','',10);
        $pdf->SetTopMargin(0);
        $pdf->SetLineWidth(0.05);   
        $pdf->SetXY(5,10);
        $pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L'); 
        $pdf->SetXY(250,10);
        $pdf->Cell(0,4,$depdes,0,0,'L'); 
        $y=15;
    }
    
    $pdf->SetXY(5,$y+5);
    $pdf->Cell(0,4,"DEPOSITO: ".$deposito,0,0,'L'); 
    $pdf->SetXY(5,$y+15);
    $pdf->Cell(0,4,"CLIENTE:".$ragsoc,0,0,'L'); 
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
    $pdf->Cell(0,4,"IVA",0,0,'L'); 
    $pdf->SetXY(218,$y+35);
    $pdf->Cell(8,4,"",0,0,'L'); 
    $pdf->SetXY(228,$y+35);
    $pdf->SetFont('Arial','',7.5);
    $pdf->Cell(11,4,"Gia.02",0,0,'R');
    $pdf->Cell(11,4,"Gia.03",0,0,'R');
    $pdf->Cell(11,4,"Ord.02",0,0,'R');
    $pdf->Cell(11,4,"Ord.03",0,0,'R');
    $pdf->Cell(11,4,"Orf.02",0,0,'R');
    $pdf->Cell(11,4,"Orf.03",0,1,'R');
    $pdf->SetFont('Arial','',10);    
 
    // INIZIO STAMPA RIGHE ORDINE
    for($j=0;$j<count($righe["desc"]);$j++)    { 
        $articolo=$righe["cod"][$j];

        $valori=calcola_valore_medio($articolo,"",$dal,$al,"S");
        $z_giacenza2=number_format($valori["depo_val"]["02"]["qta"]+$valori["depo_val"]["12"]["qta"],2,",",".");
        $z_giacenza3=number_format($valori["depo_val"]["03"]["qta"]+$valori["depo_val"]["13"]["qta"],2,",",".");        
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
        
        $resto=$righe["qta"][$j]-$righe["qta_sca"][$j];
        $nosta=0;
        if($evaso=="N" && $resto==0)
          { $nosta=1; }
        if($evaso=="S" && $resto>0)
          { $nosta=1; }
        if($nosta==0)
          {
        $y = $pdf->getY(); 
        $pdf->SetXY(5,$y); 
        //$pdf->Cell(22,4,$articolo,0,0,'L');
   	    $pdf->CellFit(22,4,$articolo,0,0,'L',false,'',true,false);
        //$pdf->Cell(110,4, $descri,0,0,'L');
   	    $pdf->CellFit(110,4,$descri,0,0,'L',false,'',true,false);
        $pdf->Cell(10,4,$umis,0,0,'R');
        $pdf->Cell(12,4,$quantita,0,0,'R');
        $pdf->Cell(18,4,$prezzo,0,0,'R');
        $pdf->Cell(13,4,$sconto,0,0,'R');
        $pdf->Cell(20,4,$totale,0,0,'R'); 
        $pdf->Cell(10,4,$aliq,0,0,'L'); 
        if($resto == 0){
            $pdf->Cell(8,4,"EV S",0,0,'L');  
        } else {
            $pdf->Cell(8,4,"EV N",0,0,'L');  
        }
        $pdf->SetFont('Arial','',7.5);
        $pdf->Cell(11,4,$z_giacenza2,0,0,'R');
        $pdf->Cell(11,4,$z_giacenza3,0,0,'R');
        $pdf->Cell(11,4,$z_ordini2,0,0,'R');
        $pdf->Cell(11,4,$z_ordini3,0,0,'R');
        $pdf->Cell(11,4,$z_ordinifo2,0,0,'R');
        $pdf->Cell(11,4,$z_ordinifo3,0,1,'R');
        $pdf->SetFont('Arial','',10);
		  } //fine nosta
 
    }
    
        $y = $pdf->getY();

    if($y>=150){
        $pdf->AddPage("L","A4"); 
        $pdf->SetFont('Arial','',10);
        $pdf->SetTopMargin(0);
        $pdf->SetLineWidth(0.05);   
        $pdf->SetXY(5,10);
        $pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L'); 
        $pdf->SetXY(250,10);
        $pdf->Cell(0,4,$depdes,0,0,'L'); 
        $y=15;
    }
        
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
        if($caparra>0){
            $pdf->SetXY(180,$y+20); 
            $pdf->Cell(0,4,"CAPARRA",0,0,'L');  
            $pdf->SetXY(195,$y+20); 
            $pdf->Cell(0,4,$caparra,0,1,'L'); 
        } else {
            $pdf->SetXY(195,$y+20); 
            $pdf->Cell(0,4,"",0,1,'L'); 
        }

    //fine righe ordine

 /*   $dicitura = "CONSEGNA BORDO CAMION AL NUMERO CIVICO. LA DATA DI CONSEGNA NON PUO' ESSERE GARANTITA, E' PURAMENTE INDICATIVA ";
    $dicitura_2 = "ESSENDO SUBORDINATA ALLE SPEDIZIONI DELLE SINGOLE CASE PRODUTTRICI E POTREBBE CAMBIARE A SECONDA DELLE DISPONIBILITA'";

    $y = $pdf->getY();
    $pdf->SetXY(5,$y+4);
    $pdf->Cell(0,4,$dicitura,0,0,'L'); 
    $pdf->SetXY(5,$y+8);
    $pdf->Cell(0,4,$dicitura_2,0,0,'L'); */
    $y = $pdf->getY();
    $pdf->SetXY(5,$y+4);
    $pdf->Cell(0,4,"***************************************************************************************************************************************************************************************",0,0,'L'); 
    $y = $pdf->getY();
    if($y>=170){
        $pdf->AddPage("L","A4"); 
        $pdf->SetFont('Arial','',10);
        $pdf->SetTopMargin(0);
        $pdf->SetLineWidth(0.05);   
        $pdf->SetXY(5,10);
        $pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L'); 
        $pdf->SetXY(250,10);
        $pdf->Cell(0,4,$depdes,0,0,'L'); 
        $y=15;
    }
}
}
//
        $y+=5;  
        $pdf->SetXY(180,$y+3); 
        $pdf->Cell(0,4,"Totale: ",0,0,'L'); 
        $pdf->SetXY(195,$y+3); 
        $pdf->Cell(0,4,$totale_impo,0,0,'L'); 
        $pdf->SetXY(180,$y+8); 
        $pdf->Cell(0,4,"IVA: ",0,0,'L'); 
        $pdf->SetXY(195,$y+8); 
        $pdf->Cell(0,4,$totale_iva,0,0,'L');
        $pdf->SetXY(195,$y+12); 
        $pdf->Cell(0,4,"---------",0,0,'L');  
        $pdf->SetXY(180,$y+15); 
        $pdf->Cell(0,4,"TOT. ",0,0,'L'); 
        $pdf->SetXY(195,$y+15); 
        $pdf->Cell(0,4,$totale_tot,0,0,'L'); 
//        
$pdf->Output();

?>