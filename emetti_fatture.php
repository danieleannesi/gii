<?php
session_start();
if(!isset($_SESSION["iddu"]))
  {
  echo "Sessione scaduta; <a href=\"login.php\">Effettuare il Login</a>"; exit;
  }
$iddu=$_SESSION["iddu"];
$ute=$_SESSION["ute"];
$utente=$iddu;
//
set_time_limit(6000);
//
require 'include/database.php';
require 'include/java.php';
require 'include/functions.php';
require 'class_varie.php';
require 'leggi_codici.php';
//
function somma_totali($tot,$raee,$ali)
{
global $imponibile;
global $tot_raee;
if(isset($imponibile["$ali"]))
  {
  $imponibile["$ali"]+=floatval($tot);
  $imponibile["$ali"]+=floatval($raee);
  $tot_raee+=floatval($raee);
  }
else
  {
  $imponibile["$ali"]=floatval($tot);
  $imponibile["$ali"]+=floatval($raee);
  $tot_raee=floatval($raee);
  }
}
// fine somma_totali
//
function leggi_tabelle($codice)
{
$ret=Array();
global $con;
$qr="SELECT * FROM tabelle WHERE tab_key = '$codice'";
$rsi = mysql_query($qr, $con);
while($roi = mysql_fetch_array($rsi)) {
	   $ret=$roi;
	   }
return $ret["tab_resto"];
}
//
function calcola_scadenze($data, $importo, $codpag, $cliente)
{
$dati=array();
$spese_incasso=0;
//
$ret=leggi_tabelle("t66$codpag");
$roi=json_decode($ret,true);
$tipo_pagamento=$roi["TIPO_PAGAMENTO"];
$fine_mese=intval($roi["1=FM_O_GG_RITARDO"]);
$gg1=intval($roi["GIORNI_PRIMASCAD"]);
$gg2=intval($roi["GIORNI_SECONDASCAD"]);
$gg3=intval($roi["GIORNI_TERZASCAD"]);
$gg4=intval($roi["GIORNI_QUARTASCAD"]);
$gg5=intval($roi["GG_5_SC_O_CPAG_FIRM"]);
$gg_scad[]=$gg1;
if($gg2>0) { $gg_scad[]=$gg1+$gg2; }
if($gg3>0) { $gg_scad[]=$gg1+$gg2+$gg3; }
if($gg4>0) { $gg_scad[]=$gg1+$gg2+$gg3+$gg4; }
if($gg5>0) { $gg_scad[]=$gg1+$gg2+$gg3+$gg4+$gg5; }
//
$data_ini=$data;
$nsca=count($gg_scad);
$rata=round($importo/$nsca,2);
$tot=$rata*$nsca;
$ultima=$rata + ($importo-$tot);
$max=$nsca-1;
for($j=0;$j<$nsca;$j++)
  {
  $gg=$gg_scad[$j];
  $data=strtotime ("+$gg day", strtotime($data_ini));
  $data=date('Y-m-d',$data);
  if($fine_mese>0)
    {
    $fm=cal_days_in_month(CAL_GREGORIAN, substr($data,5,2), substr($data,0,8));
    $data=substr($data,0,8) . sprintf("%02d",$fm);
	}
  if($fine_mese>1)
    {
    $data=strtotime ("+$fine_mese day", strtotime($data));
    $data=date('Y-m-d',$data);
	}	
  $data_sca[$j]=$data;
  if($j==$max)
    {
	$rata=$ultima;
	}
  $imp_sca[$j]=$rata;
  }
if($tipo_pagamento=="4" && $fine_mese>0)
  {
  $spese_incasso=3.62*$nsca;
  }
//$dati["gg_scad"]=$gg_scad;
$dati["data"]=$data_sca;
$dati["importo"]=$imp_sca;
if($importo==0)
  {
  $dati["spese_incasso"]=$spese_incasso;
  }
/*
$aa=print_r($dati,true);
file_put_contents("testscade.txt","$data_ini - $importo - $codpag - $spese_incasso - $cliente\n$aa\n", FILE_APPEND);
*/
return json_encode($dati);
}
//
$alla_data=addrizza("",$_POST["alla_data"]);
$anno=substr($alla_data,0,4);
$prima=0;
$ultima=0;
//
//elenco ddt da emettere --------------------------------------
$j=0;
unset($emesse);
$qr="SELECT DOCT_CLIENTE, DOCT_COD_PAG, DOCT_CIG, DOCT_CUP FROM documtes WHERE DOCT_DATA_FATTURA='0000-00-00' AND NOT DOCT_DATA_DOC > '$alla_data' AND DOCT_TIPO_DOC='1' GROUP BY DOCT_CLIENTE, DOCT_COD_PAG, DOCT_CIG, DOCT_CUP ORDER BY DOCT_CLIENTE, DOCT_DATA_DOC";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $emesse[$j]["cliente"]=$row["DOCT_CLIENTE"];
   $emesse[$j]["cod_pag"]=$row["DOCT_COD_PAG"];
   $emesse[$j]["cig"]=$row["DOCT_CIG"];
   $emesse[$j]["cup"]=$row["DOCT_CUP"];
   $j++;
   }   
