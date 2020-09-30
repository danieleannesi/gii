<?php
session_start();
if(!isset($_SESSION["ute"])) {
  echo "<a href=\"login.php\">Effettuare il Login</a>";
  exit;
  }
$utente=$_SESSION["ute"];
$idt=$_POST["idt"];
require 'include/database.php';
require 'leggi_codici.php';
//
//leggi societa
  $qr="SELECT * FROM societa";  
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi societa) " . mysql_error();
	mysql_close($con);
	exit;
	}
  if(mysql_num_rows($rst)==0) {
     echo "anagrafica societa non trovata";
	 exit;  
     }
  $ros = mysql_fetch_array($rst);
  $soc_denomi=$ros["soc_denomi"];
  $soc_partitaiva=$ros["soc_partitaiva"];
  $soc_indi_legale=$ros["soc_indi_legale"];
  $soc_cap_legale=$ros["soc_cap_legale"];
  $soc_localita_legale=$ros["soc_localita_legale"];
  $soc_prov_legale=$ros["soc_prov_legale"];
  $soc_regime=$ros["soc_regime"];
//
//leggi fattura
  $qr="SELECT * FROM documtes WHERE DOCT_ID=$idt";  
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi documtes) " . mysql_error();
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
    
  file_put_contents("errori_pa.txt","$qr\n");

  $data_doc=$row["DOCT_DATA_DOC"];
  $DOCT_COD_PAG=$row["DOCT_COD_PAG"];
