<link rel="stylesheet" href="css/jquery.dataTables.min.css" type="text/css" /> 
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css" type="text/css">
<script type="text/javascript" src="include/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="include/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>  
<script type="text/javascript" src="anagrafica_cl.js"></script>

<?php
require 'include/database.php';
require_once 'leggi_codici.php';
session_start();
if(!isset($_SESSION["iddu"])){
  exit;
  }
$iddu=$_SESSION["iddu"];
$deposito=$_SESSION["deposito"];
$utente=$_SESSION["ute"]; 

//dropdown province
$province = "";
$qr="SELECT id_province, sigla_province FROM province ";
$rst=mysql_query($qr,$con);
while($row = mysql_fetch_assoc($rst)) {
    $province .="<option value='$row[id_province]'>$row[sigla_province]</option>";
} 
?>

<table id="table_anagrafica" class="display">
        <thead>
            <tr>
                <th></th>
                <th>Codice</th>
                <th>Tipo</th> 
                <th>Ragione Sociale</th> 
                <th>Piva</th>
                <th>Codice Fiscale</th>
                <th>Telefono</th>
            </tr>
        </thead> 
    </table>
    
<div class="detail" id="detailAnagrafica">  
    <form id="anag_cl" class="needs-validation">
        <input type="hidden" value="1" name="cf_cli_for" />
        <input type="hidden" value="<?php echo $utente; ?>" name="utente" />
        <div class="row">
             <div class="col-6"><label for="cf_cod">Codice Cliente </label><input type="text" class="form-control form-control-sm" name="cf_cod" value="" readonly> </div> 
            <div class="col-6"><label for="cf_tipo">Tipo</label><br>
                    <select name="cf_tipo" id="cf_tipo" required>
                        <option value=""></option>
                        <option value="G">G</option>
                        <option value="F">F</option> 
                    </select>
            </div> 
        </div> 
        <div class="row">
            <div class="col-12"><label for="cf_ragsoc">RAGIONE SOCIALE</label><input type="text" class="form-control form-control-sm" name="cf_ragsoc" value="" required> </div>
        </div>
        <div class="row">
            <div class="col-6"><label for="cf_cognome">Cognome</label><input type="text" class="form-control form-control-sm" name="cf_cognome" value="" > </div> 
            <div class="col-6"><label for="cf_nome">Nome</label><input type="text" class="form-control form-control-sm" name="cf_nome" value=""> </div> 
       </div>
       <div class="row">
            <div class="col-6"><label for="cf_piva">P.IVA</label><input type="text" class="form-control form-control-sm" name="cf_piva" value=""> </div> 
            <div class="col-6"><label for="cf_codfisc">Codice Fiscale</label><input type="text" class="form-control form-control-sm" name="cf_codfisc" value=""> </div> 
       </div>
       <div class="row">
            <div class="col-6"><label for="cf_localita">Citta</label><input type="text" class="form-control form-control-sm" name="cf_localita" value=""> </div> 
            <div class="col-3"><label for="cf_cap">Cap</label><input type="text" class="form-control form-control-sm" name="cf_cap" value=""> </div> 
            <div class="col-3"><label for="cf_prov">Provincia</label><br>
            <select name="cf_prov" id="province">
                <option value="">--</option>
                <?php echo $province; ?>
            </select></div>  
       </div>
       <div class="row">
            <div class="col-12"><label for="cf_indirizzo">Indirizzo</label><input type="text" class="form-control form-control-sm" name="cf_indirizzo" value="" > </div> 
       </div>
       <div class="row">
            <div class="col-6"><label for="cf_telefono">Telefono</label><input type="text" class="form-control form-control-sm" name="cf_telefono" value="" > </div> 
            <div class="col-6"><label for="cf_fax">Fax</label><input type="text" class="form-control form-control-sm" name="cf_fax" value=""> </div> 
       </div>
       <div class="row">
            <div class="col-6"><label for="cf_email">Email</label><input type="text" class="form-control form-control-sm" name="cf_email" value=""> </div> 
            <div class="col-6"><label for="cf_pec">Pec</label><input type="text" class="form-control form-control-sm" name="cf_pec" value=""> </div> 
       </div> 
        <div class="row">
            <div class="col-6"><label for="cf_iva">Iva</label>
                <select id="cf_iva" name="cf_iva" class="piccolo">
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
            <div class="col-6"><label for="cf_codice_unico">Codice Univoco</label><input type="text" class="form-control form-control-sm" name="cf_codice_unico" value=""> </div> 
        </div>
        <div class="row">
            <div class="col-6"><label for="cf_rif_uff_acquisti">Rif. Uff. Acquisti</label><input type="text" class="form-control form-control-sm" name="cf_rif_uff_acquisti" value=""> </div> 
            <div class="col-6"><label for="cf_rif_ammi">Rif. Amministrativi</label><input type="text" class="form-control form-control-sm" name="cf_rif_ammi" value=""> </div> 
        </div>
        <div class="row">
            <div class="col-6"><label for="cf_banca">Banca</label><input type="text" class="form-control form-control-sm" name="cf_banca" value=""> </div> 
            <div class="col-6"><label for="cf_iban">IBAN</label><input type="text" class="form-control form-control-sm" name="cf_iban" value=""> </div> 
        </div>
       <!-- fine amministrativi -->
        
       <div class="row">
            <div class="col-4">
            <label for="cf_agente">Agente</label><br>
            <select id="cf_agente" name="cf_agente">
                <?php
                $h=0;
                while(isset($codage[$h])) {
                    echo "<option value=\"$codage[$h]\"";
                    if($agente==$codage[$h]) { echo " selected"; };
                    echo ">" . $desage[$h] . "</option>";
                    $h++;
                    }
                ?>
            </select>
            </div>
       </div> 
    </form>
    
</div>