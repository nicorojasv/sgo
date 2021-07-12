$(document).ready(function(){
	$("#example1").dataTable({
        scrollY:        "500px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 1
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