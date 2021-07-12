$(document).ready(function(){
	if($('input:radio[name=pago]:checked').val() == 0){
		$("#oc").attr('disabled', false);
		$("#ccosto").attr('disabled', false);
		$("#ciudadch").attr('disabled', false);
		$("#valor_examen").attr('disabled', false);
		//$("#indice_ganancia").attr('disabled', false);
	}else if($('input:radio[name=pago]:checked').val() == 1){
		$("#oc").attr('disabled', true);
		$("#ccosto").attr('disabled', true);
		$("#ciudadch").attr('disabled', true);
		$("#valor_examen").attr('disabled', true);
		//$("#indice_ganancia").attr('disabled', true);
	}

	$("input[type='radio']").click(function(){
		if($('input:radio[name=pago]:checked').val() == 0){
			$("#oc").attr('disabled', false);
			$("#ccosto").attr('disabled', false);
			$("#ciudadch").attr('disabled', false);
			$("#valor_examen").attr('disabled', false);
			//$("#indice_ganancia").attr('disabled', false);
		}else if($('input:radio[name=pago]:checked').val() == 1){
			$("#oc").attr('disabled', true);
			$("#ccosto").attr('disabled', true);
			$("#ciudadch").attr('disabled', true);
			$("#valor_examen").attr('disabled', true);
			//$("#indice_ganancia").attr('disabled', true);
		}
    });
});