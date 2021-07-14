<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><b>TODOS LOS USUARIOS ASIGNADOS AL REQUERIMIENTO: </b><?php echo $nombre_req ?></h4>
		<span class='badge' style='background-color:#D7DF01'>EP</span> En Proceso <span class='badge' style='background-color:green'>A</span> Aprobado <span class='badge' style='background-color:red'>R</span> Rechazado <span class='badge' style='background-color:#886A08'>NA</span> No Asiste <span class='badge' style='background-color:#000000'>NG</span> No Gestionado
	</div>
	<div class="panel-body">
		<form action="<?php echo base_url() ?>carrera/trabajadores/solicitudes_revision_examenes" method="post">
			<div class="col-md-8">
				<a href="<?php echo base_url() ?>carrera/requerimiento/asignacion/<?php echo $id_requerimiento ?>"><i class="fa fa-reply"></i></a>
				<h5><b>FECHA TERMINO: </b><?php echo $fecha_termino ?></h5>
				<h5><?php echo '<b>FECHA SOLICITUD: </b>'.$fecha.' - <b>CENTRO DE COSTO: </b>'.$centro_costo.' - <b>PLANTA: </b>'.$planta ?></h5>
			</div>
			<div class="col-md-4">
				<input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" data-style="slide-right" class="btn btn-blue" value="Exportar a Excel">
				<?php if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 10 or $this->session->userdata('id') == 16 or $this->session->userdata('id') == 39 or $this->session->userdata('id') == 81){ ?>
				<button type="submit" class="btn btn-green">Enviar Revisión Examenes</button>
				<?php } ?>
	        </div>
			<?php if(!empty($listado)){ ?>
			<table id="example1">
				<thead>
		            <th style="text-align:center">Todos<br><input type="checkbox" onchange="togglecheckboxes(this,'seleccionar_todos[]')"></th>
					<th style="text-align:center">Nombre</th>
					<th style="text-align:center">Fecha</th>
					<th style="text-align:center">Referido</th>
					<th style="text-align:center">Area</th>
					<th style="text-align:center">Cargo</th>
					<th style="text-align:center">Examen Preo</th>
					<th style="text-align:center">MASSO</th>
					<th style="text-align:center">Exam. Psicol.</th>
					<th style="text-align:center">Doc. Contractuales</th>
					<th style="text-align:center">Contratos y Anexos<br>Generados/Creados</th>
					<th style="text-align:center">Status General</th>
					<th style="text-align:center">Jefe &Aacute;rea</th>
					<th style="text-align:center">Comentario</th>
					<th style="text-align:center">Acciones</th>
				</thead>
				<tbody>
					<?php foreach ($listado as $l) { ?>
						<tr>
		                    <td style="text-align:center"><input type="checkbox" name="seleccionar_todos[]" value="<?php echo $l->usuario_id ?>"></td>
							<td>
								<?php echo ucwords(mb_strtolower($l->nombre, 'utf-8')); ?>
							</td>
							<td>
								<a href="#" class="dob" data-type="combodate" data-name="fecha" data-value="<?php echo $l->fecha; ?>" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="D / MMM / YYYY" data-pk="<?php echo $l->id ?>" data-url="<?php echo base_url() ?>carrera/requerimiento/guardar_fecha"  data-original-title="Fecha de Ingreso"></a>
							</td>
							<td class="center">
								<a href="#" class="opcion_referido" data-type="select" data-name="referido" data-pk="<?php echo $l->id ?>" data-value="" data-url="<?php echo base_url() ?>carrera/requerimiento/guardar_fecha" data-original-title="Select sex">
									<?php echo ($l->referido)? 'Si':'No'; ?>
								</a>
							</td>
							<td class="center"><?php echo $l->nombre_area ?></td>
							<td class="center"><?php echo $l->nombre_cargo ?></td>
							<td class="center">
								<?php if(!empty($l->preocupacional)){ ?>
								<a target="_blank" style="color:<?php echo $l->color_examen ?>" href="<?php echo base_url().$l->preocupacional->url ?>"><i class="<?php echo $l->dedo_preo ?>"></i></a>
								<?php } else{ ?>
								<a target="_blank" style="color:red" href="#"><i class="fa fa-thumbs-down"></i></a>
								<?php } ?>
								<?php echo $l->badge_preo ?>
							</td>
							<td class="center">
								<?php if(!empty($l->masso)){ ?>
								<a target="_blank" style="color:<?php echo $l->color_masso ?>" href="<?php echo base_url().$l->masso->url ?>"><i class="<?php echo $l->dedo_masso ?>"></i></a>
								<?php } else{ ?>
								<a target="_blank" style="color:red" href="#"><i class="fa fa-thumbs-down"></i></a>
								<?php } ?>
								<?php echo $l->badge_masso ?>
							</td>
							<td class="center">
								<?php if(!empty($l->psicologico)){ ?>
								<a style="color:<?php echo $l->color_psicol ?>"><i class="<?php echo $l->dedo_psicol ?>"></i></a>
								<?php } else{ ?>
								<a style="color:red"><i class="fa fa-thumbs-down"></i></a>
								<?php } ?>
								<?php echo $l->badge_psicol ?>
							</td>
							<td class="center">
								<a class="sv-callback-list" data-usuario='<?php echo $l->usuario_id ?>' href="<?php echo base_url().'carrera/requerimiento/callback_view_documentos_general/'.$l->usuario_id ?>/<?php echo $l->id ?>/<?php echo $id_requerimiento ?>" style="color:blue;">
									<i class="fa fa-book" ></i>
								</a>
							</td>
							<td class="center">
								<a href="<?php echo base_url().'carrera/requerimiento/contratos_req_trabajador/'.$l->usuario_id ?>/<?php echo $l->id ?>/<?php echo $l->requerimiento_area_cargo_id ?>" style="color:blue;" target="_blank">
									<i class="fa fa-book" ></i>
									<?php echo $l->cantidad_contratos_realizados_generados."/".$l->cantidad_contratos_realizados ?>
								</a>
							</td>
							<td class="center">
								<a href="#" class="opcion_status" data-type="select" data-name="status" data-pk="<?php echo $l->id ?>" data-value="" data-url="<?php echo base_url() ?>carrera/requerimiento/guardar_fecha" data-original-title="Seleccione Estado">
									<?php 
									if ($l->status){
										//if($l->status == 1) echo "No Disponible";
										if($l->status == 2) echo "En Proceso";
										if($l->status == 3) echo "En Servicio";
										//if($l->status == 4) echo "Renuncia";
										if($l->status == 5) echo "Contrato Firmado";
										if($l->status == 6) echo "Contrato Finalizado";
										if($l->status == 7) echo "Renuncia Voluntaria";
									}
									else echo "No Contactado";
									?>
								</a>
							</td>
							<td>
								<a href="#" class="opcion_jefe_area" data-type="text" data-name="jefe_area" data-pk="<?php echo $l->id ?>" data-value="" data-url="<?php echo base_url() ?>carrera/requerimiento/guardar_fecha" data-original-title="Jefe de Area">
								<?php echo $l->jefe_area ?></a>
							</td>
							<td>
								<a href="#" class="comments" data-type="text" data-pk="<?php echo $l->id ?>" data-name="comentario" data-url="<?php echo base_url() ?>carrera/requerimiento/guardar_fecha" data-placeholder="Agregar comentario..." data-original-title="Comenta">
									<?php echo ($l->comentario)? $l->comentario : ''; ?>
								</a>
							</td>
							<td class="center">
								<a class='eliminar' href="<?php echo base_url() ?>carrera/requerimiento/eliminar_usuarios_general_req/<?php echo $l->id ?>/<?php echo $id_requerimiento ?>"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } else{ ?>
			<h5>No hay usuarios asignados a este requerimiento</h5>
			<?php } ?>
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	<form class="guardar_modal" method="post" action="" >
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h2 class="modal-title" id="myModalLabel">Comentario</h2>
	      </div>
	      <div class="modal-body">
	        
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="submit" class="btn btn-primary">Guardar</button>
	      </div>
  		</form>
    </div>
  </div>
</div>

<!-- Modal agregar usuarios al requerimiento-->
<div class="modal fade" id="ModalUsuarios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar Usuarios al Requerimiento</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!--<div id="divTableDataHolder" style="display:none">-->
<div id="divTableDataHolder" style="display:none">
	<meta content="charset=UTF-8"/>
  	<table>
      	<thead>
	      	<tr style="text-align:center">
	      		<td colspan="34" >TODOS LOS USUARIOS ASIGNADOS AL REQUERIMIENTO: </b><?php echo $nombre_req ?></td>
	      	</tr>
	      	<tr style="text-align:center;">
		        <th>/</th>
		        <th>Codigo Unico Requerimiento</th>
		        <th>Nombre Empresa EST</th>
		        <th>Rut Empresa EST</th>
		        <th>Nombres</th>
		        <th>Rut</th>
		        <th>Fecha Solicitud</th>
		        <th>Referido</th>
		        <th>Sexo</th>
		        <th>Ciudad</th>
		        <th>Area</th>
		        <th>Cargo</th>
		        <th>Masso</th>
		        <th>Valor Masso</th>
		        <th>Examen Preocupacional</th>
		        <th>Valor Examen</th>
		        <th>Centro Costo</th>
		        <th>Causal Legal Contratacion</th>
		        <th>Motivo de Contratacion</th>
		        <th>Dias Causal</th>
		        <th>Jornada</th>
		        <th>Fecha Inicio</th>
		        <th>Fecha Termino</th>
		        <th>Tiempo Duracion Contrato</th>
		        <th>Nivel Educacional</th>
		        <th>Jefe Area</th>
		        <th>Status Trabajador</th>
		        <th>Sueldo Base</th>
		        <th>Bono Responsabilidad</th>
		        <th>Sueldo Base + Bonos Fijos</th>
		        <th>Asignacion Colacion</th>
		        <th>Otros no Imponibles</th>
		        <th>Seguro de Vida Arauco</th>
		        <th>Comentarios</th>
	    	</tr>
	      </thead>
	      <tbody>
			<?php $i=1; foreach ($listado as $l) {

	          if ($l->sexo == 0){
	            $nombre_sexo = "Masculino";
	          }elseif($l->sexo == 1){
	            $nombre_sexo = "Femenino";
	          }else{
	            $nombre_sexo = "N/D";
	          }
	        ?>
	        <tr style="text-align:center">
	        	<td><?php echo $i ?></td>
	          	<td><?php echo $codigo_requerimiento ?></td>
	          	<td>Integra EST Ltda.</td>
	          	<td>76.735.710-9</td>
	          	<td><?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?></td>
	          	<td><?php echo ucwords(mb_strtolower($l->rut_usuario,'UTF-8')) ?></td>
	          	<td><?php echo $l->fecha; ?></td>
		      	<td><?php echo ($l->referido)? 'Si':'No'; ?></td>
	        	<td><?php echo $nombre_sexo ?></td>
	          	<td><?php echo $l->ciudad ?></td>
	          	<td><?php echo ucwords(mb_strtolower($l->nombre_area,'UTF-8')) ?></td>
	          	<td><?php echo ucwords(mb_strtolower($l->nombre_cargo,'UTF-8')) ?></td>
		        <td><?php echo $l->estado_masso ?></td>
		        <td><?php echo $l->valor_masso ?></td>
		        <td><?php echo $l->estado_preo ?></td>
		        <td><?php echo $l->valor_examen ?></td>
		        <td><?php echo $centro_costo ?></td>
		      	<td><?php echo $l->causal ?></td>
		      	<td><?php echo $l->motivo ?></td>
		      	<td><?php echo $l->dias_causal ?></td>
		      	<td><?php echo $l->jornada ?></td>
		      	<td><?php echo $l->fecha_inicio ?></td>
		      	<td><?php echo $l->fecha_termino ?></td>
		      	<td><?php echo $l->dias_contrato ?></td>
		      	<td><?php echo $l->nivel_estudios ?></td>
		        <td><?php echo $l->jefe_area ?></td>
		        <td>
		        	<?php 
						if ($l->status){
							if($l->status == 2) echo "En Proceso";
							if($l->status == 3) echo "En Servicio";
							if($l->status == 5) echo "Contrato Firmado";
						}
						else echo "No Contactado";
						?>
		        </td>
	          	<td><?php echo $l->renta_imponible ?></td>
	          	<td><?php echo $l->bono_responsabilidad ?></td>
	          	<td><?php echo $l->sueldo_base_mas_bonos_fijos ?></td>
	          	<td><?php echo $l->asignacion_colacion ?></td>
	          	<td><?php echo $l->otros_no_imponibles ?></td>
	          	<td><?php echo $l->seguro_vida_arauco ?></td>
		        <td><?php echo ($l->comentario)? $l->comentario : ''; ?></td>
	        </tr>
	        <?php $i++; } ?>
      	</tbody>
    </table>
</div>