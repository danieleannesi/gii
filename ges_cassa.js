indice = new Array();
qta = new Array();
cod = new Array();
desc = new Array();
iva = new Array();
uni = new Array();
tot = new Array();
sco = new Array();
raee = new Array();
ordine = new Array();

tot_ali = new Array();
tot_imponibile = new Array();
tot_imposta = new Array();
tot_desali = new Array();

tot_tot = new Array();
var totale_fattura;
var totale_imponibile;
var totale_imposta;
var totale_raee;

Number.prototype.toFixedNumber = function(x, base){
  var pow = Math.pow(base||10,x);
  return +( Math.round(this*pow) / pow );
}

function calcola_totali() {
   tot_ali.splice(0,tot_ali.length);
   tot_imponibile.splice(0,tot_imponibile.length);
   tot_imposta.splice(0,tot_imposta.length);
   tot_tot.splice(0,tot_tot.length);
   totale_fattura=0;
   totale_imponibile=0;
   totale_imposta=0;
   totale_raee=0;
   comodo=0;
   for(j=0;j<desc.length;j++)
     {
   if(tot_ali.length==0)
      {
      tot_ali.push(iva[j]);
	  tot_imponibile.push((parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j]))).toFixedNumber(2));
      totale_raee=(totale_raee + parseFloat(raee[j]) * parseFloat(qta[j])).toFixedNumber(2);
	  }
	 else
	  {
     for(k=0;k<tot_ali.length;k++)
       {
       if(tot_ali[k]==iva[j])
         {
		 break;
		 }
	   }
	   
      if(k<tot_ali.length)
        {
	    tot_imponibile[k]=parseFloat(tot_imponibile[k]) + parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j]));
	    totale_raee=totale_raee + (parseFloat(raee[j]) * parseFloat(qta[j]));
		}
      else
        {
		tot_ali.push(iva[j]);
	    tot_imponibile.push(parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j])));
	    totale_raee=totale_raee + raee[j] * parseFloat(qta[j]);
		}
	   }
	   totale_imponibile=parseFloat(totale_imponibile) + parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j]));
	   totale_imponibile=totale_imponibile;
       }

     scontocassa=parseFloat($('#scontocassa').val());
     if(isNaN(scontocassa)) { scontocassa=0; }
     comodo = parseFloat(tot_imponibile[0])*scontocassa/100;
     sconto_cassa=comodo.toFixedNumber(2);
     tot_imponibile[0]=tot_imponibile[0] - sconto_cassa;
	 totale_imponibile = parseFloat(totale_imponibile) - sconto_cassa;
     $('#importoscontocassa').val(sconto_cassa);
     insta=parseFloat($('#installazione').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);
     insta=parseFloat($('#collaudo').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);
     insta=parseFloat($('#addvari').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);
     insta=parseFloat($('#noleggio').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);
     insta=parseFloat($('#europallet').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);
     insta=parseFloat($('#jolly').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);
     insta=parseFloat($('#spincasso').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(insta);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(insta);     

     acconto=parseFloat($('#acconto').val());
     if(isNaN(acconto)) { acconto=0; }
     tot_imponibile[0]=tot_imponibile[0] - acconto;
	 totale_imponibile = parseFloat(totale_imponibile) - acconto;
     caparra=parseFloat($('#caparra').val());
     if(isNaN(caparra)) { caparra=0; }
     tot_imponibile[0]=tot_imponibile[0] - caparra;
	 totale_imponibile = parseFloat(totale_imponibile) - caparra;
     
     for(k=0;k<tot_ali.length;k++)
       {
        var result=leggi_codiva(tot_ali[k]);
        comodo=tot_imponibile[k]*result["perc"]/100;
        tot_desali[k]=result["descri"];
        comodo=comodo.toFixedNumber(2);
        tot_imposta[k]=comodo;
        totale_imposta=totale_imposta+comodo;
	   }       
     totale_fattura=totale_imponibile+totale_imposta;
     totale_fattura=totale_fattura.toFixedNumber(2);
     totale_raee=totale_raee.toFixedNumber(2);
     $('#totaledoc').val(totale_fattura);
     }

