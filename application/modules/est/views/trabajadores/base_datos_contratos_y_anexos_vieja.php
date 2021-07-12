<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
        <div class="col-md-10" align="center"></div>
        <div class="col-md-2" align="center">
          <form action="<?php echo base_url() ?>est/trabajadores/exportar_excel_contratos_y_anexos" method="post" target="_blank" id="FormularioExportacion">
            <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="submit" class="botonExcel btn btn-primary btn-block" value="Exportar a Excel"><br>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
          </form>
          <!--<input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel">--><br>
        </div>
      </div>
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
              <th>URL</th>
              <th>Causal</th>
              <th>Motivo</th>
              <th>Inicio contrato</th>
              <th>Termino contrato</th>
              <th>Jornada</th>
              <th>Renta imponible</th>
              <th>Bono<br>responsabilidad</th>
              <th>Sueldo base<br>mas bonos fijos</th>
              <th>Asginacion colacion</th>
              <th>Otros no imponibles</th>
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
                <td>
                  <?php if($rm->url != NULL and $rm->url != ""){ ?>
                    <a href="<?php echo base_url().$rm->url ?>" target="_blank"> VER </a>
                  <?php }else{ ?>
                    <font color="red">S/D</font>
                  <?php } ?>
                </td>
                <td><?php echo $rm->causal ?></td>
                <td><?php echo $rm->motivo ?></td>
                <td><?php echo $rm->fecha_inicio ?></td>
                <td><?php echo $rm->fecha_termino ?></td>
                <td><?php echo $rm->jornada ?></td>
                <td><?php echo $rm->renta_imponible ?></td>
                <td><?php echo $rm->bono_responsabilidad ?></td>
                <td><?php echo $rm->sueldo_base_mas_bonos_fijos ?></td>
                <td><?php echo $rm->asignacion_colacion ?></td>
                <td><?php echo $rm->otros_no_imponibles ?></td>
                <td><?php echo $rm->seguro_vida_arauco ?></td>
              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
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
      <th>Bono<br>responsabilidad</th>
      <th>Sueldo base<br>mas bonos fijos</th>
      <th>Asginacion colacion</th>
      <th>Otros no imponibles</th>
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
        <td><?php echo $rm->bono_responsabilidad ?></td>
        <td><?php echo $rm->sueldo_base_mas_bonos_fijos ?></td>
        <td><?php echo $rm->asignacion_colacion ?></td>
        <td><?php echo $rm->otros_no_imponibles ?></td>
        <td><?php echo $rm->seguro_vida_arauco ?></td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>
</div>