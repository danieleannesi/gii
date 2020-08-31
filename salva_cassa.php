<?php
session_start();
if(!isset($_SESSION["iddu"]))
  {
  echo "Sessione scaduta; <a href=\"login.php\">Effettuare il Login</a>"; exit;
  }
$iddu=$_SESSION["iddu"];
$ute=$_SESSION["ute"];
$utente=$iddu;
require 'include/database.php';
require 'include/functions.php';
require 'class_varie.php';
//
function scarica_ordine($ordine,$cod,$qta)
  {
  global $con;
  $qr="SELECT * FROM ordini WHERE ORDI_ID='$ordine'";
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
     $righej=$row["ORDI_RIGHE"];
     $righe=json_decode ($righej,true);
     for($j=0;$j<count($righe["qta"]);$j++)
       {
	   if($righe["cod"][$j]==$cod)
	     {
	     $resto=$righe["qta"][$j]-$righe["qta_sca"][$j];
	     if($qta<=$resto)
	       {
		   $righe["qta_sca"][$j]+=$qta;
		   }
		 }
	   }
     $righej=json_encode($righe);
     $righej=addslashes($righej);
     $qr="UPDATE ordini SET ORDI_RIGHE='$righej' WHERE ORDI_ID='$ordine'";
     $rst=mysql_query($qr,$con);
     //file_put_contents("debugord.txt", "$qr\n",FILE_APPEND);
   }  
  }
//
$dati_json = $_POST["dati_json"];
$dati=json_decode ($dati_json,true);
$righe=$dati["righe"];
$righej=json_encode($righe);
$righej=addslashes($righej);
//file_put_contents("debug.txt", $dati_json);
$data_doc=substr($dati["data_doc"],6,4) . "-" . substr($dati["data_doc"],3,2) . "-" . substr($dati["data_doc"],0,2);
$anno=substr($dati["data_doc"],6,4);
$idt=$dati["idt"];
$tipo_documento=$dati["tipo_documento"];
$deposito=$dati["deposito"];
$nume_man=$dati["nume_man"];
$numsco=$dati["numsco"];
$cliente=$dati["cliente"];
$agente=$dati["agente"];
$paga=$dati["paga"];
$causale=addslashes($dati["causale"]);
$tot_ali=$dati["tot_ali"];
$tot_imponibile=$dati["tot_imponibile"];
$tot_imposta=$dati["tot_imposta"];
//
$des_rag_soc=addslashes($dati["des_rag_soc"]);
$des_indirizzo=addslashes($dati["des_indirizzo"]);
$des_cap=addslashes($dati["des_cap"]);
$des_localita=addslashes($dati["des_localita"]);
$des_prov=addslashes($dati["des_prov"]);
$cig=addslashes($dati["cig"]);
$cup=addslashes($dati["cup"]);
$notes=addslashes($dati["notes"]);
$porto=addslashes($dati["porto"]);
$aspetto=addslashes($dati["aspetto"]);
$colli=addslashes($dati["colli"]);
$peso=addslashes($dati["peso"]);
$data_ritiro=substr($dati["data_ritiro"],6,4) . "-" . substr($dati["data_ritiro"],3,2) . "-" . substr($dati["data_ritiro"],0,2);
$ora_ritiro=addslashes($dati["ora_ritiro"]);
$consegna=addslashes($dati["consegna"]);
$vettore=addslashes($dati["vettore"]);
$indvettore=addslashes($dati["indvettore"]);
$acconto=floatval($dati["acconto"]);
$caparra=floatval($dati["caparra"]);
$trasporto=floatval($dati["trasporto"]);
$installazione=floatval($dati["installazione"]);
$jolly=floatval($dati["jolly"]);
$noleggio=floatval($dati["noleggio"]);
$collaudo=floatval($dati["collaudo"]);
$europallet=floatval($dati["europallet"]);
$addvari=floatval($dati["addvari"]);
$scontocassa=floatval($dati["scontocassa"]);
$importoscontocassa=floatval($dati["importoscontocassa"]);
//
for($j=0;$j<5;$j++)
  {
  $p=$j+1;
  $ali_j="DOCT_ALIQUOTA_" . $p;  
  $imponibile_j="DOCT_IMPONIBILE_" . $p;  
  $imposta_j="DOCT_IMPOSTA_" . $p;
  
  if(isset($tot_ali[$j]))
    {
    $$ali_j=$tot_ali[$j];  
    $$imponibile_j=$tot_imponibile[$j];  
    $$imposta_j=$tot_imposta[$j];  
	}
  else
    {
    $$ali_j="";  
    $$imponibile_j=0;  
    $$imposta_j=0;  
	}
  }
