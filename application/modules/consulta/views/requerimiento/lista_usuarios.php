<div class="span11 prepend_1">
	<?php echo @$aviso; ?>
	<?php if( count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th>RUT</th>
			<th>Nombre</th>
			<th>Grupo</th>
			<th>Cargo</th>
			<th>Área</th>
			<th>Teléfono</th>
			<th>MASSO</th>
			<th>Examen</th>
		</thead>
		<tbody>
			<?php foreach ($listado as $r) { ?>
			<tr class="odd gradeX">
				<td><?php echo $r->rut; ?></td>
				<td><?php echo $r->nombre. ' '.$r->paterno . ' '. $r->materno ; ?></td>
				<td><?php echo $r->grupo ?></td>
				<td><?php echo $r->cargo ?></td>
				<td><?php echo $r->area ?></td>
				<td><?php echo $r->fono ?></td>
				<td><?php echo $r->masso ?></td>
				<td><?php echo $r->examen_pre ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
	<p>No existen usuarios asignados.</p>
	<?php } ?>
</div>