<div class="span8 offset1">
	<?php echo @$aviso; ?>
	<h2>Ingresar Cargo</h2>
	<form id="form_mandante" action="<?php echo base_url() ?>administracion/cargos/guardar"  class="form" method="post">
		<div class="field input">
			<label>Nombre Cargo: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="nombre" value="<?php echo @$texto_anterior['nombre'] ?>" id="n_p" size="39" class="required1">
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
	<br /><br />
</div>