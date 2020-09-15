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
$righej=json_encode($righe);
$righej=addslashes($righej);
//
$dati_prima_cipi=addslashes($dati["dati_prima_cipi"]);
$cliente_cipi=$dati["cliente_cipi"];
$age_cipi=$dati["age_cipi"];
$abilitato_cipi=$dati["abilitato_cipi"];
//
$scadenze=$dati["scadenze"];
$scadenzej=json_encode($scadenze);
//file_put_contents("debug.txt", $dati_json);
$data_doc=substr($dati["data_doc"],6,4) . "-" . substr($dati["data_doc"],3,2) . "-" . substr($dati["data_doc"],0,2);
$anno=substr($dati["data_doc"],6,4);
$idt=$dati["idt"];
$tipodoc=$dati["tipodoc"];
$deposito=$dati["deposito"];
$nume_man=$dati["nume_man"];
$cliente=$dati["cliente"];
$age=$dati["age"];
$paga=$dati["paga"];
$tot_ali=$dati["tot_ali"];
$tot_imponibile=$dati["tot_imponibile"];
$tot_imposta=$dati["tot_imposta"];
//
$consegna=$dati["consegna"];
$vettore=addslashes($dati["vettore"]);
$indvettore=addslashes($dati["indvettore"]);
$scontocassa=floatval($dati["scontocassa"]);
$importoscontocassa=floatval($dati["importoscontocassa"]);
$causale=addslashes($dati["causale"]);
$porto=addslashes($dati["porto"]);
$aspetto=addslashes($dati["aspetto"]);
$colli=floatval($dati["colli"]);
$peso=floatval($dati["peso"]);
$incassato=floatval($dati["incassato"]);
$data_ritiro=substr($dati["data_ritiro"],6,4) . "-" . substr($dati["data_ritiro"],3,2) . "-" . substr($dati["data_ritiro"],0,2);
$ora_ritiro=addslashes($dati["ora_ritiro"]);
//
$des_rag_soc=addslashes($dati["des_rag_soc"]);
$des_indirizzo=addslashes($dati["des_indirizzo"]);
$des_cap=addslashes($dati["des_cap"]);
$des_localita=addslashes($dati["des_localita"]);
$des_prov=addslashes($dati["des_prov"]);
$des_spedizione=addslashes($dati["des_spedizione"]);
$des_trasporto=addslashes($dati["des_trasporto"]);
$des_imballo=addslashes($dati["des_imballo"]);
$cig=addslashes($dati["cig"]);
$cup=addslashes($dati["cup"]);
$notes=addslashes($dati["notes"]);
$descausale=addslashes($dati["descausale"]);
$acconto=floatval($dati["acconto"]);
$caparra=floatval($dati["caparra"]);
$trasporto=floatval($dati["trasporto"]);
$installazione=floatval($dati["installazione"]);
$jolly=floatval($dati["jolly"]);
$noleggio=floatval($dati["noleggio"]);
$collaudo=floatval($dati["collaudo"]);
$europallet=floatval($dati["europallet"]);
$addvari=floatval($dati["addvari"]);
//
for($j=0;$j<5;$j++)
  {
  $p=$j+1;
  $ali_j="DOCT_ALIQUOTA_" . $p;  
  $imponibile_j="DOCT_IMPONIBILE_" . $p;  
  $imposta_j="DOCT_IMPOSTA_" . $p;
  
  if(isset($tot_ali[$j]))
    {
    $$ali_j=$tot_ali[$j];  
    $$imponibile_j=$tot_imponibile[$j];  
    $$imposta_j=$tot_imposta[$j];  
	}
  else
    {
    $$ali_j="";  
    $$imponibile_j=0;  
    $$imposta_j=0;  
	}
  }
