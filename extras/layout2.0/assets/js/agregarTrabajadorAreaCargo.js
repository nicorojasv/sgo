
function buscar() {
    var textoBusqueda = $("input#busqueda").val();
    $("input#searchNombre").val('');
    $("input#searchApellido").val('');
    if (textoBusqueda != "" && textoBusqueda.length >4) {
        $.post(base_url+"est/requerimiento/busqueda", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
        }); 
    };

};
function buscarNombre() {
    var textoBusqueda = $("input#searchNombre").val();
    $("input#busqueda").val('');
    $("input#searchApellido").val('');
    if (textoBusqueda != "" && textoBusqueda.length >4) {
        $.post(base_url+"est/requerimiento/busqueda", {valorBusquedaNombre: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
    };
    
};
function buscarApellido() {
    var textoBusqueda = $("input#searchApellido").val();
 	$("input#busqueda").val('');
    $("input#searchNombre").val('');
    if (textoBusqueda != "" && textoBusqueda.length >4) {
        $.post(base_url+"est/requerimiento/busqueda", {valorBusquedaApellido: textoBusqueda}, function(mensaje) {
            console.log(mensaje)
            $("#resultadoBusqueda").html(mensaje);
        }); 
    };
    
};
$(document).ready(function() {
	//alert(document.getElementById("cont_add").value)
   	$("#resultadoBusqueda").on('click','.agregarAlRequerimiento',function(){
        var idTrabajador = $(this).attr('data');
        var nombreTrabajador = $(this).attr('data-nombre');
        var idAreaCargo = $("#id_area_cargo").val();
        
        $.ajax({
            type: "POST",
            url: base_url+"est/requerimiento/agregar_usuarios_requerimiento_ajax",
            data: {idTrabajador: idTrabajador, idAreaCargo: idAreaCargo},
            dataType: "json",                    
            success: function(data) {
            	if (data == 0) {
            		alertify.error(nombreTrabajador+' ya se encuentra agregado al requerimiento');
            	}else{
	                var y = new Number(document.getElementById('cont_adda').innerHTML);
	                $('#cont_adda').empty();
	                $('#cont_adda').append(y+1);
            		alertify.success(nombreTrabajador+' a sido agregado al requerimiento');
            		$('#'+idTrabajador+'tr').fadeOut('9000'), function(){
                   	 	$(this).remove();
                	}
            	}                        
            }
        });
    });                 
 });     


