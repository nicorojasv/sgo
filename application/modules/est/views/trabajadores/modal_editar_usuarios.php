<div id="modal">
  <div id="modal_content">
    <div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>est/trabajadores/actualizar_datos_usuario" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
      ?>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Rut</label>
            <div class="controls">
              <input type='hidden' name="id_usuario" id="id_usuario" value="<?php echo $row->id_usuario?>"/>
              <input type='hidden' name="tipo_usuario" id="tipo_usuario" value="<?php echo $tipo_usuario?>"/>
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
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Telefono</label>
            <div class="controls">
              <input type="text" class="input-mini" name="fono" id="fono" value="<?php echo $row->fono?>" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">E-mail</label>
            <div class="controls">
               <input type="text" name="email" id="email" value="<?php echo $row->email?>" required>
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
        ?> <br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</div>