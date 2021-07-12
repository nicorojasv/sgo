<!-- <script src="<?php echo base_url() ?>extras/js/wysihtml5/advanced.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/contrato.js" type="text/javascript"></script> -->
<!-- <script src="<?php echo base_url() ?>extras/js/raptor/dependencies/jquery-ui.js" type="text/javascript"></script> -->
<script src="<?php echo base_url() ?>extras/js/raptor/packages/raptor.0deps.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/contrato.js" type="text/javascript"></script> 
<div class="grid grid_18">
	<form method="post" name="form_contrato" action="<?php echo base_url() ?>administracion/contratos/guardar_contrato">
		<h3>Nombre del contrato</h3>
		<input type="text" name="nb_contrato" placeholder="Nombre del contrato" style="width: 569px;font-family: Arial;" />
		<br />
		<br />
		<h3>Texto del contrato</h3>
		<textarea style="font-family: Arial;color:#444;" name="txt_contrato" id="textarea" cols="110" rows="30" ></textarea>
		<br />
		<button id="btn_guardar" type="submit" class="btn primary">
			Guardar
		</button>
	</form>
</div>
<div class="grid grid_6">
	<div class="box">
		<h3>Variables</h3>
		<ul>
			<?php foreach($listado_tags as $lt): ?>
				<li class="tags"><a href="<?php echo $lt->variable ?>"><?php echo ucwords( mb_strtolower($lt->nombre, 'UTF-8')) ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>