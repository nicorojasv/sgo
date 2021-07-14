
<div class="panel panel-white">
  <div class="panel-body">
      <div class="row" style="padding-left: 10px; margin-bottom: 10px;">
        <div class="col-md-10" style="border: 1px solid #ccc; padding-bottom: 10px;">
          <form action="<?php echo base_url() ?>carrera/trabajadores/contratos_y_anexos" method="post" id="FormularioGet">
          <label for="seleccion_planta"><h4>Planta: </h4></label>
            <select name="nombrePlantaSeleccionada" id="seleccion_planta">
            
            <option value="todasLasPlantas"<?php if(isset($plantaSeleccionada)){if($plantaSeleccionada == 'todasLasPlantas'){echo "selected";}} ?> >carrera </option>

            </select>
            <br><br>
            <div id="tipoSeleccion" class="row" style="padding:0;margin: 0;">
              <h4>Selecione Un tipo de busqueda</h4>
              <div class="col-md-3">
                <label for="estadoContratacion">Estado de Contratación</label> <input type="radio" class="seleccionFiltro" id="estadoContratacion" name="vigencia" value="vigencia" <?php if(isset($inptradio)){ if($inptradio == 'vigencia')echo "checked";} ?>>
              </div>
              <div class="col-md-3">
              <label for="rangoFecha">Rango de fecha </label> <input type="radio" class="seleccionFiltro" id="rangoFecha" name="vigencia" value="rango" <?php if(isset($inptradio)){ if($inptradio == 'rango')echo "checked";} ?>>
              </div>
            </div>
             <br><br>
            <div id="divContratacion"  style="<?php if(isset($estado)){echo "";}else{ echo "display:none;";}?> ;padding:0;margin: 0; ">
                <label for="vigencia">Buscar con :</label>
                <select name="estado" id="vigencia">
                <option selected disabled >Seleccione</option>
                  <option value="vigente" <?php if(isset($estado))echo ($estado == 'vigente')?'selected':''; ?>>Contrato Vigente</option>
                  <option value="no_vigente" <?php if(isset($estado)) echo ($estado == 'no_vigente')?'selected':''; ?>>Contrato Finalizado</option>
                </select>
            </div>
        
                <div class="col-md-6 input-group input-daterange" id="divRangoFecha" style=" <?php if(isset($fechaFiltroInicio)){echo "";}else{ echo "display:none;";}?> ;padding:0;margin: 0; ">
                    <input type="text" style="border: 1px solid #ccc" class="form-control" name="fecha_inicio" id="datepicker" autocomplete="off" value="<?php if (isset($fechaFiltroInicio)){echo $fechaFiltroInicio;} ?>" placeholder="Fecha Inicio">
                    <div class="input-group-addon" style="background: #428bca">Hasta</div>
                    <input type="text" style="border: 1px solid #ccc"  class="form-control" name="fecha_termino" id="datepicker2" autocomplete="off" value="<?php if (isset($fechaFiltroTermino)){echo $fechaFiltroTermino; } ?>" placeholder="Fecha Fin">
                </div>
                <br><br>
            <input type="submit" class="btn btn-primary" name="Obtener" value="Generar Busqueda">
          </form>

        </div>
        <?php if(!empty($listado)){ ?>
        <div class="col-md-2" align="center">
          <form action="<?php echo base_url() ?>carrera/trabajadores/exportar_excel_contratos_y_anexos" method="post" target="_blank" id="FormularioExportacion">
            <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="submit" class="botonExcel btn btn-success btn-block" value="Exportar a Excel"><br>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
          </form>
          <!--<input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel">--><br>
        </div>
        <?php }?>
      </div>
 <?php if(!empty($listado)){ ?>
      <div class="row">
        <div class="col-md-12" align="center">
          <table id="example1">
            <thead>
              <th>N°</th>
              <th>Nombres</th>
              <th>Paterno</th>
              <th>Materno</th>
              <th>Rut</th>
              <th>Codigo<br>requerimiento</th>
              <th>Nombre<br>requerimiento</th>
              <th>Area</th>
              <th>Cargo</th>
              <th>Referido</th>
              <th>Fecha solicitud</th>
              <th>Fecha inicio</th>
              <th>Fecha termino</th>
              <th>Empresa</th>
              <th>Documento</th>
              <th>Causal</th>
              <th>Motivo</th>
              <th>Inicio contrato</th>
              <th>Termino contrato</th>
              <th>Jornada</th>
              <th>Renta imponible</th>
              <th>Asginacion colacion</th>
              <th>Seguro de vida arauco</th>
            </thead>
            <tbody>
              <?php $i=1; foreach($listado as $rm){  ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->nombre_usuario,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->paterno,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->materno,'UTF-8')) ?></a><b/></td>
                <td><b><a><?php echo ucwords(mb_strtolower($rm->rut_usuario,'UTF-8')) ?></a><b/></td>
                <td><?php echo $rm->codigo_requerimiento ?></td>
                <td><?php echo $rm->nombre_req ?></td>
                <td><?php echo $rm->nombre_area ?></td>
                <td><?php echo $rm->nombre_cargo ?></td>
                <td>
                  <?php if($rm->referido == 1){
                    echo "SI";
                  }elseif($rm->referido == 0){
                    echo "NO";
                  } ?>
                </td>
                <td><?php echo $rm->f_solicitud ?></td>
                <td><?php echo $rm->fecha_inicio_req ?></td>
                <td><?php echo $rm->f_fin_req ?></td>
                <td><?php echo $rm->nombre_empresa ?></td>
                <td>
                  <?php if($rm->tipo_archivo == 1){
                    echo "Contrato";
                  }elseif($rm->tipo_archivo == 2){
                    echo "Anexo de Contrato";
                  } ?>
                </td>

                <td><?php echo $rm->causal ?></td>
                <td style="width: 20%"><?php echo $rm->motivo ?></td>
                <td><?php echo $rm->fecha_inicio ?></td>
                <td><?php echo $rm->fecha_termino ?></td>
                <td><?php echo $rm->jornada ?></td>
                <td><?php echo $rm->renta_imponible ?></td>
                <td><?php echo $rm->asignacion_colacion ?></td>
                <td><?php echo $rm->seguro_vida_arauco ?></td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php }?>
  </div>
