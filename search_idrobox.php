<?php  
require 'include/database.php';

session_start();
if(!isset($_SESSION["iddu"]))
  {
  echo "Sessione scaduta; <a href=\"login.php\">Effettuare il Login</a>"; exit;
  }

global $con;
$iddu=$_SESSION["iddu"];
$ute=$_SESSION["ute"];
$utente=$iddu;
$marca = $_POST["marca"];
$codArt = $_POST["codArt"];
$result_array = array();
$msg="";
$res = array();
$checkArt = "SELECT art_codice FROM articoli WHERE art_fornitore LIKE '".$codArt."' "; 
$qry=mysql_query($checkArt,$con);

$rst = mysql_fetch_assoc($qry); 
 
$count=mysql_num_rows($qry);
 

if($count>0){  
    
    $cod_art = $rst["art_codice"];
    $msg = "Articolo presente in anagrafica: ".$cod_art;
    $success = false; 

} else { 
    require 'include/idrobox.php';
    $sql = "SELECT articoli.mar_codice, art_codiceproduttore, art_descrizioneridotta,art_um,art_conf,lis_prezzoeuro1, lis_datalistino,lcr_descrizione, set_codice, mac_codice,fam_codice,lis_prezzoeuroprec FROM articoli  
    LEFT JOIN abb_art_liscarrev ON articoli.art_codice=abb_art_liscarrev.art_codice AND articoli.mar_codice=abb_art_liscarrev.mar_codice  
    LEFT JOIN liscarrev ON abb_art_liscarrev.lcr_id=liscarrev.lcr_id  
    WHERE articoli.mar_codice LIKE '".$marca."' AND  art_codiceproduttore LIKE '".$codArt."' ";
    $success = true;
    $rst=mysql_query($sql,$idr);
   
    while($row = mysql_fetch_assoc($rst)) { 
        array_push($result_array, $row);
    } 

    
}

$resp = array("success" => $success, "msg" => $msg, "dati" => $result_array);
    header('Content-Type: application/json');
    echo json_encode($resp);