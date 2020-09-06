$(document).ready(function() {
    $('.datepicker').datepicker({dateFormat: 'dd/mm/yy'});
    $('#insertArticolo').hide();
    $("#searchIdrobox").on("click", function(){
        $('#insertArticolo').hide();
        $("#result").empty();

        $.ajax({
            type: 'post',
            url: 'search_idrobox.php',
            data:  $("#searchIdro").serialize(),
            async: false,
            success: function(res) {

                if(!res.success){
                    alert(res.msg);
                } else {
                    var header = "<table id='resArticolo'><thead><th></th><th>Marca</th><th>Codice</th><th>Descrizione</th><th>Um</th><th>Set</th><th>Mac. Fam.</th><th>Famiglia</th><th>Confezione</th><th>Prezzo Lis.</th><th>Data Lis.</th></thead><tbody></tbody></table>"; 
                    $("#result").append(header);
                    $(res.dati).each(  function() { 
                        var riga = "<tr><td><input type='button' class='btnSelect' value='SELEZIONA' ></td><td>"+this.mar_codice+"</td><td>"+this.art_codiceproduttore+"</td><td>"+this.art_descrizioneridotta+"</td><td>"+this.art_um+"</td><td>"+this.set_codice+"</td><td>"+this.mac_codice+"</td><td>"+this.fam_codice+"</td><td>"+this.art_conf+"</td><td>"+this.lis_prezzoeuro1+"</td><td>"+this.lis_datalistino+"</td></tr>";
                        $("#resArticolo tbody").append(riga);  
                    }); 
                }
            },
            error: function(xhr, ajaxOptions, thrownError) { 
                alert(xhr.responseText); 
                $("#dialog").html('<p>Errore (search_idrobox.php)</p>').dialog({modal: true });
             }
        });   
    });

    $("#result").on("click","input.btnSelect" , function(){ 
         
            var cod_prod = $(this).closest('tr').find('td:eq(2)').text();
            var descr = $(this).closest('tr').find('td:eq(3)').text();
            var art_uni_mis = $(this).closest('tr').find('td:eq(4)').text();
            var art_listino1 = $(this).closest('tr').find('td:eq(9)').text();
            $("input[name=art_fornitore]").val(cod_prod); 
            $("input[name=art_descrizione]").val(descr); 
            $("input[name=art_uni_mis]").val(art_uni_mis);
            $("input[name=art_listino1]").val(art_listino1); 
            $('#insertArticolo').show();
        
    });

    $("#insertArticolo").on("click","input.btnArticolo" , function(){ 
        var size_codice = $("input[name=art_codice]").val().length;
        if(size_codice == 11){
            $.ajax({
                type: 'post',
                url: 'save_articolo.php',
                data:  $("#formArticolo").serialize(),
                async: false,
                success: function(res) { 
                     alert("Articolo inserito correttamente");
                },
                error: function(xhr, ajaxOptions, thrownError) { 
                    alert(xhr.responseText); 
                    $("#dialog").html('<p>Errore (search_idrobox.php)</p>').dialog({modal: true });
                 }
            });   
        } else {
            alert("Codice Articolo deve essere di 11 caratteri");
        }
       
         
    
    });
    


});