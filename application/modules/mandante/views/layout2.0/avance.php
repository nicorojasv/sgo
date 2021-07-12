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
		<div class="row-fluid">
			<div class="row">
				<div class="col-md-4" align="center"></div>
				<div class="col-md-3" align="center">
					<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
					  	<option value="#">Avance Contratacion</option>
					  	<option value="<?php echo base_url() ?>mandante/causales_contratacion/<?php echo $id_requerimiento ?>">Causales de Contratacion</option>
					</select>
	  				<br><br>
				</div>
			</div>
			<div class="span8 offset2" >
				<div style='border: 1px solid black;padding-top:20px;padding-bottom:20px;padding-left:10px; padding-right:10px'>
					<div class='pgp-left' style='float:left' >
						<?php 
						$desde_aux = explode('-', $requerimiento->f_inicio);
						$hasta_aux = explode('-', $requerimiento->f_fin);
						$desde = $desde_aux[2].'/'.$desde_aux[1].'/'.$desde_aux[0];
						$hasta = $hasta_aux[2].'/'.$hasta_aux[1].'/'.$hasta_aux[0];

						$no_en_servicio = $personas - $servicio;
						$no_en_proceso = $personas - $proceso;
						$no_en_no_disponible = $personas - $no_disponible;
						$no_en_no_contactado = $personas - $no_contactado;
						$no_en_referido = $personas - $referido;
						?>
						<div class='pgp-title'><?php echo $requerimiento->nombre ?></div>
						<div class='pgp-subtitle'><small>Periodo <?php echo $desde ?> al <?php echo $hasta ?></small></div>
					</div>
					<div class='pgp-center' style='float:left; margin-left:140px' >
						<span class='' style='float:left'>Dotaci&oacute;n: <?php echo $personas ?></span>
						<div class="progressBar progressBar1" style='margin-left:10px;float:left'><div></div></div>
					</div>
					<div class='pgp-right' style='float:right' >
						<div class=''><span class='circulito verde'></span>En Servicio: <?php echo $servicio ?> <span class='circulito rojo'></span>En Proceso: <?php echo $proceso ?></div>
					</div>
					<div class='clear'></div>
					<div id="porcentaje_total" style="display: none;"><?php echo $porcentaje ?></div>
					<br>
				</div>
			</div>
			<div class="span10 offset1" style="margin-top:20px;">
				<div class='span12'>
					<table class='table table-hover table-condensed table-striped'>
						<thead style="background-color:#D7D7D7">
							<th style="text-align:center;width:220px"><b>Item</b></th>
							<th style="text-align:center;"><b>Si</b></th>
							<th style="text-align:center;"><b>No</b></th>
							<th style="text-align:center;"><b>Avance(%)</b></th>
							<th style="text-align:center;"><b>Progreso</b></th>
						</thead>
						<tbody>
							<tr>
								<td><b>En Proceso</b></td>
								<td style="text-align:center;"><?php echo $proceso ?></td>
								<td style="text-align:center;"><?php echo $no_en_proceso ?></td>
								<td style="text-align:center;" id="porcentaje_contactados"><?php echo $porcentaje_proceso ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar2" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>En Servicio</b></td>
								<td style="text-align:center;"><?php echo $servicio ?></td>
								<td style="text-align:center;"><?php echo $no_en_servicio ?></td>
								<td style="text-align:center;" id="porcentaje_disponibilidad"><?php echo $porcentaje ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar3" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>Referido</b></td>
								<td style="text-align:center;"><?php echo $referido ?></td>
								<td style="text-align:center;"><?php echo $no_en_referido ?></td>
								<td style="text-align:center;" id="porcentaje_certificacion"><?php echo $porcentaje_referido ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar4" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>No Disponible</b></td>
								<td style="text-align:center;"><?php echo $no_disponible ?></td>
								<td style="text-align:center;"><?php echo $no_en_no_disponible ?></td>
								<td style="text-align:center;" id="porcentaje_examenes"><?php echo $porcentaje_no_disponible ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar5" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>No Contactado</b></td>
								<td style="text-align:center;"><?php echo $no_contactado ?></td>
								<td style="text-align:center;"><?php echo $no_en_no_contactado ?></td>
								<td style="text-align:center;" id="porcentaje_masso"><?php echo $porcentaje_no_contactado ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar6" style=''><div></div></div></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
			<div class="span10 offset1" style="margin-top:20px;"></div>
		</div>
	</div>
</div>
