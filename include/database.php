<?php
$DB_SERVER = "localhost";
$DB_USER = "root";
$DB_PASS = "Pw606589";
$DB_NAME = "gii";
$r=0;
//
$con=mysql_pconnect($DB_SERVER, $DB_USER, $DB_PASS);
if (!$con) 
	{
	echo "$DB_USER-" . mysql_error();
	exit;
	}
if (!mysql_select_db($DB_NAME, $con)) 
	{
	echo mysql_error();
	mysql_close($con);
	exit;
	}
mysql_query("set names 'utf8'");
date_default_timezone_set('Europe/Rome');	
?>
