<!DOCTYPE html>
<html>
<head>
<title>Gestione Clienti</title>
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />

<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="include/jquery-dateFormat.min.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javascript" src="clienti.js"></script>
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
<form method='POST' id='formclienti' name='formclienti'>
<div id="lista_vie" ></div>
<div id="dialog" ></div>
<div class="ana"><input type="button" value="NUOVA ANAGRAFICA" onclick="nuovo_cliente();"></div>
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
<div class="ana">Tipo Anagrafica:</div>
<div>
<fieldset style="border: none;">
<input type="radio" id="tipo_cliente" name="tipo_anagrafica" value="1" title="Cliente" checked/><label for="tipo_cliente">C</label>
<input type="radio" id="tipo_fornitore" name="tipo_anagrafica" value="9" title="Fornitore" /><label for="tipo_fornitore">F</label>
</fieldset>
</div>
<div class="ana">Codice:</div><div><input name="cf_cod" id="cf_cod" type="text" size="9" readonly onchange="carica_cliente(this);"><input id="nuovo" type="hidden" value=""></div>
<div class="ana">Ragione Sociale:</div><div><input id="cf_ragsoc" type="text" size="80" name="cf_ragsoc" style="text-transform:uppercase"/></div>
<div class="ana">Natura Giuridica:</div>
<div>
<fieldset style="border: none;">
<input type="radio" id="giuridica" name="cf_tipo" value="G" checked/><label for="giuridica">G</label>
<input type="radio" id="maschio" name="cf_tipo" value="M"/><label for="maschio">M</label>
<input type="radio" id="femmina" name="cf_tipo" value="F"/><label for="femmina">F</label>
</fieldset>
</div>
<div class="ana">Cognome:</div><div><input id="cf_cognome" type="text" size="80" name="cf_cognome" style="text-transform:uppercase"/></div>
<div class="ana">Nome:</div><div><input id="cf_nome" type="text" size="80" name="cf_nome" style="text-transform:uppercase"/></div>
<div class="ana">Nazione:</div><div><input id="cf_cnazione" type="text" size="7" name="cf_cnazione" readonly/>&nbsp;<input id="cf_nazione" type="text" size="40" name="cf_nazione"/></div>
<div class="ana">Partita IVA:</div><div><input id="cf_piva" type="text" size="11" name="cf_piva" onchange="controlla_cf_piva(this.value);"/></div>
<div class="ana">Codice Fiscale:</div><div><input id="cf_codfisc" type="text" size="18" name="cf_codfisc" onchange="controlla_cf_piva(this.value);"/></div>
<div class="ana">Indirizzo:</div><div><input id="cf_indirizzo" type="text" size="80" name="cf_indirizzo"/></div>
<div class="ana">Cap:</div><div><input id="cf_cap" type="text" size="6" name="cf_cap"/></div>
<div class="ana">Localita:</div><div><input id="cf_clocalita" type="text" size="7" name="cf_clocalita" readonly/>&nbsp;<input id="cf_localita" type="text" size="60" name="cf_localita"/></div>
<div class="ana">Provincia:</div><div><input id="cf_prov" type="text" size="6" name="cf_prov"/></div>
<div class="ana"><label for="age">Recapiti Telefonici:</label></div><div><input id="cf_telefono" type="text" size="80" name="cf_telefono"/></div>
<div class="ana"><label for="age">Fax:</label></div><div><input id="cf_fax" type="text" size="80" name="cf_fax"/></div>
<div class="ana"><label for="age">Email:</label></div><div><input id="cf_email" type="text" size="80" name="cf_email"/></div>

<div class="ana"><label for="age">Tipo Cliente:</label></div>
<div>
<select id="cf_cod_contab" name="cf_cod_contab">
<?php
$j=0;
while(isset($codtipo[$j])) {
  echo "<option value=\"$codtipo[$j]\"";
  echo ">" . $desctipo[$j] . "</option>";
  $j++;
  }
