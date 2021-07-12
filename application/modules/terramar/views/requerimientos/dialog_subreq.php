<div>
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>SubRequerimientos</h3>
	</div>
	<div id="modal_content">
		<div style="width: 570px;">
			<table class="data display">
				<thead>
					<tr>
						<th>Inicio</th>
						<th>Termino</th>
						<th>Especialidad</th>
						<th>Cantidad</th>
						<th>Estado</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($listado as $l){ ?>
					<tr class="odd gradeX">
						<td><?php echo $l->fecha_inicio ?></td>
						<td><?php echo $l->fecha_termino ?></td>
						<td><?php echo ucwords(mb_strtolower($this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador)->desc_especialidad, 'UTF-8')) ?></td>
						<td><?php echo $l->cantidad."/".$l->cantidad_ok ?></td>
						<td><?php echo ucwords(mb_strtolower($this->Requerimiento_model->get_estado($l->id_estado)->nombre, 'UTF-8')) ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>