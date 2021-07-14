<?php 
//el anexo traera fecha de inicio del  contrato creado
//
?>
<style type="text/css">
  hr.colored {
  border: 0;   /* in order to override TWBS stylesheet */
  height: 2px;
background: #716f6f;
 
}
</style>
<script>
    $(document).ready(function(){
      $(".inptCheck").click(function(){

        var idPersona = $(this).attr("data-idUsuario");
        var chckid = $(this).attr("id");
        var diaft = $("#datepicker2").val();
        var fechaHoy = $("#fechaHoy").val();
        var fechaTerminoContrato = diaft;

          var dia = $("#dia_fi").val();
          var mes = $("#mes_fi").val();
          var ano = $("#ano_fi").val();
          var ftmnno = $("#fecha_termino_contrato_anterior").val();
          var fechaInicio = moment(ano+'-'+mes+'-'+dia);
          var fechaTermino = moment(fechaTerminoContrato);
          diferenciaDias = fechaTermino.diff(fechaInicio, 'days');
          if (new Date(fechaInicio).getTime() > new Date(fechaTermino).getTime()) {
            alertify.alert('Imposible! ', "La fecha de Termino del Anexo no puede ser inferior a la fecha de Inicio del Contrato!");
            cambiarDefaulAll();
            return false;
          }
          if (new Date(ftmnno).getTime() > new Date(fechaTermino).getTime()) {
            alertify.alert('Imposible! ', "La fecha de Termino del Anexo no puede ser inferior a la fecha de Termino Actual del Contrato!");
            cambiarDefaulAll();
            return false;
          }

         if (fechaTerminoContrato==null || fechaTerminoContrato=='') {
          alertify.alert('Ops ', "Debe seleccionar la fecha de termino de Anexo antes de consultar por los examenes");
          return false;
        }
        if (this.checked == true) {
             if (this.value == 1) {//si hay que verificar el examen preocupacion
                $.ajax({
                      type:"POST",
                      url: base_url+"carrera/requerimientos/verificarExamenPreocupacional/"+idPersona,
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
                          alertify.alert('No es posible ', "Fecha vigencia del examen preocupacional es hasta "+theRialFecha);
                          alertify.error('Rechazado');
                           document.getElementById(chckid+"msg").innerHTML = " <span style='color:red'>Vencido con fecha: "+theRialFecha+"</span>";
                          document.getElementById(chckid).checked = false;
                        }else{
                            alertify.success('Examen Preocupacional Vigente');
                            document.getElementById(chckid+"msg").innerHTML = "<span style='color:green'> Vigente hasta : "+theRialFecha+"</span>";
                            validanding();
                          //  $('#agregarAnexo').removeAttr("disabled");
                        }

                     }
                });
             }// End EXAMEN PREOCUPACIONAL198362

             if (this.value == 2) {//si hay que verificar charla masso
                 $.ajax({
                      type:"POST",
                      url: base_url+"carrera/requerimientos/verificarCharlaMasso/"+idPersona,
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
                          //$('#agregarAnexo').removeAttr("disabled");
                        }
                     }
                });
             }//End MASSO
        }else{
             if (this.value == 1) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarAnexo').attr('disabled','disabled');}
             if (this.value == 2) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarAnexo').attr('disabled','disabled');}
             /*if (this.value == 3) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarAnexo').attr('disabled','disabled');}*/
        }
      });
      function validanding(){
          /*Validacion de checkbox
            2.-Celulosa Arauco y Constitución S.A.
            4.-Maderas Arauco S.A.
            5.-Forestal Arauco S.A.
            6.-CAMANCHACA PESCA SUR S.A.
            7.-EWOS CHILE ALIMENTOS LIMITADA.*/
            if ($('#id_empresa').val() == 2) {
                  var checked1 = $('#chck1').is(':checked');
                  var checked2 = $('#chck2').is(':checked');
                // var checked3 = $('#chck3').is(':checked');
                  if(checked1 == true && checked2== true /*&& checked3 == true*/){
                    $('#agregarAnexo').removeAttr("disabled");
                  }else{
                    $('#agregarAnexo').attr('disabled','disabled');
                  }
            }else /*Fin 2.-Celulosa Arauco y Constitución S.A. */

            if ($('#id_empresa').val() == 4 || $('#id_empresa').val()== 7) {
                  var checked1 = $('#chck1').is(':checked');
                  //var checked3 = $('#chck3').is(':checked');
                  if(checked1 == true /*&& checked3 == true*/){
                    $('#agregarAnexo').removeAttr("disabled");
                  }else{
                    $('#agregarAnexo').attr('disabled','disabled');
                  }
            }else{/*Fin 4.-Maderas Arauco S.A. */
              $('#agregarAnexo').removeAttr("disabled");
            }
      }
      
    });
