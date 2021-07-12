<div class="panel panel-white">
	<div class="panel-body">
		<h2><b>Requerimientos</b></h2>
		<table id="sample_1">
			<thead>
				<th class="center">Nombre</th>
				<th class="center">Regimen</th>
				<th class="center">Fecha Inicio</th>
				<th class="center">Fecha Fin</th>
				<th class="center">Dotación</th>
				<th class="center">Ver Detalle</th>
				<th class="center">Reportabilidad</th>
				<th class="center">Indicadores</th>
			</thead>
			<tbody>
				<?php foreach ($requerimientos as $r) { ?>
					<tr>
						<?php 
						$tooltip = "<div style='border: 1px solid black;padding-top:20px;padding-bottom:20px;padding-left:10px; padding-right:10px;width:550px;font-size:10px;'>
							<div class='pgp-left' style='float:left' >
								<div class='pgp-title'>".$r->nombre."</div>
								<div class='pgp-subtitle'><small>Periodo ".$r->f_inicio." al ".$r->f_fin."</small></div>
							</div>
							<div class='pgp-center' style='float:left; margin-left:10px' >
								<span class='' style='float:left'>Dotaci&oacute;n: ".$r->dot."</span>
								<div class='progressBar' style='margin-left:10px;float:left;width: 90px;'><div></div></div>
							</div>
							<div class='pgp-right' style='float:right' >
								<div class=''><span class='circulito verde'></span>En Servicio: ".$r->servicio." <span class='circulito rojo'></span>En Proceso: ".$r->proceso."</div>
							</div>
							<div class='clear'></div>
							<br/>
						</div>
						<script type='text/javascript'>
						function progressBar(percent, element) {
						var progressBarWidth = percent * element.width() / 100;
						element.find('div').animate({ width: progressBarWidth }, 500).html(percent + '%&nbsp;');
						}
						</script>

						<script>
						progressBar(".$r->porcentaje.", $('.progressBar'));
						</script>";
						?>
						<?php $regimen = ($r->regimen == 'NL') ? 'Regimen Normal' : 'Regimen PGP' ?>
						<td><?php echo ucwords(mb_strtolower($r->nombre,'UTF-8')) ?></td>
						<td><?php echo $regimen; ?></td>
						<td class="center"><?php echo $r->f_inicio ?></td>
						<td class="center"><?php echo $r->f_fin ?></td>
						<td class="center"><?php echo $r->dot ?></td>
						<td class="center"><a style="color:green" href="<?php echo base_url() ?>mandante/planilla_pgp/<?php echo $r->id ?>"><i class="fa fa-external-link"></i></a></td>
						<td class="center"><a href="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $r->id ?>"><i class="fa fa-file-text"></i></a></td>
						<td class="center"><a class="tooltipp" title="<?php echo $tooltip; ?>" style="color:green" href="<?php echo base_url() ?>mandante/avance_pgp/<?php echo $r->id ?>"><i class="fa fa-bar-chart-o"></i></a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul style=''>
			
			<!--<li><a style='color:#444444;' href="#">Regimen Normal - Caldera Recuperadora R1</a></li>
			<li><a style='color:#444444;' href="#">Regimen Normal - Pulpa L1</a></li>
			<li><a style='color:#444444;' href="<?php echo base_url() ?>mandante/planilla_pgp2">Regimen Normal - Pulpa L2</a></li>
			<li><a style='color:#444444;' href="<?php echo base_url() ?>mandante/planilla_pgp">Regimen PGP - Mayo 2015</a></li>-->
		</ul>
	</div>
</div>