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
<script type="text/javascript" src="lista_ordifo.js"></script>

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
$data_da=date('d/m/Y', strtotime('-6 months'));
$dal=addrizza("",$data_da);
$al=addrizza("",$data_a);
$fornitore="";
$ragsoc="";
if(isset($_POST["data_da"]))
  {
  $utente=$_POST["utente"];
  $fornitore=$_POST["fornitore"];
  $ragsoc=$_POST["ragsoc"];
  $data_da=$_POST["data_da"];
  $data_a=$_POST["data_a"];
  $evaso=$_POST["evaso"];
  $deposito=$_POST["deposito"];
  $dal=addrizza("",$data_da);
  $al=addrizza("",$data_a);
  }
?>
<body>
<div id="dialog" ></div>
<div id="stampa" title=""></div>
<div id="popup" title=""></div>
<div class="ordini">
<form action="lista_ordifo.php" method='POST' id='formperdata' name='formperdata'>

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
<label for="utente">Commesso</label>
<select id="utente" name="utente">
<?php
$j=0;
while(isset($codcom[$j])) {
  echo "<option value=\"$codcom[$j]\"";
  if($utente==$codcom[$j]) { echo " selected"; };
  echo ">" . $descom[$j] . "</option>";
  $j++;
  }
?>
</select>
<br>
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
  <label for="evaso">Stato Ordine:</label> 
  <select id="evaso" name="evaso" class="form-control">
      <option value="T" <?php if($evaso=="T") echo "selected";?>>Tutti</option>
      <option value="E" <?php if($evaso=="E") echo "selected";?>>Evasi</option>
      <option value="N"<?php if($evaso=="N") echo "selected";?>>Non Evasi</option>
  </select> 
<br>        
<label for="cliente">Fornitore</label>
<input id="fornitore" name="fornitore" type="text"size="9" maxlength="8" value="<?php echo $fornitore;?>" readonly>
<input name="ragsoc"  id="ragsoc" type="text" size="90" value="<?php echo $ragsoc;?>">
&nbsp;&nbsp;
<input type="button" id="listap" name="listap" value="LISTA" onclick="document.formperdata.submit();">
<input type="button" id="stampa" name="stampa" value="STAMPA">

</form>	
</div>
<div>
<?php
$q1="";
if($fornitore>"")
  {
  $q1="AND ORDI_FORNITORE='$fornitore'";
  }
$q2="";
if($utente>"")
  {
  $q2=" AND ORDI_UTENTE='$utente'";
  }  
if($evaso  == "E"){
  $q2 .= " AND ORDI_EVASO LIKE '$evaso' ";
} else {
  $q2 .= " AND (ORDI_EVASO IS NULL OR ORDI_EVASO = '') ";
} 
   
$qr="SELECT * FROM ordinifo LEFT JOIN clienti ON ORDI_FORNITORE=cf_cod WHERE ORDI_DEPOSITO='$deposito' AND ORDI_DATA_DOC BETWEEN '$dal' AND '$al' $q1 $q2 ORDER BY ORDI_DATA_DOC DESC, ORDI_NUM_DOC DESC LIMIT 500";
//echo $qr;   
$rst=mysql_query($qr,$con);
?>
<div class='tablewrap'><div class='tablewrap-inner'><table><thead><tr><th class='a'>Data</th><th class='b'>Numero</th><th class='c'>Ragione Sociale</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th></tr></thead><tbody>
<?php
while($row=mysql_fetch_assoc($rst)){
  extract($row);
  $totresto=0;
  $righej=$ORDI_RIGHE;
  $righe=json_decode($righej,true);
  for($j=0;$j<count($righe["qta"]);$j++)
     {
	 $resto=$righe["qta"][$j]-$righe["qta_sca"][$j];
	 $totresto+=$resto;
	 }
   
 
  if($evaso=="N" && ($totresto==0 || $ORDI_EVASO=="S")){
      $salta=1;	  	
	  }
    if($evaso=="E" && $totresto>0){
      $salta=2;
	  }
    if($evaso=="E" && $ORDI_EVASO=="S"){
      $salta=3;
	  }
	  
  if($salta==0){
    $classe="";	 
    if($totresto==0 || $ORDI_EVASO=="S"){
      $classe="style='background-color: #f7f493;'";
    }
  }
  $data=addrizza($row["ORDI_DATA_DOC"],"");
  echo "<tr $classe>";
  echo "<td class='a'>$data</td><td class='b'>$ORDI_NUM_DOC</td><td class='c'>$cf_ragsoc</td><td class='d'><td class='i'><img src='immagini/pencil.png' width='20px' title='MODIFICA ORDINE' onclick='chiama_ordifo($ORDI_ID);'></td><td class='i'><img src='immagini/printer.png' width='20px' title='Stampa' onclick='stampa_ordifo($ORDI_ID);'></td><td class='i'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='immagini/button_drop.png' width='15px' title='ELIMINA ORDINE FORNITORE' onclick='cancella_doc($ORDI_ID, $ORDI_NUM_DOC);'></td></tr>";
  }
?>
</tbody></table></div></div>
</div>
<div id="lancia"></div>
</body>
</html>