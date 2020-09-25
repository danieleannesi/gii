function carica_articolo()
{
	var codart=$('#codart').val();
    var dati="codice=" + codart;
    request=$.ajax({
	  type: 'post',
	  url: 'get_dati_articolo.php',
	  data: dati,
	  success: function(result) {
     	    $('#modifica').val(1);
     	    $('#art_fornitore').val(result.mgf_codfor);
     	    $('#mgf_cod_for').val(result.mgf_codprod);
     	    $('#codArt').val(result.mgf_codprod);
     	    $('#art_codice').val(result.art_codice);
     	    $('#art_descrizione').val(result.art_descrizione);
     	    $('#art_uni_mis').val(result.art_uni_mis);
     	    $('#art_classe_merc').val(result.art_classe_merc);
     	    $('#art_listino1').val(result.art_listino1);
     	    $('#art_listino2').val(result.art_listino2);
     	    $('#art_data_listino').val(result.art_data_listino.substr(8,2) + "/" + result.art_data_listino.substr(5,2) + "/" + result.art_data_listino.substr(0,4));
     	    $('#mgf_listino1').val(result.mgf_pr_listino);
     	    $('#mgf_listino2').val(result.mgf_pr_listino2);
     	    
     	    $('#mgf_data_listino').val(result.mgf_data_listino.substr(8,2) + "/" + result.mgf_data_listino.substr(5,2) + "/" + result.mgf_data_listino.substr(0,4));
     	    $('#mgf_sconto1').val(result.mgf_sconto);
     	    $('#mgf_sconto2').val(result.mgf_sconto2);
     	    $('#mgf_data_sconto').val(result.mgf_data_sconto.substr(8,2) + "/" + result.mgf_data_sconto.substr(5,2) + "/" + result.mgf_data_sconto.substr(0,4));
     	    $('#art_codice_raee').val(result.art_codice_raee);
     	    $('#art_uni_mis').val(result.art_uni_mis);
     	    $('#art_classe_merc').val(result.art_classe_merc);
     	    $('#art_cod_iva').val(result.art_cod_iva);
     	    $('#art_scorta_min').val(result.art_scorta_min);
     	    $('#art_scorta_max').val(result.art_scorta_max);
     	    $('#art_tempo_appro').val(result.art_tempo_appro);
     	    $('#art_tipo_art').val(result.art_tipo_art);
     	    $('#art_trasporto').val(result.art_trasporto);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;
}
//
function articolo_manuale()
{
$('#insertArticolo').show();
}

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

    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "art_fornitore", ret3: "", ret4: "" }, gestisci_fornitori);
    $('#codart').bind('keyup', { ar_lista: "lista_articoli", ret1: "art_descrizione", ret2: "codart", ret3: "", ret4: "" }, gestisci_articoli);

    var options_rag = {
      callback: function () { $('#ragsoc').val($('#art_fornitore').val()); $('#ragsoc').trigger('keyup'); },
      wait: 750,
      highlight: true,
      allowSubmit: false,
      captureLength: 2
      }
    $("#art_fornitore").typeWatch( options_rag );  
    
    var options_art = {
      callback: function () { $('#codart').val($('#test_art').val()); $('#codart').trigger('keyup'); },
      wait: 750,
      highlight: true,
      allowSubmit: false,
      captureLength: 2
      }
    $("#test_art").typeWatch( options_art );      

});