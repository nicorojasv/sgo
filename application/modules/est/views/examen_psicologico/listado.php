<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores a Gestionar Examen Psicologico</h4>
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
		<div class="row">
	  		<div class="col-md-4" class="center">
				<span class='badge' style='background-color:#DAAA08'>P</span> Pendientes <span class='badge' style='background-color:#3E9610'>A</span> Aprobados <span class='badge' style='background-color:red'>D</span> Desaprobados
	  			<br><br>
	  		</div>
		</div>
		<div class="row">
	  		<div class="col-md-4">
	  			<label>Estado Trabajadores:</label>
	  			<select onChange="estado_examenes" name="milista" id="milista">
	  				<option value="pendientes" <?php if($estado == "pendientes") echo "selected"; ?> >Pendientes</option>
	  				<option value="aprobados" <?php if($estado == "aprobados") echo "selected"; ?> >Aprobados</option>
	  				<option value="desaprobados" <?php if($estado == "desaprobados") echo "selected"; ?> >Desaprobados</option>
	  			</select>
	  			<input type="hidden" name="estado" id="estado" value="<?php echo $estado ?>">
	  		</div>
		</div>
		<div class="row">
	  		<div class="col-md-12">
				<table id="example1">
					<thead>
						<tr>
							<th>/</th>
							<th>Rut</th>
							<th>Nombres</th>
							<th>Fono</th>
							<th>Residencia</th>
							<th>Referido</th>
							<th>Lugar de Trabajo</th>
							<th>Solicitante</th>
							<th>Psicologo/a</th>
							<th>Cargo Anterior</th>
							<th>Cargo Postulacion</th>
							<th>Tecnico/Supervisor</th>
							<th>Sueldo Definido</th>
							<th>Resultado</th>
							<th>Fecha Solicitud EST</th>
							<th>Fecha P. Psicologica</th>
							<th>Fecha Vigencia</th>
							<th>Observacion</th>
							<th>Herramientas</th>
							<th>Estados</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; foreach ($lista_aux as $row){ $i += 1; ?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $row->rut_usuario ?></td>
							<td><?php echo $row->nombres_usuario ?></td>
							<td><?php echo $row->fono ?></td>
							<td><?php echo $row->residencia ?></td>
							<td><?php if($row->referido == 1) echo "SI"; elseif($row->referido == 2) echo "NO"; ?></td>
							<td><?php echo $row->lugar_trabajo ?></td>
							<td><?php echo $row->solicitante ?></td>
							<td><?php echo $row->psicologo ?></td>
	  						<td><?php echo $row->especialidad1 ?> <?php if(!$row->especialidad2){}else echo " / ".$row->especialidad2 ?> <?php if(!$row->especialidad3){}else echo " / ".$row->especialidad3 ?></td>
							<td><?php echo $row->especialidad_post ?></td>
							<td><?php echo $row->tecnico_supervisor ?></td>
							<td><?php echo $row->sueldo_definido ?></td>
							<td><?php echo $row->resultado ?></td>
							<td><?php echo $row->fecha_solicitud ?></td>
							<td><?php echo $row->fecha_evaluacion ?></td>
							<td><?php echo $row->fecha_vigencia ?></td>
							<td><?php echo $row->observaciones ?></td>
							<td class="center">
								<a href="<?php echo base_url() ?>est/examen_psicologico/detalle/<?php echo $row->id_examen ?>"><i style="color:<?php echo $row->color_examen ?>" class="fa fa-book" aria-hidden="true"></i></a>
								<?php if($row->letra_estado == 'P' and $this->session->userdata('tipo_usuario') == 8){ ?>
								<a class="eliminar" href="<?php echo base_url() ?>est/examen_psicologico/eliminar_examen/<?php echo $row->id_examen ?>"><i class="fa fa-times fa fa-white" aria-hidden="true"></i></a>
								<?php } ?>
							</td>
							<td class="center"><span class='badge' style='background-color:<?php echo $row->color_estado ?>'><?php echo $row->letra_estado ?></span></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>