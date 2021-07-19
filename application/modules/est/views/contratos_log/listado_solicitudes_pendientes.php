<style type="text/css">
  /* Pulse */
  @-webkit-keyframes hvr-pulse {
    25% {
      -webkit-transform: scale(1.1);
      transform: scale(1.1);
    }
    75% {
      -webkit-transform: scale(0.9);
      transform: scale(0.9);
    }
  }
  @keyframes hvr-pulse {
    25% {
      -webkit-transform: scale(1.1);
      transform: scale(1.1);
    }
    75% {
      -webkit-transform: scale(0.9);
      transform: scale(0.9);
    }
  }
  .hvr-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  }
  .hvr-pulse:hover, .hvr-pulse:focus, .hvr-pulse:active {
    -webkit-animation-name: hvr-pulse;
    animation-name: hvr-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
  }

  /* Icon Spin */
  .hvr-icon-spin {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  }
  .hvr-icon-spin .hvr-icon {
    -webkit-transition-duration: 1s;
    transition-duration: 1s;
    -webkit-transition-property: transform;
    transition-property: transform;
    -webkit-transition-timing-function: ease-in-out;
    transition-timing-function: ease-in-out;
  }
  .hvr-icon-spin:hover .hvr-icon, .hvr-icon-spin:focus .hvr-icon, .hvr-icon-spin:active .hvr-icon {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
    color:red;
  }
</style>
<div class="panel panel-white">
  <div class="panel-body">
    <form action="<?php echo base_url() ?>est/contratos_log/aprobacion_masiva_contrato_anexo_doc" method="post">
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
          <br>
          <button id="myButtonControlID" class="btn btn-green">Exportarcito a Excel</button>
          <button type="submit" class="btn btn-yellow">Aprobación Masiva</button>
          <br><br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" align="center">
          <table id="example1">
            <thead>
              <th style="text-align:center; width:6%"><input type="checkbox" onchange="togglecheckboxes(this,'solicitudes[]')" style="width:12px;"/><br>Todos</th>
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
              <th style="text-align:center">Herramientas</th>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr>
                <td><input type="checkbox" name="solicitudes[]" value="<?php echo $rm->id_req_usu_arch ?>"></td>
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
                  <td>
                    <label title="<?php echo str_replace("<w:br/>","\n", $rm->desc_jornada) ?>"><?php echo $rm->jornada ?></label>
                  </td>
                  <td><?php echo $rm->renta_imponible ?></td>
                  <td>
                    <a href="<?php echo base_url() ?>est/contratos_log/aprobar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" title="Aprobar solicitud"><i class="fa fa-check hvr-pulse" aria-hidden="true"></i></a>-
                    <a data-toggle="modal" href="<?php echo base_url() ?>est/contratos_log/modal_rechazar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles" class="hvr-icon-spin"><i class="fa fa-times  hvr-icon" aria-hidden="true"></i></a>-
                    <a data-toggle="modal" href="<?php echo base_url() ?>est/contratos_log/modal_visualizar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </td>
                </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
      </form>
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
    <meta charset="UTF-8">
    <table>
      <thead>
        <th>Solicitantesss</th>
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
        <th>Banco </th>
        <th>codigo_banco<th>
        <th>codigo Uny </th>
        <th>Numero de Cuenta</th>
      </thead>
      <tbody>
        <?php $i=1; foreach($listado as $rm){  ?>
        <tr>
          <td><?php echo ucwords(mb_strtolower($rm->nombre_completo_solicitante,'UTF-8')) ?></td>
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
          <td><?php echo $rm->banco ?></td>
          <td><?php echo $rm->tipo_cuenta ?></td>
          <td><?php echo $rm->codigoUny  ?></td>
          <td><?php echo $rm->cuenta_banco ?></td> 
        </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div> 