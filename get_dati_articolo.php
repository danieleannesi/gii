<?php
require 'include/database.php';
//require 'include/idrobox.php';
//require 'calcola_medio.php';
$codice=$_POST["codice"];
//$codice="5314205250";
//
$oggi=date("Y-m-d");
$res=array();
//
mysql_select_db($DB_NAME, $con);
$qr="SELECT * FROM mgforn LEFT JOIN articoli ON mgf_codart=art_codice WHERE mgf_codart='$codice' LIMIT 1";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   }
/*
$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
//
$valori=calcola_valore_medio($codice,$deposito,$dal,$al,"S");
$res["val_medio"]=$valori["nw_medio"];
$valori=calcola_valore_medio($codice,$deposito,$dal,$al,"N");
$res["tqta"]=$valori["tqta"];
$res["depositi"]=$valori["depo_val"];
$res["valori"]=$valori;
//
$qta_ord=ordini_per_articolo($codice,$dal,$al);
$res["ordinato"]=$qta_ord;
*/
//
//$a=print_r($res,true);
//file_put_contents("testf.txt", "$a - $qr - $qe");
//
header('Content-Type: application/json');
echo json_encode($res);
?>
