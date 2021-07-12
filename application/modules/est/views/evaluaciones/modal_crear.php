<div  style="width: 500px; height: auto;">
	<p>Trabajador: <a href="#"><?php echo ucwords( mb_strtolower($usr->nombres.' '.$usr->paterno.' '.$usr->materno, 'UTF-8')) ?></a></p>
	<form class="form" id="form_modal_crear" method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/evaluaciones/guardar_creacion_eval/<?php echo $usr->id ?>/">
		<div class="field select">
			<label><b>Evaluación </b>:</label> 
			<div class="fields">
			<select style="width: 244px;" name="evaluacion">
				<option value="">Seleccione</option>
				<?php foreach($examenes as $ex){ ?>
					<option value="<?php echo $ex->id_eval ?>"><?php echo ucwords(mb_strtolower($ex->nombre_eval, 'UTF-8')) ?></option>
				<?php } ?>
			</select>
			</div>
		</div>
		<div id="div_faena" style="display:none">
			<div class="field input">
				<label>Nombre Fanea:</label>
				<div class="fields">
					<input type="text" name="faena" placeholder='Faena' />
				</div>
			</div>
		</div>
		<div class="field input">
			<label>Fecha evaluación:</label>
			<div class="fields">
				<select name="dia_e" style="width: 60px;">
					<option value="" >Dia</option>
					<?php for($i=1;$i<32;$i++){ ?>
					<option ><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="mes_e" style="width: 108px;">
					<option value="">Mes</option>
					<?php $meses = meses(); ?>
					<?php foreach($meses as $m){ ?>
					<option value="<?php echo mesXdia($m); ?>"><?php echo $m ?></option>
					<?php } ?>
				</select>
				<select name="ano_e" style="width: 70px;">
					<option value="">Año</option>
					<?php $tope_f = (date('Y') - 5 ); ?>
					<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div id="div_desempeno" style="display:none">
			<div class="field input">
			<label>Fecha vigencia:</label>
			<div class="fields">
				<select name="dia_v" style="width: 60px;">
					<option value="" >Dia</option>
					<?php for($i=1;$i<32;$i++){ ?>
					<option><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="mes_v" style="width: 108px;">
					<?php $meses = meses(); ?>
					<option value="" >Mes</option>
					<?php foreach($meses as $m){ ?>
					<option value="<?php echo mesXdia($m); ?>"><?php echo $m ?></option>
					<?php } ?>
				</select>
				<select name="ano_v" style="width: 70px;">
					<option value="">Año</option>
					<?php $tope_f = (date('Y') - 5 );  ?>
					<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		</div>
		<div class="field select">
			<label>Resultado:</label>
			<div class="fields resultado">
				<select name="resultado">
					<option value="">Seleccione</option>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div id="div_recomienda" style="display:none">
			<div class="field input">
				<label>Recomienda?:</label>
				<div class="fields">
					no <input type="radio" name="recomienda" value='0' />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					si <input type="radio" name="recomienda" value='1'/>
				</div>
			</div>
		</div>
		<div class="field input">
			<label>Archivo:</label>
			<div class="fields">
				<input type="file" name="docu" />
			</div>
			<!-- .fields -->
		</div>
		<div class="field input">
			<label>Observación:</label>
			<div class="fields">
				<textarea name="obs" cols="40" rows="5"></textarea>
			</div>
			<!-- .fields -->
		</div>
		<div class="actions">
			<input type="hidden" name="id_ee" />
			<input type="hidden" name="tipo" value="<?php echo $tipo ?>" />
			<button type="submit" class="btn primary" id="guardar_nuevo_examen">
				Guardar
			</button>
		</div>
	</form>
</div>