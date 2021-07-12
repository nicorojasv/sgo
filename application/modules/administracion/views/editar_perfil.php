<div class="grid grid_17">
	<?php echo @$avisos; ?>
	<form action="<?php echo base_url() ?>administracion/perfil/guardar" method="post" class="form" enctype="multipart/form-data">
		<div class="field input">
			<label>Nombre:</label>
			<div class="fields">
				<input type="text" name="nombres" value="<?php echo $usuario->nombres ?>" id="fname" size="39">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Apellidos:</label>
			<div class="fields">
				<input type="text" name="paterno" value="<?php echo $usuario->paterno ?>" id="input_paterno" size="15">
				&nbsp;&nbsp;
				<input type="text" name="materno" value="<?php echo $usuario->materno ?>" id="input_materno" size="15">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Telefono:</label>
			<div class="fields">
				<?php if(isset($datos_usuario->fono)){ ?>
				<?php $fono = explode("-",$datos_usuario->fono); ?>
				<?php $fono1 = $fono[0]; $fono2 = $fono[1]; ?>
				<?php } ?>
				<input type="text" name="fono1" value="<?php echo @$fono1 ?>" id="phone1" size="2">
				-
				<input type="text" name="fono2" value="<?php echo @$fono2 ?>" id="phone2" size="19">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Telefono:</label>
			<div class="fields">
				<?php if(isset($datos_usuario->telefono2)){ ?>
				<?php $fon = explode("-",$datos_usuario->telefono2); ?>
				<?php $fon1 = $fon[0]; $fon2 = $fon[1]; ?>
				<?php } ?>
				<input type="text" name="fono3" value="<?php echo @$fon1 ?>" id="phone1" size="2">
				-
				<input type="text" name="fono4" value="<?php echo @$fon2 ?>" id="phone2" size="19">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Email:</label>
			<div class="fields">
				<input type="text" name="correo" value="<?php echo $usuario->email ?>" id="fname" size="29">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field file">
			<label>Imagen:</label>
			<div class="fields">
				<input type="file" name="imagen" id="imagen">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Contraseña actual:</label>
			<div class="fields">
				<input type="password" name="pass_actual" value="" id="fname" size="29">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Nueva contraseña:</label>
			<div class="fields">
				<input type="password" name="pass_nuevo1" value="" id="fname" size="29">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Repetir contraseña:</label>
			<div class="fields">
				<input type="password" name="pass_nuevo2" value="" id="fname" size="29">
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
<div class="grid grid_7">
	<a href="<?php echo base_url() ?>administracion/perfil" class="btn xlarge secondary dashboard_add"><span></span>Perfil</a>
	<a href="<?php echo base_url() ?>administracion/perfil/editar" class="btn xlarge primary dashboard_add">Editar Perfil</a>
</div>