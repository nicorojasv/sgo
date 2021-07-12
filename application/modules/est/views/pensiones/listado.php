<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Pensiones</h4>
		<div class="panel-tools">
			<div class="dropdown">
				<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
					<i class="fa fa-cog"></i>
				</a>
				<ul class="dropdown-menu dropdown-light pull-right" role="menu">
					<li>
						<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
					</li>
					<li>
						<a class="panel-refresh" href="#">
							<i class="fa fa-refresh"></i> <span>Refresh</span>
						</a>
					</li>
					<li>
						<a class="panel-config" href="#panel-config" data-toggle="modal">
							<i class="fa fa-wrench"></i> <span>Configurations</span>
						</a>
					</li>
					<li>
						<a class="panel-expand" href="#">
							<i class="fa fa-expand"></i> <span>Fullscreen</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row" >
			<div class="col-md-10"></div>
			<div class="col-md-2">
          		<input type="button" title="Agregar Nueva Pension" value="Agregar Nueva Pensión" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar">&nbsp;
			</div>
		</div><br>
		<div class="row">
	  		<div class="col-md-12">
				<table id="example1">
					<thead>
						<tr>
							<th>/</th>
							<th>Razón Social</th>
							<th>Rut</th>
							<th>Telefono</th>
							<th>Fecha Contrato</th>
							<th>N° Cuenta</th>
							<th>Pension Completa</th>
							<th>Almuerzo</th>
							<th>Reserva</th>
							<th>Otros Valores</th>
							<th>Centro Costo</th>
							<th>Documentos</th>
							<th>Editar</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; foreach ($lista_aux as $row){ $i += 1; ?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $row->razon_social ?></td>
							<td><?php echo $row->rut ?></td>
							<td><?php echo $row->telefono ?></td>
							<td><?php echo $row->fecha_contrato ?></td>
							<td><?php echo $row->n_cuenta ?></td>
							<td><?php echo $row->pension_completa ?></td>
							<td><?php echo $row->almuerzo ?></td>
							<td><?php echo $row->reserva ?></td>
							<td><?php echo $row->otros_valores ?></td>
							<td><?php echo $row->centro_costo ?></td>
							<td>
								<?php
									if($row->doc_contrato != NULL)
										$doc_contrato = "<a href='".base_url().$row->doc_contrato."' target='_blank'>Contrato</a>";
									else
										$doc_contrato = "<font style='color:red'>Contrato</font>";

									if($row->doc_cuenta != NULL)
										$doc_cuenta = "<a href='".base_url().$row->doc_cuenta."' target='_blank'>Cuenta</a>";
									else
										$doc_cuenta = "<font style='color:red'>Cuenta</font>";

									echo $doc_contrato." - ".$doc_cuenta;
								?>
							</td>
							<td class="center">
								<a title="Editar Datos Pension" data-target="#ModalEditar" data-toggle="modal" href="<?php echo base_url() ?>est/pensiones/editar/<?php echo $row->id_pension ?>"><i class="fa fa-pencil fa-fw"></i></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Editar Datos de la Pension-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Agregar Pension-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Registro de Nueva Pensión</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>est/pensiones/guardar_pension" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Rut</label>
              <div class="controls">
                <input type='text' class="input-mini" name="rut" id="rut" maxlength='12' onkeypress='return valida_letras_rut(event)' placeholder="11.111.111-1" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Razón Social</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="razon_social" id="razon_social" onkeypress='return valida_abecedario(event)' maxlength='200' required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">telefono</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="telefono" id="telefono" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Datos de la cuenta</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="cuenta" id="cuenta" maxlength='500' required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Documento del Contrato</label>
              <div class="controls">
              	<input type="file" name="doc_contrato" id="doc_contrato">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Documento de la cuenta</label>
              <div class="controls">
              	<input type="file" name="doc_cuenta" id="doc_cuenta">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Contrato</label>
              <div class="controls">
				<select name="dia_fc" style="width: 60px;" required>
					<option value="" >Dia</option>
					<?php for($i=1;$i<32;$i++){ ?>
					<option value="<?php echo $i ?>" ><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="mes_fc" style="width: 108px;" required>
					<option value="">Mes</option>
					<option value='01'>Enero</option>
					<option value='02'>Febrero</option>
					<option value='03'>Marzo</option>
					<option value='04'>Abril</option>
					<option value='05'>Mayo</option>
					<option value='06'>Junio</option>
					<option value='07'>Julio</option>
					<option value='08'>Agosto</option>
					<option value='09'>Septiembre</option>
					<option value='10'>Octubre</option>
					<option value='11'>Noviembre</option>
					<option value='12'>Diciembre</option>
				</select>
				<select name="ano_fc" style="width: 70px;" required>
					<option value="">Año</option>
					<?php $tope_f = (date('Y') - 2 ); ?>
					<?php for($i = $tope_f; $i < (date('Y') + 2 ); $i++){ ?>
						<option value="<?php echo $i ?>" ><?php echo $i ?></option>
					<?php } ?>
				</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Pension Completa</label>
                <div class="controls">
                   <input type="text" name="pension_completa" id="pension_completa" placeholder="Valor Pension Completa" required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Almuerzo</label>
                <div class="controls">
                   <input type="text" name="almuerzo" id="almuerzo" placeholder="Valor Almuerzo de la Pension" required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Reserva</label>
                <div class="controls">
                   <input type="text" name="reserva" id="reserva" placeholder="Valor Reserva de la Pension" required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Otros Valores</label>
                <div class="controls">
                   <input type="text" name="otros_valores" id="otros_valores" placeholder="Otros Valores de la Pension" required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Centro de Costo</label>
                <div class="controls">
                	<select name="centro_costo" id="centro_costo" required>
                		<option value="">[Seleccione]</option>
                		<?php foreach ($empresas_planta as $key) { ?>
                			<option value="<?php echo $key->id ?>"><?php echo $key->nombre ?></option>
						<?php } ?>
                	</select>
                </div>
            </div>
          </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>