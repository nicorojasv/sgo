<script src="<?php echo base_url() ?>extras/js/administracion/jquery.Rut.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/crear_subusuario.js" type="text/javascript"></script>
<div class="grid grid_17">
	<?php echo @$aviso; ?>
	<h2>Creación de subusuario</h2>
	<form id="form_mandante" action="<?php echo base_url() ?>mandante/subusuarios/guardar"  class="form" method="post">
		<input type="hidden" name="planta" value="<?php echo $planta ?>" />
		<div class="field input">
			<label>Nombre: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="nombres_m" value="<?php echo @$texto_anterior['nombres'] ?>" id="username" size="29" class="required3">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Apellidos: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="paterno" value="<?php echo @$texto_anterior['paterno'] ?>" id="paterno" size="15" class="required1" >
				&nbsp;&nbsp;
				<input type="text" name="materno" value="<?php echo @$texto_anterior['materno'] ?>" id="materno" size="15" class="required1" >
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Rut:</label>
			<div class="fields">
				<input type="text" name="rut" value="<?php echo @$texto_anterior['rut_usuario'] ?>" id="fname" size="15" class="required3">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Codigo Ingreso: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="codigo_ingreso" value="<?php echo $codigo_ingreso ?>" id="fname" size="15" readonly >
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Telefono: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="fono1" value="<?php echo @$texto_anterior['fono3'] ?>" id="phone1" size="2" class="required3">
				-
				<input type="text" name="fono2" value="<?php echo @$texto_anterior['fono4'] ?>" id="phone2" size="12" class="required3">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Email:</label>
			<div class="fields">
				<input type="text" name="email_mandante" value="<?php echo @$texto_anterior['email_m'] ?>" id="fname" size="39" >
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Cargo: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="cargo" value="<?php echo @$texto_anterior['cargo_mandante'] ?>" id="fname" size="28" class="required3">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Contraseña: <span class="required">*</span></label>
			<div class="fields">
				<input type="password" name="pass1" value="" id="fname" size="39" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Repetir: <span class="required">*</span></label>
			<div class="fields">
				<input type="password" name="pass2" value="" id="fname" size="39" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<!-- <div class="field controlset">		
			<label>Busqueda:</label>
			<div class="fields">
				<input type="radio" name="radio_field" value="" id="radio_1">
				<label for="radio_1">Si</label>
				<input type="radio" name="radio_field" value="" id="radio_2" checked >
				<label for="radio_2">No</label>
			</div> <!-- .fields
		</div> -->
		<!-- .field -->
		<div class="actions">
			<button type="submit" class="btn primary">
				Guardar
			</button>
		</div>
		<!-- .actions -->
		<p id="custom-buttons-1" class="stepy-buttons">
			<a id="custom-back-1" href="#" class="button-back btn small grey">Volver</a>
		</p>
	</form>
</div>
<div class="grid grid_7">
	<a href="" class="btn xlarge primary dashboard_add"><span></span>Asignar</a>
	<a href="<?php echo base_url() ?>mandante/subusuarios/listado" class="btn xlarge secondary dashboard_add">Buscar</a>
</div>