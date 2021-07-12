<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos del Requerimiento</h4>
  </div>
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>logistica_servicios/requerimientos/actualizar_requerimiento" method='post' autocomplete="off">
      <?php
        if ($listado != FALSE){
        foreach ($listado as $row){
      ?>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Codigo Requerimiento</b></label>
            <div class="controls">
              <input type="hidden" name="id_req" id="id_req" value="<?php echo $row->id ?>" >
              <input type='text' class="input-mini form-control" name="codigo" id="codigo" value="<?php echo $row->codigo_requerimiento ?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Nombre</b></label>
            <div class="controls">
                <input type='text' class="input-mini form-control" name="nombre" id="nombre" value="<?php echo $row->nombre ?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Planta</b></label>
            <div class="controls">
              <select name="select_planta" id="select_planta" class="form-control" required>
                <option value="">[Seleccione]</option>
                <?php foreach ($listado_empresa as $emp) { ?>
                <option value="<?php echo $emp->id ?>" <?php if($row->planta_id == $emp->id) echo "selected"; ?> ><?php echo ucwords(mb_strtolower($emp->nombre,'UTF-8')) ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Regimen</b></label>
            <div class="controls">
                  <select name="select_regimen" id="select_regimen" class="form-control" required>
                    <option value="">[Seleccione]</option>
                    <option value="NL" <?php if($row->regimen == "NL") echo "selected"; ?> >Normal</option>
                    <option value="CTG" <?php if($row->regimen == "CTG") echo "selected"; ?> >CONTINGENCIA</option>
                    <option value="URG" <?php if($row->regimen == "URG") echo "selected"; ?> >URGENCIA</option>
                  </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Causal</b></label>
            <div class="controls">
                <input type='text' class="input-mini form-control" name="causal" id="causal" value="<?php echo $row->causal ?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Motivo</b></label>
            <div class="controls">
                <input type='text' class="input-mini form-control" name="motivo" id="motivo" value="<?php echo $row->motivo ?>" required/>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Solicitud</b></label>
            <div class="controls">
              <input type="text" name="f_solicitud" id="f_solicitud" class="form-control" value="<?php echo $row->f_solicitud ?>" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Inicio</b></label>
            <div class="controls">
               <input type="text" name="f_inicio" id="f_inicio" class="form-control" value="<?php echo $row->f_inicio ?>" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Fin</b></label>
            <div class="controls">
               <input type="text" name="f_fin" id="f_fin" class="form-control" value="<?php echo $row->f_fin ?>" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Comentario</b></label>
            <div class="controls">
              <textarea class="form-control" name="comentario"><?php echo $row->comentario ?></textarea>
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
        ?> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>