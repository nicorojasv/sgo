<div class="panel panel-white">
	<div class="panel-body">
		<div id="contact_profile" class="col-md-12">
			<table class="table table-striped">
				<tbody>
					<tr>
						<td class="td_avatar">
							<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
								<img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" class="avatar" alt="Imagen Perfil">
							</a> 
						</td>
						<td class="td_info"><h1 class="contact_name"><?php echo ucwords(mb_strtolower($usuario -> nombres . ' ' . $usuario -> paterno . ' ' . $usuario -> materno,"UTF-8"));?></h1>
						<p class="contact_company">
							<?php if($this -> session -> userdata('tipo') == 3) $url = base_url().'administracion/trabajadores/buscar'; else $url = 'javascript:;'; ?>
							<?php echo ucwords(mb_strtolower($tipo_usuario->desc_tipo_usuarios,"UTF-8")); ?>
						</p>
						<p class="contact_tags">
							<?php if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No se ha actualizado el perfil";
								else{
									 $act = explode("-",$usuario->fecha_actualizacion);
									$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
								} ?>
							<span>Ultima actualizacion: <?php echo $actualizacion ?></span>
						</p></td>
					</tr>
				</tbody>
			</table>
			<hr>
			<h2>I. Evaluaciones de Despempeño</h2>
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="width:550px">Nombre Evaluación</th>
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
			<br>
			<h2>II. Evaluaciones de Conocimiento</h2>
			<table class="table table-striped">
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
			<br />
		</div>
		<div id="contact_profile" class="col-md-12">
			<h2>III. Evaluaciones Médicas</h2>
			<table class="table table-striped">
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
		<div id="archivos" class="col-md-12">
			<h2>IV. Evaluaciones Seguridad</h2>
			<table class="table table-striped">
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
</div>