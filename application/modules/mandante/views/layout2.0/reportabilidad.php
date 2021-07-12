<div class="panel panel-white">
  <div class="panel-heading">
    <h4 class="panel-title"></h4>
    <div class="panel-tools">
      <div class="dropdown">
        <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
          <i class="fa fa-cog"></i>
        </a>
        <ul class="dropdown-menu dropdown-light pull-right" role="menu">
          <li>
            <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
          </li>
          <li>
            <a class="panel-refresh" href="#">
              <i class="fa fa-refresh"></i> <span>Refresh</span>
            </a>
          </li>
          <li>
            <a class="panel-config" href="#panel-config" data-toggle="modal">
              <i class="fa fa-wrench"></i> <span>Configurations</span>
            </a>
          </li>
          <li>
            <a class="panel-expand" href="#">
              <i class="fa fa-expand"></i> <span>Fullscreen</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-10" align="center"><h3 style='text-align:center;float:left;'><?php echo $requerimiento->nombre ?></h3></div>
        <div class="col-md-2" align="center">
        <input id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel"><br>
        </div>
      </div>
    
     <!--
     <div style='float:left;'>
    	<select>
    		<option>Todas los Cargos</option>
            <option>Cargo 1</option>
            <option>Cargo 2</option>
            <option>Cargo 3</option>
    		    <option>Cargo 4</option>
    	</select>
        <select>
            <option>Todas las Areas</option>
            <option>area 1</option>
            <option>area 2</option>
            <option>area 3</option>
            <option>area 4</option>
        </select>
        <select>
            <option>Todas las Causales</option>
            <option>A</option>
            <option>B</option>
            <option>C</option>
            <option>D</option>
            <option>E</option>
        </select>
        <select>
            <option>Todas las Alertas</option>
            <option>Verde</option>
            <option>Amarillo</option>
            <option>Rojo</option>
        </select>
    </div>
 -->
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
        </tr>
        <?php $i++; } ?>
    	</tbody>
    </table>
  </div>





<!--<div id="divTableDataHolder" style="display:none">-->
<div id="divTableDataHolder" style="display:none">
  <meta content="charset=UTF-8"/>
  <table id="example1">
      <thead>
        <th style="text-align:center;">Codigo Unico Requerimiento</th>
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
        <th style="text-align:center;">Renta Imponible</th>
      </thead>
      <tbody>
        <?php foreach($listado as $l){
          if ($l->sexo == 0){
            $nombre_sexo = "Masculino";
          }elseif($l->sexo == 1){
            $nombre_sexo = "Femenino";
          }else{
            $nombre_sexo = "N/D";
          }
          ?>
        <tr>
          <td><?php echo $l->codigo_requerimiento ?></td>
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
          <td><?php echo $l->renta_imponible ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>