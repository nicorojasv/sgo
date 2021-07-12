<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>extras/js/cleditor/jquery.cleditor.css" />
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/cleditor/jquery.cleditor.min.js"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.form.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.blockUI.js' type="text/javascript" language="javascript"></script>
<div class="grid grid_17">
	<?php echo @$aviso; ?>
	<h2>Publicar noticia</h2>
	<form enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/noticia/guardar_noticia" method="post" class="form">
		<div class="field select">
			<label>Categoria:</label>
			<div class="fields">
				<select name="select_cat">
					<option value="0">Seleccione...</option>
					<?php foreach($cat_noticias as $c){ ?>
					<option value="<?php echo $c->id ?>"><?php echo $c->nombre ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="field select">
			<label>Usuarios:</label>
			<div class="fields">
				<select name="select_usuarios">
					<option value="0">Todos</option>
					<?php foreach($tipos as $t){ ?>
					<option value="<?php echo $t->id ?>"><?php echo ucwords(mb_strtolower($t->desc_tipo_usuarios,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="field input">
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
<div class="grid grid_7">
	<a href="<?php echo base_url() ?>administracion/publicaciones/publicar" class="btn xlarge primary dashboard_add"><span></span>Publicar Noticia</a>
	<a href="<?php echo base_url() ?>administracion/noticia/buscar" class="btn xlarge secondary dashboard_add">Noticias Publicadas</a>
	<div class="box">
		<h3>Categorias</h3>
		<ul class="contact_details">
			<?php foreach($cat_noticias as $n){ ?>
			<li><?php echo $n->nombre ?></li>
			<?php } ?>
		</ul>
		<h4><a href="#modal" class="dialog">Agregar nueva categoria</a></h4>
	</div>
</div>
<!-- OVERLAY CON EL INGRESO DE UNA CATEGORIA -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de nueva categoria</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese una nueva categoria.
			</p>
			<form action="<?php echo base_url() ?>administracion/noticia/ingresar_categoria" method="post" class="form">
				<div class="field">
					<label for="email">Nombre</label>
					<div class="fields">
						<input type="text" name="cat" value="" id="cat" size="30" tabindex="1">
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