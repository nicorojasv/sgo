
<div class="panel panel-white">
  <div class="panel-body">
          <div class="row">
              <div class="col-md-4">
                <div id="datepickerDT"></div>
              </div>
              <div class="col-md-5"></div>

              <div class="col-md-3" align="center">
                
            <form action="<?php echo base_url() ?>est/requerimiento/exportar_excel_dt" method="post" target="_blank" id="FormularioExportacion2">
              <?php 
                if (isset($fechaParaDatePickerDT)) {
              ?>
                  <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="button" class="btnExportarDT btn btn-success " value="Exportar a Excel"><br>
                  <input type="hidden" id="datos_a_enviar2" name="datos_a_enviar2"/>
              <?php
              }else{
              ?>
                  <input title="EXPORTAR DATOS A ARCHIVO EXCEL"  type="button" class=" btn btn-secondary " value="Exportar a Excel">
              <?php
            }
              ?>
            </form>
            <br>
        </div>
       </div>
       <input type="hidden" name="fechaParaDatePickerDT" id="fechaParaDatePickerDT" value="<?php echo isset($fechaParaDatePickerDT)?$fechaParaDatePickerDT:''; ?>">
        <div class="row">
          
        </div>
    <div id="content" align="center"></div>
      <?php
        if (empty($dt)) {
           if (isset($fechaParaDatePickerDT)) {
      ?>

        <div class="alert alert-danger" role="alert">
         no existen registro para la fecha seleccionada
        </div>
      <?php 
        }
         }else{
      ?>
      <div class="alert alert-success" role="alert">
        Presione exportar a Excel  para generar DT de la fecha de seleccionada
      </div>
      <?php
         }
      ?>
  </div>
</div>
<!--fin-->
  <div id="divTableDataHolder2" style="display:none">
  <meta content="charset=UTF-8"/>
    <table id="Exportar_a_Excel2" style="border-collapse:collapse;" >
      <thead>
        <th>rut_tr</th>
        <th>dv_tr</th>
        <th>nombres_tr</th>
        <th>ap_paterno_tr</th>
        <th>ap_materno_tr</th>
        <th>comuna_tr</th>
        <th>sexo</th>
        <th>fecha_notificacion</th>
        <th>medio_notificacion</th>
        <th>oficina_correos</th>
        <th>fecha_inicio</th>
        <th>fecha_termino</th>
        <th>monto_anio_servicio</th>
        <th>monto_aviso_previo</th>
        <th>CodigoTipoCausal</th>
        <th>ArticuloCausal</th>
        <th>HechosCausal</th>
        <th>EstadoCotizaciones</th>
        <th>TipoDocCotizaciones</th>
      </thead>
      <tbody>
        <?php $i=1; foreach($dt as $rm){  ?>
        <tr>
          <td><?php echo $rm->rut_tr ?></td>
          <td><?php echo $rm->dv_tr ?></td>
          <td><?php echo $rm->nombres_tr ?></td>
          <td><?php echo $rm->ap_paterno_tr ?></td>
          <td><?php echo $rm->ap_materno_tr ?></td>
          <td><?php echo $rm->comuna_tr ?></td>
          <td><?php echo $rm->sexo ?></td>
          <td><?php echo $rm->fechaNotificacion ?></td>
          <td><?php echo $rm->medio_comunicacion ?></td>
          <td><?php echo $rm->oficina_correo ?></td>
          <td><?php echo $rm->fecha_inicio ?></td>
          <td><?php echo $rm->fecha_termino ?></td>
          <td>0</td>
          <td>0</td>
          <td>6</td>
          <td>Art.159N4</td>
          <td>Los hechos en que se funda la causal invocada, consisten en el vencimiento del plazo convenido en el contrato con fecha <?php echo $rm->fecha_termino_letra ?>.</td>
          <td>Pagado</td>
          <td>1</td>
        </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>
<script type="text/javascript">
$(document).ready(function(){
  $('[data-toggle="popover"]').popover({ html : true });; 
});
</script>
<script type="text/javascript">
$(document).ready(function() {/*20-09-2018 g.r.m */
  /*alertify.prompt().set('onshow',function(){//# se incorpora para desabilitar la entrada al prompt 07-12-18
     $(this.elements.content).find('.ajs-input').attr('disabled', true); 
  });*/

    $('.solicitarBajaContrato').click(function(){//script dinamico al momento de presionar dar de baja un contrato
      //$('.ajs-input').val('Inasistencia con aviso');

        var service = $(this).attr('data-idctd');
        var nombre = $(this).attr('data-nombre');
        var planta = $(this).attr('data-planta');
          alertify.prompt('Anulación de carta de termino',"Carta Termino de "+nombre+".<br><br>Indique motivo de anulación: ", "",
            function(evt, value ){// si presiona ok hacer esto
              $.ajax({
                  type: "POST",
                  url: base_url+"est/requerimiento/anulacionCartaTermino/"+service,
                  data: {service: service, value: value, planta:planta, nombre:nombre},
                  dataType: "json",
                  success: function(data) {  
                    if (data == 1) {
                        alertify.success('Solicitud de baja enviada');
                        $('#'+service+'tr').fadeOut('slow'), function(){
                          $(this).remove();
                        }
                    }else if (data ==2) {
                      alertify.error('Debe indicar un motivo de Anulacion');
                     
                    }else{
                      alertify.error('intente recargar la pagina...');
                    }
                  }
              });
            },
            function(){// si presiona cancelar hacer esto
              alertify.error('Cancelado');
            });     
    });
});

      function remove(value){
        $('.ajs-input').val(value)
        $('ajs-button ajs-ok').prop('disabled', true);
    }
</script>
