<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Usuarios ingresados</h2>
	<table class="data display">
		<thead>
			<th>Cargo</th>
			<th>Rut</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Email</th>
		</thead>
		<tbody>
			<?php if(isset($listado_interno)){ ?>
			<?php foreach($listado_interno as $e){ ?>
			<tr>
				<td><?php echo ucwords(mb_strtolower($this->Tipousuarios_model->get($e->id_tipo_usuarios)->desc_tipo_usuarios,'UTF-8')) ?></td>
				<td><?php echo $e->rut_usuario ?></td>
				<td><?php echo ucwords(mb_strtolower($e->nombres.' '.$e->paterno.' '.$e->materno,'UTF-8')) ?></td>
				<td><?php echo $e->fono ?></td>
				<td><?php echo $e->email ?></td>
			</tr>
			<?php } ?>
			<?php } else{ ?>
			<tr><td colspan="6">No existen usuarios agregadas</td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/internos/agregar" class="btn xlarge secondary dashboard_add"><span></span>Agregar usuario interno</a>
	<a href="<?php echo base_url() ?>administracion/internos/buscar" class="btn xlarge primary dashboard_add">Buscar</a>
</div>