<?php
require 'include/database.php';
require 'include/idrobox.php';
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
$codmar=substr($codice,0,3);
$codart=trim(substr($codice,3,30));
$qr="SELECT articoli.mar_codice, art_codiceproduttore,art_descrizioneridotta,art_um,art_conf,lis_prezzoeuro1,lis_datalistino,art_catsc,lcr_descrizione,art_immaginegrande,art_disegnotecnico,set_codice,mac_codice,fam_codice,lis_prezzoeuroprec FROM articoli LEFT JOIN abb_art_liscarrev ON articoli.art_codice=abb_art_liscarrev.art_codice AND articoli.mar_codice=abb_art_liscarrev.mar_codice LEFT JOIN liscarrev ON abb_art_liscarrev.lcr_id=liscarrev.lcr_id WHERE articoli.mar_codice='$codmar' AND BINARY art_codiceproduttore='$codart'";

file_put_contents("testi.txt",$qr);

$rst=mysql_query($qr,$idr);
while($row = mysql_fetch_assoc($rst)) {
   //$res=$row;
   $res["listino"]=$row["lis_prezzoeuro1"];
   $res["art_descrizione"]=$row["lcr_descrizione"];
   }
$res["raee"]=0;   
//sconti per cliente
$sconto=0;
$qr="SELECT * FROM sconti WHERE CodCli='$cliente' AND '$codice' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $sconti=$row;
  }
////////////////////
//sconti per classe
if($sconto==0)
  {
  $qr="SELECT * FROM sconti WHERE CodCli='00000000' AND classe='$classe' AND '$codice' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
    $sconti=$row;
    }
  }
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
