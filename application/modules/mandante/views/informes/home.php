<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
	        <div class="col-md-11" align="rigth">
				<h4><b>REQUERIMIENTOS: </b> <?php echo $empresa_planta->nombre ?></h4>
	        </div>
	        <div class="col-md-1" align="center">
	        	<br>
				<a href="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $id_planta ?>"><i class="fa fa-reply"><br><b>Volver a Trazabilidad</b></i></a>
	        </div>
	     </div>
		<table id="sample_1">
			<thead>
				<th class="center">Nombre</th>
				<th class="center">Regimen</th>
				<th class="center">Fecha Inicio</th>
				<th class="center">Fecha Fin</th>
				<th class="center">Dotación</th>
				<th class="center">Ver Detalle</th>
				<!--<th class="center">Reportabilidad</th>
				<th class="center">Indicadores</th>-->
			</thead>
			<tbody>
				<?php foreach ($requerimientos as $r) { ?>
					<tr>
						<?php $regimen = ($r->regimen == 'NL') ? 'Regimen Normal' : 'Regimen PGP' ?>
						<td><?php echo ucwords(mb_strtolower($r->nombre,'UTF-8')) ?></td>
						<td><?php echo $regimen; ?></td>
						<td class="center"><?php echo $r->f_inicio ?></td>
						<td class="center"><?php echo $r->f_fin ?></td>
						<td class="center"><?php echo $r->dot ?></td>
						<!--<td class="center"><a style="color:green" href="#"><i class="fa fa-external-link"></i></a></td>-->
						<td class="center"><a style="color:green" href="<?php echo base_url() ?>mandante/planilla_pgp/<?php echo $r->id ?>/<?php echo $id_planta ?>"><i class="fa fa-external-link"></i></a></td>
						<!--<td class="center"><a style="color:green" href="<?php echo base_url() ?>mandante/planilla_pgp/<?php echo $r->id ?>"><i class="fa fa-external-link"></i></a></td>
						<td class="center"><a href="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $r->id ?>"><i class="fa fa-file-text"></i></a></td>
						<td class="center"><a class="tooltipp" title="<?php echo $tooltip; ?>" style="color:green" href="<?php echo base_url() ?>mandante/avance_pgp/<?php echo $r->id ?>"><i class="fa fa-bar-chart-o"></i></a></td>-->
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<ul style=''>
			
			</ul>
	</div>
</div>