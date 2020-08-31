<?php
session_start();
require_once "include/database.php";
$codart=trim($_POST["codart"]);
$qr="SELECT art_codice, art_descrizione FROM articoli WHERE NOT art_codice < '$codart' and art_descrizione NOT LIKE '' ORDER BY art_codice LIMIT 200";
$rst=mysql_query($qr,$con);
$lista_nomi = array();
$i=array();
$togli = array("'","\"");
while($row=mysql_fetch_assoc($rst)){
    $i["articolo"]=$row["art_codice"] . " " . $row["art_descrizione"];
    $i["codice"]=$row["art_codice"];
    $i["terzo"]=$row["art_descrizione"];
    $i["quarto"]="";    
    $lista_nomi[] = $i;
}
//$a=print_r($lista_nomi,true);
//file_put_contents("testf.txt", "$a - $qr");
$lista_nomi=json_encode($lista_nomi);
header('Content-Type: application/json');
echo $lista_nomi;
?>