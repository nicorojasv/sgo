
/*
$(document).ready(function() {
	$('.envioSolicitud').click(function(){
		$('#blw').empty();
  		$("#blw").append(' <input type="submit" id="aceptar" value="GUARDANDOs..." disabled > </input>').hide().fadeIn(1);
	});
});*/
function bloqEnvio(){
	if (document.getElementById('btnEviarRevision')) {
	$('#blw').empty();
  	$("#blw").append(' <input  name="envio_solicitud_contrato" id="aceptar" class="btn btn-green""  value="Enviando..."  > </input>').hide().fadeIn(1);
  }
  	return true;
}

function bloqEnvioMasivo(){
	$('#aprobasionMasiva').attr("disabled", true);
return true;
}

$( "#foo" ).one( "click", function() {
  $(".aValidar").attr("href", "javascript: void(0);" ); 
});