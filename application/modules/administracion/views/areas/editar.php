<script src="<?php echo base_url() ?>extras/js/administracion/crear_areas.js" type="text/javascript"></script>
<div class="span8 offset1">
	<?php echo @$aviso; ?>
	<h2>Editar Area</h2>
	<form id="form_mandante" action="<?php echo base_url() ?>administracion/areas/guardar/<?php echo $area->id; ?>"  class="form" method="post">
		<!-- .field -->
		<div class="field input">
			<label>Nombre Area: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="nombre" value="<?php echo @$area->nombre ?>" id="n_p" size="39" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="actions">
			<button type="submit" class="btn primary">
				Guardar
			</button>
		</div>
	</form>
</div>