$(document).ready(function () {
	$(".planta1").click( function() {
 		usuario = ($('input:hidden[name=usuario]').val());
 		location.href=base_url+"est/trabajadores/gestion_usuarios/"+usuario;
 	});
});