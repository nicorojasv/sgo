$(document).ready(function() {
    $(".botonExcelArauco").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
	});
});

$(document).ready(function () {
  $('#datepickerAraucoSCompletas').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"est/contratos/solicitudes_completas/0/"+fecha_seleccionada;
      });
});

function historico(){
   location.href=base_url+"est/contratos/solicitudes_completas/1/historico";
}

$(document).ready(function () {
  $('#datepickerAraucoAdministrador').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"est/requerimiento/solicitudes_completas/"+fecha_seleccionada;
      });
});
function historicoAdministrador(){
   location.href=base_url+"est/requerimiento/solicitudes_completas/historico";
}

/*
$(document).ready(function() {
    $(".botonExcelEnjoyBono").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_Excel_Bono").eq(0).clone()).html());
        $("#FormularioExportacionBono").submit();
	});
});

$(document).ready(function() {
    $(".botonExcelEnjoyAsistencia").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_Excel_Asistencia").eq(0).clone()).html());
        $("#FormularioExportacionAsistencia").submit();
	});
});

$(document).ready(function () {
  $('#datepickerEnjoySCompletas').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"enjoy/contratos/solicitudes_completas/"+fecha_seleccionada;
      });
});

function historico(){
   location.href=base_url+"enjoy/contratos/solicitudes_completas/historico";
}

$(document).ready(function() {/*20-09-2018 g.r.m  * /
    $(".botonExcelEnjoyTrabajadores").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
  });
});*/