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
require 'include/database.php';
require 'include/functions.php';
require 'class_varie.php';
require 'calcola_medio.php';
//
$dati_json = $_POST["dati_json"];
$righe=json_decode ($dati_json,true);
//
$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
//
for($j=0; $j<count($righe["cod"]); $j++)
  {
  $cod=$righe["cod"][$j];
  $qta=$righe["qta"][$j];
  $uni=$righe["uni"][$j];
  $sco=$righe["sco"][$j];
  $tot=$righe["tot"][$j];

  $resto=5.1;
  if(substr($cod,0,3)=="016") { $resto=4; }
  if(substr($cod,0,3)=="303") { $resto=7; }
  if(substr($cod,0,4)=="5348") { $resto=20; }
  if($cod > "3130000000" && $cod < "3132699999") { $resto=6; }
  if($cod > "0126000000" && $cod < "0126200060") { $resto=4; }
  if($cod > "0128000000" && $cod < "0128500060") { $resto=6; }
  if($cod > "0210500400" && $cod < "0210900660") { $resto=4; }
  if($cod > "3147600000" && $cod < "3147799999") { $resto=6; }
  if($cod > "3020000000" && $cod < "3023400060") { $resto=5; }
  
  $valori=calcola_valore_medio($cod,$deposito,$dal,$al,"S");
  $val_medio=$valori["nw_medio"];
  $nuovo=$val_medio + ($val_medio * $resto / 100);
  $nuovo=round($nuovo,4);
  if($nuovo < $uni && $val_medio > 0)
	  {
	  $uni=$nuovo;
	  $sco=0.00;
	  $tot=round($qta*$uni,4);
	  }
  $righe["uni"][$j]=$uni;
  $righe["sco"][$j]=$sco;
  $righe["tot"][$j]=$tot;
  }
$msg="";
if ($msg=="") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel cipi: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "righe" => $righe);
header('Content-Type: application/json');
echo json_encode($resp);
?>
