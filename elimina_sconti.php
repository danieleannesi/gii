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
$qr="DELETE FROM sconti WHERE CodCli='$cliente' AND classe='$classe' AND CodArtDa='$codiceda' AND CodArtA='$codicea' LIMIT 1";
mysql_query($qr,$con);
$success = false;
$msg = mysql_error();
//
//$msg=$qr;
$qr=addslashes($qr);
$log=new scrivi_log($utente,"elimina_sconti: $qr");
//
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nella eliminazione: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg);
header('Content-Type: application/json');
echo json_encode($resp);
?>
