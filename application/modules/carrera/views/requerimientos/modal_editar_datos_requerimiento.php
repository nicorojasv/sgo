<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos del Requerimiento</h4>
  </div>
  <div id="modal_content">
		<br>
    <form action="<?php echo base_url() ?>carrera/requerimientos/actualizar_requerimiento" method='post' autocomplete="off">
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
            <label class="control-label" for="inputTipo"><b>Centro Costo</b></label>
            <div class="controls">
              <select name="select_empresa" id="select_empresa" class="form-control" required>
                <option value="">Seleccione...</option>
                <?php foreach ($listado_empresa as $ep) { ?>
                <option value="<?php echo $ep->id ?>" <?php if($row->empresa_id == $ep->id) echo "selected"; ?> ><?php echo $ep->razon_social ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Sucursal</b></label>
            <div class="controls">
              <select name="select_planta" id="select_planta" class="form-control" required>
                <option value="">[Seleccione]</option>
                <?php foreach ($unidad_negocio as $un) { ?>
                <option value="<?php echo $un->id ?>" <?php if($row->planta_id == $un->id) echo "selected"; ?> ><?php echo ucwords(mb_strtolower($un->nombre,'UTF-8')) ?></option>
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
              <select name="causal" id="causal" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="A" <?php if($row->causal == "A") echo "selected"; ?> >A</option>
                <option value="B" <?php if($row->causal == "B") echo "selected"; ?> >B</option>
                <option value="C" <?php if($row->causal == "C") echo "selected"; ?> >C</option>
                <option value="D" <?php if($row->causal == "D") echo "selected"; ?> >D</option>
                <option value="E" <?php if($row->causal == "E") echo "selected"; ?> >E</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Motivo</b></label>
            <div class="controls">
                <input type='text' class="input-mini form-control" name="motivo" id="motivo" value="<?php echo $row->motivo ?>" required/>
            </div>
          </div>
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
            <label class="control-label" for="inputTipo"><b>Codigo Requerimiento</b></label>
            <div class="controls">
              <input type="text" name="centrocosto" id="centrocosto" class="form-control" value="<?php echo $row->codigo_centro_costo ?>" required>
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