</script>
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Creando Anexo</h4>
      </div>

<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimientos/guardar_anexo/<?php echo $usuario?>/<?php echo $tipo?>/<?php echo $asc_area?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <input type='hidden' name="datos_extras" id="datos_extras" value="SI"/> 
  <input type="hidden" name="fechaHoy" id="fechaHoy" value="<?php echo date('Y-m-d') ?>">
                 
  <div id="modal_content">
    <?php 
        if($datos_generales != FALSE){
          foreach ($datos_generales as $usu){
    ?>
          <?php $causaliti =  isset($datos_req->causal)?$datos_req->causal:'' ?>
            <input type="hidden" name="nombre" value="<?php echo $usu->nombres_apellidos ?>">
            <input type="hidden" name="rut" value="<?php echo $usu->rut ?>">
            <input type="hidden" name="estado_civil" value="<?php echo $usu->estado_civil ?>">
            <input type="hidden" name="fecha_nacimiento" value="<?php echo $usu->fecha_nac ?>">
            <input type="hidden" name="domicilo" value="<?php echo $usu->domicilo ?>">
            <input type="hidden" name="ciudad" value="<?php echo $usu->ciudad ?>">
            <input type="hidden" name="nacionalidad" value="<?php echo $usu->nacionalidad ?>">
            <input type="hidden" name="id_empresa" id="id_empresa"  value="<?php echo $usu->id_empresa ?>">
            <input type="hidden" name="id_planta" id="id_planta"  value="<?php echo $usu->id_planta ?>">
            <input type="hidden" name="id_area_cargo" id="id_area_cargo"  value="<?php echo $usu->id_req_area_cargo ?>">
            <input type="hidden" name="afp" id="afp"  value="<?php echo $usu->prevision ?>">
            <input type="hidden" name="salud" id="salud"  value="<?php echo $usu->salud ?>">
            <input type="hidden" name="nombre_centro_costo" id="nombre_centro_costo"  value="<?php echo $usu->nombre_centro_costo ?>">
            <input type="hidden" name="telefono" id="telefono"  value="<?php echo $usu->telefono ?>">
            <input type="hidden" name="nivel_estudios" id="nivel_estudios"  value="<?php echo $usu->nivel_estudios ?>">
            <input type="hidden" name="nombre_banco" id="nombre_banco"  value="<?php echo $usu->nombre_banco ?>">
            <input type="hidden" name="tipo_cuenta" id="tipo_cuenta"  value="<?php echo $usu->tipo_cuenta ?>">
            <input type="hidden" name="cuenta_banco" id="cuenta_banco"  value="<?php echo $usu->cuenta_banco ?>">
            <input type="hidden" name="nombre_planta" id="nombre_planta"  value="<?php echo $usu->nombre_planta ?>">
            <input type="hidden" name="causal" id="causal"  value="<?php echo $causaliti ?>">


    <?php 
            $idEmpresa= $usu->id_empresa;
          } 
        } 
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
      <input type="hidden" id="dia_fi" name="dia_fi" value="<?php echo $dia_fi ?>">
      <input type="hidden" id="mes_fi" name="mes_fi" value="<?php echo $mes_fi ?>">
      <input type="hidden" id="ano_fi" name="ano_fi" value="<?php echo $ano_fi ?>">

        <div class="col-md-12" style="background-color: #dedede;">
          <h4><b><u>Datos del contrato</u></b></h4>
          <div class="col-md-6">
            <div class="controls">
            <label class="control-label" for="dia_fi">Nombre</label>
              <input type="text" class="form-control" name="nombre" value="<?php echo $usu->nombres_apellidos ?>" disabled>
            </div>
          </div>
          <div class="control-form col-md-6">
            <label class="control-label" for="causal">Domicilio</label>
            <div class="controls">
              <input type="text" class="form-control" name="causal" value="<?php echo $usu->domicilo ?>" disabled>
            </div>
          </div>

          <div class="control-form col-md-6">
            <label class="control-label" for="dia_fi">Fecha Inicio del Contrato</label>
            <div class="controls">
              <?php 
                switch($mes_fi){
                   case 1: $mesInicio="Enero"; break;
                   case 2: $mesInicio="Febrero"; break;
                   case 3: $mesInicio="Marzo"; break;
                   case 4: $mesInicio="Abril"; break;
                   case 5: $mesInicio="Mayo"; break;
                   case 6: $mesInicio="Junio"; break;
                   case 7: $mesInicio="Julio"; break;
                   case 8: $mesInicio="Agosto"; break;
                   case 9: $mesInicio="Septiembre"; break;
                   case 10: $mesInicio="Octubre"; break;
                   case 11: $mesInicio="Noviembre"; break;
                   case 12: $mesInicio="Diciembre"; break;
                }
              ?>
              <input type="text" class="form-control" name="fecha_inicio_contrato" value="<?php echo $dia_fi.' de '.$mesInicio.' de '.$ano_fi ?>" disabled>
              <input type="hidden" name="fecha_inicio_contrato" value="<?php echo $ano_fi.'-'.$mes_fi.'-'.$dia_fi ?>">
            </div>
          </div>
          <div class="control-form col-md-6">
            <?php 
                if ($datos_req->tipo_archivo_requerimiento_id == 2 ) {
            ?>
                   <label class="control-label" for="dia_fi">Fecha Termino del ultimo Anexo</label>
            <?php
                }else{
            ?>
                  <label class="control-label" for="dia_fi">Fecha Termino del Contrato</label>
            <?php
                }
            ?>
            <div class="controls">
                <?php 
                switch($mes_ft){
                   case 1: $mes="Enero"; break;
                   case 2: $mes="Febrero"; break;
                   case 3: $mes="Marzo"; break;
                   case 4: $mes="Abril"; break;
                   case 5: $mes="Mayo"; break;
                   case 6: $mes="Junio"; break;
                   case 7: $mes="Julio"; break;
                   case 8: $mes="Agosto"; break;
                   case 9: $mes="Septiembre"; break;
                   case 10: $mes="Octubre"; break;
                   case 11: $mes="Noviembre"; break;
                   case 12: $mes="Diciembre"; break;
                }
              ?>
              <input type="text" id="fecha_termino" class="form-control" name="fecha_termino" value="<?php echo $dia_ft.' de '.$mes.' de '.$ano_ft ?>" disabled>
            </div>
          </div>

          <div class="control-form col-md-12">
            <label class="control-label" for="motivo">Motivo</label>
            <div class="controls">
              <input type='text' class="form-control" name="motivo" id="motivo" value="<?php echo isset($datos_req->motivo)?$datos_req->motivo:$motivo_defecto ?>" disabled/>
            </div>
          </div>
          <div class="control-form col-md-12" style="visibility: hidden;">
            <label class="control-label" for="motivo"></label>
            <div class="controls">
              <
            </div>
          </div>
        </div>
        <div class="control-form col-md-12">
            <hr class="colored" /> 
        </div>
        <div>
          <div class="control-form col-md-2"></div>
          <div class="control-form col-md-4">
            <label class="control-label" for="datepicker2" >Fecha Termino Anexo</label>
            <div class="controls">
              <input type="hidden" name="fecha_termino_contrato_anterior" id="fecha_termino_contrato_anterior" value="<?php echo $ano_ft.'-'.$mes_ft.'-'.$dia_ft ?>">
              <input type="text" style="cursor: pointer" class="form-control" onchange="cambiarDefaul(this.value)"  autocomplete="off" id="datepicker2" name="fechaTerminoAnexo" readOnly >
           </div>
          </div>
          <div class="control-form col-md-6"></div>

          <div class="clearfix"></div>
          <div class="control-form col-md-2"></div>
          <div class="control-form col-md-10">
              <div class="checkbox">
               <input type="hidden" name="inptCheck" class="<?php if($idEmpresa != 2)echo "not" ?>" id="chck1" value="1" data-idUsuario="<?php echo $usuario?>">
              </div>
              <?php
                if ($idEmpresa ==2) {
              ?>
                  <div class="checkbox">
                    <input type="hidden" name="inptCheck" class="inptCheck" id="chck2" value="2" data-idUsuario="<?php echo $usuario?>">
                  </div>
              <?php 
                }
              ?>
          </div>


        </div>
    </div>
          <div class="clearfix"></div>

      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" id="agregarAnexo" class="btn btn-primary" disabled>Agregar</button>
      </div>
    </form>
