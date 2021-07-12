$(document).ready(function() {
    $(".botonExcelaramark").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
	});
});

$(document).ready(function() {
    $(".botonExcelaramarkBono").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_Excel_Bono").eq(0).clone()).html());
        $("#FormularioExportacionBono").submit();
	});
});

$(document).ready(function() {
    $(".botonExcelaramarkAsistencia").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_Excel_Asistencia").eq(0).clone()).html());
        $("#FormularioExportacionAsistencia").submit();
	});
});

$(document).ready(function () {
  $('#datepickeraramarkSCompletas').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"aramark/contratos/solicitudes_completas/"+fecha_seleccionada;
      });
});

function historico(){
   location.href=base_url+"aramark/contratos/solicitudes_completas/historico";
}

$(document).ready(function() {/*20-09-2018 g.r.m  */
    $(".botonExcelaramarkTrabajadores").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
  });
});