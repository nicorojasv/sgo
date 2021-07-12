<script src="<?php echo base_url() ?>extras/js/subir_trabajador.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<form enctype="multipart/form-data" action="<?php echo base_url()?>administracion/trabajadores/subir" method="post" class="form">
		<h2>Subir archivo</h2>
		<p>Aquí podrá agregar trabajadores mediante un archivo, favor seleccione el archivo que desea subir. La extencion de los archivos soportados son .xls y .xlsx.<br/>
		Si desea descargar una <b>planilla guia</b>, puede hacerlo en <a id="link-guia" href="<?php echo base_url() ?>administracion/trabajadores/generar_excel">este enlace</a>. <span id="salida-generada"></span></p>
		<!-- .fields -->
		<div class="field file">
			<label>Archivo:</label>
			<div class="fields">
				<input type="file" name="archivo" id="file" />
			</div>
			<!-- .fields -->
		</div>
		<!-- .fields -->
		<div class="actions">
			<button type="submit" class="btn primary">
				Subir archivo
			</button>
		</div>
		<!-- .actions -->
	</form>
</div>