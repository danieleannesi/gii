<?php
require 'include/database.php';
require 'include/java.php';
//
$rr=0;
$handle = fopen("MOVMAG.TXT", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
    	$id=substr($line,0,11);
        $num_fattura=substr($line,11,6);
        $data_fattura=substr($line,17,4) . "-" . substr($line,21,2) . "-" . substr($line,23,2);
        $data_final=substr($line,25,4) . "-" . substr($line,29,2) . "-" . substr($line,31,2);
        if($data_final!="0000-00-00")
          {
          $qw="UPDATE movmag SET mov_data_fattura='$data_fattura', mov_num_fattura='$num_fattura', mov_data_final='$data_final' WHERE mov_id='$id'";
          mysql_query($qw,$con);
          $r=mysql_affected_rows();
          $msg=mysql_error();
          $rr+=$r;
		  }    	
    }
   }
fclose($handle);
echo "$rr records aggiornati";
?>
