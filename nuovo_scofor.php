<link rel="stylesheet" href="css/jquery.dataTables.min.css" type="text/css" /> 
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css" type="text/css"> 
 <script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="nuovo_scofor.js"></script>
<script type="text/javascript" src="win_idro.js"></script>
<?php
session_start();
require 'include/database.php';
require 'include/idrobox.php';

$marca[]="Seleziona la Marca";
$ql="SELECT * FROM tab_marche ORDER BY mar_codice";
$rsl=mysql_query($ql,$idr);
while($rol = mysql_fetch_assoc($rsl)) {
   $marca[]=$rol["mar_codice"] . " - " . $rol["mar_descrizione"];
   } 
?>

 
<div class="container scofor" id="detail_scofor">
   <input type="button" id="openIdro" onclick="openIdro();" value="IDROLAB"/>
    <form id="scofor" class="needs-validation">
    <input type="hidden" name="sco_id"  >
            <div class="form-row col-12">
            <label for="scf_tipo">Tipo Scofor</label><br>
                <select name="scf_tipo" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
             <div class="form-row col-12">
                <div class="col"><label for="scf_marca"> Marca</label><br>
                    <select id="scf_marca" name="scf_marca" class="form-control" required>
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
                <div class="col"><label for="listino"> Listino</label><input type="text" class="form-control form-control-sm" name="listino" placeholder="Cod. Fornitore" value="" > </div>

                <div class="col"><label for="scf_codfor"> Cod. Fornitore</label><input type="text" class="form-control form-control-sm" name="scf_codfor" placeholder="Cod. Fornitore" value="" required> </div>
            </div> 
            <div class="form-row col-12">
                <div class="col-3"><label for="scf_um">Um</label> <input type="text" class="form-control form-control-sm" name="scf_um"  value="" ></div>
                <div class="col-3"> <label for="scf_set">Set</label> <input type="text" class="form-control form-control-sm" name="scf_set" value="" ></div>
                <div class="col-3"> <label for="scf_mac">Mac</label> <input type="text" class="form-control form-control-sm" name="scf_mac" value="" ></div>
                <div class="col-3"> <label for="scf_fam">Fam</label> <input type="text" class="form-control form-control-sm" name="scf_fam" value="" ></div>
            </div> 
            <div class="form-row col-12">
                <div class="col"><label for="scf_da_articolo">Da Articolo</label> <input type="text" class="form-control form-control-sm modificabile" name="scf_da_articolo" placeholder="DA ARTICOLO" value="" ></div>
                <div class="col"> <label for="scf_a_articolo">A Articolo</label> <input type="text" class="form-control form-control-sm modificabile" name="scf_a_articolo" placeholder="A ARTICOLO" value="" ></div>
            </div>  
            <div class="form-row col-12">
                <div class="col"> <label for="scf_data_da">Data da</label>  <input type="text" class="form-control form-control-sm modificabile datepicker" name="scf_data_da" placeholder="Data da" value="" ></div>
                <div class="col"> <label for="scf_data_a">Data a</label> <input type="text" class="form-control form-control-sm modificabile datepicker" name="scf_data_a" placeholder="Data a" value="" ></div>
            </div>  
            <div class="form-row col-12">
                <div class="col"> <label for="scf_sconto_1">Sconto 1</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_1" placeholder="Sconto 1" value="" ></div>
                <div class="col"> <label for="scf_sconto_2">Sconto 2</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_2" placeholder="Sconto 2" value="" ></div>
            </div> 
            <div class="form-row col-12">
                <div class="col"> <label for="scf_sconto_3">Sconto 3</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_3" placeholder="Sconto 3" value="" ></div>
                <div class="col"> <label for="scf_sconto_4">Sconto 4</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_4" placeholder="Sconto 4" value="" ></div>
            </div> 
            <div class="form-row col-12">
                <div class="col"> <label for="scf_sconto_5">Sconto 5</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_5" placeholder="Sconto 5" value="" ></div>
                <div class="col"></div>
            </div>
            <div class="form-row col-12">
                <div class="col"><label for="scf_netto">Prezzo Netto</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_netto" placeholder="Prezzo Netto" value="" ></div>
                <div class="col"><label for="scf_lis_da_netto">List. da Netto</label><br>
                    <select name="scf_lis_da_netto"  class="modificabile form-control" >
                        <option></option>
                        <option value="S">S</option>
                        <option value="N">N</option>
                    </select>
                </div>
            </div> 
            <div class="form-row col-12">
                <div class="col"> <label for="scf_sconto_ag">Scontro Agg.Forn.</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_ag" placeholder="" value="" ></div>
                <div class="col"><label for="scf_magg_netto">%Maggiorazione</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_magg_netto" placeholder="" value="" ></div>
            </div> 
            <div class="form-row col-12">
                <div class="col"> <label for="">Di cui al cliente??</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_cliente" placeholder="" value="" ></div>
                <div class="col"><label for="scf_trasporto">Trasporto %</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_trasporto" placeholder="" value="" ></div>
            </div>
            <div class="form-row col-12">
                <div class="col"> <label for="scf_da_tabart">Da Tabart</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_da_tabart" placeholder="" value="" ></div>
                <div class="col"><label for="scf_a_tabart">A Tabart</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_a_tabart" placeholder="" value="" ></div>
            </div>
            <div class="form-row col-12">
                <div class="col"><label for="scf_ricarica">Moltiplicatore</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_ricarica" placeholder="" value="" ></div>
                <div class="col"></div>
            </div> 
            <div class="form-row col-12"> 
                <div class="col"><label for="scf_note">Note</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_note" placeholder="Note" value="" ></div>
             </div>  
            <div class="form-row col-12"> 
                <input type="submit" value="SALVA" />
            </div>
   </form>
</div> 

<div id="listiniOrdini" style="background:#ffffff;border:1px solid grey;padding:10px;"> 
    <form id="cercaListini">
        <div class="row">
            <label class="idro" for="marchio">Marchio</label>
            <select id="marchio" name="marchio">
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
          
        <div class="row">  
            <input type="button" value="CERCA LISTINI" id="cercaListini"/>
        </div>
    </form>
    <div id="result">
    </div>
</div>
 

 