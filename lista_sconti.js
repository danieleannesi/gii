function elimina()
{
var cliente=$('#cliente').val();
var classe=$('#rclasse').val();
var codiceda=$('#dacodice').val();
var codicea=$('#acodice').val();
var unitario=parseFloat($('#unitario').val());
var sconto1=$('#sconto1').val();
var sconto2=$('#sconto2').val();
var sconto3=$('#sconto3').val();
var sconto4=$('#sconto4').val();
var sconto5=$('#sconto5').val();
var sconto6=$('#sconto6').val();
//	
if(confirm("CONFERMA ELIMINAZIONE"))
  {
var dati="classe=" + classe + "&cliente=" + cliente + "&codiceda=" + codiceda + "&codicea=" + codicea + "&unitario=" + unitario;
dati+="&sconto1=" + sconto1 + "&sconto2=" + sconto2;
dati+="&sconto3=" + sconto3 + "&sconto4=" + sconto4;
dati+="&sconto5=" + sconto5 + "&sconto6=" + sconto6;
request=$.ajax({
	  type: 'post',
	  url: 'elimina_sconti.php',
	  data: dati,
	  success: function(res) {
	     //$("#dialog").html('<p>Dati Salvati Correttamente</p>').dialog({modal: true, buttons: '',title: "Salva Dati" });
         //$("#dialog").dialog("open");
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (elimina_sconti.php)</p>').dialog({modal: true }); }
	});
  }	  
}
function modifica(classe,codiceda,codicea,unitario,sconto1,sconto2,sconto3,sconto4,sconto5,sconto6)
{
$('#rclasse').val(classe);
$('#dacodice').val(codiceda);
$('#acodice').val(codicea);
$('#unitario').val(unitario);
$('#sconto1').val(sconto1);
$('#sconto2').val(sconto2);
$('#sconto3').val(sconto3);
$('#sconto4').val(sconto4);
$('#sconto5').val(sconto5);
$('#sconto6').val(sconto6);
}

function salva()
{
var cliente=$('#cliente').val();
var classe=$('#rclasse').val();
var codiceda=$('#dacodice').val();
var codicea=$('#acodice').val();
var unitario=parseFloat($('#unitario').val());
var sconto1=$('#sconto1').val();
var sconto2=$('#sconto2').val();
var sconto3=$('#sconto3').val();
var sconto4=$('#sconto4').val();
var sconto5=$('#sconto5').val();
var sconto6=$('#sconto6').val();
var dati="classe=" + classe + "&cliente=" + cliente + "&codiceda=" + codiceda + "&codicea=" + codicea + "&unitario=" + unitario;
dati+="&sconto1=" + sconto1 + "&sconto2=" + sconto2;
dati+="&sconto3=" + sconto3 + "&sconto4=" + sconto4;
dati+="&sconto5=" + sconto5 + "&sconto6=" + sconto6;
request=$.ajax({
	  type: 'post',
	  url: 'salva_sconti.php',
	  data: dati,
	  success: function(res) {
	     //$("#dialog").html('<p>Dati Salvati Correttamente</p>').dialog({modal: true, buttons: '',title: "Salva Dati" });
         //$("#dialog").dialog("open");	  	
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_sconti.php)</p>').dialog({modal: true }); }
	});
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);    
});

    