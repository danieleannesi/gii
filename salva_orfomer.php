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
$dati=json_decode($dati_json,true);
$righe=$dati["righe"];
$data_ddt=substr($dati["data_ddt"],6,4) . "-" . substr($dati["data_ddt"],3,2) . "-" . substr($dati["data_ddt"],0,2);
$data_car=substr($dati["data_car"],6,4) . "-" . substr($dati["data_car"],3,2) . "-" . substr($dati["data_car"],0,2);
$anno=substr($dati["data_car"],6,4);
$idt=$dati["idt"];
$deposito=$dati["deposito"];
$nume_ddt=$dati["nume_ddt"];
$nume_doc=$dati["nume_doc"];
$fornitore=$dati["fornitore"];
$ord_cliente=$dati["ord_cliente"];
//
$a=print_r($dati,true);
file_put_contents("debug.txt", "$a\n");  
$success=false;
$msg="";
$id_rife=progressivo($anno,$deposito,"MM");
for($j=0;$j<count($righe["cod"]); $j++)
  {
  $art=$righe["cod"][$j];
  $qua=$righe["qta_ric"][$j];
  $prezzo=$righe["uni"][$j];
  $sco=$righe["sco"][$j];
  $totale=$righe["tot"][$j];

  $rr["cod"][$j]=$righe["cod"][$j];
  $rr["desc"][$j]=$righe["desc"][$j];
  $rr["qta"][$j]=$righe["qta"][$j];
  $rr["uni"][$j]=$righe["uni"][$j];
  $rr["sco"][$j]=$righe["sco"][$j];
  $rr["tot"][$j]=$righe["tot"][$j];
  $rr["iva"][$j]=$righe["iva"][$j];
  $rr["raee"][$j]=$righe["raee"][$j];
  $rr["qta_sca"][$j]=$righe["qta_sca"][$j] + $righe["qta_ric"][$j];

  if($qua>0)
    {
    $qr="INSERT INTO movmag (mov_data, mov_codart, mov_dep, mov_causale, mov_qua, mov_prezzo, mov_sconto, mov_totale, mov_tipo_doc, mov_doc, mov_clifor, mov_id_rife, mov_data_ins, mov_data_mod, mov_utente) VALUES ('$data_car', '$art', '$deposito', '02', '$qua', '$prezzo', '$sco', '$totale', '', '$nume_ddt', '$fornitore', '$id_rife', NOW(), NOW(), '$iddu')";
    file_put_contents("debug.txt", "$qr\n", FILE_APPEND);  
    mysql_query($qr,$con);
    $msg.=trim(mysql_error());
	}
  }
