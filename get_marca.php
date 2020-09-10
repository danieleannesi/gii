<?php
session_start();
require 'include/database.php';   
 
$codice = $_POST["codice"];
$sql = "SELECT DISTINCT scf_codfor FROM `scofor` WHERE scf_marca like '".$codice."' ";
 
$result=mysql_query($sql,$con);
$marca =  mysql_result($result, 0); 
  
echo $marca;
?>