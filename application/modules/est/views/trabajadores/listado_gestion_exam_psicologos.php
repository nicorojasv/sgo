<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Gestionar permiso a usuarios del sistema EST a enviar solicitudes de examen psicologico...</b></h2>
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
  		<form action="<?php echo base_url() ?>est/trabajadores/guardar_estado_permiso_examen_psicologico" role="form" id="form" method='post' autocomplete="off">
			<div class="col-md-9">
				Con permiso: <span class='badge' style='background-color:#3E9610'>CP</span> Sin permiso: <span class='badge' style='background-color:#DAAA08'>SP</span>
			</div>
			<div class="col-md-2"></div>
			<br><br><br>
			<div class="row" >
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<table id="example1">
			            <thead>
			                <tr>
			                  	<th style="text-align:center;">#</th>
			                  	<th style="text-align:center;">Rut</th>
								<th style="text-align:center;">Nombres</th>
								<th style="text-align:center;">Telefono</th>
								<th style="text-align:center;">E-mail</th>
								<th style="text-align:center;">Asignación</th>
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
							            <td><h5><?php echo $row->nombres." ".$row->paterno." ".$row->materno ?> </h5></td>
							            <td><h5><?php echo $row->fono ?></h5></td>
							            <td><h5><?php echo $row->email ?></h5></td>
							            <td>
											<input type="hidden" name="usuarios[]" value="<?php echo $row->id ?>">
											<input type="checkbox" name="check_estado[]" value="<?php echo $row->id ?>" <?php echo ($row->estado)?"checked='checked'":""; ?> > <?php echo ($row->estado)?"<span class='badge' style='background-color:#3E9610'>CP</span>":"<span class='badge' style='background-color:#DAAA08'>SP</span>"; ?>
										</td>
							        </tr>
						            <?php
										$i++;
			                          }
			                    }else{
			                    }
			                ?>
			            </tbody>
			        </table>
	        	</div>
				<div class="col-md-2" ></div>
			</div><br>
			<div class="row">
	  		    <div class="col-md-7"></div>
	      		<div class="col-md-3">
	      			<button class="btn btn-green btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar Permisos a Examenes Psicologicos">
						Guardar Estados Permisos
					</button>
	      		</div>
	    	</div><br><br>
    	</form>
	</div>
</div>