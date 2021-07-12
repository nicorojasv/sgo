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
          alertify.alert('Ops ', "Debe seleccionar la fecha de termino de contrato antes de consultar por los examenes");
          return false;
        }
        var fechaTerminoContrato = anoft+"-"+mesft+"-"+diaft;
        if (this.checked == true) {
             if (this.value == 1) {//si hay que verificar el examen preocupacion
                $.ajax({
                      type:"POST",
                      url: base_url+"terramar/requerimientos/verificarExamenPreocupacional/"+idPersona,
                      data:idPersona,
                      dataType: "json",
                      success:function(data){
                         if (data.length ==0) {
                          alertify.error('no posee Examen Preocupacional');
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
                      url: base_url+"terramar/requerimientos/verificarCharlaMasso/"+idPersona,
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
                      url: base_url+"terramar/requerimientos/verificarExamenPsicologico/"+idPersona,
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
                           document.getElementById(chckid+"msg").innerHTML = "<span style='color:red'>Vencido con fecha: "+theRialFecha+"</span>";
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
             }//End MASSO*/

        }else{
             if (this.value == 1) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarContrato').attr('disabled','disabled');}
             if (this.value == 2) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarContrato').attr('disabled','disabled');}
             /*if (this.value == 3) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarContrato').attr('disabled','disabled');}*/
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
                // var checked3 = $('#chck3').is(':checked');
                  if(checked1 == true && checked2== true /*&& checked3 == true*/){
                    $('#agregarContrato').removeAttr("disabled");
                  }else{
                    $('#agregarContrato').attr('disabled','disabled');
                  }
            }else /*Fin 2.-Celulosa Arauco y Constitución S.A. */

            if ($('#id_empresa').val() == 4 || $('#id_empresa').val()== 7) {
                  var checked1 = $('#chck1').is(':checked');
                  //var checked3 = $('#chck3').is(':checked');
                  if(checked1 == true /*&& checked3 == true*/){
                    $('#agregarContrato').removeAttr("disabled");
                  }else{
                    $('#agregarContrato').attr('disabled','disabled');
                  }
            }else{/*Fin 4.-Maderas Arauco S.A. */
              $('#agregarContrato').removeAttr("disabled");
            }
      }
      
    });
</script>
<!--
*Cuando solicitan aprobacion de examen, y alvaro verifica que le qeda un mes , pero el administrador genera el contrato por 2 meses
*Como solicitan mandar a realizar examenes 
*Celulosa Arauco y todas sus plantas exigen : preocupacion , masso y psicologico ?
*En Madera siempres es preocupacional y psicologico
*Forestal libre , pero puede consultar por los examenes
*Como solicitan el tipo de examen preocupacional y psicologico para cada planta
-->
<?php 

  if ($this->session->userdata('notificado')==0) {
/*
<div id="la" style="display: none">
Ya que es la primera vez que entras a crear  un contrato
desde la ultima actualizacion, le comento que podrá consultar
directamente los examenes que tenga vigente el trabajador, 
por ende si no estan vigentes no podra crear el contrato. 


</div>
<script type="text/javascript">
  /*
  var pre = document.createElement('pre');
//custom style.
pre.style.maxHeight = "400px";
pre.style.margin = "0";
pre.style.padding = "24px";
pre.style.whiteSpace = "pre-wrap";
pre.style.textAlign = "justify";
pre.appendChild(document.createTextNode($('#la').text()));
//show as confirm
alertify.confirm('Hola <?php//echo $this->session->userdata('nombres');?>',pre, function(){
        //alertify.success('Accepted');
    },function(){
      var idPersona=1;
                     $.ajax({
                      type:"POST",
                      url: base_url+"terramar/requerimientos/no_mostrar_notificacion",
                      data:idPersona,
                      dataType: "json",
                      success:function(data){
                        if (data== true) {
                          alertify.message('no se volvera a mostrar');
                        }
                     }
                });

    }).set({labels:{ok:'Aceptar', cancel: 'Ok, no volver a mostrar'}, padding: false});
</script>
<?php */
  }
?>
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Creando Contrato de Trabajo</h4>
      </div>
<div id="modal">
  <form action="<?php echo base_url() ?>terramar/requerimientos/guardar_nuevo_contrato_anexo_doc_contractual/<?php echo $usuario?>/<?php echo $tipo?>/<?php echo $asc_area?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <input type='hidden' name="datos_extras" id="datos_extras" value="SI"/> 
  <input type="hidden" name="fechaHoy" id="fechaHoy" value="<?php echo date('Y-m-d') ?>">
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
                <?php 
                  $idEmpresa = $usu->id_empresa;
                ?>
                   <input type="hidden" name="id_empresa" id="id_empresa"  value="<?php echo $usu->id_empresa ?>">
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
                <tr>
                  <td><b>Tipo Gratificación Planta</b></td>
                  <td><?php echo $usu->tipo_gratificacion ?></td>
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
              <select name="causal" id="causal" class="form-control" required onchange="cambiarDefaulAll()">
              <?php $causaliti =  isset($datos_req->causal)?$datos_req->causal:'' ?>
                <option selected disabled value="">Seleccione</option>
                <option <?php if($causaliti == "A")echo "selected" ?> value="A">A</option>
                <option <?php if($causaliti == "B")echo "selected" ?>  value="B">B</option>
                <option <?php if($causaliti == "C")echo "selected" ?>  value="C">C</option>
                <option <?php if($causaliti == "D")echo "selected" ?>  value="D">D</option>
                <option <?php if($causaliti == "E")echo "selected" ?>  value="E">E</option>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="motivo">Motivo</label>
            <div class="controls">
              <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo isset($datos_req->motivo)?$datos_req->motivo:$motivo_defecto ?>" required/>
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
              } ?>
              <select name="dia_fi" id="dia_fi" style="width: 33%;" onchange="cambiarDefaulInico()" required>
                <option selected disabled value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fi" id="mes_fi" style="width: 33%;" onchange="cambiarDefaulInico()"  required>
               <?php 
                if ($mes_fi ==false) {
                  $mes_fi = date('m');
                  $bloqear = isset($mes_fi)?$mes_fi:false;
                }else{
                  $bloqear = isset($mes_fi)?$mes_fi:false;
                }
              ?>
                <option selected disabled value="">Mes</option>
                <option value='01' <?php if($bloqear!=false){if($mes_fi>'01'){echo '';}} echo ($mes_fi == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php if($bloqear!=false){if($mes_fi>'02'){echo '';}} echo ($mes_fi == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php if($bloqear!=false){if($mes_fi>'03'){echo '';}} echo ($mes_fi == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php if($bloqear!=false){if($mes_fi>'04'){echo '';}} echo ($mes_fi == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php if($bloqear!=false){if($mes_fi>'05'){echo '';}} echo ($mes_fi == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php if($bloqear!=false){if($mes_fi>'06'){echo '';}} echo ($mes_fi == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php if($bloqear!=false){if($mes_fi>'07'){echo '';}} echo ($mes_fi == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php if($bloqear!=false){if($mes_fi>'08'){echo '';}} echo ($mes_fi == '8')? "selected='selected'" : '' ?>>Agosto</option>
                <option value='09' <?php if($bloqear!=false){if($mes_fi>'09'){echo '';}} echo ($mes_fi == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php if($bloqear!=false){if($mes_fi>'10'){echo '';}} echo ($mes_fi == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php if($bloqear!=false){if($mes_fi>'11'){echo '';}} echo ($mes_fi == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php if($bloqear!=false){if($mes_fi>'12'){echo '';}} echo ($mes_fi == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <select name="ano_fi" id="ano_fi" style="width: 32%;" onchange="cambiarDefaulInico()"  required>
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
            } ?>
            <select name="dia_ft" id="dia_ft" style="width: 33%;" onchange="cambiarDefaul()">
              <option selected disabled  value="" >Dia</option>
              <?php for($i=1;$i<32;$i++){ ?>
              <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
            <select  name="mes_ft" id="mes_ft" style="width: 33%;" onchange="cambiarDefaul()">
              <option selected disabled value="">Mes</option>
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
            <select name="ano_ft" id="ano_ft" style="width: 32%;" onchange="cambiarDefaul()">
              <option selected disabled  value="">Año</option>
              <?php $tope_f = (date('Y') ); ?>
              <?php for($i=$tope_f;$i < (date('Y') + 2 ); $i++){ ?>
                <option value="<?php echo $i ?>" <?php echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
              <?php } ?>
            </select>
           </div>
          </div>
          <div class="control-form">
          <?php  //var_dump($horarios_planta); ?>
            <label class="control-label" for="jornada">Jornada</label>
            <div class="controls">
              <?php $id_horario_antiguo = isset($datos_req->jornada)?$datos_req->jornada:'' ?>
              <select name="jornada" id="jornada" class="form-control" required>
                <option value="">[Seleccione]</option>
                <?php

                 foreach($horarios_planta as $hp){ ?>
                <option value="<?php echo $hp->id ?>" title="<?php echo str_replace("<w:br/>","\n", $hp->descripcion) ?>" <?php if($id_horario_antiguo == $hp->id) echo "selected"; ?>  ><?php echo $hp->nombre_horario ?></option>
                <?php } ?>
                <option value="1" title="En atención a la naturaleza de la función encomendada, de dirección y supervisión, el trabajador quedará excluido de la limitación de jornada horaria lo establecido en el Art. 22 inciso segundo del Código del Trabajo, sin perjuicio de lo anterior, prestará los servicios convenidos, de lunes a sábado de cada mes calendario.">Sin Horario</option>
              </select>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="renta_imponible">Sueldo Base de la Liquidación</label>
            <div class="controls">
                <input type='text' class="form-control" name="renta_imponible" id="renta_imponible" value="<?php echo isset($datos_req->renta_imponible)?$datos_req->renta_imponible:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
              <div class="checkbox">
                <label><input type="checkbox" name="inptCheck" class="inptCheck" id="chck1" value="1" data-idUsuario="<?php echo $usuario?>">Examen Preocupacional</label><label id="chck1msg" style="font-weight: bold" for="chck1"></label>
              </div>
          <?php
            if ($idEmpresa ==2) {
          ?>
              <div class="checkbox">
                <label class="<?php if($idEmpresa != 2)echo "not" ?>"><input type="checkbox" name="inptCheck" class="inptCheck" id="chck2" value="2" data-idUsuario="<?php echo $usuario?>">Masso</label><label id="chck2msg" style="font-weight: bold;" for="chck2"></label>
              </div>
          <?php 
            }
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
        <div class="col-md-6">
         <h4><b><u>Bonos</u></b></h4>
          <div class="control-form">
            <label class="control-label" for="bono_responsabilidad">Bono Responsabilidad</label>
            <div class="controls">
              <input type='text' class="form-control" name="bono_responsabilidad" id="bono_responsabilidad" value="<?php echo isset($datos_req->bono_responsabilidad)?$datos_req->bono_responsabilidad:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="bono_gestion">Bono Gestión</label>
            <div class="controls">
              <input type='text' class="form-control" name="bono_gestion" id="bono_gestion" value="<?php echo isset($datos_req->bono_gestion)?$datos_req->bono_gestion:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="bono_confianza">Bono Confianza</label>
            <div class="controls">
              <input type='text' class="form-control" name="bono_confianza" id="bono_confianza" value="<?php echo isset($datos_req->bono_confianza)?$datos_req->bono_confianza:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_movilizacion">Asignación Movilización</label>
            <div class="controls">
              <input type='text' class="form-control" name="asignacion_movilizacion" id="asignacion_movilizacion" value="<?php echo isset($datos_req->asignacion_movilizacion)?$datos_req->asignacion_movilizacion:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_colacion">Asignación Colación</label>
            <div class="controls">
              <input type='text' class="form-control" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo isset($datos_req->asignacion_colacion)?$datos_req->asignacion_colacion:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_zona">Asignación Zona</label>
            <div class="controls">
              <input type='text' class="form-control" name="asignacion_zona" id="asignacion_zona" value="<?php echo isset($datos_req->asignacion_zona)?$datos_req->asignacion_zona:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="asignacion_herramientas">Asignación Herramientas</label>
            <div class="controls">
              <input type='text' class="form-control" name="asignacion_herramientas" id="asignacion_herramientas" value="<?php echo isset($datos_req->asignacion_herramientas)?$datos_req->asignacion_herramientas:'0' ?>" required/>
            </div>
          </div>
          <div class="control-form">
            <label class="control-label" for="viatico">Viatico</label>
            <div class="controls">
              <input type='text' class="form-control" name="viatico" id="viatico" value="<?php echo isset($datos_req->viatico)?$datos_req->viatico:'0' ?>" required/>
            </div>
          </div>
        </div>
      </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <br><br><br><br><br>


      <div class="modal_content">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" id="agregarContrato" class="btn btn-primary" disabled>Agregar</button>
      </div>
    </form>
</div>
<script type="text/javascript">
        function cambiarDefaulAll(){
           document.getElementById("chck1").checked = false;
          if ( document.getElementById("chck2")) {
               document.getElementById("chck2").checked = false;
          }
          if ( document.getElementById("chck3")) {
               document.getElementById("chck3").checked = false;
          }
          if ( document.getElementById("chck1msg")) {
               document.getElementById("chck1msg").innerHTML = "";
          }
          if ( document.getElementById("chck2msg")) {
               document.getElementById("chck2msg").innerHTML = "";
          }
          if ( document.getElementById("chck3msg")) {
               document.getElementById("chck3msg").innerHTML = "";
          }
           $('#agregarContrato').attr('disabled','disabled');
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
                    alertify.alert('Ops ', "De acuerdo a la causal B, no puede superar los 90 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "C") {// causal C 180 dias maximo
                 if (diferenciaDias >180) {
                    alertify.alert('Ops ', "De acuerdo a la causal C, no puede superar los 180 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "D") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ops ', "De acuerdo a la causal D, no puede superar los 90 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "E") {// causal E 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ops ', "De acuerdo a la causal E, no puede superar los 90 dias de contratación.<br>Tienes  un total de: "+diferenciaDias+" dias entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
            }
            $('#agregarContrato').attr('disabled',true);
      }
      function cambiarDefaulInico(){
        $('#agregarContrato').attr('disabled',true);
      }
</script>