<?php
require 'include/database.php';
$deposito=$_POST["deposito"];
$oggi=date("Y-m-d");
$sco_numero=0;
//
$res=array();
$res["errore"]="NON TROVATO";
$res["numsco"]=0;
$qr="SELECT * FROM sconum WHERE sco_deposito='$deposito' AND sco_data='$oggi'";
$rst=mysql_query($qr,$con);
if(mysql_num_rows()==0)
  {
  $qw="INSERT INTO sconum (sco_deposito, sco_data, sco_numero) VALUES ('$deposito', '$oggi', 0)";
  mysql_query($qw,$con);
  $rst=mysql_query($qr,$con);
  }
while($row = mysql_fetch_assoc($rst)) {
   $sco_numero=$row["sco_numero"] + 1;
   $res["numsco"]=$sco_numero;
   $res["errore"]="0";
   }
//
header('Content-Type: application/json');
echo json_encode($res);
?>
