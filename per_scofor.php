<?php
require 'include/database.php';
require 'include/idrobox.php';
//
$mar_codice=$_POST["marca"];
$art_codiceproduttore=$_POST["codiceproduttore"];
//
//$mar_codice="BAX";
//$art_codiceproduttore="LSD79900101";
//
$res=per_scofor($mar_codice,$art_codiceproduttore);
//  
header('Content-Type: application/json');
echo json_encode($res);
exit;  
/////////////////////////////////////////////////////
function per_scofor($mar_codice,$art_codiceproduttore)
{
global $DB_NAME;
global $DBI_NAME;
global $idr;
global $con;
//
$oggi=date("Y-m-d");
$dataoggi=date("d/m/Y");
//
  mysql_select_db($DBI_NAME, $idr);
//
  $qi="SELECT articoli.mar_codice, art_codiceproduttore,art_descrizioneridotta,art_descrizionearticolo, art_descrizioneorigine, art_um,art_conf,lis_prezzoeuro1,lis_datalistino,art_catsc,lcr_descrizione,art_immaginegrande,art_disegnotecnico,set_codice,mac_codice,fam_codice,lis_prezzoeuroprec FROM articoli LEFT JOIN abb_art_liscarrev ON articoli.art_codice=abb_art_liscarrev.art_codice AND articoli.mar_codice=abb_art_liscarrev.mar_codice LEFT JOIN liscarrev ON abb_art_liscarrev.lcr_id=liscarrev.lcr_id WHERE articoli.mar_codice='$mar_codice' AND BINARY art_codiceproduttore='$art_codiceproduttore'";
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
  $desidro=$idro["art_descrizioneridotta"];
// 
  mysql_select_db($DB_NAME, $con);

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
     if($r==0)
       {
       $res["errore"]=1;
       return $res;
	   }
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
    
     $scoc=1 - $scofor["scf_sconto_1"] / 100;
     $scoc=$scoc * (1 - $scofor["scf_sconto_2"] / 100) * 
                   (1 - $scofor["scf_sconto_3"] / 100) * 
                   (1 - $scofor["scf_sconto_4"] / 100) * 
                   (1 - $scofor["scf_sconto_5"] / 100) *
                   (1 - $scofor["scf_sconto_agg_cl"] / 100).
     $scoc=floatval($scoc);
     $scoc=($scoc - 1) * 100;
     $scoc=$scoc*-1;
     $scoc=round($scoc,4);

  $cal_prezzo_ven=round(($cal_prezzo * $scofor["scf_ricarica"]),4);
  $res["sconto_for"]=$scoc;
  $res["cal_prezzo"]=$cal_prezzo;
  $res["cal_prezzo_acq"]=$cal_prezzo_acq;
  $res["listino"]=$cal_prezzo_ven;
  $res["codfor"]=$scofor["scf_codfor"];
  $res["descri"]=addslashes($desidro);
  $res["oggi"]=$dataoggi;
  $res["errore"]=0;
  $tabart=$scofor["scf_da_tabart"];

  $qr="SELECT * FROM articoli WHERE art_codice > '$tabart' LIMIT 1";
  $rst=mysql_query($qr, $con);
  while($row=mysql_fetch_assoc($rst)) {
        $res["articolo"]=$row;
	    }  
  //$a=print_r($res,true);
  //$b=print_r($scofor,true);
  //echo "$a";
  return $res;
} 
?>