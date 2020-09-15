indice = new Array();
qta = new Array();
cod = new Array();
desc = new Array();
iva = new Array();
uni = new Array();
tot = new Array();
sco = new Array();
raee = new Array();

tot_ali = new Array();
tot_imponibile = new Array();
tot_imposta = new Array();
tot_desali = new Array();

sca_data = new Array();
sca_importo = new Array();

tot_tot = new Array();
var totale_fattura;
var totale_imponibile;
var totale_imposta;
var totale_raee;
var valori;
var val_medio;
var tipi_doc;

Number.prototype.toFixedNumber = function(x, base){
  var pow = Math.pow(base||10,x);
  return +( Math.round(this*pow) / pow );
}

function esegui_cipi() {
   if(!confirm("ESEGUI CP"))
     {
	 return;
	 }
   var righe={};
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
    var d=JSON.stringify(righe);
    dati_json=encodeURIComponent(d);
    var dati="dati_json=" + dati_json;
    $("#dati_prima_cipi").val(d);
    request=$.ajax({
	  type: 'post',
	  url: 'esegui_cipi.php',
	  data: dati,
	  success: function(res) {
         //aggiorna righe
         //alert(res.righe.cod[0] + " " + res.righe.uni[0] + " " + res.righe.tot[0] + " " + res.resto);
	     uni=res.righe.uni;
	     sco=res.righe.sco;
	     tot=res.righe.tot;
         disegna_tabella();
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (esegui_cipi.php)</p>').dialog({modal: true }); }
	});
}

function abilita_cipi() {
var ss=$("#super").val();
var tipodoc=$("#tipodoc").val();
var idt=$("#idt").val();
if(ss==0 || idt==0 || tipodoc!=1)
  {
  return;
  }
$("#cliente").prop("disabled",false);
$("#ragsoc").prop("disabled",false);
$("#cipi").css("visibility", "visible");
$("#abilitato_cipi").val(1);
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
   trasp_perc=parseFloat($('#trasp_perc').val());
   trasp_euro=parseFloat($('#trasp_euro').val());
   
   for(j=0;j<desc.length;j++)
     {
   if(tot_ali.length==0)
      {
      tot_ali.push(iva[j]);
	  tot_imponibile.push((parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j]))).toFixed(2));
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
	    tot_imponibile.push((parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j]))).toFixed(2));
	    totale_raee=(raee[j] * parseFloat(qta[j])).toFixed(2);
		}
	   }
	   totale_imponibile=parseFloat(totale_imponibile) + parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta[j]));
	   totale_imponibile=totale_imponibile.toFixedNumber(2);
       }
     
     //spese di trasporto
     traspo=parseFloat($('#trasporto').val());
     if(isNaN(traspo)) { traspo=0; }
     if(traspo==0)
       {
	   traspo=(tot_imponibile[0]*trasp_perc/100).toFixedNumber(2);
	   if(traspo==0)
	     {
		 traspo=trasp_euro;
		 }
       $('#trasporto').val(traspo);		 
	   }
     tot_imponibile[0] = parseFloat(tot_imponibile[0]) + parseFloat(traspo);
	 totale_imponibile = parseFloat(totale_imponibile) + parseFloat(traspo);
	 //fine spese di trasporto

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
        totale_imposta=totale_imposta.toFixedNumber(2);
	   }       
     totale_fattura=totale_imponibile+totale_imposta;
     totale_fattura=totale_fattura.toFixedNumber(2);
     totale_raee=parseFloat(totale_raee);
     totale_raee=totale_raee.toFixedNumber(2);
     }

