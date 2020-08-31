<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="win_idro.js"></script>
<?php
session_start();
require 'include/database.php';
require 'include/idrobox.php';
//
$oggi=date("Y-m-d");
unset($marca);
$marca[]="    Seleziona la Marca";
$ql="SELECT * FROM tab_marche ORDER BY mar_codice";
$rsl=mysql_query($ql,$idr);
while($rol = mysql_fetch_assoc($rsl)) {
   $marca[]=$rol["mar_codice"] . " - " . $rol["mar_descrizione"];
   }
if(isset($_SESSION["idrolocal"]))
  echo "<label>Idrobox in locale</label><br>";
?>
<label class="idro" for="marchio">Marchio</label>
<select id="marchio" name="marchio" onchange="ricarica_settori();">
<?php
$j=0;
while(isset($marca[$j])) {
  $mare=trim(substr($marca[$j],0,3));
  echo "<option value=\"$mare\"";
  echo ">" . $marca[$j] . "</option>";
  $j++;
  }
?>
</select>

<?php
unset($settore);
unset($setcodice);
$settore[]="Seleziona il Settore";
$setcodice[]="";
$ql="SELECT * FROM tab_settori ORDER BY set_descrizione";
$rsl=mysql_query($ql,$idr);
while($rol = mysql_fetch_assoc($rsl)) {
   $settore[]=$rol["set_descrizione"];
   $setcodice[]=$rol["set_codice"];
   }
?>
<br>  
<label class="idro" for="settore">Settore</label>
<select id="settore" name="settore" onchange="ricarica_macrofamiglia();">
<?php
$j=0;
while(isset($settore[$j])) {
  echo "<option value=\"$setcodice[$j]\"";
  echo ">" . $settore[$j] . "</option>";
  $j++;
  }
?>
</select>
<br>
<label class="idro" for="macrofamiglia">Macrofamiglia</label>
<select id="macrofamiglia" name="macrofamiglia" onchange="ricarica_famiglia();">
<option value="">Seleziona la Macrofamiglia</option>
</select>
<br>
<label class="idro" for="famiglia">Famiglia</label>
<select id="famiglia" name="famiglia">
<option value="">Seleziona la Famiglia</option>
</select>
<br>
<label class="idro" for="cercain">Cerca In</label>
<select id="cercain" name="cercain">
<option value="d">Descrizione Articolo</option>
<option value="c">Codice Articolo</option>
</select>
<br>
<label class="idro" for="cerca">&nbsp;</label>
<input type="text" size="60" id="cerca" name="cerca" placeholder="inserisci dati di ricerca">
&nbsp;
<input type="button" id="ricerca" name="ricerca" value="Ricerca" onclick="esegui();">
<div class="div_elenco380" id="elencoart" name="elencoart"></div>
