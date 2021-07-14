<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Trabajadores ingresados para solicitud de revision de examenes completas</b></h2>
		<span class='badge' style='background-color:#D7DF01'>EP</span> En Proceso <span class='badge' style='background-color:green'>A</span> Aprobado <span class='badge' style='background-color:red'>R</span> Rechazado <span class='badge' style='background-color:#886A08'>NA</span> No Asiste
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<table id="example1">
					<thead class="center">
						<th>#</th>
						<th>Rut</th>
						<th>Nombres</th>
						<th>Ciudad</th>
						<th>Fono</th>
						<th>Especialidad</th>
						<th>Fecha Nacim.</th>
						<th>Centro Costo</th>
						<th>Requerimiento Asociado</th>
						<th>Referido</th>
						<th>Cargo</th>
						<th>Area</th>
						<th>Fecha Solicitud</th>
						<th>Fecha Ingreso Esperada</th>
						<th>Masso</th>
						<th>Examen Preo.</th>
						<th>Examen Psicológico</th>
						<th>Observaciones</th>
						<!--<th>Enviar</th>-->
					</thead>
					<tbody>
						<?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
						<tr>
							<td>
								<?php echo $i ?>
								<input type="hidden" name="usuarios[<?php echo $i ?>]" value="<?php echo $row->usuario_id ?>" <?php if($row->referido == NULL) echo "disabled"; ?> >
								<input type="hidden" name="id_requerimiento[<?php echo $i ?>]" value="<?php echo $row->id_req ?>">
								<input type="hidden" name="id_asc_trab[<?php echo $i ?>]" value="<?php echo $row->id_asc_trab ?>">
								<input type="hidden" name="id_solicitud[<?php echo $i ?>]" value="<?php echo $row->id_solicitud ?>">
							</td>
							<td><?php echo $row->rut ?></td>
							<td><a href="<?php echo base_url() ?>carrera/trabajadores/trabajador_carrera/<?php echo $row->usuario_id ?>" target="_blank"><?php echo $row->nombres ?></a></td>
							<td><?php echo $row->desc_ciudades ?></td>
							<td><?php echo $row->fono ?></td>
							<td><?php echo $row->especialidad1 ?> <?php if(!$row->especialidad2){}else echo " / ".$row->especialidad2 ?></td>
							<td><?php echo $row->fecha_nac ?></td>
							<td><?php echo $row->empresa_planta ?></td>
							<td><?php echo $row->nombre_req ?></td>
							<td><?php if($row->referido == 0 and $row->referido != NULL) echo "No"; elseif($row->referido == 1) echo "Si" ?></td>
							<td><?php echo $row->nombre_cargo ?></td>
							<td><?php echo $row->nombre_area ?></td>
							<td><?php echo $row->fecha_solicitud ?></td>
							<td><?php echo $row->fecha_esperada_ingreso ?></td>
							<td style="text-align:center">
								<?php if($row->examen_masso != 0){ ?>
									<?php if($row->masso_id != NULL){ ?>
										<span class='badge' style='background-color:<?php echo $row->color_estado_eval_sre_masso ?>'><?php echo $row->letra_estado_eval_sre_masso ?></span><br>
										<a style='color:<?php echo $row->color_masso ?>'><?php echo $row->masso; if($row->masso == "N/D") echo "<br>"; ?></a>
										<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen masso" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_masso ?>/1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
									<?php }else{
										if($row->id_sre_agenda_masso != NULL)
											echo "<span class='badge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/1/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</a></font>";
										else
											echo "<span class='badge' style='background-color:#D7DF01'>EP</span><br><font color='red'>No Agendado</font>";
									} ?>
								<?php } ?>
							</td>
							<td style="text-align:center">
								<?php if($row->examen_preo != 0){ ?>
									<?php if($row->preo_id != NULL){ ?>
										<span class='badge' style='background-color:<?php echo $row->color_estado_eval_sre_preo ?>'><?php echo $row->letra_estado_eval_sre_preo ?></span><br>
										<a style='color:<?php echo $row->color_preo ?>'><?php echo $row->examen_pre; if($row->examen_pre == "N/D") echo "<br>"; ?></a>
										<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen preocupacional" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_preo ?>/1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
									<?php }else{
										if($row->id_sre_agenda_preo != NULL)
											echo "<span class='badge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/2/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
										else
											echo "<span class='badge' style='background-color:#D7DF01'>EP</span><br><font color='red'>No Agendado</font>";
									} ?>
								<?php } ?>
							</td>
							<td style="text-align:center">
								<?php if($row->examen_psicologico != 0){ ?>
									<?php if($row->eval_psic_id != NULL){ ?>
										<span class='badge' style='background-color:<?php echo $row->color_estado_eval_sre_psic ?>'><?php echo $row->letra_estado_eval_sre_psic ?></span><br>
										<?php if($tipo_usuario == "psicologo"){ ?>
										<a href="<?php echo base_url() ?>carrera/examen_psicologico/detalle/<?php echo $row->eval_psic_id ?>" style='color:<?php echo $row->color_psic ?>' target="_blank"><?php echo $row->examen_psic; ?></a><br>
										<?php }else{ ?>
										<a style='color:<?php echo $row->color_psic ?>'><?php echo $row->examen_psic; ?></a><br>
										<?php } ?>
										<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen psicologico" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_psic ?>/1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
									<?php }else{
										if($row->id_sre_agenda_psic != NULL)
											echo "<span class='badge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/3/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
										else
											echo "<span class='badge' style='background-color:#D7DF01'>EP</span><br><font color='red'>No Agendado</font>";
									} ?>
								<?php } ?>
							</td>
							<td><?php echo $row->observaciones ?></td>
							<!--<td style="text-align:center">
								<input type="checkbox" name="check_estado[<?php echo $i ?>]" id="check_estado[<?php echo $i ?>]" value="<?php echo $row->usuario_id ?>" <?php if($row->referido == NULL) echo "title='Este trabajador no esta asociado a un requerimiento activo' disabled"; ?> >
							</td>-->
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div><br>
	</div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->