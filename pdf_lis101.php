<?php
///////////lisforn//////////////////
function leggi_tabelle($codice,$descri)
{
	global $con;
	$descrizione="";
	$qr="SELECT * FROM tabelle WHERE tab_key = '$codice'";
    $rsi = mysql_query($qr, $con);
    while($roi = mysql_fetch_array($rsi)) {
       $tabresto=json_decode($roi["tab_resto"],true);
       $descrizione=$tabresto["$descri"];
	   }
return $descrizione;
}
//
set_time_limit(1200);
//
require 'fpdf_js.php';
require 'include/database.php';
require 'include/idrobox.php';
require 'include/java.php';
require 'calcola_medio.php';
//
foreach ($_GET as $key => $value) 
  { 
  $$key=$value;
  }
//
$data_val_ven=addrizza("",$data_val_ven);
$data_val_acq=addrizza("",$data_val_acq);
if($aggiorna=="true")
  {
  file_put_contents("testwart.txt", "");
  }
////////////////////////////////////////////////////
//class PDF extends FPDF_Javascript
class PDF_AutoPrint extends PDF_Javascript
{
function AutoPrint($dialog=false)
{
    //Embed some JavaScript to show the print dialog or start printing immediately
    $param=($dialog ? 'true' : 'false');
//	
}
//Page header 
function Header()
{
//
$num_pag=$this->PageNo();
//
$this->SetTopMargin(0);
$this->SetFont('Times','',7);
//
}

function Footer()
{
}

} //fine class
/////////////////INIZIO PROGRAMMA///////////////////////////
$pdf=new PDF_AutoPrint();
$pdf->AliasNbPages();
$pdf->AddPage("L","A4");
//
$pdf->SetFont('Times','',10);
$mm=10;
$a=4;
$deposito="";
$dal="2020-01-01";
$al="2020-12-31";
$correttivo=1.43;
$oggi=date("Y-m-d");
//
$pdf->SetXY(6,10);
//
mysql_select_db($DB_NAME, $con);
$qr="SELECT * FROM clienti WHERE cf_cod='$fornitore'";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
   $clienti=$row;   
   }
$cf_porto=$clienti["cf_porto"];
$trasp1=leggi_tabelle("t52$cf_porto","ADDEBITO_IN_PERCENT");
unset($marchio);
$qs="SELECT DISTINCT scf_marca FROM scofor WHERE scf_codfor='$fornitore'";
$rss = mysql_query($qs, $con);
while($ros = mysql_fetch_array($rss)) {
  $marchio[]=$ros["scf_marca"];
  }
if(!isset($marchio[0]))
   {
   echo "Marchio NON trovato in SCOFOR per $fornitore ($qs)";
   exit;
   }
