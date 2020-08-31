// questo e' il path della X per chiudere il popup.
var pathimgclose="immagini/divclose.png";
var my_zindex = 210;
/* DEFINIZIONE E MESSAGGI */
// questo e' l'id DI un DIV grosso come lo schermo che contiene il velo nero e il messaggio loading per le richieste sincrone.
var ID_OSCURA="oscura";
// questo e' l' ID mi sembra di ricordare, del popup che raccoglie l'errore nel caso non ci sia una risposta corretta dell ajax o qualcosa andasse storto
// per i casi che sono riuscito a intercettare e cattuarare
var ID_ERR="err_id";
// nomebase delle classi CSS che descrivono il popup popup_cont, popup, popup_title, popup_int
// il file drag drop JS muove i popup il cuititolo ha classe ="popup_title" , il comportamento e' variabile nel file, si puo' cambiare nome ovviamente.
var ID_POPUP="popup";
// id dell elemento dove si va a posizionare il loading message " sto caricando" per le richieste sincrone
var ID_LOADING_MESSAGE="loading_message";

// errori gesitit:
var FILE_NOT_FOUND = "Il file php richiesto non si trova";
var FILE_ERROR = "Il file php richiesto ha un errore";
var FORM_NOT_FOUND = "La form per l'invio dati non si trova";
var ID_NOT_FOUND = "L'oggetto con id non &egrave; stato trovato";
var NAME_NOT_FOUND = "Il campo della form non &egrave; stato trovato";
var QUALE_NOT_FOUND = "La form non &grave; stata trovata";
var ELEM_NOT_FOUND = "Il campo della form non &egrave; stato trovato";
var TITLE_XCLOSE= "Chiudimi";
var ERROR_MESSAGE_CODE=Array();
ERROR_MESSAGE_CODE[404]=FILE_NOT_FOUND;
ERROR_MESSAGE_CODE[500]=FILE_ERROR;

function makeid(quanto) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for( var i=0; i < quanto; i++ ){
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
	return text;
}

