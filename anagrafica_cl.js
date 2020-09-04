$(document).ready(function () {
 $("#detailAnagrafica").css("display", "none");
 var table = $('#table_anagrafica').DataTable({  
    processing: false,
    serverSide: false,
    ajax: {
        url : 'get_anagrafica_cl.php' 
    }, 
    columns: [ 
        {
            "class":          "fa-edit details-control",
            "orderable":      false,
            "data":           null,
            "defaultContent": "<i class='fas fa-edit'></i>"
        },
        {"data": "cf_cod"}, 
        {"data": "cf_tipo"},
        {"data": "cf_ragsoc"},
        {"data": "cf_piva"},
        {"data": "cf_codfisc"},
        {"data": "cf_telefono"}
    ]
});

$('#table_anagrafica tbody').on( 'click', 'tr td.details-control', function () {
    var data = table.row($(this).parents('tr')).data();
    var id = data["cf_cod"]; 
    openEdit(id);
    

});

function openEdit(id){
 
    if(id){
       
        //get cliente
        $.ajax({
            type: "post",
            url: "get_anagrafica_cl.php",
            data: {cf_cod:id}, 
            success: function (data) {  
                $("input[name=cf_cli_for]").val(data.cf_cli_for); 
                $("input[name=cf_cod]").val(data.cf_cod); 
                $("input[name=cf_tipo]").val(data.cf_tipo); 
                $("#cf_tipo").val(data.cf_tipo);
                $("input[name=cf_ragsoc]").val(data.cf_ragsoc);
                $("input[name=cf_cognome]").val(data.cf_cognome);   
                $("input[name=cf_nome]").val(data.cf_nome);     
                $("input[name=cf_piva]").val(data.cf_piva);     
                $("input[name=cf_codfisc]").val(data.cf_codfisc);     
                
                $("input[name=cf_localita]").val(data.cf_localita);     
                $("input[name=cf_cap]").val(data.cf_cap);     
                $("#province").val(data.cf_prov);     
                $("input[name=cf_indirizzo]").val(data.cf_indirizzo);     
                $("input[name=cf_telefono]").val(data.cf_telefono);     
                $("input[name=cf_fax]").val(data.cf_fax);     

                $("input[name=cf_email]").val(data.cf_email);     
                $("input[name=cf_pec]").val(data.cf_pec);     
                $("input[name=cf_iva]").val(data.cf_iva);   

                $("input[name=cf_codice_unico]").val(data.cf_codice_unico);     
                $("input[name=cf_rif_uff_acquisti]").val(data.cf_rif_uff_acquisti);     
                $("input[name=cf_rif_ammi]").val(data.cf_rif_ammi);

                $("input[name=cf_banca]").val(data.cf_banca);     
                $("input[name=cf_iban]").val(data.cf_iban);     
                $("#cf_agente").val(data.cf_agente);

            } 
        });

    }
    $("#detailAnagrafica").dialog({
        autoOpen: false,
        width: 800,
        modal: true,
        title: "Richiesta Carta Bianca",
        dialogClass: "detail",
        buttons: {
            "Cancel": function () {
                $("#detailAnagrafica").dialog("close");
            },
            "Salva": function () {
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                    
                Array.prototype.filter.call(forms, function (form) {
            
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        var dati = $("#anag_cl").serialize(); 
                        $.ajax({
                            type: "post",
                            url: "save_anagrafica_cl.php",
                            data: dati, 
                            success: function (data) {  
                                $("input[name=cf_cod]").val(data.cf_cod);
                                $("#detailAnagrafica").dialog("close");
                                $('#table_anagrafica').row( $(this) ).invalidate().draw();
                            } 
                        });
            
                    }
                    form.classList.add('was-validated');
                    
                });
            }
        } 
    });
    

    $("#detailAnagrafica").dialog("open");
   
}
 

  
});





 