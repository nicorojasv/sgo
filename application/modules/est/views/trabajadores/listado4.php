<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Trabajadores ingresados</b><?php if($datos_req){ ?><span id="cont_add"> <?php echo $datos_req->agregados ?></span>/<?php echo $datos_req->cantidad; } ?></h2>
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
		<div class="row" >
			<div class="col-md-10" >
				<?php if($datos_req){ ?>
					<h4><b>Requerimiento: </b> <?php echo $datos_req->nombre ?> <b>Area: </b> <?php echo $datos_req->area ?> , <b>Cargo: </b> <?php echo $datos_req->cargo ?></h4>
				<?php } ?>
			</div>
			<div class="col-md-2" >
				<?php if($datos_req){ ?>
					<a href="#" class="btn btn-primary add_req">Agregar a Requerimiento</a>
				<?php } else{ ?>
				<a data-style="slide-right" class="btn btn-primary" href="<?php echo  base_url() ?>usuarios/perfil/crear/3">Agregar Trabajador</a>
				<?php } ?>
			</div>
		</div>
		<?php if(count($listado) > 0){ ?>
		<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
			<thead>
				<tr role="row">
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Telefono</th>
					<th>Ciudad</th>
					<th>Especialidad</th>
					<th class="uk-date-html">Masso</th>
					<th class="uk-date-html">Examen Preo</th>
					<th class="uk-date-column">Fecha Nacimiento</th>
					<th>Documentos</th>
					<th>Herramienta</th>
					<th>Eval</th>
					<th style="display:none"></th>
					<th style="display:none"></th>
					<th style="display:none"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($listado as $l){ ?>
				<tr>
					<td><input type="checkbox" name="edicion" value="<?php echo $l->id_user ?>" class="check_edit" /></td>
					<td><?php echo $l->rut_usuario ?></td>
					<td><a target="_blank" href="<?php echo base_url() ?>usuarios/perfil/listar_trabajador/<?php echo $l->id_user ?>"><?php echo $l->nombres ?></a></td>
					<td><?php echo $l->fono ?></td>
					<td><?php echo $l->desc_ciudades ?></td>
					<td><?php echo $l->especilidad1; ?> <br/>
						<?php echo $l->especilidad2; ?></td>
					<td id="masso_<?php echo $l->id_user ?>">
						<a target="_blank" href="<?php echo base_url() ?>est/evaluaciones/informe/<?php echo $l->id_user ?>" style="<?php 
						if($l->estado_masso == 'vigente'){ echo 'color:green'; }
					if($l->estado_masso == 'vencida'){ echo 'color:red'; }
					if($l->estado_masso == 'falta'){ echo 'color:#FF8000'; } ?>">
							<?php echo $l->masso ?>
						</a>
					</td>
					<td id="examen_<?php echo $l->id_user ?>">
						<a target="_blank" href="<?php echo base_url() ?>est/evaluaciones/informe/<?php echo $l->id_user ?>" style="<?php 
						if($l->estado_examen == 'vigente'){ echo 'color:green'; }
					if($l->estado_examen == 'vencida'){ echo 'color:red'; }
					if($l->estado_examen == 'falta'){ echo 'color:#FF8000'; } ?>">
							<?php echo $l->examen_pre ?>
						</a>
					</td>
					<td><?php echo $l->fecha_nacimiento ?></td>
					<td>
						<a target="_blank" style="<?php echo (@$l->cv)?'color:green':'color:red'; ?>" href="<?php echo (@$l->cv)?base_url().$l->cv[0]->url:'#'; ?>" >CV</a> - 
						<a target="_blank" style="<?php echo (@$l->afp)?'color:green':'color:red'; ?>" href="<?php echo (@$l->afp)?base_url().$l->afp[0]->url:'#'; ?>">AFP</a> - 
						<a target="_blank" style="<?php echo (@$l->salud)?'color:green':'color:red'; ?>" href="<?php echo (@$l->salud)?base_url().$l->salud[0]->url:'#'; ?>">SALUD</a> - 
						<a target="_blank" style="<?php echo (@$l->estudios)?'color:green':'color:red'; ?>" href="<?php echo (@$l->estudios)?base_url().$l->estudios[0]->url:'#'; ?>">ESTU</a>
					</td>
					<td>
						<a href="<?php echo base_url() ?>est/trabajadores/anotaciones/<?php echo $l->id_user ?>" target="_blank">
							<img src="<?php 
							if ($l->ln == 0 ) echo base_url().'extras/images/circle_green_16_ns.png';
							if ($l->ln == 1 ) echo base_url().'extras/images/circle_yellow_16_ns.png';
							if ($l->ln == 2 ) echo base_url().'extras/images/circle_red_16_ns.png';
							if ($l->ln == 3 ) echo base_url().'extras/images/circle_red-yellow_16.png';
							?>">
						</a>
						<?php if($l->requerimiento){?>
						<a style="color:red;" target="_blank" title="<?php echo $l->requerimiento->nombre ?>" href="<?php echo base_url().'est/requerimiento/usuarios_requerimiento/'.$l->requerimiento->id_area_cargo.'/'.$l->id_user ?>"><i class="fa fa-flag"></i></a>
						<?php }else{ ?>
							<i style="color:green;" class="fa fa-flag"></i>
						<?php } ?>
						<a href="<?php echo base_url() ?>est/evaluaciones/informe/<?php echo $l->id_user ?>" target="_blank">
							<i class="fa fa-eye"></i>
						</a>
						<a href="<?php echo base_url() ?>usuarios/perfil/trabajador_est/<?php echo $l->id_user ?>#datos-personales" target="_blank">
							<i class="fa fa-edit"></i>
						</a>
						<a href="<?php echo base_url() ?>est/trabajadores/desactivar/<?php echo $l->id_user ?>" class="desactivar_trabajador">
							<i class="fa fa-ban"></i>
						</a>
						<a href="<?php echo base_url() ?>est/trabajadores/eliminar_trabajador/<?php echo $l->id_user ?>" class="eliminar_trabajador2">
							<i class="fa fa-trash-o"></i>
						</a>
					</td>
					<td>
						<a data-usuario="<?php echo $l->id_user ?>" href="<?php echo base_url() ?>est/evaluaciones/listado_usuario/<?php echo $l->id_user ?>" class="sv-callback-list">
							<i class="fa fa-book"></i>
						</a>
					</td>
					<td style="display:none"><?php echo $l->especilidad1; ?></td>
					<td style="display:none"><?php echo $l->especilidad2; ?></td>
					<td style="display:none"><?php echo $l->especilidad3; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php echo $paginado ?>
		<?php } else{ ?>
			<p>No existen trabajadores agregados o asociados a la busqueda</p>
		<?php } ?>
	</div>
</div>
<!-- MODAL -->
<div class="modal hide" id="modal_nuevo" role="dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3 id="myModalLabel">Asignación de Personal</h3>
    </div>
    <div class="modal-body">
        
    </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    	<button class="btn btn-primary" id="save_btn">Asignar</button>
  	</div>
</div>