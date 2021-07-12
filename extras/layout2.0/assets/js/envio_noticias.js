$(document).ready(function (){
	$(".envio_noticia").click( function(){
 		tipo_usuario = ($('input:hidden[name=tipo_usuario]').val());
 		id_noticia = ($('input:hidden[name=id_noticia]').val());
 		location.href=base_url+"noticias/envio_noticias/"+id_noticia+"/"+tipo_usuario;
 	});
});