function bringToTop(){
	this.parentElement.parentElement.style.zIndex=my_zindex++;
}
function bringToTopE(){
	this.parentElement.parentElement.style.zIndex=parent.my_zindex++;
}
function creapopupe(id_div,title,content){
//	alert(id_div);
    var doc=parent.document;
	var nuovodiv=doc.createElement("DIV");
	nuovodiv.setAttribute("id",id_div+"_cont");
	nuovodiv.className="popup_box";
		//quello scuro
		var nuovodiv2=doc.createElement("DIV");
		nuovodiv2.className="popup_cont";
		nuovodiv2.innerHtml="";
		nuovodiv.appendChild(nuovodiv2);
		//ora alert
		var nuovodiv2=doc.createElement("DIV");
		nuovodiv2.className="popup";
		nuovodiv2.setAttribute("id",id_div);
		nuovodiv2.style.left='0px';
		nuovodiv2.style.top='0px';
		// ora devo creare dentro nuovodiv2 gli altri div e poi appendere tutto.
			//xclose, la x per chiudere.
			var nuovodiv3=doc.createElement("DIV");
			nuovodiv3.className="xclose";
			nuovodiv3.innerHTML="<img id=\"closemee\" src=\""+pathimgclose+"\" onclick=\"closedive('" + id_div + "_cont');\" title=\""+ TITLE_XCLOSE +"\" />";
			nuovodiv2.appendChild(nuovodiv3);
			var nuovodiv3=doc.createElement("DIV");
			nuovodiv3.className="popup_title";
			nuovodiv3.setAttribute("id",id_div + "_title");
			if(typeof(title)!='undefined'){
				nuovodiv3.innerHTML=title;	
			}
			nuovodiv2.appendChild(nuovodiv3);
			var nuovodiv3=doc.createElement("DIV");
			nuovodiv3.className="popup_int";
			nuovodiv3.setAttribute("id",id_div + "_int");
			if(typeof(content)!='undefined'){
				nuovodiv3.innerHTML=content;
			}
			nuovodiv2.appendChild(nuovodiv3);
	nuovodiv.appendChild(nuovodiv2);
	doc.body.appendChild(nuovodiv);
	nuovodiv.style.zIndex=parent.my_zindex++;
	doc.getElementById(id_div+'_title').addEventListener('click',bringToTopE,false);
}
function creapopup(id_div,title,content){
//	alert(id_div);
	var nuovodiv=document.createElement("DIV");
	nuovodiv.setAttribute("id",id_div+"_cont");
	nuovodiv.className="popup_box";
		//quello scuro
		var nuovodiv2=document.createElement("DIV");
		nuovodiv2.className="popup_cont";
		nuovodiv2.innerHtml="";
		nuovodiv.appendChild(nuovodiv2);
		//ora alert
		var nuovodiv2=document.createElement("DIV");
		nuovodiv2.className="popup";
		nuovodiv2.setAttribute("id",id_div);
		nuovodiv2.style.left='0px';
		nuovodiv2.style.top='0px';
		// ora devo creare dentro nuovodiv2 gli altri div e poi appendere tutto.
			//xclose, la x per chiudere.
			var nuovodiv3=document.createElement("DIV");
			nuovodiv3.className="xclose";
			nuovodiv3.innerHTML="<img id=\"closeme\" src=\""+pathimgclose+"\" onclick=\"closediv('" + id_div + "_cont');\" title=\""+ TITLE_XCLOSE +"\" />";
			nuovodiv2.appendChild(nuovodiv3);
			var nuovodiv3=document.createElement("DIV");
			nuovodiv3.className="popup_title";
			nuovodiv3.setAttribute("id",id_div + "_title");
			if(typeof(title)!='undefined'){
				nuovodiv3.innerHTML=title;	
			}
			nuovodiv2.appendChild(nuovodiv3);
			var nuovodiv3=document.createElement("DIV");
			nuovodiv3.className="popup_int";
			nuovodiv3.setAttribute("id",id_div + "_int");
			if(typeof(content)!='undefined'){
				nuovodiv3.innerHTML=content;
			}
			nuovodiv2.appendChild(nuovodiv3);
	nuovodiv.appendChild(nuovodiv2);
	nuovodiv.style.zIndex=my_zindex++;
	document.body.appendChild(nuovodiv);
	document.getElementById(id_div+'_title').addEventListener('click',bringToTop,false);
}

function base64Encode(str) {
    var CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var out = "", i = 0, len = str.length, c1, c2, c3;
    while (i < len) {
        c1 = str.charCodeAt(i++) & 0xff;
        if (i == len) {
            out += CHARS.charAt(c1 >> 2);
            out += CHARS.charAt((c1 & 0x3) << 4);
            out += "==";
            break;
        }
        c2 = str.charCodeAt(i++);
        if (i == len) {
            out += CHARS.charAt(c1 >> 2);
            out += CHARS.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
            out += CHARS.charAt((c2 & 0xF) << 2);
            out += "=";
            break;
        }
        c3 = str.charCodeAt(i++);
        out += CHARS.charAt(c1 >> 2);
        out += CHARS.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
        out += CHARS.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
        out += CHARS.charAt(c3 & 0x3F);
    }
    return out;
}

function getNewHttpObject2() {
	var objType = false;
    try { 
		objType = new ActiveXObject('Msxml2.XMLHTTP');			
	} catch(err) { 
		try {
			objType = new ActiveXObject('Microsoft.XMLHTTP'); 
		} catch(err) { 
			try {
				objType = new XMLHttpRequest();
			} catch (err) {
				alert('XML non supportato');
			}
		}	
	}
	return objType;
}

