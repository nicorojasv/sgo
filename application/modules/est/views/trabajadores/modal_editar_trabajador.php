<div id="modal">
	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Trabajadores</h4>
  </div>
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>servicios/trabajadores/actualizar_trabajador" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($trabajador != FALSE){
        foreach ($trabajador as $row){
      ?>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Rut</label>
            <div class="controls">
              <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $row->usuario_id?>" >
              <input type='text' class="input-mini" name="rut_usuario" id="rut_usuario" value="<?php echo $row->rut_usuario?>"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Paterno</label>
            <div class="controls">
                <input type='text' class="input-mini" name="paterno" id="paterno" value="<?php echo $row->paterno?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Materno</label>
            <div class="controls">
               <input type='text' class="input-mini" name="materno" id="materno" value="<?php echo $row->materno?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Nombres</label>
            <div class="controls">
                <input type='text' class="input-mini" name="nombres" id="nombres" value="<?php echo $row->nombres?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Cargo</label>
              <div class="controls">
                <select name="cargos" id="cargos" required>
                  <option value="<?php echo $row->cargos_id ?>"> <?php echo $row->desc_cargo ?> </option>
                    <?php
                      foreach ($arrCargos as $id => $desc_cargos)
                      echo '<option value="',$id,'">',$desc_cargos,'</option>';
                   ?>
                </select>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Contrato</label>
            <div class="controls">
              <select name="contrato" id="contrato" required>
                <option value="<?php echo $row->tipo_contrato_id ?>"> <?php echo $row->descripcion ?> </option>
                  <?php
                    foreach ($arrTipoContrato as $id => $descripcion)
                    echo '<option value="',$id,'">',$descripcion,'</option>';
                 ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Convenio</label>
            <div class="controls">
              <select name="convenio" id="convenio" required>
                <option value="<?php echo $row->convenio_id ?>"> <?php echo $row->nombre_convenio ?> </option>
                  <?php
                    foreach ($arrConvenios as $id => $nombre_convenio)
                    echo '<option value="',$id,'">',$nombre_convenio,'</option>';
                 ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Fecha Inicio</label>
            <div class="controls">
              <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $row->fecha_inicio?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Fecha Termino</label>
            <div class="controls">
               <input type="text" name="fecha_termino" id="fecha_termino" value="<?php echo $row->fecha_termino?>">
            </div>
          </div>
        </div>
        <?php
          }
            }else{
        ?>
          <p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
        <?php
          }
        ?> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>