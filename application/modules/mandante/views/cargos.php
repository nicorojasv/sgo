<?php 
	echo @$avisos;
?>
<h2>Listado de cargos creados</h2>
<table class="data display">
	<thead>
		<tr>
			<th>Codigo</th>
			<th>Nombre</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if( count($listado_cargos) > 0 ){ ?>
		<?php foreach ($listado_cargos as $la) { ?>
		<tr class="odd gradeX">
			<td><?php echo $la->id ?></td>
			<td><?php echo ucwords( mb_strtolower($la->desc_cargo , 'UTF-8')) ?></td>
			<td class="center"><a class="dialog" href="<?php echo base_url()?>mandante/cargos/html_editar/cargos/<?php echo $la->id ?>">editar</a></td>
			<td class="center"><a class="eliminar ajax" href="<?php echo base_url() ?>mandante/cargos/eliminar/<?php echo $la->id ?>">eliminar</a></td>
		</tr>
		<?php } ?>
		<?php } else{ ?>
		<tr class="odd gradeX">
			<td colspan="4">no existen cargos creadas</td>
		</tr>
		<?php } ?>
	</tbody>
</table>


<!-- OVERLAY CON EL INGRESO DE UN AREA -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de nuevo cargo</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese un nuevo cargo.
			</p>
			<form action="<?php echo base_url() ?>mandante/cargos/ingresar" method="post" class="form">
				<div class="field">
					<label for="nombre">Nombre</label>
					<div class="fields">
						<input type="text" name="cargo" value="" id="cargo" size="30" tabindex="1">
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