<?php
session_start();
$deposito=$_SESSION["deposito"];
$ute=$_SESSION["ute"];
$utente=$ute;
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
<link rel="STYLESHEET" href="style.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css">    

<title>Gestione Movimenti di Magazzino</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body class="bg-light">
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="include/jquery-3.5.0.slim.min.js"></script>
    <script src="include/popper.min.js"></script>
    <script src="include/bootstrap/js/bootstrap.min.js"></script>
    
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javaScript" src="calendar/calendar_eu.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javaScript" src="ges_magaz.js"></script>

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
  $fornitore="";
  $ragsoc="";
  $totalefat="";
  $iva1="";
  $impo1="";
  $ali1="22";
  $iva2="";
  $impo2="";
  $ali2="65";
  $note="";
  $age="";
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
require 'leggi_codici.php';
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
?>
<div class="container-sm">

<form name='documenti' id='documenti'>
<div class="form-group">
<div class="row" style="margin-top: 3px;">
<label for="deposito">Deposito</label>
<select id="deposito" name="deposito" style="width:60%;" class="form-control form-control-sm">
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
</div>
</div>

<input id="idt" name="idt" type="hidden" value="<?php echo $idt?>" >
<input id="clifor" name="clifor" type="hidden" value="F" >

<div class="form-group">
<div class="row">
<label for="data_doc">Data</label>
<input id="data_doc" name="data_doc" type="text" style="width:20%;" maxlength="11" class="form-control form-control-sm" value="<?php echo $data?>" onChange="check_date(data_doc);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_doc'
        });
        </script>
<label for="causale">Causale</label>
<select id="causale" name="causale" style="width:35%;" class="form-control form-control-sm" onchange="leggi_causale(this);">
<?php
$j=0;
while(isset($codcaus[$j])) {
  echo "<option value=\"$codcaus[$j]\"";
  //if($causale==$codcaus[$j]) { echo " selected"; };
  echo ">" . $descaus[$j] . "</option>";
  $j++;
  }
?>
</select>
<label for="numero">N.Documento</label>&nbsp;<input id="numero" name="numero" type="text" style="width:20%;" class="form-control form-control-sm" maxlength="20">
</div>
</div>

<div class="form-group">
<div class="row">
<label for="fornitore" id="tipocli">Fornitore</label>
<input id="fornitore" name="fornitore" type="text" class="form-control form-control-sm" style="width:10%;" maxlength="8" value="<?php echo $fornitore?>" readonly onchange="carica_fornitore(this.value);">
<input name="ragsoc" id="ragsoc" type="text" class="form-control form-control-sm" style="width:70%;" value="<?php echo $ragsoc?>">
</div>
</div>

<div class="form-group">
<div class="row">
<input type="text" id="codart" name="codart" class="form-control form-control-sm" style="width:10%;" placeholder="codice articolo" onchange="carica_articolo(this.value);">
<textarea id="desart" name="desart" class="form-control form-control-sm" style="width:80%;" placeholder="descrizione articolo" rows="1" cols="80">
</textarea>
<input name="OK" type="button" class="btn btn-primary btn-sm" value="Salva Riga" onClick="salvariga();">
</div>
</div>

<div class="form-group">
<div class="row">
<label for="quantita">Quantita</label>
<input id="indice" name="indice" type="hidden">
<input id="tipo_doc" name="tipo_doc" type="hidden" value="">
<input id="doc" name="doc" type="hidden" value="">
<input id="id_rife" name="id_rife" type="hidden" value="">
<input id="quantita" name="quantita" class="piccolo" type="number" step=".01" onfocus="$('#lista_vie').hide();" onBlur="calcolar();">
<label for="prezzo">Unit.</label>
<input id="prezzo" name="prezzo" class="piccolo" type="number" step=".0001" onBlur="calcolar()">
<label for="sconto">Sconto</label>
<input id="sconto" name="sconto" class="piccolo" type="number" step=".01" onBlur="calcolar()">
<label for="quantita">Totale</label>
<input id="totale" name="totale" class="piccolo" type="number" step=".01" readonly="true" tabindex="-1">
</div>
</div>

<div id="righedoc" class="righedoc">
<!-- RIGHE DOCUMENTO -->
</div>

<div class="form-group">
<div class="row">
<label for="totale_doc">Totale Documento</label>
<input class="destra" type="text" id="totale_doc" name="totale_doc" size="10" readonly>
</div>
</div>

<div class="form-group">
<input name="confe" id="confe" type="button" class="btn btn-primary btn-lg btn-block" value="CONFERMA" onClick="confer()">
</div>

</div>

</form>
</div>
</body>
</html>