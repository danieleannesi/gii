function conferma()
{
   for (var i=0;i<document.preventivi.elements.length;i++)
     {
    nomeint=document.preventivi.elements[i].id;
    nomenome=document.preventivi.elements[i].name;
    nometag=document.preventivi.elements[i].tagName;
    tipo=document.preventivi.elements[i].type;
    valore="";
    if (nometag == "INPUT") {
       if (tipo == "checkbox") {
           valore="";
           if(document.getElementById(nomeint).checked==true)
             {
             valore=document.querySelector("input[name='" + nomeint + "']:checked").value;
    var dati="idt=" + valore;
    request=$.ajax({
	  type: 'post',
	  url: 'get_preventivo.php',
	  data: dati,
	  success: function(res) {
         var result=JSON.parse(res.PREV_RIGHE);
         for(var k=0;k<result.cod.length;k++)
            {
            parent.document.getElementById("quantita").value=result.qta[k];
            parent.document.getElementById("codart").value=result.cod[k];
            parent.document.getElementById("desart").value=result.desc[k];
            parent.document.getElementById("ali0").value=result.iva[k];
            parent.document.getElementById("prezzo").value=result.uni[k];	
            parent.document.getElementById("totale").value=result.tot[k];	
            parent.document.getElementById("sconto").value=result.sco[k];
            parent.document.getElementById("raee").value=result.raee[k];
            parent.salvariga();
			}
         parent.chiudi_ele_preventivi();
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (get_preventivo.php)</p>').dialog({modal: true }); }
	});
             }
            }
            }
       }

}