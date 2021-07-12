<link href="<?php echo base_url() ?>extras/js/TableTools/css/dataTables.tableTools.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>extras/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>

<div class="span11">
	<?php echo @$aviso; ?>
	<h2>Grupo de Trabajadores Asignados</h2>

	<?php if(count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th></th>
			<th>Rut</th>
			<th>Nombre</th>
			<th>Dirección</th>
			<th>Estado Civl</th>
			<th>AFP</th>
			<th>Sist. Salud</th>
			<th>Nacionalidad</th>
			<th></th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="checkbox" name="edicion" value="<?php echo $l->grupo_id ?>" class="check_edit" /></td>
				<td><?php echo $l->usuario_rut ?></td>
				<td><?php echo $l->usuario_nb ?> <?php echo $l->usuario_app ?> <?php echo $l->usuario_apm ?></td>
				<td><?php echo $l->usuario_dire ?></td>
				<td><?php echo $l->civil ?></td>
				<td><?php echo $l->usuario_afp ?></td>
				<td><?php echo $l->usuario_salud ?></td>
				<td><?php echo $l->nacionalidad ?></td>
				<td>
					<span style="<?php if(@$l->cv){ echo 'color:green'; } else{ echo 'color:red'; } ?>">CV</span> - 
					<span style="<?php if(@$l->afp){ echo 'color:green'; } else{ echo 'color:red'; } ?>">AFP</span> - 
					<span style="<?php if(@$l->salud){ echo 'color:green'; } else{ echo 'color:red'; } ?>">SALUD</span> - 
					<span style="<?php if(@$l->estudios){ echo 'color:green'; } else{ echo 'color:red'; } ?>">ESTU</span>
				</td>
				<td><a href='<?php echo base_url() ?>administracion/trabajadores/eliminar_usuario_listado_grupo_asignados/<?php echo $l->id ?>/<?php echo $l->grupo_id ?>'> eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php //echo $paginado ?>
	<?php } else{ ?>
		<p>No existen grupos ingresados</p>
	<?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('table.data').dataTable({
		"dom": 'T<"clear">lfrtip',
		"tableTools": {
            "sSwfPath": base_url + "/extras/js/TableTools/swf/copy_csv_xls_pdf.swf"
        }
	});
});
</script>