// fine elenco-------------------------------------------------
//
$res["numeri"]="";
$numero=0;
//
for($f=0; $f<count($emesse); $f++)
  {
//azzera tutto
  $msg="";
  unset($frighe);
  unset($ele_ddt);
  $imponibile=array();
  $imposta=array();  
  $DOCT_TRASPORTO=0;
  $DOCT_INSTALLAZ=0;
  $DOCT_JOLLY=0;
  $DOCT_NOLEGGIO=0;
  $DOCT_COLLAUDO=0;
  $DOCT_EUROPALLET=0;
  $DOCT_ADDVARI=0;
  $DOCT_TOT_IMPONIBILE=0;
  $DOCT_TOT_IMPOSTA=0;
  $DOCT_TOT_FATTURA=0;
  for($p=1; $p<6; $p++) 
    {
    $ali_j="DOCT_ALIQUOTA_" . $p;
    $imponibile_j="DOCT_IMPONIBILE_" . $p;  
    $imposta_j="DOCT_IMPOSTA_" . $p;  
    $$ali_j="";
    $$imponibile_j=0;
    $$imposta_j=0;
    }
  $tot_raee=0;
  $scadenzej="";
  $r=0;
//fine azzera  
  $cliente=$emesse[$f]["cliente"];
  $cod_pag=$emesse[$f]["cod_pag"];
  $cig=$emesse[$f]["cig"];
  $cup=$emesse[$f]["cup"];
  $qr="SELECT * FROM documtes WHERE DOCT_DATA_FATTURA='0000-00-00' AND NOT DOCT_DATA_DOC > '$alla_data' AND DOCT_CLIENTE='$cliente' AND DOCT_COD_PAG='$cod_pag' AND DOCT_CIG='$cig' AND DOCT_CUP='$cup' AND DOCT_TIPO_DOC='1' ORDER BY DOCT_CLIENTE, DOCT_DATA_DOC";
  $rst=mysql_query($qr,$con);
  while($row = mysql_fetch_assoc($rst)) {
     $righe=json_decode($row["DOCT_RIGHE"],true);

     $age=$row["DOCT_AGENTE"];
     $DOCT_TRASPORTO+=$row["DOCT_TRASPORTO"];
     $DOCT_INSTALLAZ+=$row["DOCT_INSTALLAZ"];
     $DOCT_JOLLY+=$row["DOCT_JOLLY"];
     $DOCT_NOLEGGIO+=$row["DOCT_NOLEGGIO"];
     $DOCT_COLLAUDO+=$row["DOCT_COLLAUDO"];
     $DOCT_EUROPALLET+=$row["DOCT_EUROPALLET"];
     $DOCT_ADDVARI+=$row["DOCT_ADDVARI"];

     $ele_ddt[]=$row["DOCT_ID"];
     $frighe["cod"][$r]="";
     $frighe["desc"][$r]="Documento " . $row["DOCT_NUM_DOC"] . " Del " . addrizza($row["DOCT_DATA_DOC"],"");
     $frighe["qta"][$r]=0;
     $frighe["uni"][$r]=0;
     $frighe["sco"][$r]=0;
     $frighe["tot"][$r]=0;
     $frighe["iva"][$r]=$row["DOCT_ALIQUOTA_1"];
     $frighe["raee"][$r]=0;
     $frighe["ordine"][$r]=0;
     $r++;
     
     for($j=0;$j<count($righe["cod"]);$j++)
       {
       $frighe["cod"][$r]=$righe["cod"][$j];
       $frighe["desc"][$r]=$righe["desc"][$j];
       $frighe["qta"][$r]=$righe["qta"][$j];
       $frighe["uni"][$r]=$righe["uni"][$j];
       $frighe["sco"][$r]=$righe["sco"][$j];
       $frighe["tot"][$r]=$righe["tot"][$j];
       $frighe["iva"][$r]=$righe["iva"][$j];
       $frighe["raee"][$r]=$righe["raee"][$j];
       $frighe["ordine"][$r]=$righe["ordine"][$j];
       somma_totali($righe["tot"][$j],$righe["raee"][$j],$righe["iva"][$j]);
       $r++;
	   }
     } //fine while   
//
//totali
//
//calcola spese incasso con totale zero
$scadenzej=calcola_scadenze($alla_data, 0, $cod_pag, $cliente);
$scade=json_decode($scadenzej,true);
$spese_incasso=$scade["spese_incasso"];
//
//cerca aliquota con massimo imponibile per sommarci le spese
$impomax=0;
$alimax="";
foreach ($imponibile as $key => $value) 
  {
  if($value>$impomax)
    {
	$alimax=$key;
	}
  }
$imponibile["$alimax"]=$imponibile["$alimax"] + $DOCT_TRASPORTO + $DOCT_INSTALLAZ + $DOCT_JOLLY + $DOCT_NOLEGGIO + $DOCT_COLLAUDO + $DOCT_EUROPALLET + $DOCT_ADDVARI + $spese_incasso;
foreach ($imponibile as $key => $value) 
  {
  for($j=0; $j<count($codiva); $j++)
     {
	 if($key==$codiva[$j])
	   {
       $imposta["$key"]=round(($imponibile["$key"] * $perciva[$j] / 100),2);
	   }
	 }
  }
$p=1;
foreach ($imponibile as $key => $value) 
  {
  $ali_j="DOCT_ALIQUOTA_" . $p;
  $imponibile_j="DOCT_IMPONIBILE_" . $p;  
  $imposta_j="DOCT_IMPOSTA_" . $p;  
  $$ali_j=$key;
  $$imponibile_j=$imponibile["$key"];
  $$imposta_j=$imposta["$key"];
  $DOCT_TOT_IMPONIBILE+=$imponibile["$key"];
  $DOCT_TOT_IMPOSTA+=$imposta["$key"];
  $p++;
  }
$DOCT_TOT_FATTURA=$DOCT_TOT_IMPONIBILE + $DOCT_TOT_IMPOSTA;
$scadenzej=calcola_scadenze($alla_data, $DOCT_TOT_FATTURA, $cod_pag, $cliente);
//fine totali
//
//scrivi record
     $righej=json_encode($frighe);
     $righej=addslashes($righej);
     $numero=progressivo($anno,"0","7");
     if($prima==0)
       {
	   	$prima=$numero;
	   }
	 $ultima=$numero;
     $qw = "INSERT INTO documtes (DOCT_TIPO_DOC, DOCT_DEPOSITO, DOCT_DATA_DOC, DOCT_NUM_DOC, DOCT_CLIENTE, DOCT_ALIQUOTA_1, DOCT_IMPONIBILE_1, DOCT_IMPOSTA_1,DOCT_ALIQUOTA_2, DOCT_IMPONIBILE_2, DOCT_IMPOSTA_2, DOCT_ALIQUOTA_3, DOCT_IMPONIBILE_3, DOCT_IMPOSTA_3, DOCT_ALIQUOTA_4, DOCT_IMPONIBILE_4, DOCT_IMPOSTA_4, DOCT_ALIQUOTA_5, DOCT_IMPONIBILE_5, DOCT_IMPOSTA_5, DOCT_TOT_IMPONIBILE, DOCT_TOT_IMPOSTA, DOCT_TOT_FATTURA, DOCT_AGENTE, DOCT_COD_PAG, DOCT_CAUSALE, DOCT_DES_CAUSALE, DOCT_IMPORTO_RAE, DOCT_UTENTE, DOCT_SCADENZE, DOCT_DES_RAG_SOC, DOCT_DES_INDIRIZZO,DOCT_DES_CAP, DOCT_DES_LOC, DOCT_DES_PR, DOCT_CIG, DOCT_CUP, DOCT_NOTE, DOCT_ACCONTO, DOCT_VERSAMENTO, DOCT_TRASPORTO, DOCT_INSTALLAZ, DOCT_JOLLY, DOCT_NOLEGGIO, DOCT_COLLAUDO, DOCT_EUROPALLET, DOCT_ADDVARI, DOCT_SPESE_INCASSO, DOCT_MDV, DOCT_VETTORE, DOCT_IND_VETTORE, DOCT_PORTO, DOCT_ASPETTO, DOCT_COLLI, DOCT_PESO, DOCT_SCONTO_CASSA, DOCT_INCASSATO, DOCT_DATA_RITIRO, DOCT_ORA_RIT, DOCT_RIGHE) VALUES ('7', '02', '$alla_data','$numero', '$cliente', '$DOCT_ALIQUOTA_1', '$DOCT_IMPONIBILE_1', '$DOCT_IMPOSTA_1', '$DOCT_ALIQUOTA_2', '$DOCT_IMPONIBILE_2', '$DOCT_IMPOSTA_2', '$DOCT_ALIQUOTA_3', '$DOCT_IMPONIBILE_3', '$DOCT_IMPOSTA_3', '$DOCT_ALIQUOTA_4', '$DOCT_IMPONIBILE_4', '$DOCT_IMPOSTA_4', '$DOCT_ALIQUOTA_5', '$DOCT_IMPONIBILE_5', '$DOCT_IMPOSTA_5', '$DOCT_TOT_IMPONIBILE', '$DOCT_TOT_IMPOSTA', '$DOCT_TOT_FATTURA', '$age', '$cod_pag', '50', 'VENDITA', '$tot_raee', '$ute', '$scadenzej', '', '', '', '', '', '$cig', '$cup', '', '0', '0', '$DOCT_TRASPORTO', '$DOCT_INSTALLAZ', '$DOCT_JOLLY', '$DOCT_NOLEGGIO', '$DOCT_COLLAUDO', '$DOCT_EUROPALLET', '$DOCT_ADDVARI', '$spese_incasso', '','','','','','','','', '', '', '', '$righej')";
     mysql_query($qw,$con);
     $msg=mysql_error();
     if($msg>"")
       {
       file_put_contents("test_fat.txt", "$qw\n$msg\n\n", FILE_APPEND);       
	   }
     
//aggiorna data fattura su ddt
for($j=0;$j<count($ele_ddt); $j++)
  {
  $id=$ele_ddt[$j];
  $qw="UPDATE documtes SET DOCT_DATA_FATTURA='$alla_data', DOCT_NUM_FATTURA='$numero' WHERE DOCT_ID='$id' LIMIT 1";
  mysql_query($qw,$con);
  }
//fine aggiorna
//
       
//$a=print_r($imponibile,true);
//file_put_contents("test_fat.txt", "$msg\n");       

  } //fine for
//
$res["prima"]=$prima;
$res["ultima"]=$ultima;
header('Content-Type: application/json');
echo json_encode($res);   
?>
