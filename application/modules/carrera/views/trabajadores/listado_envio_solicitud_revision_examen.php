<?php 
	if ($this->session->userdata('exito')==1) {//eliminar_solicitud_previa_revision_examen
?>
		<script type="text/javascript">
			alertify.success('Solicitud Eliminada Exitosamente');
		</script>
<?php
	$this->session->unset_userdata('exito');		
	}
?>

<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Trabajadores ingresados para envio de solicitud de revision de examenes</b></h2>
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
							<th>Fecha Nacim.</th>
							<th>Requerimiento Asociado</th>
							<th>Fecha Ingreso Esperada</th>
							<th>Tecnico/Supervisor</th>
							<th>Sueldo<br>Definido</th>
							<th>Eval. Solicitadas</th>
							<th>Observaciones</th>
							<th>Enviar</th>
							<th>Eliminar</th>
						</thead>
						<tbody>
							<?php $i = 0; foreach($listado as $row){ $i += 1; ?>
							<tr>
								<td><?php echo $i ?><input type="hidden" name="usuarios[<?php echo $i ?>]" value="<?php echo $row->usuario_id ?>"></td>
								<td><?php echo $row->rut ?></td>
								<td><?php echo $row->nombres ?></td>
								<td><?php echo $row->desc_ciudades ?></td>
								<td><?php echo $row->fecha_nac ?></td>
								<td>
									<?php if($row->req_activos == 0){ echo "------"; }else{ ?>
									<select class="form-control" name="requerimiento_asociado[<?php echo $i ?>]" id="requerimiento_asociado[<?php echo $i ?>]" <?php if($row->req_activos > 1) echo "style='background:#F87474' " ?> >
									<?php
										foreach ($row->requerimientos_activos as $req){
									?>
										<option value="<?php echo $req->id_req ?>" title="<?php echo "Area: ".$req->nombre_area." - Cargo: ".$req->nombre_cargo." - Referido: ".$req->referido." - Empresa: ".$req->empresa_planta ?>" ><?php echo $req->nombre_req; ?></option>
									<?php
										}
									?>
									</select>
									<?php } ?>
								</td>
								<td><input name="fecha_ingreso_esperado[<?php echo $i ?>]" type="text" id="fecha_ingreso_esperado[<?php echo $i ?>]" class="fecha_ingreso_esperado" size="10" value="<?php echo date('Y-m-d') ?>" readonly="true" title="Fecha de Ingreso Esperado para el trabajador" <?php if($row->req_activos == 0) echo "disabled hidden"; ?> required/><?php if($row->req_activos == 0) echo "------"; ?></td>
								<td>
									<?php if($row->req_activos == 0){ echo "------"; }else{ ?>
									<select name="superv_tecnico[<?php echo $i ?>]" id="superv_tecnico[<?php echo $i ?>]" <?php if($row->req_activos == 0) echo "disabled hidden"; ?> class="form-control" required>
										<option value="">[Seleccione]</option>
										<option value="1">Tecnico</option>
										<option value="2">Supervisor</option>
									</select>
									<?php } ?>
								</td>
								<td><input type="text" class="input-mini" name="sueldo_definido[<?php echo $i ?>]" id="sueldo_definido[<?php echo $i ?>]" style="width:90%" value="0" <?php if($row->req_activos == 0) echo "disabled hidden"; ?> required><?php if($row->req_activos == 0) echo "------"; ?></td>
								<td>
									<?php if($row->req_activos == 0){ echo "------"; }else{ ?>
									<input type="checkbox" name="examen_preo[<?php echo $i ?>]" id="examen_preo[<?php echo $i ?>]" <?php if($row->req_activos == 0) echo "disabled hidden"; else echo "checked onclick='javascript: return false;'"; if($row->envio_preo != NULL and $row->envio_preo != 0) echo "disabled title='Examen ya se encuentra solicitado para este requerimiento'"; ?> > <?php if($row->req_activos > 0) echo "Exam. Preoc." ?><br>
									<!--<input type="checkbox" name="examen_masso[<?php //echo $i ?>]" id="examen_masso[<?php //echo $i ?>]" <?php //if($row->req_activos == 0) echo "disabled hidden"; if($row->envio_masso != NULL and $row->envio_masso != 0) echo "disabled title='Examen ya se encuentra solicitado para este requerimiento'" ?> > <?php //if($row->req_activos > 0) echo "Masso" ?><br>-->
									
									<!--<input type="checkbox" name="examen_psicologico[<?php //echo $i ?>]" id="examen_psicologico[<?php //echo $i ?>]" <?php //if($row->req_activos == 0) echo "disabled hidden"; if($row->envio_psic != NULL and $row->envio_psic != 0) echo "disabled title='Examen ya se encuentra solicitado para este requerimiento'"; ?> > <?php //if($row->req_activos > 0) echo "Ev. Psic" ?>-->
									
									<?php } ?>
								</td>
								<td><input type="text" name="observaciones[<?php echo $i ?>]" id="observaciones[<?php echo $i ?>]" style="width:90%" <?php if($row->req_activos == 0) echo "disabled hidden"; ?> ><?php if($row->req_activos == 0) echo "------"; ?></td>
								<td style="text-align:center">
									<input type="checkbox" name="check_estado[<?php echo $i ?>]" id="check_estado[<?php echo $i ?>]" value="<?php echo $row->usuario_id ?>" <?php if($row->req_activos == 0) echo "title='Este trabajador no esta asociado a un requerimiento activo' disabled"; ?> >
								</td>
								<td>
									<a title="Eliminar Solicitud" class="eliminar" href="<?php echo base_url() ?>carrera/trabajadores/eliminar_solicitud_previa_revision_examen/<?php echo $row->id_solicitud_previa ?>"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div><br>
			<div class="row">
	  		    <div class="col-md-9"></div>
	      		<div class="col-md-3">
	      			<button class="btn btn-green btn-block" type="submit" name="enviar" value="enviar" title="Enviar solicitudes para revision de examenes de los trabajadores">
						Enviar Solicitud de Revisión
					</button>
	      		</div>
	    	</div>
	    	<br><br>
    	</form>
	</div>
</div>