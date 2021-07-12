<!-- OVERLAY CON EL INGRESO UNA EXPERIENCIA -->
<div id="modalExp" style="height: 550px;">
  <div class="modal-header">
   <h3>Creación de nueva experiencia</h3>
  </div>
   <form action="<?php echo base_url().$form_url ?>" method="post" class="form" id="form_exp">
  <div class="modal-body" style="width: 420px;">
		<div class="field select">
			<label for="desde">Desde<span class="required">*</span></label>
			<div class="fields">
				<?php if(isset($exp)){  ?>
					<?php $fecha_desde = $exp -> desde; ?>
					<?php $fecha_hasta = $exp -> hasta; ?>
					<?php $fecha_desde = explode('-', $fecha_desde); ?>
					<?php $fecha_hasta = explode('-', $fecha_hasta); ?>
					<?php $funciones = explode(';', $exp -> funciones); ?>
					<?php $referencias = explode(';', $exp -> referencias); ?>
				<?php } ?>
				<select name="select_dia_desde" style="width:70px;">
					<option value="">Dia</option>
					<?php for ($i=1; $i < 32 ; $i++) { ?> 
					<option value="<?php echo $i ?>" <?php if(isset($exp)){ echo ($i == $fecha_desde[2]) ? 'SELECTED': ''; } ?>><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="select_mes_desde" style="width:100px;">
					<option value="">Mes</option>
					<?php for ($i=1; $i < 13 ; $i++) { ?> 
					<option value="<?php echo $i ?>" <?php if(isset($exp)){ echo ($i == $fecha_desde[1]) ? 'SELECTED': ''; } ?>><?php echo $meses[$i-1] ?></option>
					<?php } ?>
				</select>
				<select name="select_ano_desde" style="width:70px;">
					<option value="">Año</option>
					<?php for ($i= date('Y'); $i > 1931 ; $i--) { ?> 
					<option value="<?php echo $i ?>" <?php if(isset($exp)){ echo ($i == $fecha_desde[0]) ? 'SELECTED': ''; } ?>><?php echo $i ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="field select">
			<label for="desde">Hasta<span class="required">*</span></label>
			<div class="fields">
				<select name="select_dia_hasta" style="width:70px;">
					<option value="">Dia</option>
					<?php for ($i=1; $i < 32 ; $i++) { ?> 
					<option value="<?php echo $i ?>" <?php if(isset($exp)){ echo ($i == $fecha_hasta[2]) ? 'SELECTED': ''; } ?>><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="select_mes_hasta" style="width:100px;">
					<option value="">Mes</option>
					<?php for ($i=1; $i < 13 ; $i++) { ?> 
					<option value="<?php echo $i ?>" <?php if(isset($exp)){ echo ($i == $fecha_hasta[1]) ? 'SELECTED': ''; } ?> ><?php echo $meses[$i-1] ?></option>
					<?php } ?>
				</select>
				<select name="select_ano_hasta" style="width:70px;">
					<option value="">Año</option>
					<?php for ($i= date('Y'); $i > 1931 ; $i--) { ?> 
					<option value="<?php echo $i ?>" <?php if(isset($exp)){ echo ($i == $fecha_hasta[0]) ? 'SELECTED': ''; } ?> ><?php echo $i ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="field">
			<label for="desde">Cargo<span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="cargo" size="35" value="<?php if(isset($exp)){ echo ucwords( mb_strtolower($exp->cargo, 'UTF-8')); } ?>" />
			</div>
		</div>
		<div class="field">
			<label for="desde">Area<span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="area" size="35" value="<?php if(isset($exp)){ echo ucwords( mb_strtolower($exp->area, 'UTF-8')); } ?>" />
			</div>
		</div>
		<div class="field">
			<label for="desde">Empresa contratista<span class="required">*</span></label>
			<div class="fields">
				<input type="text" name="contratista" size="35" value="<?php if(isset($exp)){ echo ucwords( mb_strtolower($exp->empresa_c, 'UTF-8')); } ?>" />
			</div>
		</div>
		<div class="field">
			<label for="desde">Empresa mandante/planta</label>
			<div class="fields">
				<input type="text" name="mandante" size="35" value="<?php if(isset($exp)){ echo ucwords( mb_strtolower($exp->empresa_m, 'UTF-8')); } ?>" />
			</div>
		</div>
		<div class="field">
			<label for="desde">Principales funciones<span class="required">*</span></label>
			<div class="fields">
				<div class="tagsinput exp">
					<div class="tags_addTag funciones">
						<div class="cont-tag">
							<?php if(isset($exp)){ ?>
								<?php for($f=0; $f<(count($funciones) - 1); $f++){ ?>
									<span class="tag"><span><?php echo $funciones[$f] ?>&nbsp;&nbsp;</span><a href="#" title="Eliminar tag">x</a></span>
								<?php } ?>
							<?php } ?>
						</div>
						<input class="tags_tag" value="agregar" style="color: rgb(102, 102, 102);" autocomplete="off" />
					</div>
					<div class="tags_clear"></div>
					<textarea name="funciones" style="display: none;">
						<?php if(isset($exp)){ ?>
							<?php for($f=0; $f<(count($funciones) - 1); $f++){ ?>
								<?php echo $funciones[$f].';' ?>
							<?php } ?>
						<?php } ?>
					</textarea>
				</div>
				<a href="#" id='help_funciones' style="float: left;margin-left: 5px;"><img src="<?php echo base_url() ?>extras/img/question_frame.png" /></a>
			</div>
		</div>
		<div class="field">
			<label for="desde">Referencias</label>
			<div class="fields">
				<div class="tagsinput exp">
					<div class="tags_addTag referencias">
						<div class="cont-tag">
							<?php if(isset($exp)){ ?>
								<?php for($a=0; $a<(count($referencias) - 1); $a++){ ?>
									<span class="tag"><span><?php echo $referencias[$a] ?>&nbsp;&nbsp;</span><a href="#" title="Eliminar tag">x</a></span>
								<?php } ?>
							<?php } ?>
						</div>
						<input class="tags_tag" value="agregar" style="color: rgb(102, 102, 102);" autocomplete="off" />
					</div>
					<div class="tags_clear"></div>
					<textarea name="referencias" style="display: none;">
						<?php if(isset($exp)){ ?>
							<?php for($a=0; $a<(count($referencias) - 1); $a++){ ?>
								<?php echo $referencias[$a].';' ?>
							<?php } ?>
						<?php } ?>
					</textarea>
				</div>
				<a href="#" id='help_referencias' style="float: left;margin-left: 5px;"><img src="<?php echo base_url() ?>extras/img/question_frame.png" /></a>
			</div>
		</div>
  </div>
  <div class="modal-footer">
    <a href="#datos-experiencia" class="btn " data-dismiss="modal">Cerrar</a>
    <button href="#" class="btn btn-primary">Guardar</button>
  </div>
  </form>
</div>
<!-- -->