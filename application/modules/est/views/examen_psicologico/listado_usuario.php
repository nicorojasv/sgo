<div class="panel panel-white">
	<div class="panel-heading">
		<?php foreach ($datos_examen as $row){
			echo "<h4 class='panel-title'>Listado de Archivos Examen Psicológico de <b>".$row->nombres_usuario."</b></h4>";
		} ?>
	</div>
	<div class="panel-body">
		<div class="row">
	  		<div class="col-md-1"></div>
	  		<div class="col-md-4">
	  			<?php foreach ($datos_examen as $row2){ ?>
	  			<table class="table">
	  				<tbody>
	  					<tr>
	  						<td><b>Especialidad(es) del Trabajador:</b></td>
	  						<td><?php echo $row2->especialidad1 ?> <?php if(!$row2->especialidad2){}else echo " / ".$row2->especialidad2 ?> <?php if(!$row2->especialidad3){}else echo " / ".$row2->especialidad3 ?></td>
	  					</tr>
	  					<tr>
	  						<td><b>Cargo a Postular:</b></td>
	  						<td><?php echo $row2->especialidad_post ?></td>
	  					</tr>
	  					<tr>
	  						<td><b>Técnico/Supervisor:</b></td>
	  						<td><?php echo $row2->tecnico_supervisor ?></td>
	  					</tr>
	  					<tr>
	  						<td><b>Sueldo Definido:</b></td>
	  						<td><?php echo $row2->sueldo_definido ?></td>
	  					</tr>
	  				</tbody>
	  			</table>
	  			<?php } ?>
	  		</div>
	  		<div class="col-md-1"></div>
	  		<div class="col-md-4">
	  			<?php foreach ($datos_examen as $row3){ ?>
	  			<table class="table">
	  				<tbody>
	  					<tr>
							<td><b>Fecha Solicitud:</b></td>
							<td><?php echo $row2->fecha_solicitud ?></td>
	  					</tr>
	  					<tr>
	  						<td><b>Solicitante:</b></td>
	  						<td><?php echo $row2->solicitante ?></td>
	  					</tr>
	  					<tr>
	  						<td><b>Lugar de Trabajo:</b></td>
	  						<td><?php echo $row2->lugar_trabajo ?></td>
	  					</tr>
	  					<tr>
	  						<td><b>Referido:</b></td>
	  						<td><?php if($row2->referido == 1) echo "SI"; if($row2->referido == 2 or $row2->referido == 0) echo "NO"; ?></td>
	  					</tr>
	  				</tbody>
	  			</table>
	  			<?php } ?>
	  		</div>
	  	</div>
		<div class="row">
	  		<div class="col-md-1"></div>
	  		<div class="col-md-9">
				<h4><b>Informe Psicológico</b></h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Evaluación</th>
							<th>Fecha P. Psicológica</th>
							<th>Psicólogo/a Evaluador</th>
							<th>Resultado</th>
							<th>Observación</th>
							<th>Archivo</th>
							<th style="text-align:center">Editar</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($datos_examen as $key){ ?>
						<tr>
							<td>Informe Psicologico</td>
							<td><?php echo $key->fecha_evaluacion ?></td>
							<td><?php echo $key->psicologo ?></td>
							<td><?php echo $key->resultado ?></td>
							<td><?php echo $key->observaciones ?></td>
							<td class="center">
								<?php if($key->url_informe == "NE"){ ?>
									<i style="color:red" class="fa fa-file" aria-hidden="true"></i>
								<?php }else{ ?>
									<a href="<?php echo base_url() ?><?php echo $key->url_informe ?>" target="_blank"><i style="color:green" class="fa fa-file" aria-hidden="true"></i></a>
									<?php if($this->session->userdata('tipo_usuario') == 5 or $this->session->userdata('id') == 2){ ?>
										<a class="eliminar" href="<?php echo base_url() ?>est/examen_psicologico/eliminar_archivo_examen/<?php echo $key->id_archivo_examen ?>/<?php echo $id_examen ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
									<?php }else{} ?>
								<?php } ?>
							</td>
							<td style="text-align:center">
								<?php if( $this->session->userdata('tipo_usuario') == 5 || $this->session->userdata('id') == 2|| $this->session->userdata('tipo_usuario') == 8){ ?>
									<a href="#" class="btn btn-xs btn-blue" data-original-title="Editar Informe" data-toggle="modal" data-target="#ModalAgregarInforme"><i class="fa fa-edit"></i></a>
								<?php }else{} ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<br><br>
			</div>
		</div>
		<div class="row">
	  		<div class="col-md-1"></div>
	  		<div class="col-md-4">
				<h4><b>Prueba Zulliger</b></h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Archivo</th>
							<th style="text-align:center">Archivo</th>
							<th style="text-align:center">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if($existe_zulliger == 0){ ?>
							<tr class="center">
								<td colspan="3">
									<?php if( $this->session->userdata('tipo_usuario') == 5 or $this->session->userdata('id') == 2){ ?>
		          						<input type="button" title="Agregar Nueva Prueba Zulliger" value="Agregar Nueva Prueba Zulliger" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregarZulliger">
									<?php }else{} ?>
	      						</td>
	      					</tr>
						<?php }else{
							foreach ($datos_zulliger as $row4){
						?>
							<tr>
								<td>Prueba Zulliger</td>
								<td class="center"><a href="<?php echo base_url() ?><?php echo $row4->url ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a></td>
								<td class="center">
									<?php if( $this->session->userdata('tipo_usuario') == 5 or $this->session->userdata('id') == 2){ ?>
										<a href="<?php echo base_url() ?>est/examen_psicologico/eliminar_archivo_examen/<?php echo $row4->id ?>/<?php echo $id_examen ?>" class="btn btn-xs btn-red tooltips eliminar" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
									<?php }else{} ?>
								</td>
							</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
			</div>
	  		<div class="col-md-1"></div>
	  		<div class="col-md-4">
				<h4><b>Prueba Complemento</b></h4>
				<table class="table">
					<thead>
						<tr>
							<th>Nombre Archivo</th>
							<th>Tipo Examen</th>
							<th>Archivo</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php if(empty($datos_complemento_kostick) and empty($datos_complemento_western)){ ?>
						<tr class="center">
							<td colspan="4">
								<?php if( $this->session->userdata('tipo_usuario') == 5 or $this->session->userdata('id') == 2){ ?>
          							<input type="button" title="Agregar Nueva Prueba Complemento" value="Agregar Nueva Prueba Complemento" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregarComplemento">
								<?php }else{} ?>
							</td>
						</tr>
						<?php }else{
							if(!empty($datos_complemento_kostick)){
							foreach ($datos_complemento_kostick as $key2){ ?>
							<tr>
								<td>Prueba Complemento</td>
								<td>
									<?php echo $key2->nombre ?>
								</td>
								<td class="center"><a href="<?php echo base_url() ?><?php echo $key2->url ?>" target="_blank"><i style="color:green" class="fa fa-file" aria-hidden="true"></i></a></td>
								<td class="center">
									<?php if( $this->session->userdata('tipo_usuario') == 5 or $this->session->userdata('id') == 2){ ?>
										<a href="<?php echo base_url() ?>est/examen_psicologico/eliminar_archivo_examen/<?php echo $key2->id_registro_archivo ?>/<?php echo $id_examen ?>" class="btn btn-xs btn-red tooltips eliminar" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
										<a class="btn btn-xs btn-blue pull-right" data-original-title="Editar" data-toggle="modal" data-target="#ModalEditarComplementoKostick"><i class="fa fa-edit"></i></a>
									<?php }else{} ?>
								</td>
							</tr>
						<?php
								}
							}
							if(!empty($datos_complemento_western)){
								foreach ($datos_complemento_western as $key2){ ?>
								<tr>
									<td>Prueba Complemento</td>
									<td>
										<?php echo $key2->nombre ?>
									</td>
									<td class="center"><a href="<?php echo base_url() ?><?php echo $key2->url ?>" target="_blank"><i style="color:green" class="fa fa-file" aria-hidden="true"></i></a></td>
									<td class="center">
										<?php if( $this->session->userdata('tipo_usuario') == 5 or $this->session->userdata('id') == 2){ ?>
											<a href="<?php echo base_url() ?>est/examen_psicologico/eliminar_archivo_examen/<?php echo $key2->id_registro_archivo ?>/<?php echo $id_examen ?>" class="btn btn-xs btn-red tooltips eliminar" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
											<a class="btn btn-xs btn-blue pull-right" data-original-title="Editar" data-toggle="modal" data-target="#ModalEditarComplementoWestern"><i class="fa fa-edit"></i></a>
										<?php }else{} ?>
									</td>
								</tr>
							<?php
									}
								}
							}
						?>
					</tbody>
				</table>
				<br><br><br>
			</div>
		</div>
	</div>
</div>


<!-- Modal Agregar Informe Psicologico-->
<div class="modal fade" id="ModalAgregarInforme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel" align="center">Registro de Informe Psicologico</h2>
      </div>
      <div class="modal-body">
      	
      	<?php foreach ($datos_examen as $row5){ ?>
        <form action="<?php echo base_url() ?>est/examen_psicologico/subir_informe_psicologico" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
        	<input type="hidden" name="id_examen" id="id_examen" value="<?php echo $id_examen ?>">
        	<input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $row5->usuario_id ?>">
         	<div class="col-md-6">
          	<div class="control-group">
              <div class="controls">
              	<label class="control-label" for="inputTipo"><b>Archivo Anterior:</b></label>
          		<?php if($key->url_informe == "NE"){ ?>
					<i style="color:red" class="fa fa-file" aria-hidden="true"></i>
				<?php }else{ ?>
					<a href="<?php echo base_url() ?><?php echo $row5->url_informe ?>" target="_blank"><i style="color:green" class="fa fa-file" aria-hidden="true"></i></a>
				<?php } ?>
              </div>
            </div>
            <br><br>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Evaluacion</label>
              	<div class="controls">
              		<?php
						$f = explode('-', $row5->fecha_evaluacion);
						$dia_e = $f[2];
						$mes_e = $f[1];
						$ano_e = $f[0];
					?>
	              	<select name="dia_e" style="width: 60px;" required>
						<option value="" >Dia</option>
						<?php for($i=1;$i<32;$i++){ ?>
						<option value="<?php echo $i ?>" <?php echo ($dia_e == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
						<?php } ?>
					</select>
					<select name="mes_e" style="width: 108px;" required>
						<option value="">Mes</option>
						<option value='01' <?php echo ($mes_e == '1')? "selected='selected'" : '' ?> >Enero</option>
						<option value='02' <?php echo ($mes_e == '2')? "selected='selected'" : '' ?> >Febrero</option>
						<option value='03' <?php echo ($mes_e == '3')? "selected='selected'" : '' ?> >Marzo</option>
						<option value='04' <?php echo ($mes_e == '4')? "selected='selected'" : '' ?> >Abril</option>
						<option value='05' <?php echo ($mes_e == '5')? "selected='selected'" : '' ?> >Mayo</option>
						<option value='06' <?php echo ($mes_e == '6')? "selected='selected'" : '' ?> >Junio</option>
						<option value='07' <?php echo ($mes_e == '7')? "selected='selected'" : '' ?> >Julio</option>
						<option value='08' <?php echo ($mes_e == '8')? "selected='selected'" : '' ?> >Agosto</option>
						<option value='09' <?php echo ($mes_e == '9')? "selected='selected'" : '' ?> >Septiembre</option>
						<option value='10' <?php echo ($mes_e == '10')? "selected='selected'" : '' ?> >Octubre</option>
						<option value='11' <?php echo ($mes_e == '11')? "selected='selected'" : '' ?> >Noviembre</option>
						<option value='12' <?php echo ($mes_e == '12')? "selected='selected'" : '' ?> >Diciembre</option>
					</select>
					<select name="ano_e" style="width: 70px;" required>
						<option value="">Año</option>
						<?php $tope_f = (date('Y') - 5 ); ?>
						<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
							<option value="<?php echo $i ?>" <?php echo ($ano_e == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
						<?php } ?>
					</select>
            	</div>
            </div>
            <br>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Vigencia</label>
              <div class="controls">
              		<?php
						$g = explode('-', $row5->fecha_vigencia);
						$dia_v = $g[2];
						$mes_v = $g[1];
						$ano_v = $g[0];
					?>
              		<select name="dia_v" style="width: 60px;">
						<option value="" >Dia</option>
						<?php for($i=1;$i<32;$i++){ ?>
						<option value="<?php echo $i ?>" <?php echo ($dia_v == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
						<?php } ?>
					</select>
					<select name="mes_v" style="width: 108px;">
						<option value="">Mes</option>
						<option value='01' <?php echo ($mes_v == '1')? "selected='selected'" : '' ?> >Enero</option>
						<option value='02' <?php echo ($mes_v == '2')? "selected='selected'" : '' ?> >Febrero</option>
						<option value='03' <?php echo ($mes_v == '3')? "selected='selected'" : '' ?> >Marzo</option>
						<option value='04' <?php echo ($mes_v == '4')? "selected='selected'" : '' ?> >Abril</option>
						<option value='05' <?php echo ($mes_v == '5')? "selected='selected'" : '' ?> >Mayo</option>
						<option value='06' <?php echo ($mes_v == '6')? "selected='selected'" : '' ?> >Junio</option>
						<option value='07' <?php echo ($mes_v == '7')? "selected='selected'" : '' ?> >Julio</option>
						<option value='08' <?php echo ($mes_v == '8')? "selected='selected'" : '' ?> >Agosto</option>
						<option value='09' <?php echo ($mes_v == '9')? "selected='selected'" : '' ?> >Septiembre</option>
						<option value='10' <?php echo ($mes_v == '10')? "selected='selected'" : '' ?> >Octubre</option>
						<option value='11' <?php echo ($mes_v == '11')? "selected='selected'" : '' ?> >Noviembre</option>
						<option value='12' <?php echo ($mes_v == '12')? "selected='selected'" : '' ?> >Diciembre</option>
					</select>
					<select name="ano_v" style="width: 70px;">
						<option value="">Año</option>
						<?php $tope_f = (date('Y') - 5 ); ?>
						<?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
							<option value="<?php echo $i ?>" <?php echo ($ano_v == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
						<?php } ?>
					</select>
                </div>
            </div>
          </div>
          <div class="col-md-6">
 			<div class="control-group">
              <div class="controls">
	              	<label class="control-label" for="inputTipo"><b>Actualizar Archivo:</b></label>
					<input type="file" class="form-control" name="documento"/>
              </div>
            </div>
            <br>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Resultado</label>
              <div class="controls">
              		<select name="resultado" id="resultado" class="form-control" required>
              			<option value="">[Seleccione]</option>
              			<option value="A" <?php if($row5->resultado == "A") echo "selected" ?> >A</option>
              			<option value="B" <?php if($row5->resultado == "B") echo "selected" ?> >B</option>
              			<option value="C" <?php if($row5->resultado == "C") echo "selected" ?> >C</option>
              			<option value="NA" <?php if($row5->resultado == "NA") echo "selected" ?> >No Aprueba</option>
              		</select>
                </div>
            </div>
            <br>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Psicologo/a Evaluador</label>
              <div class="controls">
              		<select name="psicologo" id="psicologo" class="form-control" required>
              			<option value="">[Seleccione]</option>
              			<?php foreach ($psicologos as $key){ ?>
              			<option value="<?php echo $key->id ?>" <?php if($row5->psicologo_id == $key->id) echo "selected" ?>  ><?php echo $key->nombres." ".$key->paterno." ".$key->materno ?></option>
              			<?php } ?>
              		</select>
                </div>
            </div>
            <br>
            <div class="control-group">
              	<label class="control-label" for="inputTipo">Observacion</label>
              	<div class="controls">
              		<textarea name="observaciones" id="observaciones"><?php echo $row5->observaciones ?></textarea>
                </div>
            </div>
          </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal Agregar Prueba Zullinger-->
<div class="modal fade" id="ModalAgregarZulliger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel" align="center">Registro de Nueva Prueba de Zulliger</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>est/examen_psicologico/subir_prueba_zulling" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <input type="hidden" name="id_examen" id="id_examen" value="<?php echo $id_examen ?>">
          <div class="col-md-3"></div>
          <div class="col-md-8">
            <div class="control-group">
              	<div class="controls">
	              	<label class="control-label" for="inputTipo">Archivo:</label>
					<input type="file" name="documento" required/>
              	</div>
            </div>
          </div><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Prueba Complemento-->
<div class="modal fade" id="ModalAgregarComplemento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel" align="center">Registro de Nueva Prueba de Complemento</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>est/examen_psicologico/subir_prueba_complemento" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <input type="hidden" name="id_examen" id="id_examen" value="<?php echo $id_examen ?>">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="control-group">
              <div class="controls">
	              	<label class="control-label" for="inputTipo">Tipo Examen:</label>
	              	<select name="tipo_examen" id="tipo_examen" required>
	              		<option value="">[Seleccione]</option>
	              		<option value="3">Kostick "Profesionales"</option>
	              		<option value="4">Western "Tecnicos"</option>
	              	</select>
              </div>
            </div>
            <br>
            <div class="control-group">
              <div class="controls">
	              	<label class="control-label" for="inputTipo">Archivo:</label>
					<input type="file" name="documento" required/>
              </div>
            </div>
          </div><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Prueba Complemento-->
<div class="modal fade" id="ModalEditarComplementoKostick" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel" align="center">Editar Prueba de Complemento</h2>
      </div>
      <div class="modal-body">
      	<?php foreach ($datos_complemento_kostick as $row1){ ?>
        <form action="<?php echo base_url() ?>est/examen_psicologico/actualizar_prueba_complemento" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <input type="hidden" name="id_examen" id="id_examen" value="<?php echo $id_examen ?>">
          <input type="hidden" name="id_registro_archivo" id="id_registro_archivo" value="<?php echo $row1->id_registro_archivo ?>">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="control-group">
              <div class="controls">
              	<label class="control-label" for="inputTipo"><b>Archivo Anterior:</b></label>
					<a href="<?php echo base_url() ?><?php echo $row1->url ?>" target="_blank"><i style="color:green" class="fa fa-file" aria-hidden="true"></i></a>
              </div>
            </div>
            <br>
            <div class="control-group">
              <div class="controls">
	              	<label class="control-label" for="inputTipo">Tipo Examen:</label>
	              	<select name="tipo_examen" id="tipo_examen" required>
	              		<option value="">[Seleccione]</option>
	              		<option value="3" <?php if($row1->tipo_examen_id == 3) echo "selected" ?> >Kostick "Profesionales"</option>
	              		<option value="4" <?php if($row1->tipo_examen_id == 4) echo "selected" ?> >Western "Tecnicos"</option>
	              	</select>
              </div>
            </div>
            <br>
            <div class="control-group">
            	<div class="controls">
	              	<label class="control-label" for="inputTipo">Actualizar Archivo:</label>
					<input type="file" name="documento"/>
              	</div>
            </div>
          </div><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal Editar Prueba Complemento-->
<div class="modal fade" id="ModalEditarComplementoWestern" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel" align="center">Editar Prueba de Complemento</h2>
      </div>
      <div class="modal-body">
      	<?php foreach ($datos_complemento_western as $row1){ ?>
        <form action="<?php echo base_url() ?>est/examen_psicologico/actualizar_prueba_complemento" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <input type="hidden" name="id_examen" id="id_examen" value="<?php echo $id_examen ?>">
          <input type="hidden" name="id_registro_archivo" id="id_registro_archivo" value="<?php echo $row1->id_registro_archivo ?>">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="control-group">
              <div class="controls">
              	<label class="control-label" for="inputTipo"><b>Archivo Anterior:</b></label>
					<a href="<?php echo base_url() ?><?php echo $row1->url ?>" target="_blank"><i style="color:green" class="fa fa-file" aria-hidden="true"></i></a>
              </div>
            </div>
            <br>
            <div class="control-group">
              <div class="controls">
	              	<label class="control-label" for="inputTipo">Tipo Examen:</label>
	              	<select name="tipo_examen" id="tipo_examen" required>
	              		<option value="">[Seleccione]</option>
	              		<option value="3" <?php if($row1->tipo_examen_id == 3) echo "selected" ?> >Kostick "Profesionales"</option>
	              		<option value="4" <?php if($row1->tipo_examen_id == 4) echo "selected" ?> >Western "Tecnicos"</option>
	              	</select>
              </div>
            </div>
            <br>
            <div class="control-group">
            	<div class="controls">
	              	<label class="control-label" for="inputTipo">Actualizar Archivo:</label>
					<input type="file" name="documento"/>
              	</div>
            </div>
          </div><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
        <?php } ?>
      </div>
    </div>
  </div>
</div>