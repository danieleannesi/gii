<?php 
require 'include/database.php';
require 'include/java.php';
require 'class_varie.php';
session_start();
$iddu=$_SESSION["iddu"];
$utente=$_SESSION["ute"];

$modifica = $_POST["modifica"]; 
$art_codice = $_POST["art_codice"]; 
$art_fornitore = $_POST["art_fornitore"];
//check articolo
$checkArt = "SELECT * FROM articoli WHERE art_codice ='$art_codice'"; 
$qry=mysql_query($checkArt,$con);
$count=mysql_num_rows($qry);

if($count>0 && $modifica!=1){ 
   $success = false;
   $msg="Articolo gia' Esistente ($modifica)";
   $resp = array("success" => $success, "msg" => $msg);
   header('Content-Type: application/json');
   echo json_encode($resp);
   exit;
   }
//
      $art_descrizione = addslashes($_POST["art_descrizione"]);
      $art_codice = $_POST["art_codice"];
      $art_codice_raee = $_POST["art_codice_raee"];
      $art_uni_mis = $_POST["art_uni_mis"];
      $art_classe_merc = $_POST["art_classe_merc"];
      $art_fornitore = $_POST["art_fornitore"];
      $art_scorta_min = floatval($_POST["art_scorta_min"]);
      $art_scorta_max = floatval($_POST["art_scorta_max"]);
      $art_trasporto = floatval($_POST["art_trasporto"]);
      $art_tipo_art = $_POST["art_tipo_art"];
      $art_tempo_appro = floatval($_POST["art_tempo_appro"]);
      $dep_anno = $_POST["dep_anno"];
      
      $art_listino1 = floatval($_POST["art_listino1"]);
      $art_listino2 = floatval($_POST["art_listino2"]); 
      $art_data_listino = addrizza("",$_POST["art_data_listino"]);

      $mgf_listino1 = floatval($_POST["mgf_listino1"]);
      $mgf_listino2 = floatval($_POST["mgf_listino2"]); 
      $mgf_data_listino = addrizza("",$_POST["mgf_data_listino"]);
      
      $mgf_sconto1 = floatval($_POST["mgf_sconto1"]);
      $mgf_sconto2 = floatval($_POST["mgf_sconto2"]); 
      $mgf_data_sconto = addrizza("",$_POST["mgf_data_sconto"]);

      $art_cod_iva = $_POST["art_cod_iva"];  
      $codArt = addslashes($_POST["codArt"]);
      $mgf_cod_for = addslashes($_POST["mgf_cod_for"]);
      if(trim($codArt)=="")
        {
		$codArt=$mgf_cod_for;
		}
      $art_data_mod = date("Y-m-d H:i:s");

      if($modifica!=1)
        {
      $art_data_ins = date("Y-m-d H:i:s");
      $sql = "INSERT INTO `articoli`(`art_codice`,`art_fornitore`, `art_descrizione`, `art_listino1`, `art_listino2`, art_data_listino, 
      `art_uni_mis`, `art_cod_iva`, `art_scorta_min`, `art_scorta_max`, `art_data_ins`, `art_data_mod`, `art_classe_merc`, art_codice_raee, art_trasporto, art_tipo_art, art_tempo_appro) 
      VALUES ('$art_codice', '$art_fornitore', '$art_descrizione','$art_listino1', '$art_listino2', '$art_data_listino',
      '$art_uni_mis',$art_cod_iva, '$art_scorta_min','$art_scorta_max','$art_data_ins' ,'$art_data_mod','$art_classe_merc', '$art_codice_raee', '$art_trasporto', '$art_tipo_art', '$art_tempo_appro')";
      mysql_query($sql,$con);
      $msg = mysql_error();

      //mgforn
      $sql = "INSERT INTO mgforn (mgf_codart, mgf_codfor, mgf_codprod, mgf_barcode, mgf_pr_listino, mgf_pr_listino2, mgf_data_listino, mgf_sconto, mgf_sconto2, mgf_data_sconto) 
          VALUES ('$art_codice', '$art_fornitore', '$codArt', '', '$mgf_listino1', '$mgf_listino2','$mgf_data_listino', '$mgf_sconto1', '$mgf_sconto2','$mgf_data_sconto')";
      mysql_query($sql,$con);
      $msg.= mysql_error();

      //articoli_anno
      $ini="{\"02\":{\"giacenza_ini\":\"0.0000\",\"valore_ini\":\"0.0000\",\"giac_ini_esposizione\":\"0.0000\",\"giac_ini_riparazione\":\"0.0000\",\"giac_ini_lavorazione\":\"0.0000\",\"giac_ini_visione\":\"0.0000\",\"giac_ini_obsoleta\":\"0.0000\",\"giac_ini_visforn\":\"0.0000\"},\"03\":{\"giacenza_ini\":\"0.0000\",\"valore_ini\":\"0.0000\",\"giac_ini_esposizione\":\"0.0000\",\"giac_ini_riparazione\":\"0.0000\",\"giac_ini_lavorazione\":\"0.0000\",\"giac_ini_visione\":\"0.0000\",\"giac_ini_obsoleta\":\"0.0000\",\"giac_ini_visforn\":\"0.0000\"},\"04\":{\"giacenza_ini\":\"0.0000\",\"valore_ini\":\"0.0000\",\"giac_ini_esposizione\":\"0.0000\",\"giac_ini_riparazione\":\"0.0000\",\"giac_ini_lavorazione\":\"0.0000\",\"giac_ini_visione\":\"0.0000\",\"giac_ini_obsoleta\":\"0.0000\",\"giac_ini_visforn\":\"0.0000\"},\"06\":{\"giacenza_ini\":\"0.0000\",\"valore_ini\":\"0.0000\",\"giac_ini_esposizione\":\"0.0000\",\"giac_ini_riparazione\":\"0.0000\",\"giac_ini_lavorazione\":\"0.0000\",\"giac_ini_visione\":\"0.0000\",\"giac_ini_obsoleta\":\"0.0000\",\"giac_ini_visforn\":\"0.0000\"}}";
      $sql = "INSERT INTO articoli_anno (dep_anno, dep_codice, dep_inizio, dep_giacenze, dep_data_mod) 
          VALUES ('$dep_anno', '$art_codice', '$ini','',NOW())";
      mysql_query($sql,$con);
      $msg.= mysql_error();
      $log=new scrivi_log($utente,"inserito_articolo: $art_codice");
		}     
     else
        {
      $sql="UPDATE articoli SET art_fornitore='$art_fornitore', art_descrizione='$art_descrizione', art_listino1='$art_listino1', art_listino2='$art_listino2', art_data_listino='$art_data_listino', art_uni_mis='$art_uni_mis',art_cod_iva='$art_cod_iva', art_scorta_min='$art_scorta_min', art_scorta_max='$art_scorta_max', art_data_mod=NOW(), art_classe_merc='$art_classe_merc', art_codice_raee='$art_codice_raee', art_trasporto='$art_trasporto', art_tipo_art='$art_tipo_art', art_tempo_appro='$art_tempo_appro' WHERE art_codice='$art_codice'";
      mysql_query($sql,$con);
      $msg = mysql_error();

      $sql = "UPDATE mgforn SET mgf_codprod='$codArt', mgf_pr_listino='$mgf_listino1', mgf_pr_listino2='$mgf_listino2', mgf_data_listino='$mgf_data_listino', mgf_sconto='$mgf_sconto1', mgf_sconto2='$mgf_sconto2', mgf_data_sconto='$mgf_data_sconto' WHERE mgf_codart='$art_codice'";
      mysql_query($sql,$con);
      $msg.= mysql_error();
	  	
      $log=new scrivi_log($utente,"modificato_articolo: $art_codice");
	    }
      
      $success = false;
      if ($msg=="") {
        $success = true;
      } else {
        $msg = "Attenzione, errori nel salvataggio: ".$msg;
      }
      $resp = array("success" => $success, "msg" => $msg);
      header('Content-Type: application/json');
      echo json_encode($resp);
