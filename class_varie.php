<?php
//
//classe scrivi_log
  class scrivi_log {
//
    function scrivi_log($utente, $messaggio) {
       require 'include/database.php';
       $data=date("Y-m-d H-i-s");
       $sql="INSERT INTO log SET data='$data', utente='$utente', messaggio='$messaggio'";
       $rst = mysql_query($sql, $con);
       if (!$rst) {
	      echo mysql_error();
	      mysql_close($con);
	      exit;
		  }
     }
//fine function scrivi_log
  }
//fine class scrivi_log
//
//
//classe e_mail
  class e_mail {
//
    function e_mail($utente, $oggetto, $messaggio) {
    $res=mail("rudy.tosoni@gmail.com", "$oggetto (Utente: $utente)", $messaggio,"From: fatturazione@vitaldent.net");
      }
//fine function e_mail
  }
//fine classe e_mail
//
//classe e_mail
  class e_mailp {
//
    function e_mailp($utente, $oggetto, $messaggio,$allegato) {
//manda email//////////////////////////////////
// Valorizzo le variabili relative all'allegato
$mittente=".....";
$destinatario=".....";
//$oggetto="";
//$messaggio="";
//$allegato = "/tmp/$numid.pdf";
$allegato_type = "pdf";
$allegato_name = $allegato;
// Creo 2 variabili che riempirò più avanti...
$headers = "From: " . $mittente;
$msg = "";
// Apro e leggo il file allegato
$file = fopen($allegato,'rb');
$data = fread($file, filesize($allegato));
fclose($file);
// Adatto il file al formato MIME base64 usando base64_encode
$data = chunk_split(base64_encode($data));
// Genero il "separatore"
// Serve per dividere, appunto, le varie parti del messaggio.
// Nel nostro caso separerà la parte testuale dall'allegato
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
// Aggiungo le intestazioni necessarie per l'allegato
$headers .= "\nMIME-Version: 1.0\n";
$headers .= "Content-Type: multipart/mixed;\n";
$headers .= " boundary=\"{$mime_boundary}\"";
  // Definisco il tipo di messaggio (MIME/multi-part)
$msg .= "This is a multi-part message in MIME format.\n\n";
// Metto il separatore
$msg .= "--{$mime_boundary}\n";
// Questa è la parte "testuale" del messaggio
$msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
$msg .= "Content-Transfer-Encoding: 7bit\n\n";
$msg .= $messaggio . "\n\n";
// Metto il separatore
$msg .= "--{$mime_boundary}\n";
// Aggiungo l'allegato al messaggio
$msg .= "Content-Disposition: attachment;\n";
$msg .= " filename=\"{$allegato_name}\"\n";
$msg .= "Content-Transfer-Encoding: base64\n\n";
$msg .= $data . "\n\n";
// chiudo con il separatore
$msg .= "--{$mime_boundary}--\n";
// Invio la mail
mail($destinatario, $oggetto, $msg, $headers);
//$res=mail("d.annesi@deltalink.it", "$oggetto (Utente: $utente)", $messaggio,"From: fatturazione@vitaldent.net");
      }
//fine function e_mailp
  }
