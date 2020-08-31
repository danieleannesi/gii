indice = new Array();
qta = new Array();
cod = new Array();
desc = new Array();
iva = new Array();
uni = new Array();
tot = new Array();
sco = new Array();

tot_tot = new Array();
var totale_imponibile;

Number.prototype.toFixedNumber = function(x, base){
  var pow = Math.pow(base||10,x);
  return +( Math.round(this*pow) / pow );
}

function azzera_tabella() {
qta = new Array();
cod = new Array();
desc = new Array();
iva = new Array();
uni = new Array();
tot = new Array();
sco = new Array();
calcola_totali();
disegna_totali();
disegna_tabella();
}

function calcola_totali() {
   totale_imponibile=0;
   comodo=0;
   
   for(j=0;j<desc.length;j++)
     {
	  totale_imponibile+=parseFloat(tot[j]) * parseFloat(qta[j]).toFixed(2);
     }
   }

function modificariga(riga) {
     document.getElementById("indice").value=riga;
     document.getElementById("quantita").value=qta[riga];
     document.getElementById("codart").value=cod[riga];
     document.getElementById("desart").value=desc[riga];
     document.getElementById("prezzo").value=uni[riga];	
     document.getElementById("totale").value=tot[riga];	
     document.getElementById("sconto").value=sco[riga];
}

