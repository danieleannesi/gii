<?php
session_start();
require_once "include/database.php";
$qr="SELECT CR_ICTRY, CR_CNAME FROM a_country ORDER BY CR_CNAME";
$rst=mysql_query($qr,$con);
$lista_nomi = array();
$i=array();
$togli = array("'","\"");
while($row=mysql_fetch_assoc($rst)){
  $i["articolo"]=$row["CR_CNAME"];
  $i["codice"]=$row["CR_ICTRY"];
  $lista_nomi[] = $i;
}
$lista_nomi=json_encode($lista_nomi);
header('Content-Type: application/json');
echo $lista_nomi;
?>