//fine classe e_mailp
//
//classe codice_fiscale
  class codice_fiscale {
//
  var $txt_Nome = "";
  var $txt_Cognome = "";
  var $txt_Data = "";
  var $txt_Sesso = "";
  var $txt_Citta_Nascita = "";
  var $strCodFisc = "";
  var $errore = "0";
//
    function codice_fiscale() 
	  {
      }
//	  
    function calcola_codice_fiscale() 
	  {
    require 'include/database.php';
	$citta=addslashes($this->txt_Citta_Nascita);
	$strCodFisc="";
	$qr="SELECT * FROM a_city WHERE CY_CNAME='$citta'";
    $rst = mysql_query($qr, $con);
    if($row = mysql_fetch_array($rst)) { 
	   $codice=$row["CY_ISTAT"];
       $strCodFisc = $this->ExtractBegin(urldecode($this->txt_Cognome), true);
       $strCodFisc = $strCodFisc . $this->ExtractBegin(urldecode($this->txt_Nome), false);
	   if ($this->txt_Sesso == "M")
		  $strCodFisc = $strCodFisc . $this->ExtractDate($this->txt_Data, true);
	   else
		  $strCodFisc = $strCodFisc . $this->ExtractDate($this->txt_Data, false);
       $strCodFisc = $strCodFisc . $codice;
       $this->strCodFisc = $strCodFisc . $this->CodFiscControl($strCodFisc);
	   }
	 else {
	    $this->strCodFisc="";
		$this->errore="COMUNE NON TROVATO";
	   }
//
     }
//	 
function ExtractBegin($strVal, $bCog)
{
	$retValue = "";
	$strVoc="AaEeIiOoUu";

	$numCon = 0;
	$numVoc = 0;

	for ($i = 0; $i < strlen($strVal); $i++)
	{
		$tmp = substr($strVal, $i, 1);
		if (strpos($strVoc, $tmp)===false && $tmp != " ")
		{
			$retValue = $retValue.$tmp;
			$numCon++;
		}
		if ($numCon >= 3)
		{
			if ($bCog)
			{
				break;
			}
			else
			{
				for ($k = $i + 1; $k < strlen($strVal); $k++)
				{
					$tmp = substr($strVal, $k, 1);
					if (strpos($strVoc, $tmp)===false && $tmp != " ")
					{
						$retValue = $retValue.$tmp;
						$strTemp = $retValue;
						$retValue = substr($strTemp, 0, 1);
						$retValue = $retValue.substr($strTemp, strlen($strTemp) - 2, 2);
						$i = strlen($strVal);
						break;
					}
				}
			}
		}
	}
	if ($numCon < 3)
	{
		for ($i = 0; $i < strlen($strVal); $i++)
		{
			$tmp = substr($strVal, $i, 1);
			if (strpos($strVoc, $tmp)!=false)
			{
				$retValue = $retValue.$tmp;
				$numVoc++;
			}
			if (($numCon + $numVoc) >= 3)
				break;
		}
	}
	if (($numCon.$numVoc) < 3)
	{
		if (($numCon.$numVoc) == 0)
			$retValue = "***";
		if (($numCon.$numVoc) == 1)
			$retValue = "***";
		if (($numCon.$numVoc) == 2)
			$retValue = $retValue."X";
	}
	return strtoupper($retValue);
}
//
function ExtractDate($dt, $bSex) // funzione per estrarre la data dt = data bsex = true maschio
{
	$array = explode("/", $dt);
	$retValue = "";
	$retValue = substr($array[2], 2, 2);
	switch ($array[1])
	{
	case "01":
		$retValue = $retValue."A";
		break;
	case "02":
		$retValue = $retValue."B";
		break;
	case "03":
		$retValue = $retValue."C";
		break;
	case "04":
		$retValue = $retValue."D";
		break;
	case "05":
		$retValue = $retValue."E";
		break;
	case "06":
		$retValue = $retValue."H";
		break;
	case "07":
		$retValue = $retValue."L";
		break;
	case "08":
		$retValue = $retValue."M";
		break;
	case "09":
		$retValue = $retValue."P";
		break;
	case "10":
		$retValue = $retValue."R";
		break;
	case "11":
		$retValue = $retValue."S";
		break;
	case "12":
		$retValue = $retValue."T";
		break;
	}

	$day = $array[0];
	if ($bSex == false)
		$day = $day + 40;

	$buffer = $day;

	return $retValue.$buffer;
}
//
function CodFiscControl($strCod) // con i pesi si calcola il carattere finale di controllo, $strCod = codice trovato fino ad ora
{
	$pesi = 0;
	//$arrPesi[36];

	$arrPesi[0] = 1;
	$arrPesi[1] = 0;
	$arrPesi[2] = 5;
	$arrPesi[3] = 7;
	$arrPesi[4] = 9;
	$arrPesi[5] = 13;
	$arrPesi[6] = 15;
	$arrPesi[7] = 17;
	$arrPesi[8] = 19;
	$arrPesi[9] = 21;
	$arrPesi[10] = 1;
	$arrPesi[11] = 0;
	$arrPesi[12] = 5;
	$arrPesi[13] = 7;
	$arrPesi[14] = 9;
	$arrPesi[15] = 13;
	$arrPesi[16] = 15;
	$arrPesi[17] = 17;
	$arrPesi[18] = 19;
	$arrPesi[19] = 21;
	$arrPesi[20] = 2;
	$arrPesi[21] = 4;
	$arrPesi[22] = 18;
	$arrPesi[23] = 20;
	$arrPesi[24] = 11;
	$arrPesi[25] = 3;
	$arrPesi[26] = 6;
	$arrPesi[27] = 8;
	$arrPesi[28] = 12;
	$arrPesi[29] = 14;
	$arrPesi[30] = 16;
	$arrPesi[31] = 10;
	$arrPesi[32] = 22;
	$arrPesi[33] = 25;
	$arrPesi[34] = 24;
	$arrPesi[35] = 23;

	strtoupper($strCod);

	for ($i = 0; $i < strlen($strCod); $i++)
	{
		$tmp = substr($strCod, $i, 1);
		if ((($i + 1) % 2) == 0)
		{
			if (ord($tmp) >= ord("0") && ord($tmp) <= ord("9"))
				$pesi += (ord($tmp) - ord("0"));
			else if (ord($tmp) >= ord("A") && ord($tmp) <= ord("Z"))
				$pesi += ord($tmp) - ord("A");
		}
		else
		{
			if (ord($tmp) >= ord("0") && ord($tmp) <= ord("9"))
				$pesi += $arrPesi[ord($tmp) - ord("0")];
			else if (ord($tmp) >= ord("A") && ord($tmp) <= ord("Z"))
				$pesi += $arrPesi[ord($tmp) - ord("A") + 10];
		}
	}
	return chr(65 + ($pesi % 26));
}	 
  }
//fine class codice_fiscale
//
?>