</div>
<script type="text/javascript">
       
      function cambiarDefaulInico(){
        $('#agregarAnexo').attr('disabled',true);
      }
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
    $("#datepicker").datepicker({ minDate: 0,  duration: "slow"  });
    $("#datepicker2").datepicker({ minDate: 0,  duration: "slow" });
    $("#datepicker3").datepicker({ minDate: 0,  duration: "slow" });
});
</script>

<script type="text/javascript">
        function cambiarDefaulAll(){
           document.getElementById("chck1").checked = false;
           if (document.getElementById("chck2")) {
              document.getElementById("chck2").checked = false;
           }
           //document.getElementById("chck3").checked = false;
           document.getElementById("chck1msg").innerHTML = "";
           if (document.getElementById("chck2msg")) {
              document.getElementById("chck2msg").innerHTML = "";
           }
          // document.getElementById("chck3msg").innerHTML = "";
           $('#editar').attr('disabled','disabled');
           $('#btnEnvioSolicitud').attr('disabled','disabled');
        }



        function cambiarDefaul(fechaTermino = false){
           $('#agregarAnexo').attr('disabled',true);
            document.getElementById("chck1").checked = false;
            if (document.getElementById("chck2")) {
                document.getElementById("chck2").checked = false;
            }
            //console.log(fechaTermino)

           var causal = $("#causal").val();
           var dia = $("#dia_fi").val();
           var mes = $("#mes_fi").val();
           var ano = $("#ano_fi").val();

            var fechaInicio = moment(ano+'-'+mes+'-'+dia);
            var fechaTermino = moment(fechaTermino);
            diferenciaDias = fechaTermino.diff(fechaInicio, 'days');
            if (new Date(fechaInicio).getTime() > new Date(fechaTermino).getTime()) {
              alertify.alert('Imposible! ', "La fecha de Termino del Anexo no puede ser inferior a la fecha de Inicio del Contrato!");
              cambiarDefaulAll();
              return false;
            }

               if (causal == "A") {// causal A ilimitada
                 return true;
               }

               if (causal == "B") {// causal B 90 dias maximo
                 if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal B, no puede superar los 90 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio del contrato y termino del anexo<br> Intente reducir la fecha.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "C") {// causal C 180 dias maximo
                 if (diferenciaDias >180) {
                    alertify.alert('Ups ', "De acuerdo a la causal C, no puede superar los 180 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio del contrato y termino del anexo<br> Intente reducir la fecha.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "D") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal D, no puede superar los 90 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio del contrato y Termino del anexo <br> Intente reducir la fecha.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
               if (causal == "E") {// causal D 90 dias maximo
                if (diferenciaDias >90) {
                    alertify.alert('Ups ', "De acuerdo a la causal E, no puede superar los 90 días de contratación.<br>Tienes  un total de: "+diferenciaDias+" días entre Fecha de Inicio y Termino <br> Intente reducir la fecha de contratacion.");
                    cambiarDefaulAll();
                    return false;
                 }
               }
            $('#agregarAnexo').removeAttr("disabled");
      }
      introJs().start();
</script>