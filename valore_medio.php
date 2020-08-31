<?php
function calcola_valore_medio($articolo,$deposito,$dal,$al)
{
   global $con;
   $causali = array("02" => "CN" , "03" => "CN" , "04" => "CN" , "05" => "SN" , "06" => "CN" , "08" => "CN" , "09" => "CN" , "10" => "CN" , "11" => "SN" , "12" => "CN" , "14" => "CN" , "15" => "CN" , "16" => "SN" , "17" => "SN" , "18" => "CN" , "21" => "CN" , "22" => "SN" , "25" => "SN" , "39" => "CN" , "40" => "SN" , "41" => "SN" ,  "42" => "CN" , "43" => "CN" , "44" => "SN" , "45" => "SN" , "46" => "CN" , "47" => "CN" , "48" => "SN" , "50" => "SN" , "51" => "SN" , "52" => "SN" , "53" => "SN" , "54" => "SN" , "55" => "SN" , "56" => "SN" , "57" => "SN" , "58" => "SN" , "59" => "SN" , "60" => "SN" , "61" => "SN" , "62" => "CN" , "63" => "CN" , "64" => "SN" , "65" => "SN" , "66" => "CN" , "67" => "CN" , "68" => "SN" , "69" => "CN" , "71" => "CN" , "80" => "SN" , "85" => "SN" , "86" => "CN" , "87" => "CN" , "88" => "SN" , "89" => "CN" , "90" => "SN" , "91" => "CN" ,"92" => "SN" );
//
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
     $giac_iniz+=$inizio[$key]["giacenza_ini"];
     $val_iniz+=$inizio[$key]["valore_ini"];
     }
//   
//leggi articolo

//
   $nw_qta=$giac_iniz;
   $tqta=$giac_iniz;
   $nw_totale=$val_iniz;
   $nw_medio=0;
   if($nw_qta>0)
     {
     $nw_medio=round(($nw_totale/$nw_qta),4);
     }
   $dep="";
   if($deposito>"")
     {
	 $dep="mov_dep='$deposito' AND ";
	 }     
// query movimenti
   $qr1="SELECT * FROM movmag WHERE $dep mov_codart = '$articolo'
         AND mov_data BETWEEN '$dal' AND '$al' ORDER BY mov_dep, mov_data, mov_causale DESC";
   //file_put_contents("test.txt",$qr1);
   $rst = mysql_query($qr1, $con);
   while(($row = mysql_fetch_assoc($rst))!=0)
      {
      $cau=$row["mov_causale"];
      $data=$row["mov_data"];
      $unitario=$row["mov_prezzo"];
      $qua=$row["mov_qua"];
      $cs=substr($causali[$cau],0,1);
//scarichi
      if($cs=="S")
        {       	
		//$descri[]="scarico data=$data qua=$qua";
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
//carichi
      if($cs=="C")
        {
		//$descri[]="carico data=$data qua=$qua";
        $old_qta=$tqta;
        $oldv=$tqta*$nw_medio;
        $old_medio=$nw_medio;
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
   return $nw_medio;
}
?>