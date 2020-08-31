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
<title>Gestione Cassa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body class="prev">
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javaScript" src="calendar/calendar_eu.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javaScript" src="fatturazione.js"></script>

<div id="oscura" class="popup_cont" >
	<div id="attendere" >
			<img src="immagini/loading.gif" />
			<br />
			Loading...
			<div id="loading_message" ></div>
	</div>
</div>
<div id="dialog" title=""></div>
<?php
require 'include/functionsJS.js';
require 'include/java.php';
require 'include/database.php';
//
$data=date("d/m/Y");
//
require 'leggi_codici.php';
//
?>
<form name='documenti' id='documenti'>
<label for="data_doc">Alla Data</label>
<input id="data_doc" name="data_doc" type="text" size="11" maxlength="11" value="<?php echo $data?>" onChange="check_date(data_doc);">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_doc'
        });
        </script>
<input name="fattura" id="fattura" type="button" style="width:100px;" value="EMETTI FATTURE" onClick="emetti_fatture();">
</form>
</body>
</html>