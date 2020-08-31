<?php
require_once "include/database.php";
$lista=array();
$qr="SELECT * FROM contatori_tipi WHERE cot_tipo_doc='S' ORDER BY cot_ordine";
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
  $lista[]=$row;
}
$ret=json_encode($lista);
header('Content-Type: application/json');
echo $ret;
?>