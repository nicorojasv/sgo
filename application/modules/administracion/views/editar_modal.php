<!-- OVERLAY CON LA EDICION  -->
<div id="modal2" >
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Edición de <?php echo $modal_subtitulo; ?></h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor edite <?php echo $modal_subtitulo; ?>.
			</p>
			<form action="<?php echo base_url() ?>administracion/configuracion/<?php echo $url_editar ?>" method="post" class="form">
				<div class="field">
					<label for="nombre">Nombre:</label>
					<div class="fields">
						<input type="text" name="nombre" value="<?php echo $nb ?>" id="nombre" size="30" tabindex="1">
						<input type="hidden" name='id' value="<?php echo $id ?>" />
					</div>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary" tabindex="1">
						Crear
					</button>
				</div>
			</form>
		</div>
	</div>
	   
</div>
<!-- -->