<script src="<?php echo base_url() ?>extras/js/administracion/areas.js" type="text/javascript"></script>

<h2>Areas ingresadas</h2>
<?php if(count($listado) > 0){ ?>
<table class="table">
	<thead>
		<th>#</th>
		<th>Area</th>
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
	<p>No existen areas agregados o asociados a la busqueda</p>
<?php } ?>

<div class="span3">
	<a href="<?php echo base_url().'administracion/areas/agregar' ?>" id="" class="btn xlarge primary dashboard_add">Crear</a>
	<a href="<?php echo base_url().'administracion/areas/editar' ?>" id="editar_area" class="btn xlarge primary dashboard_add">Editar</a>
	<a href="<?php echo base_url().'administracion/areas/eliminar' ?>" class="btn xlarge secondary dashboard_add" id="eliminar_area" rel='<?php echo urlencode( $this->encrypt->encode( current_url()) ) ?>' >Eliminar</a>
</div>