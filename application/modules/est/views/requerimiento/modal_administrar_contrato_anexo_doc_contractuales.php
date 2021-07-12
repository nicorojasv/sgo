<script>
    $(document).ready(function(){
      $(".inptCheck").click(function(){
        cambiarDefaul();
        var idPersona = $(this).attr("data-idUsuario");
        var chckid = $(this).attr("id");
        var diaft = $("#dia_ft").val();
        var mesft = $("#mes_ft").val();
        var anoft = $("#ano_ft").val();
        var fechaHoy = $("#fechaHoy").val();
        if (diaft==null || mesft== null || anoft==null) {
          alertify.alert('Ups ', "Debe seleccionar la fecha de termino de contrato antes de consultar por los examenes");
          return false;
        }
        var fechaTerminoContrato = anoft+"-"+mesft+"-"+diaft;
        if (this.checked == true) {
             if (this.value == 1) {//si hay que verificar el examen preocupacion
                $.ajax({
                      type:"POST",
                      url: base_url+"est/requerimiento/verificarExamenPreocupacional/"+idPersona,
                      data:idPersona,
                      dataType: "json",
                      success:function(data){
                         if (data.length ==0) {
                          alertify.error('No posee Examen Preocupacional');
                          document.getElementById(chckid).checked = false;
                          return false;
                        }else{
                           theRialFecha = data.fecha_v.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
                        }
                        if (data.fecha_v=="0000-00-00") {
                           alertify.error('El examen preocupacion no cuenta con fecha de termino , comunicarse con oficina central');
                           document.getElementById(chckid).checked = false;
                        }else if (new Date(data.fecha_v).getTime() < new Date(fechaHoy).getTime()) {//fecha de examen <  fecha de hoy
                           alertify.error('Examen preocupacional vencido');
                           document.getElementById(chckid+"msg").innerHTML = " <span style='color:red'>Vencido con fecha: "+theRialFecha+"</span>";
                           document.getElementById(chckid).checked = false;
                        }else if (new Date(data.fecha_v).getTime()  < new Date(fechaTerminoContrato).getTime() ) {
                          alertify.alert('No es posible ', "Fecha vigencia del examen preocupacional es hasta"+theRialFecha);
                          alertify.error('Rechazado');
                          document.getElementById(chckid).checked = false;
                        }else{
                            alertify.success('Examen Preocupacional Vigente');
                            document.getElementById(chckid+"msg").innerHTML = "<span style='color:green'> Vigente hasta : "+theRialFecha+"</span>";
                            validanding();
                          //  $('#agregarContrato').removeAttr("disabled");
                        }

                     }
                });
             }// End EXAMEN PREOCUPACIONAL198362

             if (this.value == 2) {//si hay que verificar charla masso
                 $.ajax({
                      type:"POST",
                      url: base_url+"est/requerimiento/verificarCharlaMasso/"+idPersona,
                      data:idPersona,
                      dataType: "json",
                      success:function(data){
                       if (data.length ==0) {
                          alertify.error('no posee Charla Masso');
                          document.getElementById(chckid).checked = false;
                          return false;
                        }else{
                           theRialFecha = data.fecha_v.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
                        }
                        if (data.fecha_v=="0000-00-00") {
                           alertify.error('La Charla Masso no cuenta con fecha de termino , comunicarse con oficina central');
                           document.getElementById(chckid).checked = false;
                        }else if (new Date(data.fecha_v).getTime() < new Date(fechaHoy).getTime()) {
                           alertify.error('Charla Masso Vencida');
                           document.getElementById(chckid+"msg").innerHTML = " <span style='color:red'>Vencido con fecha: "+theRialFecha+"</span>";
                           document.getElementById(chckid).checked = false;
                         }else if (new Date(data.fecha_v).getTime() < new Date(fechaTerminoContrato).getTime()) {
                          alertify.alert('No es posible ', "Fecha vigencia de Charla Masso es hasta "+theRialFecha);
                          alertify.error('Rechazado');
                          document.getElementById(chckid).checked = false;
                        }else{
                          alertify.success('Charla Masso Vigente');
                          document.getElementById(chckid+"msg").innerHTML = "<span style='color:green'> Vigente hasta : "+theRialFecha+"</span>";
                          validanding();
                          //$('#agregarContrato').removeAttr("disabled");
                        }
                     }
                });
             }//End MASSO

             /*if (this.value == 3) {//si hay que verificar examen psicologico
                 $.ajax({
                      type:"POST",
                      url: base_url+"est/requerimiento/verificarExamenPsicologico/"+idPersona,
                      data:idPersona,
                      dataType: "json",
                      success:function(data){
                       if (data.length ==0) {
                          alertify.error('No posee examen Psicologico');
                          document.getElementById(chckid).checked = false;
                          return false;
                        }else{
                           theRialFecha = data.fecha_vigencia.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
                        } 
                        if (data.fecha_vigencia=="0000-00-00") {
                           alertify.error('El examen psicologico no cuenta con fecha de termino , comunicarse con psicologia');
                           document.getElementById(chckid).checked = false;
                        }else if (new Date(data.fecha_vigencia).getTime() < new Date(fechaHoy).getTime()) {
                           alertify.error('Examen Psicologico Vencido');
                           document.getElementById(chckid+"msg").innerHTML = " <span style='color:red'>Vencido con fecha: "+theRialFecha+"</span>";
                           document.getElementById(chckid).checked = false;
                         }else if (new Date(data.fecha_vigencia).getTime() < new Date(fechaTerminoContrato).getTime()) {
                          alertify.alert('No es posible '," Fecha vigencia del examen preocupacional es "+theRialFecha);
                          document.getElementById(chckid).checked = false;
                        // callback(chckid)
                        }else{
                          alertify.success('Examen Psicologico Vigente');
                          document.getElementById(chckid+"msg").innerHTML = "<span style='color:green'> Vigente hasta : "+theRialFecha+"</span>";
                          validanding();
                        }
                     }
                });
             }//End Psicologico*/
        }else{
             if (this.value == 1) { 
              document.getElementById(chckid+"msg").innerHTML = "";
              $('#editar').attr('disabled','disabled');
              $('#btnEnvioSolicitud').attr('disabled','disabled');
            }
             if (this.value == 2) { 
              document.getElementById(chckid+"msg").innerHTML = "";
              $('#editar').attr('disabled','disabled');
              $('#btnEnvioSolicitud').attr('disabled','disabled');
            }
             /*if (this.value == 3) {
              document.getElementById(chckid+"msg").innerHTML = "";
              $('#editar').attr('disabled','disabled');
              $('#btnEnvioSolicitud').attr('disabled','disabled');
            }*/
        }
      });

     function validanding(){
          /*
            Validacion de checkbox
            2.-Celulosa Arauco y Constitución S.A.
            4.-Maderas Arauco S.A.
            5.-Forestal Arauco S.A.
            6.-CAMANCHACA PESCA SUR S.A.
            7.-EWOS CHILE ALIMENTOS LIMITADA.
          */
            if ($('#id_empresa').val() == 2) {
                  var checked1 = $('#chck1').is(':checked');
                  var checked2 = $('#chck2').is(':checked');
                  //var checked3 = $('#chck3').is(':checked');
                  if(checked1 == true && checked2== true /*&& checked3 == true*/){
                    $('#editar').removeAttr("disabled");
                    $('#btnEnvioSolicitud').removeAttr("disabled");
                  }else{
                     $('#editar').attr('disabled','disabled');
                    $('#btnEnvioSolicitud').attr('disabled','disabled');
                  }
            }/*Fin 2.-Celulosa Arauco y Constitución S.A. */

            if ($('#id_empresa').val() == 4 || $('#id_empresa').val() == 7) {
                  var checked1 = $('#chck1').is(':checked');
                 // var checked3 = $('#chck3').is(':checked');
                  if(checked1 == true /*&& checked3 == true*/){
                    $('#editar').removeAttr("disabled");
                    $('#btnEnvioSolicitud').removeAttr("disabled");
                  }else{
                    $('#editar').attr('disabled','disabled');
                    $('#btnEnvioSolicitud').attr('disabled','disabled');
                  }
            }/*Fin 4.-Maderas Arauco S.A. */
     }
  });
