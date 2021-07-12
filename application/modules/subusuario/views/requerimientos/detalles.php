<div id="contact_profile" class="grid grid_17 append_1">
	<?php echo @$aviso ?>
	<h2>Datos Generales</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td>Empresa Mandante</td>
				<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/empresa/<?php echo $requerimiento->id_de ?>"><?php echo ucwords(mb_strtolower($requerimiento->de,"UTF-8")) ?></a></td>
			</tr>
			<tr class="odd gradeX">
				<td>Creador</td>
				<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/mandante/<?php echo $requerimiento->id_creador ?>">
					<?php echo ucwords(mb_strtolower($requerimiento->creador,"UTF-8")) ?></a></td>
			</tr>
			<tr class="odd gradeX">
				<td>Nombre</td>
				<td><?php echo ucwords(mb_strtolower($requerimiento->nombre,"UTF-8")) ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Lugar</td>
				<td><?php echo ucwords(mb_strtolower($requerimiento->lugar,"UTF-8")) ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Id requerimiento</td>
				<td><?php echo $requerimiento->id_req ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Comentario</td>
				<td><?php echo $requerimiento->comentario ?></td>
			</tr>
		</tbody>
	</table>
</div>
<div class="grid grid_24">
<h2>Requerimiento de Personal</h2>
	<table class="data display">
		<thead>
			<th>Id</th>
			<th>Area</th>
			<th>Cargo</th>
			<th>Centro de costo</th>
			<th>Especialidad</th>
			<th>Fecha de inicio</th>
			<th>Fecha de termino</th>
			<th>Trabajadores</th>
			<th>Estado</th>
		</thead>
		<tbody>
			<tr class="odd">
				<td><?php echo $requerimiento->id ?></td>
				<td><?php echo $requerimiento->areas ?></td>
				<td><?php echo $requerimiento->cargos ?></td>
				<td><?php echo $requerimiento->cc ?></td>
				<td><?php echo $requerimiento->especialidad ?></td>
				<td><?php echo $requerimiento->f_inicio ?></td>
				<td><?php echo $requerimiento->f_termino ?></td>
				<td><b><?php echo $requerimiento->cantidad ?>/<?php echo $requerimiento->cantidad_ok ?></b></td>
				<td><?php echo $requerimiento->estado ?></td>
			</tr>
		</tbody>
	</table>
	<br />
</div>