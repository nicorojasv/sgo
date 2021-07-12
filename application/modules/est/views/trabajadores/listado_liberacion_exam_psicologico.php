<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de trabajadores con solicitud de examen psicologico</h4>
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
		<?php if( count($listado) > 0){ ?>
  		<form action="<?php echo base_url() ?>est/trabajadores/enviar_aprobacion_examen_psicologico" role="form" id="form" method='post' autocomplete="off">
  			<div class="row">
	  		    <div class="col-md-1"></div>
	  		    <div class="col-md-9">
					<table id="example1">
						<thead>
							<tr>
								<th style="text-align:center">Rut</th>
								<th style="text-align:center">Nombre Completo</th>
								<th style="text-align:center">Solicitante</th>
								<th style="text-align:center">Referido</th>
								<th style="text-align:center">Cargo Postulacion</th>
								<th style="text-align:center">Lugar de Trabajo</th>
								<th style="text-align:center">Técnico/Supervisor</th>
								<th style="text-align:center">Sueldo Definido</th>
								<th style="text-align:center">Fecha Solicitud</th>
								<th style="text-align:center">Liberación</th>
								<th style="text-align:center">Acción</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($listado as $r){ ?>
							<tr class="center">
								<td><?php echo $r->rut ?></td>
								<td><?php echo $r->nombres ?></td>
								<td><?php echo $r->solicitante; ?></td>
								<td><?php if($r->referido == 1) echo "SI"; elseif($r->referido == 2) echo "NO"; ?></td>
								<td><?php echo $r->especialidad_post ?></td>
								<td><?php echo $r->lugar_trabajo ?></td>
								<td><?php echo $r->tecnico_supervisor ?></td>
								<td><?php echo $r->sueldo_definido; ?></td>
								<td><?php echo $r->fecha_solicitud; ?></td>
								<td>
									<input type="checkbox" name="check_estado[]" value="<?php echo $r->id_registro ?>" checked>
								</td>
								<td><a title="Eliminar Solicitud" class="eliminar" href="<?php echo base_url() ?>est/trabajadores/eliminar_solicitud_examen_psicologico/<?php echo $r->id_registro ?>"><i class="fa fa-trash-o"></i></a></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
	  		</div>
			<div class="row">
	  		    <div class="col-md-8"></div>
	      		<div class="col-md-2">
				<?php if($this->session->userdata('tipo_usuario') == 8 or $this->session->userdata('id') == 16){ ?>
				<button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Boton enviar aprobacion de solicitudes">
					Enviar Liberacion de Solicitudes
				</button>
				<br><br>	
				<?php } ?>
	      		</div>
	    	</div>
	    </form>
		<?php }else{ ?>
		<p>No existen nuevas solicitudes.</p>
		<?php } ?>
	</div>
</div>