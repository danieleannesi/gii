<?php
require 'fpdf.php';
require 'include/database.php';
require 'calcola_medio.php';

 
$dal="2020-01-01";
$al="2020-12-31";
$deposito = $_GET["deposito"];
$marca = $_GET["art_fornitore"];
$saldi = $_GET["saldi"];
$negativi = $_GET["negativi"]; 
$year = date("Y");
$pdf = new FPDF();
$pdf->AddPage("L");  
$pdf->SetFont('Arial','',10);
$pdf->SetTopMargin(10);
$pdf->SetLineWidth(0.05);   
$pdf->SetXY(5,10);
$pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');  
$pdf->SetXY(80,10);
$pdf->Cell(0,4,"MG060 - INVENTARIO DI MAGAZZINO",0,0,'L'); 
$pdf->SetXY(180,10);
$pdf->Cell(0,4,"DEPOSITO: ".$deposito,0,0,'L');
$pdf->SetXY(215,10);
$pdf->Cell(0,4,"ANNO: ".$year,0,0,'L');


$y = $pdf->getY();
$pdf->SetXY(5,$y+10);
$pdf->Cell(0,4,"COD ARTICOLO",0,0,'L'); 
$pdf->SetXY(40,$y+10);
$pdf->Cell(0,4,"DESCRIZIONE",0,0,'L'); 
$pdf->SetXY(165,$y+10);
$pdf->Cell(0,4,"SALDO",0,0,'L'); 
if(!$saldi){
    $pdf->SetXY(185,$y+10);
    $pdf->Cell(0,4,"VAL. UNI. MEDIO",0,0,'L'); 
    $pdf->SetXY(215,$y+10);
    $pdf->Cell(0,4,"VAL. REALE MGZ",0,0,'L'); 
}
$qr="SELECT articoli.art_codice, articoli.art_descrizione, articoli_anno.dep_inizio, articoli_anno.dep_giacenze FROM articoli LEFT JOIN articoli_anno ON dep_anno='".$year."' AND dep_codice=art_codice ";
if($marca){
    $qr .= " WHERE art_fornitore like '".$marca."' ";
}
 
