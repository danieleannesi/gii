<?php
require 'include/database.php';
require 'include/idrobox.php';
require 'calcola_medio.php';
//
mysql_select_db($DB_NAME, $con);
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
$cliente=$_POST["cliente"];
//
//$codice="2471344151";
//$cliente="11962500";
//
function truncate($number, $precision = 0) {
   // warning: precision is limited by the size of the int type
   $shift = pow(10, $precision);
   return intval($number * $shift)/$shift;
}
//codice=2471344151&cliente=11962500
$oggi=date("Y-m-d");
$anno=date("Y");
$res=array();
//
mysql_select_db($DB_NAME, $con);
//leggi classe di sconto del cliente
$classe="";
$qr="SELECT cf_classe_sconto FROM clienti WHERE cf_cod='$cliente'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $classe=$row["cf_classe_sconto"];
  }
//fine leggi classe di sconto cliente
//
//file_put_contents("test.txt", "$qr\n");
//
RILEGGI:
//vedi se da idrobox
if(!is_numeric(substr($codice,0,1)))
  {
  mysql_select_db($DBI_NAME, $idr);
  $mar_codice=substr($codice,0,3);
  $art_codiceproduttore=substr($codice,3);
  $qi="SELECT articoli.mar_codice, art_codiceproduttore,art_descrizioneridotta,art_descrizionearticolo, art_descrizioneorigine, art_um,art_conf,lis_prezzoeuro1,lis_datalistino,art_catsc,lcr_descrizione,art_immaginegrande,art_disegnotecnico,set_codice,mac_codice,fam_codice,lis_prezzoeuroprec FROM articoli LEFT JOIN abb_art_liscarrev ON articoli.art_codice=abb_art_liscarrev.art_codice AND articoli.mar_codice=abb_art_liscarrev.mar_codice LEFT JOIN liscarrev ON abb_art_liscarrev.lcr_id=liscarrev.lcr_id WHERE articoli.mar_codice='$mar_codice' AND BINARY art_codiceproduttore='$art_codiceproduttore'";
  //$qi="SELECT * FROM articoli WHERE mar_codice='$mar_codice' AND art_codiceproduttore='$art_codiceproduttore'";
  
  file_put_contents("test.txt", "$qi\n");
  
  $rsi=mysql_query($qi,$idr);
  while($roi = mysql_fetch_assoc($rsi)) {
    $idro=$roi;
    }

  $art_um=$idro["art_um"];
  $set_codice=$idro["set_codice"];
  $mac_codice=$idro["mac_codice"];
  $fam_codice=$idro["fam_codice"];
  $art_catsc=$idro["art_catsc"];
  $lcr_descrizione=$idro["lcr_descrizione"];
//  
//leggi scofor per codice fornitore per vedere se esiste in mgforn
  mysql_select_db($DB_NAME, $con);
  $scf_codfor="";
  $qi="SELECT scf_marca, scf_codfor FROM scofor WHERE scf_marca='$mar_codice' GROUP BY scf_marca, scf_codfor";
  $rsi=mysql_query($qi,$con);
  while($roi = mysql_fetch_assoc($rsi)) {
    $scf_codfor=$roi["scf_codfor"];
    }
  if($scf_codfor>"")
    {
    $mgf_codart="";
    $qi="SELECT * FROM mgforn WHERE mgf_codfor='$scf_codfor' AND mgf_codprod='$art_codiceproduttore'";
    $rsi=mysql_query($qi,$con);
    while($roi = mysql_fetch_assoc($rsi)) {
      $mgf_codart=$roi["mgf_codart"];
      }
    if($mgf_codart>"")
      {
	  $codice=$mgf_codart;

      //file_put_contents("test.txt", "LETTO DA mgforn: $codice\n", FILE_APPEND);
	  
	  goto RILEGGI;
	  }		
	}
//fine vedi se esiste articolo codificato gi
//
  $scofor=array();
  
//CERCA TIPO 1 SU SCOFOR (prezzo netto)
     $qs="SELECT * FROM scofor WHERE scf_tipo='1' AND scf_marca='$mar_codice' AND '$art_codiceproduttore' BETWEEN scf_da_articolo AND scf_a_articolo";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }

