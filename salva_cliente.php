<?php
//contatore CS
function contatore()
{
global $con;	
global $tipo_anagrafica;	
$proto=0;
$cerca=$tipo_anagrafica . "7777700";
$qr="SELECT cf_cod FROM clienti WHERE cf_cod < '$cerca' ORDER BY cf_cod DESC LIMIT 1";
$rst=mysql_query($qr, $con);
while ($row = mysql_fetch_assoc($rst)) {
        $proto=$row["cf_cod"] + 100;
        }
return $proto;  
}
////////////
session_start();
$iddu=$_SESSION["iddu"];
$utente=$_SESSION["ute"];
require 'include/database.php';
require 'include/java.php';
require 'class_varie.php';
$dati = $_POST["dati_json"];
$nuovo = $_POST["nuovo"];
$json = json_decode($dati, TRUE);
foreach($json as $key=>$value){
  if (is_array($json[$key])) {
    $$key = $value;
  } else {
    $$key = mysql_real_escape_string($value);
  }
}
//file_put_contents("debug.txt", $dati);
$msg="";
$cf_ragsoc=addslashes(strtoupper($cf_ragsoc));
$cf_cognome=addslashes(strtoupper($cf_cognome));
$cf_nome=addslashes(strtoupper($cf_nome));
$cf_codfisc=strtoupper($cf_codfisc);
$cf_note=addslashes($cf_note);
/*
$add_imballo=0;
$add_sp_inc=0;
$no_ec=0;
$fatt_separate=0;
$rb_unicacig=0;
if(isset($cf_add_imballo)) {$add_imballo=1;}
if(isset($cf_add_sp_inc)) {$add_sp_inc=1;}
if(isset($cf_no_ec)) {$no_ec=1;}
if(isset($cf_fatt_separate)) {$fatt_separate=1;}
if(isset($cf_rb_unicacig)) {$rb_unicacig=1;}
*/
if($nuovo=="1")
  {
  if(trim($cf_cod)=="")
    {
	$cf_cod=contatore();
	}
  $qr = "INSERT INTO clienti (cf_cli_for, cf_ragsoc, cf_tipo, cf_cognome, cf_nome, cf_cnazione, cf_nazione, cf_piva, cf_codfisc, cf_indirizzo, cf_clocalita, cf_localita, cf_cap, cf_prov, cf_add_imballo, cf_add_sp_inc, cf_no_ec, cf_fatt_separate, cf_rb_unicacig, cf_note, cf_cod) VALUES ('$tipo_anagrafica', '$cf_ragsoc', '$cf_tipo', '$cf_cognome', '$cf_nome', '$cf_cnazione', '$cf_nazione', '$cf_piva', '$cf_codfisc', '$cf_indirizzo', '$cf_clocalita', '$cf_localita', '$cf_cap', '$cf_prov', '$cf_add_imballo', '$cf_add_sp_inc', '$cf_no_ec', '$cf_fatt_separate', '$cf_rb_unicacig', '$cf_note', '$cf_cod')";
//file_put_contents("debug1.txt", $qr);
  mysql_query($qr,$con);
  $msg = mysql_error();
  $qs=addslashes($qr);
  $log=new scrivi_log($utente,"inserito cliente: $qs");
  }
else
  {
  $qr="UPDATE clienti SET cf_cli_for='$tipo_anagrafica', cf_ragsoc='$cf_ragsoc', cf_tipo='$cf_tipo', cf_cognome='$cf_cognome', cf_nome='$cf_nome', cf_cnazione='$cf_cnazione', cf_nazione='$cf_nazione', cf_piva='$cf_piva', cf_codfisc='$cf_codfisc', cf_indirizzo='$cf_indirizzo', cf_clocalita='$cf_clocalita', cf_localita='$cf_localita', cf_cap='$cf_cap', cf_prov='$cf_prov', cf_add_imballo='$cf_add_imballo', cf_add_sp_inc='$cf_add_sp_inc', cf_no_ec='$cf_no_ec', cf_fatt_separate='$cf_fatt_separate', cf_rb_unicacig='$cf_rb_unicacig', cf_note='$cf_note' WHERE cf_cod='$cf_cod'";
  mysql_query($qr,$con);
  $msg = mysql_error();
  $qs=addslashes($qr);
  $log=new scrivi_log($utente,"aggiornato cliente: $qs");
  }  
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
?>