$mar_codice=trim($marchio[0]);
//  
$qr="SELECT * FROM mgforn LEFT JOIN articoli ON art_codice=mgf_codart WHERE mgf_codfor='$fornitore' AND mgf_codprod BETWEEN '$da_artfo' AND '$a_artfo' AND mgf_codart BETWEEN '$da_artgi' AND '$a_artgi' ORDER BY mgf_codart";
$rst = mysql_query($qr, $con);
while($row = mysql_fetch_array($rst)) {
  	 extract($row);
     $trasp=$trasp1;
     if($art_trasporto>0)
       {
	   	$trasp=$art_trasporto;
	   }
     if($art_trasporto=99.99)
       {
	   	$trasp=0;;
	   }
//	   
//lettura idrobox
     $desidro="";
     $idro=array();
     mysql_select_db($DBI_NAME, $idr);
     $art_codiceproduttore=trim($mgf_codprod);
     $qi="SELECT articoli.mar_codice, art_codiceproduttore,art_descrizioneridotta,art_descrizionearticolo, art_descrizioneorigine, art_um,art_conf,lis_prezzoeuro1,lis_datalistino,art_catsc,lcr_descrizione,art_immaginegrande,art_disegnotecnico,set_codice,mac_codice,fam_codice,lis_prezzoeuroprec FROM articoli LEFT JOIN abb_art_liscarrev ON articoli.art_codice=abb_art_liscarrev.art_codice AND articoli.mar_codice=abb_art_liscarrev.mar_codice LEFT JOIN liscarrev ON abb_art_liscarrev.lcr_id=liscarrev.lcr_id WHERE articoli.mar_codice='$mar_codice' AND BINARY art_codiceproduttore='$art_codiceproduttore'";
     $rsi = mysql_query($qi, $idr);
     while($roi = mysql_fetch_array($rsi)) {
     	$idro=$roi;
	    }
     $desidro=$idro["art_descrizioneridotta"];
     mysql_select_db($DB_NAME, $con);
// fine lettura idrobox
     $qq="";
     $scofor=array();
     
     if(count($idro)==0)
       {
	   $qq="NON TROVATO idrobox per ($mgf_codart) ($mar_codice) ($art_codiceproduttore)\n$a\n\n";
       $pdf->SetXY(10,$mm);
   	   $pdf->Cell(0,4,"NON TROVATO idrobox per ($mgf_codart) ($mar_codice) ($art_codiceproduttore)",0,0,'L');
       $mm+=$a;
       $mm+=$a;
          
	   goto NEXT;  	
	   }

     $qq="($mgf_codart) ($mar_codice) ($art_codiceproduttore)\n";

//CERCA TIPO 1 SU SCOFOR (prezzo netto)
     $qs="SELECT * FROM scofor WHERE scf_tipo='1' AND scf_marca='$mar_codice' AND '$art_codiceproduttore' BETWEEN scf_da_articolo AND scf_a_articolo";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }

