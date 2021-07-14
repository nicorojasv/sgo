<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">A&ntilde;adir Evaluaci&oacute;n Medica <a href="<?php echo base_url() ?>carrera/trabajadores/detalle/<?php echo $id ?>"><i class="fa fa-reply"></i></a></h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="agregar_examen" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>carrera/trabajadores/guardar_creacion_eval/<?php echo $id ?>/<?php if($eval){ echo $eval->id; } ?>">
		<input type="hidden" name="evaluacion" value="2">	
			<div class="row">
				<div class='col-md-6' >
					<div class="panel panel-white">
						<div class="panel-heading">
							<h4 class="panel-title"></h4>
						</div>
						<div class="form-group">
								<label class='col-sm-2 control-label'>Rut:</label> 
								<div class="col-sm-10">
									<?php echo $rut; ?>
								</div>
							</div>
						<div class="panel-body">
							<div class="form-group">
								<label class='col-sm-2 control-label'>Trabajador:</label> 
								<div class="col-sm-10">
									<a href="#"><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></a>
								</div>
							</div>
							<div class="form-group">
								<label class='col-sm-2 control-label'>Edad:</label> 
								<div class="col-sm-10">
									<?php echo $edad; ?>
								</div>
							</div>
							<div class="form-group">
								<label class='col-sm-2 control-label'>Evaluación:</label> 
								<div class="col-sm-10">
									<select id="subtipo" style="width: 244px;" name="id_ee" required>
										<option value="">Seleccione</option>
										<?php foreach($evaluaciones as $ev){ ?>
											<option value="<?php echo $ev->id ?>" <?php if($eval){ echo ($eval->id_evaluacion == $ev->id) ? "selected='selected'" : ''; } ?>><?php echo ucwords(mb_strtolower($ev->nombre, 'UTF-8')) ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class='col-sm-2 control-label'>Fecha evaluación:</label> 
								<div class="col-sm-10">
									<?php if( $eval ){
										$f = explode('-', $eval->fecha_e);
										$dia_e = $f[2];
										$mes_e = $f[1];
										$ano_e = $f[0];
									}else{
										$dia_e = false;
										$mes_e = false;
										$ano_e = false;
									} ?>
									<select name="dia_e" style="width: 60px;" required>
										<option value="" >Dia</option>
										<?php for($i=1;$i<32;$i++){ ?>
										<option value="<?php echo $i ?>" <?php echo ($dia_e == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
									<select name="mes_e" style="width: 108px;" required>
										<option value="">Mes</option>
										<option value='01' <?php echo ($mes_e == '1')? "selected='selected'" : '' ?>>Enero</option>
										<option value='02' <?php echo ($mes_e == '2')? "selected='selected'" : '' ?>>Febrero</option>
										<option value='03' <?php echo ($mes_e == '3')? "selected='selected'" : '' ?>>Marzo</option>
										<option value='04' <?php echo ($mes_e == '4')? "selected='selected'" : '' ?>>Abril</option>
										<option value='05' <?php echo ($mes_e == '5')? "selected='selected'" : '' ?>>Mayo</option>
										<option value='06' <?php echo ($mes_e == '6')? "selected='selected'" : '' ?>>Junio</option>
										<option value='07' <?php echo ($mes_e == '7')? "selected='selected'" : '' ?>>Julio</option>
										<option value='08' <?php echo ($mes_e == '8')? "selected='selected'" : '' ?>>Agosto</option>
										<option value='09' <?php echo ($mes_e == '9')? "selected='selected'" : '' ?>>Septiembre</option>
										<option value='10' <?php echo ($mes_e == '10')? "selected='selected'" : '' ?>>Octubre</option>
										<option value='11' <?php echo ($mes_e == '11')? "selected='selected'" : '' ?>>Noviembre</option>
										<option value='12' <?php echo ($mes_e == '12')? "selected='selected'" : '' ?>>Deciembre</option>
									</select>
									<select name="ano_e" style="width: 70px;" required>
										<option value="">Año</option>
										<?php $tope_f = (date('Y') - 2 ); ?>
										<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
											<option value="<?php echo $i ?>" <?php echo ($ano_e == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div id="div_desempeno" class="form-group">
								<label class='col-sm-2 control-label'>Fecha vigencia:</label> 
								<div class="col-sm-10">
									<?php if( $eval ){
										$f = explode('-', $eval->fecha_v);
										$dia_v = $f[2];
										$mes_v = $f[1];
										$ano_v = $f[0];
									}else{
										$dia_v = false;
										$mes_v = false;
										$ano_v = false;
									} ?>
									<select name="dia_v" style="width: 60px;">
										<option value="" >Dia</option>
										<?php for($i=1;$i<32;$i++){ ?>
										<option <?php echo ($dia_v == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
									<select name="mes_v" style="width: 108px;">
										<option value="" >Mes</option>
										<option value='01' <?php echo ($mes_v == '1')? "selected='selected'" : '' ?>>Enero</option>
										<option value='02' <?php echo ($mes_v == '2')? "selected='selected'" : '' ?>>Febrero</option>
										<option value='03' <?php echo ($mes_v == '3')? "selected='selected'" : '' ?>>Marzo</option>
										<option value='04' <?php echo ($mes_v == '4')? "selected='selected'" : '' ?>>Abril</option>
										<option value='05' <?php echo ($mes_v == '5')? "selected='selected'" : '' ?>>Mayo</option>
										<option value='06' <?php echo ($mes_v == '6')? "selected='selected'" : '' ?>>Junio</option>
										<option value='07' <?php echo ($mes_v == '7')? "selected='selected'" : '' ?>>Julio</option>
										<option value='08' <?php echo ($mes_v == '8')? "selected='selected'" : '' ?>>Agosto</option>
										<option value='09' <?php echo ($mes_v == '9')? "selected='selected'" : '' ?>>Septiembre</option>
										<option value='10' <?php echo ($mes_v == '10')? "selected='selected'" : '' ?>>Octubre</option>
										<option value='11' <?php echo ($mes_v == '11')? "selected='selected'" : '' ?>>Noviembre</option>
										<option value='12' <?php echo ($mes_v == '12')? "selected='selected'" : '' ?>>Deciembre</option>
									</select>
									<select name="ano_v" style="width: 70px;">
										<option value="">Año</option>
										<?php $tope_f = (date('Y') - 2 );  ?>
										<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
											<option value="<?php echo $i ?>" <?php echo ($ano_v == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class='col-sm-2 control-label'>Resultado:</label> 
								<div class="col-sm-10">
									<select name="resultado_cualitativo" required>
										<option value="">Seleccione</option>
										<option value="0" <?php if($eval){ echo ($eval->resultado == 0) ? "selected='selected'" : ''; } ?>>Aprobado</option>
										<option value="1" <?php if($eval){ echo ($eval->resultado == 1) ? "selected='selected'" : ''; } ?>>Rechazado</option>
										<option value="2" <?php if($eval){ echo ($eval->asistencia_examen == 0 and $eval->resultado == 2) ? "selected='selected'" : ''; } ?>>No Asiste</option>
									</select>
								</div>
								<!-- .fields -->
							</div>
							<div class="form-group">
								<label class='col-sm-2 control-label'>Archivo:</label> 
								<div class="col-sm-10">
									<input type="file" name="docu"/>
								</div>
								<!-- .fields -->
							</div>
							<div class="form-group">
								<label class='col-sm-2 control-label'>Observación:</label> 
								<div class="col-sm-10">
									<textarea class="form-control" name="obs" cols="40" rows="5"><?php if($eval){ echo ($eval->observaciones) ? $eval->observaciones : ''; } ?></textarea>
								</div>
								<!-- .fields -->
							</div>
							<div class="actions">
								<button type="submit" class="btn pull-right" id="guardar_nuevo_examen<?php if($eval){ echo '_mod'; } ?>">
									Guardar
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<div class="form-group">
						<div class="col-sm-10">
							Examen Referido<br>
							<label class="radio-inline">
							   <input type="radio" id="referido" name="referido" value='1' <?php if($eval){ echo ($eval->examen_referido == 1)?"checked='checked'":''; } ?> required/> Si
							</label>
							<label class="radio-inline">
							   <input type="radio" id="referido" name="referido" value='0' <?php if($eval){ echo ($eval->examen_referido == 0)?"checked='checked'":''; } ?> required/> No
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10">
							<label class="radio-inline">
							   <input type="radio" id="pago" name="pago" value='0' <?php if($eval){ echo ($eval->pago == 0) ? "checked='checked'" : ''; } ?> checked/> Propia
							</label>
							<label class="radio-inline">
							   <input type="radio" id="pago" name="pago" value='1' <?php if($eval){ echo ($eval->pago == 1) ? "checked='checked'" : ''; } ?> /> Terceros
							</label>
						</div>
						<!-- .fields -->
					</div>
					<div class="form-group">
						<label class='col-sm-3 control-label'>C.Costo</label> 
						<div class="col-sm-3">
							<select id="ccosto" name="ccosto" required>
								<option value="">Seleccione[]</option>
								<?php foreach ($empresa_planta as $ep){ ?>
								<option value="<?php echo $ep->id ?>" <?php if($eval){ if($eval->ccosto == $ep->id) echo "selected"; } ?> ><?php echo $ep->nombre ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class='col-sm-3'>Valor Examen</label> 
						<div class="col-sm-3">
							<?php
							if($eval){
								if($eval->estado_cobro == "1"){
							?>
								<input type="text" id="valor_examen" name="valor_examen" value="<?php if($eval){ echo ($eval->valor_examen) ? $eval->valor_examen : '0'; } ?>" readonly="readonly">
							<?php
								}else{
							?>
								<input type="text" id="valor_examen" name="valor_examen" value="<?php if($eval){ echo ($eval->valor_examen) ? $eval->valor_examen : '0'; } ?>">
							<?php
								}
							}else{
							?>
							<input type="text" id="valor_examen" name="valor_examen" value="<?php if($eval){ echo ($eval->valor_examen) ? $eval->valor_examen : '0'; } ?>">
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class='col-sm-3'>Indice de Ganancia</label> 
						<div class="col-sm-3">
							<?php
							if($eval){
								if($eval->estado_cobro == "1"){
							?>
								<input type="text" id="indice_ganancia" name="indice_ganancia" style="width:80%" value="<?php if($eval){ echo ($eval->indice_ganancia) ? $eval->indice_ganancia : '0'; } ?>" required readonly="readonly">%
							<?php
								}else{
							?>
								<input type="text" id="indice_ganancia" name="indice_ganancia" style="width:80%" value="<?php if($eval){ echo ($eval->indice_ganancia) ? $eval->indice_ganancia : '0'; } ?>" required>%
							<?php
								}
							}else{
							?>
								<input type="text" id="indice_ganancia" name="indice_ganancia" style="width:80%" value="<?php if($eval){ echo ($eval->indice_ganancia) ? $eval->indice_ganancia : '0'; } ?>" required>%
							<?php } ?>
						</div>
					</div>
					<br />
					<div class="panel panel-grey">
						<div class="panel-heading">
							<h4 class="panel-title">Bater&iacute;as</h4>
						</div>
						<div class="panel-body">
							<div class='col-md-6'>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Bateria B&aacute;sica" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Bateria Básica") echo "checked";
								   	}
								   } ?>>Bateria B&aacute;sica
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Altura F&iacute;sica" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Altura Física") echo "checked";
								   	}
								   } ?>>Altura F&iacute;sica
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Expuesto a Ruido" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Expuesto a Ruido") echo "checked";
								   	}
								   } ?>>Expuesto a Ruido
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Espacio Confinado" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Espacio Confinado") echo "checked";
								   	}
								   } ?>>Espacio Confinado
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Agentes Neumoconiogenos" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Agentes Neumoconiogenos") echo "checked";
								   	}
								   } ?>>Agentes Neumoconiogenos
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Agentes Prod. de Asma" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Agentes Prod. de Asma") echo "checked";
								   	}
								   } ?>>Agentes Prod. de Asma
								</label>
							</div>
							<div class='col-md-6'>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Conduc. de Equipos Moviles" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Conduc. de Equipos Moviles") echo "checked";
								   	}
								   } ?>>Conduc. de Equipos Moviles
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Radiaciones Lonizantes" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Radiaciones Lonizantes") echo "checked";
								   	}
								   } ?>>Radiaciones Lonizantes
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Humos Metalicos" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Humos Metalicos") echo "checked";
								   	}
								   } ?>>Humos Metalicos
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Solventes" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Solventes") echo "checked";
								   	}
								   } ?>>Solventes
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Formaldehido" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Formaldehido") echo "checked";
								   	}
								   } ?>>Formaldehido
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Movimientos Repetitivos" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Movimientos Repetitivos") echo "checked";
								   	}
								   } ?>>Movimientos Repetitivos
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="MMC" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "MMC") echo "checked";
								   	}
								   } ?>>MMC
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Alcohol" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Alcohol") echo "checked";
								   	}
								   } ?>>Alcohol
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Anfetamina" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Anfetamina") echo "checked";
								   	}
								   } ?>>Anfetamina
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Cocaina" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Cocaina") echo "checked";
								   	}
								   } ?>>Cocaina
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Marihuana" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Marihuana") echo "checked";
								   	}
								   } ?>>Marihuana
								</label>
								<label style="color: #141518;" class="checkbox-inline">
								   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Benzodiazepinas" <?php if($bat){
								   	foreach ($bat as $b) {
								   		if($b->nombre == "Benzodiazepinas") echo "checked";
								   	}
								   } ?>>Benzodiazepinas
								</label>
							</div>
						</div>
					</div>
					<div class="panel panel-grey">
						<div class="panel-heading">
							<h4 class="panel-title">Cargos</h4>
						</div>
						<div class="panel-body">
							<div class='col-md-12'>
								<select name="cargos_aptos[]" class="selectpicker" multiple data-actions-box="true">
									<?php foreach ($r_cargos as $cg){ ?>
									  <option value="<?php echo $cg->id_r_cargo ?>" <?php if($cg->estado == 1) echo "selected" ?> ><?php echo $cg->nombre_r_cargo ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
	    	</div>
	    </form>
	</div>
</div>