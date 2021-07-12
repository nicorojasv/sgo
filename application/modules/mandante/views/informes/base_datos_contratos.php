<div class="panel panel-white">
  <div class="panel-body">
    <div class="row">
        <div class="col-md-7" align="center">
          <h4 style='text-align:center;float:left;'><b>PLANTA: </b><?php echo $empresa_planta->nombre ?></h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4" align="rigth"><b>Base de Datos Excel</b>
          <select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
            <option title="INFORME ACTUAL: BASE DE DATOS DE CONTRATOS EXPORTACION A EXCEL" value="#">Base de Datos de Contratos</option>
            <option title="TRAZABILIDAD DOTACION POR PLANTAS" value="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $id_planta ?>">Avance de Contrataciones</option>
            <option title="REPORTABILIDAD DOTACION EQUIVALENTE/CANTIDAD CONTRATOS/POR TRABAJADOR" value="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $id_planta ?>">Reportabilidad Dotaci&oacute;n</option>
            <option title="REPORTABILIDAD CAUSALES DE CONTRATOS" value="<?php echo base_url() ?>mandante/reporte_causales/<?php echo $id_planta ?>">Reportabilidad Causales</option>
            <option title="INDICADOR DE PERMANENCIA" value="<?php echo base_url() ?>mandante/indicador_permanencia/<?php echo $id_planta ?>">Indicador de Permanencia</option>
          </select>
            <br><br>
        </div>
        <div class="col-md-2" align="center">
          Activos: <span class='badge' style='background-color:#3E9610'>A</span><br> Inactivos: <span class='badge' style='background-color:#DAAA08'>I</span>
        </div>
        <div class="col-md-3" align="center"></div>

        <div class="col-md-3" align="center">
            <form action="<?php echo base_url() ?>mandante/exportar_excel" method="post" target="_blank" id="FormularioExportacion">
              <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="button" src="<?php echo base_url() ?>extras/imagenes/Excel-Export.jpg" class="botonExcelArauco " value="Exportar a Excel"><br>
              <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
            </form>
            <br>
      </div>
      </div>
    <div class='clear'></div>
    <table id="example1">
    	<thead>
        <th style="text-align:center;">Nombre</th>
    		<th style="text-align:center;">Cargo</th>
    		<th style="text-align:center;">Area</th>
        <th style="text-align:center;">Tipo Causal</th>
        <th style="text-align:center;">Dias Causal</th>
        <th style="text-align:center;">Fecha Inicio</th>
        <th style="text-align:center;">Fecha Término</th>
        <th style="text-align:center;">Tiempo Duracion Contrato</th>
        <th style="text-align:center;">Estado</th>
    	</thead>
    	<tbody>
        <?php $i=0; ?>
        <?php foreach($listado as $l){  ?>
    		<tr>
          <td><b><a href='<?php echo base_url() ?>mandante/perfil2/<?php echo $l->usuario_id ?>' target="_blank"><?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?></a><b/></td>
    			<td style="text-align:center;"><?php echo ucwords(mb_strtolower($l->cargo,'UTF-8')) ?></td>
          <td style="text-align:center;"><?php echo ucwords(mb_strtolower($l->area,'UTF-8')) ?></td>
          <td style="text-align:center;"><?php echo $l->causal ?></td>
    			<td style="text-align:center;"><?php echo $l->dias_causal ?></td>
    			<td style="text-align:center;"><?php echo $l->fecha_inicio ?></td>
          <td style="text-align:center;"><?php echo $l->fecha_termino ?></td>
          <td style="text-align:center;"><?php echo $l->dias_contrato ?></td>
          <td style="text-align:center"><?php echo ($l->estado_req)?"<span class='badge' style='background-color:#3E9610' title='".$l->nombre_req."'>A</span>":"<span class='badge' style='background-color:#DAAA08' title='".$l->nombre_req."'>I</span>"; ?></td>
        </tr>
        <?php $i++; } ?>
    	</tbody>
    </table>
  </div>


