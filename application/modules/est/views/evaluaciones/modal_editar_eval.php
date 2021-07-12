<div id="modal">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Edición de evaluación</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor edite los datos de la evaluacion
			</p>
			<form action="<?php echo base_url() ?>administracion/evaluaciones/editar_evaluacion/<?php echo $id ?>" method="post" class="form">
				<div class="field select">
					<label for="email">Tipo</label>
					<div class="fields">
						<select name="tipo_eval">
							<?php if(!empty($listado_tipos)){ ?>
							<option value="">Seleccione...</option>
							<?php foreach($listado_tipos as $l){ ?>
							<option value="<?php echo $l->id ?>" <?php echo ($l->id == $eval->id)? 'SELECTED': ''; ?> ><?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')) ?></option>
							<?php } ?>
							<?php }else{ ?>
							<option value="">No existen tipos de evaluaciones</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="email">Nombre</label>
					<div class="fields">
						<input type="text" name="eval" value="<?php echo ucwords( mb_strtolower($eval->nombre, 'UTF-8')) ?>" id="cat" size="30" tabindex="1">
					</div>
				</div>
				<div class="field">
					<label for="email">Abreviación</label>
					<div class="fields">
						<input type="text" name="abre" value="<?php echo $eval->abreviacion ?>" id="abr" size="5" tabindex="1">
					</div>
				</div>
				<div class="fields">
					<label for="email">Tipo de resultado</label>
					<div class="fields">
						<input type="radio" name="resultado" value="1" <?php echo ($eval->tipo_resultado == 1)? 'CHECKED': '' ?> /> Numérico &nbsp; <input type="radio" name="resultado" value="2" <?php echo ($eval->tipo_resultado == 2)? 'CHECKED': '' ?> /> Cualitativo
					</div>
				</div>
				<div class="actions">
					<br />
					<button type="submit" class="btn primary" tabindex="1">
						Editar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>