<?php
function progressivo($anno,$deposito,$tipo)
{
global $con;
$cot_contatore=$tipo;
$cot_per_deposito=0;
$cot_prefisso=0;
$cot_moltiplica=1;
$qr="SELECT * FROM contatori_tipi WHERE cot_tipo='$tipo'";
$rst=mysql_query($qr, $con);
while ($row = mysql_fetch_assoc($rst)) {
        $cot_contatore=$row["cot_contatore"];
        $cot_per_deposito=$row["cot_per_deposito"];
        $cot_prefisso=$row["cot_prefisso"];
        $cot_moltiplica=$row["cot_moltiplica"];
        }
$da_sommare=0;        
$tipo=$cot_contatore;
if(!$cot_per_deposito)
  {
  $deposito=0;
  }
if($cot_prefisso)
  {
  if($deposito>0)
    {
    $da_sommare=$deposito*$cot_moltiplica;
	}
  else
    {
    $da_sommare=$cot_moltiplica;
    }
  }
//
$proto=0;
mysql_query('START TRANSACTION');
$qr="SELECT * FROM contatori WHERE con_anno='$anno' AND con_dep='$deposito' AND con_tipo='$tipo' FOR UPDATE";
$rst=mysql_query($qr, $con);
$nrec=mysql_num_rows($rst);
if($nrec==0)
  {
  $qr="INSERT INTO contatori SET con_anno='$anno', con_dep='$deposito', con_tipo='$tipo', con_conta=0";
  $rst=mysql_query($qr, $con);
  $qr="SELECT * FROM contatori WHERE con_anno='$anno' AND con_dep='$deposito' AND con_tipo='$tipo' FOR UPDATE";
  $rst=mysql_query($qr, $con);  
  }
while ($row = mysql_fetch_assoc($rst)) {
        $proto=$da_sommare + $row["con_conta"] + 1;
        }
$qr_up="UPDATE contatori SET con_conta=con_conta+1 WHERE con_anno='$anno' AND con_dep='$deposito' AND con_tipo='$tipo'";
mysql_query($qr_up,$con);
mysql_query('COMMIT');
return $proto;
}
?>