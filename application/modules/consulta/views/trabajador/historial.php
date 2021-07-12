<div id="contact_profile" class="grid grid_24 append_1">
	<table>
		<tbody>
			<tr>
				<td class="td_avatar">
					<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
						<img src="<?php echo base_url().$imagen_grande->thumb ?>" class="avatar" alt="Imagen Perfil">
					</a> 
				</td>
				<td class="td_info"><h1 class="contact_name"><?php echo ucwords(mb_strtolower($usuario -> nombres . ' ' . $usuario -> paterno . ' ' . $usuario -> materno,"UTF-8"));?></h1>
				<p class="contact_company">
					<?php if($this -> session -> userdata('tipo') == 3) $url = base_url().'administracion/trabajadores/buscar'; else $url = 'javascript:;'; ?>
					<a href="<?php echo $url ?>"><?php echo ucwords(mb_strtolower($tipo_usuario->desc_tipo_usuarios,"UTF-8")); ?></a>
				</p>
				<p class="contact_tags">
					<?php if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No se ha actualizado el perfil";
						else{
							 $act = explode("-",$usuario->fecha_actualizacion);
							$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
						} ?>
					<span>Ultima actualizacion: <?php echo $actualizacion ?></span>
				</p></td>
			</tr>
		</tbody>
	</table>
	<hr>
	<h2>Trabajos asignados</h2>
	<table class="data display">
		<thead>
			<tr>
				<th style="width:150px">Area</th>
				<th>Cargo</th>
				<th>Grupo</th>
				<th>Solicitud</th>
				<th>Fecha inicio*</th>
				<th>Fecha termino*</th>
				<th>Motivo</th>
			</tr>
		</thead>
		<tbody>
			<?php if($trabajos){ ?>
			<?php foreach ($trabajos as $t) { ?>
				<tr class="odd gradeX">
					<td><?php echo $t->area; ?></td>
					<td><?php echo $t->cargo; ?></td>
					<td><?php echo $t->grupo; ?></td>
					<td>
						<?php $fs = explode('-', $t->solicitud); ?>
						<?php echo $fs[2].'-'.$fs[1].'-'.$fs[0]; ?>
					</td>
					<td>
						<?php $fi = explode('-',$t->inicio); ?>
						<?php echo $fi[2].'-'.$fi[1].'-'.$fi[0]; ?>
					</td>
					<td>
						<?php $ff = explode('-',$t->fin); ?>
						<?php echo $ff[2].'-'.$ff[1].'-'.$ff[0]; ?>
					</td>
					<td><?php echo $t->motivo; ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</tbody>
	</table>
	<br />
	<div><b>* Fechas de Referencia</b></div>
</div>

