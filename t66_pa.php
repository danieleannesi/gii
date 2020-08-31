<?php
//
require 'include/database.php';
//
//leggi codici pagamento
  $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't66%' ORDER BY tab_key";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi codici pag) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) { 
     $tabpag=json_decode($row["tab_resto"],true);
     $codpaga=substr($row["tab_key"],3,3);
     $despaga=$tabpag["DESCRIZ_PAGAMENTO"];

     $tipo="";
     $modo="";
     
     $pos = strpos($despaga, "CONT");
     if($pos!==false)
       {
	   	$tipo="TP02";
	   	$modo="MP01";
	   }     
     $pos = strpos($despaga, "BONI");
     if($pos!==false)
       {
	   	$tipo="TP02";
	   	$modo="MP05";
	   }     
     $pos = strpos($despaga, "BON.");
     if($pos!==false)
       {
	   	$tipo="TP02";
	   	$modo="MP05";
	   }     	   
     $pos = strpos($despaga, "B.B.");
     if($pos!==false)
       {
	   	$tipo="TP02";
	   	$modo="MP05";
	   }     	   	   
     $pos = strpos($despaga, "B/B");
     if($pos!==false)
       {
	   	$tipo="TP02";
	   	$modo="MP05";
	   }     	   	   
     $pos = strpos($despaga, "RIMES");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP01";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP01";
	   }     
     $pos = strpos($despaga, "R.D.");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP01";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP01";
	   }     
     $pos = strpos($despaga, "RD");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP01";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP01";
	   }     
     $pos = strpos($despaga, "RIM.");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP01";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP01";
	   }     	   
     $pos = strpos($despaga, "R.DIR");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP01";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP01";
	   }     	   
     $pos = strpos($despaga, "R.B.");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP12";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP12";
	   }     
     $pos = strpos($despaga, "RB");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP12";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP12";
	   }     	   
     $pos = strpos($despaga, "TIT");
     $pos0 = strpos($despaga, "0");
     if($pos!==false && $pos0 !==false)
       {
	   	$tipo="TP01";
	   	$modo="MP02";
	   }     
     if($pos!==false && $pos0 ===false)
       {
	   	$tipo="TP02";
	   	$modo="MP02";
	   }     

     $qw="UPDATE tabelle SET tab_tipo='$tipo', tab_modo='$modo' WHERE tab_key='T66$codpaga'";
     $rsw = mysql_query($qw, $con);
     echo "$qw<br>";
    
	 }
//fine leggi codici pag/////////////////////////////////////////////////////////////////////////
//
?>