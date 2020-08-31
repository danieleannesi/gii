function chiama_ordi(idt)
{
apri_win2("Gestione Ordini","ges_ord.php?idt=" + idt);
}
//
function stampa_ordi(idt)
{
apri_win2("Stampa Ordini","stampaord.php?idt=" + idt);
}

function elimina_doc(idt)
{
    var dati="idt=" + idt;
    request=$.ajax({
	  type: 'post',
      async: false,
	  url: 'elimina_ordine.php',
	  data: dati,
	  success: function(res) {
          if(res.msg>"")
            {
            alert(res.msg);
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (elimina_ordine.php)</p>').dialog({modal: true }); }
	});	
}

function cancella_doc(idt,numero)
{
	var html="Eliminare Ordine Numero " + numero;
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

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);    
});

    