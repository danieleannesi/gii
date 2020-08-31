<?php
require 'include/database.php';
$idt=0;
$numero=0;
if(isset($_POST["idt"]))
  {
  $idt=$_POST["idt"];
  }
if(isset($_POST["numero"]))
  {
  $numero=$_POST["numero"];
  }
//
$trasp_perc=0;
$trasp_euro=0;
$res=array();
$res["errore"]="NON TROVATO";
if($idt>0)
  {
  $qr="SELECT * FROM ordinifo LEFT JOIN clienti ON cf_cod=ORDI_FORNITORE WHERE ORDI_ID='$idt'";
  }
if($numero>0)
  {
  $qr="SELECT * FROM ordinifo LEFT JOIN clienti ON cf_cod=ORDI_FORNITORE WHERE ORDI_NUM_DOC='$numero'";
  }
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
   $res=$row;
   $res["errore"]="0";
   }
//
//leggi tabella porto per trasporto
$porto=$res["cf_porto"];
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't52$porto'";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
     $tab_resto=json_decode($row["tab_resto"],true);
     $trasp_perc=$tab_resto["ADDEBITO_IN_PERCENT"]/100;
     $trasp_euro=$tab_resto["ADDEBITO_IN_LIRE"]/100;
	 }
$res["trasp_perc"]=$trasp_perc;
$res["trasp_euro"]=$trasp_euro;
//
header('Content-Type: application/json');
echo json_encode($res);
?>
