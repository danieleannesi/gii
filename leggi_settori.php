<?php
session_start();
require 'include/idrobox.php';
$marca = $_POST["marca"];
//$marca = "BAX";
$dati=array();
$qr = "SELECT * FROM abb_marche_settori LEFT JOIN tab_settori ON abb_marche_settori.set_codice=tab_settori.set_codice WHERE mar_codice = '$marca'";
$rst=mysql_query($qr,$idr);
while($row=mysql_fetch_assoc($rst)){
   $k=$row["set_codice"];
   $v=$row["set_descrizione"];
   $dati["$k"]=$v;
  }
//  
$success = false;
$msg = mysql_error();
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nella lettura: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "dati" => $dati);
header('Content-Type: application/json');
echo json_encode($resp);
?>