$DOCT_TOT_IMPOSTA=$dati["totale_imposta"];
$DOCT_TOT_IMPONIBILE=$dati["totale_imponibile"];
$DOCT_TOT_FATTURA=$dati["totale_fattura"];
$DOCT_IMPORTO_RAE=$dati["totale_raee"];
//
  if($tipo_documento==3) //scontrino
    {
	$numero=$numsco;
	}
  else
    {
  if(intval($nume_man)==0)
    {
    $numero=progressivo($anno,$deposito,$tipo_documento);
	}
  else
    {
	$numero=intval($nume_man);
	}
  }
  $qr = "INSERT INTO documtes (DOCT_TIPO_DOC, DOCT_DEPOSITO, DOCT_DATA_DOC, DOCT_NUM_DOC, DOCT_CLIENTE, DOCT_ALIQUOTA_1, DOCT_IMPONIBILE_1, DOCT_IMPOSTA_1,DOCT_ALIQUOTA_2, DOCT_IMPONIBILE_2, DOCT_IMPOSTA_2, DOCT_ALIQUOTA_3, DOCT_IMPONIBILE_3, DOCT_IMPOSTA_3, DOCT_ALIQUOTA_4, DOCT_IMPONIBILE_4, DOCT_IMPOSTA_4, DOCT_ALIQUOTA_5, DOCT_IMPONIBILE_5, DOCT_IMPOSTA_5, DOCT_TOT_IMPONIBILE, DOCT_TOT_IMPOSTA, DOCT_TOT_FATTURA, DOCT_AGENTE, DOCT_COD_PAG, DOCT_CAUSALE, DOCT_DES_CAUSALE, DOCT_IMPORTO_RAE, DOCT_UTENTE, DOCT_DES_RAG_SOC, DOCT_DES_INDIRIZZO,DOCT_DES_CAP, DOCT_DES_LOC, DOCT_DES_PR, DOCT_CIG, DOCT_CUP, DOCT_NOTE, DOCT_MDV, DOCT_VETTORE, DOCT_IND_VETTORE, DOCT_PORTO, DOCT_ASPETTO, DOCT_COLLI, DOCT_PESO, DOCT_DATA_RITIRO, DOCT_ORA_RIT, DOCT_ACCONTO, DOCT_VERSAMENTO, DOCT_ULT_SCONTO, DOCT_SCONTO_CASSA, DOCT_TRASPORTO, DOCT_INSTALLAZ, DOCT_JOLLY, DOCT_NOLEGGIO, DOCT_COLLAUDO, DOCT_EUROPALLET, DOCT_ADDVARI, DOCT_RIGHE) VALUES ('$tipo_documento', '$deposito', '$data_doc','$numero', '$cliente', '$DOCT_ALIQUOTA_1', '$DOCT_IMPONIBILE_1', '$DOCT_IMPOSTA_1', '$DOCT_ALIQUOTA_2', '$DOCT_IMPONIBILE_2', '$DOCT_IMPOSTA_2', '$DOCT_ALIQUOTA_3', '$DOCT_IMPONIBILE_3', '$DOCT_IMPOSTA_3', '$DOCT_ALIQUOTA_4', '$DOCT_IMPONIBILE_4', '$DOCT_IMPOSTA_4', '$DOCT_ALIQUOTA_5', '$DOCT_IMPONIBILE_5', '$DOCT_IMPOSTA_5', '$DOCT_TOT_IMPONIBILE', '$DOCT_TOT_IMPOSTA', '$DOCT_TOT_FATTURA', '$agente', '$paga', '50', '$causale', '$DOCT_IMPORTO_RAE', '$ute', '$des_rag_soc', '$des_indirizzo', '$des_cap', '$des_localita', '$des_prov', '$cig', '$cup', '$notes', '$consegna', '$vettore', '$indvettore', '$porto', '$aspetto', '$colli', '$peso', '$data_ritiro', '$ora_ritiro', '$acconto', '$caparra','$scontocassa', '$importoscontocassa', '$trasporto', '$installazione', '$jolly', '$noleggio', '$collaudo', '$europallet', '$addvari', '$righej')";
//
//file_put_contents("debugqr.txt", $qr);
mysql_query($qr,$con);
if($idt==""||$idt=="0")
  {
  $idt = mysql_insert_id();
  }
$success = false;
$msg = mysql_error();
//
//$msg=$qr;
$qr=addslashes($qr);
$log=new scrivi_log($utente,"salva_doc: $qr");
//
$cot_magazzino="N";
$qr="SELECT cot_magazzino FROM contatori_tipi WHERE cot_tipo='$tipo_documento'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $cot_magazzino=$row["cot_magazzino"];
  }
//
//scrivi righe su movmag
if($cot_magazzino=="S")
  {
for($j=0; $j<count($righe["cod"]); $j++)
  {
  $cod=$righe["cod"][$j];
  //$desc=addslashes($righe["desc"][$j]);
  $qta=$righe["qta"][$j];
  $uni=$righe["uni"][$j];
  $sco=$righe["sco"][$j];
  $tot=$righe["tot"][$j];
  $ordine=$righe["ordine"][$j];
  if(substr($cod,0,1)<"A")
    {
    $qw="INSERT INTO movmag (mov_data, mov_codart, mov_dep, mov_causale, mov_qua, mov_prezzo, mov_sconto, mov_totale, mov_tipo_doc, mov_doc, mov_clifor, mov_id_rife, mov_data_ins, mov_data_mod, mov_utente) VALUES ('$data_doc', '$cod', '$deposito', '50', '$qta', '$uni', '$sco', '$tot', '$tipo_documento', '$numero', '$cliente', '$idt', NOW(), NOW(), '$iddu')";
    mysql_query($qw,$con);
    $msg.=mysql_error();
    $qw=addslashes($qw);
    $log=new scrivi_log($utente,"scrivi movmag: $qw");
	}
  scarica_ordine($ordine,"$cod",$qta);
  }
  }
//
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "idt" => $idt, "numero" => $numero);
header('Content-Type: application/json');
echo json_encode($resp);
?>
