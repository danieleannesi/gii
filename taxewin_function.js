var LIMITE_LEGGE=154.94;
aggiornamento_softwa=true;
indice = new Array();
qta = new Array();
desc = new Array();
iva = new Array();
imponibile = new Array();
imposta = new Array();
tot = new Array();
sco = new Array();

tot_ali = new Array();
tot_imponibile = new Array();
tot_imposta = new Array();
tot_tot = new Array();
var totale_fattura;
var totale_imponibile;
var totale_imposta;
//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
/*var sottrai=false;*/
//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
var turista_riconosciuto=false;
var esiste_itinerario=false;
var id_travel='';
var id_assistenza='';
var assistenza_inserita=false;
var ass_esistente=true;
var articoli_select='';
var altezza_mobile='';
var mobile=0;
var card_turista='';
var modulo_duty=false;
tipo_sconto=new Array('','-','%');
var giorni_preaut_cc='';
var finemese_cc=false;
var tipo_carta_cc='';
var prima_riga=0;

// sconto arriva da index

turista_anagrafica = new Object();
turista_otello = new Object();
desc_articoli = new Array();
iva_articoli = new Array();
ind_articoli = new Array();
array_blocchi_display = new Array('blocco-ins-articoli','box-tot','box-data','box-turista','box-salva','tur-ricerca');

$.extend($.ui.dialog.prototype.options, { width : '0px !important' });

var array_campi_post={
						ecard : "card_tur",
						name : "name",
						surname : "surname",
						gender : "gender",
						email : "email",
						address : "addr",
						city : "city",
						country : "country",
						country_code : "country_cod",
						doc_type : "tipo_doc",
						passport : "doc",
						doc_country : "nazdoc",
						doc_country_code : "nazdoc_cod",
						doc_exp : "exp",
						city_birth : "citybirt",
						country_birth : "birt",
						country_birth_code : "birt_cod",
						date_birth : "dtbirt"
}

////////////////////////////////////////////////////////////////////////////////////////	BLOCCO RICERCA NAZIONI INIZIO
var naz = { }, europa= {}, codici_naz = { }, codici_naz_23 = { }, cursor_naz = 0;
//(function(a,b){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))window.location=b})(navigator.userAgent||navigator.vendor||window.opera,'http://detectmobilebrowser.com/mobile');
function info_utente() {
	info={	infobrowser : navigator.userAgent,
			browser 	: navigator.appName,
			piattaforma	: navigator.platform,
			monitorX	: screen.width,
			monitorY	: screen.height,
			finestraX	: window.outerWidth,
			finestraY	: window.outerHeight
	}
	plug=navigator.plugins;
return {info:info,plug:plug};
}

function show_info(){
	var html='<div>';
	var info=info_utente();
	$.each(info.info,function(key,value){
		
		html+='<label>'+ key +' => '+ value +'</label><br/>';	
	});
	var test=info.plug;
		html+='<label> => '+ Object.keys(test) +'</label><br/>';	
	
	
	html+='</div>';

	$( "#dialog_info" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'Info',
							buttons: {	Ok: function() {
														$(this).dialog("close");
														}
									}
					});

	$( "#dialog_info" ).html(html);
	$('#dialog_info').dialog("option", "minWidth", '50%');
	$('#dialog_info').dialog("option", "maxWidth", '90%');
	$( "#dialog_info" ).dialog( "open" );
}

function caricaEuropa() {
  $.ajax({
    type: 'post',
    url: 'taxewin_otellonazioni_europa.php',
    success: function(data) {
      for(var i in data) {
        europa = data;
      }
    },
    dataType: 'json'
  });
}

function caricaNazioni() {
  $.ajax({
  	beforeSend:sessione_scaduta,
    type: 'post',
    url: 'taxewin_otellonazioni.php',
    success: function(data) {
        naz = data.naz;
        codici_naz = data.cod;
		for(kv in codici_naz){
			codici_naz_23[codici_naz[kv]]=kv;
		}
        //console.log(data);
    },
    error: function(err, textStatus, errorThrown) {
	          console.log("error ajax carica nazioni "+ textStatus + " " + errorThrown);
	},
    dataType: 'json'
  });
}

function scegliNaz(event) {
  var value_naz = event.target.getAttribute('naz');
  $(event.data.dove).val(value_naz);
    
  var value_cod = event.target.getAttribute('cod');
  var currentName = event.data.dove.getAttribute('name');
  currentName = currentName + '_cod';
  document.getElementsByName(currentName)[0].value = value_cod;
  //$('#nazionetur_cod').change();
  //$('#nazione2tur_cod').change();
  nascondilista();
  cursor_naz = 0;
  if(tastiera_conf){
  	var classe=$(event.data.dove).attr('class');
  	var index_tag=$('.'+classe).index(this) + 1;
  	$('.'+classe).eq(index_tag).focus();	
  }
}

function filtra(naz, chiave) {
  
  var result = {}, i, nazione;
  for (i in naz) {
    nazione = naz[i];
    var appoggio_cod_naz23=codici_naz_23[i];
    if(typeof appoggio_cod_naz23 === 'undefined'){
		continue;
	}
    if (appoggio_cod_naz23.indexOf(chiave) !== -1 || nazione.indexOf(chiave) !== -1) {
    	result[appoggio_cod_naz23] = nazione;
    }
  }
  return result;
}

function caricalista(event,levaeuropa) {
	var naz_appoggio=naz;
	if(typeof levaeuropa === 'undefined'){		// se non esiste il parametro prendo tutte le nazioni altrimenti prendo solo europa
		
	}else{
		naz_appoggio={};
		for(chiave_naz in naz){	
			if (typeof europa[chiave_naz] === 'undefined') {		// mi prendo solo le nazioni escludendo europa
				naz_appoggio[chiave_naz]=naz[chiave_naz];
			}
		}
	}
  var key = event.target.value.toUpperCase();
  var nazione, li, css, ul;
  
    
  if (event.which == 27  || key.trim() == '') {
    nascondilista();
    return;
  }
  if (key.trim() == '') {
    return;
  }

  var mialista = filtra(naz_appoggio, key);
  var counter = Object.keys(mialista).length;

  if (event.which === 40 || event.which === 38) {
	cursor_naz += event.which - 39;
	if (cursor_naz < 0) {
	  cursor_naz = 0;
	}

	if (cursor_naz > counter) {
	  cursor_naz = counter;
	}
	coloraElemento(cursor_naz, 'listanaz1');
	return;
  }
  
  if (event.which === 13 || event == event.click) {
    $('#listanaz1 li:nth-child(' + cursor_naz + ')').click();
	return;
  }
  
	var ul = document.getElementById('listanaz1');
	$("#listanaz1").empty();
	if(counter > 0){	
		for(var i in mialista) {
			nazione = mialista[i];
			li = document.createElement("LI");
			li.innerHTML = '[' + i + ']____' + nazione;
			li.setAttribute('naz', nazione);
			li.setAttribute('cod', i);
			ul.appendChild(li);
		}
		var offset = $('#' + event.target.id).position(), left = offset.left, top = offset.top + $('#' + event.target.id).height() + 10;
		/////////// provo a togliere il valore left che prendo dal tag padre e metto semplicemente rigth a zero nel css
		/////////// css = {display: 'block', left: left, top: top, width:'60%'};
		css = {display: 'block', top: top, width:'60%', right: '0px'};
		$('#listanaz1 li').click({dove: event.target}, scegliNaz);
		$('#listanaz1').css(css);
	}else{
		nascondilista();
	}
}

function nascondilista() {
  $('#listanaz1').css({display: 'none'});
}

function coloraElemento(cursore, elementid) {
	$('#' + elementid + ' li').css({'background-color': ''});
	$('#' + elementid + ' li:nth-child(' + cursore + ')').css({'background-color': '#FFD600'});
}
////////////////////////////////////////////////////////////////////////////////////////	BLOCCO RICERCA NAZIONI FINE

////////////////////////////////////////////////////////////////////////////////////////	BLOCCO RICARCA AEROPORTI INIZIO
 	/*$('#airports').keydown(scorriLista);
  	$('#airports').keyup(scorriLista);
  	$('#airports').on('blur',listaAeroporti);
*/

var airports = new Object();

function caricaAeroporti() {
  var ore = new Date().getHours();
  /*if (voli[ore]) {
    return;
  }*/
  $.ajax({
  	beforeSend:sessione_scaduta,
    type: 'post',
	async:true,
    url: 'taxewin_otellocercaaeroporto.php',
    success: function(data) {
      airports = data;
    },
    error: function(err, textStatus, errorThrown) {
	          console.log("error ajax carica aeroporti "+ textStatus + " " + errorThrown);
	},
    dataType: 'json'
  });
}

function nascondiListaAeroporti() {
  $('#listaAirports').css({display: 'none'});
}

function listaAeroporti(event) {
 	var valore = event.target.value.toUpperCase();


	if (event.which == 27  || valore.trim() == '') {
		nascondiListaAeroporti();
		return;
	}
	if (valore.trim() == '') {
		return;
	}
	var ul, li, aeroporto;
	var aeroporti_filtrati = cercaAeroporto(valore);
	var counter_aeroporti_filtrati = Object.keys(aeroporti_filtrati).length;

	if (event.which === 40 || event.which === 38) {
		cursor_naz += event.which - 39;
		if (cursor_naz < 0) {
	  		cursor_naz = 0;
		}

		if (cursor_naz > counter) {
			cursor_naz = counter;
		}
		coloraElemento(cursor_naz, 'listaAirports');
		return;
	}
	if (event.which === 13) {
		$('#listaAirports li:nth-child(' + cursor_naz + ')').click();
		return;
	}

	var ul = document.getElementById('listaAirports');
	$("#listaAirports").empty();
	//document.body.removeChild(ul);
	var counter = 0;
	if(aeroporti_filtrati.length > 0){
		
		for (var i in aeroporti_filtrati) {
			if (counter++ > 50) break;
			aeroporto = aeroporti_filtrati[i];
			li = document.createElement("LI");
			//li.innerHTML = '<span>[' + aeroporto.i + ']</span> ' + aeroporto.c + ', ' + aeroporto.C + ' "' + aeroporto.n + '"';
			li.innerHTML = '<span>[' + aeroporto.i + ']</span><span>' + aeroporto.c + '</span>,<br/><span>' + aeroporto.C + ' "' + aeroporto.n + '"</span>';
			li.setAttribute('cod', aeroporto.i);
			li.setAttribute('air', aeroporto.c + ', ' + aeroporto.C);
			ul.appendChild(li);
		}
		//var offset_off = $('#' + event.target.id).offset(), left_off = offset_off.left , top_off = offset_off.top -10;// + $('#' + event.target.id).height() + 10;
	  	var offset_off2 = $('#ote_aerodest').offset(), left_off2 = offset_off2.left , top_off2 = offset_off2.top -10;// + $('#' + event.target.id).height() + 10;
	  	
	  	var offset_off = $('#dialog_otello').offset(), left_off = offset_off.left , top_off = offset_off.top;// + $('#' + event.target.id).height() + 10;
	  	css = {display: 'block', top: top_off2-top_off+75, width:'120%', left: '-' + $('#' + event.target.id).width()};
		//css = {display: 'block', width:'130%',  position:'absolute'};
	  	//document.body.appendChild(ul);
	  	$('#dialog_otello').after(ul);
	  	//$('#listaAirports li').click(selezionaAeroporto);
	  	$('#listaAirports li').click({dove: event.target}, selezionaAeroporto);
	  	$('#listaAirports').css(css);
	}else{
		nascondiListaAeroporti();
	}
}

function selezionaAeroporto(event) {
  	var el = event.target;
  	var air = el.getAttribute('air');
  	 $(event.data.dove).val(air);
  	$('#ote_aerodest').val(air);
	var cod = el.getAttribute('cod');
	$('#ote_aerodest_cod').val(cod);
  cursor_air = 0;
  nascondiListaAeroporti();
}

function cercaAeroporto(valore) {
  var valori = valore.split(' ');
  var count = 0;
  var risultati = airports.filter(function(air) {
											    if (count > 50) {
											      return false;
											    }
											    for (i in valori) {
											      if (air.c.indexOf(valori[i]) == -1 && air.i.indexOf(valori[i]) == -1 && air.n.indexOf(valori[i]) == -1 && air.C.indexOf(valori[i]) == -1) {
											        return false;
											      }
											    }
											    count++;
											    return true;
									});
  return risultati;
}
////////////////////////////////////////////////////////////////////////////////////////	BLOCCO RICARCA AEROPORTI FINE
function pulisci_array(){
	indice = new Array();
	qta = new Array();
	desc = new Array();
	iva = new Array();
	imponibile = new Array();
	imposta = new Array();
	tot = new Array();
	sco = new Array();

	tot_ali = new Array();
	tot_imponibile = new Array();
	tot_imposta = new Array();
	tot_tot = new Array();
	totale_fattura = '';
	totale_imponibile = '';
	totale_imposta = '';
	assistenza_inserita=false;
	id_travel='';
	card_turista='';
	turista_otello= new Object();
	giorni_preaut_cc='';
	finemese_cc=false;
	tipo_carta_cc='';
}

function modify(questo,testo){
	if (questo.value==testo){
		questo.value="";
		questo.click();
	}
}

function restore(questo,testo){
	if (questo.value=="")
	questo.value=testo;
}

function calcola_totali() {

   tot_ali.splice(0,tot_ali.length);
   tot_imponibile.splice(0,tot_imponibile.length);
   tot_imposta.splice(0,tot_imposta.length);
   tot_tot.splice(0,tot_tot.length);
   totale_fattura=0;
   totale_imponibile=0;
   totale_imposta=0;

   for(j=0;j<desc.length;j++)
     {
   if(tot_ali.length==0)
      {
      tot_ali.push(iva[j]);
	  tot_imponibile.push(parseFloat(imponibile[j]).toFixed(2));
	  tot_imposta.push(parseFloat(imposta[j]).toFixed(2));
	  tot_tot.push(parseFloat(tot[j]).toFixed(2));
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
 	    tot_imponibile[k]=parseFloat(tot_imponibile[k]) + parseFloat(imponibile[j]);
	    tot_imposta[k]=parseFloat(tot_imposta[k]) + parseFloat(imposta[j]);
	    tot_tot[k]=parseFloat(tot_tot[k]) + parseFloat(tot[j]);
		}
      else
        {
		tot_ali.push(iva[j]);
	    tot_imponibile.push(parseFloat(imponibile[j]).toFixed(2));
	    tot_imposta.push(parseFloat(imposta[j]).toFixed(2));
	    tot_tot.push(parseFloat(tot[j]).toFixed(2));
		}
	   }
	   totale_fattura=parseFloat(totale_fattura) + parseFloat(tot[j]);
	   totale_imponibile=parseFloat(totale_imponibile) + parseFloat(imponibile[j]);
	   totale_imposta=parseFloat(totale_imposta) + parseFloat(imposta[j]);
       }
     }

function modificariga(riga) {
     document.getElementById("qta").value=qta[riga];
     document.getElementById("qta_mob").value=qta[riga];
     document.getElementById("qta_hidden").value=qta[riga];
     document.getElementById("desc").value=desc[riga];
     document.getElementById("desc_mob").value=desc[riga];
     document.getElementById("desc_hidden").value=desc[riga];
     document.getElementById("iva").value=iva[riga];
     //document.getElementById("imponibile").value=imponibile[riga];
     //document.getElementById("imposta").value=imposta[riga];
    if(sco[riga] != ""){
	 	switch(sconto) {
		    case 0:
		        break;
		    case 1:
		    	document.getElementById("tot").value=tot[riga] + parseFloat(sco[riga]);		        
		        break;
		    case 2:
		    	var scontato = 100-sco[riga];
		    	scontato = tot[riga]/scontato;
		    	scontato = scontato*sco[riga];
		    	document.getElementById("tot").value = scontato+tot[riga];
		    	break;
		    default:
		    	document.getElementById("tot").value=tot[riga];
		    break;
		}	
	}else{
		document.getElementById("tot").value=tot[riga];	
	}
     
     document.getElementById("indice").value=riga;
     calcola_impo();
     document.getElementById("sco").value=sco[riga];
     //document.getElementById("qta").focus();
}

