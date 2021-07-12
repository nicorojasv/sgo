<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
	        <div class="col-md-10" align="rigth">
	        	<h5><b>Requerimiento:</b> <?php echo $requerimiento->nombre ?></h5>
	        	<h5><b>Regimen:</b> <?php echo $requerimiento->regimen ?> - <b>Causal:</b> <?php echo $requerimiento->causal ?></h5>
	        	<h5><b>Motivo:</b> <?php echo $requerimiento->motivo ?></h5>
				<h5><b>Fecha Solicitud:</b> <?php echo $requerimiento->f_solicitud ?> - <b>Fecha Inicio:</b> <?php echo $requerimiento->f_inicio ?> - <b>Fecha Fin:</b> <?php echo $requerimiento->f_fin ?></h5>
	        </div>
	        <div class="col-md-1" style="text-align:center">
				<a href="<?php echo base_url() ?>mandante/detalle_requerimientos/<?php echo $id_planta ?>"><i class="fa fa-reply"><br><b>Volver a Requerimientos</b></i></a><br>
				<a href='<?php echo base_url() ?>mandante/evaluar_pgp/<?php echo $requerimiento->id ?>/<?php echo $id_planta ?>' class='btn btn-blue' style='float:right;'>Evaluar</a><br/>
	        </div>
	     </div>
		<br class='clear'/>
		<br/>
		<div class="row">
	        <div class="col-md-2"></div>
	        <div class="col-md-8">
				<table id="example1">
					<thead>
						<tr style="text-align:center">
							<td>N°</td>
							<td>Area</td>
							<td>Cargo</td>
							<td>Cantidad</td>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; foreach ($area_cargos_requerimiento as $ar_car){ $i+=1; ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $ar_car->nombre_area; ?></td>
							<td><?php echo $ar_car->nombre_cargo; ?></td>
							<td style="text-align:center">
								<a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>mandante/detalle_pgp/<?php echo $ar_car->id ?>/<?php echo $id ?>/<?php echo $id_planta ?>'>
									<?php echo $ar_car->asignadas ?>/<?php echo $ar_car->cantidad ?>
								</a>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>