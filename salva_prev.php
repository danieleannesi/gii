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
//5318000150
file_put_contents("debug.txt", $dati_json);

$data_doc=substr($dati["data_doc"],6,4) . "-" . substr($dati["data_doc"],3,2) . "-" . substr($dati["data_doc"],0,2);
$anno=substr($dati["data_doc"],6,4);
$idt=$dati["idt"];
$deposito=$dati["deposito"];
$nume_man=$dati["nume_man"];
$cliente=$dati["cliente"];
$age=$dati["agente"];
$paga=$dati["paga"];
$tot_ali=$dati["tot_ali"];
$tot_imponibile=$dati["tot_imponibile"];
$tot_imposta=$dati["tot_imposta"];
//
for($j=0;$j<5;$j++)
  {
  $p=$j+1;
  $ali_j="PREV_ALIQUOTA_" . $p;  
  $imponibile_j="PREV_IMPONIBILE_" . $p;  
  $imposta_j="PREV_IMPOSTA_" . $p;
  
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
$PREV_TOT_IMPOSTA=$dati["totale_imposta"];
$PREV_TOT_IMPONIBILE=$dati["totale_imponibile"];
$PREV_TOT_FATTURA=$dati["totale_fattura"];
$PREV_IMPORTO_RAE=$dati["totale_raee"];
//
if($idt==""||$idt=="0")
  {
  if(intval($nume_man)==0)
    {
    $numero=progressivo($anno,"0","P");
	}
  else
    {
	$numero=intval($nume_man);
	}
  $qr = "INSERT INTO preventivi (PREV_DEPOSITO, PREV_DATA_DOC, PREV_NUM_DOC, PREV_CLIENTE, PREV_ALIQUOTA_1, PREV_IMPONIBILE_1, PREV_IMPOSTA_1,PREV_ALIQUOTA_2, PREV_IMPONIBILE_2, PREV_IMPOSTA_2, PREV_ALIQUOTA_3, PREV_IMPONIBILE_3, PREV_IMPOSTA_3, PREV_TOT_IMPONIBILE, PREV_TOT_IMPOSTA, PREV_TOT_PREVENT, PREV_AGENTE, PREV_COD_PAG, PREV_IMPORTO_RAE, PREV_COMMESSO_PREV, PREV_RIGHE) VALUES ('$deposito', '$data_doc','$numero', '$cliente', '$PREV_ALIQUOTA_1', '$PREV_IMPONIBILE_1', '$PREV_IMPOSTA_1', '$PREV_ALIQUOTA_2', '$PREV_IMPONIBILE_2', '$PREV_IMPOSTA_2', '$PREV_ALIQUOTA_3', '$PREV_IMPONIBILE_3', '$PREV_IMPOSTA_3', '$PREV_TOT_IMPONIBILE', '$PREV_TOT_IMPOSTA', '$PREV_TOT_FATTURA', '$age', '$paga', '$PREV_IMPORTO_RAE', '$ute', '$righej')";
  }
else
  {
  $qr="UPDATE preventivi SET PREV_ALIQUOTA_1='$PREV_ALIQUOTA_1', PREV_IMPONIBILE_1='$PREV_IMPONIBILE_1', PREV_IMPOSTA_1='$PREV_IMPOSTA_1',PREV_ALIQUOTA_2='$PREV_ALIQUOTA_2', PREV_IMPONIBILE_2='$PREV_IMPONIBILE_2', PREV_IMPOSTA_2='$PREV_IMPOSTA_2', PREV_ALIQUOTA_3='$PREV_ALIQUOTA_3', PREV_IMPONIBILE_3='$PREV_IMPONIBILE_3', PREV_IMPOSTA_3='$PREV_IMPOSTA_3', PREV_TOT_IMPONIBILE='$PREV_TOT_IMPONIBILE', PREV_TOT_IMPOSTA='$PREV_TOT_IMPOSTA', PREV_TOT_PREVENT='$PREV_TOT_FATTURA', PREV_AGENTE='$age', PREV_COD_PAG='$paga', PREV_IMPORTO_RAE='$PREV_IMPORTO_RAE', PREV_COMMESSO_PREV='$ute', PREV_RIGHE='$righej' WHERE PREV_ID='$idt'";
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
$log=new scrivi_log($utente,"salva_doc: $qr");
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
