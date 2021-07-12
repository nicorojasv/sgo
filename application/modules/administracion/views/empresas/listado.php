<h2>Empresas ingresadas</h2>
<table class="table">
	<thead>
		<th>#</th>
		<th>Razón Social</th>
		<th>Rut</th>
		<th>Giro</th>
		<th>Dirección</th>
		<th>Pagina Web</th>
	</thead>
	<tbody>
		<?php if(isset($listado_empresas)){ ?>
		<?php foreach($listado_empresas as $e){ ?>
		<tr>
			<td><input type='radio' name='editar' value='<?php echo $e->id ?>' ></td>
			<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/empresa/<?php echo $e->id ?>"><?php echo ucwords(mb_strtolower($e->razon_social,'UTF-8')) ?></a></td>
			<td><?php echo $e->rut ?></td>
			<td><?php echo ucwords(mb_strtolower($e->giro,'UTF-8')) ?></td>
			<td><?php echo ucwords(mb_strtolower($e->direccion,'UTF-8')) ?></td>
			<td><?php echo $e->web ?></td>
		</tr>
		<?php } ?>
		<?php } else{ ?>
		<tr><td colspan="6">No existen empresas agregadas</td></tr>
		<?php } ?>
	</tbody>
</table>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/empresas/buscar" class="btn xlarge primary dashboard_add">Editar</a>
	<a href="<?php echo base_url() ?>administracion/empresas/buscar" class="btn xlarge secondary dashboard_add">Eliminar</a>
	<a href="<?php echo base_url() ?>administracion/empresas/agregar" class="btn xlarge primary dashboard_add"><span></span>Agregar Empresa</a>
</div>