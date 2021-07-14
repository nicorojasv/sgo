<style type="text/css">
  input:checked {
  border: 6px solid black;
}
</style>


<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
        <div class="col-md-12" align="center">
        <?php if (!isset($completa_baja)) { ?>
          <div class="col-md-8" align="left">
              <label for="datepickerEnjoySCompletas">Mes A Consultar: </label>
              <input name="datepicker" type="text" id="datepickerEnjoySCompletas" style="border: 1px solid #ccc;" class="datepicker" value="<?php if(isset($mes)) echo $mes ?>" size="10" readonly="true" title="Fecha a Gestionar Asistencia"><br>
              <input style="cursor: pointer;"  type="radio" id="historico" name="historico" value="historico"<?php if($mes == 'historico')echo "checked" ?>  onclick="historico()">
              <label for="historico" style="cursor: pointer;" >Historico</label>
          </div>
          
        <?php }else{ ?>
            <div class="col-md-8" align="left">
              <label for="datepickerEnjoyBajadas">Mes A Consultar: </label>
              <input name="datepicker" type="text" id="datepickerEnjoyBajadas" style="border: 1px solid #ccc;" class="datepicker" value="<?php if(isset($mes)) echo $mes ?>" size="10" readonly="true" title="Fecha a Gestionar Asistencia"><br>
              <input style="cursor: pointer;"  type="radio" id="historico" name="historico" value="historico"<?php if($mes == 'historico')echo "checked" ?>  onclick="historicoBajas()">
              <label for="historico" style="cursor: pointer;" >Historico</label>
          </div>  
        <?php }?>
          <div class="col-md-4" align="center">
            <form action="<?php echo base_url() ?>carrera/contratos/exportar_excel_contratos_y_anexos" method="post" target="_blank" id="FormularioExportacion">
              <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="button" class="botonExcelEnjoy btn btn-success btn-block" value="Exportar a Excel"><br>
              <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
            </form>
            <br>
        </div>
          <table id="example1">
            <thead>
              <th style="width:6%">N°</th>
              <th style="text-align:center">Solicitante</th>
              <th style="text-align: center;">Fecha Solicitudss</th>
              <?php   if (isset($completa_baja)) { ?>
              <th style="text-align: center;">Fecha Solicitud de baja</th>
              <th style="text-align: center;">Solicita baja</th>
              <?php } ?>
              <th style="text-align:center">Requerimiento</th>
              <th style="text-align:center">Empresa</th>
              <th style="text-align:center">Planta</th>
              <th style="text-align:center">Regimen</th>
              <th style="text-align:center">Nombres Trabajador</th>
              <th style="text-align:center">Rut</th>
              <th style="text-align:center">Tipo Archivo</th>
              <th style="text-align:center">Tipo Contrato</th>
              <th style="text-align:center">Causal</th>
              <th style="text-align:center">Motivo</th>
              <th style="text-align:center">Fecha Inicio</th>
              <th style="text-align:center">Fecha Termino</th>
              <th style="text-align:center">Jornada</th>
              <th style="text-align:center">Renta Imponible</th>
              <th style="text-align:center">A Pago Liquido</th>
              <th style="text-align:center">Feriado Proporcional</th>
            <?php   if (!isset($completa_baja)) { ?>
              <th style="text-align:center">Herramientas</th>
            <?php } ?>
            <?php   if (isset($completa_baja)) { ?>
              <th style="text-align:center; color:#EA5C5B">Motivo de baja</th>
            <?php } ?>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr id="<?php echo $i ?>">
                <td><?php echo $i ?></td>
                <td><?php echo ucwords(mb_strtolower($rm->nombre_completo_solicitante,'UTF-8')) ?></td>
                <td><?php echo $rm->fechaSolicitud ?></td>
                <?php   if (isset($completa_baja)) { ?>
                  <td><?php echo $rm->fechaSolicitudBaja ?></td>
                  <td><?php echo $rm->solicitaBaja ?></td>
                <?php } ?>
                <td><?php echo $rm->nombre_req ?></td>
                <td><?php echo $rm->nombre_centro_costo ?></td>
                <td><?php echo $rm->nombre_planta ?></td>
                <td><?php if($rm->regimen == "NL") echo "Normal"; elseif($rm->regimen == "CTG") echo "Contingencia"; elseif($rm->regimen == "URG") echo "Urgencia"; ?></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->nombres_apellidos,'UTF-8')) ?></a><b/></td>
                <td><?php echo $rm->rut ?></td>
                <td><?php echo $rm->tipo_archivo ?></td>
                <td><?php if($rm->id_tipo_contrato == 1) echo "Diario"; elseif($rm->id_tipo_contrato == 2) echo "Mensual"; ?></td>
                <td><?php echo $rm->causal ?></td>
                <td><?php echo $rm->motivo ?></td>
                <td><?php echo $rm->fecha_inicio ?></td>
                <td><?php echo $rm->fecha_termino ?></td>
                <td><?php echo $rm->jornada ?></td>
                <td><?php echo $rm->renta_imponible ?></td>
                <td><?php echo $rm->total_liquido_finiquito ?></td>
                <td><?php echo $rm->feriado_proporcional_finiquito ?></td>
                <?php 
                  if (!isset($completa_baja)) {                  
                ?>
                <td>
                  <a data-toggle="modal" href="<?php echo base_url() ?>carrera/contratos/modal_visualizar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-search" aria-hidden="true"></i></a>
                  <?php if($this->session->userdata('tipo_usuario') == 14 || $this->session->userdata('tipo_usuario') == 8 ){?>

                  <i class="fa fa-minus" style="color: #ccc" aria-hidden="true"></i>
                 <!-- <a href="<?php echo base_url() ?>carrera/contratos/solicitud_bajar_contrato/<?php echo $rm->id_req_usu_arch ?>" title="Solicitar baja contrato" onClick="if(confirm('¿Esta seguro de dar de baja este contrato ?')) return true; else return false;"><i class="fa fa-sign-out" style="color: red" aria-hidden="true"></i></a>-->
                  <a href="javascript:void(0)" class="solicitarBajaContrato" data-idreq="<?php echo $rm->id_req_usu_arch ?>" data-nombre="<?php echo ucwords(mb_strtolower($rm->nombres_apellidos,'UTF-8')) ?>" data-quitar="<?php echo $i ?>"><i class="fa fa-sign-out" style="color: red" aria-hidden="true"></i></a>

                  <?php } ?>

                </td>
                <?php }?>
                <?php   if (isset($completa_baja)) { ?>
                 <td><?php echo $rm->motivoSolicitud ?></td>
                <?php } ?>

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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<div id="divTableDataHolder" style="display:none">
   <meta content="charset=UTF-8"/>
  <table id="Exportar_a_Excel" style="border-collapse:collapse;">
    <thead>
      <th>Solicitante</th>
      <th >Fecha Solicitud</th>
       <?php   if (isset($completa_baja)) { ?>
              <th>Fecha Solicitud de baja</th>
              <th>Solicita baja</th>
       <?php } ?>
      <th>Regimen</th>
      <th>Nombres Trabajador</th>
      <th>Rut</th>
      <th>Nacionalidad</th>
      <th>F. Nacimiento</th>
      <th>E. Civil</th>
      <th>Domicilio</th>
      <th>Comuna</th>
      <th>Cargo</th>
      <th>Sueldo Base</th>
      <th>Sueldo Base Palabras</th>
      <th>Asig. Movilizacion</th>
      <th>Asig. Movilizacion Palabras</th>
      <th>Asig. Colacion</th>
      <th>Asig. Colacion Palabras</th>
      <th>Asig. Zona</th>
      <th>Asig. Zona Palabras</th>
      <th>Viatico</th>
      <th>Viatico Palabras</th>
      <th>AFP</th>
      <th>Salud</th>
      <th>Fecha Ingreso</th>
      <th>Fecha Termino</th>
      <th>Fecha Pago</th>
      <th>Letra Causal</th>
      <th>Motivo</th>
      <th>Telefono</th>
      <th>Turno</th>
      <th>Referido</th>
      <th>Centro de Costo</th>
      <th>Codigo CC</th>
      <th>Area de Trabajo</th>
      <th>Nivel Educacional</th>
      <th>Planta</th>
      <th>A Pago Liquido</th>
      <th>Feriado Proporcional</th>
      <th>Banco </th>
      <th>Tipo de Cuenta </th>
      <th>Numero de Cuenta</th>
      <th>Sueldo Base Mensual</th>
      <th>Nombre Requerimiento</th>
     <?php 
      if (!isset($completa_baja)) {
      ?>
          <th>Fecha Solicitud Requerimiento</th>
          <th>Comentario</th>
      
      <?php } if (isset($completa_baja)) { ?>
      <th>Motivo de Baja</th>
      <?php } ?>
    </thead>
    <tbody>
      <?php $i=1; foreach($listado as $rm){  ?>
      <tr>
        <td><?php echo ucwords(mb_strtolower($rm->nombre_completo_solicitante,'UTF-8')) ?></td>
        <td><?php echo $rm->fechaSolicitud ?></td>
        <?php   if (isset($completa_baja)) { ?>
                  <td><?php echo $rm->fechaSolicitudBaja ?></td>
                  <td><?php echo $rm->solicitaBaja ?></td>
        <?php } ?>
        <td><?php if($rm->regimen == "NL") echo "Normal"; elseif($rm->regimen == "CTG") echo "Contingencia"; elseif($rm->regimen == "URG") echo "Urgencia"; ?></td>
        <td><?php echo ucwords(mb_strtolower($rm->nombres_apellidos,'UTF-8')) ?></td>
        <td><?php echo $rm->rut ?></td>
        <td><?php echo $rm->nacionalidad ?></td>
        <td><?php echo $rm->fecha_nacimiento_texto_largo ?></td>
        <td><?php echo $rm->estado_civil ?></td>
        <td><?php echo $rm->domicilio ?></td>
        <td><?php echo $rm->ciudad ?></td>
        <td><?php echo $rm->cargo ?></td>
        <td><?php echo $rm->renta_imponible ?></td>
        <td><?php echo num2letras($rm->renta_imponible) ?></td>
        <td><?php echo $rm->asignacion_movilizacion ?></td>
        <td><?php echo num2letras($rm->asignacion_movilizacion) ?></td>
        <td><?php echo $rm->asignacion_colacion ?></td>
        <td><?php echo num2letras($rm->asignacion_colacion) ?></td>
        <td><?php echo $rm->asignacion_zona ?></td>
        <td><?php echo num2letras($rm->asignacion_zona) ?></td>
        <td><?php echo $rm->viatico ?></td>
        <td><?php echo num2letras($rm->viatico) ?></td>
        <td><?php echo $rm->prevision ?></td>
        <td><?php echo $rm->salud ?></td>
        <td><?php echo $rm->fecha_inicio_texto_largo ?></td>
        <td><?php echo $rm->fecha_termino_texto_largo ?></td>
        <td><?php echo $rm->fecha_pago_texto_largo ?></td>
        <td><?php echo $rm->causal ?></td>
        <td><?php echo $rm->motivo ?></td>
        <td><?php echo $rm->telefono ?></td>
        <td><?php echo $rm->jornada ?></td>
        <td><?php if($rm->referido == 0) echo "No"; else echo "Si"; ?></td>
        <td><?php echo $rm->nombre_centro_costo ?></td>
        <td><?php echo $rm->codigo_centro_costo ?></td>
        <td><?php echo $rm->area ?></td>
        <td><?php echo $rm->nivel_estudios ?></td>
        <td><?php echo $rm->nombre_planta ?></td>
        <td><?php echo $rm->total_liquido_finiquito ?></td>
        <td><?php echo $rm->feriado_proporcional_finiquito ?></td>
        <td><?php echo $rm->banco ?></td>
        <td><?php echo $rm->tipo_cuenta ?></td>
        <td><?php echo $rm->cuenta_banco ?></td>
        <td><?php echo $rm->sueldoMensual ?></td>
        <td><?php echo $rm->nombreRequerimiento?></td>
        <?php 
          if (!isset($completa_baja)) {
        ?>
             <td><?php echo $rm->f_solicitud ?></td>
             <td><?php echo $rm->comentario ?></td>
        <?php 
          }
        ?>

        <?php if (isset($completa_baja)) { ?>
        <td><?php echo $rm->motivoSolicitud ?></td>
        <?php } ?>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">

$(document).ready(function() {/*20-09-2018 g.r.m */
  alertify.prompt().set('onshow',function(){//# se incorpora para desabilitar la entrada al prompt 07-12-18
   $(this.elements.content).find('.ajs-input').attr('disabled', true); 
});

    $('.solicitarBajaContrato').click(function(){//script dinamico al momento de presionar dar de baja un contrato
      //$('.ajs-input').val('Inasistencia con aviso');

        var service = $(this).attr('data-idreq');
        var nombre = $(this).attr('data-nombre');
        var idQuitar = $(this).attr('data-quitar');
          alertify.prompt('Baja de Contrato',"Contrato de "+nombre+".<br><br>Especifique motivo de solicitud de baja: <select id ='motivoBaja' onchange='remove(this.value);'><option>Seleccione Motivo de baja</option><option>Inasistencia con aviso</option><option>Inasistencia sin aviso</option><option>Cambio de Fecha</option><option>Cambio de Horario</option><option>Cambio de Renta</option><option>Cambio de Cargo</option><option>Modificación Motivo</option><option>Modificación Causal</option><option>Presentarse sin Uniforme</option><option>Cambio de Ceco y/o Area</option><option>Anulación requerimiento</option><option>Duplicidad</option><option>Otro</option></select>", "",
            function(evt, value ){// si presiona ok hacer esto
              $.ajax({
                  type: "POST",
                  url: base_url+"carrera/contratos/solicitud_bajar_contrato/"+service,
                  data: {service: service, value: value},
                  dataType: "json",
                  success: function(data) {    
                    if (data == 1) {
                        alertify.success('Solicitud de baja enviada');
                        $('#'+idQuitar).fadeOut('slow'), function(){
                          $(this).remove();
                        }
                    }else{
                      alertify.error('Ops, no seleccionó motivo de baja');
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