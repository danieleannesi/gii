<?php
require 'include/database.php';
$codice=$_POST["codice"];
//$codice="90176000";
//
$trasp_perc=0;
$trasp_euro=0;
$res=array();
$qr="SELECT * FROM clienti WHERE cf_cod='$codice'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   }
//leggi tabella porto per trasporto
$porto=$res["cf_porto"];
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't52$porto'";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
     $tab_resto=json_decode($row["tab_resto"],true);
     $trasp_perc=$tab_resto["ADDEBITO_IN_PERCENT"]/100;
     $trasp_euro=$tab_resto["ADDEBITO_IN_LIRE"]/100;
	 }
$res["trasp_perc"]=$trasp_perc;
$res["trasp_euro"]=$trasp_euro;//
header('Content-Type: application/json');
echo json_encode($res);
?>
