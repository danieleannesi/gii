<link rel="stylesheet" href="css/jquery.dataTables.min.css" type="text/css" /> 
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
<link rel="stylesheet" href="css/dropdown.css" media="screen"  type="text/css" />
<link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css" type="text/css"> 
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javaScript" src="include/jquery.typewatch.js"></script>
<script type="text/javascript" src="elenchi.js"></script>
<script type="text/javascript" src="ges_articoli.js"></script>
<div id="lista_vie" class="lista_vie" ></div>
<?php
session_start();
require 'include/database.php';
require 'leggi_codici.php';
require 'include/idrobox.php';  
//
$anno=date("Y");
//
$marca[]="Seleziona la Marca";
$ql="SELECT * FROM tab_marche ORDER BY mar_codice";
$rsl=mysql_query($ql,$idr);
while($rol = mysql_fetch_assoc($rsl)) {
   $marca[]=$rol["mar_codice"] . " - " . $rol["mar_descrizione"];
} 

?>

<div class="container">        
    <form id="formArticolo" name="formArticolo">
        <div class="form-row col-12"> 
                <div class="col-1"> <br>
                    <input type="button" value="NUOVO" id="nuovo" class="form-control" onclick="document.formArticolo.submit();">
                </div>        
                <div class="col-3">
                    <label for="marca"> Marca</label><br>
                    <select id="marca" name="marca" class="form-control" required>
                        <?php
                            $j=0;
                            while(isset($marca[$j])) {
                                $mare=trim(substr($marca[$j],0,3));
                                echo "<option value=\"$mare\"";
                                echo ">" . $marca[$j] . "</option>";
                                $j++;
                                }
                        ?>
                    </select> 
                </div>
                <div class="col-3">
                    <label for="codArt">Codice Articolo</label>
                    <input type="text" id="codArt" name="codArt" value="" class="form-control">
                </div>
                <div class="col-1"> <br>
                    <input type="button" value="CERCA" id="searchIdrobox" class="form-control">
                </div> 
                <div class="col-1"> <br>
                    <input type="button" value="MANUALE" id="manuale" class="form-control" onclick="articolo_manuale();">
                    <input type="hidden" id="modifica" name="modifica" value="0">
                </div>
                <div class="col-1"> <br>
                    <input id="test_art" name="test_art" type="text" size="10" placeholder="ricerca" style="background-color: yellow;">	
                    <input id="codart" name="codart" type="hidden" size="10" onchange="carica_articolo(this.value);">	
                </div>                
        </div>
    <div id="result"></div>