$DOCT_TOT_IMPOSTA=$dati["totale_imposta"];
$DOCT_TOT_IMPONIBILE=$dati["totale_imponibile"];
$DOCT_TOT_FATTURA=$dati["totale_fattura"];
$DOCT_IMPORTO_RAE=$dati["totale_raee"];
//
$numero=$dati["nume_doc"];
if($idt==""||$idt=="0")
  {
  if(intval($nume_man)==0)
    {
    $numero=progressivo($anno,$deposito,$tipodoc);
	}
  else
    {
	$numero=intval($nume_man);
	}
  $qr = "INSERT INTO documtes (DOCT_TIPO_DOC, DOCT_DEPOSITO, DOCT_DATA_DOC, DOCT_NUM_DOC, DOCT_CLIENTE, DOCT_ALIQUOTA_1, DOCT_IMPONIBILE_1, DOCT_IMPOSTA_1,DOCT_ALIQUOTA_2, DOCT_IMPONIBILE_2, DOCT_IMPOSTA_2, DOCT_ALIQUOTA_3, DOCT_IMPONIBILE_3, DOCT_IMPOSTA_3, DOCT_ALIQUOTA_4, DOCT_IMPONIBILE_4, DOCT_IMPOSTA_4, DOCT_ALIQUOTA_5, DOCT_IMPONIBILE_5, DOCT_IMPOSTA_5, DOCT_TOT_IMPONIBILE, DOCT_TOT_IMPOSTA, DOCT_TOT_FATTURA, DOCT_AGENTE, DOCT_COD_PAG, DOCT_CAUSALE, DOCT_DES_CAUSALE, DOCT_IMPORTO_RAE, DOCT_UTENTE, DOCT_SCADENZE, DOCT_DES_RAG_SOC, DOCT_DES_INDIRIZZO,DOCT_DES_CAP, DOCT_DES_LOC, DOCT_DES_PR, DOCT_CIG, DOCT_CUP, DOCT_NOTE, DOCT_ACCONTO, DOCT_VERSAMENTO, DOCT_TRASPORTO, DOCT_INSTALLAZ, DOCT_JOLLY, DOCT_NOLEGGIO, DOCT_COLLAUDO, DOCT_EUROPALLET, DOCT_ADDVARI, DOCT_MDV, DOCT_VETTORE, DOCT_IND_VETTORE, DOCT_PORTO, DOCT_ASPETTO, DOCT_COLLI, DOCT_PESO, DOCT_ULT_SCONTO, DOCT_SCONTO_CASSA, DOCT_INCASSATO, DOCT_DATA_RITIRO, DOCT_ORA_RIT, DOCT_RIGHE) VALUES ('$tipodoc', '$deposito', '$data_doc','$numero', '$cliente', '$DOCT_ALIQUOTA_1', '$DOCT_IMPONIBILE_1', '$DOCT_IMPOSTA_1', '$DOCT_ALIQUOTA_2', '$DOCT_IMPONIBILE_2', '$DOCT_IMPOSTA_2', '$DOCT_ALIQUOTA_3', '$DOCT_IMPONIBILE_3', '$DOCT_IMPOSTA_3', '$DOCT_ALIQUOTA_4', '$DOCT_IMPONIBILE_4', '$DOCT_IMPOSTA_4', '$DOCT_ALIQUOTA_5', '$DOCT_IMPONIBILE_5', '$DOCT_IMPOSTA_5', '$DOCT_TOT_IMPONIBILE', '$DOCT_TOT_IMPOSTA', '$DOCT_TOT_FATTURA', '$age', '$paga', '$causale', '$descausale', '$DOCT_IMPORTO_RAE', '$ute', '$scadenzej', '$des_rag_soc', '$des_indirizzo', '$des_cap', '$des_localita', '$des_prov', '$cig', '$cup', '$notes', '$acconto', '$caparra', '$trasporto', '$installazione', '$jolly', '$noleggio', '$collaudo', '$europallet', '$addvari', '$consegna', '$vettore','$indvettore','$porto','$aspetto','$colli','$peso','$scontocassa','$importoscontocassa','$incassato', '$data_ritiro', '$ora_ritiro', '$righej')";
  }
else
  {
  $qr="UPDATE documtes SET DOCT_CLIENTE='$cliente', DOCT_AGENTE='$age', DOCT_ALIQUOTA_1='$DOCT_ALIQUOTA_1', DOCT_IMPONIBILE_1='$DOCT_IMPONIBILE_1', DOCT_IMPOSTA_1='$DOCT_IMPOSTA_1',DOCT_ALIQUOTA_2='$DOCT_ALIQUOTA_2', DOCT_IMPONIBILE_2='$DOCT_IMPONIBILE_2', DOCT_IMPOSTA_2='$DOCT_IMPOSTA_2', DOCT_ALIQUOTA_3='$DOCT_ALIQUOTA_3', DOCT_IMPONIBILE_3='$DOCT_IMPONIBILE_3', DOCT_IMPOSTA_3='$DOCT_IMPOSTA_3', DOCT_ALIQUOTA_4='$DOCT_ALIQUOTA_4', DOCT_IMPONIBILE_4='$DOCT_IMPONIBILE_4', DOCT_IMPOSTA_4='$DOCT_IMPOSTA_4', DOCT_ALIQUOTA_5='$DOCT_ALIQUOTA_5', DOCT_IMPONIBILE_5='$DOCT_IMPONIBILE_5', DOCT_IMPOSTA_5='$DOCT_IMPOSTA_5', DOCT_TOT_IMPONIBILE='$DOCT_TOT_IMPONIBILE', DOCT_TOT_IMPOSTA='$DOCT_TOT_IMPOSTA', DOCT_TOT_FATTURA='$DOCT_TOT_FATTURA', DOCT_AGENTE='$age', DOCT_COD_PAG='$paga', DOCT_CAUSALE='$causale', DOCT_DES_CAUSALE='$descausale', DOCT_IMPORTO_RAE='$totale_rae', DOCT_UTENTE='$ute', DOCT_SCADENZE='$scadenzej', DOCT_DES_RAG_SOC='$des_rag_soc',DOCT_DES_INDIRIZZO='$des_indirizzo',DOCT_DES_CAP='$des_cap', DOCT_DES_LOC='$des_localita', DOCT_DES_PR='$des_prov', DOCT_CIG='$cig', DOCT_CUP='$cup', DOCT_NOTE='$notes', DOCT_ACCONTO='$acconto', DOCT_VERSAMENTO='$caparra', DOCT_TRASPORTO='$trasporto', DOCT_INSTALLAZ='$installazione', DOCT_JOLLY='$jolly', DOCT_NOLEGGIO='$noleggio', DOCT_COLLAUDO='$collaudo', DOCT_EUROPALLET='$europallet', DOCT_ADDVARI='$addvari', DOCT_MDV='$consegna', DOCT_VETTORE='$vettore', DOCT_IND_VETTORE='$indvettore', DOCT_PORTO='$porto', DOCT_ASPETTO='$aspetto', DOCT_COLLI='$colli', DOCT_PESO='$peso',DOCT_ULT_SCONTO='$scontocassa', DOCT_SCONTO_CASSA='$importoscontocassa', DOCT_INCASSATO='$incassato', DOCT_DATA_RITIRO='$data_ritiro', DOCT_ORA_RIT='$ora_ritiro', DOCT_RIGHE='$righej' WHERE DOCT_ID='$idt'";
  }
