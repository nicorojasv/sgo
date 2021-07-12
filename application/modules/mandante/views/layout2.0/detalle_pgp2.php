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
		<h3> Mecánicos pre pta e/s - Secado </h3>
		<div>
			<select>
				<option>Status Todos</option>
				<option>No Contactado</option>
				<option>No Disponible</option>
				<option>En Proceso</option>
				<option>En Servicio</option>
			</select>
		</div>
		<br/>
		<table class="table table-hover">
			<thead style="background-color:#D7D7D7;color:black;">
		        <th style="text-align:center;">Nombre</th>
				<th style="text-align:center;">Referido</th>
		        <th style="text-align:center;">Cargo</th>
				<th style="text-align:center;">Competencias</th>
				<th style="text-align:center;">Contacto</th>
				<th style="text-align:center;">Disponiblidad</th>
				<th style="text-align:center;">Certificaci&oacute;n</th>
				<th style="text-align:center;">Examen Preocupacional</th>
				<th style="text-align:center;">MASSO</th>
				<th style="text-align:center;">Contrato</th>
				<th style="text-align:center;">Status General</th>
		        <th style="text-align:center;">Comentario Integra</th>
		        <th style="text-align:center;">Recomienda?</th>
				<th style="text-align:center;">Comentarios</th>
			</thead>
			<tbody>
				<tr>
		            <td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Benjamin Button</a><b/></td>
					<td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
		            <td style="text-align:center;">Comentario</td>
					<td style="text-align:center;">si<input type='radio' name='r' checked /> no<input type='radio' name='r' /></td>
		            <td style="text-align:center;"><a href='' data-toggle="modal" data-target="#myModal">Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Pedro Retamal</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='s' checked /> no<input type='radio' name='s' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Gustavo Flores</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='d' checked /> no<input type='radio' name='d' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Claudio Garrido</a><b/></td>
		            <td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='f' checked /> no<input type='radio' name='f' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr style="border-bottom:1px solid #DDD">
					<td><b><a href='#'>Herbie Lagos</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='g' checked /> no<input type='radio' name='g' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
		            <td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Benjamin Button</a><b/></td>
					<td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
		            <td style="text-align:center;">Comentario</td>
					<td style="text-align:center;">si<input type='radio' name='r' checked /> no<input type='radio' name='r' /></td>
		            <td style="text-align:center;"><a href='' data-toggle="modal" data-target="#myModal">Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Pedro Retamal</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='s' checked /> no<input type='radio' name='s' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Gustavo Flores</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='d' checked /> no<input type='radio' name='d' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Claudio Garrido</a><b/></td>
		            <td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='f' checked /> no<input type='radio' name='f' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr style="border-bottom:1px solid #DDD">
					<td><b><a href='#'>Herbie Lagos</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='g' checked /> no<input type='radio' name='g' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
		            <td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Benjamin Button</a><b/></td>
					<td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
		            <td style="text-align:center;">Comentario</td>
					<td style="text-align:center;">si<input type='radio' name='r' checked /> no<input type='radio' name='r' /></td>
		            <td style="text-align:center;"><a href='' data-toggle="modal" data-target="#myModal">Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Pedro Retamal</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='s' checked /> no<input type='radio' name='s' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Gustavo Flores</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='d' checked /> no<input type='radio' name='d' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Claudio Garrido</a><b/></td>
		            <td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='f' checked /> no<input type='radio' name='f' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr style="border-bottom:1px solid #DDD">
					<td><b><a href='#'>Herbie Lagos</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='g' checked /> no<input type='radio' name='g' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
		            <td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Benjamin Button</a><b/></td>
					<td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
		            <td style="text-align:center;">Comentario</td>
					<td style="text-align:center;">si<input type='radio' name='r' checked /> no<input type='radio' name='r' /></td>
		            <td style="text-align:center;"><a href='' data-toggle="modal" data-target="#myModal">Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='<?php echo base_url() ?>mandante/perfil2'>Pedro Retamal</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='s' checked /> no<input type='radio' name='s' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Gustavo Flores</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='d' checked /> no<input type='radio' name='d' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr>
					<td><b><a href='#'>Claudio Garrido</a><b/></td>
		            <td style="text-align:center;color:green;"><b><i class='fa fa-check'><b/></td>
					<td style="text-align:center;">Cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Servicio</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='f' checked /> no<input type='radio' name='f' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
				<tr style="border-bottom:1px solid #DDD">
					<td><b><a href='#'>Herbie Lagos</a><b/></td>
		            <td style='text-align:center;color:#e66b6b;'><b><i class='fa fa-times'></i><b/></td>
					<td style="text-align:center;">cargo</td>
		            <td style="text-align:center;"><a href='<?php echo base_url() ?>mandante/perfil_trabajador'><i class='fa fa-info'></a></i></td>
					<td style="text-align:center;color:green;"><i class='fa fa-check'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;color:#e66b6b;"><i class='fa fa-times'></i></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><a style="color:green;" href='#'><i class='fa fa-check'></a></td>
					<td style="text-align:center;"><b>En Proceso</b></td>
					<td style="text-align:center;">Comentario</td>
		            <td style="text-align:center;">si<input type='radio' name='g' checked /> no<input type='radio' name='g' /></td>
		            <td style="text-align:center;"><a href='#'>Comentar</a></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Comentario</h2>
      </div>
      <div class="modal-body">
        <form class="">
         <textarea rows="5" style="width: 515px;"></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>