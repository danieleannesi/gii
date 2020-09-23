$(document).ready(function() {
    $('.datepicker').datepicker({dateFormat: 'dd/mm/yy'});
    $('#insertArticolo').hide();
    $("#searchIdrobox").on("click", function(){
        $('#insertArticolo').hide();
        $("#result").empty();

        $.ajax({
            type: 'post',
            url: 'search_idrobox.php',
            data:  $("#formArticolo").serialize(),
            async: false,
            success: function(res) {

                if(!res.success){
                    alert("errore " + res.msg);
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
            var marca = $(this).closest('tr').find('td:eq(1)').text();
            var cod_prod = $(this).closest('tr').find('td:eq(2)').text();
            var dati="marca=" + marca + "&codiceproduttore=" + cod_prod;
            $.ajax({
                type: 'post',
                url: 'per_scofor.php',
                data: dati,
                success: function(res) {
                    $("input[name=art_fornitore]").val(res.codfor);
                    $("input[name=art_descrizione]").val(res.descri); 
                    $("input[name=art_uni_mis]").val(res.articolo.art_uni_mis);
                    $("input[name=art_scorta_min]").val(res.articolo.art_scorta_min);
                    $("input[name=art_scorta_max]").val(res.articolo.art_scorta_max);
                    $("input[name=art_codice_raee]").val(res.articolo.art_codice_raee);
                    $("input[name=art_tempo_appro]").val(res.articolo.art_tempo_appro);
                    $("input[name=art_tipo_art]").val(res.articolo.art_tipo_art);
                    $("input[name=art_trasporto]").val(res.articolo.art_trasporto);
                    $("input[name=art_cod_iva]").val(res.articolo.art_cod_iva);
                    $("input[name=mgf_listino1]").val(res.cal_prezzo); 
                    $("input[name=mgf_listino2]").val(res.cal_prezzo); 
                    $("input[name=art_listino1]").val(res.listino); 
                    $("input[name=art_listino2]").val(res.listino); 
                    $("input[name=art_data_listino]").val(res.oggi); 
                    $("input[name=mgf_data_listino]").val(res.oggi); 
                    $("input[name=mgf_sconto1]").val(res.sconto_for); 
                    $("input[name=mgf_sconto2]").val(res.sconto_for); 
                    $("input[name=mgf_data_sconto]").val(res.oggi); 

                    $('#insertArticolo').show();
                }
            });
        
    });

    $("#insertArticolo").on("click","input.btnArticolo" , function(){ 
        var size_codice = $("input[name=art_codice]").val().length;
        if(size_codice == 10){
            $.ajax({
                type: 'post',
                url: 'save_articolo.php',
                data:  $("#formArticolo").serialize(),
                async: false,
                success: function(res) { 
                     if(res.success)
                       {
                       alert("Articolo inserito correttamente");
					   }
					 else
					   {
					   alert("Errore: " + res.msg);
					   }
                },
                error: function(xhr, ajaxOptions, thrownError) { 
                    alert("aaa" + xhr.responseText); 
                    $("#dialog").html('<p>Errore (save_articolo.php)</p>').dialog({modal: true });
                 }
            });   
        } else {
            alert("Codice Articolo deve essere di 10 caratteri");
        }
    
    });
    


});