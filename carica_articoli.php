<?php
session_start();
require_once "include/database.php";
require 'calcola_medio.php';
//
//lettura causali magazzino
unset($codcaus);
unset($descaus);
unset($causali);
$codcaus[]="";
$descaus[]="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't40%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
echo mysql_error();
while($row = mysql_fetch_array($rst)) {
     $tabcaus=json_decode($row["tab_resto"],true);
     $codcaus[]=substr($row["tab_key"],3,2);
     $descaus[]=substr($row["tab_key"],3,3) . " " . $tabcaus["DESCRIZIONE_CAUSALE"];
     $a=trim(substr($row["tab_key"],3,2));
     $tipo=$tabcaus["CAR_SCAR_INV_TRASF"];
     $causali[$a]=$tipo;     
	 }
//
//file_put_contents("testf.txt", "");
//
$codart=trim($_POST["codart"]);
$qr="SELECT art_codice, art_descrizione FROM articoli WHERE NOT art_codice < '$codart' and art_descrizione NOT LIKE '' ORDER BY art_codice LIMIT 1000";
$rst=mysql_query($qr,$con);
$lista_nomi = array();
$i=array();
$togli = array("'","\"");
while($row=mysql_fetch_assoc($rst)){

$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
//
$valori=calcola_valore_medio($row["art_codice"],$deposito,$dal,$al,"S");
$tqta="(" . $valori["tqta"] . ")";

//$a=print_r($valori,true);
//file_put_contents("testf.txt", $row["art_codice"] . " dep=$deposito dal=$dal al=$al\n", FILE_APPEND);
//file_put_contents("testf.txt", "$a\n", FILE_APPEND);

//$depositi=$valori["depo_val"];
//$res["valori"]=$valori;	
	
    $i["articolo"]=$row["art_codice"] . " " . $row["art_descrizione"] . " $tqta";
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