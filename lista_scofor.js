function format( detail) { 

    var id_form = "form_"+detail.sco_id;
    var html = '<form class="row_detail" name="row_form" id="'+id_form+'">';
    var contents = $("#detail_scofor").html(); //reference the contents of id xy
    var last_row = '<div class="form-row row col-8">'+
                    '<div class="col-2"><input type="button" onclick="modifica_row('+detail.sco_id+');" value="MODIFICA"  ></div>'+
                    '<div class="col-2"><input type="submit" id="save_'+detail.sco_id+'" onclick="save_row('+detail.sco_id+');" value="SALVA" hidden  ></div>'+
                    '<div class="col-2"><input type="button" id="delete_'+detail.sco_id+'" onclick="delete_row('+detail.sco_id+');" value="ELIMINA" > </div>'+
                    '</div></form> '; 
    html = html + contents + last_row; 
    
    return html ; 
    
}

function compile(d){
     
   
    $.ajax({
        type: "GET",
        url: "get_dettaglio_scofor.php",
        data: {"id":d.sco_id,"tipo":d.scf_tipo},
        async: false,
        dataType: 'json', 
        success: function (response) {
            detail = response; 
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //alert(xhr.status);
            //alert(thrownError);
            console.log(thrownError);
        }
    });

        $('[name="scf_marca"]').val(detail.scf_marca);
        $('[name="sco_id"]').val(detail.sco_id);    
        $('[name="scf_codfor"]').val(detail.scf_codfor);
        $('[name="scf_um"]').val(detail.scf_um);   

        $('[name="scf_set"]').val(detail.scf_set);
        $('[name="scf_mac"]').val(detail.scf_mac);    
        $('[name="scf_fam"]').val(detail.scf_fam);
        $('[name="scf_da_articolo"]').val(detail.scf_da_articolo); 

        $('[name="scf_a_articolo"]').val(detail.scf_a_articolo);
        $('[name="scf_data_da"]').val(detail.scf_data_da);    
        $('[name="scf_data_a"]').val(detail.scf_data_a);
        $('[name="scf_sconto_1"]').val(detail.scf_sconto_1); 

        $('[name="scf_sconto_2"]').val(detail.scf_sconto_2);
        $('[name="scf_sconto_3"]').val(detail.scf_sconto_3);    
        $('[name="scf_sconto_4"]').val(detail.scf_sconto_4);
        $('[name="scf_sconto_5"]').val(detail.scf_sconto_5); 

        $('[name="scf_netto"]').val(detail.scf_netto);
        $('[name="scf_lis_da_netto"]').val(detail.scf_lis_da_netto).attr("checked",true);    
        $('[name="scf_sconto_ag"]').val(detail.scf_sconto_ag);
        $('[name="scf_magg_netto"]').val(detail.scf_magg_netto);

        $('[name="scf_cliente"]').val(detail.scf_cliente);
        $('[name="scf_trasporto"]').val(detail.scf_trasporto);    
        $('[name="scf_da_tabart"]').val(detail.scf_da_tabart);
        $('[name="scf_a_tabart"]').val(detail.scf_a_tabart); 

        $('[name="scf_ricarica"]').val(detail.scf_ricarica);
        $('[name="scf_note"]').val(detail.scf_note);     


} 

function modifica_row(id){ 
    $('#save_'+id).removeAttr('hidden');
    $('#form_'+id+' .modificabile').prop("disabled", false);
    $('#modifica_row'+id).hide();
     
} 

function save_row(id){
      
        var form = $("#form_"+id); 

        $.ajax({
            type: 'post',
            url: 'salva_scofor.php',
            dataType: 'JSON',
            async: false,
            data: form.serialize(), 
            success: function (result) {
                console.log('Submission was successful.');
                console.log(result);
            },
            error: function (result) {
                console.log('An error occurred.');
                console.log(result);
            },
        });
}

function delete_row(id){
    var message = "Sei sicuro di voler eliminare lo scofor selezionato?";
    $('<div></div>').appendTo('body')
    .html('<div><h6>' + message + '?</h6></div>')
    .dialog({
      modal: true,
      title: 'Cancella Scofor',
      zIndex: 10000,
      autoOpen: true,
      width: '300',
      resizable: false,
      buttons: {
        Yes: function() {
          // $(obj).removeAttr('onclick');                                
          // $(obj).parents('.Parent').remove();
          $.post( "delete_scofor.php", {sco_id: id },function( data ) {
            $( ".result" ).html( data );
          });
          

          $(this).dialog("close");
        },
        No: function() {  
          $(this).dialog("close");
        }
      },
      close: function(event, ui) {
        $(this).remove();
      }
    });

    $('#table_scofor').DataTable().ajax.reload();
}


$(document).ready(function() {  
    var table = $('#table_scofor').DataTable({  
        processing: false,
        serverSide: false,
        ajax: {
            url : 'get_scofor.php',
            data: {scf_eliminato:0}
        }, 
        columns: [ 
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            {"data": "scf_marca"},
            {"data": "scf_tipo"},
            {"data": "scf_listino"},
            {"data": "scf_codfor"},
            {"data": "scf_da_articolo"},
            {"data": "scf_a_articolo"}
         ],
         initComplete: function () {
            this.api().columns([2]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()))
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
            this.api().columns([1,3,4,5,6]).every( function () {
                var column = this;
                var select = $('<br><input type="text" />')
                .appendTo( $(column.header()) )
                .on( 'keyup', function () {
                    column 
                        .search( this.value )
                        .draw();
                } );
  
            } );
        }
    });

     // Array to track the ids of the details displayed rows
     var detailRows = [];
 
     $('#table_scofor tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
  
        if ( row.child.isShown() ) {
            // This row is already open - close it 
            tr.removeClass('shown');
            tr.removeClass( 'details' );
            row.child.hide();
        }  else {   
            row.child( format(row.data()) ).show();
            compile(row.data());
            tr.addClass('shown'); 
         }
     } ); 

 
     // On each draw, loop over the `detailRows` array and show any child rows
     table.on( 'draw', function () {
         $.each( detailRows, function ( i, id ) {
             $('#'+id+' td.details-control').trigger( 'click' );
         } );
     } );
     
     
     

} );