$(document).ready(function () {
  	var empresa = ($('input:hidden[name=id_empresa]').val());
	var	fecha = ($('input:radio[name=ano_consolidad]').val());

	$(".ano_consolidad").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_consolidad]').val());
	  	location.href=base_url+"mandante/reportabilidad/"+empresa+"/"+fecha;
	});

	$(".ano_consolidad2").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_consolidad2]').val());
	  	location.href=base_url+"mandante/reportabilidad/"+empresa+"/"+fecha;
	});

	$(".ano_consolida2").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_consolida2]').val());
	  	location.href=base_url+"mandante/reportabilidad/"+empresa+"/"+fecha;
	});

	$(".ano_consolida3").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_consolida3]').val());
	  	location.href=base_url+"mandante/reportabilidad/"+empresa+"/"+fecha;
	});


	$(".ano_consolidad3").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_consolidad3]').val());
	  	location.href=base_url+"mandante/reporte_causales/"+empresa+"/"+fecha;
	});

	$(".ano_consolidad4").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_consolidad4]').val());
	  	location.href=base_url+"mandante/reporte_causales/"+empresa+"/"+fecha;
	});
	
	$(".ano_causales2018").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_causales2018]').val());
	  	location.href=base_url+"mandante/reporte_causales/"+empresa+"/"+fecha;
	});

	$(".ano_causales2019").click( function() {
		empresa = ($('input:hidden[name=id_empresa]').val());
		fecha = ($('input:radio[name=ano_causales2019]').val());
	  	location.href=base_url+"mandante/reporte_causales/"+empresa+"/"+fecha;
	});

});