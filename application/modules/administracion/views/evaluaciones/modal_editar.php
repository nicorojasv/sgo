<div id="modal">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Editar Evaluación</h3>
	</div>
	<div id="modal_content">
		<div  style="width: 500px; height: auto;">
			<p>Trabajador: <a href="#"><?php echo ucwords( mb_strtolower($salida[0]->nombres.' '.$salida[0]->paterno.' '.$salida[0]->materno, 'UTF-8')) ?></a></p>
			<form class="form" id="form_modal" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/evaluaciones/edicion_evaluacion/">
			<?php foreach($salida as $s){ ?>
			<?php if($s->nombre_tipo == "DESEMPEÑO") $rel = 'desemp'; ?>
			<?php if($s->nombre_tipo != "DESEMPEÑO") $rel = 'nodesemp'; ?>
			<p><b>Evaluación</b>: <b><a class="click_eval" rel='<?php echo $rel; ?>' href="#" title="Click para ver detalle"><?php echo ucwords( mb_strtolower( $s->nombre_examen, 'UTF-8' )); ?></a></b></p>
			<div class='contenedor_nodesemp' style="display: none">
				<p>Archivo: <span id="cont-arch">
				<?php if(isset($s->url)){ ?>
					<a href="<?php echo base_url().$s->url ?>" target='_blank'>Descargar archivo</a>&nbsp;<a id="eliminar_archivo" href="#" rel="<?php echo $s->id_evaluacion ?>" style="position: absolute;margin-top: -7px;"><img src="<?php echo base_url()?>extras/img/delete-2.png" /></a>
				<?php }else{ ?>
					No posee archivo
				<?php } ?>
				</span>
				</p>
				<div class="field input">
					<label>Fecha evaluación:</label>
					<?php $f = $s->fecha_e; ?>
					<?php $f_e = explode('-', $f); ?>
					<div class="fields">
						<select name="dia_e[<?php echo $s->id_evaluacion ?>]" style="width: 60px;">
							<?php for($i=1;$i<32;$i++){ ?>
							<option <?php if($f_e[2] == $i) echo " selected='true'"; ?> ><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="mes_e[<?php echo $s->id_evaluacion ?>]" style="width: 108px;">
							<?php $meses = meses(); ?>
							<?php foreach($meses as $m){ ?>
							<option value="<?php echo mesXdia($m); ?>" <?php if($f_e[1] == mesXdia($m)) echo " selected='true'"; ?> ><?php echo $m ?></option>
							<?php } ?>
						</select>
						<select name="ano_e[<?php echo $s->id_evaluacion ?>]" style="width: 70px;">
							<option value="">Año</option>
							<?php if($f_e[0] > (date('Y') - 5 ) ) $tope_f = (date('Y') - 5 );
									else $tope_f = $f_e[0]; ?>
							<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
								<option <?php if($f_e[0] == $i) echo " selected='true'"; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
					</div>
					<!-- .fields -->
				</div>
				<?php if($s->nombre_tipo == "DESEMPEÑO"){ ?>
				<div class="field input">
					<label>Nombre Fanea:</label>
					<div class="fields">
						<input type="text" name="faena" placeholder='Faena' value='<?php echo $s->faena ?>' />
					</div>
				</div>
				<?php } ?>
				<?php if($s->nombre_tipo != "DESEMPEÑO"){ ?>
				<?php if($id_eval != 3){  ?>
					<div class="field input">
					<label>Fecha vigencia:</label>
					<?php $v = $s->fecha_v; ?>
					<?php $f_v = explode('-', $v); ?>
					<div class="fields">
						<select name="dia_v[<?php echo $s->id_evaluacion ?>]" style="width: 60px;">
							<?php for($i=1;$i<32;$i++){ ?>
							<option <?php if($f_v[2] == $i) echo " selected='true'"; ?> ><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="mes_v[<?php echo $s->id_evaluacion ?>]" style="width: 108px;">
							<?php $meses = meses(); ?>
							<?php foreach($meses as $m){ ?>
							<option value="<?php echo mesXdia($m); ?>" <?php if($f_v[1] == mesXdia($m)) echo " selected='true'"; ?> ><?php echo $m ?></option>
							<?php } ?>
						</select>
						<select name="ano_v[<?php echo $s->id_evaluacion ?>]" style="width: 70px;">
							<option value="">Año</option>
							<?php if($f_e[0] > (date('Y') - 5 ) ) $tope_f = (date('Y') - 5 );
									else $tope_f = $f_v[0]; ?>
							<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
								<option <?php if($f_v[0] == $i) echo " selected='true'"; ?> value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
					</div>
					<!-- .fields -->
				</div>
				<?php } ?>
				<?php } ?>
				<div class="field select">
					<label>Resultado:</label>
					<div class="fields">
						<?php if($s->tipo_resultado == 2){ ?>
						<select name="resultado[<?php echo $s->id_evaluacion ?>]" >
							<option value="">Resultado</option>
							<?php if($s->nombre_tipo == "SEGURIDAD"){ ?>
								<option <?php if($s->resultado == 0) echo " selected='true'"; ?> value="0">Aprobado</option>
								<option <?php if($s->resultado == 1) echo " selected='true'"; ?> value="1">Rechazado</option>
							<?php }
							elseif($s->nombre_tipo == "MEDICA"){ ?>
								<option <?php if($s->resultado == 0) echo " selected='true'"; ?> value="0">Sin Contraindicaciones</option>
								<option <?php if($s->resultado == 1) echo " selected='true'"; ?> value="1">Con Contraindicaciones</option>
							<?php }
							elseif($s->nombre_tipo == "DESEMPEÑO"){ ?>
								<option <?php if($s->resultado == 0) echo " selected='true'"; ?> value="0">Aprobado</option>
								<option <?php if($s->resultado == 1) echo " selected='true'"; ?> value="1">Rechazado</option>
							<?php } ?>
						</select>
						<?php } else{ ?>
							<input type="text" name="resultado[<?php echo $s->id_evaluacion ?>]" value="<?php echo $s->resultado ?>" />
						<?php } ?>
					</div>
					<!-- .fields -->
				</div>
				<?php if($s->nombre_tipo == "DESEMPEÑO"){ ?>
				<div class="field input">
					<label>Recomienda?:</label>
					<div class="fields">
						no <input type="radio" name="recomienda" value='0' <?php if($s->recomienda == 0) echo 'CHECKED'; ?> />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						si <input type="radio" name="recomienda" value='1' <?php if($s->recomienda == 1) echo 'CHECKED'; ?> />
					</div>
				</div>
				<?php } ?>
				<div class="field input">
					<label>Archivo:</label>
					<div class="fields">
						<input type="file" name="docu[<?php echo $s->id_evaluacion ?>]" <?php if(isset($s->url)) {echo "disabled='disabled'";} ?> />
					</div>
					<!-- .fields -->
				</div>
				<div class="field input">
					<label>Observación:</label>
					<div class="fields">
						<textarea name="obs[<?php echo $s->id_evaluacion ?>]" cols="40" rows="5"><?php echo ucwords( mb_strtolower(nl2br($s->observaciones), 'UTF-8')) ?></textarea>
					</div>
					<!-- .fields -->
				</div>
			</div>
			<?php } ?>
				<div class="actions">
					<input type="hidden" name="tipo" value="<?php echo $salida[0]->id_tipo ?>" />
					<button type="submit" class="btn primary" id="subir_documento">
						Guardar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>