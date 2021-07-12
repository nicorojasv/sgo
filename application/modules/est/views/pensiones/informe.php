<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Informe de Pensiones <b><?php echo $centro_costo ?></b></h4>
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
		<form action="<?php echo base_url() ?>est/pensiones/redireccionar_informe" method="post">
		<div class="row" >
			<div class="col-md-1"></div>
			<div class="col-md-6" align="right">
          		Centro Costo:
          		<select name="centro_costo" id="centro_costo" required>
            		<option value="">[Seleccione el centro de costo]</option>
            		<?php foreach ($empresas_planta as $key) { ?>
            			<option value="<?php echo $key->id ?>" <?php if($id_centro_costo == $key->id) echo "selected"; ?> ><?php echo $key->nombre ?></option>
					<?php } ?>
            	</select>
            	Desde:
            	<input name="fecha_inicio" id="fecha_inicio" class="fecha_inicio" style="width:12%" readonly="readonly" value="<?php echo $fecha_inicio ?>" required>
            	Hasta:
            	<input name="fecha_termino" id="fecha_termino" class="fecha_termino" style="width:12%" readonly="readonly" value="<?php echo $fecha_termino ?>" required>
	            <?php if(!empty($mensaje)) echo "<br></h4><font color='red'><b>".$mensaje."</b></font></h4>"; ?>
   			</div>
			<div class="col-md-1" align="left">
	          	<input title="Buscar informe de pensiones" type="submit" class="btn btn-green btn-block" value="Buscar"><br>
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-2">
	          	<input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel"><br>
			</div>
		</div><br>
		</form>
		<div class="row">
	  		<div class="col-md-12">
				<table id="example1">
					<thead>
						<tr>
							<th class="center">/</th>
							<th class="center">Nombre Pensión</th>
							<th class="center">Rut Pensión</th>
							<th class="center">Nombre Trabajador</th>
							<th class="center">Rut</th>
							<th class="center">Cargo</th>
							<th class="center">Procedencia</th>
							<th class="center">Contrato<br>Desde<br>Hasta</th>
							<th class="center">Valor*Dias Pensión = Total</th>
							<th class="center">Valor*Dias Almuerzo = Total</th>
							<th class="center">Valor*Dias Reserva = Total</th>
							<th class="center">Valor*Dias Otros = Total</th>
							<th class="center">Total Trabajador</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 0; foreach ($lista_aux as $row){ $i += 1; ?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<td><?php echo $row->nombre_pension ?></td>
							<td><?php echo $row->rut_pension ?></td>
							<td><?php echo $row->nombre_trabajador ?></td>
							<td><?php echo $row->rut_trabajador ?></td>
							<td><?php echo $row->cargo ?></td>
							<td><?php echo $row->procedencia_trab ?></td>
							<td><?php echo $row->fecha_inicio_contrato."<br>".$row->fecha_termino_contrato ?></td>
							<td><?php echo $row->valor_pension_completa."*".$row->n_dias_pension_completa."=".$row->total_pension_completa ?></td>
							<td><?php echo $row->valor_almuerzo."*".$row->n_dias_almuerzo."=".$row->total_almuerzo ?></td>
							<td><?php echo $row->valor_reserva."*".$row->n_dias_reserva."=".$row->total_reserva ?></td>
							<td><?php echo $row->valor_otros_valores."*".$row->n_dias_otros_valores."=".$row->total_otros_valores ?></td>
							<td><?php echo $row->total_total ?></td>
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
                   <input type="text" name="almuerzo" id="almuerzo" placeholder="Valor Almuerzo de la Pension">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Reserva</label>
                <div class="controls">
                   <input type="text" name="reserva" id="reserva" placeholder="Valor Reserva de la Pension">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Otros Valores</label>
                <div class="controls">
                   <input type="text" name="otros_valores" id="otros_valores" placeholder="Otros Valores de la Pension">
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

<!--<div id="divTableDataHolder" style="display:none"> para exportar a excel-->
<div id="divTableDataHolder" style="display:none">
	<meta content="charset=UTF-8"/>
	<table border="1">
		<thead>
			<tr>
				<th colspan="4" align="center">Datos Pensión</th>
				<th colspan="3" align="center">Datos del Trabajador</th>
				<th colspan="5" align="center">Datos del Requerimiento</th>
				<th colspan="2" align="center">Contrato</th>
				<th colspan="3" align="center">Datos de Pension Completa</th>
				<th colspan="3" align="center">Datos del Almuerzo</th>
				<th colspan="3" align="center">Datos de la Reserva</th>
				<th colspan="3" align="center">Datos de Otros Valores</th>
				<th></th>
			</tr>
			<tr>
				<th class="center">/</th>
				<th class="center">Centro Costo</th>
				<th class="center">Nombre Pensión</th>
				<th class="center">Rut Pensión</th>
				<th class="center">Nombre Trabajador</th>
				<th class="center">Rut</th>
				<th class="center">Procedencia</th>
				<th class="center">Nombre Req.</th>
				<th class="center">Codigo Req.</th>
				<th class="center">Cargo</th>
				<th class="center">Area</th>
				<th class="center">Motivo</th>
				<th class="center">Desde</th>
				<th class="center">Hasta</th>
				<th class="center">Valor Pensión Completa</th>
				<th class="center">Numero de Dias Pensión</th>
				<th class="center">Total Pensión Completa</th>
				<th class="center">Valor Almuerzo Pensión</th>
				<th class="center">Numero de Dias Almuerzo</th>
				<th class="center">Total Almuerzo</th>
				<th class="center">Valor Reserva</th>
				<th class="center">Numero Dias Reserva</th>
				<th class="center">Total Reserva</th>
				<th class="center">Valor Otros Valores</th>
				<th class="center">Numero Dias Otros Valores</th>
				<th class="center">Total Otros Valores</th>
				<th class="center">Total Trabajador</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0; foreach ($lista_aux as $row){ $i += 1; ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $centro_costo; ?></td>
				<td><?php echo $row->nombre_pension ?></td>
				<td><?php echo $row->rut_pension ?></td>
				<td><?php echo $row->nombre_trabajador ?></td>
				<td><?php echo $row->rut_trabajador ?></td>
				<td><?php echo $row->procedencia_trab ?></td>
				<td><?php echo $row->nombre_req ?></td>
				<td><?php echo $row->codigo_req ?></td>
				<td><?php echo $row->cargo ?></td>
				<td><?php echo $row->area ?></td>
				<td><?php echo $row->motivo_req ?></td>
				<td><?php echo date("d-m-Y", strtotime($row->fecha_inicio_contrato)); ?></td>
				<td><?php echo date("d-m-Y", strtotime($row->fecha_termino_contrato)); ?></td>
				<td><?php echo $row->valor_pension_completa ?></td>
				<td><?php echo $row->n_dias_pension_completa ?></td>
				<td><?php echo $row->total_pension_completa ?></td>
				<td><?php echo $row->valor_almuerzo ?></td>
				<td><?php echo $row->n_dias_almuerzo ?></td>
				<td><?php echo $row->total_almuerzo ?></td>
				<td><?php echo $row->valor_reserva ?></td>
				<td><?php echo $row->n_dias_reserva ?></td>
				<td><?php echo $row->total_reserva ?></td>
				<td><?php echo $row->valor_otros_valores ?></td>
				<td><?php echo $row->n_dias_otros_valores ?></td>
				<td><?php echo $row->total_otros_valores ?></td>
				<td><?php echo $row->total_total ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>