<script src="<?php echo base_url() ?>extras/js/administracion/listado_trabajadores3.js" type="text/javascript"></script>
<div class="span11">
	<?php echo @$aviso; ?>
	<h2>Trabajadores ingresados</h2>
	<div class='span2'>
		<a data-target="#modal_nuevo" data-toggle="modal" data-backdrop="false" href="<?php echo base_url() ?>administracion/trabajadores/modal_requerimiento" class="btn primary dashboard_add">Requerimiento</a>
	</div>
	<div style="float:right;">
		<form action="<?php echo base_url() ?>administracion/trabajadores/buscar_nuevo/pagina/1" method="get">
		<input type="text" name="filtro" value="<?php echo $filtro; ?>"><button class="btn">Buscar</button>
		</form>
	</div>
	<?php if(count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th></th>
			<th>Rut</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Ciudad</th>
			<th>Masso</th>
			<th>Examen Preo</th>
			<th>Actualización</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="checkbox" name="edicion" value="<?php echo $l->id_user ?>" /></td>
				<td><?php echo $l->rut_usuario ?></td>
				<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/trabajador/<?php echo $l->id_user ?>"><?php echo $l->nombres ?></a></td>
				<td><?php echo $l->fono ?></td>
				<td><?php echo $l->desc_ciudades ?></td>
				<td>
					<a target="_blank" href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id_user ?>">
						<?php echo $l->masso ?>
					</a>
				</td>
				<td>
					<a target="_blank" href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id_user ?>">
						<?php echo $l->examen_pre ?>
					</a>
				</td>
				<td><?php echo $l->fecha_actualizacion ?></td>
				<td>
					<a href="<?php echo base_url() ?>administracion/trabajadores/anotaciones/<?php echo $l->id_user ?>" target="_blank"><img src="<?php 
					if ($l->ln == 0 ) echo base_url().'extras/images/circle_green_16_ns.png';
					if ($l->ln == 1 ) echo base_url().'extras/images/circle_yellow_16_ns.png';
					if ($l->ln == 2 ) echo base_url().'extras/images/circle_red_16_ns.png';
					if ($l->ln == 3 ) echo base_url().'extras/images/circle_red-yellow_16.png';
					?>"></a>
					<a href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id_user ?>" target="_blank"><i class="icon-signal"></i></a>
					<a href="<?php echo base_url() ?>administracion/trabajadores/editar/<?php echo $l->id_user ?>#datos-personales" target="_blank"><i class="icon-pencil"></i></a>
					<a href="<?php echo base_url() ?>administracion/trabajadores/desactivar/<?php echo $l->id_user ?>" class="desactivar_trabajador"><i class="icon-remove-sign"></i></a>
					<a href="<?php echo base_url() ?>administracion/trabajadores/eliminar_trabajador/<?php echo $l->id_user ?>" class="eliminar_trabajador2"><i class="icon-remove"></i></a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class="pagination pagination-small pagination-right">
	  	<ul>
		    <li><a href="<?php echo base_url() ?>administracion/trabajadores/buscar_nuevo/pagina/<?php echo $ant; ?>">Anterior</a></li>
		    <li><a href="<?php echo base_url() ?>administracion/trabajadores/buscar_nuevo/pagina/<?php echo $sig; ?>">Siguente</a></li>
	  	</ul>
	</div>
	<?php //echo $paginado ?>
	<?php } else{ ?>
		<p>No existen trabajadores agregados o asociados a la busqueda</p>
	<?php } ?>
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