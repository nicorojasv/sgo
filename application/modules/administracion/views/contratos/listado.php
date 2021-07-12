<script src="<?php echo base_url() ?>extras/js/contrato.js" type="text/javascript"></script> 
<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Trabajadores ingresados</h2>
	<?php if(count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th></th>
			<th>nombre</th>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="radio" name="edicion" value="<?php echo $l->id ?>" /></td>
				<td><a target="_blank" href="#"><?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
		<p>No existen contratos ingresados</p>
	<?php } ?>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/contratos/editor_contratos/" id="editar_contrato" class="btn xlarge primary dashboard_add">Editar</a>
	<a href="javascript:;" class="btn xlarge secondary dashboard_add" id="eliminar_contrato" >Eliminar</a>
</div>