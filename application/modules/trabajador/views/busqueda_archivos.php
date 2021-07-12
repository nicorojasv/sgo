<?php echo @$avisos; ?>
<div class="span8" style="margin-left:30px">
	<?php foreach($listado as $ld){ ?>
	<h2><?php echo $ld->nb_tipo ?></h2>
	<?php if($ld->existe == "no"){ ?>
	<p>No existen archivos</p>
	<?php } else {?>
	<table class="data display">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Fecha</th>
				<th colspan="2">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<$ld->cant;$i++){ ?>
			<tr class="odd gradeX">
				<td><?php echo $ld->nb_archivo[$i] ?></td>
				<td><?php echo $ld->fecha[$i] ?></td>
				<td><a href="<?php echo base_url().$ld->url[$i] ?>">Descargar</a></td>
				<td><a href="<?php echo base_url()?>trabajador/archivos/eliminar_archivo/<?php echo $ld->id_archivo[$i] ?>">Eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
	<br />
	<?php } ?>
	
	
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>trabajador/archivos/subir" class="btn xlarge secondary dashboard_add"><span></span>Subir Archivo</a>
	<a href="<?php echo base_url() ?>trabajador/archivos/buscar" class="btn xlarge primary dashboard_add">Buscar Archivo</a>
</div>