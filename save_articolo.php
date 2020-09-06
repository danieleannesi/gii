<?php 
require 'include/database.php';
session_start();
$iddu=$_SESSION["iddu"];
$utente=$_SESSION["ute"];
global $con;


$art_codice = $_POST["art_codice"]; 
$art_fornitore = $_POST["art_fornitore"];
//check articolo
$checkArt = "SELECT * FROM articoli WHERE art_codice LIKE '".$art_codice."' "; 
$qry=mysql_query($checkArt,$con);
$count=mysql_num_rows($qry);

  if($count==0){ 
      $art_descrizione = addslashes($_POST["art_descrizione"]);
      $art_uni_mis = $_POST["art_uni_mis"];
      $art_classe_merc = $_POST["art_classe_merc"];
      
      $art_listino1 = $_POST["art_listino1"];
      $art_listino2 = $_POST["art_listino2"];
      $art_data_listino = $_POST["art_data_listino"];
      
      $art_scorta_max = $_POST["art_scorta_max"];
      $art_scorta_min = $_POST["art_scorta_min"];
      
      $art_cod_iva = $_POST["art_cod_iva"]; 
      $art_codice_raee = $_POST["art_codice_raee"];
      
      
      $art_data_ins = date("Y-m-d H:i:s");
      $art_data_mod = date("Y-m-d H:i:s");
     
      $sql = "INSERT INTO `articoli`(`art_codice`,`art_fornitore`, `art_descrizione`, `art_listino1`, `art_listino2`, `art_data_listino`, `art_codice_raee`, 
      `art_uni_mis`, `art_cod_iva`, `art_scorta_min`, `art_scorta_max`, `art_data_ins`, `art_data_mod`, `art_classe_merc`) 
      VALUES ('$art_codice', '$art_fornitore', '$art_descrizione','$art_listino1', '$art_listino2','$art_data_listino','$art_codice_raee', 
      '$art_uni_mis',$art_cod_iva, $art_scorta_min ,  $art_scorta_max , '$art_data_ins' ,'$art_data_mod','$art_classe_merc')";
            
      mysql_query($sql,$con);
      $msg = mysql_error();
      $log=new scrivi_log($utente,"inserito_articolo: $sql");
      
      $success = false;
      $msg = mysql_error();
      if ($msg ==  "") {
        $success = true;
      } else {
        $msg = "Attenzione, errori nel salvataggio: ".$msg;
      }
      $resp = array("success" => $success, "msg" => $msg);
      header('Content-Type: application/json');
      echo json_encode($resp);
  } 