function eliminariga(j) {
	var html="Eliminare l'articolo dalla lista?";
	 $( "#dialog_eliminariga" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
															indice.splice(j,1);
															qta.splice(j,1);
														    desc.splice(j,1);
														    iva.splice(j,1);
														    imponibile.splice(j,1);
														    imposta.splice(j,1);
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

	$( "#dialog_eliminariga" ).html(html);
	$( "#dialog_eliminariga" ).dialog( "open" );
}

function salvariga() {
	var qua=parseFloat($.trim(document.getElementById("qta_hidden").value));
	   if(isNaN(qua))
	     {
	     qua=0;
		 }

   var aliquota=$.trim(document.getElementById("iva").value);
   var descri=$.trim(document.getElementById("desc_hidden").value);
   var dtot=document.getElementById("tot").value;
  if(descri==""||aliquota==""||qua==0||dtot==""||dtot==0||isNaN(dtot))
     {
	 return;
	 }

   var dimponibile=parseFloat(document.getElementById("imponibile").value);
   var dimposta=parseFloat(document.getElementById("imposta").value);
   //var dtot=parseFloat(document.getElementById("tot").value);
   
   //////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
/*if(sottrai){
   		var dtot=parseFloat('-' + document.getElementById("tot").value);
   }else{
		var dtot=parseFloat(document.getElementById("tot").value);
   }   */
   		var dtot=parseFloat(document.getElementById("tot").value);
   //////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
   
   var dsco=parseFloat(document.getElementById("sco").value);
   if(isNaN(dimponibile)) {
   	 dimponibile=0;
   }
   if(isNaN(dimposta)) {
   	 dimposta=0;
   }
   if(isNaN(dtot)) {
   	 dtot=0;
   }
   if(isNaN(dsco)) {
   	 //dsco=0;
	 dsco='';
   }

   var riga=document.getElementById("indice").value;
   if(riga!="")
     {
     qta[riga]=document.getElementById("qta_hidden").value;
     desc[riga]=document.getElementById("desc_hidden").value;
     iva[riga]=document.getElementById("iva").value;
     imponibile[riga]=dimponibile;
     imposta[riga]=dimposta;
     tot[riga]=dtot;
     sco[riga]=dsco;
	 }
   else
     {
     qta.push(document.getElementById("qta_hidden").value);
     desc.push(document.getElementById("desc_hidden").value);
     iva.push(document.getElementById("iva").value);
     imponibile.push(dimponibile);
     imposta.push(dimposta);
     tot.push(dtot);
     sco.push(dsco);
	 }

     disegna_tabella();
     sbianca_input();
}

function sbianca_input() {
     document.getElementById("qta").value="";
     document.getElementById("qta_hidden").value="";
     document.getElementById("qta_mob").value="";
     document.getElementById("desc").value="";
     document.getElementById("desc_hidden").value="";
     document.getElementById("desc_mob").value="";
     document.getElementById("imponibile").value="";
     document.getElementById("imposta").value="";
     document.getElementById("tot").value="";
     document.getElementById("sco").value="";
     document.getElementById("indice").value="";
     }

function disegna_tabella() {
   	var righe="";
   	var totale=0;
   	
	//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
	/*var class_sottrai='';*/
    //////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
    
    for(j=0;j<qta.length;j++){
		if(isNaN(sco[j])) {
   			sco[j]='';
   		}
       	totale=tot[j].toFixed(2);
       //righe = righe + "<tr><td>" + qta[j] + "</td><td>" + desc[j] + "</td><td>" + iva[j] + "</td><td>" + imponibile[j] + "</td><td>" + imposta[j] + "</td><td>" + totale + "</td><td>" + sco[j] + "</td><td>" + "<img src='img/edit.png' title='MODIFICA' onclick='modificariga(" + j + ")'/>" + "</td><td>" + "<img src='img/trash.png' title='ELIMINA' onclick='eliminariga(" + j + ")'/>" +  "</td></tr>";
		
		//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
		/*if(totale<0){
   			class_sottrai='class_sottrai';
   		}else{
   			class_sottrai='';
   		}*/
   		//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
   		
	   	if(sco[j]!=0){
			var blocco_sconto = tipo_sconto[sconto] + sco[j]	
		}else{
			var blocco_sconto = '';
		}
	   	
	   	//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
       	/*righe = righe + "<tr class=" + class_sottrai + "><td>" + qta[j] + "</td><td>" + desc[j] + "</td><td>" + iva[j] + "</td><td>" + imponibile[j] + "</td><td>" + imposta[j] + "</td><td>" + totale + "</td><td>" + blocco_sconto + "</td><td>" + "<img src='img/edit.png' title='MODIFICA' onclick='modificariga(" + j + ")'/>" + "</td><td>" + "<img src='img/trash.png' title='ELIMINA' onclick='eliminariga(" + j + ")'/>" +  "</td></tr>";*/
       	righe = righe + "<tr id='row"+j+"'><td>" + qta[j] + "</td><td>" + desc[j] + "</td><td>" + iva[j] + "</td><td>" + imponibile[j] + "</td><td>" + imposta[j] + "</td><td>" + totale + "</td><td>" + blocco_sconto + "</td><td>" + "<img id='row"+j+"img1' class='img_art_tab' src='img/edit.png' title='MODIFICA' onclick='modificariga(" + j + ");'/>" + "</td><td>" + "<img id='row"+j+"img2' class='img_art_tab' src='img/trash.png' title='ELIMINA' onclick='eliminariga(" + j + ");'/>" +  "</td></tr>";
       	//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
	}
    righe="<table id='box-articoli-tab'>" + righe + "</table>";
    document.getElementById("box-articoli").innerHTML=righe;
    
    /*for(j=0;j<qta.length;j++){
		    //$('#row'+j+'img1').unbind();
		$('#row'+j+'img1').on('click',function(evt){
			alert('ciao');
			$('#qta').on('keydown',function(e){
				e.preventDefault();
				$('#qta').focus();
				alert('ciaooo');
			});
			//$('#row'+j+'img1').click();
		});
	}*/
    
    calcola_totali();
    disegna_totali();
    if(document.getElementById('box-articoli') != null && tastiera_conf){
		muoversi_frecce_tabella('box-articoli','box-articoli-tab','.img_art_tab','img',2,'#2A8B45','yellow');
	}

}

function disegna_totali() {
	   var righe="<tr><td>Iva</td><td>Imponibile</td><td>Imposta</td><td>Totali</td></tr>";
       var imponibile=0;
       var imposta=0;
       var totale=0;
       for(j=0;j<tot_ali.length;j++)
         {
         imponibile=parseFloat(tot_imponibile[j]).toFixed(2);
         imposta=parseFloat(tot_imposta[j]).toFixed(2);
         totale=parseFloat(tot_tot[j]).toFixed(2);
         righe = righe + "<tr><td>" + tot_ali[j] + "</td><td>" + imponibile + "</td><td>" + imposta + "</td><td>" + totale + "</td></tr>";		     }
       righe="<table>" + righe + "</table>";
       document.getElementById("box-totali").innerHTML=righe;
       document.getElementById("tot_fattura").value=parseFloat(totale_fattura).toFixed(2);

       calcola_rimborso();

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
        document.getElementById("tot").value="";
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

function scadenza_cc(nomecampo,mesicarta,campocarta){
	var exp_cc = $('#' + nomecampo ).val();
	var mese='';
	var anno='';
	var meseexp='';
	
	var num_pos=exp_cc.indexOf('/');
	if( (num_pos != -1 && exp_cc.length != 5) || (num_pos == -1 && exp_cc.length != 4) ){
		alert('La data inserita non e\' corretta.\n I formati supportati sono:\n - mmaa\n - mm/aa');
		$('#' + nomecampo ).val('');
		return false;
	}
	
	if( exp_cc.length == 5 ){
		exp_cc=exp_cc.replace('/', '');
	}
	
	var d = new Date();
	var qstanno = d.getFullYear();
	var qstanno_corto= qstanno.toString().substr(2, 2);;
	 	
	var meseattuale=( d.getMonth() + 1 + qstanno * 12 );
	
	mese = exp_cc.substr(0, 2);
    anno = exp_cc.substr(2, 2);
    
    if (parseInt(mese) < 1 || parseInt(mese) > 12) {
      	exp_cc = "";
      	alert('Data di scadenza non valida');
      	$('#' + nomecampo ).val('');
		return false;
    }
    if (parseInt(anno) > (parseInt(qstanno_corto) + 10)) {
      	exp_cc = "";
      	alert('Data di scadenza non valida');
      	$('#' + nomecampo ).val('');
		return false;
    }
        
    meseexp = parseInt(mese) + (2000 + parseInt(anno)) * 12;
    
	if (meseexp <= meseattuale ) {
		alert('Carta di Credito SCADUTA');
		$('#' + nomecampo ).val('');
		$('#' + campocarta ).val('');
		$('#' + campocarta ).css({'background-color' : 'red'});
		return false;
	}
	if (!(meseexp>= meseattuale + mesicarta )) {
		alert('Scadenza Carta di Credito non valida per la scadenza del modulo');
		$('#' + nomecampo ).val('');
		$('#' + campocarta ).val('');
		$('#' + campocarta ).css({'background-color' : 'red'});
		return false;
	}
	return true; 
}

function verifica_cc(cc_test){
	var risposta=false;

	$.ajax({
			beforeSend:sessione_scaduta,
		    type: 'post',
		    async: false,
		    url: 'taxewin_check_luhn.php',
		    data: 'cc=' + cc_test,
			dataType: 'json',
		    success: function(result) {
	      		//console.log(result);
	      		if(result.esito=="ko"){
			  	  	return false;
			  	}
				if(!result.esito){
			  		alert(result.errore);
			  		return false;
			  	}
			  	risposta=result.esito;
			  	giorni_preaut_cc=Number(result.giorni_preaut);
			  	finemese_cc=(result.finemese === 'true');
			  	tipo_carta_cc=Number(result.cod_carta);
			  	//console.log(scadenza_modDuty(tipo_carta_cc));
			},
			error: function(err, textStatus, errorThrown) {
			  	console.log("error ajax check carta"+ textStatus + " " + errorThrown);
			}
	    });
	return risposta;
}

function scadenza_modDuty(tipocartacc){		////// ASSEGNO IN ORDINE SPECIFICHE DA TABELLA O SOVRASCRIVO CON SPECS TOTALI DA CONFIG O SOVRASCRIVO CON SPECS IN PARTICOLARE PER UNA CARTA
	var data_scad=false;
	
	if( tipocartacc!='' && giorni_preaut_cc !== '' ){	//// GIORNI E FINE MESE DA TABELLA FISSO PER CARTA
		
		if(giorni_preaut_cc !== ''){
			
			var gg=giorni_preaut_cc*1000*60*60*24;
			var d = new Date();
			var oggi_milsec = d.getTime();
			var somma_milsec=oggi_milsec+gg;
			d.setTime(somma_milsec);
			var anno=d.getFullYear();
			var mese=d.getMonth();
			var giorno=d.getDate();
			
			var data_scad = anno + '-' + (mese+1) + '-' + giorno;	
		}
		if(finemese_cc){
			var d = new Date(anno, mese+1, 1);
			//d.setMonth(mese+1);
			var oggi_milsec = d.getTime();	//riprendo questo tanto ho aggiornato i millisecondi sommando i giorni
			var ungg_milsec=1*1000*60*60*24;
			var diff_milsec=oggi_milsec-ungg_milsec;
			d.setTime(diff_milsec);
			var anno=d.getFullYear();
			var mese=d.getMonth();
			var giorno=d.getDate();
			
			var data_scad = anno + '-' + (mese+1) + '-' + giorno;	
		}	
	}
	
	if(tipocartacc!='' && typeof scadduty_gg_config !== "undefined" && typeof scadduty_gg_config['gg'] !== "undefined"){		//// GIORNI E FINE MESE DA CONFIGURAZIONE PER TUTTE LE CARTE
		
		if(typeof scadduty_gg_config['gg'] !== "undefined" && scadduty_gg_config['gg'] !== '' ){	
			
			var gg=scadduty_gg_config['gg']*1000*60*60*24;
			var d = new Date();
			var oggi_milsec = d.getTime();
			var somma_milsec=oggi_milsec+gg;
			d.setTime(somma_milsec);
			var anno=d.getFullYear();
			var mese=d.getMonth();
			var giorno=d.getDate();
			
			var data_scad = anno + '-' + (mese+1) + '-' + giorno;	
		}
		if(typeof scadduty_gg_config !== "undefined" && typeof scadduty_gg_config['fm'] !== "undefined" && scadduty_gg_config['fm'] !== false ){
			var d = new Date(anno, mese+1, 1);
			//d.setMonth(mese+1);
			var oggi_milsec = d.getTime();	//riprendo questo tanto ho aggiornato i millisecondi sommando i giorni
			var ungg_milsec=1*1000*60*60*24;
			var diff_milsec=oggi_milsec-ungg_milsec;
			d.setTime(diff_milsec);
			var anno=d.getFullYear();
			var mese=d.getMonth();
			var giorno=d.getDate();
			
			var data_scad = anno + '-' + (mese+1) + '-' + giorno;	
		}		
	}
	
	if(tipocartacc!='' && typeof tipocarta_config !== "undefined" && typeof tipocarta_config[tipocartacc] !== "undefined"){	//// GIORNI E FINE MESE DA CONFIGURAZIONE SPECIFICO PER OGNI CARTA
		
		if(typeof tipocarta_config !== "undefined" && typeof tipocarta_config[tipocartacc]['gg'] !== "undefined" && tipocarta_config[tipocartacc]['gg'] !== '' ){
			
			var gg=tipocarta_config[tipocartacc]['gg']*1000*60*60*24;
			var d = new Date();
			var oggi_milsec = d.getTime();
			var somma_milsec=oggi_milsec+gg;
			d.setTime(somma_milsec);
			var anno=d.getFullYear()
			var mese=d.getMonth();
			var giorno=d.getDate();
			
			var data_scad = anno + '-' + (mese+1) + '-' + giorno;	
		}
		if(typeof tipocarta_config !== "undefined" && typeof tipocarta_config[tipocartacc]['fm'] !== "undefined" && tipocarta_config[tipocartacc]['fm'] != false){
			var d = new Date(anno, mese+1, 1);
			//d.setMonth(mese+1);
			var oggi_milsec = d.getTime();	//riprendo questo tanto ho aggiornato i millisecondi sommando i giorni
			var ungg_milsec=1*1000*60*60*24;
			var diff_milsec=oggi_milsec-ungg_milsec;
			d.setTime(diff_milsec);
			var anno=d.getFullYear()
			var mese=d.getMonth();
			var giorno=d.getDate();
			
			var data_scad = anno + '-' + (mese+1) + '-' + giorno;		
		}		
	}
    return data_scad;
}

function salva_dati(md) {
	var lock=true;
	var url_fatt='taxewin_numfat_up.php';
	var scadenza_mod_dichiarazione='';
	//var fm_mod_dichiarazione='';
	if(md){
		url_fatt='taxewin_transaction_up.php';
		if( !verifica_cc( $('#ccredito').val() ) ){
			$('#ccredito').css({'background-color' : 'red'});
			$('#ccredito').focus();
			return false;
		}
		if( !scadenza_cc('cc_exp',mesicc_config,'ccredito') || $('#cc_exp').val()== '' ){
			$('#cc_exp').css({'background-color' : 'red'});
			$('#cc_exp').focus();
			return false;
		}
		
		if(!(scadenza_mod_dichiarazione=scadenza_modDuty(tipo_carta_cc))){
			alert('Problema Scadenza Modulo contattare Taxrefund');
			return false;
		}
		//fm_mod_dichiarazione
	}
	var risultato_sessione=false;
	var flag_ajax=false;
	var numfat_up;
	var tipo_documento='';
	if($('#id_php').val()==''){	
		$.ajax({
			beforeSend:sessione_scaduta,
		    type: 'post',
		    async: false,
		    url: url_fatt,
		    success: function(result) {
	      		//console.log(result);
	      		if(result.esito=="ko"){
			  	  	risultato_sessione=true;
			  	  	return;
			  	}
				if(!result.esito){
			  		alert('Si è verificato un errore nella registrazione del numero fattura');
			  		return;
			  	}
			  	if(!result.lock){
					lock=false;
				}
			 	numfat_up=result.numfattura;
			 	numtrans_up=result.transaction;
			},
			error: function(err, textStatus, errorThrown) {
			  	console.log("error ajax salvadati numfat"+ textStatus + " " + errorThrown);
			},
			dataType: 'json'
	    });
	    if(!modulo_duty){
			var tipo_mod="T";
		}else{
			var tipo_mod=tipo_documento="D";
		}
	}else{
		numfat_up=$('#numero').val();
		numtrans_up=$('#trans_num').val();
		//var tipo_mod="NC";
		var tipo_mod=tipo_documento=$('#tipo_documento').val();		// inserisco questo valore da input hidden che ho riempito durante lettura da db. almeno posso risalvare lo stato precedente senza perderlo (andrebbe levato il tipo documento dalla qr update di class.taxewin)
	}
	var card_tur = $('#card_tur').val().trim();
	//console.log(numfat_up);
	card_tur=card_tur.replace(/ /g,"");

    var pS="";
    pS = pS + "tipo_documento=" + tipo_documento + "&";
    
    pS = pS + "codice_tax=" + card_tur + "&";
    pS = pS + "nometur=" + $('#name').val() + "&";
    pS = pS + "cognometur=" + $('#surname').val() + "&";
    pS = pS + "sessotur=" + $('#gender').val() + "&";
    
    pS = pS + "emailtur=" + $('#email').val() + "&";
    
    pS = pS + "indirizzotur=" + $('#addr').val() + "&";
    pS = pS + "cittatur=" + $('#city').val() + "&";
    pS = pS + "nazionetur=" + $('#country').val() + "&";
    pS = pS + "codice_nazione=" + codici_naz[$('#country_cod').val()] + "&";
    
    pS = pS + "tipo_doc=" + $('#tipo_doc').val() + "&";
    pS = pS + "passaportotur=" + $('#doc').val() + "&";
     if($('#exp').val()!=''){
		var doc_exp=$('#exp').val().substr(6,4) +'-' + $('#exp').val().substr(3,2)+'-' + $('#exp').val().substr(0,2);
	}else{	var doc_exp='0000-00-00';}
    
    pS = pS + "scadenza_doc=" + doc_exp + "&";
    pS = pS + "nazione_doc=" + $('#nazdoc').val() + "&";
    pS = pS + "codice_nazione_doc=" + codici_naz[$('#nazdoc_cod').val()] + "&";
    
    if($('#dtbirt').val()!=''){
		var dt_nas=$('#dtbirt').val().substr(6,4) +'-' + $('#dtbirt').val().substr(3,2)+'-' + $('#dtbirt').val().substr(0,2);	
	}else{	var dt_nas='0000-00-00';}
    
	pS = pS + "datanascita=" + dt_nas + "&";
    pS = pS + "luogonascita=" + $('#citybirt').val() + "&";
    pS = pS + "nazionetur2=" + $('#birt').val() + "&";
    pS = pS + "codice_nazionetur2=" + codici_naz[$('#birt_cod').val()] + "&";	// CONVERTO DA ISO 3 (CHE MI SERVE PERCHè I PASSAPORTI HANNO 3) A ISO 2 PERCHè LE DOGANE VOGLIONO ISO 2
    
    pS = pS + "datafattura=" + $('#data-fattura').val() + "&";
    pS = pS + "transazione=" + numtrans_up + "&";
    pS = pS + "associato=" + $('#associato').val() + "&";
    pS = pS + "numscontrino=" + $('#scontrino').val() + "&";
    pS = pS + "numfattura=" + numfat_up + "&";
    pS = pS + "prefissofattura=" + $('#prefisso').val() + "&";
    pS = pS + "barraanno=" + $('#barra_anno').val() + "&";
    pS = pS + "suffissofattura=" + $('#suffisso').val() + "&";
    pS = pS + "numerocarta=" + $('#ccredito').val() + "&";
    pS = pS + "scadenzacarta=" + $('#cc_exp').val() + "&";
    
		// commento questo blocco perchè provo a passare sempre il tipo di documento che lo leggo dalla fattura che ripesco per id se è modifica
    /*if($('#id_php').val()==''){	
    	pS = pS + "tipo=" + tipo_mod + "&";		/////////////////////// al momento non tocco il tipo di modulo
	}*/
	pS = pS + "tipo=" + tipo_mod + "&";
	
    pS = pS + "valuta=" + "" + "&";
    pS = pS + "duty=" + $('#duty').val() + "&";
    pS = pS + "duty1=" + $('#duty1').val() + "&";
    pS = pS + "scadenzamodulo=" + scadenza_mod_dichiarazione + "&";
    pS = pS + "annullata=" + "" + "&";
    pS = pS + "totalefattura=" + totale_fattura.toFixed(2) + "&";
    pS = pS + "totaleiva=" + totale_imposta.toFixed(2) + "&";
    pS = pS + "totaleimponibile=" + totale_imponibile.toFixed(2) + "&";
    pS = pS + "rimborso=" + $('#rimbo').val() + "&";
    //pS = pS + "rimborso2=" + "0" + "&";
    pS = pS + "rimborso2=" + $('#tot_refund2').val() + "&";
    pS = pS + "luogonascita2=" + "" + "&";
    /*pS = pS + "datanascita=" + "" + "&";
    pS = pS + "luogonascita=" + "" + "&";
    pS = pS + "nazionetur2=" + "" + "&";*/
    pS = pS + "id_php=" + $('#id_php').val() + "&";
    pS = pS + "username=" + $('#user').val() + "&";
    pS = pS + "password=" + $('#psw').val() + "&";
    pS = pS + "tab=" + $('#tabella_iva').val() + "&";
    pS = pS + "scontoimpo=" + "0" + "&";		// lasciamo zero????
    pS = pS + "tiposconto=" + sconto + "&";
    pS = pS + "scontoiva=" + "0" + "&";			// lasciamo zero????
    pS = pS + "versione=" + "3.0b" + "&";
    for(k=0;k<qta.length;k++)
      {
      j = k + 1;
      pS = pS + "quantita[" + j + "]=" + qta[k] + "&";
      pS = pS + "descrizione[" + j + "]=" + desc[k] + "&";
      pS = pS + "codice_iva[" + j + "]=" + iva[k] + "&";
      pS = pS + "imponibile[" + j + "]=" + imponibile[k] + "&";
      pS = pS + "iva[" + j + "]=" + imposta[k] + "&";
      pS = pS + "totale[" + j + "]=" + tot[k] + "&";
      pS = pS + "sconto[" + j + "]=" + sco[k] + "&";
      pS = pS + "totale_sconto[" + j + "]=" + "0" + "&";		// lasciamo zero????
      pS = pS + "iva_sconto[" + j + "]=" + "0" + "&";			// lasciamo zero????
      pS = pS + "imponibile_sconto[" + j + "]=" + "0" + "&";	// lasciamo zero????
      }

	if(!lock){
		alert('Impossibile Emettere Fattura, Record Occupato Riprovare Tra Qualche Minuto.');
		return false;
	}	
	if(!risultato_sessione){
    /*$.ajax({
    	beforeSend:sessione_scaduta,
      type: 'post',
      async: false,
      url: 'webservices/salvadati_taxewin.php',
      data: pS,
      success: function(result) {
        	  var ok=result.substr(0,2);
      	  var oko=result;
      	  if(ok!="OK")
      	    {
			alert("SI E' VERIFICATO UN ERRORE IN SALVATAGGIO DATI:" + oko);
			}
		  else
		    {
            id_php=result.substr(2,8);
            $('#id_php').val(id_php);
			}
          },
      error: function(err, textStatus, errorThrown) {
          console.log("errore salvadati: " + textStatus + " " + errorThrown);
          },
      dataType: 'text'
      });*/
      /////////////////////////////////// sostituisco la chiamata precedente con questa per poter gestire la risposta webservice
      //console.log(pS);
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			async: false,
			url: 'webservices/salvadati_taxweb.php',
			data: pS,
			success: function(result) {
				result=JSON.parse(result);
				//console.log(result);
				//console.log(result.error['0'].err_mess); 
				if(result.status=="OK"){
					id_php=result.resource_id;
					$('#id_php').val(result.resource_id);
					//console.log(id_php);
				}else{	            
					if(result.error['0'].err_fields != 'undefined'){
					var arr_miss=result.error['0'].err_fields;
					//console.log(result.error['0'].err_fields); 
					for(key_post in arr_miss){
							var campo=array_campi_post[arr_miss[key_post]];
							$('#'+campo).css({'background-color' : 'red'}).attr('disabled',false);
						}	            	
					}else{
						console.log(result);
					}
					flag_ajax=true;
					var html='';
					html=result.error['0'].err_mess;
					$( "#dialog_msg_web" ).dialog({
										autoOpen: false,
										modal: true,
										async: false,
										closeOnEscape: false,
										title:'AVVISO',
										buttons: {	Ok: function() {
																	$(this).dialog("close");
																	$(this).empty();
																	}
												}
					});
					$('#dialog_msg_web').dialog("option", "minWidth", '50%');
					$('#dialog_msg_web').dialog("option", "maxWidth", '90%');
					$( "#dialog_msg_web" ).html(html);
					$( "#dialog_msg_web" ).dialog( "open" );
					return;
				}
			},
				error: function(err, textStatus, errorThrown) {
				console.log("errore salvadati: " + textStatus + " " + errorThrown);
			},
			dataType: 'text'
		});
		///////ora stampa pdf SE NON HO PROBLEMI DI DATI MANCANTI
		if(!flag_ajax){
			stampa_pdf(id_php);
	    	pulisci_array();
	    	return true;
		}
	} 
	return false;
}

function stampa_pdf(id_php) {
    var asso_pdf=$('#associato').val();
    var user_pdf=$('#user').val();
    var psw_pdf=$('#psw').val();
    
    function get_pdf(id_php){
    	
		$.ajax({
			url: 'taxewin_session.php',
			dataType: 'json',
			async: false,
			success: function(result) {
					if(!result){
						switch(true){
							case /1/.test(download_conf):
								$('body').append('<div class="modal" id="modal_pdf"><iframe  id="frame_pdf" class="iframe" src="get_pdf.php?id=' + id_php + '" ></iframe></div>');	//passato da get_pdf_down a get_pdf per peruzzi almeno apre subito
								//$("#modal_pdf").empty(); 
								//$("#modal_pdf").remove(); 
								break;
							case /Win/.test(navigator.platform):
								/*html="<iframe src='get_pdf.php?id=" + id_php + "' style='overflow:hidden;height:100%;width:100%'></iframe>";
								$( "#dialog_pdf" ).dialog({
									autoOpen: false,
									modal: true,
									width:1100,
									height:700,
									async: false,
									draggable:false,
									title:'Stampa Fattura',
									buttons: {	Chiudi: function() {
																	$("#dialog_pdf").dialog("close");
																	$("#dialog_pdf").empty();
																}
											}
								});*/
								
								$('body').append('<div class="modal" id="modal_pdf"><div id="divframe"><iframe  id="frame_pdf" class="iframe" src="get_pdf.php?id=' + id_php + '" ></iframe><input type="button" id="modal_chiudi" value="Chiudi"/></div></div>');
								$("#modal_pdf").show();								
								$('#modal_chiudi').on('click',function(){
																			$("#modal_pdf").empty(); 
																			$("#modal_pdf").remove(); 
																		});
								//onload="function daje(){ var pdfFrame = window.frames["frame_pdf"];pdfFrame.document.getElementById(\'print\').focus();pdfFrame.print(); } daje();"
								//pdfFrame.print();																
								disply_blocchi(mobile);
								break;
							case /Mac/.test(navigator.platform):
								/*html="<iframe src='get_pdf.php?id=" + id_php + "' style='overflow:hidden;height:100%;width:100%'></iframe>";
								$( "#dialog_pdf" ).dialog({
									autoOpen: false,
									modal: true,
									width:1100,
									height:700,
									async: false,
									draggable:false,
									title:'Stampa Fattura',
									buttons: {	Chiudi: function() {
																	$("#dialog_pdf").dialog("close");
																	$("#dialog_pdf").empty();
																}
											}
								});*/
								$('body').append('<div class="modal" id="modal_pdf"><div id="divframe"><iframe class="iframe" src="get_pdf.php?id=' + id_php + '" /><input type="button" id="modal_chiudi" value="Chiudi"/></div></div>');
								$("#modal_pdf").show();
								$('#modal_chiudi').on('click',function(){
																			$("#modal_pdf").empty(); 
																			$("#modal_pdf").remove(); 
																		})
								disply_blocchi(mobile);
								break;
							case /Android/.test(navigator.platform):
								html='Cliccare Download Per Scaricare E Poi Stampare La Fattura';
								$( "#dialog_pdf" ).dialog({
									autoOpen: false,
									modal: true,
									async: false,
									closeOnEscape: false,
									draggable:false,
									title:'Stampa Fattura',
									buttons: {	Download:function(){
														//$('body').append('<iframe src="get_pdf_down.php?id=' + id_php+ '" style="display: none;" ></iframe>');
														$("#dialog_pdf").empty();
														$("#dialog_pdf").html('<iframe src="get_pdf_down.php?id=' + id_php + '" style="display: none;" ></iframe>');
														$("#dialog_pdf").dialog("close");
												},										
												Chiudi: function() {
														$("#dialog_pdf").dialog("close");
														$("#dialog_pdf").empty();
												}
											}
								});
								$('#dialog_pdf').dialog("option", "minWidth", '50%');
								$('#dialog_pdf').dialog("option", "maxWidth", '90%');
								$( "#dialog_pdf" ).html(html);	
								$( "#dialog_pdf" ).dialog( "open" );
								disply_blocchi(mobile);
								break;
							default :
								html='Premere Download Per Scaricare E Stampare La Fattura';
								$( "#dialog_pdf" ).dialog({
									autoOpen: false,
									modal: true,
									width:"auto",
									height:200,
									async: false,
									closeOnEscape: false,
									draggable:false,
									title:'Stampa Fattura',
									buttons: {	Download:function(){
														$("#dialog_pdf").empty();
														window.open('get_pdf_down.php?id=' + id_php, '_BLANK');
														$("#dialog_pdf").dialog("close");
												},										
												Chiudi: function() {
														$("#dialog_pdf").dialog("close");
														$("#dialog_pdf").empty();
												}
											}
								});
								$( "#dialog_pdf" ).html(html);	
								$( "#dialog_pdf" ).dialog( "open" );
								disply_blocchi(mobile);
								break;
						}
					}else{
						return;
					}
			},
			error: function(err, textStatus, errorThrown) {
		          	console.log("errore stampa pdf: " + textStatus + " " + errorThrown);
		    }
		});
	}
    
    var dati="associato=" + asso_pdf + "&id_php=" + id_php + "&username=" + user_pdf + "&password=" + psw_pdf;
    var html;
    $.ajax({
    		type: 'post',
		    async: false,
		    url: 'webservices/get_resource.php',
		    data: dati,
		    responseType: 'arraybuffer',
		    success: function(result) {
		      			get_pdf(id_php);
		    },
		    error: function(err, textStatus, errorThrown) {
		          console.log("errore stampa pdf: " + textStatus + " " + errorThrown);
		        	return;
		    }
	});
}
    
function remove_pdf() {
    var elem = document.getElementById('stampapdf');
    elem.parentNode.removeChild(elem);
    }

function calcola_rimborso() {
    t_totali = new Array();
    t_totali_iva = new Array();
    var tabella=$('#tabella_iva').val();
    if(duty_conf && modulo_duty){
    	var tabella=$('#tabella_iva_2').val();		//duty
	}
	var tabella3=$('#tabella_iva_3').val();		//doppio rimb
    var iva="";
    var calc_rimborso='';
    var duty=0;
    var duty1=0;
    //var calc_rimborso_duty='';
    for(j=0;j<tot_ali.length;j++)
       {
       //iva=tot_ali[j].toString();
       iva=parseInt(tot_ali[j]);
       t_totali[iva]=tot_tot[j];
       t_totali_iva[iva]=tot_imposta[j];
       }
    var jtotali = JSON.stringify(t_totali);
    var jtotali_iva = JSON.stringify(t_totali_iva);
    
    $.ajax({
    	beforeSend:sessione_scaduta,
		type: 'post',
		async: false,
		url: 'calcola_rimborso.php',
		data: 'tab=' + tabella + '&totali=' + jtotali + '&t_totali_iva=' + jtotali_iva,
		success: function(result) {
			//console.log(result);
			calc_rimborso=result.refund;
			document.getElementById("rimbo").value=calc_rimborso.toFixed(2);
			if(duty_conf  && modulo_duty){
				duty = calc_rimborso = result.tot - calc_rimborso;
				document.getElementById("duty").value = duty.toFixed(2);
				duty1 = (result.iva * perc_spese_duty/100) *100;
				duty1 = duty1 / 100;
				if(duty1 < 10){
					duty1 = result.iva + min_spese_duty;
				}else{
					duty1 = result.iva + duty1;
				}
				document.getElementById("duty1").value = duty1.toFixed(2);
				
				//console.log(duty1);  
			}
			//alert(calc_rimborso + ' xx ' + result.tot + ' xx ' + calc_rimborso_duty);
			document.getElementById("tot_refund").value=calc_rimborso.toFixed(2);
			
			//alert(result.query);
		},
		error: function(err, textStatus, errorThrown) {
		console.log("error ajax calcolarimborso" + textStatus + " " + errorThrown);
		},
		dataType: 'json'
	});
	//calcola tot_refind2 su tabella3 se rimborso_cash=1
    document.getElementById("tot_refund2").value="0";
    if(document.getElementById("rimborso_cash").value=="1"){
	    $.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			async: false,
			url: 'calcola_rimborso.php',
			data: 'tab=' + tabella3 + '&totali=' + jtotali + '&t_totali_iva=' + jtotali_iva,
			success: function(result) {
				// document.getElementById("tot_refund2").value=result.refund.toFixed(2);				/// tolgo i decimali sul secondo rimorso e passo a .00
				document.getElementById("tot_refund2").value=result.refund.toFixed(2).slice(0,-2)+'00';
				//alert(result.query);
				//console.log(result);
			},
			error: function(err, textStatus, errorThrown) {
			console.log("error ajax calcolarimborso" + textStatus + " " + errorThrown);
			},
			dataType: 'json'
	    });
	}
	/*if(duty_conf){
		$.ajax({
	    	beforeSend:sessione_scaduta,
			type: 'post',
			async: false,
			url: 'calcola_rimborso.php',
			data: 'tab=' + tabella2 + '&totali=' + jtotali + '&t_totali_iva=' + jtotali_iva,
			success: function(result) {
			document.getElementById("tot_refund").value=result.refund.toFixed(2);
			//alert(result.query);
			},
			error: function(err, textStatus, errorThrown) {
			console.log("error ajax calcolarimborso" + textStatus + " " + errorThrown);
			},
			dataType: 'json'
		});
	}*/
    //////////////////////////////// inserire conteggio duty addebbito ??????????????????????????
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// BLOCCO TEST PROMISE
function $http(url){
 
	// Piccolo esempio di oggetto
	var core = {
				// Metodo che realizza la chiamata ajax
				ajax : function (method, url, args) {
														// Creazione della promise
														var promise = new Promise( function (resolve, reject) {
																												// Generazione di una XMLHttpRequest
																												var client = new XMLHttpRequest();
																												var parameter='';
																												var uri = url;
																												if (args) {
																													
																													switch(method){
																														case 'GET':
																															uri += '?';
																															var argcount = 0;
																															for (var key in args) {
																																if (args.hasOwnProperty(key)) {
																																	if (argcount++) {
																																		uri += '&';
																																	}
																																uri += encodeURIComponent(key) + '=' + encodeURIComponent(args[key]);
																																}
																															}																										
																														break;
																														
																														case 'POST':
																															var argcount = 0;
																															for (var key in args) {
																																if (args.hasOwnProperty(key)) {
																																	if (argcount++) {
																																		parameter += '&';
																																	}
																																parameter += encodeURIComponent(key) + '=' + encodeURIComponent(args[key]);
																																}
																															}																										
																														break;
																													}
																													
																													
																												}
																												client.open(method, uri,true); 
																												client.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
																												client.setRequestHeader("Content-length", parameter.length);
																												client.setRequestHeader("Connection", "close");
																												client.send(parameter);

																												client.onload = function () {
																																				  if (this.status == 200) {
																																						// Performa la funzione "resolve"
																																						// quando this.status è 200
																																					   resolve(this.response);
																																				  } else {
																																						// Performa la funzione "reject"
																																						// quando this.status è diverso da 200
																																						reject(this.statusText);
																																				  }
																																			};
																												client.onerror = function () {
																													reject(this.statusText);
																												};
																											}
																					);

														  // Restituisce la promise
														  return promise;
														}
	  };

	  // Adapter pattern
	return {
				'get' : function(args) {
				  return core.ajax('GET', url, args);
				},
				'post' : function(args) {
				  return core.ajax('POST', url, args);
				},
				'put' : function(args) {
				  return core.ajax('PUT', url, args);
				},
				'delete' : function(args) {
				  return core.ajax('DELETE', url, args);
				}
			};
};
// End A

/*// B-> Qui si definisce la sua funzione e il suo payload
var mdnAPI = 'https://developer.mozilla.org/en-US/search.json';
var payload = {
  'topic' : 'js',
  'q'     : 'Promise'
};

var callback = {
  success : function(data){
     console.log(1, 'success', JSON.parse(data));
  },
  error : function(data){
     console.log(2, 'error', JSON.parse(data));
  }
};
// End B

// Esegue la chiamata al metodo 
$http(mdnAPI) 
  .get(payload) 
  .then(callback.success) 
  .catch(callback.error);

// Esegue la chiamata al metodo con un metodo alternativo (1)
// di risolvere il caso di fallimento 
$http(mdnAPI) 
  .get(payload) 
  .then(callback.success, callback.error);*/
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// BLOCCO TEST PROMISE


