<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Subir un <span class="text-bold">documentos</span></h4>
		<div class="panel-tools">										
			<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu dropdown-light pull-right" role="menu">
				<li>
					<a class="panel-collapse collapses" href="table_basic.html#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
				</li>
				<li>
					<a class="panel-refresh" href="table_basic.html#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="table_basic.html#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="table_basic.html#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="table_basic.html#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
		<p>
			For basic styling—light padding and only horizontal dividers—add the base class <code>.table</code> to any <code>&lt;table&gt;</code>. It may seem super redundant, but given the widespread use of tables for other plugins like calendars and date pickers, we've opted to isolate our custom table styles.
		</p>
		<div class="col-md-12 space20">
			<a class="btn btn-green" href="<?php echo base_url() ?>documentos/documentos/listado">
				Listado de Documentos <i class="fa fa-level-up"></i>
			</a>
		</div>
		<form role="form" class="form-horizontal" method='post' action="" enctype="multipart/form-data" > 
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-4">
					Categoria Usuario
				</label>
				<div class="col-sm-9" >
					<div class="row">
						<div class="col-md-12">
							<select name="select_tipo" id="select_tipo" class="form-control">
								<option value="">Seleccione...</option>
								<?php foreach ($lista_categoria as $c) { ?>
									<option value='<?php echo $c->id ?>'><?php echo $c->nombre ?></option>
								<?php } ?>
							</select>
						</div>
					</div> 
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-4">
					Tipo Usuario
				</label>
				<div class="col-sm-9" >
					<div class="row">
						<div class="col-md-12">
							<select name="select_categoria" id="select_categoria" class="form-control">
								<option value="">Seleccione...</option>
							</select>
						</div>
					</div> 
				</div> 
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">
					Archivo
				</label>
				<div class="col-sm-9">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-group">
							<div class="form-control uneditable-input">
								<i class="fa fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<div class="input-group-btn">
								<div class="btn btn-light-grey btn-file">
									<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Seleccionar Archivo</span>
									<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Cambiar</span>
									<input type="file" name='archivo[]' class="file-input" multiple="multiple">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
				</div>
				<div class="col-md-4">
					<button class="btn btn-yellow btn-block" type="submit">
						Guardar <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</div>
		</form>
	</div>
</div>