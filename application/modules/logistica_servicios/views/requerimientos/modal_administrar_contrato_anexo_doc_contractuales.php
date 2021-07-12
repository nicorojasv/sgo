<div id="modal">
  <form action="<?php echo base_url() ?>logistica_servicios/requerimientos/actualizar_contrato_anexo_doc_contractual/<?php echo $id_usu_arch?>/<?php echo $id_area_cargo?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <div id="modal_content">
    <?php if($datos_generales != FALSE){ ?>
      <?php foreach ($datos_generales as $usu){ 
        $bloqueo1 = $usu->get_proceso_val_contr;// == 1 Solicitud de contrato ya enviada
        $bloqueo2 = $usu->get_proceso_validado; // == 1 Solicitud de contrato validada, en proceso de aprobacion RRHH.
        $bloqueo3 = $usu->get_proceso_aprobado; // == 1  Generar Contrato
        $desbloqueo = $usu->get_proceso_rechazo;// == 1 si fue rechazado
      ?>
        <div class="row">
          <div class="col-md-6 col-sd-6">
            <h5><b><u>Datos trabajador:</u></b></h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><b>Nombres</b></td>
                  <td>
                    <input type="hidden" name="nombre" id="nombre" value="<?php echo $usu->nombres_apellidos ?>">
                    <input type="hidden" name="nombre_sin_espacios" id="nombre_sin_espacios" value="<?php echo $usu->nombre_sin_espacios ?>">
                    <?php echo $usu->nombres_apellidos ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Rut</b></td>
                  <td>
                    <input type="hidden" name="rut_usuario" id="rut_usuario" value="<?php echo $usu->rut ?>">
                    <?php echo $usu->rut ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Estado Civil</b></td>
                  <td>
                    <input type="hidden" name="estado_civil" id="estado_civil" value="<?php echo $usu->estado_civil ?>">
                    <?php echo $usu->estado_civil ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Fecha Nacimiento</b></td>
                  <td>
                    <input type="hidden" name="fecha_nac" id="fecha_nac" value="<?php echo $usu->fecha_nac ?>">
                    <?php echo $usu->fecha_nac ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Domicilio</b></td>
                  <td>
                    <input type="hidden" name="domicilio" id="domicilio" value="<?php echo $usu->domicilio ?>">
                    <?php echo $usu->domicilio ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Ciudad</b></td>
                  <td>
                    <input type="hidden" name="ciudad" id="ciudad" value="<?php echo $usu->ciudad ?>">
                    <?php echo $usu->ciudad ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Previsión</b></td>
                  <td>
                    <input type="hidden" name="prevision" id="prevision" value="<?php echo $usu->prevision ?>">
                    <?php echo $usu->prevision ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Salud</b></td>
                  <td>
                    <input type="hidden" name="salud" id="salud" value="<?php echo $usu->salud ?>">
                    <?php echo $usu->salud ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6  col-sd-6">
            <h5><b><u>Datos adicionales:</u></b></h5>
            <table class="table">
              <tbody>
                <!--<tr>
                  <td><b>Nombre Requerimiento</b></td>
                  <td><font color="#0101DF"><?php //echo $usu->nombre_req ?></font></td>
                </tr>-->
                <tr>
                  <td><b>Referido</b></td>
                  <td>
                    <input type="hidden" name="referido" id="referido" value="<?php if($usu->referido == 1) echo "SI"; else echo "NO"; ?>">
                    <?php if($usu->referido == 1) echo "SI"; else echo "NO";  ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Puesto de trabajo/Cargo</b></td>
                  <td>
                    <input type="hidden" name="cargo" id="cargo" value="<?php echo $usu->cargo ?>">
                    <?php echo $usu->cargo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Area Trabajo</b></td>
                  <td>
                    <input type="hidden" name="area" id="area" value="<?php echo $usu->area ?>">
                    <?php echo $usu->area ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Centro de Costo</b></td>
                  <td>
                    <?php echo $usu->nombre_centro_costo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Nivel Educacional</b></td>
                  <td>
                    <input type="hidden" name="nivel_estudios" id="nivel_estudios" value="<?php echo $usu->nivel_estudios ?>">
                    <?php echo $usu->nivel_estudios ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Teléfono</b></td>
                  <td>
                    <input type="hidden" name="telefono" id="telefono" value="<?php echo $usu->telefono ?>">
                    <?php echo $usu->telefono ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Nacionalidad</b></td>
                  <td>
                    <input type="hidden" name="nacionalidad" id="nacionalidad" value="<?php echo $usu->nacionalidad ?>">
                    <?php echo $usu->nacionalidad ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <h5><b><u>Datos empresa:</u></b></h5>
        <div class="row">
          <div class="col-md-6  col-sd-6">
            <table class="table">
              <tbody>
                <tr>
                  <td><b>Razón Social</b></td>
                  <td>
                    <input type="hidden" name="nombre_centro_costo" id="nombre_centro_costo" value="<?php echo $usu->nombre_centro_costo ?>">
                    <?php echo $usu->nombre_centro_costo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Rut</b></td>
                  <td>
                    <input type="hidden" name="rut_centro_costo" id="rut_centro_costo" value="<?php echo $usu->rut_centro_costo ?>">
                    <?php echo $usu->rut_centro_costo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Planta</b></td>
                  <td>
                    <input type="hidden" name="id_planta" id="id_planta" value="<?php echo $usu->id_planta ?>">
                    <input type="hidden" name="nombre_planta" id="nombre_planta" value="<?php echo $usu->nombre_planta ?>">
                    <?php echo $usu->nombre_planta ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6  col-sd-">
            <table class="table">
              <tbody>
                <tr>
                  <td><b>Dirección Planta</b></td>
                  <td>
                    <input type="hidden" name="direccion_planta" id="direccion_planta" value="<?php echo $usu->direccion_planta ?>">
                    <?php echo $usu->direccion_planta ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Comuna Planta</b></td>
                  <td>
                    <input type="hidden" name="ciudad_planta" id="ciudad_planta" value="<?php echo $usu->ciudad_planta ?>">
                    <?php echo $usu->ciudad_planta ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Región Planta</b></td>
                  <td>
                    <input type="hidden" name="region_planta" id="region_planta" value="<?php echo $usu->region_planta ?>">
                    <?php echo $usu->region_planta ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Tipo Gratificación Planta</b></td>
                  <td>
                    <input type="hidden" name="tipo_gratificacion" id="tipo_gratificacion" value="<?php echo $usu->tipo_gratificacion ?>">
                    <input type="hidden" name="descripcion_tipo_gratificacion" id="descripcion_tipo_gratificacion" value="<?php echo $usu->descripcion_tipo_gratificacion ?>">
                    <?php echo $usu->tipo_gratificacion ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
    <hr>
      <br>
        <?php
          if($datos_usu_arch != FALSE){
            foreach ($datos_usu_arch as $row){

        ?>
      <div class="row">
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Datos del contrato</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="causal">Causal</label>
            <div class="controls">
              <input type='hidden' name="gc_causal" value="<?php echo $row->causal ?>" />
              <select name="causal" id="causal" class="form-control" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="<?php echo $row->causal ?>"><?php echo $row->causal ?></option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="motivo">Motivo</label>
            <div class="controls">
              <input type='hidden' name="gc_motivo" value="<?php echo $row->motivo ?>" />
              <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo $row->motivo?>" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> />
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="dia_fi">Fecha Inicio</label>
            <div class="controls">
              <?php if($row->fecha_inicio){
                $f = explode('-', $row->fecha_inicio);
                $dia_fi = $f[2];
                $mes_fi = $f[1];
                $ano_fi = $f[0];
              }else{
                $dia_fi = false;
                $mes_fi = false;
                $ano_fi = false;
              } ?>
              <input type="hidden" name="gc_dia_fi" value="<?php echo $dia_fi ?>">
              <select name="dia_fi" id="dia_fi" style="width:33%;" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <input type="hidden" name="gc_mes_fi" value="<?php echo $mes_fi ?>">
              <select name="mes_fi" id="mes_fi" style="width: 33%;" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_fi == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php echo ($mes_fi == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php echo ($mes_fi == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php echo ($mes_fi == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php echo ($mes_fi == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php echo ($mes_fi == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php echo ($mes_fi == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php echo ($mes_fi == '8')? "selected='selected'" : '' ?>>Agosto</option>
                <option value='09' <?php echo ($mes_fi == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php echo ($mes_fi == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php echo ($mes_fi == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php echo ($mes_fi == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <input type="hidden" name="gc_ano_fi" value="<?php echo $ano_fi ?>">
              <select name="ano_fi" id="ano_fi" style="width: 32%;" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="dia_ft">Fecha Termino</label>
            <div class="controls">
              <?php if($row->fecha_termino){
                $f = explode('-', $row->fecha_termino);
                $dia_ft = $f[2];
                $mes_ft = $f[1];
                $ano_ft = $f[0];
              }else{
                $dia_ft = false;
                $mes_ft = false;
                $ano_ft = false;
              } ?>
              <input type="hidden" name="gc_dia_ft" value="<?php echo $dia_ft ?>">
              <select name="dia_ft" id="dia_ft" style="width: 33%;" <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <input type="hidden" name="gc_mes_ft" value="<?php echo $mes_ft ?>">
              <select name="mes_ft" id="mes_ft" style="width: 33%;" <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_ft == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php echo ($mes_ft == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php echo ($mes_ft == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php echo ($mes_ft == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php echo ($mes_ft == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php echo ($mes_ft == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php echo ($mes_ft == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php echo ($mes_ft == '8')? "selected='selected'" : '' ?>>Agosto</option>
                <option value='09' <?php echo ($mes_ft == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php echo ($mes_ft == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php echo ($mes_ft == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php echo ($mes_ft == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <input type="hidden" name="gc_ano_ft" value="<?php echo $ano_ft ?>">
              <select name="ano_ft" id="ano_ft" style="width: 32%;" <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
           </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="jornada">Jornada/Turno</label>
            <div class="controls">
              <input type="hidden" name="gc_jornada" value="<?php echo $row->jornada ?>">
              <select name="jornada" id="jornada" class="form-control" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >
                <option value="">[Seleccione]</option>
                <?php foreach($horarios_planta as $hp){ ?>
                <option value="<?php echo $hp->id ?>" title="<?php echo str_replace("<w:br/>","\n", $hp->descripcion) ?>" <?php if($row->jornada == $hp->id) echo "selected"; ?> ><?php echo $hp->nombre_horario ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
            <div class="controls">
              <input type='hidden' name="gc_renta_imponible" value="<?php echo $row->renta_imponible?>"/>
              <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="<?php echo $row->renta_imponible?>" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> />
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Bonos</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
            <div class="controls">
              <input type='hidden'  name="gc_asignacion_movilizacion" value="<?php echo $row->asignacion_movilizacion ?>" />
              <input type='text' class="form-control" name="asignacion_movilizacion" id="asignacion_movilizacion" value="<?php echo $row->asignacion_movilizacion ?>" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> />
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_colacion">Asignación Colación</label>
            <div class="controls">
              <input type='hidden' name="gc_asignacion_colacion" value="<?php echo $row->asignacion_colacion ?>" />
              <input type='text' class="form-control" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo $row->asignacion_colacion ?>" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> />
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_zona">Asignación Zona</label>
            <div class="controls">
              <input type='hidden'  name="gc_asignacion_zona" value="<?php echo $row->asignacion_zona ?>"  />
              <input type='text' class="form-control" name="asignacion_zona" id="asignacion_zona" value="<?php echo $row->asignacion_zona ?>" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> />
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="viatico">Viático</label>
            <div class="controls">
              <input type='hidden' name="gc_viatico" value="<?php echo $row->viatico ?>" />
              <input type='text' class="form-control" name="viatico" id="viatico" value="<?php echo $row->viatico ?>" required <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> />
            </div>
          </div>
        </div>
      </div>
      <br><br>
      <div class="modal_content">
        <div class="row">
          <div class="col-md-6">
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="actualizar" class="btn btn-primary" <?php if($bloqueo1 == 1 || $bloqueo2 == 1 || $bloqueo3 == 1) echo "disabled"; ?> >Editar</button>
          </div>
          <div class="col-md-6" style="text-align: center">
              <?php if($usu->get_proceso_aprobado == 1){ ?>
              <button type="submit" name="generar_contrato" class="btn btn-green">Generar Contrato</button>
              <br>
              <?php }elseif($usu->get_proceso_val_contr == 1){ ?>
              <button type="button" class="btn btn-red">Solicitud de contrato ya enviada...</button>
              <br>
              <?php }elseif($usu->get_proceso_validado == 1){ ?>
              <button type="button" class="btn btn-green">Solicitud de contrato validada, en proceso de aprobacion RRHH...</button>
              <br>
              <?php }else{ ?>
              <?php if ($desbloqueo ==1 && !empty($usu->comentarios))echo " <b>Observacion:</b> ".$usu->comentarios;?>
              <button type="submit" name="envio_solicitud_contrato" class="<?php if($desbloqueo==1)echo "btn btn-orange"; else echo "btn btn-green" ?>"><?php if($desbloqueo==1)echo "Solicitud anterior rechazada, volver a enviar solicitud"; else echo "Enviar solicitud de revision de contrato"; ?></button>
              <?php } ?>
          </div>
        </div>
      </div>
      <?php
            }
          }
        ?>
    </form>
    <br><br>
</div>
</div>