</div>
<div id="insertArticolo"> 
        <div class="row"><h4>Articoli</h4></div>
        
        <div class="row">
            <div class="col-3">
                <label for="dep_anno">Anno:</label>
                <input id="dep_anno" name="dep_anno" type="text" size="4" value="<?php echo $anno;?>" class="form-control">
            </div>
        </div>            
        <div class="row">
            <div class="col-3">
                <label for="art_fornitore">Codice Fornitore:</label>
                <input id="art_fornitore" type="text" size="8" name="art_fornitore" class="form-control"/> 
            </div>
            <div class="col-3">
                <label for="art_fornitore">Fornitore:</label>
                <input id="ragsoc" type="text" size="20" name="ragsoc" class="form-control"/> 
            </div>
            
            <div class="col-3">
                <label for="art_codice">Codice GI:</label>
                <input id="art_codice" name="art_codice" type="text" size="10" class="form-control">
            </div>
            <div class="col-3">
                <label for="mgf_cod_for">Codice Art.Fornitore:</label>
                <input id="mgf_cod_for" name="mgf_cod_for" type="text" size="20" class="form-control">
            </div>            
        </div>
        
        <div class="row">
            <div class="col-12">
                <label for="art_descrizione">Descrizione:</label>
                <input type="text" size="60" id="art_descrizione" name="art_descrizione" style="text-transform:uppercase" class="form-control"/>
            </div>
        </div>  
        <div class="row">
            <div class="col-3">       
                <label for="art_uni_mis">Unita di Misura:</label>
                <input type="text" value="" id="art_uni_mis" name="art_uni_mis" class="form-control">
            </div>
            <div class="col-3">
                <label for="art_classe">Classe Merceologica:</label>  
                <select id="art_classe_merc" id="art_classe_merc" name="art_classe_merc" class="form-control">
                <?php
                    $j=0;
                    while(isset($codmerc[$j])) {
                    $merc=$codmerc[$j];
                    echo "<option value=\"$merc\"";
                    echo ">" . $descmerc[$j] . "</option>";
                    $j++;
                }
                ?>
                </select>
            </div>

        </div> 
        <div class="row">
            <div class="col-3">    
                <label for="art_listino1">Listino:</label>
                <input id="art_listino1" type="text" size="15" name="art_listino1" class="form-control"/>
            </div>
            <div class="col-3">    
                <label for="art_listino2">Listino 2:</label>
                <input id="art_listino2" type="text" size="15" name="art_listino2" class="form-control"/>
            </div>
            <div class="col-3">
                <label for="art_data_listino" >Data Listino:</label>
                <input id="art_data_listino" type="text" size="11" maxlength="11" name="art_data_listino" class="form-control datepicker"/>
            </div> 
        </div> 

        <div class="row">
            <div class="col-3">    
                <label for="mgf_listino1">Listino Fornitore:</label>
                <input id="mgf_listino1" type="text" size="15" name="mgf_listino1" class="form-control"/>
            </div>
            <div class="col-3">    
                <label for="mgf_listino2">Listino Fornitore 2:</label>
                <input id="mgf_listino2" type="text" size="15" name="mgf_listino2" class="form-control"/>
            </div>
            <div class="col-3">
                <label for="mgf_data_listino" >Data Listino Fornitore:</label>
                <input id="mgf_data_listino" type="text" size="11" maxlength="11" name="mgf_data_listino" class="form-control datepicker"/>
            </div> 
        </div> 

        <div class="row">
            <div class="col-3">    
                <label for="mgf_sconto1">Sconto Fornitore:</label>
                <input id="mgf_sconto1" type="text" size="15" name="mgf_sconto1" class="form-control"/>
            </div>
            <div class="col-3">    
                <label for="mgf_sconto2">Sconto Fornitore 2:</label>
                <input id="mgf_sconto2" type="text" size="15" name="mgf_sconto2" class="form-control"/>
            </div>
            <div class="col-3">
                <label for="mgf_data_sconto" >Data Sconto Fornitore:</label>
                <input id="mgf_data_sconto" type="text" size="11" maxlength="11" name="mgf_data_sconto" class="form-control datepicker"/>
            </div> 
        </div>         
        
         <div class="row">
            <div class="col-3">    
                <label for="art_codice_raee">Cod.Articolo RAEE:</label> 
                <input id="art_codice_raee" type="text" size="9" name="art_codice_raee" class="form-control"/> 
            </div>
            <div class="col-3"> 
                <label for="art_cod_iva">Trattamento IVA:</label>
                <select id="art_cod_iva" name="art_cod_iva" class="form-control">
                    <?php
                    $j=0;
                    while(isset($codiva[$j])) {
                        $civa=$codiva[$j];
                        echo "<option value=\"$civa\"";
                        echo ">" . $desiva[$j] . "</option>";
                        $j++;
                    }
                    ?>
                </select>
            </div> 
            <div class="col-3">    
                <label for="art_scorta_min">Scorta Minima:</label>
                <input class="form-control" id="art_scorta_min" type="text" size="15" name="art_scorta_min" class="form-control"/>
            </div> 
            <div class="col-3">    
                <label for="art_scorta_max">Scorta Massima:</label>
                <input class="form-control" id="art_scorta_max" type="text" size="15" name="art_scorta_max" class="form-control"/>  
            </div> 
        </div>

        <div class="row">
            <div class="col-3">    
                <label for="art_tempo_appro">Tempo Approvv.:</label>
                <input id="art_tempo_appro" type="text" size="15" name="art_tempo_appro" class="form-control"/>
            </div>
            <div class="col-3">    
                <label for="art_tipo_art">Tipo Articolo:</label>
                <input id="art_tipo_art" type="text" size="1" name="art_tipo_art" class="form-control"/>
            </div>
            <div class="col-3">
                <label for="art_trasporto" >Trasporto Articolo:</label>
                <input id="art_trasporto" type="text" size="15" maxlength="15" name="art_trasporto" class="form-control"/>
            </div> 
        </div> 

        <div class="row">
            <div class="col-3"> 
                    <input type="button" value="SALVA" class="form-control btnArticolo" >
            </div>
        </div> 
    </form>
</div>