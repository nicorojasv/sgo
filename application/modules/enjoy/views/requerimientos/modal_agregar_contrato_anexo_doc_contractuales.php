
<div id="modal">

  <form action="<?php echo base_url() ?>enjoy/requerimientos/guardar_nuevo_contrato_anexo_doc_contractual/<?php echo $usuario ?>/<?php echo $tipo ?>/<?php echo $asc_area ?>" role="form"  id="form2" method='post' name="f2" enctype="multipart/form-data">

    <input type='hidden' name="datos_extras" id="datos_extras" value="SI"/> 
    <div id="modal_content">
      <?php if($datos_generales != FALSE){ ?>
      <?php foreach ($datos_generales as $usu){ ?>
      <div class="row">
        <div class="col-md-6 col-sd-6">
          <h5><b><u>Datos trabajador:</u></b></h5>

          <table class="table">
            <tbody>
              <tr>
                <td><b>Nombres</b></td>
                <td><?php echo $usu->nombres_apellidos ?></td>
              </tr>
              <tr>
                <td><b>Rut</b></td>
                <td><?php echo $usu->rut ?></td>
              </tr>
              <tr>
                <td><b>Estado Civil</b></td>
                <td><?php echo $usu->estado_civil ?></td>
              </tr>
              <tr>
                <td><b>Fecha Nacimiento</b></td>
                <td><?php echo $usu->fecha_nac ?></td>
              </tr>
              <tr>
                <td><b>Domicilio</b></td>
                <td><?php echo $usu->domicilo ?></td>
              </tr>
              <tr>
                <td><b>Ciudad</b></td>
                <td><?php echo $usu->ciudad ?></td>
              </tr>
              <tr>
                <td><b>Previsión</b></td>
                <td><?php echo $usu->prevision ?></td>
              </tr>
              <tr>
                <td><b>Salud</b></td>
                <td><?php echo $usu->salud ?></td>
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
                  <td><font color="#0101DF"><?php echo $usu->nombre_req ?></font></td>
                </tr>-->
                <tr>
                  <td><b>Referido</b></td>
                  <td><?php if($usu->referido == 1) echo "SI"; else echo "NO";  ?></td>
                </tr>
                <tr>
                  <td><b>Puesto de trabajo/Cargo</b></td>
                  <td><?php echo $usu->cargo ?></td>
                </tr>
                <tr>
                  <td><b>Area Trabajo</b></td>
                  <td><?php echo $usu->area ?></td>
                </tr>
                <tr>
                  <td><b>Centro de Costo</b></td>
                  <td><?php echo $usu->nombre_centro_costo ?></td>
                </tr>
                <tr>
                  <td><b>Nivel Educacional</b></td>
                  <td><?php echo $usu->nivel_estudios ?></td>
                </tr>
                <tr>
                  <td><b>Teléfono</b></td>
                  <td><?php echo $usu->telefono ?></td>
                </tr>
                <tr>
                  <td><b>Nacionalidad</b></td>
                  <td><?php echo $usu->nacionalidad ?></td>
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
                  <td><?php echo $usu->nombre_centro_costo ?></td>
                </tr>
                <tr>
                  <td><b>Rut</b></td>
                  <td><?php echo $usu->rut_centro_costo ?></td>
                </tr>
                <tr>
                  <td><b>Planta</b></td>
                  <td><?php echo $usu->nombre_planta ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6  col-sd-">
            <table class="table">
              <tbody>
                <tr>
                  <td><b>Dirección Planta</b></td>
                  <td><?php echo $usu->direccion_planta ?></td>
                </tr>
                <tr>
                  <td><b>Región Planta</b></td>
                  <td><?php echo $usu->region_planta ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <?php } ?>
        <?php } ?>
        <hr>
        <br>
        <div class="col-md-6">
          <h4><b><u>Datos del contrato</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="causal">Causal</label>
            <div class="controls">
                <?php 
                    $causal = isset($datos_req->causal)?$datos_req->causal:'';
              ?>
              <select name="causal" v-model="causal" id="causal" class="form-control"  >
          
              <option selected disabled value="">[Seleccione]</option>
                <option <?php if($causal == 'A') echo 'selected';?> value="A">A</option>
                <option <?php if($causal == 'B') echo 'selected';?> value="B">B</option>
                <option <?php if($causal == 'C') echo 'selected';?> value="C">C</option>
                <option <?php if($causal == 'D') echo 'selected';?> value="D">D</option>
                <option <?php if($causal == 'E') echo 'selected';?> value="E">E</option>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="motivo">Motivo</label>
            <div :class="'controls'+(descriptionError ? ' has-error': '')">
              <input type='text' class="form-control" name="motivo" v-model="motivo" id="motivo" value="<?php echo isset($datos_req->motivo)?$datos_req->motivo:$motivo_defecto ?>" />

            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="dia_fi">Fecha Inicio</label>
            <div class="controls">
             <?php
             $get_fi = isset($datos_req->fecha_inicio)?1:0;
             if($get_fi == 1){
              $f = explode('-', $datos_req->fecha_inicio);
              $dia_fi = $f[2];
              $mes_fi = $f[1];
              $ano_fi = $f[0];
            }else{
              $dia_fi = false;
              $mes_fi = false;
              $ano_fi = false;
            }
            ?>
           
            <select name="dia_fi" id="dia_fi" style="width: 33%;" >
              <option value="" >Dia</option>

              <?php 
                if ($dia_fi == false) {
                  $dia_fi = date('d');
                }
                  for($i=1;$i<32;$i++){ 
              ?>
              <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
            <?php //var_dump($mes_fi); ?>
            <select name="mes_fi" id="mes_fi" style="width: 33%;" >
              <option selected disabled value="">Mes</option>
              <?php 
                if ($mes_fi ==false) {
                  $mes_fi = date('m');
                  $bloqear = isset($mes_fi)?$mes_fi:false;
                }else{
                  $bloqear = isset($mes_fi)?$mes_fi:false;
                }

              ?>
              <option value='01' <?php if($bloqear!=false){if($mes_fi>'01'){echo '';}} echo ($mes_fi == '1')? "selected='selected'" : ''; ?>>Enero</option>
              <option value='02' <?php if($bloqear!=false){if($mes_fi>'02'){echo '';}} echo ($mes_fi == '2')? "selected='selected'" : '' ?>>Febrero</option>
              <option value='03' <?php if($bloqear!=false){if($mes_fi>'03'){echo '';}} echo ($mes_fi == '3')? "selected='selected'" : '' ?>>Marzo</option>
              <option value='04' <?php if($bloqear!=false){if($mes_fi>'04'){echo '';}} echo ($mes_fi == '4')? "selected='selected'" : '' ?>>Abril</option>
              <option value='05' <?php if($bloqear!=false){if($mes_fi>'05'){echo '';}} echo ($mes_fi == '5')? "selected='selected'" : '' ?>>Mayo</option>
              <option value='06' <?php if($bloqear!=false){if($mes_fi>'06'){echo '';}} echo ($mes_fi == '6')? "selected='selected'" : '' ?>>Junio</option>
              <option value='07' <?php if($bloqear!=false){if($mes_fi>'07'){echo '';}} echo ($mes_fi == '7')? "selected='selected'" : '' ?>>Julio</option>
              <option value='08' <?php if($bloqear!=false){if($mes_fi>'08'){echo '';}}  echo ($mes_fi == '8')? "selected='selected'" : '' ?>>Agosto</option>
              <option value='09' <?php if($bloqear!=false){if($mes_fi>'09'){echo '';}}  echo ($mes_fi == '9')? "selected='selected'" : '' ?>>Septiembre</option>
              <option value='10' <?php if($bloqear!=false){if($mes_fi>'10'){echo '';}}  echo ($mes_fi == '10')? "selected='selected'" : '' ?>>Octubre</option>
              <option value='11' <?php if($bloqear!=false){if($mes_fi>'11'){echo '';}}  echo ($mes_fi == '11')? "selected='selected'" : '' ?>>Noviembre</option>
              <option value='12' <?php if($bloqear!=false){if($mes_fi>'12'){echo '';}}  echo ($mes_fi == '12')? "selected='selected'" : '' ?>>Diciembre</option>
            </select>
            <select name="ano_fi" id="ano_fi" style="width: 32%;" >
              <option selected disabled value="">Año</option>
              <?php $tope_f = (date('Y') ); ?>
              <?php for($i=$tope_f;$i < (date('Y') + 2 ); $i++){ ?>
              <option value="<?php echo $i ?>" <?php if($ano_fi == false){$ano_fi =date('Y');} echo ($ano_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="dia_ft">Fecha Termino</label>
          <div class="controls">
            <?php
            $get_ft = isset($datos_req->fecha_termino)?1:0;
            if($get_ft == 1){
              $f = explode('-', $datos_req->fecha_termino);
              $dia_ft = $f[2];
              $mes_ft = $f[1];
              $ano_ft = $f[0];
            }else{
              $dia_ft = false;
              $mes_ft = false;
              $ano_ft = false;
            }

                if ($dia_ft == false) {
                  $dia_ft = date('d');
                }

            ?>

            <select name="dia_ft" id="dia_ft" style="width: 33%;">
              <option value="" >Dia</option>
              <?php for($i=1;$i<32;$i++){ ?>
              <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
            <select name="mes_ft" id="mes_ft" style="width: 33%;" >
              <option value="">Mes</option>
               <?php 
                if ($mes_ft ==false) {
                  $mes_ft = date('m');
                  $bloqear2 = isset($mes_ft)?$mes_ft:false;
                }else{
                  $bloqear2 = isset($mes_ft)?$mes_ft:false;
                }

              ?>
              <option value='01' <?php if($bloqear2!=false){if($mes_ft>'01'){echo '';}} echo ($mes_ft == '1')? "selected='selected'" : '' ?>>Enero</option>
              <option value='02' <?php if($bloqear2!=false){if($mes_ft>'02'){echo '';}} echo ($mes_ft == '2')? "selected='selected'" : '' ?>>Febrero</option>
              <option value='03' <?php if($bloqear2!=false){if($mes_ft>'03'){echo '';}} echo ($mes_ft == '3')? "selected='selected'" : '' ?>>Marzo</option>
              <option value='04' <?php if($bloqear2!=false){if($mes_ft>'04'){echo '';}} echo ($mes_ft == '4')? "selected='selected'" : '' ?>>Abril</option>
              <option value='05' <?php if($bloqear2!=false){if($mes_ft>'05'){echo '';}} echo ($mes_ft == '5')? "selected='selected'" : '' ?>>Mayo</option>
              <option value='06' <?php if($bloqear2!=false){if($mes_ft>'06'){echo '';}} echo ($mes_ft == '6')? "selected='selected'" : '' ?>>Junio</option>
              <option value='07' <?php if($bloqear2!=false){if($mes_ft>'07'){echo '';}} echo ($mes_ft == '7')? "selected='selected'" : '' ?>>Julio</option>
              <option value='08' <?php if($bloqear2!=false){if($mes_ft>'08'){echo '';}} echo ($mes_ft == '8')? "selected='selected'" : '' ?>>Agosto</option>
              <option value='09' <?php if($bloqear2!=false){if($mes_ft>'09'){echo '';}} echo ($mes_ft == '9')? "selected='selected'" : '' ?>>Septiembre</option>
              <option value='10' <?php if($bloqear2!=false){if($mes_ft>'10'){echo '';}} echo ($mes_ft == '10')? "selected='selected'" : '' ?>>Octubre</option>
              <option value='11' <?php if($bloqear2!=false){if($mes_ft>'11'){echo '';}} echo ($mes_ft == '11')? "selected='selected'" : '' ?>>Noviembre</option>
              <option value='12' <?php if($bloqear2!=false){if($mes_ft>'12'){echo '';}} echo ($mes_ft == '12')? "selected='selected'" : '' ?>>Diciembre</option>
            </select>
            <select name="ano_ft" id="ano_ft" style="width: 32%;">
              <option value="">Año</option>
              <?php $tope_f = (date('Y') ); ?>
              <?php for($i=$tope_f;$i < (date('Y') + 2 ); $i++){ ?>
              <option value="<?php echo $i ?>" <?php if($ano_ft == false){$ano_ft =date('Y');} echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="dia_ft">Fecha Pago</label>
          <div class="controls">
            <?php
            $get_fi = isset($datos_req->fecha_pago)?1:0;
            if($get_fi == 1){
              $f = explode('-', $datos_req->fecha_pago);
              $dia_fp = $f[2];
              $mes_fp = $f[1];
              $ano_fp = $f[0];
            }else{
              $dia_fp = false;
              $mes_fp = false;
              $ano_fp = false;
            }
            ?>
            <select name="dia_fp" id="dia_fp"  required style="width: 33%;">
              <option value="" >Dia</option>
              <?php for($i=1;$i<32;$i++){ ?>
              <option <?php echo ($dia_fp == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
            <?php 
                if ($mes_fp ==false) {
                  $mes_fp = date('m');
                  $bloqear3 = isset($mes_fp)?$mes_fp:false;
                }else{
                  $bloqear3 = isset($mes_fp)?$mes_fp:false;
                }

              ?>
            <select name="mes_fp" id="mes_fp" style="width: 33%;">
              <option value="">Mes</option>
              <option value='01' <?php if($bloqear3!=false){if($mes_fp>'01'){echo '';}} echo ($mes_fp == '1')? "selected='selected'" : '' ?>>Enero</option>
              <option value='02' <?php if($bloqear3!=false){if($mes_fp>'02'){echo '';}} echo ($mes_fp == '2')? "selected='selected'" : '' ?>>Febrero</option>
              <option value='03' <?php if($bloqear3!=false){if($mes_fp>'03'){echo '';}} echo ($mes_fp == '3')? "selected='selected'" : '' ?>>Marzo</option>
              <option value='04' <?php if($bloqear3!=false){if($mes_fp>'04'){echo '';}} echo ($mes_fp == '4')? "selected='selected'" : '' ?>>Abril</option>
              <option value='05' <?php if($bloqear3!=false){if($mes_fp>'05'){echo '';}} echo ($mes_fp == '5')? "selected='selected'" : '' ?>>Mayo</option>
              <option value='06' <?php if($bloqear3!=false){if($mes_fp>'06'){echo '';}} echo ($mes_fp == '6')? "selected='selected'" : '' ?>>Junio</option>
              <option value='07' <?php if($bloqear3!=false){if($mes_fp>'07'){echo '';}} echo ($mes_fp == '7')? "selected='selected'" : '' ?>>Julio</option>
              <option value='08' <?php if($bloqear3!=false){if($mes_fp>'08'){echo '';}} echo ($mes_fp == '8')? "selected='selected'" : '' ?>>Agosto</option>
              <option value='09' <?php if($bloqear3!=false){if($mes_fp>'09'){echo '';}} echo ($mes_fp == '9')? "selected='selected'" : '' ?>>Septiembre</option>
              <option value='10' <?php if($bloqear3!=false){if($mes_fp>'10'){echo '';}} echo ($mes_fp == '10')? "selected='selected'" : '' ?>>Octubre</option>
              <option value='11' <?php if($bloqear3!=false){if($mes_fp>'11'){echo '';}} echo ($mes_fp == '11')? "selected='selected'" : '' ?>>Noviembre</option>
              <option value='12' <?php if($bloqear3!=false){if($mes_fp>'12'){echo '';}} echo ($mes_fp == '12')? "selected='selected'" : '' ?>>Diciembre</option>
            </select>
            <select name="ano_fp" id="ano_fp" style="width: 32%;">
              <option value="">Año</option>
              <?php $tope_f = (date('Y')  ); ?>
              <?php for($i=$tope_f;$i < (date('Y') + 2 ); $i++){ ?>
              <option value="<?php echo $i ?>" <?php if($ano_fp == false){$ano_fp =date('Y');}  echo ($ano_fp == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="jornada">Jornada</label>
          <div class="controls">
            <?php $id_horario_antiguo = isset($datos_req->jornada)?$datos_req->jornada:''; ?>
            <select name="jornada" v-model="jornada" id="jornada" class="form-control" >
              <option value="">[Seleccione]</option>
              <?php foreach($listado_horarios as $lh){ ?>
              <option value="<?php echo $lh->id ?>" <?php if($lh->id == $id_horario_antiguo) echo "selected"; ?> ><?php echo $lh->nombre_horario ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
          <div class="controls">
            <?php $renta_anterior = isset($datos_req->renta_imponible)?$datos_req->renta_imponible:'0';  ?>
            <select class="form-control" name="renta_imponible" id="renta_imponible">
              <option value="15000" <?php if($renta_anterior == "15000") echo "selected"; ?> >$15.000</option>
              <option value="20000" <?php if($renta_anterior == "20000") echo "selected"; ?> >$20.000</option>
              <option value="25000" <?php if($renta_anterior == "25000") echo "selected"; ?> >$25.000</option>
              <option value="30000" <?php if($renta_anterior == "30000") echo "selected"; ?> >$30.000</option>
              <option value="35000" <?php if($renta_anterior == "35000") echo "selected"; ?> >$35.000</option>
              <option value="37000" <?php if($renta_anterior == "37000") echo "selected"; ?> >$37.000</option>
              <option value="40000" <?php if($renta_anterior == "40000") echo "selected"; ?> >$40.000</option>
              <option value="42000" <?php if($renta_anterior == "42000") echo "selected"; ?> >$42.000</option>
              <option value="45000" <?php if($renta_anterior == "45000") echo "selected"; ?> >$45.000</option>
              <option value="50000" <?php if($renta_anterior == "50000") echo "selected"; ?> >$50.000</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6">
       <h4><b><u>Tipo Contrato</u></b></h4>
       <div class="control-form">
        <label class="control-label" for="tipo_contrato">Tipo Contrato</label>
        <div class="controls">
          <?php $tipo_contrato_anterior = isset($datos_req->id_tipo_contrato)?$datos_req->id_tipo_contrato:'0'; ?>
          <label for="tipo_contrato1"><input type='radio'  name="tipo_contrato" id="tipo_contrato1" value="1" <?php if($tipo_contrato_anterior == 1 || $tipo_contrato_anterior== 0) echo "checked"; ?> /> Diario</label>
          <label for="tipo_contrato2"><input type='radio'  name="tipo_contrato" id="tipo_contrato2" value="2" <?php if($tipo_contrato_anterior == 2) echo "checked"; ?> /> Mensual</label>
        </div>
      </div>
      <h4><b><u>Bonos</u></b></h4>
      <div class="control-form">
        <label class="control-label" for="bono_gestion">Bono Gestión</label>
        <div class="controls">
          <input type='text' class="form-control" name="bono_gestion" id="bono_gestion" value="<?php echo isset($datos_req->bono_gestion)?$datos_req->bono_gestion:'0' ?>" />
        </div>
      </div>
      <div class="control-form">
        <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
        <div class="controls">
          <input type='text' class="form-control" name="asignacion_movilizacion" id="asignacion_movilizacion" value="<?php echo isset($datos_req->asignacion_movilizacion)?$datos_req->asignacion_movilizacion:'0' ?>" />
        </div>
      </div>
      <div class="control-form">
        <label class="control-label" for="asignacion_colacion">Asignación Colación</label>
        <div class="controls">
          <input type='text' class="form-control" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo isset($datos_req->asignacion_colacion)?$datos_req->asignacion_colacion:'0' ?>" />
        </div>
      </div>
      <div class="control-form">
        <label class="control-label" for="asignacion_zona">Asignación Zona</label>
        <div class="controls">
          <input type='text' class="form-control" name="asignacion_zona" id="asignacion_zona" value="<?php echo isset($datos_req->asignacion_zona)?$datos_req->asignacion_zona:'0' ?>" />
        </div>
      </div>
      <div class="control-form">
        <label class="control-label" for="viatico">Viatico</label>
        <div class="controls">
          <input type='text' class="form-control" name="viatico" id="viatico" value="<?php echo isset($datos_req->viatico)?$datos_req->viatico:'0' ?>" />
        </div>
      </div>
    </div>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br>
  <div class="modal_content">

    <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit"  name="actualizar" class="btn btn-primary">Agregar</button>

  </div>

</form>
</div>
