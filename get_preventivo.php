<?php
require 'include/database.php';
$idt=$_POST["idt"];
//
$res=array();
$res["errore"]="NON TROVATO";
$qr="SELECT * FROM preventivi LEFT JOIN clienti ON cf_cod=PREV_CLIENTE WHERE PREV_ID='$idt'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $res["errore"]="0";
   }
//
$res["PREV_COMMESSO_PREV"]=sprintf("%03.0d",$res["PREV_COMMESSO_PREV"]);
header('Content-Type: application/json');
echo json_encode($res);
?>
