<?php
session_start();
if(!isset($_SESSION["iddu"]))
  {
  echo "Sessione scaduta; <a href=\"login.php\">Effettuare il Login</a>"; exit;
  }
$iddu=$_SESSION["iddu"];
$ute=$_SESSION["ute"];
$utente=$iddu;
require 'include/database.php';
require 'include/functions.php';
require 'class_varie.php';
$dati_json = $_POST["dati_json"];
$dati=json_decode ($dati_json,true);
$righe=$dati["righe"];
$data_doc=substr($dati["data_doc"],6,4) . "-" . substr($dati["data_doc"],3,2) . "-" . substr($dati["data_doc"],0,2);
$anno=substr($dati["data_doc"],6,4);
$idt=$dati["idt"];
$deposito=$dati["deposito"];
$numero=$dati["numero"];
$fornitore=$dati["fornitore"];
$totale_imponibile=$dati["totale_imponibile"];
$causale=addslashes($dati["causale"]);
$tipo_doc=$dati["tipo_doc"];
$doc=$dati["doc"];
$id_rife=$dati["id_rife"];
//
$success=false;
$msg="";
if($idt=="" || $idt=="0")
  {
  $id_rife=progressivo($anno,$deposito,"MM");
  }
for($j=0; $j<count($righe["cod"]); $j++)
  {

  $log=new scrivi_log($utente,"salva_pnmagaz: j=$j");

  $art=$righe["cod"][$j];
  $qua=$righe["qta"][$j];
  $prezzo=$righe["uni"][$j];
  $sco=$righe["sco"][$j];
  $totale=$righe["tot"][$j];
  if($idt=="" || $idt=="0")
    {
    $qr="INSERT INTO movmag (mov_data, mov_codart, mov_dep, mov_causale, mov_qua, mov_prezzo, mov_sconto, mov_totale, mov_tipo_doc, mov_doc, mov_clifor, mov_id_rife, mov_data_ins, mov_data_mod, mov_utente) VALUES ('$data_doc', '$art', '$deposito', '$causale', '$qua', '$prezzo', '$sco', '$totale', '$tipo_doc', '$numero', '$fornitore', '$id_rife', NOW(), NOW(), '$iddu')";
    mysql_query($qr,$con);
    $msg.=trim(mysql_error());
    }
  else
    {
    $qr="UPDATE movmag SET mov_data='$data_doc', mov_codart='$art', mov_dep='$deposito', mov_causale='$causale', mov_qua='$qua', mov_prezzo='$prezzo', mov_sconto='$sco', mov_totale='$totale', mov_tipo_doc='$tipo_doc', mov_doc='$doc', mov_clifor='$fornitore', mov_id_rife='$id_rife', mov_data_mod=NOW(), mov_utente='$iddu' WHERE mov_id='$idt'";
    mysql_query($qr,$con);
    $msg.=trim(mysql_error());
    }
  }
$success = false;
//
$qr=addslashes($qr);
$log=new scrivi_log($utente,"salva_pnmagaz: $qr - $msg");
//
if ($msg=="") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg);
header('Content-Type: application/json');
echo json_encode($resp);
?>
