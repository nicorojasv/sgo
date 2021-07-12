jQuery(document).ready(function($){
// Change es un evento que se ejecuta cada vez que se cambia el valor de un elemento (input, select, etc).
$('#milista').change(function(e){
	$('#estado').val($(this).val());
  		estado = ($('input:hidden[name=estado]').val());
		location.href=base_url+"est/examen_psicologico/index/"+estado;
});
});


function buscar() {
    var textoBusqueda = $("input#busqueda").val();
    $("input#searchNombre").val('');
    $("input#searchApellido").val('');
    if (textoBusqueda != "" && textoBusqueda.length >4) {
        $.post(base_url+"est/examen_psicologico/busqueda", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $('.dataTables_empty').fadeOut();
            $("#resultadoBusqueda").html(mensaje);
        }); 
    };

};