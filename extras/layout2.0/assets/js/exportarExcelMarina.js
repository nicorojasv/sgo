$(document).ready(function() {
    $(".botonExcelmarina").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
	});
});

$(document).ready(function() {
    $(".botonExcelmarinaBono").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_Excel_Bono").eq(0).clone()).html());
        $("#FormularioExportacionBono").submit();
	});
});

$(document).ready(function() {
    $(".botonExcelmarinaAsistencia").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_Excel_Asistencia").eq(0).clone()).html());
        $("#FormularioExportacionAsistencia").submit();
	});
});

$(document).ready(function () {
  $('#datepickermarinaSCompletas').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"marina/contratos/solicitudes_completas/"+fecha_seleccionada;
      });
});

function historico(){
   location.href=base_url+"marina/contratos/solicitudes_completas/historico";
}

$(document).ready(function() {/*20-09-2018 g.r.m  */
    $(".botonExcelmarinaTrabajadores").click(function(event) {
        $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
        $("#FormularioExportacion").submit();
  });
});
//Requerimientos MArina
$(document).ready(function () {
  $('#datepickerMarinaRequerimientos').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"marina/requerimientos/listado/"+fecha_seleccionada;
      });
});
function historicoRequerimiento(){
   location.href=base_url+"marina/requerimientos/listado/historico";
}
//Listado de bajas
$(document).ready(function () {
  $('#datepickerMarinaBajadas').datepicker({
    format: 'yyyy-mm',
    startView: "months", 
    minViewMode: "months",
    language: 'ES',
  }).on('changeDate', function(ev) {
      fecha_seleccionada = $(this).val();
      location.href=base_url+"marina/contratos/solicitudes_completas_baja/"+fecha_seleccionada;
      });
});

function historicoBajas(){
   location.href=base_url+"marina/contratos/solicitudes_completas_baja/historico";
}