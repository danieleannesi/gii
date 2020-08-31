<?php
session_start();
require_once "include/database.php";
$desart=$_POST["desart"];
$qr="SELECT art_codice, art_descrizione FROM articoli WHERE art_descrizione LIKE '$desart%' ORDER BY art_descrizione";
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
//
$qr="SELECT art_codice, art_descrizione FROM articoli WHERE art_descrizione LIKE '%$desart%' AND NOT art_descrizione LIKE '$desart%' ORDER BY art_descrizione";
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
    $i["articolo"]=$row["art_codice"] . " " . $row["art_descrizione"];
    $i["codice"]=$row["art_codice"];
    $i["terzo"]=$row["art_descrizione"];
    $i["quarto"]="";    
    $lista_nomi[] = $i;
}
//
$lista_nomi=json_encode($lista_nomi);
header('Content-Type: application/json');
echo $lista_nomi;
?>