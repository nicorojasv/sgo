$(document).ready(function(){
	$('.summernote').summernote({
		airMode: true
	});
	$("select[name=select_publicaciones]").change(function(){
		if ( $(this).val() == 3 )
			$("#div_requerimiento").show();
	});
});