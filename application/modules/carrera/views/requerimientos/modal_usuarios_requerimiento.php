<div id="modal">
  <div id="modal_content">
    Requerimiento <?php echo $id_area_cargo ?>
    <form action="<?php echo base_url() ?>carrera/trabajadores/actualizar_trabajador" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
          echo $row->rut_usuario;
          echo "<br>";
      ?>
      <!--
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Rut</label>
            <div class="controls">
              <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $row->usuario_id?>" >
              <input type="hidden" name="id_planta" id="id_planta" value="<?php echo $row->empresa_planta_id?>">
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
        </div>-->
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