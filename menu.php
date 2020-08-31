<?php
session_start();
if(!isset($_SESSION["iddu"]))
  {
  exit;
  }
$iddu=$_SESSION["iddu"];
$nomeesteso=$_SESSION["nomeesteso"];
require 'include/database.php';
//leggi menu
unset($capi);
$qr="SELECT DISTINCT men_gruppo FROM menu ORDER BY men_ordine";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) { 
     $capi[]=$row["men_gruppo"];
	 }
//
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Galli Innocenti & C</title>
	<link rel="stylesheet" type="text/css" href="dropdowns.css">
	<link rel="stylesheet" type="text/css" href="dropdowns-skin-discrete.css">
    <link rel="stylesheet" href="style.css" type="text/css">

<link rel="STYLESHEET" href="ajax.css" type="text/css">

<link rel="STYLESHEET" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css">    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="include/jquery-3.5.0.slim.min.js"></script>
    <script src="include/popper.min.js"></script>
    <script src="include/bootstrap/js/bootstrap.min.js"></script>
        
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="include/jquery-dateFormat.min.js"></script>
</head>
<body>
<script type="text/javascript" src="MyAjax.js"></script>
<script type="text/javascript"src="DragDrop.js"></script>
<script type="text/javascript"src="lib2.js"></script>

<div id="oscura" class="popup_cont" >
	<div id="attendere" >
			<img src="immagini/loading.gif" />
			<br />
			Loading...
			<div id="loading_message" ></div>
	</div>
</div>
<div id="timepopup" class="timepopup" ></div>
<div id="popup2" title=""></div>
<div id="dialogs" title=""></div>
<?php
require_once "functions_ajax.php";
?>
<div class="container-md" id="container">

<form method='post' name='menu'>
<div style="width: 200px; float: left;">
    <img src="immagini/logo_GI.png" border="0" width="40px">
</div>
<div style="float: left;">
Utente:&nbsp;
</div>
<div style="float: left;">
<?php echo $nomeesteso;?>
</div>
<div style="clear:both;"></div>
<div id="lista_vie" ></div>
<div id="riga">
<hr>
</div> 
<div class="dropdowns">
	
<a class="toggleMenu" href="#">Menu</a>
<ul class="nav">
<?php
for($j=0;$j<count($capi);$j++)
  {
  $testa=$capi[$j];
  echo "<li><a href=\"#\">$testa</a>";
  echo "<ul>";
  $qr="SELECT * FROM menu WHERE men_gruppo='$testa' ORDER BY men_ordine_prog";
  $rst = mysql_query($qr, $con);
  while($row = mysql_fetch_array($rst)) { 
     $men_nome_prog=$row["men_nome_prog"];
     $men_esegui=$row["men_esegui"];
     $men_autor=$row["men_autor"];
     $autor=preg_split("/[\s,]+/", $men_autor);
     //if (in_array($tipo_utente, $autor)) 
       {
       echo "<li><a onClick=\"$men_esegui\" href=\"#\">$men_nome_prog</a></li>";
	   }  
	 }  
  echo "</ul>";
  }
echo "</ul>";
?>
</div>
<script type="text/javascript" src="dropdowns.js"></script>
<script>
	$(".dropdowns").dropdowns();
    document.addEventListener("mousedown",_mdown);
</script>
<div id="lancia"></div>
<div id="lancia2"></div>
</form>
</div>
</body>
</html>