<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de <span class="text-bold">documentos</span></h4>
		<div class="panel-tools">										
			<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu dropdown-light pull-right" role="menu">
				<li>
					<a class="panel-collapse collapses" href="table_basic.html#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
				</li>
				<li>
					<a class="panel-refresh" href="table_basic.html#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="table_basic.html#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="table_basic.html#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="table_basic.html#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
		<p>
			For basic styling—light padding and only horizontal dividers—add the base class <code>.table</code> to any <code>&lt;table&gt;</code>. It may seem super redundant, but given the widespread use of tables for other plugins like calendars and date pickers, we've opted to isolate our custom table styles.
		</p>
		<div class="row">
			<div class="col-md-9"></div>
			<div class="col-md-3">
				<?php  if( $this->session->userdata('tipo') == 1){ ?>
				<a class="btn btn-green" href="<?php echo base_url() ?>documentos/documentos/crear">
					Agregar Documento <i class="fa fa-plus"></i>
				</a>
				<?php } ?>
			</div>
		</div>
		<table class="table table-hover" id="sample-table-1">
			<thead>
				<tr>
					<th class="center">#</th>
					<th lass="center">Documento</th>
					<th class="hidden-xs center">Descargar</th>
					<?php  if( $this->session->userdata('tipo') == 1){ ?>
					<th></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($listado as $l) { ?>
				<?php if( ($this->session->userdata('tipo') == 1) || ( $this->session->userdata('tipo') == $l->usuarios_categoria_id && $this->session->userdata('subtipo') == $l->tipo_usuario_id ) ){ ?>
					<tr>
						<td class="center"><?php echo $l->id ?></td>
						<td><?php echo $l->nombre ?></td>
						<td class="hidden-xs center"><a href="<?php echo base_url() ?>administracion/archivos/descargar/<?php echo $l->id; ?>"><i class="fa fa-download"></i></a></td>
						<?php  if( $this->session->userdata('tipo') == 1){ ?>
						<td class="center">
							<div class="visible-md visible-lg hidden-sm hidden-xs">
								<a href="#" class="btn btn-xs btn-green tooltips" data-placement="top" data-original-title="Compartir"><i class="fa fa-share"></i></a>
								<a href="<?php echo base_url() ?>administracion/archivos/eliminar/<?php echo $l->id; ?>" class="btn btn-xs btn-red tooltips" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
							</div>
						</td>
						<?php } ?>
					</tr>
				<?php 
					} 
					} ?>
			</tbody>
		</table>
	</div>
</div>