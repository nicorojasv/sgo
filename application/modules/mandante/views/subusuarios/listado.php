<script type="text/javascript" src="<?php echo base_url() ?>extras/js/mandante/asignar_subusuarios.js"></script>
<?php echo @$aviso; ?>
<div class="grid grid_18">
	<h2>Listado</h2>
	<?php if( count($listado) > 0 ){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<th>Nombre</th>
				<th>Rut</th>
				<th>Requerimiento</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr class="odd gradeX">
				<td><input type="radio" name="req" value="<?php echo $l->id ?>" /></td>
				<td><?php echo ucwords(mb_strtolower($l->nombre.' '.$l->paterno.' '.$l->materno, 'UTF-8')) ?></td>
				<td><?php echo $l->rut ?></td>
				<td>
					<?php 
						if($l->requerimiento)
							echo ucwords(mb_strtolower($l->requerimiento, 'UTF-8'));
						else echo "<b>Usuario sin asignar a requerimiento</b>";
					?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<p>No existen Subusuarios agregados</p>
	<?php } ?>
</div>
<div class="grid grid_6">
	<div id="gallery_filter" class="box">
		<h3><a href="#" id='click_filtro'>Filtrar usuarios</a></h3>
		<div id="esconder" style="display: none">
		<form>
			<input type="checkbox" name="sin-asign" /> Sin asignar<br />
			<select name="" style="width:183px;">
				<option value="">Requerimiento...</option>
			</select><br />
			<select name="" style="width:183px;">
				<option value="">SubRequerimiento...</option>
			</select><br /><br />
			<button id="btn_filtrar" type="submit" class="btn primary">
				Filtrar
			</button>
		</form>
		</div>
	</div>
	<a href="#" id="editar_req" class="btn primary xlarge block">Editar</a>
	<a href="<?php echo base_url() ?>mandante/subusuarios/asignar" id="asignar_req" class="btn secondary xlarge block">Asignar</a>
	<a href="#" id="eliminar_req" class="btn tertiary xlarge block">Eliminar</a>
</div>