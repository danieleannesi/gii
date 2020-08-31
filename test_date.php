<?php
$acc_dt_carico="2019-01-01";
$acc_dt_richiesta="2020-01-01 20:00:00";

    $datetime1 = new DateTime($acc_dt_carico); 
    $datetime2 = new DateTime(substr($acc_dt_richiesta,0,10)); 
    $difference = $datetime1->diff($datetime2); 
    $diff=$difference->format('%R%'); 	
	echo $diff;
?>