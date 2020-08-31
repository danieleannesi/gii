function ricarica_settori()
{
    var marca = $('#marchio').val();
    var settore = $('#settore');
    settore.empty();
    settore.append('<option value="' + '">Cerca in tutti i Settori</option>');
    var dati="marca=" + marca;
    request=$.ajax({
	  type: 'post',
	  url: 'leggi_settori.php',
	  data: dati,
      async: false,	  
	  success: function(res) {
          for (var key in res.dati) {
            settore.append('<option value="' + key + '">' + res.dati[key] + '</option>');
            //console.log(arr_jq_TabContents[key]);
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
}

function ricarica_macrofamiglia()
{
    var marca = $('#marchio').val();
    var settore = $('#settore').val();
    var macrofamiglia = $('#macrofamiglia');
    macrofamiglia.empty();
    macrofamiglia.append('<option value="' + '">Seleziona la Macrofamiglia</option>');
    var dati="marca=" + marca + "&settore=" + settore;
    request=$.ajax({
	  type: 'post',
	  url: 'leggi_macrofamiglia.php',
	  data: dati,
      async: false,	  
	  success: function(res) {
          for (var key in res.dati) {
            macrofamiglia.append('<option value="' + key + '">' + res.dati[key] + '</option>');
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
}

function ricarica_famiglia()
{
    var marca = $('#marchio').val();
    var settore = $('#settore').val();
    var macrofamiglia = $('#macrofamiglia').val();
    var famiglia = $('#famiglia');
    famiglia.empty();
    famiglia.append('<option value="' + '">Seleziona la Famiglia</option>');
    var dati="marca=" + marca + "&settore=" + settore + "&macrofamiglia=" + macrofamiglia;
    request=$.ajax({
	  type: 'post',
	  url: 'leggi_famiglia.php',
	  data: dati,
      async: false,	  
	  success: function(res) {
          for (var key in res.dati) {
            famiglia.append('<option value="' + key + '">' + res.dati[key] + '</option>');
			}
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
}

function esegui()
{
    var marca = $('#marchio').val();
    var settore = $('#settore').val();
    var macrofamiglia = $('#macrofamiglia').val();	
    var famiglia = $('#famiglia').val();
    var cerca = $('#cerca').val();
    var cercain = $('#cercain').val();
    $('#elencoart').html('');
    if(marca=="" && cerca=="")
      {
	  alert("Inserire un criterio di ricerca (marchio o descrizione)");
	  return;
	  }
    var dati="marca=" + marca + "&settore=" + settore + "&macrofamiglia=" + macrofamiglia + "&famiglia=" + famiglia + "&cerca=" + cerca + "&cercain=" + cercain;
    request=$.ajax({
	  type: 'post',
	  url: 'cerca_idrobox.php',
	  data: dati,
      async: false,	  
	  success: function(res) {
         $('#elencoart').append(res.dati);
         alert(res.quanti);
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); }
	});
}

function cliccato(marca,codice,descri)
{
	parent.document.getElementById("codart").value=marca+codice;
	parent.document.getElementById("desart").value=descri;
    window.parent.$('.ui-dialog-content:visible').dialog('close');
    parent.document.getElementById("codart").onchange();
}