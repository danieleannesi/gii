<?php
$idt=0;
$tipo=0;
$file=0;
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
if(isset($_POST["file"]))
  {
  $file=$_POST["file"];
  }
if($tipo=="1")
  {
  header("Location: staboll.php?idt=$idt&tipo=$tipo");
  }
if($tipo=="2" || $tipo=="A")
  {
  header("Location: staboll.php?idt=$idt&tipo=$tipo&file=$file");
  }
if($tipo=="3")
  {
  header("Location: stasco.php?idt=$idt&tipo=$tipo");
  }
if($tipo=="7")
  {
  header("Location: stafat.php?idt=$idt&tipo=$tipo&file=$file");
  }
if($tipo=="8")
  {
  header("Location: stafat.php?idt=$idt&tipo=$tipo&file=$file");
  }  
echo "errore stampadoc.php: mancante tipo=$tipo";  
exit;
?>
