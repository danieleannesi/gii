// $('#desc').keyup(gestisci_tasti);
// $('#desc').bind('keyup', { ar_lista: "lista_indirizzi", codice: "12345678" }, gestisci_tasti);
//
var ret1;
var ret2;
var ret3;
var ret4;
//
function delay(callback, ms) {
  var timer = 0;
  return function() {
    var context = this, args = arguments;
    clearTimeout(timer);
    timer = setTimeout(function () {
      callback.apply(context, args);
    }, ms || 0);
  };
}
//
function sceglivia(event) {
	event.preventDefault();
	$('#lista_vie').hide();
	if(ret1>"")
	  {
	  $('#' + ret1).val(event.data.articolo);
	  }
	if(ret2>"")
	  {
	  $('#' + ret2).val(event.data.codice).trigger('change');
	  }
	if(ret3>"")
	  {
	  $('#' + ret3).val(event.data.terzo);
	  }
	if(ret4>"")
	  {
	  $('#' + ret4).val(event.data.quarto);
	  }
    $('input[id$=_txtTest]').val('hello').trigger('change');	  
	return false;
}

function gestisci_tasti(evt){
    //var dati = evt.data.dati;
    //alert(evt.data.dati + " " + evt.data.codice + " key=" + evt.keyCode + " which=" + evt.which);
    ret1=evt.data.ret1;
    ret2=evt.data.ret2;
    ret3=evt.data.ret3;
    ret4=evt.data.ret4;
    var ar_lista=evt.data.ar_lista;
	var charcode = evt.which || evt.keyCode;
	switch(charcode){
		case 27:
			$("#lista_vie").css({display:'none'});
		break;
		case 38:
			naviga('up');
		break;
		case 40:
			naviga('down');
		break;
		case 13:
            $("#lista_vie ul li").eq(current_sel).click();
        break;
		default:
	    if (evt.target.value.toString().length == 0 || evt.target.value == '') {	///////////////////////////////// if (evt.target.value.toString().length == 0) faccio in modo che se è vuoto non apra la lista
        return;
		  }
      var ul = $('#lista_vie');
      ul.empty();
      var ul2 = document.createElement("UL");
      var lista_cerca=filtraIndirizzi(window[ar_lista], evt.target.value);
        if(lista_cerca != ''){
			for (i in lista_cerca) {
	      	via = lista_cerca[i];
	        var li = $('<li/>').html(via.articolo).click(via,sceglivia).appendTo(ul2);
		      }
		      var offset = $('#' + ret1).position();
		      //var left = offset.left + $('#' + ret1).width() + 10;
		      var w=$('#' + ret1).width();
		      var left = offset.left;
		      //var top = offset.top + $('#' + ret1).height() - 12;
		      var top = offset.top + $('#' + ret1).height() + 17;
		      var css = {display:'block', position:'absolute', top: top, left: left, width: w, height:'500px',padding:'0px',margin:'0px' };
		      $(ul).append(ul2);
		      $('#lista_vie').css(css);
		      //$('#lista_vie').center();
		}else{
				$('#lista_vie').css({display:'none'});
		}
    }
}

function filtraIndirizzi(lista, ricerca) {
  ricerca = ricerca.replace(/['`]/g, ' ');
  var parole = ricerca.split(' '), j = parole.length, parola, i = 0;
  return lista.filter(function(element){
									  	if(i<501)
									  	  {
									    for (var k = 0; k < j; k++) {
									      parola = parole[k].toUpperCase();
									      if(element.articolo==null)
									        return true;
                                          arti=element.articolo.toUpperCase();
									      //if (arti.indexOf(parola) == -1) {
									      //  return false;
									      //  }
									      if(!arti>=parola)
									        {
									        return false;
									        }	
									    }
									    i++;
									    return true;
										  }
									  });
}

function carica_indirizzi(prog,aname,ragsoc) {
dati="ragsoc=" + ragsoc;
$.ajax({
  type: "POST",
  url: prog,
  data: dati,
  async: false,
  success: function(data) {
      window[aname]=data;
      }
});	
}	

function naviga(direction){
   var selector = "#lista_vie ul li";
   if($(selector+ ".selezionato").size()==0) {
      current_sel = -1;
   }
   if(direction == 'up' && current_sel != -1) {
   		if(current_sel!=0){
			current_sel--;	
		}
   } else if (direction == 'down') {
      if(current_sel!=($(selector).size()-1)) {
         current_sel++;
      }
   }
   seleziona(current_sel);
}

function seleziona(quale){
	var selector = "#lista_vie ul li";
	$(selector).removeClass("selezionato");
	$(selector).eq(quale).addClass("selezionato");
}

var confirmOnPageExit = function (e) {
    // If we haven't been passed the event get the window.event
    //if (shouldWarn) { return ''};
};

function carica_articoli(prog,aname,codart) {
dati="codart=" + codart;
$.ajax({
  type: "POST",
  data: dati,
  url: prog,
  async: false,
  success: function(data) {
      window[aname]=data;
      }
});	
}	

function carica_descrizione(prog,aname,desart) {
dati="desart=" + desart;
$.ajax({
  type: "POST",
  data: dati,
  url: prog,
  async: false,
  success: function(data) {
      window[aname]=data;
      }
});	
}	

function gestisci_clienti(evt){
       var ragsoc=$('#ragsoc').val();
       if(ragsoc.length < 3)
         {
	     return;
	     }

    if(isNaN(ragsoc))
      {
      carica_indirizzi("carica_clienti.php","lista_clienti",ragsoc);
	  }
	else
	  {
      carica_indirizzi("carica_clienti_codice.php","lista_clienti",ragsoc);
	  }
    gestisci_tasti(evt);
};

function gestisci_fornitori(evt){
    var ragsoc=$('#ragsoc').val();
    if(ragsoc.length < 3)
      {
	  return;
	  }
    carica_indirizzi("carica_fornitori.php","lista_clienti",ragsoc);
    gestisci_tasti(evt);
};

function gestisci_fornitori1(evt){
    var ragsoc=$('#ragsocfo').val();
    if(ragsoc.length < 3)
      {
	  return;
	  }
    carica_indirizzi("carica_fornitori.php","lista_clienti",ragsoc);
    gestisci_tasti(evt);
};

function gestisci_articoli(evt){
    var codart=$("#codart").val();
    if(codart.length < 3)
      {
	  return;
	  }
    if(isNaN(codart))
      {
      carica_descrizione("carica_descrizione.php","lista_articoli",codart);
	  }
	else
	  {
      carica_articoli("carica_articoli.php","lista_articoli",codart);
	  }
    gestisci_tasti(evt);
};

function gestisci_descrizione(evt){
    var desart=$("#desart").val();
    if(desart.length < 2)
      {
	  return;
	  }
    carica_descrizione("carica_descrizione.php","lista_articoli",desart);
    gestisci_tasti(evt);
};