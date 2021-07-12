<link href="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/subusuarios/tooltip.js" type="text/javascript"></script>
<div class="grid grid_18">
	<p>Especialidad requerida: <b><?php echo ucwords(mb_strtolower($especialidad,"UTF-8")) ?></b>
	</p>
	<ul class="gallery cf ui-sortable">
		<?php if(count($listado_usuarios) > 0){ ?>
		<?php foreach($listado_usuarios as $u){?>
		<li>
			<input type="hidden" name="id_usuario" value="<?php echo $u->id ?>" />
			<img alt="" src="<?php echo base_url().$u->foto ?>">
			<a class="tooltip" href="#" rel="<?php echo base_url()?>subusuario/requerimiento/tooltip/<?php echo $u->id ?>">
			<div><?php echo ucwords(mb_strtolower($u->nombres." ".$u->paterno." ".$u->materno,"UTF-8")) ?></div>
			<div><?php echo $u->rut ?></div>
			</a>
		</li>
		<?php } ?>
		<?php } else{ ?>
		<p>No existen usuarios para este criterio.</p>
		<?php }?>
	</ul>
	<br />
	<div style="width: 100%;height: 1px;position: relative;clear: both;"></div>
	<?php echo @$paginado ?>
	<br>
	<br>
</div>
<div class="grid grid_6">
	
</div>