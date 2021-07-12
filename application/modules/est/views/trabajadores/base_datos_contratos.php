<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
        <div class="col-md-10" align="center">
          <h4 style='text-align:center;float:left;'><b>PLANTA: </b><?php echo $empresa_planta->nombre ?></h4>
          <label style="color:green">Examen Cobrado</label><br>
          <label style="color:red">Examen No Cobrado</label>
        </div>
        <div class="col-md-2" align="center">
          <input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel"><br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" align="center">
          <table id="example1">
            <thead>
              <th>N°</th>
              <th style="text-align:center; width:6%">Paterno</th>
              <th style="text-align:center; width:6%">Materno</th>
              <th style="text-align:center; width:10%">Nombres</th>
              <th style="text-align:center; width:8%">Rut</th>
              <!--<th style="text-align:center; width:22%">Referido - Requerimientos</th>-->
              <th style="text-align:center; width:21%">Referido - Asiste- Masso - Valor</th>
              <th style="text-align:center;">Referido - Asiste- Examen Preoc. - Valor</th>
              <th style="text-align:center;">Examen Psicologico<br>Resultado - Tecnico/Supervisor - F. Eval.</th>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->paterno,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->materno,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->nombres,'UTF-8')) ?></a><b/></td>
                <td><?php echo $rm->rut_usuario ?></td>
                <!--<td>
                  <?php
                    /*foreach ($rm->datos_req as $key){
                      if($key->referido == 1){
                        $referido = "SI";
                      }elseif($key->referido == 0){
                        $referido = "NO";
                      }
                      echo $referido." - ".$key->nombre_req;
                      echo "<br>";
                    }*/
                  ?>
                </td>-->
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

                      echo "<a title='Editar Estado Examen' data-target='#ModalEditar' data-toggle='modal' href='".base_url()."est/trabajadores/editar_estado_examen/".$key2->id_eval."/".$id_planta."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <label style='color:".$color_masso."' title='Fecha Inicio - Fecha Termino Masso - Valor Examen'>".$examen_referido." - ".$asiste_examen." - ".$key2->fecha_e." - ".$key2->fecha_v." - $".$key2->valor_examen."</label>";
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
                      echo "<a title='Editar Estado Examen' data-target='#ModalEditar' data-toggle='modal' href='".base_url()."est/trabajadores/editar_estado_examen/".$key3->id_eval."/".$id_planta."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <label style='color:".$color_preo."' title='Fecha Inicio - Fecha Termino Examen Preocupacional - Valor Examen'>".$examen_referido2." - ".$asiste_examen2." - ".$key3->fecha_e." - ".$key3->fecha_v." - $".$key3->valor_examen."</label>";
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

                      echo "<a title='Editar Estado Examen Psicologico' data-target='#ModalEditar' data-toggle='modal' href='".base_url()."est/trabajadores/editar_estado_examen_ps_ccosto/".$key4->id_evaluacion."/".$id_planta."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <label style='color:".$color_ps."' title='Resulta - Tecnico/Supervisor - Fecha Evaluacion Examen Psicologico'>".$key4->resultado." - ".$key4->tecnico_supervisor." - ".$key4->fecha_evaluacion."</label>";
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
  <table border="1">
    <thead>
      <tr style="text-align:center">
        <th colspan="5">DATOS DEL TRABAJADOR</th>
        <th></th>
        <th colspan="2">REQUERIMIENTOS</th>
        <th colspan="6">EXAMEN MASSO</th>
        <th colspan="6">EXAMEN PREOCUPACIONAL</th>
        <th colspan="5">EXAMEN PSICOLOGICO</th>
      </tr>
      <tr style="text-align:center">
        <th>/</th>
        <th>Ap. Paterno</th>
        <th>Ap. Materno</th>
        <th>Nombres</th>
        <th>Rut</th>
        <th>Planta</th>
        <th>Referido</th>
        <th>Nombre</th>
        <th>Referido</th>
        <th>Asiste Examen</th>
        <th>Fecha Evaluacion</th>
        <th>Fecha Vigencia</th>
        <th>Valor $</th>
        <th>Estado Cobro</th>
        <th>Referido</th>
        <th>Asiste Examen</th>
        <th>Fecha Evaluacion</th>
        <th>Fecha Vigencia</th>
        <th>Valor $</th>
        <th>Estado Cobro</th>
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
        <td><?php echo $empresa_planta->nombre ?></td>
        <td>
          <?php
            foreach ($rm->datos_req as $key){
              if($key->referido == 1){
                $referido = "SI";
              }elseif($key->referido == 0){
                $referido = "NO";
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
              if($key2->examen_referido == 1){
                  $examen_referido = "SI";
                }elseif($key2->examen_referido == 0){
                  $examen_referido = "NO";
                }
              echo $examen_referido;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_masso as $key2){
              if($key2->asiste_examen == 1){
                  $asiste_examen = "SI";
                }elseif($key2->asiste_examen == 0){
                  $asiste_examen = "NO";
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
              if($key2->estado_cobro == 1){
                $estado_cobro_masso = "SI COBRADO";
              }elseif($key2->estado_cobro == 0){
                $estado_cobro_masso = "NO COBRADO";
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
            foreach ($rm->datos_preo as $key3){
              if($key3->examen_referido == 1){
                $examen_referido2 = "SI";
              }elseif($key3->examen_referido == 0){
                $examen_referido2 = "NO";
              }
              echo $examen_referido2;
              echo "<br>";
            }
          ?>
        </td>
        <td>
          <?php
            foreach ($rm->datos_preo as $key3){
              if($key3->asiste_examen == 1){
                $asiste_examen2 = "SI";
              }elseif($key3->asiste_examen == 0){
                $asiste_examen2 = "NO";
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
              if($key3->estado_cobro == 1){
                $estado_cobro_preo = "SI COBRADO";
              }elseif($key3->estado_cobro == 0){
                $estado_cobro_preo = "NO COBRADO";
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
            if($key4->estado_cobro == 1){
              $estado_cobro = "Cobrado";
            }elseif($key4->estado_cobro == 0){
              $estado_cobro = "No Cobrado";
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