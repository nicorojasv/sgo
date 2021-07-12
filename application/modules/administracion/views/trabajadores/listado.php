<link href="<?php echo base_url() ?>extras/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/administracion/listado_trabajadores.js" type="text/javascript"></script>
<div class="span9">
	<?php echo @$aviso; ?>
	<h2>Trabajadores ingresados</h2>
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
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="radio" name="edicion" value="<?php echo $l->id_user ?>" /></td>
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
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php //echo $paginado ?>
	<?php } else{ ?>
		<p>No existen trabajadores agregados o asociados a la busqueda</p>
	<?php } ?>
</div>
<div class="span2">
<div class="well">
	<div id="gallery_filter" class="box">
		<h3>Filtros</h3>
		<p>
			Para nueva busqueda, favor seleccione uno o mas filtros.
		</p>
		<form method="post" action="<?php echo base_url() ?>administracion/trabajadores/filtrar">
			<ul class="filters">
				<li>
					<a href="#">Nombre</a><br />
					<input type="text" name="nombre" value="<?php if(@$input_nombre) echo $input_nombre; ?>" style="<?php if(!$input_nombre) echo 'display: none;'; ?>" />
				</li>
				<li>
					<a href="#">Rut</a><br />
					<input type="text" name="rut" value="<?php if(@$input_rut) echo $input_rut; ?>" style="<?php if(!$input_rut) echo 'display: none;'; ?>" />
				</li>
				<li>
					<a href="#">Profesión</a><br />
					<select name="profesion" style="<?php if(!@$input_prof) echo 'display: none;'; ?>width: 188px;" >
						<option value="">Seleccione...</option>
						<?php foreach($listado_profesiones as $p){ ?>
						<option value="<?php echo $p->id ?>" <?php if((isset($input_prof)) && ($input_prof==$p->id)) echo 'selected="true"'; ?> ><?php echo $p->desc_profesiones ?></option>
						<?php } ?>
					</select>
				</li>
				<li>
				<a href="#">Especialidad</a><br />
				<select name="especialidad" style="<?php if(!$input_espe) echo 'display: none;'; ?> width: 188px;">
					<option value="">Seleccione...</option>
					<?php foreach($listado_especialidad as $e){ ?>
					<option value="<?php echo $e->id ?>" <?php if((isset($input_espe)) && ($input_espe==$e->id)) echo 'selected="true"'; ?>><?php echo $e->desc_especialidad ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<a href="#">Ciudad</a><br />
				<select name="ciudad" style="<?php if(!$input_ciudad) echo 'display: none;'; ?> width: 188px;">
					<option value="">Seleccione...</option>
					<?php foreach($listado_ciudades as $c){ ?>
					<option value="<?php echo $c->id ?>" <?php if((isset($input_ciudad)) && ($input_ciudad==$c->id)) echo 'selected="true"'; ?>><?php echo $c->desc_ciudades ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<a href="#">Palabra Clave</a><br />
				<input type="text" name="clave" value="<?php if(@$input_palabra_clave) echo $input_palabra_clave; ?>" style="<?php if(!$input_palabra_clave) echo 'display: none;'; ?>" />
			</li>
			</ul>
			<button id="btn_filtrar" type="submit" class="btn primary">
				Filtrar
			</button>
		</form>
	</div>
	<a data-target="#modal_nuevo" data-toggle="modal" data-backdrop="false" href="<?php echo base_url() ?>administracion/trabajadores/modal_requerimiento" class="btn xlarge primary dashboard_add">Requerimiento</a>
	<a href="<?php echo base_url() ?>administracion/trabajadores/editar/" id="editar_trabajador" class="btn xlarge primary dashboard_add">Editar</a>
	<a href="javascript:;" class="btn xlarge secondary dashboard_add" id="eliminar_trabajador" >Eliminar</a>
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