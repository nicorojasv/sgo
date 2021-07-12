<script src="<?php echo base_url() ?>extras/js/jquery.base64.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/urlEncode.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/requerimiento_admin.js" type="text/javascript"></script>
<div id="contact_profile" class="span8 append_1">
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
<div class="span3">
	<a id="agregar" href="<?php echo base_url() ?>administracion/requerimiento/asignar" class="btn primary xlarge block">Asignar trabajadores</a>
	<a id="contratos" href="<?php echo base_url() ?>administracion/contratos/asignar" class="btn secondary xlarge block">Contratos</a>
</div>
<div class="grid grid_24">
<h2>Requerimiento de Personal</h2>
	<p>Cantidad de requerimientos:  <?php echo count($requerimiento->detalle) ?></p>
	<table class="data display">
		<thead>
			<th>&nbsp;</th>
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
		<?php foreach($requerimiento->detalle as $rd){ ?>
			<tr class="odd">
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><input type="radio" name="asignar" value="<?php echo $rd->id ?>" /></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->id ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->areas ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->cargos ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->cc ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->especialidad ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->f_inicio ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->f_termino ?></td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>>
					<a href="<?php echo base_url() ?>administracion/requerimiento/asignados/<?php echo urlencode( encode_to_url($this->encrypt->encode($rd->id)) ); ?>" target="_blank"><?php echo $rd->cantidad ?>/<?php echo $rd->cantidad_ok ?></a>
				</td>
				<td <?php if($rd->activo) echo 'class="activa"'; ?>><?php echo $rd->estado ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	<br />
</div>