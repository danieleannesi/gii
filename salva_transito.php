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
require 'include/java.php';
require 'class_varie.php';
//
foreach($_POST as $key=>$value){
  if (is_array($_POST[$key])) {
    $$key = $value;
  } else {
    $$key = mysql_real_escape_string($value);
  }
}
$data_final=addrizza("",$data_final);
$data_fattura=addrizza("",$data_fattura);
$num_fattura=addslashes($num_fattura);
//$data_final=date("Y-m-d");
if($azzera=="true")
  {
  $data_fattura="0000-00-00";  	
  $data_final="0000-00-00";  	
  $num_fattura="";  	
  }
//
$qw="UPDATE movmag SET mov_data_fattura='$data_fattura', mov_num_fattura='$num_fattura', mov_data_final='$data_final' WHERE mov_id='$id'";
mysql_query($qw,$con);
$msg.=mysql_error();
$qw=addslashes($qw);
$log=new scrivi_log($utente,"aggiorna transito movmag: $qw");
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