</script>
<style type="text/css">
  .not{
    cursor: not-allowed !important;
  }
</style>
<div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Agregar/Editar Documento Contractual</h4>
      </div>
<div id="modal">
  <form action="<?php echo base_url() ?>est/requerimiento/actualizar_contrato_anexo_doc_contractual/<?php echo $id_usu_arch?>/<?php echo $id_area_cargo?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <div id="modal_content">
    <?php if($datos_generales != FALSE){ ?>
      <?php foreach ($datos_generales as $usu){ ?>
        <div class="row">
          <div class="col-md-6 col-sd-6">
            <h5><b><u>Datos trabajadors:</u></b></h5>
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
                    <input type="hidden" name="id_centro_costo" id="id_centro_costo" value="<?php echo $usu->id_centro_costo ?>">
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
                  <?php 
                  $idEmpresa = $usu->id_empresa;
                ?>
                <input type="hidden" name="id_empresa" id="id_empresa"  value="<?php echo $usu->id_empresa ?>">
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
              $usuario= $row->usuario_id;
        ?>
      <div class="row">
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Datos del contrato</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="causal">Causal</label>
            <div class="controls">
                <input type="hidden" name="fechaHoy" id="fechaHoy" value="<?php echo date('Y-m-d') ?>">
                <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $usuario?>">
                <input type="hidden" name="diaHoy" id="diaHoy" value="<?php  echo date('d') ?>">
                <input type="hidden" name="mesHoy" id="mesHoy" value="<?php  echo date('m') ?>">
                <input type="hidden" name="anoHoy" id="anoHoy" value="<?php  echo date('Y') ?>">
              <input type="hidden" name="gc_causal" value="<?php echo $row->causal ?>">
              <select name="causal" onchange="cambiarDefaulAll()" id="causal" class="form-control" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
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
              <input type="hidden" name="gc_motivo" value="<?php echo $row->motivo ?>">
              <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo $row->motivo?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
            </div>
          </div>
          <?php //var_dump($row->motivo); ?>
          
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
              <input type="hidden" name="gc_dia_fi" value="<?php echo $dia_fi ?>" >
              <select name="dia_fi" id="dia_fi" style="width:33%;" onchange="cambiarDefaulInico()" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <input type="hidden"  name="gc_mes_fi" value="<?php echo $mes_fi ?>">
              <select name="mes_fi" onchange="cambiarDefaulInico()" id="mes_fi" style="width: 33%;" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
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
              <select name="ano_fi" onchange="cambiarDefaulInico()" id="ano_fi" style="width: 32%;" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
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
              <select onchange="cambiarDefaul()" name="dia_ft" id="dia_ft" style="width: 33%;" <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <input type="hidden" name="gc_mes_ft" value="<?php echo $mes_ft ?>">
              <select onchange="cambiarDefaul()" name="mes_ft" id="mes_ft" style="width: 33%;" <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
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
              <select onchange="cambiarDefaul()" name="ano_ft" id="ano_ft" style="width: 32%;" <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
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
            <?php 
                if (!is_numeric($row->jornada)) {
            ?>
               <br> <label class="text-primary">Seleccione la jornada : <?php echo $row->jornada ?></label>
            <?php
                }
            ?>
            
            <div class="controls">
              <input type="hidden" name="gc_jornada" value="<?php echo $row->jornada ?>">
              <select name="jornada" id="jornada" class="form-control" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> >
                <option value="">[Seleccione]</option>
                <?php foreach($horarios_planta as $hp){ ?>
                <option value="<?php echo $hp->id ?>" title="<?php echo str_replace("<w:br/>","\n", $hp->descripcion) ?>" <?php if($row->jornada == $hp->id) echo "selected"; ?> ><?php echo $hp->nombre_horario ?></option>
                <?php } ?>
                <option value="1" title="En atención a la naturaleza de la función encomendada, de dirección y supervisión, el trabajador quedará excluido de la limitación de jornada horaria lo establecido en el Art. 22 inciso segundo del Código del Trabajo, sin perjuicio de lo anterior, prestará los servicios convenidos, de lunes a sábado de cada mes calendario." <?php if($row->jornada == '1') echo "selected"; ?> >Sin Horario</option>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
            <div class="controls">
              <input type='hidden' name="gc_renta_imponible" value="<?php echo $row->renta_imponible?>"/>
              <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="<?php echo $row->renta_imponible?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
            </div>
          </div>
                    <div class="control-form">
          <div class="checkbox">
              <label><input type="checkbox" <?php if($estado_bloqueo == "si") echo "disabled"; ?> class="inptCheck" checked id="chck1" value="1" data-idUsuario="<?php echo $usuario?>">Examen Preocupacional</label><label id="chck1msg" style="font-weight: bold" for="chck1"></label>
            </div>
          <?php
          //  if ($idEmpresa ==2) {
          ?>
              <div class="checkbox">
                <label class="<?php if($idEmpresa != 2)echo "not" ?>"><input type="checkbox" name="inptCheck" class="inptCheck" id="chck2" value="2" checked data-idUsuario="<?php echo $usuario?>">Masso</label><label id="chck2msg" style="font-weight: bold;" for="chck2"></label>
              </div>
          <?php 
          //  }
           /* if ($idEmpresa ==2 || $idEmpresa ==4 || $idEmpresa ==7) {
          ?>
              <div class="checkbox ">
                <label><input type="checkbox" name="inptCheck" class="inptCheck" id="chck3" value="3" data-idUsuario="<?php echo $usuario?>">Examen Psicologico</label><label id="chck3msg" style="font-weight: bold;" for="chck3"></label>
              </div>
          <?php 
            }*/
          ?>

          </div>
        </div>
        <div class="col-md-6 col-sd-6">
          <h4><b><u>Bonos</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="bono_responsabilidad">Bono Responsabilidad</label>
            <div class="controls">
              <input type='hidden' name="gc_bono_responsabilidad" value="<?php echo $row->bono_responsabilidad ?>"/>
              <input type='text' class="form-control" name="bono_responsabilidad" id="bono_responsabilidad" value="<?php echo $row->bono_responsabilidad ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="bono_gestion">Bono Gestión</label>
            <div class="controls">
              <input type='hidden' name="gc_bono_gestion" value="<?php echo $row->bono_gestion ?>"/>
              <input type='text' class="form-control" name="bono_gestion" id="bono_gestion" value="<?php echo $row->bono_gestion ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="bono_confianza">Bono Confianza</label>
            <div class="controls">
              <input type='hidden' name="gc_bono_confianza" value="<?php echo $row->bono_confianza ?>"/>
              <input type='text' class="form-control" name="bono_confianza" id="bono_confianza" value="<?php echo $row->bono_confianza ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
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
            <label class="control-label" for="asignacion_herramientas">Asignación de Herramientas</label>
            <div class="controls">
              <input type='hidden' name="gc_asignacion_herramientas" value="<?php echo $row->asignacion_herramientas ?>"/>
              <input type='text' class="form-control" name="asignacion_herramientas" id="asignacion_herramientas" value="<?php echo $row->asignacion_herramientas ?>" required <?php if($estado_bloqueo == "si") echo "disabled"; ?> />
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
        <div class="row">
          <div class="col-md-6">
            <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" name="actualizar" id="editar" class="btn btn-primary" <?php if($estado_bloqueo == "si") echo "disabled"; ?> >Editar</button>
          </div>
          <div class="col-md-6">
            <?php if($revisiones_al_dia >= 1 and $evaluaciones_rechazados == 0){ ?>
              <?php if($row->estado_aprobacion_revision == '1' and $solicitud_existente_contrato == '1'){ ?>
              <button type="submit" name="generar_contrato" class="btn btn-green">Generar Contrato</button>
               
              <button type="submit" name="generar_doc_adicionales_contrato" class="btn btn-green">Generar Doc. Adicionales</button>
              
              <?php }elseif($solicitud_existente_contrato == '0'){ ?>
              <button type="button" class="btn btn-red">Solicitud de contrato ya enviada...</button>
              <?php }elseif($solicitud_existente_contrato == '2'){ ?>
              <button type="submit" name="envio_solicitud_contrato" id="btnEnvioSolicitud" class="btn btn-orange">Solicitud anterior rechazada, volver enviar solicitud</button>
              <?php echo "<br>".$comentarios_existente_contrato ?>
              <?php }else{ ?>
              <button type="submit" name="envio_solicitud_contrato" id="btnEnvioSolicitud" class="btn btn-green">Enviar solicitud de contrato</button>
              <?php } ?>
            <?php
              }else{
                echo "Para realizar generación de contratos, el trabajador debe tener todos los exámenes revisados y aprobados!!!";
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
        function cambiarDefaulAll(){
           document.getElementById("chck1").checked = false;
           document.getElementById("chck2").checked = false;
           //document.getElementById("chck3").checked = false;
           document.getElementById("chck1msg").innerHTML = "";
           document.getElementById("chck2msg").innerHTML = "";
          // document.getElementById("chck3msg").innerHTML = "";
           $('#editar').attr('disabled','disabled');
           $('#btnEnvioSolicitud').attr('disabled','disabled');
        }

        function cambiarDefaul(){
           var causal = $("#causal").val();
           var dia = $("#dia_fi").val();
           var mes = $("#mes_fi").val();
           var ano = $("#ano_fi").val();
           var diaft = $("#dia_ft").val();
           var mesft = $("#mes_ft").val();
           var anoft = $("#ano_ft").val();
           if (causal == null) { // Validando que se seleccione causal
            alertify.error('Debe Seleccionar causal');
              $("#dia_ft").val('');
              $("#mes_ft").val('');
              $("#ano_ft").val('');
              return false;
           }
           //alert(dia)
           if (dia==null || mes==null || ano==null) {// validando que se selecciono fecha de inicio de contrato
             $("#dia_ft").val('');
              $("#mes_ft").val('');
              $("#ano_ft").val('');
              alertify.error('Debe Seleccionar Fecha de inicio contrato');
              return false;
           } 

           if (diaft != null && mesft !=null && anoft != null) {

            var fechaInicio = moment(ano+'-'+mes+'-'+dia);
            var fechaTermino = moment(anoft+'-'+mesft+'-'+diaft);
            diferenciaDias = fechaTermino.diff(fechaInicio, 'days');
            if (new Date(fechaInicio).getTime() > new Date(fechaTermino).getTime()) {
              alertify.alert('Imposible! ', "La fecha de inicio contrato no puede ser superior a la fecha de termino!");
              cambiarDefaulAll();
              return false;
            }

               if (causal == "A") {// causal A ilimitada
                 return true;
               }

               if (causal == "B") {// causal B 90 dias maximo
                 if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal B, no puede superar los 90 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "C") {// causal C 180 dias maximo
                 if (diferenciaDias >180) {
                    alertify.alert('Ups ', "De acuerdo a la causal C, no puede superar los 180 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "D") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal D, no puede superar los 90 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "E") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal E, no puede superar los 90 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
            }
      }
       function cambiarDefaulInico(){
         var fechaHoy = $("#fechaHoy").val();
         var dia = $("#dia_fi").val();
         var mes = $("#mes_fi").val();
         var ano = $("#ano_fi").val();
         var diaHoy = $("#diaHoy").val();
         var mesHoy = $("#mesHoy").val();
         var anoHoy = $("#anoHoy").val();
         var idPersona = $("#idUsuario").val();
         if (dia!=null) {
           if (dia<10) {
            dia='0'+dia;
           }
         }
         var fechaInicio = ano+'-'+mes+'-'+dia;
         var f1 = new Date(ano, mes, dia); //31 de diciembre de 2015
         var f2 = new Date(anoHoy, mesHoy, diaHoy); //30 de noviembre de 2014
         console.log(dia)

         if (dia==null) {// validando que se selecciono fecha de inicio de contrato
              alertify.error('Debe Seleccionar dia de inicio de contrato');
              return false;
          } 
          if ( mes==null ) {
            alertify.error('Debe Seleccionar Mes de inicio de contrato');
              return false;
          }
          if (ano==null) {
            alertify.error('Debe Seleccionar Año de inicio de contrato');
              return false;
          }
          var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
          var f=new Date();
          fechaHoyEscrita = f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
          /* #yayo editado el 16-10-2019 para permitir crear contrato con fecha inferior a la actual
          if(f1 < f2){
            alertify.error('No es posible crear contrato con fecha inferior a: <b>'+fechaHoyEscrita+'</b>', { timeOut: 9500 });
            $("#dia_fi").val('');
            return false;
          }*/
                $.ajax({
                      type:"POST",
                      url: base_url+"est/requerimiento/revisar_fecha/"+idPersona,
                      data:{fechaInicio:fechaInicio},
                      dataType: "json",
                      success:function(data){
                          var fa=new Date(data.fecha_termino2+"Z");
                          var ff = (fa.getDate()+ 1) + " de " + meses[fa.getMonth()] + " del " + fa.getFullYear()
                          var finicioTexto=new Date(fechaInicio+"Z");
                          var fiTexto = (finicioTexto.getDate()+ 1) + " de " + meses[finicioTexto.getMonth()] + " del " + finicioTexto.getFullYear()
                        if (data.tipo_archivo_requerimiento_id==1) {//Contrato
                          alertify.alert('No es posible  crear contrato', "Al momento de crear un contrato el trabajador no debe tener un contrato vigente<br><li>Esta intentando crear un contrato con fecha de inicio: <b>"+fiTexto+"</b></li><br><li> En este caso <b>"+data.nombres+"</b> cuenta con <b>Contrato</b> con fecha termino: <b>"+ff+"</b></li><br><br> <a target='_blank' href="+base_url+"est/requerimiento/contratos_req_trabajador/"+data.usuario_id+"/"+data.requerimiento_asc_trabajadores_id+"/"+data.id_requerimiento_area_cargo+" >ir a Contrato vigente</a> ");
                           alertify.error('Trabajador Cuenta con Contrato vigente');
                            $("#dia_fi").val('');
                            $("#dia_ft").val('');
                            $("#mes_ft").val('');
                            $("#ano_ft").val('');
                        }else if (data.tipo_archivo_requerimiento_id==2){//Anexos
                          alertify.alert('No es posible  crear contrato', "Al momento de crear un contrato el trabajador no debe tener un Anexo vigente<br><li>Esta intentando crear un contrato con fecha de inicio: <b>"+fiTexto+"</b></li><br><li>En este caso <b>"+data.nombres+"</b> cuenta con <b>anexo de contrato</b> con fecha termino <b>"+ff+"</b><br><br> <a target='_blank' href="+base_url+"est/requerimiento/contratos_req_trabajador/"+data.usuario_id+"/"+data.requerimiento_asc_trabajadores_id+"/"+data.id_requerimiento_area_cargo+">ir a anexo vigente</a> ");
                           alertify.error('Trabajador Cuenta con Anexo vigente');
                           $("#dia_fi").val('');
                            $("#dia_ft").val('');
                            $("#mes_ft").val('');
                            $("#ano_ft").val('');
                        }
                     }
                });

        $('#agregarContrato').attr('disabled',true);
      }
</script>