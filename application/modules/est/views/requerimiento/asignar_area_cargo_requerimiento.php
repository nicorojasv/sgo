<script type="text/javascript">
	function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
  
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}
</script>
<div class="panel panel-white" >
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> ASIGNAR AREAS - CARGOS REQUERIMIENTO</h4>
		<br>
		<?php
			if ($this->session->userdata('exito')==1) {//al guardar requerimiento
		?>
			<script type="text/javascript">
			alertify.success('Requerimiento Guardado');
			</script>
		<?php
			$this->session->unset_userdata('exito');		
			}
			if ($this->session->userdata('exito')==2) {// al guardar area cargo
		?>
				<script type="text/javascript">
				alertify.success('Area - Cargo del Requerimiento Ingresado Exitosamente');
				</script>
		<?php
				$this->session->unset_userdata('exito');		
			}

			if ($this->session->userdata('exito')==3) {// al guardar area cargo
		?>
				<script type="text/javascript">
					alertify.success('Areas/Cargos del Requerimiento Actualizado Exitosamente');
				</script>
		<?php
				$this->session->unset_userdata('exito');		
			}
			if ($this->session->userdata('nodata')==true) {// al guardar area cargo
		 ?>
		 	<script type="text/javascript">
					alertify.warning('Este Requerimiento no cuenta con contratos masivos para descargar');
			</script>
		<?php 
				$this->session->unset_userdata('nodata');
			}
			if ($this->session->userdata('nodata1')==true) {// al guardar area cargo
		?>
			<script type="text/javascript">
					alertify.warning('Este Requerimiento no cuenta con anexos masivos para descargar');
			</script>
		<?php 
				$this->session->unset_userdata('nodata1');
			}
			if ($this->session->userdata('noselecciono')==true) {// al guardar area cargo
		?>
			<script type="text/javascript">
					alertify.error('no selecciono trabajador');
			</script>
		<?php 
				$this->session->unset_userdata('noselecciono');
			}
		?>
		<div class="row">
	        <div class="col-md-10" align="rigth">
	        	<?php foreach ($requerimiento as $row){ ?>
	        	<h5><b>Requerimiento:</b> <?php echo $row->nombre ?> </h5>
	        	<h5><b>Regimen:</b> <?php echo $row->regimen ?> - <b>Causal:</b> <?php echo $row->causal ?></h5>
	        	<h5><b>Motivo:</b> <?php echo $row->motivo ?></h5>
				<h5><b>Fecha Solicitud:</b> <?php echo $row->f_solicitud ?> - <b>Fecha Inicio:</b> <?php echo $row->f_inicio ?> - <b>Fecha Fin:</b> <?php echo $row->f_fin ?></h5>
	        	<?php } ?>
	        	
	        	
	        	<div class="container">
  <ul class="nav nav-tabs">
    <li ><a data-toggle="tab" href="#home" class="changeDisplay">Contratos</a></li>
    <li><a data-toggle="tab" href="#menu1" class="changeDisplay">Anexos</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade ">
    	<?php 
    		if ($noContrato== false) {
    	?>
    		<div class="alert alert-danger" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Error:</span>
			  No Existen Contratos para descarga masiva
			</div>
    	<?php 
    		}else{
    	?>
	    	<a href="<?php echo base_url() ?>est/requerimiento/descargar_masiva/<?php echo $row->id ?>"  type="button" class="btn btn-outline-success">Descargar todos los contratos del requerimiento <i class="fa fa-download" aria-hidden="true"></i></a><br>
		    <a href="javascript:void(0)" class="getMasivoContrato btn btn-outline-success" data-id="<?php echo $row->id ?>"><span class="getMasivoContratoc">Seleccionar Contratos a descargar</span> <b class="getMasivoContrato9cc"><i class="fa fa-download" aria-hidden="true"></i></b></a>
		<?php 
			}
		?>
    </div>
    <div id="menu1" class="tab-pane fade">
    	<?php 
    		if ($noAnexos== false) {
    	?>
    		<div class="alert alert-danger" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Error:</span>
			  No Existen Anexos para descarga masiva
			</div>
    	<?php 
    		}else{
    	?>
	        <a href="<?php echo base_url() ?>est/requerimiento/descargar_masiva_anexo/<?php echo $row->id ?>"   type="button" class="btn btn-outline-success">Descargar todos los Anexos del requerimiento <i class="fa fa-download " aria-hidden="true"></i></a><br>
			<a href="javascript:void(0)" class="getMasivoAnexo btn btn-outline-success" data-id="<?php echo $row->id ?>"><span class="getMasivoAnexoc">Seleccionar Anexos a descargar</span> <b class="getMasivoAnexocc"><i class="fa fa-download" aria-hidden="true"></i></b></a>
		<?php 
			}
		?>
    </div>
  </div>
