<?php
function get_articolofo($fornitore,$codice)
{
global $con;
//
$oggi=date("Y-m-d");
$res=array();
//
if(substr($fornitore,0,1)=="9")
  {
$qr="SELECT * FROM mgforn LEFT JOIN articoli ON mgf_codart=art_codice WHERE mgf_codart='$codice' AND mgf_codfor='$fornitore'";
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
if($art_codice_raee>"")
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
//
return $res;
}
?>