function eliminariga(j) {
	var codice=cod[j];
	var descri=desc[j];
	var html="Eliminare l'articolo\n" + codice +  " " + descri + "\ndal documento ?";
	 $("#dialog").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
															indice.splice(j,1);
															qta.splice(j,1);
														    cod.splice(j,1);
														    desc.splice(j,1);
														    uni.splice(j,1);
														    tot.splice(j,1);
														    sco.splice(j,1);

														    disegna_tabella();
														    sbianca_input();
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

function salvariga() {
	var qua=parseFloat($.trim(document.getElementById("quantita").value));
	   if(isNaN(qua))
	     {
	     qua=0;
		 }
   var descri=$.trim(document.getElementById("desart").value);
   var dtot=document.getElementById("totale").value;
   var duni=document.getElementById("prezzo").value;
   if(descri==""||qua==0||dtot==""||dtot==0||isNaN(dtot))
     {
	 return;
	 }

   var dsco=parseFloat(document.getElementById("sconto").value);
   if(isNaN(dtot)) {
   	 dtot=0;
   }
   if(isNaN(duni)) {
   	 duni=0;
   }
   if(isNaN(dsco)) {
   	 dsco=0;
   }

   var riga=document.getElementById("indice").value;
   if(riga!="")
     {
     qta[riga]=document.getElementById("quantita").value;
     cod[riga]=document.getElementById("codart").value;
     desc[riga]=document.getElementById("desart").value;
     tot[riga]=dtot;
     uni[riga]=duni;
     sco[riga]=dsco;
	 }
   else
     {
     qta.push(document.getElementById("quantita").value);
     cod.push(document.getElementById("codart").value);
     desc.push(document.getElementById("desart").value);
     tot.push(dtot);
     uni.push(duni);
     sco.push(dsco);
	 }

     disegna_tabella();
     sbianca_input();
}

function sbianca_input() {
     document.getElementById("quantita").value="";
     document.getElementById("codart").value="";
     document.getElementById("desart").value="";
     document.getElementById("totale").value="";
     document.getElementById("prezzo").value="";
     document.getElementById("sconto").value="";
     document.getElementById("indice").value="";
     }

function disegna_tabella() {
   	var righe="";
   	var totale=0;
    for(j=0;j<qta.length;j++){
		if(isNaN(sco[j])) {
   			sco[j]='';
   		}
       	totale=parseFloat(tot[j]).toFixed(2);
       	righe = righe + "<tr id='row"+j+"' class='r'><td>" + cod[j] + "</td><td>" + desc[j] + "</td><td class='r'>" + qta[j] + "</td><td class='r'>" + uni[j] + "</td><td class='r'>"  + sco[j] + "</td><td class='r'>" + totale + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";

	}

    tabella="<table id='righedoc'>";
    tabella=tabella + "<colgroup><col span='1' style='width: 80px;'><col span='1' style='width: 500px;'><col span='1' style='width: 50px; text-align: right;'><col span='1' style='width: 80px; text-align: right;'><col span='1' style='width: 60px; text-align: right;'><col span='1' style='width: 80px;'><col span='1' style='width: 30px;'><col span='1' style='width: 10px;'><col span='1' style='width: 10px;'></colgroup>";
    tabella=tabella + righe + "</table>";
    document.getElementById("righedoc").innerHTML=tabella;
    calcola_totali();
    disegna_totali();
}

function disegna_totali() {
    document.getElementById("totale_doc").value=parseFloat(totale_imponibile).toFixed(2);
    }

function calcola_impo2(scoriga) {
      calcola_impo(scoriga);
	  if(parseFloat(document.getElementById("tot").value)!=0 && parseFloat(document.getElementById("tot").value)!=NaN)
	    {
	    var tot=parseFloat(document.getElementById("tot").value);
        	if(!isNaN(tot.toFixed(2))){
				document.getElementById("tot").value=tot.toFixed(2);	//////////////////////////////////////// compilo il campo solo se non è NaN
			}
        }
      else
        {
        document.getElementById("tot").value=0.00;
		}
      }

function calcola_impo(sc) {
	if(sc=='undefined'){
		sc=false;
	}
	//console.log(document.getElementById("tot").value);
	//console.log(parseFloat(document.getElementById("tot").value));
	var dot=document.getElementById("tot").value;
	dot=dot.replace(',','.');
	document.getElementById("tot").value=dot;
	if(!isNaN(parseFloat(document.getElementById("tot").value))){
	
		var tot=parseFloat(document.getElementById("tot").value);
		
		if(sc && $('#sco').val().trim != '' && $('#sco').val()!=0 ){
			switch(sconto) {
			    case 0:
			        break;
			    case 1:
			    	var scontodiff=parseFloat($('#sco').val());
			        tot=tot - parseFloat($('#sco').val());		        
			        break;
			    case 2:
			    	var scontoperc=parseFloat($('#sco').val());
			    	tot=(tot - tot*scontoperc/100) *100;
			    	tot=tot / 100;  
			        break;
			    default:
			    break;
			}
		} 
		  var aliq=parseInt(document.getElementById("iva").value);
	      var imponibile=tot*100/(100+aliq);
	      var imposta=tot-imponibile;
	      document.getElementById("imponibile").value=imponibile.toFixed(2);
	      document.getElementById("imposta").value=imposta.toFixed(2);
		  document.getElementById("tot").value=tot.toFixed(2);
	}else{
	
		document.getElementById("imponibile").value=0;
		document.getElementById("imposta").value=0;
		document.getElementById("tot").value="";
	}
}

function confer()
{
data=document.getElementsByName('data_doc').item(0);
if(check_date(data))
  {
  return false;
  }
calcola_totali();
disegna_totali();
if(qta.length==0 || $("#causale").val()=="")
  {
  return false;
  }
	 var html="Conferma prima nota magazzino ?";
	 $("#dialog").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'CONFERMA',
							buttons: {	Ok: function() {
                                                        salva_tutto();
                                                        azzera_tabella();
                                                        $("#documenti").trigger("reset");
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
   var tutto={};
   var righe={};
   for (var i=0;i<document.documenti.elements.length;i++)
     {
    nomeint=document.documenti.elements[i].id;
    nomenome=document.documenti.elements[i].name;
    nometag=document.documenti.elements[i].tagName;
    tipo=document.documenti.elements[i].type;
    nome=nomeint;
    valore="";
    hvalore="";
    if (nometag == "INPUT") {
            if (tipo == "text" || tipo == "hidden" || tipo == "number") {
               valore=document.getElementById(nomeint).value;
               }
            if (tipo == "checkbox") {
               valore="";
               if(document.getElementById(nomeint).checked==true)
                 {
                 valore=document.querySelector("input[name='" + nomeint + "']:checked").value;
                 }
            }
            if (tipo == "radio") {
               valore="";
               if(document.getElementById(nomeint).checked==true)
                 {
                 valore=document.querySelector("input[name='" + nomenome + "']:checked").value;
				 }
            }
         }   
         if (nometag == "SELECT") {
               valore=document.getElementById(nomeint).value;
         }    
         if (nometag == "TEXTAREA") {
               valore=document.getElementById(nomeint).value;
         }    
             valore=$.trim(valore);
             tutto[nomenome]=valore;
	}
    for (var i = 0; i < desc.length; i++) {
       desc[i]=desc[i].replace(/"/g, '\\"');
       }
	righe["cod"]=cod;
	righe["desc"]=desc;
	righe["qta"]=qta;
	righe["uni"]=uni;
	righe["sco"]=sco;
	righe["tot"]=tot;

	tutto["righe"]=righe;
	tutto["totale_imponibile"]=totale_imponibile;
    var dati=JSON.stringify(tutto);
    dati_json=encodeURIComponent(dati);
    var dati="dati_json=" + dati_json;
    request=$.ajax({
	  type: 'post',
	  url: 'salva_pnmagaz.php',
	  data: dati,
	  success: function(res) {
	  	 if(res.msg!="")
	  	   {
		   	alert("errore:" + res.msg);
		   }
	  	 $("#idt").val(res.idt);
	     $("#dialog").html('<p>Dati Salvati Correttamente</p>').dialog({modal: true, buttons: '',title: "Salva Dati" });
         $("#dialog").dialog("open");
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_pnmagaz.php)</p>').dialog({modal: true }); }
	});
	  
   //$("#confe").prop("disabled",true);
}

function stampa()
{
var idt=document.getElementById('idt').value;
if(idt>0) {
	var h="<iframe src=\"stampaordfo.php?idt=" + idt + "\" width=\"600px\" height=\"700px\"></iframe>";
	$("#dialog").html(h).dialog({modal: true, buttons: '',title: "Stampa Ordine", width: 'auto', height:'auto'});
    $("#dialog").dialog("open");
  }
}

function calcolar()
{
  var quantita=document.documenti.quantita.value;
  var prezzo=document.documenti.prezzo.value;
  var sconto=document.documenti.sconto.value;
  var totale=0;
  totale=quantita*prezzo-quantita*prezzo*sconto/100;
  totale=+totale.toFixed(2);
  document.documenti.totale.value=totale;
}

function leggi_causale(e)
{
    var dati="causale=" + e.value;
    request=$.ajax({
	  type: 'post',
	  url: 'leggi_causale.php',
	  data: dati,
	  success: function(result) {
          var clifor=$('#clifor').val();
          if(result.dati.clifor!=clifor)
            {
            if(result.dati.clifor=="C")
              {
              $('#clifor').val("C");
              $("#tipocli").text("Clienti");
              carica_indirizzi("carica_clienti.php","lista_fornitori");
			  }
			else
			  {
              $('#clifor').val("F");
              $("#tipocli").text("Fornitori");
              carica_indirizzi("carica_fornitori.php","lista_fornitori");
			  }
			}
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function carica_articolo(codice)
{
	var data=$('#data_doc').val();
	var alla_data=data.substr(6,4) + "-" + data.substr(3,2) + "-" + data.substr(0,2);  
	var dalla_data=data.substr(6,4) + "-01-01";
    var dati="articolo=" + codice + "&deposito=&dalla_data=" + dalla_data + "&alla_data=" + alla_data;
    request=$.ajax({
	  type: 'post',
	  url: 'valore_medio_json.php',
	  data: dati,
	  async: false,
	  success: function(result) {
	  	  $('#prezzo').val(result.val_medio);
	  	  $('#sconto').val(0);
	  	  $('#codart').val(result.codart);
	  	  $('#desart').val(result.desart);
	  	  //alert(result.debug);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function carica_articolo_descri(codice)
{
	var descri="";
	var data=$('#data_doc').val();
	var alla_data=data.substr(6,4) + "-" + data.substr(3,2) + "-" + data.substr(0,2);  
	var dalla_data=data.substr(6,4) + "-01-01";
    var dati="articolo=" + codice + "&deposito=&dalla_data=" + dalla_data + "&alla_data=" + alla_data;
    request=$.ajax({
	  type: 'post',
	  url: 'valore_medio_json.php',
	  data: dati,
	  async: false,
	  success: function(result) {
	  	  descri=result.desart;
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return descri;
}

function carica_fornitore(codice)
{
    var dati="codice=" + codice;
    request=$.ajax({
	  type: 'post',
	  url: 'get_fornitore.php',
	  data: dati,
	  success: function(result) {
	  	  $('#ragsoc').val(result.cf_ragsoc);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function leggi_documento(idt)
{
    var dati="idt=" + idt;
    request=$.ajax({
	  type: 'post',
	  url: 'get_pnmagaz.php',
	  data: dati,
	  success: function(result) {
	  	  if(result.errore=='0')
	  	    {
	  	    $('#idt').val(result.mov_id);
            var data=result.mov_data.substr(8,2) + "/" + result.mov_data.substr(5,2) + "/" + result.mov_data.substr(0,4);  
	  	    $('#data_doc').val(data);
	  	    $('#causale').val(result.mov_causale);
	  	    $('#numero').val(result.mov_doc);
	  	    $('#fornitore').val(result.mov_clifor);
	  	    $('#tipo_doc').val(result.mov_tipo_doc);
	  	    $('#doc').val(result.mov_doc);
	  	    $('#id_rife').val(result.mov_id_rife);
	  	    carica_fornitore(result.mov_clifor);
	  	    cod[0]=result.mov_codart;
            desc[0]=carica_articolo_descri(result.mov_codart);
	        qta[0]=result.mov_qua;
	        uni[0]=result.mov_prezzo;
	        sco[0]=result.mov_sconto;
	        tot[0]=result.mov_totale;
            calcola_totali();
            disegna_totali();
            disegna_tabella();
			}
		  else
		    {
            $("#confe").prop("disabled",true);
	        $("#dialog").html('<p>Movimento Non Trovato</p>').dialog({modal: true, buttons: '',title: "Movimento Non Trovato" });
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

function win_idro()
{
	$("#dialog").html('<iframe src=\"win_idro.php\" width=\"600px\" height=\"600px\"></iframe>').dialog({modal: true, buttons: '',title: "idrobox", width: 'auto', height:'auto'});
    $("#dialog").dialog("open");
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "fornitore", ret3: "", ret4: "" }, gestisci_fornitori);        
    $('#codart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_articoli);
    $('#desart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_descrizione);
    var idt=$('#idt').val();
    if(idt>0)
      {
      leggi_documento(idt);	  	
	  }
});

