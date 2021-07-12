<script src="<?php echo base_url() ?>extras/js/administracion/grupos.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Grupos ingresados</h2>
	<?php if(count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th>#</th>
			<th>Nombre</th>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="radio" name="edicion" value="<?php echo $l->id ?>" /></td>
				<td><?php echo ucwords( mb_strtolower( $l->nombre, 'UTF-8' ) ) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php echo @$paginado ?>
	<?php } else{ ?>
		<p>No existen trabajadores agregados o asociados a la busqueda</p>
	<?php } ?>
</div>
<div class="span3">
	<a href="<?php echo base_url().'administracion/grupos/agregar' ?>" class="btn xlarge primary dashboard_add">Crear</a>
	<a href="<?php echo base_url().'administracion/grupos/editar' ?>" id="editar_grupo" class="btn xlarge primary dashboard_add">Editar</a>
	<a href="<?php echo base_url().'administracion/grupos/eliminar' ?>" class="btn xlarge secondary dashboard_add" id="eliminar_grupo" rel='<?php echo urlencode( $this->encrypt->encode( current_url()) ) ?>' >Eliminar</a>
</div>