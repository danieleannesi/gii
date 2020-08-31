function calcola_cf() {
	var cognome=$('#p_cognome').val();
	var nome=$('#p_nome').val();
	var datanas=$('#p_datanas').val();
	var comunenas=$('#dcomunenas').val();
    var sesso="M";
	if($('#maschio').prop('checked'))
	  {
	  sesso="M";
	  }
	if($('#femmina').prop('checked'))
	  {
	  sesso="F";
	  }
	var dati="cognome=" + cognome + "&nome=" + nome + "&datanas=" + datanas + "&comunenas=" + comunenas + "&sesso=" + sesso;
    request=$.ajax({
	  type: 'post',
	  url: 'calcola_cf.php',
	  data: dati,
	  async: false,
	  success: function(result) {
           if(result.errore==0)
             {
             $('#p_codfisc').val(result.codfisc);
			 }
		},
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (calcola_cf.php)</p>').dialog({modal: true }); }
	});   
}
function nuovo_cliente()
{
$("#dialog").html('<p>Conferma Nuova Anagrafica</p>');
$("#dialog").show(); 
$("#dialog").dialog({
                title: "Nuova Anagrafica",
                buttons: {
                    "SI": function () {
                              $('#formclienti')[0].reset();
                              $('#nuovo').val(1);
                              $('#cf_cod').removeAttr("readonly");
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
     	
function carica()
{
var codice=document.getElementById("codicecliente").value;
if(codice!="")
  {
    request=$.ajax({
	  type: 'post',
	  url: 'leggi_cliente.php',
	  data: 'codice=' + codice,
	  success: function(result) 
	      { 
      	  $.each(result.dati, function(campo, valore) {
      	  	if(campo=="p_sesso")
      	  	  {
			  if(valore=="M") { $('#maschio').attr('checked', true); }
			  if(valore=="F") { $('#femmina').attr('checked', true); }
			  if(valore=="N") { $('#non').attr('checked', true); }
			  }
			else
			  {
              $('#' + campo).val(valore);
			  }
           });
	      $("#p_note").resizable({ });    
	      $("#p_note2").resizable({ });    
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (leggi_cliente.php)</p>').dialog({modal: true }); }
	});    

  }
}

function carica_cliente(e)
{
	var nuovo=document.getElementById("nuovo").value;
	if(nuovo==1)
	  {
	  return;
	  }
    var dati="codice=" + e.value;
    request=$.ajax({
	  type: 'post',
	  url: 'get_cliente.php',
	  data: dati,
	  success: function(result) {
          document.getElementById("formclienti").reset();
      	  $.each(result, function(campo, valore) {
      	  	if(campo=="cf_tipo")
      	  	  {
	  	      if(result.cf_tipo=="G") { document.getElementById("giuridica").checked=true; }
	  	      if(result.cf_tipo=="M") { document.getElementById("maschio").checked=true; }
	  	      if(result.cf_tipo=="F") { document.getElementById("femmina").checked=true; }
			  }
			 
			  {
              $('#' + campo).val(valore);
			  }

            if(result.cf_add_imballo==1) { document.getElementById("cf_add_imballo").checked=true; }
            if(result.cf_add_sp_inc==1) { document.getElementById("cf_add_sp_inc").checked=true; }
            if(result.cf_no_ec==1) { document.getElementById("cf_no_ec").checked=true; }
            if(result.cf_fatt_separate==1) { document.getElementById("cf_fatt_separate").checked=true; }
            if(result.cf_rb_unicacig==1) { document.getElementById("cf_rb_unicacig").checked=true; }
           });
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });	
    $('#nav').addClass('hiding');
    carica_indirizzi("carica_clienti.php","lista_clienti");
    $('#cf_ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "cf_ragsoc", ret2: "cf_cod", ret3: "", ret4: "" }, gestisci_tasti);    carica_indirizzi("carica_citta.php","lista_citta");
    $('#cf_localita').bind('keyup', { ar_lista: "lista_citta", ret1: "cf_localita", ret2: "cf_clocalita" }, gestisci_tasti);
    carica_indirizzi("carica_nazioni.php","lista_nazioni");
    $('#cf_nazione').bind('keyup', { ar_lista: "lista_nazioni", ret1: "cf_nazione", ret2: "cf_cnazione" }, gestisci_tasti);
            
});
