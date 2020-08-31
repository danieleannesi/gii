<?php
require 'include/database.php';
require 'include/functions.php';
require 'class_varie.php';
session_start();
if(!isset($_SESSION["iddu"]))
  {
  echo "Sessione scaduta; <a href=\"login.php\">Effettuare il Login</a>"; exit;
  }
$iddu=$_SESSION["iddu"];
$ute=$_SESSION["ute"];
$utente=$iddu;

$sco_id = $_POST["sco_id"];  
$sql = "";
if(isset($sco_id)){
    $sql = "UPDATE scofor  SET scf_eliminato = 1 WHERE sco_id=".$sco_id;
}


mysql_query($sql,$con);
$success = false;
$msg = mysql_error();
$qr=addslashes($sql);
$log=new scrivi_log($utente,"delete_scofor: $qr");
//
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg); 
header('Content-Type: application/json');
echo json_encode($resp); 