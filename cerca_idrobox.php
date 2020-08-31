<?php
session_start();
require 'include/idrobox.php';
$marca = $_POST["marca"];
$settore = $_POST["settore"];
$macrofamiglia = $_POST["macrofamiglia"];
$famiglia = $_POST["famiglia"];
$cerca = $_POST["cerca"];
$cercain = $_POST["cercain"];
$rice="1=1 ";
if($marca>"") { $rice.=" AND mar_codice='$marca'"; }
if($settore>"") { $rice.=" AND set_codice='$settore'"; }
if($macrofamiglia>"") { $rice.=" AND mac_codice='$macrofamiglia'"; }
if($famiglia>"") { $rice.=" AND fam_codice='$famiglia'"; }
if($cercain=="d")
  {
  if($cerca>"") { $rice.="AND art_descrizioneestesa LIKE '%$cerca%'"; }
  }
if($cercain=="c")
  {
  if($cerca>"") { $rice.="AND art_codiceproduttore LIKE '%$cerca%'"; }
  }
$dati="<table>";
$qr = "SELECT * FROM articoli WHERE $rice ORDER BY art_descrizioneorigine LIMIT 500";
file_put_contents("testidro.txt", $qr);
$rst=mysql_query($qr,$idr);
$quanti=mysql_num_rows($rst);
while($row=mysql_fetch_assoc($rst)){
   $a=$row["mar_codice"];
   $b=$row["art_codiceproduttore"];
   $d=$row["art_descrizionearticolo"] . " " . $row["art_descrizioneorigine"];
   $h=htmlentities($d);
   $dati.="<tr class='r' onclick=\"cliccato('$a','$b','$h');\"><td>$a</td><td>$b</td><td>$d</td></tr>";
  }
$dati.="</table>";
//  
$success = false;
$msg = mysql_error();
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nella lettura articoli: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "quanti" => $quanti, "dati" => $dati);
header('Content-Type: application/json');
echo json_encode($resp);
?>
