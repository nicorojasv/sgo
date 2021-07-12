<div class="span8" style="margin-left:40px">
	<?php echo @$aviso; ?>
	<form enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/evaluaciones/subir" method="post" class="form">
		<h2>Subir archivo</h2>
		<p>Favor seleccione el archivo que desea subir. La extencion de los archivos soportados son .xls y .xlsx.</p>
		<p>Si desea descargar una <b>plantilla guia</b> para la evaluacion <b>medica</b> puede hacerlo en <a href="<?php echo base_url() ?>extras/evaluaciones/plantilla_guia_medica.xls" target="_blank">este enlace</a>, por el contrario, si desea descargar una <b>plantilla guia</b>
			para la evaluación de <b>desempeño</b> puede hacerlo en <a href="#" target="_blank">este enlace</a>.
		</p>
		<!-- .fields -->
		<div class="field file">
			<label>Archivo:</label>
			<div class="fields">
				<input type="file" name="archivo" id="file">
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