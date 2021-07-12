$(document).ready(function() {
    $(".botonExcelEnjoy").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
	});
});

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

$(document).ready(function() {/*20-09-2018 g.r.m  */
    $(".botonExcelEnjoyTrabajadores").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
  });
});

//Requerimientos enjoy
$(document).ready(function () {
  $('#datepickerEnjoyRequerimientos').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"enjoy/requerimientos/listado/"+fecha_seleccionada;
      });
});
function historicoRequerimiento(){
   location.href=base_url+"enjoy/requerimientos/listado/historico";
}

//Listado de bajas
$(document).ready(function () {
  $('#datepickerEnjoyBajadas').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"enjoy/contratos/solicitudes_completas_baja/"+fecha_seleccionada;
      });
});

function historicoBajas(){
   location.href=base_url+"enjoy/contratos/solicitudes_completas_baja/historico";
}