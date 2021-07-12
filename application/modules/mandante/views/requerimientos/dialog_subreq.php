<div>
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>SubRequerimientos</h3>
	</div>
	<div id="modal_content">
		<div style="width: 670px;">
			<table class="data display">
				<thead>
					<tr>
						<th>Area</th>
						<th>Cargo</th>
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
						<td><?php echo ucwords(mb_strtolower($this->Areas_model->get($l->id_areas)->desc_area, 'UTF-8')) ?></td>
						<td><?php echo ucwords(mb_strtolower($this->Cargos_model->get($l->id_cargos)->desc_cargo, 'UTF-8')) ?></td>
						<td><?php echo $l->fecha_inicio ?></td>
						<td><?php echo $l->fecha_termino ?></td>
						<td>
							<?php if($l->id_especialidad){ ?>
							<?php echo ucwords(mb_strtolower($this->Especialidadtrabajador_model->get($l->id_especialidad)->desc_especialidad, 'UTF-8')) ?>
							<?php } else{ ?>&nbsp;<?php } ?>
						</td>
						<td><a href="<?php echo base_url() ?>mandante/requerimiento/asignados/<?php echo urlencode(encode_to_url($this->encrypt->encode($l->id))); ?>" target="_blank"><?php echo $l->cantidad."/".$l->cantidad_ok ?></a></td>
						<td><?php echo ucwords(mb_strtolower($this->Requerimiento_model->get_estado($l->id_estado)->nombre, 'UTF-8')) ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>