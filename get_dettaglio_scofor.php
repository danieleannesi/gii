<?php
require 'include/database.php';
require 'include/idrobox.php';
require 'calcola_medio.php';
//
mysql_select_db($DB_NAME, $con);
header('Content-Type: application/json');
$id_scofor=$_GET["id"];
$tipo= $_GET["tipo"];
 
if($tipo == 1 && isset($id_scofor)){
    $sql="SELECT * FROM scofor WHERE sco_id= ".$id_scofor; 
    $result=mysql_query($sql,$con);  
    $row = mysql_fetch_array($result);
    echo json_encode($row); 
  
}

 
if($tipo == 2 && isset($id_scofor)){
    $sql="SELECT * FROM scofor WHERE sco_id= ".$id_scofor; 
    $result=mysql_query($sql,$con);  
    $row = mysql_fetch_array($result);
    echo json_encode($row); 
  
}
   

?>