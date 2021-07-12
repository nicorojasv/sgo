<script type="text/javascript" src="<?php echo base_url(); ?>extras/archivos_paginado/jquery.js"></script>
<link type="text/css" href="<?php echo base_url(); ?>extras/archivos_paginado/demo_table.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>extras/archivos_paginado/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>extras/archivos_paginado/jslistadopaises.js"></script>

<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Usuarios Registrados <?php echo $nombre_usuario ?></b></h2>
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
		<div class="row" >
			<div class="col-md-7"></div>
			<div class="col-md-3">
				<?php if($usuario == "mandantes"){ ?>
		        	<input type="radio" class="planta1" onclick="javacript: document.getElementById('usuario').value = 'mandantes' " checked> Mandantes
				    <input type="radio" class="planta1" onclick="javacript: document.getElementById('usuario').value = 'est_externo' " > EST EXTERNO
			    <?php } ?>

				<?php if($usuario == "est_externo"){ ?>
	    	    	<input type="radio" class="planta1" onclick="javacript: document.getElementById('usuario').value = 'mandantes' "> Mandantes
				    <input type="radio" class="planta1" onclick="javacript: document.getElementById('usuario').value = 'est_externo' " checked> EST EXTERNO
			    <?php } ?>

			    <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
				
			</div>
			<div class="col-md-2" >
				<?php if($usuario == "mandantes"){ ?>
					<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>usuarios/perfil/crear_mandante">Agregar Usuario Mandante</a>
				<?php } ?>

				<?php if($usuario == "est_externo"){ ?>
					<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>usuarios/perfil/crear_est_externo">Agregar Usuario EST</a>
	    	    <?php } ?>
			</div>
		</div><br>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_paises">
            <thead>
                <tr>
                  	<th style="text-align:center;">#</th>
                  	<th style="text-align:center;">Rut</th>
					<th style="text-align:center;">Nombres</th>
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
				            <td><h5><?php echo $row->paterno ?> <?php echo $row->materno ?> <?php echo $row->nombres ?></h5></td>
				            <td><h5><?php echo $row->fono ?></h5></td>
				            <td><h5><?php echo $row->email ?></h5></td>
				            <td>
                        		<a title="Gestionar Plantas" data-toggle="modal" href="<?php echo base_url() ?>est/trabajadores/modal_permiso_planta_usuarios/<?php echo $usuario ?>/<?php echo $row->id_usuario ?>" data-target="#ModalGestionPlantas"><i class="fa fa-puzzle-piece"></i></a>
                        		<a title="Editar Datos Usuario" data-toggle="modal" href="<?php echo base_url() ?>est/trabajadores/modal_editar_usuarios/<?php echo $usuario ?>/<?php echo $row->id_usuario ?>" data-target="#ModalEditar"><i class="fa fa-pencil"></i></a>
								<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
								<a title="Eliminar" class="eliminar" href="<?php echo base_url() ?>est/trabajadores/eliminar/<?php echo $usuario ?>/<?php echo $row->id_usuario ?>"><i class="fa fa-trash-o"></i></a>
								<?php } ?>
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

<!-- Modal Editar Datos del Usuarios-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Usuario</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Gestion de Permiso de Plantas-->
<div class="modal fade" id="ModalGestionPlantas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Gestionar Permisos a Plantas a Usuarios</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- MODAL -->
<div class="modal hide" id="modal_nuevo" role="dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3 id="myModalLabel">Asignación de Personal</h3>
    </div>
    <div class="modal-body">
        
    </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    	<button class="btn btn-primary" id="save_btn">Asignar</button>
  	</div>
</div>

<div class="modal fade" id="exportar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Seleccionar Registros</h4>
      </div>
      <form method="post" action="<?php echo base_url() ?>est/trabajadores/exportar_excel">
      <div class="modal-body">
      	<h4>Seleccionar Elementos a Exportar</h4>
        <div class="checkbox">
			<label class="">
				<input type="checkbox" name="id" value="1" class="grey">
				ID
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="nb" value="1" class="grey">
				Nombres
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="rut" value="1" class="grey">
				Rut
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="fono" value="1" class="grey">
				Teléfono
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="fn" value="1" class="grey">
				Fecha de Nacimiento
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="dire" value="1" class="grey">
				Dirección
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="ciudad" value="1" class="grey">
				Ciudad
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="civil" value="1" class="grey">
				Estado Civil
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="esp" value="1" class="grey">
				Especialidad
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="afp" value="1" class="grey">
				AFP
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="salud" value="1" class="grey">
				Salud
			</label>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-primary" value="Generar">
      </div>
  	</form>
    </div>
  </div>
</div>