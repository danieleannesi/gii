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
    <div class="row"> 
      <div class="col-4">
        <label for="deposito">Deposito</label>
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
      <div class="col-4">
        <label for="art_fornitore">Codice Fornitore:</label> 
        <input id="art_fornitore" type="text" size="8" name="art_fornitore" required /> 
      </div>
      <div class="col-4">
          <input type="button" id="stampa" name="stampa" value="STAMPA">
      </div> 
    </div>
    </form>
</div>
<?php
 require_once "footer.php";
?> 
