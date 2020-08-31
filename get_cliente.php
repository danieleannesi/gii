<?php
require 'include/database.php';
$codice=$_POST["codice"];
//$codice="10028200";
//
$res=array();
$qr="SELECT * FROM clienti WHERE cf_cod='$codice'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   }
//leggi tabella porto per trasporto
$trasp_perc=0;
$trasp_euro=0;
$porto=$res["cf_porto"];
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't52$porto'";
$res["qr"]=$qr;
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
     $tab_resto=json_decode($row["tab_resto"],true);
     $trasp_perc=$tab_resto["ADDEBITO_IN_PERCENT"]/100;
     $trasp_euro=$tab_resto["ADDEBITO_IN_LIRE"]/100;
	 }
$res["trasp_perc"]=$trasp_perc;
$res["trasp_euro"]=$trasp_euro;   
//
$nord=0;
$qr="SELECT ORDI_EVASO FROM ordini WHERE ORDI_CLIENTE='$codice' AND (ORDI_EVASO IS NULL OR ORDI_EVASO='')";
$rst=mysql_query($qr,$con);
$nord=mysql_num_rows($rst);
$res["nord"]=$nord;
//
$nprev=0;
$qr="SELECT PREV_ORDINATO FROM preventivi WHERE PREV_CLIENTE='$codice' AND (PREV_ORDINATO IS NULL OR PREV_ORDINATO='')";
$rst=mysql_query($qr,$con);
$nprev=mysql_num_rows($rst);
$res["nprev"]=$nprev;
//
header('Content-Type: application/json');
echo json_encode($res);
?>
