<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Envio de Publicaci&oacute;n</h4>
	</div>
	<div class="panel-body">
		<div class="col-sm-12">
			<?php if($tipo_usuario == "trabajador"){ ?>
				<form action="<?php echo base_url() ?>noticias/enviar_publicacion_trabajador" enctype="multipart/form-data" method="post">
			<?php } ?>
			<?php if($tipo_usuario == "requerimiento"){ ?>
				<form action="<?php echo base_url() ?>noticias/enviar_publicacion_requerimientos" enctype="multipart/form-data" method="post">
			<?php } ?>
			<?php if($tipo_usuario == "especialidad"){ ?>
				<form action="<?php echo base_url() ?>noticias/enviar_publicacion_especialidad" enctype="multipart/form-data" method="post">
			<?php } ?>
			<div class="form-group">
				<label>
					<b><u>Detalle de Publicaci&oacute;n:</u></b>
				</label>
				<div class="row">
					<div class="col-sm-12">
						<label>
						<?php foreach ($noticia as $row){ ?>
							<div class="row">
								<div class="col-sm-2">
									<b>Titulo:</b>
								</div>
								<div class="col-sm-10">
									<b><?php echo $row->titulo ?></b>
								</div>
								<div class="col-sm-2">
									<b>Fecha:</b>
								</div>
								<div class="col-sm-10">
									<b><?php echo $row->fecha ?></b>
								</div>
								<div class="col-sm-2">
									<b>Descripcion Titulo:</b>
								</div>
								<div class="col-sm-10">
									<?php echo $row->desc_noticia ?>
								</div>
							</div>
						<?php } ?>
						<br>
						<?php foreach ($adjuntos_noticia as $row2){ ?>
							<div class="row">
								<div class="col-sm-2">
									<b>Archivo Adjunto:</b>
								</div>
								<div class="col-sm-10">
									<b><a href="<?php echo base_url() ?><?php echo $row2->url; ?>" target="_blank"><i class="fa fa-search"></i></a></b>
								</div>
							</div>
						<?php } ?>
					</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>
					Usuarios: 
				</label>
				<div class="row">
					<div class="col-sm-4">
						<input type="radio" class="envio_noticia" name="usuario" id="usuario" onclick="javacript: document.getElementById('tipo_usuario').value = 'requerimiento' " <?php if($tipo_usuario == "requerimiento") echo "checked" ?> > Por Requerimientos
					</div>
					<div class="col-sm-4">
						<input type="radio" class="envio_noticia" name="usuario" id="usuario" onclick="javacript: document.getElementById('tipo_usuario').value = 'especialidad' " <?php if($tipo_usuario == "especialidad") echo "checked" ?> > Por Especialidad
					</div>
					<div class="col-sm-4">
						<input type="radio" class="envio_noticia" name="usuario" id="usuario" onclick="javacript: document.getElementById('tipo_usuario').value = 'trabajador' " <?php if($tipo_usuario == "trabajador") echo "checked" ?> > Por Trabajador
					</div>
			        <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="<?php echo $tipo_usuario ?>">
			        <input type="hidden" name="id_noticia" id="id_noticia" value="<?php echo $id_noticia ?>">
				</div>
			</div>
			<?php if($tipo_usuario == "trabajador"){ ?>
				<!-- Div por Trabajador -->
				<div class="row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10">
						<table id="example1">
							<thead>
								<tr>
									<th>/</th>
				    				<th style="text-align:center">Seleccionar<br><input type="checkbox" onchange="togglecheckboxes(this,'seleccionar_usuario[]')"></th>
									<th>Rut</th>
									<th>Nombre</th>
									<th>Apellido Paterno</th>
									<th>Apellido Materno</th>
									<th>Especialidad</th>
									<th>Fecha Actualizacion</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 0; foreach ($trabajadores as $r){ $i += 1; ?>
								<tr class="odd gradeX">
									<td><?php echo $i ?></td>
									<td style="text-align:center"><input type="checkbox" name="seleccionar_usuario[]" value="<?php echo $r->id_usuario ?>"></td>
									<td><?php echo $r->rut_usuario ?></td>
									<td><?php echo $r->nombre ?></td>
									<td><?php echo $r->ap_paterno ?></td>
									<td><?php echo $r->ap_materno ?></td>
									<td><?php echo $r->especialidad ?> <?php if(!$r->especialidad2){}else echo " / ".$r->especialidad2 ?> <?php if(!$r->especialidad3){}else echo " / ".$r->especialidad3 ?></td>
									<td><?php echo $r->fecha_actualizacion ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<br><br>
				</div>
			<?php } ?>
			<?php if($tipo_usuario == "requerimiento"){ ?>
				<!-- Div por Requerimientos -->
				<div class="row">
					<div class="col-sm-12">
						<table id="example2">
							<thead>
								<tr>
									<th>/</th>
				    				<th style="text-align:center">Seleccionar<br><input type="checkbox" onchange="togglecheckboxes2(this,'seleccionar_req[]')"></th>
									<th>Nombre</th>
									<th>Solicitud</th>
									<th>Planta</th>
									<th>Regimen</th>
									<th>Inicio</th>
									<th>Fin</th>
									<th>Causal</th>
									<th>Motivo</th>
									<th>Dotaci&oacute;n</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 0; foreach ($requerimientos as $r){ $i += 1; ?>
								<tr class="odd gradeX">
									<td><?php echo $i ?></td>
									<td style="text-align:center"><input type="checkbox" name="seleccionar_req[]" value="<?php echo $r->id ?>"></td>
									<td><?php echo $r->nombre ?></td>
									<td><?php echo $r->f_solicitud; ?></td>
									<td><?php echo $r->planta ?></td>
									<td><?php echo $r->regimen ?></td>
									<td><?php echo $r->f_inicio; ?></td>
									<td><?php echo $r->f_fin; ?></td>
									<td><?php echo $r->causal; ?></td>
									<td><?php echo $r->motivo; ?></td>
									<td><?php echo $r->dotacion; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<br><br>
				</div>
			<?php } ?>
			<?php if($tipo_usuario == "especialidad"){ ?>
				<!-- Div por Especialidad-->
				<div class="row">
					<br>
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						<table id="example2">
							<thead>
								<tr>
									<th>/</th>
				    				<th style="text-align:center">Seleccionar<br><input type="checkbox" onchange="togglecheckboxes3(this,'seleccionar_espec[]')"></th>
									<th>Nombre</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 0; foreach ($especialidades as $r){ $i += 1; ?>
								<tr class="odd gradeX">
									<td><?php echo $i ?></td>
									<td style="text-align:center"><input type="checkbox" name="seleccionar_espec[]" value="<?php echo $r->id ?>"></td>
									<td><?php echo $r->desc_especialidad ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<br><br>
				</div>
			<?php } ?>
			<div class="form-group">
				<br>
				<div class="col-sm-9"></div>
				<div class="col-sm-2">
					<input type="submit" class="form-control btn btn-primary" value="Procesar Envio">
				</div><br><br>
			</div>
			</form>
		</div>
	</div>
</div>