//$aa=print_r($dati, true);
//file_put_contents("debugqr.txt", "$aa\n$qr");
mysql_query($qr,$con);
if($idt==""||$idt=="0")
  {
  $idt = mysql_insert_id();
  }
$success = false;
$msg="";
$msg.=mysql_error();
//
//$msg=$qr;
$qr=addslashes($qr);
$log=new scrivi_log($utente,"salva_doc: $qr");
//
$cot_magazzino="N";
$qr="SELECT cot_magazzino FROM contatori_tipi WHERE cot_tipo='$tipodoc'";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
  $cot_magazzino=$row["cot_magazzino"];
  }
//
//scrivi righe su movmag
if($cot_magazzino=="S")
  {
$qd="DELETE FROM movmag WHERE mov_clifor='$cliente_cipi' AND mov_tipo_doc='$tipodoc' AND mov_id_rife='$idt'";
mysql_query($qd,$con);
for($j=0; $j<count($righe["cod"]); $j++)
  {
  $cod=$righe["cod"][$j];
  $desc=addslashes($righe["desc"][$j]);
  $qta=$righe["qta"][$j];
  $uni=$righe["uni"][$j];
  $sco=$righe["sco"][$j];
  $tot=$righe["tot"][$j];
  if(substr($cod,0,1)<"A" && trim($cod)>"")
    {  
    $qw="INSERT INTO movmag (mov_data, mov_codart, mov_dep, mov_causale, mov_qua, mov_prezzo, mov_sconto, mov_totale, mov_tipo_doc, mov_doc, mov_clifor, mov_id_rife, mov_data_ins, mov_data_mod, mov_utente) VALUES ('$data_doc', '$cod', '$deposito', '$causale', '$qta', '$uni', '$sco', '$tot', '$tipodoc', '$numero', '$cliente', '$idt', NOW(), NOW(), '$iddu')";
    mysql_query($qw,$con);
    $msg.=mysql_error();
    $qw=addslashes($qw);
    $log=new scrivi_log($utente,"scrivi movmag: $qw");
	}
//scrivi statvaria se cipi
  if($abilitato_cipi=="1")
    {
    $qd="DELETE FROM statvaria WHERE var_idt='$idt' LIMIT 1";
    mysql_query($qd,$con);
    $msg.=mysql_error();
    $qw="INSERT INTO statvaria (var_idt, var_data_doc, var_num_doc, var_cliente, var_clienten, var_agente, var_agenten, var_righe, var_righen, var_data_ins, var_data_mod, var_utente) VALUES ('$idt', '$data_doc', '$numero', '$cliente_cipi', '$cliente', '$age_cipi', '$age', '$dati_prima_cipi', '$righej' , NOW(), NOW(), '$iddu')";
    mysql_query($qw,$con);
    $msg.=mysql_error();
	}
  }
  }
//fine scrivi righe
//
if ($msg ==  "") {
  $success = true;
} else {
  $msg = "Attenzione, errori nel salvataggio: ".$msg;
}
$resp = array("success" => $success, "msg" => $msg, "idt" => $idt, "numero" => $numero);
header('Content-Type: application/json');
echo json_encode($resp);
?>
