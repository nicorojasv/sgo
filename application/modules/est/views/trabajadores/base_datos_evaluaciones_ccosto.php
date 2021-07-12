<script type="text/javascript">

function input_fecha_cobro_rango(){
  document.getElementById("fecha_cobro_inicio").disabled = false; 
  document.getElementById("fecha_cobro_termino").disabled = false; 
}

function input_fecha_cobro_todos(){
  document.getElementById("fecha_cobro_inicio").disabled = true; 
  document.getElementById("fecha_cobro_termino").disabled = true; 
}

function input_fecha_eva_rango(){
  document.getElementById("fecha_eval_inicio").disabled = false; 
  document.getElementById("fecha_eval_termino").disabled = false; 
}

function input_fecha_eva_todos(){
  document.getElementById("fecha_eval_inicio").disabled = true; 
  document.getElementById("fecha_eval_termino").disabled = true; 
}
</script>
<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
        <div class="col-md-2" align="left">
          <label style="color:green">Examen Cobrado</label>
          <br>
          <label style="color:red">Examen No Cobrado</label>
        </div>
        <div class="col-md-8" align="left">
          <form action="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto" method='post'>
            <table class="table">
              <tr>
                <td style="width:10%"><b>Centro Costo</b></td>
                <td style="width:10%">
                  <select name="centro_costo" id="centro_costo" required>
                    <option value="">[Seleccione]</option>
                    <?php foreach ($centro_de_costos as $cc){ ?>
                      <option value="<?php echo $cc->id ?>" <?php if($id_centro_costo == $cc->id) echo "selected" ?> ><?php echo $cc->nombre ?></option>
                    <?php } ?>
                    <option value="terceros" <?php if($id_centro_costo == "terceros") echo "selected" ?> >Terceros</option>
                    <option value="sin_cc" <?php if($id_centro_costo == "sin_cc") echo "selected" ?> >Propios sin centro de costo</option>
                    <option value="todos" <?php if($id_centro_costo == "todos") echo "selected" ?> >Todas las evaluaciones</option>
                  </select>
                </td>
                <td style="width:15%"><b>Fecha Evaluación</b></td>
                <td style="width:15%">
                  <input type="radio" name="radio_f_evaluacion" id="radio_f_evaluacion" value="rango_fecha" onclick="input_fecha_eva_rango()" <?php if($radio_f_evaluacion == "rango_fecha") echo "checked" ?> >Rango Fecha
                  <input type="radio" name="radio_f_evaluacion" id="radio_f_evaluacion" value="todos" onclick="input_fecha_eva_todos()" <?php if($radio_f_evaluacion == "todos" or $radio_f_evaluacion == NULL) echo "checked" ?> >Todos
                </td>
                <td style="width:25%">
                  <input type="text" name="fecha_eval_inicio" class="fecha_eval_inicio" id="fecha_eval_inicio" style="width:40%" onkeypress="return valida_cero_teclas(event)" style="width:62%" value="<?php echo $fecha_eval_inicio ?>" <?php if($radio_f_evaluacion == "todos" or $radio_f_evaluacion == NULL) echo "disabled" ?> required >
                  <input type="text" name="fecha_eval_termino" class="fecha_eval_termino" id="fecha_eval_termino" style="width:40%" onkeypress="return valida_cero_teclas(event)" style="width:62%" value="<?php echo $fecha_eval_termino ?>" <?php if($radio_f_evaluacion == "todos" or $radio_f_evaluacion == NULL) echo "disabled" ?> required >
                </td>
              </tr>
              <tr>
                <td style="width:10%"><b>Estado Examen</b></td>
                <td style="width:10%">
                  <select name="estado_examen" id="estado_examen" required>
                    <option value="todos" <?php if($estado_examen == "todos" or $estado_examen == NULL) echo "selected" ?> >Todos</option>
                    <option value="cobrados" <?php if($estado_examen == "cobrados") echo "selected" ?> >Cobrados</option>
                    <option value="no_cobrados" <?php if($estado_examen == "no_cobrados") echo "selected" ?> >No Cobrados</option>
                    <option value="no_informados" <?php if($estado_examen == "no_informados") echo "selected" ?> >No Informados</option>
                  </select>
                </td>
                <td style="width:15%"><b>Fecha Cobro</b></td>
                <td style="width:15%">
                  <input type="radio" name="radio_f_cobro" id="radio_f_cobro" onclick="input_fecha_cobro_rango()" value="rango_fecha" <?php if($radio_f_cobro == "rango_fecha") echo "checked" ?> >Rango Fecha
                  <input type="radio" name="radio_f_cobro" id="radio_f_cobro" onclick="input_fecha_cobro_todos()" value="todos" <?php if($radio_f_cobro == "todos" or $radio_f_cobro == NULL) echo "checked" ?> >Todos
                </td>
                <td style="width:25%">
                  <input type="text" name="fecha_cobro_inicio" class="fecha_cobro_inicio" id="fecha_cobro_inicio" style="width:40%" onkeypress="return valida_cero_teclas(event)" style="width:62%" value="<?php echo $fecha_cobro_inicio ?>" <?php if($radio_f_cobro == "todos" or $radio_f_cobro == NULL) echo "disabled" ?> required >
                  <input type="text" name="fecha_cobro_termino" class="fecha_cobro_termino" id="fecha_cobro_termino" style="width:40%" onkeypress="return valida_cero_teclas(event)" style="width:62%" value="<?php echo $fecha_cobro_termino ?>" <?php if($radio_f_cobro == "todos" or $radio_f_cobro == NULL) echo "disabled" ?> required >
                </td>
              </tr>
              <tr>
                <td><b>Tipo Evaluación</b></td>
                <td colspan="3"><input type="checkbox" name="eval_masso" id="eval_masso" value="eval_masso" <?php if($eval_masso != NULL) echo "checked"; ?> > Masso <input type="checkbox" name="eval_preocupacional" id="eval_preocupacional" value="eval_preocupacional" <?php if($eval_preocupacional != NULL) echo "checked"; ?> > Preocupacional <input type="checkbox" name="eval_psicologico" id="eval_psicologico" value="eval_psicologico" <?php if($eval_psicologico != NULL) echo "checked"; ?> > Psicologico</td>
                <td>
                  <input title="aplicar filtros seleccionados anteriormente" type="submit" class="btn btn-green btn-block" value="Aplicar Filtros">
                </td>
              </tr>
            </table>
          </form>
        </div>
        <div class="col-md-2" align="center">
          <form action="<?php echo base_url() ?>est/trabajadores/exportar_excel_evaluaciones" method="post" target="_blank" id="FormularioExportacion">
            <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="submit" class="botonExcel btn btn-primary btn-block" value="Exportar a Excel"><br>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" align="center">
          <table id="example1" style="font-size:12px">
            <thead>
              <th>N°</th>
              <th style="text-align:center; width:6%">Paterno</th>
              <th style="text-align:center; width:6%">Materno</th>
              <th style="text-align:center; width:10%">Nombres</th>
              <th style="text-align:center; width:8%">Rut</th>
              <th style="text-align:center; width:22%">Referido - Requerimientos</th>
              <th style="text-align:center; width:21%">Referido - Asiste- Masso - Valor</th>
              <th style="text-align:center;">Referido - Asiste- Examen Preoc. - Valor</th>
              <th style="text-align:center;">Examen Psicologico<br>Resultado - Tecnico/Supervisor - Fecha Evaluación</th>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->paterno,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->materno,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->nombres,'UTF-8')) ?></a><b/></td>
                <td><?php echo $rm->rut_usuario ?></td>
                <td>
                  <?php
                    foreach ($rm->datos_req as $key){
                      if($key->referido == 1){
                        $referido = "SI";
                      }elseif($key->referido == 0){
                        $referido = "NO";
                      }
                      echo $referido." - ".$key->nombre_req;
                      echo "<br>";
                    }
                  ?>
                </td>
                <td>
                  <?php
                    foreach ($rm->datos_masso as $key2){
                      if($key2->estado_cobro == 1){
                        $color_masso = "green";
                      }elseif($key2->estado_cobro == 0){
                        $color_masso = "red";
                      }else{
                        $color_masso = "";
                      }

                      if($key2->examen_referido == 1){
                        $examen_referido = "SI";
                      }elseif($key2->examen_referido == 0){
                        $examen_referido = "NO";
                      }

                      if($key2->asiste_examen == 1){
                        $asiste_examen = "SI";
                      }elseif($key2->asiste_examen == 0){
                        $asiste_examen = "NO";
                      }

                      echo "<a title='Editar Estado Examen' data-target='#ModalEditar' data-toggle='modal' href='".base_url()."est/trabajadores/editar_estado_examen_ccosto/".$key2->id_eval."/".$id_planta."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <label style='color:".$color_masso."' title='Fecha Inicio - Fecha Termino Masso - Valor Examen'>".$examen_referido." - ".$asiste_examen." - ".$key2->fecha_e." - ".$key2->fecha_v."<br>$".$key2->valor_examen." - ".$key2->ccosto."</label>";
                      echo "<br>";
                    }
                  ?>
                </td>
                <td>
                  <?php
                    foreach ($rm->datos_preo as $key3){
                      if($key3->estado_cobro == 1){
                        $color_preo = "green";
                      }elseif($key3->estado_cobro == 0){
                        $color_preo = "red";
                      }else{
                        $color_preo = "";
                      }

                      if($key3->examen_referido == 1){
                        $examen_referido2 = "SI";
                      }elseif($key3->examen_referido == 0){
                        $examen_referido2 = "NO";
                      }

                       if($key3->asiste_examen == 1){
                        $asiste_examen2 = "SI";
                      }elseif($key3->asiste_examen == 0){
                        $asiste_examen2 = "NO";
                      }
                      echo "<a title='Editar Estado Examen' data-target='#ModalEditar' data-toggle='modal' href='".base_url()."est/trabajadores/editar_estado_examen_ccosto/".$key3->id_eval."/".$id_planta."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <label style='color:".$color_preo."' title='Fecha Inicio - Fecha Termino Examen Preocupacional - Valor Examen'>".$examen_referido2." - ".$asiste_examen2." - ".$key3->fecha_e." - ".$key3->fecha_v."<br>$".$key3->valor_examen." - ".$key3->ccosto."</label>";
                      echo "<br>";
                    }
                  ?>
                </td>
                <td>
                  <?php
                    foreach ($rm->datos_examen_ps as $key4){
                      if($key4->estado_cobro == 1){
                        $color_ps = "green";
                      }elseif($key4->estado_cobro == 0){
                        $color_ps = "red";
                      }else{
                        $color_ps = "";
                      }

                      echo "<a title='Editar Estado Examen Psicologico' data-target='#ModalEditar' data-toggle='modal' href='".base_url()."est/trabajadores/mostrar_estado_examen_ps_ccosto/".$key4->id_evaluacion."/".$id_planta."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <label style='color:".$color_ps."' title='Resulta - Tecnico/Supervisor - Fecha Evaluacion Examen Psicologico'>".$key4->resultado." - ".$key4->tecnico_supervisor." - ".$key4->fecha_evaluacion."<br>".$key4->ccosto."</label>";
                      echo "<br>";
                    }
                  ?>
                </td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>

