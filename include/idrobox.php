<?php
session_start();
if(!isset($_SESSION["idrolocal"]))
  {
  $DBI_SERVER = "192.168.29.83";
  $DBI_USER = "customer";
  $DBI_PASS = "custmydb313";
  $idr=mysql_pconnect($DBI_SERVER, $DBI_USER, $DBI_PASS);
  }
if (!$idr) 
  {
  $DBI_SERVER = "localhost";
  $DBI_USER = "root";
  $DBI_PASS = "";
  $idr=mysql_pconnect($DBI_SERVER, $DBI_USER, $DBI_PASS);
  $_SESSION["idrolocal"]="1";
  }
$DBI_NAME = "idrodata";
//
if (!$idr) 
	{
	echo "$DBI_USER-" . mysql_error();
	exit;
	}
if (!mysql_select_db($DBI_NAME, $idr)) 
	{
	echo mysql_error();
	mysql_close($idr);
	exit;
	}
mysql_query("set names 'utf8'");	
?>