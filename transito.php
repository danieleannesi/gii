<?php
session_start();
$deposito=$_SESSION["deposito"];
$ute=$_SESSION["ute"];
$utente=$ute;
?>
<html>
<head>
<link rel="STYLESHEET" href="style.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />
<title>Gestione Merci in Transito</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body class="prev">
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javaScript" src="calendar/calendar_eu.js"></script>
<script type="text/javaScript" src="include/jquery.typewatch.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javaScript" src="transito.js"></script>
<?php
require 'include/functionsJS.js';
?>
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
require 'include/java.php';
require 'include/database.php';
//
$data=date("d/m/Y");
$anno=date("Y");
//
?>
<form action=<?php echo "$SELF"?> method='post' name='documenti' id='documenti'>
<div id="testa" class="testa">

<table class="testata">
<tr>
<td>
<input type="button" value="Nuova Registrazione" onclick="window.location.href='transito.php';">
</td>
</tr>
</table>

<table class="testata">
<tr>
<td>
<label for="fornitore">Fornitore</label>
<input id="fornitore" name="fornitore" type="text"size="9" maxlength="8" readonly onchange="carica_fornitore(this);">
</td>
<td>
<input id="test_rag" name="test_rag" type="text" size="8" placeholder="ricerca" style="background-color: yellow;">	
</td>
<td>
<input name="ragsoc"  id="ragsoc" type="text" size="50">
</td>
<td>
<label for="nume_doc">Anno</label>
<input id="anno_doc" name="anno_doc" type="text" size="5" value="<?php echo $anno;?>">
</td>
<td>
<label for="nume_doc">Numero Doc.</label>
<input id="nume_doc" name="nume_doc" type="text" size="8">
<input type="button" value="Carica" onclick="leggi_movimenti();">
</td>
</tr>
</table>

<table class="testata">
<tr>
<td>
<label for="data_fin">Data Final.</label>
<input id="data_fin" name="data_fin" type="text" size="11" maxlength="11" value="<?php echo $data;?>" onChange="check_date(data_fin);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_fin'
        });
        </script>
</td>
<td>
<label for="data_car">Data Fattura</label>
<input id="data_fat" name="data_fat" type="text" size="11" maxlength="11" onChange="check_date(data_fat);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_fat'
        });
        </script>
</td>
<td>
<label for="nume_fat">Numero Fat.</label>
<input id="nume_fat" name="nume_fat" type="text" size="8">
</td>

<td>
<label for="azzera">Azzera dati</label>
<input id="azzera" name="azzera" type="checkbox">
</td>

</tr>
</table>

</div>

<div id="sopra" class="sopra">

<div id="righedoc" class="righedoc">
<!-- RIGHE DOCUMENTO -->
</div>
<!-- FINE DIV sopra -->
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
</tr>
</table>
</form>
</body>
</html>