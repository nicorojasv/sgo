<script src="<?php echo base_url() ?>extras/js/mandante_estado_req.js" type="text/javascript"></script>
<?php echo @$aviso; ?>
<div class="grid grid_18">
	<h2>Requerimientos vigentes</h2>
	<?php if( count($lista_req) > 0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Nombre</th>
				<th>Lugar</th>
				<th>Subrequerimientos</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lista_req as $l){ ?>
			<tr class="odd gradeX">
				<td><input type="radio" name="req" value="<?php echo urlencode( base64_encode($l->id_req) ) ?>" /></td>
				<td><?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')) ?></td>
				<td><?php echo ucwords(mb_strtolower($l->lugar_trabajo, 'UTF-8')) ?></td>
				<td><a class="dialog" href="<?php echo base_url() ?>mandante/requerimiento/estado_subreq/<?php echo $l->id_req ?>"><?php echo count($this->Requerimiento_trabajador_model->get_requerimiento($l->id_req)) ?></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
	<p>No existen requerimientos.</p>
	<?php } ?>
</div>
<div class="grid grid_6">
	<a href="#" id="editar_req" class="btn primary xlarge block">Editar</a>
	<a href="#" id="eliminar_req" class="btn secondary xlarge block">Eliminar</a>
</div>