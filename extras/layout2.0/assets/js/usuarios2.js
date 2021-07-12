$(document).ready(function(){
	$("#rut").focusout(function(){
		rut = $(this).val();

		var posting = $.post( base_url + "wood/trabajadores/rut_existe",{rut : rut});
 
        // Put the results in a div
        posting.done(function( data ) {
            if(data.trim() == 'no'){
            	toastr.success("El rut esta disponible");
            }
            if(data.trim() == 'si'){
            	toastr.error("El rut ya se encuentra en el sistema");
            }
            if(data.trim() == 'vacio'){
            	toastr.error("El campo esta vacio!!");
            }
        });
	});

	$("#rut").Rut({
	   format_on: 'keyup',
	   on_error: function(){ toastr.error('El rut ingresado es incorrecto'); }
	});

	$("#tipo_usuario").change(function(){
		id_tipo = $(this).val();
		$('#cargo_usuario').find('option').remove();
		$.ajax({
			dataType: "json",
			type: 'post',
			url: base_url + "usuarios/perfil/tipo_usuario",
			data: {id : id_tipo},
			success: function(data){
				$.each(data, function(i, value) {   
				    $('#cargo_usuario')
				        .append($("<option></option>")
				        .attr("value",data[i].id)
				        .text(data[i].desc_tipo_usuarios)); 
				});
			}
		});
	});

	$("#select_region").on('change',function(){
		val = $(this).val();
		$.ajax({
	      	url: base_url+'usuarios/perfil/ajax_provincias/'+val,
	      	type: 'GET',
	      	dataType: "json",
	      	success: function(json) {
	      		$('#select_provincia').html("");
	      		$.each(json, function(i, value) {
		            $('#select_provincia').append($("<option>").text(value.desc_provincias).attr('value', value.id));
		        });
		    }
	    });
	    $.ajax({
	      	url: base_url+'usuarios/perfil/ajax_ciudades/'+val,
	      	type: 'GET',
	      	dataType: "json",
	      	success: function(json) {
	      		$('#select_ciudad').html("");
	      		$.each(json, function(i, value) {
		            $('#select_ciudad').append($("<option>").text(value.desc_ciudades).attr('value', value.id));
		        });
		    }
	    });
	});
});
