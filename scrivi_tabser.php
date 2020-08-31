<?php
require 'include/database.php';
$handle = fopen("DESJSON.TXT", "r");
while (!feof($handle)) {
    $buffer = fgets($handle, 4096);
    $tas_key=trim(substr($buffer,0,3));    
    $tas_descri=trim(substr($buffer,10,55));
    if(trim($buffer)>"")
      {
      $qr = "INSERT INTO tabser (tas_key, tas_descri) VALUES ('$tas_key','$tas_descri')";
      mysql_query($qr,$con);
	  }
}
fclose($handle);
?>