//
//leggi codici pagamento
  unset($a_paga);
  $handle = @fopen("pag_pa.txt", "r");
  if ($handle) {
    while (($buffer = fgets($handle)) !== false) {
        $paga_cod=substr($buffer,3,3);
        $paga_tp=substr($buffer,6,4);
        $paga_mp=substr($buffer,10,4);
        $a_paga["$paga_cod"]["tp"]=$paga_tp;
        $a_paga["$paga_cod"]["mp"]=$paga_mp;
        }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
$tp="TP02";
$mp="MP01";
if(isset($a_paga["$DOCT_COD_PAG"]["tp"]))
  {
  $tp=$a_paga["$DOCT_COD_PAG"]["tp"];
  $mp=$a_paga["$DOCT_COD_PAG"]["mp"];
  }
//
//fine leggi codici pagamento
//
//leggi codici esenzione iva
  unset($a_iva);
  $handle = @fopen("iva_pa.txt", "r");
  if ($handle) {
    while (($buffer = fgets($handle)) !== false) {
        $iva_ali=substr($buffer,3,2);
        $iva_ese=substr($buffer,5,2);
        $a_iva["$iva_ali"]["ali"]=$iva_ali;
        $a_iva["$iva_ali"]["ese"]=$iva_ese;
        }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
//fine leggi codici pagamento
//  	   
  $num_doc=sprintf("%06d",$row["DOCT_NUM_DOC"]);
  $anno_doc=substr($data_doc,2,2);
  $cliente=$row["DOCT_CLIENTE"];
  $qc="SELECT * FROM clienti WHERE cf_cod='$cliente'";
  $rsc = mysql_query($qc, $con);
  if(mysql_num_rows($rsc)==0) {
     echo "Cliente non trovato";
     }
  $roc = mysql_fetch_array($rsc);
    $denome=trim($roc["cf_ragsoc"]);
    $denome=str_replace("&","E",$denome);
    $nome=trim($roc["cf_nome"]);
    $cognome=trim($roc["cf_cognome"]);
    $cl_indirizzo=strtoupper($roc["cf_indirizzo"]);
    $cl_cap=$roc["cf_cap"];
    $cl_localita=strtoupper($roc["cf_localita"]);
    $cl_prov=strtoupper($roc["cf_prov"]);
    //$cl_reverse=$roc["cl_reverse"];
    $cl_partitaiva=trim($roc["cf_piva"]);
    $cfiscale=trim($roc["cf_codfisc"]);
    //$cl_note=$roc["cl_note"];

    //$cl_telefono=$roc["cl_telefono"];
    //$cl_email=$roc["cl_email"];
    //$cl_paga=$roc["cl_paga"];

    $cl_codice_unico=$roc["cf_codice_unico"];
    $cl_email_pec=$roc["cf_pec"];
    //$cl_cup=$roc["cl_cup"];
    //$cl_cig=$roc["cl_cig"];
//
$impon1=$row["DOCT_IMPONIBILE_1"];
$impon2=$row["DOCT_IMPONIBILE_2"];
$impon3=$row["DOCT_IMPONIBILE_3"];
$iva1=$row["DOCT_IMPOSTA_1"];
$iva2=$row["DOCT_IMPOSTA_2"];
$iva3=$row["DOCT_IMPOSTA_3"];
$ali1=$row["DOCT_ALIQUOTA_1"];
$aligen=$ali1;
$ali2=$row["DOCT_ALIQUOTA_2"];
$ali3=$row["DOCT_ALIQUOTA_3"];
$totfat=$row["DOCT_TOT_FATTURA"];
$caparra=$row["DOCT_VERSAMENTO"]*-1;
$trasporto=$row["DOCT_TRASPORTO"];
$collaudo=$row["DOCT_COLLAUDO"];
$spese_incasso=$row["DOCT_SPESE_INCASSO"];
$rit_acc=0;
//$totpagare=number_format($totfat - $row["DOCT_RIT_ACC"],2,".","");
//$caparra=$row["DOCT_CAPARRA"];
//$note=$row["DOCT_NOTE"];
//$age=$row["DOCT_AGENTE"];
$tipodoc=$row["DOCT_TIPO_DOC"];
//$periodo_dal="";
//$periodo_al="";
$tipo="TD01";
if($tipodoc=="8")
  {
  $tipo="TD04";
  }
//
$tot_impo=$row["DOCT_TOT_IMPONIBILE"];
$tot_iva=$row["DOCT_TOT_IMPOSTA"];
$tot_impo=number_format($tot_impo,2,".","");
$tot_iva=number_format($tot_iva,2,".","");
$tot_iva=number_format($tot_iva,2,".","");
$ali1=number_format($ali1,2);
$ali2=number_format($ali2,2);
$ali3=number_format($ali3,2);
//$pagato=$totfat-$caparra;
//
//  
$piva_aruba="01879020517";
$formato="FPR12";
$formato_breve="FPR";
if(strlen(trim($cl_codice_unico))==6)
  {
  $formato="FPA12";	
  $formato_breve="FPA";
  }
$esigi="I";  
/*
if($cl_reverse==1)
  {
  $esigi="S";  
  }
*/
//
$f="<?xml version=\"1.0\"?>";
$f.="<q1:FatturaElettronica versione=\"$formato\" xmlns:q1=\"http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2\">\r\n";
$f.="<FatturaElettronicaHeader>\r\n";
$f.="<DatiTrasmissione>\r\n";
$f.="<IdTrasmittente>\r\n";
$f.="<IdPaese>IT</IdPaese>\r\n";
$f.="<IdCodice>$piva_aruba</IdCodice>\r\n";
$f.="</IdTrasmittente>\r\n";
$f.="<ProgressivoInvio>00001</ProgressivoInvio>\r\n";
$f.="<FormatoTrasmissione>$formato</FormatoTrasmissione>\r\n";
if($cl_codice_unico>"")
  {
  $f.="<CodiceDestinatario>$cl_codice_unico</CodiceDestinatario>\r\n";
  }
else
  {
  $f.="<CodiceDestinatario>0000000</CodiceDestinatario>\r\n";
  if(strlen(trim($cl_email_pec))>0)
    {
    $f.="<PECDestinatario>$cl_email_pec</PECDestinatario>\r\n";
	}    
  }  
$f.="</DatiTrasmissione>\r\n";
//
$f=$f . "<CedentePrestatore>\r\n";
$f=$f . "<DatiAnagrafici>\r\n";
$f=$f . "<IdFiscaleIVA><IdPaese>IT</IdPaese><IdCodice>$soc_partitaiva</IdCodice></IdFiscaleIVA>\r\n";
$f=$f . "<Anagrafica><Denominazione>$soc_denomi</Denominazione></Anagrafica>\r\n";
$f=$f . "<RegimeFiscale>$soc_regime</RegimeFiscale>\r\n";
$f=$f . "</DatiAnagrafici>\r\n";
$f=$f . "<Sede>\r\n";
$f=$f . "<Indirizzo>$soc_indi_legale</Indirizzo>\r\n";
$f=$f . "<CAP>$soc_cap_legale</CAP>\r\n";
$f=$f . "<Comune>$soc_localita_legale</Comune>\r\n";
$f=$f . "<Provincia>$soc_prov_legale</Provincia>\r\n";
$f=$f . "<Nazione>IT</Nazione>\r\n";
$f=$f . "</Sede>\r\n";
$f=$f . "</CedentePrestatore>\r\n";
//
$f=$f . "<CessionarioCommittente>\r\n";
$f=$f . "<DatiAnagrafici>\r\n";
if($cl_partitaiva>"")
  {
  $f=$f . "<IdFiscaleIVA><IdPaese>IT</IdPaese><IdCodice>$cl_partitaiva</IdCodice></IdFiscaleIVA>\r\n";
  }
if($cfiscale>"")
  {
  $f=$f . "<CodiceFiscale>$cfiscale</CodiceFiscale>\r\n";
  }
if(substr($cfiscale,0,1)>"9")
  {
  if($cognome=="")
    {
	$pezzi=explode(" ", $denome);
    $cognome=$pezzi[0];
    $nome=$pezzi[1];
    if(isset($pezzi[2]))
      {
      $nome.=" " . $pezzi[2];
	  }
	}
  $f=$f . "<Anagrafica><Nome>$nome</Nome><Cognome>$cognome</Cognome></Anagrafica>\r\n";
  }
else
  {
  $f=$f . "<Anagrafica><Denominazione>$denome</Denominazione></Anagrafica>\r\n";
  }
$f=$f . "</DatiAnagrafici>\r\n";
$f=$f . "<Sede>\r\n";
$f=$f . "<Indirizzo>$cl_indirizzo</Indirizzo>\r\n";
$f=$f . "<CAP>$cl_cap</CAP>\r\n";
$f=$f . "<Comune>$cl_localita</Comune>\r\n";
if($cl_prov>"")
  {
  $f=$f . "<Provincia>$cl_prov</Provincia>\r\n";
  }
$f=$f . "<Nazione>IT</Nazione>\r\n";
$f=$f . "</Sede>\r\n";
$f=$f . "</CessionarioCommittente>\r\n";
//
$f=$f . "</FatturaElettronicaHeader>\r\n";
//
$f=$f . "<FatturaElettronicaBody>\r\n";
$f=$f . "<DatiGenerali>\r\n";
$f=$f . "<DatiGeneraliDocumento>\r\n";
$f=$f . "<TipoDocumento>$tipo</TipoDocumento>\r\n";
$f=$f . "<Divisa>EUR</Divisa>\r\n";
$f=$f . "<Data>$data_doc</Data>\r\n";
$f=$f . "<Numero>$formato_breve $num_doc/$anno_doc</Numero>\r\n";

if($rit_acc > 0)
  {
  $f=$f . "<DatiRitenuta>\r\n";
  $f=$f . "<TipoRitenuta>RT02</TipoRitenuta>\r\n";
  $f=$f . "<ImportoRitenuta>$rit_acc</ImportoRitenuta>\r\n";
  $f=$f . "<AliquotaRitenuta>$ali_ra</AliquotaRitenuta>\r\n";
  $f=$f . "<CausalePagamento>W</CausalePagamento>\r\n";
  $f=$f . "</DatiRitenuta>\r\n";
  }

$f=$f . "<ImportoTotaleDocumento>$totfat</ImportoTotaleDocumento>";
$f=$f . "</DatiGeneraliDocumento>\r\n";
//
/*
if($cl_contratto_num>"")
  {
  $f=$f . "<DatiContratto>\r\n";
  $f=$f . "<RiferimentoNumeroLinea>1</RiferimentoNumeroLinea>\r\n";
  $f=$f . "<IdDocumento>$cl_contratto_num</IdDocumento>\r\n";
  $f=$f . "<Data>$cl_contratto_dt</Data>\r\n";
  $f=$f . "<NumItem>1</NumItem>\r\n";
  if(trim($cl_cup)>"")
    {
    $f=$f . "<CodiceCUP>$cl_cup</CodiceCUP>\r\n";
    }
  $f=$f . "<CodiceCIG>$cl_cig</CodiceCIG>\r\n";
  $f=$f . "</DatiContratto>\r\n";
  }
*/
//
$f=$f . "</DatiGenerali>\r\n";
//
$f=$f . "<DatiBeniServizi>\r\n";
//
//righe
  $prog=1; 
  for($j=0;$j<count($righe["desc"]);$j++)
     {
     $articolo=$righe["cod"][$j];
     $descri=$righe["desc"][$j];
     $descri=str_replace("&","E",$descri);
     $quantita=floatval($righe["qta"][$j]);
     $prezzo=floatval($righe["uni"][$j]);
     $sconto=floatval($righe["sco"][$j]);
     $totale=floatval($righe["tot"][$j]);
     $praee=floatval($righe["raee"][$j]);
     $raee=$praee*$quantita;
     //$umis=$row["umis"][$j];
     $umis="";
     $aliq=$righe["iva"][$j];
     $aliquota=0;
     for($a=0; $a<count($codiva); $a++)
       {
	   if($aliq==$codiva[$a])
	     {
         $aliquota=$perciva[$a];
	     }
	   }
	 $natura="N1";
	 if(isset($a_iva["$aliq"]["ali"]))
	   {
	   $natura=$a_iva["$aliq"]["ese"];
	   }
     if(trim($sconto)=="0") { $sconto=""; }
	 $quantita=number_format($quantita, 4, '.', '');
	 $prezzo=number_format($prezzo, 4, '.', '');
	 $totale=number_format($totale, 2, '.', '');
	 $scontoz=number_format($sconto, 2, '.', '');
	 $raeez=number_format($raee, 2, '.', '');
	 $praeez=number_format($praee, 2, '.', '');

     $f=$f . "<DettaglioLinee>\r\n";
     $f=$f . "<NumeroLinea>$prog</NumeroLinea>\r\n";
     $f=$f . "<Descrizione>$descri</Descrizione>\r\n";
     if($quantita>0)
       {
       $f=$f . "<Quantita>$quantita</Quantita>\r\n";
	   }
     $f=$f . "<PrezzoUnitario>$prezzo</PrezzoUnitario>\r\n";
     if($sconto>0)
       {
       $f.="<ScontoMaggiorazione>\r\n";
       $f.="<Tipo>SC</Tipo>\r\n";
       $f.="<Percentuale>$scontoz</Percentuale>\r\n";
       $f.="</ScontoMaggiorazione>\r\n";
	   }  
     $f=$f . "<PrezzoTotale>$totale</PrezzoTotale>\r\n";
     $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
     if($aliquota=="0")
       {
       $f=$f . "<Natura>$natura</Natura>\r\n";
	   }
     $f=$f . "</DettaglioLinee>\r\n";
     $prog++;

     if($raee>0)
       {
     $f=$f . "<DettaglioLinee>\r\n";
     $f=$f . "<NumeroLinea>$prog</NumeroLinea>\r\n";
     $f=$f . "<Descrizione>RAEE</Descrizione>\r\n";
     if($quantita>0)
       {
       $f=$f . "<Quantita>$quantita</Quantita>\r\n";
	   }
     $f=$f . "<PrezzoUnitario>$praeez</PrezzoUnitario>\r\n";
     $f=$f . "<PrezzoTotale>$raeez</PrezzoTotale>\r\n";
     $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
     if($aliquota=="0")
       {
       $f=$f . "<Natura>$natura</Natura>\r\n";
	   }
     $f=$f . "</DettaglioLinee>\r\n";
     $prog++;
	   }	   
     
	 }
//
     if($trasporto>0)
       {
       $f=$f . "<DettaglioLinee>\r\n";
       $f=$f . "<NumeroLinea>$prog</NumeroLinea>\r\n";
       $f=$f . "<Descrizione>TRASPORTO</Descrizione>\r\n";
       $f=$f . "<Quantita>1.00</Quantita>\r\n";
       $f=$f . "<PrezzoUnitario>$trasporto</PrezzoUnitario>\r\n";
       $f=$f . "<PrezzoTotale>$trasporto</PrezzoTotale>\r\n";
       $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
       if($aliquota=="0")
         {
         $f=$f . "<Natura>$natura</Natura>\r\n";
	     }
       $f=$f . "</DettaglioLinee>\r\n";
       $prog++;
	   }

     if($collaudo>0)
       {
       $f=$f . "<DettaglioLinee>\r\n";
       $f=$f . "<NumeroLinea>$prog</NumeroLinea>\r\n";
       $f=$f . "<Descrizione>COLLAUDO</Descrizione>\r\n";
       $f=$f . "<Quantita>1.00</Quantita>\r\n";
       $f=$f . "<PrezzoUnitario>$collaudo</PrezzoUnitario>\r\n";
       $f=$f . "<PrezzoTotale>$collaudo</PrezzoTotale>\r\n";
       $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
       if($aliquota=="0")
         {
         $f=$f . "<Natura>$natura</Natura>\r\n";
	     }
       $f=$f . "</DettaglioLinee>\r\n";
       $prog++;
	   }

     if($caparra!=0)
       {
     $f=$f . "<DettaglioLinee>\r\n";
     $f=$f . "<NumeroLinea>$prog</NumeroLinea>\r\n";
     $f=$f . "<Descrizione>CAPARRA</Descrizione>\r\n";
     $f=$f . "<Quantita>1.00</Quantita>\r\n";
     $f=$f . "<PrezzoUnitario>$caparra</PrezzoUnitario>\r\n";
     $f=$f . "<PrezzoTotale>$caparra</PrezzoTotale>\r\n";
     $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
     if($aliquota=="0")
       {
       $f=$f . "<Natura>$natura</Natura>\r\n";
	   }
     $f=$f . "</DettaglioLinee>\r\n";
     $prog++;
	   }

     if($spese_incasso>0)
       {
     $f=$f . "<DettaglioLinee>\r\n";
     $f=$f . "<NumeroLinea>$prog</NumeroLinea>\r\n";
     $f=$f . "<Descrizione>TRASPORTO</Descrizione>\r\n";
     $f=$f . "<Quantita>1.00</Quantita>\r\n";
     $f=$f . "<PrezzoUnitario>$spese_incasso</PrezzoUnitario>\r\n";
     $f=$f . "<PrezzoTotale>$spese_incasso</PrezzoTotale>\r\n";
     $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
     if($aliquota=="0")
       {
       $f=$f . "<Natura>$natura</Natura>\r\n";
	   }
     $f=$f . "</DettaglioLinee>\r\n";
     $prog++;
	   }

//
if($impon1>0)
  {
  $aliquota=0;
  for($a=0; $a<count($codiva); $a++)
    {
    if($ali1==$codiva[$a])
      {
      $aliquota=$perciva[$a];
      }
    }
  $natura="N1";
  if(isset($a_iva["$ali1"]["ali"]))
    {
    $natura=$a_iva["$ali1"]["ese"];
    }
  $f=$f . "<DatiRiepilogo>\r\n";
  $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
  if($aliquota=="0")
     {
     $f=$f . "<Natura>$natura</Natura>\r\n";
     }  
  $f=$f . "<ImponibileImporto>$impon1</ImponibileImporto>\r\n";
  $f=$f . "<Imposta>$iva1</Imposta>\r\n";
/*
  if($aliquota=="0")
     {  
     $f=$f . "<RiferimentoNormativo>Esente art.15</RiferimentoNormativo>\r\n";  
	 }
*/
  $f=$f . "</DatiRiepilogo>\r\n";
  }
if($impon2>0)
  {
  $aliquota=0;
  for($a=0; $a<count($codiva); $a++)
    {
    if($ali2==$codiva[$a])
      {
      $aliquota=$perciva[$a];
      }
    }
  $natura="N1";
  if(isset($a_iva["$ali2"]["ali"]))
    {
    $natura=$a_iva["$ali2"]["ese"];
    }
  $f=$f . "<DatiRiepilogo>\r\n";
  $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
  if($aliquota=="0")
     {
     $f=$f . "<Natura>$natura</Natura>\r\n";
     }  
  $f=$f . "<ImponibileImporto>$impon2</ImponibileImporto>\r\n";
  $f=$f . "<Imposta>$iva2</Imposta>\r\n";
/*
  if($aliquota=="0")
     {  
     $f=$f . "<RiferimentoNormativo>Esente art.15</RiferimentoNormativo>\r\n";  
	 }
*/
  $f=$f . "</DatiRiepilogo>\r\n";
  }
//
if($impon3>0)
  {
  $aliquota=0;
  for($a=0; $a<count($codiva); $a++)
    {
    if($ali3==$codiva[$a])
      {
      $aliquota=$perciva[$a];
      }
    }
  $natura="N1";
  if(isset($a_iva["$ali3"]["ali"]))
    {
    $natura=$a_iva["$ali3"]["ese"];
    }
  $f=$f . "<DatiRiepilogo>\r\n";
  $f=$f . "<AliquotaIVA>$aliquota.00</AliquotaIVA>\r\n";
  if($aliquota=="0")
     {
     $f=$f . "<Natura>$natura</Natura>\r\n";
     }  
  $f=$f . "<ImponibileImporto>$impon3</ImponibileImporto>\r\n";
  $f=$f . "<Imposta>$iva3</Imposta>\r\n";
/*
  if($aliquota=="0")
     {  
     $f=$f . "<RiferimentoNormativo>Esente art.15</RiferimentoNormativo>\r\n";  
	 }
*/
  $f=$f . "</DatiRiepilogo>\r\n";
  }
//
$f=$f . "</DatiBeniServizi>\r\n";
//
if(count($scadenze["data"])>0)
  {
  $f=$f . "<DatiPagamento>\r\n";
  $f=$f . "<CondizioniPagamento>$tp</CondizioniPagamento>\r\n";
  for($j=0;$j<count($scadenze["data"]);$j++)
     {
     $data_sca=$scadenze["data"][$j];
     $importo_sca=$scadenze["importo"][$j];
     $importo_sca=number_format($importo_sca, 2, '.', '');
     $f=$f . "<DettaglioPagamento>\r\n";
     $f=$f . "<ModalitaPagamento>$mp</ModalitaPagamento>\r\n";
     $f=$f . "<DataScadenzaPagamento>$data_sca</DataScadenzaPagamento>\r\n";
     $f=$f . "<ImportoPagamento>$importo_sca</ImportoPagamento>\r\n";
     $f=$f . "</DettaglioPagamento>\r\n";
     }     
  $f=$f . "</DatiPagamento>\r\n";
  }
//
$f=$f . "</FatturaElettronicaBody>\r\n";
$f=$f . "</q1:FatturaElettronica>\r\n";
//
$nome_file="IT$piva_aruba" . "_" . $tipodoc . "_" . $anno_doc . $num_doc . ".xml";
$res["msg"]="";
$ret=file_put_contents("tmp/elettroniche/$nome_file",$f);
if($ret===false)
  {
  file_put_contents("errori_pa.txt","$nome_file\n",FILE_APPEND);
  $res["msg"]="ERRORE SU $nome_file";
  }
//
header('Content-Type: application/json');
echo json_encode($res);
//  
?>
