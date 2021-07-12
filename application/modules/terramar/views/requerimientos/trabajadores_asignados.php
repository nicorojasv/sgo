<link href="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/mandante/listado_asignados.js" type="text/javascript"></script>
<div class="grid grid_18">
	<p><b><?php echo ucwords(mb_strtolower($nb_req, 'UTF-8')) ?></b>. Area: <?php echo ucwords(mb_strtolower($nb_area.'. Cargo: '. $nb_cargo, 'UTF-8')) ?></p>
	<ul class="gallery cf ui-sortable">
		<?php if(count($listado_usuarios) > 0){ ?>
		<?php foreach($listado_usuarios as $u){?>
		<li>
			<img alt="" src="<?php echo base_url().$u->foto ?>">
			<a class="tooltip" href="javascript:;" rel="<?php echo base_url()?>administracion/requerimiento/tooltip/<?php echo $u->id ?>">
			<div><?php echo ucwords(mb_strtolower($u->nombres." ".$u->paterno." ".$u->materno,"UTF-8")) ?></div>
			<div><?php echo $u->rut ?></div>
			</a>
		</li>
		<?php } ?>
		<?php } else{ ?>
		<p>No existen usuarios para este criterio.</p>
		<?php }?>
	</ul>
</div>