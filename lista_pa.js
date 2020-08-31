function stampa_doc(idt,tipo)
{
apri_win2("Stampa Documenti","stampadoc.php?idt=" + idt + "&tipo=" + tipo);
}

function clista()
{
	var tutti=document.getElementById("tutti").checked;
    for (var i=0;i<document.formperdata.elements.length;i++)
      {
      nomeint=document.formperdata.elements[i].id;
      nometag=document.formperdata.elements[i].tagName;
      tipo=document.formperdata.elements[i].type;
      if(nometag == "INPUT") {
         if(tipo == "checkbox") {
           document.getElementById(nomeint).checked=tutti;
		   }
		 }
	  }
}

function fatturepa()
{
   for (var i=0;i<document.formperdata.elements.length;i++)
     {
    nomeint=document.formperdata.elements[i].id;
    nomenome=document.formperdata.elements[i].name;
    nometag=document.formperdata.elements[i].tagName;
    tipo=document.formperdata.elements[i].type;
    if (nometag == "INPUT") {
       if (tipo == "checkbox") {
           valore="";
           if(document.getElementById(nomeint).checked==true)
             {
             valore=document.querySelector("input[name='" + nomeint + "']:checked").value;	
    var dati="idt=" + valore;
    request=$.ajax({
	  type: 'post',
	  url: 'fatturapa.php',
	  data: dati,
	  async: false,
	  success: function(res) {
          if(res.msg>"")
            {
            alert(res.msg);
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (fatturapa.php)</p>').dialog({modal: true }); }
	});	
            } //if checked 
      } //if checkbox
    } //if input
  } //fine for
alert("FINE GENERAZIONE FATTURE ELETTRONICHE");  
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);    
});

    