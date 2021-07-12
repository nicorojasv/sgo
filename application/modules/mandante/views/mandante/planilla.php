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
		<h3 style='text-align:center;float:left;'><?php echo $requerimiento->nombre ?></h3>
		
		<a href='<?php echo base_url() ?>mandante/evaluar_pgp/<?php echo $requerimiento->id ?>' class='btn btn-blue' style='float:right;'>Evaluar</a><br/>
		<br  class='clear'/>
		<br />

		<table id="example1">
			<thead>
				<tr>
					<th class="center">Especialidad</th>
					<?php foreach ($areas as $a) { ?>
						<th class="center"><?php echo $this->Areas_model->r_get($a)->nombre; ?></th>
					<?php } ?>
					<!--<th class="center">Total</th>-->
				</tr>
			</thead>
			<tbody>
				<?php $z = 0 ?>
				<?php foreach ($cargos as $c) { ?>
					<tr>
						<td class="center"><?php echo $this->Cargos_model->r_get($c)->nombre; ?></td>
						<?php for($i=0;$i<count($areas);$i++){ ?>
						<td class="center">
							<a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>mandante/detalle_pgp/<?php echo $ids[$z] ?>'>
								<?php echo $asignadas[$z] ?>/<?php echo $personas[$z] ?>
							</a>
						</td>
						<?php $z++; } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<!--
		<table style="width:100%" class='table table-condensed'>
			<thead>
				<!--<tr>
					<th></th>
					<th></th>
					<th></th>
					<th colspan="8" style='border:1px solid black;text-align:center;'>Area que lo Requiere</th>
					<th></th>
				</tr> --><!--
				<tr style="background-color:#D7D7D7;color:black;">
					<th style='text-align:center;padding:3px;'>Especialidad</th>
					<th style='text-align:center;padding:3px;'>Det. y pta e/s</th>
					<th style='text-align:center;padding:3px;'>Maderas</th>
					<th style='text-align:center;padding:3px;'>Pulpa</th>
					<th style='text-align:center;padding:3px;'>Secado</th>
					<th style='text-align:center;padding:3px;'>P. Termica</th>
					<th style='text-align:center;padding:3px;'>Evap. Gen</th>
					<th style='text-align:center;padding:3px;'>Caustificaci&oacute;n</th>
					<th style='text-align:center;padding:3px;'>Maestranza</th>
					<th style='text-align:center;padding:3px;'>Turno mant</th>
					<th style='text-align:center;padding:3px;'>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style=''><b>Mec&aacute;nicos</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Mec&aacute;nicos pre pta e/s</b></td>
					<td style='text-align:center;'>2/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'><a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>mandante/detalle_pgp'>9/20</a></td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Lubricadores</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Pañoleros</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Pañoleros Pañol Lubric.</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Caldereros</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Soldadores Mixtos</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Cald. Area</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Sold. Area</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Electricistas Arear</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Elec. Taller</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>DCS (Controlista)</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Instrumentistas Areas</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Tec. Instrum. Taller</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr>
					<td style=''><b>Ayudante Alineador</b></td>
					<td style='text-align:center;'>0/2</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
					<td style='text-align:center;'>0/0</td>
				</tr>
				<tr style="border-bottom:1px solid #DDD">
					<td style=';'><b>TOTAL</b></td>
					<td style='text-align:center;'><b>0/2</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
					<td style='text-align:center;'><b>0/0</b></td>
				</tr>
			</tbody>
		</table>-->
	</div>
</div>