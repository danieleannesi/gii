<?php

require 'include/database.php';
require 'include/java.php';
require 'class_varie.php';

session_start();
$iddu=$_SESSION["iddu"];
$utente=$_SESSION["ute"];
global $con;
//valore 1 CLIENTE 9 FORNITORE
$anagrafica = $_POST["cf_cli_for"];
$cf_cod = $_POST["cf_cod"];
$nuovo = "1"; 
if($cf_cod=="" || $cf_cod=="NULL" ){
  $nuovo = "0";
} 

$cf_tipo = $_POST["cf_tipo"];
//file_put_contents("debug.txt", $dati);
$msg="";
$cf_ragsoc=addslashes(strtoupper($_POST["cf_ragsoc"]));
$cf_cognome=addslashes(strtoupper($_POST["cf_cognome"]));
$cf_nome=addslashes(strtoupper($_POST["cf_nome"]));
$cf_codfisc=strtoupper($_POST["cf_codfisc"]);
$cf_note=addslashes($_POST["cf_note"]);
$cf_piva = $_POST["cf_piva"];
$cf_localita = $_POST["cf_localita"];
$cf_cap = $_POST["cf_cap"];
$cf_prov = $_POST["cf_prov"];
$cf_indirizzo = $_POST["cf_indirizzo"];
$cf_telefono = $_POST["cf_telefono"];
$cf_fax = $_POST["cf_fax"];
$cf_email = $_POST["cf_email"];
$cf_pec = $_POST["cf_pec"];
$cf_iva = $_POST["cf_iva"];
$cf_codice_unico = $_POST["cf_codice_unico"];
$cf_rif_uff_acquisti = addslashes($_POST["cf_rif_uff_acquisti"]);
$cf_rif_ammi =  addslashes($_POST["cf_rif_ammi"]);
$cf_banca = $_POST["cf_banca"];
$cf_iban = $_POST["cf_iban"];
$cf_agente = $_POST["cf_agente"]; 
$cf_codpag = $_POST["cf_codpag"];
$qs="";
$operazione="";
$cf_data_ins = date("Y-m-d H:i:s");
$cf_data_mod = date("Y-m-d H:i:s");

if($nuovo=="0"){
 
	  $cf_cod=contatore($anagrafica);  
      $qr = " INSERT INTO `clienti` (`cf_cod`, `cf_cli_for`, `cf_tipo`, `cf_ragsoc`, `cf_cognome`, `cf_nome`,`cf_nazione`, `cf_piva`, `cf_codfisc`, 
    `cf_indirizzo`, `cf_localita`, `cf_cap`, `cf_prov`, `cf_agente`, `cf_codpag`, `cf_telefono`, `cf_fax`, `cf_email`, `cf_iva`,
     `cf_cod_contab`, `cf_banca`, `cf_iban`, `cf_fido`, `cf_classe_sconto`, `cf_rif_uff_acquisti`, `cf_rif_ammi`, `cf_note`, `cf_data_mod`, `cf_data_ins`, 
     `cf_operatore`, `cf_pec`, `cf_codice_unico`) 
     VALUES ($cf_cod,$anagrafica,'$cf_tipo','$cf_ragsoc','$cf_cognome','$cf_nome','$cf_nazione','$cf_piva','$cf_codfisc','$cf_indirizzo','$cf_localita','$cf_cap','$cf_prov',
     '$cf_agente','$cf_codpag','$cf_telefono','$cf_fax','$cf_email','$cf_iva','$cf_cod_contab','$cf_banca','$cf_iban','$cf_fido','$cf_classe_sconto','$cf_rif_uff_acquisti',
     '$cf_rif_ammi','$cf_note','$cf_data_mod','$cf_data_ins','$utente','$cf_pec','$cf_codice_unico')"; 
    
    $operazione = "inserito cliente:";
  } else   {
    $qr="UPDATE clienti SET cf_cf_ragsoc='$cf_ragsoc', cf_tipo='$cf_tipo', cf_cognome='$cf_cognome', cf_nome='$cf_nome', cf_cnazione='$cf_cnazione', cf_nazione='$cf_nazione', cf_piva='$cf_piva', cf_codfisc='$cf_codfisc', cf_indirizzo='$cf_indirizzo', cf_clocalita='$cf_clocalita', cf_localita='$cf_localita', cf_cap='$cf_cap', cf_prov='$cf_prov', cf_add_imballo='$cf_add_imballo', cf_add_sp_inc='$cf_add_sp_inc', cf_no_ec='$cf_no_ec', cf_fatt_separate='$cf_fatt_separate', cf_rb_unicacig='$cf_rb_unicacig', cf_note='$cf_note' WHERE cf_cod='$cf_cod'";
    mysql_query($qr,$con);
    $msg = mysql_error();
    $qs=addslashes($qr);
    $operazione = "aggiornato cliente:";
  }  
//file_put_contents("debug1.txt", $qr);
mysql_query($qr,$con);
$msg = mysql_error();
$qs=addslashes($qr); 

  $log=new scrivi_log($utente,"".$operazione.$qs);
//$id = mysql_insert_id();
$success = false;
$msg = mysql_error();
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "cf_cod" => $cf_cod);
header('Content-Type: application/json');
echo json_encode($resp);


function contatore($anagrafica){ 
  global $con;	
  $proto=0;
  $cerca=$anagrafica . "7777700";
  $sql = "SELECT cf_cod FROM clienti WHERE cf_cod < '$cerca' ORDER BY cf_cod DESC LIMIT 1";
  $query=mysql_query($sql, $con); 
  while ($row = mysql_fetch_assoc($query)) {
    $proto=$row["cf_cod"] + 100;
  } 
  
  return $proto;  
}
?>
