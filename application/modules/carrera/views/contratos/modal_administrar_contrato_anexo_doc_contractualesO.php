<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>carrera/contratos/generar_contrato_anexo_doc_contractual" method='post' enctype="multipart/form-data">
    <?php if($datos_generales != FALSE){ ?>
      <?php foreach ($datos_generales as $usu){ 
       if(isset($usu->codigoContrato)) $codigoContrato = $usu->codigoContrato; 
      ?>
        <div class="row">
          <div class="col-md-6 col-sd-6">
            <h5><b><u>Datos trabajador:</u></b></h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><b>Nombres</b></td>
                  <td>
                    <input type="hidden" name="id_req_usu_arch" id="id_req_usu_arch" value="<?php echo $id_usu_arch ?>">
                    <input type="hidden" name="nombre" id="nombre" value="<?php echo titleCase($usu->nombres_apellidos) ?>">
                    <input type="hidden" name="nombre_sin_espacios" id="nombre_sin_espacios" value="<?php echo titleCase($usu->nombre_sin_espacios) ?>">
                    <?php echo titleCase($usu->nombres_apellidos) ?>
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
                    <input type="hidden" name="id_centro_costo" id="id_centro_costo" value="<?php echo $usu->id_centro_costo ?>">
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
              </tbody>
            </table>
          </div>
        </div>
      <?php } ?>
    <?php } ?>
    <hr>
      <br>
        <?php
          if ($datos_usu_arch != FALSE){
            foreach ($datos_usu_arch as $row){
        ?>
      <div class="row">
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Datos del contrato</u></b></h4>
          <div class="control-form">
            <label class="control-label">Causal</label>
            <div class="controls">
              <input type="hidden" name="causal" id="causal" value="<?php echo $row->causal ?>">
              <?php echo $row->causal ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Motivo</label>
            <div class="controls">
              <input type="hidden" name="motivo" id="motivo" value="<?php echo $row->motivo ?>">
              <?php echo $row->motivo ?>
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
              <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="<?php echo $row->fecha_inicio ?>">
              <select name="dia_fi" id="dia_fi" style="width:33%;" disabled >
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fi" id="mes_fi" style="width: 33%;" disabled >
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
              <select name="ano_fi" id="ano_fi" style="width: 32%;" disabled>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="dia_fp">Fecha Termino</label>
            <div class="controls">
              <?php if($row->fecha_termino){
                $f = explode('-', $row->fecha_termino);
                $dia_fp = $f[2];
                $mes_fp = $f[1];
                $ano_fp = $f[0];
              }else{
                $dia_fp = false;
                $mes_fp = false;
                $ano_fp = false;
              } ?>
              <input type="hidden" name="fecha_termino" id="fecha_termino" value="<?php echo $row->fecha_termino ?>">
              <select name="dia_fp" id="dia_fp" style="width: 33%;" disabled>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fp == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fp" id="mes_fp" style="width: 33%;" disabled>
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_fp == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php echo ($mes_fp == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php echo ($mes_fp == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php echo ($mes_fp == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php echo ($mes_fp == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php echo ($mes_fp == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php echo ($mes_fp == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php echo ($mes_fp == '8')? "selected='selected'" : '' ?>>Agosto</option>
                <option value='09' <?php echo ($mes_fp == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php echo ($mes_fp == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php echo ($mes_fp == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php echo ($mes_fp == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <select name="ano_fp" id="ano_fp" style="width: 32%;" disabled>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_fp == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
           </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="dia_fp">Fecha Pago</label>
            <div class="controls">
              <?php if($row->fecha_pago){
                $f = explode('-', $row->fecha_pago);
                $dia_fp = $f[2];
                $mes_fp = $f[1];
                $ano_fp = $f[0];
              }else{
                $dia_fp = false;
                $mes_fp = false;
                $ano_fp = false;
              } ?>
              <input type="hidden" name="fecha_pago" id="fecha_pago" value="<?php echo $row->fecha_pago ?>">
              <select name="dia_fp" id="dia_fp" style="width: 33%;" disabled>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fp == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fp" id="mes_fp" style="width: 33%;" disabled>
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_fp == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php echo ($mes_fp == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php echo ($mes_fp == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php echo ($mes_fp == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php echo ($mes_fp == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php echo ($mes_fp == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php echo ($mes_fp == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php echo ($mes_fp == '8')? "selected='selected'" : '' ?>>Agosto</option>
                <option value='09' <?php echo ($mes_fp == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php echo ($mes_fp == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php echo ($mes_fp == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php echo ($mes_fp == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <select name="ano_fp" id="ano_fp" style="width: 32%;" disabled>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_fp == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
           </div>
          </div>
          <div class="control-form">
            <label class="control-label">Jornada/Turno</label>
            <div class="controls">
              <?php
                $horario_encontrado = 0;
                foreach($listado_horarios as $lh){
                  if($row->jornada == $lh->id){
                    $horario_encontrado += 1;
                    echo "<input type='hidden' name='jornada' value='".$lh->id."'>";
                    echo "<input type='hidden' value='".$lh->descripcion."'>";
                  }
                }
                if($horario_encontrado == 0)
                  echo "<input type='hidden' name='jornada' id='jornada' value=''>";
              ?>
              <select class="form-control" disabled>
                <option value="">[Seleccione]</option>
                <?php foreach($listado_horarios as $lh){ ?>
                  <option value="<?php echo $lh->id ?>" <?php if($row->jornada == $lh->id) echo "selected" ?>><?php echo $lh->nombre_horario ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Sueldo Base de la Liquidación</label>
            <div class="controls">
              <input type="hidden" name="renta_imponible" id="renta_imponible" value="<?php echo $row->renta_imponible ?>">
              <?php echo $row->renta_imponible ?>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Tipo Contrato</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="tipo_contrato">Tipo Contrato</label>
            <div class="controls">
              <input type='hidden' name="gc_tipo_contrato" value="<?php echo $row->id_tipo_contrato ?>"/>
              <label><input type='radio' <?php if($row->id_tipo_contrato == 1) echo "checked"; ?> disabled/> Diario</label>
              <label><input type='radio' <?php if($row->id_tipo_contrato == 2) echo "checked"; ?> disabled/> Mensual</label>
            </div>
          </div>
          <h4><b><u>Bonos</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="bono_gestion">Bono Gestión</label>
            <div class="controls">
              <input type="hidden" name="bono_gestion" id="bono_gestion" value="<?php echo $row->bono_gestion ?>">
              <?php echo $row->bono_gestion ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
            <div class="controls">
              <input type="hidden" name="asignacion_movilizacion" id="asignacion_movilizacion" value="<?php echo $row->asignacion_movilizacion ?>">
              <?php echo $row->asignacion_movilizacion ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Asignación Colación</label>
            <div class="controls">
              <input type="hidden" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo $row->asignacion_colacion ?>">
              <?php echo $row->asignacion_colacion ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Asignación Zona</label>
            <div class="controls">
              <input type="hidden" name="asignacion_zona" id="asignacion_zona" value="<?php echo $row->asignacion_zona ?>">
              <?php echo $row->asignacion_zona ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Viático</label>
            <div class="controls">
              <input type="hidden" name="viatico" id="viatico" value="<?php echo $row->viatico ?>">
              <?php echo $row->viatico ?>
            </div>
          </div>
        </div>
      </div>
      <div class="modal_content">
        <br><br>
        <div class="row">
          <div class="col-md-6">
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
          <div class="col-md-6">
        <?php
            if(isset($pedientes_baja)){// si vengo a dar de baja este contrato
               if($this->session->userdata('tipo_usuario') == 11 || $this->session->userdata('tipo_usuario') == 8){
        ?>  
                <span>Codigo Contrato: <?php echo $codigoContrato; ?></span><br>
                  <button type="submit" name="dar_de_baja" class="btn btn-green">Dar de baja contrato</button>
                  <button type="submit" name="deshacer_solicitud" class="btn btn-red">Deshacer solicitud</button>
        <?php
                }
            }else{
                  if($this->session->userdata('tipo_usuario') != 11 && $this->session->userdata('tipo_usuario') != 8){
                    if($row->estado_proceso == 2){
        ?>
                        <button type="submit" name="generar_contrato" class="btn btn-green">Generar Contrato WORD</button>
                        <button type="submit" name="generar_doc_adicionales_contrato" class="btn btn-green">Generar Doc. Adicionales</button>
        <?php
                      if($row->id_tipo_contrato == 1){
        ?>
                        <button type="submit" name="generar_finiquito_diario" class="btn btn-green">Generar Finiquito</button>
        <?php 
                      } 
                    }
                   }else{ 
        ?>
                        <button type="submit" name="generar_contrato" class="btn btn-green">Generar Contrato WORD</button>
                        <button type="submit" name="generar_doc_adicionales_contrato" class="btn btn-green">Generar Doc. Adicionales</button>
        <?php
                    if($row->id_tipo_contrato == 1){
        ?>
                        <button type="submit" name="generar_finiquito_diario" class="btn btn-green">Generar Finiquito</button>
        <?php 
                    }
                 } 
            }
        ?>
          </div>
        </div>
      </div>
    </form>
    <?php
        }
      }
    ?>
    <br><br>
  </div>
</div>