function nuovo_articolo()
{
$("#dialog").html('<p>Conferma Nuovo Articolo</p>');
$("#dialog").show(); 
$("#dialog").dialog({
                title: "Nuovo Articolo di Magazzino",
                buttons: {
                    "SI": function () {
                              $('#formarticoli')[0].reset();
                              $('#nuovo').val(1);
                              $('#codart').removeAttr("readonly");
                              $(this).dialog('close');
                           },
                     "NO": function () {
                              $(this).dialog('close');
                            }
                },
                modal: true
            });

}

function controlla() {
    var nuovo=$('#nuovo').val();
    var codicecliente=$('#codicecliente').val();
    var cognome=$('#p_cognome').val();
    var nome=$('#p_nome').val();
    var data=$('#p_datanas').val();
    var codfisc=$('#p_codfisc').val();
    if(cognome=="" || nome=="" || data=="" || codfisc=="")
      {
	  $("#dialog").html('<p>Inserire almeno Cognome, Nome, Data di Nascita e Codice Fiscale</p>').dialog({modal: true, buttons: '' }); 
      return false;		   	
	  }
   if(nuovo==1)
     {
    var dati="codicecliente=" + codicecliente + "&codfisc=" + codfisc;
    var esiste=0;
    request=$.ajax({
	  type: 'post',
	  url: 'controlla_cliente.php',
	  data: dati,
	  async: false,
	  success: function(result) {
	  	 if(result.esiste>0)
	  	   {
	  	   esiste=1;
	       $("#dialog").html('<p>Codice Cliente gia Esistente\ndati NON Salvati</p>').dialog({modal: true, buttons: '' }); 
		   }
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (controlla_cliente.php)</p>').dialog({modal: true }); }
	});       
	 }
   if(esiste==1)
     {
	 return false;
	 }
//   
   var tutto={};
   var nome;
   var valore;
   var nometag;
   var tipo;
   for (var i=0;i<document.formclienti.elements.length;i++)
     {
    nomeint=document.formclienti.elements[i].id;
    nomenome=document.formclienti.elements[i].name;
    nometag=document.formclienti.elements[i].tagName;
    tipo=document.formclienti.elements[i].type;
    if (nometag == "INPUT") {
            if (tipo == "text") {
               valore=document.getElementById(nomeint).value;
               }
            if (tipo == "checkbox") {
               valore=0;
               if($("#" + nomeint).is(':checked'))
                 {
                 valore=1;
				 }
               //valore=document.querySelector("input[name='" + nomeint + "']:checked").value;
            }
            if (tipo == "radio") {
               valore="";
               if(document.getElementById(nomeint).checked==true)
                 {
                 valore=document.querySelector("input[name='" + nomenome + "']:checked").value;
				 }
			   if(valore=="")
			     {
				 nomenome="_buttare";
				 }
            }
         }   
         if (nometag == "SELECT") {
               valore=document.getElementById(nomeint).value;
         }    
         if (nometag == "TEXTAREA") {
               valore=document.getElementById(nomeint).value;
         }
       tutto[nomenome]=valore;
     }
    var dati_json = JSON.stringify(tutto);
    var dati="dati_json=" + dati_json + "&nuovo=" + nuovo;
    request=$.ajax({
	  type: 'post',
	  url: 'salva_cliente.php',
	  data: dati,
	  success: function(result) {
	  	  if(result.msg>"")
	  	    {
		    alert(result.msg);
		    }
          $('#cf_cod').val(result.cf_cod);
          $('#nuovo').val(0);
          $('#formclienti')[0].reset();
          $('#cf_cod').val(result.cf_cod);
	      $("#dialog").html('<p>Dati Salvati Correttamente</p>').dialog({modal: true, buttons: '' });
	      carica_indirizzi("carica_clienti.php","lista_clienti"); 
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_cliente.php)</p>').dialog({modal: true }); }
	});    
    return false;     	
}
     	
function carica_fornitore(e)
{
    var dati="codice=" + e.value;
    request=$.ajax({
	  type: 'post',
	  url: 'get_cliente.php',
	  data: dati,
	  success: function(result) {
	  	  $('#art_fornitore').val(result.cf_cod);
	  	  $('#for_ragsoc').val(result.cf_ragsoc);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     		
}

Number.prototype.toFixedNumber = function(x, base){
  var pow = Math.pow(base||10,x);
  return +( Math.round(this*pow) / pow );
}

function carica_articolo(e)
{
	var nuovo=document.getElementById("nuovo").value;
	var giace="<div class=\"giacenza\" style=\"margin-left: 12px;\">Giacenze</div>";
	var qua=0;
	if(nuovo==1)
	  {
	  return; 
	  }
    var dati="codice=" + e.value;
    request=$.ajax({
	  type: 'post', 
	  url: 'get_art.php',
	  data: dati,
	  success: function(result) { 
          document.getElementById("formarticoli").reset();
      	  $.each(result, function(campo, valore) {
      	  	//alert(campo + "=" + valore);
            $('#' + campo).val(valore);
      	  	if(campo=="art_codice")
      	  	  {
              $('#codart').val(valore);
			  }
      	  	if(campo=="art_descrizione")
      	  	  {
              $('#desart').val(valore);
			  }
      	  	if(campo=="art_data_listino")
      	  	  {
              $('#art_data_listino').val(addrizza(valore));
			  }
			 
           });
		    valori=result.depositi;
	  	  val_medio=result.val_medio;
          for(var key in result.depositi) {
          	  qua=parseFloat(result.depositi[key]["qta"]);
          	  giace+="<div class=\"giacenzadep\">" + key + ":</div>";
          	  giace+="<div class=\"giacenza\">" + qua.toFixedNumber(2) + "</div>";
              }
          giace+="<div class=\"giacenzaord\">Ordini:</div>";
          giace+="<div class=\"giacenza\">" + result.ordinato + "</div>";
          $('#giacenze').html(giace);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function addrizza(valore)
{
 return valore.substr(8,2) + "/" + valore.substr(5,2) + "/" + valore.substr(0,4);
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    carica_indirizzi("carica_fornitori.php","lista_fornitori");
    $('#for_ragsoc').bind('keyup', { ar_lista: "lista_fornitori", ret1: "for_ragsoc", ret2: "art_fornitore", ret3: "", ret4: "" }, gestisci_tasti);
    $('#codart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "", ret4: "" }, gestisci_articoli);
    $('#desart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "", ret4: "" }, gestisci_descrizione);
    var idt=$('#idt').val();
    if(idt>0)
      {
      leggi_articolo(idt);	  	
	  }	
});
