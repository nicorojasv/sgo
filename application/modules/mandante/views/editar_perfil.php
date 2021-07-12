<script src="<?php echo base_url() ?>extras/js/administracion/jquery.Rut.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/editar_perfil.js" type="text/javascript"></script>
<div class="grid grid_6">
	<div class="tabs-side">
        <ul class="tab-nav">
            <li class="current">
                <a href="#datos-representante">
                	Datos Representante
                	<span>Lorem ipsum dolot sit amet</span>	   
                	                     
            	</a>
            </li>
            <li class="">
                <a href="#datos-imagen">
                	Imagen
                	<span>Lorem ipsum dolot sit amet</span>	   
                	                     
            	</a>
            </li>
			<li class="">
                <a href="#datos-pass">
                	Cambiar contraseña
                	<span>Actualice su contraseña</span>	                        	
            	</a>
            </li>
        </ul>
    </div>
</div>
<div class="grid grid_18">
		<div title="#datos-representante"  class="contenido-tab">
			<form action="<?php echo base_url() ?>mandante/perfil/guardar_representante" method="post" class="form">
			<h2>Datos Representante</h2>
			<?php echo @$avisos_representante; ?>
			<div class="field input">
				<label>Planta/Sucursal:</label>
				<div class="fields">
					<input type="text" name="planta" value="<?php echo ucwords(mb_strtolower($datos_planta->nombre,"UTF-8")); ?>" id="input_planta" size="36" disabled="true" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>RUT:</label>
				<div class="fields">
					<input type="text" name="rut_usuario" value="<?php echo $datos_usuario->rut_usuario; ?>" id="input_rut" size="36">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Codigo Ingreso:</label>
				<div class="fields">
					<input type="text" name="codigo_usuario" value="<?php echo $datos_usuario->codigo_ingreso; ?>" id="input_codigo" size="36" disabled="true" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nombres:</label>
				<div class="fields">
					<input type="text" name="nombres" value="<?php echo ucwords(mb_strtolower($datos_usuario->nombres,"UTF-8")); ?>" id="input_nombre" size="39">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Apellidos:</label>
				<div class="fields">
					<input type="text" name="paterno" value="<?php echo ucwords(mb_strtolower($datos_usuario->paterno,"UTF-8")); ?>" id="input_paterno" size="15">
					&nbsp;&nbsp;
					<input type="text" name="materno" value="<?php echo ucwords(mb_strtolower($datos_usuario->materno,"UTF-8")); ?>" id="input_materno" size="15">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Cargo:</label>
				<div class="fields">
					<input type="text" name="cargo" value="<?php echo ucwords(mb_strtolower($datos_usuario->cargo_mandante,"UTF-8")); ?>" id="input_cargo" size="39">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Sexo:</label>
				<div class="fields">
					<select name="select_sexo" id="select_sexo">
						<option value="">Selecione...</option>
						<option value="0" <?php echo ($datos_usuario->sexo == 0) ? "selected='TRUE'":'' ?>>Masculino</option>
						<option value="1" <?php echo ($datos_usuario->sexo == 1) ? "selected='TRUE'":'' ?>>Femenino</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Telefono:</label>
				<div class="fields">
					<?php if(isset($datos_usuario->fono)){ ?>
					<?php $telefono = explode("-",$datos_usuario->fono); ?>
					<?php $telefono1 = $telefono[0]; $telefono2 = $telefono[1]; ?>
					<?php } ?>
					<input type="text" name="fono3" value="<?php echo @$telefono1; ?>" id="fono3" size="2">
					-
					<input type="text" name="fono4" value="<?php echo @$telefono2; ?>" id="fono4" size="19">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Email:</label>
				<div class="fields">
					<input type="text" name="correo" value="<?php echo $datos_usuario->email; ?>" id="input_correo" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar mis datos
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
	<div title="#datos-imagen" class="contenido-tab">
		<form action="<?php echo base_url() ?>mandante/perfil/guardar_imagen" method="post" class="form" enctype="multipart/form-data" >
			<h2>Modificar imagen</h2>
			<?php echo @$avisos_img; ?>
			<p>Favor seleccione que tipo de imagen desea subir. La extencion de <b>los archivos soportados son .png y .jpg</b>, el <b>tamaño maximo del archivo es de 2MB</b>.</p>
			<!-- .fields -->
			<div class="field file">
				<label>Imagen:</label>
				<div class="fields">
					<input type="file" name="imagen" id="file" />
				</div>
				<!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar imagen
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
	<div title="#datos-pass" class="contenido-tab">
		<form action="<?php echo base_url() ?>mandante/perfil/editar_contrasena" method="post" class="form">
			<h2>Modificar contraseña</h2>
			<?php echo @$avisos_pass; ?>
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
					Editar contraseña
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
</div>
<!-- <div class="grid grid_7">
	<a href="<?php echo base_url() ?>trabajador/perfil" class="btn xlarge secondary dashboard_add"><span></span>Perfil</a>
	<a href="<?php echo base_url() ?>trabajador/perfil/editar" class="btn xlarge primary dashboard_add">Editar Perfil</a>
	<a href="<?php echo base_url() ?>trabajador/perfil/cambiar_contrasena" class="btn xlarge tertiary dashboard_add">Cambiar Contraseña</a>
</div> -->