</div>
	        </div>
	     </div>
		<div class="panel-tools">

		</div>
	</div>
	<div class="panel-body" id="general">

		<div id="wizard" class="swMain">
			<div class="row">
				<div class="col-md-8"></div>
				<div class="col-md-3" style="text-align:center">
         			<p><input type="button" title="Agregar Area Cargo" value="Agregar Area-Cargo" name ="+" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar"></p>
         			<p><a href="<?php echo base_url() ?>est/requerimiento/usuarios_general_requerimiento/<?php echo $id_req ?>"><input type="button" title="Ver todos los trabajadores del requerimiento" value="VER TODOS" name ="+" class="btn btn-green"></a></p>
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
									<a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>est/requerimiento/usuarios_requerimiento/<?php echo $ar_car->id ?>'>
										<?php echo $ar_car->asignadas ?>/<?php echo $ar_car->cantidad ?>
									</a>
								</td>
								<td style="text-align:center"><?php echo $ar_car->valor_aprox; ?></td>
								<td style="text-align:center">
									<!--<a title="Administrar Area-Cargo" href="<?php echo base_url() ?>est/requerimiento/usuarios_requerimiento/<?php echo $ar_car->id ?>"><i class="fa fa-puzzle-piece"></i></a>-->
									<a title="Editar datos Area-Cargo Requerimiento" data-target="#ModalEditar" data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/editar_area_cargo_requerimiento/<?php echo $ar_car->id ?>/<?php echo $id_req ?>"><i class="fa fa-pencil fa-fw"></i></a>
				            		<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
									<a title="Eliminar Area-Cargo Requerimiento" class="eliminar" href="<?php echo base_url() ?>est/requerimiento/eliminar_area_cargo_req/<?php echo $ar_car->id ?>/<?php echo $id_req ?>"><i class="fa fa-trash-o"></i></a>
									<?php } ?>
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
	<div class="panel-body" style="display:none;" id="divAnexos">
		<div id="wizard" class="swMain">
			<form action="<?php echo base_url() ?>est/requerimiento/descargar_seleccionado_anexo/<?php echo $row->id ?>" method="post">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-6"><input type="submit" title="Agregar Area Cargo" value="Descargar Seleccionado" class="btn btn-info"></div>
				<div class="col-md-3" style="text-align:center">
         			<p><input type="button" title="Agregar Area Cargo" value="Agregar Area-Cargo" name ="+" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar"></p>
         			<p><a href="<?php echo base_url() ?>est/requerimiento/usuarios_general_requerimiento/<?php echo $id_req ?>"><input type="button" title="Ver todos los trabajadores del requerimiento" value="VER TODOS" name ="+" class="btn btn-green"></a></p>
         		</div>
         	</div>
		<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
		      	<table id="example2" class="display" style="width:100%">
						<thead>
							<tr>
								<th style="text-align:center"><input type="checkbox" onchange="togglecheckboxes(this,'seleccionar_todos[]')"></th>
								<th>Rut</th>
								<th>Nombre</th>
								<th>Descargar</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						//var_dump($trabajadoresAnexo);
							if ($trabajadoresAnexo) {
								foreach ($trabajadoresAnexo as $key ){
						?>
							<tr >
								<td style="text-align:center"><input type="checkbox"  data-core="<?php echo titleCase($key->nombres) ?>" class="inptCheck" name="seleccionar_todos[]" value="<?php echo $key->id_trabajador ?>"></td>
								<td style="text-align:center"><?php echo $key->rut_usuario ?></td>
								<td style="text-align:center"><?php echo $key->nombres." ".$key->paterno ?></td>
								<td style="text-align:center"><a href="<?php echo base_url().$key->url ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
							</tr>
						<?php 
							}
						}
						?>
						</tbody>
					</table>
					</div>
				<div class="col-md-2"></div>
			</div>
			</form>
	</div>
