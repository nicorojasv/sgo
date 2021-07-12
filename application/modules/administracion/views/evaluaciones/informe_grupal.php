<div class="span11 prepend_1">
	<table class="data display">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Rut Trabajador</th>
				<th>Nombre</th>
				<th>Especialidad</th>
				<th>MASSO</th>
				<th>Exámen</th>
				<th>Desempeño</th>
				<th>Recomendado</th>
				<th>Conocimiento</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($listado as $l) { ?>
			<tr class="odd gradeX">
				<td><?php echo $l->id ?></td>
				<td><?php echo $l->rut ?></td>
				<td><a href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $l->id ?>"><?php echo $l->nombre ?></a></td>
				<td><?php echo $l->especialidad ?></td>
				<td><?php echo $l->masso ?></td>
				<td><?php echo $l->examen_pre ?></td>
				<td><?php echo $l->desempeno ?></td>
				<td><?php echo $l->recomienda ?></td>
				<td><?php echo $l->resultado ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<br />
	<div style="width: 100%;height: 1px;position: relative;clear: both;"></div>
	<br>
	<br>
</div>