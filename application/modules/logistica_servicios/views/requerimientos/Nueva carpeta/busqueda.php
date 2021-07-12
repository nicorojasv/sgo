<script src="<?php echo base_url() ?>extras/js/ajax_consulta_admin.js" type="text/javascript"></script>
<div class="span11 offset0">
	<form class="form-inline" action="<?php echo base_url() ?>administracion/requerimiento/busqueda_grupos" method='post'>
		<label>Planta: </label>
		<select name="planta" id="planta">
    		<option value='0'>Todos</option>
    		<?php foreach ($listado_plantas as $p) { ?>
    			<option value="<?php echo $p->id ?>"><?php echo $p->nombre ?></option>
	    	<?php } ?>
		</select>
		<label>Grupo: </label>
    	<select name="grupo" id="grupo">
    		<option value='0'>Todos</option>

		</select>
		<label>Area</label>
    	<select name="area" id="area">
    		<option value='0'>Todos</option>
		  	
		</select>
		<label>Cargo</label>
    	<select name="cargo" id="cargo">
    		<option value='0'>Todos</option>
		  	
		</select>
		<button type="submit" class="btn">Buscar</button>
	</form>
	<hr/>
	<?php if( isset($listado) ){ ?>
	<table class="data display">
		<thead>
			<th>RUT</th>
			<th>Nombre</th>
			<th>Grupo</th>
			<th>Cargo</th>
			<th>Área</th>
			<th>Teléfono</th>
			<th>MASSO</th>
			<th>Examen</th>
		</thead>
		<tbody>
			<?php foreach ($listado as $r) { ?>
			<tr class="odd gradeX">
				<td><?php echo $r->rut; ?></td>
				<td><?php echo $r->nombre. ' '.$r->paterno . ' '. $r->materno ; ?></td>
				<td><?php echo $r->grupo ?></td>
				<td><?php echo $r->cargo ?></td>
				<td><?php echo $r->area ?></td>
				<td><?php echo $r->fono ?></td>
				<td><?php echo $r->masso ?></td>
				<td><?php echo $r->examen_pre ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
</div>