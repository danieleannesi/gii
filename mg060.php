<?php
 require_once "header.php";


//
$marca[]="Seleziona la Marca";
$ql="SELECT * FROM tab_marche ORDER BY mar_codice";
$rsl=mysql_query($ql,$idr);
while($rol = mysql_fetch_assoc($rsl)) {
   $marca[]=$rol["mar_codice"] . " - " . $rol["mar_descrizione"];
}

?> 
<script type="text/javascript">
  $(document).ready(function() { 
    $("#ragsoc").autocomplete({
      source: function( request, response ) {
        $.ajax( {
            url: "get_anagrafica_byname.php", 
            data: {
              ragsoc: request.term,
              tipo: 9
            }, 
            type: "GET",
            success: function (data) { 
              var res = jQuery.parseJSON(data);
              response($.map(res, function (i) {
                  return {
                      value: i.cod,
                      label: i.ragsoc
                  };
              }));
            }             
        });
      },
      minLength: 4,
      select: function (event, ui) {
          $('#art_fornitore').val(ui.item.value);
          $("#ragsoc").val(ui.item.label);
          return false;
      }  
    });
	
      $(".inventario").on("click","input#stampa", function(){
        var art_fornitore = $("#art_fornitore").val();
        if(art_fornitore){
          var dati = $("#formperdata").serialize();
          window.location.assign("stampa_mg060.php?"+dati);
        }
      }); 
  });
</script>
<div class="container inventario">
  <form method='POST' id='formperdata' name='formperdata'> 
    <div class="form-group">
        <div class="row">
          <div class="col-3">
            <label for="deposito">Deposito</label>
          </div>
          <div class="col-4">
              <select id="deposito" name="deposito">
              <?php
              $j=0;
              while(isset($coddep[$j])) {
                echo "<option value=\"$coddep[$j]\"";
                if($deposito==$coddep[$j]) { echo " selected"; };
                echo ">" . $desdep[$j] . "</option>";
                $j++;
                }
              ?>
              </select>
          </div> 
        </div>
        <div class="row">
          <div class="col-3">
             <label for="art_fornitore">Codice Fornitore:</label> 
          </div>
          <div class="col-6"> 
            <input id="art_fornitore" name="art_fornitore" type="text"size="9" maxlength="8" value="<?php echo $fornitore;?>" readonly>
            <input name="ragsoc"  id="ragsoc" type="text" size="90" value="<?php echo $ragsoc;?>"> 
          </div>
        </div>  
        <div class="row">
          <div class="col-3">
              <label>Saldi Negativi</label><input type="checkbox" name="negativi" >
            </div>
        </div>
        <div class="row">
          <div class="col-3">
              <label>Solo Saldi</label><input type="checkbox" name="saldi" >
            </div>
        </div>
        <div class="row">
          <div class="col-4">
              <input type="button" class="btn btn-primary btn-lg btn-block" id="stampa" name="stampa" value="STAMPA">
          </div> 
        </div>
      </div>
    </form>
</div>
<?php
 require_once "footer.php";
?> 
