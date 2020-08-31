<!DOCTYPE html>
<html>
<head>
<title>Galli Innocenti</title>
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="style_listaper.css" type="text/css">
<link rel="stylesheet" href="calendar/calendar.css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />
<link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css" type="text/css" />
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="include/jquery-dateFormat.min.js"></script>
<script type="text/javascript" src="calendar/calendar_eu.js"></script>
<script type="text/javascript" src="lib2.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javascript" src="lista_prev.js"></script>

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
$cliente="";
$ragsoc="";
$agente=$_SESSION["ute"];
if(isset($_POST["data_da"]))
  {
  $utente=$_POST["utente"];
  $cliente=$_POST["cliente"];
  $ragsoc=$_POST["ragsoc"];
  $agente=$_POST["agente"];
  $data_da=$_POST["data_da"];
  $data_a=$_POST["data_a"];
  $deposito=$_POST["deposito"];
  $dal=addrizza("",$data_da);
  $al=addrizza("",$data_a);
  }
?>
<body>
<div id="dialog" ></div>
<div id="stampa" title=""></div>
<div id="popup" title=""></div>
<div class="intestazione">
<form action="lista_prev.php" method='POST' id='formperdata' name='formperdata'>
<div class="container">
    <div class="row">
      <div class="col-12">   
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
      </div>
    </div>
    <div class="row"> 
        <div class="col-6">  
          <label for="agente">Agente</label>
          <select id="agente" name="agente">
          <?php
          $h=0;
          while(isset($codage[$h])) {
            echo "<option value=\"$codage[$h]\"";
            if($agente==$codage[$h]) { echo " selected"; };
            echo ">" . $desage[$h] . "</option>";
            $h++;
            }
          ?>
          </select>
        </div>
        <div class="col-6"> 
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
        </div>
    </div>
    <div class="row">
        <div class="col-8">   
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

          </div>
          <div class="col-4">   
            <label for="n_preventivo">N. preventivo</label>
              <input type="text" name="n_preventivo" value="" size="6"/>
          </div>
    </div>
    <div class="row">
        <div class="col-12">     
          <label for="cliente">Cliente</label>
          <input id="cliente" name="cliente" type="text" size="9" maxlength="8" value="<?php echo $cliente?>" readonly  onchange="carica_cliente(this);">
          <input name="ragsoc"  id="ragsoc" type="text" size="70" value="<?php echo $ragsoc?>" style="text-transform:uppercase" >
          <input type="button" id="listap" name="listap" value="LISTA" onclick="document.formperdata.submit();">
        </div>
    </div>
</div>
</form>	
</div>
<div>
<?php
$q1="";
if($cliente>""){
  $q1="AND PREV_CLIENTE='$cliente'";
  }
$q2="";
if($utente>""){
   $q2 .=" AND PREV_COMMESSO_PREV='$utente'";
}  
if($agente>""){
  $q2 .=" AND PREV_AGENTE='$agente'";
} 
$n_prev = $_POST["n_preventivo"];
if($n_prev>""){
  $q2 .=" AND PREV_NUM_DOC LIKE '%$n_prev'";
}
$qr="SELECT * FROM preventivi LEFT JOIN clienti ON PREV_CLIENTE=cf_cod WHERE PREV_DEPOSITO='$deposito' AND PREV_DATA_DOC BETWEEN '$dal' AND '$al' $q1 $q2 ORDER BY PREV_DATA_DOC DESC, PREV_NUM_DOC DESC LIMIT 500";
//echo $qr;   
$rst=mysql_query($qr,$con);
?>
<div class='tablewrap'><div class='tablewrap-inner'><table><thead><tr><th class='a'>Data</th><th class='b'>Numero</th><th class='c'>Ragione Sociale</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th><th class='i'>&nbsp;</th></tr></thead><tbody>
<?php
while($row=mysql_fetch_assoc($rst)){
  extract($row);
  $salta=0;
/*
  if($protocollo>"")
     {
	 if($acc_protocollo!=$protocollo)
	   {
	   	$salta=1;
	   }
	 }
*/
if($salta==0)
 {
  $data=addrizza($row["PREV_DATA_DOC"],"");
  echo "<tr>";
  echo "<td class='a'>$data</td><td class='b'>$PREV_NUM_DOC</td><td class='c'>$cf_ragsoc</td><td class='d'><td class='i'><img src='immagini/pencil.png' width='20px' title='Note' onclick='chiama_prev($PREV_ID);'></td><td class='i'><img src='immagini/printer.png' width='20px' title='Stampa' onclick='stampa_prev($PREV_ID);'></td><td class='i'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='immagini/button_drop.png' width='15px' title='ELIMINA PREVENTIVO' onclick='cancella_doc($PREV_ID, $PREV_NUM_DOC);'></td></tr>";
 }	 
  }
?>
</tbody></table></div></div>
</div>
<div id="lancia"></div>
</body>
</html>