<link href="<?php echo base_url() ?>extras/css/date.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/wizard.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/requerimiento.js" type="text/javascript"></script>
<div class="grid grid_24">
	<?php echo @$aviso; ?>
	<ul class="stepy-titles">
		<li id="wizard-1" class="current-step">
			General<span>datos basicos</span>
		</li>
		<li id="wizard-2" class="">
			Personal<span>cantidad de personal</span>
		</li>
	</ul>
	<form id="form_trabajador" class="form" method="post" action="<?php echo ($editar == FALSE)? base_url().'mandante/requerimiento/guardar': base_url().'mandante/requerimiento/editando/'.urlencode(base64_encode($id_req)); ?>">
		<fieldset id="wizard-step-1" class="step" style="display: block; ">
			<legend>
				my description one
			</legend>
			<div class="field input">
				<label>Nombre: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="nombre" value="<?php echo @ucwords(mb_strtolower($datos->nombre, 'UTF-8')) ?>" id="fname" size="39" class="required1">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Lugar trabajo: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="lugar" value="<?php echo @ucwords(mb_strtolower($datos->lugar_trabajo, 'UTF-8')) ?>" id="fname" size="39" class="required1">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Comentarios:</label>
				<div class="fields">
					<textarea name="texto" rows="8" cols="45"><?php echo @nl2br($datos->comentario) ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .fields -->
			<p id="custom-buttons-0" class="stepy-buttons">
				<a id="custom-next-0" href="#" class="button-next btn small grey">Siguiente</a>
			</p>
		</fieldset>
		<fieldset id="wizard-step-2" class="step" style="display: none; ">
			<legend>
				my description two
			</legend>
			<?php if($editar == FALSE){ ?>
			<div class="field select clonar" id="clonar" style="border-bottom: 1px solid #DDD;padding-bottom: 18px;">
				<div class="field select ref">
					<label>Area:</label>
					<div class="fields">
						<select name="select_area[]" id="select_area" class="required2 jarea">
							<option value="">Area...</option>
							<?php foreach ($listado_areas as $la) { ?>
							<option value="<?php echo $la->id ?>"><?php echo ucwords(mb_strtolower($la->desc_area,'UTF-8')) ?></option>
							<?php } ?>
						</select>
						<span id="click-medio" style="margin-left: 25px;"><a href="#">Nuevo Cargo</a></span>
					</div> <!-- .fields -->
				</div>
				<div class="fields add">
					<div class="cargos_div">
					<select name="select_cargo[]" id="select_cargo" class="required2 jcargo" >
						<option value="">Cargo...</option>
						<?php foreach ($listado_cargos as $lc) { ?>
						<option value="<?php echo $lc->id ?>"><?php echo ucwords(mb_strtolower($lc->desc_cargo,'UTF-8')) ?></option>
						<?php } ?>
					</select>
					<select name="select_especialidad[]" id="select_especialidad" class="required2 jespecialidad">
						<option value="">Especialidad...</option>
						<?php foreach ($listado_especialidad as $le) { ?>
						<option value="<?php echo $le->id ?>"><?php echo ucwords(mb_strtolower($le->desc_especialidad,'UTF-8')) ?></option>
						<?php } ?>
					</select>
					<a class="abs_elim_cargo" href="#" style="display: none;"><img src="<?php echo base_url() ?>extras/img/remove.png" alt="Eliminar" /></a>
					<br /><br />
					<div class="chicos">
						<input type="text" name="cantidad[]" value="" placeholder="cantidad" class="required2 jcantidad" style="width: 35px;" maxlength="4">
						<input type="text" name="fdesde[]" value="Desde" id="fdesde" size="20" autocomplete="off" class="input_fecha required2 jfdesde" style="width: 85px;" >
						<input type="text" name="fhasta[]" value="Hasta" id="fhasta" size="20" autocomplete="off" class="input_fecha required2 jfhasta" style="width: 85px;" >
						<select name="select_cc[]" id="select_cc" class="jcc">
							<option value="">Centro de costo...</option>
							<?php foreach ($listado_cc as $lc) { ?>
							<option value="<?php echo $lc->id ?>"><?php echo ucwords(mb_strtolower($lc->desc_centrocosto,'UTF-8')) ?></option>
							<?php } ?>
						</select>
						<input type="file" />
						<span id="click-chico" style="margin-left: 25px;"><a href="#"><img src="<?php echo base_url() ?>extras/img/textfield_add.png" /></a></span><br /><br />
					</div>
					</div>
				</div>
				<div class="clonado-medio"></div>
				</div>
					<?php }else{ ?>
					<?php foreach($subreq as $s){ ?>
					<div class="field select clonar" id="clonar" style="border-bottom: 1px solid #DDD;padding-bottom: 18px;">
						<div class="field select ref">
							<label>Area:</label>
							<div class="fields">
								<select name="select_area[]" id="select_area" class="required2 jarea">
									<option value="">Area...</option>
									<?php foreach ($listado_areas as $la) { ?>
									<option <?php if($la->id == $s->id_areas) echo "selected='TRUE'" ?> value="<?php echo $la->id ?>"><?php echo ucwords(mb_strtolower($la->desc_area,'UTF-8')) ?></option>
									<?php } ?>
								</select>
								<span id="click-medio" style="margin-left: 25px;"><a href="#">Nuevo Cargo</a></span>
								<a class="abs_elim_req" href="#"><img src="<?php echo base_url() ?>extras/img/delete.png" alt="Eliminar" /></a>
								<input type="hidden" name="area_antigua[]" value="<?php echo $s->id ?>" class='jarea_antigua' /> <!-- ID AREA -->
							</div> <!-- .fields -->
						</div>
						<div class="fields add">
							<?php $y=0; foreach($this->Requerimiento_cargos_model->get_area($s->id) as $ra){ $y++; ?>
								<div class="cargos_div">
								<?php if($y > 1) echo '<hr />'; ?>
								<select name="select_cargo[<?php echo $s->id_areas ?>][]" id="select_cargo" class="required2 jcargo" >
									<option value="">Cargo...</option>
									<?php foreach ($listado_cargos as $lc) { ?>
									<option <?php if($lc->id == $ra->id_cargos) echo "selected='TRUE'" ?> value="<?php echo $lc->id ?>"><?php echo ucwords(mb_strtolower($lc->desc_cargo,'UTF-8')) ?></option>
									<?php } ?>
								</select>
								<select name="select_especialidad[<?php echo $s->id_areas ?>][]" id="select_especialidad" class="required2 jespecialidad">
								<option value="">Especialidad...</option>
									<?php foreach ($listado_especialidad as $le) { ?>
									<option <?php if($le->id == $ra->id_especialidad) echo "selected='TRUE'" ?> value="<?php echo $le->id ?>"><?php echo ucwords(mb_strtolower($le->desc_especialidad, 'UTF-8' )) ?></option>
									<?php } ?>
								</select>
									<a class="abs_elim_cargo" href="#"><img src="<?php echo base_url() ?>extras/img/remove.png" alt="Eliminar" /></a>
									<input type="hidden" name="cargo_antiguo[<?php echo $s->id_areas ?>][]" value="<?php echo $ra->id ?>" class='jcargo_antiguo'  />
								<br /><br />
								<?php $z=0; foreach($this->Requerimiento_trabajador_model->get_cargos($ra->id) as $rt){ $z++; ?>
									<div class="chicos">
										<input type="text" name="cantidad[<?php echo $s->id_areas ?>][<?php echo $ra->id_cargos ?>][<?php echo (empty($ra->id_especialidad)) ? '0' : $ra->id_especialidad; ?>][]" value="<?php echo @$rt->cantidad ?>" placeholder="cantidad" class="required2 jcantidad" style="width: 35px;">
										<input type="text" name="fdesde[<?php echo $s->id_areas ?>][<?php echo $ra->id_cargos ?>][<?php echo (empty($ra->id_especialidad)) ? '0' : $ra->id_especialidad; ?>][]" value="<?php echo @$rt->fecha_inicio ?>" class="input_fecha required2 jfdesde" autocomplete="off"  style="width: 85px;" >
										<input type="text" name="fhasta[<?php echo $s->id_areas ?>][<?php echo $ra->id_cargos ?>][<?php echo (empty($ra->id_especialidad)) ? '0' : $ra->id_especialidad; ?>][]" value="<?php echo @$rt->fecha_termino ?>" class="input_fecha required2 jfhasta" autocomplete="off"  style="width: 85px;" >
										<select name="select_cc[<?php echo $s->id_areas ?>][<?php echo $ra->id_cargos ?>][<?php echo (empty($ra->id_especialidad)) ? '0' : $ra->id_especialidad; ?>][]" class="required2 jcc" >
											<option value="">Centro de costo...</option>
											<?php foreach ($listado_cc as $lc) { ?>
											<option <?php if($lc->id == $rt->id_centrocosto) echo "selected='TRUE'" ?> value="<?php echo $lc->id ?>"><?php echo ucwords(mb_strtolower($lc->desc_centrocosto,'UTF-8')) ?></option>
											<?php } ?>
										</select>
										<input type="file" />
										<?php if($z==1){ ?>
										<span id="click-chico" style="margin-left: 25px;"><a href="#"><img src="<?php echo base_url() ?>extras/img/textfield_add.png" /></a></span>
										<?php }else{ ?>
										<a class="abs_elim_subreq" href="#"><img src="<?php echo base_url() ?>extras/img/delete_date.png" alt="Eliminar" /></a>
										<?php } ?>
										<input type="hidden" name="antiguo_rt[<?php echo $s->id_areas ?>][<?php echo $ra->id_cargos ?>][<?php echo (empty($ra->id_especialidad)) ? '0' : $ra->id_especialidad; ?>][]" value="<?php echo $rt->id ?>" class='jcant_antiguo' />
										<br /><br />	
									</div>
								<?php } ?>
								</div>
							<?php } ?>
						</div>
						<div class="clonado-medio"></div>
					</div>
					<?php } ?>
					<?php } ?>
				<!-- .fields -->
			<div class="clonados"></div>
			<div class="field input">
				<a href="#" class="click_requerimiento">Nueva Area</a>
			</div>
			<!-- .field -->
			<div class="actions">
				<input type="hidden" id='idplanta' name="planta" value="<?php echo $id_planta ?>" />
				<button type="submit" class="btn primary">
					<?php echo ($editar == FALSE)? "Guardar" : "Editar"; ?>
				</button>
			</div>
			<!-- .actions -->
			<p id="custom-buttons-1" class="stepy-buttons">
				<a id="custom-back-1" href="#" class="button-back btn small grey">Volver</a>
			</p>
		</fieldset>
	</form>
</div>
<!-- <div class="grid grid_7">
	<a href="<?php echo base_url() ?>mandante/requerimiento/publicar" class="btn xlarge primary dashboard_add"><span></span>Publicar</a>
	<a href="<?php echo base_url() ?>mandante/requerimiento/estado" class="btn xlarge secondary dashboard_add">Estado</a>
	<a href="<?php echo base_url() ?>mandante/requerimiento/ofertas_recibidas" class="btn xlarge tertiary dashboard_add">Ofertas Recibidas</a>
</div> -->