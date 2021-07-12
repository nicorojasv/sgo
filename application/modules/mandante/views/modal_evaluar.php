<div id="modal">
	<div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="exampleModalLabel">Encuesta Trabajador <?php echo $usuario->nombres ?> <?php echo $usuario->paterno ?></h4>
  </div>
  <div id="modal_content">
			<div class="modal-header">
        <h5>Instrucciones</h5>
        <p>Complete los siguientes campos: &aacute;rea de trabajo, Nombre de trabajador, rut, quien eval&uacute;a.</p>
        <p>Ponga nota del 1 al 7 y trdponfs 'si/no' frente a la pregunta si recomendar&iacute;a al trabajador.</p>
      </div><br>

        <form action="<?php echo base_url() ?>mandante/mandante/guardar_evaluacion" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
            <div class="col-md-6">
              <br><br>
              <div class="control-group">
                <label class="control-label" for="inputTipo">Trabaja en equipo</label>
                <div class="controls">
                  <input type='hidden' class="input-mini" name="usuario_id" id="usuario_id" value="<?php echo $_GET['usuario_id']; ?>"/>
                  <input type='hidden' class="input-mini" name="requerimiento_id" id="requerimiento_id" value="<?php echo $_GET['requerimiento_id']; ?>"/>
                  <input type='hidden' class="input-mini" name="area_id" id="area_id" value="<?php echo $_GET['area_id']; ?>"/>
                  <input type='text' class="input-mini" size="5" name="trabajo_equipo" id="trabajo_equipo" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Orientaci&oacute;n a la calidad</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="orientacion_calidad" id="orientacion_calidad" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Orientaci&oacute;n al logro<br>y cumplimiento de metas</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="orientacion_logro" id="orientacion_logro" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Iniciativa / Productividad</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="iniciativa_productividad" id="iniciativa_productividad" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Adaptabilidad al cambio</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="adaptabilidad_al_cambio" id="adaptabilidad_al_cambio" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Capacidad de aprendizaje</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="capacidad_aprendizaje" id="capacidad_aprendizaje" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Concientizaci&oacute;n sobre seguridad y MA</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="concientizacion_seguridad_ma" id="concientizacion_seguridad_ma" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Tolerancia al trabajo bajo presi&oacute;n</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="tolerancia_trabajo_bajo_presion" id="tolerancia_trabajo_bajo_presion" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Comunicaci&oacute;n a todo nivel</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="comunicacion_todo_nivel" id="comunicacion_todo_nivel" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">An&aacute;lisis y evaluaci&oacute;n de problemas</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="analisis_evaluacion_problemas" id="analisis_evaluacion_problemas" maxlength='1' required/>
                </div>
              </div>
              <div class="control-group">
              <label class="control-label" for="inputTipo">Disposici&oacute;n a recibir ordenes</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="disponibilidad_recibir_ordenes" id="disponibilidad_recibir_ordenes" maxlength='1' required/>
                </div>
              </div>
              </div>
            <div class="col-md-6">
              <br><br>
              <div class="control-group">
                <label class="control-label" for="inputTipo">Relaciones interpersonales</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="relaciones_interpersonales" id="relaciones_interpersonales" maxlength='1' required/>
                </div>
              </div>
            <div class="control-group">
                <label class="control-label" for="inputTipo">Aplicaci&oacute;n de conocimientos<br> de la especialidad</label>
                <div class="controls">
                  <input type='text' class="input-mini" size="5" name="aplicacion_conocimientos" id="aplicacion_conocimientos" maxlength='1' required/>
                </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Capacidad de toma de decisiones<br> (solo nivel superior)</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="capacidad_toma_decisiones" id="capacidad_toma_decisiones" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Liderazgo (solo nivel superior)</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="liderazgo" id="liderazgo" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Responsabilidad</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="responsabilidad" id="responsabilidad" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Autocuidado</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="autocuidado" id="autocuidado" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Presentaci&oacute;n personal</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="presentacion_personal" id="presentacion_personal" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Cumplimiento de normas y procedimientos</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="cumplimiento_normas" id="cumplimiento_normas" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Motivaci&oacute;n</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="motivacion" id="motivacion" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Respeto</label>
            <div class="controls">
                <input type='text' class="input-mini" size="5" name="respeto" id="respeto" maxlength='1' required/>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputTipo">Recomendar&iacute; al trabajador?</label>
            <div class="controls">
                si <input type='radio' name='recomienda' value="1">
                no <input type='radio' name='recomienda' value="0">
            </div>
            </div>
          </div>
			      <div class="modal-footer">
              <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" name="actualizar" class="btn btn-primary">Guardar</button>
            </div>
      </form>
	</div>
</div>