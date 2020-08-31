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
$dati_json = $_POST["dati_json"];
$dati=json_decode ($dati_json,true);
$righe=$dati["righe"];
$righej=json_encode($righe);
$righej=addslashes($righej);

file_put_contents("debug.txt", $dati_json);

$data_doc=substr($dati["data_doc"],6,4) . "-" . substr($dati["data_doc"],3,2) . "-" . substr($dati["data_doc"],0,2);
$anno=substr($dati["data_doc"],6,4);
$idt=$dati["idt"];
$deposito=$dati["deposito"];
$nume_man=$dati["nume_man"];
$fornitore=$dati["fornitore"];
$data_consegna=substr($dati["data_consegna"],6,4) . "-" . substr($dati["data_consegna"],3,2) . "-" . substr($dati["data_consegna"],0,2);
$age="";
$utente=$dati["utente"];
$paga=$dati["paga"];
$tot_ali=$dati["tot_ali"];
$tot_imponibile=$dati["tot_imponibile"];
$tot_imposta=$dati["tot_imposta"];
//
$des_rag_soc=addslashes($dati["des_rag_soc"]);
$des_indirizzo=addslashes($dati["des_indirizzo"]);
$des_cap=addslashes($dati["des_cap"]);
$des_localita=addslashes($dati["des_localita"]);
$des_prov=addslashes($dati["des_prov"]);
$des_spedizione=addslashes($dati["des_spedizione"]);
$des_trasporto=addslashes($dati["des_trasporto"]);
$des_imballo=addslashes($dati["des_imballo"]);
$cig=addslashes($dati["cig"]);
$cup=addslashes($dati["cup"]);
$notes=addslashes($dati["notes"]);
$acconto=floatval($dati["acconto"]);
$caparra=floatval($dati["caparra"]);
$trasporto=floatval($dati["trasporto"]);
$installazione=floatval($dati["installazione"]);
$jolly=floatval($dati["jolly"]);
$noleggio=floatval($dati["noleggio"]);
$collaudo=floatval($dati["collaudo"]);
$europallet=floatval($dati["europallet"]);
$addvari=floatval($dati["addvari"]);
//
for($j=0;$j<3;$j++)
  {
  $p=$j+1;
  $ali_j="ORDI_ALIQUOTA_" . $p;  
  $imponibile_j="ORDI_IMPONIBILE_" . $p;  
  $imposta_j="ORDI_IMPOSTA_" . $p;
  
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
$ORDI_TOT_IMPOSTA=$dati["totale_imposta"];
$ORDI_TOT_IMPONIBILE=$dati["totale_imponibile"];
$ORDI_TOT_PREVENT=$dati["totale_fattura"];
//
if($idt==""||$idt=="0")
  {
  if(intval($nume_man)==0)
    {
    $numero=progressivo($anno,"0","OF");
	}
  else
    {
	$numero=intval($nume_man);
	}
  $qr = "INSERT INTO ordinifo (ORDI_DEPOSITO, ORDI_DATA_DOC, ORDI_NUM_DOC, ORDI_FORNITORE, ORDI_DATA_CONS, ORDI_ALIQUOTA_1, ORDI_IMPONIBILE_1, ORDI_IMPOSTA_1,ORDI_ALIQUOTA_2, ORDI_IMPONIBILE_2, ORDI_IMPOSTA_2, ORDI_ALIQUOTA_3, ORDI_IMPONIBILE_3, ORDI_IMPOSTA_3, ORDI_TOT_IMPONIBILE, ORDI_TOT_IMPOSTA, ORDI_TOT_ORDINE, ORDI_AGENTE, ORDI_COD_PAG, ORDI_UTENTE, ORDI_DES_RAG_SOC, ORDI_DES_INDIRIZZO,ORDI_DES_CAP, ORDI_DES_LOC, ORDI_DES_PR, ORDI_CIG, ORDI_CUP, ORDI_NOTE, ORDI_ACCONTO, ORDI_VERSAMENTO, ORDI_TRASPORTO, ORDI_INSTALLAZ, ORDI_JOLLY, ORDI_NOLEGGIO, ORDI_COLLAUDO, ORDI_EUROPALLET, ORDI_ADDVARI, ORDI_DES_SPEDIZIONE, ORDI_DES_TRASPORTO, ORDI_DES_IMBALLO, ORDI_RIGHE) VALUES ('$deposito', '$data_doc','$numero', '$fornitore', '$data_consegna', '$ORDI_ALIQUOTA_1', '$ORDI_IMPONIBILE_1', '$ORDI_IMPOSTA_1', '$ORDI_ALIQUOTA_2', '$ORDI_IMPONIBILE_2', '$ORDI_IMPOSTA_2', '$ORDI_ALIQUOTA_3', '$ORDI_IMPONIBILE_3', '$ORDI_IMPOSTA_3', '$ORDI_TOT_IMPONIBILE', '$ORDI_TOT_IMPOSTA', '$ORDI_TOT_PREVENT', '$age', '$paga', '$utente', '$des_rag_soc', '$des_indirizzo', '$des_cap', '$des_localita', '$des_prov', '$cig', '$cup', '$notes', '$acconto', '$caparra', '$trasporto', '$installazione', '$jolly', '$noleggio', '$collaudo', '$europallet', '$addvari', '$des_spedizione', '$des_trasporto', '$des_imballo', '$righej')";
  }
else
  {
  $qr="UPDATE ordinifo SET ORDI_DATA_CONS='$data_consegna', ORDI_ALIQUOTA_1='$ORDI_ALIQUOTA_1', ORDI_IMPONIBILE_1='$ORDI_IMPONIBILE_1', ORDI_IMPOSTA_1='$ORDI_IMPOSTA_1',ORDI_ALIQUOTA_2='$ORDI_ALIQUOTA_2', ORDI_IMPONIBILE_2='$ORDI_IMPONIBILE_2', ORDI_IMPOSTA_2='$ORDI_IMPOSTA_2', ORDI_ALIQUOTA_3='$ORDI_ALIQUOTA_3', ORDI_IMPONIBILE_3='$ORDI_IMPONIBILE_3', ORDI_IMPOSTA_3='$ORDI_IMPOSTA_3', ORDI_TOT_IMPONIBILE='$ORDI_TOT_IMPONIBILE', ORDI_TOT_IMPOSTA='$ORDI_TOT_IMPOSTA', ORDI_TOT_ORDINE='$ORDI_TOT_PREVENT', ORDI_AGENTE='$age', ORDI_COD_PAG='$paga', ORDI_UTENTE='$utente', ORDI_DES_RAG_SOC='$des_rag_soc',ORDI_DES_INDIRIZZO='$des_indirizzo',ORDI_DES_CAP='$des_cap', ORDI_DES_LOC='$des_localita', ORDI_DES_PR='$des_prov', ORDI_CIG='$cig', ORDI_CUP='$cup', ORDI_NOTE='$notes', ORDI_ACCONTO='$acconto', ORDI_VERSAMENTO='$caparra', ORDI_TRASPORTO='$trasporto', ORDI_INSTALLAZ='$installazione', ORDI_JOLLY='$jolly', ORDI_NOLEGGIO='$noleggio', ORDI_COLLAUDO='$collaudo', ORDI_EUROPALLET='$europallet', ORDI_ADDVARI='$addvari', ORDI_DES_SPEDIZIONE='$des_spedizione', ORDI_DES_TRASPORTO='$des_trasporto', ORDI_DES_IMBALLO='$des_imballo', ORDI_RIGHE='$righej' WHERE ORDI_ID='$idt'";
  }
file_put_contents("debugqr.txt", $qr);
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
$log=new scrivi_log($utente,"salva_ord: $qr");
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
