<div class="col-md-6 col-md-offset-2">
  <h3>Encuesta Trabajador <b><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno,'UTF-8')); ?></b></h3>    
    <?php
      if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
    ?>
    <div class="form-group">
     <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Trabaja en equipo
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" value="<?php echo $row->trabajo_equipo ?>" style="border:1px solid black" disabled/>
       </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n a la calidad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control input-mini" size="5" value="<?php echo $row->orientacion_calidad ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n al logro y cumplimiento de metas
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->orientacion_logro ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Iniciativa / Productividad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->iniciativa_productividad ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Adaptabilidad al cambio
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->adaptabilidad_al_cambio ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de aprendizaje
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->capacidad_aprendizaje ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Concientizaci&oacute;n sobre seguridad y MA
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->concientizacion_seguridad_ma ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Tolerancia al trabajo bajo presi&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->tolerancia_trabajo_bajo_presion ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Comunicaci&oacute;n a todo nivel
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->comunicacion_todo_nivel ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        An&aacute;lisis y evaluaci&oacute;n de problemas
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->analisis_evaluacion_problemas ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Disposici&oacute;n a recibir ordenes
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->disponibilidad_recibir_ordenes ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Relaciones interpersonales
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->relaciones_interpersonales ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Aplicaci&oacute;n de conocimientos de la especialidad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->aplicacion_conocimientos ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de toma de decisiones (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->capacidad_toma_decisiones ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Liderazgo (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->liderazgo ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Responsabilidad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->responsabilidad ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Autocuidado
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->autocuidado ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Presentaci&oacute;n personal
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->presentacion_personal ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Cumplimiento de normas y procedimientos
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->cumplimiento_normas ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Motivaci&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="<?php echo $row->motivacion ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Respeto
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" value="<?php echo $row->respeto ?>" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Recomendar&iacute; al trabajador?
      </label>
      <div class="col-sm-2">
        <div class="controls">
            si <input type='radio' name='recomienda' value="1" <?php if($row->recomienda == '1'){ echo "checked"; } ?> disabled>
            no <input type='radio' name='recomienda' value="0" <?php if($row->recomienda == '0'){ echo "checked"; } ?> disabled>
        </div>
      </div>
    </div>
   <?php
           }
        }else{
  ?>

  <div class="form-group">
     <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Trabaja en equipo
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" value="0" style="border:1px solid black" disabled/>
       </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n a la calidad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control input-mini" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n al logro y cumplimiento de metas
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Iniciativa / Productividad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Adaptabilidad al cambio
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de aprendizaje
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Concientizaci&oacute;n sobre seguridad y MA
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Tolerancia al trabajo bajo presi&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Comunicaci&oacute;n a todo nivel
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        An&aacute;lisis y evaluaci&oacute;n de problemas
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Disposici&oacute;n a recibir ordenes
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Relaciones interpersonales
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Aplicaci&oacute;n de conocimientos de la especialidad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de toma de decisiones (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Liderazgo (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Responsabilidad
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Autocuidado
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Presentaci&oacute;n personal
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Cumplimiento de normas y procedimientos
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Motivaci&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" size="5" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Respeto
      </label>
      <div class="col-sm-2">
        <input type='text' class="form-control" value="0" style="border:1px solid black" disabled/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Recomendar&iacute; al trabajador?
      </label>
      <div class="col-sm-2">
        <div class="controls">
            si <input type='radio' name='recomienda' value="1" disabled>
            no <input type='radio' name='recomienda' value="0" disabled>
        </div>
      </div>
    </div>

  <?php
        }
    ?>
    <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default close-subviews">Cancelar</button>
      </div>
</div>