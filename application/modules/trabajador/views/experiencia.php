<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.js"></script>
<!--<script src="<?php echo base_url() ?>extras/js/trabajador_experiencia.js" type="text/javascript"></script>-->
<?php echo @$aviso; ?>
<div class="span2"></div>
<div class="span11">
<h2>Listado de experiencias</h2>
<p>
	En esta sección usted podrá ingresar la experiencia que ha tenido como trabajador.
</p>
<table class="data display">
	<thead>
		<tr>
			<th>Desde</th>
			<th>Hasta</th>
			<th>Cargo</th>
			<th>Area</th>
			<th>Empresa contratista</th>
			<th>Empresa mandante/planta</th>
			<th>Principales funciones</th>
			<th>Referencias</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if( count($experiencia) > 0 ){ ?>
		<?php foreach ($experiencia as $ex) { ?>
		<tr class="odd gradeX">
			<?php $f_desde = explode("-", $ex->desde) ?>
			<td><?php echo $f_desde[2].'-'.$f_desde[1].'-'.$f_desde[0] ?></td>
			<?php $f_hasta = explode("-", $ex->hasta) ?>
			<td><?php echo $f_hasta[2].'-'.$f_hasta[1].'-'.$f_hasta[0] ?></td>
			<td><?php echo $ex->cargo ?></td>
			<td><?php echo $ex->area ?></td>
			<td><?php echo $ex->empresa_c ?></td>
			<td><?php echo $ex->empresa_m ?></td>
			<td>
				<?php echo $ex->funciones; ?>
			<!--<?php $funciones = explode(";", $ex->funciones); ?>
			<?php for($i=0;$i<(count($funciones)-1);$i++){
				echo ucwords(strtolower($funciones[$i]));
				if($i < (count($funciones)-2)) echo ", ";
			} ?>-->
			</td>
			<td>
				<?php echo $ex->referencias; ?>
			<!--<?php $referencia = explode(";", $ex->referencias); ?>
			<?php for($i=0;$i<(count($referencia)-1);$i++){
				echo ucwords(strtolower($referencia[$i]));
				if($i < (count($referencia)-2)) echo ", ";
			} ?>-->
			</td>
			<td class="center"><a class="dialog" href="<?php echo base_url()?>mandante/areas/html_editar/areas/<?php echo $ex->id ?>">editar</a></td>
			<td class="center"><a class="eliminar ajax" href="<?php echo base_url() ?>trabajador/experiencia/eliminar/<?php echo $ex->id ?>">eliminar</a></td>
		</tr>
		<?php } ?>
		<?php } else{ ?>
		<tr class="odd gradeX">
			<td colspan="10">no existen experiencias agregadas</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>
<!-- OVERLAY CON EL INGRESO UNA EXPERIENCIA -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de nueva experiencia</h3>
	</div>
	<div id="modal_content">
		<div style="width: 420px;">
			<form action="<?php echo base_url() ?>trabajador/experiencia/agregar" method="post" class="form">
				<div class="field select">
					<label for="desde">Desde<span class="required">*</span></label>
					<div class="fields">
						<select name="select_dia_desde" style="width:70px;">
							<option value="">Dia</option>
							<?php for ($i=1; $i < 32 ; $i++) { ?> 
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="select_mes_desde" style="width:100px;">
							<option value="">Mes</option>
							<?php for ($i=1; $i < 13 ; $i++) { ?> 
							<option value="<?php echo $i ?>"><?php echo $meses[$i-1] ?></option>
							<?php } ?>
						</select>
						<select name="select_ano_desde" style="width:70px;">
							<option value="">Año</option>
							<?php for ($i= date('Y'); $i > 1931 ; $i--) { ?> 
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
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
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
						<select name="select_mes_hasta" style="width:100px;">
							<option value="">Mes</option>
							<?php for ($i=1; $i < 13 ; $i++) { ?> 
							<option value="<?php echo $i ?>"><?php echo $meses[$i-1] ?></option>
							<?php } ?>
						</select>
						<select name="select_ano_hasta" style="width:70px;">
							<option value="">Año</option>
							<?php for ($i= date('Y'); $i > 1931 ; $i--) { ?> 
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="desde">Cargo<span class="required">*</span></label>
					<div class="fields">
						<input type="text" name="cargo" size="35" />
					</div>
				</div>
				<div class="field">
					<label for="desde">Area<span class="required">*</span></label>
					<div class="fields">
						<input type="text" name="area" size="35" />
					</div>
				</div>
				<div class="field">
					<label for="desde">Empresa contratista<span class="required">*</span></label>
					<div class="fields">
						<input type="text" name="contratista" size="35" />
					</div>
				</div>
				<div class="field">
					<label for="desde">Empresa mandante/planta</label>
					<div class="fields">
						<input type="text" name="mandante" size="35" />
					</div>
				</div>
				<div class="field">
					<label for="desde">Principales funciones<span class="required">*</span></label>
					<div class="fields">
						<textarea name="funciones"></textarea>
					</div>
				</div>
				<div class="field">
					<label for="desde">Referencias</label>
					<div class="fields">
						<textarea name="referencias"></textarea>
					</div>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary" tabindex="1">
						Crear
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- -->