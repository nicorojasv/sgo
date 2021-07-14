<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Area/Cargo del Requerimiento</h4>
  </div>
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>carrera/requerimientos/actualizar_area_cargo_requerimiento" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($datos_area_cargo_req != FALSE){
        foreach ($datos_area_cargo_req as $row){
      ?>
      <div class="col-md-8">
            <div class="control-group">
              <input type="hidden" name="id_req" id="id_req" value="<?php echo $row->requerimiento_id ?>">
              <input type="hidden" name="id_area_cargo" id="id_area_cargo" value="<?php echo $row->id ?>">
              <label class="control-label" for="inputTipo"><b>AREAS</b></label>
              <div class="controls">
                <select name="area" id="area" required>
                  <option value="<?php echo $row->areas_id ?>"><?php echo $row->nombre_area ?></option>
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
                    <option value="<?php echo $row->cargos_id ?>"><?php echo $row->nombre_cargo ?></option>
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
                <input type="text" name="cantidad" id="cantidad" placeholder="Cantidad" value="<?php echo $row->cantidad ?>" onkeypress='return valida_numeros(event)' maxlength='3' required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo"><b>VALOR APROX</b></label>
              <div class="controls">
                <input type="text" name="valor" id="valor" placeholder="Valor Aprox." value="<?php echo $row->valor ?>" onkeypress='return valida_numeros(event)' maxlength='9' required>
              </div>
            </div>
          </div>
          <br><br><br><br><br><br><br><br>
        <?php
          }
            }else{
        ?>
          <p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
        <?php
          }
        ?>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>