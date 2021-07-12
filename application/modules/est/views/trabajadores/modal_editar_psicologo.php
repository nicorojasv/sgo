<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Psicologo</h4>
  </div>
  <div id="modal_content"><br>
    <form action="<?php echo base_url() ?>est/trabajadores/actualizar_datos_psicologo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
      ?>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Rut</label>
            <div class="controls">
              <input type="hidden" name="usuario_id" id="usuario_id" value="<?php echo $row->id?>" >
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
            <label class="control-label" for="inputTipo">Fecha Nacimiento</label>
            <div class="controls">
              <?php if( $row->fecha_nac ){
                $f = explode('-', $row->fecha_nac);
                $dia_fn = $f[2];
                $mes_fn = $f[1];
                $ano_fn = $f[0];
              }else{
                $dia_fn = false;
                $mes_fn = false;
                $ano_fn = false;
              } ?>
              <select name="dia_fn" style="width: 60px;">
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option value="<?php echo $i ?>" <?php echo ($dia_fn == $i)? "selected='selected'":'' ?> ><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fn" style="width: 108px;">
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_fn == '1')? "selected='selected'":'' ?> >Enero</option>
                <option value='02' <?php echo ($mes_fn == '2')? "selected='selected'":'' ?> >Febrero</option>
                <option value='03' <?php echo ($mes_fn == '3')? "selected='selected'":'' ?> >Marzo</option>
                <option value='04' <?php echo ($mes_fn == '4')? "selected='selected'":'' ?> >Abril</option>
                <option value='05' <?php echo ($mes_fn == '5')? "selected='selected'":'' ?> >Mayo</option>
                <option value='06' <?php echo ($mes_fn == '6')? "selected='selected'":'' ?> >Junio</option>
                <option value='07' <?php echo ($mes_fn == '7')? "selected='selected'":'' ?> >Julio</option>
                <option value='08' <?php echo ($mes_fn == '8')? "selected='selected'":'' ?> >Agosto</option>
                <option value='09' <?php echo ($mes_fn == '9')? "selected='selected'":'' ?> >Septiembre</option>
                <option value='10' <?php echo ($mes_fn == '10')? "selected='selected'":'' ?> >Octubre</option>
                <option value='11' <?php echo ($mes_fn == '11')? "selected='selected'":'' ?> >Noviembre</option>
                <option value='12' <?php echo ($mes_fn == '12')? "selected='selected'":'' ?> >Diciembre</option>
              </select>
              <select name="ano_fn" style="width: 70px;">
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 50 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') - 18 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_fn == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Direccion</label>
            <div class="controls">
               <input type="text" name="direccion" id="direccion" value="<?php echo $row->direccion?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Correo Electronico</label>
            <div class="controls">
               <input type="text" name="email" id="email" value="<?php echo $row->email?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Fono</label>
            <div class="controls">
               <input type="text" name="fono" id="fono" value="<?php echo $row->fono?>">
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
        ?> <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>