//CERCA TIPO 3 SU SCOFOR (UM oppure SET oppure MAC o FAM)
     $idro_um=trim($idro["art_um"]);
     if($idro_um>"")
       {
       $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_um='$idro_um'";
       $qq.="$qs\n";
       $rss = mysql_query($qs, $con);
       $r=mysql_num_rows($rss);
       while($ros = mysql_fetch_array($rss)) {
          $scofor=$ros;     	
	      }
       if($r>0) {	goto TROVATO; }
       //CERCA PER UM E ARTICOLO
       $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_um='$idro_um' AND scf_a_articolo='$art_codiceproduttore'";
       $qq.="$qs\n";
       $rss = mysql_query($qs, $con);
       $r=mysql_num_rows($rss);
       while($ros = mysql_fetch_array($rss)) {
          $scofor=$ros;     	
	      }
       if($r>0) {	goto TROVATO; }
       //CERCA PER UM E ARTICOLO
       $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_um='$idro_um' AND NOT scf_a_articolo>'$art_codiceproduttore' AND NOT scf_da_articolo<'$art_codiceproduttore'";
       $qq.="$qs\n";
       $rss = mysql_query($qs, $con);
       $r=mysql_num_rows($rss);
       while($ros = mysql_fetch_array($rss)) {
          $scofor=$ros;     	
	      }
       if($r>0) {	goto TROVATO; }
	   }
     //CERCA PER SET
     $idro_set=$idro["set_codice"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_set='$idro_set' AND scf_mac='' AND scf_fam=''";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }
     //CERCA PER SET e MAC
     $idro_mac=$idro["mac_codice"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_set='$idro_set' AND scf_mac='$idro_mac' AND scf_fam=''";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }
    //CERCA PER SET e MAC e FAM
     $idro_fam=$idro["fam_codice"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='3' AND scf_marca='$mar_codice' AND scf_set='$idro_set' AND scf_mac='$idro_mac' AND scf_fam='$idro_fam'";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }

//CERCA TIPO 2 SU SCOFOR (listino generale)
     $idro_catsc=$idro["art_catsc"];
     $idro_listino=$idro["lcr_descrizione"];
     $qs="SELECT * FROM scofor WHERE scf_tipo='2' AND scf_marca='$mar_codice' AND scf_catsc='$idro_catsc' AND scf_listino='$idro_listino'";
     $qq.="$qs\n";
     $rss = mysql_query($qs, $con);
     $r=mysql_num_rows($rss);
     while($ros = mysql_fetch_array($rss)) {
        $scofor=$ros;     	
	    }
     if($r>0) {	goto TROVATO; }
     
TROVATO:

     if($r==0)
       {
	   	$qq.="NON TROVATO scofor\n";
        goto NEXT;
	   }
     $qq.="\n\n";

     if(!isset($scofor["scf_trasporto"]))
       {
        $aa=print_r($scofor,true);
	   	file_put_contents("test101.txt","$qq\n$aa\n",FILE_APPEND);
	   }
     if($scofor["scf_trasporto"]>0)
       {
	   	$trasp=$scofor["scf_trasporto"];
	   }
     $listino_for=$idro["lis_prezzoeuro1"];
     $sconto1=$scofor["scf_sconto_1"];
     $sconto2=$scofor["scf_sconto_2"];
     $sconto3=$scofor["scf_sconto_3"];
     $sconto4=$scofor["scf_sconto_4"];
     $sconto5=$scofor["scf_sconto_5"];
     $sconto_agg=$scofor["scf_sconto_ag"];
     $sconto_agg_cl=$scofor["scf_sconto_ag_cl"];
     $scf_moltiplica=$scofor["scf_moltiplica"];
     $scf_dividi=$scofor["scf_dividi"];
     $scf_magg_netto=$scofor["scf_magg_netto"];
     $scf_lis_da_netto=$scofor["scf_lis_da_netto"];    
     $scf_netto=$scofor["scf_netto"];    
     $scf_ricarica=$scofor["scf_ricarica"];    
     $scf_classe=$scofor["scf_classe"];    
     
     $prezzo_acq=$listino_for;
     $prezzo_acq=$prezzo_acq - $prezzo_acq * $sconto1 / 100;
     $prezzo_acq=$prezzo_acq - $prezzo_acq * $sconto2 / 100;
     $prezzo_acq=$prezzo_acq - $prezzo_acq * $sconto3 / 100;
     $prezzo_acq=$prezzo_acq - $prezzo_acq * $sconto4 / 100;
     $prezzo_acq=$prezzo_acq - $prezzo_acq * $sconto5 / 100;
     $prezzo_acq=$prezzo_acq - $prezzo_acq * $sconto_agg / 100;
     
     $prezzo_netto=0.00;
     
     if($scf_lis_da_netto=="S")
       {
	   $prezzo_ven=$scf_netto * $scf_ricarica;
	   $prezzo_netto=$scf_netto;
	   }
	 else
	   {
	   $prezzo_ven=$listino_for * $scf_ricarica;	
	   }
     
     $prenet_eu=$prezzo_acq + $prezzo_acq * $trasp / 100;
     $ricarica= ($prezzo_ven / $correttivo - $prenet_eu) * 100 / $prenet_eu;
     $ricarica=round($ricarica,2);     
     if($ricarica<0)
       {
	   	$ricarica=$ricarica*-1;
	   }

/*
      *****calcolo ricarica nuova********************************
           COMPUTE PRENET-EU ROUNDED = 
                   PREZZO-ACQ + PREZZO-ACQ * TRASPART / 100.
           COMPUTE RICARICA ROUNDED = 
             ( PREZZO-VEN / CORRETTIVO - PRENET-EU )
                            * 100 / PRENET-EU.
           MOVE RICARICA TO ST-RICA2.


      ********calcolo listino gi**************************************
           IF SCF-LIS-DA-NETTO = "S" AND SCF-NETTO > 0
              COMPUTE PREZZO-VEN ROUNDED = SCF-NETTO * SCF-RICARICA
           ELSE
              COMPUTE PREZZO-VEN ROUNDED = LNK-PREZZO * SCF-RICARICA.

 
           COMPUTE PREZZO-ACQ ROUNDED = PREZZO-ACQ -
                      PREZZO-ACQ * SCF-SCONTO-1 / 100
           COMPUTE PREZZO-ACQ ROUNDED = PREZZO-ACQ -
                      PREZZO-ACQ * SCF-SCONTO-2 / 100
           COMPUTE PREZZO-ACQ ROUNDED = PREZZO-ACQ -
                      PREZZO-ACQ * SCF-SCONTO-3 / 100
           COMPUTE PREZZO-ACQ ROUNDED = PREZZO-ACQ -
                      PREZZO-ACQ * SCF-SCONTO-4 / 100
           COMPUTE PREZZO-ACQ ROUNDED = PREZZO-ACQ -
                      PREZZO-ACQ * SCF-SCONTO-5 / 100.
           COMPUTE PREZZO-ACQ ROUNDED = PREZZO-ACQ -
                      PREZZO-ACQ * SCF-SCONTO-AG / 100.

           MOVE SCF-SCONTO-1 TO SCO.
           COMPUTE SCO1 ROUNDED = 1 - SCO / 100.
           COMPUTE SCO1 ROUNDED = SCO1 * (1 - SCF-SCONTO-2 / 100) *
                                         (1 - SCF-SCONTO-3 / 100) *
                                         (1 - SCF-SCONTO-4 / 100) *
                                         (1 - SCF-SCONTO-5 / 100) *
                                         (1 - SCF-SCONTO-AG / 100).
           COMPUTE SCO ROUNDED = (SCO1 - 1) * 100.

           COMPUTE SCOC ROUNDED = 1 - SCF-SCONTO-1 / 100.
           COMPUTE SCOC ROUNDED = SCOC * (1 - SCF-SCONTO-2 / 100) *
                                         (1 - SCF-SCONTO-3 / 100) *
                                         (1 - SCF-SCONTO-4 / 100) *
                                         (1 - SCF-SCONTO-5 / 100) *
                                         (1 - SCF-SCONTO-AG-CL / 100).
           COMPUTE SCOC ROUNDED = (SCOC - 1) * 100.
*/
     //$sco1=1 - 45 / 100 = 0.55
     //$sco1=0,55 * 0,75 * 0,95 * 1 * 1 = 0,391875
     //$sco1=(0,391875 - 1) * 100 = -60,81
     
     $sco=0;
     $scoc=0;
     if($sconto1>0 || $sconto2>0 || $sconto3>0 || $sconto4>0 ||$sconto5>0 || $sconto_agg_cli>0)
       {
     $sco1=1 - $sconto1 / 100;
     $sco1=$sco1 * (1 - $sconto2 / 100) * 
                   (1 - $sconto3 / 100) * 
                   (1 - $sconto4 / 100) * 
                   (1 - $sconto5 / 100) *
                   (1 - $sconto_agg / 100).
     $sco1=floatval($sco1);
     $sco=($sco1 - 1) * 100;
     $sco=$sco*-1;
     $sco=round($sco,4);

     $scoc=1 - $sconto1 / 100;
     $scoc=$scoc * (1 - $sconto2 / 100) * 
                   (1 - $sconto3 / 100) * 
                   (1 - $sconto4 / 100) * 
                   (1 - $sconto5 / 100) *
                   (1 - $sconto_agg_cl / 100).
     $scoc=floatval($scoc);
     $scoc=($scoc - 1) * 100;
     $scoc=$scoc*-1;
     $scoc=round($scoc,4);
	   }

     if($scf_moltiplica > 0)
       {
	   	$sco_euc=100 - $scf_moltiplica / $scf_dividi;
        $sco1=1 - $sco_euc / 100;
        $sco1=$sco1 * (1 - $scoc / 100) * 100;
        $sco1=$sco1 * (100 + $scf_magg_netto) / 100;
        $sco=($sco1 - 1) * 100;
        $prezzo_acq=$listino_for - $listino_for * $sco / 100;
	   }

/*
           IF SCF-RED-MOLTIPLICA NOT = SPACES
             IF SCF-MOLTIPLICA > 0
                COMPUTE SCO-EUC ROUNDED = 100 - 
                        SCF-MOLTIPLICA / SCF-DIVIDI
                COMPUTE SCO1 ROUNDED = 1 - SCO-EUC / 100
                COMPUTE SCO1 ROUNDED = SCO1 * (1 - SCOC / 100) * 100
                COMPUTE SCO1 ROUNDED = 
                        SCO1 * (100 + SCF-MAGG-NETTO) / 100
                COMPUTE SCO ROUNDED = (SCO1 - 1) * 100
                COMPUTE PREZZO-ACQ ROUNDED = LNK-PREZZO -
                      LNK-PREZZO * SCO / 100.
*/

     $zricarica=number_format($ricarica,2,",",".");
     $zprezzo_acq=number_format($prezzo_acq,4,",",".");
     $zprezzo_ven=number_format($prezzo_ven,4,",",".");
     $zprezzo_netto=number_format($prezzo_netto,4,",",".");
     
     $zsco=number_format($sco,4,",",".");
     $zscoc=number_format($scoc,4,",",".");
	   
     $ztrasp=number_format($trasp,2,",",".");
     if($ztrasp=="0,00")
       {
	   	$ztrasp="";
	   }
	 $zlistino_for=number_format($listino_for,4,",",".");
	 
//dati vecchi
	 if(!$oggi < $mgf_data_listino || $mgf_data_listino=='0000-00-00')
	   {
	   	$prezzo_netto1=$mgf_pr_netto2;
	   	$prezzo_acq1=$mgf_pr_listino2;
	   }
	 else
	   {
	   	$prezzo_netto1=$mgf_pr_netto;
	   	$prezzo_acq1=$mgf_pr_listino;
	   }
	 $listino_for1=$prezzo_acq1;
	 $zlistino_for1=number_format($listino_for1,4,",",".");
	 
     if(!$oggi < $art_data_listino && $art_data_listino>'0000-00-00')
       {
	   	$prezzo_ven1=$art_listino2;
	   }
	 else
	   {
	   	$prezzo_ven1=$art_listino1;
	   }
   
     if(!$oggi<$mgf_data_sconto && $mgf_data_sconto>'0000-00-00')
       {
	   	$sconto=$mgf_sconto;
	   }
	 else
	   {
	   	$sconto=$mgf_sconto2;
	   }
     $prezzo_acq1=$prezzo_acq1 - ($prezzo_acq1 * $sconto / 100);
     
     $prenet_eu=$prezzo_acq1 + $prezzo_acq1 * $trasp / 100;
     $ricarica1=($prezzo_ven1 / $correttivo - $prenet_eu) * 100 / $prenet_eu;
     if($ricarica1<0)
       {
	   	$ricarica1=$ricarica1*-1;
	   }
     $scoc1=$mgf_sconto;

     $zricarica1=number_format($ricarica1,2,",",".");
     $zprezzo_acq1=number_format($prezzo_acq1,4,",",".");
     $zprezzo_ven1=number_format($prezzo_ven1,4,",",".");
     $zprezzo_netto1=number_format($prezzo_netto1,4,",",".");     
     $zscoc1=number_format($scoc1,4,",",".");     
//fine dati vecchi

/*
      *****calcolo ricarica vecchia******************************
           COMPUTE PRENET-EU ROUNDED = 
      *            ZF-06-EU   + ZF-06-EU   * TRASPART / 100.
                   PRE-ACQ    + PRE-ACQ    * TRASPART / 100.
           COMPUTE RICARICA ROUNDED = 
             ( PREVEN1    / CORRETTIVO - PRENET-EU )
                            * 100 / PRENET-EU.
           MOVE RICARICA TO ST-RICA1.


           IF ZF-17 > DATA-OGGI OR ZF-17 = "000000"
              MOVE ZF-15-EU   TO ST-NETTO1
              MOVE ZF-18-EU   TO ST-PRE1 PRE-ACQ
           ELSE
              MOVE ZF-16-EU   TO ST-NETTO1
              MOVE ZF-19-EU   TO ST-PRE1 PRE-ACQ.
              
           IF DATA-OGGI NOT < MAG-26 AND MAG-26 > "000000"
              MOVE MAG-25-EU  TO ST-VEN1 PREVEN1
           ELSE
              MOVE MAG-24-EU  TO ST-VEN1 PREVEN1.
           
           COMPUTE PRE-ACQ ROUNDED = PRE-ACQ - (PRE-ACQ * ZF-12 / 100).
           MOVE PRE-ACQ    TO ST-ACQ1.
*/ 

/*
     $valori=calcola_valore_medio($mgf_codart,0,$dal,$al,"N");
     $nw_medio=$valori["nw_medio"];
     $zgiacenza=number_format($valori["tqta"],2,",",".");
     if($zgiacenza=="0,00")
       {
	   	$zgiacenza="";
	   }
*/

     $pdf->SetXY(10,$mm);
   	 //$pdf->Cell(30,4,$mgf_codprod,0,0,'L');
   	 $pdf->Cell(30,4,$mgf_codart,0,0,'L');
   	 $pdf->Cell(115,4,$art_descrizione,0,0,'L');
   	 $pdf->Cell(10,4,$zricarica1,0,0,'R');
   	 $pdf->Cell(20,4,$zprezzo_netto1,0,0,'R');
   	 $pdf->Cell(20,4,$zlistino_for1,0,0,'R');
   	 $pdf->Cell(20,4,$zprezzo_ven1,0,0,'R');
   	 $pdf->Cell(20,4,$zprezzo_acq1,0,0,'R');
   	 $pdf->Cell(20,4,$zscoc1,0,0,'R');
   	 $pdf->Cell(8,4,$art_classe_merc,0,0,'R');
     $mm+=$a;

     //$pdf->SetXY(10,$mm);
   	 //$pdf->Cell(30,4,"!$oggi < $art_data_listino $mgf_pr_listino $mgf_pr_listino2",0,0,'L');
     //$mm+=$a;
     
     $pdf->SetXY(10,$mm);
   	 $pdf->Cell(30,4,$mgf_codprod,0,0,'L');
   	 //$pdf->Cell(20,4,$mgf_codart,0,0,'L');
   	 $pdf->Cell(115,4,$desidro,0,0,'L');
   	 $pdf->Cell(10,4,$zricarica,0,0,'R');
   	 $pdf->Cell(20,4,$zprezzo_netto,0,0,'R');
   	 $pdf->Cell(20,4,$zlistino_for,0,0,'R');
   	 $pdf->Cell(20,4,$zprezzo_ven,0,0,'R');
   	 $pdf->Cell(20,4,$zprezzo_acq,0,0,'R');
   	 $pdf->Cell(20,4,$zscoc,0,0,'R');
   	 $pdf->Cell(8,4,$scf_classe,0,0,'R');
   	 
     $mm+=$a;
     $mm+=$a;
//////////////////////////////////////////
//aggiornamenti
/*
aggiorna
descri
prefisso
soloforni
solocli
evita
*/
if($aggiorna=="true")
  {
   $q1="";
   $q2="";
   $q3="";  
   if($evita=="false")
    {
	$q1="art_listino1=art_listino2";
	}	
  //if($art_data_listino>$oggi)
   if($soloforni=="false")
    {
	$q2=", art_data_listino='$data_val_ven', art_listino2='$prezzo_ven'";
	}
  if($descri=="true")
    {
    $desidro=addslashes($desidro);
    $q3=", art_descrizione='$desidro'";
    }
  $qw="UPDATE articoli SET $q1 $q2 $q3 WHERE art_codice='$mgf_codart' LIMIT 1";
  $rsw=mysql_query($qw, $con);
  file_put_contents("testwart.txt", "$qw\n",FILE_APPEND);
  }
if($aggiorna=="true" && $solocli=="false")
  {
  $q1="";
  $q2="";
  $q3="";
  if($evita=="false")
    {
	$q1="mgf_pr_netto=mgf_pr_netto2, mgf_sconto=mgf_sconto2";
	}
  $q2=",mgf_pr_netto2='$prezzo_netto', mgf_pr_listino2='$listino_for', mgf_sconto2='$scoc', mgf_data_listino='$data_val_acq'";
  $qw="UPDATE mgforn SET $q1 $q2 WHERE mgf_codart='$mgf_codart' LIMIT 1";
  $rsw=mysql_query($qw, $con);
  file_put_contents("testwart.txt", "$qw\n",FILE_APPEND);
  }
//fine aggiornamenti
NEXT:
   if($mm>190) { 
      $pdf->AddPage("L","A4");
      $pdf->SetXY(6,10);
      $mm=10;
	  }
	}	   

////stampa automatica////////////////////////////////////////
//$pdf->IncludeJS("pp=getPrintParams(); print(pp);");
$pdf->AutoPrint(false);
//
$pdf->Output();
?>
