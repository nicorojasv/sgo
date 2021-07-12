<script src="<?php echo base_url() ?>extras/js/administracion/crear_planta.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Editar Planta</h2>
	<form id="form_mandante" action="<?php echo base_url() ?>administracion/plantas/guardar/<?php echo $planta->id ?>"  class="form" method="post">
		<div class="field select">
			<label>Empresa: <span class="required">*</span></label>
			<div class="fields">
				<select name="empresa" class="required1">
					<option value="">Seleccione...</option>
					<?php foreach($listado_empresas as $e){ ?>
					<option value="<?php echo $e->id ?>" <?php if($planta->id_empresa==$e->id){ echo 'SELECTED'; } ?>><?php echo ucwords(mb_strtolower($e->razon_social,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Nombre: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="nombre" value="<?php echo $planta->nombre ?>" id="n_p" size="39" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Telefono: <span class="required">*</span></label>
			<div class="fields">
				<?php
				if ($planta->fono)
					$fono = explode('-',$planta->fono); 
				?>
				<input type="text" name="fono_cod" value="<?php echo @$fono[0]; ?>" id="phone1" size="2" class="required1 input-mini">
				-
				<input type="text" name="fono_num" value="<?php echo @$fono[1]; ?>" id="phone2" size="12" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Direccion: <span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="direccion" value="<?php echo $planta->direccion ?>" id="fname" size="39" class="required1">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field input">
			<label>Email:</label>
			<div class="fields">
				<input type="text" name="email" value="<?php echo $planta->email; ?>" id="fname" size="39">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field select">
			<label>Región: <span class="required">*</span></label>
			<div class="fields">
				<select name="region" id="select_region" class="required1">
					<option value="">Seleccione una región...</option>
					<?php foreach($listado_regiones as $lr){ ?>
					<option value="<?php echo $lr->id; ?>" <?php if($planta->id_regiones==$lr->id){ echo 'SELECTED'; } ?>><?php echo $lr->desc_regiones; ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .fields -->
		<div class="field select">
			<label>Provincia: <span class="required">*</span></label>
			<div class="fields">
				<select name="provincia" id="select_provincia" class="required1">
					<option value="">Seleccione una provincia...</option>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .fields -->
		<div class="field select">
			<label>Ciudad: <span class="required">*</span></label>
			<div class="fields">
				<select name="ciudad" id="select_ciudad" class="required1">
					<option value="">Seleccione una ciudad...</option>
				</select>
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
	<a href="<?php echo base_url() ?>administracion/plantas/buscar" class="btn xlarge primary dashboard_add"><span></span>Buscar</a>
	<div class="box">
		<h3>Plantas/Sucursales agregadas</h3>
		<ul class="contact_details">
			<li>Seleccione una empresa para ver sus plantas/sucursales</li>
		</ul>
	</div>
</div>