$rst=mysql_query($qr,$con);
while($row=mysql_fetch_assoc($rst)){
    $giacei=json_decode($row["dep_inizio"],true);
    $giace=json_decode($row["dep_giacenze"],true);
     
    foreach( $giacei as $chiave=>$valore){

        $y = $pdf->getY();       
        if($y>=190){
            $pdf->AddPage("L"); 
            $pdf->SetFont('Arial','',10);
            $pdf->SetTopMargin(15);
            $pdf->SetLineWidth(0.05);   
            $pdf->SetXY(5,10);
            $pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');  
            $pdf->SetXY(80,10);
            $pdf->Cell(0,4,"MG060 - INVENTARIO DI MAGAZZINO",0,0,'L'); 
            $pdf->SetXY(180,10);
            $pdf->Cell(0,4,"DEPOSITO: ".$deposito,0,0,'L');
            $pdf->SetXY(215,10);
            $pdf->Cell(0,4,"ANNO: ".$year,0,0,'L');  
        }
       
        if($row["art_descrizione"] != ""){
            if($deposito!= ""){ 
             
                if($deposito == $chiave){ 
                    $saldo =number_format($valore["giacenza_ini"],0,",",".");    
                    $valori=calcola_valore_medio($row["art_codice"],$deposito,$dal,$al,"N");
                    $z_medio=number_format($valori["nw_medio"],2,",",".");
                    $valmerce=$saldo*$valori["nw_medio"]; 
                    $z_valore=number_format($valmerce,2,",",".");
                    if($saldo>0 && !$negativi){
                        $y = $pdf->getY();
                        $pdf->SetXY(5,$y+5);
                        $pdf->Cell(0,4,$row["art_codice"],0,0,'L'); 
                        $pdf->SetXY(40,$y+5);
                        $pdf->Cell(0,4, $row["art_descrizione"],0,0,'L'); 
                        $pdf->SetXY(165,$y+5);
                        $pdf->Cell(0,4, $saldo,0,0,'L');
                        if(!$saldi){
                            $pdf->SetXY(185,$y+5);
                            $pdf->Cell(0,4, $z_medio,0,0,'L');   
                            $pdf->SetXY(215,$y+5);
                            $pdf->Cell(0,4, $z_valore,0,0,'L');   
                        } 
                    } else if($saldi<0 && $negativi == "on"){
                        $y = $pdf->getY();
                        $pdf->SetXY(5,$y+5);
                        $pdf->Cell(0,4,$row["art_codice"],0,0,'L'); 
                        $pdf->SetXY(40,$y+5);
                        $pdf->Cell(0,4, $row["art_descrizione"],0,0,'L'); 
                        $pdf->SetXY(165,$y+5);
                        $pdf->Cell(0,4, $saldo,0,0,'L');
                        if(!$saldi){
                            $pdf->SetXY(185,$y+5);
                            $pdf->Cell(0,4, $z_medio,0,0,'L');   
                            $pdf->SetXY(215,$y+5);
                            $pdf->Cell(0,4, $z_valore,0,0,'L');   
                        } 
                    }
                }
            } else {
    
                $valori=calcola_valore_medio($row["art_codice"],$deposito,$dal,$al,"N");
    
                $saldo =number_format($valori["tqta"],2,",","."); 
                $z_medio=number_format($valori["nw_medio"],2,",",".");
                $valmerce=$valori["tqta"]*$valori["nw_medio"]; 
                $z_valore=number_format($valmerce,2,",",".");
                if($saldo>0 && !$negativi){
                    $y = $pdf->getY();
                    $pdf->SetXY(5,$y+5);
                    $pdf->Cell(0,4,$row["art_codice"],0,0,'L'); 
                    $pdf->SetXY(40,$y+5);
                    $pdf->Cell(0,4, $row["art_descrizione"],0,0,'L'); 
                    $pdf->SetXY(165,$y+5);
                    $pdf->Cell(0,4, $saldo,0,0,'L');
                    if(!$saldi){
                        $pdf->SetXY(185,$y+5);
                        $pdf->Cell(0,4, $z_medio,0,0,'L');   
                        $pdf->SetXY(215,$y+5);
                        $pdf->Cell(0,4, $z_valore,0,0,'L');   
                    } 
                } else if($saldi<0 && $negativi == "on"){
                    $y = $pdf->getY();
                    $pdf->SetXY(5,$y+5);
                    $pdf->Cell(0,4,$row["art_codice"],0,0,'L'); 
                    $pdf->SetXY(40,$y+5);
                    $pdf->Cell(0,4, $row["art_descrizione"],0,0,'L'); 
                    $pdf->SetXY(165,$y+5);
                    $pdf->Cell(0,4, $saldo,0,0,'L');
                    if(!$saldi){
                        $pdf->SetXY(185,$y+5);
                        $pdf->Cell(0,4, $z_medio,0,0,'L');   
                        $pdf->SetXY(215,$y+5);
                        $pdf->Cell(0,4, $z_valore,0,0,'L');   
                    } 
                }
            }
        }
        
        
    }
} 
    $y = $pdf->getY();       
    if($y>=190){
        $pdf->AddPage("L"); 
        $pdf->SetFont('Arial','',10);
        $pdf->SetTopMargin(15);
        $pdf->SetLineWidth(0.05);   
        $pdf->SetXY(5,10);
        $pdf->Cell(0,4,"GALLI INNOCENTI & C. S.p.A.",0,0,'L');  
        $pdf->SetXY(80,10);
        $pdf->Cell(0,4,"MG060 - INVENTARIO DI MAGAZZINO",0,0,'L'); 
        $pdf->SetXY(180,10);
        $pdf->Cell(0,4,"DEPOSITO: ".$deposito,0,0,'L');
        $pdf->SetXY(215,10);
        $pdf->Cell(0,4,"ANNO: ".$year,0,0,'L');
    }
 


$pdf->Output();

 

?>