function leggi_codiva(codiva) {
    var result = new Array();
    result["perc"]=0;
    result["descri"]="";
    var dati="codiva=" + codiva;
    request=$.ajax({
	  type: 'post',
	  url: 'leggi_codiva.php',
	  data: dati,
      async: false,	  
	  success: function(res) {
         result["perc"]=res.perc;
         result["descri"]=res.descri;
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
	return result;  
}

function modificariga(riga) {
     document.getElementById("indice").value=riga;
     document.getElementById("quantita").value=qta[riga];
     document.getElementById("codart").value=cod[riga];
     document.getElementById("desart").value=desc[riga];
     document.getElementById("ali0").value=iva[riga];
     document.getElementById("prezzo").value=uni[riga];	
     document.getElementById("totale").value=tot[riga];	
     document.getElementById("sconto").value=sco[riga];
     document.getElementById("raee").value=raee[riga];
     document.getElementById("ordine").value=ordine[riga];
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
														    iva.splice(j,1);
														    uni.splice(j,1);
														    tot.splice(j,1);
														    sco.splice(j,1);
														    raee.splice(j,1);
														    ordine.splice(j,1);

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
	var traee=parseFloat($.trim(document.getElementById("raee").value));
	   if(isNaN(traee))
	     {
	     traee=0;
		 }
   var aliquota=$.trim(document.getElementById("ali0").value);
   var descri=$.trim(document.getElementById("desart").value);
   var dtot=document.getElementById("totale").value;
   var duni=document.getElementById("prezzo").value;
   if(descri==""||aliquota==""||qua==0||dtot==""||dtot==0||isNaN(dtot))
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
     iva[riga]=document.getElementById("ali0").value;
     ordine[riga]=document.getElementById("ordine").value;
     raee[riga]=traee;
     tot[riga]=dtot;
     uni[riga]=duni;
     sco[riga]=dsco;
	 }
   else
     {
     qta.push(document.getElementById("quantita").value);
     cod.push(document.getElementById("codart").value);
     desc.push(document.getElementById("desart").value);
     iva.push(document.getElementById("ali0").value);
     ordine.push(document.getElementById("ordine").value);
     raee.push(traee);
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
     document.getElementById("raee").value="";
     document.getElementById("indice").value="";
     document.getElementById("ordine").value="";
     }

function disegna_tabella() {
   	var righe="";
   	var totale=0;
   	var totaleraee=0;
   	var raee4=0;
    for(j=0;j<qta.length;j++){
		if(isNaN(sco[j])) {
   			sco[j]='';
   		}
       	totale=parseFloat(tot[j]).toFixed(2);
        totaleraee=raee[j]*qta[j];
       	totaleraee=totaleraee.toFixed(2);
       	raee4=parseFloat(raee[j]).toFixed(4);
       	righe = righe + "<tr id='row"+j+"' class='r'><td>" + cod[j] + "</td><td>" + desc[j] + "</td><td class='r'>" + qta[j] + "</td><td class='r'>" + uni[j] + "</td><td class='r'>"  + sco[j] + "</td><td class='r'>" + totale + "</td><td class='r'>" + iva[j] + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
	    if(raee[j]>0)
	      {
       	righe = righe + "<tr id='row"+j+"' class='r'><td>&nbsp;</td><td>ECO CONTRIBUTO RAEE</td><td class='r'>" + qta[j] + "</td><td class='r'>" + raee4 + "</td><td class='r'>0.00</td><td class='r'>" + totaleraee + "</td><td class='r'>" + iva[j] + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
		  }
	
	}

    tabella="<table id='righedoc'>";
    tabella=tabella + "<colgroup><col span='1' style='width: 80px;'><col span='1' style='width: 500px;'><col span='1' style='width: 50px; text-align: right;'><col span='1' style='width: 80px; text-align: right;'><col span='1' style='width: 60px; text-align: right;'><col span='1' style='width: 80px;'><col span='1' style='width: 30px;'><col span='1' style='width: 10px;'><col span='1' style='width: 10px;'></colgroup>";
    tabella=tabella + righe + "</table>";
    document.getElementById("righedoc").innerHTML=tabella;
    calcola_totali();
    disegna_totali();
}

function disegna_totali() {
	   var righe="<colgroup><col span='1' style='width: 30px;'><col span='1' style='width: 200px;'><col span='1' style='width: 80px;'><col span='1' style='width: 80px; text-align: right;'>";
	   righe=righe + "<tr class='it'><td>C.iva</td><td>Descrizione iva</td><td class='t'>Imponibile</td><td class='t'>Imposta</td></tr>";
       var imponibile=0;
       var imposta=0;
       var totale=0;
       for(j=0;j<tot_ali.length;j++)
         {
         imponibile=parseFloat(tot_imponibile[j]).toFixed(2);
         imposta=parseFloat(tot_imposta[j]).toFixed(2);
         righe = righe + "<tr class='t'><td>" + tot_ali[j] + "</td><td>" + tot_desali[j] + "</td><td class='t'>" + imponibile + "</td><td class='t'>" + imposta + "</td><td>&nbsp;</td></tr>";
         }
         righe = righe + "<tr class='tb'><td>&nbsp;</td><td>Totali</td><td class='tb'>" + totale_imponibile + "</td><td class='tb'>" + totale_imposta + "</td><td class='tb'>(Raee " + totale_raee + ")</td></tr>";
       righe="<table>" + righe + "</table>";
       document.getElementById("righetot").innerHTML=righe;
       document.getElementById("totale_fattura").value=parseFloat(totale_fattura).toFixed(2);
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
		//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
		/*if(sottrai){
		  	tot=parseFloat('-' + tot);
		  	//tot=tot*(-1);
		  }*/
		//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
		  
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
	 var html="Conferma emissione del documento ?";
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
	righe["iva"]=iva;
	righe["raee"]=raee;
	righe["ordine"]=ordine;

	tutto["righe"]=righe;
	tutto["tot_ali"]=tot_ali;
	tutto["tot_imponibile"]=tot_imponibile;
	tutto["tot_imposta"]=tot_imposta;
	tutto["totale_fattura"]=totale_fattura;
	tutto["totale_imponibile"]=totale_imponibile;
	tutto["totale_imposta"]=totale_imposta;
	tutto["totale_raee"]=totale_raee;
    var dati=JSON.stringify(tutto);
    //alert(dati);
    dati_json=encodeURIComponent(dati);
    var dati="dati_json=" + dati_json;
    request=$.ajax({
	  type: 'post',
	  url: 'salva_cassa.php',
	  data: dati,
	  success: function(res) {
	  	 $("#idconferma").hide();
	  	 $("#idstampa").show();
	  	 $("#nume_doc").val(res.numero);
	  	 $("#idt").val(res.idt);
	     $("#dialog").html('<p>Dati Salvati Correttamente</p>').dialog({modal: true, buttons: '',title: "Salva Dati" });
         $("#dialog").dialog("open");
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_ord.php)</p>').dialog({modal: true }); }
	});
	  
   $("#confe").prop("disabled",true);
}

function stampa()
{
var idt=document.getElementById('idt').value;
var tipo=document.getElementById('tipo_documento').value;
if(idt>0) {
	var h="<iframe src=\"stampadoc.php?idt=" + idt + "&tipo=" + tipo + "\" width=\"600px\" height=\"700px\"></iframe>";
	$("#dialog").html(h).dialog({modal: true, buttons: '',title: "Stampa Documento", width: 'auto', height:'auto'});
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

function carica_idrobox(e)
{
	var cliente=$('#cliente').val();
    var dati="codice=" + e.value + "&cliente=" + cliente;
    request=$.ajax({
	  type: 'post',
	  url: 'get_idrobox.php',
	  data: dati,
	  success: function(result) {
	  	  $('#prezzo').val(result.listino);
	  	  $('#sconto').val(result.sconto);
	  	  $('#desart').val(result.art_descrizione);
	  	  $('#raee').val(result.raee);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function carica_articolo(e)
{
	var cliente=$('#cliente').val();
    var dati="codice=" + e.value + "&cliente=" + cliente;
    var giace="<div class=\"giacenza\" style=\"margin-left: 12px;\">Giacenze</div>";
    request=$.ajax({
	  type: 'post',
	  url: 'get_articolo.php',
	  data: dati,
	  success: function(result) {
	  	  $('#prezzo').val(result.listino);
	  	  $('#sconto').val(result.sconto);
	  	  $('#codart').val(result.art_codice);
	  	  $('#desart').val(result.art_descrizione);
	  	  $('#raee').val(result.raee);
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
	  	  if(result.nprev>0)
	  	    {
			alert("Il Cliente ha preventivi in corso: " + result.nprev);
            $('#preventivi').show();
			}	  	  
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function carica_prev()
{
	var idt=$('#nume_prev').val();
    var dati="idt=" + idt;
    request=$.ajax({
	  type: 'post',
	  url: 'get_preventivo_num.php',
	  data: dati,
	  success: function(result) {
	  	  if(result.errore=='0')
	  	    {
	  	    $('#deposito').val(padLeft(result.PREV_DEPOSITO,2));
	  	    //$('#data_doc').val(result.PREV_DATA_DOC.substr(8, 2) + "/" + result.PREV_DATA_DOC.substr(5, 2) + "/" + result.PREV_DATA_DOC.substr(0, 4)); 
	  	    //$('#nume_doc').val(result.PREV_NUM_DOC); 
	  	    
	  	    $('#ute').val(result.PREV_UTENTE);
	  	    $('#paga').val(result.PREV_COD_PAG);
	  	    $('#agente').val(result.cf_agente);
            $('#ali0').val(result.cf_iva);
          
           $('#cliente').val(result.PREV_CLIENTE); 
            $('#ragsoc').val(result.cf_ragsoc); 
            $('#des_rag_soc').val(result.cf_ragsoc);  
            $('#des_indirizzo').val(result.cf_indirizzo);
            $('#des_cap').val(result.cf_cap);
            $('#des_localita').val(result.cf_localita);
            $('#des_prov').val(result.cf_prov);
            $('#cig').val(result.PREV_CIG);
            $('#cup').val(result.PREV_CUP);
            $('#notes').val(result.PREV_NOTA_1);
            $('#acconto').val(result.PREV_ACCONTO);
            $('#caparra').val(result.PREV_VERSAMENTO);
            $('#trasporto').val(result.PREV_TRASPORTO);
            $('#installazione').val(result.PREV_INSTALLAZ);
            $('#jolly').val(result.PREV_JOLLY);
            $('#noleggio').val(result.PREV_NOLEGGIO);
            $('#collaudo').val(result.PREV_COLLAUDO);
            $('#europallet').val(result.PREV_EUROPALLET);
            $('#addvari').val(result.PREV_ADDVARI);
           
            //$("#deposito").prop("disabled",true);
            //$("#data_doc").prop("disabled",true);
            //$("#nume_doc").prop("disabled",true); 
            //$("#nume_man").prop("disabled",true);

            var righe = JSON.parse(result.PREV_RIGHE);
            qta=righe.qta;
            cod=righe.cod;
            desc=righe.desc;
            iva=righe.iva;
            uni=righe.uni;
            tot=righe.tot;
            sco=righe.sco;
            raee=righe.raee;
            ordine=righe.ordine;
            disegna_tabella()
			}
		  else
		    {
            $("#confe").prop("disabled",true);
            $("#stamp").prop("disabled",true);
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

function win_idro()
{
	$("#dialog").html('<iframe src=\"win_idro.php\" width=\"600px\" height=\"600px\"></iframe>').dialog({modal: true, buttons: '',title: "idrobox", width: 'auto', height:'auto'});
    $("#dialog").dialog("open");
}

function chiudi_ele_preventivi()
{
$("#dialog").dialog("close");
}
	
function vedi_preventivi()
{
	var codice=$("#cliente").val();
	var html='<iframe src=\"ele_preventivi.php?codice=' + codice + '\" width=\"600px\" height=\"600px\"></iframe>';
	$("#dialog").html(html).dialog({modal: true, buttons: '',title: "Preventivi in Corso", width: 'auto', height:'auto'});
    $("#dialog").dialog("open");
}

function altri_dati_torna()
{
var x=$("#tipo_documento").val();
if(x==1 || x==2)
  {
  $("#sopra").show();
  $("#sotto_fa").hide();
  }	
if(x==3)
  {
  $("#sopra").show();
  $("#sotto_sco").hide();
  }	
}

function altri_dati(x)
{
	$("#des_rag_soc").val($("#ragsoc").val());
	$("#tipo_documento").val(x);
    if(x==1)
      {
	  $("#torna").val("Torna: D.D.T.");
	  }
    if(x==2)
      {
	  $("#torna").val("Torna: Fattura Accompagnatoria");
	  }	  	  
	if(x==1 || x==2)
	  {
      $("#totaledoc").val($("#totale_fattura").val());
      $("#incassato").val(0);
      $("#sopra").hide();
      $("#sotto_fa").show();
      }
	if(x==3)
	  {
	  get_numero_scontrino();
      $("#sopra").hide();
      $("#sotto_sco").show();
	  }
}

function get_numero_scontrino()
{
	var deposito=$("#deposito").val();
    var dati="deposito=" + deposito;
    request=$.ajax({
	  type: 'post',
	  url: 'get_numero_scontrino.php',
	  data: dati,
	  success: function(result) {
       	  $("#numsco").val(result.numsco);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    $('#consegna').val('D');  
    $('#causale').val('50');  
    $('#paga').val('162');  
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);    
    $('#codart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_articoli);
    $('#desart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_descrizione);
    var idt=$('#idt').val();
    if(idt>0)
      {
      leggi_documento(idt);	  	
	  }
});

