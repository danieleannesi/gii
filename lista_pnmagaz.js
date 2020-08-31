function chiama_pnmagaz(idt)
{
apri_win2("Gestione Movimenti di Magazzino","ges_magaz.php?idt=" + idt);
}
//

function elimina_pnmagaz(idt,tipodoc,cliente)
{
    var dati="idt=" + idt;
    request=$.ajax({
	  type: 'post',
	  url: 'elimina_pnmagaz.php',
	  data: dati,
	  success: function(res) {
          if(res.msg>"")
            {
            alert(res.msg);
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (elimina_doc.php)</p>').dialog({modal: true }); }
	});	
}
function cancella_doc(idt)
{
	var html="Eliminare Movimento di Magazzino";
	 $("#dialogs").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							//closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
                                                        elimina_pnmagaz(idt);
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
    $('#codart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_articoli);
    $('#desart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_descrizione);    
});

    