<?php
require 'include/database.php';
require 'include/idrobox.php';
require 'calcola_medio.php';
//
mysql_select_db($DB_NAME, $con);
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
$codice=$_POST["codice"];
//
//$codice="2471344151";
//
function truncate($number, $precision = 0) {
   // warning: precision is limited by the size of the int type
   $shift = pow(10, $precision);
   return intval($number * $shift)/$shift;
}
$oggi=date("Y-m-d");
$anno=date("Y");
$res=array();
//
////////articoli da gi////////////////////////////////////
$qr="SELECT * FROM articoli WHERE art_codice='$codice'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $listino=$row["art_listino2"];
   if($row["art_data_listino"]>$oggi || $row["art_data_listino"]=="2000-00-00")
     {
	 //$listino=$row["art_listino1"] . " " . $row["art_data_listino"] . " " . $oggi;
	 $listino=$row["art_listino1"];
	 }
   $res["listino"]=$listino;
   }
//
  //$a=print_r($res,true);
  //file_put_contents("test.txt", "$a\n", FILE_APPEND);
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
header('Content-Type: application/json');
echo json_encode($res);
?>
