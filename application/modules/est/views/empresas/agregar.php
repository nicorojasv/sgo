<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Ingresar Empresa</h4>
		<div class="panel-tools">										
			<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu dropdown-light pull-right" role="menu">
				<li>
					<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
				</li>
				<li>
					<a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
		<form id="form_trabajador" class="form-horizontal" method="post" action="" >
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Razón Social:
				</label>
				<div class="col-sm-9">
					<input type="text" name="razon" value="<?php echo @$texto_anterior['razon'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Rut:
				</label>
				<div class="col-sm-9">
					<input type="text" name="rut" value="<?php echo @$texto_anterior['rut'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Giro:
				</label>
				<div class="col-sm-9">
					<input type="text" name="giro" value="<?php echo @$texto_anterior['giro'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Dirección:
				</label>
				<div class="col-sm-9">
					<input type="text" name="dir" value="<?php echo @$texto_anterior['dir'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Sitio Web:
				</label>
				<div class="col-sm-9">
					<input type="text" name="web" value="<?php echo @$texto_anterior['web'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>
			<!-- .field -->
			<div class="form-group">
				<div class="col-sm-2" ></div>
				<div class="col-sm-9">
					<button type="submit" class="btn btn-primary">
						Guardar
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
