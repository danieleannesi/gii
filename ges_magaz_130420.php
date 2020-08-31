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
<body class="prev">
    
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
<div class="container-md">

<form action=<?php echo "$SELF"?> method='post' name='documenti' id='documenti'>
<div id="testa" class="testa">

<table class="testata">
<tr>
<td>
<label for="deposito">Deposito</label>
<select id="deposito" name="deposito" class="form-control">
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
<input id="clifor" name="clifor" type="hidden" value="F" >
<label for="data_doc">Data</label>
<input id="data_doc" name="data_doc" type="text" size="11" maxlength="11" class="form-control" value="<?php echo $data?>" onChange="check_date(data_doc);">
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
<label for="paga">Causale</label>
<select id="causale" name="causale" class="form-control" onchange="leggi_causale(this);">
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
</td>
<td>
<label for="numero">Numero Documento</label>&nbsp;<input id="numero" name="numero" type="text" class="form-control" size="21" maxlength="20">
</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
<label for="fornitore" id="tipocli">Fornitore</label>
<input id="fornitore" name="fornitore" type="text" class="form-control" size="9" maxlength="8" value="<?php echo $fornitore?>" readonly onchange="carica_fornitore(this);">
</td>
<td>
<input name="ragsoc" id="ragsoc" type="text" class="form-control" size="90" value="<?php echo $ragsoc?>">
</td>
</tr>
</table>
</div>

<div id="sopra" class="sopra">
<div id="rigamag" class="rigamag"> 
<table width="916">
<tr>
<td>
<input type="text" id="codart" name="codart" class="form-control" size="10" placeholder="codice articolo" onchange="carica_articolo(this);">
</td>
<td>
<textarea id="desart" name="desart" class="form-control" placeholder="descrizione articolo" rows="1" cols="80">
</textarea>
</td>
<td><input name="OK" type="button" class="btn btn-primary btn-lg btn-block" value="Salva Riga" onClick="salvariga();"></td>
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
</tr>
</table>
</div>
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
<label for="totale_doc">Totale Documento</label>
<input class="destra" type="text" id="totale_doc" name="totale_doc" size="10" readonly>
</div>
<div id="tappo" class="tappo">
</div>
<table>
<tr>
<td width="109"><input name="confe" id="confe" type="button" class="btn btn-primary btn-lg btn-block" value="CONFERMA" onClick="confer()"></td>
</tr>
</table>
</form>
</div>
</body>
</html>