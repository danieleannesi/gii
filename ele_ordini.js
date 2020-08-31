function conferma()
{
   var ind=0;
   for (var i=0;i<document.ordini.elements.length;i++)
     {
    nomeint=document.ordini.elements[i].id;
    nomenome=document.ordini.elements[i].name;
    nometag=document.ordini.elements[i].tagName;
    tipo=document.ordini.elements[i].type;
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
	  url: 'get_ordine.php',
	  data: dati,
	  async: false,
	  success: function(res) {
         var result=JSON.parse(res.ORDI_RIGHE);
         for(var k=0;k<result.cod.length;k++)
            {
            parent.document.getElementById("indice").value=ind;
            parent.document.getElementById("quantita").value=result.qta[k];
            parent.document.getElementById("codart").value=result.cod[k];
            parent.document.getElementById("desart").value=result.desc[k];
            parent.document.getElementById("ali0").value=result.iva[k];
            parent.document.getElementById("prezzo").value=result.uni[k];	
            parent.document.getElementById("totale").value=result.tot[k];	
            parent.document.getElementById("sconto").value=result.sco[k];
            parent.document.getElementById("raee").value=result.raee[k];
            parent.document.getElementById("ordine").value=res.ORDI_ID;
            parent.carica_articolo(result.cod[k]);
            parent.salvariga();
            ind++;
			}
         parent.chiudi_ele_ordini();
	     },
	  error: function(xhr, ajaxOptions, thrownError) { alert(xhr.responseText); $("#dialog").html('<p>Errore (get_ordine.php)</p>').dialog({modal: true }); }
	});
             } //fine if checked
            }
            }
       }

}