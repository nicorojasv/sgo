<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Mandantes ingresados</h2>
	<table class="data display">
		<thead>
			<th>Planta</th>
			<th>Codigo Ingreso</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Email</th>
		</thead>
		<tbody>
			<?php if(isset($listar)){ ?>
			<?php foreach($listar as $l){ ?>
			<tr>
				<td><?php echo ucwords(mb_strtolower($this->Planta_model->get($l->id_planta)->nombre,'UTF-8')) ?></td>
				<td><?php echo $l->codigo_ingreso ?></td>
				<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/mandante/<?php echo $l->id ?>"><?php echo ucwords(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8')) ?></a></td>
				<td><?php echo $l->fono ?></td>
				<td><?php echo $l->email ?></td>
			</tr>
			<?php } ?>
			<?php } else{ ?>
			<tr><td colspan="6">No existen mandantes agregadas</td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/mandantes/agregar" class="btn xlarge secondary dashboard_add"><span></span>Agregar Mandante</a>
	<a href="<?php echo base_url() ?>administracion/mandantes/buscar" class="btn xlarge primary dashboard_add">Buscar</a>
</div>