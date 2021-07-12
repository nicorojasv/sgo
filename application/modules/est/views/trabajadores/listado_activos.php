<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores</h4>
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
		<div class="col-md-9">
			Activos: <span class='badge' style='background-color:#3E9610'>A</span> Inactivos: <span class='badge' style='background-color:#DAAA08'>I</span>
		</div>
		<div class="col-md-2">
			<!--<a href="<?php echo  base_url() ?>usuarios/perfil/crear" class="btn btn-blue btn-block">Agregar</a>-->
		</div>
		<br><br><br>
		<?php if( count($listado) > 0){ ?>
  		<form action="<?php echo base_url() ?>est/trabajadores/cambiar_estados_trabajadores" role="form" id="form" method='post' autocomplete="off">
			<div class="row">
	  		    <div class="col-md-1"></div>
	      		<div class="col-md-10">
					<table id="example1">
						<thead>
							<tr>
								<th>Rut</th>
								<th>Nombre</th>
								<th>Apellido Paterno</th>
								<th>Apellido Materno</th>
								<th>Especialidad</th>
								<th>Fecha Actualizacion</th>
								<th>Masso</th>
								<th>Examen Preo</th>
								<th style="text-align:center">Activo</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($listado as $r){ ?>
							<tr class="odd gradeX">
								<td><?php echo $r->rut_usuario ?></td>
								<td><?php echo $r->nombre ?></td>
								<td><?php echo $r->ap_paterno ?></td>
								<td><?php echo $r->ap_materno ?></td>
								<td><?php echo $r->especialidad ?> <?php if(!$r->especialidad2){}else echo " / ".$r->especialidad2 ?> <?php if(!$r->especialidad3){}else echo " / ".$r->especialidad3 ?></td>
								<td><?php echo $r->fecha_actualizacion ?></td>
			                    <td><a style='color:<?php echo $r->color_masso ?>'><?php echo $r->masso ?></a></td>
			                    <td><a style='color:<?php echo $r->color_preo ?>'><?php echo $r->examen_pre ?></a></td>
								<td style="text-align:center">
									<input type="hidden" name="usuarios[]" value="<?php echo $r->id_usuario ?>">
									<input type="checkbox" name="check_estado[]" value="<?php echo $r->id_usuario ?>" <?php echo ($r->estado)?"checked='checked'":""; ?> > <?php echo ($r->estado)?"<span class='badge' style='background-color:#3E9610'>A</span>":"<span class='badge' style='background-color:#DAAA08'>I</span>"; ?>
								</td>
								<td style="width:47px;">
									<a title="Editar" class="editar" href="<?php echo base_url() ?>usuarios/perfil/trabajador_est/<?php echo $r->id_usuario ?>" target="_blank"><i class="fa fa-pencil fa-fw"></i></a>
									<a title="Eliminar" class="eliminar" href="<?php echo base_url() ?>est/trabajadores/eliminar_trabajador_listado/<?php echo $r->id_usuario ?>"><i class="fa fa-trash-o"></i></a>
									<?php echo ($r->estado_usu_req)?"<i style='color:green' class='fa fa-flag' title='".$r->nombre_requerimiento."'></i>":""; ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
	    	</div>
			<div class="row">
	  		    <div class="col-md-8"></div>
	      		<div class="col-md-3">
	      			<button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo de los Trabajadores">
						Guardar Estados Trabajadores
					</button>
	      		</div>
	    	</div>
	    </form>
		<?php } else{ ?>
		<p>No existen trabajadores.</p>
		<?php } ?>
	</div>
</div>