<?php
function addrizza($rovescio,$dritto)
{
$ladata="";
if (strlen(trim($dritto)>0)) {
   $ladata=substr($dritto,6,4) . "-" . substr($dritto,3,2) . "-" . substr($dritto,0,2);  }
if (strlen(trim($rovescio)>0)) {
   $ladata=substr($rovescio,8,2) . '/' . substr($rovescio,5,2) . '/' . substr($rovescio,0,4);  }
return $ladata;
}
function datediff($dal,$al)
{
$d1=strtotime($al);		   
$d2=strtotime($dal);
$ggd=floor(($d1-$d2)/86400)+1;
return $ggd;	   
}
?>