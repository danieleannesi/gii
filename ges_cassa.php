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
<script type="text/javaScript" src="ges_cassa.js"></script>

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
$orario=date("H:i");
  $data_doc="";
  $nume_doc="";
  $paga="";
  $tipo_cli_e=" selected ";
  $tipo_cli_p="";
  $cliente="";
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
?>
<form name='documenti' id='documenti'>
<div id="testa" class="testa">
<table class="testata">
<tr>
<td>
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
</td>
<td>
<label for="nume_prev">Num.Preventivo</label><input id="nume_prev" name="nume_prev" type="text" size="8">
<input type="button" value="Carica" onclick="carica_prev();">
</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
<input id="idt" name="idt" type="hidden" value="<?php echo $idt?>" >
<label for="data_doc">Data</label>
<input id="data_doc" name="data_doc" type="text" size="11" maxlength="11" value="<?php echo $data?>" onChange="check_date(data_doc);">
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
<label for="nume_doc">Numero</label>
<input id="nume_doc" name="nume_doc" type="text" size="8" value="<?php echo $nume_doc?>" readonly="true" tabindex="-1">
</td>
<td>
<label for="nume_man">Numero Manuale</label><input id="nume_man" name="nume_man" type="text" size="8">
</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
<label for="cliente">Cliente</label>
<input id="cliente" name="cliente" type="text"size="9" maxlength="8" value="<?php echo $cliente?>" readonly onchange="carica_cliente(this);">
</td>
<td>
<input name="ragsoc"  id="ragsoc" type="text" size="90" value="<?php echo $ragsoc?>">
<input type="button" id="preventivi" name="preventivi" value="Preventivi" onclick="vedi_preventivi();" style="display: none;">
</td>
</tr>
</table>
<table class="testata">
<tr>
<td>
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
</td>
<td>
<label for="paga">Pagamento</label>
<select id="paga" name="paga">
<?php
$j=0;
while(isset($codpaga[$j])) {
  echo "<option value=\"$codpaga[$j]\"";
  if($paga==$codpaga[$j]) { echo " selected"; };
  echo ">" . $despaga[$j] . "</option>";
  $j++;
  }
?>
</select>
</td>
</tr>
</table>
</div>

<div id="sotto_fa" class="sotto_fa">
<input type="button" id="torna" name="torna" value="Fattura Accompagnatoria" onclick="altri_dati_torna();"><br>

<label for="des_rag_soc" class="dx10">Destinazione</label>
<input type="text" id="des_rag_soc" name="des_rag_soc" size="50"><br>
<label for="des_indirizzo" class="dx10">Indirizzo</label>
<input type="text" id="des_indirizzo" name="des_indirizzo" size="50"><br>
<label for="des_indirizzo" class="dx10">CAP/Localita/Prov</label>
<input type="text" id="des_cap" name="des_cap" size="5">
<input type="text" id="des_localita" name="des_localita" size="35">
<input type="text" id="des_prov" name="des_prov" size="3"><br>
<label for="cig" class="dx10">CIG/CUP</label>
<input type="text" id="cig" name="cig" size="10">
<input type="text" id="cup" name="cup" size="15"><br>

<label for="consegna" class="dx10">Consegna</label>
<select id="consegna" name="consegna">
<option value="M">Mittente</option>
<option value="D">Destinatario</option>
<option value="V">Vettore</option>
</select>
<br>
<label for="vettore" class="dx10">Vettore</label>
<input type="text" id="vettore" name="vettore" size="35">
<label for="indvettore" class="dx10">Ind.Vettore</label>
<input type="text" id="indvettore" name="indvettore" size="35">
<br>
<label for="scontocassa" class="dx10">% Sconto Cassa</label>
<input id="scontocassa" name="scontocassa" type="number" step=".01">
<input id="importoscontocassa" name="importoscontocassa" type="hidden">
<br>
<label for="causale" class="dx10">Causale</label>
<select id="causale" name="causale">
<?php
$j=0;
while(isset($codcaus[$j])) {
  echo "<option value=\"$codcaus[$j]\"";
  if($codcaus[$j]=="50") { echo " selected"; };
  echo ">" . $descaus[$j] . "</option>";
  $j++;
  }
?>
</select>
&nbsp;&nbsp;
<label for="porto" class="dx10">Porto</label>
<select id="porto" name="porto">
<option value="F">Franco</option>
<option value="A">Assegnato</option>
</select>
<br>
<label for="aspetto" class="dx10">Aspetto</label>
<input id="aspetto" name="aspetto" type="text" size="35">
<label for="colli" class="dx10">Colli</label>
<input id="colli" name="colli" type="number" step="1">
<label for="peso" class="dx10">Peso</label>
<input id="peso" name="peso" type="number" step=".01">
<br>
<label for="data_ritiro" class="dx10">Data Ritiro</label>
<input id="data_ritiro" name="data_ritiro" type="text" size="11" maxlength="11" onChange="check_date(data_ritiro);" value="<?php echo $data?>">
          <script  type="text/javascript">
        new tcal ({
                // form name
                'formname': 'documenti',
                // input name
                'controlname': 'data_ritiro'
        });
        </script>
