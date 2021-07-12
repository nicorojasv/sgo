 <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>extras/css/tooltipster.css" />
 <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>extras/css/themes/tooltipster-light.css" />

<h3 style='text-align:center;float:left;'>Regimen Normal - Pulpa L2</h3>
<?php 
$tooltip = "<div style='border: 1px solid black;padding-top:20px;padding-bottom:20px;padding-left:10px; padding-right:10px;width:550px;font-size:10px;'>
	<div class='pgp-left' style='float:left' >
		<div class='pgp-title'>PGP XXXXX año XXXX</div>
		<div class='pgp-subtitle'><small>Periodo xx/xx/xxxx al xx/xx/xxxx</small></div>
	</div>
	<div class='pgp-center' style='float:left; margin-left:10px' >
		<span class='' style='float:left'>Dotaci&oacute;n: 20</span>
		<div class='progressBar' style='margin-left:10px;float:left;width: 90px;'><div></div></div>
	</div>
	<div class='pgp-right' style='float:right' >
		<div class=''><span class='circulito verde'></span>En Servicio: 9 <span class='circulito rojo'></span>En Proceso: 11</div>
	</div>
	<div class='clear'></div>
</div>
<script type='text/javascript'>
function progressBar(percent, element) {
var progressBarWidth = percent * element.width() / 100;
element.find('div').animate({ width: progressBarWidth }, 500).html(percent + '%&nbsp;');
}
</script>

<script>
progressBar(20, $('.progressBar'));
</script>";
?>
<a href='<?php echo base_url() ?>mandante/evaluar_pgp2' class='btn btn-info' style='float:right;'>Evaluar</a><br/>
<br/>
<a href="<?php echo base_url() ?>mandante/avance_pgp2" class="tooltipp" style='float:right;' title="<?php echo $tooltip; ?>">Indicadores</a>
<br  class='clear'/>
<br />
<table style="width:100%" class='table table-condensed'>
	<thead>
		<!--<tr>
			<th></th>
			<th></th>
			<th></th>
			<th colspan="8" style='border:1px solid black;text-align:center;'>Area que lo Requiere</th>
			<th></th>
		</tr> -->
		<tr style="background-color:#D7D7D7;color:black;">
			<th style='text-align:center;padding:3px;'>Especialidad</th>
			<th style='text-align:center;padding:3px;'>Det. y pta e/s</th>
			<th style='text-align:center;padding:3px;'>Maderas</th>
			<th style='text-align:center;padding:3px;'>Pulpa</th>
			<th style='text-align:center;padding:3px;'>Secado</th>
			<th style='text-align:center;padding:3px;'>P. Termica</th>
			<th style='text-align:center;padding:3px;'>Evap. Gen</th>
			<th style='text-align:center;padding:3px;'>Caustificaci&oacute;n</th>
			<th style='text-align:center;padding:3px;'>Maestranza</th>
			<th style='text-align:center;padding:3px;'>Turno mant</th>
			<th style='text-align:center;padding:3px;'>Total</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style=''><b>Mec&aacute;nicos</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Mec&aacute;nicos pre pta e/s</b></td>
			<td style='text-align:center;'>2/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'><a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>mandante/detalle_pgp2'>6/6</a></td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Lubricadores</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Pañoleros</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Pañoleros Pañol Lubric.</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Caldereros</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Soldadores Mixtos</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Cald. Area</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Sold. Area</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Electricistas Arear</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Elec. Taller</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>DCS (Controlista)</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Instrumentistas Areas</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Tec. Instrum. Taller</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr>
			<td style=''><b>Ayudante Alineador</b></td>
			<td style='text-align:center;'>0/2</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
			<td style='text-align:center;'>0/0</td>
		</tr>
		<tr style="border-bottom:1px solid #DDD">
			<td style=';'><b>TOTAL</b></td>
			<td style='text-align:center;'><b>0/2</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
			<td style='text-align:center;'><b>0/0</b></td>
		</tr<
	</tbody>
</table>