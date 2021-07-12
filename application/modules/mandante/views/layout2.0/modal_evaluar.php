<script type="text/javascript">
  function valida_numeros_siete(e){
    tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==8){
            return true;
        }
        patron =/[1234567]/;
        tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }
</script>
<div class="col-md-6 col-md-offset-2">
  <h3>Encuesta Trabajador <b><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno,'UTF-8')); ?></b></h3>
  <h4>Instrucciones</h4>
  <p>Inserte nota del 1 al 7 y 'si/no', seg&uacute;n corresponda.</p>
  <form action="<?php echo base_url() ?>mandante/mandante/guardar_evaluacion" method="post" role="form" class="form-horizontal">
    <?php
      if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
    ?>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Trabaja en equipo
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" value="<?php echo $row->trabajo_equipo ?>" name="trabajo_equipo" id="trabajo_equipo" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
        <input type='hidden' name="area_cargo" id="area_cargo" value="<?php echo $area_cargo ?>"/>
        <input type='hidden' name="id_usuario" id="id_usuario" value="<?php echo $id_usuario ?>"/>
        <input type='hidden' name="id_planta" id="id_planta" value="<?php echo $id_planta ?>"/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n a la calidad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control input-mini" size="5" value="<?php echo $row->orientacion_calidad ?>" name="orientacion_calidad" id="orientacion_calidad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n al logro y cumplimiento de metas
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->orientacion_logro ?>" name="orientacion_logro" id="orientacion_logro" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Iniciativa / Productividad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->iniciativa_productividad ?>" name="iniciativa_productividad" id="iniciativa_productividad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" style="border:1px solid black" min="1" max="7" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Adaptabilidad al cambio
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->adaptabilidad_al_cambio ?>" name="adaptabilidad_al_cambio" id="adaptabilidad_al_cambio" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" style="border:1px solid black" min="1" max="7" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de aprendizaje
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->capacidad_aprendizaje ?>" name="capacidad_aprendizaje" id="capacidad_aprendizaje" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Concientizaci&oacute;n sobre seguridad y MA
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->concientizacion_seguridad_ma ?>" name="concientizacion_seguridad_ma" id="concientizacion_seguridad_ma" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Tolerancia al trabajo bajo presi&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->tolerancia_trabajo_bajo_presion ?>" name="tolerancia_trabajo_bajo_presion" id="tolerancia_trabajo_bajo_presion" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Comunicaci&oacute;n a todo nivel
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->comunicacion_todo_nivel ?>" name="comunicacion_todo_nivel" id="comunicacion_todo_nivel" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        An&aacute;lisis y evaluaci&oacute;n de problemas
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->analisis_evaluacion_problemas ?>" name="analisis_evaluacion_problemas" id="analisis_evaluacion_problemas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Disposici&oacute;n a recibir ordenes
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->disponibilidad_recibir_ordenes ?>" name="disponibilidad_recibir_ordenes" id="disponibilidad_recibir_ordenes" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Relaciones interpersonales
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->relaciones_interpersonales ?>" name="relaciones_interpersonales" id="relaciones_interpersonales" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Aplicaci&oacute;n de conocimientos de la especialidad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->aplicacion_conocimientos ?>" name="aplicacion_conocimientos" id="aplicacion_conocimientos" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de toma de decisiones (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->capacidad_toma_decisiones ?>" name="capacidad_toma_decisiones" id="capacidad_toma_decisiones" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Liderazgo (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->liderazgo ?>" name="liderazgo" id="liderazgo" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Responsabilidad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->responsabilidad ?>" name="responsabilidad" id="responsabilidad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Autocuidado
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->autocuidado ?>" name="autocuidado" id="autocuidado" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Presentaci&oacute;n personal
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->presentacion_personal ?>" name="presentacion_personal" id="presentacion_personal" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Cumplimiento de normas y procedimientos
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->cumplimiento_normas ?>" name="cumplimiento_normas" id="cumplimiento_normas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Motivaci&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" value="<?php echo $row->motivacion ?>" name="motivacion" id="motivacion" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Respeto
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" value="<?php echo $row->respeto ?>" name="respeto" id="respeto" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Recomendar&iacute; al trabajador?
      </label>
      <div class="col-sm-2">
        <div class="controls">
            si <input type='radio' name='recomienda' value="1" <?php if($row->recomienda == '1'){ echo "checked"; } ?>>
            no <input type='radio' name='recomienda' value="0" <?php if($row->recomienda == '0'){ echo "checked"; } ?>>
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
        <input type='number' class="form-control" name="trabajo_equipo" id="trabajo_equipo" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
        <input type='hidden' name="area_cargo" id="area_cargo" value="<?php echo $area_cargo ?>"/>
        <input type='hidden' name="id_usuario" id="id_usuario" value="<?php echo $id_usuario ?>"/>
        <input type='hidden' name="id_planta" id="id_planta" value="<?php echo $id_planta ?>"/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n a la calidad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control input-mini" size="5" name="orientacion_calidad" id="orientacion_calidad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Orientaci&oacute;n al logro y cumplimiento de metas
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="orientacion_logro" id="orientacion_logro" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Iniciativa / Productividad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="iniciativa_productividad" id="iniciativa_productividad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" style="border:1px solid black" min="1" max="7" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Adaptabilidad al cambio
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="adaptabilidad_al_cambio" id="adaptabilidad_al_cambio" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" style="border:1px solid black" min="1" max="7" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de aprendizaje
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="capacidad_aprendizaje" id="capacidad_aprendizaje" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Concientizaci&oacute;n sobre seguridad y MA
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="concientizacion_seguridad_ma" id="concientizacion_seguridad_ma" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Tolerancia al trabajo bajo presi&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="tolerancia_trabajo_bajo_presion" id="tolerancia_trabajo_bajo_presion" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Comunicaci&oacute;n a todo nivel
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="comunicacion_todo_nivel" id="comunicacion_todo_nivel" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        An&aacute;lisis y evaluaci&oacute;n de problemas
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="analisis_evaluacion_problemas" id="analisis_evaluacion_problemas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Disposici&oacute;n a recibir ordenes
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="disponibilidad_recibir_ordenes" id="disponibilidad_recibir_ordenes" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Relaciones interpersonales
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="relaciones_interpersonales" id="relaciones_interpersonales" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Aplicaci&oacute;n de conocimientos de la especialidad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="aplicacion_conocimientos" id="aplicacion_conocimientos" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Capacidad de toma de decisiones (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="capacidad_toma_decisiones" id="capacidad_toma_decisiones" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Liderazgo (solo nivel superior)
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="liderazgo" id="liderazgo" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Responsabilidad
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="responsabilidad" id="responsabilidad" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Autocuidado
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="autocuidado" id="autocuidado" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Presentaci&oacute;n personal
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="presentacion_personal" id="presentacion_personal" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Cumplimiento de normas y procedimientos
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="cumplimiento_normas" id="cumplimiento_normas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Motivaci&oacute;n
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" size="5" name="motivacion" id="motivacion" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Respeto
      </label>
      <div class="col-sm-2">
        <input type='number' class="form-control" name="respeto" id="respeto" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="1" min="1" max="7" style="border:1px solid black" onKeyPress="return valida_numeros_siete(event)" required/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-6 control-label" for="form-field-1" style="text-align: left;">
        Recomendar&iacute; al trabajador?
      </label>
      <div class="col-sm-2">
        <div class="controls">
            si <input type='radio' name='recomienda' value="1" checked>
            no <input type='radio' name='recomienda' value="0">
        </div>
      </div>
    </div>

  <?php
        }
    ?>
    <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default close-subviews">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
      </div>
  </form>
</div>