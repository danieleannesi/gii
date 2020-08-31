<?php
$handle = fopen("test.txt", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
    $line = str_replace("\n", '', $line);
    $line = str_replace("\r", '', $line);
    $ar[]=$line;
    }
   }
fclose($handle);
if(in_array("00754980589",$ar))
  {
  echo "si";
  }
?>