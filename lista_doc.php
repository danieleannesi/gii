<!DOCTYPE html>
<html>
<head>
<title>Galli Innocenti</title>
<link rel="stylesheet" href="Style.css" type="text/css">
<link rel="stylesheet" href="style_listaper.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />

<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="include/jquery-dateFormat.min.js"></script>
<script type="text/javascript" src="calendar/calendar_eu.js"></script>
<script type="text/javascript" src="lib2.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javascript" src="lista_doc.js"></script>

<div id="oscura" class="popup_cont" >
	<div id="attendere" >
			<img src="immagini/loading.gif" />
			<br />
			Loading...
			<div id="loading_message" ></div>
	</div>
</div>
<div id="timepopup" class="timepopup" ></div>
<div id="dialog" title=""></div>
<div id="dialogs" title=""></div>
<div id="popup" title=""></div>
<div id="lista_vie" ></div>
</head>
<?php
session_start();
if(!isset($_SESSION["iddu"]))
  {
  exit;
  }
$iddu=$_SESSION["iddu"];
$deposito=$_SESSION["deposito"];
$ute=$_SESSION["ute"];
$utente=$ute;
//
require 'include/database.php';
require 'include/java.php';
require 'include/functionsJS.js';
require_once 'leggi_codici.php';
//
$oggi=date("d/m/Y");
$data_a=$oggi;
$data_da=date('d/m/Y', strtotime('-6 months'));
$dal=addrizza("",$data_da);
$al=addrizza("",$data_a);
$tipodoc="";
$cliente="";
$ragsoc="";
if(isset($_POST["data_da"]))
  {
  $tipodoc=$_POST["tipodoc"];
  $cliente=$_POST["cliente"];
  $ragsoc=$_POST["ragsoc"];
  $data_da=$_POST["data_da"];
  $data_a=$_POST["data_a"];
  $deposito=$_POST["deposito"];
  $dal=addrizza("",$data_da);
  $al=addrizza("",$data_a);
  }
?>
<body>
<div id="dialog" ></div>
<div id="stampa" title=""></div>
<div id="popup" title=""></div>
<div>
<form action="lista_doc.php" method='POST' id='formperdata' name='formperdata'>

<label for="deposito">Deposito</label>
<select id="deposito" name="deposito">
<?php
$j=0;
while(isset($coddep[$j])) {
  echo "<option value=\"$coddep[$j]\"";
  if($deposito==$coddep[$j]) { echo " selected"; };
  echo ">" . $desdep[$j] . "</option>";
  $j++;
  }
?>
</select>
&nbsp;&nbsp;
<label for="tipodoc">Tipo Doc.</label>
<select id="tipodoc" name="tipodoc">
<option value="7"<?php if($tipodoc=="7") echo " selected";?>>Fattura</option>
<option value="8"<?php if($tipodoc=="8") echo " selected";?>>Nota di Credito</option>
<option value="1"<?php if($tipodoc=="1") echo " selected";?>>Doc.di Trasporto</option>
<option value="2"<?php if($tipodoc=="2") echo " selected";?>>Fattura accompagnatoria</option>
<option value="3"<?php if($tipodoc=="3") echo " selected";?>>Scontrino</option>
<option value="4"<?php if($tipodoc=="4") echo " selected";?>>Buono di acquisto (da reso merce)</option>
<option value="5"<?php if($tipodoc=="5") echo " selected";?>>Fattura caparra</option>
<option value="6"<?php if($tipodoc=="6") echo " selected";?>>Scontrino caparra</option>
<option value="9"<?php if($tipodoc=="9") echo " selected";?>>Nota di debito</option>
<option value="A"<?php if($tipodoc=="A") echo " selected";?>>Documento Interno</option>
<option value="B"<?php if($tipodoc=="B") echo " selected";?>>Incasso versam. su ORDINE</option>
</select>
<br>
<label for="data_da">Dalla Data:</label>
<input id="data_da" type="text" size="11" maxlength="11" onChange="check_date(data_da);" name="data_da" value="<?php echo $data_da?>"/>
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'formperdata',
                // input name
                'controlname': 'data_da'
        });
        </script>
&nbsp;&nbsp;
<label for="data_a">Alla Data:</label>
<input id="data_a" type="text" size="11" maxlength="11" onChange="check_date(data_a);" name="data_a" value="<?php echo $data_a?>"/>
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'formperdata',
                // input name
                'controlname': 'data_a'
        });
        </script>
<br>        
<label for="cliente">Cliente</label>
<input id="cliente" name="cliente" type="text"size="9" maxlength="8" value="<?php echo $cliente?>" readonly>
<input name="ragsoc"  id="ragsoc" type="text" size="90" value="<?php echo $ragsoc?>">
&nbsp;&nbsp;
<input type="button" id="listap" name="listap" value="LISTA" onclick="document.formperdata.submit();">

</form>	
</div>
<div>
<?php
$q1="";
if($cliente>"")
  {
  $q1="AND DOCT_CLIENTE='$cliente'";
  }
$qr="SELECT * FROM documtes LEFT JOIN clienti ON DOCT_CLIENTE=cf_cod WHERE DOCT_DEPOSITO='$deposito' AND DOCT_TIPO_DOC='$tipodoc' AND DOCT_DATA_DOC BETWEEN '$dal' AND '$al' $q1 ORDER BY DOCT_DATA_DOC DESC, DOCT_NUM_DOC DESC LIMIT 500";
//echo $qr;   
$rst=mysql_query($qr,$con);
?>
<div class='tablewrap'><div class='tablewrap-inner'><table><thead><tr><th class='a'>Data</th><th class='b'>Numero</th><th class='c'>Ragione Sociale</th><th class='b'>Totale</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th></tr></thead><tbody>
<?php
while($row=mysql_fetch_assoc($rst)){
  extract($row);
  $salta=0;
/*
  if($protocollo>"")
     {
	 if($acc_protocollo!=$protocollo)
	   {
	   	$salta=1;
	   }
	 }
*/
if($salta==0)
 {
  $data=addrizza($row["DOCT_DATA_DOC"],"");
  echo "<tr>";
  echo "<td class='a'>$data</td><td class='b'>$DOCT_NUM_DOC</td><td class='c'>$cf_ragsoc</td><td class='b'>$DOCT_TOT_FATTURA</td><td class='d'><td class='i'><img src='immagini/pencil.png' width='20px' title='Modifica Documento' onclick='chiama_doc($DOCT_ID);'></td><td class='i'><img src='immagini/printer.png' width='20px' title='Stampa' onclick='stampa_doc($DOCT_ID,$tipodoc);'></td><td class='i'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='immagini/button_drop.png' width='15px' title='ELIMINA DOCUMENTO' onclick='cancella_doc($DOCT_ID,$DOCT_NUM_DOC,$tipodoc,$DOCT_CLIENTE);'></td></tr>";
 }	 
  }
?>
</tbody></table></div></div>
</div>
<div id="lancia"></div>
</body>
</html>