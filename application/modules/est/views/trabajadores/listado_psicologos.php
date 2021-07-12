<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores Psicologo/as</h4>
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
			<div class="col-md-1"></div>
			<div class="col-md-8">
				Activos: <span class='badge' style='background-color:#3E9610'>A</span> Inactivos: <span class='badge' style='background-color:#DAAA08'>I</span>
			</div>
			<div class="col-md-2">
          		<input type="button" title="Agregar Trabajador" value="Agregar Psicologo/a" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar">&nbsp;
			</div>
		</div><br>
		<?php if( count($listado) > 0){ ?>
  		<form action="<?php echo base_url() ?>est/trabajadores/cambiar_estados_psicologos" role="form" id="form" method='post' autocomplete="off">
			<div class="row">
	  		    <div class="col-md-1"></div>
	      		<div class="col-md-10">
					<table id="example1">
						<thead>
							<tr>
								<th>/</th>
								<th>Rut</th>
								<th>Nombres y Apellidos</th>
								<th>Dirección</th>
								<th>Fecha Nacimiento</th>
								<th>Email</th>
								<th>Fono</th>
								<th style="text-align:center">Activo</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; foreach ($listado as $r){ $i += 1; ?>
							<tr class="odd gradeX">
								<td><?php echo $i ?></td>
								<td><?php echo $r->rut_usuario ?></td>
								<td><?php echo $r->nombre." ".$r->ap_paterno." ".$r->ap_materno ?></td>
								<td><?php echo $r->direccion ?></td>
								<td><?php echo $r->fecha_nac ?></td>
								<td><?php echo $r->email ?></td>
								<td><?php echo $r->fono ?></td>
			                    <td style="text-align:center">
									<input type="hidden" name="usuarios[]" value="<?php echo $r->id_usuario ?>">
									<input type="checkbox" name="check_estado[]" value="<?php echo $r->id_usuario ?>" <?php echo ($r->estado)?"checked='checked'":""; ?> > <?php echo ($r->estado)?"<span class='badge' style='background-color:#3E9610'>A</span>":"<span class='badge' style='background-color:#DAAA08'>I</span>"; ?>
								</td>
								<td style="width:47px;">
									<a title="Editar" data-toggle="modal" href="<?php echo base_url() ?>est/trabajadores/modal_editar_psicologo/<?php echo $r->id_usuario ?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>
									
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
	    	</div>
			<div class="row">
	  		    <div class="col-md-8"></div>
	      		<div class="col-md-3">
	      			<button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo de los Trabajadores">
						Guardar Estados Psicologos
					</button>
	      		</div>
	    	</div>
	    </form>
		<?php } else{ ?>
		<p>No existen registro de trabajadores.</p>
		<?php } ?>
	</div>
</div>


<!-- Modal Editar Trabajador-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->


<!-- Modal Agregar Trabajador-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Registro de Nuevo Trabajador Psicologo/a</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>est/trabajadores/guardar_trabajador_psicologo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Rut</label>
              <div class="controls">
                <input type='text' class="input-mini" name="rut" id="rut" maxlength='12' onkeypress='return valida_letras_rut(event)' placeholder="11.111.111-1" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Paterno</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="paterno" id="paterno" onkeypress='return valida_abecedario(event)' maxlength='30' required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Materno</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="materno" id="materno" onkeypress='return valida_abecedario(event)' maxlength='30' required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Nombres</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="nombres" id="nombres" onkeypress='return valida_abecedario(event)' maxlength='50' required/>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Nacimiento</label>
              <div class="controls">
				<select name="dia_fn" style="width: 60px;">
					<option value="" >Dia</option>
					<?php for($i=1;$i<32;$i++){ ?>
					<option value="<?php echo $i ?>" ><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="mes_fn" style="width: 108px;">
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
				<select name="ano_fn" style="width: 70px;">
					<option value="">Año</option>
					<?php $tope_f = (date('Y') - 50 ); ?>
					<?php for($i=$tope_f; $i < (date('Y') - 18 ); $i++){ ?>
						<option value="<?php echo $i ?>" ><?php echo $i ?></option>
					<?php } ?>
				</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Direccion</label>
                <div class="controls">
                   <input type="text" name="direccion" id="direccion" placeholder="Direccion Particular">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Correo Electronico</label>
                <div class="controls">
                   <input type="text" name="email" id="email" placeholder="Email Personal">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fono</label>
                <div class="controls">
                   <input type="text" name="fono" id="fono" placeholder="Fono Personal">
                </div>
            </div>
          </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>