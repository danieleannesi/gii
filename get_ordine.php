<?php
require 'include/database.php';
$idt=$_POST["idt"];
$n_ordine=$_POST["n_ordine"];
//
$res=array();
$res["errore"]="NON TROVATO";
if($idt>""){
   $qr="SELECT * FROM ordini LEFT JOIN clienti ON cf_cod=ORDI_CLIENTE WHERE ORDI_ID='$idt'";
}

if($n_ordine>""){
   $qr="SELECT * FROM ordini LEFT JOIN clienti ON cf_cod=ORDI_CLIENTE WHERE ORDI_NUM_DOC='$n_ordine'";
}

$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $res["errore"]="0";
   }
//
header('Content-Type: application/json');
echo json_encode($res);
?>
