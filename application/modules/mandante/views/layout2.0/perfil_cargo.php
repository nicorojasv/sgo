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
		<table class="table">
			<tr>
				<td width="350"><b>Cargo</b></td>
				<td><?php echo ucwords(mb_strtolower($nombre_cargo->nombre,'UTF-8')) ?></td>
			</tr>
			<?php if( !empty($cargo) ){ ?>
			<tr>
				<td width="350"><b>Requisitos B&aacute;sicos</b></td>
				<td>
					<?php echo $cargo->requisitos_basicos ?>
				</td>
			</tr>
			<tr>
				<td width="350"><b>Conocimientos</b></td>
				<td>
					<?php echo $cargo->conocimientos ?>
				</td>
			</tr>
			<!--
			<tr>
				<td width="350"><b>Examen Psicol&oacute;gico</b></td>
				<td>Si</td>
			</tr>
			-->
			<?php } else { ?>
			<tr>
				<td width="350"></td>
				<td>
					Perfil de Cargo, no añadido.
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
</div>