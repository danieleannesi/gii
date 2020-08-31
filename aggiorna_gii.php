<?php
require_once "include/database.php";
$qr="TRUNCATE TABLE articoli";
$rst=mysql_query($qr,$con);
$qr="LOAD DATA LOCAL INFILE '/usr1/tmp/ARTI.TXT' INTO TABLE articoli FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\n';";
$rst=mysql_query($qr,$con);


echo "end";
?>