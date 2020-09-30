function stampa()
{
var alla_data=$('#alla_data').val();
var h="<iframe src=\"pdf_transito.php?data=" + alla_data + "\" width=\"900px\" height=\"700px\"></iframe>";
$("#dialog").html(h).dialog({modal: true, buttons: '',title: "Stampa Merci In Transito", width: 'auto', height:'auto'});
$("#dialog").dialog("open");
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
    $('#nav').addClass('hiding');
});
