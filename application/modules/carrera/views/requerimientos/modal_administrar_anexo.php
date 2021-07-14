<script>

$(document).ready(function(){
  $("#datepicker2").change(function(){
   $('#agregarContrato').attr('disabled','disabled')
  });
});
    $(document).ready(function(){
      $(".inptCheck").click(function(){
        var idPersona = $(this).attr("data-idUsuario");
        var chckid = $(this).attr("id");
        var diaft = $("#datepicker2").val();
        var fechaHoy = $("#fechaHoy").val();
        var fechaTerminoContrato = diaft;
        if (fechaTerminoContrato==null || fechaTerminoContrato=='') {
          alertify.alert('Ops ', "Debe seleccionar la fecha de termino de contrato antes de consultar por los examenes");
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
                          //$('#agregarContrato').removeAttr("disabled");
                        }
                     }
                });
             }//End MASSO
        }else{
             if (this.value == 1) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarContrato').attr('disabled','disabled');}
             if (this.value == 2) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarContrato').attr('disabled','disabled');}
             /*if (this.value == 3) { document.getElementById(chckid+"msg").innerHTML = ""; $('#agregarContrato').attr('disabled','disabled');}*/
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
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Editar Fecha de  Anexo de contrato</h4>
      </div>
      <?php
        if ($datosAnexo->motivo_rechazo) {
      ?>
      <span>Rechazado por: <?php echo $datosAnexo->motivo_rechazo; ?></span><br><br>
      <?php 
        }
       ?>
<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimientos/actualizar_anexo/<?php echo $anexos->id ?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <input type='hidden' name="datos_extras" id="datos_extras" value="SI"/> 
  <input type="hidden" name="fechaHoy" id="fechaHoy" value="<?php echo date('Y-m-d') ?>">
          <div class="clearfix"></div>
                <div class="control-form col-md-2"></div> 
  <div id="modal_content">
          <div class="control-form col-md-4">
            <label class="control-label" for="datepicker2">Fecha Termino Anexo</label>
            <div class="controls">
              <input type="hidden" name="fecha_termino_contrato_anterior" value="">
              <input type="text" class="form-control" style="cursor: pointer"  autocomplete="off" id="datepicker2" readOnly name="fechaTerminoAnexo" >
           </div>
          </div>
  </div>


          <div class="clearfix"></div>
          <div class="control-form col-md-2"></div>
          <div class="control-form col-md-10">
              <div class="checkbox">
                <label><input type="checkbox" name="inptCheck" class="inptCheck " id="chck1" value="1" data-idUsuario="<?php echo $anexos->usuario_id?>">Examen Preocupacional</label><label id="chck1msg" style="font-weight: bold" for="chck1"></label>
              </div>
              <?php
            //  var_dump($id_planta);
                if ($id_planta->id_centro_costo == 2) {
              ?>
                  <div class="checkbox">
                    <label ><input type="checkbox" name="inptCheck" class="inptCheck" id="chck2" value="2" data-idUsuario="<?php echo $anexos->usuario_id?>">Masso</label><label id="chck2msg" style="font-weight: bold;" for="chck2"></label>
                  </div>
              <?php 
                }
              ?>
          </div>
            <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" id="agregarContrato" class="btn btn-primary" >Agregar</button>
      </div>
    </form>
</div>
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