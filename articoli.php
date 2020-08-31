<!DOCTYPE html>
<html>
<head>
<title>Gestione Articoli</title>
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />

<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="include/jquery-dateFormat.min.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javascript" src="articoli.js"></script>
<script type="text/javascript" src="calendar/calendar_eu.js"></script>
</head>
<body class="prev">
<div id="oscura" class="popup_cont" >
	<div id="attendere" >
			<img src="immagini/loading.gif" />
			<br />
			Loading...
			<div id="loading_message" ></div>
	</div>
</div>
<div id="timepopup" class="timepopup" ></div>
<?php
session_start();
$puosalvare=1;
/*
if(!isset($_SESSION["ute"])) {
  echo "<a href=\"login.php\">Effettuare il Login</a>";
  exit;
  }
$ute=$_SESSION["ute"];
$unita=$_SESSION["s_unita"];
$tipo_utente=$_SESSION["s_tipo_utente"];
$amministratore=$_SESSION["amministratore"];
$coordinatore=$_SESSION["coordinatore"];
$puosalvare=0;
if($tipo_utente==9 || $tipo_utente==4 || $amministratore==1)
  {
  $puosalvare=1;
  }
*/
//
require 'include/database.php';
require 'include/java.php';
require 'leggi_codici.php';
require 'include/functionsJS.js';
?>
<form method='POST' id='formarticoli' name='formarticoli'>
<div id="lista_vie" ></div>
<div id="dialog" ></div>
<div class="ana"><input type="button" value="NUOVA ANAGRAFICA" onclick="nuovo_articolo();"></div>
<?php
if($puosalvare==1)
  {
?>
<div style="margin-left:50px;">
<input type="button" name="conferma" id="conferma" value="CONFERMA" title="Conferma" onClick="return controlla();"/>
</div>
<?php  	
  }
?>
<div class="ana">Codice:</div><div><input name="codart" id="codart" type="text" size="11" onchange="carica_articolo(this);"><input id="nuovo" type="hidden" value=""></div>
<div class="ana">Descrizione:</div><div><input id="desart" type="text" size="80" name="desart" style="text-transform:uppercase"/></div>
<div class="ana"><label for="art_classe">Classe Merceologica:</label></div>
<div>
<select id="art_classe_merc" name="art_classe_merc" class="piccolo">
<?php
$j=0;
while(isset($codmerc[$j])) {
  $merc=$codmerc[$j];
  echo "<option value=\"$merc\"";
  echo ">" . $descmerc[$j] . "</option>";
  $j++;
  }
?>
</select>
</div>
<div class="ana"><label for="art_fornitore">Codice Fornitore:</label></div>
<div><input id="art_fornitore" type="text" size="8" name="art_fornitore" onchange="carica_fornitore(this);"/><input id="for_ragsoc" type="text" size="80" name="for_ragsoc" style="text-transform:uppercase"/></div>
<div class="ana"><label for="art_uni_mis">Unita di Misura:</label></div>
<div>
<select id="art_uni_mis" name="art_uni_mis">
<?php
$j=0;
while(isset($codunita[$j])) {
  echo "<option value=\"$codunita[$j]\"";
  echo ">" . $descunita[$j] . "</option>";
  $j++;
  }
?>
</select>
</div>
<div class="ana"><label for="art_cod_iva">Trattamento IVA:</label></div>
<div>
<select id="art_cod_iva" name="art_cod_iva" class="piccolo">
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
<div class="ana"><label for="art_listino1">Listino 1:</label></div><div><input class="dx" id="art_listino1" type="text" size="15" name="art_listino1"/></div>
<div class="ana"><label for="art_listino2">Listino 2:</label></div>
<div>
<input class="dx" id="art_listino2" type="text" size="15" name="art_listino2"/>
<label for="art_data_listino" >Data Listino 2:</label><input id="art_data_listino" type="text" size="11" maxlength="11" onChange="check_date(art_data_listino);" name="art_data_listino"/>
          <script type="text/javascript">
        new tcal ({
                // form name
                'formname': 'formarticoli',
                // input name
                'controlname': 'art_data_listino'
        });
        </script>
</div>
<div class="ana"><label for="art_codice_raee">Cod.Articolo RAEE:</label></div><div><input id="art_codice_raee" type="text" size="9" name="art_codice_raee"/></div>
<div class="ana"><label for="art_scorta_min">Scorta Minima:</label></div><div><input class="dx" id="art_scorta_min" type="text" size="15" name="art_scorta_min"/></div>
<div class="ana"><label for="art_scorta_max">Scorta Massima:</label></div><div><input class="dx" id="art_scorta_max" type="text" size="15" name="art_scorta_max"/></div>
<div id="giacenze"></div>

</form>
</body>
</html>