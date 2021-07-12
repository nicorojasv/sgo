<link href="<?php echo base_url() ?>extras/css/imprimir_perfil.css" rel="stylesheet" type="text/css" media="print" />
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
		<div id="contact_profile" class="col-xs-12">
			<table class='table col-xs-3'>
				<tbody>
					<tr>
						<td class="td_avatar" style='width:79px;'>
							<!--<a href="<?php //echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">-->
								<img src="<?php echo base_url(); echo $usuario->thumb_usu ?>" class="avatar" alt="Imagen Perfil">
						</td>
						<td class="td_info"><h1 class="contact_name"><?php echo $usuario->nombre; ?></h1>
						<p class="contact_company">
							<a>Trabajador</a>
						</p>
						<p class="contact_tags">
							<span>Ultima actualizacion: <?php echo $usuario->actualizacion ?></span>
						</p></td>
						<td><a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn btn-primary btn-block">Imprimir</a></td>
					</tr>
				</tbody>
			</table>
			<hr>
			<h2>Datos Personales</h2>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Rut</td>
						<td><?php echo $usuario->rut; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td width="350">Telefono</td>
						<td><?php echo $usuario->telefono; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td width="350">Correo Electr&oacute;nico</td>
						<td><?php echo (isset($usuario->email))?$usuario->email:''; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Sexo</td>
						<td><?php echo $usuario->sexo; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Fecha de Nacimiento</td>
						<td><?php echo $usuario->nacimiento; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Regi&oacute;n</td>
						<td><?php echo $usuario->region; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Provincia</td>
						<td><?php echo $usuario->provincia; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Ciudad</td>
						<td><?php echo $usuario->ciudad; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Direcci&oacute;n</td>
						<td><?php echo $usuario->direccion; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Estado Civil</td>
						<td><?php echo $usuario->civil; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>AFP</td>
						<td><?php echo $usuario->afp; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Sistema de Salud</td>
						<td><?php echo $usuario->salud; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Nacionalidad</td>
						<td><?php echo $usuario->nacionalidad; ?></td>
					</tr>
				</tbody>
			</table>
			<br>
			<h2>Contacto de Emergencia</h2>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Nombre</td>
						<td><?php echo $usuario->nombre_emerg ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Telefono</td>
						<td><?php echo $usuario->telefono_emerg ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Parentesco</td>
						<td><?php echo $usuario->parentesco_emerg ?></td>
					</tr>
				</tbody>
			</table>
			<br>
			<h2>Datos Tecnicos</h2>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Nivel Máximo de Estudios</td>
						<td><?php echo ($tecnicos->estudios)?$tecnicos->estudios:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Nombre de la Institución</td>
						<td><?php echo ($tecnicos->institucion)?$tecnicos->institucion:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Año de Egreso</td>
						<td><?php echo ($tecnicos->egreso)?$tecnicos->egreso:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Profesión</td>
						<td><?php echo ($tecnicos->profesion)?$tecnicos->profesion:'No ingresada'; ?></td>
					</tr>


					<tr class="odd gradeX">
						<td>Especialidad</td>
						<td><?php echo ($tecnicos->especialidad)?$tecnicos->especialidad:'No ingresada'; ?></td>
					</tr>
					<?php if(isset($tecnicos->especialidad2)){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Segunda Especialidad</td>
						<td><?php echo $tecnicos->especialidad2 ?></td>
					</tr>
					<?php } ?>
					<?php if(isset($tecnicos->especialidad3)){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Tercera Especialidad</td>
						<td><?php echo ucwords(mb_strtolower($tecnicos->especialidad3,"UTF-8")); ?></td>
					</tr>
					<?php } ?>
					<tr class="odd gradeX">
						<td>Años de Experiencia</td>
						<td><?php echo ($tecnicos->experiencia)?$tecnicos->experiencia:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Cursos relevantes</td>
						<td><?php echo ($tecnicos->cursos)?$tecnicos->cursos:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Equipos que maneja</td>
						<td><?php echo ($tecnicos->equipos)?$tecnicos->equipos:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Software que maneja</td>
						<td><?php echo ($tecnicos->software)?$tecnicos->software:'No ingresada'; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Idiomas</td>
						<td><?php echo ($tecnicos->idiomas)?$tecnicos->idiomas:'No ingresada'; ?></td>
					</tr>
				</tbody>
			</table>
			<br/>
		</div>
		<div id="contact_profile">
			<h2>Experiencia (XX años)</h2>
			<?php if($usuario->experiencia){ ?>
			<table class="table">
				<thead>
					<tr>
						<th>Desde</th>
						<th>Hasta</th>
						<th>Cargo</th>
						<th>Area</th>
						<th>Empresa contratista</th>
						<th>Empresa mandante/planta</th>
						<th>Principales funciones</th>
						<th>Referencias</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($usuario->experiencia as $e){ ?>
					<tr class="odd gradeX">
						<td><?php echo $e->desde ?></td>
						<td><?php echo $e->hasta ?></td>
						<td><?php echo $e->cargo ?></td>
						<td><?php echo $e->area ?></td>
						<td><?php echo $e->empresa_c ?></td>
						<td><?php echo $e->empresa_m ?></td>
						<td><?php echo $e->funciones ?></td>
						<td><?php echo $e->referencias ?></td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
			<?php }else{ ?>
				<p>No existen experiencias para este usuario</p>
			<?php } ?>
			<br>
		</div>
		<div id="archivos" >
			<h2>Contratos, Anexos y Finiquitos</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Tipo Archivo</th>
						<th>Fecha Contrataci&oacute;n</th>
						<th>Fecha Caducidad</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($contratos as $l) { ?>
						<tr class="odd gradeX">
							<td>Contrato de Trabajo</td>
							<td><?php echo $l->fecha_inicio; ?></td>
							<td><?php echo $l->fecha_termino; ?></td>
							<td>
								<?php $href = (isset($l->url)) ? base_url().$l->url : '#'; ?>
								<?php $color = (isset($l->url)) ? "color:green":"color:red"; ?>
								<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
							</td>
						</tr>
					<?php } ?>
					<?php foreach ($anexos as $r) { ?>
						<tr class="odd gradeX">
							<td>Anexos de Contratos</td>
							<td><?php echo $r->fecha_inicio; ?></td>
							<td><?php echo $r->fecha_termino; ?></td>
							<td>
								<?php $href = (isset($r->url)) ? base_url().$r->url : '#'; ?>
								<?php $color = (isset($r->url)) ? "color:green":"color:red"; ?>
								<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
							</td>
						</tr>
					<?php } ?>
					<?php foreach ($finiquitos as $j) { ?>
						<tr class="odd gradeX">
							<td>Finiquitos</td>
							<td><?php echo $j->fecha_inicio; ?></td>
							<td><?php echo $j->fecha_termino; ?></td>
							<td>
								<?php $href = (isset($j->url)) ? base_url().$j->url : '#'; ?>
								<?php $color = (isset($j->url)) ? "color:green":"color:red"; ?>
								<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<br>
		</div>
		<div id="archivos" >
			<h2>Examenes Preocupacionales</h2>
			<table class='table'>
				<thead>
					<th>Tipo Examen</th>
					<th>Nombre Evaluaci&oacute;n</th>
					<th>Fecha Evaluaci&oacute;n</th>
					<th>Fecha Vigencia</th>
					<th>Calificaci&oacute;n</th>
					<th>Archivo</th>
				</thead>
				<tbody>
					<?php foreach ($examen_preo as $l) { ?>
						<tr>
							<td><?php echo $l->nombre_tipo; ?></td>
							<td><?php echo $l->nombre_eval; ?></td>
							<td>
								<?php if($l->fecha_e) { $f_e = explode('-',$l->fecha_e); $f_e = $f_e[2].'-'.$f_e[1].'-'.$f_e[0]; } ?>
								<?php echo ($l->fecha_e) ? $f_e : '-' ; ?>
							</td>
							<td>
								<?php if($l->fecha_v) { $f_v = explode('-',$l->fecha_v); $f_v = $f_v[2].'-'.$f_v[1].'-'.$f_v[0]; } ?>
								<?php echo ($l->fecha_v) ? $f_v : '-' ; ?>
							</td>
							<td>
								<?php if($l->tipo_resultado == 2){ ?>
								<?php echo ($l->resultado == 1) ? 'Rechazado' : 'Aprobado'; ?>
								<?php } else { ?>
								<?php echo $l->resultado; ?>
								<?php } ?>
							</td>
							<td>
								<?php $href = (isset($l->url)) ? base_url().$l->url : '#'; ?>
								<?php $color = (isset($l->url)) ? "color:green":"color:red"; ?>
								<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<br>
		</div>
		<div id="archivos" >
			<h2>Charlas Masso</h2>
				<table class='table'>
					<thead>
						<th>Tipo Examen</th>
						<th>Nombre Evaluaci&oacute;n</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Fecha Vigencia</th>
						<th>Calificaci&oacute;n</th>
						<th>Archivo</th>
					</thead>
					<tbody>
						<?php foreach ($masso as $l) { ?>
							<tr>
								<td><?php echo $l->nombre_tipo; ?></td>
								<td><?php echo $l->nombre_eval; ?></td>
								<td>
									<?php if($l->fecha_e) { $f_e = explode('-',$l->fecha_e); $f_e = $f_e[2].'-'.$f_e[1].'-'.$f_e[0]; } ?>
									<?php echo ($l->fecha_e) ? $f_e : '-' ; ?>
								</td>
								<td>
									<?php if($l->fecha_v) { $f_v = explode('-',$l->fecha_v); $f_v = $f_v[2].'-'.$f_v[1].'-'.$f_v[0]; } ?>
									<?php echo ($l->fecha_v) ? $f_v : '-' ; ?>
								</td>
								<td>
									<?php if($l->tipo_resultado == 2){ ?>
									<?php echo ($l->resultado == 1) ? 'Rechazado' : 'Aprobado'; ?>
									<?php } else { ?>
									<?php echo $l->resultado; ?>
									<?php } ?>
								</td>
								<td>
									<?php $href = (isset($l->url)) ? base_url().$l->url : '#'; ?>
									<?php $color = (isset($l->url)) ? "color:green":"color:red"; ?>
									<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<br><br>
		</div>
		<div id="contact_profile">
			<h2>Historial de Requerimientos</h2>
			<?php if($usuario->requerimientos != NULL){ ?>
			<table class="table">
				<thead>
					<tr>
						<th>Codigo Req.</th>
						<th>Nombre Req.</th>
						<th>Fecha Solicitud</th>
						<th>Fecha Inicio</th>
						<th>Fecha Termino</th>
						<th>Causal</th>
						<th>Motivo</th>
						<th>Regimen</th>
						<th>Empresa Planta</th>
						<th>Area</th>
						<th>Cargo</th>
						<th>Status</th>
						<th>Referido</th>
						<th>Comentarios</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($usuario->requerimientos as $req){ ?>
					<tr class="odd gradeX">
						<td><?php echo $req->codigo_requerimiento ?></td>
						<td><?php echo $req->nombre_req ?></td>
						<td><?php echo $req->f_solicitud ?></td>
						<td><?php echo $req->f_inicio ?></td>
						<td><?php echo $req->f_fin ?></td>
						<td><?php echo $req->causal ?></td>
						<td><?php echo $req->motivo ?></td>
						<td><?php echo $req->regimen ?></td>
						<td><?php echo $req->empresa_planta ?></td>
						<td><?php echo $req->nombre_area ?></td>
						<td><?php echo $req->nombre_cargo ?></td>
						<td><?php if($req->status == 0) echo "No Contactado"; elseif($req->status == 1) echo "No Disponible"; elseif($req->status == 2) echo "En Proceso"; elseif($req->status == 3) echo "En Servicio"; elseif($req->status == 4) echo "Renuncia"; elseif($req->status == 5) echo "Contrato Firmado"; elseif($req->status == 6) echo "Contrato Finalizado"; elseif($req->status == 7) echo "Renuncia"; ?></td>
						<td><?php if($req->referido == 0) echo "No"; elseif($req->referido == 1) echo "Si"; ?></td>
						<td><?php echo $req->comentario ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php }else{ ?>
				<p>No existen requerimientos registrados para este usuario</p>
			<?php } ?>
			<br>
		</div>
	</div>
</div>