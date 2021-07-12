<?php 
	echo @$avisos;
?>
<h2>Listado de centros de costo</h2>
<table class="data display">
	<thead>
		<tr>
			<th>Codigo</th>
			<th>Nombre</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if( count($listado_cc) > 0 ){ ?>
		<?php foreach ($listado_cc as $la) { ?>
		<tr class="odd gradeX">
			<td><?php echo $la->id ?></td>
			<td><?php echo ucwords( mb_strtolower($la->desc_centrocosto, 'UTF-8' )) ?></td>
			<td class="center"><a class="dialog" href="<?php echo base_url()?>mandante/centros_de_costo/html_editar/centro_costo/<?php echo $la->id ?>">editar</a></td>
			<td class="center"><a class="eliminar ajax" href="<?php echo base_url() ?>mandante/centros_de_costo/eliminar/<?php echo $la->id ?>">eliminar</a></td>
		</tr>
		<?php } ?>
		<?php } else{ ?>
		<tr class="odd gradeX">
			<td colspan="4">no existen centros de costo creados</td>
		</tr>
		<?php } ?>
	</tbody>
</table>


<!-- OVERLAY CON EL INGRESO DE UN AREA -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de nuevo centro de costo</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese un nuevo centro de costo.
			</p>
			<form action="<?php echo base_url() ?>mandante/centros_de_costo/ingresar" method="post" class="form">
				<div class="field">
					<label for="nombre">Nombre</label>
					<div class="fields">
						<input type="text" name="cc" value="" id="cc" size="30" tabindex="1">
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