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
$cot_magazzino="N";
$qr="SELECT cot_magazzino FROM contatori_tipi WHERE cot_tipo='$tipodoc'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $cot_magazzino=$row["cot_magazzino"];
  }
//
$qd1="";
$msg="";
$log=new scrivi_log($utente,"elimina_doc: $cliente - $tipodoc - $idt");
if($cot_magazzino=="S")
  {
  $qd1="DELETE FROM movmag WHERE mov_clifor='$cliente' AND mov_tipo_doc='$tipodoc' AND mov_id_rife='$idt'";
  mysql_query($qd1,$con);
  $msg = mysql_error();
  }
$qd2="DELETE FROM documtes WHERE DOCT_ID='$idt'";
mysql_query($qd2,$con);
$msg.= mysql_error();
$success = false;
//
$qd1=addslashes($qd1);
$qd2=addslashes($qd2);
$log=new scrivi_log($utente,"elimina_doc: $qd1 - $qd2 - $msg");
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
