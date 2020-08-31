<!DOCTYPE html>
<html>
<head>
<title>Galli Innocenti</title>
<link rel="stylesheet" href="Style.css" type="text/css">
<link rel="stylesheet" href="style_listapn.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />

<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="include/jquery-dateFormat.min.js"></script>
<script type="text/javascript" src="calendar/calendar_eu.js"></script>
<script type="text/javascript" src="lib2.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javascript" src="lista_pnmagaz.js"></script>

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
//
require 'include/database.php';
require 'include/java.php';
require 'include/functionsJS.js';
require_once 'leggi_codici.php';
//
$oggi=date("d/m/Y");
$data_a=$oggi;
$data_da=date('d/m/Y', strtotime('-1 months'));
$dal=addrizza("",$data_da);
$al=addrizza("",$data_a);
$codart="";
$desart="";
$causale="";
if(isset($_POST["data_da"]))
  {
  $utente=$_POST["utente"];
  $deposito=$_POST["deposito"];
  $data_da=$_POST["data_da"];
  $data_a=$_POST["data_a"];
  $codart=$_POST["codart"];
  $desart=$_POST["desart"];
  $causale=$_POST["causale"];
  $dal=addrizza("",$data_da);
  $al=addrizza("",$data_a);
  }
?>
<body>
<div id="dialog" ></div>
<div id="stampa" title=""></div>
<div id="popup" title=""></div>
<div>
<form action="lista_pnmagaz.php" method='POST' id='formperdata' name='formperdata'>

<label for="deposito">Deposito</label>
<select id="deposito" name="deposito">
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
&nbsp;&nbsp;
<label for="data_da">Dalla Data:</label>
<input id="data_da" type="text" size="11" maxlength="11" onChange="check_date(data_da);" name="data_da" value="<?php echo $data_da?>"/>
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'formperdata',
                // input name
                'controlname': 'data_da'
        });
        </script>
&nbsp;&nbsp;
<label for="data_a">Alla Data:</label>
<input id="data_a" type="text" size="11" maxlength="11" onChange="check_date(data_a);" name="data_a" value="<?php echo $data_a?>"/>
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'formperdata',
                // input name
                'controlname': 'data_a'
        });
        </script>
&nbsp;&nbsp;
<input type="button" id="listap" name="listap" value="LISTA" onclick="document.formperdata.submit();">

<br>
<input type="text" id="codart" name="codart" style="width:10%;" placeholder="codice articolo" value="<?php echo $codart;?>">
<textarea id="desart" name="desart" style="width:40%;" placeholder="descrizione articolo" rows="1" cols="50">
<?php echo $desart;?>
</textarea>
&nbsp;&nbsp;
<label for="causale">Causale</label>
<select id="causale" name="causale">
<?php
$j=0;
while(isset($codcaus[$j])) {
  echo "<option value=\"$codcaus[$j]\"";
  if($causale==$codcaus[$j]) { echo " selected"; };
  echo ">" . $descaus[$j] . "</option>";
  $j++;
  }
?>  
</select>

</form>
</div>
<div>
<?php
$qq="";
if($codart>"")
  {
  $qq="AND mov_codart='$codart'";
  }
if($causale>"")
  {
  $qq.=" AND mov_causale='$causale'";
  }  
$qr="SELECT * FROM movmag LEFT JOIN clienti ON mov_clifor=cf_cod LEFT JOIN articoli ON mov_codart=art_codice WHERE mov_dep='$deposito' AND mov_data BETWEEN '$dal' AND '$al' $qq ORDER BY mov_data DESC,mov_id DESC LIMIT 200";
//echo $qr;
$rst=mysql_query($qr,$con);
?>
<div class='tablewrap'><div class='tablewrap-inner'><table><tr class='r'><thead><th>Dep</th><th>Data</th><th>Articolo</th><th>Descrizione</th><th>Cau</th><th>Cli/For</th><th>Qua</th><th>Unitario</th><th>Totale</th><th>&nbsp;</th><th>&nbsp;</th></tr></thead><tbody>
<?php
while($row=mysql_fetch_assoc($rst)){
  extract($row);
  $data=addrizza($row["mov_data"],"");
  echo "<tr class='r'>";
  echo "<td>$mov_dep</td><td>$data</td><td>$mov_codart</td><td>$art_descrizione</td><td>$mov_causale</td><td>$cf_ragsoc</td><td class='r'>$mov_qua</td><td class='r'>$mov_prezzo</td><td class='r'>$mov_totale</td><td><img src='immagini/pencil.png' width='20px' title='Prima Nota Magazzino' onclick='chiama_pnmagaz($mov_id)'></td><td class='i'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='immagini/button_drop.png' width='15px' title='ELIMINA MOVIMENTO DI MAGAZZINO' onclick='cancella_doc($mov_id);'></td></tr>";
  }
?>
</tbody></table></div></div>
</div>
</body>
</html>