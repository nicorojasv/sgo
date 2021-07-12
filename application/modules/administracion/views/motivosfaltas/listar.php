<script src="<?php echo base_url() ?>extras/js/administracion/motivos_falta.js" type="text/javascript"></script>
<div class="grid grid_17">	
	<?php echo @$aviso; ?>
	<?php if( count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>#</th>
				<th>Nombre</th>
				<th colspan="2">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($listado as $l) { ?>
			<tr class="odd gradeX">
				<td><?php echo $l->id ?></td>
				<td><?php echo ucwords( mb_strtolower($l->nombre , 'UTF-8')) ?></td>
				<td class="center"><a href="<?php echo $l->id ?>" class="dialog">editar</a></td>
				<td class="center"><a href="<?php echo base_url() ?>administracion/motivosfalta/eliminar/<?php echo $l->id ?>" id='eliminar'>eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
	<p>No existen motivos de faltas.</p>
	<?php } ?>
</div>
<div class="grid grid_7">
	
</div>

<!-- OVERLAY CON EL INGRESO DEL MOTIVO -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de Motivos de ausencia</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese el motivo de la ausencia.
			</p>
			<form action="<?php echo base_url() ?>administracion/motivosfalta/ingresar" method="post" class="form">
				<div class="field">
					<label for="nombre">Nombre:</label>
					<div class="fields">
						<input type="text" name="nombre_motivo" size="30" tabindex="1">
					</div>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary" tabindex="1">
						Crear
					</button>
				</div>
			</form>
		</div>
	</div>
	   
</div>
<!-- -->