</div>
<!--Div de Contratos-->
	<div class="panel-body" style="display:none;" id="divContratos">
		<div id="wizard" class="swMain">
			<form action="<?php echo base_url() ?>est/requerimiento/descargar_seleccionado_contrato/<?php echo $row->id ?>" method="post">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-6"><input type="submit" title="Agregar Area Cargo" value="Descargar Seleccionado" class="btn btn-info"></div>
				<div class="col-md-3" style="text-align:center">
         			<p><input type="button" title="Agregar Area Cargo" value="Agregar Area-Cargo" name ="+" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar"></p>
         			<p><a href="<?php echo base_url() ?>est/requerimiento/usuarios_general_requerimiento/<?php echo $id_req ?>"><input type="button" title="Ver todos los trabajadores del requerimiento" value="VER TODOS" name ="+" class="btn btn-green"></a></p>
         		</div>
         	</div>
		<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
		      	<table id="example3" class="display" style="width:100%">
						<thead>
							<tr>
								<th style="text-align:center"><input type="checkbox" onchange="togglecheckboxes(this,'seleccionar_todosc[]')"></th>
								<th>Rut</th>
								<th>Nombre</th>
								<th>Descargar</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						//var_dump($trabajadoresAnexo);
							if ($trabajadoresContrato) {
								foreach ($trabajadoresContrato as $key ){
						?>
							<tr >
								<td style="text-align:center"><input type="checkbox"  data-core="<?php echo titleCase($key->nombres) ?>" class="inptCheck" name="seleccionar_todosc[]" value="<?php echo $key->id_trabajador ?>"></td>
								<td style="text-align:center"><?php echo $key->rut_usuario ?></td>
								<td style="text-align:center"><?php echo $key->nombres." ".$key->paterno ?></td>
								<td style="text-align:center"><a href="<?php echo base_url().$key->url ?>"><i class="fa fa-download" aria-hidden="true"></i></a></td>
							</tr>
						<?php 
							}
						}
						?>
						</tbody>
					</table>
					</div>
				<div class="col-md-2"></div>
			</div>
			</form>
	</div>
</div>
</div>


<!-- Modal Agregar Area Cargo-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nueva Area-Cargo al Requerimiento</h2>
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
        <form action="<?php echo base_url() ?>est/requerimiento/guardar_area_cargo_req" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <input type="hidden" name="id_req" id="id_req" value="<?php echo $row->id ?>">
          <div class="col-md-8">
            <div class="control-group">
              <label class="control-label" for="inputTipo"><b>AREAS</b></label>
              <div class="controls">
                <select name="area" id="area" required>
                  <option value="">Selecione</option>
                    <?php
                      foreach ($areas as $ar)
                      echo '<option value="'.$ar->id.'">'.titleCase($ar->nombre).'</option>';
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
          <div class="col-md-4">
            <div class="control-group">
              <label class="control-label" for="cantidad"><b>CANTIDAD</b></label>
              <div class="controls">
                <input type="text" name="cantidad" id="cantidad"  onkeypress='return valida_numeros(event)' maxlength='3' autocomplete="off" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="valor"><b>SUELDO BASE</b></label>
              <div class="controls">
                <input type="text" name="valor" id="valor"  onkeyup="format(this)" onkeypress='return valida_numeros(event)' maxlength='9' required>
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
<script>
	
	 $(document).on('click', '.changeDisplay', function() {
	 	$('#divAnexos').hide();
	 	$('#divContratos').hide();
	 	$('#general').show();
	 });

	numero =1;
	 $(document).on('click', '.getMasivoAnexo', function() {
	 		$('#divAnexos').toggle();
			$('#general').toggle();
			

			if (numero % 2 == 0){
   				 $('.getMasivoAnexoc').text('Seleccionar Anexos a descargar');
   				 $('.getMasivoAnexocc').html('<i class="fa fa-download" aria-hidden="true"></i>');
   				 
  			}else {
  				$('.getMasivoAnexoc').text('Volver a Area Cargo');
   				 $('.getMasivoAnexocc').html('<i class="fa fa-arrow-left" aria-hidden="true"></i>');

  			}
  			numero++;
        });

	 num =1;
	 $(document).on('click', '.getMasivoContrato', function() {
	 		$('#divContratos').toggle();
			$('#general').toggle();
			if (num % 2 == 0){
   				 $('.getMasivoContratoc').text('Seleccionar Contratos a descargar');
   				 $('.getMasivoContratocc').html('<i class="fa fa-download" aria-hidden="true"></i>');
   				 
  			}else {
  				$('.getMasivoContratoc').text('Volver a Area Cargo');
   				 $('.getMasivoContratocc').html('<i class="fa fa-arrow-left" aria-hidden="true"></i>');

  			}
  			num++;
        });
</script>