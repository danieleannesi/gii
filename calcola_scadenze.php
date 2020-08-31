<?php
session_start();
require 'include/database.php';
require 'include/java.php';
//
////////////////////////////////////
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
////////////////////////////////////
$data=$_POST["data"];
$importo=$_POST["importo"];
$codpag=$_POST["codpag"];
/*
$data="13/12/2019";
$importo=221.89;
$codpag="071";
*/
$dati=array();
//
$ret=leggi_tabelle("t66$codpag");
$roi=json_decode($ret,true);
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
$fine_mese=intval($roi["1=FM_O_GG_RITARDO"]);
//
$data_ini=substr($data,6,4) . "-" . substr($data,3,2) . "-" . substr($data,0,2);
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

//$dati["gg_scad"]=$gg_scad;
$dati["date"]=$data_sca;
$dati["importo"]=$imp_sca;
//$dati["fine_mese"]=$fine_mese;
//   
$success = false;
$msg = mysql_error();
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nella lettura: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "dati" => $dati);
header('Content-Type: application/json');
echo json_encode($resp);
?>
