<?php
session_start();
if(!isset($_SESSION["iddu"]))
  {
  exit;
  }
$iddu=$_SESSION["iddu"];
$deposito=$_SESSION["deposito"];
$ute=$_SESSION["ute"];
?>
<html>
<head>
<link rel="STYLESHEET" href="style.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />
<title>Gestione Preventivi</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body class="prev">
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javaScript" src="calendar/calendar_eu.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javaScript" src="ges_prev.js"></script>

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
<div id="dialog_eliminariga"></div>
<div id="popup" title=""></div>
<div id="lista_vie" ></div>

<?php
require 'include/functionsJS.js';
require 'include/java.php';
require 'include/database.php';
//
$data=date("d/m/Y");
  $data_doc="";
  $nume_doc="";
  $paga="";
  $tipo_cli_e=" selected ";
  $tipo_cli_p="";
  $cliente="";
  $ragsoc="";
  $totalefat="";
  $iva1="";
  $impo1="";
  $ali1="22";
  $iva2="";
  $impo2="";
  $ali2="65";
  $note="";
  //$agente=$_SESSION["ute"];
  $sele1=" selected ";
  $rit_acc=0;
  $vrit_acconto=0;
  $vali_ra="";
  $data_ord="";
  $nume_ord="";
  $data_con="";
  $nume_con="";
  $cig="";
  $cup="";
//
require_once 'leggi_codici.php';
//
$idt=0;
if(isset($_GET["idt"]))
  {
  $idt=$_GET["idt"];
  }
if(isset($_POST["idt"]))
  {
  $idt=$_POST["idt"];
  }
if($idt==0){
  echo '<div class="intestazione"><a href="javascript:void(0)" class="a_button" onclick="location.reload()">Nuovo Preventivo</a></div>';
} 
?>
<form name='documenti' id='documenti'>
<div id="testa" class="testa"> 

<table class="testata">
<tr>
<td>
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
</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
<input id="idt" name="idt" type="hidden" value="<?php echo $idt?>" >
<label for="data_doc">Data</label>
<input id="data_doc" name="data_doc" type="text" size="11" maxlength="11" value="<?php echo $data?>" onChange="check_date(data_doc);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_doc'
        });
        </script>
</td>
<td>
<label for="nume_doc">Numero</label>
<input id="nume_doc" name="nume_doc" type="text" size="8" value="<?php echo $nume_doc?>" readonly="true" tabindex="-1">
</td>
<td>
<label for="nume_man">Numero Manuale</label><input id="nume_man" name="nume_man" type="text" size="8">
</td>
<td>
<label for="n_ordine">Numero Ordine</label><input id="n_ordine" name="n_ordine" type="text" size="8"><input type="button" id="trova_ordine" name="trova_ordine" value="Trova Ordine">

</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
<label for="cliente">Cliente</label>
<input id="cliente" name="cliente" type="text"size="9" maxlength="8" value="<?php echo $cliente?>" readonly onchange="carica_cliente(this);">
</td>
<td>
<input name="ragsoc"  id="ragsoc" type="text" size="90" value="<?php echo $ragsoc?>">
<input type="button" id="ordini" name="ordini" value="Ordini" onclick="vedi_ordini();" style="display: none;">
</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
<label for="agente">Agente</label>
<select id="agente" name="agente">
<?php
$h=0;
while(isset($codage[$h])) {
  echo "<option value=\"$codage[$h]\"";
  if($agente==$codage[$h]) { echo " selected"; };
  echo ">" . $desage[$h] . "</option>";
  $h++;
  }
?>
</select>
</td>
<td>
<label for="ute">Commesso</label>
<select id="ute" name="ute">
<?php
$j=0;
while(isset($codcom[$j])) {
  echo "<option value=\"$codcom[$j]\"";
//  if($ute==$codcom[$j]) { echo " selected"; };
  echo ">" . $descom[$j] . "</option>";
  $j++;
  }
