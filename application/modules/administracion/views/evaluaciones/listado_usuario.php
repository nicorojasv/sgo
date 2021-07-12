<div class="col-md-9 col-md-offset-2">
	<h3>Listado de Examenes de <b><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></b></h3>
	<a id='sv-callback-add' class="btn btn-blue pull-right" href="<?php echo base_url() ?>administracion/evaluaciones/crear_nuevo/<?php echo $id ?>">Nuevo Examen</a>
	<table class='table'>
		<thead>
			<th>Tipo Examen</th>
			<th>Nombre Evaluaci&oacute;n</th>
			<th>Fecha Evaluaci&oacute;n</th>
			<th>Fecha Vigencia</th>
			<th>Calificaci&oacute;n</th>
			<th>Observaci&oacute;n</th>
			<th>Archivo</th>
			<th>#</th>
		</thead>
		<tbody>
			<?php foreach ($listado as $l) { ?>
				<tr>
					<td><?php echo $l->nombre_tipo; ?></td>
					<td><?php echo $l->nombre_eval; ?></td>
					<td>
						<?php if($l->fecha_e) { $f_e = explode('-',$l->fecha_e); $f_e = $f_e[2].'-'.$f_e[1].'-'.$f_e[0]; } ?>
						<?php echo ($l->fecha_e) ? $f_e : '-' ; ?>
					</td>
					<td>
						<?php if($l->fecha_v) { $f_v = explode('-',$l->fecha_v); $f_v = $f_v[2].'-'.$f_v[1].'-'.$f_v[0]; } ?>
						<?php echo ($l->fecha_v) ? $f_v : '-' ; ?>
					</td>
					<td>
						<?php if($l->tipo_resultado == 2){ ?>
						<?php echo ($l->resultado == 1) ? 'Rechazado' : 'Aprobado'; ?>
						<?php } else { ?>
						<?php echo $l->resultado; ?>
						<?php } ?>
					</td>
					<td><?php echo $l->observaciones; ?></td>
					<td>
						<?php $href = (isset($l->url)) ? base_url().$l->url : '#'; ?>
						<?php $color = (isset($l->url)) ? "color:green":"color:red"; ?>
						<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
					</td>
					<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
							<a href="#" class="btn btn-xs btn-blue tooltips" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a>
							<a href="#" class="btn btn-xs btn-red tooltips" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
						</div>
					</td>
				</tr>
			<?php } ?>		
		</tbody>
	</table>
</div>