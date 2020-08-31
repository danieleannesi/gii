//funzioni per i div
var idd;
function setspostadiv(id)
{
idd=id;
document.onmousemove = spostadiv;
}
function spostadiv(e)
{
if (!e) var e = window.event;
var w=document.getElementById(idd).clientWidth/2;
document.getElementById(idd).style.left=e.clientX - w;
document.getElementById(idd).style.top=(e.clientY + document.body.scrollTop - 11);
}
function finespostadiv()
{
document.onmousemove = null;
}
function closeDiv(menu,nometag)
{
document.getElementById(nometag).style.visibility='hidden';
var el=document.getElementById(nometag);
el.parentNode.removeChild(el);
if(menu) {
  location.href = "menu.php";
  }
return false;
}
function displayFinestra(codice,nomeart,nometag)
{
document.getElementById(nomeart).src=codice
document.getElementById(nometag).style.left=50;
document.getElementById(nometag).style.top=(50 + document.body.scrollTop);
document.getElementById(nometag).style.visibility="visible";
}
function displayFinestra0(codice,nomeart,nometag)
{
document.getElementById(nomeart).src=codice
document.getElementById(nometag).style.left=0;
document.getElementById(nometag).style.top=0;
document.getElementById(nometag).style.visibility="visible";
}
function displayWin(nometag)
{
document.getElementById(nometag).style.visibility="visible";
}
//
function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
  
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
}
//
function ex_chiama(nome,codice,nomeart,nometag,x,y,wx,wy)
{
codice=escape(codice);
var tipo="free";
if(nometag=="modal")
  tipo="modal";
ajax('none','popup.php?name=' + nomeart + '&titolo=' + nome + '&script=' + codice + '&wx=' + wx + '&wy=' + wy + '&ax=' + x + '&ay=' + y + '&type=' + tipo,'',true,'POST');
}

function chiama(nome,codice,nomeart,nometag,x,y,wx,wy)
{
	apri_win(nome,codice);
}

function chiama2(nome,codice,nomeart,nometag,x,y,wx,wy)
{
codice=escape(codice);
var tipo="free";
if(nometag=="modal")
  tipo="modal";		
ajax('none','popupe.php?name=' + nomeart + '&titolo=' + nome + '&script=' + codice + '&wx=' + wx + '&wy=' + wy + '&ax=' + x + '&ay=' + y + '&type=' + tipo,'',true,'POST');
}
function chiamas(nome,codice,nomeart,nometag,campo,x,y,wx,wy)
{
if(!document.getElementById(nometag))
  {
  var wxd=wx;
  var wyd=wy;
  var inner="<div class=\"dynamicDivS\" style=\"width:" + wxd + "px; height:" + wyd + "px;\" id=\"" + nometag + "\"><iframe id=\"" + nomeart + "\" src=\"\" width=\"" + wx + "\" height=\"" + wy + "\"></iframe></div>";
  document.getElementById("lancia").innerHTML=document.getElementById("lancia").innerHTML + inner;
  }
var yc=document.getElementById(campo);
var position = getPosition(yc);
var h = document.getElementById(campo).offsetHeight;
document.getElementById(nomeart).src=codice;
document.getElementById(nometag).style.left=position.x;
document.getElementById(nometag).style.top=(position.y + document.body.scrollTop + h + 3);
document.getElementById(nometag).style.visibility="visible";
}

function _apri_win(titolo, script) {
     var documentWidth = $(document).width() - 10; //retrieve current document width
     var documentHeight = $(document).height() - 80; //retrieve current document height
     var h="<iframe style='width: " + documentWidth + "px; " + "height: " + documentHeight + "px;' id='frame' frameBorder='0' src='" + script + "'></iframe>";
     $("#dialogs").html(h);
	 $("#dialogs").dialog({
		title: titolo,
		modal: true,
		width: 'auto',
		height: 'auto',
		position: { at: "left bottom" },
		close: function() {
			$( this ).dialog( "close" );
		}
	})
	$("#dialogs").show();
}

function apri_win(titolo, script) {
     var documentWidth = $("#container").width() - 4; //retrieve current document width
     var documentHeight = $(document).height() - 90;
     var h="<iframe style='width: " + documentWidth + "px; " + "height: " + documentHeight + "px;' id='frame' frameBorder='0' src='" + script + "'></iframe>";
     $("#dialogs").html(h);
	 $("#dialogs").dialog({
		title: titolo,
        autoOpen: false,
        resizable: false,
		modal: true,
		width: 'auto',
		close: function() {
			$( this ).dialog( "close" );
		}
	})    
	$("#dialogs").dialog('open');
}

function apri_win2(titolo, script) {
     var documentWidth = $("#dialogs").parent().width() - 4; //retrieve current document width
     var documentHeight = $(document).height() - 90;
     var h="<iframe style='width: " + documentWidth + "px; " + "height: " + documentHeight + "px;' id='frame' frameBorder='0' src='" + script + "'></iframe>";
     $("#dialogs").html(h);
	 $("#dialogs").dialog({
		title: titolo,
        autoOpen: false,
        resizable: false,
		modal: true,
		width: 'auto',
		close: function() {
			$( this ).dialog( "close" );
		}
	})    
	$("#dialogs").dialog('open');
}