//aggiorna ordine fornitore
$righej=json_encode($rr);
$righej=addslashes($righej);
$qw="UPDATE ordinifo SET ORDI_RIGHE='$righej' WHERE ORDI_ID='$idt'";
file_put_contents("debug.txt", "$qw\n", FILE_APPEND);  
$rst=mysql_query($qw,$con);
$msg.=trim(mysql_error());
//
//emetti documento interno in caso di ordine fornitore con ordi_cliente
if($ord_cliente>0)
  {
  $qo="SELECT * FROM ordini WHERE ORDI_num_doc='$ord_cliente'";
  $rso=mysql_query($qo,$con);
  while($roo = mysql_fetch_assoc($rso)) {
     extract($roo);
     }
  $righecli=json_decode($ORDI_RIGHE,true);
  for($j=0; $j<count($righecli["cod"]); $j++)
    {
    $righecli["qta_sca"][$j]=$righecli["qta_sca"][$j] + $righe["qta_ric"][$j];
	}      
  $righej=json_encode($righecli);
  $righej=addslashes($righej);
//aggiorna ordine cliente
  $qw="UPDATE ordini SET ORDI_RIGHE='$righej' WHERE ORDI_num_doc='$ord_cliente'";
  file_put_contents("debug.txt", "$qw\n", FILE_APPEND);  
  $rst=mysql_query($qw,$con);
  $msg.=trim(mysql_error());
//
  for($j=0; $j<count($righecli["cod"]); $j++)
    {
    $righecli["qta"][$j]=$righe["qta_ric"][$j];
	}      
  $righej=json_encode($righecli);
  $righej=addslashes($righej);
//  
//emetti ddt interno
  $numeroin=progressivo($anno,"0","A");
  $qr = "INSERT INTO documtes (DOCT_TIPO_DOC, DOCT_DEPOSITO, DOCT_DATA_DOC, DOCT_NUM_DOC, DOCT_CLIENTE, DOCT_ALIQUOTA_1, DOCT_IMPONIBILE_1, DOCT_IMPOSTA_1, DOCT_ALIQUOTA_2, DOCT_IMPONIBILE_2, DOCT_IMPOSTA_2, DOCT_ALIQUOTA_3, DOCT_IMPONIBILE_3, DOCT_IMPOSTA_3, DOCT_ALIQUOTA_4, DOCT_IMPONIBILE_4, DOCT_IMPOSTA_4, DOCT_ALIQUOTA_5, DOCT_IMPONIBILE_5, DOCT_IMPOSTA_5, DOCT_TOT_IMPONIBILE, DOCT_TOT_IMPOSTA, DOCT_TOT_FATTURA, DOCT_AGENTE, DOCT_COD_PAG, DOCT_CAUSALE, DOCT_DES_CAUSALE, DOCT_IMPORTO_RAE, DOCT_UTENTE, DOCT_SCADENZE, DOCT_DES_RAG_SOC, DOCT_DES_INDIRIZZO,DOCT_DES_CAP, DOCT_DES_LOC, DOCT_DES_PR, DOCT_CIG, DOCT_CUP, DOCT_NOTE, DOCT_ACCONTO, DOCT_VERSAMENTO, DOCT_TRASPORTO, DOCT_DOC_INTERNO, DOCT_INSTALLAZ, DOCT_JOLLY, DOCT_NOLEGGIO, DOCT_COLLAUDO, DOCT_EUROPALLET, DOCT_ADDVARI, DOCT_MDV, DOCT_VETTORE, DOCT_IND_VETTORE, DOCT_PORTO, DOCT_ASPETTO, DOCT_COLLI, DOCT_PESO, DOCT_SCONTO_CASSA, DOCT_INCASSATO, DOCT_DATA_RITIRO, DOCT_ORA_RIT, DOCT_RIGHE) VALUES ('1', '$deposito', '$data_car','$numeroin', '$ORDI_CLIENTE', '$ORDI_ALIQUOTA_1', '$ORDI_IMPONIBILE_1', '$ORDI_IMPOSTA_1', '$ORDI_ALIQUOTA_2', '$ORDI_IMPONIBILE_2', '$ORDI_IMPOSTA_2', '$ORDI_ALIQUOTA_3', '$ORDI_IMPONIBILE_3', '$ORDI_IMPOSTA_3', '$ORDI_ALIQUOTA_4', '$ORDI_IMPONIBILE_4', '$ORDI_IMPOSTA_4', '$ORDI_ALIQUOTA_5', '$ORDI_IMPONIBILE_5', '$ORDI_IMPOSTA_5', '$ORDI_TOT_IMPONIBILE', '$ORDI_TOT_IMPOSTA', '$ORDI_TOT_ORDINE', '$age', '$paga', '50', 'VENDITA', '0', '$utente', '', '$des_rag_soc', '$des_indirizzo', '$des_cap', '$des_localita', '$des_prov', '$cig', '$cup', '$notes', '$acconto', '$caparra', '$trasporto', 'S', '$installazione', '$jolly', '$noleggio', '$collaudo', '$europallet', '$addvari', 'D', '','','','','0','0','0','0', '', '', '$righej')";  	
  mysql_query($qr,$con);
  $msg.= mysql_error();
  file_put_contents("debug.txt", "$qr\n",FILE_APPEND);
//
//movimenti di magazzino
$id_rife=progressivo($anno,$deposito,"MM");
for($j=0;$j<count($righecli["cod"]); $j++)
  {
  $art=$righecli["cod"][$j];
  $qua=$righecli["qta_sca"][$j];
  $prezzo=$righecli["uni"][$j];
  $sco=$righecli["sco"][$j];
  $totale=$righecli["tot"][$j];
  $qr="INSERT INTO movmag (mov_data, mov_codart, mov_dep, mov_causale, mov_qua, mov_prezzo, mov_sconto, mov_totale, mov_tipo_doc, mov_doc, mov_clifor, mov_id_rife, mov_data_ins, mov_data_mod, mov_utente) VALUES ('$data_car', '$art', '$deposito', '50', '$qua', '$prezzo', '$sco', '$totale', '', '$numeroin', '$ORDI_CLIENTE', '$id_rife', NOW(), NOW(), '$iddu')";
  file_put_contents("debug.txt", "$qr\n",FILE_APPEND);
  mysql_query($qr,$con);
  $msg.=trim(mysql_error());
  }
//fine movimenti di magazzino
  } //if ord_cliente
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
