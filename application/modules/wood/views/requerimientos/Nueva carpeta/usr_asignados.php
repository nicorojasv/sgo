<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/requerimiento_admin.js" type="text/javascript"></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() ?>extras/css/bootstrap-editable.css" />
<script src="<?php echo base_url() ?>extras/js/bootstrap-editable.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
	  $('.editable').editable();
	});
</script>
<div class="span11 prepend_1">
	<div>
		<?php echo $datos_req['planta']; ?> &gt;&gt; <?php echo $datos_req['ca']; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Solicitante: <b><?php echo $solicitante; ?></b>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php $f_d = explode('-',$datos_req['desde']); ?>
		<?php $f_d = $f_d[2].'-'.$f_d[1].'-'.$f_d[0]; ?>
		<?php $f_h = explode('-',$datos_req['hasta']); ?>
		<?php $f_h = $f_h[2].'-'.$f_h[1].'-'.$f_h[0]; ?>
		Desde:<?php echo $f_d; ?> &nbsp;&nbsp;&nbsp; Hasta:<?php echo $f_h; ?>
	</div>
	<?php echo @$aviso; ?>
	<?php if( count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th>#</th>
			<th>RUT</th>
			<th>Nombre</th>
			<th>Origen</th>
			<th>Fecha Inicio</th>
			<th>Fecha Termino</th>
			<th>Cargo</th>
			<th>Área</th>
			<th>Teléfono</th>
			<th>MASSO</th>
			<th>Examen</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach ($listado as $r) { ?>
			<tr class="odd gradeX">
				<td><input type="radio" name="asignar" value="<?php echo $r->id ?>" /></td>
				<td><?php echo $r->rut; ?></td>
				<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/trabajador/<?php echo $r->id_usr ?>"><?php echo $r->nombre. ' '.$r->paterno . ' '. $r->materno ; ?></a></td>
				<td><?php echo $r->origen ?></td>
				<td>
					<a class="editable" id="f_inicio" data-pk="<?php echo $r->id ?>" href="#" data-placement="left" data-type="date" data-viewformat="dd-mm-yyyy" data-url="<?php echo base_url() ?>administracion/requerimiento/editar_fecha" data-original-title="Editar Fecha Inicio"><?php echo $r->f_inicio ?></a>
				</td>
				<td><a class="editable" id="f_fin" data-pk="<?php echo $r->id ?>" href="#" data-placement="left" data-type="date" data-viewformat="dd-mm-yyyy" data-url="<?php echo base_url() ?>administracion/requerimiento/editar_fecha" data-original-title="Editar Fecha Término"><?php echo $r->f_fin ?></a></td>
				<td><?php echo $r->cargo ?></td>
				<td><?php echo $r->area ?></td>
				<td><?php echo $r->fono ?></td>
				<td><a href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $r->id_usr ?>" target="_blank"><?php echo $r->masso ?></a></td>
				<td><a href="<?php echo base_url() ?>administracion/evaluaciones/informe/<?php echo $r->id_usr ?>" target="_blank"><?php echo $r->examen_pre ?></a></td>
				<td><a href="<?php echo base_url() ?>administracion/requerimiento/eliminar_usr/<?php echo $id_req ?>/<?php echo $r->id_usr ?>"><img src="<?php echo base_url() ?>extras/img/delete-2.png"></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
	<p>No existen usuarios asignados.</p>
	<?php } ?>
</div>