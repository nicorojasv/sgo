<div class="panel panel-white">
	<div class="panel-heading">
		<?php if($datos_generales != FALSE){ ?>
			<?php foreach ($datos_generales as $usu){ ?>
				<div class="row">
					<div class="col-md-6 col-sd-6">
						<h5><b><u>Datos trabajador:</u></b></h5>
						<table class="table">
							<tbody>
								<tr>
									<td><b>Nombres</b></td>
									<td><?php echo $usu->nombres_apellidos ?></td>
								</tr>
								<tr>
									<td><b>Rut</b></td>
									<td><?php echo $usu->rut ?></td>
								</tr>
								<tr>
									<td><b>Estado Civil</b></td>
									<td><?php echo $usu->estado_civil ?></td>
								</tr>
								<tr>
									<td><b>Fecha Nacimiento</b></td>
									<td><?php echo $usu->fecha_nac ?></td>
								</tr>
								<tr>
									<td><b>Domicilio</b></td>
									<td><?php echo $usu->domicilo ?></td>
								</tr>
								<tr>
									<td><b>Ciudad</b></td>
									<td><?php echo $usu->ciudad ?></td>
								</tr>
								<tr>
									<td><b>Previsión</b></td>
									<td><?php echo $usu->prevision ?></td>
								</tr>
								<tr>
									<td><b>Salud</b></td>
									<td><?php echo $usu->salud ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6  col-sd-6">
						<h5><b><u>Datos adicionales:</u></b></h5>
						<table class="table">
							<tbody>
								<tr>
									<td><b>Nombre Requerimiento</b></td>
									<td><font color="#0101DF"><?php echo $usu->nombre_req ?></font></td>
								</tr>
								<tr>
									<td><b>Referido</b></td>
									<td><?php if($usu->referido == 1) echo "SI"; else echo "NO";  ?></td>
								</tr>
								<tr>
									<td><b>Puesto de trabajo/Cargo</b></td>
									<td><?php echo $usu->cargo ?></td>
								</tr>
								<tr>
									<td><b>Area Trabajo</b></td>
									<td><?php echo $usu->area ?></td>
								</tr>
								<tr>
									<td><b>Centro de Costo</b></td>
									<td><?php echo $usu->nombre_centro_costo ?></td>
								</tr>
								<tr>
									<td><b>Nivel Educacional</b></td>
									<td><?php echo $usu->nivel_estudios ?></td>
								</tr>
								<tr>
									<td><b>Teléfono</b></td>
									<td><?php echo $usu->telefono ?></td>
								</tr>
								<tr>
									<td><b>Nacionalidad</b></td>
									<td><?php echo $usu->nacionalidad ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<h5><b><u>Datos empresa:</u></b></h5>
				<div class="row">
					<div class="col-md-6  col-sd-6">
						<table class="table">
							<tbody>
								<tr>
									<td><b>Razón Social</b></td>
									<td><?php echo $usu->nombre_centro_costo ?></td>
								</tr>
								<tr>
									<td><b>Rut</b></td>
									<td><?php echo $usu->rut_centro_costo ?></td>
								</tr>
								<tr>
									<td><b>Planta</b></td>
									<td><?php echo $usu->nombre_planta ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6  col-sd-">
						<table class="table">
							<tbody>
								<tr>
									<td><b>Dirección Planta</b></td>
									<td><?php echo $usu->direccion_planta ?></td>
								</tr>
								<tr>
				                  <td><b>Comuna Planta</b></td>
				                  <td>
				                    <?php echo $usu->ciudad_planta ?>
				                  </td>
				                </tr>
								<tr>
									<td><b>Región Planta</b></td>
									<td><?php echo $usu->region_planta ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	<div class="panel-body">
		<div class="col-md-8"></div>
		<div class="col-md-4">
          	<a data-toggle="modal" href="<?php echo base_url() ?>marina_chillan/requerimientos/modal_agregar_contrato_anexo/<?php echo $id_usuario ?>/1/<?php echo $id_asc_area_req ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalEditar"><input type="button" class='btn btn-blue' value="Agregar Contrato"></a>
          	<a data-toggle="modal" href="<?php echo base_url() ?>marina_chillan/requerimientos/modal_agregar_contrato_anexo/<?php echo $id_usuario ?>/2/<?php echo $id_asc_area_req ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalEditar"><input type="button" class='btn btn-blue' value="Agregar Anexo"></a>
			<br><br>
		</div>
		<div class="col-md-12">
			<table id='example1'>
				<thead>
					<th>ID</th>
					<th>Tipo Archivo</th>
					<th>Tipo Contrato</th>
					<th>Causal</th>
					<th>Motivo</th>
					<th>Fecha Inicio</th>
					<th>Fecha Termino</th>
					<th>Fecha Pago</th>
					<th>Jornada</th>
					<th>Renta Imponible</th>
					<th>Documento</th>
					<th>#</th>
				</thead>
				<tbody>
					<?php foreach ($contratos as $row) { ?>
						<tr>
							<td><?php echo $row->id_req_usu_arch ?></td>
							<td>Contrato</td>
							<td><?php if($row->id_tipo_contrato == 1) echo "Diario"; elseif($row->id_tipo_contrato == 2) echo "Mensual"; ?></td>
							<td><?php echo $row->causal ?></td>
							<td><?php echo $row->motivo ?></td>
							<td><?php echo $row->fecha_inicio ?></td>
							<td><?php echo $row->fecha_termino ?></td>
							<td><?php echo $row->fecha_pago ?></td>
							<td>
								<label title="<?php echo str_replace("<w:br/>","\n", $row->desc_jornada) ?>"><?php echo $row->jornada ?></label>
							</td>
							<td><?php echo $row->renta_imponible ?></td><td>
								<?php if($row->estado_generacion_contrato == 1){ ?>
								<a style="color:green"><i class="fa fa-thumbs-up"></i></a>
								<?php } else{ ?>
								<a style="color:red"><i class="fa fa-thumbs-down"></i></a>
								<?php } ?>
							</td>
    	                    <td>
    	                    	<a data-toggle="modal" href="<?php echo base_url() ?>marina_chillan/requerimientos/modal_administrar_contrato_anexo_doc_general/<?php echo $row->id_req_usu_arch ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalEditar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    	                    	<!--
								<a title="Eliminar Documento" class="eliminar" href="<?php echo base_url() ?>marina_chillan/requerimientos/eliminar_contratos_req_trabajador/<?php echo $id_usuario ?>/<?php echo $id_asc_area_req ?>/<?php echo $id_area_cargo_req ?>/<?php echo $row->id_req_usu_arch ?>"><i class="fa fa-trash-o"></i></a>
								-->
    	                    </td>
						</tr>
					<?php } ?>
					<?php foreach ($anexos as $row) { ?>
						<tr>
							<td><?php echo $row->id_req_usu_arch ?></td>
							<td>Anexo</td>
							<td><?php if($row->id_tipo_contrato == 1) echo "Diario"; elseif($row->id_tipo_contrato == 2) echo "Mensual"; ?></td>
							<td><?php echo $row->causal ?></td>
							<td><?php echo $row->motivo ?></td>
							<td><?php echo $row->fecha_inicio ?></td>
							<td><?php echo $row->fecha_termino ?></td>
							<td><?php echo $row->jornada ?></td>
							<td></td>
							<td><?php echo $row->renta_imponible ?></td>
							<td>
								<?php if($row->estado_generacion_contrato == 1){ ?>
								<a style="color:green"><i class="fa fa-thumbs-up"></i></a>
								<?php } else{ ?>
								<a style="color:red"><i class="fa fa-thumbs-down"></i></a>
								<?php } ?>
							</td>
							<td>
    	                    	<a data-toggle="modal" href="<?php echo base_url() ?>marina_chillan/requerimientos/modal_administrar_contrato_anexo_doc_general/<?php echo $row->id_req_usu_arch ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalEditar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<!--
								<a title="Eliminar Documento" class="eliminar" href="<?php echo base_url() ?>marina_chillan/requerimientos/eliminar_contratos_req_trabajador/<?php echo $id_usuario ?>/<?php echo $id_asc_area_req ?>/<?php echo $id_area_cargo_req ?>/<?php echo $row->id_req_usu_arch ?>"><i class="fa fa-trash-o"></i></a>
    	                    	-->
    	                    </td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<br>
		</div>
	</div>
</div>

<!-- Modal Agregar/Editar Doc. Contractuales-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar/Editar Documento Contractual</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->
