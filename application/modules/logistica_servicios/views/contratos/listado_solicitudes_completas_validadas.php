<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
        <div class="col-md-12" align="center">
          <button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
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
              <th style="text-align:center">Herramientas</th>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr>
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
                <td>
                  <label title="<?php echo str_replace("<w:br/>","\n", $rm->desc_jornada) ?>"><?php echo $rm->jornada ?></label>
                </td>
                <td><?php echo $rm->renta_imponible ?></td>
                <td>
                  <a data-toggle="modal" href="<?php echo base_url() ?>logistica_servicios/contratos/modal_visualizar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-search" aria-hidden="true"></i></a>
                </td>
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
  <meta charset="UTF-8">
  <table>
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
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>