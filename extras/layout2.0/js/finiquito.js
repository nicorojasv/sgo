 
 	$(document).on('click', '.finiquitar', function() {
		$('.miFormulario').trigger("reset"); 
		console.log($(this).data('termino'))
		termino = $(this).data('termino')
		inicio = $(this).data('inicio')
		$( "#datepicker" ).datepicker( "destroy" );
		$("#datepicker").datepicker({ minDate:inicio, maxDate: termino  });
		$('#myModal').modal('show');
	});

	$.datepicker.regional['es'] = {
		 closeText: 'Cerrar',
		 prevText: '< Ant',
		 nextText: 'Sig >',
		 currentText: 'Hoy',
		 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
		 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
		 weekHeader: 'Sm',
		 //dateFormat: 'dd-mm-yy',
		 dateFormat: 'yy-mm-dd',
		 firstDay: 1,
		 isRTL: false,
		 showMonthAfterYear: false,
		 yearSuffix: ''
	};
	 $//("#datepicker").attr( 'readOnly' , 'true' );
	$.datepicker.setDefaults($.datepicker.regional['es']);

$(document).on('click', '.agregar-anotacion', function() {
	
});
