<?php
ob_start();
session_start();
$PHP_SELF=$_SERVER['PHP_SELF'];
require 'include/database.php';
require 'class_varie.php';
//
if (isset($_POST["utente"]) && isset($_POST["pwd"])) {

	$utente=$_POST["utente"];
	$pwd=$_POST["pwd"];
	$qr="SELECT * FROM utenti WHERE BINARY utente='$utente' AND BINARY password='$pwd'";
	$rst = mysql_query($qr, $con);
	if (!$rst) {
        echo "(leggi utente) " . mysql_error();
		mysql_close($con);
		exit;
			}
	$row = mysql_fetch_array($rst);
	$righe = mysql_num_rows($rst);
   
	if($righe>0) {
    	extract($row);

		$_SESSION["ute"]=$utente;
		$utente=$_SESSION["ute"];
		
		$_SESSION["iddu"]=$idu;
		$_SESSION["nomeesteso"]="$nome $cognome";
		$_SESSION["nomebreve"]=$breve;
		$_SESSION["admin"]=$amministratore;
		$_SESSION["super"]=$super;
		$_SESSION["deposito"]=$deposito;

        $log=new scrivi_log($utente,"login");

		header("Location: menu.php");
		exit;
	} else {
		if (isset($_SESSION["contaerrori"])) {
			$contaerrori=$_SESSION["contaerrori"];
			$contaerrori+=1;
		} else {
			$contaerrori=$_SESSION["contaerrori"];
			$contaerrori=1;
		}
		unset($utente);
		unset($pwd);
		if ($contaerrori>=3){
	      	exit;
		} else {
	      	header("Location: $PHP_SELF");
		}
	  	exit;
	}
} 

if(isset($_GET["logout"])) {
	if (isset($_SESSION["ute"])) {
        $log=new scrivi_log($_SESSION["ute"],"logout");
		unset($_SESSION["ute"]);
	}
}

if(isset($_SESSION["utente"])) {
   header("Location: menu.php"); 
   exit;
}
?>
<html>
<head>
<link rel="STYLESHEET" href="style.css" type="text/css">
<title>login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="login" autocomplete="off">
<p>&nbsp;</p><table  border="0" cellspacing="10" cellpadding="5" align="center" class="bottone" width="250px">
  <tr>
      <td>
	  <img src="immagini/login.jpg" border="0" width="60px">
      </td>
      <td>
	  <img src="immagini/logo_GI.png" border="0" width="140px">
      </td>
  </tr>
  <tr>
    <td align="right" width="50%" nowrap="nowrap">login :</td>
    <td ><input name="utente" type="text" size="20" maxlength="30"></td>
  </tr>
  <tr>
    <td align="right" width="50%" nowrap="nowrap">password :</td>
    <td ><input name="pwd" type="password" size="20" maxlength="20"></td>
  </tr>
  <tr>
	<td colspan="2" align="center"><input class="bottonelogin" type="submit" Value="Login" ></td>
  </tr>
</table>
<p>&nbsp;</p><table width="25%" border="0" cellspacing="0" cellpadding="0" align="center">
  
</table>
</form>
<SCRIPT>
document.login.utente.focus();
</SCRIPT>
</body>
</html>
