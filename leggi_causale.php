<?php
session_start();
require 'include/database.php';
$causale = $_POST["causale"];
$dati=array();
$qr="SELECT * FROM tabelle WHERE tab_key='t40$causale'";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
   $tabcaus=json_decode($row["tab_resto"],true);
   $dati["clifor"]=$tabcaus["C=CLIEN_-_F=FORNIT"];
   $dati["dadepos"]=$tabcaus["DA_DEPOS_A_DEPOS_S_N"];
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
