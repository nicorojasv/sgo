<script src="<?php echo base_url() ?>extras/js/variables_contrato.js" type="text/javascript"></script> 
<div class="span8">
	<?php if( isset($listado)){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th style="width:20px">#</th>
				<th style="text-align: center;">Nombre</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="radio" name="ID" value="<?php echo $l->id ?>"></td>
				<td><?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
</div>
<div class='span3'>
	<a href="#" id="nuevo" class="btn xlarge primary dashboard_add">Nuevo</a>
	<a href="#" id="editar" class="btn xlarge secondary dashboard_add">Editar</a>
	<a href="#" id="eliminar" class="btn xlarge tertiary dashboard_add">Eliminar</a>
</div>