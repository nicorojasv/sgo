<div class="panel panel-white">
  <div class="panel-body">
    <div class="row">
     
      <div class="col-md-3">
      <?php if (!isset($completa_baja)) { ?>
        <div class="row">
          <div class="col-md-2" style="text-align: center; margin: auto">
            Planta:
          </div>
          <div class="col-md-10">
            <select class="form-control" onchange="location = this.value">
              <option value="<?php echo base_url() ?>carrera/contratos/solicitudes_completas">[Todas]</option>
              <?php foreach($listado_plantas as $ep){ ?>
              <option value="<?php echo base_url() ?>carrera/contratos/solicitudes_completas/<?php echo $ep->id ?>" <?php if($planta_seleccionada == $ep->id) echo "selected" ?> ><?php echo $ep->nombre ?></option>
              <?php } ?>
            </select>
          </div>
                    <div class="col-md-8" align="left">
              <label for="datepickerAraucoSCompletas">Mes A Consultar: </label>
              <input name="datepicker" type="text" id="datepickerAraucoSCompletas" style="border: 1px solid #ccc;" class="datepicker" value="<?php if(isset($mes)) echo $mes ?>" size="10" readonly="true" title="Fecha a Gcarreraionar Asistencia"><br>
              <input style="cursor: pointer;"  type="radio" id="historico" name="historico" value="historico"<?php if($mes == 'historico')echo "checked" ?>  onclick="historico()" >
      <label for="historico" style="cursor: pointer;" >Historico</label>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="col-md-3"></div>
      
      <div class="col-md-3" align="center">
            <form action="<?php echo base_url() ?>carrera/contratos/exportar_excel_contratos_y_anexos" method="post" target="_blank" id="FormularioExportacion">
              <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="image" src="<?php echo base_url() ?>extras/imagenes/Excel-Export.jpg" class="botonExcelArauco " value="Exportar a Excel"><br>
              <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
            </form>
            <br>
      </div>
      <!--<div class="col-md-4" align="center">
        <button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
      </div>-->
    </div>
    <div class="row">
      <div class="col-md-12" align="center">
        <table id="example1">
          <thead>
            <th style="width:6%">N°</th>
            <th style="text-align:center">Solicitante</th>
            <th style="text-align:center">Requerimiento</th>
            <th style="text-align:center">Planta</th>
            <th style="text-align:center">Nombres Trabajador</th>
            <th style="text-align:center">Rut</th>
            <th style="text-align:center">Tipo Archivo</th>
            <th style="text-align:center">Causal</th>
            <th style="text-align:center">Motivo</th>
            <th style="text-align:center">Fecha Inicio</th>
            <th style="text-align:center">Fecha Termino</th>
            <th style="text-align:center">Jornada</th>
            <th style="text-align:center">Renta Imponible</th>
            <?php if (!isset($completa_baja)) { ?>
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
              <td><?php echo $rm->nombre_req ?></td>
              <td><?php echo $rm->nombre_planta ?></td>
              <td><b><a><?php echo ucwords(mb_strtolower($rm->nombres_apellidos,'UTF-8')) ?></a><b/></td>
                <td><?php echo $rm->rut ?></td>
                <td><?php echo $rm->tipo_archivo ?></td>
                <td><?php echo $rm->causal ?></td>
                <td><?php echo $rm->motivo ?></td>
                <td><?php echo $rm->fecha_inicio ?></td>
                <td><?php echo $rm->fecha_termino ?></td>
                <td><?php echo $rm->jornada ?></td>
                <td><?php echo $rm->renta_imponible ?></td>
                <?php if (!isset($completa_baja)) { ?>
                <td>
                  <a data-toggle="modal" href="<?php echo base_url() ?>carrera/contratos/modal_visualizar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-search" aria-hidden="true"></i></a>
                  <?php 
                    if($this->session->userdata('tipo_usuario') == 2 || 
                       $this->session->userdata('tipo_usuario') == 4 ||  
                       $this->session->userdata('tipo_usuario') == 8   ){ 
                  ?>
                        <i class="fa fa-minus" style="color: #ccc" aria-hidden="true"></i>
                        <a href="javascript:void(0)" class="solicitarBajaContrato" title="Solicitar baja de contrato" data-idreq="<?php echo $rm->id_req_usu_arch ?>" data-nombre="<?php echo ucwords(mb_strtolower($rm->nombres_apellidos,'UTF-8')) ?>" data-quitar="<?php echo $i ?>"><i class="fa fa-sign-out" style="color: red" aria-hidden="true"></i></a>
                  <?php } ?>
                </td>
                <?php } ?>
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
        <th>Bono Responsabilidad</th>
        <th>Bono Responsabilidad Palabras</th>
        <th>Bono Gcarreraion</th>
        <th>Bono Gcarreraion Palabras</th>
        <th>Bono Confianza</th>
        <th>Bono Confianza Palabras</th>
        <th>Asig. Movilizacion</th>
        <th>Asig. Movilizacion Palabras</th>
        <th>Asig. Colacion</th>
        <th>Asig. Colacion Palabras</th>
        <th>Asig. Zona</th>
        <th>Asig. Zona Palabras</th>
        <th>Asig. Herramientas</th>
        <th>Asig. Herramientas Palabras</th>
        <th>Viatico</th>
        <th>Viatico Palabras</th>
        <th>AFP</th>
        <th>Salud</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Termino</th>
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
        <th>nombre_banco</th>
        <th>tipo_cuenta</th>
        <th>cuenta_banco</th>
        <?php if (isset($completa_baja)) { ?>
        <th>Motivo de Baja</th>
      <?php } ?>
      </thead>
      <tbody>
        <?php $i=1; foreach($listado as $rm){  ?>
        <tr>
          <td><?php echo ucwords(mb_strtolower($rm->nombre_completo_solicitante,'UTF-8')) ?></td>
          <td><?php echo ucwords(mb_strtolower($rm->nombres_apellidos,'UTF-8')) ?></td>
          <td><?php echo $rm->rut ?></td>
          <td><?php echo $rm->nacionalidad ?></td>
          <td><?php echo $rm->fecha_nacimiento_texto_largo ?></td>
          <td><?php echo $rm->carreraado_civil ?></td>
          <td><?php echo $rm->domicilio ?></td>
          <td><?php echo $rm->ciudad ?></td>
          <td><?php echo $rm->cargo ?></td>
          <td><?php echo $rm->renta_imponible ?></td>
          <td><?php echo num2letras($rm->renta_imponible) ?></td>
          <td><?php echo $rm->bono_responsabilidad ?></td>
          <td><?php echo num2letras($rm->bono_responsabilidad) ?></td>
          <td><?php echo $rm->bono_gcarreraion ?></td>
          <td><?php echo num2letras($rm->bono_gcarreraion) ?></td>
          <td><?php echo $rm->bono_confianza ?></td>
          <td><?php echo num2letras($rm->bono_confianza) ?></td>
          <td><?php echo $rm->asignacion_movilizacion ?></td>
          <td><?php echo num2letras($rm->asignacion_movilizacion) ?></td>
          <td><?php echo $rm->asignacion_colacion ?></td>
          <td><?php echo num2letras($rm->asignacion_colacion) ?></td>
          <td><?php echo $rm->asignacion_zona ?></td>
          <td><?php echo num2letras($rm->asignacion_zona) ?></td>
          <td><?php echo $rm->asignacion_herramientas ?></td>
          <td><?php echo num2letras($rm->asignacion_herramientas) ?></td>
          <td><?php echo $rm->viatico ?></td>
          <td><?php echo num2letras($rm->viatico) ?></td>
          <td><?php echo $rm->prevision ?></td>
          <td><?php echo $rm->salud ?></td>
          <td><?php echo $rm->fecha_inicio_texto_largo ?></td>
          <td><?php echo $rm->fecha_termino_texto_largo ?></td>
          <td><?php echo $rm->causal ?></td>
          <td><?php echo $rm->motivo ?></td>
          <td><?php echo $rm->telefono ?></td>
          <td><?php echo $rm->jornada ?></td>
          <td><?php if($rm->referido == 0) echo "No"; else echo "Si"; ?></td>
          <td><?php echo $rm->nombre_centro_costo ?></td>
          <td><?php echo $rm->codigo_centro_costo ?></td>
          <td><?php echo $rm->area ?></td>
          <td><?php echo $rm->nivel_carreraudios ?></td>
          <td><?php echo $rm->nombre_planta ?></td>
          <td><?php echo $rm->nombre_banco ?></td>
          <td><?php echo $rm->tipo_cuenta ?></td>
          <td><?php echo $rm->cuenta_banco ?></td>
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
          $('.solicitarBajaContrato').click(function(){//script dinamico al momento de presionar dar de baja un contrato
              var service = $(this).attr('data-idreq');
              var nombre = $(this).attr('data-nombre');
              var idQuitar = $(this).attr('data-quitar');
                alertify.prompt('Baja de Contrato',"Contrato de "+nombre+".<br><br>Especifique motivo de solicitud de baja.", "",
                  function(evt, value ){// si presiona ok hacer carrerao
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
                            alertify.error('Ops , no es posible en carreraos momentos');
                          }
                        }
                    });
                  },
                  function(){// si presiona cancelar hacer carrerao
                    alertify.error('Cancelado');
                  }).set('labels', {ok:'Enviar', cancel:'cancelar'});     
          });
      });
</script>