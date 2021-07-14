<?php 
  if ($this->session->userdata('msg')) {
?>
  <script type="text/javascript">
    alertify.alert('Aprobación Masiva Exitosa', 'Proceso finalizado', function(){ });
  </script>
<?php
    $this->session->unset_userdata('msg');
  }
?>

<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
         <form action="<?php echo base_url() ?>carrera/contratos/aprobacion_masiva_anexos" method="post">
          <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-3">

              </div>
              <div class="col-md-3" align="center">
                <button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
              </div>
      
              <div class="col-md-4" align="center">
                <button type="submit" class="btn btn-yellow">Aprobación Masiva</button>
              </div>
      
       </div>
    <div id="content" align="center"></div>
          <div class="col-md-12" align="center">
            <table id="example1">
              <thead>
                 <th style="text-align:center; width:6%"><input type="checkbox" onchange="togglecheckboxes(this,'solicitudes[]')" style="width:12px;"/><br>Todos</th>
                <th style="text-align:center">Nombre Trabajador</th>
                <th style="text-align:center">Rut</th>
                <th style="text-align:center">F. Inicio Contrato</th>
                <th style="text-align:center">F. termino</th>
                <th style="text-align:center; color: blue">F. Termino Anexo</th>
                <th style="text-align:center">Causal</th>
                <th style="text-align:center">Centro Costo</th>
                <th style="text-align:center">Opcion</th>
              </thead>
              <tbody>
                <?php 
                $i=1; foreach($trabajadores as $rm){ 
                 ?>
                <tr id="<?php echo $rm->idAnexo.'tr'; ?>">
                   <td><input type="checkbox" name="solicitudes[]" value="<?php echo $rm->idAnexo ?>"></td>
                    <td><?php echo $rm->nombreTrabajador; ?></td>
                    <td><?php echo $rm->rutTrabajador ?></td>
                    <td><?php echo $rm->fechaInicioContrato ?></td>
                    <td><?php echo $rm->fechaTerminoContratoAnterior ?></td>
                    <td><?php echo $rm->fechaTerminoAnexo ?></td>
                    <td><?php  echo $rm->causalTrabajador ?></td>
                    <td><?php echo $rm->centroTrabajador ?></td>
                    <td>
                        <a href="<?php echo base_url()?>carrera/contratos/aprobar_anexo/<?php echo $rm->idAnexo; ?>" title="Aprobar"><i style="color: green;" class="fa fa-check-circle" aria-hidden="true"></i></a> 
                          |
                        <a onclick="rechazar(this)" data-nombre="<?php echo $rm->nombreTrabajador?>" data-id="<?php echo $rm->idAnexo ?>" title="Rechazar"><i style="color: red; cursor: pointer;" class="fa fa-times-circle" aria-hidden="true"></i></a>
                          |
                        <a href="<?php echo base_url()?>carrera/contratos/descargar_anexo/<?php echo $rm->idAnexo; ?>" title="Descargar"><i style="color: blue;" class="fa fa-download" aria-hidden="true"></i></a>
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

<!------Exportacion----------->
  <div id="divTableDataHolder" style="display:none">
    <meta charset="UTF-8">
    <table>
     <thead>
                <th style="text-align:center">Nombre Trabajador</th>
                <th style="text-align:center">Rut</th>
                <th style="text-align:center">Nacionalidad</th>
                <th style="text-align:center">F. Nacimiento</th>
                <th style="text-align:center">E. Civil</th>
                <th style="text-align:center">Domicilio</th>
                <th style="text-align:center">Comuna</th>
                <th style="text-align:center">AFP</th>
                <th style="text-align:center">Salud</th>
                <th style="text-align:center">F. Inicio Contrato</th>
                <th style="text-align:center">F. Termino Anexo</th>
                <th style="text-align:center">Causal</th>
                <th style="text-align:center">telefono</th>
                <th style="text-align:center">Centro Costo</th>
              </thead>
              <tbody>
                <?php 
                $i=1; foreach($trabajadores as $rm){ 
                 ?>
                <tr>
                    <td><?php echo $rm->nombreTrabajador; ?></td>
                    <td><?php echo $rm->rutTrabajador ?></td>
                    <td><?php echo $rm->nacionalidadTrabajador ?></td>
                    <td><?php echo $rm->nacimientoTrabajador ?></td>
                    <td><?php echo $rm->civilTrabajador ?></td>
                    <td><?php echo $rm->direccionTrabajador ?></td>
                    <td><?php echo $rm->ciudadTrabajador?></td>
                    <td><?php echo $rm->afpTrabajador ?></td>
                    <td><?php echo $rm->saludTrabajador ?></td>
                    <td><?php echo $rm->fechaInicioContrato ?></td>
                    <td><?php echo $rm->fechaTerminoAnexo ?></td>
                    <td><?php  echo $rm->causalTrabajador ?></td>
                    <td><?php echo $rm->telefonoTrabajador ?></td>
                    <td><?php echo $rm->centroTrabajador ?></td>

                  </tr>
                  <?php  $i++; } ?>
                </tbody>

    </table>
  </div>
  <script type="text/javascript">
    function rechazar(e){
      var nombre = $(e).attr('data-nombre');
      var id = $(e).attr('data-id');
      alertify.prompt( 'Bueno rechazemos este anexo', 'Indiquemos al Administrador de contrato el porque :', ''
               , function(evt, value) { //si
                if (value === '' || value.trim() === "") {
                    alertify.error('indique motivo de rechazo')
                    return false;
                }
                $('#content').html("<div class='loading'><img src='"+base_url+"extras/img/loader2.gif' alt='loading' /><br/>Un momento, por favor...</div>");
                    $.ajax({
                       type: "POST",
                      url: base_url+"carrera/contratos/rechazar_anexo/"+id,
                      data: {'id':id,'value':value},
                      dataType: "json",
                    }).done(function ( data ) { 
                          if (data ==1) {
                            $('#'+id+'tr').fadeOut('3000'), function(){
                                $(this).remove();
                             }
                             $('#content').fadeIn(1000).html("");
                             alertify.success('Comentario de rechazo enviado')  
                          }
                    })
                  }

               , function() { //no
                      alertify.error('Ok, no lo rechazaremos ') 
                  }).set('labels', {ok:'Rechazar', cancel:'No, mejor no!'});;;

    }
  </script>