<label for="ora_ritiro" class="dx10">Ora</label>
<input id="ora_ritiro" name="ora_ritiro" type="text" size="5" value="<?php echo $orario?>">
<br>

<label for="acconto" class="dx10">Acconto</label>
<input id="acconto" name="acconto" type="number" step=".01">
<label for="caparra" class="dx10">Caparra</label>
<input id="caparra" name="caparra" type="number" step=".01">
<label for="trasporto" class="dx10">Trasporto</label>
<input id="trasporto" name="trasporto" type="number" step=".01"><br>

<label for="installazione" class="dx10">Installazione</label>
<input id="installazione" name="installazione" type="number" step=".01">
<label for="jolly" class="dx10">Jolly</label>
<input id="jolly" name="jolly" type="number" step=".01">
<label for="noleggio" class="dx10">Noleggio</label>
<input id="noleggio" name="noleggio" type="number" step=".01">
<label for="totaledoc" class="dx10">Totale</label>
<input id="totaledoc" name="totaledoc" type="number" readonly><br>

<label for="collaudo" class="dx10">Collaudo</label>
<input id="collaudo" name="collaudo" type="number" step=".01">
<label for="europallet" class="dx10">Europallet</label>
<input id="europallet" name="europallet" type="number" step=".01">
<label for="addvari" class="dx10">Addebiti Vari</label>
<input id="addvari" name="addvari" type="number" step=".01">
<label for="incassato" class="dx10">Incassato</label>
<input id="incassato" name="incassato" type="number" step=".01"><br>

<label for="notes" class="dx10">Riferimenti e Note</label>
<textarea id="notes" name="notes" rows="1" cols="50">
</textarea>
&nbsp;&nbsp;&nbsp;
<a href="#" class="conferma" id="idconferma" onclick="confer();">CONFERMA</a>
<a href="#" class="conferma" id="idstampa" style="display: none;" onclick="stampa();">STAMPA</a>
</div>

<div id="sotto_sco" class="sotto_sco">
<input type="button" id="tornasco" name="tornasco" value="Torna: Scontrino" onclick="altri_dati_torna();"><br>

<label for="numsco" class="dx10">Scontrino Numero</label>
<input id="numsco" name="numsco" type="number" step="1">
&nbsp;&nbsp;&nbsp;
<a href="#" class="conferma" onclick="confer();">CONFERMA</a>
</div>

<div id="sopra" class="sopra">
<div id="riga" class="riga"> 
<table width="916">
<tr>
<td>
<input type="button" id="idro" value="idro" onclick="win_idro();">
<input type="text" id="codart" name="codart" size="10" placeholder="codice articolo" onchange="carica_articolo(this);">
</td>
<td>
<textarea id="desart" name="desart" placeholder="descrizione articolo" rows="1" cols="80">
</textarea>
<input type="hidden" id="raee" name="raee">
<input type="hidden" id="ordine" name="ordine">
<input type="hidden" id="tipo_documento" name="tipo_documento">
<input type="hidden" id="agente" name="agente">
</td>
<td><input class="acapo" name="OK" type="button" value="Salva Riga" onClick="salvariga();"></td>
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
<td width="59" align="right" class="labelit">Cod.Iva</td>
<td>
<select id="ali0" name="ali0" class="piccolo">
<?php
$j=0;
while(isset($codiva[$j])) {
  $civa=$codiva[$j];
  echo "<option value=\"$civa\"";
  echo ">" . $desiva[$j] . "</option>";
  $j++;
  }
?>
</select>
</td>
</tr>
</table>
<div id="giacenze"></div>
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
<label for="totale_fattura">Totale Documento</label>
<input class="destra" type="text" id="totale_fattura" name="totale_fattura" size="10" readonly>
</div>
<div id="tappo" class="tappo">
</div>
<table>
<tr>
<td width="109"><input name="scontrino" id="scontrino" type="button" style="width:100px;" value="SCONTRINO" onClick="altri_dati(3);"></td>
<td width="109"><input name="ddt" id="ddt" type="button" style="width:100px;" value="D.D.T." onClick="altri_dati(1);"></td>
<td width="109"><input name="fa" id="fa" type="button" style="width:100px;" value="Fatt.Acc." onClick="altri_dati(2);"></td>
</tr>
</table>
</form>
</body>
</html>