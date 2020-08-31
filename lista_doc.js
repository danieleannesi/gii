function chiama_doc(idt)
{
apri_win2("Gestione Documenti","ges_doc.php?idt=" + idt);
}
//
function pa_doc(idt)
{
//window.location.href = "fatturapa.php?idt=" + idt;
    var dati="idt=" + idt;
    request=$.ajax({
	  type: 'post',
	  url: 'fatturapa.php',
	  data: dati,
	  //async: false,
	  success: function(res) {
          if(res.msg>"")
            {
            alert(res.msg);
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (fatturapa.php)</p>').dialog({modal: true }); }
	});	
}

function stampa_doc(idt,tipo)
{
apri_win2("Stampa Documenti","stampadoc.php?idt=" + idt + "&tipo=" + tipo);
}

function elimina_doc(idt,tipodoc,cliente)
{
    var dati="idt=" + idt + "&tipodoc=" + tipodoc + "&cliente=" + cliente;
    request=$.ajax({
	  type: 'post',
	  url: 'elimina_doc.php',
	  data: dati,
	  async: false,
	  success: function(res) {
          if(res.msg>"")
            {
            alert(res.msg);
			}
		  else
		    {
			alert("Documento Eliminato");
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (elimina_doc.php)</p>').dialog({modal: true }); }
	});	
}
function cancella_doc(idt,numero,tipodoc,cliente)
{
	var html="Eliminare Documento Numero " + numero;
	 $("#dialogs").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							//closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
                                                        elimina_doc(idt,tipodoc,cliente);
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

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);    
});

    