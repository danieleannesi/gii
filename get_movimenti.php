<?php
require 'include/database.php';
$anno=$_POST["anno"];
$numero=$_POST["numero"];
$fornitore=$_POST["fornitore"];
/*
$anno="2020";
$numero="5983";
$fornitore="90123700";
*/
//
$res=array();
$res["errore"]="NON TROVATO";
$qr="SELECT * FROM movmag LEFT JOIN articoli ON mov_codart=art_codice WHERE mov_clifor='$fornitore' AND mov_doc='$numero' AND mov_data LIKE '$anno%' AND mov_causale='02'";
//$res["qr"]=$qr;
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res["righe"]["id"][]=$row["mov_id"];
   $res["righe"]["data_mov"][]=$row["mov_data"];
   $res["righe"]["codart"][]=$row["mov_codart"];
   $res["righe"]["desart"][]=addslashes($row["art_descrizione"]);
   $res["righe"]["dep"][]=$row["mov_dep"];
   $res["righe"]["qua"][]=$row["mov_qua"];
   $res["righe"]["prezzo"][]=$row["mov_prezzo"];
   $res["righe"]["sconto"][]=$row["mov_sconto"];
   $res["righe"]["totale"][]=$row["mov_totale"];
   $res["righe"]["num_fattura"][]=$row["mov_num_fattura"];
   $res["righe"]["data_fattura"][]=$row["mov_data_fattura"];
   $res["righe"]["data_final"][]=$row["mov_data_final"];
   $res["errore"]="0";
   }
//
header('Content-Type: application/json');
echo json_encode($res);
?>
