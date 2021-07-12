<?php 
	echo @$avisos;
?>
<h2>Listado de areas creadas</h2>
<table class="data display">
	<thead>
		<tr>
			<th>Codigo</th>
			<th>Nombre</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if( count($listado_areas) > 0 ){ ?>
		<?php foreach ($listado_areas as $la) { ?>
		<tr class="odd gradeX">
			<td><?php echo $la->id ?></td>
			<td><?php echo ucwords( mb_strtolower($la->desc_area, 'UTF-8')) ?></td>
			<td class="center"><a class="dialog" href="<?php echo base_url()?>mandante/areas/html_editar/areas/<?php echo $la->id ?>">editar</a></td>
			<td class="center"><a class="eliminar ajax" href="<?php echo base_url() ?>mandante/areas/eliminar/<?php echo $la->id ?>">eliminar</a></td>
		</tr>
		<?php } ?>
		<?php } else{ ?>
		<tr class="odd gradeX">
			<td colspan="4">no existen areas creadas</td>
		</tr>
		<?php } ?>
	</tbody>
</table>


<!-- OVERLAY CON EL INGRESO DE UN AREA -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de nueva area</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese una nueva area.
			</p>
			<form action="<?php echo base_url() ?>mandante/areas/ingresar" method="post" class="form">
				<div class="field">
					<label for="email">Nombre</label>
					<div class="fields">
						<input type="text" name="area" value="" id="area" size="30" tabindex="1">
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