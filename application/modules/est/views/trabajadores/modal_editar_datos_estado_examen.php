<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Dato Estado de Examen</h4>
  </div>
  <div id="modal_content">
    <?php
      if ($listado != FALSE){
        foreach ($listado as $row){
    ?>
		<div class="modal-header">
      <div class="col-md-7">
        <h5><b>Trabajador:</b></h5>
        <p>Nombre:<br> <?php echo $row->nombres ?></p>
        <p>Rut:<br> <?php echo $row->rut_usuario ?></p>
      </div>
      <div class="col-md-5">
        <h5><b>Dato Examen:</b></h5>
        <p>Fecha Eval: <?php echo $row->fecha_e ?></p>
        <p>Fecha Vigencia: <?php echo $row->fecha_v ?></p>
        <p>Valor: $<?php echo $row->valor_examen ?></p>
        <p>Centro Costo: <?php echo $row->ccosto ?></p>
      </div>
      <br><br><br><br><br><br><br><br>
    </div><br>
    <form action="<?php echo base_url() ?>est/trabajadores/actualizar_datos_estado_examen" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="id_planta" id="id_planta" value="<?php echo $id_planta ?>">
        <input type="hidden" name="id_eval" id="id_eval" value="<?php echo $row->id_eval ?>">
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Tipo Examen</b></label>
            <div class="controls">
                <?php
                  if($row->id_tipo_evaluacion == 3){
                    $tipo_examen = "Examen Preocupacional";
                  }elseif($row->id_tipo_evaluacion == 4){
                    $tipo_examen = "Induccion Masso Celulosa Arauco";
                  }else{
                    $tipo_examen = "";
                  }
                ?>
                <input type='text' class="input-mini form-control" value="<?php echo $tipo_examen ?>" readonly="readonly"/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Estado Cobro</b></label>
            <div class="controls">
              <select name="select_cobro" id="select_cobro" class="form-control" required>
                <option value="0" <?php if($row->estado_cobro == "0") echo "selected"; ?> >NO COBRADO</option>
                <option value="1" <?php if($row->estado_cobro == "1") echo "selected"; ?> >SI COBRADO</option>
                <option value="2" <?php if($row->estado_cobro == "2") echo "selected"; ?> >NO INFORMADO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Cobro</b></label>
            <div class="controls">
              <select name="dia_cobro" style="width: 60px;" required>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option value="<?php echo $i ?>" <?php echo ($row->dia_c == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_cobro" style="width: 108px;" required>
                <option value="">Mes</option>
                <option value='01' <?php echo ($row->mes_c == '1')? "selected='selected'" : '' ?> >Enero</option>
                <option value='02' <?php echo ($row->mes_c == '2')? "selected='selected'" : '' ?> >Febrero</option>
                <option value='03' <?php echo ($row->mes_c == '3')? "selected='selected'" : '' ?> >Marzo</option>
                <option value='04' <?php echo ($row->mes_c == '4')? "selected='selected'" : '' ?> >Abril</option>
                <option value='05' <?php echo ($row->mes_c == '5')? "selected='selected'" : '' ?> >Mayo</option>
                <option value='06' <?php echo ($row->mes_c == '6')? "selected='selected'" : '' ?> >Junio</option>
                <option value='07' <?php echo ($row->mes_c == '7')? "selected='selected'" : '' ?> >Julio</option>
                <option value='08' <?php echo ($row->mes_c == '8')? "selected='selected'" : '' ?> >Agosto</option>
                <option value='09' <?php echo ($row->mes_c == '9')? "selected='selected'" : '' ?> >Septiembre</option>
                <option value='10' <?php echo ($row->mes_c == '10')? "selected='selected'" : '' ?> >Octubre</option>
                <option value='11' <?php echo ($row->mes_c == '11')? "selected='selected'" : '' ?> >Noviembre</option>
                <option value='12' <?php echo ($row->mes_c == '12')? "selected='selected'" : '' ?> >Diciembre</option>
              </select>
              <select name="ano_cobro" style="width: 70px;" required>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($row->ano_c == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Comentario</b></label>
            <div class="controls">
              <textarea class="form-control" name="comentario_pago"><?php echo $row->comentario_pago ?></textarea>
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
        ?> <br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>