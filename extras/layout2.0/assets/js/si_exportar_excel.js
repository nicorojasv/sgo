$("[id$=myButtonControlID]").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=divTableDataHolder]').html()));
    e.preventDefault();
});
$(document).ready(function() {
    $(".btnExportarDT").click(function(event) {
    	
        $("#datos_a_enviar2").val( $("<div>").append( $("#Exportar_a_Excel2").eq(0).clone()).html());
        $("form#FormularioExportacion2").submit();
    
	});
});