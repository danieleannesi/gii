function emetti_fatture() {
    var alla_data=$('#data_doc').val();	
	var html="CONFERMA EMISSIONE FATTURE ALLA DATA " + alla_data;
	 $("#dialog").dialog({
							autoOpen: false,
							modal: true,
							async: false,
							closeOnEscape: false,
							title:'AVVISO',
							buttons: {	Ok: function() {
														    esegui();
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
	
function esegui()
{
    var alla_data=$('#data_doc').val();
    var dati="alla_data=" + alla_data;
    request=$.ajax({
	  type: 'post',
	  url: 'emetti_fatture.php',
	  data: dati,
	  success: function(res) {
         //$("#dialog").dialog("close");
	     var html="EMESSE FATTURE DALLA NUMERO " + res.prima + " ALLA NUMERO " + res.ultima;
	     $("#dialog").dialog({
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
          $("#dialog").html(html);
	      $("#dialog").dialog("open");	
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert("?"); alert(xhr.responseText); }
	});
	return;  
}

$(document).ready(function() {
	$(document).bind("ajaxStop",function() { $("#oscura").hide(); });
	$(document).bind("ajaxStart",function() { $("#oscura").show(); });
});

