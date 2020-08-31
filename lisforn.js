function stampa()
{
var data_for=$('#data_for').val();
var data_ven=$('#data_ven').val();
var fornitore=$('#fornitore').val();
var h="<iframe src=\"pdf_lisforn.php?data_for=" + data_for + "&data_ven=" + data_ven  + "&fornitore=" + fornitore + "\" width=\"900px\" height=\"700px\"></iframe>";
$("#dialog").html(h).dialog({modal: true, buttons: '',title: "Stampa Listino Fornitore", width: 'auto', height:'auto'});
$("#dialog").dialog("open");
}

function carica_fornitore(e)
{
    var dati="codice=" + e.value;
    request=$.ajax({
	  type: 'post',
	  url: 'get_fornitore.php',
	  data: dati,
	  success: function(result) {
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "fornitore", ret3: "", ret4: "" }, gestisci_fornitori);        
});
