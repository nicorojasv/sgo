
<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
         <form  method="post">
          <!--<div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-7"></div>

              <div class="col-md-3" align="center">
                <button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
              </div>
       </div>-->
    <div id="content" align="center"></div>
          <div class="col-md-12" align="center">
            <table id="example1">
              <thead>
                <th style="text-align:center">Nombre Requerimiento</th>
                <th style="text-align:center">Trabajador</th>
                <th style="text-align:center">Rut </th>
                <th style="text-align:center">F. Descarga</th>
                <th style="text-align:center">Planta</th>
                <th style="text-align:center; color: red">Anular CT</th>
              </thead>
              <tbody>
                <?php 
                $i=1; foreach($historico as $rm){ 
                 ?>
                 <?php 
                    if ($rm->contratoAscTrab != null && $rm->contratoAreaCargo != null) {
                        $url = $rm->id_trabajador.'/'.$rm->contratoAscTrab.'/'.$rm->contratoAreaCargo;                       
                    }else{
                        $url = $rm->id_trabajador.'/'.$rm->anexoAscTrab.'/'.$rm->anexoAreaCargo; 
                    }
                 ?>
                <tr id="<?php echo $rm->id.'tr'; ?>">
                    <td>
                        <?php  
                            if ($rm->contratoNombreRequerimiento != null) {
                        ?>
                               <a href="<?php echo base_url()?>correo/<?php echo $url ?>" target="_blank" data-container="body"  data-placement="top" data-toggle="popover" data-content="Ir a listado de contratos de <?php echo titleCase($rm->nombres.' '.$rm->paterno) ?>" data-trigger="hover"><?php echo titleCase($rm->contratoNombreRequerimiento); ?></a>        
                        <?php 
                            }else{
                        ?>
                                <a href="<?php echo base_url()?>correo/<?php echo $url ?>" target="_blank" data-container="body"  data-placement="top" data-toggle="popover" data-content="Ir a listado de contratos de <?php echo titleCase($rm->nombres.' '.$rm->paterno) ?>" data-trigger="hover"><?php echo titleCase($rm->anexoNombreRequerimiento); ?></a>      
                        <?php 
                            }
                        ?>
                    </td>
                    <td><?php echo titleCase($rm->nombres.' '.$rm->paterno) ?></td>
                    <td><?php echo $rm->rut_usuario ?></td>
                    <td><?php
                     $date = new DateTime( $rm->fecha_descarga);
                     ?>
                      <span data-container="body"  data-placement="top" data-toggle="popover" data-content="<?php echo $date->format('H:i') ?> hrs." data-trigger="hover"> <?php echo $date->format('d-m-Y') ?></span>
                    </td>
                    <td>
                      <?php 
                        if ($rm->anexoNombrePlanta != null) {
                          echo titleCase($rm->anexoNombrePlanta);
                          $planta = titleCase($rm->anexoNombrePlanta);
                        }else{
                          echo titleCase($rm->contratoNombrePlantas);
                          $planta = titleCase($rm->contratoNombrePlantas);

                        }
                      ?>
                    </td>
                    <td align="center">
                        <a href="javascript:void(0)" class="solicitarBajaContrato" data-idctd="<?php echo $rm->id ?>" data-nombre="<?php echo titleCase($rm->nombres.' '.$rm->paterno) ?>" data-planta="<?php echo $planta ?>">  <i class="fa fa-ban" aria-hidden="true" style="color: red"></i></a>
                    </td>
                  </tr>
                  <?php  $i++; } ?>
                </tbody>
            </table>
          </div>
        </form>
      </div>
  </div>
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