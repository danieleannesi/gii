function chiama_prev(idt)
{
apri_win2("Gestione Preventivi","ges_prev.php?idt=" + idt);
}
//
function stampa_prev(idt)
{
apri_win2("Stampa Preventivi","stampaprev.php?idt=" + idt);
}


function elimina_doc(idt)
{
    var dati="idt=" + idt;
    request=$.ajax({
	  type: 'post',
	  url: 'elimina_preventivo.php',
	  data: dati,
	  success: function(res) {
          if(res.msg>"")
            {
            alert(res.msg);
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (elimina_preventivo.php)</p>').dialog({modal: true }); }
	});	
}

function cancella_doc(idt,numero)
{
	var html="Eliminare Preventivo Numero " + numero;
	 $("#dialogs").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							//closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
                                                        elimina_doc(idt);
                                                        document.formperdata.submit();
														$(this).dialog("close");
														},
										Annulla: function(){
														$(this).dialog("close");
														}
										}
					});

	$("#dialogs").html(html);
	$("#dialogs").dialog("open");
}

function carica_cliente(e)
{
    var dati="codice=" + e.value;
    request=$.ajax({
	  type: 'post',
	  url: 'get_cliente.php',
	  data: dati,
	  success: function(result) {
	  	  $('#paga').val(result.cf_codpag); 
	  	  $('#ali0').val(result.cf_iva);
	  	  if(result.nord>0)
	  	    {
			alert("Il Cliente ha ordini in corso: " + result.nord);
            $('#ordini').show();
			}
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    //carica_indirizzi("carica_clienti.php","lista_clienti");
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);
});

    