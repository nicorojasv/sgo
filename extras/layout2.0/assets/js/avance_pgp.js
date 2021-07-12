function progressBar(percent, element) {
	var progressBarWidth = percent * element.width() / 100;
	element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
}

progressBar($("#porcentaje_total").text(), $('.progressBar1'));
progressBar($("#porcentaje_contactados").text(), $('.progressBar2'));
progressBar($("#porcentaje_disponibilidad").text(), $('.progressBar3'));
progressBar($("#porcentaje_certificacion").text(), $('.progressBar4'));
progressBar($("#porcentaje_examenes").text(), $('.progressBar5'));
progressBar($("#porcentaje_masso").text(), $('.progressBar6'));
progressBar($("#porcentaje_contratos").text(), $('.progressBar7'));
progressBar($("#porcentaje_planta").text(), $('.progressBar8'));