function numfattura(){
	
	var d = new Date();
	var qstanno = d.getFullYear(); 

	$.ajax({
		beforeSend:sessione_scaduta,
      type: 'post',
      async: false,
      url: 'taxewin_numfat.php',
      success: function(result) {
      		if(!result.esito){
      			if(result.anno<qstanno){
					alert('Essendo entrati nel ' + qstanno + ' reimpostate il numero fattura a vostro piacimento o ripartirà in automatico da 1');
				}
          		$('#numero').val(result.numfatt);
          		if($('#id_php').val()=='' || ( $('#id_php').val()=='' && $('#trans_num').val()!='' ) ){
          			$('#trans_num').val(result.transaction);
          			$('#transazione').html('Transazione : ' + result.transaction);
				}
          	}else{
				alert(result.msg);
			}
        },
      error: function(err, textStatus, errorThrown) {
          console.log("errore ajax numfattura()" + textStatus + " " + errorThrown);
        },
      dataType: 'json'
    });
}

function presuf(){

	$.ajax({
		beforeSend:sessione_scaduta,
      type: 'post',
      async: false,
      url: 'taxewin_presuf.php',
      success: function(result) {
      		if(result.length!=0){
          		$('#prefisso').val(result.pref);
          		$('#suffisso').val(result.suff);
          	}else{
				alert('Problema query presuf() o Sessione Scaduta');
			}
        },
      error: function(err, textStatus, errorThrown) {
          console.log("errore ajax presuf()" + textStatus + " " + errorThrown);
        },
      dataType: 'json'
    });
}

function sbianca_campi(){

	$(':text').not('#data-fattura,#associato,#tabella-iva,#indice,#data_login,#user,#psw,#data-da,#data-a').val('');
	$(':input[type="number"]').val('');								
	$('#id_php').val('');
	$('#tipo_documento').val('');	//sbianco il campo che ho inserito per capire in modifica il tipo di documento
	//$(':hidden').not('').val('');
	$('#box-totali,#box-articoli').empty();
	$('#box-principale').css({'background-color':'#ffd600'});
	$('#box_cc :text').css({'background-color':''});
	$('select option:first').attr('selected',true);
	$('#qta_mob').val($('#qta_mob option:first').val());
	$('#desc_mob').val($('#desc_mob option:first').val());
	$('#iva').val($('#iva option:first').val());
	$('#trans_num').val('');
	$("#tur_fastline").show();
	$("#tur_vipdesk").hide();
	$('#data-fattura').val(carica_data);
	id_assistenza='';
	card_turista='';
}

function archivio(asso,da,a,fat,gg_max,evento){

	var associato=asso;
	var data_da=da;
	var data_a=a;
	var num_fat=fat;
	var html='<div id="intestazione" style="text-align:center">Nessuna Fattura Presente In Archivio</div>';
	var gg_max=gg_max;

	if(diff_date(da,a,gg_max) || fat!=''){
		$.ajax({
			beforeSend:sessione_scaduta,
		  	type: 'post',
		    url: 'taxewin_archivio.php',
		    dataType: 'json',
		    async: false,
		    data: {associato:associato, data_da:data_da, data_a:data_a, num_fat:num_fat},
		    success: function(data){
		    	//console.log(data);
    					if(data.length!=0){
    						//console.log(data.lista);
						html='<div id="intestazione">'+
								'<table id="ark">'+
    									'<tr class=\"focus_archivio\">'+
    										'<td>Num</td>'+
    										'<td>Data</td>'+
    										'<td>Tipo</td>'+
    										'<td>Transazione</td>'+
    										'<td>Turista</td>'+
    										'<td>Annullata</td>'+
    										'<td>Totale</td>'+
    										'<td id="utility" colspan="4">Utility</td>'+
    									'</tr>'+
								'</table></div><div id="lista" tabindex="1"><table class="macro_blocchi_archivio1" id="lista_row">';
							for(var i=0; i<data.length; i++){
								var color_annul_duty='';
								if(data[i].data_annulla!='0000-00-00 00:00:00'){
									var data_annull='<img src="img/del.png" title="Fattura Annullata" />';
									var ristampa='';
									var modifica='';
									var elimina='';
									var mod_mobile='';
									if(data[i].transazione != 0 && data[i].transazione != ''){
										color_annul_duty='annulla_duty';
									}
								}else{
									var data_annull='';
									var id_php=data[i].id;
									var ristampa='<img src="img/printer.png" title="Ristampa" onclick="stampa_pdf(' + data[i].id + ');" id="row' + data[i].id + 'img1" class="img_tools" />';
									var modifica='<img src="img/edit.png" title="Modifica" onclick="modifica(' + data[i].id + ');" id="row' + data[i].id + 'img2" class="img_tools" />';
									var elimina='<img src="img/trash.png" title="Elimina" onclick="elimina(' + data[i].id + ',' + data[i].numfattura + ',' + data[i].transazione + ');" id="row' + data[i].id + 'img3" class="img_tools" />';
									var mod_mobile='<img src="img/mod.png" title="Modifica" onclick="impostazioni_mob(' + data[i].id + ',' + data[i].numfattura + ',' + data[i].transazione + ')" id="row' + data[i].id + 'img2" class="img_tools" />';
								}
								var data_fat=data[i].datafattura;
								data_fat=data_fat.substr(8,2)+'-'+data_fat.substr(5,2)+'-'+data_fat.substr(0,4);
								if(data[i].tipo=='' || data[i].tipo=='T'){	var tipo_mod_archivio='Tax';	}else{	/*var tipo_mod_archivio=data[i].tipo;*/ var tipo_mod_archivio='Duty';	}
								html+='<tr class=\' ' + color_annul_duty + ' \' id="row' + data[i].id + '">'+
    										'<td>'+ data[i].numfattura +'</td>'+
    										'<td>'+ data_fat +'</td>'+
    										'<td calss="hvr-grow-shadow">'+ tipo_mod_archivio +'</td>'+
    										'<td>'+ data[i].transazione +'</td>'+
    										'<td>'+ data[i].nometur +'</td>'+
    										'<td>'+ data_annull +'</td>'+
    										'<td>'+ data[i].totalefattura +'</td>'+
    										'<td>'+ ristampa +'</td>'+
    										'<td>'+ modifica +'</td>'+
    										'<td></td>'+
    										'<td>'+ elimina +'</td>'+
    										'<td colspan="4">'+ mod_mobile +'</td>'+
    									'</tr>';
							}
							html+='</table></div>';
	    				}
	    				$('#box-ins').hide();
	    				$('#box-archivio').show();
	    				//$('#box-fatture').html(html);
	    				document.getElementById('box-fatture').innerHTML=html;
	    				
		    		},
				error: function(err, textStatus, errorThrown) {
	          		console.log("error ajax archivio "+ textStatus + " " + errorThrown);
	        }
			});
	}else{
		alert('Inserire Massimo Intervallo Di 3 Mesi');
	}
	$('img[id^=print_archivio_id]').on('click',function(){
		var id_ristampa=this.name
		switch(true){
						case /Win/.test(navigator.platform):
							stampa_pdf(id_ristampa);
							break;
						case /Mac/.test(navigator.platform):
							stampa_pdf(id_ristampa);
							break;
						case /Linux/.test(navigator.platform):
							stampa_pdf(id_ristampa);
							break;
						default :
							$("#ajax_loader").show(function(){
								stampa_pdf(id_ristampa);
							});
							break;
					}
		});
	//console.log(document.getElementById('lista_row'));
	if(document.getElementById('lista_row') != null && tastiera_conf){
		muoversi_frecce_tabella('lista','lista_row','.img_tools','img',3,"#2A8B45",'yellow');
		/*if(tastiera_conf){
			evt.preventDefault();
			$("[class*='evidenzia_blocchi_archivio']").css( { "background-color" : "" } );
    		$("[class*='evidenzia_blocchi_archivio1']").css( { "background-color" : "#00ff03" } );		
    		$('#lista').focus();
		}*/
	}	
}

function muoversi_frecce_tabella(id_div_tabella,id_tabella,class_taginrow,tag_rifrow,qnt_tagimg,color_riga,color_tag){
	var row = document.getElementById(id_tabella).rows;
	var row_lenght=row.length;
			//console.log(row);
			//console.log(prima_riga);
	//row[0].scrollIntoView(false);
	$('#'+id_div_tabella).unbind();
	//console.log($('#'+row[prima_riga].id));
	if(typeof row[prima_riga] !== 'undefined' ){
		
		$('#'+row[prima_riga].id).focus().css({"background-color":color_riga});
		var focusriga='';
		var riferimento_img=0;
		var riferimento_img_max=qnt_tagimg;
		$('#'+id_div_tabella).unbind();
		$('#'+id_div_tabella).on('keydown',function(ev) {
		    ev.preventDefault();
			//ev.stopPropagation();	
	    	function scrollToRow(class_taginrow,index_row,index_prev,e){
				
				riferimento_img=0
				var row = document.getElementById(id_tabella).rows[index_row];
				$('#'+row.id).focus().css({"background-color":color_riga});
				var row_prev = document.getElementById(id_tabella).rows[index_prev];
				$('#'+row_prev.id).css({"background-color":""});
				$('#'+row_prev.id + ' ' +class_taginrow ).css({"background-color":""});	
				if(index_row > index_prev){
					row.scrollIntoView(false);	
				}else{
					row.scrollIntoView(true);
				}
			}
			function moveToChild(index_row,tag_rifrow,id_rif,id_rif_prev){	//
				
				var row = document.getElementById(id_tabella).rows[index_row];
				
				if(id_rif_prev > 0){
					$('#' + row.id + tag_rifrow + id_rif_prev ).css({"background-color":""});	
				}
				$('#' + row.id + tag_rifrow + id_rif ).css({"background-color":color_tag}).focus();
				focusriga=row.id + tag_rifrow + id_rif;
				
			}
			switch (ev.which) {
			    case 39:	//destra
			    	riferimento_img_prev=riferimento_img;
			    	if(riferimento_img < riferimento_img_max){
						riferimento_img+=1;
						moveToChild(prima_riga,tag_rifrow,riferimento_img,riferimento_img_prev);
					}
					ev.stopPropagation();
			    	break;
			    case 37:	//sinistra
			        riferimento_img_prev=riferimento_img;
			    	if(riferimento_img > 1){
						riferimento_img-=1;
						moveToChild(prima_riga,tag_rifrow,riferimento_img,riferimento_img_prev);
					}
			    	break;
			    case 40:	// giu
			    	riga_prev=prima_riga;
			    	if(prima_riga < (row_lenght - 1)){
			    		prima_riga+=1;
						scrollToRow(class_taginrow,prima_riga,riga_prev,ev);
					}
			    	break;
			    case 38:	// su
			    	riga_prev=prima_riga;
			    	if(prima_riga>0){
			    		prima_riga-=1;			    	
						scrollToRow(class_taginrow,prima_riga,riga_prev,ev);	
					}
					break;
				case 13:	// enter
			 		//console.log(ev);
			    		$('#' + focusriga).trigger('click');
			    		
					break;
			}
		});
	}
}

function impostazioni_mob(id_mob,numfat_mob,trans_mob){
	var html="";
	 $( "#dialog_modifica" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'Impostazioni Fattura',
							buttons: {	
										Annulla: function(){
														$(this).dialog("close");
														$(this).empty();
														}
										}
					});
	html='<div><img src="img/printer.png" title="Ristampa" onclick="stampa_pdf(' + id_mob + ');" />' +
			'<img src="img/edit.png" title="Modifica" onclick="modifica(' + id_mob + ');" />' +
			'<img src="img/trash.png" title="Elimina" onclick="elimina(' + id_mob + ',' + numfat_mob + ',' + trans_mob + ');" /></div>';
	$( "#dialog_modifica" ).html(html);
	$( "#dialog_modifica" ).dialog( "open" );
}

function modifica(id){
	//var html="La Variazione Della Fattura Non è Ammessa,<br/>Se Si Effettuano Variazioni e Si Confermano Poi Premendo<br/> \"Stampa\",<br/>Verrà Generata Automaticamente:<br/>Una Nota Di Credito Per L'Attuale Fattura e <br/>Una Nuova Fattura Completa Delle Modifiche.<br/>Procedere?";
	var html="Modificare La Fattura ?";
	 $( "#dialog_modifica" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
														campi_tax_duty('tax');
														//azzero
														  indice.splice(0,indice.length);
														  qta.splice(0,qta.length);
													      desc.splice(0,desc.length);
													      iva.splice(0,iva.length);
													      imponibile.splice(0,imponibile.length);
													      imposta.splice(0,imposta.length);
													      tot.splice(0,tot.length);
													      sco.splice(0,sco.length);
														//
															sbianca_campi();
													      $.ajax({
													      		  beforeSend:sessione_scaduta,
															      type: 'post',
															      async: false,
															      url: 'leggi_dati_negozi.php',
															      data: "id_php=" + id,
															      success: function(result) {
															          dati=JSON.parse(result);
																	//console.log(dati);
																if(dati.errore_sessione!='ko'){
																	
																	$('#box-archivio').hide();
																	$('#box-principale').css({'background-color':'red'});
																    $('#box-ins').show();
																    if(dati.transazione != '' && dati.duty != '0.00' ){
																		/*$('#box-totali2-ref span').html('Ref.');
																		$('#box_duty').show();
																		modulo_duty=true;*/
																		campi_tax_duty('duty');
																		$('#trans_num').val(dati.transazione);
          																$('#transazione').html('Transazione : ' + dati.transazione);
          																$('#ccredito').val(dati.numerocarta);
          																$('#cc_exp').val(dati.scadenzacarta);
          																//$('#box-totali2-ref span').html('Duty');
																	}
																    
																    $('#name').val(dati.nometur);
																    $('#surname').val(dati.cognometur);
																    $('#gender').val(dati.sessotur);
																    $('#addr').val(dati.indirizzotur);
																    $('#email').val(dati.emailtur);
																    $('#city').val(dati.cittatur);
																    $('#country').val(dati.nazionetur);
																    if(dati.codice_nazione.length == 2){ dati.codice_nazione=codici_naz_23[dati.codice_nazione]; }
																    $('#country_cod').val(dati.codice_nazione);
																      
																    $('#tipo_doc').val(dati.tipo_doc);
																    $('#doc').val(dati.passaportotur);
																	var exp=dati.scadenza_doc.substr(8,2)+'/'+dati.scadenza_doc.substr(5,2)+'/'+dati.scadenza_doc.substr(0,4);
																    $('#exp').val(exp);															      
																    $('#nazdoc').val(dati.nazione_doc);
																    if(dati.codice_nazione_doc.length == 2){ dati.codice_nazione_doc=codici_naz_23[dati.codice_nazione_doc]; }
																    $('#nazdoc_cod').val(dati.codice_nazione_doc);
																    
																    var data_nas=dati.datanascita.substr(8,2)+'/'+dati.datanascita.substr(5,2)+'/'+dati.datanascita.substr(0,4);
																    $('#dtbirt').val(data_nas);
																    $('#citybirt').val(dati.luogonascita);
																	$('#birt').val(dati.nazionetur2);
																	if(dati.codice_nazionetur2.length == 2){ dati.codice_nazionetur2=codici_naz_23[dati.codice_nazionetur2]; }
																	$('#birt_cod').val(dati.codice_nazionetur2);
																	
																    var data_fat=dati.datafattura.substr(8,2)+'/'+dati.datafattura.substr(5,2)+'/'+dati.datafattura.substr(0,4);
																    $('#data-fattura').val(data_fat);
																    $('#associato').val(dati.associato);
																    $('#scontrino').val(dati.numscontrino);
																    $('#numero').val(dati.numfattura);
																    $('#prefisso').val(dati.prefissofattura);
																    $('#barra_anno').val(dati.barraanno);
																    $('#suffisso').val(dati.suffissofattura);
																    $('#tipo_documento').val(dati.tipo_documento);	//aggiunto per poter capire che tipo di documento è quando sono in modifica ,altrimenti lo risalvuo vuoto e i duty diventano tax
																    totale_fattura=dati.totalefattura;
																    totale_imposta=dati.totaleiva;
																    totale_imponibile=dati.totaleimponibile;
																    $('#tot_fattura').val(dati.totalefattura);
																    
																	
																	
																    $('#tot_refund').val(dati.rimborso);
																    $('#id_php').val(dati.id);
																    var items=0;
																    for (key in dati.desc){
																        if(dati.desc.hasOwnProperty(key))
																        	items++;
																        }
																    items++; //indice parte da 1
																    for(j=1;j<items;j++){
																        var k = j - 1;
																        qta[k]=parseFloat(dati.qta[j]);
																        desc[k]=dati.desc[j];
																        tot[k]=parseFloat(dati.prezzo[j]);
																        iva[k]=parseFloat(dati.codiva[j]);
																        imponibile[k]=parseFloat(tot[k]*100/(100+iva[k]));
																        imponibile[k]=imponibile[k].toFixed(2);
																        imposta[k]=tot[k]-imponibile[k];
																        imposta[k]=imposta[k].toFixed(2);
																        sco[k]=dati.sconto_art[j]
																	}
																    disegna_tabella();
																    //disabilita_turista();
																    //$('#tur_canc').hide();
																}else{
																	return;
																}

															          },
															      error: function(err, textStatus, errorThrown) {
															          console.log("errore leggi_dati_negozi: " + textStatus + " " + errorThrown);
															          }
													      });
															$(this).dialog("close");
														},
										Annulla: function(){

														$(this).dialog("close");
														}
										}
					});

	$( "#dialog_modifica" ).html(html);
	$( "#dialog_modifica" ).dialog( "open" );
}


function elimina(id, fattura, trans){
	var html="Elimina la Fattura " + fattura +"?";
	 $( "#dialog_elimina" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
															$.ajax({
																	  beforeSend:sessione_scaduta,
																      type: 'post',
																      async: false,
																      url: 'elimina_fattura.php',
																      data: "id=" + id + "&trans=" + trans,
																      success: function(result) {
																      	  $('#ricerca').click();
																          },
																      error: function(err, textStatus, errorThrown) {
																          console.log("errore elimina fattura: " + textStatus + " " + errorThrown);
																          }
																    });
															$(this).dialog("close");
														},
										Annulla: function(){

														$(this).dialog("close");
														}
										}
					});

	$( "#dialog_elimina" ).html(html);
	$( "#dialog_elimina" ).dialog( "open" );

}

function tasto_presuf(){
	var pref;
	var suf;
	var html='<div id="opz-presuf">'+
				    '<label id="lbl-prefisso">Prefisso<br/><input id="opz-prefisso" class="input_prefsuf" value="'+ $('#prefisso').val() +'"/></label>'+
				    '<label id="lbl-numero">Numero<br/>Fattura<br/><input id="opz-numero" value="'+ $('#numero').val() +'" disabled/></label>'+
				    '<label id="lbl-suffisso">Suffisso<br/><input id="opz-suffisso" class="input_prefsuf" value="'+ $('#suffisso').val() +'"/></label>'+
				'</div>';
	
	butt_dialog	=	[	{	text: "Ok", "id": 'ok_presuf', click: function() {
															pref=$('#opz-prefisso').val();
															suf=$('#opz-suffisso').val();
															$.ajax({
																		beforeSend:sessione_scaduta,
																      type: 'post',
																      async: false,
																      dataType: 'json',
																      url: 'taxewin_opzioni.php',
																      data:{prefisso:pref, suffisso:suf},
																      success: function(result) { 
																      							if(result.length>0){
																									alert('Problema Query Modifica Impostazioni: '+result.risp);
																								}
																								presuf();
																        	},
																      error: function(err, textStatus, errorThrown) {
																      			console.log("Errore Modifica Opzioni: " + textStatus + " " + errorThrown);
																    		}
																    });
															
															$(this).dialog("close");	}	},
						{	text: "Annulla", click: function() {	$(this).dialog("close");	}	}	];
	
	$( "#dialog_opzioni1" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'OPZIONI'/*,
							buttons: {	Ok: function() {
															pref=$('#opz-prefisso').val();
															suf=$('#opz-suffisso').val();
															$.ajax({
																		beforeSend:sessione_scaduta,
																      type: 'post',
																      async: false,
																      dataType: 'json',
																      url: 'taxewin_opzioni.php',
																      data:{prefisso:pref, suffisso:suf},
																      success: function(result) { 
																      							if(result.length>0){
																									alert('Problema Query Modifica Impostazioni: '+result.risp);
																								}
																								presuf();
																        	},
																      error: function(err, textStatus, errorThrown) {
																      			console.log("Errore Modifica Opzioni: " + textStatus + " " + errorThrown);
																    		}
																    });
															
															$(this).dialog("close");
														},
										Annulla: function(){

														$(this).dialog("close");
														}
										}*/
					});
	$('#dialog_opzioni1').dialog("option", "minWidth", '50%');
	$('#dialog_opzioni1').dialog("option", "maxWidth", '90%');
	$("#dialog_opzioni1" ).html(html);
	//$("#dialog_opzioni1" ).dialog( "open" );
	$("#dialog_opzioni1").dialog('option','buttons', butt_dialog).dialog( "open" );
	$("#opz-prefisso").focus();
	
	/*$('#opz-presuf :input').on('focus',function(evt){
		$(this).css({'border':'2px solid #FF0000 !important'});
	});
	$('#opz-presuf :input').on('blur',function(evt){
		$(this).css({'border':''});
	});*/
	
	$('.input_prefsuf').on('keydown',function (e) {
         if (e.which === 13) {
             var index = $('.input_prefsuf').index(this) + 1;
             if($('.input_prefsuf').eq(index).length) {
  				$('.input_prefsuf').eq(index).focus();
			}else{
				e.preventDefault();
			 	$('#ok_presuf').focus();
			 } 
         }
    });

}

function tasto_numfat(){
	if(confirm("Cambio numero fattura, bloccherà l\'emissione max 2 minuti.")){
		$.ajax({
			beforeSend:sessione_scaduta,
		    type: 'post',
			async: false,
			url: 'taxewin_readlock_numfat.php',
			dataType: 'json',
			success: function(result) {
				//console.log(result);
							if(!result.esito){
								var html='<div id="opz_numfat">'+
											    '<label id="opz_numfat_lblnumero">Prossimo Numero Fattura<br/><input id="opz_numfat_numero" value="'+ result.numfattura +'" /></label>'+
											'</div>';
											
								$( "#dialog_opzioni2" ).dialog({
														autoOpen: false,
														modal: true,
														async: false,
														closeOnEscape: false,
														title:'OPZIONI',
														buttons: {	Ok: function() {
																						var html;
																						var flag=false;
																						var numvero=$('#opz_numfat_numero').val();
																																					
																						if(isNaN(numvero || numvero<1)){
																											html='Il Numero Di Fattura Deve Essere Numerico<br/> E Maggiore Di 0'; 
																											flag=true;
																										}else{	
																												var ver=verifica_numfat(numvero,$('#data-fattura').val());
																												if(ver>0){
																															html='Fattura Gi&agrave; Presente In Archivio.'; 
																															flag=true;
																														}
																										}														
																						if(flag){
																									//alert('1');
																									
																									$( "#dialog_alert_numfat" ).dialog({
																												autoOpen: false,
																												modal: true,
																												async: false,
																												closeOnEscape: false,
																												title:'AVVISO',
																												buttons: {	Ok: function() {
																																			$(this).dialog("close");
																																			}
																														}
																									});
																									$( "#dialog_alert_numfat" ).html(html);
																									$( "#dialog_alert_numfat" ).dialog( "open" );
																									return;
																								}																
																							num=numvero-1; ///////////////////////// faccio meno uno perchè in tabella devo segno l'ultima emessa e poi la incremento in emissione es.(per fare la 40 devo scrivere 39)
																							//alert('2');
																							$.ajax({
																									beforeSend:sessione_scaduta,
																								      type: 'post',
																								      async: false,
																								      dataType: 'json',
																								      url: 'taxewin_saltofattura.php',
																								      data:{numero:num},
																								      success: function(result) {
																								      							//alert('3'); 
																								      							if(!result){
																																	alert('Problema Query Inserimento Salto Fattura per num: '+numvero);
																																}else{
																																	numfattura();
																																}
																								        	},
																								      error: function(err, textStatus, errorThrown) {
																								      			console.log("Errore Modifica Salto Fattura: " + textStatus + " " + errorThrown);
																								    		}
																						    });
																						$(this).dialog("close");
																						$(this).empty();
																					},
																	Annulla: function(){
																					$.ajax({
																						beforeSend:sessione_scaduta,
																						type: 'post',
																						async: false,
																						dataType: 'json',
																						url: 'taxewin_saltofattura.php',
																						data:{annulla:'annulla'},
																						success: function(result) {
																												//alert('3'); 
																												if(!result){
																													alert('Problema Con Sblocco Record Salto Fattura Contattare Taxrefund');
																												}
																						},
																						error: function(err, textStatus, errorThrown) {
																								console.log("Errore Modifica Salto Fattura: " + textStatus + " " + errorThrown);
																						}
																					});
																					$(this).dialog("close");
																					$(this).empty();
																					}
																	}
								});
								$( "#dialog_opzioni2" ).html(html);
								$('#dialog_opzioni2').dialog("option", "minWidth", '50%');
								$('#dialog_opzioni2').dialog("option", "maxWidth", '90%');
								$( "#dialog_opzioni2" ).dialog( "open" );	
						  	}else{
								alert(result.msg);
							}
		    },
		    error: function(err, textStatus, errorThrown) {
		    	console.log("errore ajax salto fattura" + textStatus + " " + errorThrown);
		    }
	    });
	    $('#opz_numfat_lblnumero').focus();
	    $('#opz_numfat_lblnumero').on('keydown',function(evt){
	    	if(evt.which == 13){
	    		evt.preventDefault();
	    		$('#opz_numfat_lblnumero').parent().parent().next().children().children('button:first-of-type').focus();
				//alert($('.ui-button:focus input.ui-button').parent().next().attr('class'));
				//$('.ui-button:focus').parent().next().focus();
				//console.log($('#opz_numfat_lblnumero').parent().parent().next().children().children('button:first-of-type'));
			}
	    });
		
		
	}
}
////////////////////////////////////////////// CON QUESTA FUNZIONE VERIFICO SOLO SE IL NUM FATTURA ESISTE O NO. E NON LO SCRIVO IN TABELLA NUMERI_NEGOZI
function tasto_numfat_damod(){
	var html='<div id="opz_numfat">'+
				    '<label id="opz_numfat_lblnumero">Prossimo Numero Fattura<br/><input id="opz_numfat_numero" value="'+ document.getElementById('numero').value +'" /></label>'+
				'</div>';
				
	$( "#dialog_opzioni2" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'OPZIONI',
							buttons: {	Ok: function() {
															var html;
															var flag=false;
															var numvero=$('#opz_numfat_numero').val();
																														
															if(isNaN(numvero || numvero<1)){
																html='Il Numero Di Fattura Deve Essere Numerico<br/> E Maggiore Di 0'; 
																flag=true;
															}else{	
																var ver=verifica_numfat(numvero,$('#data-fattura').val());
																if(ver>0){
																			html='Fattura Gi&agrave; Presente In Archivio.'; 
																			flag=true;
																		}
															}														
															if(flag){
																		//alert('1');
																		
																$( "#dialog_alert_numfat" ).dialog({
																			autoOpen: false,
																			modal: true,
																			async: false,
																			closeOnEscape: false,
																			title:'AVVISO',
																			buttons: {	Ok: function() {
																										$(this).dialog("close");
																										}
																					}
																});
																$( "#dialog_alert_numfat" ).html(html);
																$( "#dialog_alert_numfat" ).dialog( "open" );
																return;
															}
															document.getElementById('numero').value=document.getElementById('opz_numfat_numero').value															
															$(this).dialog("close");
															$(this).empty();
							},
							Annulla: function(){
													$(this).dialog("close");
													$(this).empty();
												}
							}
	});
	$( "#dialog_opzioni2" ).html(html);
	$('#dialog_opzioni2').dialog("option", "minWidth", '50%');
	$('#dialog_opzioni2').dialog("option", "maxWidth", '90%');
	$( "#dialog_opzioni2" ).dialog( "open" );
	$('#opz_numfat_lblnumero').focus();
    $('#opz_numfat_lblnumero').on('keydown',function(evt){
    	if(evt.which == 13){
    		evt.preventDefault();
    		$('#opz_numfat_lblnumero').parent().parent().next().children().children('button:first-of-type').focus();
		}
    });
}

