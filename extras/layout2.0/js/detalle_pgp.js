$(document).ready(function(){
	$(".guardar_modal").submit(function(e){
      	e.preventDefault();
      	id = $('.comentario').data('id');
      	url = base_url+'mandante/mandante/modal_comentario/'+id;
      	textarea = $('.comentario').val();
      	$.post( url,{comentario : textarea});
      	toastr.success("Comentario guardado");
    });
    $("#example1").dataTable({
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1,
            rightColumns: 1
        }
    });
    $('#example1 tbody').on('click','.sv-callback-list', function (e) {
      e.preventDefault();
      id_usuario = $(this).data('usuario');
      url = $(this).attr('href');
      $('#subview-eval-list').load(url,function(){
        $.subview({
          content: "#subview-eval-list",
          startFrom: "right",
        });
      });
    });
});