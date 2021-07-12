<div id="modal">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Adjuntar Documento</h3>
	</div>
	<div id="modal_content">
		<div  style="width: 400px;">
			<?php if(@$eval){ ?>
			<p>Actualmente <b>existe un archivo adjuntado en esta evaluación</b>. Para eliminar el archivo presione <a href="#" title="eliminar archivo" rel="<?php echo $eval ?>" >aqui</a> o si decide subir uno nuevo, se sobrescribirá.</p>
			<?php } ?>
			<form class="form" id="form_modal" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/evaluaciones/subir_archivo/">
			<div class="field input">
				<label>Archivo:</label>
				<div class="fields">
					<input type="file" name="documento" />
					<input type="hidden" name="redirect" value="<?php echo $redirect ?>" />
					<input type="hidden" name="id_eval" value="<?php echo $id_eval ?>" />
				</div>
				<!-- .fields -->
			</div>
			<div class="actions">
				<button type="submit" class="btn primary" id="subir_documento">
					Guardar
				</button>
			</div>
			</form>
		</div>
	</div>
</div>