<?php
$lista_nomi="[{\"deposito\":\"02\",\"quantita\":\"10.0000\",\"importo\":\"100.0000\"},{\"deposito\":\"03\",\"quantita\":\"20.0000\",\"importo\":\"200.0000\"}]";
$lista=json_decode($lista_nomi);
echo $lista_nomi . "<br>";
print_r($lista);
?>