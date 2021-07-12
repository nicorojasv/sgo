<script src="<?php echo base_url() ?>extras/js/internos.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<form id="form_trabajador" class="form" method="post" action="<?php echo base_url()?>administracion/internos/guardar" >
		<div class="field select">
			<label>Cargo: <span class="required">*</span></label>
			<div class="fields">
				<select name="cargo" class="required1">
					<option value="">Seleccione...</option>
					<?php foreach($listado_tipo as $l){ ?>
					<option value="<?php echo $l->id ?>"><?php echo ucwords(mb_strtolower($l->desc_tipo_usuarios,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Nombres: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="nombres" value="<?php echo @$texto_anterior['nombres'] ?>" id="nombres" size="39" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Apellidos: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="paterno" value="<?php echo @$texto_anterior['paterno'] ?>" id="fname" size="15"   >
				&nbsp;&nbsp;
				<input type="text" name="materno" value="<?php echo @$texto_anterior['materno'] ?>" id="lname" size="15" class="required1" >
			</div>
			<!-- .fields -->
		</div>
		<!-- .fields -->
		<div class="field input">
			<label>Rut: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="rut" value="<?php echo @$texto_anterior['rut_usuario'] ?>" id="fname" size="15" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Email:</label>
			<div class="fields">
				<input type="text" name="email" value="<?php echo @$texto_anterior['email'] ?>" id="email" size="29" >
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Telefono: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="fono_cod" value="<?php echo @$texto_anterior['fono1'] ?>" id="phone1" size="2" class="required1 input-mini">
				-
				<input type="text" name="fono_num" value="<?php echo @$texto_anterior['fono2'] ?>" id="phone2" size="12" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Dirección:</label>
			<div class="fields">
				<input type="text" name="dir" value="<?php echo @$texto_anterior['direccion'] ?>" id="dir" size="29" >
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Contraseña:</label>
			<div class="fields">
				generar <input type="radio" name="contra" value="pass2" id="pass2"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				manual <input type="radio" name="contra" value="pass" id="pass"/>
			</div>
			<!-- .fields -->
		</div>
		<div class="field input pass" style="display:none;">
			<label>Contraseña: <span class="required">*</span></label>
			<div class="fields">
				<input type="password" name="pass1" value="" id="pass1" size="29" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<div class="field input pass" style="display:none;">
			<label>Repetir Contraseña:<span class="required">*</span></label>
			<div class="fields">
				<input type="password" name="pass2" value="" id="pass2" size="29" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<div class="field input pass2" style="display:none;">
			<label>Generada: </label>
			<div class="fields">
				<input type="text" name="pass3" value="<?php echo $pass_generada ?>" id="pass3" size="29" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<div class="actions">
			<button type="submit" class="btn primary">
				Guardar
			</button>
		</div>
		<!-- .actions -->
	</form>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/internos/agregar" class="btn xlarge primary dashboard_add"><span></span>Agregar usuario interno</a>
	<a href="<?php echo base_url() ?>administracion/internos/buscar" class="btn xlarge secondary dashboard_add">Buscar</a>
</div>