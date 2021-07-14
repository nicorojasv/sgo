<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><b>Empresa:</b> <?php echo $empresa ?> <b>Unidad de Negocio: </b><?php echo $planta ?> <b>Requerimiento: </b><?php echo $requerimiento->nombre; ?></h4>
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
							<a style='width:100%;height:100%;display:block;' href='<?php echo base_url() ?>est/requerimiento/usuarios_requerimiento/<?php echo $ids[$z] ?>'>
								<?php echo $asignadas[$z] ?>/<?php echo $personas[$z] ?>
							</a>
						</td>
						<?php $z++; } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>