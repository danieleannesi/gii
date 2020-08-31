<?php
$idt=0;
$tipo=0;
if(isset($_GET["idt"]))
  {
  $idt=$_GET["idt"];
  }
if(isset($_POST["idt"]))
  {
  $idt=$_POST["idt"];
  }
if(isset($_GET["tipo"]))
  {
  $tipo=$_GET["tipo"];
  }
if(isset($_POST["tipo"]))
  {
  $tipo=$_POST["tipo"];
  }
if($tipo=="1")
  {
  header("Location: staboll.php?idt=$idt&tipo=$tipo");
  }
if($tipo=="2")
  {
  header("Location: staboll.php?idt=$idt&tipo=$tipo");
  }
if($tipo=="3")
  {
  header("Location: stasco.php?idt=$idt&tipo=$tipo");
  }
if($tipo=="7")
  {
  header("Location: stafat.php?idt=$idt&tipo=$tipo");
  }
if($tipo=="8")
  {
  header("Location: stafat.php?idt=$idt&tipo=$tipo");
  }  
echo "errore: mancante tipo=$tipo";  
exit;
?>
