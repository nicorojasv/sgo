<div class="col-md-10 col-md-offset-2">
	<form class="form-horizontal" id="agregar_examen" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>est/evaluaciones/guardar_creacion_eval/<?php echo $id ?>/<?php if($eval){ echo $eval->id; } ?>">
	<h3>A&ntilde;adir Evaluaci&oacute;n Medica</h3>
	<input type="hidden" name="evaluacion" value="2" >
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
						<select id="subtipo" style="width: 244px;" name="id_ee">
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
						<select name="dia_e" style="width: 60px;">
							<option value="" >Dia</option>
							<?php for($i=1;$i<32;$i++){ ?>
							<option <?php echo ($dia_e == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="mes_e" style="width: 108px;">
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
						<select name="ano_e" style="width: 70px;">
							<option value="">Año</option>
							<?php $tope_f = (date('Y') - 5 ); ?>
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
							<?php $tope_f = (date('Y') - 5 );  ?>
							<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
								<option value="<?php echo $i ?>" <?php echo ($ano_v == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class='col-sm-2 control-label'>Resultado:</label> 
					<div class="col-sm-10">
						<select name="resultado_cualitativo">
							<option value="">Seleccione</option>
							<option value="0" <?php if($eval){ echo ($eval->resultado == 0) ? "selected='selected'" : ''; } ?>>Aprobado</option>
							<option value="1" <?php if($eval){ echo ($eval->resultado == 1) ? "selected='selected'" : ''; } ?>>Rechazado</option>
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
				<label class="radio-inline">
				   <input type="radio" name="pago" value='0' <?php if($eval){ echo ($eval->pago == 0) ? "checked='checked'" : ''; } ?> /> Propia
				</label>
				<label class="radio-inline">
				   <input type="radio" name="pago" value='1' <?php if($eval){ echo ($eval->pago == 1) ? "checked='checked'" : ''; } ?> /> Terceros
				</label>
			</div>
			<!-- .fields -->
		</div>
		<div class="form-group">
			<label class='col-sm-3 control-label'>C.Costo</label> 
			<div class="col-sm-4">
				<input type="text" name="ccosto" value="<?php if($eval){ echo ($eval->ccosto) ? $eval->ccosto : ''; } ?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class='col-sm-3'>Valor Examen</label> 
			<div class="col-sm-3">
				<?php
				if($eval){
					if($eval->estado_cobro == "1"){
				?>
					<input type="text" name="valor_examen" value="<?php if($eval){ echo ($eval->valor_examen) ? $eval->valor_examen : '0'; } ?>" required readonly="readonly">
				<?php
					}else{
				?>
					<input type="text" name="valor_examen" value="<?php if($eval){ echo ($eval->valor_examen) ? $eval->valor_examen : '0'; } ?>" required>
				<?php
					}
				}else{
				?>
				<input type="text" name="valor_examen" value="<?php if($eval){ echo ($eval->valor_examen) ? $eval->valor_examen : '0'; } ?>" required>
				<?php } ?>
			</div>
		</div>
		<br />
		<div class="panel panel-grey">
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
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Chofer Maquina Pesada" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Chofer Maquina Pesada") echo "checked";
					   	}
					   } ?>>Chofer Maquina Pesada
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Exposici&oacute;n Ta. Extremas" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Exposición Ta. Extremas") echo "checked";
					   	}
					   } ?>>Exposici&oacute;n Ta. Extremas
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Altura Geografica" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Altura Geografica") echo "checked";
					   	}
					   } ?>>Altura Geografica
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Expusto a Plagicida" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Expusto a Plagicida") echo "checked";
					   	}
					   } ?>>Expusto a Plagicida
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Vigilante" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Vigilante") echo "checked";
					   	}
					   } ?>>Vigilante
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Manipulador Alimentos" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Manipulador Alimentos") echo "checked";
					   	}
					   } ?>>Manipulador Alimentos
					</label>
				</div>
				<div class='col-md-6'>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Canabinoides" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Canabinoides") echo "checked";
					   	}
					   } ?>>Canabinoides
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Anfetaminas" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Anfetaminas") echo "checked";
					   	}
					   } ?>>Anfetaminas
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Cocaina o Pasta Base" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Cocaina o Pasta Base") echo "checked";
					   	}
					   } ?>>Cocaina o Pasta Base
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Alcohol" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Alcohol") echo "checked";
					   	}
					   } ?>>Alcohol
					</label>
					<label style="color: #141518;" class="checkbox-inline">
				   	<input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="MMC" <?php if($bat){
				   		foreach ($bat as $b) {
				   			if($b->nombre == "MMC") echo "checked";
				   		}
				   		} ?>>MMC
					</label>
				<br/>
				<!--
				<label style="color: #141518;" class="checkbox-inline">
				   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Operacion Equipos Fijos con Partes Moviles y Puente Grua" <?php if($bat){
				   	foreach ($bat as $b) {
				   		if($b->nombre == "Operacion Equipos Fijos con Partes Moviles y Puente Grua") echo "checked";
				   	}
				   } ?>>Operacion Equipos Fijos con Partes Moviles y Puente Grua
				</label>-->
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="checkbox" id="inlineCheckbox1" name="baterias[]" value="Otros" <?php if($bat){
					   	foreach ($bat as $b) {
					   		if($b->nombre == "Otros") echo "checked";
					   	}
					   } ?>>Otros (indicar)
					</label>
					<label style="color: #141518;" class="checkbox-inline">
					   <input type="text" >
					</label>
				</div>
			</div>
		</div>
	</div>
	</form>
</div>