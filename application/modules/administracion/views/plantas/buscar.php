<script src="<?php echo base_url() ?>extras/js/administracion/plantas.js" type="text/javascript"></script>
<h2>Plantas ingresadas</h2>
<?php if(count($listado) > 0){ ?>
<table class="table">
	<thead>
		<th></th>
		<th>Nombre</th>
		<th>Telefono</th>
		<th>Email</th>
		<th>Dirección</th>
	</thead>
	<tbody>
		<?php foreach($listado as $l){ ?>
		<tr>
			<td><input type="radio" name="edicion" value="<?php echo $l->id ?>" /></td>
			<td><?php echo ucwords( mb_strtolower( $l->nombre, 'UTF-8' ) ) ?></td>
			<td><?php echo $l->fono ?></td>
			<td><?php echo $l->email ?></td>
			<td><?php echo ucwords( mb_strtolower( $l->direccion, 'UTF-8' ) ) ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php echo @$paginado ?>
<?php } else{ ?>
	<p>No existen trabajadores agregados o asociados a la busqueda</p>
<?php } ?>
<div class="span3">
	<a href="<?php echo base_url().'administracion/plantas/agregar' ?>" class="btn xlarge primary dashboard_add">Crear</a>
	<a href="<?php echo base_url(); ?>administracion/plantas/editar" id="editar_planta" class="btn xlarge primary dashboard_add">Editar</a>
	<a href="<?php echo base_url().'administracion/plantas/eliminar' ?>" class="btn xlarge secondary dashboard_add" id="eliminar_planta" rel='<?php echo urlencode( $this->encrypt->encode( current_url()) ) ?>' >Eliminar</a>
</div>