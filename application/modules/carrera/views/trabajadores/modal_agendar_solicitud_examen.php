<div id="modal">
	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel" align="center">Agendar Examen <?php echo $tipo_examen ?></h4>
  </div>
  <div id="modal_content">
    <form action="<?php echo base_url() ?>carrera/trabajadores/ingresar_agenda_de_examen" method='post'>
      <br>
      <input type='hidden' value="<?php echo $id_solicitud ?>" name="id_solicitud" id="id_solicitud"/>
      <input type='hidden' value="<?php echo $id_tipo_examen ?>" name="id_tipo_examen" id="id_tipo_examen"/>
      <input type='hidden' value="<?php echo isset($agendado->id)?$agendado->id:NULL ?>" name="id_agendado" id="id_agendado"/>
      <div class="col-md-6">
        <div class="control-group">
          <label class="control-label" for="dia_fc">Fecha Citacion</label>
          <div class="controls">
            <?php
            $id_agendado = isset($agendado->id)?$agendado->id:NULL;
            if( $id_agendado != NULL ){
              $f = explode('-', $agendado->fecha_citacion);
              $dia_ct = $f[2];
              $mes_ct = $f[1];
              $ano_ct = $f[0];
            }else{
              $dia_ct = false;
              $mes_ct = false;
              $ano_ct = false;
            }
            ?>
            <select name="dia_fc" style="width: 30%;" required <?php if($estado_bloqueo == "SI") echo "disabled" ?> >
              <option value="" >Dia</option>
              <?php for($i=1;$i<32;$i++){ ?>
              <option value="<?php echo $i ?>" <?php echo ($dia_ct == $i)?"selected":'' ?> ><?php echo $i ?></option>
              <?php } ?>
            </select>
            <select name="mes_fc" style="width: 33%;" required <?php if($estado_bloqueo == "SI") echo "disabled" ?> >
              <option value="">Mes</option>
              <option value='01' <?php echo ($mes_ct == '01')?"selected":'' ?> >Enero</option>
              <option value='02' <?php echo ($mes_ct == '02')?"selected":'' ?> >Febrero</option>
              <option value='03' <?php echo ($mes_ct == '03')?"selected":'' ?> >Marzo</option>
              <option value='04' <?php echo ($mes_ct == '04')?"selected":'' ?> >Abril</option>
              <option value='05' <?php echo ($mes_ct == '05')?"selected":'' ?> >Mayo</option>
              <option value='06' <?php echo ($mes_ct == '06')?"selected":'' ?> >Junio</option>
              <option value='07' <?php echo ($mes_ct == '07')?"selected":'' ?> >Julio</option>
              <option value='08' <?php echo ($mes_ct == '08')?"selected":'' ?> >Agosto</option>
              <option value='09' <?php echo ($mes_ct == '09')?"selected":'' ?> >Septiembre</option>
              <option value='10' <?php echo ($mes_ct == '10')?"selected":'' ?> >Octubre</option>
              <option value='11' <?php echo ($mes_ct == '11')?"selected":'' ?> >Noviembre</option>
              <option value='12' <?php echo ($mes_ct == '12')?"selected":'' ?> >Diciembre</option>
            </select>
            <select name="ano_fn" style="width: 33%;" required <?php if($estado_bloqueo == "SI") echo "disabled" ?> >
              <option value="">Año</option>
              <?php $tope_f = (date('Y') ); ?>
              <?php for($i=$tope_f;$i < (date('Y') + 3 ); $i++){ ?>
                <option value="<?php echo $i ?>" <?php echo ($ano_ct == $i)?"selected":'' ?> ><?php echo $i ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="lugar">Lugar</label>
          <div class="controls">
            <input type='text' name="lugar" class="form-control" value="<?php echo isset($agendado->lugar)?$agendado->lugar:'' ?>" required <?php if($estado_bloqueo == "SI") echo "disabled" ?> />
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="control-group">
          <label class="control-label" for="hora">Hora</label>
          <div class="controls">
            <input type='text' name="hora" class="form-control" value="<?php echo isset($agendado->hora)?$agendado->hora:'' ?>" required <?php if($estado_bloqueo == "SI") echo "disabled" ?> />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="observaciones">Observaciones</label>
          <div class="controls">
            <textarea name="observaciones" class="form-control" required <?php if($estado_bloqueo == "SI") echo "disabled" ?> ><?php echo isset($agendado->observaciones)?$agendado->observaciones:'' ?></textarea>
          </div>
        </div>
      </div>
      <br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary" <?php if($estado_bloqueo == "SI") echo "disabled" ?> >Guardar y Procesar</button>
      </div>
    </form>
	</div>
</div>