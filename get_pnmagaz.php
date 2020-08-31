<?php
require 'include/database.php';
$idt=$_POST["idt"];
//
$res=array();
$res["errore"]="NON TROVATO";
$qr="SELECT * FROM movmag LEFT JOIN clienti ON cf_cod=mov_clifor WHERE mov_id='$idt'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $res["errore"]="0";
   }
//
header('Content-Type: application/json');
echo json_encode($res);
?>
