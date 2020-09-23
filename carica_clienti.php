<?php
session_start();
require_once "include/database.php";
$ragsoc=addslashes(trim($_POST["ragsoc"]));
//$ragsoc=addslashes(trim("d'eramo"));
$qr="SELECT * FROM clienti WHERE cf_cli_for='1' AND cf_eliminato=0 AND cf_ragsoc LIKE '$ragsoc%' ORDER BY cf_ragsoc";
$rst=mysql_query($qr,$con);
$lista_nomi = array();
$i=array();
$togli = array("'","\"");
while($row=mysql_fetch_assoc($rst)){
  if($row["cf_ragsoc"]>"")
    {
    //$i["articolo"]=$row["cf_cod"] . " " . $row["cf_ragsoc"];
    $i["articolo"]=$row["cf_ragsoc"];
    $i["codice"]=$row["cf_cod"];
    $i["terzo"]="";
    $i["quarto"]="";    
    $lista_nomi[] = $i;
	}
}
//
$qr="SELECT * FROM clienti WHERE cf_cli_for='1' AND cf_eliminato=0 AND cf_ragsoc LIKE '%$ragsoc%' AND NOT cf_ragsoc LIKE '$ragsoc%' ORDER BY cf_ragsoc";
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
  if($row["cf_ragsoc"]>"")
    {
    $i["articolo"]=$row["cf_ragsoc"];
    $i["codice"]=$row["cf_cod"];
    $i["terzo"]="";
    $i["quarto"]="";    
    $lista_nomi[] = $i;
	}
}
//$a=print_r($lista_nomi,true);
//file_put_contents("testf.txt", "$a - $qr");
$lista_nomi=json_encode($lista_nomi);
header('Content-Type: application/json');
echo $lista_nomi;
?>