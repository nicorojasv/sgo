<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-1" style="align:center">
				<img src="<?php echo base_url().$this->session->userdata('imagen_barra'); ?>" style="width:80px; height:80px">
			</div>
			<div class="col-md-6" style="align:center">
				<h3><b><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno, 'UTF-8')) ?></b></h3>
				<h5>Trabajador</h5>
				<p class="contact_tags">
					<?php
						if($usuario->fecha_actualizacion == "0000-00-00")
							$actualizacion = "No se ha actualizado el perfil";
						else{
							 $act = explode("-",$usuario->fecha_actualizacion);
							$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
						}
					?>
					<span>Ultima actualización: <?php echo $actualizacion ?></span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h4>I. Evaluaciones de Despempeño</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Evaluación</th>
							<th>Nota</th>
							<th>Recomendado</th>
							<th>Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php if($le){ ?>
						<?php foreach ($le as $e) { ?>
							<tr class="odd gradeX">
								<td><b><?php echo $e['nombre'] ?></b></td>
								<td><b><?php echo $e['promedio'] ?></b></td>
								<td><b><?php echo $e['porcentaje'] ?></b></td>
								<td><b>Detalles</b></td>
							</tr>
							<?php foreach ($e['sub'] as $s) { ?>
								<tr class="odd gradeX">
									<td><?php echo $s['nombre'] ?></td>
									<td><?php echo $s['nota'] ?></td>
									<td><?php echo ($s['recomienda'] == 1)?'Si':'No'; ?></td>
									<td><?php echo $s['comentario'] ?></td>
								</tr>
							<?php } ?>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br><br>
				<h4>II. Evaluaciones de Conocimiento</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Evaluación</th>
							<th>Nota</th>
							<th>Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php if($evaluaciones){ ?>
						<?php foreach ($evaluaciones as $e) { ?>
							<?php if ($e->nombre_tipo == "CONOCIMIENTO"){ ?>
							<tr class="odd gradeX">
								<?php $fecha_cono = explode("-",$e->fecha_e); ?>
								<?php $fecha_cono = $fecha_cono[2]."-".$fecha_cono[1]."-".$fecha_cono[0]; ?>
								<td>
									<?php echo $fecha_cono." ".$e->nombre_eval ?>
								</td>
								<td><?php echo $e->resultado ?></td>
								<td><?php echo $e->observaciones ?></td>
							</tr>
							<?php } ?>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br><br>
				<h4>III. Evaluaciones Médicas</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Evaluación</th>
							<th>Vigencia</th>
							<th>Resultado</th>
							<th>Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php if($evaluaciones){ ?>
						<?php foreach ($evaluaciones as $e) { ?>
							<?php if ($e->nombre_tipo == "MEDICA"){ ?>
							<tr class="odd gradeX">
								<?php $fecha_med = explode("-",$e->fecha_e); ?>
								<?php $fecha_med = $fecha_med[2]."-".$fecha_med[1]."-".$fecha_med[0]; ?>
								<td>
									<?php echo $fecha_med." ".$e->nombre_eval ?>
								</td>
								<td>
									<?php $fecha_v = explode("-",$e->fecha_v); ?>
									<?php $fecha_v = $fecha_v[2]."-".$fecha_v[1]."-".$fecha_v[0]; ?>
									<?php echo $fecha_v ?>
								</td>
								<td>
									<?php 
									if($e->resultado == 0) $res = "Sin Contraindicaciones";
									if($e->resultado == 1) $res = "Con Contraindicaciones";
									echo $res;
									?>
								</td>
								<td><?php echo $e->observaciones ?></td>
							</tr>
							<?php } ?>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br><br>
				<h4>IV. Evaluaciones Seguridad</h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Evaluación</th>
							<th>Vigencia</th>
							<th>Resultado</th>
							<th>Comentarios</th>
						</tr>
					</thead>
					<tbody>
						<?php if($evaluaciones){ ?>
						<?php foreach ($evaluaciones as $e) { ?>
							<?php if ($e->nombre_tipo == "SEGURIDAD"){ ?>
							<tr class="odd gradeX">
								<?php $fecha_seg = explode("-",$e->fecha_e); ?>
								<?php $fecha_seg = $fecha_seg[2]."-".$fecha_seg[1]."-".$fecha_seg[0]; ?>
								<td>
									<?php echo $fecha_seg." ".$e->nombre_eval ?>
								</td>
								<td>
									<?php $fecha_v = explode("-",$e->fecha_v); ?>
									<?php $fecha_v = $fecha_v[2]."-".$fecha_v[1]."-".$fecha_v[0]; ?>
									<?php echo $fecha_v ?>
								</td>
								<td>
									<?php 
									if($e->resultado == 0) $res = "Aprobado";
									if($e->resultado == 1) $res = "Rechazado";
									echo $res;
									?>
								</td>
								<td><?php echo $e->observaciones ?></td>
							</tr>
							<?php } ?>
						<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<br><br><br>
	</div>
</div>