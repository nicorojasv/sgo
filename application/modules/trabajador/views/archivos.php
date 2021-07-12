<?php echo @$avisos; ?>
<link href="<?php echo base_url() ?>extras/css/subir_archivo.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/jquery.si.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/subir_archivo.js" type="text/javascript"></script>
<div class="span8">
	<h2>Subir un archivo al sistema</h2>
	<p>
		Favor seleccione que <b>tipo de archivo</b> desea subir. La extencion de los archivos soportados son <b>Word (.doc) y Pdf (.pdf)</b>, el <b>tamaño maximo</b> de cada 
		archivo es de <b>5MB</b>. Usted puede ingresar un <strong>maximo</strong> de 7 archivos.
	</p>
	<form enctype="multipart/form-data" action="<?php echo base_url() ?>trabajador/archivos/guardar" method="post" class="form">
		<div class="field select">
			<label>Tipo de archivo:</label>
			<div class="fields">
				<select name="select_archivo" id="select_archivo">
					<option value="">Seleccione el tipo de archivo...</option>
					<?php foreach($listado_tipo as $lt){ ?>
					<option value="<?php echo $lt->id; ?>"><?php echo $lt->desc_tipoarchivo; ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field file">
			<label>Documento:</label>
			<div class="fields">
				<input type="file" name="documento" id="documento">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="actions">
			<button type="submit" class="btn primary">
				Subir archivo
			</button>
		</div>
		<!-- .actions -->
	</form>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>trabajador/archivos/subir" class="btn xlarge primary dashboard_add"><span></span>Subir Archivo</a>
	<a href="<?php echo base_url() ?>trabajador/archivos/buscar" class="btn xlarge secondary dashboard_add">Buscar Archivo</a>
</div>