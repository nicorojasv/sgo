<div class="col-md-8 col-md-offset-2">
	<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/evaluaciones/guardar_creacion_eval/<?php echo $id ?>/">
	<h3>Agregar Examen para <b><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></b></h3>
	<div class='col-md-7' >
		<div class="panel panel-white">
			<div class="panel-heading">
				<h4 class="panel-title">Panel</h4>
				<div class="panel-tools">
					<div class="dropdown">
						<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu dropdown-light pull-right" role="menu" style="display: none;">
							<li>
								<a class="panel-collapse collapses" href="ui_panels.html#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
							</li>
							<li>
								<a class="panel-expand" href="ui_panels.html#">
									<i class="fa fa-expand"></i> <span>Fullscreen</span>
								</a>
							</li>
						</ul>
					</div>
					<a class="btn btn-xs btn-link panel-close" href="ui_panels.html#">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class='col-sm-2 control-label'>Tipo de Evaluación:</label> 
					<div class="col-sm-10">
						<select style="width: 244px;" name="evaluacion">
							<option value="">Seleccione</option>
							<?php foreach($tipo as $ex){ ?>
								<option value="<?php echo $ex->id ?>"><?php echo ucwords(mb_strtolower($ex->nombre, 'UTF-8')) ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class='col-sm-2 control-label'>Evaluación:</label> 
					<div class="col-sm-10">
						<select style="width: 244px;" name="id_ee">
							<option value="">Seleccione</option>
							<?php foreach($evaluaciones as $ev){ ?>
								<option value="<?php echo $ev->id ?>"><?php echo ucwords(mb_strtolower($ev->nombre, 'UTF-8')) ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="form-group" id="div_faena" >
					<label class='col-sm-2 control-label'>Nombre Fanea:</label> 
					<div class="col-sm-10">
						<input type="text" name="faena" placeholder='Faena' style="width: 243px;" />
					</div>
				</div>

				<div class="form-group">
					<label class='col-sm-2 control-label'>Fecha evaluación:</label> 
					<div class="col-sm-10">
						<select name="dia_e" style="width: 60px;">
							<option value="" >Dia</option>
							<?php for($i=1;$i<32;$i++){ ?>
							<option ><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="mes_e" style="width: 108px;">
							<option value="">Mes</option>
							<option value='01'>Enero</option>
							<option value='02'>Febrero</option>
							<option value='03'>Marzo</option>
							<option value='04'>Abril</option>
							<option value='05'>Mayo</option>
							<option value='06'>Junio</option>
							<option value='07'>Julio</option>
							<option value='08'>Agosto</option>
							<option value='09'>Septiembre</option>
							<option value='10'>Octubre</option>
							<option value='11'>Noviembre</option>
							<option value='12'>Deciembre</option>
						</select>
						<select name="ano_e" style="width: 70px;">
							<option value="">Año</option>
							<?php $tope_f = (date('Y') - 5 ); ?>
							<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div id="div_desempeno" class="form-group">
					<label class='col-sm-2 control-label'>Fecha vigencia:</label> 
					<div class="col-sm-10">
						<select name="dia_v" style="width: 60px;">
							<option value="" >Dia</option>
							<?php for($i=1;$i<32;$i++){ ?>
							<option><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="mes_v" style="width: 108px;">
							<option value="" >Mes</option>
							<option value='01'>Enero</option>
							<option value='02'>Febrero</option>
							<option value='03'>Marzo</option>
							<option value='04'>Abril</option>
							<option value='05'>Mayo</option>
							<option value='06'>Junio</option>
							<option value='07'>Julio</option>
							<option value='08'>Agosto</option>
							<option value='09'>Septiembre</option>
							<option value='10'>Octubre</option>
							<option value='11'>Noviembre</option>
							<option value='12'>Deciembre</option>
						</select>
						<select name="ano_v" style="width: 70px;">
							<option value="">Año</option>
							<?php $tope_f = (date('Y') - 5 );  ?>
							<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class='col-sm-2 control-label'>Resultado:</label> 
					<div class="col-sm-10">
						<select name="resultado_cualitativo">
							<option value="">Seleccione</option>
							<option value="0">Aprobado</option>
							<option value="1">Rechazado</option>
						</select>
					</div>
					<!-- .fields -->
				</div>
				<div class="form-group">
					<label class='col-sm-2 control-label'>Resultado:</label> 
					<div class="col-sm-10">
						<input type="text" name="resultado_cuantitativo" placeholder='Resultado' style="width: 243px;" />
					</div>
					<!-- .fields -->
				</div>
				<div id="div_recomienda" class="form-group">
					<label class='col-sm-2 control-label'>Recomienda?:</label> 
					<div class="col-sm-10">
						<label class="radio-inline">
						   <input type="radio" name="recomienda" value='0' /> No
						</label>
						<label class="radio-inline">
						   <input type="radio" name="recomienda" value='1'/> Si
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class='col-sm-2 control-label'>Archivo:</label> 
					<div class="col-sm-10">
						<input type="file" name="docu" />
					</div>
					<!-- .fields -->
				</div>
				<div class="form-group">
					<label class='col-sm-2 control-label'>Observación:</label> 
					<div class="col-sm-10">
						<textarea class="form-control" name="obs" cols="40" rows="5"></textarea>
					</div>
					<!-- .fields -->
				</div>
				<div class="actions">
					<button type="submit" class="btn pull-right" id="guardar_nuevo_examen">
						Guardar
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class='col-md-5'>
		<div class="form-group">
			<div class="col-sm-10">
				<label class="radio-inline">
				   <input type="radio" name="tipo_eval" value='0' /> Propia
				</label>
				<label class="radio-inline">
				   <input type="radio" name="tipo_eval" value='1' /> Terceros
				</label>
			</div>
			<!-- .fields -->
		</div>
		<br />
		<div class="panel panel-orange">
			<div class="panel-heading">
				<h4 class="panel-title">Bater&iacute;as</h4>
				<div class="panel-tools">
					<div class="dropdown">
						<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu dropdown-light pull-right" role="menu" style="display: none;">
							<li>
								<a class="panel-collapse collapses" href="ui_panels.html#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
							</li>
							<li>
								<a class="panel-expand" href="ui_panels.html#">
									<i class="fa fa-expand"></i> <span>Fullscreen</span>
								</a>
							</li>
						</ul>
					</div>
					<a class="btn btn-xs btn-link panel-close" href="ui_panels.html#">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="panel-body">
				<div class='col-md-6'>
					<label class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" value="option1">lalalaa
					</label>
				</div>
				<div class='col-md-6'>

				</div>
			</div>
		</div>
	</div>
	</form>
</div>