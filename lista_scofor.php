<link rel="stylesheet" href="css/jquery.dataTables.min.css" type="text/css" /> 
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css" type="text/css">
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>  
<script type="text/javascript" src="lista_scofor.js"></script>
 
    <table id="table_scofor" class="display">
        <thead>
            <tr>
                <th></th>
                <th>Marca</th>
                <th>Tipo</th> 
                <th>Listino</th> 
                <th>Cod. For</th>
                <th>Da articolo</th>
                <th>A articolo</th>
            </tr>
        </thead> 
    </table>
     
    <div class="container scofor" id="detail_scofor" style="display:none;"> 
            <input type="hidden" name="sco_id" value="">
            <div class="form-row col-8">
                <div class="col"><label for="scf_marca"> Marca</label><input type="text" class="form-control form-control-sm" name="scf_marca" value="" disabled> </div>
                <div class="col"><label for="scf_codfor"> Cod. Fornitore</label><input type="text" class="form-control form-control-sm" name="scf_codfor" placeholder="Cod. Fornitore" value="" disabled> </div>
            </div> 
            <div class="form-row col-8">
                <div class="col-3"><label for="scf_um">Um</label> <input type="text" class="form-control form-control-sm" name="scf_um"  value="" disabled></div>
                <div class="col-3"> <label for="scf_set">Set</label> <input type="text" class="form-control form-control-sm" name="scf_set" value="" disabled></div>
                <div class="col-3"> <label for="scf_mac">Mac</label> <input type="text" class="form-control form-control-sm" name="scf_mac" value="" disabled></div>
                <div class="col-3"> <label for="scf_fam">Fam</label> <input type="text" class="form-control form-control-sm" name="scf_fam" value="" disabled></div>
            </div> 
            <div class="form-row col-8">
                <div class="col"><label for="scf_da_articolo">Da Articolo</label> <input type="text" class="form-control form-control-sm modificabile" name="scf_da_articolo" placeholder="DA ARTICOLO" value="" disabled></div>
                <div class="col"> <label for="scf_a_articolo">A Articolo</label> <input type="text" class="form-control form-control-sm modificabile" name="scf_a_articolo" placeholder="A ARTICOLO" value="" disabled></div>
            </div>  
            <div class="form-row col-8">
                <div class="col"> <label for="scf_data_da">Data da</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_data_da" placeholder="Data da" value="" disabled></div>
                <div class="col"> <label for="scf_data_a">Data a</label> <input type="text" class="form-control form-control-sm modificabile" name="scf_data_a" placeholder="Data a" value="" disabled></div>
            </div>  
            <div class="form-row col-8">
                <div class="col"> <label for="scf_sconto_1">Sconto 1</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_1" placeholder="Sconto 1" value="" disabled></div>
                <div class="col"> <label for="scf_sconto_2">Sconto 2</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_2" placeholder="Sconto 2" value="" disabled></div>
            </div> 
            <div class="form-row col-8">
                <div class="col"> <label for="scf_sconto_3">Sconto 3</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_3" placeholder="Sconto 3" value="" disabled></div>
                <div class="col"> <label for="scf_sconto_4">Sconto 4</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_4" placeholder="Sconto 4" value="" disabled></div>
            </div> 
            <div class="form-row col-8">
                <div class="col"> <label for="scf_sconto_5">Sconto 5</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_5" placeholder="Sconto 5" value="" disabled></div>
                <div class="col"></div>
            </div>
            <div class="form-row col-8">
                <div class="col"><label for="scf_netto">Prezzo Netto</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_netto" placeholder="Prezzo Netto" value="" disabled></div>
                <div class="col"><label for="scf_lis_da_netto">List. da Netto</label><br>
                    <select name="scf_lis_da_netto"  class="modificabile form-control">
                        <option></option>
                        <option value="S">S</option>
                        <option value="N">N</option>
                    </select>
                </div>
            </div> 
            <div class="form-row col-8">
                <div class="col"> <label for="scf_sconto_ag">Scontro Agg.Forn.</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_sconto_ag" placeholder="" value="" disabled></div>
                <div class="col"><label for="scf_magg_netto">%Maggiorazione</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_magg_netto" placeholder="" value="" disabled></div>
            </div> 
            <div class="form-row col-8">
                <div class="col"> <label for="">Di cui al cliente??</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_cliente" placeholder="" value="" disabled></div>
                <div class="col"><label for="scf_trasporto">Trasporto %</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_trasporto" placeholder="" value="" disabled></div>
            </div>
            <div class="form-row col-8">
                <div class="col"> <label for="scf_da_tabart">Da Tabart</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_da_tabart" placeholder="" value="" disabled></div>
                <div class="col"><label for="scf_a_tabart">A Tabart</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_a_tabart" placeholder="" value="" disabled></div>
            </div>
            <div class="form-row col-8">
                <div class="col"><label for="scf_ricarica">Moltiplicatore</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_ricarica" placeholder="" value="" disabled></div>
                <div class="col"></div>
            </div> 
            <div class="form-row col-8"> 
                <div class="col"><label for="scf_note">Note</label>  <input type="text" class="form-control form-control-sm modificabile" name="scf_note" placeholder="Note" value="" disabled></div>
             </div>  
            
        </div> 

