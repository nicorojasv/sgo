<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>carrera/horarios/actualizar_horario" method='post'>
      <?php
      if ($datos_horario != FALSE){
        foreach ($datos_horario as $row){
      ?>
      <input type="hidden" name="id_horario" value="<?php echo $row->id ?>">
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