<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>est/cargos/actualizar_datos_cargo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($datos_cargo != FALSE){
        foreach ($datos_cargo as $row){
      ?>
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">ID</label>
            <div class="controls">
              <input type='text' class="input-mini" name="id_cargo" id="id_cargo" readonly="readonly" value="<?php echo $row->id?>"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Nombre</label>
            <div class="controls">
                <input type='text' class="input-mini" name="nombre_cargo" id="nombre_cargo" maxlength='60' value="<?php echo $row->nombre?>" required/>
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
        ?> <br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>