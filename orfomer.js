indice = new Array();
qta = new Array();
cod = new Array();
desc = new Array();
iva = new Array();
uni = new Array();
tot = new Array();
sco = new Array();
raee = new Array();
qta_sca = new Array();
qta_ric = new Array();

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
   trasp_perc=0;
   trasp_euro=0;

   for(j=0;j<desc.length;j++)
     {
   if(tot_ali.length==0)
      {
      tot_ali.push(iva[j]);
	  tot_imponibile.push((parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta_ric[j]))).toFixedNumber(2));
      totale_raee=(totale_raee + parseFloat(raee[j]) * parseFloat(qta_ric[j])).toFixedNumber(2);
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
	    totale_raee=totale_raee + (parseFloat(raee[j]) * parseFloat(qta_ric[j]));
		}
      else
        {
		tot_ali.push(iva[j]);
	    tot_imponibile.push(parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta_ric[j])));
	    totale_raee=totale_raee + raee[j] * parseFloat(qta_ric[j]);
		}
	   }
	   totale_imponibile=parseFloat(totale_imponibile) + parseFloat(tot[j]) + (parseFloat(raee[j]) * parseFloat(qta_ric[j]));
	   totale_imponibile=totale_imponibile;
       }
       
     //spese di trasporto
     traspo=0;
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
     tot_imponibile[0]+=traspo;
	 totale_imponibile+=traspo;
	 //fine spese di trasporto

     insta=parseFloat($('#installazione').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0]+=insta;
	 totale_imponibile+=insta;
     insta=parseFloat($('#collaudo').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0]+=insta;
	 totale_imponibile+=insta;    
     insta=parseFloat($('#addvari').val());
     if(isNaN(insta)) { insta=0; }
     tot_imponibile[0]+=insta;
	 totale_imponibile+=insta;	 
	  
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
     document.getElementById("qua_sca").value=qta_sca[riga];
     document.getElementById("qua_ric").value=qta_ric[riga];
     document.getElementById("qua_ric").focus();
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
	var tqta_sca=parseFloat($.trim(document.getElementById("qua_sca").value));
	   if(isNaN(tqta_sca))
	     {
	     tqta_sca=0;
		 }
	var tqta_ric=parseFloat($.trim(document.getElementById("qua_ric").value));
	   if(isNaN(tqta_ric))
	     {
	     tqta_ric=0;
		 }		 
   var aliquota=$.trim(document.getElementById("ali0").value);
   var descri=$.trim(document.getElementById("desart").value);
   var dtot=document.getElementById("totale").value;
   var duni=document.getElementById("prezzo").value;
   if(descri==""||aliquota==""||dtot==""||isNaN(dtot))
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
     raee[riga]=traee;
     qta_sca[riga]=tqta_sca;
     qta_ric[riga]=tqta_ric;
     tot[riga]=dtot;
     uni[riga]=duni;
     sco[riga]=dsco;
	 }

     disegna_tabella();
     sbianca_input();
}