<!-- Modal Editar Datos de los Examenes-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!--<div id="divTableDataHolder" style="display:none">-->

<div id="divTableDataHolder" style="display:none">
  <meta content="charset=UTF-8"/>
  <table width="50%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="Exportar_a_Excel" style="border-collapse:collapse;">
  <!--<table border="1">-->
    <thead>
      <tr style="text-align:center">
        <th colspan="5">DATOS DEL TRABAJADOR</th>
        <th colspan="3">REQUERIMIENTOS</th>
        <th colspan="8">EXAMEN MASSO</th>
        <th colspan="8">EXAMEN PREOCUPACIONAL</th>
        <th colspan="6">EXAMEN PSICOLOGICO</th>
      </tr>
      <tr style="text-align:center">
        <th>/</th>
        <th>Ap. Paterno</th>
        <th>Ap. Materno</th>
        <th>Nombres</th>
        <th>Rut</th>
        <th>Centro Costo</th>
        <th>Referido</th>
        <th>Nombre</th>
        <th>Centro Costo</th>
        <th>Referido</th>
        <th>Asiste Examen</th>
        <th>Fecha Evaluacion</th>
        <th>Fecha Vigencia</th>
        <th>Valor $</th>
        <th>Estado Cobro</th>
        <th>Propio/Tercero</th>
        <th>Centro Costo</th>
        <th>Referido</th>
        <th>Asiste Examen</th>
        <th>Fecha Evaluacion</th>
        <th>Fecha Vigencia</th>
        <th>Valor $</th>
        <th>Estado Cobro</th>
        <th>Propio/Tercero</th>
        <th>Centro Costo</th>
        <th>Resultado</th>
        <th>Tecnico/Supervisor</th>
        <th>Fecha Evaluación</th>
        <th>Valor Examen $</th>
        <th>Estado Cobro</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; foreach($listado as $rm){  ?>
      <tr style="text-align:center">
        <td><?php echo $i ?></td>
        <td><b><?php echo ucwords(mb_strtolower($rm->paterno,'UTF-8')) ?><b/></td>
        <td><b><?php echo ucwords(mb_strtolower($rm->materno,'UTF-8')) ?><b/></td>
        <td><b><?php echo ucwords(mb_strtolower($rm->nombres,'UTF-8')) ?><b/></td>
        <td><?php echo $rm->rut_usuario ?></td>
        <td>
          <?php
            foreach ($rm->datos_req as $key){
              echo $key->ccosto;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_req as $key){
              if($key->referido == 0){
                $referido = "NO";
              }elseif($key->referido == 1){
                $referido = "SI";
              }
              echo $referido;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_req as $key){
              echo $key->nombre_req;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              echo $key2->ccosto;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              if($key2->examen_referido == 0){
                  $examen_referido = "NO";
                }elseif($key2->examen_referido == 1){
                  $examen_referido = "SI";
                }
              echo $examen_referido;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              if($key2->asiste_examen == 0){
                  $asiste_examen = "NO";
                }elseif($key2->asiste_examen == 1){
                  $asiste_examen = "SI";
                }
              echo $asiste_examen;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              echo $key2->fecha_e;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              echo $key2->fecha_v;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              echo $key2->valor_examen;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              if($key2->estado_cobro == 0){
                $estado_cobro_masso = "NO COBRADO";
              }elseif($key2->estado_cobro == 1){
                $estado_cobro_masso = "SI COBRADO";
              }elseif($key2->estado_cobro == 2){
                $estado_cobro_masso = "NO INFORMADO";
              }else{
                $estado_cobro_masso = "N/D";
              }
              echo $estado_cobro_masso;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              if($key2->pago == 0){
                $propio_tercero_masso = "PROPIO";
              }elseif($key2->pago == 1){
                $propio_tercero_masso = "TERCERO";
              }else{
                $propio_tercero_masso = "N/D";
              }
              echo $propio_tercero_masso;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              echo $key3->ccosto;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              if($key3->examen_referido == 0){
                $examen_referido2 = "NO";
              }elseif($key3->examen_referido == 1){
                $examen_referido2 = "SI";
              }
              echo $examen_referido2;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              if($key3->asiste_examen == 0){
                $asiste_examen2 = "NO";
              }elseif($key3->asiste_examen == 1){
                $asiste_examen2 = "SI";
              }
              echo $asiste_examen2;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              echo $key3->fecha_e;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              echo $key3->fecha_v;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              echo $key3->valor_examen;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              if($key3->estado_cobro == 0){
                $estado_cobro_preo = "NO COBRADO";
              }elseif($key3->estado_cobro == 1){
                $estado_cobro_preo = "SI COBRADO";
              }elseif($key3->estado_cobro == 2){
                $estado_cobro_preo = "NO INFORMADO";
              }else{
                $estado_cobro_preo = "N/D";
              }
              echo $estado_cobro_preo;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              if($key3->pago == 0){
                $propio_tercero_preo = "PROPIO";
              }elseif($key3->pago == 1){
                $propio_tercero_preo = "TERCERO";
              }else{
                $propio_tercero_preo = "N/D";
              }
              echo $propio_tercero_preo;
              echo "<br>";
            }
          ?>
        </td>
        <td>
        <?php
          foreach ($rm->datos_examen_ps as $key4){
            echo $key4->ccosto;
            echo "<br>";
          }
        ?>
        </td>
        <td>
        <?php
          foreach ($rm->datos_examen_ps as $key4){
            echo $key4->resultado;
            echo "<br>";
          }
        ?>
        </td>
        <td>
        <?php
          foreach ($rm->datos_examen_ps as $key4){
            echo $key4->tecnico_supervisor;
            echo "<br>";
          }
        ?>
        </td>
        <td>
        <?php
          foreach ($rm->datos_examen_ps as $key4){
            echo $key4->fecha_evaluacion;
            echo "<br>";
          }
        ?>
        </td>
        <td>
        <?php
          foreach ($rm->datos_examen_ps as $key4){
            echo $key4->valor_examen;
            echo "<br>";
          }
        ?>
        </td>
        <td>
        <?php
          foreach ($rm->datos_examen_ps as $key4){
            if($key4->estado_cobro == 0){
              $estado_cobro = "No Cobrado";
            }elseif($key4->estado_cobro == 1){
              $estado_cobro = "Cobrado";
            }else{
              $estado_cobro = "";
            }

            echo $estado_cobro;
            echo "<br>";
          }
        ?>
        </td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>