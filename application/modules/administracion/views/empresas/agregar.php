<script src="<?php echo base_url() ?>extras/js/wizard.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<form id="form_trabajador" class="form" method="post" action="<?php echo base_url()?>administracion/empresas/guardar" >
		<div class="field input">
			<label>Razón Social: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="razon" value="" id="razon" size="29" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Rut: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="rut" value="" id="fname" size="15" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Giro:</label>
			<div class="fields">
				<input type="text" name="giro" value="" id="giro" size="29" >
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Dirección: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="dir" value="" id="dir" size="29" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Sitio Web:</label>
			<div class="fields">
				<input type="text" name="web" value="" id="web" size="29">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="actions">
			<button type="submit" class="btn primary">
				Guardar
			</button>
		</div>
		<!-- .actions -->
	</form>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/empresas/agregar" class="btn xlarge primary dashboard_add"><span></span>Agregar Empresa</a>
	<a href="<?php echo base_url() ?>administracion/empresas/buscar" class="btn xlarge secondary dashboard_add">Buscar</a>
</div>