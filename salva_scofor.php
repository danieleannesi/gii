<?php
require 'include/database.php';
require 'include/functions.php';
require 'class_varie.php';
session_start();
if(!isset($_SESSION["iddu"]))
  {
  echo "Sessione scaduta; <a href=\"login.php\">Effettuare il Login</a>"; exit;
  }
$iddu=$_SESSION["iddu"];
$ute=$_SESSION["ute"];
$utente=$iddu;

//
$scf_id = $_POST["sco_id"];   
$scf_tipo = $_POST["scf_tipo"];
$scf_marca = $_POST["scf_marca"];
$scf_codfor = $_POST["scf_codfor"];
$scf_a_articolo = $_POST["scf_a_articolo"];
$scf_da_articolo = $_POST["scf_da_articolo"];
$scf_data_da = $_POST["scf_data_da"];
$scf_data_a = $_POST["scf_data_a"];
$scf_um = $_POST["scf_um"];
$scf_set = $_POST["scf_set"];
$scf_mac = $_POST["scf_mac"];
$scf_fam = $_POST["scf_fam"];
$scf_catsc = $_POST["scf_catsc"];
$scf_listino = $_POST["scf_listino"];

$scf_sconto_1 = $_POST["scf_sconto_1"];
$scf_sconto_2 = $_POST["scf_sconto_2"];
$scf_sconto_3 = $_POST["scf_sconto_3"];
$scf_sconto_4 = $_POST["scf_sconto_4"];
$scf_sconto_5 = $_POST["scf_sconto_5"];

$scf_netto = $_POST["scf_netto"];
$scf_ricarica = $_POST["scf_ricarica"];
$scf_sconto_ag = $_POST["scf_sconto_ag"];
$scf_sconto_ag_cl = $_POST["scf_sconto_ag_cl"];
$scf_trasporto = $_POST["scf_trasporto"];

$scf_trasp_impo = $_POST["scf_trasp_impo"];
$scf_da_tabart = $_POST["scf_da_tabart"];
$scf_a_tabart = $_POST["scf_a_tabart"];
$scf_note = $_POST["scf_note"];
$scf_lis_da_netto = $_POST["scf_lis_da_netto"];

$scf_magg_netto = $_POST["scf_magg_netto"];
$scf_moltiplica = $_POST["scf_moltiplica"];
$scf_dividi = $_POST["scf_dividi"];
$scf_classe = $_POST["scf_classe"]; 

if(isset($scf_id)){
  $sql = "UPDATE `scofor` SET `scf_data_da`= '$scf_data_da',`scf_data_a`= '$scf_data_a',`scf_a_articolo` = '$scf_a_articolo', `scf_da_articolo`= '$scf_da_articolo',
  `scf_um`='$scf_um',`scf_set`='$scf_set',`scf_mac`='$scf_mac',  `scf_fam`='$scf_fam',`scf_catsc`='$scf_catsc',`scf_listino`='$scf_listino',
  `scf_sconto_1`='$scf_sconto_1',`scf_sconto_2`='$scf_sconto_2',`scf_sconto_3`='$scf_sconto_3', `scf_sconto_4`='$scf_sconto_4',`scf_sconto_5`='$scf_sconto_5',
  `scf_netto`='$scf_netto',`scf_ricarica`='$scf_ricarica',`scf_sconto_ag`='$scf_sconto_ag',`scf_sconto_ag_cl`='$scf_sconto_ag_cl',
  `scf_trasporto`='$scf_trasporto',`scf_trasp_impo`='$scf_trasp_impo',`scf_da_tabart`='$scf_da_tabart',`scf_a_tabart`='$scf_a_tabart',
  `scf_note`='$scf_note',`scf_lis_da_netto`='$scf_lis_da_netto',
  `scf_magg_netto`='$scf_magg_netto',`scf_moltiplica`='$scf_moltiplica',`scf_dividi`='$scf_dividi',`scf_classe`='$scf_classe' WHERE sco_id=".$scf_id;

} else {
  $sql = "INSERT INTO `scofor`(`scf_tipo`, `scf_marca`, `scf_codfor`, `scf_a_articolo`, `scf_da_articolo`, `scf_data_da`, `scf_data_a`, `scf_um`, 
  `scf_set`, `scf_mac`, `scf_fam`, `scf_catsc`, `scf_listino`, `scf_sconto_1`, `scf_sconto_2`, `scf_sconto_3`, `scf_sconto_4`, `scf_sconto_5`, `scf_netto`, 
  `scf_ricarica`, `scf_sconto_ag`, `scf_sconto_ag_cl`, `scf_trasporto`, `scf_trasp_impo`, `scf_da_tabart`, `scf_a_tabart`, `scf_note`, `scf_lis_da_netto`, 
  `scf_magg_netto`, `scf_moltiplica`, `scf_dividi`, `scf_classe`) 
  VALUES ($scf_tipo,'$scf_marca','$scf_codfor','$scf_a_articolo','$scf_da_articolo','$scf_data_da','$scf_data_a','$scf_um','$scf_set','$scf_mac',
  '$scf_fam','$scf_catsc','$scf_listino','$scf_sconto_1','$scf_sconto_2','$scf_sconto_3','$scf_sconto_4','$scf_sconto_5','$scf_netto','$scf_ricarica','$scf_sconto_ag',
  '$scf_sconto_ag_cl','$scf_trasporto','$scf_trasp_impo','$scf_da_tabart','$scf_a_tabart','$scf_note','$scf_lis_da_netto','$scf_magg_netto','$scf_moltiplica',
  '$scf_dividi','$scf_classe')";
}

mysql_query($sql,$con);
$success = false;
$msg = mysql_error();
$qr=addslashes($sql);
$log=new scrivi_log($utente,"salva_scofor: $qr");
//
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg); 
header('Content-Type: application/json');
echo json_encode($resp); 
?>
