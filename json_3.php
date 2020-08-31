<?php
$lista_nomi = array();
$i=array();

/*
    $i["00"]["giac_esposizione"]="1.0000";
    $i["00"]["val_esposizione"]="1.0000";
    $i["00"]["giac_riparazione"]="1.0000";
    $i["00"]["val_riparazione"]="1.0000";
    $i["00"]["giac_lavorazione"]="1.0000";
    $i["00"]["val_lavorazione"]="1.0000";
    $i["00"]["giac_visione"]="1.0000";
    $i["00"]["val_visione"]="1.0000";
    $i["00"]["giac_obsoleta"]="1.0000";
    $i["00"]["val_obsoleta"]="1.0000";
    $i["00"]["giac_visforn"]="1.0000";
    $i["00"]["val_visforn"]="1.0000";
    
    $i["02"]["giac_esposizione"]="1.0000";
    $i["02"]["val_esposizione"]="1.0000";
    $i["02"]["giac_riparazione"]="1.0000";
    $i["02"]["val_riparazione"]="1.0000";
    $i["02"]["giac_lavorazione"]="1.0000";
    $i["02"]["val_lavorazione"]="1.0000";
    $i["02"]["giac_visione"]="1.0000";
    $i["02"]["val_visione"]="1.0000";
    $i["02"]["giac_obsoleta"]="1.0000";
    $i["02"]["val_obsoleta"]="1.0000";
    $i["02"]["giac_visforn"]="1.0000";
    $i["02"]["val_visforn"]="1.0000";

    $i["03"]["giac_esposizione"]="3.0000";
    $i["03"]["val_esposizione"]="3.0000";
    $i["03"]["giac_riparazione"]="3.0000";
    $i["03"]["val_riparazione"]="3.0000";
    $i["03"]["giac_lavorazione"]="3.0000";
    $i["03"]["val_lavorazione"]="3.0000";
    $i["03"]["giac_visione"]="3.0000";
    $i["03"]["val_visione"]="3.0000";
    $i["03"]["giac_obsoleta"]="3.0000";
    $i["03"]["val_obsoleta"]="3.0000";
    $i["03"]["giac_visforn"]="3.0000";
    $i["03"]["val_visforn"]="3.0000";


*/

    $i["00"]["giac_ini_esposizione"]="1.0000";
    $i["00"]["val_ini_esposizione"]="1.0000";
    $i["00"]["giac_ini_riparazione"]="1.0000";
    $i["00"]["val_ini_riparazione"]="1.0000";
    $i["00"]["giac_ini_lavorazione"]="1.0000";
    $i["00"]["val_ini_lavorazione"]="1.0000";
    $i["00"]["giac_ini_visione"]="1.0000";
    $i["00"]["val_ini_visione"]="1.0000";
    $i["00"]["giac_ini_obsoleta"]="1.0000";
    $i["00"]["val_ini_obsoleta"]="1.0000";
    $i["00"]["giac_ini_visforn"]="1.0000";
    $i["00"]["val_ini_visforn"]="1.0000";
    
    $i["02"]["giac_ini_esposizione"]="1.0000";
    $i["02"]["val_ini_esposizione"]="1.0000";
    $i["02"]["giac_ini_riparazione"]="1.0000";
    $i["02"]["val_ini_riparazione"]="1.0000";
    $i["02"]["giac_ini_lavorazione"]="1.0000";
    $i["02"]["val_ini_lavorazione"]="1.0000";
    $i["02"]["giac_ini_visione"]="1.0000";
    $i["02"]["val_ini_visione"]="1.0000";
    $i["02"]["giac_ini_obsoleta"]="1.0000";
    $i["02"]["val_ini_obsoleta"]="1.0000";
    $i["02"]["giac_ini_visforn"]="1.0000";
    $i["02"]["val_ini_visforn"]="1.0000";

    $i["03"]["giac_ini_esposizione"]="3.0000";
    $i["03"]["val_ini_esposizione"]="3.0000";
    $i["03"]["giac_ini_riparazione"]="3.0000";
    $i["03"]["val_ini_riparazione"]="3.0000";
    $i["03"]["giac_ini_lavorazione"]="3.0000";
    $i["03"]["val_ini_lavorazione"]="3.0000";
    $i["03"]["giac_ini_visione"]="3.0000";
    $i["03"]["val_ini_visione"]="3.0000";
    $i["03"]["giac_ini_obsoleta"]="3.0000";
    $i["03"]["val_ini_obsoleta"]="3.0000";
    $i["03"]["giac_ini_visforn"]="3.0000";
    $i["03"]["val_ini_visforn"]="3.0000";



$lista_nomi=json_encode($i);
header('Content-Type: application/json');
echo $lista_nomi;
?>