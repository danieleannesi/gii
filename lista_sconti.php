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
<script type="text/javascript" src="lista_sconti.js"></script>

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
$classe="21";
$cliente="";
//
require 'include/database.php';
require 'include/java.php';
require 'include/functionsJS.js';
require_once 'leggi_codici.php';
//
if(isset($_POST["classe"]))
  {
  $classe=$_POST["classe"];
  $cliente=$_POST["cliente"];
  $ragsoc=$_POST["ragsoc"];
  }
?>
<body>
<div id="dialog" ></div>
<div id="stampa" title=""></div>
<div id="popup" title=""></div>
<div>
<form action="lista_sconti.php" method='POST' id='formperdata' name='formperdata'>
<label for="cliente">Cliente</label>
<input id="cliente" name="cliente" type="text"size="9" maxlength="8" value="<?php echo $cliente?>">
<input name="ragsoc"  id="ragsoc" type="text" size="90" value="<?php echo $ragsoc?>">
&nbsp;&nbsp;
<label for="classe">Classe</label>
<select id="classe" name="classe">
<?php
$j=0;
while(isset($codclasse[$j])) {
  echo "<option value=\"$codclasse[$j]\"";
  if($classe==$codclasse[$j]) { echo " selected"; };
  echo ">" . $desclasse[$j] . "</option>";
  $j++;
  }
?>
</select>
&nbsp;&nbsp;
<input type="button" id="listap" name="listap" value="LISTA" onclick="document.formperdata.submit();">

</form>	
</div>
<div id="rigasconti" class="rigasconti"> 
<table width="916">
<tr>
<td width="65" align="right" class="labelit">Classe</td>
<td>
<select id="rclasse" name="rclasse">
<?php
$j=0;
while(isset($codclasse[$j])) {
  echo "<option value=\"$codclasse[$j]\"";
  echo ">" . $desclasse[$j] . "</option>";
  $j++;
  }
?>
</select>	
</td>
<td width="65" align="right" class="labelit">Da Codice</td>
<td><input id="dacodice" name="dacodice" class="piccolo" size="10"></td>
<td width="59" align="right" class="labelit">A Codice</td>
<td><input id="acodice" name="acodice" class="piccolo" size="10"></td>
<td width="59" align="right" class="labelit">Unitario</td>
<td><input id="unitario" name="unitario" class="piccolo" size="6"></td>
</tr>
<table>
<tr>
<td width="59" align="right" class="labelit">Sconto 1</td>
<td><input id="sconto1" name="sconto1" class="piccolo" size="6"></td>
<td width="59" align="right" class="labelit">Sconto 2</td>
<td><input id="sconto2" name="sconto2" class="piccolo" size="6"></td>
<td width="59" align="right" class="labelit">Sconto 3</td>
<td><input id="sconto3" name="sconto3" class="piccolo" size="6"></td>
<td width="59" align="right" class="labelit">Sconto 4</td>
<td><input id="sconto4" name="sconto4" class="piccolo" size="6"></td>
<td width="59" align="right" class="labelit">Sconto 5</td>
<td><input id="sconto5" name="sconto5" class="piccolo" size="6"></td>
<td width="59" align="right" class="labelit">Sconto 5</td>
<td><input id="sconto6" name="sconto6" class="piccolo" size="6"></td>
<td>&nbsp;&nbsp;&nbsp;<input type="button" value="SALVA" onclick="salva();"></td>
<td class='i'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='immagini/delete-icon.png' width='20px' title='Elimina' onclick='elimina();'></td>
</tr>
</table>
</div>

<div class="righesconti">
<table>
<thead><tr><th class='a'>Cliente</th><th class='b'>Classe</th><th class='c'>Da Articolo</th><th class='c'>A Articolo</th><th class='c'>Unitario</th><th class='c'>Sconto1</th><th class='c'>Sconto2</th><th class='c'>Sconto3</th><th class='c'>Sconto4</th><th class='c'>Sconto5</th><th class='c'>Sconto6</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th></tr></thead>
<tbody>
<?php
$q1="WHERE CodCli='00000000'";
$q2="";  
if($classe>"")
  {
  $q2="AND classe='$classe'";
  }
if($cliente>"")
  {
  $q1="WHERE CodCli='$cliente'";
  $q2="";
  }
$qr="SELECT * FROM sconti $q1 $q2 ORDER BY classe, CodArtDa, CodArtA";
//echo $qr;   
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
  extract($row);
  echo "<tr>";
  echo "<td class='a'>$CodCli</td><td class='b'>$classe</td><td class='c'>$CodArtDa</td><td class='c'>$CodArtA</td><td class='c'>$PrezzoUni</td><td class='c'>$Sconto1</td><td class='c'>$Sconto2</td><td class='c'>$Sconto3</td><td class='c'>$Sconto4</td><td class='c'>$Sconto5</td><td class='c'>$Sconto6</td><td class='i'><img src='immagini/pencil.png' width='20px' title='Modifica' onclick='modifica(\"$classe\",\"$CodArtDa\",\"$CodArtA\",$PrezzoUni,$Sconto1,$Sconto2,$Sconto3,$Sconto4,$Sconto5,$Sconto6);'></td></tr>";
  }
?>
</tbody></table>
</div>
<div id="lancia"></div>
</body>
</html>