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
foreach($_POST as $key=>$value){
  if (is_array($_POST[$key])) {
    $$key = $value;
  } else {
    $$key = mysql_real_escape_string($value);
  }
}
//
if(trim($cliente)=="")
  {
  $cliente="00000000";
  }
$qr = "REPLACE INTO sconti (CodCli, classe, CodArtDa, CodArtA, PrezzoUni, Sconto1, Sconto2, Sconto3, Sconto4, Sconto5, Sconto6 ) VALUES('$cliente', '$classe', '$codiceda', '$codicea', '$unitario', '$sconto1', '$sconto2', '$sconto3', '$sconto4', '$sconto5', '$sconto6')";
mysql_query($qr,$con);
$success = false;
$msg = mysql_error();
//
//$msg=$qr;
$qr=addslashes($qr);
$log=new scrivi_log($utente,"salva_sconti: $qr");
//
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg);
header('Content-Type: application/json');
echo json_encode($resp);
?>
