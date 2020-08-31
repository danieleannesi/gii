<?php
session_start();
require_once "include/database.php";
$qr="SELECT CY__ICODE, CY_CNAME FROM a_city ORDER BY CY_CNAME";
$rst=mysql_query($qr,$con);
$lista_nomi = array();
$i=array();
$togli = array("'","\"");
while($row=mysql_fetch_assoc($rst)){
  $i["articolo"]=$row["CY_CNAME"];
  $i["codice"]=$row["CY__ICODE"];
  $lista_nomi[] = $i;
}
$lista_nomi=json_encode($lista_nomi);
header('Content-Type: application/json');
echo $lista_nomi;
?>