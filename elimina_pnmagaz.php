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
$qd2="DELETE FROM movmag WHERE mov_id='$idt' LIMIT 1";
mysql_query($qd2,$con);
$msg.= mysql_error();
$success = false;
//
$qd2=addslashes($qd2);
$log=new scrivi_log($utente,"elimina_movmag: $qd2");
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
