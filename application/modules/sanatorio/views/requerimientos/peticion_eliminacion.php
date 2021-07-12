<script src="<?php echo base_url() ?>extras/js/admin_eliminar_requerimiento.js" type="text/javascript"></script>
<div class="span8">
	<table class="data display">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Empresa</th>
				<th>Nombre</th>
				<th>Lugar</th>
				<th>Subrequerimientos</th>
			</tr>
		</thead>
		<tbody>
			<?php if( count($lista_req) > 0 ) { ?>
			<?php foreach($lista_req as $l){ ?>
			<tr class="odd gradeX">
				<td><input type="radio" name="eliminar" value="<?php echo $l->id ?>" /></td>
				<td><?php echo ucwords(mb_strtolower($this->Empresas_model->get($l->id_empresa)->razon_social, 'UTF-8')) ?></td>
				<td><a href="<?php echo base_url() ?>administracion/requerimiento/detalles/<?php echo $l->id ?>" target="_blank">
					<?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')) ?>
				</a></td>
				<td><?php echo ucwords(mb_strtolower($l->lugar_trabajo, 'UTF-8')) ?></td>
				<td><a class="dialog" href="<?php echo base_url() ?>administracion/requerimiento/estado_subreq/<?php echo $l->id ?>"><?php echo count($this->Requerimiento_model->get_prin_req($l->id)) ?></a></td>
			</tr>
			<?php } ?>
			<?php } else { ?>
			<tr class="odd gradeX">
				<td colspan="5">No existen nuevas peticiones</td>
			</tr>
			<?php } ?>	
		</tbody>
	</table>
</div>
<div class="span3">
	<a href="javascript:;" id="eliminar" class="btn primary xlarge block">Eliminar</a>
</div>