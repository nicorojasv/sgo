<script type="text/javascript" src="<?php echo base_url() ?>extras/js/mandante/asignar_subusuarios.js"></script>
<?php echo @$aviso; ?>
<div class="grid grid_18">
	<h2>Asignar requerimiento a <?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno , 'UTF-8')) ?></h2>
	<form class="form">
		<div class="field select">
			<label>Requerimiento: <span class="required">*</span></label>
			<div class="fields">
				<select name="" id="req_select">
					<option value="">Seleccione Requerimiento</option>
					<?php foreach($req as $r){ ?>
					<option value="<?php echo $r->id ?>"><?php echo ucwords(mb_strtolower($r->nombre, 'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<div class="subreq">
			
		</div>
	</form>
</div>
<div class="grid grid_6">
	<a href="#" id="editar_req" class="btn primary xlarge block">Editar</a>
	<a href="<?php echo base_url() ?>mandante/subusuarios/asignar" id="asignar_req" class="btn secondary xlarge block">Asignar</a>
	<a href="#" id="eliminar_req" class="btn tertiary xlarge block">Eliminar</a>
</div>