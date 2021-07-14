
<div id="app">

  <form action="<?php echo base_url() ?>carrera/requerimientos/guardar_nuevo_contrato_anexo_doc_contractual/<?php echo $usuario ?>/<?php echo $tipo ?>/<?php echo $asc_area ?>" role="form"  id="form2" method='post' name="f2" enctype="multipart/form-data">

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
           <!-- <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary ">
    <input type="radio" name="options" id="option1" autocomplete="off" > A
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option2" autocomplete="off"> B
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option3" autocomplete="off"> C
  </label>
    <label class="btn btn-primary ">
    <input type="radio" name="options" id="option1" autocomplete="off" > D
  </label>
    <label class="btn btn-primary ">
    <input type="radio" name="options" id="option1" autocomplete="off" > E
  </label>
</div>-->
            <label class="control-label" for="causal">Causal</label>
            <div class="controls">
                <?php 
                    $causal = isset($datos_req->causal)?$datos_req->causal:'';
              ?>
              <select name="causal" id="causal" class="form-control"  >
          
                <option selected disabled>[Seleccione]</option>
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
            <div >
              <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo isset($datos_req->motivo)?$datos_req->motivo:$motivo_defecto ?>" />

            </div>
          </div>
         <div class="row">
          <div class="control-form col-md-6">
            <label class="control-label" for="datepicker">Fecha Inicio</label>
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
            <input type="text" class="form-control" autocomplete="off" id="datepicker" name="fechaInicio" >

          </div>
        </div>
        <div class="control-form col-md-6">
          <label class="control-label" for="datepicker2">Fecha Termino</label>
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
            ?>
            <input type="text" class="form-control" autocomplete="off"  id="datepicker2" name="fechaTermino" >

           
          </div>
        </div>
        </div>
        <div class="row">
          <div class="control-form col-md-6"  v-if="vue.tipoContrato == '1'">
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
              <input type="text" class="form-control" autocomplete="off"  id="datepicker3" name="fechaPago" >
            </div>
          </div>
          <div class="control-form col-md-6">
            <label class="control-label" for="regimen">Regimen</label>
            <div class="controls">
                <select name="select_regimen" id="regimen" class="form-control" required>
                      <option value="">Seleccione...</option>
                      <option value="NL">Normal</option>
                      <option value="CTG">Contingencia</option>
                      <option value="URG">Urgencia</option>
                </select>
            </div>
          </div>

       </div>
        <div class="control-form">
          <label class="control-label" for="jornada">Jornada</label>
          <div class="controls">
            <?php $id_horario_antiguo = isset($datos_req->jornada)?$datos_req->jornada:''; ?>
            <select name="jornada"  id="jornada" class="form-control" >
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
                <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="<?php echo isset($datos_req->renta_imponible)?$datos_req->renta_imponible:'0' ?>" required/>
            </div>
          </div>
     
        <div class="control-form" v-else>
            <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
            <div class="controls">
                <input type='text' class="form-control" maxlength="6" name="renta_imponible" id="renta_imponible" value="<?php echo isset($datos_req->renta_imponible)?$datos_req->renta_imponible:'0' ?>"  required/>
            </div>
          </div>
        </div>

      <div class="col-md-6">
       <h4><b><u>Tipo Contrato</u></b></h4>
       <div class="control-form">
        <label class="control-label" for="tipo_contrato">Tipo Contrato</label>
        <div class="controls">
          <?php $tipo_contrato_anterior = isset($datos_req->id_tipo_contrato)?$datos_req->id_tipo_contrato:'0'; ?>
          <label for="tipo_contrato1"><input type='radio' v-model="vue.tipoContrato"  name="tipo_contrato" id="tipo_contrato1" value="1" <?php if($tipo_contrato_anterior == 1 || $tipo_contrato_anterior== 0) echo "checked"; ?> /> Diario</label>
          <label for="tipo_contrato2"><input type='radio' v-model="vue.tipoContrato"  name="tipo_contrato" id="tipo_contrato2" value="2" <?php if($tipo_contrato_anterior == 2) echo "checked"; ?> /> Mensual</label>
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
<script type="text/javascript">
  var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!',
    vue:{
        tipoContrato:1,
    },
  }
})
</script>

  <script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 //dateFormat: 'dd-mm-yy',
 dateFormat: 'yy-mm-dd',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
 ///$("#datepicker").attr( 'readOnly' , 'true' );
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
    $("#datepicker").datepicker({ /*minDate: 0,*/  duration: "slow"  });
    $("#datepicker2").datepicker({ /*minDate: 0,*/  duration: "slow" });
    $("#datepicker3").datepicker({ /*minDate: 0,*/  duration: "slow" });
});
</script>