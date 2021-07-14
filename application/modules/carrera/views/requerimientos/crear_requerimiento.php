<div class="panel panel-white" >
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> CREAR REQUERIMIENTO</h4>
	</div>
	<div class="panel-body">
		<form action="<?php echo base_url() ?>carrera/requerimientos/guardar_datos_requerimiento" class="smart-wizard form-horizontal" role="form" id="form" method='post' name="formulario">
			<div id="wizard" class="swMain">
				<ul class="anchor">
					<li>
						<a href="#step-1" class="selected" isdone="1" rel="1">
							<div class="stepNumber">
								1
							</div>
							<span class="stepDesc"> Paso 1
								<br>
								<small>Crear Requerimiento</small>
							</span>
						</a>
					</li>
					<li>
						<a href="#step-2" class="disabled" isdone="0" rel="2">
							<div class="stepNumber">
								2
							</div>
							<span class="stepDesc"> Paso 2
								<br>
								<small>Asignaci&oacute;n de areas,cargos y cantidad de usuarios</small>
							</span>
						</a>
					</li>
				</ul>
				<div class="stepContainer" style="height: 353px;">
					<div class="progress progress-xs transparent-black no-radius active content">
						<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar partition-green step-bar" style="width: 25%;">
							<span class="sr-only"> 0% Complete (success)</span>
						</div>
					</div>
					<div id="step-1" class="content" style="display: block;">
						<h2 class="StepTitle">Crear Requerimiento</h2>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Codigo Requerimiento
							</label>
							<div class="col-sm-7">
								<input type="text" name="codigo_requerimiento" class="form-control" value="" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Codigo Centro Costo
							</label>
							<div class="col-sm-7">
								<input type="text" name="codigo_centro_costo" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Nombre Solicitud <span class="symbol required"></span>
							</label>
							<div class="col-sm-7">
								<input type="text" name="n_solicitud" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Fecha Solicitud <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<div class="input-group">
									<input type="text"  name="f_solicitud" class="form-control date-picker2" autocomplete="off" required>
									<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								Regimen <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<div class="row">
									<div class="col-md-12">
										<select name="select_regimen" id="select_regimen" class="form-control" required>
											<option value="">Seleccione...</option>
											<option value="NL">Normal</option>
											<option value="CTG">CONTINGENCIA</option>
											<option value="URG">URGENCIA</option>
										</select>
									</div>
								</div> 
							</div> 
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Centro Costo <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<div class="row">
									<div class="col-md-12">
										<select name="select_empresa" id="select_empresa" class="form-control" required>
											<option value="">Seleccione...</option>
											<?php foreach ($listado_empresa as $ep) { ?>
											<option value="<?php echo $ep->id ?>"><?php echo $ep->razon_social ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Sucursal <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<div class="row">
									<div class="col-md-12">
										<select name="select_planta" id="select_planta" class="form-control" required>
											<!--<option value="">Seleccione...</option>-->
											<?php foreach ($unidad_negocio as $un) { ?>
											<option value="<?php echo $un->id ?>"><?php echo ucwords(mb_strtolower($un->nombre,'UTF-8')) ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Motivo <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<input type="text" name="motivo" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Causal <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<select name="causal" id="causal" class="form-control" required>
									<option value="">Seleccione...</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
									<option value="D">D</option>
									<option value="E">E</option>
								</select>
							</div>
						</div>
						<div class="form-group">	
							<label class="col-sm-3 control-label">
								Inicio / Fin <span class="symbol required"></span>
							</label>
							<div class="col-sm-7" >
								<div class="row">
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" name="fdesde" class="form-control date-picker" autocomplete="off" required>
											<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" name="fhasta" class="form-control date-picker" autocomplete="off"  required>
											<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								Comentarios
							</label>
							<div class="col-sm-7" >
								<textarea class="form-control" name="comentarios"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2 col-sm-offset-8">
								<button type="submit" class="btn btn-success btn-block ">
									Guardar <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>