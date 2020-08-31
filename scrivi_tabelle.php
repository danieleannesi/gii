<?php
require 'include/database.php';
$handle = fopen("TABJSON.TXT", "r");
while (!feof($handle)) {
    $buffer = fgets($handle, 4096);
    $le=strlen($buffer);
    $tab_key=trim(substr($buffer,0,10));    

    $x=10;
    $resto="";
RES:
    $p=$x + 50;
    $tab_descri=trim(substr($buffer,$x,50));
    $tab_descri=str_replace(".","",$tab_descri);
    $tab_descri=str_replace(" ","_",$tab_descri);
    $tab_descri=str_replace("'","",$tab_descri);
    $tab_descri=str_replace("/","_",$tab_descri);
    $tab_descri=strtoupper($tab_descri);
        
    $tab_valore=trim(substr($buffer,$p,50));
    $resto.="\"$tab_descri\":\"$tab_valore\"";    

    $x+=100;
    echo "le=$le x=$x<br>";
    if($x < $le)
      {
	  $resto=$resto . ",";
	  goto RES;
	  }
    
    if(trim($buffer)>"")
      {
      $resto="{" . $resto . "}";
      $qr = "REPLACE INTO tabelle (tab_key, tab_resto) VALUES ('$tab_key','$resto')";
      //echo "qr=$qr<br>";
      mysql_query($qr,$con);
	  }
}
fclose($handle);
?>
