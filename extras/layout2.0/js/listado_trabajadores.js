$(document).ready(function(){
	var url2 = "";
	var id_usuario = "";
	$('#sample_1').dataTable({
    	"processing": true,
        "serverSide": true,
        "ajax":{
        	async: false,
            url :base_url+"est/trabajadores/listado_gente", // json datasource
            type: "post",  // method  , by default get
            
          /*  error: function(){  // error handling
                $(".employee-grid-error").html("");
                $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#employee-grid_processing").css("display","none");

            }*/
        },
		"aoColumnDefs" : [{
			"aTargets" : [0]
		}],
		"oLanguage" : {
			"sLengthMenu" : "Show _MENU_ Rows",
			"sSearch" : "",
			"oPaginate" : {
				"sPrevious" : "",
				"sNext" : ""
			}
		},
		"aaSorting" : [[2, 'asc']],
		"aLengthMenu" : [[5, 10, 15, 20, -1], [5, 10, 15, 20, "All"] // change per page values here
		],
		// set the initial value
		"iDisplayLength" : 20,
	});

	$(".sv-callback-list").on("click", function(e) {
		e.preventDefault();
		id_usuario = $(this).data('usuario');
		url = $(this).attr('href');
		$('#subview-eval-list').load(url, function() {
			$("#sv-callback-add,#sv-callback-add1,#sv-callback-edit").on("click", function(e) {
				e.preventDefault();
				url2 = $(this).attr('href');
				$('#subview-eval-add').load(url2,function(){
					$("#tipo").on('change',function(){
						val = $(this).val();
						$.ajax({
					      	url: base_url+'est/evaluaciones/retorno_evaluacion/'+val,
					      	type: 'GET',
					      	async: false,
					      	dataType: "json",
					      	success: function(json) {
					      		$('#subtipo').html("");
					      		$.each(json, function(i, value) {
						            $('#subtipo').append($("<option>").text(value.nombre).attr('value', value.id));
						        });
						    }
					    });
					});
					$( '#agregar_examen' ).on('submit',function( f ) {
						f.preventDefault();
						action = $(this).attr('action');
					    $.ajax({
					      	url: action,
					      	type: 'POST',
					      	async: false,
					     	data: new FormData( this ),
					      	processData: false,
					      	contentType: false,
					      	success: function(data) {
						      	toastr.info(data);
						      	//$('#subview-eval-list').load(url);
						    }
					    });
					    
					    $.ajax({
					      	url: base_url+'est/evaluaciones/ultimos_examenes/'+id_usuario,
					      	type: 'GET',
					      	async: false,
					      	dataType: "json",
					      	success: function(data) {
					      		a_href_masso = "<a target='_blank' href='"+base_url +"est/evaluaciones/informe/"+id_usuario+"'>"+data.masso+"</a>";
					      		a_href_examen = "<a target='_blank' href='"+base_url +"est/evaluaciones/informe/"+id_usuario+"'>"+data.examen+"</a>";
						      	$("#masso_"+id_usuario).html( a_href_masso );
						      	$("#examen_"+id_usuario).html( a_href_examen );
						    }
					    });
					});
				});
				$.subview({
					content: "#subview-eval-add",
					startFrom: "right",
				});
			});
			$(".tooltips.eliminar").on("click",function(){
				estoy = $(this);
				id_del = $(this).data('id');
		    	$.get(base_url+"est/evaluaciones/ajax_eliminar/"+id_del,function(data){
		    		estoy.parent().parent().parent().hide();
		    		if(data == ""){
		    			toastr.info("Ha sido eliminado el examen");
		    		}
		    		else{
		    			toastr.error("Ocurrio un error");
		    		}
		    	});
		    });
		    $(".tooltips.editar").on("click",function(){
				id_del = $(this).data('id');
		    	e.preventDefault();
				$('#subview-eval-add').load(url2);
				$.subview({
					content: "#subview-eval-add",
					startFrom: "right",
				});
		    });
		});
		$.subview({
			content: "#subview-eval-list",
			startFrom: "right",
		});
	});
	$(".add_req").on("click", function(){
		url = window.location.href;
		strvalores = url.split('/');
		id_req = parseInt(strvalores[strvalores.length-1]);
		$.get(base_url+"est/requerimiento/guardar_usuarios_requerimiento/"+id_req,function(data){
        	if(data == ""){
        		toastr.success("Guardado exitosamente. Volviendo a pagina anterior!");
        		var redirect = base_url+'est/requerimiento/usuarios_requerimiento/'+id_req;    
				setTimeout (location.href=redirect, 100);
        	}
        	else{
        		toastr.error("Error al guardar, favor comunicarse con el administrador");
        	}
        });
	});
	/*
	$('#select-req').select2().on("change", function(e) {
		id_req = $(this).val();
		$.get(base_url+"est/requerimiento/guardar_usuarios_requerimiento/"+id_req,function(data){
        	if(data == ""){
        		toastr.success("Guardado exitosamente");
        	}
        	else{
        		toastr.error("Error al guardar, favor comunicarse con el administrador");
        	}
        });
	});*/

	$('.check_edit').change(function() {
		usr = $(this).val();
        if($(this).is(":checked")) {
            toastr.info("Chequeado")
            $.get(base_url+"est/requerimiento/agregar_session/"+usr,function(data){
            	if ( $( "#cont_add" ).length ) {
					valor = parseInt($( "#cont_add" ).text());
					$( "#cont_add" ).text(valor + 1);
				}
				toastr.info(data);
            });
        }
       	else{
       		toastr.info('no chequeado');
       		 $.get(base_url+"est/requerimiento/agregar_session/"+usr+"/remove",function(data){
            	if ( $( "#cont_add" ).length ) {
					valor = parseInt($( "#cont_add" ).text());
					$( "#cont_add" ).text(valor - 1);
				}
				toastr.info(data);
            });
       	}       
    });
});
