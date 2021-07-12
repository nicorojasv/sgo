<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>est/horarios/actualizar_horario" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
      if ($datos_horario != FALSE){
        foreach ($datos_horario as $row){
      ?>
      <input type="hidden" name="id_horario" value="<?php echo $row->id ?>">
      <div class="col-md-6">
        <div class="control-form">
          <label class="control-label" for="empresa_planta">Empresa Planta</label>
          <div class="controls">
            <select name="empresa_planta" id="empresa_planta" class="form-control" required>
              <option value="">[Seleccione]</option>
              <?php foreach($listado_empresas_planta as $ep){ ?>
                      <option value="<?php echo $ep->id ?>" <?php if($ep->id == $row->id_empresa_planta) echo "selected" ?> ><?php echo $ep->nombre ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="control-form">
          <label class="control-label">Tipo Jornada</label>
          <div class="controls">
            <label for="tipo_horario_1"><input type="radio" name="tipo_horario" id="tipo_horario_1" value="1" <?php if($row->id_tipo_horario == 1) echo "checked"; ?> > Administrativo </label>
            <label for="tipo_horario_2"><input type="radio" name="tipo_horario" id="tipo_horario_2" value="2" <?php if($row->id_tipo_horario == 2) echo "checked"; ?> > Turno u otros </label>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="control-form">
          <label class="control-label" for="titulo">Titulo</label>
          <div class="controls">
            <input type='text' class="form-control" name="titulo" id="titulo" onkeypress='return valida_abecedario(event)' maxlength='100' value="<?php echo $row->nombre_horario ?>" required/>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="control-form">
          <label class="control-label" for="descripcion">Descripción</label>
          <div class="controls">
            <textarea name="descripcion" id="descripcion" class="form-control" rows="6" required><?php echo str_replace("<w:br/>","\n", $row->descripcion) ?></textarea>
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
      ?>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</div>