$(document).ready(function(){
	var url2 = "";
	var id_usuario = "";

	
	var dtable = $('#sample_1').dataTable({
		scrollX:        true,
    	scrollCollapse: true,
    	"ajax":{
        	async: false,
            url :base_url+"est/trabajadores/leer_json", // json datasource
        },
    	"iDisplayLength" : 20,
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
	});

	/*
	var dtable = $('#sample_1').dataTable({
    	"processing": true,
        "serverSide": true,
        "ajax":{
        	async: false,
            url :base_url+"est/trabajadores/listado_gente", // json datasource
            type: "post",  // method  , by default get
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
		// set the initial value
		"iDisplayLength" : 20,
	}).api();
	
	$(".dataTables_filter input")
    .unbind() // Unbind previous default bindings
    .bind("keyup", function(e) { // Bind our desired behavior
        // If the length is 3 or more characters, or the user pressed ENTER, search
        if(e.keyCode == 13) {
            // Call the API search function
            dtable.search(this.value).draw();
        }
        // Ensure we clear the search if they backspace far enough
        if(this.value == "") {
            dtable.search("").draw();
        }
        return;
    }); */

	$('#sample_1 tbody').on('click','.sv-callback-list', function (e) {
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
				setTimeout (location.href=redirect, 50);
        	}
        	else{
        		toastr.error("Error al guardar, favor comunicarse con el administrador");
        	}
        	console.log(data);
        });
	});

	$('#sample_1 td').on('change','.check_edit',function() {
		usr = $(this).val();
		//alert(usr);
        if($(this).is(":checked")) {
            //toastr.info("Chequeado")
            $.get(base_url+"est/requerimiento/agregar_session/"+usr,function(data){
            	if ( $( "#cont_add" ).length ) {
					valor = parseInt($( "#cont_add" ).text());
					$( "#cont_add" ).text(valor + 1);
				}
				toastr.info("Agregado");
				console.log(data);
            });
        }
       	else{
       		//toastr.info('no chequeado');
       		 $.get(base_url+"est/requerimiento/agregar_session/"+usr+"/remove",function(data){
            	if ( $( "#cont_add" ).length ) {
					valor = parseInt($( "#cont_add" ).text());
					$( "#cont_add" ).text(valor - 1);
				}
				toastr.info("Quitado");
				console.log(data);
            });
       	}       
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
	
	
});
