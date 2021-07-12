<link href="<?php echo base_url() ?>extras/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('table.data').dataTable();
})
</script>
<div class="span11">
	<?php echo @$aviso; ?>
	<h2>Trabajadores en lista</h2>
	<div class='span2'>
		<a href="" class="btn primary dashboard_add">Descargar</a>
	</div>

	<table class="data display">
		<thead>
			<th>Rut</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Fecha</th>
			<th>Anotacion</th>
			<th>Peticion de</th>
			<th>tipo anotación</th>
			<th>Archivo</th>
			<!--<th></th>-->
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><?php echo $l->rut_usuario ?></td>
				<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/trabajador/<?php echo $l->id_usuario ?>"><?php echo $l->nombres ?> <?php echo $l->paterno ?> <?php echo $l->materno ?></a></td>
				<td><?php echo $l->fono ?></td>
				<td><?php echo $l->fecha_ln ?></td>
				<td><?php echo $l->anotacion ?></td>
				<td><?php echo $l->quien ?></td>
				<td><?php echo $l->tipo ?></td>
				<td><a href="<?php echo base_url().$l->archivo ?>" target="_blank">Descargar</a></td>
				<!--<td>
					<a href="" target="_blank"><i class="icon-signal"></i></a>
				</td>-->
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>