<div id="modal">
  <div id="modal_content">
    <form action="<?php echo base_url() ?>carrera/contratos/rechazar_contrato_anexo_doc_general" method='post' enctype="multipart/form-data">
    <input type="hidden" name="id_usu_arch" value="<?php echo $id_usu_arch ?>">
    <?php if($datos_generales != FALSE){ ?>
      <?php foreach ($datos_generales as $usu){ ?>
        <div class="row">
          <div class="col-md-6 col-sd-6">
            <h5><b><u>Datos trabajador:</u></b></h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><b>Nombres</b></td>
                  <td>
                    <?php echo titleCase($usu->nombres_apellidos) ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Rut</b></td>
                  <td>
                    <?php echo $usu->rut ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Estado Civil</b></td>
                  <td>
                    <?php echo $usu->estado_civil ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Fecha Nacimiento</b></td>
                  <td>
                    <?php echo $usu->fecha_nac ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Domicilio</b></td>
                  <td>
                    <?php echo $usu->domicilio ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Ciudad</b></td>
                  <td>
                    <?php echo $usu->ciudad ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Previsión</b></td>
                  <td>
                    <?php echo $usu->prevision ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Salud</b></td>
                  <td>
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
                    <?php if($usu->referido == 1) echo "SI"; else echo "NO";  ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Puesto de trabajo/Cargo</b></td>
                  <td>
                    <?php echo $usu->cargo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Area Trabajo</b></td>
                  <td>
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
                    <?php echo $usu->nivel_estudios ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Teléfono</b></td>
                  <td>
                    <?php echo $usu->telefono ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Nacionalidad</b></td>
                  <td>
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
                    <?php echo $usu->nombre_centro_costo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Rut</b></td>
                  <td>
                    <?php echo $usu->rut_centro_costo ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Planta</b></td>
                  <td>
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
                    <?php echo $usu->direccion_planta ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Comuna Planta</b></td>
                  <td>
                    <?php echo $usu->ciudad_planta ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Región Planta</b></td>
                  <td>
                    <?php echo $usu->region_planta ?>
                  </td>
                </tr>
                <tr>
                  <td><b>Tipo Gratificación Planta</b></td>
                  <td>
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
          if ($datos_usu_arch != FALSE){
            foreach ($datos_usu_arch as $row){
        ?>
      <div class="row">
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Datos del contrato</u></b></h4>
          <div class="control-form">
            <label class="control-label">Causal</label>
            <div class="controls">
              <?php echo $row->causal ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Motivo</label>
            <div class="controls">
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
              <select name="dia_ft" id="dia_ft" style="width: 33%;" disabled>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_ft" id="mes_ft" style="width: 33%;" disabled>
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
              <select name="ano_ft" id="ano_ft" style="width: 32%;" disabled>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
           </div>
          </div>
          <div class="control-form">
            <label class="control-label">Jornada/Turno</label>
            <div class="controls">
              <select class="form-control" disabled>
                <option value="">[Seleccione]</option>
                <?php foreach($horarios_planta as $hp){ ?>
                <option value="<?php echo $hp->id ?>" <?php if($row->jornada == $hp->id) echo "selected"; ?> ><?php echo $hp->nombre_horario ?></option>
                <?php } ?>
                <option value="1" <?php if($row->jornada == '1') echo "selected"; ?> >Sin Horario</option>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Sueldo Base de la Liquidación</label>
            <div class="controls">
              <?php echo $row->renta_imponible ?>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Bonos</u></b></h4>
          <div class="control-form">
            <label class="control-label">Bono Responsabilidad</label>
            <div class="controls">
              <?php echo $row->bono_responsabilidad ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Bono Gestión</label>
            <div class="controls">
              <?php echo $row->bono_gestion ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Bono Confianza</label>
            <div class="controls">
              <?php echo $row->bono_confianza ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
            <div class="controls">
              <?php echo $row->asignacion_movilizacion ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Asignación Colación</label>
            <div class="controls">
              <?php echo $row->asignacion_colacion ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Asignación Zona</label>
            <div class="controls">
              <?php echo $row->asignacion_zona ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Asignación de Herramientas</label>
            <div class="controls">
              <?php echo $row->asignacion_herramientas ?>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label">Viático</label>
            <div class="controls">
              <?php echo $row->viatico ?>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sd-12">
          <h4><b><u>Observaciones</u></b></h4>
          <div class="control-form">
            <div class="controls">
              <textarea name="observaciones" class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal_content">
        <div class="row">
          <div class="col-md-6">
            <br><br>
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" name="rechazar" class="btn btn-green">Rechazar</button>
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