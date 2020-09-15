function stampa()
{
var fornitore=$('#fornitore').val();
var da_artgi=$('#da_artgi').val();
var a_artgi=$('#a_artgi').val();
//
var h="<iframe src=\"pdf_mgsott.php?fornitore=" + fornitore + "&da_artgi=" + da_artgi + "&a_artgi=" + a_artgi + "\" width=\"900px\" height=\"700px\"></iframe>";
$("#dialog").html(h).dialog({modal: true, buttons: '',title: "Stampa Sottoscorta", width: 'auto', height:'auto'});
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
