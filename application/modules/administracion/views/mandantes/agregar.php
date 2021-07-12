<!-- <script src="<?php echo base_url() ?>extras/js/wizard.js" type="text/javascript"></script> -->
<script src="<?php echo base_url() ?>extras/js/crear_mandante.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<form id="form_mandante" action="<?php echo base_url() ?>administracion/mandantes/guardar"  class="form" method="post">
		<div class="field select">
			<label>Empresa: <span class="required">*</span></label>
			<div class="fields">
				<select name="empresa_select">
					<option value="">Seleccione</option>
					<?php foreach($listado_empresas as $l){ ?>
						<option value="<?php echo $l->id ?>"><?php echo ucwords( mb_strtolower( $l->razon_social , 'UTF-8') ) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field select">
			<label>Planta: <span class="required">*</span></label>
			<div class="fields">
				<select name="planta_select">
					<option value="">Seleccione</option>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="field input">
			<label>Rut:</label>
			<div class="fields">
				<input type="text" name="rut_ingreso" value="<?php echo @$texto_anterior['rut_ingreso'] ?>" id="fname" size="15" class="required3" readonly>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<!-- .fields -->
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
			<label>Codigo de Ingreso: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="codigo_ingreso" value="<?php echo @$texto_anterior['codigo_ingreso'] ?>" id="fname" size="15" class="required3" readonly>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Telefono: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="fono1" value="<?php echo @$texto_anterior['fono3'] ?>" id="phone1" size="2" class="required3 input-mini">
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
		<div class="field controlset">		
			<label>Busqueda:</label>
			<div class="fields">
				<input type="radio" name="radio_field" value="" id="radio_1">
				<label for="radio_1">Si</label>
				<input type="radio" name="radio_field" value="" id="radio_2" checked >
				<label for="radio_2">No</label>
			</div> <!-- .fields -->
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
	<a href="<?php echo base_url() ?>administracion/mandantes/agregar" class="btn xlarge primary dashboard_add"><span></span>Agregar Mandante</a>
	<a href="<?php echo base_url() ?>administracion/mandantes/buscar" class="btn xlarge secondary dashboard_add">Buscar</a>
</div>