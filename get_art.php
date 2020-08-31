<?php
require 'include/database.php';
require 'calcola_medio.php';
$codice=$_POST["codice"];
//
$res=array();
$qr="SELECT * FROM articoli WHERE art_codice='$codice'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   }
//

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
header('Content-Type: application/json');
echo json_encode($res);
?>
