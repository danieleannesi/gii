 
 
function openIdro(){
    $("#listiniOrdini").dialog("open");
}
 

 

$(document).ready(function () {   
    $('.datepicker').datepicker({dateFormat: 'dd/mm/yy'});
    $(function () {  
        $("#cercaListini").on("click", function(){
            var dati = $("#cercaListini").serialize();
            $("#result").empty();
            $.ajax({
                type: "post",
                url: "listiniIdro.php",
                data: dati, 
                async: false,	  
                success: function(res){
                   if(res.success){
                       var header = "<table id='listini'><thead><th>Codice</th><th>Marca</th><th>Listino</th><th>Data Validita'</th><th>Valido</th></thead><tbody></tbody></table>"; 
                       $("#result").append(header);
                       $(res.dati).each(  function() { 
                            var riga = "<tr><td>"+ this.art_catsc + "</td>"+
                            "<td>"+ this.mar_codice + "</td>"+
                            "<td>"+ this.lcr_descrizione + "</td>"+
                            "<td>"+ this.lcr_data + "</td>"+
                            "<td>"+ this.lcr_lisvalido + "</td>"+
                            "<td><input type='button' class='btnSelectMarca' value='Seleziona' ></td></tr>"; 
                            $("#listini tbody").append(riga);
                        });
                        
                   }   
                    
                }
            });
        });
    });
 

    $(function () {  
        $("#listiniOrdini").dialog({
            autoOpen: false,
            width: 500,
            modal: true,
            title: "Ricerca Listini Idro",  
        });

        $("#listiniOrdini").css("display", "none");
        
    });

    $("#listiniOrdini").on("click", "input.btnSelectMarca", function(){
        var marca = $(this).closest('tr').find('td:eq(1)').text();
        var listino = $(this).closest('tr').find('td:eq(2)').text();
        $("#scf_marca").val(marca);
        $("input[name=listino]").val(listino);
        $("#listiniOrdini").dialog("close");
    });
    
    $('#scofor').submit(function (event) {
        var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                    
                Array.prototype.filter.call(forms, function (form) {
            
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        var dati = $('#scofor').serialize();
                        event.preventDefault();
                        $.ajax({
                            type: "post",
                            url: "salva_scofor.php",
                            data: dati, 
                            async: false,	  
                            success: function(res){
                                if(res.success){
                                    $("input[name=sco_id]").val(res.sco_id);   
                                } else {
                                    alert("Errore: "+res.msg);
                                }
                                 
                            } 
                        });
            
                    }
                    form.classList.add('was-validated');
                    
                });
 
      });
});