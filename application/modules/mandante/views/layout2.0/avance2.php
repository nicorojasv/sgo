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
			<div class="span8 offset2" >
				<div style='border: 1px solid black;padding-top:20px;padding-bottom:20px;padding-left:10px; padding-right:10px'>
					<div class='pgp-left' style='float:left' >
						<div class='pgp-title'>Regimen Normal - Pulpa L2</div>
						<div class='pgp-subtitle'><small>Periodo xx/xx/xxxx al xx/xx/xxxx</small></div>
					</div>
					<div class='pgp-center' style='float:left; margin-left:140px' >
						<span class='' style='float:left'>Dotaci&oacute;n: 340</span>
						<div class="progressBar" style='margin-left:10px;float:left'><div></div></div>
					</div>
					<div class='pgp-right' style='float:right' >
						<div class=''><span class='circulito verde'></span>En Servicio: 40 <span class='circulito rojo'></span>En Proceso: 300</div>
					</div>
					<div class='clear'></div>
				</div>
				<div style='position:relative;float:right;margin-right: -83px;'><a href='<?php echo base_url() ?>mandante/planilla_pgp'>Ver Planilla <i class="icon-hand-left"></i></a></div>
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
								<td><b>Contactados</b></td>
								<td style="text-align:center;">340</td>
								<td style="text-align:center;">-60</td>
								<td style="text-align:center;">98</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>Diponibilidad</b></td>
								<td style="text-align:center;">250</td>
								<td style="text-align:center;">50</td>
								<td style="text-align:center;">74</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>Certificaci&oacute;n</b></td>
								<td style="text-align:center;">200</td>
								<td style="text-align:center;">140</td>
								<td style="text-align:center;">59</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>Examenes</b></td>
								<td style="text-align:center;">300</td>
								<td style="text-align:center;">40</td>
								<td style="text-align:center;">88</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>Charla Masso</b></td>
								<td style="text-align:center;">240</td>
								<td style="text-align:center;">100</td>
								<td style="text-align:center;">71</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
							<tr>
								<td><b>Contratos</b></td>
								<td style="text-align:center;">200</td>
								<td style="text-align:center;">140</td>
								<td style="text-align:center;">159</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
							<tr style="border-bottom:1px solid #DDD">
								<td><b>En Planta</b></td>
								<td style="text-align:center;">0</td>
								<td style="text-align:center;">340</td>
								<td style="text-align:center;">0</td>
								<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
			<div class="span10 offset1" style="margin-top:20px;">
				<!--<div id="chartContainer" style="height: 500px;"></div>-->
			</div>
		</div>
	</div>
</div>
