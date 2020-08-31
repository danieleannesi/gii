<?php
session_start();
require 'include/database.php';
$codice = $_POST["codicepaziente"];
$codfisc = $_POST["codfisc"];
$esiste=0;
$qr = "SELECT PA_IPERM FROM a_patient WHERE PA_IPERM = '$codice' LIMIT 1";
//file_put_contents("debug.txt", $qr);
$rst=mysql_query($qr,$con);
$esiste+=mysql_num_rows($rst);
$qr = "SELECT PA_IPERM FROM a_patient WHERE p_codfisc = '$codfisc' LIMIT 1";
$rst=mysql_query($qr,$con);
$esiste+=mysql_num_rows($rst);
//file_put_contents("debug.txt", $qr);
$resp = array("esiste" => $esiste);
header('Content-Type: application/json');
echo json_encode($resp);
?>
