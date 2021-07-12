$(document).ready(function(){
	var url2 = "";
	var id_usuario = "";
	var dtable = $('#sample_1').dataTable({
		scrollX:        true,
    	scrollCollapse: true,
    	"ajax":{
        	async: false,
            url :base_url+"est/trabajadores/leer_json",
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


	$('#sample_1 tbody').on('click','.sv-callback-list', function (e){
		e.preventDefault();
		id_usuario = $(this).data('usuario');
		url = $(this).attr('href');
		$('#subview-eval-list').load(url, function() {
			$("#sv-callback-add,#sv-callback-add1,#sv-callback-edit").on("click", function(e){
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
					      	async: true,
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

	$(".add_psicologico").on("click", function(){
		url = window.location.href;
		toastr.success("Favor ingrese los datos que a continuacion se solicitan!");
		var redirect = url;    
		setTimeout (location.href=redirect, 2500);
	});

	$(".add_revision_examen").on("click", function(){
		url = window.location.href;
		toastr.success("Favor ingrese los datos que a continuacion se solicitan!");
		var redirect = url;    
		setTimeout (location.href=redirect, 2500);
	});

	$('#sample_1 tbody').on( 'click', 'tr td .check_edit', function () {
		usr = $(this).val();
		//alert(usr);
        if($(this).is(":checked")){
            //toastr.info("Chequeado")
            $.get(base_url+"est/requerimiento/agregar_session/"+usr+"/add",function(data){
            	if ( $( "#cont_add" ).length ){
					valor = parseInt($( "#cont_add" ).text());
					$( "#cont_add" ).text(valor + 1);
				}
				toastr.info("Agregado exitosamente");
				console.log(usr + "(add) - " +data);
            });
        }else{
       		//toastr.info('no chequeado');
       		 $.get(base_url+"est/requerimiento/agregar_session/"+usr+"/remove",function(data){
            	if ( $( "#cont_add" ).length ){
					valor = parseInt($( "#cont_add" ).text());
					$( "#cont_add" ).text(valor - 1);
				}
				toastr.info("Quitado exitosamente");
				console.log(usr + "(remove) - " +data);
            });
       	}
    });
    $("#exportar").click(function(e){
    	e.preventDefault();
    	$('#exportar_modal').modal('show');
    });

  $('[data-toggle="popover"]').popover({ html : true });; 


});
