<?php
session_start();
require 'include/database.php';
require 'include/java.php';
$codice = $_POST["codice"];
$dati=array();
$qr = "SELECT * FROM a_patient WHERE PA_IPERM = '$codice'";
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
  foreach($row as $key=>$value){
    $dati[$key]=addslashes($value);
    }
  }
//  
   //leggi citta nascita
   $citta=$dati["p_comunenas"];
   $qi="SELECT CY_CNAME FROM a_city WHERE CY__ICODE='$citta'";
   $rsi = mysql_query($qi, $con);
   $roi = mysql_fetch_array($rsi);
   $dati["dcomunenas"]=$roi["CY_CNAME"];
   //fine leggi citta nascita
   //
   //leggi citta residenza
   $citta=$dati["p_comuneres"];
   $qi="SELECT CY_CNAME FROM a_city WHERE CY__ICODE='$citta'";
   $rsi = mysql_query($qi, $con);
   $roi = mysql_fetch_array($rsi);
   $dati["dcomuneres"]=$roi["CY_CNAME"];
   //fine leggi citta residenza
   //   
   //leggi nazione nascita
   $nazione=$dati["p_statonas"];
   $qi="SELECT CR_CNAME FROM a_country WHERE CR_ICTRY='$nazione'";
   $rsi = mysql_query($qi, $con);
   $roi = mysql_fetch_array($rsi);
   $dati["dstatonas"]=$roi["CR_CNAME"];
   //fine leggi nazione nascita
   //   
   //leggi cittadinanza
   $nazione=$dati["p_cittadinanza"];
   $qi="SELECT CR_CNAME FROM a_country WHERE CR_ICTRY='$nazione'";
   $rsi = mysql_query($qi, $con);
   $roi = mysql_fetch_array($rsi);
   $dati["dcittadinanza"]=$roi["CR_CNAME"];
   //fine leggi cittadinanza   
   //
   //leggi nazione residenza
   $nazione=$dati["p_statores"];
   $qi="SELECT CR_CNAME FROM a_country WHERE CR_ICTRY='$nazione'";
   $rsi = mysql_query($qi, $con);
   $roi = mysql_fetch_array($rsi);
   $dati["dstatores"]=$roi["CR_CNAME"];
   //fine leggi cittadinanza   
   $dati["p_datanas"]=addrizza($dati["p_datanas"],"");
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
