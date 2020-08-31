<?php
$lista_nomi = array();
$i=array();

    $i["deposito"]=["02","03","04"];

    $i["giac_esposizione"]=["10.0000","20.0000","30.0000"];
    $i["giac_riparazione"]=["10.0000","20.0000","30.0000"];
    $i["giac_lavorazione"]=["10.0000","20.0000","30.0000"];
    $i["giac_visione"]=["10.0000","20.0000","30.0000"];
    $i["giac_obsoleta"]=["10.0000","20.0000","30.0000"];
    $i["giac_prefattu"]=["10.0000","20.0000","30.0000"];

$lista_nomi=json_encode($i);
header('Content-Type: application/json');
echo $lista_nomi;

?>