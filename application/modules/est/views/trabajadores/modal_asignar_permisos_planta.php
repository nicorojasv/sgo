<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>est/trabajadores/guardar_relacion_planta_usuario" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
    <div class="modal-header" style="text-align:center">
      <?php
        if ($lista_aux != FALSE){
                $i = 0;
        foreach ($lista_aux as $row){
                $i++;
      ?>

      <input type="hidden" name="rut_ingresar[<?php echo $i ?>]" id="rut_ingresar[]" value="<?php echo $row->id_usuario ?>">
      <h5>Usuario: <b><?php echo $row->nombres; echo " "; echo $row->paterno; echo " "; echo $row->materno ?></b></h5>
      <?php
        }
          }else{}
      ?>
    </div><br>
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $row->id_usuario ?>">
        <input type="hidden" name="tipo_usuario" id="tipo_usuario" value="<?php echo $tipo_usuario ?>">
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Celulosa Arauco y Constitución S.A.</label>
            <div class="controls">
            <?php if( $row->plantas_celulosas ){
                $i = 0;
                foreach($row->plantas_celulosas as $ar){
                  $i++;
                ?>
                <input type="hidden" name="rut_ingresar2[<?php echo $i ?>]" id="rut_ingresar2[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="planta_ingresar_celulosa[<?php echo $i ?>]" id="planta_ingresar_celulosa[<?php echo $i ?>]" value="<?php echo $ar->id_planta ?>" <?php echo ($ar->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <input type="hidden" name="rut_ingresar2[<?php echo $i ?>]" id="rut_ingresar2[]" value="<?php echo $row->id_usuario ?>">
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>
          <br>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Camanchaca Pesca Sur S.A.</label>
            <div class="controls">
            <?php if( $row->plantas_camanchacas ){
                $i = 0;
                foreach($row->plantas_camanchacas as $ar1){
                  $i++;
                ?>
                <input type="hidden" name="rut_ingresar1[<?php echo $i ?>]" id="rut_ingresar1[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="planta_ingresar_camanchaca[<?php echo $i ?>]" id="planta_ingresar_camanchaca[<?php echo $i ?>]" value="<?php echo $ar1->id_planta ?>" <?php echo ($ar1->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar1->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <input type="hidden" name="rut_ingresar1[<?php echo $i ?>]" id="rut_ingresar1[]" value="<?php echo $row->id_usuario ?>">
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>
          <br>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Cargill</label>
            <div class="controls">
            <?php if( $row->plantas_cargill ){
                $i = 0;
                foreach($row->plantas_cargill as $ar4){
                  $i++;
                ?>
                <input type="hidden" name="rut_ingresar5[<?php echo $i ?>]" id="rut_ingresar5[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="planta_ingresar_cargill[<?php echo $i ?>]" id="planta_ingresar_cargill[<?php echo $i ?>]" value="<?php echo $ar4->id_planta ?>" <?php echo ($ar4->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar4->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <input type="hidden" name="rut_ingresar5[<?php echo $i ?>]" id="rut_ingresar5[]" value="<?php echo $row->id_usuario ?>">
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>

        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Paneles (Maderas) Arauco S.A.</label>
            <div class="controls">
            <?php if( $row->plantas_maderas ){
                $x = 0;
              foreach($row->plantas_maderas as $ar2){
                $x++;
                ?>
                <input type="hidden" name="rut_ingresar3[<?php echo $x ?>]" id="rut_ingresar3[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="planta_ingresar_maderas[<?php echo $x ?>]" id="planta_ingresar_maderas[<?php echo $x ?>]" value="<?php echo $ar2->id_planta ?>" <?php echo ($ar2->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar2->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <input type="hidden" name="rut_ingresar3[<?php echo $x ?>]" id="rut_ingresar3[]" value="<?php echo $row->id_usuario ?>">
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>
          <br>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Forestal Arauco S.A.</label>
            <div class="controls">
            <?php if( $row->plantas_forestal ){
                $x = 0;
              foreach($row->plantas_forestal as $ar3){
                $x++;
                ?>
                <input type="hidden" name="rut_ingresar4[<?php echo $x ?>]" id="rut_ingresar4[]" value="<?php echo $row->id_usuario ?>">
                <input type="checkbox" name="planta_ingresar_forestal[<?php echo $x ?>]" id="planta_ingresar_forestal[<?php echo $x ?>]" value="<?php echo $ar3->id_planta ?>" <?php echo ($ar3->si_existe)?"checked='checked'":""; ?> >
                <a style="color:green" target="_blank"><?php echo $ar3->nombre ?></a>
                <br/>
              <?php } ?>
            <?php } else { ?>
            <input type="hidden" name="rut_ingresar4[<?php echo $x ?>]" id="rut_ingresar4[]" value="<?php echo $row->id_usuario ?>">
            <a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
            <?php } ?>
            </div>
          </div>
        </div>
       <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
</div>