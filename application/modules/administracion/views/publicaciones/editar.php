<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>extras/js/cleditor/jquery.cleditor.css" />
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/cleditor/jquery.cleditor.min.js"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.form.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.MultiFile.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/fileupload/jquery.blockUI.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url() ?>extras/js/administracion/publicaciones.js' type="text/javascript" language="javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#textarea").cleditor();
  });
</script>
<div class="grid grid_17">
	<?php echo @$aviso; ?>
	<form enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/publicaciones/editar_publicacion" method="post" class="form">
		<input type="hidden" name="select_publicaciones" value="<?php echo $tipo ?>" />
		<div class="field select"  <?php if($tipo != 1){ ?> style="display:none;" <?php } ?>>
			<label>Categoria:</label>
			<div class="fields">
				<select name="select_cat">
					<option value="0">Seleccione...</option>
					<?php foreach($cat_noticias as $c){ ?>
					<option value="<?php echo $c->id ?>"  <?php if($c->id == $datos->categoria){ echo 'selected'; } ?>><?php echo $c->nombre ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="field select"  <?php if($tipo != 1){ ?>style="display:none;" <?php } ?>>
			<label>Usuarios:</label>
			<div class="fields">
				<select name="select_usuarios">
					<option value="0">Todos</option>
					<?php foreach($tipos as $t){ ?>
					<option value="<?php echo $t->id ?>"  <?php if($t->id == $datos->usuarios){ echo 'selected'; } ?>><?php echo ucwords(mb_strtolower($t->desc_tipo_usuarios,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- requerimiemto -->
		<div class="field select"  <?php if($tipo != 3){ ?>style="display:none;" <?php } ?>>
			<label>Requerimiento:</label>
			<div class="fields">
				<select name="select_req">
					<option value="">Todos</option>
					<?php foreach($lista_req as $r){ ?>
					<option value="<?php echo $r->id ?>" <?php if($r->id == $datos->requerimiento){ echo 'selected'; } ?> ><?php echo ucwords(mb_strtolower($r->nombre,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="field select" <?php if($tipo != 3){ ?>style="display:none;" <?php } ?>>
			<label>Area:</label>
			<div class="fields">
				<select name="select_area">
					<option value='0'>Todas</option>
					<?php
						foreach($datos->foreach_req as $a){
							$area = $this->Areas_model->get($a->id_areas);
							echo "<option value='".$a->id."' "; echo ($a->id == $datos->area)? 'selected':''; echo ">". ucwords( mb_strtolower( $area->desc_area, 'UTF-8'))."</option>";
						}
					?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- -->
		<div class="field input" id="input_titulo">
			<label>Titulo:</label>
			<div class="fields">
				<input type="text" name="titulo" size="59" value="<?php echo $datos->titulo ?>">
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
			<textarea id="textarea" name="texto"><?php echo nl2br(@$datos->texto) ?></textarea>
			<input type="hidden" name="id" value="<?php echo @$datos->id ?>" />
		</div>
		<div class="actions">
			<button type="submit" class="btn primary">
				Editar
			</button>
		</div>
		<!-- .actions -->
	</form>
</div>
<div class="grid grid_7">
	<a href="<?php echo base_url() ?>administracion/publicaciones/buscar" class="btn xlarge primary dashboard_add">Publicaciones</a>
	<div class="box">
		<h3>Categorias de noticias</h3>
		<ul class="contact_details">
			<?php foreach($cat_noticias as $n){ ?>
			<li><?php echo ucwords( mb_strtolower($n->nombre, 'UTF-8')) ?> <a class="eliminar_categoria" title="Eliminar" style="position: absolute;margin-top: -8px" href="<?php echo base_url() ?>administracion/publicaciones/eliminar_categorias_noticias/<?php echo encrypt($n->id) ?>"><img src="<?php echo base_url() ?>extras/img/delete-2.png" /></a></li>
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