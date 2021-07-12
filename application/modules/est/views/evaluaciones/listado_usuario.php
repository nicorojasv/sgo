<div class="col-md-9 col-md-offset-2">
	<h3>Listado de Examenes de <b><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></b></h3>
	<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2 or $this->session->userdata('tipo_usuario') == 8 or $this->session->userdata('id') == 99 ){ ?>
		<a id='sv-callback-add' class="btn btn-blue pull-right" style="margin-left:10px;" href="<?php echo base_url() ?>est/evaluaciones/crear_examen/<?php echo $id ?>">Nuevo Examen</a>
		<a id='sv-callback-add1' class="btn btn-blue pull-right" href="<?php echo base_url() ?>est/evaluaciones/crear_masso/<?php echo $id ?>">Nuevo Masso</a>
	<?php } ?>
	<table class='table'>
		<thead>
			<th>Tipo Examen</th>
			<th>Nombre Evaluaci&oacute;n</th>
			<th>Fecha Evaluaci&oacute;n</th>
			<th>Fecha Vigencia</th>
			<th>Calificaci&oacute;n</th>
			<th>Observaci&oacute;n</th>
			<th>Valor</th>
			<th>Archivo</th>
			<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2 or $this->session->userdata('id') == 99 or $this->session->userdata('tipo_usuario') == 8 ){ ?>
				<th>#</th>
			<?php } ?>
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
						<?php
							if($l->tipo_resultado == 2){
								if($l->asistencia_examen == 0 and $l->resultado == 2)
									echo "No Asiste";
								else
									echo ($l->resultado == 1) ? 'Rechazado' : 'Aprobado';
							}else{
								echo $l->resultado;
							}
						?>
					</td>
					<td><?php echo $l->observaciones; ?></td>
					<td class="center"><?php echo $l->valor_examen; ?></td>
					<td>
						<?php $href = (isset($l->url)) ? base_url().$l->url : '#'; ?>
						<?php $color = (isset($l->url)) ? "color:green":"color:red"; ?>
						<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
					</td>
					<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2 or $this->session->userdata('id') == 99  or $this->session->userdata('tipo_usuario') == 8){ ?>
						<td class="center" style="width:66px;">
							<div class="visible-md visible-lg hidden-sm hidden-xs">
								<a href="<?php echo base_url() ?>est/evaluaciones/eliminar_examen/<?php echo $l->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-id="<?php echo $l->id ?>" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
								<a id="sv-callback-edit" href="<?php echo ($l->id_tipo == 4)? base_url().'est/evaluaciones/crear_masso/'.$id.'/'.$l->id : base_url().'est/evaluaciones/crear_examen/'.$id.'/'.$l->id; ?>" class="btn btn-xs btn-blue pull-right editar" data-id="<?php echo $l->id ?>" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a>
							</div>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>