<?php
session_start();  
//require 'include/database.php';  
require 'include/idrobox.php';  
$result_array = array();
 
$marca = $_POST["marchio"]; 
  
 
  $sql = "SELECT DISTINCT art_catsc, lis_codice, lcr_descrizione,liscarrev.lcr_data, liscarrev.lcr_lisvalido, articoli.mar_codice
            FROM articoli 
            LEFT JOIN abb_art_liscarrev ON articoli.art_codice=abb_art_liscarrev.art_codice 
            AND articoli.mar_codice=abb_art_liscarrev.mar_codice  
            LEFT JOIN liscarrev ON abb_art_liscarrev.lcr_id=liscarrev.lcr_id 
            LEFT JOIN tab_marche ON articoli.mar_codice=tab_marche.mar_codice 
            WHERE articoli.mar_codice='".$marca."' and liscarrev.lcr_lisvalido = 'S' ORDER BY lcr_descrizione ";
 
$rst=mysql_query($sql,$idr);  

while($row = mysql_fetch_assoc($rst)) {
    array_push($result_array, $row);
} 
 
$success = false;
$msg = mysql_error();
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nella lettura: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "dati" =>$result_array);
header('Content-Type: application/json');
echo json_encode($resp);

?>