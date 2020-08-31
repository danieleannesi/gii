<?php
require 'include/database.php';
$codice=$_POST["codice"];
$cliente=$_POST["cliente"];
//
$classe="";
$qr="SELECT cf_classe_sconto FROM clienti WHERE cf_cod='$cliente'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $classe=$row["cf_classe_sconto"];
  }
$oggi=date("Y-m-d");
$res=array();
$qr="SELECT * FROM articoli WHERE art_codice='$codice'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $listino=$row["art_listino2"];
   if($row["art_data_listino"]>$oggi)
     {
	 $listino=$row["art_listino1"] . " " . $row["art_data_listino"] . " " . $oggi;
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
   if($row["art_data_listino"]>$oggi)
     {
	 $listino=$row["art_listino1"] . " " . $row["art_data_listino"] . " " . $oggi;
	 }  	
   $res["raee"]=$listino;
   }
  }
//sconti per cliente
$sconto=0;
$qr="SELECT * FROM sconti WHERE CodCli='$cliente' AND '$codice' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $sconti=$row;
  }
////////////////////
//sconti per classe
$sconti=array(0,0,0,0,0,0);
if($sconto==0)
  {
  $qr="SELECT * FROM sconti WHERE CodCli='00000000' AND classe='$classe' AND '$codice' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
    $sconti=$row;
    }
  }
/*
$s=print_r($sconti,true);
file_put_contents("test.txt",$s);
*/  
$sco=100;
for($i=1;$i<7;$i++)
  {
  $scox=$sconti["Sconto".$i];
  $sco=$sco - ($sco * $scox / 100);
  }
$sco=100-$sco;
$res["sconto"]=$sco;  
//
header('Content-Type: application/json');
echo json_encode($res);
?>
