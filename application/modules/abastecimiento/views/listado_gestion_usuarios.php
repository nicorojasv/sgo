<script type="text/javascript" src="<?php echo base_url(); ?>extras/archivos_paginado/jquery.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>extras/archivos_paginado/demo_table.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>extras/archivos_paginado/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>extras/archivos_paginado/jslistadopaises.js"></script>
<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Listado de Usuarios del Sistema</b></h2>
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
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
            <thead>
                <tr>
                  	<th style="text-align:center;">#</th>
                  	<th style="text-align:center;">Rut</th>
					<th style="text-align:center;">Nombre y Apellidos</th>
					<th style="text-align:center;">Telefono</th>
					<th style="text-align:center;">E-mail</th>
					<th style="text-align:center;">Herramientas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 if ($lista_aux != FALSE){
					$i = 1;
                      foreach ($lista_aux as $row){
                   	?>
				        <tr style="text-align:center">
				        	<td><?php echo $i ?></td>
				            <td><h5><?php echo $row->rut_usuario ?></h5></td>
				            <td><h5><?php echo $row->nombres." ".$row->paterno." ".$row->materno ?></h5></td>
				            <td><h5><?php echo $row->fono ?></h5></td>
				            <td><h5><?php echo $row->email ?></h5></td>
				            <td>
                        		<a title="Gestionar Plantas" data-toggle="modal" href="<?php echo base_url() ?>abastecimiento/modal_permiso_planta_usuarios/<?php echo $row->id_usuario ?>" data-target="#ModalGestionPlantas"><i class="fa fa-puzzle-piece"></i></a>
                        	</td>
				        </tr>
			            <?php
							$i++;
                          }
                    }else{
                    }
                ?>
            <tbody>
        </table>
	</div>
</div>

<!-- Modal Gestion de Permiso de Plantas-->
<div class="modal fade" id="ModalGestionPlantas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Gestionar Permisos Plantas/Abastecimiento a Usuarios</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->