?>
</select>
</td>
<td>
<label for="paga">Pagamento</label>
<select id="paga" name="paga">
<?php
$j=0;
while(isset($codpaga[$j])) {
  echo "<option value=\"$codpaga[$j]\"";
  if($paga==$codpaga[$j]) { echo " selected"; };
  echo ">" . $despaga[$j] . "</option>";
  $j++;
  }
?>
</select>
</td>
</tr>
</table>
</div>
<div id="riga" class="riga"> 
<table width="916">
<tr>
<td>
<input type="button" id="idro" value="idro" onclick="win_idro();">
<input type="text" id="codart" name="codart" size="10" placeholder="codice articolo" onchange="carica_articolo(this.value);">
</td>
<td>
<textarea id="desart" name="desart" placeholder="descrizione articolo" rows="1" cols="80">
</textarea>
<input type="hidden" id="raee" name="raee">
<input type="hidden" id="ordine" name="ordine">
</td>
<td><input class="acapo" id="OK" name="OK" type="button" value="Salva Riga" onClick="salvariga();"></td>
</tr>
</table>
<table width="916">
<tr>
<td width="64" align="right" class="labelit">Quantita</td>
<td>
<input id="indice" name="indice" type="hidden">	
<input id="quantita" name="quantita" class="piccolo" type="number" step=".01" onfocus="$('#lista_vie').hide();" onBlur="calcolar();">
</td>
<td width="65" align="right" class="labelit">Unit.</td>
<td><input id="prezzo" name="prezzo" class="piccolo" type="number" step=".0001" onBlur="calcolar()"></td>
<td width="65" align="right" class="labelit">Sconto</td>
<td><input id="sconto" name="sconto" class="piccolo" type="number" step=".01" onBlur="calcolar()"></td>
<td width="59" align="right" class="labelit">Totale</td>
<td><input id="totale" name="totale" class="piccolo" type="number" step=".01" readonly="true" tabindex="-1"></td>
<td width="59" align="right" class="labelit">Cod.Iva</td>
<td>
<select id="ali0" name="ali0" class="piccolo">
<?php
$j=0;
while(isset($codiva[$j])) {
  $civa=$codiva[$j];
  echo "<option value=\"$civa\"";
  echo ">" . $desiva[$j] . "</option>";
  $j++;
  }
?>
</select>
</td>
</tr>
</table>
<div id="giacenze"></div>
</div>
<div id="righedoc" class="righedoc">
<!-- RIGHE DOCUMENTO --> 
</div>
<div class="row"> <input type="checkbox" id="checkall" />
<label for="checkall">Seleziona tutto</label>
<input type="button" onclick="modifica_iva();" name="modify_iva" value="MODIFICA IVA" />
<input type="button" onclick="deleteSelectedRow();" name="deleteRow" value="ELIMINA RIGHE" />
</div>
<div id="righetot" class="righetot">
<!-- RIGHE TOTALI -->
</div>
<div id="righetot2" class="righetot2">
<!-- RIGHE DESTRA -->
<label for="totale_fattura">Totale Documento</label>
<input class="destra" type="text" id="totale_fattura" name="totale_fattura" size="10" readonly>
</div>
<div id="tappo" class="tappo">
</div>
<table>
<tr>
<td width="109"><input name="confe" id="confe" type="button" value="CONFERMA" onClick="confer()"></td>
<td width="92" class="destra"><input id="stamp" name="stamp" type="button" value="STAMPA" onClick="stampa()"></td>
</tr>
</table>
</form>
<div id="dialog_iva" title="Modifica Iva">
  <p>Applica Iva alle righe selezionate</p>
    <select id="ali_iva" name="ali_iva" class="piccolo">
        <?php
        $j=0;
        while(isset($codiva[$j])) {
          $civa=$codiva[$j];
          echo "<option value=\"$civa\"";
          echo ">" . $desiva[$j] . "</option>";
          $j++;
          }
        ?>
    </select>
</div>
</body>
</html>