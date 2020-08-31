<?php
require 'include/database.php';
require 'include/idrobox.php';
require 'calcola_medio.php';
$codice=$_POST["codice"];
$fornitore=$_POST["fornitore"];
//
function truncate($number, $precision = 0) {
   // warning: precision is limited by the size of the int type
   $shift = pow(10, $precision);
   return intval($number * $shift)/$shift;
}
//
//$codice="5314205250";
//$fornitore="90609000";
//
$oggi=date("Y-m-d");
$res=array();
//
mysql_select_db($DB_NAME, $con);
if(substr($fornitore,0,1)=="9")
  {
$qr="SELECT * FROM mgforn LEFT JOIN articoli ON mgf_codart=art_codice WHERE mgf_codart='$codice' AND mgf_codfor like '%$fornitore%' ";
 
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $listino=$row["mgf_pr_listino2"];
   if($row["mgf_data_listino"]>$oggi || $row["mgf_data_listino"]=="2000-00-00")
     {
	 $listino=$row["mgf_pr_listino"];
	 }
   $res["listino"]=$listino;

   $netto=$row["mgf_pr_netto2"];
   if($row["mgf_data_listino"]>$oggi || $row["mgf_data_listino"]=="2000-00-00")
     {
	 $netto=$row["mgf_pr_netto"];
	 }
   if($netto>0)
     {
     $res["listino"]=$netto;
	 }
//sconto
   $sconto=$row["mgf_sconto2"];
   if($row["mgf_data_sconto"]>$oggi || $row["mgf_data_sconto"]=="2000-00-00")
     {
	 $sconto=$row["mgf_sconto"];
	 }
   $res["sconto"]=$sconto;
//
   }
$res["raee"]=0;   
$art_codice_raee=$res["art_codice_raee"];  
if($art_codice_raee!="")
  {
  $qe="SELECT art_data_listino, art_listino1, art_listino2 FROM articoli WHERE art_codice='$art_codice_raee'";
  $rst=mysql_query($qe,$con);
  while($row = mysql_fetch_assoc($rst)) {
   $listino=$row["art_listino2"];
   if($row["art_data_listino"]>$oggi || $row["art_data_listino"]=="2000-00-00")
     {
	 $listino=$row["art_listino1"];
	 }  	
   $res["raee"]=$listino;
   }
  }
  } //fornitore presente
else
  {
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
$res["raee"]=0;   
$art_codice_raee=$res["art_codice_raee"]; 
if($art_codice_raee>"")
  {
  $qr="SELECT * FROM articoli WHERE art_codice='$art_codice_raee'";
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
   $listino=$row["art_listino2"];
   if($row["art_data_listino"]>$oggi || $row["art_data_listino"]=="2000-00-00")
     {
	 //$listino=$row["art_listino1"] . " " . $row["art_data_listino"] . " " . $oggi;
	 $listino=$row["art_listino1"];
	 }  	
   $res["raee"]=$listino;
   }
  }
  } //cliente
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
//
//$a=print_r($res,true);
//file_put_contents("testf.txt", "$a - $qr - $qe");
//
header('Content-Type: application/json');
echo json_encode($res);
?>
