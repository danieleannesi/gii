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

<title>Stampa Merci in Transito</title>
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
<script type="text/javaScript" src="sta_transito.js"></script>

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
<label for="data_for">Alla Data</label>
<input id="alla_data" name="alla_data" type="text" style="width:10%;" maxlength="11" class="form-control form-control-sm" onChange="check_date(alla_data);" value="<?php echo $data?>">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'alla_data'
        });
        </script>
</div>
</div>

<div class="form-group">
<input name="confe" id="confe" type="button" class="btn btn-primary btn-lg btn-block" value="STAMPA" onClick="stampa()">
</div>

</div>

</form>
</body>
</html>