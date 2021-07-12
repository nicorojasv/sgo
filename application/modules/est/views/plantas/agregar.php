<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Ingresar Unidad de negocio</h4>
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
		<form id="form_mandante" action="" class="form-horizontal" method="post">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Nombre:
				</label>
				<div class="col-sm-9">
					<input type="text" name="nombre" value="<?php echo @$texto_anterior['nombre'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>
			<!-- .field -->
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Telefono:
				</label>
				<div class="col-sm-1">
					<input type="text" name="fono_cod" value="<?php echo @$texto_anterior['fono1'] ?>" id="n_p" size="39" class="form-control">
				</div>
				<div class="col-sm-8">
					<input type="text" name="fono_num" value="<?php echo @$texto_anterior['fono2'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>

			<!-- .field -->

			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Direccion:
				</label>
				<div class="col-sm-9">
					<input type="text" name="direccion" value="<?php echo @$texto_anterior['nombre'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Email:
				</label>
				<div class="col-sm-9">
					<input type="email" name="email" value="<?php echo @$texto_anterior['nombre'] ?>" id="n_p" size="39" class="form-control">
				</div>
			</div>
			<!-- .field -->
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Región:
				</label>
				<div class="col-sm-9">
					<select name="region" id="select_region" class="form-control">
						<option value="">Seleccione una región...</option>
						<?php foreach($listado_regiones as $lr){ ?>
						<option value="<?php echo $lr->id; ?>"><?php echo $lr->desc_regiones; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<!-- .fields -->
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Provincia:
				</label>
				<div class="col-sm-9">
					<select name="provincia" id="select_provincia" class="form-control">
						<option value="">Seleccione una provincia...</option>
						<?php foreach($listado_provincias as $lp){ ?>
							<option value="<?php echo $lp->id; ?>"><?php echo $lp->desc_provincias; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<!-- .field -->
			<div class="form-group">
				<label class="col-sm-2 control-label" for="form-field-1">
					Ciudad:
				</label>
				<div class="col-sm-9">
					<select name="ciudad" id="select_ciudad" class="form-control">
						<option value="">Seleccione una ciudad...</option>
						<?php foreach($listado_ciudades as $lc){ ?>
							<option value="<?php echo $lc->id; ?>"><?php echo $lc->desc_ciudades; ?></option>
						<?php } ?>
					</select>
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