function tasto_articoli(){
	
	var select;
	//var aliquote=$('#aliquote').val();
	//var aliquote=<?php echo 'ciao' ?>;
	//aliquote=JSON.parse(aliquote);
	//console.log(aliquote);
	select='<select id="opz_articoli_iva" class="move_art" name="opz_iva">';
	
    for(var j=0; aliquote.length>j; j++ ){
		if(aliquote[j]>''){
			select+='<option value="' + aliquote[j] + '" >' + aliquote[j] + '</option>';
   		}
  	}    
	select+='</select>';
	
	var html='<div id="opz_articoli" class="evidenzia_blocchi_articoli1">'+
				    '<label id="opz_articoli_lbldescr">Descrizione Articolo<br/><input id="opz_descr_articolo" class="move_art" value="" /></label>'+
				    '<label id="opz_articoli_lbliva">' + select + '</label>'+
				    '<input id="opz_ins_articoli" class="move_art" type="button" value="Inserisci" />'+
				    '<input id="opz_riga_articolo" type="hidden" value="" />'+
				    '<input id="opz_indi_articolo" type="hidden" value="" />'+
				'</div><div id="opz_tab_articoli" tabindex="1" class="evidenzia_blocchi_articoli2"></div>';
				
	butt_dialog	=	[	{	text: "Chiudi", "id": 'chiudi_art', click: function() {
															carica_indirizzi();
															$(this).dialog("close");
															$(this).empty();	}	}	];
	
	$( "#dialog_opzioni3" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'OPZIONI'/*,
							buttons: {	Chiudi: function() {
															carica_indirizzi();
															$(this).dialog("close");
															}
										}*/
					});

	$( "#dialog_opzioni3" ).html(html);
	$('#dialog_opzioni3').dialog("option", "minWidth", '50%');
	$('#dialog_opzioni3').dialog("option", "maxWidth", '90%');
	gestione_carica_articoli();
	//$( "#dialog_opzioni3" ).dialog( "open" );
	$("#dialog_opzioni3").dialog('option','buttons', butt_dialog).dialog( "open" );
	$('#opz_ins_articoli').on('click',function(){ 
													if($("#opz_descr_articolo").val()!=''){ 
																							$("#lista_vie").css({display:'none'});
																							gestione_riga_articoli();
																							if(tastiera_conf){
																								$('#opz_tab_articoli').focus();
																				    			$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
																				    			$("[class*='evidenzia_blocchi_articoli2']").css( { "background-color" : "#00ff03" } );	
																							}
																						} 
												});
	$('.move_art').on('keydown',function (e) {
        if (e.which === 13) {
            var index = $('.move_art').index(this) + 1;
            if($('.move_art').eq(index).length) {
  				$('.move_art').eq(index).focus();
			}else{
				if($('.move_art').eq(0).val()==''){
					$('.move_art').eq(0).focus();
				}else{
					$('.move_art').eq(index).click();
				}
			} 
        }
    });
}

function gestione_carica_articoli(){
	gestione_pulisci_arrarticoli();
	$.ajax({
		beforeSend:sessione_scaduta,
	    type: 'post',
	    async: false,
	    url: 'carica_articoli.php',
	    success: function(data) {
    			//console.log(data);
      			for (var i=0; i < data.length; i++) {
			        desc_articoli.push(data[i].articolo);
			        iva_articoli.push(data[i].aliq);
			        ind_articoli.push(data[i].indi);
			    }
			    gestione_disegna_tabarticoli();
        	},
	    error: function(err, textStatus, errorThrown) {
	        console.log("errore ajax carica articoli" + textStatus + " " + errorThrown);
	        },
	    dataType: 'json'
    });
}
 
function gestione_riga_articoli(){
	
	var riga=$("#opz_riga_articolo").val();
	var indi=$("#opz_indi_articolo").val();
	
   if(riga!=""){	////////////////////////////////////////////////////// sono in modifica
     	desc_articoli[riga]=$("#opz_descr_articolo").val();
     	iva_articoli[riga]=$("#opz_articoli_iva").val();
     	ind_articoli[riga]=$("#opz_indi_articolo").val();
     	
     	$.ajax({
     				beforeSend:sessione_scaduta,
			    	type: 'post',
			      	async: false,
			      	dataType: 'json',
			      	url: 'taxewin_salvalistaart.php',
				    data:{azione:'U',articolo:desc_articoli[riga],iva:iva_articoli[riga],indice:ind_articoli[riga]},
				    success: function(result) { 
			      					//console.log(result);		
			        	},
			      	error: function(err, textStatus, errorThrown) {
			      			console.log('Errore Salvataggio UPDATE Lista Articoli ' + textStatus + ' ' + errorThrown);
			    		}
			    });
	}else{			////////////////////////////////////////////////////// sono in inserimento nuovo
     	desc_articoli.push($("#opz_descr_articolo").val());
     	iva_articoli.push($("#opz_articoli_iva").val());
     	
     	$.ajax({
     				beforeSend:sessione_scaduta,
			    	type: 'post',
			      	async: false,
			      	dataType: 'json',
			      	url: 'taxewin_salvalistaart.php',
				    data:{azione:'I',articolo:$("#opz_descr_articolo").val(),iva:$("#opz_articoli_iva").val()},
				    success: function(result) { 
			      					//console.log(result);		
			        	},
			      error: function(err, textStatus, errorThrown) {
			      			console.log('Errore Salvataggio INSERT Lista Articoli ' + textStatus + ' ' + errorThrown);
			    		}
			    });     	
    }
	gestione_pulisci_articoli();
    gestione_carica_articoli();
}

function gestione_disegna_tabarticoli(){
	var righe="";
	for(j=0;j<desc_articoli.length;j++){
       	righe = righe + "<tr id='row"+j+"'>"+
	       					"<td>" + desc_articoli[j] + "</td>"+
	       					"<td>" + iva_articoli[j] + "</td>"+
	       					"<td>" + "<img id='row"+j+"img1' class='img_art' src='img/edit.png' title='MODIFICA' onclick='gestione_modifica_articoli(" + j + ");'/></td>"+
	       					"<td>" + "<img id='row"+j+"img2' class='img_art' src='img/trash.png' title='ELIMINA' onclick='gestione_elimina_articoli(" + j + ");'/></td>"+
	       					"<input id='riga_articolo' type='hidden' value='" + j + "'/>"+
	       					"<input id='indi_articolo' type='hidden' value='" + ind_articoli[j] + "'/>"+
       					"</tr>";
	}
    righe="<table id='tab_art_lista'>" + righe + "</table>";
    $("#opz_tab_articoli").html('');
    $("#opz_tab_articoli").html(righe);
    if(document.getElementById('tab_art_lista') != null && tastiera_conf){
		muoversi_frecce_tabella('opz_tab_articoli','tab_art_lista','.img_art','img',2,'#2A8B45','yellow');
	}
    if(tastiera_conf){
		$('#opz_descr_articolo').focus();
		$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
		$("[class*='evidenzia_blocchi_articoli1']").css( { "background-color" : "#00ff03" } );	
	}
}

function gestione_pulisci_articoli(){
	$('#opz_descr_articolo').val('');
	$('#opz_riga_articolo').val('');
	$('#opz_indi_articolo').val('');
	$("#opz_articoli_iva").val($('select option:first').val());
}

function gestione_modifica_articoli(riga){
	
    $('#opz_descr_articolo').val(desc_articoli[riga]);
    var val_iva=iva_articoli[riga];
    var pad = "00";
	val_iva = pad.substring(0, pad.length - val_iva.length) + val_iva;
	$('#opz_articoli_iva').val(val_iva);
    $('#opz_riga_articolo').val(riga);
    $('#opz_indi_articolo').val(ind_articoli[riga]);
    if(tastiera_conf){
    	$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
		$("[class*='evidenzia_blocchi_articoli1']").css( { "background-color" : "#00ff03" } );
		$('#opz_descr_articolo').focus();
	}
}

function gestione_elimina_articoli(j){
	var html="Eliminare l'articolo dalla lista?";
	 $( "#dialog_articoli" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
															$.ajax({
																beforeSend:sessione_scaduta,
														    	type: 'post',
														      	async: false,
														      	dataType: 'json',
														      	url: 'taxewin_salvalistaart.php',
															    data:{azione:'D',indice:ind_articoli[j]},
															    success: function(result) { 
														      					//console.log(result);
														        	},
														      	error: function(err, textStatus, errorThrown) {
														      			console.log('Errore Salvataggio INSERT Lista Articoli ' + textStatus + ' ' + errorThrown);
														    		}
														    });
														    gestione_pulisci_articoli();
														    gestione_carica_articoli();
														    $(this).dialog("close");
														},
										Annulla: function(){
														$(this).dialog("close");
														}
										}
					});
	$( "#dialog_articoli" ).html(html);
	$( "#dialog_articoli" ).dialog( "open" );
}

function gestione_pulisci_arrarticoli(){
	desc_articoli = new Array();
	iva_articoli = new Array();
	ind_articoli = new Array();
}

function verifica_campi_cambiopsw(){
	var result=true;
	var oldpsw=$('#opz_cambiopsw_vecchia').val();
	var oldoldpsw=$('#psw').val();
	var newpsw=$('#opz_cambiopsw_nuova').val();
	var ripnewpsw=$('#opz_cambiopsw_ripeti').val();
	
	if(oldpsw!='' || newpsw!='' || ripnewpsw==''){
		
		
		if(oldpsw!=oldoldpsw || oldpsw==''){
			$('#opz_cambiopsw_vecchia').css({'background-color':'red'});
			result=false;
		}
		if(newpsw!=ripnewpsw || ripnewpsw=='' ){
			$('#opz_cambiopsw_ripeti').css({'background-color':'red'});
			if(newpsw==''){
				$('#opz_cambiopsw_nuova').css({'background-color':'red'});
			}
			result=false;
		}
		
	}
	return result;
}

function tasto_cambiopsw(){
	
	var html='<div id="opz_cambiopsw">'+
				    '<label id="opz_cambiopsw_lblvecchia" >Vecchia Password: <br/><input id="opz_cambiopsw_vecchia" class="move_password" value="" type="password" /></label><br/>'+
				    '<label id="opz_cambiopsw_lblnuova" >Nuova Password: <br/><input id="opz_cambiopsw_nuova" class="move_password" value="" type="password" /></label><br/>'+
				    '<label id="opz_cambiopsw_lblripeti" >Ripetere La Nuova Password: <br/><input id="opz_cambiopsw_ripeti" class="move_password" value="" type="password" /></label><br/>'+
				'</div>';
				
	butt_dialog	=	[	{	text: "Modifica","class": 'ok_password', "id": 'ok_password', click: function() {	
																											var oldpsw=$('#opz_cambiopsw_vecchia').val();
																											var oldoldpsw=$('#psw').val();
																											var newpsw=$('#opz_cambiopsw_nuova').val();
																											var ripnewpsw=$('#opz_cambiopsw_ripeti').val();
																											
																											if(verifica_campi_cambiopsw()){
																												$.ajax({
																														beforeSend:sessione_scaduta,
																													      type: 'post',
																													      async: false,
																													      dataType: 'json',
																													      url: 'taxewin_cambiopsw.php',
																													      data:{oldpsw:oldpsw,newpsw:newpsw},
																													      success: function(result) { 
																													      							if(!result){
																																						alert('Problema Query Inserimento Salto Fattura per num: '+numvero);
																																					}
																													        	},
																													      error: function(err, textStatus, errorThrown) {
																													      			console.log("Errore Modifica Cambio Password: " + textStatus + " " + errorThrown);
																													    		}
																												});
																												$(this).dialog("close");
																												location.href='logout.php';		
																											}		}	},
						{	text: "Annulla", click: function() {	$(this).dialog("close");	}	}	];
	
	$( "#dialog_opzioni4" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'OPZIONI'/*,
							buttons: {	Modifica: function() {
															var oldpsw=$('#opz_cambiopsw_vecchia').val();
															var oldoldpsw=$('#psw').val();
															var newpsw=$('#opz_cambiopsw_nuova').val();
															var ripnewpsw=$('#opz_cambiopsw_ripeti').val();
															
															if(verifica_campi_cambiopsw()){
																$.ajax({
																		beforeSend:sessione_scaduta,
																	      type: 'post',
																	      async: false,
																	      dataType: 'json',
																	      url: 'taxewin_cambiopsw.php',
																	      data:{oldpsw:oldpsw,newpsw:newpsw},
																	      success: function(result) { 
																	      							if(!result){
																										alert('Problema Query Inserimento Salto Fattura per num: '+numvero);
																									}
																	        	},
																	      error: function(err, textStatus, errorThrown) {
																	      			console.log("Errore Modifica Cambio Password: " + textStatus + " " + errorThrown);
																	    		}
																});
																$(this).dialog("close");
																location.href='logout.php';		
															}	
															
														},
										Annulla: function(){
														$(this).dialog("close");
														}
										}*/
					});

	$( "#dialog_opzioni4" ).html(html);
	$('#dialog_opzioni4').dialog("option", "minWidth", '50%');
	$('#dialog_opzioni4').dialog("option", "maxWidth", '90%');
	//$( "#dialog_opzioni4" ).dialog( "open" );
	$("#dialog_opzioni4").dialog('option','buttons', butt_dialog).dialog( "open" );
	$('#opz_cambiopsw_vecchia').on('change',function(){$('#opz_cambiopsw_vecchia').css({'background-color':'white'}); });
	$('#opz_cambiopsw_nuova').on('change',function(){$('#opz_cambiopsw_nuova').css({'background-color':'white'}); });
	$('#opz_cambiopsw_ripeti').on('change',function(){$('#opz_cambiopsw_ripeti').css({'background-color':'white'}); });
}

function opzioni(){
	var pref;
	var suf;
	var html='<div id="box-opzioni">'+
				    '<div id="tasto_presuf">'+
				    	'<input class="move_opzioni" id="tasto_presuf_button" type="button" value="Pref/Suff" />'+
				    '</div>'+
				    '<div id="tasto_numfat">'+
				    	'<input class="move_opzioni" id="tasto_numfat_button" type="button" value="Num Fatt" />'+
				    '</div>'+
				    '<div id="tasto_articoli">'+
				    	'<input class="move_opzioni" id="tasto_articoli_button" type="button" value="Articoli" />'+
				    '</div>'+
				    '<div id="tasto_cambiopsw">'+
				    	'<input class="move_opzioni" id="tasto_cambiopsw_button" type="button" value="Cambio Password" />'+
				    '</div>'+
				'</div>';

	butt_dialog	=	[	{	text: "Ok","class": 'ok_opzioni', "id": 'ok_opzioni', click: function() {	$(this).dialog("close");	}	}	];

	$( "#dialog_boxopzioni" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'OPZIONI',
							buttons: {	Ok: function() {
														$(this).dialog("close");
														}
										}
					});

	$("#dialog_boxopzioni").html(html);
	$('#dialog_boxopzioni').dialog("option", "minHeight", '50%');
	$('#dialog_boxopzioni').dialog("option", "maxWidth", '90%');
	//$("#dialog_boxopzioni").dialog( "open" );
	$("#dialog_boxopzioni").dialog('option','buttons', butt_dialog).dialog( "open" );
	$('#tasto_presuf_button').on('click',function(evt){ tasto_presuf(); evt.preventDefault(); });
	$('#tasto_numfat_button').on('click',function(evt){ tasto_numfat(); evt.preventDefault(); });
	$('#tasto_articoli_button').on('click',function(evt){ tasto_articoli(); evt.preventDefault(); });
	$('#tasto_cambiopsw_button').on('click',function(evt){ tasto_cambiopsw(); evt.preventDefault(); });
	/*$('#tasto_presuf_button').on('click',function(){ tasto_presuf(); });
	//$('#tasto_numfat_button').on('click',function(){ alert('test1'); });
	$('#tasto_articoli_button').on('click',function(){ alert('test2'); });
	$('#tasto_cambiopsw_button').on('click',function(){ alert('test3'); });*/
}

function otello(){
	var pref;
	var suf;
	var day;
	var vip='';
	var butt_dialog
	var html='<div id="box-otello">'+
					'<div id="ote_3"><select id="ote_aeropart" title="Selezionare l\'aeroporto di partenza tra quelli presenti">'+
										'<option value="">Aeroporto Di Partenza...</option>'+
										'<option value="FCO">ROMA FIUMICINO "LEONARDO DA VINCI"</option>'+
										'<option value="MXP">MILANO "MILANO MALPENSA"</option>'+
									'</select>'+
						'<input id="ote_aeropart_cod" type="text" placeholder="Cod..." disabled="true"/></div>'+
					'<div id=""><input id="ote_day" type="hidden" readonly placeholder="Data Della Partenza..." value="" title="Solezionare la data di partenza nel calendario"/></div>'+
					'<div id="div_calendar_otello"></div>'+
					'<div id="ote_2"><input id="ote_orario" type="button" value="Orario Partenza" /><input id="ote_oravolo" type="text" placeholder="hh" readonly="readonly" /><label id="duepunti">:</label><input id="ote_minvolo" type="text" placeholder="mm" readonly="readonly" /></div>'+
					'<div id="ote_11">'+
						'<div id="ote_1"><input id="ote_numvolo" type="text" placeholder="Numero Del Volo..." /></div>'+
						'<div id="ote_6">'+
							'<label><input id="ote_trans" type="checkbox" value="1"/>Transito</label>'+
							'<input id="ote_idtravel" type="hidden" value=""/>'+
						'</div>'+
					'</div>'+
					//'<div id="ote_3"><input id="ote_aeropart" type="text" placeholder="Aeroporto Di Partenza..." /><input id="ote_aeropart_cod" type="text" placeholder="Cod..." /></div>'+
					'<div id="ote_4"><input id="ote_aerodest" type="text" placeholder="Aeroporto Di Destinazione..." /><input id="ote_aerodest_cod" type="text" placeholder="Cod..." disabled="true" /></div>'+
					'<div id="ote_5">'+
						'<div id="ote_51">'+
							'<select id="ote_tipodoc">'+
								'<option value="">Tipo Doc...</option>'+
								'<option value="BI">Biglietto</option>'+
								'<option value="CI">C. Imbarco</option>'+
							'</select>'+
						'</div>'+
						'<div id="ote_52">'+
							'<input id="ote_docviaggio" type="text" placeholder="Num Doc Viaggio..." />'+
						'</div>'+
					'</div>'+
				'</div>';

	if(vip_assistance){						//////////////// vedo se devo far apparire il tasto assistenza e sia per Si ch No devo verificare se esiste un itinerario, in quel caso non faccio inviare i dati di nuovo
		//if(!jQuery.isEmptyObject(turista_otello)){
		if(esiste_itinerario){
			if(!ass_esistente){
				butt_dialog	=	[	{	text: "Richiesta VipDesk", "class": 'tastoVip', click: function() {	
																											$(this).dialog("close");	
																											dialog_assistenza($('#ote_idtravel').val());
																											}	},
									{	text: "Chiudi", "class": '', click: function() {	$(this).dialog("close"); $(this).empty();	}	}
								];
			}else{
				butt_dialog	=	[	{	text: "Chiudi", "class": '', click: function() {	$(this).dialog("close"); $(this).empty();	}	}	];
			}
		}else{
			butt_dialog	=	[	//{	text: "Richiesta VipDesk", "class": 'tastoVip', click: function() {	$(this).dialog("close");	}	},
								{	text: "Invia", "class": '', click: function() {	if(!controllo_campi_fasttrack() ){
																						inserisci_itinerario();
																						$(this).dialog("close");
																						$(this).empty();
																					}	}	},
								{	text: "Annulla", "class": '', click: function() {	$(this).dialog("close"); $(this).empty();	}	}
							];
		}
	}else{
		//if(!jQuery.isEmptyObject(turista_otello)){
		if(esiste_itinerario){
			
			butt_dialog	=	{	Chiudi: function() {	$(this).dialog("close"); $(this).empty();	}	};
			
		}else{
			butt_dialog	=	{	Invia: function()	{	if(!controllo_campi_fasttrack()){
															//fast_track();
															inserisci_itinerario();
															$(this).dialog("close");
															$(this).empty();
														}
													},
								Annulla: function() {	$(this).dialog("close"); $(this).empty();	}
							};
		}
	}
	$( "#dialog_otello" ).dialog({
							autoOpen: false,
							modal: true,
							//width:'90%',
							top:'5%',
							async: false,
							closeOnEscape: false,
							title:'Fast Track Otello'
					});
	$("#dialog_otello").html(html);
	//$('#dialog_otello').dialog("option", "minWidth", '50%');
	//$('#dialog_otello').dialog("option", "maxWidth", '90%');
	$("#dialog_otello").dialog('option','buttons', butt_dialog).dialog( "open" );
	
	var cal_1 = new Calendar({
								element: 'div_calendar_otello',
								inline: true,
								months: 1,
								dateFormat: 'd/m/Y',
								disablePast: true,
								onSelect: function (element, selectedDate, date, cell) {
									day = selectedDate;
									$('#ote_day').val(day).css({'background-color' : ''});
								}
							});
	
	$('#ote_numvolo').on('keydown',function(){		$('#ote_numvolo').css({'background-color' : ''});	});
	/*$('#ote_oravolo').on('change',function(){		$('#ote_oravolo').css({'background-color' : ''});	});				///////// ora e minuti li sbianco nella funzione orario quando seleziono orario
	$('#ote_minvolo').on('change',function(){		$('#ote_minvolo').css({'background-color' : ''});	});*/
	$('#ote_aeropart').on('change',function(){		$('#ote_aeropart').css({'background-color' : ''});	});
	$('#ote_aerodest').on('change',function(){		$('#ote_aerodest').css({'background-color' : ''});	});
	$('#ote_docviaggio').on('keydown',function(){	$('#ote_docviaggio').css({'background-color' : ''});	});
	//$('#ote_aeropart').on('keyup',listaAeroporti);
  	//$('#ote_aerodest').on('blur',nascondiListaAeroporti);
  	$('#ote_aeropart').on('change',function(){	$('#ote_aeropart_cod').val( $('#ote_aeropart option:selected').val() )	});
  	$('#ote_aerodest').on('keyup',listaAeroporti);
  	//$('#ote_aerodest').on('blur',nascondiListaAeroporti);
  	orario('ote_orario','divorario',$('#ote_oravolo').val(),$('#ote_minvolo').val());
  	$('#ote_orario').on('click',function(){
  		if(document.getElementById('divorario').style.visibility == 'hidden'){
			$('#divorario').css({'visibility':'visible'});
			$('#ote_orario').val('Chiudi').css({'background-color':'red'});
		}else{
			$('#divorario').css({'visibility':'hidden'});
			$('#ote_orario').val('Orario Partenza').css({'background-color':''}); 
		}
	});
	$('#box-otello input,#box-otello select').on('focus click',function(event){ 
    	if(event.target.hasAttribute('title') && event.target.title!=''){
			tips(event.target.id,'tips');
		}
    });
    if(!jQuery.isEmptyObject(turista_otello)){
    	compila_fasttrack();
    	/* $('#ote_day').attr('type','text');
    	$('#div_calendar_otello').html('Itinerario Gi&agrave; Presente<br/>Abilitato Per Priority Desk').addClass('iti_presente');
    	$(':text',"#box-otello").attr('disabled','disabled');
    	$(':button',"#box-otello").attr('disabled','disabled');
		$('select',"#box-otello").attr('disabled','disabled'); */
		//TOLGO IL BLOCCO SOPRA E PROVO A LASCIARE SOL UNA LISTA DI DATI CARICATA DALLA FUNZIONE COMPILA FASTTRACK
		
	}
    $('#ote_aeropart').focus();
} 

