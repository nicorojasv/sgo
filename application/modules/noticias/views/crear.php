<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Crear Publicaci&oacute;n</h4>
	</div>
	<div class="panel-body">
		<div class="col-sm-12">
			<form action="<?php echo base_url() ?>noticias/guardar" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label>
						Tipo de Publicaci&oacute;n
					</label>
					<div>
						<select class="form-control" name="select_publicaciones" required>
							<option value="">Seleccione...</option>
							<?php foreach ($lista_tipo as $l) { ?>
								<option value="<?php echo $l->id ?>"><?php echo $l->nombre ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label>
						Categoria
					</label>
					<div>
						<select class="form-control" name="select_cat" required>
							<option value="">Seleccione...</option>
							<?php foreach ($lista_categoria as $l) { ?>
								<option value="<?php echo $l->id ?>"><?php echo $l->nombre ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<!--<div class="form-group">
					<label>
						Usuarios
					</label>
					<select class="form-control" name="select_usuarios" required>
						<option value="">Seleccione...</option>
						<option value="0">Todos</option>
						<option value="1">Por Requerimientos</option>
						<option value="2">Por Especialidad</option>
					</select>
				</div>
				<div class="form-group">
					<label>
						Enviar correo 
					</label>
					<div class="row">
					<div class="col-sm-1">
						<input style="position:left;" type="checkbox" name="env_email" class="form-control" /> 
					</div>
					<div class="col-sm-11">
					</div>
					</div>
				</div>-->
				<div class="form-group">
					<div class="col-sm-13">
						<label>
							Adjuntar
						</label>
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-group">
								<div class="form-control uneditable-input">
									<i class="fa fa-file fileupload-exists"></i>
									<span class="fileupload-preview"></span>
								</div>
								<div class="input-group-btn">
									<div class="btn btn-light-grey btn-file">
										<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
										<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
										<input type="file" class="file-input" name="doc">
									</div>
									<a href="form_elements.html#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
										<i class="fa fa-times"></i> Remove
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>
						Titulo
					</label>
					<div>
						<input type="text" name="titulo" class="form-control" required>
					</div>
				</div>
				<div class="form-group">
					<div class="noteWrap">
						<div class="form-group">
							<textarea class="summernote" name="texto" placeholder="Escriba aqui..."></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>
					</label>
					<div class="col-sm-2">
						<input type="submit" class="form-control btn btn-primary" value="Guardar">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>