<!--<div id="divTableDataHolder" style="display:none">-->
<div id="divTableDataHolder" style="display:none">
  <meta content="charset=UTF-8"/>
  <table id="Exportar_a_Excel" >
      <thead>
        <th style="text-align:center;">Codigo Unico Requerimiento</th>
        <th style="text-align:center;">Nombre Requerimiento</th>
        <th style="text-align:center;">Nombre empresa EST</th>
        <th style="text-align:center;">Rut empresa EST</th>
        <th style="text-align:center;">Nombres</th>
        <th style="text-align:center;">Rut</th>
        <th style="text-align:center;">Sexo</th>
        <th style="text-align:center;">Ciudad</th>
        <th style="text-align:center;">Area</th>
        <th style="text-align:center;">Cargo</th>
        <th style="text-align:center;">Centro Costo</th>
        <th style="text-align:center;">Causal Legal Contratacion</th>
        <th style="text-align:center;">Motivo de Contratacion</th>
        <th style="text-align:center;">Dias Causal</th>
        <th style="text-align:center;">Jornada</th>
        <th style="text-align:center;">Fecha Inicio</th>
        <th style="text-align:center;">Fecha Termino</th>
        <th style="text-align:center;">Tiempo Duracion Contrato</th>
        <th style="text-align:center;">Nivel Educacional</th>
        <th style="text-align:center;">Estado Trabajador</th>
        <th style="text-align:center;">Sueldo Base</th>
        <th style="text-align:center;">Bono Responsabilidad</th>
        <th style="text-align:center;">Sueldo Base + Bonos Fijos</th>
        <th style="text-align:center;">Asignacion Colacion</th>
        <th style="text-align:center;">Otros no Imponibles</th>
        <th style="text-align:center;">Seguro de Vida Arauco</th>
      </thead>
      <tbody>

         <?php $i=0; ?>
        <?php foreach($listado as $l){
          if ($l->sexo == 0){
            $nombre_sexo = "Masculino";
          }elseif($l->sexo == 1){
            $nombre_sexo = "Femenino";
          }else{
            $nombre_sexo = "N/D";
          }
          ?>
                
         <tr style="text-align:center;">
          <td><?php echo $l->codigo_requerimiento ?></td>
          <td><?php echo $l->nombre_req ?></td>
          <td>Integra EST Ltda.</td>
          <td>76.735.710-9</td>
          <td><?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?></td>
          <td><?php echo ucwords(mb_strtolower($l->rut_usuario,'UTF-8')) ?></td>
          <td><?php echo $nombre_sexo ?></td>
          <td><?php echo $l->ciudad ?></td>
          <td><?php echo ucwords(mb_strtolower($l->area,'UTF-8')) ?></td>
          <td><?php echo ucwords(mb_strtolower($l->cargo,'UTF-8')) ?></td>
          <td><?php echo $l->nombre_planta ?></td>
          <td><?php echo $l->causal ?></td>
          <td><?php echo $l->motivo ?></td>
          <td><?php echo $l->dias_causal ?></td>
          <td><?php echo $l->jornada ?></td>
          <td><?php echo $l->fecha_inicio ?></td>
          <td><?php echo $l->fecha_termino ?></td>
          <td><?php echo $l->dias_contrato ?></td>
          <td><?php echo $l->nivel_estudios ?></td>
          <td>
            <?php if(!empty($l->estado_req)){ ?>Activo
            <?php } else{ ?>Inactivo
            <?php } ?>
          </td>
          <td><?php echo $l->renta_imponible ?></td>
          <td><?php echo $l->bono_responsabilidad ?></td>
          <td><?php echo $l->sueldo_base_mas_bonos_fijos ?></td>
          <td><?php echo $l->asignacion_colacion ?></td>
          <td><?php echo $l->otros_no_imponibles ?></td>
          <td><?php echo $l->seguro_vida_arauco ?></td>
        </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
</div>