<?php
session_start();
require 'include/idrobox.php';
$marca = $_POST["marca"];
$settore = $_POST["settore"];
$macrofamiglia = $_POST["macrofamiglia"];
$dati=array();
$qr = "SELECT * FROM abb_marche_famiglie LEFT JOIN tab_famiglie ON abb_marche_famiglie.set_codice=tab_famiglie.set_codice WHERE mar_codice = '$marca' AND tab_famiglie.set_codice='$settore' AND tab_famiglie.mac_codice='$macrofamiglia' GROUP BY fam_descrizione ORDER BY tab_famiglie.fam_descrizione";
$rst=mysql_query($qr,$idr);
while($row=mysql_fetch_assoc($rst)){
   $k=$row["fam_codice"];
   $v=$row["fam_descrizione"];
   $dati["$k"]=$v;
  }
//  
$success = false;
$msg = mysql_error();
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nella lettura famiglie: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "dati" => $dati);
header('Content-Type: application/json');
echo json_encode($resp);
?>
