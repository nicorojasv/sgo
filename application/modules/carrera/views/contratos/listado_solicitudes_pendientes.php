<div class="panel panel-white">
  <div class="panel-body">
    <form action="<?php echo base_url() ?>carrera/contratos/aprobacion_masiva_contrato_anexo_doc" method="post">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
        <?php if(!isset($pedientes_baja)){?>
          <div class="row">
            <!--<div class="col-md-2" style="text-align: center; margin: auto">
              Planta:
            </div>
            <div class="col-md-8">
              <select class="form-control" onchange="location = this.value">
                <option value="<?php echo base_url() ?>carrera/contratos/solicitudes_pendientes">[Todas]</option>
                <?php foreach($listado_plantas as $ep){ ?>
                <option value="<?php echo base_url() ?>carrera/contratos/solicitudes_pendientes/<?php echo $ep->id ?>" <?php if($planta_seleccionada == $ep->id) echo "selected" ?> ><?php echo $ep->nombre ?></option>
                <?php } ?>
              </select>
            </div> -->
          </div>
<?php } ?>
        </div>
        <div class="col-md-3" align="center">
          <button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
        </div>
        <?php if(!isset($pedientes_baja)){?>
        <div class="col-md-4" align="center">
          <button type="submit" class="btn btn-yellow">Aprobación Masiva</button>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-md-12" align="center">
          <table id="example1">
            <thead>
            <?php if(!isset($pedientes_baja)){?>
              <th style="text-align:center; width:6%"><input type="checkbox" onchange="togglecheckboxes(this,'solicitudes[]')" style="width:12px;"/><br>Todos</th>
            <?php } ?>
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
              <?php if(isset($pedientes_baja)){ ?>
              <th style="text-align:center; color:#EA5C5B">Motivo de baja</th>
              <?php } ?>
              <th style="text-align:center">Herramientas</th>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr>
              <?php if(!isset($pedientes_baja)){?>
                <td><input type="checkbox" name="solicitudes[]" value="<?php echo $rm->id_req_usu_arch ?>"></td>
              <?php } ?>
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
                  <?php if(isset($pedientes_baja)){ ?>
                  <td><?php echo $rm->motivoSolicitud ?></td>
                  <?php } ?>
                  <td>
                  <?php 
                   if(!isset($pedientes_baja)){?>
                    <a href="<?php echo base_url() ?>carrera/contratos/aprobar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" title="Aprobar solicitud"><i class="fa fa-check" aria-hidden="true"></i></a>
                    <a data-toggle="modal" href="<?php echo base_url() ?>carrera/contratos/modal_rechazar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-times" aria-hidden="true"></i></a>
                  <?php } 
                    if(isset($pedientes_baja)){ 
                  ?>
                    <a data-toggle="modal" href="<?php echo base_url() ?>carrera/contratos/modal_visualizar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>/bajar" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-search" style="color: red" aria-hidden="true"></i></a>
                  <?php 
                    }else{
                  ?>
                    <a data-toggle="modal" href="<?php echo base_url() ?>carrera/contratos/modal_visualizar_contrato_anexo_doc_general/<?php echo $rm->id_req_usu_arch ?>" data-target="#ModalEditar" title="Visualizar mas detalles"><i class="fa fa-search" aria-hidden="true"></i></a>
                  <?php   
                    }
                  ?>
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
        <th>Bono Gestion</th>
        <th>Bono Gestion Palabras</th>
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
        <th>UF pactada</th>
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
          <td><?php echo $rm->bono_responsabilidad ?></td>
          <td><?php echo num2letras($rm->bono_responsabilidad) ?></td>
          <td><?php echo $rm->bono_gestion ?></td>
          <td><?php echo num2letras($rm->bono_gestion) ?></td>
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
          <td><?php echo $rm->uf_pactada ?></td>
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
          <td><?php echo $rm->nombre_banco ?></td>
          <td><?php echo $rm->tipo_cuenta ?></td>
          <td><?php echo $rm->cuenta_banco ?></td>
        </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>