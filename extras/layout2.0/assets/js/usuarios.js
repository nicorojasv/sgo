$(document).ready(function(){


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