<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>extras/js/cleditor/jquery.cleditor.css" />
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/cleditor/jquery.cleditor.min.js"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.form.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.blockUI.js' type="text/javascript" language="javascript"></script>
<!--<script src='<?php echo base_url() ?>extras/js/administracion/publicaciones.js' type="text/javascript" language="javascript"></script>-->
<script type="text/javascript">
  $(document).ready(function() {
    $("#textarea").cleditor();
  });
</script>
<div class="span8">
	<?php echo @$aviso; ?>
	<form enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/ofertas/guardar_publicacion" method="post" class="form">
		
		<div class="field select" id="select_usuarios" >
			<label>Usuarios:</label>
			<div class="fields">
				<select multiple name="select_usuarios[]">
					<option value="0">Todos</option>
					<?php foreach($tipos as $t){ ?>
					<option value="<?php echo $t->id ?>"><?php echo ucwords(mb_strtolower($t->desc_tipo_usuarios,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="field select" id="envio_mail">
			<label>Enviar correo:</label>
			<div class="fields">
				<input type="checkbox" name="env_email" /> 
			</div>
			<!-- .fields -->
		</div>
		<!-- TITULO -->
		<div class="field input" id="input_titulo">
			<label>Titulo:</label>
			<div class="fields">
				<input type="text" name="titulo" size="59">
			</div>
			<!-- .fields -->
		</div>
		<div class="field input">
			<label>Adjuntar:</label>
			<div class="fields">
				<input type="file" name="doc[]" size="59" class="multi" accept="doc|docx|pdf" maxlength="4">
			</div>
			<!-- .fields -->
		</div>
		<div class="field input">
			<textarea id="textarea" name="texto"></textarea>
		</div>
		<div class="actions">
			<button type="submit" class="btn primary">
				Publicar
			</button>
		</div>
		<!-- .actions -->
	</form>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/ofertas/buscar" class="btn xlarge primary dashboard_add">Ofertas Laborales</a>
</div>