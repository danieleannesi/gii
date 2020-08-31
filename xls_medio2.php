<?php
session_start();
if(!isset($_SESSION["ute"])) {
  echo "<a href=\"login.php\">Effettuare il Login</a>";
  exit;
  }
set_time_limit(600);
$ute=$_SESSION["ute"];
$idu=$_SESSION["iddu"];
$nomeesteso=$_SESSION["nomeesteso"];
$menuu=$_SESSION["menuu"];
$PHP_SELF=$_SERVER['PHP_SELF'];
//

$DB_SERVER = "localhost";
$DB_USER = "root";
$DB_PASS = "bandinelli"; 
$DB_NAME = "gi";
//
$con=mysql_pconnect($DB_SERVER, $DB_USER, $DB_PASS);
if (!$con) 
	{
	echo mysql_error();
	exit;
	}
if (!mysql_select_db($DB_NAME, $con)) 
	{
	echo mysql_error();
	mysql_close($con);
	exit;
	}
//
function calcola_valore_medio($articoli,$deposito,$dal,$al)
{
   global $con;
   global $causali;
   global $nw_qta;
   global $tqta;
   global $nw_totale;
   global $nw_medio;
   global $descri;
//
   $codice = $articoli["codice"];

   $val_iniz = $articoli["val_iniz"];
   $giac_iniz = $articoli["giac_iniz"];
   $val_iniz = 0;
   $giac_iniz = 0;
   
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
   $qr1="SELECT * FROM movmag WHERE $dep mov_codart = '$codice'
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

}
/////////////////////////////////////////////////////////
require 'include/java.php';
//
$da_codice_prod=$_POST["da_codice_prod"];
$a_codice_prod=$_POST["a_codice_prod"];
$deposito=$_POST["deposito"];
$alla_data=$_POST["alla_data"];
$dalla_data=$_POST["dalla_data"];
/*
$data_appoggio = explode("/", $alla_data);
$anno_corretto=$data_appoggio["2"];
*/
$al=addrizza("",$alla_data);
//$dal = "01-01-" . $anno_corretto;
$dal=addrizza("",$dalla_data);
$causali = array("02" => "CN" , "03" => "CN" , "04" => "CN" , "05" => "SN" , "06" => "CN" , "08" => "CN" , "09" => "CN" , "10" => "CN" , "11" => "SN" , "12" => "CN" , "14" => "CN" , "15" => "CN" , "16" => "SN" , "17" => "SN" , "18" => "CN" , "21" => "CN" , "22" => "SN" , "25" => "SN" , "39" => "CN" , "40" => "SN" , "41" => "SN" ,  "42" => "CN" , "43" => "CN" , "44" => "SN" , "45" => "SN" , "46" => "CN" , "47" => "CN" , "48" => "SN" , "50" => "SN" , "51" => "SN" , "52" => "SN" , "53" => "SN" , "54" => "SN" , "55" => "SN" , "56" => "SN" , "57" => "SN" , "58" => "SN" , "59" => "SN" , "60" => "SN" , "61" => "SN" , "62" => "CN" , "63" => "CN" , "64" => "SN" , "65" => "SN" , "66" => "CN" , "67" => "CN" , "68" => "SN" , "69" => "CN" , "71" => "CN" , "80" => "SN" , "85" => "SN" , "86" => "CN" , "87" => "CN" , "88" => "SN" , "89" => "CN" , "90" => "SN" , "91" => "CN" ,"92" => "SN" );

//
/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
//require_once dirname(__FILE__) . '/Classes/PHPExcel/Style/Border.php';
//
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
//
$gruppo="";
$r=1;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$r", "Dal");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$r", "$dalla_data");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$r", "Al");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$r", "$alla_data");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$r", "Deposito $deposito");
$r=2;
//
$objPHPExcel->getActiveSheet()->getStyle("B$r")->getNumberFormat()->setFormatCode(PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->getActiveSheet()->getStyle("D$r")->getNumberFormat()->setFormatCode(PHPExcel_Cell_DataType::TYPE_STRING);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$r", "Da codice");
$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("B$r", "$da_codice_prod",PHPExcel_Cell_DataType::TYPE_STRING);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$r", "A codice");
$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("D$r", "$a_codice_prod",PHPExcel_Cell_DataType::TYPE_STRING);

$r=3;
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$r", "Codice art");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$r", "Descrizione art");
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$r", "Giac iniziale");
//$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$r", "Valore iniziale");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$r", "Giacenza mov");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$r", "Valore mov");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$r", "Valore medio");
$r=4;
//
$qa="SELECT * FROM  arti  WHERE codice BETWEEN '$da_codice_prod' AND '$a_codice_prod' order by codice ASC ";
// $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A3", $qa);
$raa = mysql_query($qa, $con);
while(($articoli = mysql_fetch_assoc($raa))!=0)
   {
   calcola_valore_medio($articoli,$deposito,$dal,$al);

   $des=print_r($descri,true);
   
//
   $objPHPExcel->getActiveSheet()->getStyle("C$r")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
   $objPHPExcel->getActiveSheet()->getStyle("D$r")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
   $objPHPExcel->getActiveSheet()->getStyle("E$r")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
   $objPHPExcel->getActiveSheet()->getStyle("F$r")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
   $objPHPExcel->getActiveSheet()->getStyle("G$r")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED3);


if($tqta != 0 ){ 

$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit("A$r", $articoli["codice"],PHPExcel_Cell_DataType::TYPE_STRING);
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$r", $articoli["descrizione"]);
   //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$r", $articoli["giac_iniz"]);
   //$objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$r", $articoli["val_iniz"]);
//   $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$r", $nw_qta);
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$r", $tqta);
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$r", $nw_totale);
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$r", $nw_medio);   
   $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$r", $des);   
   $r++;
} 
}

//
$new = $objPHPExcel->createSheet();
//
/////////////////////////////////////////////////////////////////////////////////////////
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Giacenza');
//
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);    
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);    
//
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="giacenza.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
//
exit;
?>