function ricerca_tur(cercamail,dialog){
	
	if(cercamail === undefined) {
      cercamail = '';
   	}
   	if(dialog === undefined) {
      dialog = true;
   	}
	
	var html='';
	var dacercare;
	if(cercamail != ''){
		dacercare=cercamail;
	}else{
		//dacercare=$('#card_tur').val();
		dacercare=document.getElementById('card_tur').value;
	}
	var card_tur = dacercare.trim();
	//console.log(card_tur);
	card_tur=card_tur.replace(/ /g,"");
	//console.log(card_tur);
	//var concorrenza = $('#concorrenza').val();
	//var email = $('#email').val();
	var pS='';
	pS = pS + "shop=" + $('#associato').val() + "&";
	pS = pS + "username=" + $('#user').val() + "&";
    pS = pS + "password=" + $('#psw').val() + "&";
	pS = pS + "search=" + card_tur + "&";
	
	if(card_tur!=''){
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			dataType: 'json',
			async: false,
			url: 'webservices/read_card.php',
			data:pS,
			success: function(data) {
				//console.log(data);
      			if(data.status == 'OK'){
					turista_riconosciuto=data.turista_riconosciuto;
					card_turista=data.customer['ecard'];
					var card_spazi=data.customer['ecard'].substr(0,4) + ' ' + data.customer['ecard'].substr(4,4) + ' ' + data.customer['ecard'].substr(8,4) + ' ' + data.customer['ecard'].substr(12,4);
					$('#card_tur').val(card_spazi).css({'background-color' : '#00ff08'});
					if( $('#name').val().trim() == '' ){
						$('#name').val(data.customer['name']).css({'background-color' : '#00ff08'});
					}
					if( $('#surname').val().trim() == '' ){
						$('#surname').val(data.customer['surname']).css({'background-color' : '#00ff08'});
					}
					$('#email').val(data.customer['email']).css({'background-color' : '#00ff08'});
					if( $('#gender').val().trim() == '' && data.customer['gender']!= '' && data.customer['gender']!= '0000-00-00' && data.customer['gender']!= '0000-00-00 00:00:00'){
						$('#gender').val(data.customer['gender']).css({'background-color' : '#00ff08'});
						//$('#addr').val(data.customer['address']).css({'background-color' : ''});	
					}
					if( $('#addr').val().trim() == '' && data.customer['address']!= '' && data.customer['address']!= '0000-00-00' && data.customer['address']!= '0000-00-00 00:00:00'){
						$('#addr').val(data.customer['address']).css({'background-color' : '#00ff08'});
						//$('#addr').val(data.customer['address']).css({'background-color' : ''});	
					}
					if($('#city').val().trim() == '' && data.customer['city']!= '' && data.customer['city']!= '0000-00-00' && data.customer['city']!= '0000-00-00 00:00:00'){
						$('#city').val(data.customer['city']).css({'background-color' : '#00ff08'});
						//$('#city').val(data.customer['city']).css({'background-color' : ''});	
					}										
					if($('#country').val().trim() == '' && data.customer['country']!= '' && data.customer['country']!= '0000-00-00' && data.customer['country']!= '0000-00-00 00:00:00'){
						$('#country').val(data.customer['country']).css({'background-color' : '#00ff08'});
						//$('#country').val(data.customer['country']).css({'background-color' : ''});
					}
					if($('#country_cod').val().trim() == '' && data.customer['country_code']!= '' && data.customer['country_code']!= '0000-00-00' && data.customer['country_code']!= '0000-00-00 00:00:00'){
						if(data.customer['country_code'].length == 2){ data.customer['country_code']=codici_naz_23[data.customer['country_code']]; }
						$('#country_cod').val(data.customer['country_code']).css({'background-color' : '#00ff08'});
						//$('#country_cod').val(data.customer['country_code']).css({'background-color' : ''});
					}
					if($('#tipo_doc').val().trim() == '' && data.customer['doc_type']!= '' && data.customer['doc_type']!= '0000-00-00' && data.customer['doc_type']!= '0000-00-00 00:00:00'){
						$('#tipo_doc').val(data.customer['doc_type'].toUpperCase()).css({'background-color' : '#00ff08'});
						//$('#tipo_doc').val(data.customer['doc_type']).css({'background-color' : ''});
					}
					if($('#doc').val().trim() == '' && data.customer['passport']!= '' && data.customer['passport']!= '0000-00-00' && data.customer['passport']!= '0000-00-00 00:00:00'){
						$('#doc').val(data.customer['passport']).css({'background-color' : '#00ff08'});
						//$('#doc').val(data.customer['passport']).css({'background-color' : ''});
					}
					if($('#nazdoc').val().trim() == '' && data.customer['doc_country']!= '' && data.customer['doc_country']!= '0000-00-00' && data.customer['doc_country']!= '0000-00-00 00:00:00'){
						$('#nazdoc').val(data.customer['doc_country']).css({'background-color' : '#00ff08'});
						//$('#nazdoc').val(data.customer['doc_country']).css({'background-color' : ''});
					}
					if($('#nazdoc_cod').val().trim() == '' && data.customer['doc_country_code']!= '' && data.customer['doc_country_code']!= '0000-00-00' && data.customer['doc_country_code']!= '0000-00-00 00:00:00'){
						if(data.customer['doc_country_code'].length == 2){ data.customer['doc_country_code']=codici_naz_23[data.customer['doc_country_code']]; }
						$('#nazdoc_cod').val(data.customer['doc_country_code']).css({'background-color' : '#00ff08'});
						//$('#nazdoc_cod').val(data.customer['doc_country_code']).css({'background-color' : ''});	
					}
					if($('#exp').val().trim() == '' && data.customer['doc_exp']!= '' && data.customer['doc_exp']!= '0000-00-00' && data.customer['doc_exp']!= '0000-00-00 00:00:00'){
						var doc_exp=data.customer['doc_exp'].substr(8,2) +'/' + data.customer['doc_exp'].substr(5,2)+'/' + data.customer['doc_exp'].substr(0,4);
						$('#exp').val(doc_exp).css({'background-color' : '#00ff08'});
						//$('#exp').val(doc_exp).css({'background-color' : ''});	
					}
					if($('#citybirt').val().trim() == '' && data.customer['city_birth']!= '' && data.customer['city_birth']!= '0000-00-00' && data.customer['city_birth']!= '0000-00-00 00:00:00'){
						$('#citybirt').val(data.customer['city_birth']).css({'background-color' : '#00ff08'});	
						//$('#citybirt').val(data.customer['city_birth']).css({'background-color' : ''});	
					}
					if($('#birt').val().trim() == '' && data.customer['country_birth']!= '' && data.customer['country_birth']!= '0000-00-00' && data.customer['country_birth']!= '0000-00-00 00:00:00'){
						$('#birt').val(data.customer['country_birth']).css({'background-color' : '#00ff08'});
						//$('#birt').val(data.customer['country_birth']).css({'background-color' : ''});
					}
					if($('#birt_cod').val().trim() == '' && data.customer['country_birth_code']!= '' && data.customer['country_birth_code']!= '0000-00-00' && data.customer['country_birth_code']!= '0000-00-00 00:00:00'){
						if(data.customer['country_birth_code'].length == 2){ data.customer['country_birth_code']=codici_naz_23[data.customer['country_birth_code']]; }
						$('#birt_cod').val(data.customer['country_birth_code']).css({'background-color' : '#00ff08'});
						//$('#birt_cod').val(data.customer['country_birth_code']).css({'background-color' : ''});	
					}
					if($('#dtbirt').val().trim() == '' && data.customer['date_birth']!= '' && data.customer['date_birth']!= '0000-00-00' && data.customer['date_birth']!= '0000-00-00 00:00:00'){
						var d_nascita_dritta=data.customer['date_birth'].substr(8,2) +'/' + data.customer['date_birth'].substr(5,2)+'/' + data.customer['date_birth'].substr(0,4);
						$('#dtbirt').val(d_nascita_dritta).css({'background-color' : '#00ff08'});
						//$('#dtbirt').val(d_nascita_dritta).css({'background-color' : ''});	
					}
					//disabilita_turista();
					return false;
				}else{
					$('#card_tur').css({'background-color' : '#ff0000'});
					if(typeof data.error['0'].err_mess != 'undefined'){
						html=data.error['0'].err_mess;	
					}else{
						html="";
					}
					if(dialog){						
						$( "#dialog_msg_web" ).dialog({
										autoOpen: false,
										modal: true,
										async: false,
										closeOnEscape: false,
										title:'AVVISO',
										buttons: {	Ok: function() {
																	$(this).dialog("close");
																	$(this).empty();
																	}
												}
						});
						$( "#dialog_msg_web" ).html(html);
						$('#dialog_msg_web').dialog("option", "minWidth", '50%');
						$('#dialog_msg_web').dialog("option", "maxWidth", '90%');
						$( "#dialog_msg_web" ).dialog( "open" );
						html=true;
					}else{
						html+='<br/>Riprovare Con La Ricerca<br/>';
					}
				}
        	},
      		error: function(err, textStatus, errorThrown) {
          		console.log("errore ajax ricerca_tur()" + textStatus + " " + errorThrown);
        	}				
		});
		// B-> Qui si definisce la sua funzione e il suo payload
			//////// var mdnAPI = 'webservices/read_card.php';
			//////// var payload = {
			////////   	'shop' : log_associato,
			//////// 	'username' : log_username,
			////////     'password' : log_password,
			//////// 	'search' : card_tur 
			//////// };

			//////// var callback = {
			////////   success : function(data){
			////////      console.log(1, 'success', JSON.parse(data));
			////////   },
			////////   error : function(data){
			////////      console.log(2, 'error', JSON.parse(data));
			////////   }
			//////// };
			// End B

			// Esegue la chiamata al metodo 
			//////// $http(mdnAPI) 
			////////   .post(payload) 
			////////   .then(callback.success) 
			////////   .catch(callback.error);

			/*// Esegue la chiamata al metodo con un metodo alternativo (1)
			// di risolvere il caso di fallimento 
			$http(mdnAPI) 
			  .get(payload) 
			  .then(callback.success, callback.error);	*/
		return html;
	}else{
		
		html='Turista Non Riconosciuto, Inserire La Mail Del Turista O La Sua Carta Virtuale e Premere Il Tasto Cerca<br/>';
		if(dialog){
			$( "#dialog_msg_web" ).dialog({
						autoOpen: false,
						modal: true,
						async: false,
						closeOnEscape: false,
						title:'AVVISO',
						buttons: {	Ok: function() {
													$(this).dialog("close");
													$(this).empty();
													}
								}
			});
			$("#dialog_msg_web" ).html(html);
			$('#dialog_msg_web').dialog("option", "minWidth", '50%');
			$('#dialog_msg_web').dialog("option", "maxWidth", '90%');
			$( "#dialog_msg_web" ).dialog( "open" );
			return true;
		}else{
			return html;	
		}
	}
}

function inserisci_tur(risp_ricerca, dialog){
 
	if(risp_ricerca === undefined) {
    	risp_ricerca = '';
   	}
   	if(dialog === undefined) {
      dialog = true;
   	}
 
	var flag_ins=false;
	var card_tur = $('#card_tur').val().trim();
	//var concorrenza = $('#concorrenza').val();
	//var email = $('#email').val();
	var pS='';
	pS=	"shop=" + $('#associato').val() + "&" +
		"username=" + $('#user').val() + "&" +
		"password=" + $('#psw').val() + "&" +
		"ecard=" + $('#card_tur').val() + "&" +
		"name=" + $('#name').val() + "&" +
		"surname=" + $('#surname').val() + "&" +
		"gender=" + $('#gender').val() + "&" +
		"address=" + $('#addr').val() + "&" +
		"city=" + $('#city').val() + "&" +
		"country_code=" + codici_naz[$('#country_cod').val()] + "&" +
		"country=" + $('#country').val() + "&" +
		"document_type=" + $('#tipo_doc').val() + "&" +
		"document=" + $('#doc').val() + "&" +
		"document_exp=" + $('#exp').val() + "&" +
		"doc_country=" + $('#nazdoc').val() + "&" +
		"doc_country_code=" + codici_naz[$('#nazdoc_cod').val()] + "&" +
		"date_birth=" + $('#dtbirt').val() + "&" +
		"city_birth=" + $('#citybirt').val() + "&" +
		"country_birth=" + $('#birt').val() + "&" +
		"country_birth_code=" + codici_naz[$('#birt_cod').val()] + "&" +
		"email=" + $('#email').val() + "&" +
		"phone_number=&" +
		"response=JSON";
		//console.log(pS);
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			dataType: 'json',
			async: false,
			url: 'webservices/get_card.php',
			data:pS,
			success: function(data) {
				//console.log(data);
      			if(data.status == 'OK'){
					card_turista=data.customer['ecard'];
					var card_spazi=data.customer['ecard'].substr(0,4) + ' ' + data.customer['ecard'].substr(4,4) + ' ' + data.customer['ecard'].substr(8,4) + ' ' + data.customer['ecard'].substr(12,4);
					$('#card_tur').val(card_spazi).css({'background-color' : ''});
					$('#name').val(data.customer['name']).css({'background-color' : ''});
					$('#surname').val(data.customer['surname']).css({'background-color' : ''});
					$('#email').val(data.customer['email']).css({'background-color' : ''});
					$('#addr').val(data.customer['address']).css({'background-color' : ''});
					$('#city').val(data.customer['city']).css({'background-color' : ''});
					$('#country').val(data.customer['country']).css({'background-color' : ''});
					if(data.customer['country_code'].length == 2){ data.customer['country_code']=codici_naz_23[data.customer['country_code']]; }
					$('#country_cod').val(data.customer['country_code']).css({'background-color' : ''});
					$('#tipo_doc').val(data.customer['doc_type']).css({'background-color' : ''});
					$('#doc').val(data.customer['passport']).css({'background-color' : ''});
					$('#nazdoc').val(data.customer['doc_country']).css({'background-color' : ''});
					if(data.customer['doc_country_code'].length == 2){ data.customer['doc_country_code']=codici_naz_23[data.customer['doc_country_code']]; }
					$('#nazdoc_cod').val(data.customer['doc_country_code']).css({'background-color' : ''});
					var doc_exp=data.customer['doc_exp'].substr(8,2) +'/' + data.customer['doc_exp'].substr(5,2)+'/' + data.customer['doc_exp'].substr(0,4);
					$('#exp').val(doc_exp).css({'background-color' : ''});
					$('#citybirt').val(data.customer['city_birth']).css({'background-color' : ''});
					$('#birt').val(data.customer['country_birth']).css({'background-color' : ''});
					if(data.customer['country_birth_code'].length == 2){ data.customer['country_birth_code']=codici_naz_23[data.customer['country_birth_code']]; }
					$('#birt_cod').val(data.customer['country_birth_code']).css({'background-color' : ''});
					var d_nascita_dritta=data.customer['date_birth'].substr(8,2) +'/' + data.customer['date_birth'].substr(5,2)+'/' + data.customer['date_birth'].substr(0,4);
					$('#dtbirt').val(d_nascita_dritta).css({'background-color' : ''});
					//disabilita_turista();
				}else{
					var html=risp_ricerca + '<br/>Procedere Come Segue Per La Registrazione<br/><br/>';
					//console.log(typeof data.error['0']);
					if( typeof data.error[0] !== 'undefined' && data.error['0'].err_code != 'E00144'){
						html+=data.error['0'].err_mess;
						if(dialog){
							$( "#dialog_msg_web" ).dialog({
										autoOpen: false,
										modal: true,
										width:'80%',
										async: false,
										closeOnEscape: false,
										title:'AVVISO',
										buttons: {	Ok: function() {
																	$(this).dialog("close");
																	$(this).empty();
																	}
												}
							});
							$('#dialog_msg_web').empty();
							$('#dialog_msg_web').dialog("option", "minWidth", '40%');
							$('#dialog_msg_web').dialog("option", "maxWidth", '80%');
							$( "#dialog_msg_web" ).html(html);
							$( "#dialog_msg_web" ).dialog( "open" );
							if( (typeof data.error[0].err_fields)!== 'undefined' && data.error[0].err_fields.length > 0 ){
								campi_mancanti(data.error[0].err_fields);
							}
						}
						flag_ins=true;
					}else{
						if((typeof data.alert[0] !== 'undefined') && (data.alert[0].err_code=='A00110')){
							ricerca_tur($('#email').val(),dialog);
						}else{
							return;
						}
					}
				}
        	},
      		error: function(err, textStatus, errorThrown) {
          		console.log("errore ajax inserisci_tur()" + textStatus + " " + errorThrown);
        	}				
		});
		
		
	return flag_ins;
}

function inserisci_itinerario(){
	var flag_ins=false;
	var val_chek=($("#ote_trans").is(':checked') ?	'S' : 'N');
	var card_tur = $('#card_tur').val().trim();
	card_tur=card_tur.replace(/ /g,"");
	var pS='';
	pS=	"shop=" + $('#associato').val() + "&" +
		"username=" + $('#user').val() + "&" +
		"password=" + $('#psw').val() + "&" +
		"ecard=" + card_tur + "&" +
		"flight_number=" + $('#ote_numvolo').val() + "&" +
		"departure_date=" + $('#ote_day').val() + "&" +
		"departure_time=" + $('#ote_oravolo').val() + ":" + $('#ote_minvolo').val() + "&" +
		"departure_airport=" + $('#ote_aeropart_cod').val() + "&" +
		"destination_airport=" + $('#ote_aerodest_cod').val() + "&" +
		"travel_doc_type=" + $('#ote_tipodoc').val() + "&" +
		"travel_doc_number=" + $('#ote_docviaggio').val() + "&" +
		"transit=" + val_chek + "&" +
		"response=JSON";
		//console.log(pS);
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			dataType: 'json',
			async: false,
			url: 'webservices/travel_customer.php',
			data:pS,
			success: function(data) {
				//console.log(data);
      			if(data.status == 'OK'){
					fast_track();
					id_travel=data.travel_id;
					disabilita_turista();
					// se vipdesk trasformo il tasto in richiesta vip desk altrimenti disabilito il tasto e scrivo (abilitato a prioritydesk)
					if(vip_assistance){
						$("#tur_vipdesk").on('click',function(){
							dialog_assistenza(id_travel);
						}).show();
						$("#tur_fastline").hide();
						/*$('#tur_fastline').val('VipDesk').addClass('tastoVipDesk').on('onclick',function(){
							dialog_assistenza(id_travel);
						});*/	
					}else{
						$("#tur_fastline").off("click");
						$('#tur_fastline').val('Priority Desk - Abilitato!').on('onclick',function(){
						});
					}
					
					
				}else{
					if((typeof data.error[0] !== 'undefined')){
						html=data.error['0'].err_mess;
						$( "#dialog_msg_web" ).dialog({
									autoOpen: false,
									modal: true,
									async: false,
									closeOnEscape: false,
									title:'AVVISO',
									buttons: {	Ok: function() {
																$(this).dialog("close");
																$(this).empty();
																}
											}
						});
						$( "#dialog_msg_web" ).html(html);
						$('#dialog_msg_web').dialog("option", "minWidth", '50%');
						$('#dialog_msg_web').dialog("option", "maxWidth", '90%');
						$( "#dialog_msg_web" ).dialog( "open" );
						flag_ins=true;
					}else{
						return;
					}
				}
        	},
      		error: function(err, textStatus, errorThrown) {
          		console.log("errore ajax inserisci_itinerario()" + textStatus + " " + errorThrown);
        	}				
		});
		
		
	return flag_ins;
}

function ricerca_itinerario(ecard_tur){
	
	if(ecard_tur === undefined) {
    	ecard_tur = '';
   	}
	 
	ecard_tur = ecard_tur.trim();
	ecard_tur=ecard_tur.replace(/ /g,"");
		
	var pS='';
	pS = pS + "shop=" + $('#associato').val() + "&";
	pS = pS + "username=" + $('#user').val() + "&";
    pS = pS + "password=" + $('#psw').val() + "&";
	pS = pS + "ecard=" + ecard_tur + "&";
	
	var html='';
	
	if(ecard_tur==''){
		return false;
	}
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			dataType: 'json',
			async: false,
			url: 'webservices/read_travel_customer.php',
			data:pS,
			success: function(data) {
				//console.log(data);
				if(data.status == 'OK' && data.travel_customer){
					var itinerario=new Array();
					for(key_itinerario in data.travel_customer){
						itinerario = data.travel_customer[key_itinerario];
					}
					//console.log(data.travel_customer);
					//console.log(itinerario);
					var ore = itinerario['departure_time'].substr(0,2);
					var minuti = itinerario['departure_time'].substr(3,2);
					var aeroporti_filtrati = cercaAeroporto(itinerario['destination_airport']);
					//console.log(aeroporti_filtrati[0].c + ', ' + aeroporti_filtrati[0].C + ' \"' + aeroporti_filtrati[0].n + '\"');  ////// non esce perchè????? 
					var aero_appoggio=aeroporti_filtrati[0].c + ', ' + aeroporti_filtrati[0].C + ' \"' + aeroporti_filtrati[0].n + '\"';
					turista_otello={	
										'ote_day' : itinerario['departure_date'],
										'ote_numvolo' : itinerario['flight_number'],
										'ote_oravolo' : ore,
										'ote_minvolo' : minuti,
										'ote_aeropart' : itinerario[''],
										'ote_aeropart_cod' : itinerario['departure_airport'],
										'ote_aerodest' : aero_appoggio,
										'ote_aerodest_cod' : itinerario['destination_airport'],
										'ote_tipodoc' : itinerario['travel_doc_type'],
										'ote_docviaggio' :itinerario['travel_doc_number'],
										'ote_trans' : itinerario['transit'],
										'ote_id' : key_itinerario	
									}
					//compila_fasttrack();
					esiste_itinerario=true;
					//$("#div_calendar_otello .bcal-date").removeAttr("onclick"); 
					otello();
					return true;
				}else{
					esiste_itinerario=false;
					otello();
					return false
				}
        	},
      		error: function(err, textStatus, errorThrown) {
          		console.log("errore ajax ricerca_tur()" + textStatus + " " + errorThrown);
        	}				
		});
}

function ricerca_assistenza(ecard_tur){
	
	if(ecard_tur === undefined) {
    	ecard_tur = '';
   	}
 
	ecard_tur = ecard_tur.trim();
	ecard_tur=ecard_tur.replace(/ /g,"");
		
	var pS='';
	pS = pS + "shop=" + $('#associato').val() + "&";
	pS = pS + "username=" + $('#user').val() + "&";
    pS = pS + "password=" + $('#psw').val() + "&";
	pS = pS + "ecard=" + ecard_tur + "&";
		
	$.ajax({
		beforeSend:sessione_scaduta,
		type: 'post',
		dataType: 'json',
		async: false,
		url: 'webservices/search_vipass.php',
		data:pS,
		success: function(data) {
			//console.log(data);
			if(data.status == 'OK' && !data.vip_ass){
				return false;
			}else{
				return true;
			}
    	},
  		error: function(err, textStatus, errorThrown) {
      		console.log("errore ajax ricerca_tur()" + textStatus + " " + errorThrown);
    	}				
	});
	return true;
}

function dialog_assistenza(id_iti){
	var html='<div id="box-assistenza">'+
					'<div id="vip_1"><input id="vip_idtravel" type="hidden" value=' + id_iti + ' /></div>'+
					'<div id="vip_2"><textarea rows="4" cols="50" id="vip_note" type="text" placeholder="Note per TaxRefund utili ai fini dell\'assistenza..." /></div>'+
					'<div id="vip_3">'+
						'<label><input id="vip_eng" type="checkbox" value="1"/>Parla Inglese</label>'+
					'</div>'+
					'<div id="vip_5"><input id="vip_preftel" type="text" placeholder="Pref Tel Nazione..." </div>'+
					'<div id="vip_4"><input id="vip_tel" type="text" placeholder="Recapito Telefonico..." </div>'+
				'</div>';

	butt_dialog	=	[	{	text: "Invia Richiesta", "class": 'tastoVip', click: function() {	if(!controllo_campi_assistenza() ){
																									inserisci_assistenza();
																									$(this).dialog("close");
																									$(this).empty();
																								}	}	},
						{	text: "Annulla", "class": '', click: function() {	$(this).dialog("close"); $(this).empty();	}	}
					];
		
	
	$( "#dialog_assistenza" ).dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'Richiesta Assistenza'
					});
	$("#dialog_assistenza").html(html);
	$('#dialog_assistenza').dialog("option", "minWidth", '50%');
	$('#dialog_assistenza').dialog("option", "maxWidth", '90%');
	$("#dialog_assistenza").dialog('option','buttons', butt_dialog).dialog( "open" );
	$('#vip_tel').on('keydown',function(){		$('#vip_tel').css({'background-color' : ''});	});
}

function inserisci_assistenza(){
	
	var flag_ins=false;
	var card_tur = $('#card_tur').val().trim();
	card_tur=card_tur.replace(/ /g,"");
	var pS='';
	pS=	"shop=" + $('#associato').val() + "&" +
		"username=" + $('#user').val() + "&" +
		"password=" + $('#psw').val() + "&" +
		"ecard=" + card_tur + "&" +
		"id_travel=" + $('#vip_idtravel').val() + "&" +
		"note=" + $('#vip_note').val() + "&" +
		"speak_english=" + $('#vip_eng').val() + "&" +
		"phone_number=" + $('#vip_tel').val() + "&" +
		"country_calling_code=" + $('#vip_preftel').val() + "&" +
		"response=JSON";
		//console.log(pS);
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			dataType: 'json',
			async: false,
			url: 'webservices/vip_assistance.php',
			data:pS,
			success: function(data) {
				//console.log(data);
      			if(data.status == 'OK' && data.insert_id){
      				disabilita_turista();
					assistenza_inserita=true;
					id_assistenza=data.insert_id;
					/*$("#tur_fastline").off("click");
					$('#tur_fastline').val('VipDesk - Prenotato!').addClass('tastoVipDesk');*/
					$("#tur_vipdesk").val('VipDesk - Prenotato!').show().off('click');/*,function(){
							dialog_assistenza(id_travel);
						});;*/
					$("#tur_fastline").hide();
				}else{
					if((typeof data.error[0] !== 'undefined')){
						html=data.error['0'].err_mess;
						$( "#dialog_msg_web" ).dialog({
									autoOpen: false,
									modal: true,
									async: false,
									closeOnEscape: false,
									title:'AVVISO',
									buttons: {	Ok: function() {
																$(this).dialog("close");
																$(this).empty();
																}
											}
						});
						$( "#dialog_msg_web" ).html(html);
						$('#dialog_msg_web').dialog("option", "minWidth", '50%');
						$('#dialog_msg_web').dialog("option", "maxWidth", '90%');
						$( "#dialog_msg_web" ).dialog( "open" );
					}else{
						return;
					}
				}
        	},
      		error: function(err, textStatus, errorThrown) {
          		console.log("errore ajax inserisci_itinerario()" + textStatus + " " + errorThrown);
        	}				
		});
		
		
	return flag_ins;
}

function conferma_assistenza(){
	
	var flag_ins=false;
	var card_tur = $('#card_tur').val().trim();
	card_tur=card_tur.replace(/ /g,"");
	var pS='';
	pS=	"shop=" + $('#associato').val() + "&" +
		"username=" + $('#user').val() + "&" +
		"password=" + $('#psw').val() + "&" +
		"ecard=" + card_tur + "&" +
		"id_ass=" + id_assistenza + "&" +
		"response=JSON";
		//console.log(pS);
		$.ajax({
			beforeSend:sessione_scaduta,
			type: 'post',
			dataType: 'json',
			async: false,
			url: 'webservices/vip_assistance_confirm.php',
			data:pS,
			success: function(data) {
				//console.log(data);
      			if(data.status == 'OK' && data.insert_id){
      				return flag_ins=true;
				}else{
					if((typeof data.error[0] !== 'undefined')){
						html=data.error['0'].err_mess;
						$( "#dialog_msg_web" ).dialog({
									autoOpen: false,
									modal: true,
									async: false,
									closeOnEscape: false,
									title:'AVVISO',
									buttons: {	Ok: function() {
																$(this).dialog("close");
																$(this).empty();
																}
											}
						});
						$( "#dialog_msg_web" ).html(html + "<br/>ASSISTENZA VIPDESK NON INSERITA CONTATTARE LA SEDE.<br/>ID:" + id_assistenza);
						$('#dialog_msg_web').dialog("option", "minWidth", '50%');
						$('#dialog_msg_web').dialog("option", "maxWidth", '90%');
						$( "#dialog_msg_web" ).dialog( "open" );
					}else{
						return;
					}
				}
        	},
      		error: function(err, textStatus, errorThrown) {
          		console.log("errore ajax inserisci_itinerario()" + textStatus + " " + errorThrown);
        	}				
		});
		
		
	return flag_ins;
}

function campi_mancanti(lista){
	
	var nome_campo;
	for( nome_campo in lista){
		$('#' + lista[nome_campo]).css({'background-color' : '#F00'}); 	
	}	
}

