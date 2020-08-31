<?php
function calcola_valore_medio($articolo,$deposito,$dal,$al,$fittizi)
{
   global $con;
   global $causali;
   global $art_descrizione;
   global $fitdep;
//
   unset($depo_val);
   $val_iniz = 0;
   $giac_iniz = 0;
   $anno=substr($dal,0,4);
//leggi giacenza iniziale
   $dep_inizio=array();
   $qr="SELECT * FROM articoli_anno WHERE dep_anno='$anno' AND dep_codice='$articolo'";
   $rst = mysql_query($qr, $con);
   while(($row = mysql_fetch_assoc($rst))!=0)
      {
	  $dep_inizio=$row["dep_inizio"];
	  }
   $inizio=json_decode($dep_inizio,true);
   foreach ($inizio as $key => $value) {
     if($fitdep[$key]=="")
       {
       $giac_iniz+=$inizio[$key]["giacenza_ini"];
       $val_iniz+=$inizio[$key]["valore_ini"];
	   }
     $depo_val["$key"]["qta"]=$inizio[$key]["giacenza_ini"];
     $depo_val["$key"]["val"]=$inizio[$key]["valore_ini"];
     }
//   
//leggi articolo
   $art_descrizione="";
   $qr="SELECT * FROM articoli WHERE art_codice='$articolo'";
   $rst = mysql_query($qr, $con);
   while(($row = mysql_fetch_assoc($rst))!=0)
      {
	  $art_descrizione=$row["art_descrizione"];
	  }
//
   $nw_qta=$giac_iniz;
   $tqta=$giac_iniz;
   $nw_totale=$val_iniz;
   $nw_medio=0;

   if($nw_qta>0)
     {
     $nw_medio=round(($nw_totale/$nw_qta),4);
     }
// query movimenti
   $qr1="SELECT * FROM movmag WHERE mov_codart = '$articolo'
         AND mov_data BETWEEN '$dal' AND '$al' ORDER BY mov_dep, mov_data, mov_causale DESC";
   //file_put_contents("test.txt",$qr1);
   $rst = mysql_query($qr1, $con);
   while(($row = mysql_fetch_assoc($rst))!=0)
      {
      $cau=$row["mov_causale"];
      $data=$row["mov_data"];
      //$unitario=$row["mov_prezzo"];
      $sconto=$row["mov_sconto"];
      $qua=$row["mov_qua"];
      $mov_dep=$row["mov_dep"];
      $mov_totale=$row["mov_totale"];
      $unitario=round($mov_totale/$qua,4);
      $cs=substr($causali[$cau],0,1);
      /*
      if($cs!="S" && $cs!="C")
        {
		echo "*causale $cau errata ($cs)<br>";
		echo "causali:";
		print_r($causali);
		echo ".";
		exit;
		}
	  */
//scarichi
      if($cs=="S")
        {       	
		//$descri[]="scarico data=$data qua=$qua";
        $depo_val["$mov_dep"]["qta"]-=$qua;
        $depo_val["$mov_dep"]["val"]-=$mov_totale;
        //
        if($fitdep["$mov_dep"]=="" || $fittizi=="S")
		  {
        $tqta-=$qua;
		$nw_qta-=$qua;
		if($cau=="05") //storno per errato mov.acq.
		  {
		  $nw_totale-=$unitario*$qua;
		  }
		if($cau=="16") //rettifica acq.meno
		  {
		  if($nw_medio!=0)
		    {
			$unitario=$nw_medio;
			}
		  }
	    if($nw_medio>0)
	      {
		  $nw_totale-=$qua*$nw_medio;
		  }	
		else
		  {
		  $nw_totale-=$unitario*$qua;
		  } 		
 		  }
		}
//carichi
      if($cs=="C")
        {
		//$descri[]="carico data=$data qua=$qua";
        $old_qta=$tqta;
        $oldv=$tqta*$nw_medio;
        $old_medio=$nw_medio;
        $depo_val["$mov_dep"]["qta"]+=$qua;
        $depo_val["$mov_dep"]["val"]+=$mov_totale;
        if($fitdep["$mov_dep"]=="" || $fittizi=="S")
		  {        
		$tqta+=$qua;
		$nw_qta+=$qua;
        if($cau!="04" && $cau!="14") //reso da clienti o reso da scontrino
          {
		  if($cau=="18")
		    {
			if($nw_medio!=0)
			  {
			  $unitario=$nw_medio;
			  }
			}
		  $nw_totale+=$qua*$unitario;
		  }
        $totv=$oldv+$qua*$unitario;
        if($cau!="04" && $cau!="14") //reso da clienti o reso da scontrino
          {
  		  $nw_medio=round(($totv/$tqta),4);
  		  }
  		//$descri[]="old_qta=$old_qta oldv=$oldv old_medio=$old_medio totv=$totv nw_medio=$nw_medio";
         }
        }
      }
   $valori["giac_iniz"]=$giac_iniz;
   $valori["val_iniz"]=$val_iniz;
   $valori["tqta"]=$tqta;
   $valori["nw_medio"]=$nw_medio;
   $valori["depo_val"]=$depo_val;
   return $valori;
}
//
function ordini_per_articolo($codice,$dal,$al)
{
global $con;
$qta=0;
$qr="SELECT * FROM ordini WHERE (NOT ORDI_EVASO='E' OR ORDI_EVASO IS NULL) AND ORDI_DATA_DOC BETWEEN '$dal' AND '$al'";
$rst = mysql_query($qr, $con);
while(($row = mysql_fetch_assoc($rst))!=0)
      {	
      $righe=json_decode($row["ORDI_RIGHE"],true);
      for($j=0;$j<count($righe["cod"]);$j++)
        {
        $articolo=$righe["cod"][$j];
        if($articolo==$codice)
          {
          $qta+=($righe["qta"][$j] - $righe["qta_sca"][$j]);
		  }
	    }
	  }
return $qta;
}
?>