function calcola_scadenze() {
var data=$("#data_doc").val();
var codpag=$("#paga").val();

    var result = new Array();
    var dati="data=" + data + "&importo=" + totale_fattura + "&codpag=" + codpag;
    request=$.ajax({
	  type: 'post',
	  url: 'calcola_scadenze.php',
	  data: dati,
      async: false,	  
	  success: function(res) {
         result=res;
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
	return result;  
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
     carica_articolo(cod[riga]);
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

if(document.getElementById("codart").value>"")
  {
//controlla giacenza
   var dep=document.getElementById("deposito").value;
   giac=parseFloat(valori[dep]["qta"]);
   if(document.getElementById("quantita").value>giac)
     {
	 alert("Quantita maggiore della giacenza");
	 }
//
//controlla prezzo
   var unitario=dtot/qua;
   if(unitario<val_medio)
     {
	 alert("Prezzo minore del valore medio " + val_medio);
	 //return;
	 }
//              
  }
//
   var riga=document.getElementById("indice").value;
   if(riga!="")
     {
     qta[riga]=document.getElementById("quantita").value;
     cod[riga]=document.getElementById("codart").value;
     desc[riga]=document.getElementById("desart").value;
     iva[riga]=document.getElementById("ali0").value;
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
     document.getElementById("test_art").value="";
     document.getElementById("codart").value="";
     document.getElementById("desart").value="";
     document.getElementById("totale").value="";
     document.getElementById("prezzo").value="";
     document.getElementById("sconto").value="";
     document.getElementById("raee").value="";
     document.getElementById("indice").value="";
     $('#giacenze').html("");
     }

function disegna_tabella() {
   	var righe="";
   	var totale=0;
   	var totaleraee=0;
    var sconto=0;
    for(j=0;j<qta.length;j++){
      	sconto=sco[j];
		if(isNaN(sco[j])) {
   			sco[j]='';
   			sconto=0;
   		}
       	totale=parseFloat(tot[j]).toFixed(2);
        totaleraee=raee[j]*qta[j];
       	totaleraee=totaleraee.toFixed(2);
       	
       	var dif=parseFloat(qta[j])*parseFloat(uni[j]);
       	var scon=parseFloat(dif) * parseFloat(sconto) / 100;
       	dif=parseFloat(dif) - parseFloat(scon) - parseFloat(tot[j]);
       	//alert(dif + "-" + scon + "-" + parseFloat(qta[j]) + "-" + parseFloat(uni[j]) + "-" + sconto);
        var a="";
       	if(Math.abs(dif)>0.02)
       	  {
		  a="*";
		  }

       	righe = righe + "<tr id='row"+j+"' class='r'><td>" + a + cod[j] + "</td><td>" + desc[j] + "</td><td class='r'>" + qta[j] + "</td><td class='r'>" + uni[j] + "</td><td class='r'>"  + sco[j] + "</td><td class='r'>" + totale + "</td><td class='r'>" + iva[j] + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
	    if(raee[j]>0)
	      {
       	righe = righe + "<tr id='row"+j+"' class='r'><td>&nbsp;</td><td>RAEE</td><td class='r'>" + qta[j] + "</td><td class='r'>" + raee[j] + "</td><td class='r'>0.00</td><td class='r'>" + totaleraee + "</td><td class='r'>" + iva[j] + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
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
         righe = righe + "<tr class='tb'><td>&nbsp;</td><td>Totali</td><td class='tb'>" + totale_imponibile + "</td><td class='tb'>" + totale_imposta + "</td><td class='tb'>(Raee" + totale_raee + ")</td></tr>";
       righe="<table>" + righe + "</table>";
       
       document.getElementById("totale_fattura").value=parseFloat(totale_fattura).toFixed(2);
       
       var res=calcola_scadenze();
       var righesca="";
       var datae="";
       for(j=0;j<res.dati.date.length;j++)
         {
         sca_data[j]=res.dati.date[j];
         sca_importo[j]=res.dati.importo[j];
         datae=res.dati.date[j].substr(8,2) + "/" + res.dati.date[j].substr(5,2) + "/" + res.dati.date[j].substr(0,4);
         righesca=righesca+"<td>" + datae + "</td><td>" + res.dati.importo[j] + "</td>";
	     }
       righesca="<br><table><tr>" + righesca + "</tr></table>";
       	     
       document.getElementById("righetot").innerHTML=righe + righesca;

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

function altri_dati()
{
	if($("#sotto").is(":hidden"))
	  {
      $("#sopra").hide();
	  $("#sotto").show();
	  }
	else
	  {
      $("#sopra").show();
	  $("#sotto").hide();
	  }
}

function sopra_dati()
{
	$("#sopra").show();
	$("#sotto").hide();
}

function confer()
{
data=document.getElementById('data_doc');
if(check_date(data))
  {
  return false;
  }
//
if(document.getElementById("causale").value=="")
  {
  alert("Manca la Causale");
  return false;
  }
//
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
   var scade={};
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

    scade["data"]=sca_data;
    scade["importo"]=sca_importo;

	tutto["righe"]=righe;
	tutto["scadenze"]=scade;
	tutto["tot_ali"]=tot_ali;
	tutto["tot_imponibile"]=tot_imponibile;
	tutto["tot_imposta"]=tot_imposta;
	tutto["totale_fattura"]=totale_fattura;
	tutto["totale_imponibile"]=totale_imponibile;
	tutto["totale_imposta"]=totale_imposta;
	tutto["totale_raee"]=totale_raee;

    var dati=JSON.stringify(tutto);
    dati_json=encodeURIComponent(dati);

    var dati="dati_json=" + dati_json;
    request=$.ajax({
	  type: 'post',
	  url: 'salva_doc.php',
	  data: dati,
	  success: function(res) {
	  	 $("#nume_doc").val(res.numero);
	  	 $("#idt").val(res.idt);
	     $("#dialog").html('<p>Dati Salvati Correttamente</p>').dialog({modal: true, buttons: '',title: "Salva Dati" });
         $("#dialog").dialog("open");
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_doc.php)</p>').dialog({modal: true }); }
	});
	  
   $("#confe").prop("disabled",true);
}

function stampa()
{
var idt=document.getElementById('idt').value;
var tipo=document.getElementById('tipodoc').value;
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

function carica_tipi_doc()
{
      request=$.ajax({
	  //type: 'post',
	  //async: false,
	  url: 'carica_tipi_doc.php',
	  success: function(result) {
	  	  tipi_doc=result;
	  	  for(var j=0;j<tipi_doc.length;j++)
	  	    {
            $('#tipodoc').append('<option value="' + tipi_doc[j].cot_tipo + '">' + tipi_doc[j].cot_descri + '</option>'); 
			}
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;
}

function carica_articolo(e)
{
	if(e.length<10)
	  {
	  return;
	  }
	var cliente=$('#cliente').val();
    var dati="codice=" + e + "&cliente=" + cliente;
    var giace="<div class=\"giacenza\" style=\"margin-left: 12px;\">Giacenze</div>";
    var qua=0;
    request=$.ajax({
	  type: 'post',
	  async: false,
	  url: 'get_articolo.php',
	  data: dati,
	  success: function(result) {
	  	  if($('#indice').val()=="") //evito di sovrascrivere in variazione
	  	    {
	  	    $('#prezzo').val(result.listino);
	  	    $('#sconto').val(result.sconto);
	  	    $('#codart').val(result.art_codice);
	  	    $('#desart').val(result.art_descrizione);
	  	    $('#raee').val(result.raee);
			}
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
	  	  $('#age').val(result.cf_agente); 
	  	  $('#paga').val(result.cf_codpag); 
	  	  $('#ali0').val(result.cf_iva); 
	  	  $('#trasp_perc').val(result.trasp_perc);
	  	  $('#trasp_euro').val(result.trasp_euro);
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
	  url: 'get_documento.php',
	  data: dati,
	  success: function(result) {
	  	  if(result.errore=='0')
	  	    {
	  	    $('#deposito').val(padLeft(result.DOCT_DEPOSITO,2));
	  	    $('#data_doc').val(result.DOCT_DATA_DOC.substr(8, 2) + "/" + result.DOCT_DATA_DOC.substr(5, 2) + "/" + result.DOCT_DATA_DOC.substr(0, 4)); 
	  	    $('#tipodoc').val(result.DOCT_TIPO_DOC); 
	  	    $('#nume_doc').val(result.DOCT_NUM_DOC); 
	  	    $('#cliente').val(result.DOCT_CLIENTE); 
	  	    $('#cliente_cipi').val(result.DOCT_CLIENTE); 
	  	    $('#ragsoc').val(result.cf_ragsoc); 
	  	    $('#age').val(result.DOCT_AGENTE);
	  	    $('#age_cipi').val(result.DOCT_AGENTE);
	  	    $('#paga').val(result.DOCT_COD_PAG);
	  	    $('#causale').val(result.DOCT_CAUSALE);
	  	    $('#descausale').val(result.DOCT_DES_CAUSALE);
            $('#ali0').val(result.cf_iva);
            $('#des_rag_soc').val(result.DOCT_DES_RAG_SOC);
            $('#des_indirizzo').val(result.DOCT_DES_INDIRIZZO);
            $('#des_cap').val(result.DOCT_DES_CAP);
            $('#des_localita').val(result.DOCT_DES_LOC);
            $('#des_prov').val(result.DOCT_DES_PR);
            $('#cig').val(result.DOCT_CIG);
            $('#cup').val(result.DOCT_CUP);
            $('#notes').val(result.DOCT_NOTE);
            $('#acconto').val(result.DOCT_ACCONTO);
            $('#caparra').val(result.DOCT_VERSAMENTO);
            $('#trasporto').val(result.DOCT_TRASPORTO);
            $('#installazione').val(result.DOCT_INSTALLAZ);
            $('#jolly').val(result.DOCT_JOLLY);
            $('#noleggio').val(result.DOCT_NOLEGGIO);
            $('#collaudo').val(result.DOCT_COLLAUDO);
            $('#europallet').val(result.DOCT_EUROPALLET);
            $('#addvari').val(result.DOCT_ADDVARI);
            $('#spincasso').val(result.DOCT_SPESE_INCASSO);
            $('#des_spedizione').val(result.DOCT_DES_SPEDIZIONE);
            $('#des_trasporto').val(result.DOCT_DES_TRASPORTO);
            $('#des_imballo').val(result.DOCT_DES_IMBALLO);
            $("#deposito").prop("disabled",true);
            $("#data_doc").prop("disabled",true);
            $("#tipodoc").prop("disabled",true);
            $("#nume_doc").prop("disabled",true);
            $("#cliente").prop("disabled",true);
            $("#ragsoc").prop("disabled",true);
            $("#nume_man").prop("disabled",true);
	  	    $('#trasp_perc').val(result.trasp_perc);
	  	    $('#trasp_euro').val(result.trasp_euro);
	  	    $('#consegna').val(result.DOCT_MDV);
	  	    $('#vettore').val(result.DOCT_VETTORE);
	  	    $('#indvettore').val(result.DOCT_IND_VETTORE);
	  	    $('#indvettore').val(result.DOCT_IND_VETTORE);
	  	    $('#importoscontocassa').val(result.DOCT_SCONTO_CASSA);
	  	    $('#scontocassa').val(result.DOCT_ULT_SCONTO);
	  	    $('#porto').val(result.DOCT_PORTO);
	  	    $('#aspetto').val(result.DOCT_ASPETTO);
	  	    $('#colli').val(result.DOCT_COLLI);
	  	    $('#colli').val(result.DOCT_COLLI);
	  	    $('#peso').val(result.DOCT_PESO);
	  	    $('#incassato').val(result.DOCT_INCASSATO);
	  	    $('#data_ritiro').val(result.DOCT_DATA_RITIRO.substr(8,2) + "/" + result.DOCT_DATA_RITIRO.substr(5,2) + "/" + result.DOCT_DATA_RITIRO.substr(0,4));
	  	    $('#ora_ritiro').val(result.DOCT_ORA_RIT);
	  	  
            var righe = JSON.parse(result.DOCT_RIGHE);
            qta=righe.qta;
            cod=righe.cod;
            desc=righe.desc;
            iva=righe.iva;
            uni=righe.uni;
            tot=righe.tot;
            sco=righe.sco;
            raee=righe.raee;
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

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
    carica_tipi_doc();
    $('#ragsoc').bind('keyup', { ar_lista: "lista_clienti", ret1: "ragsoc", ret2: "cliente", ret3: "", ret4: "" }, gestisci_clienti);
    $('#codart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_articoli);
    $('#desart').bind('keyup', { ar_lista: "lista_articoli", ret1: "desart", ret2: "codart", ret3: "desart", ret4: "" }, gestisci_descrizione);

    var options_rag = {
      callback: function () { $('#ragsoc').val($('#test_rag').val()); $('#ragsoc').trigger('keyup'); },
      wait: 750,
      highlight: true,
      allowSubmit: false,
      captureLength: 2
      }
    $("#test_rag").typeWatch( options_rag );
    
    var options_art = {
      callback: function () { $('#codart').val($('#test_art').val()); $('#codart').trigger('keyup'); },
      wait: 750,
      highlight: true,
      allowSubmit: false,
      captureLength: 2
      }
    $("#test_art").typeWatch( options_art );
    
    var idt=$('#idt').val();
    if(idt>0)
      {
      leggi_documento(idt);	  	
	  }
});
 