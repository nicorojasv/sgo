
	<script type="text/javascript">
			alertify.success('Usuarios Agregados Exitosamente');
		</script>

<div class="panel panel-white">

	<div class="panel-heading">
		<h4 class="panel-title"><b>NOMBRE REQUERIMIENTO: </b><?php echo $nombre_req ?> <b>USUARIOS ASIGNADOS A LA AREA-CARGO:</b> <?php echo $agregados.'/'.$cantidad ?></h4>
		
	</div>
	<div class="panel-body">
		<form action="<?php echo base_url() ?>carrera/trabajadores/solicitudes_revision_examenes" method="post">
			<div class="col-md-8">
				<a href="<?php echo base_url() ?>carrera/requerimientos/asignacion/<?php echo $id_requerimiento ?>"><i class="fa fa-reply"></i></a>
				<h5><b>FECHA TERMINO: </b><?php echo $fecha_termino ?></h5>
				<h5><?php echo '<b>FECHA SOLICITUD: </b>'.$fecha.' - <b>CENTRO DE COSTO: </b>'.$centro_costo.' - <b>PLANTA: </b>'.$planta.' <b>AREA-CARGO: </b>'.$area.' - '.$cargo ?></h5>
			</div>
			<div class="col-md-4">
	          	<a data-style="slide-right" class='btn btn-blue' href="<?php echo base_url() ?>carrera/requerimientos/usuarios_requerimientos_listado/<?php echo $area_cargo ?>">Agregar trabajadores</a>
				<?php //if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 10 or $this->session->userdata('id') == 16 or $this->session->userdata('id') == 39 or $this->session->userdata('id') == 81){ ?>
				
				<?php //} ?>
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
					<th style="text-align:center">Contratos y Anexos<br>Generados/Creados</th>
					<th style="text-align:center">Status General</th>
					<th style="text-align:center">Jefe &Aacute;rea</th>
					<th style="text-align:center">Comentario</th>
					<th style="text-align:center">Acciones</th>
				</thead>
				<tbody>
					<?php foreach ($listado as $l) { ?>
						<tr <?php if($paso_usuario){ echo ($l->usuario_id==$paso_usuario)?"style='background-color:#E6E6E6;'":""; } ?>>
	                        <td style="text-align:center"><input type="checkbox"  data-core="<?php echo titleCase($l->nombre) ?>" data-contrato="<?php echo $l->cantidad_contratos_realizados ?>" class="inptCheck" name="seleccionar_todos[]" value="<?php echo $l->usuario_id ?>"></td>
							<td><?php echo ucwords(mb_strtolower($l->nombre, 'utf-8')); ?></td>
							<td>
								<a href="#" class="dob" data-type="combodate" data-name="fecha" data-value="<?php echo $l->fecha; ?>" data-format="YYYY-MM-DD" data-viewformat="DD/MM/YYYY" data-template="DD / MMM / YYYY" data-pk="<?php echo $l->id ?>" data-url="<?php echo base_url() ?>carrera/requerimientos/guardar_fecha"  data-original-title="Fecha de Ingreso"></a>
							</td>
							<td class="center">
								<a href="#" class="opcion_referido" data-type="select" data-name="referido" data-pk="<?php echo $l->id ?>" data-value="" data-url="<?php echo base_url() ?>carrera/requerimientos/guardar_fecha" data-original-title="Select sex">
									<?php echo ($l->referido)? 'Si':'No'; ?>
								</a>
							</td>
							<td class="center">
								<?php echo $area ?>
							</td>
							<td class="center">
								<?php echo $cargo ?>
							</td>
							
							
							
							
							<td class="center">
								<a href="<?php echo base_url().'carrera/requerimientos/contratos_req_trabajador/'.$l->usuario_id ?>/<?php echo $l->id ?>/<?php echo $l->id_req ?>" style="color:blue;" target="_blank">
									<i class="fa fa-book" ></i>
									<?php echo $l->cantidad_contratos_realizados_generados."/".$l->cantidad_contratos_realizados ?>
								</a>
							</td>
							<td class="center">
								<a href="#" class="opcion_status" data-type="select" data-name="status" data-pk="<?php echo $l->id ?>" data-value="" data-url="<?php echo base_url() ?>carrera/requerimientos/guardar_fecha" data-original-title="Seleccione Estado">
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
								<a href="#" class="opcion_jefe_area" data-type="text" data-name="jefe_area" data-pk="<?php echo $l->id ?>" data-value="" data-url="<?php echo base_url() ?>carrera/requerimientos/guardar_fecha" data-original-title="Jefe de Area">
								<?php echo $l->jefe_area ?></a>
							</td>
							<td>
								<a href="#" class="comments" data-type="text" data-pk="<?php echo $l->id ?>" data-name="comentario" data-url="<?php echo base_url() ?>carrera/requerimientos/guardar_fecha" data-placeholder="Agregar comentario..." data-original-title="Comenta">
									<?php echo ($l->comentario)? $l->comentario : ''; ?>
								</a>
							</td>
							<td class="center">
								<a class='eliminar' href="<?php echo base_url() ?>carrera/requerimientos/eliminar_usuarios_req/<?php echo $l->id ?>/<?php echo $area_cargo ?>"><i class="fa fa-trash-o"></i></a>
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
