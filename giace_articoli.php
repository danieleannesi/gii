<?php
session_start();
require_once "include/database.php";
$qr="SELECT * FROM articoli LEFT JOIN articoli_anno ON dep_anno='2018' AND dep_codice=art_codice ORDER BY art_codice LIMIT 100000";
echo "$qr<br>";
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
    $giacei=json_decode($row["dep_inizio"],true);
    $giace=json_decode($row["dep_giacenze"],true);
    //echo $row["art_codice"] . "<br>";
    foreach( $giacei as $chiave=>$valore)
      {
      if($valore["giac_ini_visione"]>0)
        {
        echo $row["art_codice"] . "<br>";
        echo $chiave . "=" . $valore["giac_ini_visione"] . " " . $giace[$chiave]["giac_visione"] . "<br>";
        $sk=scheda($row["art_codice"],$chiave);
/*        
        for($j=0;$j<count($sk);$j++)
          {
		  echo $sk[$j] . "<br>";
		  }        
*/
		}
      //echo $row["art_codice"] . $deposito . " giac_ini_visione=" . $giacei[$deposito]["giac_ini_visione"] . "<br>";
      }  
    //echo "<br>";
/*
    echo $row["art_codice"] . "<br>";
    
    //echo $row["dep_inizio"] . "<br>";
    print_r($giacei["02"]);
    echo "<br>";

    //echo $row["dep_giacenze"] . "<br>";
    print_r($giace["02"]);
    
    echo "<br><br>";
*/
}
function scheda($codice,$deposito)
{
global $con;
//$sk=array();
$oggi=date("Y-m-d");
$qr="SELECT * FROM movmag WHERE mov_codart='$codice' AND mov_dep='$deposito' AND mov_data BETWEEN '2018-01-01' AND '$oggi'";
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
  if($row["mov_causale"]=="61" || $row["mov_causale"]=="62")
    {
	$riga=$row["mov_data"] . " causale=" . $row["mov_causale"] . " qua=" . $row["mov_qua"] . " prezzo=" . $row["mov_prezzo"] . "<br>";
    $sk[]=$riga;
    echo "riga=$riga<br>";
	}
  }
return $sk;
}
?>