</div>

<!--<div id="divTableDataHolder" style="display:none">-->
<div id="divTableDataHolder" style="display:none">
  <meta content="charset=UTF-8"/>
  <table width="50%" border="1" cellpadding="10" cellspacing="0" bordercolor="#666666" id="Exportar_a_Excel" style="border-collapse:collapse;">
    <thead>
      <th>N°</th>
      <th>Nombres</th>
      <th>Paterno</th>
      <th>Materno</th>
      <th>Rut</th>
      <th>Codigo<br>requerimiento</th>
      <th>Nombre<br>requerimiento</th>
      <th>Area</th>
      <th>Cargo</th>
      <th>Referido</th>
      <th>Fecha solicitud</th>
      <th>Fecha inicio</th>
      <th>Fecha termino</th>
      <th>Empresa</th>
      <th>Documento</th>
      <th>Causal</th>
      <th>Motivo</th>
      <th>Inicio contrato</th>
      <th>Termino contrato</th>
      <th>Jornada</th>
      <th>Renta imponible</th>
      <th>Asginacion colacion</th>
      <th>Seguro de vida arauco</th>
    </thead>
    <tbody>
      <?php $i=1; foreach($listado as $rm){  ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><b><a><?php echo ucwords(mb_strtolower($rm->nombre_usuario,'UTF-8')) ?></a><b/></td>
        <td><b><a><?php echo ucwords(mb_strtolower($rm->paterno,'UTF-8')) ?></a><b/></td>
        <td><b><a><?php echo ucwords(mb_strtolower($rm->materno,'UTF-8')) ?></a><b/></td>
        <td><b><a><?php echo ucwords(mb_strtolower($rm->rut_usuario,'UTF-8')) ?></a><b/></td>
        <td><?php echo $rm->codigo_requerimiento ?></td>
        <td><?php echo $rm->nombre_req ?></td>
        <td><?php echo $rm->nombre_area ?></td>
        <td><?php echo $rm->nombre_cargo ?></td>
        <td>
          <?php if($rm->referido == 1){
            echo "SI";
          }elseif($rm->referido == 0){
            echo "NO";
          } ?>
        </td>
        <td><?php echo $rm->f_solicitud ?></td>
        <td><?php echo $rm->fecha_inicio_req ?></td>
        <td><?php echo $rm->f_fin_req ?></td>
        <td><?php echo $rm->nombre_empresa ?></td>
        <td>
          <?php if($rm->tipo_archivo == 1){
            echo "Contrato de Trabajo";
          }elseif($rm->tipo_archivo == 2){
            echo "Anexo de Contrato";
          } ?>
        </td>
        <td><?php echo $rm->causal ?></td>
        <td><?php echo $rm->motivo ?></td>
        <td><?php echo $rm->fecha_inicio ?></td>
        <td><?php echo $rm->fecha_termino ?></td>
        <td><?php echo $rm->jornada ?></td>
        <td><?php echo $rm->renta_imponible ?></td>
        <td><?php echo $rm->asignacion_colacion ?></td>
        <td><?php echo $rm->seguro_vida_arauco ?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>
