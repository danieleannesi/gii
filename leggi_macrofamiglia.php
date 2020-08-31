<?php
session_start();
require 'include/idrobox.php';
$marca = $_POST["marca"];
$settore = $_POST["settore"];
//$marca = "BAX";
$dati=array();
$qr = "SELECT * FROM abb_marche_macrofamiglie LEFT JOIN tab_macrofamiglie ON abb_marche_macrofamiglie.set_codice=tab_macrofamiglie.set_codice WHERE mar_codice = '$marca' AND tab_macrofamiglie.set_codice='$settore' GROUP BY mac_descrizione ORDER BY tab_macrofamiglie.mac_descrizione";
$rst=mysql_query($qr,$idr);
while($row=mysql_fetch_assoc($rst)){
   $k=$row["mac_codice"];
   $v=$row["mac_descrizione"];
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