function controllo_campi_fasttrack(){
	var blocca=false;
	
	if($('#ote_day').val() == ''){			$('.bcal-table').css({'border-color' : '#F00'});		blocca=true;	}
	if($('#ote_numvolo').val() == ''){		$('#ote_numvolo').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#ote_oravolo').val() == ''){		$('#ote_oravolo').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#ote_minvolo').val() == ''){		$('#ote_minvolo').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#ote_aeropart').val() == ''){		$('#ote_aeropart').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#ote_aerodest').val() == ''){		$('#ote_aerodest').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#ote_docviaggio').val() == ''){	$('#ote_docviaggio').css({'background-color' : '#F00'});	blocca=true;	}
	if($('#ote_tipodoc').val() == ''){		$('#ote_tipodoc').css({'background-color' : '#F00'});	blocca=true;	}
	
	return blocca;
}

function controllo_campi_assistenza(){
	var blocca=false;
	if($('#vip_preftel').val() == ''){		$('#vip_preftel').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#vip_tel').val() == ''){		$('#vip_tel').css({'background-color' : '#F00'});		blocca=true;	}
		
	return blocca;
}

function fast_track(){		//// riempio l'array dell'itinerario con i dati inseriti nei campi
	var val_chek
	
	val_chek=($("#ote_trans").is(':checked') ?	1 : 0);
	
	turista_otello={	'ote_day' : $('#ote_day').val(),
						'ote_numvolo' : $('#ote_numvolo').val(),
						'ote_oravolo' : $('#ote_oravolo').val(),
						'ote_minvolo' : $('#ote_minvolo').val(),
						'ote_aeropart' : $('#ote_aeropart').val(),
						'ote_aeropart_cod' : $('#ote_aeropart_cod').val(),
						'ote_aerodest' : $('#ote_aerodest').val(),
						'ote_aerodest_cod' : $('#ote_aerodest_cod').val(),
						'ote_tipodoc' : $('#ote_tipodoc').val(),
						'ote_docviaggio' : $('#ote_docviaggio').val(),
						'ote_trans' : val_chek	
					}
}

function compila_fasttrack(){		//// compilo i campi con i valori dell'array
	var val_chek
	
	/*$('#ote_day').val(turista_otello['ote_day'].substr(8,2)+'/'+turista_otello['ote_day'].substr(5,2)+'/'+turista_otello['ote_day'].substr(0,4));
	$('#ote_numvolo').val(turista_otello['ote_numvolo']);
	$('#ote_oravolo').val(turista_otello['ote_oravolo']);
	$('#ote_minvolo').val(turista_otello['ote_minvolo']);
	$('#ote_aeropart option[value="' + turista_otello['ote_aeropart_cod']+'"]').attr('selected',true);
	$('#ote_aeropart_cod').val(turista_otello['ote_aeropart_cod']);
	$('#ote_aerodest').val(turista_otello['ote_aerodest']);
	$('#ote_aerodest_cod').val(turista_otello['ote_aerodest_cod']);
	$('input:radio[value='+ turista_otello['ote_tipodoc'] +']').attr('checked',true);
	$('#ote_idtravel').val(turista_otello['ote_id']);
	$('#ote_docviaggio').val(turista_otello['ote_docviaggio']);
	if(turista_otello['ote_trans'] == 1){	$('#ote_trans')[0].checked = true;	}
	*/ //// PROVO A TOGLIERE QUESTO BLOCCO E SCRIVO DIRETTAMENTE UNA LISTA DI DATI
	if(ass_esistente && vip_assistance){
		html="<label>Itinerario Presente<br/>E Assistenza Già Prenotata</label><br/><br/>";
	}else{
		html="<label>Itinerario Gi&agrave; Presente<br/>Turista Abilitato Per Priority Desk<br/><br/></label>";	
	}
	html+="<label>Data di Partenza:</label> "+turista_otello['ote_day'].substr(8,2)+'/'+turista_otello['ote_day'].substr(5,2)+'/'+turista_otello['ote_day'].substr(0,4)+"<br/>" +
		"<label>Orario:</label> "+turista_otello['ote_oravolo']+":"+turista_otello['ote_minvolo']+"<br/>" +
		"<label>Num. Volo:</label> "+turista_otello['ote_numvolo']+"<br/>" +
		"<label>Aeroporto Partenza:</label> "+turista_otello['ote_aeropart_cod']+"<br/>" +
		"<label>Aeroporto Destinazione:</label> "+turista_otello['ote_aerodest']+"<br/>" +
		"<label>Docum. Viaggio:</label> "+turista_otello['ote_tipodoc']+" - "+turista_otello['ote_docviaggio'];
	html+="<input id=\"ote_idtravel\" type=\"hidden\" value=\""+turista_otello['ote_id']+"\"/>";
		
	$("#box-otello").html(html).addClass('iti_completo');
}

function avvio_controllo_tur(){ // devo vedere i campi minimi richiesti per l'emissione da tabella per bloccare in caso di mancanza dati ???????????????????????????????????????????????????????????????? forse lo gestisco già da webservice con risposta errore
	var blocca=false;
	
	if($('#email').val().trim() == '' && !turista_riconosciuto){	
												$('#email').css({'background-color' : '#F00'});			blocca=true;
	}
	if($('#name').val().trim() == ''){			$('#name').css({'background-color' : '#F00'});			blocca=true;	}
	if($('#addr').val().trim() == ''){			$('#addr').css({'background-color' : '#F00'});			blocca=true;	}
	if($('#city').val().trim() == ''){			$('#city').css({'background-color' : '#F00'});			blocca=true;	}
	if($('#country').val().trim() == ''){		$('#country').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#country_cod').val().trim() == ''){	$('#country_cod').css({'background-color' : '#F00'});	blocca=true;	}
	if($('#tipo_doc').val() == ''){				$('#tipo_doc').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#doc').val().trim() == ''){			$('#doc').css({'background-color' : '#F00'});			blocca=true;	}
	if($('#nazdoc_cod').val().trim() == ''){	$('#nazdoc_cod').css({'background-color' : '#F00'});	blocca=true;	}
	if($('#citybirt').val().trim() == ''){		$('#citybirt').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#birt').val().trim() == ''){			$('#birt').css({'background-color' : '#F00'});			blocca=true;	}
	if($('#dtbirt').val().trim() == ''){		$('#dtbirt').css({'background-color' : '#F00'});		blocca=true;	}
	if($('#nazdoc').val().trim() == ''){		$('#nazdoc').css({'background-color' : '#F00'});		blocca=true;	}
	
	return blocca;
}

function sbianca_turista(){
	$(':text','#box-turista').val('');
	$(':text','#box-turista').css({'background-color' : ''});
	//$("#concorrenza").val($("#concorrenza option:first").val());
	//$("#concorrenza").css({'background-color' : ''});
	$("#tipo_doc").val($("#tipo_doc option:first").val());
	$("#tipo_doc").css({'background-color' : ''});
	$("#gender").val($("#gender option:first").val());
	$("#gender").css({'background-color' : ''});
	turista_riconosciuto = false;
	$(':text','#box-turista').not('#country_cod,#nazdoc_cod,#birt_cod').attr('disabled',false);
	//$("#concorrenza").attr('disabled',false);
	$("#tipo_doc").attr('disabled',false);
	$("#gender").attr('disabled',false);
	$("#cerca_tur").attr('disabled',false);
	turista_otello= new Object();
	id_travel='';
	assistenza_inserita=false;
	$("#tur_fastline").show();
	$("#tur_vipdesk").hide();
	id_assistenza='';
	card_turista='';
	ass_esistente=true;
}

function disabilita_turista(){
	$(':text','#box-turista').attr('disabled','disabled');
	//$("#concorrenza").attr('disabled','disabled');
	$("#tipo_doc").attr('disabled','disabled');
	$("#gender").attr('disabled','disabled');
	$("#cerca_tur").attr('disabled','disabled');
}


function genera_num(valmin, valmax) {
 	valmin = Math.ceil(valmin);
  	valmax = Math.floor(valmax);
  	var num = Math.floor(Math.random() * (valmax - valmin + 1)) + valmin;
  	return num;
}

function genera_psw(lung_psw){
	
	var selectionarray=new Array(62)
	selectionarray=["@","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","!","?","#","-"];
	var length=selectionarray.length-1;
  	var i=0,j;
	var passw="";
	while(i<lung_psw){
		j=genera_num(0,length);
		passw=passw+selectionarray[j]
		i++;
	}
	return passw;
}

function diff_date(data_da,data_a,gg_max){

	var data_da = new Date(data_da);
	var data_a = new Date(data_a);
	var gg_max = gg_max;

	var diff = new Date( data_da.getTime() - data_a.getTime() );
	var days = diff/1000/60/60/24;

	if(Math.abs(days) < gg_max){

		return true;
	}else{
		return false;
	}
}

function verifica_numfat(num,datafat){
	var num=num;
	var esito;
		$.ajax({
			beforeSend:sessione_scaduta,
	      type: 'post',
	      async: false,
	      url: 'taxewin_verfat.php',
	      data:'numfat='+num+'&datafat='+datafat,
	      success: function(data) {
	      			esito=data.trovata;
	        },
	      error: function(err, textStatus, errorThrown) {
	          console.log("errore ajax verifica_numfat()" + textStatus + " " + errorThrown);
	        },
	      dataType: 'json'
	    });
	return esito;
}

function camera(){
	// Grab elements, create settings, etc.
	var video = document.getElementById('video');
	
	/*// Get access to the camera!
	navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia);
	if(navigator.getMedia) {
	    // Not adding `{ audio: true }` since we only want video now
	    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
	        video.srcObject = stream;
	        video.play();
	    });*/
	
	// Older browsers might not implement mediaDevices at all, so we set an empty object first
	if (navigator.mediaDevices === undefined) {
	  navigator.mediaDevices = {};
	}

	// Some browsers partially implement mediaDevices. We can't just assign an object
	// with getUserMedia as it would overwrite existing properties.
	// Here, we will just add the getUserMedia property if it's missing.
	if (navigator.mediaDevices.getUserMedia === undefined) {
	  navigator.mediaDevices.getUserMedia = function(constraints) {
	
	    // First get ahold of the legacy getUserMedia, if present
	    var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
	
	    // Some browsers just don't implement it - return a rejected promise with an error
	    // to keep a consistent interface
	    if (!getUserMedia) {
	      return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
	    }

	    // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
	    return new Promise(function(resolve, reject) {
	      getUserMedia.call(navigator, constraints, resolve, reject);
	    });
	  }
	}
	
	// Facciamo una nuova "promessa": promettiamo la strings 'result'
    // (dopo aver aspettato 3s)
    var p1 = new Promise(
        // La funzione è chiamata con la capacità di risolvere o
        // rigettare la promessa
        function(resolve, reject) {
            //console.log('Promise started (<small>Async code started</small>)<br/>');
            // Questo è solo un esempio per creare l'asincronicità
            /*window.setTimeout(
                function() {
                    // Rispettiamo la promessa!
                    resolve(console.log('risolto'));
                }, Math.random() * 6000 + 1000);*/
            //navigator.mediaDevices.getUserMedia({ audio: false, video: true });
            resolve(navigator.mediaDevices.getUserMedia({ audio: false, video: true }) );
        });

    // Definiamo cosa fare in caso di risoluzione della promise
    // ma potremmo chiamare questo metodo solo se la
    // promise è soddisfatta
    p1.then(function(stream) {
	  var video = document.querySelector('video');
	  // Older browsers may not have srcObject
	  //console.log(video);
	  video.srcObject = stream;
	  video.onloadedmetadata = function(e) {
	    video.play();
	  };
      /*  // Scrivi un log con un messaggio e un valore
        function(val) {
            console.log('funzionato');
        }*/
	}).catch(
        // Le promesse fallite ignorano il metodo Promise.prototype.then(onFulfilled)
        function(reason) {
            //console.log(reason);
        });

	/*navigator.mediaDevices.getUserMedia({ audio: false, video: true })
	.then(function(stream) {
	  var video = document.querySelector('video');
	  // Older browsers may not have srcObject
	  console.log(video);
	  if ("srcObject" in video) {
	    video.srcObject = stream;
	  } else {
	    // Avoid using this in new browsers, as it is going away.
	    video.src = window.URL.createObjectURL(stream);
	  }
	  video.onloadedmetadata = function(e) {
	    video.play();
	  };
	})
	.catch(function(err) {
	  console.log(err.name + ": " + err.message);
	});  */
	
	html='<div>'+
			'<video id="video" width="480" height="320" autoplay></video>'+
			'<button id="snap">Snap Photo</button>'+
			'<canvas id="canvas" width="480" height="320"></canvas>'+
			'</div>';
	$( "#dialog_camera" ).dialog({
				autoOpen: false,
				modal: true,
				async: false,
				closeOnEscape: false,
				title:'AVVISO',
				buttons: {	Ok: function() {
											$(this).dialog("close");
											$(this).empty();
											}
						}
	});
	$('#dialog_camera').html(html);
	$('#dialog_camera').dialog("option", "minWidth", '50%');
	$('#dialog_camera').dialog("option", "maxWidth", '90%');
	$('#dialog_camera').dialog("open");
		// Elements for taking the snapshot
	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');

	// Trigger photo take
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 480, 320);
	});
}
function controllaLogin(){


	var user = $("#username").val();
	var pass = $("#password").val();


	user = (user).replace("%", "");
	pass = (pass).replace("%", "");
	if (user == ""){$("#username").css({'background-color' : '#F00'});}
	if (pass == ""){$("#password").css({'background-color' : '#F00'});}
	if (user !="" && pass != ""){
		$.ajax({
		url: 'checkLogin.php',
		method: 'POST',
		data: {username:user, password:pass},
		dataType: 'text',
		success: function(risposta) {
			if (risposta == "ok") {
				if(user=="tur_milano@tur_milanobigli" || user=="tur_roma@tur_romafontanella"){
					location.replace("taxewin_cardturisti.php");
				}else{
					location.replace("taxewin_index.php");
				}
			}else if (risposta == "timeout") {
				location.replace("logout.php");
			}else{
				$('div#infoLogin').empty;
				$('div#infoLogin').html("Utente non riconosciuto");
				}
			},
		error: function(err, textStatus, errorThrown) {
	          console.log("error ajax controlla login"+ textStatus + " " + errorThrown);
	          }
	  });
	}
}

function controllaLogin2(){

	var user = $("#username").val();
	var pass = $("#password").val();
	var esito=false;
	user = (user).replace("%", "");
	pass = (pass).replace("%", "");
	if (user == ""){$("#username").css({'background-color' : '#F00'});}
	if (pass == ""){$("#password").css({'background-color' : '#F00'});}
	if (user !="" && pass != ""){
		$.ajax({
		url: 'checkLogin.php',
		method: 'POST',
		async: false,
		data: {username:user, password:pass},
		dataType: 'text',
		success: function(risposta) {
			if (risposta == "ok") {
				esito=true;
			}else{
				$('div#infoLogin').empty;
				$('div#infoLogin').html("Utente non riconosciuto");
				}
			},
		error: function(err, textStatus, errorThrown) {
	          console.log("error ajax controlla login2 "+ textStatus + " " + errorThrown);
	          }
	  });
	}
	return esito;
}

function sbiancaCampo(campo){
	$("#" + campo).css({'background-color' : '#FFF'});
}

function passwordDimenticata(){
var user = $("#username").val();
	if (user != ""){
		$.ajax({
			url: 'passwordDimenticata.php',
			method: 'POST',
			data: 'username=' + user,
			dataType: 'html',
			success: function(risposta) {
				$('div#infoLogin').html(risposta);/*
				if (risposta == 0) {
					$('div#infoLogin').empty;
					$('div#infoLogin').html("E' stata inviata una mail con le indicazioni \n per il recupero della password all'indirizzo:\n");
				}else{
					$('div#infoLogin').empty;
					$('div#infoLogin').html("L'username inserito non è riconosciuto");
				}*/
			},
			error: function(err, textStatus, errorThrown) {
	          console.log("error ajax pswd dimenticata "+ textStatus + " " + errorThrown);
	          }
		});
	}else{
		$('div#infoLogin').empty;
		$('div#infoLogin').html("Inserire il nome utente.");
		$("#username").focus();
	}
}

function chiudimenu(){
	$('#menu').animate({	width: "0px",
						    
						    opacity: 0	}, 	400, function(){ $('#menu').hide(); });
	
}

function aprimenu(){
	$('#menu').show();
	
	$('#menu').animate({	width: "60%",
						   
						    opacity: 1	}, 400 );
	$('#new').focus();
}

function disply_blocchi(blocco){
	switch(blocco){
		case 1:
			$('#' + array_blocchi_display[2]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[3]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[4]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[5]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[0]).css('visibility', 'visible');
			$('#' + array_blocchi_display[1]).css('visibility', 'visible');
			$('#indietro').css('visibility', 'hidden');
			$('#avanti').css('visibility', 'visible');
			
			break;
		case 2:
			$('#' + array_blocchi_display[0]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[3]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[4]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[5]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[1]).css('visibility', 'visible');
			$('#' + array_blocchi_display[2]).css('visibility', 'visible');
			$('#avanti').css('visibility', 'visible');
			$('#indietro').css('visibility', 'visible');
			break;
		case 3:
			$('#' + array_blocchi_display[0]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[1]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[2]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[3]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[4]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[5]).each(function () {
															    this.style.setProperty('visibility','visible','important');
											});
			$('#avanti').css('visibility', 'visible');
			$('#indietro').css('visibility', 'visible');
			break;
		case 4:
			$('#' + array_blocchi_display[0]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[1]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[2]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[5]).css('visibility', 'hidden');
			$('#' + array_blocchi_display[3]).css('visibility', 'visible');
			$('#avanti').css('visibility', 'hidden');
			$('#' + array_blocchi_display[4]).css('visibility', 'visible');
			$('#indietro').css('visibility', 'visible');
			break;
		default:
			$('#' + array_blocchi_display[0]).css('visibility', 'visible');
			$('#' + array_blocchi_display[1]).css('visibility', 'visible');
			$('#' + array_blocchi_display[2]).css('visibility', 'visible');
			$('#' + array_blocchi_display[3]).css('visibility', 'visible');
			$('#' + array_blocchi_display[4]).css('visibility', 'visible');
			$('#' + array_blocchi_display[5]).css('visibility', 'visible');
			$('#indietro').css('visibility', 'hidden');
			$('#avanti').css('visibility', 'hidden');
			break;
	}	
	$('#blocco').val(blocco);	
}

function sessione_scaduta(){
	html='<table border="0" cellspacing="0" cellpadding="2" class="tableMain" style="margin-right:auto;margin-left:auto;width:70%;background-color:#FFD600;" >'+
			'<tr>'+
				'<td colspan="2" style="text-align:center;">'+
					'<img src="./img/logo.png" >'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td style="text-align:right">Utente :</td>'+
				'<td>'+
					'<input id="username" name="username" type="text" size="20" placeholder="username"  />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td style="text-align:right">Password :</td>'+
				'<td>'+
					'<input id="password" name="password" type="password" size="20" maxlength="20" placeholder="password" />'+
				'</td>'+
			'</tr>'+
			'<tr>'+
				'<td colspan="2" style="text-align:center;">'+
					'<div id="infoLogin"></div>'+
				'</td>'+
			'</tr>'+
		'</table>';
	$.ajax({
			url: 'taxewin_session.php',
			dataType: 'json',
			async: false,
			success: function(risposta) {
				if(risposta){
					$( "#dialog_sessione" ).dialog({
						autoOpen: false,
						modal: true,
						async: false,
						closeOnEscape: false,
						title:'AVVISO SESSIONE SCADUTA',
						buttons: {	LogIn: function() {
														if(controllaLogin2()){	
															numfattura();
										    				presuf();
															$(this).dialog("close");	}
														}
								}
						
					});
					$( "#dialog_sessione" ).html(html);
					$('#dialog_sessione').dialog("option", "minWidth", '50%');
					$('#dialog_sessione').dialog("option", "maxWidth", '90%');
					$( "#dialog_sessione" ).dialog( "open" );	
				}else{
					return;
				}
			},
			error: function(err, textStatus, errorThrown) {
	          console.log("error ajax sessione scaduta "+ err + " " + textStatus + " " + errorThrown);
	          }
		});	        
}

function validaMail(email) {
	var result_mail =true;
	var regex =/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
				///^(([a-zA-Z0-9_.-])+@(([a-zA-Z0-9%+-])+.)+([a-zA-Z0-9]{2,4})+$)/;
				///^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
				//^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,}$
				//^
		result_mail=regex.test(email);
		if(!result_mail){
			alert("La mail inserita non e' corretta\n Digitarla in modo corretto.");
		}
	return result_mail
}

function tips(id_input,div_tips){
	
	var left;
	var top;
	$('#' + div_tips).remove();		
	//var div = $('<div />').insertAfter($('#' + id_input));
	$('#' + id_input).after('<div id="'+div_tips+'" />');
	var div = $('#' + div_tips);
	div.css({'display':'block','z-index':'1000','position':'absolute','background-color':'#FF4D4D','border-radius':'4px','font-size':'12pt','padding':'2px','width':'auto','box-shadow':'0 10px 10px -10px rgba(0, 0, 0, 1)'});
	//div.attr('id', div_tips);
	div.html($('#' + id_input).attr('title'));
	var offset_div=div.offset();
	var offset=$('#' + id_input).offset();
	var offset2=$('#box-principale').offset();
	//console.log(offset2);
	//console.log(offset);
	//console.log(offset_div);
	//console.log(div.position().left);
	//console.log($('#' + id_input).position().left);
	
	var larghezza = window.outerWidth;
	if(larghezza==''){
		larghezza = screen.width;
	}
	
	larghezza=larghezza/2;
	
	/*if(offset.left>larghezza){	
		left=div.position().left - $('#' + id_input).width() - div.width() - 10; 	
	}else{
		left=div.position().left-8;
	}*/
	//left=$('#' + id_input).width();	
	
	//console.log(left+ ' ' +top+ ' larghezza tot:'+$('#' + id_input).width()+ ' left tot:'+offset.left+ ' left div:'+div.position().left+' larghezza div'+div.width());
	//top=div.position().top - 12;
	top= 20;
	//div.html(offset.left+ ' ' +offset.top);
	
	div.css({'top':$('#' + id_input).position().top+38 , 'left': $('#' + id_input).position().left });
	//function rimuovidiv(){
		$('#' + div_tips).css( "display", "inline" ).fadeOut( 4500 );
	//}
	//setInterval(rimuovidiv, 2000);
	
}

function orario(id_input,div_orario,selora,selmin){
	
	var left;
	var top;
	//var div = $('<div />').insertAfter($('#' + id_input));
	$('#' + id_input).after('<div id="'+div_orario+'" />');
	var div = $('#' + div_orario);
	div.css({'visibility':'hidden','z-index':'1000','position':'absolute','background-color':'#bbae91','border-radius':'5px','font-size':'12pt','padding':'2px','width':'auto','box-shadow':'0 10px 10px -10px rgba(0, 0, 0, 1)'});
	var html_ora='<div id="ora">';
	
	for(var i=0; i<24; i++){
		var ora = "" + i;
		var pad = "00";
		var ora = pad.substring(0, pad.length - ora.length) + ora;
		html_ora+='<label id="ora_'+ora+'" onclick="document.getElementById(\'ote_oravolo\').value=\''+ora+'\'; document.getElementById(\'ote_oravolo\').style.background=\'\';">'+ora+'</label>';
		if(ora == '05' || ora == '11' || ora == '17' || ora == '23' ){
			html_ora+='<br/>';
		}
	}
	html_ora+='</div>';
	var html_min='<div id="min">';
	
	for(var i=0; i<60; i=i+5){
		var minuto = "" + i;
		var pad = "00";
		var minuto = pad.substring(0, pad.length - minuto.length) + minuto;
		html_min+='<label onclick="document.getElementById(\'ote_minvolo\').value=\''+minuto+'\'; document.getElementById(\'ote_minvolo\').style.background=\'\';">'+minuto+'</label>';
		if((minuto %3 == 1 ?  true : false)){
			html_min+='<br/>';
		}
	}
	html_min+='</div>';		
	html_punti='<div id="punti">:</div>';
	div.css({'top':$('#' + id_input).position().top+45,'left':$('#' + id_input).position().left+30});
	//$('#' + div_orario).css( "display", "inline" ).fadeOut( 4500 );	
	$('#' + div_orario).html(html_ora+html_punti+html_min);
	$('#' + div_orario).focusout(function(){
		//$('#' + div_orario).remove(); 
		//alert('ciao');
	});
	$('#' + div_orario + ' #ora label').on('click',function(){
		$('#' + div_orario + ' #ora label').css({'background-color':''});
		$(this).css({'background-color':'green'});
	});
	$('#' + div_orario + ' #min label').on('click',function(){
		$('#' + div_orario + ' #min label').css({'background-color':''});
		$(this).css({'background-color':'green'});
	});
	if(selora != ''){
		$('#ora_' + selora).css({'background-color':'green'});
	}
	if(selmin != ''){
		$('#min_' + selmin).css({'background-color':'green'});
	}
}

function campi_tax_duty(tipo_modulo){
	switch(tipo_modulo){
		case 'duty':
			$('#box-articoli').css({'background-image':'url("img/duty.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
			$('#box_duty').show();
			$('#box-totali2-ref span').html('Duty');
			modulo_duty=true;
		break;
		
		case 'tax':
			$('#box-articoli').css({'background-image':'url("img/tax.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
			$('#box-totali2-ref span').html('Ref.');
			$('#box_duty').hide();
			modulo_duty=false;
		break;
	}
}

function scelta_duty_tax(){
	butt_dialog_duty =	[	{	text: "TaxRefund", "class": 'ddut_tax move_duty', click: function() {	
																								campi_tax_duty('tax');
																								$(this).dialog("close");
																								posiziona_focus();
																							}	
							},
							{	text: "Duty", "class": 'ddut_duty move_duty', click: function() {
																				campi_tax_duty('duty');
																				$(this).dialog("close");
																				posiziona_focus();
																			}	
							}
						];
		$( "#dialog_duty" ).dialog({
										autoOpen: false,
										modal: true,
										async: false,
										closeOnEscape: false,
										title:'Tipo Di Emissione',
										buttons: butt_dialog_duty,
										dialogClass: 'dialogservizio'
									});	
		$( "#dialog_duty" ).html("Scegliere il servizio da utilizzare.");
		$('#dialog_duty').dialog("option", "minWidth", '50%');
		$('#dialog_duty').dialog("option", "maxWidth", '90%');
		$( "#dialog_duty" ).dialog( "open" );
		$('#dialog_duty').parent().find('.ui-dialog-buttonset button:first-of-type').focus();
		$('body').on('keydown', '.ui-dialog-buttonset', function (event) {
		    var myself = this;
		    if (event.keyCode === 13) {
		    	event.target.click();
		        event.preventDefault();
		    }
		}); 
		//$( "#dialog_duty button:first-of-type").focus();
		// mettere focus sul tasto ???????????????????????????????
}

/*function scelta_duty_tax(){
	butt_dialog_duty =	[	{	text: "TaxRefund", "class": 'ddut_tax move_duty', click: function() {	
																								$('#box-articoli').css({'background-image':'url("img/tax.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
																								$('#box-totali2-ref span').html('Ref.');
																								$('#box_duty').hide();
																								modulo_duty=false;
																								$(this).dialog("close");
																								posiziona_focus();
																							}	
							},
							{	text: "Duty", "class": 'ddut_duty move_duty', click: function() {
																				$('#box-articoli').css({'background-image':'url("img/duty.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
																				$('#box_duty').show();
																				$('#box-totali2-ref span').html('Duty');
																				modulo_duty=true;
																				$(this).dialog("close");
																				posiziona_focus();
																			}	
							}
						];
		$( "#dialog_duty" ).dialog({
										autoOpen: false,
										modal: true,
										async: false,
										closeOnEscape: false,
										title:'Tipo Di Emissione',
										buttons: butt_dialog_duty,
										dialogClass: 'dialogservizio'
									});	
		$( "#dialog_duty" ).html("Scegliere il servizio da utilizzare.");
		$('#dialog_duty').dialog("option", "minWidth", '50%');
		$('#dialog_duty').dialog("option", "maxWidth", '90%');
		$( "#dialog_duty" ).dialog( "open" );
		$('#dialog_duty').parent().find('.ui-dialog-buttonset button:first-of-type').focus();
		$('body').on('keydown', '.ui-dialog-buttonset', function (event) {
		    var myself = this;
		    if (event.keyCode === 13) {
		    	event.target.click();
		        event.preventDefault();
		    }
		}); 
		//$( "#dialog_duty button:first-of-type").focus();
		// mettere focus sul tasto ???????????????????????????????
}*/

function swipecc(){
	swipev=$('#ccredito').val();
	if(swipev.substr(0,2)=='%b' || swipev.substr(0,2)=='%B'){
		var posizione=swipev.indexOf("&");
		if(posizione==-1) { posizione=swipev.indexOf("^"); }
		var cc=swipev.substr(2,posizione-2);
		swipev=swipev.substr(posizione+1,swipev.length - posizione);
		posizione=swipev.indexOf("&");
		if(posizione==-1) { posizione=swipev.indexOf("^"); }
		var nome=swipev.substr(0,posizione);
		swipev=swipev.substr(posizione+1,swipev.length - posizione);
		var ccexp=swipev.substr(2,2)+"/"+swipev.substr(0,2);
		$('#ccredito').val(cc);
		//document.controlla.nometurista.value=nome.replace("-"," ","g");
		$('#cc_exp').val(ccexp);
		//document.controlla.swipe.value='swiped';
	}
	//Dblur('creditcard',false);
	//document.controlla.datapart.focus();
	fallo=true;
	$('#ajax_loader').hide();
}
var fallo=true
function startswipe3sec(evt) {

	var evt = (evt) ? evt : ((event) ? event : null);
	var charcode = evt.which || evt.keyCode
	
	if(charcode==37 && fallo) {
		$('#ajax_loader').show();
		fallo=false;
		window.setTimeout(swipecc,3500);
	}
	
}

function tasto_stampa(){
	if($('#tot_fattura').val() < LIMITE_LEGGE){
		  	html="L'Importo Fattura Deve Superare<br/>Il Limite di Legge Di Euro" + LIMITE_LEGGE;
			$( "#dialog_limite" ).dialog({
								autoOpen: false,
								modal: true,
								async: false,
								closeOnEscape: false,
								title:'AVVISO',
								buttons: {	Ok: function() {
															$(this).dialog("close");
															}
										}
			});
			$('#dialog_limite').dialog('option', 'minWidth', '50%');
			$('#dialog_limite').dialog('option', 'maxWidth', '90%');
			$('#dialog_limite').html(html);
			$('#dialog_limite').dialog('open');
			
			return;
		}
		////////////////////////////////////////////////////////////////////////////////////// provo a bypassare questo controllo numero fattura tanto lui prende l'ultimo disponibile comunque
		/*var ver=verifica_numfat($('#numero').val(),$('#data-fattura').val());
		if(ver>0 && $( "#id_php" ).val()==''){
			var html='Fattura Gi&agrave; Presente In Archivio.';
			$( "#dialog_fattpresente" ).dialog({
						autoOpen: false,
						modal: true,
						async: false,
						title:'AVVISO',
						buttons: {	Ok: function() {
													$(this).dialog("close");
													}
								}
			});
			$( "#dialog_fattpresente" ).html(html);
			$('#dialog_fattpresente').dialog("option", "minWidth", '50%');
			$('#dialog_fattpresente').dialog("option", "maxWidth", '90%');
			$( "#dialog_fattpresente" ).dialog( "open" );
			return;
		}*/	
		//////////////////////////////////////////////////////////////////////////////////////
	inserisci_tur('',false);
			
		//return;
		var html='Confermare Salvataggio Fattura?';
		$( "#dialog_stampa" ).dialog({
					autoOpen: false,
					modal: true,
					async: false,
					closeOnEscape: false,
					title:'AVVISO',
					buttons: {	Ok: function() {
												if(duty_conf){
													scelta_duty_tax();
												}else{
													$('#box-articoli').css({'background-image':'url("img/tax.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
													posiziona_focus();
												}
												if(!salva_dati(modulo_duty)){
													$(this).dialog("close"); 
													return;
												}
												if(id_assistenza!=''){
													conferma_assistenza();
												}
												sbianca_campi();
												sbianca_turista();
												numfattura();
				    							presuf();
												$(this).dialog("close");
												
												},
								Annulla: function(){
												$(this).dialog("close");
												}
								}
		});
		$( "#dialog_stampa" ).html(html);
		$('#dialog_stampa').dialog("option", "minWidth", '50%');
		$('#dialog_stampa').dialog("option", "maxWidth", '90%');
		$( "#dialog_stampa" ).dialog( "open" );
		var datamod=$('#data-fattura').val();
		var datanow=$('#dataoggi').val();
		//if(verifica_data('data-fattura',datamod,datanow)){ alert('aaaa');}
}

function posiziona_focus(){
	if($('#qta_mob').css('display') == 'none'){
										if(duty_conf && modulo_duty){
											$('#ccredito').focus();
											$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
											if(tastiera_conf){
												$("[class*='evidenzia_blocchi1']").css( { "background-color" : "#00ff03" } );
											}
										}else{
											$('#qta').focus();
											$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
											if(tastiera_conf){
												$("[class*='evidenzia_blocchi2']").css( { "background-color" : "#00ff03" } );
											}
										}
									}else{
										$('#qta_mob').focus();
									}
}

function carica_data(){
	var risposta_data=false;
	$.ajax({
			url: 'taxewin_data.php',
			dataType: 'json',
			async: false,
			success: function(risposta) {
				if(risposta){
					risposta_data=risposta
				}else{
					alert('Attenzione problema con data di sistema. \nE\' necessario aggiornare la pagina con [F5]');
					risposta_data=false;
				}
			},
			error: function(err, textStatus, errorThrown) {
	          console.log("error ajax calcolo data "+ err + " " + textStatus + " " + errorThrown);
	          }
	});	        
	
	return risposta_data;
}

function nascondi_load_qrc(){
	$("#ajax_loader").hide();
}

function ricerca_qrcode(cod_qrcode){
	return new Promise(function(resolve, reject){
		lista_qrc='';
		$.ajax({
				beforeSend:nascondi_load_qrc,
				url: 'taxewin_cercaqrc.php',
				dataType: 'json',
				async: true,
				method: 'POST',
				data: 'ricerca_qrc=' + cod_qrcode,
				success: function(risposta) {
					if(!risposta.error){
						resolve(risposta);
						if(risposta.array_tur != '' ){
							document.getElementById('name').value=risposta.array_tur.qrcode_nome;
							document.getElementById('surname').value=risposta.array_tur.qrcode_cognome;
							document.getElementById('gender').value=risposta.array_tur.qrcode_gender;
							document.getElementById('email').value=risposta.array_tur.qrcode_email;
							var qrc_nascita_dritta=risposta.array_tur.qrcode_dnascita.substr(8,2) +'/' + risposta.array_tur.qrcode_dnascita.substr(5,2)+'/' + risposta.array_tur.qrcode_dnascita.substr(0,4);
							document.getElementById('dtbirt').value=qrc_nascita_dritta;
							document.getElementById('country_cod').value=risposta.array_tur.qrcode_nazione;
							document.getElementById('country').value=naz[codici_naz[risposta.array_tur.qrcode_nazione]];
							var appoggio_doc_up=risposta.array_tur.qrcode_tipodoc.toString(); 
							document.getElementById('tipo_doc').value=appoggio_doc_up.toUpperCase();
							document.getElementById('doc').value=risposta.array_tur.qrcode_doc;
							var qrc_exp=risposta.array_tur.qrcode_scaddoc.substr(8,2) +'/' + risposta.array_tur.qrcode_scaddoc.substr(5,2)+'/' + risposta.array_tur.qrcode_scaddoc.substr(0,4);
							document.getElementById('exp').value=qrc_exp;
							document.getElementById('nazdoc_cod').value=risposta.array_tur.qrcode_nazdoc;
							document.getElementById('nazdoc').value=naz[codici_naz[risposta.array_tur.qrcode_nazdoc]];
							document.getElementById('birt_cod').value=risposta.array_tur.qrcode_nazione;
							document.getElementById('birt').value=naz[codici_naz[risposta.array_tur.qrcode_nazione]];
							console.log(naz);
						}
					}else{
						var risposta = {
									esito: true,
				        			msg: 'Attenzione problema ricerca turista'
									};
						reject(risposta);
						
					}
				},
				error: function(err, textStatus, errorThrown) {
					var risposta = {
									esito: false,
				        			msg: "error ajax calcolo qrcode "+ err + " " + textStatus + " " + errorThrown
									};
					reject(risposta);
		          console.log("error ajax calcolo data "+ err + " " + textStatus + " " + errorThrown);
		          }
		});
	
	});
}

function qrcode_app(){
	return new Promise(function(resolve, reject){
		$.ajax({
				url: 'taxewin_dataqr.php',
				dataType: 'json',
				async: true,
				method: 'POST',
				data: 'associato=' + $('#associato').val(),
				success: function(data) {
					if(!data.error){
						resolve(data);
						
					}else{
						var risposta = {
									esito: true,
				        			msg: 'Attenzione : ' + data.msg
									};
						reject(risposta);
						
					}
				},
				error: function(err, textStatus, errorThrown) {
					var risposta = {
									esito: false,
				        			msg: "error ajax calcolo qrcode "+ err + " " + textStatus + " " + errorThrown
									};
					console.log("error ajax calcolo qrcode "+ err + " " + textStatus + " " + errorThrown);
					reject(risposta);
		          
		          }
		});
	});  

}

	

$(document).ready(function() {
	/*jQuery(function ($){
		$(document).ajaxStop(function(){
            document.getElementById('ajax_loader').style.display='none';
            alert('none');
         });
         $(document).ajaxStart(function(){
            document.getElementById('ajax_loader').style.display='block';
            alert('block');
         });
    });*/
	//alert(app_qrc);
	if(duty_conf){
		scelta_duty_tax();
	}else{
		$('#box-articoli').css({'background-image':'url("img/tax.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
		posiziona_focus();
	}
	
	$('#app_tur').on('click',function(){
		qrcode_app()
			.then(function(data){	
					var html='<div id="contenitore_qr"><div id="app_qrcode"><\div><\div>';
						$( "#dialog_qrcode" ).dialog({
									autoOpen: false,
									modal: true,
									async: false,
									closeOnEscape: false,
									title:'Scansionare il QRCODE con la App Taxrefund'/*,
									buttons: {	Chiudi: function() {
																$(this).dialog("close");
																$(this).empty();											
												}
											}*/
						});
						$( "#dialog_qrcode" ).html(html);
						$("#app_qrcode").qrcode({ text: data.qrc_tur,
					                      //render: "table",
					                      width: 350,
					                      height: 350
					                      //qrsize: 50
					                    })
						$('#dialog_qrcode').dialog("option", "Width", '400');
						$('#dialog_qrcode').dialog("option", "Width", '400');
						$( "#dialog_qrcode" ).dialog( "open" );
						ricerca_qrcode(data.qrc_tur)
							.then(function(result){	
								$( "#dialog_qrcode" ).dialog( "close" );
								$( "#dialog_qrcode" ).empty();
							})
							.catch(function(error){	
									if(error.esito){
										alert('aa'+error.msg);
									}else{
										alert('bb'+error.msg);
									}
									//$("#ajax_loader").hide();
									console.log(error);
									$("#ajax_loader").hide(); 
							});
						
					//console.log(result);
					//$("#ajax_loader").hide();  
																								
			})
			.catch(function(errore){	
					if(errore.esito){
						alert('cc'+errore.msg);
					}else{
						alert('ff'+errore.msg);
					}
					//$("#ajax_loader").hide();
					console.log(errore);
					$("#ajax_loader").hide(); 
			});

	});
	if(typeof app_qrc !== 'undefined' && app_qrc){
		document.getElementById('app_tur').style.display='block';
		document.getElementById('cerca_tur').style.width='50%';
	}
	var schermo=info_utente();
	//alert(window.innerWidth+' '+window.innerHeight);
   	//if(schermo.info.monitorX > schermo.info.monitorY ){	// metto una pezza perchè l'ipad viene visto sempre in verticale e X è sempre minore di Y
   	if(window.innerWidth > window.innerHeight ){	// metto una pezza perchè l'ipad viene visto sempre in verticale e X è sempre minore di Y
   		mobile=0;
    }else{
   		mobile=1;
   		//alert(window.innerHeight+'ciao'+window.innerWidth+' '+navigator.platform);
    }
    /*$('#camera').on('click',function(){
    	camera();
			});*/
	//$(document).bind("ajaxStop",function () {
	$(document).ajaxStop(function(){	
    		$("#ajax_loader").hide();
    		//$("#ajax_loader").css({'display':'none'});
		});
	//$(document).bind("ajaxStart",function () {
	$(document).ajaxStart(function(){
		$("#ajax_loader").show();
		//$("#ajax_loader").css({'display':'block'});
		//alert('block');
	});
	//$("#ajax_loader").hide();
	//alert('inserire prefisso telefonico !!');
	carica_indirizzi();
	//if(typeof carica_indirizzi === 'function'){	}
	//alert('pippo');
	$('#formtax input,#formtax select').on('focus click',function(event){ 
    	//$('#formtax input').focus();
    	if(event.target.hasAttribute('title') && event.target.title!=''){
			tips(event.target.id,'tips');
		}
		//$( this ).off( event );    	
    });   
    if(typeof sconto !== 'undefined' && sconto!=0){
		$('#int-sconto').css('visibility', 'visible');
		$('#sco').css('visibility', 'visible');
	}
	if(typeof priority_conf !== 'undefined' && priority_conf){
		$('#tur_fastline').css('visibility', 'visible');
		$('#tur_vipdesk').css('visibility', 'visible');
	}
	$('#avanti').on('click',function(){
							var numblocco = $('#blocco').val();
							numblocco = parseInt(numblocco) + 1;
								disply_blocchi(numblocco);
								mobile=1;
								
	});
	$('#indietro').on('click',function(){
							var numblocco = $('#blocco').val();
							numblocco = parseInt(numblocco) - 1;
								disply_blocchi(numblocco);
	});
	
	$('#ccredito').on('keypress',function(evt){
		startswipe3sec(evt);
	});
	
	$('#ccredito').on('blur',function(){
		if($('#ccredito').val() != '' ){
			if( !verifica_cc($('#ccredito').val()) ){
				$('#ccredito').val('');
				$('#ccredito').focus();
				$('#ccredito').css({'background-color' : 'red'});
			}else{
				$('#ccredito').css({'background-color' : '#00ff08'});
				if( $('#cc_exp').val()!='' ){
					if(!scadenza_cc('cc_exp',mesicc_config,'ccredito') ){
						$('#cc_exp').css({'background-color' : 'red'});
						$('#ccredito').focus();
					}else{
						$('#cc_exp').css({'background-color' : '#00ff08'});
					}
				}
			}
		}
	});
	
	$('#cc_exp').on('blur',function(){
		if( $('#cc_exp').val()!='' ){
			if( !scadenza_cc('cc_exp',mesicc_config,'ccredito') ){
				$('#cc_exp').css({'background-color' : 'red'});
			}else{
				$('#cc_exp').css({'background-color' : '#00ff08'});
			}
		}
	});
	
	$('#info').on('click',show_info);

	$('#openMenu').on('click',function(){
        							aprimenu();
	});

	$('#closeMenu').on('click',function(){
									chiudimenu();
	});
	$('#menu').on('blur',function(){
		chiudimenu();
	});
	$('#tur_fastline').on('click',function(){
									
									/*var resp_ricerca=ricerca_tur( $('#email').val(),false);
									var resp_insetur=inserisci_tur(resp_ricerca);*/
									
									var resp_insetur
									
									function fn_show(){
										var dfd = $.Deferred();
										//$("#ajax_loader").css({'display':'block'});
										//document.getElementById('ajax_loader').style.display='block';
										$("#ajax_loader").show(300, dfd.resolve);
										//dfd.resolve();
										return dfd.promise();
									}
									function fn1(){
										var dfd = $.Deferred();
										resp_insetur=inserisci_tur();
										dfd.resolve();
										return dfd.promise();
									}
									//if(!resp_ricerca || (!resp_insetur && resp_ricerca )){
										//ricerca_tur( $('#email').val(),false);
										
											// ricerco itinerario se esistente
											
									function fn3(){
										var dfd = $.Deferred();
										if(!resp_insetur){
											//alert(card_turista);
											ass_esistente=ricerca_assistenza(card_turista);
										}
										dfd.resolve();
										return dfd.promise();
									}
									function fn4(){
										var dfd = $.Deferred();
										if(!resp_insetur){	
										//alert(card_turista);
											ricerca_itinerario(card_turista);
										}
										dfd.resolve();
										return dfd.promise();
									}
										
									/*function test(){
									  var d = jQuery.Deferred(), 
									  p=d.promise();
									  //You can chain jQuery promises using .then
									  //p.then(fn_show)
									  p.then(fn1)
									  .then(fn3)
									  .then(fn4);
									  d.resolve();
									}*/
									$.when(
										fn_show()
									).then(function(){
										var d = $.Deferred(), 
										p = d.promise();
									    p.then(fn1)
									  	.then(fn3)
									  	.then(fn4);
									  	d.resolve();																			
									});
									
		 
									/*if(!avvio_controllo_tur()){
										otello();
										//console.log(turista_anagrafica);
									}else{
										$( "#dialog_verificatur" ).dialog({
												autoOpen: false,
												modal: true,
												async: false,
												title:'AVVISO',
												buttons: {	Ok: function() {
																			$(this).dialog("close");
																			}
															}
										});
										$( "#dialog_verificatur" ).html("E' Necessario Aver Completato Tutti I Dati Del Turista Per Accedere Alla Sezione FastTrack");
										$( "#dialog_verificatur" ).dialog( "open" );		
									}*/
	});
	
	$('#tur_canc').on('click',function(){
									$( "#dialog_sbiancatur" ).dialog({
												autoOpen: false,
												modal: true,
												async: false,
												closeOnEscape: false,
												title:'AVVISO',
												buttons: {	Ok: function() {
																			sbianca_turista();
																			$(this).dialog("close");
																			},
															Annulla: function(){
																			$(this).dialog("close");
																			}
															}
										});
		$( "#dialog_sbiancatur" ).html("Conferma Sbiancamento Form Turista?");
		$('#dialog_sbiancatur').dialog("option", "minWidth", '50%');
		$('#dialog_sbiancatur').dialog("option", "maxWidth", '90%');
		$( "#dialog_sbiancatur" ).dialog( "open" );																	
	});
	
	$('#cerca_tur').on('click',function(){ ricerca_tur();})
	
	$('#salva').on('click',function(){
									calcola_impo2(true);
									salvariga();
									$("#lista_vie").css({display:'none'});
									
									if($('#qta_mob').css('display') == 'none'){
										$('#qta').focus();
									}else{
										$('#qta_mob').focus();
									}
									//posiziona_focus();
									//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
									/*sottrai=false;
									$("#tot").css({'background-color':''});
									$("#salva").val('+');*/
									//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
	});

	$('#archivio').on('click',function(){
									chiudimenu();
									var data_da=$('#data-da').val();
									if(data_da==''){	data_da=$('#datamenoweek').val();	}
										data_da=data_da.substr(6,4)+'-'+data_da.substr(3,2)+'-'+data_da.substr(0,2);
									var data_a=$('#data-a').val();
									if(data_a==''){	data_a=$('#dataoggi').val();	}
										data_a=data_a.substr(6,4)+'-'+data_a.substr(3,2)+'-'+data_a.substr(0,2);
	  									$( "#dialog_richiestaarchivio" ).dialog({
												autoOpen: false,
												modal: true,
												async: false,
												closeOnEscape: false,
												title:'AVVISO',
												buttons: {	Ok: function(evt) {
																			$('#box-principale').css({'background-color':'#ffd600'});
																			pulisci_array();
																			archivio($('#associato').val(),data_da,data_a,'',93);
																			$(this).dialog("close");
																			evt.preventDefault();
																			if(tastiera_conf){
																				$('#lista').focus();
																				$("[class*='evidenzia_blocchi_archivio']").css( { "background-color" : "" } );
																    			$("[class*='evidenzia_blocchi_archivio1']").css( { "background-color" : "#00ff03" } );			
																			}
																			},
															Annulla: function(){
																			$(this).dialog("close");
																			}
															}
										});
		$( "#dialog_richiestaarchivio" ).html("Consultare L'Archivio Fatture?");
		$('#dialog_richiestaarchivio').dialog("option", "minWidth", '50%');
		$('#dialog_richiestaarchivio').dialog("option", "maxWidth", '90%');
		$( "#dialog_richiestaarchivio" ).dialog( "open" );
	});
	
	
	$('#new').on('click',function(){
			chiudimenu();
			$( "#dialog_richiestanew" ).dialog({
					autoOpen: false,
					modal: true,
					async: false,
					closeOnEscape: false,
					title:'AVVISO',
					buttons: {	Ok: function() {
												sbianca_campi();
												sbianca_turista();
				    							pulisci_array();
												numfattura();
				    							presuf();
				    							$('#tur_canc').show();											    							
				    							$('#box-ins').show();
												$('#box-archivio').hide();
												$(this).dialog("close");
												if(duty_conf){
													scelta_duty_tax();
												}else{
													$('#box-articoli').css({'background-image':'url("img/tax.png")','background-repeat':'no-repeat','background-position':'center','background-size':'70%'});
													posiziona_focus();
												}
												},
								Annulla: function(){
												$(this).dialog("close");
												}
					}
			});
			$( "#dialog_richiestanew" ).html("Emettere Nuova Fattura?");
			$('#dialog_richiestanew').dialog("option", "minWidth", '50%');
			$('#dialog_richiestanew').dialog("option", "maxWidth", '90%');
			$( "#dialog_richiestanew" ).dialog( "open" );
  	});

	$('#opzioni').on('click',function(){
			chiudimenu();
			opzioni();
	});

	$('#data-da').on('change',function(){
			check_date(this);
	});
	$("#data-da").on('keypress',function(evt){
			if(evt.which==13){
				if(check_date(this)!=1){
					$('#data-a').focus();
				}
			}
	});

	$('#data-a').on('change',function(evt){
			/*if( ( $('#data-a').val() != '' && check_date(this) != 1 )  || $('#data-a').val()=='' ){
				$('#fattura').focus();
			}else{
				$('data-a').focus();
			}*/
			if(check_date(this)!=1){
				$('#data-a').focus();
			}
	});
	
	$('#data-a').on('keypress',function(evt){
			if(evt.which==13 && check_date(this)!=1){
				//evt.preventDefault();
				$('#fattura').focus();
			}
	});
	
	$("#fattura").on('keypress',function(evt){
			if(evt.which==13){
				//$('#archivio').click();		// per il momento su invio ripasso per click archivio almeno ho il tempo di riposizionarmi col focus sulla lista
				var data_da=$('#data-da').val();
				var fatt_val=$('#fattura').val();
				
				if(data_da==''){
					data_da=$('#datamenoweek').val();	
				}
				
				data_da=data_da.substr(6,4)+'-'+data_da.substr(3,2)+'-'+data_da.substr(0,2);
				var data_a=$('#data-a').val();
				
				if(data_a==''){
					data_a=$('#dataoggi').val();	
				}
				
				data_a=data_a.substr(6,4)+'-'+data_a.substr(3,2)+'-'+data_a.substr(0,2);
				$('#fattura').val('');
				$('#data-da').val('');
				$('#data-a').val('');		
				archivio($('#associato').val(),data_da,data_a,fatt_val,93);
				/*evt.preventDefault();
				$('#lista').click();*/
			}
	});
	
	/*$('#ricerca').on('keypress',function(evt){
			if(evt.which==13){
				$('#ricerca').click();
			}
	});*/
	
	$('#email').on('change',function(){
			if(!validaMail($('#email').val())){
				$('#email').val('');
				setTimeout((function() { $('#email').focus(); }), 0);
			} 
	});
	
	$('#dtbirt').on('change',function(){
			if(check_date_nascita(this)==1){
				$('#dtbirt').val('');
				setTimeout((function() { $('#dtbirt').focus(); }), 0);
			} 
	});
	$('#exp').on('change',function(){
			if(check_date_nascita(this,'exp')==1){
				$('#exp').val('');
				setTimeout((function() { $('#exp').focus(); }), 0);
			} 
	});
	
	
	$('#ricerca').on('click',function(evt){
			var data_da=$('#data-da').val();
			var fatt_val=$('#fattura').val();
			
			if(data_da==''){
				data_da=$('#datamenoweek').val();	
			}
			
			data_da=data_da.substr(6,4)+'-'+data_da.substr(3,2)+'-'+data_da.substr(0,2);
			var data_a=$('#data-a').val();
			
			if(data_a==''){
				data_a=$('#dataoggi').val();	
			}
			
			data_a=data_a.substr(6,4)+'-'+data_a.substr(3,2)+'-'+data_a.substr(0,2);
			$('#fattura').val('');
			$('#data-da').val('');
			$('#data-a').val('');			
			archivio($('#associato').val(),data_da,data_a,fatt_val,93);
	});
					
	$("#username").focus();
	$("#pwdDimenticata").on( "click", passwordDimenticata );
	/*$("#username").on('keydown',function(){sbiancaCampo('username')});
	$("#password").on('keydown',function(){sbiancaCampo('password')});*/
	
	
	$('#card_tur').on('blur keydown',function(evt){			
			turista_anagrafica['card_tur']=$('#card_tur').val();
			if(evt.which == 13 && $('#card_tur').val().trim != ''){
				ricerca_tur();
			}
			//alert('Selezionare Il Competitor Legato Al Numero Della Card Inserita');  
			//$('#concorrenza').css({'background-color' : 'red'});
	});
	/*$('#concorrenza').on('change',function(){	
												$('#concorrenza').css({'background-color' : ''});		
												if($('#card_tur').val()!=0){
													turista_anagrafica['concorrenza']=$('#card_tur').val();
												}else{
													alert('Selezionare Il Competitor Legato Al Numero Della Card Inserita');  
												}
											});	*/	
	$('#dtbirt').on('click',function(){
			if($('#dtbirt').val() == '00/00/0000'){
				$('#dtbirt').val('');
			}
	});
	$('#exp').on('click',function(){
			if($('#exp').val() == '00/00/0000'){
				$('#exp').val('');
			}
	});
	
	$('#card_tur').on('click',function(){		$('#card_tur').css({'background-color' : ''});	});
	
	$('#email').on('keydown',function(){		$('#email').css({'background-color' : ''});	});
		$('#email').on('blur',function(){			turista_anagrafica['email']=$('#email').val();	});
	$('#name').on('keydown',function(){			$('#name').css({'background-color' : ''});	});
		$('#name').on('blur',function(){			turista_anagrafica['name']=$('#name').val();	});
	$('#surname').on('keydown',function(){			$('#surname').css({'background-color' : ''});	});
		$('#surname').on('blur',function(){			turista_anagrafica['surname']=$('#surname').val();	});	
	$('#gender').on('change',function(){		$('#gender').css({'background-color' : ''});	});
		$('#gender').on('change',function(){		turista_anagrafica['gender']=$('#gender').val();	});
	
	$('#addr').on('keydown',function(){			$('#addr').css({'background-color' : ''});	});
		$('#addr').on('blur',function(){			turista_anagrafica['addr']=$('#addr').val();	});
	$('#city').on('keydown',function(){			$('#city').css({'background-color' : ''});	});
		$('#city').on('blur',function(){			turista_anagrafica['city']=$('#city').val();	});
	$('#country').on('keydown',function(){		$('#country').css({'background-color' : ''});	$('#country_cod').css({'background-color' : ''});	});
		$('#country').on('blur',function(){			turista_anagrafica['country']=$('#country').val();
													turista_anagrafica['country_cod']=$('#country_cod').val();	});
	$('#tipo_doc').on('change',function(){		$('#tipo_doc').css({'background-color' : ''});	});
		$('#tipo_doc').on('change',function(){		turista_anagrafica['tipo_doc']=$('#tipo_doc').val();	});
	$('#doc').on('keydown',function(){			$('#doc').css({'background-color' : ''});	});
		$('#doc').on('blur',function(){				turista_anagrafica['doc']=$('#doc').val();	});
	$('#exp').on('keydown',function(){			$('#exp').css({'background-color' : ''});	});
		$('#exp').on('blur',function(){				turista_anagrafica['exp']=$('#exp').val();	});
	$('#nazdoc').on('keydown',function(){		$('#nazdoc').css({'background-color' : ''});	$('#nazdoc_cod').css({'background-color' : ''});	});
		$('#nazdoc').on('blur',function(){			turista_anagrafica['nazdoc']=$('#nazdoc').val();
													turista_anagrafica['nazdoc_cod']=$('#nazdoc_cod').val();	});
	$('#citybirt').on('keydown',function(){		$('#citybirt').css({'background-color' : ''});	});
		$('#citybirt').on('blur',function(){		turista_anagrafica['citybirt']=$('#citybirt').val();	});
	$('#birt').on('keydown',function(){			$('#birt').css({'background-color' : ''});	$('#birt_cod').css({'background-color' : ''});	});
		$('#birt').on('blur',function(){			turista_anagrafica['birt']=$('#birt').val();	
													turista_anagrafica['birt_cod']=$('#birt_cod').val();	});
	$('#dtbirt').on('keydown',function(){		$('#dtbirt').css({'background-color' : ''});	});
		$('#dtbirt').on('blur',function(){			turista_anagrafica['dtbirt']=$('#dtbirt').val();	});
					
	$('#country').on('keyup',function(ev){ caricalista(ev,'togli')});
	//$('#country').on('blur',nascondilista);
	$('#nazdoc').on('keyup',caricalista);
	//$('#nazdoc').on('blur',nascondilista);
	$('#birt').on('keyup',caricalista);
	
	caricaEuropa();
	caricaNazioni();
  	caricaAeroporti();

	$('#numero').on('click',function(){
		if($('#id_php').val()==''){		///////////////////////// chiamo una funzione diversa se sto in modifica. leandro 15/11/17
			tasto_numfat(); 	
		}else{
			tasto_numfat_damod();
		}
	});
	
	/*$("#tot").on('keypress',function(ev){
								if(ev.which==13){
									$('#salva').click();
								}
	});*/
	
    //////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
	/*$("#tot").on('keyup',function(ev){
		//alert(ev.which);
								switch(ev.which) {
									//case 45:	//questo era con keypress ma passo a keyup per android
									case 109:
										sottrai=true;
						
										$("#tot").css({'background-color':'red'});
										$("#qta").val(1);
										$("#qta_mob").val(1);
										$("#qta_hidden").val(1);
										if($("#desc").val()==''){
											$("#desc").val('Sconto');
											$("#desc_hidden").val('Sconto');
											$("#desc_mob").val('');				 
										}
										$("#salva").val('Sconto');
										$("#tot").prop('title','Disabilitare la modalità Sconto Premendo Il Tasto [+]');
										$("#tot").focus();
										break;
									case 229:
										sottrai=true;
						
										$("#tot").css({'background-color':'red'});
										$("#qta").val(1);
										$("#qta_mob").val(1);
										$("#qta_hidden").val(1);
										if($("#desc").val()==''){
											$("#desc").val('Sconto');
											$("#desc_hidden").val('Sconto');
											$("#desc_mob").val('');
										}
										$("#salva").val('Sconto');
										$("#tot").prop('title','Disabilitare la modalità Sconto Premendo Il Tasto [+]');
										$("#tot").focus();
										break;	
									case 43:
										sottrai=false;
										$("#tot").css({'background-color':''});
										if($("#desc").val()=='Sconto'){
											$("#desc").val('');	
										}
										$("#salva").val('+');
										$("#tot").prop('title','Premere Il Tasto Meno [-] Per Abilitare Lo Sconto');
										$("#tot").focus();
										break;
									case 13:
										if(sconto == 0){
											$('#salva').click();
										}
										break;
								}
								//if(ev.which==45){
								//	sottrai=true;
								//	$("#tot").css({'background-color':'red'});
								//}
								//if(ev.which==13){
								//	$('#salva').click();
								//}
								
	});*/
	//////////////////////////////////////// tolgo la parte di scontro con segno meno	leandro 16/08/2017
	
	/*$("#sco").on('keyup',function(ev){
			switch(ev.which) {
				case 13:
					$('#salva').click();
					break;
			}
	});*/
	/*$("#tot").on('keyup',function(ev){
		if(sconto==0){
			switch(ev.which) {
				case 13:
					$('#salva').click();
					break;
			}
		}
	});*/
	
	/*$("#tot").on('keydown',function(ev){
		if(ev.which === 110 || ev.which === 190){
			console.log($('#tot').val());
			ev.preventDefault();
			$('#tot').val($('#tot').val() + ',');
			
			
		}
		//ev.target.value=ev.target.value.replace('.',',');
		//console.log(ev.target.value);
	});	*/
			
	$('#stampa').on('click',function(){
			tasto_stampa();
  	});
  	
	/*
		//////////// passato in funzione
	if($('#qta_mob').css('display') == 'none'){
										$('#qta').focus();
									}else{
										$('#qta_mob').focus();
									}*/
	//posiziona_focus();
	$('#logout').on('click',function(){
			$( "#dialog_logout" ).dialog({
									autoOpen: false,
									modal: true,
									async: false,
									closeOnEscape: false,
									title:'AVVISO',
									buttons: {	Ok: function() {
														location.href='logout.php';
														$(this).dialog("close");
													},
									Annulla: function(){
												$(this).dialog("close");
											}
									}
			});
			$( "#dialog_logout" ).html("Confermare Uscita Dal Programma?");
			$('#dialog_logout').dialog("option", "minWidth", '50%');
			$('#dialog_logout').dialog("option", "maxWidth", '90%');
			$( "#dialog_logout" ).dialog( "open" );
  	});
  									
	/*$('#data-fattura').on('blur',function(){
						    	var datamod=$('#data-fattura').val();
								var datanow=$('#dataoggi').val();
								verifica_data('data-fattura',datamod,datanow);
    		});*/
    		
	if(window.location.href.indexOf("taxewin_index.php") > -1){
	   	numfattura();
		presuf();
	}
		
	$('#nav').addClass('hiding');
	
	$('#qta_mob').on('change',function(){
		$('#qta_hidden').val($('#qta_mob').val());
	});
	$('#qta').on('change',function(){
		$('#qta_hidden').val($('#qta').val());
	});
	$('#desc_mob').on('change',function(){
		$('#desc_hidden').val($('#desc_mob').val());
	});
	$('#desc').on('change',function(){
		$('#desc_hidden').val($('#desc').val());
	});
	
	//$('#desc').on('keyup',gestisci_tasti);	//////// INSERITO NEL BLOCCO .move_ins E LO RICHIAMO SOLO SE LA TENDINA è APERTA O SE NON HANNO PREMUTO INVIO
	if(window.location.pathname.match('taxewin_index.php')){
		window.onbeforeunload = function(event) {
    	event.returnValue = "Write something clever here..";
		};
	}
	

	$('.input_tur').on('keydown',function (e) {
        if (e.which === 13) {
            if($('#listanaz1').css('display') == 'none'){
	            var index = $('.input_tur').index(this) + 1;
	            if($('.input_tur').eq(index).length) {
	  				$('.input_tur').eq(index).focus();
				}else{
				 	$('.input_tur').eq(0).focus();
				}
			} 
        }
    });
    $('.move_ins').on('keydown',function (e) {		// ERA KEYUP e non ricordo per quale motivo. lo passo a keydown altrimenti ho problemi con chrome sulla select
    	//if ( e.which === 13 && ( document.activeElement.id != 'desc' || (document.activeElement.id == 'desc' && $('#lista_vie').css('display') == 'none' )  ) )  {
    	if ( e.which === 13 && $('#lista_vie').css('display') == 'none' && e.target.id != 'sco')  {
			e.preventDefault();
			var index = $('.move_ins').index(this);
			if($(this).attr('id') == 'qta' && ( $('#qta').val()=='' || $('#qta').val()== 0 )){
				$('#qta').focus();
				/*$("[class*='macro_blocchi3']").focus();
				$("[class*='evidenzia_blocchi3']").css( { "background-color" : "#00ff03" } );*/
			}else{
				index = index + 1;
				/*console.log($('.move_ins').eq(index)['0'].id);
				console.log($('.move_ins').eq(index));
				console.log($('#' + $('.move_ins').eq(index)['0'].id).css('visibility'));*/
				if( $('.move_ins').eq(index).length && $('#' + $('.move_ins').eq(index)['0'].id).css('visibility') == 'visible') {
					$('.move_ins').eq(index).focus();
				}else{
					$('#salva').click();
					$('.move_ins').eq(0).focus();
					$('#lista_vie').empty();
					$('#lista_vie').hide();
				}
			} 
		}else{
			switch(e.target.id){
				case 'tot':
					/*if(e.which != 188 && e.which != 190 && e.which != 110){
						calcola_impo();
					}*/
					if(sconto==0 && e.which == 13){
						$('#salva').click();
					}
					break;
					
				case 'sco':
					if(e.which == 13){
						$('#salva').click();
					}		
					break;
					
				case 'desc':
					gestisci_tasti(e);
					break;
			}
			/*if(e.target.id == 'desc'){
				gestisci_tasti(e);	
			}*/
		}
    });
    $('.input_cc').on('keydown',function (e) {
         if (e.which === 13) {
             var index = $('.input_cc').index(this) + 1;
             if($('.input_cc').eq(index).length) {
  				$('.input_cc').eq(index).focus();
			}else{
			 	$('.input_cc').eq(0).focus();
			 } 
         }
    });
    
	/*$('form').on('focus', 'input[type=number]', function (e) {
		$(this).on('mousewheel.disableScroll', function (e) {
			alert('ciao');
			e.preventDefault()
		})
	})
	$('form').on('blur', 'input[type=number]', function (e) {
		$(this).off('mousewheel.disableScroll')
	})*/
	$('form').on('focus', 'input[type=number]', function(e) {
        $(this).on('wheel', function(e) {
            e.preventDefault();
        });
    });
 
    // Restore scroll on number inputs.
    $('form').on('blur', 'input[type=number]', function(e) {
        $(this).off('wheel');
    });
 
    // Disable up and down keys.
    $('form').on('keydown', 'input[type=number]', function(e) {
        if ( e.which == 38 || e.which == 40 )
            e.preventDefault();
    });  
    
    if(! /Win/.test(navigator.platform) ){
		document.getElementById('tot').type='number';
	}
		
});



//$(document).keypress(function(evt) {
$(document).keydown(function(evt) {								   
 //console.log(evt);
	switch(evt.keyCode){
		case 27:
				$("#lista_vie").css({display:'none'});
				$('#listaAirports').css({display: 'none'});
		 	 	$('#listanaz1').css({display: 'none'});
		 	 	$('#menu').css({display: 'none'});
 	 		break;
 	 	
	}
	if(tastiera_conf){
		//alert((/input_tur/.test(evt.target.className)));
		if ( evt.ctrlKey  &&  evt.keyCode === 46 && (/input_tur/.test(evt.target.className)) ) {	// canc
			//evt.preventDefault();
			//alert('pippo');
			$( "#dialog_sbiancatur" ).dialog({
					autoOpen: false,
					modal: true,
					async: false,
					closeOnEscape: false,
					title:'AVVISO',
					buttons: {	Ok: function() {
												sbianca_turista();
												$(this).dialog("close");
												},
								Annulla: function(){
												$(this).dialog("close");
												}
								}
			});
			$( "#dialog_sbiancatur" ).html("Conferma Sbiancamento Form Turista?");
			$('#dialog_sbiancatur').dialog("option", "minWidth", '50%');
			$('#dialog_sbiancatur').dialog("option", "maxWidth", '90%');
			$( "#dialog_sbiancatur" ).dialog( "open" );	
		}
		if (evt.ctrlKey  &&  evt.keyCode === 39) {	// destra
	        switch('block'){
				case $('#box-ins').css('display'):
						if(typeof precedente_num_cl_destro !== 'undefined'){	}else{	precedente_num_cl_destro=0;}
		        		var aa= evt.target.className.split(' ');
						var k_arr_cl='';
						for(var k_cl in aa){
							if(/macro_blocchi/.test(aa[k_cl])){
								var num_cl=aa[k_cl].replace('macro_blocchi','');
								num_cl=parseInt(num_cl);
								if(!isNaN(num_cl)){	
									precedente_num_cl_destro=num_cl; 
								}else{	num_cl=precedente_num_cl_destro+1;	}
								//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "" } );
								/*if($("[class*='evidenzia_blocchi"+num_cl+"']").length){
									$("[class*='evidenzia_blocchi"+num_cl+"']").css( { "background-color" : "" } );
								}*/
								$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
								$("#box-articoli").css( { "background-color" : "#aaaaaa" } );
								num_cl+=1;
								if($("[class*='macro_blocchi"+num_cl+"']").length){
									$("[class*='macro_blocchi"+num_cl+"']").focus();
									//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "2px solid red" } );
									if($("[class*='evidenzia_blocchi"+num_cl+"']").length){
										$("[class*='evidenzia_blocchi"+num_cl+"']").css( { "background-color" : "#00ff03" } );
									}
								}else{
									if($("[class*='evidenzia_blocchi1']").css('display') == 'block'){
										$("[class*='macro_blocchi1']").focus();
											$("[class*='evidenzia_blocchi1']").css( { "background-color" : "#00ff03" } );
									}else{
										$("[class*='macro_blocchi2']").focus();
										if($("[class*='evidenzia_blocchi2']").length ){
											$("[class*='evidenzia_blocchi2']").css( { "background-color" : "#00ff03" } );
										}
									}
								}
								continue;
							}
						}
				break;
				case $('#box-archivio').css('display'):
						var aa= evt.target.className.split(' ');
						var k_arr_cl='';
						for(var k_cl in aa){
							if(/macro_blocchi_archivio/.test(aa[k_cl])){
								var num_cl=aa[k_cl].replace('macro_blocchi_archivio','');
								num_cl=parseInt(num_cl);
								//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "" } );
								/*if($("[class*='evidenzia_blocchi"+num_cl+"']").length){
									$("[class*='evidenzia_blocchi"+num_cl+"']").css( { "background-color" : "" } );
								}*/
								$("[class*='evidenzia_blocchi_archivio']").css( { "background-color" : "" } );
								num_cl+=1;
								if($("[class*='macro_blocchi_archivio"+num_cl+"']").length){
									$("[class*='macro_blocchi_archivio"+num_cl+"']").focus();
									//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "2px solid red" } );
									if($("[class*='evidenzia_blocchi_archivio"+num_cl+"']").length){
										$("[class*='evidenzia_blocchi_archivio"+num_cl+"']").css( { "background-color" : "#00ff03" } );
									}
								}else{
									if($("[class*='macro_blocchi_archivio1']").length){
										$("[class*='macro_blocchi_archivio1']").focus();
										if($("[class*='evidenzia_blocchi_archivio1']").length){
											$("[class*='evidenzia_macro_archivio1']").css( { "background-color" : "#00ff03" } );
										}
									}else{
										$("[class*='macro_blocchi_archivio2']").focus();
										if($("[class*='evidenzia_blocchi_archivio2']").length){
											$("[class*='evidenzia_blocchi_archivio2']").css( { "background-color" : "#00ff03" } );
										}
									}
								}
								continue;
							}
						}
				break;
			}
				
	    }
	    if (evt.ctrlKey  &&  evt.keyCode === 37) {	// sinistra
	    	switch('block'){
				case $('#box-ins').css('display'):
						if(typeof precedente_num_cl_sinistro !== 'undefined'){	}else{	precedente_num_cl_sinistro=8;	}
						var aa= evt.target.className.split(' ');
				        var k_arr_cl='';
				        for(var k_cl in aa){
						 	if(/macro_blocchi/.test(aa[k_cl])){
								var num_cl=aa[k_cl].replace('macro_blocchi','');
								num_cl=parseInt(num_cl);
								if(!isNaN(num_cl)){	
									precedente_num_cl_sinistro=num_cl; 
								}else{	num_cl=precedente_num_cl_sinistro-1;	}
								//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "" } );
								/*if($("[class*='evidenzia_blocchi"+num_cl+"']").length){
									$("[class*='evidenzia_blocchi"+num_cl+"']").css( { "background-color" : "" } );
								}*/
								$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
								num_cl-=1;
								if($("[class*='macro_blocchi"+num_cl+"']").length && num_cl!=1){
									$("[class*='macro_blocchi"+num_cl+"']").focus();
									//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "2px solid red" } );
									if($("[class*='evidenzia_blocchi"+num_cl+"']").length){
										$("[class*='evidenzia_blocchi"+num_cl+"']").css( { "background-color" : "#00ff03" } );
									}
								}else{
									if($("[class*='evidenzia_blocchi1']").css('display') == 'block' && num_cl!=0){
										evt.preventDefault();
										$("[class*='macro_blocchi1']").focus();
										$("[class*='evidenzia_blocchi1']").css( { "background-color" : "#00ff03" } );
									}else{
										$("[class*='macro_blocchi6']").focus();
											$("[class*='evidenzia_blocchi6']").css( { "background-color" : "#00ff03" } );
									}
									//$("[class*='macro_blocchi6']").focus();
								}
								continue;
							}
						}
				break;
				case $('#box-archivio').css('display'):
					var aa= evt.target.className.split(' ');
				        var k_arr_cl='';
				        for(var k_cl in aa){
						 	if(/macro_blocchi_archivio/.test(aa[k_cl])){
								var num_cl=aa[k_cl].replace('macro_blocchi_archivio','');
								num_cl=parseInt(num_cl);
								//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "" } );
								/*if($("[class*='evidenzia_blocchi"+num_cl+"']").length){
									$("[class*='evidenzia_blocchi"+num_cl+"']").css( { "background-color" : "" } );
								}*/
								$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
								num_cl-=1;
								if($("[class*='macro_blocchi_archivio"+num_cl+"']").length){
									$("[class*='macro_blocchi_archivio"+num_cl+"']").focus();
									//$("[class*='macro_blocchi"+num_cl+"']").parent().parent().css( { "border" : "2px solid red" } );
									if($("[class*='evidenzia_blocchi_archivio"+num_cl+"']").length){
										$("[class*='evidenzia_blocchi_archivio"+num_cl+"']").css( { "background-color" : "#00ff03" } );
									}
								}else{
									$("[class*='macro_blocchi_archivio5']").focus();
									if($("[class*='evidenzia_blocchi_archivio5']").length){
										$("[class*='evidenzia_blocchi_archivio5']").css( { "background-color" : "#00ff03" } );
									}
								}
								continue;
							}
						}
				break;
			}
	    }
	    if (evt.ctrlKey  &&  evt.keyCode === 38){	// su
	    	//alert(evt.target.id);
	    	if ($('#dialog_opzioni3').is(':empty')){
				switch('block'){
					case $('#box-ins').css('display'):
							$('#qta').focus();
				    		$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
				    		$("[class*='evidenzia_blocchi2']").css( { "background-color" : "#00ff03" } );
				    		$("#box-articoli").css( { "background-color" : "#aaaaaa" });
				    break;
				    case $('#box-archivio').css('display'):
							$('#data-da').focus();
				    		$("[class*='evidenzia_blocchi_archivio']").css( { "background-color" : "" } );
				    		$("[class*='evidenzia_blocchi_archivio2']").css( { "background-color" : "#00ff03" } );		
					break;
				}
			}else{
				if(evt.target.id=='chiudi_art'){
					evt.preventDefault();
					$('#opz_tab_articoli').focus();
	    			$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
	    			$("[class*='evidenzia_blocchi_articoli2']").css( { "background-color" : "#00ff03" } );
				}else{
					evt.preventDefault();
					$('#opz_descr_articolo').focus();
		    		$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
		    		$("[class*='evidenzia_blocchi_articoli1']").css( { "background-color" : "#00ff03" } );
				}
			}
		}
	    /*if (evt.ctrlKey  &&  evt.keyCode === 13){
	    	tasto_stampa();
	    	$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
		}*/
		if (evt.ctrlKey  &&  evt.keyCode === 40){	// giù
			//alert(evt.target.id);
			if ($('#dialog_opzioni3').is(':empty')){
				switch('block'){
					case $('#box-ins').css('display'):
					    	$('#stampa').focus();
					    	$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
					    	$("#box-articoli").css( { "background-color" : "#aaaaaa" });
					case $('#box-archivio').css('display'):
							evt.preventDefault();
							$('#lista').focus();
							$("[class*='evidenzia_blocchi_archivio']").css( { "background-color" : "" } );
				    		$("[class*='evidenzia_blocchi_archivio1']").css( { "background-color" : "#00ff03" } );		
					break;
				}
			}else{
				if(evt.target.id=='opz_tab_articoli'){
					evt.preventDefault();
					$('#chiudi_art').focus();
	    			$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
				}else{
					evt.preventDefault();
					$('#opz_tab_articoli').focus();
		    		$("[class*='evidenzia_blocchi_articoli']").css( { "background-color" : "" } );
		    		$("[class*='evidenzia_blocchi_articoli2']").css( { "background-color" : "#00ff03" } );	
				}
			}
		}
		if (evt.ctrlKey  &&  evt.keyCode === 16){    	
	    	if($('#menu').css('display') == 'none'){
				aprimenu();	
			}else{
				chiudimenu();	
			}
		}
		 
		if (evt.ctrlKey  && evt.altKey &&  evt.keyCode === 77){
			///evt.preventDefault();
			document.getElementById('box-articoli').focus();
			$("[class*='evidenzia_blocchi']").css( { "background-color" : "" } );
			$("#box-articoli").css( { "background-color" : "#00ff03" } );
			//window.location.hash = '#box-articoli';
			//console.log(evt.target);
			//alert(evt.target.id);
		}  
	    if (evt.keyCode == 39 && /ui-button/.test($(evt.target).attr('class')) ) {	
	    	$(".ui-button:focus").next().focus();	}
	    if (evt.keyCode == 37 && /ui-button/.test($(evt.target).attr('class')) ) {	
	    	$(".ui-button:focus").prev().focus();	}
	    
	    
	    /*if (evt.keyCode == 39 && /move_duty/.test($(evt.target).attr('class')) ) {	
	    	$(".move_duty:focus").next().focus();	}
	    if (evt.keyCode == 37 && /move_duty/.test($(evt.target).attr('class')) ) {	
	    	$(".move_duty:focus").prev().focus();	}*/
	    
	    if (evt.keyCode == 40 ) {	//giù
	    	var class_frecce=$(evt.target).attr('class');
	    	switch (true){
				case /move_menu/.test(class_frecce):
					if($(".move_menu:focus").next().focus().length=== 0){
						$("#logout").focus();
					}	
				break;
				case /move_opzioni/.test(class_frecce):
					//alert($(".move_opzioni:focus").parent().next().children().attr('class'));
					if($(".move_opzioni:focus").parent().next().children().focus().length=== 0){
						$("#ok_opzioni").focus();
					}	
				break;
				case /move_password/.test(class_frecce):
					//alert($(".move_password:focus").parent().next().attr('class'));
					//console.log($(".move_password:focus").parent().next().next().children());
					if($(".move_password:focus").parent().next().next().children().focus().length=== 0){
						$("#ok_password").focus();
					}	
				break;
			}	    	
	    }
	    if (evt.keyCode == 38 ) {	//su	
	    	var class_frecce=$(evt.target).attr('class');
	    	switch (true){
				case /move_menu/.test(class_frecce):
					if($(".move_menu:focus").prev().focus().length=== 0){
			    		$("#box_tasti_sopra input.move_menu:last").focus();	
			    	}	
				break;
				case /move_opzioni/.test(class_frecce):
					if($(".move_opzioni:focus").parent().prev().children().focus().length=== 0){
						$(".move_opzioni:focus input.move_opzioni:last").focus();	
					}
				break;
				case /move_password/.test(class_frecce):
					if($(".move_password:focus").parent().prev().prev().children().focus().length=== 0){
						$(".move_password:focus input.move_password:last").focus();	
					}
				break;
				case /ok_opzioni/.test(class_frecce):
					if($(".move_opzioni:focus").parent().prev().children().focus().length=== 0){
						//alert($(".move_opzioni:focus").parent().next().children().attr('class'));
						$("#box-opzioni input.move_opzioni:last").focus();	
					}
				break;
				case /ok_password/.test(class_frecce):
					//console.log($(".move_password:focus").parent().prev().prev());
					if($(".move_password:focus").parent().prev().prev().children().focus().length=== 0){
						//alert($(".move_opzioni:focus").parent().next().children().attr('class'));
						$("#opz_cambiopsw input.move_password:last").focus();	
					}
				break;
			}
		}
	}
});
$(document).mouseup(function(evt) {
var container = $('#menu');
	if(container.css('display') == 'block'){
		if (!container.is(evt.target) && container.has(evt.target).length === 0) {
        	chiudimenu();
        }	
	}
	
});