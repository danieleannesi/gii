function stampa()
{
var fornitore=$('#fornitore').val();
var da_artfo=$('#da_artfo').val();
var a_artfo=$('#a_artfo').val();
var da_artgi=$('#da_artgi').val();
var a_artgi=$('#a_artgi').val();
var data_val_acq=$('#data_val_acq').val();
var data_val_ven=$('#data_val_ven').val();
var aggiorna=$('#aggiorna').prop("checked");
var descri=$('#descri').prop("checked");
var prefisso=$('#prefisso').prop("checked");
var soloforni=$('#soloforni').prop("checked");
var solocli=$('#solocli').prop("checked");
var evita=$('#evita').prop("checked");
//
var h="<iframe src=\"pdf_lis101.php?fornitore=" + fornitore + "&da_artfo=" + da_artfo + "&a_artfo=" + a_artfo + "&da_artgi=" + da_artgi + "&a_artgi=" + a_artgi + "&data_val_acq=" + data_val_acq + "&data_val_ven=" + data_val_ven + "&aggiorna=" + aggiorna + "&descri=" + descri + "&prefisso=" + prefisso + "&soloforni=" + soloforni + "&solocli=" + solocli + "&evita=" + evita + "\" width=\"900px\" height=\"700px\"></iframe>";
$("#dialog").html(h).dialog({modal: true, buttons: '',title: "Listino Fornitore da Idrobox", width: 'auto', height:'auto'});
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
