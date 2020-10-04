<?php
session_start();
require_once "include/database.php";
$ragsoc=trim($_GET["ragsoc"]);
$tipo=$_GET["tipo"];
$sql="SELECT cf_cod, cf_ragsoc FROM clienti WHERE cf_cli_for='".$tipo."' AND cf_ragsoc LIKE '%".$ragsoc."%' ";
 
$result=mysql_query($sql,$con);
 
$response = array();
 while($row = mysql_fetch_assoc($result) ){ 
   $response[] = array("cod"=>$row['cf_cod'],"ragsoc"=>$row['cf_ragsoc']);
 }

 echo json_encode($response);
 
?>