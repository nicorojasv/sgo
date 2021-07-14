<div class="panel panel-white" >
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> ASIGNAR AREAS - CARGOS REQUERIMIENTO</h4>
		<br>
		<div class="row">
	        <div class="col-md-10" align="rigth">
	        	<?php foreach ($requerimiento as $row){ ?>
	        	<h5><b>Requerimiento:</b> <?php echo $row->nombre ?></h5>
	        	<h5><b>Regimen:</b> <?php echo $row->regimen ?> - <b>Causal:</b> <?php echo $row->causal ?></h5>
	        	<h5><b>Motivo:</b> <?php echo $row->motivo ?></h5>
				<h5><b>Fecha Solicitud:</b> <?php echo $row->f_solicitud ?> - <b>Fecha Inicio:</b> <?php echo $row->f_inicio ?> - <b>Fecha Fin:</b> <?php echo $row->f_fin ?></h5>
	        	<?php } ?>
	        </div>
	     </div>
	</div>
	<div class="panel-body">
		<div id="wizard" class="swMain">
			<div class="row">
				<div class="col-md-8"></div>
				<div class="col-md-3" style="text-align:center">
         			<p><input type="button" title="Agregar Area Cargo" value="Agregar Area-Cargo" name ="+" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar"></p>
         			<!--
         			<p><a href="<?php echo base_url() ?>est/requerimiento/usuarios_general_requerimiento/<?php echo $id_req ?>"><input type="button" title="Ver todos los trabajadores del requerimiento" value="VER TODOS" name ="+" class="btn btn-green"></a></p>
         			-->
         		</div>
         	</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<table id="example1">
						<thead>
							<tr style="text-align:center">
								<td>N°</td>
								<td>Area</td>
								<td>Cargo</td>
								<td>Cantidad</td>
								<td>Valor Aprox.</td>
								<td>Acciones</td>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; foreach ($area_cargos_requerimiento as $ar_car){ $i+=1; ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $ar_car->nombre_area; ?></td>
								<td><?php echo $ar_car->nombre_cargo; ?></td>
								<td style="text-align:center">
									<a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>carrera/requerimientos/usuarios_requerimiento/<?php echo $ar_car->id ?>'>
										<?php echo $ar_car->asignadas ?>/<?php echo $ar_car->cantidad ?>
									</a>
								</td>
								<td style="text-align:center"><?php echo $ar_car->valor_aprox; ?></td>
								<td style="text-align:center">
									<a title="Editar datos Area/Cargo Requerimiento" data-target="#ModalEditar" data-toggle="modal" href="<?php echo base_url() ?>carrera/requerimientos/editar_area_cargo_requerimiento/<?php echo $ar_car->id ?>/<?php echo $id_req ?>"><i class="fa fa-pencil fa-fw"></i></a>
				          <!--
                  <a title="Eliminar Area/Cargo Requerimiento" class="eliminar" href="<?php echo base_url() ?>carrera/requerimientos/eliminar_area_cargo_req/<?php echo $ar_car->id ?>/<?php echo $id_req ?>"><i class="fa fa-trash-o"></i></a>
								  -->
                </td>
							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
					<br><br>
				</div>
				<div class="col-md-2"></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Agregar Area Cargo-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nueva Area/Cargo al Requerimiento</h2>
      </div>
      <div class="modal-header" style="text-align:center">
	      <?php
		foreach ($requerimiento as $row) {
			echo "<p><b>REQUERIMIENTO:</b> ".$row->nombre." - <b>EMPRESA:</b> ".$row->nombre_empresa."</p>";
			echo "<p><b>REGIMEN:</b> ".$row->regimen." - <b>CAUSAL:</b> ".$row->causal." - <b>MOTIVO:</b> ".$row->motivo."</p>";
		}
		 ?>
	    </div><br>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>carrera/requerimientos/guardar_area_cargo_req" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <input type="hidden" name="id_req" id="id_req" value="<?php echo $row->id ?>">
          <div class="col-md-8">
            <div class="control-group">
              <label class="control-label" for="inputTipo"><b>AREAS</b></label>
              <div class="controls">
                <select name="area" id="area" required>
                  <option value="">Selecione</option>
                    <?php
                      foreach ($areas as $ar)
                      echo '<option value="',$ar->id,'">',$ar->nombre,'</option>';
                    ?>
                </select>
              </div>
            </div>
            <br>
            <div class="control-group">
              <label class="control-label" for="inputTipo"><b>CARGOS</b></label>
              <div class="controls">
                  <select name="cargo" id="cargo" required>
                    <option value="">Selecione</option>
                      <?php
                        foreach ($cargos as $cr)
                        echo '<option value="',$cr->id,'">',$cr->nombre,'</option>';
                     ?>
                  </select>
              </div>
            </div>
          </div>
          <div class="col-md-1">
            <div class="control-group">
              <label class="control-label" for="inputTipo"><b>CANTIDAD</b></label>
              <div class="controls">
                <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" onkeypress='return valida_numeros(event)' maxlength='3' required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo"><b>VALOR APROX</b></label>
              <div class="controls">
                <input type="text" name="valor" id="valor" placeholder="Valor Aprox." onkeypress='return valida_numeros(event)' maxlength='9' required>
              </div>
            </div>
          </div>
          <br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Area/Cargo del Requerimiento-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<?php 
  if ($this->session->userdata('reqCreado')==true) {
?>
<script type="text/javascript">
    var notification = alertify.notify('Requerimiento Creado', 'success', 5,);
</script>
<?php
    $this->session->unset_userdata('reqCreado');
  }
?>