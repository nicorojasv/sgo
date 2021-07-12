<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores Inactivos</h4>
	</div>
	<div class="panel-body">
		<?php if( count($listado) > 0){ ?>
		<div class="row">
  		    <div class="col-md-1"></div>
      		<div class="col-md-10">
				<table id="example1">
					<thead>
						<tr>
							<th>Rut</th>
							<th>Nombre</th>
							<th>Apellido Paterno</th>
							<th>Apellido Materno</th>
							<th>Especialidad</th>
							<th>Fecha Actualizacion</th>
							<th>Masso</th>
							<th>Examen Preo</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($listado as $r){ ?>
						<tr class="odd gradeX">
							<td><?php echo $r->rut_usuario ?><input type="hidden" name="usuarios[]" value="<?php echo $r->id_usuario ?>"></td>
							<td><?php echo $r->nombre ?></td>
							<td><?php echo $r->ap_paterno ?></td>
							<td><?php echo $r->ap_materno ?></td>
							<td><?php echo $r->especialidad ?> <?php if(!$r->especialidad2){}else echo " / ".$r->especialidad2 ?> <?php if(!$r->especialidad3){}else echo " / ".$r->especialidad3 ?></td>
							<td><?php echo $r->fecha_actualizacion ?></td>
		                    <td><a style='color:<?php echo $r->color_masso ?>'><?php echo $r->masso ?></a></td>
		                    <td><a style='color:<?php echo $r->color_preo ?>'><?php echo $r->examen_pre ?></a></td>
							<td style="width:47px;">
								<a title="Editar" class="editar" href="<?php echo base_url() ?>usuarios/perfil/trabajador_est/<?php echo $r->id_usuario ?>" target="_blank"><i class="fa fa-pencil fa-fw"></i></a>
								<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2){ ?>
									<a title="Activar Trabajador" href="<?php echo base_url() ?>est/trabajadores/actualizar_trabajador/<?php echo $r->id_usuario ?>"><i class="fa fa-check"></i></a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
    	</div>
		<?php } else{ ?>
		<p>No existen trabajadores.</p>
		<?php } ?>
	</div>
</div>