<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Trabajadores ingresados para solicitud de revision de examenes pendientes</b></h2>
		<span class='badge' style='background-color:#D7DF01'>EP</span> En Proceso <span class='badge' style='background-color:green'>A</span> Aprobado <span class='badge' style='background-color:red'>R</span> Rechazado <span class='badge' style='background-color:#886A08'>NA</span> No Asiste
	</div>
	<div class="panel-body">
  		<form action="<?php echo base_url() ?>carrera/trabajadores/enviar_solicitud_revision_examenes" method='post'>
			<div class="row">
				<div class="col-md-12">
					<table id="example1">
						<thead class="center">
							<th>#</th>
							<th>Rut</th>
							<th>Nombres</th>
							<th>Ciudad</th>
							<th>Fono</th>
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
							<th>Examen Psicol.</th>
							<th>Observaciones</th>
							<!--<th>Liberar</th>-->
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
								<td><a href="<?php echo base_url() ?>carrera/trabajadores/detalle/<?php echo $row->usuario_id ?>" target="_blank"><?php echo $row->nombres ?></a></td>
								<td><?php echo $row->desc_ciudades ?></td>
								<td><?php echo $row->fono ?></td>
								<td><?php echo $row->fecha_nac ?></td>
								<td><?php echo $row->empresa_planta ?></td>
								<td><?php echo $row->nombre_req ?></td>
								<td><?php if($row->referido == 0 and $row->referido != NULL) echo "No"; elseif($row->referido == 1) echo "Si" ?></td>
								<td><?php echo $row->nombre_cargo ?></td>
								<td><?php echo $row->nombre_area ?></td>
								<td><?php echo $row->fecha_solicitud ?></td>
								<td><?php echo $row->fecha_esperada_ingreso ?></td>

								<?php if($tipo_usuario == "psicologo"){ ?>

									<td style="text-align:center">
										<?php if($row->examen_masso != 0){ ?>
											<?php if($row->masso_id != NULL){ ?>
												<container id="jsbadge<?php echo $row->sre_eval_req_id_masso ?>-1">
												<span class='badge jsbadge' style='background-color:<?php echo $row->color_estado_eval_sre_masso ?>'><?php echo $row->letra_estado_eval_sre_masso ?></span></container><br>
												<a style='color:<?php echo $row->color_masso ?>'><?php echo $row->masso; if($row->masso == "N/D") echo "<br>"; ?></a>
												<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen masso" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_masso ?>/1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
											<?php }else{
												if($row->id_sre_agenda_masso != NULL)
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/1/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
												else
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/1/1' data-toggle='modal' data-target='#ModalEditar'><font color='red'>Agendar</font></a>";
											} ?>
										<?php } ?>
									</td>
									<td style="text-align:center">
										<?php if($row->examen_preo != 0){ ?>
											<?php if($row->preo_id != NULL){ ?>
												<container id="jsbadge<?php echo $row->sre_eval_req_id_preo ?>-2">
												<span class='badge jsbadge' style='background-color:<?php echo $row->color_estado_eval_sre_preo ?>'><?php echo $row->letra_estado_eval_sre_preo ?></span></container><br>
												<a style='color:<?php echo $row->color_preo ?>'><?php echo $row->examen_pre; if($row->examen_pre == "N/D") echo "<br>"; ?></a>
												<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen preocupacional" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_preo ?>/1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
												<?php //echo $row->estado_preo ?>
											<?php }else{
												if($row->id_sre_agenda_preo != NULL)
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/2/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
												else
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/2/1' data-toggle='modal' data-target='#ModalEditar'><font color='red'>Agendar</font></a>";
											} ?>
										<?php } ?>
									</td>
									<td style="text-align:center">
										<?php if($row->examen_psicologico != 0){ ?>
											<?php if($row->eval_psic_id != NULL){ ?>
												<container id="jsbadge<?php echo $row->sre_eval_req_id_psic ?>-3">
												<span class='badge jsbadge' style='background-color:<?php echo $row->color_estado_eval_sre_psic ?>'><?php echo $row->letra_estado_eval_sre_psic ?></span></container><br>
												<a href="<?php echo base_url() ?>carrera/examen_psicologico/detalle/<?php echo $row->eval_psic_id ?>" style='color:<?php echo $row->color_psic ?>' target="_blank"><container id="jsbadge2<?php echo $row->sre_eval_req_id_psic ?>-3"><?php echo $row->examen_psic; if($row->examen_psic == "N/D") echo "<br>"; ?></container></a>
												<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen psicologico" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_psic ?>/0/<?php echo $row->eval_psic_id ?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
											<?php }else{
												if($row->id_sre_agenda_psic != NULL)
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/3' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
												else
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/3' data-toggle='modal' data-target='#ModalEditar'><font color='red'>Agendar</font></a>";
											} ?>
										<?php } ?>
									</td>

								<?php }elseif($tipo_usuario == "analista"){ ?>
								<!--EXAMEN MASSO-->
									<td style="text-align:center" >
										<?php if($row->examen_masso != 0){ ?>
											<?php if($row->masso_id != NULL){ ?>
												<container id="jsbadge<?php echo $row->sre_eval_req_id_masso ?>-1">
												<span class='badge jsbadge ' style='background-color:<?php echo $row->color_estado_eval_sre_masso ?>'><?php echo $row->letra_estado_eval_sre_masso ?></span></container><br>
												<a style='color:<?php echo $row->color_masso ?>'><?php echo $row->masso; if($row->masso == "N/D") echo "<br>"; ?></a>
												<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen masso" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_masso ?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
												<?php //echo $row->estado_masso ?>
											<?php }else{
												if($row->id_sre_agenda_masso != NULL)
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
												else
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/1' data-toggle='modal' data-target='#ModalEditar'><font color='red'>Agendar</font></a>";
											} ?>
										<?php } ?>
									</td>
								<!--EXAMEN PREOCUPACIONAL-->
									<td style="text-align:center">
										<?php if($row->examen_preo != 0){ ?>
											<?php if($row->preo_id != NULL){ ?>
												<container id="jsbadge<?php echo $row->sre_eval_req_id_preo ?>-2">
												<span class='badge jsbadge' style='background-color:<?php echo $row->color_estado_eval_sre_preo ?>'><?php echo $row->letra_estado_eval_sre_preo ?></span></container><br>
												<a style='color:<?php echo $row->color_preo ?>'><?php echo $row->examen_pre; if($row->examen_pre == "N/D") echo "<br>"; ?></a>
												<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen preocupacional" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_preo ?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
												<?php //echo $row->estado_preo ?>
											<?php }else{
												if($row->id_sre_agenda_preo != NULL)
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/2' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
												else
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/2' data-toggle='modal' data-target='#ModalEditar'><font color='red'>Agendar</font></a>";
											} ?>
										<?php } ?>
									</td>
								<!--EXAMEN PSICOLOGICO-->
									<td style="text-align:center">
										<?php if($row->examen_psicologico != 0){ ?>
											<?php if($row->eval_psic_id != NULL){ ?>
												<container id="jsbadge<?php echo $row->sre_eval_req_id_psic ?>-3">
												<span class='badge jsbadge' style='background-color:<?php echo $row->color_estado_eval_sre_psic ?>'><?php echo $row->letra_estado_eval_sre_psic ?></span></container><br>
												<a style='color:<?php echo $row->color_psic ?>' target="_blank"><?php echo $row->examen_psic; if($row->examen_psic == "N/D") echo "<br>"; ?></a>
												<a data-toggle="modal" data-target="#ModalEditar" title="Administrar examen psicologico" href="<?php echo base_url() ?>carrera/trabajadores/modal_editar_sre_eval_req/<?php echo $row->sre_eval_req_id_psic ?>/1"><i class="fa fa-cogs" aria-hidden="true"></i></a>
											<?php }else{
												if($row->id_sre_agenda_psic != NULL)
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/3/1' data-toggle='modal' data-target='#ModalEditar'><font color='blue'>Agendado</font></a>";
												else
													echo "<span class='badge jsbadge' style='background-color:#D7DF01'>EP</span><a href='".base_url()."carrera/trabajadores/modal_agendar_examen/".$row->id_solicitud."/3/1' data-toggle='modal' data-target='#ModalEditar'><font color='red'>Agendar</font></a>";
											} ?>
										<?php } ?>
									</td>
								<?php } ?>
								<td><?php echo $row->observaciones ?></td>
								<!--<td>
									<?php
										//if($row->proceso_completo == 0)
											//echo "<a href='".base_url()."carrera/trabajadores/liberar_solicitud_revision/".$row->id_solicitud."' ><span class='badge' style='background-color:green'>Liberar</span></a>";
									?>
								</td>-->
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div><br>
	    	<br><br>
    	</form>
	</div>
</div>

<!-- Modal Editar-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      	
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->