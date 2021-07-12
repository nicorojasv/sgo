<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Empresas ingresadas</h4>
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
					<a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
		<a href="<?php echo base_url().'est/empresas/agregar' ?>" class="btn btn-primary">Agregar</a>
		<table class="table">
			<thead>
				<th>Razón Social</th>
				<th>Rut</th>
				<th>Giro</th>
				<th>Dirección</th>
				<th>Pagina Web</th>
				<th></th>
			</thead>
			<tbody>
				<?php if(isset($listado_empresas)){ ?>
				<?php foreach($listado_empresas as $e){ ?>
				<tr>
					<!--<td><input type='radio' name='editar' value='<?php echo $e->id ?>' ></td>-->
					<td><a target="_blank" href="<?php echo base_url() ?>administracion/perfil/empresa/<?php echo $e->id ?>"><?php echo ucwords(mb_strtolower($e->razon_social,'UTF-8')) ?></a></td>
					<td><?php echo $e->rut ?></td>
					<td><?php echo ucwords(mb_strtolower($e->giro,'UTF-8')) ?></td>
					<td><?php echo ucwords(mb_strtolower($e->direccion,'UTF-8')) ?></td>
					<td><?php echo $e->web ?></td>
					<td class="center">
			            <div class="visible-md visible-lg hidden-sm hidden-xs">
			              	<a href="#" class="btn btn-xs btn-blue tooltips editar" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a>
			              	<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
			              		<a href="<?php echo base_url() ?>est/empresas/eliminar/<?php echo $e->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
			              	<?php } ?>
			           	</div>
		        	</td>
				</tr>
				<?php } ?>
				<?php } else{ ?>
				<tr><td colspan="6">No existen empresas agregadas</td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>