?>
</select>
</div>

<div class="ana"><label for="age">Agente:</label></div>
<div>
<select id="cf_agente" name="cf_agente">
<?php
$j=0;
while(isset($codage[$j])) {
  echo "<option value=\"$codage[$j]\"";
  echo ">" . $desage[$j] . "</option>";
  $j++;
  }
?>
</select>
</div>

<div class="ana"><label for="paga">Pagamento:</label></div>
<div>
<select id="cf_codpag" name="cf_codpag">
<?php
$j=0;
while(isset($codpaga[$j])) {
  echo "<option value=\"$codpaga[$j]\"";
  echo ">" . $despaga[$j] . "</option>";
  $j++;
  }
?>
</select>
</div>

<div class="ana"><label for="cf_banca">Banca di Appoggio:</label></div><div><input id="cf_banca" type="text" size="80" name="cf_banca"/></div>
<div class="ana"><label for="cf_iban">IBAN:</label></div><div><input id="cf_iban" type="text" size="28" name="cf_iban"/></div>

<div class="ana"><label for="cf_piva">Trattamento IVA:</label></div>
<div>
<select id="cf_iva" name="cf_iva" class="piccolo">
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

<div class="ana"><label for="cf_classe_sconto">Classe di Sconto:</label></div>
<div>
<select id="cf_classe_sconto" name="cf_classe_sconto" class="piccolo">
<?php
$j=0;
while(isset($codclasse[$j])) {
  $classe=$codclasse[$j];
  echo "<option value=\"$classe\"";
  echo ">" . $desclasse[$j] . "</option>";
  $j++;
  }
?>
</select>
</div>

<div class="ana"><label for="cf_fido">Importo Fido:</label></div><div><input class="dx" id="cf_fido" type="text" size="15" name="cf_fido"/></div>
<div class="ana"><label for="cf_gg_scad">GG. scad. obbligato:</label></div><div><input class="dx" id="cf_gg_scad" type="text" size="15" name="cf_gg_scad"/></div>
<div class="ana"><label for="age">Mese scad. escluso:</label></div>
<div>
<select id="cf_mese_escluso" name="cf_mese_escluso" class="piccolo">
<option value="">&nbsp;</option>
<option value="1">Gennaio</option>
<option value="2">Febbraio</option>
<option value="3">Marzo</option>
<option value="4">Aprile</option>
<option value="5">Maggio</option>
<option value="6">Giugno</option>
<option value="7">Luglio</option>
<option value="8">Agosto</option>
<option value="9">Settembre</option>
<option value="10">Ottobre</option>
<option value="11">Novembre</option>
<option value="12">Dicembre</option>
</select>
</div>


<div class="ana"><label for="cf_add_imballo">Addebito spese imballo:</label></div>
<div><input type="checkbox" id="cf_add_imballo" name="cf_add_imballo" value="1"></div>
<div class="ana"><label for="cf_add_sp_inc">Addebito spese incasso:</label></div>
<div><input type="checkbox" id="cf_add_sp_inc" name="cf_add_sp_inc" value="1"></div>
<div class="ana"><label for="cf_no_ec">NO Estratto Conto:</label></div>
<div><input type="checkbox" id="cf_no_ec" name="cf_no_ec" value="1"></div>
<div class="ana"><label for="cf_fatt_separate">Fatture separate:</label></div>
<div><input type="checkbox" id="cf_fatt_separate" name="cf_fatt_separate" value="1"></div>
<div class="ana"><label for="cf_rb_unicacig">RB unica per CIG diversi:</label></div>
<div><input type="checkbox" id="cf_rb_unicacig" name="cf_rb_unicacig" value="1"></div>

<div class="ana"><label for="cf_note">Note:</label></div>
<div>
<textarea id="cf_note" name="cf_note" rows="2" cols="50">
</textarea>
</div>

</form>
</body>
</html>