function sbianca_input() {
     document.getElementById("quantita").value="";
     document.getElementById("qua_sca").value="";
     document.getElementById("qua_ric").value="";
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
   	var raee4=0;
   	var qta_scar=0;
   	var qta_rice=0;
   	var qta_ordi=0;
    for(j=0;j<qta.length;j++){
		if(isNaN(sco[j])) {
   			sco[j]='';
   		}
       	totale=parseFloat(tot[j]).toFixed(2);
        totaleraee=raee[j]*qta[j];
       	totaleraee=totaleraee.toFixed(2);
       	raee4=parseFloat(raee[j]).toFixed(4);
        qta_ordi=qta[j];
        qta_scar=qta_sca[j];
        qta_rice=qta[j] - qta_sca[j];
        if(!isNaN(qta_ric[j]))
          {
          qta_rice=qta_ric[j];
		  }
       	righe = righe + "<tr id='row"+j+"' class='r'><td>" + cod[j] + "</td><td>" + desc[j] + "</td><td class='r'>" + qta_ordi + "</td><td class='r'>" + qta_scar + "</td><td class='r'>" + qta_rice + "</td><td class='r'>" + uni[j] + "</td><td class='r'>"  + sco[j] + "</td><td class='r'>" + totale + "</td><td class='r'>" + iva[j] + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
	    if(raee[j]>0)
	      {
       	righe = righe + "<tr id='row"+j+"' class='r'><td>&nbsp;</td><td>ECO CONTRIBUTO RAEE</td><td class='r'>" + qta_ordi + "</td><td class='r'>" + qta_scar + "</td><td class='r'>" + qta_rice + "</td><td class='r'>" + raee4 + "</td><td class='r'>0.00</td><td class='r'>" + totaleraee + "</td><td class='r'>" + iva[j] + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='immagini/button_edit.png' title='MODIFICA RIGA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='immagini/button_drop.png' title='ELIMINA RIGA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
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

function confer()
{
data=document.getElementsByName('data_doc').item(0);
if(check_date(data))
  {
  return false;
  }
calcola_totali();
disegna_totali();
	 var html="Conferma Ricezione Merce ?";
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
	righe["qta_sca"]=qta_sca;
	righe["qta_ric"]=qta_ric;

	tutto["righe"]=righe;
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
	  url: 'salva_orfomer.php',
	  data: dati,
	  success: function(res) {
	  	 $("#nume_doc").val(res.numero);
	  	 $("#idt").val(res.idt);
	     $("#dialog").html('<p>Ricezione Merce Effettuata</p>').dialog({modal: true, buttons: '',title: "Salva Dati" });
         $("#dialog").dialog("open");
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (salva_orfomer.php)</p>').dialog({modal: true }); }
	});
	  
   $("#confe").prop("disabled",true);
}

function calcolar()
{
  var quantita=document.documenti.qua_ric.value;
  var prezzo=document.documenti.prezzo.value;
  var sconto=document.documenti.sconto.value;
  var totale=0;
  totale=quantita*prezzo-quantita*prezzo*sconto/100;
  totale=+totale.toFixed(2);
  document.documenti.totale.value=totale;
}

function carica_articolo(e)
{
	var fornitore=$('#fornitore').val();
    var dati="codice=" + e.value + "&fornitore=" + fornitore;
    request=$.ajax({
	  type: 'post',
	  url: 'get_articolofo.php',
	  data: dati,
	  success: function(result) {
	  	  $('#prezzo').val(result.listino);
	  	  $('#sconto').val(result.sconto);
	  	  $('#codart').val(result.art_codice);
	  	  $('#desart').val(result.art_descrizione);
	  	  $('#raee').val(result.raee);
	  	  
	  	  $('#quantita').val(result.art_min_ordine);
	  	  if($('#ali0').val()==null)
	  	    {
	  	    $('#ali0').val(result.art_cod_iva);
			}
          calcolar();
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function carica_fornitore(e)
{
    var dati="codice=" + e.value;
    request=$.ajax({
	  type: 'post',
	  url: 'get_fornitore.php',
	  data: dati,
	  success: function(result) {
	  	  $('#paga').val(result.cf_codpag); 
	  	  $('#ali0').val(result.cf_iva);
	  	  $('#trasp_perc').val(result.trasp_perc);
	  	  $('#trasp_euro').val(result.trasp_euro);
	      },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
    return false;     	
}

function leggi_documento()
{
	var numero=$('#nume_doc').val();
    var dati="numero=" + numero;
    request=$.ajax({
	  type: 'post',
	  url: 'get_ordinefo.php',
	  data: dati,
	  success: function(result) {
	  	  if(result.errore=='0')
	  	    {
	  	    $('#deposito').val(padLeft(result.ORDI_DEPOSITO,2));
	  	    $('#data_doc').val(result.ORDI_DATA_DOC.substr(8, 2) + "/" + result.ORDI_DATA_DOC.substr(5, 2) + "/" + result.ORDI_DATA_DOC.substr(0, 4)); 
	  	    $('#data_consegna').val(result.ORDI_DATA_CONS.substr(8, 2) + "/" + result.ORDI_DATA_CONS.substr(5, 2) + "/" + result.ORDI_DATA_CONS.substr(0, 4)); 
	  	    $('#idt').val(result.ORDI_ID); 
	  	    $('#nume_doc').val(result.ORDI_NUM_DOC); 
	  	    $('#ord_cliente').val(result.ORDI_ORD_CLIENTE); 
	  	    $('#fornitore').val(result.ORDI_FORNITORE); 
	  	    $('#ragsoc').val(result.cf_ragsoc); 
	  	    $('#ute').val(result.ORDI_UTENTE);
	  	    $('#paga').val(result.ORDI_COD_PAG);
            $('#ali0').val(result.cf_iva);
            $('#des_rag_soc').val(result.ORDI_DES_RAG_SOC);
            $('#des_indirizzo').val(result.ORDI_DES_INDIRIZZO);
            $('#des_cap').val(result.ORDI_DES_CAP);
            $('#des_localita').val(result.ORDI_DES_LOC);
            $('#des_prov').val(result.ORDI_DES_PR);
            $('#cig').val(result.ORDI_CIG);
            $('#cup').val(result.ORDI_CUP);
            $('#notes').val(result.ORDI_NOTE);
            $('#acconto').val(result.ORDI_ACCONTO);
            $('#caparra').val(result.ORDI_VERSAMENTO);
            $('#trasporto').val(result.ORDI_TRASPORTO);
            $('#installazione').val(result.ORDI_INSTALLAZ);
            $('#jolly').val(result.ORDI_JOLLY);
            $('#noleggio').val(result.ORDI_NOLEGGIO);
            $('#collaudo').val(result.ORDI_COLLAUDO);
            $('#europallet').val(result.ORDI_EUROPALLET);
            $('#addvari').val(result.ORDI_ADDVARI);
            $('#des_spedizione').val(result.ORDI_DES_SPEDIZIONE);
            $('#des_trasporto').val(result.ORDI_DES_TRASPORTO);
            $('#des_imballo').val(result.ORDI_DES_IMBALLO);
	  	    $('#trasp_perc').val(result.trasp_perc);
	  	    $('#trasp_euro').val(result.trasp_euro);
            //$("#deposito").prop("disabled",true);
            $("#data_doc").prop("disabled",true);
            $("#data_consegna").prop("disabled",true);
            $("#nume_doc").prop("disabled",true);
            $("#fornitore").prop("disabled",true);
            $("#ragsoc").prop("disabled",true);
            $("#paga").prop("disabled",true);

            var righe = JSON.parse(result.ORDI_RIGHE);
            qta=righe.qta;
            cod=righe.cod;
            desc=righe.desc;
            iva=righe.iva;
            uni=righe.uni;
            tot=righe.tot;
            sco=righe.sco;
            raee=righe.raee;
            qta_sca=righe.qta_sca;
            for(j=0;j<qta_sca.length;j++)
              {
              qta_ric[j]=qta[j]-qta_sca[j];
			  }
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
	
$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
});

