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

<title>Listino da Idrobox</title>
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
<script type="text/javaScript" src="lis101.js"></script>

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
//
?>
<div class="container-sm">

<form name='documenti' id='documenti'>

<div class="form-group">
<div class="row">
<label for="fornitore" style="width:20%;">Fornitore</label>
<input id="fornitore" name="fornitore" type="text" class="form-control form-control-sm" style="width:10%;" maxlength="8" readonly onchange="carica_fornitore(this);">
<input name="ragsoc" id="ragsoc" type="text" class="form-control form-control-sm" style="width:50%;">
</div>
</div>

<div class="form-group">
<div class="row">
<label for="da_artfo" style="width:20%;">Da Articolo Fornitore</label>
<input id="da_artfo" name="da_artfo" type="text" style="width:20%;" class="form-control form-control-sm">
</div>
</div>
<div class="form-group">
<div class="row">
<label for="a_artfo" style="width:20%;">A Articolo Fornitore</label>
<input id="a_artfo" name="a_artfo" type="text" value="zzzzzzzzzzzzzzzzzzzz" style="width:20%;" class="form-control form-control-sm">
</div>
</div>
<div class="form-group">
<div class="row">
<label for="da_artgi" style="width:20%;">Da Articolo GI</label>
<input id="da_artgi" name="da_artgi" type="text" value="0000000000" style="width:20%;" class="form-control form-control-sm">
</div>
</div>
<div class="form-group">
<div class="row">
<label for="a_artgi" style="width:20%;">A Articolo GI</label>
<input id="a_artgi" name="a_artfo" type="text" value="9999999999" style="width:20%;" class="form-control form-control-sm">
</div>
</div>


<div class="form-group">
<div class="row">
<label for="data_val_acq" style="width:20%;">Data Val.Acquisti</label>
<input id="data_val_acq" name="data_val_acq" type="text" style="width:20%;" maxlength="11" class="form-control form-control-sm" onChange="check_date(data_val_acq);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_val_acq'
        });
        </script>
</div>
</div>
<div class="form-group">
<div class="row">
<label for="data_val_ven" style="width:20%;">Data Val.Vendita</label>
<input id="data_val_ven" name="data_val_ven" type="text" style="width:20%;" maxlength="11" class="form-control form-control-sm" onChange="check_date(data_val_ven);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_val_ven'
        });
        </script>
</div>
</div>



<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="aggiorna" name="aggiorna">
    <label class="form-check-label" for="aggiorna"><b>Aggiornamento Dati</b></label>
</div>
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="descri" name="descri">
    <label class="form-check-label" for="descri">Aggiorna Descrizione</label>
</div>
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="prefisso" name="prefisso">
    <label class="form-check-label" for="prefisso">Prefisso su Descrizione</label>
</div>
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="soloforni" name="soloforni">
    <label class="form-check-label" for="soloforni">Solo Fornitore</label>
</div>
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="solocli" name="solocli">
    <label class="form-check-label" for="solocli">Solo Cliente</label>
</div>
<div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="evita" name="evita">
    <label class="form-check-label" for="evita">Evita Ribaltamento</label>
</div>



<div class="form-group">
<input name="confe" id="confe" type="button" class="btn btn-primary btn-lg btn-block" value="CONFERMA" onClick="stampa()">
</div>

</div>

</form>
</body>
</html>