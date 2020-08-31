<?php
$codiva=$_POST["codiva"];
require 'include/database.php';
//
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't44$codiva'";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabiva=json_decode($row["tab_resto"],true);
     $codiva=substr($row["tab_key"],3,2);
     $desiva=$tabiva["TITOLO_ESENZIONE"];
     $perciva=$tabiva["PERCENTUALE_IVA"];
	 }
//
$resp = array("descri" => $desiva, "perc" => $perciva);
header('Content-Type: application/json');
echo json_encode($resp);
?>
