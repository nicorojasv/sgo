<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>abastecimiento/guardar_relacion_planta_usuario" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-header" style="text-align:center">
      <?php
        if ($lista_aux != FALSE){
          $i = 0;
          foreach ($lista_aux as $row){
            $i++;
      ?>
      <input type="hidden" name="rut_ingresar[<?php echo $i ?>]" id="rut_ingresar[]" value="<?php echo $row->id_usuario ?>">
      <h5>Usuario: <b><?php echo $row->nombres." ".$row->paterno." ".$row->materno ?></b></h5>
      <?php
        }
          }else{}
      ?>
    </div>
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $row->id_usuario ?>">
        <div class="col-md-6">
          <br>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Sucursales</label>
            <div class="controls">
            <?php if( $row->sucursales ){
                $i = 0;
                foreach($row->sucursales as $ar1){
                  $i++;
                ?>
                <input type="hidden" name="rut_ingresar1[<?php echo $i ?>]" id="rut_ingresar1[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="sucursales_usuario[<?php echo $i ?>]" id="sucursales_usuario[<?php echo $i ?>]" value="<?php echo $ar1->id_sucursal ?>" <?php echo ($ar1->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar1->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <br>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Centros de Costos</label>
            <div class="controls">
            <?php if( $row->centros_costos ){
                $x = 0;
              foreach($row->centros_costos as $ar2){
                $x++;
                ?>
                <input type="hidden" name="rut_ingresar2[<?php echo $x ?>]" id="rut_ingresar2[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="centro_costo_usuario[<?php echo $x ?>]" id="centro_costo_usuario[<?php echo $x ?>]" value="<?php echo $ar2->id_centro_costo ?>" <?php echo ($ar2->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar2->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>
        </div>
       <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
</div>