//CERCA TIPO 3 SU SCOFOR (UM oppure SET oppure MAC o FAM)
     $idro_um=trim($idro["art_um"]);
     if($idro_um>"")
       {
       $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_um='$idro_um'";
       $qq.="$qs\n";
       $rss = mysql_query($qs, $con);
       $r=mysql_num_rows($rss);
       while($ros = mysql_fetch_array($rss)) {
          $scofor=$ros;     	
	      }
       if($r>0) {	goto TROVATO; }
       //CERCA PER UM E ARTICOLO
       $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_um='$idro_um' AND scf_a_articolo='$art_codiceproduttore'";
       $qq.="$qs\n";
       $rss = mysql_query($qs, $con);
       $r=mysql_num_rows($rss);
       while($ros = mysql_fetch_array($rss)) {
          $scofor=$ros;     	
	      }
       if($r>0) {	goto TROVATO; }
       //CERCA PER UM E ARTICOLO
       $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_um='$idro_um' AND NOT scf_a_articolo>'$art_codiceproduttore' AND NOT scf_da_articolo<'$art_codiceproduttore'";
       $qq.="$qs\n";
       $rss = mysql_query($qs, $con);
       $r=mysql_num_rows($rss);
       while($ros = mysql_fetch_array($rss)) {
          $scofor=$ros;     	
	      }
       if($r>0) {	goto TROVATO; }
	   }
     //CERCA PER SET
     $idro_set=$idro["set_codice"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_set='$idro_set' AND scf_mac='' AND scf_fam=''";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }
     //CERCA PER SET e MAC
     $idro_mac=$idro["mac_codice"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_set='$idro_set' AND scf_mac='$idro_mac' AND scf_fam=''";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }
    //CERCA PER SET e MAC e FAM
     $idro_fam=$idro["fam_codice"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_set='$idro_set' AND scf_mac='$idro_mac' AND scf_fam='$idro_fam'";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }

//CERCA TIPO 2 SU SCOFOR (listino generale)
     $idro_catsc=$idro["art_catsc"];
     $idro_listino=$idro["lcr_descrizione"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='2' AND scf_marca='$mar_codice' AND scf_catsc='$idro_catsc' AND scf_listino='$idro_listino'";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }
     
TROVATO:
   //if($r==0)
//
////////////////////////////////////////////////
  if($scofor["scf_netto"] > 0)
    {
	$cal_prezzo_acq=$scofor["scf_netto"];
	$cal_prezzo=$cal_prezzo_acq;
	}
  else
    {
    $data_listino=substr($idro["lis_datalistino"],0,10);
    $cal_prezzo=$idro["lis_prezzoeuro1"];
	$cal_prezzo_acq=$cal_prezzo;
    if($data_listino>$oggi)
      {
	  $cal_prezzo=$idro["lis_prezzoeuroprec"];
	  $cal_prezzo_acq=$cal_prezzo;
	  }
    $cal_prezzo_acq=$cal_prezzo_acq - $cal_prezzo_acq * $scofor["scf_sconto_1"] / 100;	  	
    $cal_prezzo_acq=$cal_prezzo_acq - $cal_prezzo_acq * $scofor["scf_sconto_2"] / 100;	  	
    $cal_prezzo_acq=$cal_prezzo_acq - $cal_prezzo_acq * $scofor["scf_sconto_3"] / 100;	  	
    $cal_prezzo_acq=$cal_prezzo_acq - $cal_prezzo_acq * $scofor["scf_sconto_4"] / 100;	  	
    $cal_prezzo_acq=$cal_prezzo_acq - $cal_prezzo_acq * $scofor["scf_sconto_5"] / 100;	  	
    $cal_prezzo_acq=round($cal_prezzo_acq,4);
	}
    
  $cal_prezzo_ven=round(($cal_prezzo * $scofor["scf_ricarica"]),4);
  $res["cal_prezzo"]=$cal_prezzo;
  $res["scf_ricarica"]=$scofor["scf_ricarica"];
  $res["art_descrizione"]=$idro["art_descrizionearticolo"] . " " . $idro["art_descrizioneorigine"];
  $res["art_codice"]=$codice;
  $res["listino"]=$cal_prezzo_ven;
  $res["raee"]=0;
  $codice=$scf_da_tabart;
  
  //$a=print_r($res,true);
  //file_put_contents("test.txt", "$a\n", FILE_APPEND);
 
  } //fine se da idrobox
else
  {
////////articoli da gi////////////////////////////////////
mysql_select_db($DB_NAME, $con);
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

  //$a=print_r($res,true);
  //file_put_contents("test.txt", "$a\n", FILE_APPEND);
  
  }  //se articolo gi
//sconti per cliente
$sconti=array(0,0,0,0,0,0);
$q1="";
$q2="";
$q3="";
$qr="SELECT * FROM sconti WHERE CodCli='$cliente' AND '$codice' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
$q1=$qr;
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $scc=$row;
  }
////////////////////
//sconti per classe
if($scc["Sconto1"]==0)
  {
  $qr="SELECT * FROM sconti WHERE CodCli='00000000' AND classe='$classe' AND '$codice' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
  $q2=$qr;
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
    $scc=$row;
    }
  }
//sconti generici
if($scc["Sconto1"]==0)
  {
  $q3=$qr;
  $qr="SELECT * FROM sconti WHERE CodCli='$cliente' AND '0000000001' BETWEEN CodArtDa AND CodArtA ORDER BY (CodArtA - CodArtDa) LIMIT 1";
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
    $scc=$row;
    }
  }

//$s=print_r($sconti,true);
//file_put_contents("test.txt","$q1\n$q2\n$q3", FILE_APPEND);

$sco=100;
for($i=1;$i<7;$i++)
  {
  $scox=$scc["Sconto".$i];
  $sco=$sco - ($sco * $scox / 100);
  }
$sco=100-$sco;
//$res["sconto"]=round($sco,2);  
$res["sconto"]=truncate($sco,2);
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
$qta_ord=ordini_per_articolo($codice,$dal,$al);
$res["ordinato"]=$qta_ord;
//
//$a=print_r($res,true);
//file_put_contents("test_get_articolo.txt", "$a - $qr - $qe");
//
header('Content-Type: application/json');
echo json_encode($res);
?>
