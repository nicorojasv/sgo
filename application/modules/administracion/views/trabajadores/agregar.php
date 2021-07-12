<script src="<?php echo base_url() ?>extras/js/wizard.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/administracion/jquery.Rut.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/administracion/ingreso_trabajador.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<ul class="stepy-titles">
		<li id="wizard-1" class="current-step">
			General<span>datos basicos</span>
		</li>
		<li id="wizard-2" class="">
			Otros datos<span>datos extra</span>
		</li>
		<li id="wizard-3" class="">
			Tecnicos<span>datos tecnicos</span>
		</li>
	</ul>
	<form id="form_trabajador" class="form" method="post" action="<?php echo base_url() ?>administracion/trabajadores/guardar"  >
		<fieldset title="Thread 1" id="wizard-step-1" class="step" style="display: block; ">
			<legend>
				my description one
			</legend>
			<div class="field input">
				<label>Rut: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="rut" value="<?php echo $texto_anterior['rut_usuario']; ?>" id="input_rut" size="15" class="required1" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nombres: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="nombres" value="<?php echo $texto_anterior['nombres']; ?>" id="nombres" size="39" class="required1">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Apellidos: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="paterno" value="<?php echo $texto_anterior['paterno']; ?>" id="paterno" size="15" class="required1" >
					&nbsp;&nbsp;
					<input type="text" name="materno" value="<?php echo $texto_anterior['materno']; ?>" id="materno" size="15" class="required1" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Telefono: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="fono1" value="<?php echo $texto_anterior['fono1']; ?>" id="phone1" style="width: 40px;" size="2" class="required1" >
					-
					<input type="text" name="fono2" value="<?php echo $texto_anterior['fono2']; ?>" id="phone2" size="12" class="required1">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Telefono:</label>
				<div class="fields">
					<input type="text" name="fono3" value="<?php echo $texto_anterior['fono3']; ?>" id="phone1" size="2" style="width: 40px;">
					-
					<input type="text" name="fono4" value="<?php echo $texto_anterior['fono4']; ?>" id="phone2" size="12">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Direccion: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="direccion" value="<?php echo $texto_anterior['direccion']; ?>" id="dire" size="39" class="required1" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Email:</label>
				<div class="fields">
					<input type="text" name="email" value="<?php echo $texto_anterior['email']; ?>" id="email" size="39">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Contraseña: <span class="required">*</span></label>
				<div class="fields">
					<input type="password" name="pass1" value="" id="fname" size="39" class="required1" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Repetir: <span class="required">*</span></label>
				<div class="fields">
					<input type="password" name="pass2" value="" id="fname" size="39" class="required1" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Región: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_region" id="select_region">
						<option value="">Seleccione una región...</option>
						<?php foreach($listado_regiones as $lr){ ?>
						<option value="<?php echo $lr->id; ?>"><?php echo $lr->desc_regiones; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="field select">
				<label>Provincia: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_provincia" id="select_provincia">
						<option value="">Seleccione una provincia...</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="field select">
				<label>Ciudad: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_ciudad" id="select_ciudad">
						<option value="">Seleccione una ciudad...</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<p id="custom-buttons-0" class="stepy-buttons">
				<a id="custom-next-0" href="#" class="button-next btn small grey">Siguiente</a>
			</p>
		</fieldset>
		<fieldset title="Thread 2" id="wizard-step-2" class="step" style="display: none; ">
			<legend>
				my description two
			</legend>
			<div class="field select">
				<label>Nacionalidad:</label>
				<div class="fields">
					<select name="nacionalidad">
						<option value="">Seleccione...</option>
						<option value="chilena" <?php if($texto_anterior['nacionalidad'] == "chilena") echo "selected='true'"; ?> >Chilena</option>
						<option value="extranjera" <?php if($texto_anterior['nacionalidad'] == "extranjera") echo "selected='true'"; ?>>Extranjera</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Fecha nacimiento:</label>
				<div class="fields">
					<select name="select_nac_dia" style="width: 65px;">
						<option value="">Dia</option>
						<?php for($i=1;$i<32;$i++){ ?>
						<option value="<?php echo $i ?>" <?php if($texto_anterior['nac_dia'] == $i) echo "selected='true'"; ?> ><?php echo $i ?></option>
						<?php } ?>
					</select>
					<select name="select_nac_mes" style="width: 120px;">
						<option value="">Mes</option>
						<?php for($i=1;$i<13;$i++){ ?>
						<option value="<?php echo $i ?>" <?php if($texto_anterior['nac_mes'] == $i) echo "selected='true'"; ?>><?php echo $meses[$i-1] ?></option>
						<?php } ?>
					</select>
					<select name="select_nac_ano" style="width: 70px;">
						<option value="">Año</option>
						<?php for($i=2000;$i>1935;$i--){ ?>
						<option value="<?php echo $i ?>" <?php if($texto_anterior['nac_ano'] == $i) echo "selected='true'"; ?> ><?php echo $i ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>AFP:</label>
				<div class="fields">
					<select name="select_afp" id="select_afp">
						<option value="">Selecione...</option>
						<?php foreach($listado_afp as $afp){ ?>
							<option value="<?php echo $afp->id; ?>" <?php if($texto_anterior['id_afp'] == $afp->id) echo "selected='true'"; ?>><?php echo $afp->desc_afp; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Sistema de salud:</label>
				<div class="fields">
					<select name="select_salud" id="select_salud">
						<option value="">Selecione...</option>
						<?php foreach($listado_salud as $sa){ ?>
							<option value="<?php echo $sa->id; ?>" <?php if($texto_anterior['id_salud'] == $sa->id) echo "selected='true'"; ?> ><?php echo $sa->desc_salud; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Sexo:</label>
				<div class="fields">
					<select name="select_sexo" id="select_sexo">
						<option value="">Selecione...</option>
						<option value="0" <?php if($texto_anterior['sexo'] == 0) echo "selected='true'"; ?>>Masculino</option>
						<option value="1" <?php if($texto_anterior['sexo'] == 1) echo "selected='true'"; ?>>Femenino</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Estado civil:</label>
				<div class="fields">
					<select name="select_civil" id="select_civil">
						<option value="">Selecione...</option>
						<?php foreach($listado_civil as $cv){ ?>
							<option value="<?php echo $cv->id; ?>" <?php if($texto_anterior['id_estadocivil'] == $cv->id) echo "selected='true'"; ?>><?php echo $cv->desc_estadocivil; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Profesión:</label>
				<div class="fields">
					<select name="select_profesion" id="select_profesion" class="cortar_select2">
						<option value="">Selecione...</option>
						<?php foreach($listado_profesiones as $pf){ ?>
							<option value="<?php echo $pf->id; ?>" <?php if($texto_anterior['id_profesiones'] == $pf->id) echo "selected='true'"; ?> ><?php echo $pf->desc_profesiones; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Especialidad:</label>
				<div class="fields">
					<select name="select_especialidad" id="select_especialidad" class="cortar_select2">
						<option value="">Selecione...</option>
						<?php foreach($listado_especialidades as $es){ ?>
							<option value="<?php echo $es->id; ?>" <?php if($texto_anterior['id_especialidad_trabajador'] == $es->id) echo "selected='true'"; ?> ><?php echo $es->desc_especialidad; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Especialidad:</label>
				<div class="fields">
					<select name="select_especialidad2" id="select_especialidad2" class="cortar_select2">
						<option value="">Selecione...</option>
						<?php foreach($listado_especialidades as $es){ ?>
							<option value="<?php echo $es->id; ?>" <?php if($texto_anterior['id_especialidad_trabajador_2'] == $es->id) echo "selected='true'"; ?> ><?php echo $es->desc_especialidad; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Banco:</label>
				<div class="fields">
					<select name="select_banco" id="banco">
						<option value="">Selecione...</option>
						<?php foreach($listado_bancos as $bc){ ?>
							<option value="<?php echo $bc->id; ?>" <?php if($texto_anterior['id_bancos'] == $bc->id) echo "selected='true'"; ?>><?php echo $bc->desc_bancos; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Tipo de cuenta:</label>
				<div class="fields">
					<input type="text" name="t_cuenta" value="<?php echo $texto_anterior['tipo_cuenta']; ?>" id="cuenta" size="22">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nº de cuenta:</label>
				<div class="fields">
					<input type="text" name="n_cuenta" value="<?php echo $texto_anterior['cuenta_banco']; ?>" id="n_cuenta" size="22">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Talla de buzo:</label>
				<div class="fields">
					<select name="select_talla" id="select_talla">
						<option value="">Selecione...</option>
						<option <?php if($texto_anterior['talla_buzo'] == "S") echo "selected='true'"; ?> >S</option>
						<option <?php if($texto_anterior['talla_buzo'] == "M") echo "selected='true'"; ?>>M</option>
						<option <?php if($texto_anterior['talla_buzo'] == "L") echo "selected='true'"; ?>>L</option>
						<option <?php if($texto_anterior['talla_buzo'] == "XL") echo "selected='true'"; ?>>XL</option>
						<option <?php if($texto_anterior['talla_buzo'] == "XXL") echo "selected='true'"; ?>>XXL</option>
						<option <?php if($texto_anterior['talla_buzo'] == "XXXL") echo "selected='true'"; ?>>XXXL</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nº zapato:</label>
				<div class="fields">
					<input type="text" name="n_zapato" maxlength="2" value="<?php echo $texto_anterior['num_zapato']; ?>" id="zapato" size="8">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Licencia de conducir:</label>
				<div class="fields">
					<input type="text" name="licencia" maxlength="2" value="<?php echo $texto_anterior['licencia']; ?>" id="licencia" size="2">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<p id="custom-buttons-1" class="stepy-buttons">
				<a id="custom-back-1" href="#" class="button-back btn small grey">Volver</a><a id="custom-next-1" href="#" class="button-next btn small grey">Siguente</a>
			</p>
		</fieldset>
		<fieldset title="Thread 3" id="wizard-step-3" class="step" style="display: none; ">
			<legend>
				my description three
			</legend>
			<div class="field select">
				<label>Nivel de estudios:</label>
				<div class="fields">
					<select name="select_estudios" id="select_estudios">
						<option value="">Selecione...</option>
						<?php foreach($listado_estudios as $ne){ ?>
							<option value="<?php echo $ne->id; ?>" <?php if($texto_anterior['id_estudios'] == $ne->id) echo "selected='true'"; ?> ><?php echo $ne->desc_nivelestudios; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Institución:</label>
				<div class="fields">
					<input type="text" name="institucion" value="<?php echo $texto_anterior['institucion']; ?>" id="institucion" size="25">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Año de egreso:</label>
				<div class="fields">
					<input type="text" name="a_egreso" maxlength="4" value="<?php echo $texto_anterior['ano_egreso']; ?>" id="egreso" size="12">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Años de experiencia:</label>
				<div class="fields">
					<input type="text" name="a_experiencia" maxlength="2" value="<?php echo $texto_anterior['ano_experiencia']; ?>" id="a_experiencia" size="12">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Cursos relevantes:</label>
				<div class="fields">
					<textarea name="cursos" rows="8" cols="45"><?php echo $texto_anterior['cursos']; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="field input">
				<label>Equipos que maneja:</label>
				<div class="fields">
					<textarea name="equipos" rows="8" cols="45"><?php echo $texto_anterior['equipos']; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="field input">
				<label>Software que maneja:</label>
				<div class="fields">
					<textarea name="software" rows="8" cols="45"><?php echo $texto_anterior['software']; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="field input">
				<label>Idiomas:</label>
				<div class="fields">
					<textarea name="idiomas" rows="8" cols="45"><?php echo $texto_anterior['idiomas']; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Guardar
				</button>
			</div>
			<!-- .actions -->
			<p id="custom-buttons-2" class="stepy-buttons">
				<a id="custom-back-2" href="#" class="button-back btn small grey">Volver</a>
			</p>
		</fieldset>
	</form>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/trabajadores/agregar" class="btn xlarge primary dashboard_add"><span></span>Agregar Trabajador</a>
	<a href="#" class="btn xlarge secondary dashboard_add">Subir Archivo</a>
	<a href="<?php echo base_url() ?>administracion/trabajadores/buscar" class="btn xlarge tertiary dashboard_add">Buscar</a>
</div>