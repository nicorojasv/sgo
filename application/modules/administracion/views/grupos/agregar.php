<script src="<?php echo base_url() ?>extras/js/administracion/crear_grupo.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Ingresar Grupo</h2>
	<form id="form_mandante" action="<?php echo base_url() ?>administracion/grupos/guardar"  class="form" method="post">
		<!-- .field -->
		<div class="field input">
			<label>Nombre Grupo: <span class="required">*</span></label>
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
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/grupos/buscar" class="btn xlarge primary dashboard_add"><span></span>Buscar</a>
</div>