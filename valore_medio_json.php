<?php
//set_time_limit(600);
require 'include/database.php';
//
//leggi depositi da tabelle/////////////////////////////////////////////////////
  unset($fitdep);
  $qr="SELECT * FROM tabelle WHERE tab_key LIKE 't46%' ORDER BY tab_key";
  $rst = mysql_query($qr, $con);
  if (!$rst) {
	echo "(leggi depositi) " . mysql_error();
	mysql_close($con);
	exit;
	}
  while($row = mysql_fetch_array($rst)) {
     $tabdep=json_decode($row["tab_resto"],true);
     $fit=trim(substr($row["tab_key"],3,3));
     $fitdep["$fit"]=$tabdep["DEPOSITO_FITTIZIO"];
	 }
//fine leggi depositi///////////////////////////////////////////////////////////
//
//lettura causali magazzino
unset($causali);
$qr="SELECT * FROM tabelle WHERE tab_key LIKE 't40%' ORDER BY tab_key";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
     $tabcaus=json_decode($row["tab_resto"],true);
     $a=trim(substr($row["tab_key"],3,2));
     $tipo=$tabcaus["CAR_SCAR_INV_TRASF"];
     $causali[$a]=$tipo;
	 }
//
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
      $unitario=$row["mov_prezzo"];
      $qua=$row["mov_qua"];
      $mov_dep=$row["mov_dep"];
      $mov_totale=$row["mov_totale"];
      $cs=substr($causali[$cau],0,1);
      /*
      if($cs!="S" && $cs!="C")
        {
		echo "*causale $cau errata ($cs)<br>";
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
/////////////////////////////////////////////////////////
//
$articolo=$_POST["articolo"];
$deposito=$_POST["deposito"];
$dal=$_POST["dalla_data"];
$al=$_POST["alla_data"];
$art_descrizione="";
//
//test test test
/*
$articolo="2471095951";
$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
*/
//
$valori=calcola_valore_medio($articolo,$deposito,$dal,$al,"S");
//
$res["val_medio"]=$valori["nw_medio"];
$valori=calcola_valore_medio($articolo,$deposito,$dal,$al,"N");
//
$res["tqta"]=$valori["tqta"];
$res["codart"]=$articolo;
$res["desart"]=$art_descrizione;
$res["depositi"]=$valori["depo_val"];
$res["valori"]=$valori;

//$res["debug"]="articolo=$articolo dep=$deposito dal=$dal al=$al";
header('Content-Type: application/json');
echo json_encode($res);
?>