function downloadBlob(tipo,dati){
	//presuppone i dati base64 encodati
	window.open("data:" + tipo + ";base64," + dati, '_blank', '');
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function svuota(elem){
	while (elem.firstChild) 
		 elem.removeChild(elem.firstChild);
}

function elaboraXml(xmlDocument,errormessage) {
	
	var MyForm;
	var MyElement;
	var nome , nomeProp , nomeForm;
	var NomeElemt;
	var NodeElement;
	var valore;
	var ritorna;
	var mkey;
	var MimeType,Content;
	var k = 0;
	var i = 0;
	var j = 0;
	var h = 0;
	var m = 0;
	var n = 0; // questo cicla tra i , v , td, va etc etc
	var x = 0; // altro indice inserito per scartare i 4k di limite
	var a;
	var fragment=document.createDocumentFragment();
	k =	xmlDocument.documentElement.childNodes.length;
	for (i=0;i<k;i++) {
		nome=xmlDocument.documentElement.childNodes[i].tagName;
		switch(nome){
		case 'file':
		case 'FILE':
		case 'File':
			try { nomeForm=xmlDocument.documentElement.childNodes[i].attributes["nome"].nodeValue; } catch(err) {  nomeForm=xmlDocument.documentElement.childNodes[i].attributes[0].nodeValue; }
			j = xmlDocument.documentElement.childNodes[i].childNodes.length;
			for (h=0;h<j;h++) {
				NodeElement = xmlDocument.documentElement.childNodes[i].childNodes[h];
				NomeElement = NodeElement.tagName;
				valore=NodeElement.firstChild.data;
				if (NomeElement=="Content") {
					Content=valore;
				}
				if (NomeElement=="MimeType") {
					MimeType=valore;
				}
			}
			downloadBlob(MimeType,Content);	
		break;
		case 'myform':
		case 'MyForm':
			try { nomeForm=xmlDocument.documentElement.childNodes[i].attributes["quale"].nodeValue; } catch(err) {  nomeForm=xmlDocument.documentElement.childNodes[i].attributes[0].nodeValue; }
			MyForm=document.forms[nomeForm];
			j=MyForm.length;
			j = xmlDocument.documentElement.childNodes[i].childNodes.length;
lbl_form2:	
			for (h=0;h<j;h++) {
				NodeElement = xmlDocument.documentElement.childNodes[i].childNodes[h];
				NomeElement = NodeElement.tagName;
				switch(NomeElement){
					case "DoReset":
					case "doreset":
						MyForm.reset();
					break;
					case "Submit":
					case "submit":
						MyForm.submit();
					break;
					default:
						mkey="";
						try { mkey=NodeElement.attributes["index"].nodeValue; } catch(err){	}
						if(mkey!=""){
							NomeElement=NomeElement+'['+mkey+']';
						}
						m = NodeElement.childNodes.length;
						for (n=0;n<m;n++) {
							if(!MyForm.elements[NomeElement]){
								errormessage+=ELEM_NOT_FOUND+" (" + NomeElement + " in "+ nomeForm +")" + "\n<br />"; break lbl_form2;
							}
							nomeProp=NodeElement.childNodes[n].tagName;
							try { valore=NodeElement.childNodes[n].firstChild.data; } catch(err) { valore="";  }

							switch(nomeProp) {
								case 'css':
									MyForm.elements[NomeElement].setAttribute("style",valore);
								break;
								case 'class':
									MyForm.elements[NomeElement].className=MyForm.elements[NomeElement].className+' '+valore;
								break;
								case 'v':
									MyForm.elements[NomeElement].style.visibility=valore;
								break;
								case 's':
									MyForm.elements[NomeElement].selectedIndex=valore;
								break;
								case 'c':
									MyForm.elements[NomeElement].style.backgroundColor=valore;
								break;
								case 'va':
									MyForm.elements[NomeElement].value=valore;
								break;
								case 'tt':
									MyForm.elements[NomeElement].title=valore;
								break;
								case 'i':
									MyForm.elements[NomeElement].innerHTML=valore;
								break;
								case 'f':
									MyForm.elements[NomeElement].focus();
								break;
								case 'ck':
									if (valore=="S" || valore=="1" || valore=="checked" || valore=="true" || valore=="ON" ) {
										MyForm.elements[NomeElement].checked="checked";
									} else {
										MyForm.elements[NomeElement].checked=false;
									}
								break;
								case 'di':
									if (valore=="S" || valore=="1"  || valore=="true") {
										MyForm.elements[NomeElement].disabled=true;
									} else {
										MyForm.elements[NomeElement].disabled=false;
									}
								break;
							}
						}
				}
			}
		break;
		
		case 'MyItems':
			j = xmlDocument.documentElement.childNodes[i].childNodes.length;
			for (h=0;h<j;h++) {
				NodeElement = xmlDocument.documentElement.childNodes[i].childNodes[h];
				NomeElement = NodeElement.tagName;
				m = NodeElement.childNodes.length;
lbl_items:
				for (n=0;n<m;n++) {
					MyElement=document.getElementById(NomeElement);
					if(!MyElement){
						errormessage+=ID_NOT_FOUND+" (" + NomeElement + ")" + "\n<br />"; break lbl_items;
					}
					nomeProp=NodeElement.childNodes[n].tagName;
					try { valore=NodeElement.childNodes[n].firstChild.data; } catch(err) { valore=""; }
					switch(nomeProp) {
						case 'css':
							MyElement.setAttribute("style",valore);
						break;
						case 'class':
							MyElement.className=MyElement.className+' '+valore;
						break;
						case 'v':
							if (valore=='switchV') {
								a=MyElement.style.visibility;
								if (a=='hidden') {
									MyElement.style.visibility='visible';
								} else if (a=='visible') {
									MyElement.style.visibility='hidden';
								}
							} else {
								MyElement.style.visibility=valore;	
							}
						break;
						case 'i':
							MyElement.innerHTML=valore;
						break;
						case 's':
							MyElement.selected=true;
						break;
						case 'c':
							MyElement.style.backgroundColor=valore;
						break;
						case 'ck':
							if (valore=="S" || valore=="1" || valore=="true" || valore=="checked" || valore=="SI") {
								MyElement.checked="checked";
							} else {
								MyElement.checked=false;
							}
						break;	
						case 'va':
							MyElement.value=valore;
						break;
						// c'e da fare "style"
						case 'd':
							MyElement.style.display=valore;
						break;
						case 'md':
							setTimeout(muovidestra,30,MyElement,valore);
						break;
						case 'ms':
							setTimeout(muovisotto,30,MyElement,valore);
						break;
						case 'mc':
							muovicentro(MyElement);
							//setTimeout(muovicentro,30,MyElement);
						break;
						case 'td':
							MyElement.style.textDecoration=valore;
						break;
						case 'top':
							MyElement.style.zIndex=my_zindex++;
						break;
					}
				}
			}
		break;
		case 'popup':
			var id_div="";
			try { id_div=xmlDocument.documentElement.childNodes[i].attributes.getNamedItem("id").value; } 
			catch(err) {  
				// non c'era allora ne creo l'id.
				id_div=makeid(5);
			}
			MyElement=document.getElementById(id_div + "_cont");
			if(MyElement==null) { 
				creapopup(id_div);
				//alert("crea zindex=" + my_zindex);
			    }
			j = xmlDocument.documentElement.childNodes[i].childNodes.length;
			for (h=0;h<j;h++) {
				NodeElement = xmlDocument.documentElement.childNodes[i].childNodes[h];
				NomeElement = NodeElement.tagName;
				try { valore=NodeElement.firstChild.data; } catch(err) { valore=""; }
				switch(NomeElement) {
					case 'title':
						try {MyElement=document.getElementById(id_div + '_title'); MyElement.innerHTML=valore; } catch(err) { }
					break;
					case 'content':
						try {MyElement=document.getElementById(id_div + '_int'); MyElement.innerHTML=valore; } catch(err) { }
					break;
					case 'position':
						var tipo;
						try { tipo=NodeElement.attributes["dove"].nodeValue; } 
						catch(err) {  
							// non c'era allora ne creo l'id.
							tipo="under";
						}
						switch(tipo){
							case 'center':
								try {MyElement=document.getElementById(id_div); setTimeout(muovicentro,30,MyElement); } catch(err) { }
							break;
							case 'right':
								try {MyElement=document.getElementById(id_div); setTimeout(muovidestra,30,MyElement,valore); } catch(err) { }
							break;
							case 'under':
								try { 
								var riga=document.getElementById("riga");
								MyElement=document.getElementById(id_div); setTimeout(muovisotto,30,MyElement,riga); 
								} 
								catch(err) { }
							break;
							case 'hide':
								try {MyElement=document.getElementById(id_div + '_cont'); MyElement.style.display='none';  } catch(err) { }
							break;
							case 'none':
								try {MyElement=document.getElementById(id_div + '_cont'); MyElement.style.zIndex=my_zindex++; MyElement.style.display='block';} catch(err) { }
							break;
							default:
							    var xy=tipo.split(";");
							    var x=xy[0];
							    var y=xy[1];
							    var X=x + "px";
							    var Y=y + "px";
								try {MyElement=document.getElementById(id_div + '_cont'); MyElement.style.left=X; MyElement.style.top=Y; MyElement.style.zIndex=my_zindex++; } catch(err) { }
						}
					break;
					case 'type':
						MyElement=document.getElementById(id_div + '_cont');
						switch(valore){
							case 'modal':
								MyElement.firstChild.style.display='block';
							break;
							case 'free':
								MyElement.firstChild.style.display='none';
							break;
						}
						MyElement.style.zIndex=my_zindex++;
						MyElement.style.display='block';
					break;
				}
			}
		break;

		case 'popupe':
			var id_div="";
			try { id_div=xmlDocument.documentElement.childNodes[i].attributes["id"].nodeValue; } 
			catch(err) {  
				// non c'era allora ne creo l'id.
				id_div=makeid(5);
			}

			MyElement=parent.document.getElementById(id_div + "_cont");
			if(MyElement==null) { 
				creapopupe(id_div);
				//alert("crea zindex=" + parent.my_zindex);
			    }
			j = xmlDocument.documentElement.childNodes[i].childNodes.length;
			for (h=0;h<j;h++) {
				NodeElement = xmlDocument.documentElement.childNodes[i].childNodes[h];
				NomeElement = NodeElement.tagName;
				try { valore=NodeElement.firstChild.data; } catch(err) { valore=""; }
				switch(NomeElement) {
					case 'title':
						try {MyElement=parent.document.getElementById(id_div + '_title'); MyElement.innerHTML=valore; } catch(err) { }
					break;
					case 'content':
						try {MyElement=parent.document.getElementById(id_div + '_int'); MyElement.innerHTML=valore; } catch(err) { }
					break;
					case 'position':
						var tipo
						try { tipo=NodeElement.attributes["dove"].nodeValue; } 
						catch(err) {  
							// non c'era allora ne creo l'id.
							tipo="";
						}
						switch(tipo){
							case 'center':
								try {MyElement=parent.document.getElementById(id_div); setTimeout(muovicentro,30,MyElement); } catch(err) { }
							break;
							case 'right':
								try {MyElement=parent.document.getElementById(id_div); setTimeout(muovidestra,30,MyElement,valore); } catch(err) { }
							break;
							case 'under':
								try {MyElement=parent.document.getElementById(id_div); setTimeout(muovisotto,30,MyElement,valore); } catch(err) { }
							break;
							case 'hide':
								try {MyElement=parent.document.getElementById(id_div + '_cont'); MyElement.style.display='none';  } catch(err) { }
							break;
							case 'none':
								try {MyElement=parent.document.getElementById(id_div + '_cont'); MyElement.style.zIndex=my_zindex++; MyElement.style.display='block';} catch(err) { }
							break;
							default:
							    var xy=tipo.split(";");
							    var x=xy[0];
							    var y=xy[1];
								try {MyElement=parent.document.getElementById(id_div + '_cont'); MyElement.style.left=X; MyElement.style.top=Y; MyElement.style.zIndex=parent.my_zindex++; } catch(err) { }
						}
					break;
					case 'type':
						MyElement=parent.document.getElementById(id_div + '_cont');
						switch(valore){
							case 'modal':
								MyElement.firstChild.style.display='block';
							break;
							case 'free':
								MyElement.firstChild.style.display='none';
							break;
						}
						MyElement.style.zIndex=parent.my_zindex++;
						MyElement.style.display='block';
					break;
				}
			}
		break;

		case 'returnsmt':
			valore = xmlDocument.documentElement.childNodes[i].firstChild.data;
			switch (valore) {
				case "false":
					ritorna=false;
				break;
				case "true":
					ritorna=true;
				break;
				default:
					ritorna=valore;
				break;
			}
		break;
		case 'ajaxtime':
			valore = xmlDocument.documentElement.childNodes[i].firstChild.data;
			if(valore < window.ajaxtime) {
				return;
			} else {
				window.ajaxtime=valore;
			}
		break;
		case 'document':
			j = xmlDocument.documentElement.childNodes[i].childNodes.length;
			for (h=0;h<j;h++) {
				NodeElement = xmlDocument.documentElement.childNodes[i].childNodes[h];
				NomeElement = NodeElement.tagName;
				try { valore=NodeElement.firstChild.data; } catch(err) { valore=""; }
				switch(NomeElement) {
					case 'title':
						document.title=valore;
					break;
				}
			}
		break;
		case 'run':
			valore = xmlDocument.documentElement.childNodes[i].firstChild.data;
			//var uploader = eval("(" + valore + ")");
			eval(valore);
		break;
		case 'json':
		case 'JSON':
			valore = xmlDocument.documentElement.childNodes[i].firstChild.data;
			ritorna = JSON.parse(valore);
		break;
		}
	}
	var result = [];
    result['ritorna']=ritorna;
	result['errormessage']=errormessage;
	return result;
}

function _ajax(myurl,user_options){
	var options = {
		target: 0,
		method: 'POST',
		sync: true,
		formstart: 'none',
		param:''
	}
	for (var attrname in user_options) { options[attrname] = user_options[attrname]; }
	ajax(options.formstart,myurl,options.param,options.sync,options.method,options);
}

function ajax(formstart,myurl,parameters,sync,metodo,opzionivarie){
	var errormessage="";
	function process_risposta(){
		var ritorna;
		if (theHttpRequest.readyState == 1) {
			// STO CONTATTANDO
			document.getElementById(ID_LOADING_MESSAGE).innerHTML="(1) Sto contattando il server";
		}
		if (theHttpRequest.readyState == 2) {
			// ho gli header ci faro' qualcosa un giorno
			//var tipoRes= theHttpRequest.getAllResponseHeaders();
			var tipoRes= theHttpRequest.getResponseHeader('Content-Type');
			var Lunghezza= theHttpRequest.getResponseHeader('Content-Length');
			document.getElementById(ID_LOADING_MESSAGE).innerHTML="(2) Ho ricevuto gli header";
		}
		if (theHttpRequest.readyState == 3) {
			document.getElementById(ID_LOADING_MESSAGE).innerHTML="(3) Sto scaricando la risposta";
		}
		if (theHttpRequest.readyState == 4) {
			document.getElementById(ID_LOADING_MESSAGE).innerHTML="(4) Download completato";
			switch(theHttpRequest.status){
				case 200:
					var tipoRes= theHttpRequest.getResponseHeader('Content-Type');
					var Lunghezza= theHttpRequest.getResponseHeader('Content-Length');
					switch(tipoRes){
						case "application/json":
							ritorna = JSON.parse(theHttpRequest.responseText);
							break;
						case "text/html":
							var Testo = theHttpRequest.responseText;
							break;
						case "text/xml":
							var ritorna_arr = elaboraXml(theHttpRequest.responseXML,errormessage);
							ritorna=ritorna_arr['ritorna'];
							errormessage+=ritorna_arr['errormessage'];
							break;
						default:
							var ritorna_arr = elaboraXml(theHttpRequest.responseXML,errormessage);
							ritorna=ritorna_arr['ritorna'];
							errormessage+=ritorna_arr['errormessage'];
							break;						
							//ritorna=downloadBlob(tipoRes,base64Encode(theHttpRequest.responseText));
							//break;
					}
					break;
				default:
					errormessage+=ERROR_MESSAGE_CODE[theHttpRequest.status]+" ("+myurl+")\n<br />";
					break;
			}
			document.body.style.cursor = 'default';
		}
		if(errormessage!=""){
			if(document.getElementById(ID_ERR + "_cont")==null) { 
				creapopup(ID_ERR);
			}
			document.getElementById(ID_ERR + "_cont").style.display="block";
			document.getElementById(ID_ERR + "_cont").style.zIndex=my_zindex++;
			document.getElementById(ID_ERR + "_title").innerHTML="ERRORE AJAX JAVASCRIPT";
			document.getElementById(ID_ERR + "_int").innerHTML="<p>" + errormessage + "</p><br /> Risposta :\n<br /><pre>"+htmlEntities(theHttpRequest.responseText)+"</pre>";
			setTimeout(muovicentro,30,ID_ERR);
		}
		return ritorna;
	}
	
	errormessage="";
	if (typeof window.ajaxtime == "undefined") { window.ajaxtime=0;	}
  	if (typeof parameters == "undefined") { parameters = ""; }
	if (typeof sync == "boolean" ) { sync = sync; }
	if (typeof sync == "undefined") { sync = true; }
	if (typeof sync == "string" && sync=="true") { sync = true; }
	if (typeof sync == "string" && sync=="false") { sync = false; }
	if (typeof metodo == "undefined") { metodo = "POST"; }
	var theHttpRequest = getNewHttpObject2();
	var MyString = '';
	var url = ''
	var i= 0;
	var currentTime=new Date();
	var millis=currentTime.getTime();
	if (!sync) {
		theHttpRequest.onreadystatechange = function() { process_risposta(); }
	}
lbl_readform:
	if (formstart!='none') {
		if(!document.forms[formstart]){
			errormessage+=FORM_NOT_FOUND+" (" + formstart + ")" + "\n<br />";
			break lbl_readform;
		}
		var j= document.forms[formstart].length;
		// costruisco MyString
		for (i=0;i<j;i++) {
			switch(document.forms[formstart].elements[i].type) {
				case 'text':
				case 'hidden':
				case 'textarea':
				case 'password':
				case 'date':
					MyString = MyString + document.forms[formstart].elements[i].name + '=' + escape(document.forms[formstart].elements[i].value);
					break;
				case 'radio':
					if (document.forms[formstart].elements[i].checked) {
						MyString = MyString + document.forms[formstart].elements[i].name + '=' + escape(document.forms[formstart].elements[i].value);
					}
					break;
	
				case 'select-one':
					Item = document.forms[formstart].elements[i].selectedIndex;
					if(Item >= 0) {
						MyString = MyString + document.forms[formstart].elements[i].name + '=' + escape(document.forms[formstart].elements[i].options[Item].value);	
					}
					break;
				
				case 'checkbox':
					if (document.forms[formstart].elements[i].checked) {
						MyString = MyString + document.forms[formstart].elements[i].name + '=ON';	
					} else {
						MyString = MyString + document.forms[formstart].elements[i].name + '=OFF';						
					}
					break;
			}
			if (i<j-1 || parameters!="") {MyString+='&'}
		}
	}
	parameters=MyString + parameters + '&ajax=si&ajaxtime='+millis;
	
	if (sync) {
		oscura('block');
		//document.onkeypress = stoptasti; 
	}
	
	if (metodo=="POST") {
		url=myurl;
	} else {
		if(myurl.indexOf('?')==-1) {
			url = myurl + '?' +parameters;
		} else {
			url = myurl + '&' +parameters;
		}
	}

	theHttpRequest.open(metodo, url,!sync);
	if (metodo=="POST") {
		theHttpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		//theHttpRequest.setRequestHeader("Content-length", parameters.length);
		//theHttpRequest.setRequestHeader("Connection", "close");
	}
	// mah questa richiesta booooo
	//theHttpRequest.overrideMimeType("text/xml; charset=x-user-defined");
	theHttpRequest.send(parameters);	
	if (sync) {
		var daritornare;
		daritornare=process_risposta();
		oscura('none');
		document.onkeypress = null;
		return daritornare;
	}	
}

function getoffsetLeft(element){
	//trova left ricorsivamente
	if(!element) return 0;
	return element.offsetLeft + getoffsetLeft(element.offsetParent);
}

function getLargh(element){
	//trova left ricorsivamente
	var e;
	var f;
	var largh;
	if(!element) return 0;
	largh=parseInt(element.style.width);
	f = element.childNodes.length;
	for (e=0;e<f;e++) {
		//alert(element.childNodes[e].nodeName);
		if (element.childNodes[e].nodeName=="TBODY" || element.childNodes[e].nodeName=="DIV" || element.childNodes[e].nodeName=="TABLE" || element.childNodes[e].nodeName=="TD" || element.childNodes[e].nodeName=="TR") {
			largh2=getLargh(element.childNodes[e]);	
			if (largh2>largh) {
				largh=largh2;
			}
		}
	}
	return largh;
}

function getoffsetTop(element){
	//trova left ricorsivamente
	if(!element) return 0;
	return element.offsetTop + getoffsetTop(element.offsetParent);
}

function muovidestra(mydiv,target) {
	//alert("mydiv=" + mydiv + " target=" + target);
	//identify the element based on browser type
	var a;
	var b;
	var c;
	if (typeof(mydiv)=="string") {
		mydiv=document.getElementById(mydiv);
	}
	if (typeof(target)=="string") {
		target=document.getElementById(target);
	}
	a=parseInt(getoffsetTop(target))
	b=parseInt(getoffsetLeft(target))
	c=parseInt(target.offsetWidth) + 5 + b;
	if (window.innerWidth ) {
		a=a+"px";
		c=c+"px";
	} 
	mydiv.style.left = c;
	mydiv.style.top= a; 
}

function muovisotto(mydiv,target) {
	//identify the element based on browser type
	var a;
	var b;
	var c;
	var w;
	var h;
	var hp;
	var hp7;
	if (typeof(mydiv)=="string") {
		mydiv=document.getElementById(mydiv);
	}
	if (typeof(target)=="string") {
		target=document.getElementById(target);
	}
	a=getoffsetTop(target)
	d=parseInt(target.offsetHeight);
	w=parseInt(target.offsetWidth)-8;
	b=getoffsetLeft(target);
	c=a+d+7;
    h=window.innerHeight;
    h=h-c-20;
    hp=h;
    hp7=h-70;
	if (window.innerWidth) {
		b=b+"px";
		c=c+"px";
		w=w+"px";
		hp=h+"px";
	    hp7=h-70 + "px";
	} 
	mydiv.style.left = b;
	mydiv.style.top= c;
	mydiv.style.width = w;
	mydiv.style.height = hp;
	var frame="if_" + mydiv.id;
	document.getElementById(frame).style.height=hp7;
}

function muovicentro(mydiv) {
	//identify the element based on browser type
	var a;
	var b;
	var c;
	var d;
	var e;
	var largh;
	if (typeof(mydiv)=="string") {
		mydiv=document.getElementById(mydiv);
	}
	b=parseInt(mydiv.offsetWidth);
	if (window.innerWidth ) {
		a=window.innerWidth;
		c=(a - b)/2;
		c=( c > 0 ? c : 0 );
		c+="px";
		d=(220 + window.pageYOffset)+ "px";
	} else {
		a=document.body.offsetWidth;
		c=(a - b)/2;
		c=( c > 0 ? c : 0 );
		d=220 + document.body.scrollTop;
	}
	mydiv.style.left = c;
	mydiv.style.top= d; 
}

function closediv(quale) {
if (typeof window.frames[0].window.salva_form !== 'undefined') {	
	var a=window.frames[0].window.salvaform1();
	var salva_form=window.frames[0].window.salva_form;
	if(salva_form!=a)
       {
       if(!confirm("DATI CAMBIATI: USCIRE ?"))
          return false;	   	
	   }
	}
		document.getElementById(quale).style.display='none';
		var el=document.getElementById(quale);
        el.parentNode.removeChild(el);
}
function closedive(quale) {
if (typeof parent.window.frames[1].window.salva_form !== 'undefined') {	
	var a=parent.window.frames[1].window.salvaform1();
	var salva_form=parent.window.frames[1].window.salva_form;
	if(salva_form!=a)
       {
       if(!confirm("DATI CAMBIATI: USCIRE ?"))
          return false;	   	
	   }
	}
		parent.document.getElementById(quale).style.display='none';
		var el=parent.document.getElementById(quale);
        el.parentNode.removeChild(el);
}
// si usa con arguments[0] come primo parametro
function stopclick(e) {
	var event = e || window.event;
	if (event.cancelBubble) {
	      event.cancelBubble = true;
	} else {
	      event.stopPropagation();
	}
}

function oscura(o_display) {
	var elem;
	elem=document.getElementById(ID_OSCURA);
	if(elem){
		elem.style.display=o_display;
		elem.style.zIndex=my_zindex++;
	}
}