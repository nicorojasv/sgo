<script>
function calcularDias(){
  var date1 = new Date(document.getElementById("fecha_inicio").value);
  var date2 = new Date(document.getElementById("fecha_termino").value);
  var timeDiff = Math.abs(date2.getTime() - date1.getTime());
  var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1);
//alert(diffDays);
document.getElementById("resultado").value = diffDays;
}
</script>
<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimiento/guardar_doc_contractual_general/<?php echo $usuario?>/<?php echo $tipo?>/<?php echo $asc_area?>/<?php echo $id_req ?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
    <input type='hidden' name="datos_extras" id="datos_extras" value="SI"/>
    <div id="modal_content">
      <div class="row">
        <div class="col-md-6  col-sd-6">
          <h5><b><u>Datos trabajador:</u></b></h5>
          <table class="table">
            <tbody>
              <tr>
                <td>Nombres</td>
                <td><!--id req usuario archivo: <?php echo $id_usu_arch ?>--></td>
              </tr>
              <tr>
                <td>Rut</td>
                <td><!--id req: <?php echo $id_area_cargo ?>--></td>
              </tr>
              <tr>
                <td>Estado Civil</td>
                <td></td>
              </tr>
              <tr>
                <td>Fecha Nacim.</td>
                <td></td>
              </tr>
              <tr>
                <td>Domicilio</td>
                <td></td>
              </tr>
              <tr>
                <td>Comuna</td>
                <td></td>
              </tr>
              <tr>
                <td>Previsión</td>
                <td></td>
              </tr>
              <tr>
                <td>Salud</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6  col-sd-6">
          <h5><b><u>Datos adicionales:</u></b></h5>
          <table class="table">
            <tbody>
              <tr>
                <td>Referido</td>
                <td></td>
              </tr>
              <tr>
                <td>Puesto de trabajo/Cargo</td>
                <td></td>
              </tr>
              <tr>
                <td>Area Trabajo</td>
                <td></td>
              </tr>
              <tr>
                <td>Centro de Costo</td>
                <td></td>
              </tr>
              <tr>
                <td>Nivel Educacional</td>
                <td></td>
              </tr>
              <tr>
                <td>Teléfono</td>
                <td></td>
              </tr>
              <tr>
                <td>Nacionalidad</td>
                <td></td>
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
                <td>Razón Social</td>
                <td></td>
              </tr>
              <tr>
                <td>Rut</td>
                <td></td>
              </tr>
              <tr>
                <td>Planta</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-md-6  col-sd-">
          <table class="table">
            <tbody>
              <tr>
                <td>Dirección Planta</td>
                <td></td>
              </tr>
              <tr>
                <td>Región Planta</td>
                <td></td>
              </tr>
              <tr>
                <td>Tipo Gratificación Planta</td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <br>
      <div class="col-md-6">
        <h4><b><u>Datos del contrato</u></b></h4>
        <div class="control-form">
          <label class="control-label" for="causal">Causal</label>
          <div class="controls">
            <?php
            if ($datos_req != FALSE){
              foreach ($datos_req as $row){
                ?>
                <select name="causal" id="causal" class="form-control" required>
                  <option value="<?php echo $row->causal ?>"><?php echo $row->causal ?></option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                  <option value="E">E</option>
                </select>
                <?php
              }
            }else{
             ?>
             <select name="causal" id="causal" class="form-control" required>
              <option value="<?php echo $causal_defecto ?>"><?php echo $causal_defecto ?></option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
            </select>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="control-form">
        <label class="control-label" for="motivo">Motivo</label>
        <div class="controls">
          <?php
          if ($datos_req != FALSE){
            foreach ($datos_req as $row){
              ?>
              <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo $row->motivo?>" required/>
              <?php
            }
          }else{
           ?>
           <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo $motivo_defecto ?>" required/>
           <?php
         }
         ?>
       </div>
     </div>
          <!--
          <div class="control-group">
            <label class="control-label" for="inputTipo">Documento</label>
            <div class="controls">
              <?php
                //if ($datos_req != FALSE){
                  //foreach ($datos_req as $row){
              ?>
              <a href="<?php echo base_url().$row->url ?>" style="color:green" target="_blank"><?php echo $row->nombre ?></a><br>
              <?php
              //}
              //}else{
              //}
            ?>
              <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i>
                <input type="file" name="documento">
              </span>
            </div>
          </div>
        -->
        <div class="control-form">
          <label class="control-label" for="dia_fi">Fecha Inicio</label>
          <div class="controls">
           <?php
           if ($datos_req != FALSE){
            foreach ($datos_req as $row){
              ?>
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
              <select name="dia_fi" id="dia_fi" style="width: 33%;" required>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fi" id="mes_fi" style="width: 33%;" required>
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
              <select name="ano_fi" id="ano_fi" style="width: 32%;" required>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                <option value="<?php echo $i ?>" <?php echo ($ano_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <!--<input type='text' class="input-mini" name="fecha_inicio" id="fecha_inicio" value="<?php echo $row->fecha_inicio?>" required/>-->
              <?php } }else{ ?>
              <select name="dia_fi" id="dia_fi" style="width: 33%;" required>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fi" id="mes_fi" style="width: 33%;" required>
                <option value="">Mes</option>
                <option value='01'>Enero</option>
                <option value='02'>Febrero</option>
                <option value='03'>Marzo</option>
                <option value='04'>Abril</option>
                <option value='05'>Mayo</option>
                <option value='06'>Junio</option>
                <option value='07'>Julio</option>
                <option value='08'>Agosto</option>
                <option value='09'>Septiembre</option>
                <option value='10'>Octubre</option>
                <option value='11'>Noviembre</option>
                <option value='12'>Diciembre</option>
              </select>
              <select name="ano_fi" id="ano_fi" style="width: 32%;" required>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
              </select>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="dia_ft">Fecha Termino</label>
          <div class="controls">
            <?php
            if ($datos_req != FALSE){
              foreach ($datos_req as $row){
                ?>
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
                <select name="dia_ft" id="dia_ft" style="width: 33%;">
                  <option value="" >Dia</option>
                  <?php for($i=1;$i<32;$i++){ ?>
                  <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                  <?php } ?>
                </select>
                <select name="mes_ft" id="mes_ft" style="width: 33%;">
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
                <select name="ano_ft" id="ano_ft" style="width: 32%;">
                  <option value="">Año</option>
                  <?php $tope_f = (date('Y') - 5 ); ?>
                  <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                  <?php } ?>
                </select>
                <?php
              }
            }else{
             ?>
             <select name="dia_ft" id="dia_ft" style="width: 33%;">
              <option value="00" >Dia</option>
              <?php for($i=1;$i<32;$i++){ ?>
              <option><?php echo $i ?></option>
              <?php } ?>
            </select>
            <select name="mes_ft" id="mes_ft" style="width: 33%;">
              <option value="00">Mes</option>
              <option value='01'>Enero</option>
              <option value='02'>Febrero</option>
              <option value='03'>Marzo</option>
              <option value='04'>Abril</option>
              <option value='05'>Mayo</option>
              <option value='06'>Junio</option>
              <option value='07'>Julio</option>
              <option value='08'>Agosto</option>
              <option value='09'>Septiembre</option>
              <option value='10'>Octubre</option>
              <option value='11'>Noviembre</option>
              <option value='12'>Diciembre</option>
            </select>
            <select name="ano_ft" id="ano_ft" style="width: 32%;">
              <option value="0000">Año</option>
              <?php $tope_f = (date('Y') - 5 ); ?>
              <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php } ?>
            </select>
            <?php
          }
          ?>
        </div>
      </div>
          <!--<div class="control-form">
            <label class="control-label" for="inputTipo"><b>Dias Duración Contrato</b></label>
            <div class="controls">
              <input type="text" name="resultado" id="resultado" disabled>
            </div>
          </div>-->
          <div class="control-form">
            <label class="control-label" for="jornada">Jornada</label>
            <div class="controls">
              <?php
              if ($datos_req != FALSE){
                foreach ($datos_req as $row){
                  ?>
                  <select name="jornada" id="jornada" class="form-control" required>
                    <option value="">[Seleccione]</option>
                    <option value="Administrativa" <?php if($row->jornada == "Administrativa") echo "selected" ?> >Administrativa</option>
                    <option value="Turno" <?php if($row->jornada == "Turno") echo "selected" ?> >Turno</option>
                    <option value="Sin Horario" <?php if($row->jornada == "Sin Horario") echo "selected" ?> >Sin Horario</option>
                    <!--<option value="Otra Opcion">Otra Opcion</option>-->
                  </select>
                  <?php
                }
              }else{
               ?>
               <select name="jornada" id="jornada" class="form-control" required>
                <option value="">[Seleccione]</option>
                <option value="Administrativa">Administrativa</option>
                <option value="Turno">Turno</option>
                <option value="Sin Horario">Sin Horario</option>
              </select>
              <?php
            }
            ?>
          </div>
        </div>
        <div class="control-form">
          <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
          <div class="controls">
            <?php
            if ($datos_req != FALSE){
              foreach ($datos_req as $row){
                ?>
                <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="<?php echo $row->renta_imponible?>" required/>
                <?php
              }
            }else{
             ?>
             <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="" required/>
             <?php
           }
           ?>
         </div>
       </div>
     </div>
     <div class="col-md-6">
      <h4><b><u>Bonos</u></b></h4>
      <div class="control-form">
        <label class="control-label" for="bono_responsabilidad">Bono Responsabilidad</label>
        <div class="controls">
          <?php
          if ($datos_req != FALSE){
            foreach ($datos_req as $row){
              ?>
              <input type='text' class="form-control" name="bono_responsabilidad" id="bono_responsabilidad" value="<?php echo $row->bono_responsabilidad ?>" required/>
              <?php
            }
          }else{
           ?>
           <input type='text' class="form-control" name="bono_responsabilidad" id="bono_responsabilidad" value="" required/>
           <?php
         }
         ?>
       </div>
     </div>
     <div class="control-form">
      <label class="control-label" for="bono_gestion">Bono Gestión</label>
      <div class="controls">
        <?php
        if ($datos_req != FALSE){
          foreach ($datos_req as $row){
            ?>
            <input type='text' class="form-control" name="bono_gestion" id="bono_gestion" value="<?php echo $row->bono_gestion ?>" required/>
            <?php
          }
        }else{
         ?>
         <input type='text' class="form-control" name="bono_gestion" id="bono_gestion" value="" required/>
         <?php
       }
       ?>
     </div>
   </div>
   <div class="control-form">
    <label class="control-label" for="bono_confianza">Bono Confianza</label>
    <div class="controls">
      <?php
      if ($datos_req != FALSE){
        foreach ($datos_req as $row){
          ?>
          <input type='text' class="form-control" name="bono_confianza" id="bono_confianza" value="<?php echo $row->bono_confianza ?>" required/>
          <?php
        }
      }else{
       ?>
       <input type='text' class="form-control" name="bono_confianza" id="bono_confianza" value="" required/>
       <?php
     }
     ?>
   </div>
 </div>
 <div class="control-form">
  <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
  <div class="controls">
    <?php
    if ($datos_req != FALSE){
      foreach ($datos_req as $row){
        ?>
        <input type='text' class="form-control" name="asignacion_movilizacion" id="asignacion_movilizacion" value="<?php echo $row->asignacion_movilizacion ?>" required/>
        <?php
      }
    }else{
     ?>
     <input type='text' class="form-control" name="asignacion_movilizacion" id="asignacion_movilizacion" value="" required/>
     <?php
   }
   ?>
 </div>
</div>
<div class="control-form">
  <label class="control-label" for="asignacion_colacion">Asignación Colación</label>
  <div class="controls">
    <?php
    if ($datos_req != FALSE){
      foreach ($datos_req as $row){
        ?>
        <input type='text' class="form-control" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo $row->asignacion_colacion ?>" required/>
        <?php
      }
    }else{
     ?>
     <input type='text' class="form-control" name="asignacion_colacion" id="asignacion_colacion" value="" required/>
     <?php
   }
   ?>
 </div>
</div>
<div class="control-form">
  <label class="control-label" for="asignacion_zona">Asignación Zona</label>
  <div class="controls">
    <?php
    if ($datos_req != FALSE){
      foreach ($datos_req as $row){
        ?>
        <input type='text' class="form-control" name="asignacion_zona" id="asignacion_zona" value="<?php echo $row->asignacion_zona ?>" required/>
        <?php
      }
    }else{
     ?>
     <input type='text' class="form-control" name="asignacion_zona" id="asignacion_zona" value="" required/>
     <?php
   }
   ?>
 </div>
</div>
<div class="control-form">
  <label class="control-label" for="viatico">Viatico</label>
  <div class="controls">
    <?php
    if ($datos_req != FALSE){
      foreach ($datos_req as $row){
        ?>
        <input type='text' class="form-control" name="viatico" id="viatico" value="<?php echo $row->viatico ?>" required/>
        <?php
      }
    }else{
     ?>
     <input type='text' class="form-control" name="viatico" id="viatico" value="" required/>
     <?php
   }
   ?>
 </div>
</div>
</div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="modal_content">
  <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
  <button type="submit" name="actualizar" class="btn btn-primary">Agregar</button>
</div>
</form>
</div>