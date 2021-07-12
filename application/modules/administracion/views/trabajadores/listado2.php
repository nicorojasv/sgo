<h2>Trabajadores ingresados</h2>
<?php if(count($listado) > 0){ ?>
<table class="table table-striped table-bordered table-hover table-full-width dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">
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
			<th>Datos</th>
			<th>Herramienta</th>
			<th>Exam</th>
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
			<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/trabajador/<?php echo $l->id_user ?>"><?php echo $l->nombres ?></a></td>
			<td><?php echo $l->fono ?></td>
			<td><?php echo $l->desc_ciudades ?></td>
			<td><?php echo $l->especilidad1; ?> <br/>
				<?php echo $l->especilidad2; ?></td>
			<td>
				<a target="_blank" href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id_user ?>" style="<?php 
				if($l->estado_masso == 'vigente'){ echo 'color:green'; }
			if($l->estado_masso == 'vencida'){ echo 'color:red'; }
			if($l->estado_masso == 'falta'){ echo 'color:#FF8000'; } ?>">
					<?php echo $l->masso ?>
				</a>
			</td>
			<td>
				<a target="_blank" href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id_user ?>" style="<?php 
				if($l->estado_examen == 'vigente'){ echo 'color:green'; }
			if($l->estado_examen == 'vencida'){ echo 'color:red'; }
			if($l->estado_examen == 'falta'){ echo 'color:#FF8000'; } ?>">
					<?php echo $l->examen_pre ?>
				</a>
			</td>
			<td><?php echo $l->fecha_nacimiento ?></td>
			<td>
				<span style="<?php if(@$l->cv){ echo 'color:green'; } else{ echo 'color:red'; } ?>">CV</span> - 
				<span style="<?php if(@$l->afp){ echo 'color:green'; } else{ echo 'color:red'; } ?>">AFP</span> - 
				<span style="<?php if(@$l->salud){ echo 'color:green'; } else{ echo 'color:red'; } ?>">SALUD</span> - 
				<span style="<?php if(@$l->estudios){ echo 'color:green'; } else{ echo 'color:red'; } ?>">ESTU</span>
			</td>
			<td>
				<a href="<?php echo base_url() ?>administracion/trabajadores/anotaciones/<?php echo $l->id_user ?>" target="_blank">
					<img src="<?php 
					if ($l->ln == 0 ) echo base_url().'extras/images/circle_green_16_ns.png';
					if ($l->ln == 1 ) echo base_url().'extras/images/circle_yellow_16_ns.png';
					if ($l->ln == 2 ) echo base_url().'extras/images/circle_red_16_ns.png';
					if ($l->ln == 3 ) echo base_url().'extras/images/circle_red-yellow_16.png';
					?>">
				</a>
				<a href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id_user ?>" target="_blank">
					<i class="fa fa-eye"></i>
				</a>
				<a href="<?php echo base_url() ?>administracion/trabajadores/editar/<?php echo $l->id_user ?>#datos-personales" target="_blank">
					<i class="fa fa-edit"></i>
				</a>
				<a href="<?php echo base_url() ?>administracion/trabajadores/desactivar/<?php echo $l->id_user ?>" class="desactivar_trabajador">
					<i class="fa fa-ban"></i>
				</a>
				<a href="<?php echo base_url() ?>administracion/trabajadores/eliminar_trabajador/<?php echo $l->id_user ?>" class="eliminar_trabajador2">
					<i class="fa fa-trash-o"></i>
				</a>
			</td>
			<td>
				<a href="<?php echo base_url() ?>administracion/evaluaciones/listado_usuario/<?php echo $l->id_user ?>" class="sv-callback-list">
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