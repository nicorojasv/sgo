<script src="<?php echo base_url() ?>extras/js/subusuarios/requerimientos.js" type="text/javascript"></script>
<?php echo @$aviso; ?>
<div class="grid grid_18">
	<h2>Asignado</h2>
	<table class="data display">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Requerimiento</th>
				<th>Lugar</th>
				<th>Cantidad</th>
				<th>Fecha inicio</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lista_req as $l){ ?>
			<tr>
				<td>&nbsp;</td>
				<td colspan="5"><?php echo $l->nombre ?></td>
			</tr>
			<?php foreach($l->data as $d){ ?>
			<tr class="odd gradeX">
				<td><input type="radio" name="req" value="<?php echo $l->id ?>/<?php echo $d->id_subreq ?>" /></td>
				<td>&nbsp;</td>
				<td><?php echo ucwords(mb_strtolower($d->lugar_trabajo, 'UTF-8')) ?></td>
				<td><?php echo $d->cantidad.'/'.$d->cantidad_ok ?></td>
				<td><?php echo $d->f_inicio ?></td>
				<td><?php echo $d->estado ?></td>
			</tr>
			<?php } ?>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="grid grid_6">
	<a href="<?php echo base_url() ?>subusuario/requerimiento/trabajadores" id="ver-trabajadores" class="btn primary xlarge block">Trabajadores</a>
	<a href="<?php echo base_url() ?>subusuario/requerimiento/detalle_requerimiento" id="ver-detalles" class="btn secondary xlarge block">Ver Detalles</a>
</div>