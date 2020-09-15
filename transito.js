id = new Array();
qta = new Array();
cod = new Array();
desc = new Array();
iva = new Array();
uni = new Array();
tot = new Array();
sco = new Array();
data_final = new Array();
data_fattura = new Array();
num_fattura = new Array();

var totale_imponibile;

Number.prototype.toFixedNumber = function(x, base){
  var pow = Math.pow(base||10,x);
  return +( Math.round(this*pow) / pow );
}

function ricalcola(j)
{
var a="r" + j;
qta[j]=parseFloat(document.getElementById(a).value);
//disegna_tabella();
}

function calcola_totali() {
   totale_imponibile=0;
   for(j=0;j<tot.length;j++)
     {
     totale_imponibile+=parseFloat(tot[j]);
     }
   document.getElementById("totale_fattura").value=totale_imponibile;
}

function disegna_tabella() {
   	var righe="";
   	var totale=0;
    for(j=0;j<qta.length;j++){
       	totale=parseFloat(tot[j]).toFixed(2);
       	var data=data_fattura[j].substr(8,2) + "/" + data_fattura[j].substr(5,2) + "/" + data_fattura[j].substr(0,4);
       	var dataf=data_final[j].substr(8,2) + "/" + data_final[j].substr(5,2) + "/" + data_final[j].substr(0,4);
       	righe = righe + "<tr id='row"+j+"' class='r'><td>" + cod[j] + "</td><td>" + desc[j] + "</td><td class='r'><input id='r" + j +"' type='number' value='"      + qta[j] + "' onblur='ricalcola(" + j + ");'></td><td class='r'>" + uni[j] + "</td><td class='r'>"  + sco[j] + "</td><td class='r'>" + totale + "</td><td class='r'>" + data + "</td><td class='r'>" + num_fattura[j] + "</td><td class='r'>" + dataf + "</td></tr>";
	}

    tabella="<table id='righedoc'>";
    tabella=tabella + "<colgroup><col span='1' style='width: 80px;'><col span='1' style='width: 500px;'><col span='1' style='width: 50px; text-align: right;'><col span='1' style='width: 80px; text-align: right;'><col span='1' style='width: 60px; text-align: right;'><col span='1' style='width: 80px;'><col span='1' style='width: 30px;'><col span='1' style='width: 10px;'><col span='1' style='width: 10px;'></colgroup>";
    tabella=tabella + righe + "</table>";
    document.getElementById("righedoc").innerHTML=tabella;
    calcola_totali();
}

function confer()
{
dataf=document.getElementById('data_fin');
data=document.getElementById('data_fat');
numero=document.getElementById('nume_fat').value;
azzera=document.getElementById('azzera').checked;
if(azzera==false)
  {
if(check_date(data))
  {
  alert("inserisci la data fattura");
  return false;
  }
if(check_date(dataf))
  {
  alert("inserisci la data finalizzazione");
  return false;
  }
if(numero=="")
  {
  alert("inserisci il numero fattura");
  return false;
  }
if(data.value=="")
  {
  alert("inserisci la data fattura");
  return false;
  }  
  }
calcola_totali();

	 var html="Conferma Finalizzazione Merce ?";
	 $("#dialog").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'CONFERMA',
							buttons: {	Ok: function() {
                                                        salva_tutto();
														$(this).dialog("close");
														},
										Annulla: function(){
														$(this).dialog("close");
														}
										}
					});

	$("#dialog").html(html);
	$("#dialog").dialog("open");

}

function salva_tutto()
{
    data_final=document.getElementById('data_fin').value;
    data_fattura=document.getElementById('data_fat').value;
    num_fattura=document.getElementById('nume_fat').value;
    azzera=document.getElementById('azzera').checked;
    for (var j = 0; j < cod.length; j++) 
      {
      if(qta[j]>0)
        {
      var dati="id=" + id[j] + "&data_final=" + data_final + "&data_fattura=" + data_fattura + "&num_fattura=" + num_fattura + "&azzera=" + azzera;
      request=$.ajax({
	    type: 'post',
	    url: 'salva_transito.php',
	    data: dati,
	    async: false,
	    success: function(res) {
	     },
        error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_transito.php)</p>').dialog({modal: true }); }
	});
       }
	  }
	  
   $("#confe").prop("disabled",true);
   
   id=[];
   qta=[];
   cod=[];
   desc=[];
   iva=[];
   uni=[];
   tot=[];
   sco=[];
   data_final=[];
   data_fattura=[];
   num_fattura=[];   
   
   leggi_movimenti();
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

function leggi_movimenti()
{
	
	var fornitore=$('#fornitore').val();
	var anno=$('#anno_doc').val();
	var numero=$('#nume_doc').val();
    var dati="anno=" + anno + "&numero=" + numero + "&fornitore=" + fornitore;
    request=$.ajax({
	  type: 'post',
	  url: 'get_movimenti.php',
	  data: dati,
	  success: function(result) {
	  	  if(result.errore=='0')
	  	    {
            id=id.concat(result.righe.id);
            qta=qta.concat(result.righe.qua);
            cod=cod.concat(result.righe.codart);
            desc=desc.concat(result.righe.desart);
            uni=uni.concat(result.righe.prezzo);
            tot=tot.concat(result.righe.totale);
            sco=sco.concat(result.righe.sconto);
            data_fattura=data_fattura.concat(result.righe.data_fattura);
            num_fattura=num_fattura.concat(result.righe.num_fattura);
            data_final=data_final.concat(result.righe.data_final);
            disegna_tabella()
			}
		  else
		    {
            $("#confe").prop("disabled",true);
	        $("#dialog").html('<p>Documento Non Trovato</p>').dialog({modal: true, buttons: '',title: "Documento Non Trovato" });
            $("#dialog").dialog("open");
			}
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function padLeft(nr, n, str){
    return Array(n-String(nr).length+1).join(str||'0')+nr;
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "fornitore", ret3: "", ret4: "" }, gestisci_fornitori);

    var options_rag = {
      callback: function () { $('#ragsoc').val($('#test_rag').val()); $('#ragsoc').trigger('keyup'); },
      wait: 750,
      highlight: true,
      allowSubmit: false,
      captureLength: 2
      }
    $("#test_rag").typeWatch( options_rag );
	
});

