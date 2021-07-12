<script src="<?php echo base_url() ?>extras/js/mandante_estado_req.js" type="text/javascript"></script>
<?php echo @$aviso; ?>
<div class="grid grid_18">
	<h2>Vencidos</h2>
	<?php if( count($lista_req) >0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Id</th>
				<th>Nombre</th>
				<th>Lugar</th>
				<th>Subrequerimientos</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($lista_req as $l){ ?>
			<tr class="odd gradeX">
				<td><?php echo $l->id_req ?></td>
				<td><?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')) ?></td>
				<td><?php echo ucwords(mb_strtolower($l->lugar_trabajo, 'UTF-8')) ?></td>
				<td><a class="dialog" href="<?php echo base_url() ?>mandante/requerimiento/estado_subreq/<?php echo $l->id_req ?>"><?php echo count($this->Requerimiento_model->get_prin_req2($l->id_req)) ?></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
		<p>No existen requerimientos.</p>
	<?php } ?>
</div>
<div class="grid grid_6">
	
</div>