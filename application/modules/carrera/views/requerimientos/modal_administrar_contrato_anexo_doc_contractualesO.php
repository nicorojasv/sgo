<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimientos/actualizar_contrato_anexo_doc_contractual/<?php echo $id_usu_arch?>/<?php echo $id_area_cargo?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" onsubmit ="return bloqEnvio()" >
    <div id="modal_content">
      <?php
      if($datos_generales != FALSE){
        foreach($datos_generales as $usu){
       
          if ($usu->get_proceso_rechazado == 1) {
             $rechazado=1;
          }else
              $rechazado = 0;//si fue rechazado
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
            <input type="hidden" name="id_centro_costo" id="id_centro_costo" value="<?php echo $usu->id_centro_costo ?>">
            <input type="hidden"  name="nombre_centro_costo" id="nombre_centro_costo" value="<?php echo $usu->nombre_centro_costo ?>">
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
if($datos_usu_arch != FALSE){
  foreach ($datos_usu_arch as $row){
?>
    <div class="row">
      <div class="col-md-6 col-sd-6">
        <h4><b><u>Datos del contrato</u></b></h4>
        <div class="control-form">
          <label class="control-label" for="causal">Causal</label>
          <div class="controls">
            <input type="hidden" name="gc_causal" value="<?php echo $row->causal ?>">
            <select name="causal" id="causal" class="form-control" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
            <?php 
                    $causal = isset($row->causal)?$row->causal:'';
              ?>
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
          <div class="controls">
            <input type="hidden" name="gc_motivo" value="<?php echo $row->motivo ?>">
            <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo $row->motivo?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
          </div>
        </div>
        <div class="row">
        <div class="control-form col-md-6">
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
            }

             ?>
             <input type="text" class="form-control" autocomplete="off" id="datepicker" value="<?php echo $row->fecha_inicio?>" name="fechaInicio" <?php if($estado_bloqueo == "si") echo "disabled"; ?>>
            <input type="hidden" name="gc_dia_fi" value="<?php echo $dia_fi ?>">
            <input type="hidden" name="gc_mes_fi" value="<?php echo $mes_fi ?>">
            <input type="hidden" name="gc_ano_fi" value="<?php echo $ano_fi ?>">

          </div>
        </div>
        <div class="control-form col-md-6">
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
            } 
             if ($dia_ft == false) {
                  $dia_ft = date('d');
                }

            ?>
             <input type="text" class="form-control" autocomplete="off" id="datepicker2" value="<?php echo $row->fecha_termino?>" name="fechaTermino" <?php if($estado_bloqueo == "si") echo "disabled"; ?>>
            <input type="hidden" name="gc_dia_ft" value="<?php echo $dia_ft ?>">         
            <input type="hidden" name="gc_mes_ft" value="<?php echo $mes_ft ?>">
            <input type="hidden" name="gc_ano_ft" value="<?php echo $ano_ft ?>">
          </div>
        </div>
      </div>
      <div class="row">
      <?php 
         if($row->id_tipo_contrato == 1){
      ?>
        <div class="control-form col-md-6">
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
            }
            ?>
            <input type="text" class="form-control" autocomplete="off" value="<?php echo $row->fecha_pago?>"  id="datepicker3" name="fechaPago" <?php if($estado_bloqueo == "si") echo "disabled"; ?>>
            <input type="hidden" name="gc_dia_fp" value="<?php echo $dia_fp ?>">            
            <input type="hidden" name="gc_mes_fp" value="<?php echo $mes_fp ?>">           
            <input type="hidden" name="gc_ano_fp" value="<?php echo $ano_fp ?>">
          </div>
        </div>
      <?php
        }
      ?>
          <div class="control-form col-md-6">
            <label class="control-label" for="regimen">Regimen</label>
            <div class="controls">
                <select name="select_regimen" id="regimen" class="form-control" required <?php if($estado_bloqueo == "si") echo "disabled"; ?>>
                      <option value="">Seleccione...</option>
                      <option <?php if($row->regimen=='NL')echo "selected"; ?>  value="NL">Normal</option>
                      <option <?php if($row->regimen=='CTG')echo "selected"; ?> value="CTG">Contingencia</option>
                      <option <?php if($row->regimen=='URG')echo "selected"; ?> value="URG">Urgencia</option>
                </select>
            </div>
          </div>
    </div>
        <div class="control-form">
          <label class="control-label" for="jornada">Jornada/Turno</label>
          <div class="controls">
            <input type="hidden" name="gc_jornada" value="<?php echo $row->jornada ?>">
            <select name="jornada" id="jornada" class="form-control" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
              <option selected  value="">[Seleccione]</option>
              <?php foreach($listado_horarios as $lh){ ?>
              <option value="<?php echo $lh->id ?>" <?php if($row->jornada == $lh->id) echo "selected" ?>><?php echo $lh->nombre_horario ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <?php if($row->id_tipo_contrato == 1){ ?>
        <div class="control-form">
          <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
          <div class="controls">
            <input type='hidden' name="gc_renta_imponible" value="<?php echo $row->renta_imponible?>"/>
            <select class="form-control" name="renta_imponible" id="renta_imponible" <?php if($estado_bloqueo == "si") echo "disabled"; ?>>
              <option value="15000" <?php if($row->renta_imponible == "15000") echo "selected"; ?> >$15.000</option>
              <option value="16500" <?php if($row->renta_imponible == "16500") echo "selected"; ?> >$16.500</option>
              <option value="18000" <?php if($row->renta_imponible == "18000") echo "selected"; ?> >$18.000</option>
              <option value="20000" <?php if($row->renta_imponible == "20000") echo "selected"; ?> >$20.000</option>
              <option value="25000" <?php if($row->renta_imponible == "25000") echo "selected"; ?> >$25.000</option>
              <option value="30000" <?php if($row->renta_imponible == "30000") echo "selected"; ?> >$30.000</option>
              <option value="35000" <?php if($row->renta_imponible == "35000") echo "selected"; ?> >$35.000</option>
              <option value="40000" <?php if($row->renta_imponible == "40000") echo "selected"; ?> >$40.000</option>
              <option value="45000" <?php if($row->renta_imponible == "45000") echo "selected"; ?> >$45.000</option>
              <option value="50000" <?php if($row->renta_imponible == "50000") echo "selected"; ?> >$50.000</option>
            </select>
          </div>
        </div>
      <?php }else{ ?>
        <div class="control-form">
           <input type='hidden' name="gc_renta_imponible" value="<?php echo $row->renta_imponible?>"/>
            <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
            <div class="controls">
                <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="<?php echo isset($row->renta_imponible)?$row->renta_imponible:'0' ?>"  required/>
            </div>
          </div>
           
      <?php }?>
      </div>
      <div class="col-md-6 col-sd-6">
        <h4><b><u>Tipo Contrato</u></b></h4>
        <div class="control-form">
          <label class="control-label" for="tipo_contrato">Tipo Contrato</label>
          <div class="controls">
            <input type='hidden' name="gc_tipo_contrato" value="<?php echo $row->id_tipo_contrato ?>"/>
            <label for="tipo_contrato1"><input type='radio' name="tipo_contrato" id="tipo_contrato1" value="1" <?php if($row->id_tipo_contrato == 1){echo "checked";}else{ echo "disabled";} ?> <?php if($estado_bloqueo == "si") echo "disabled"; ?> /> Diario</label>
            <label for="tipo_contrato2"><input type='radio' name="tipo_contrato" id="tipo_contrato2" value="2" <?php if($row->id_tipo_contrato == 2){echo "checked";}else{echo "disabled";}?> <?php if($estado_bloqueo == "si") echo "disabled"; ?> /> Mensual</label>
          </div>
        </div>
        <h4><b><u>Bonos</u></b></h4>
        <div class="control-form">
          <label class="control-label" for="bono_gestion">Bono Gestión</label>
          <div class="controls">
            <input type='hidden' name="gc_bono_gestion" value="<?php echo $row->bono_gestion ?>"/>
            <input type='text' class="form-control" name="bono_gestion" id="bono_gestion" value="<?php echo $row->bono_gestion ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
          <div class="controls">
            <input type='hidden' name="gc_asignacion_movilizacion" value="<?php echo $row->asignacion_movilizacion ?>"/>
            <input type='text' class="form-control" name="asignacion_movilizacion" id="asignacion_movilizacion" value="<?php echo $row->asignacion_movilizacion ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="asignacion_colacion">Asignación Colación</label>
          <div class="controls">
            <input type='hidden' name="gc_asignacion_colacion" value="<?php echo $row->asignacion_colacion ?>"/>
            <input type='text' class="form-control" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo $row->asignacion_colacion ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="asignacion_zona">Asignación Zona</label>
          <div class="controls">
            <input type='hidden' name="gc_asignacion_zona" value="<?php echo $row->asignacion_zona ?>"/>
            <input type='text' class="form-control" name="asignacion_zona" id="asignacion_zona" value="<?php echo $row->asignacion_zona ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="viatico">Viático</label>
          <div class="controls">
            <input type='hidden' name="gc_viatico" value="<?php echo $row->viatico ?>"/>
            <input type='text' class="form-control" name="viatico" id="viatico" value="<?php echo $row->viatico ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
          </div>
        </div>
      </div>
    </div>
    <br><br>
    <div class="modal_content">
      <div class="row" >
        <div class="col-md-6">
          <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" name="actualizar" class="btn btn-primary" <?php if($estado_bloqueo == "si") echo "disabled"; ?> >Editar</button>
        </div>
        <div class="col-md-6" style="text-align: center" id="blw">
          <?php if($usu->get_proceso_aprobado == 1){ ?>
          <button type="submit" name="generar_contrato" class="btn btn-green">Generar Contrato</button>
          <button type="submit" name="generar_doc_adicionales_contrato" class="btn btn-green">Generar Doc. Adicionales</button>
          <?php
            if($row->id_tipo_contrato == 1){
          ?>
          <button type="submit" name="generar_finiquito_diario" class="btn btn-green">Generar Finiquito</button>
          <?php } ?>
          <br>
          <?php }elseif($usu->get_proceso_val_contr == 1){ ?>
          <button type="button" class="btn btn-red">Solicitud de contrato ya enviada...</button>
          <br>
          <?php }else{ ?>
          <?php if($rechazado == 1 && !empty($usu->comentarios))echo " <b>Observacion:</b> ".$usu->comentarios; ?>
            <?php 
              if ($bloqueo_solicitud == true) {
            ?>
                
                <label class="form-control">Trabajador con contrato en espera de baja</label>
            <?php 
              }else{
                if ($total == false) {
            ?>
                <label disabled>No es posible solicitar contrato <br>No se permite que una persona tenga un séptimo contrato diario  de forma consecutiva</label>
            <?php
              }else if($contratoHoy){ ?>  

                <label disabled>No es posible solicitar contrato <br>No se permite que una persona tenga mas de 1 contrato diario.</label>
                <?php 

                  foreach ($contratoHoy as $key ) {
                ?>
                    <label>Puede ver el contrato vigente <a href="<?php echo base_url()?>carrera/requerimientos/contratos_req_trabajador/<?php echo $key->idUsuario."/".$key->id."/".$key->idAreaCargo ?>">aquí</a></label>
                <?php      
                  }
                ?>

            <?php
                }else{
            ?>
                  <button type="submit" id="btnEviarRevision" name="envio_solicitud_contrato"  class=" <?php if($rechazado == 1) echo "btn btn-orange"; else echo "btn btn-green" ?>"><?php if($rechazado == 1) echo "Solicitud anterior rechazada, volver a enviar solicitud"; else echo "Enviar solicitud de revision de contrato"; ?></button>
            <?php 
                } 
              }

            } 
          ?>
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
$.datepicker.setDefaults($.datepicker.regional['es']);
$(function () {
$("#datepicker").datepicker();
$("#datepicker2").datepicker();
$("#datepicker3").datepicker();
});
</script>