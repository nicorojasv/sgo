<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Trabajadores Ingresados para envio a Examen Psicologico</b></h2>
		<div class="panel-tools">
			<div class="dropdown">
				<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
					<i class="fa fa-cog"></i>
				</a>
				<ul class="dropdown-menu dropdown-light pull-right" role="menu">
					<li>
						<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
					</li>
					<li>
						<a class="panel-refresh" href="#">
							<i class="fa fa-refresh"></i> <span>Refresh</span>
						</a>
					</li>
					<li>
						<a class="panel-config" href="#panel-config" data-toggle="modal">
							<i class="fa fa-wrench"></i> <span>Configurations</span>
						</a>
					</li>
					<li>
						<a class="panel-expand" href="#">
							<i class="fa fa-expand"></i> <span>Fullscreen</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="panel-body">
  		<form action="<?php echo base_url() ?>est/trabajadores/enviar_solicitud_examen_psicologico" role="form" id="form" method='post' autocomplete="off">
			<div class="row">
				<div class="col-md-12">
					<table id="example1">
						<thead>
								<th>#</th>
								<th>Rut</th>
								<th>Nombre</th>
								<th>Telefono</th>
								<th>Ciudad</th>
								<th>Especialidad</th>
								<th>Fecha Nacimiento</th>
								<th>Referido</th>
								<th>Cargo Postulacion</th>
								<th>Tecnico/Supervisor</th>
								<th>Sueldo<br>Definido</th>
								<th>Lugar de Trabajo</th>
								<th>Enviar</th>
						</thead>
						<tbody>
							<?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
							<tr>
								<input type="hidden" name="usuarios[<?php echo $i ?>]" value="<?php echo $row->usuario_id ?>">
								<td><?php echo $i ?></td>
								<td><?php echo $row->rut ?></td>
								<td><?php echo $row->nombres ?></td>
								<td><?php echo $row->fono ?></td>
								<td><?php echo $row->desc_ciudades ?></td>
								<td><?php echo $row->especialidad1 ?> <?php if(!$row->especialidad2){}else echo " / ".$row->especialidad2 ?> <?php if(!$row->especialidad3){}else echo " / ".$row->especialidad3 ?></td>
								<td><?php echo $row->fecha_nac ?></td>
								<td>
									<select name="referido[<?php echo $i ?>]" id="referido[<?php echo $i ?>]" required>
										<option value="">[Seleccione]</option>
										<option value="1">Si</option>
										<option value="2">No</option>
									</select>
								</td>
								<td>
									<select name="cargo_postulacion[<?php echo $i ?>]" id="cargo_postulacion[<?php echo $i ?>]" style="width:90%" required>
										<option value="">[Seleccione]</option>
										<?php foreach ($r_cargos as $key2){ ?>
										<option value="<?php echo $key2->id ?>" ><?php echo $key2->nombre ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<select name="superv_tecnico[<?php echo $i ?>]" id="superv_tecnico[<?php echo $i ?>]" required>
										<option value="">[Seleccione]</option>
										<option value="1">Tecnico</option>
										<option value="2">Supervisor</option>
									</select>
								</td>
								<td><input type="text" class="input-mini" name="sueldo_definido[<?php echo $i ?>]" id="sueldo_definido[<?php echo $i ?>]" style="width:90%" value="0" required></td>
								<td>
									<select name="lugar_trabajo[<?php echo $i ?>]" id="lugar_trabajo[<?php echo $i ?>]" style="width:90%" required>
										<option value="">[Seleccione]</option>
										<?php foreach ($empresas_plantas as $key){ ?>
										<option value="<?php echo $key->id ?>" ><?php echo $key->nombre ?></option>
										<?php } ?>
									</select>
								</td>
								<td style="text-align:center">
									<input type="checkbox" name="check_estado[<?php echo $i ?>]" id="check_estado[<?php echo $i ?>]" value="<?php echo $row->usuario_id ?>" checked>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div><br>
			<div class="row">
	  		    <div class="col-md-10"></div>
	      		<div class="col-md-2">
	      			<button class="btn btn-green btn-block" type="submit" name="enviar" value="enviar" title="Enviar solicitudes de examenes psicologicos de los Trabajadores">
						Enviar Solicitudes
					</button>
	      		</div>
	    	</div><br><br>
    	</form>
	</div>
</div>