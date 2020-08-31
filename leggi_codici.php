<?php
//lettura codici iva
unset($codiva);
unset($desiva);
unset($perciva);
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't44%' ORDER BY tab_ord";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabiva=json_decode($row["tab_resto"],true);
     $codiva[]=substr($row["tab_key"],3,2);
     $desiva[]=substr($row["tab_key"],3,3) . " " . $tabiva["TITOLO_ESENZIONE"];
     $perciva[]=$tabiva["PERCENTUALE_IVA"];
	 }
//	
//leggi codici pagamento
  unset($codpaga);
  unset($despaga);
  $codpaga[]="";
  $despaga[]="";
  $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't66%' ORDER BY tab_ord";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi codici pag) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) { 
     $tabpag=json_decode($row["tab_resto"],true);
     $codpaga[]=substr($row["tab_key"],3,3);
     $despaga[]=substr($row["tab_key"],3,3) . " " . $tabpag["DESCRIZ_PAGAMENTO"];
	 }
//fine leggi codici pag/////////////////////////////////////////////////////////////////////////
//
//leggi codici agenti
  unset($codage);
  unset($desage);
  $codage[]="";
  $desage[]="";
  $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't42%'  and tab_eliminato = 0 ORDER BY tab_key";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi codici age) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) { 
     $tabage=json_decode($row["tab_resto"],true);
     $codage[]=substr($row["tab_key"],3,3);
     $desage[]=substr($row["tab_key"],3,3) . " " . $tabage["NOME_AGENTE"];
	 }
//fine leggi codici agenti/////////////////////////////////////////////////////////////////////
//
//leggi commessi e agenti da tabelle
  unset($codcom);
  unset($descom);
  $codcom[]="";
  $descom[]="";
  $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't63%'  and tab_eliminato = 0 ORDER BY tab_key";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi codici commesso) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) { 
     $tabcom=json_decode($row["tab_resto"],true);
     $codcom[]=substr($row["tab_key"],3,3);
     $descom[]=substr($row["tab_key"],3,3) . " " . $tabcom["NOME_COMMESSO"];
	 }
 //leggi agenti
 /* $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't42%' ORDER BY tab_key";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi codici commesso) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) { 
     $tabcom=json_decode($row["tab_resto"],true);
     $codcom[]=substr($row["tab_key"],3,3);
     $descom[]=substr($row["tab_key"],3,3) . " " . $tabcom["NOME_AGENTE"];
	 }*/
//fine leggi codici commesso/////////////////////////////////////////////////////////////////////
//
//leggi depositi da tabelle
  unset($coddep);
  unset($desdep);
  unset($fitdep);
  $coddep[]="";
  $desdep[]="";
  $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't46%' ORDER BY tab_key";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi depositi) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) {
     $tabdep=json_decode($row["tab_resto"],true);
     $coddep[]=substr($row["tab_key"],3,3);
     $desdep[]=substr($row["tab_key"],3,3) . " " . $tabdep["DESCRIZDEPOSITO"] . " " . $tabdep["INDIRIZZO"];
     $fitdep[trim(substr($row["tab_key"],3,3))]=$tabdep["DEPOSITO_FITTIZIO"];
	 }
//fine leggi depositi/////////////////////////////////////////////////////////////////////////
//
//lettura classi di sconto
unset($codclasse);
unset($desclasse);
$codclasse[]="";
$desclasse[]="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't74%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabclasse=json_decode($row["tab_resto"],true);
     $codclasse[]=substr($row["tab_key"],3,2);
     $desclasse[]=substr($row["tab_key"],3,3) . " " . $tabclasse["DESCRIZCLASSE"];
	 }
//
//lettura tipi clienti
unset($codtipo);
unset($desctipo);
$codtipo[]="";
$desctipo[]="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't47%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabtipo=json_decode($row["tab_resto"],true);
     $codtipo[]=substr($row["tab_key"],3,2);
     $desctipo[]=substr($row["tab_key"],3,3) . " " . $tabtipo["DESCRIZ_SOTTOCONTO"];
	 }
//	
//lettura unita misura
unset($codunita);
unset($descunita);
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't83%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabtipo=json_decode($row["tab_resto"],true);
     $codunita[]=substr($row["tab_key"],3,2);
     $descunita[]=substr($row["tab_key"],3,3) . " " . $tabtipo["DESCRIZ_4_CARATTERI"];
	 }
//
//lettura classe merceologica
unset($codmerc);
unset($descmerc);
$codmerc[]="";
$descmerc[]="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't49%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabtipo=json_decode($row["tab_resto"],true);
     $codmerc[]=substr($row["tab_key"],3,3);
     $descmerc[]=substr($row["tab_key"],3,3) . " " . $tabtipo["DESCRIZIONE"];
	 }
//
//lettura causali magazzino
unset($codcaus);
unset($descaus);
unset($causali);
$codcaus[]="";
$descaus[]="";
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't40%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
 while($row = mysql_fetch_array($rst)) {
     $tabcaus=json_decode($row["tab_resto"],true);
     $codcaus[]=substr($row["tab_key"],3,2);
     $descaus[]=substr($row["tab_key"],3,3) . " " . $tabcaus["DESCRIZIONE_CAUSALE"];
     $a=trim(substr($row["tab_key"],3,2));
     $tipo=$tabcaus["CAR_SCAR_INV_TRASF"];
     $causali[$a]=$tipo;     
	 }
//	
//lettura classe di sconto
unset($codclasse);
unset($desclasse);
$codclasse[]="21"; $desclasse[]="21";
$codclasse[]="22"; $desclasse[]="22";
$codclasse[]="23"; $desclasse[]="23";
//
$codclasse[]="01"; $desclasse[]="01";
$codclasse[]="02"; $desclasse[]="02";
$codclasse[]="03"; $desclasse[]="03";
$codclasse[]="04"; $desclasse[]="04";
$codclasse[]="05"; $desclasse[]="05";
$codclasse[]="06"; $desclasse[]="06";
$codclasse[]="07"; $desclasse[]="07";
$codclasse[]="08"; $desclasse[]="08";
$codclasse[]="09"; $desclasse[]="09";
$codclasse[]="10"; $desclasse[]="10";
//
?>