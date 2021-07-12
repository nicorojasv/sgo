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
								<img src="<?php echo base_url() . $this->session->userdata('imagen');?>" class="avatar" alt="Imagen Perfil">
							<!--</a>-->
						</td>
						<?php
				             if ($listado != FALSE){
								$i = 1;
				                  foreach ($listado as $row){
				            
				        ?>
						<td class="td_info"><h1 class="contact_name"><?php echo $row->nombre_trab; echo " "; echo $row->a_paterno; echo $row->a_materno ?></h1>
				         <?php

							}
			                }else{
			                }
			            ?>
						<p class="contact_tags">
							<?php if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No se ha actualizado el perfil";
								else{
									 $act = explode("-",$usuario->fecha_actualizacion);
									$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
								} ?>
							<span>Ultima actualizaci&oacute;n: <?php echo $actualizacion ?></span>
						</p></td>
						<td><a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn btn-primary btn-block">Imprimir</a></td>
					</tr>
				</tbody>
			</table>
			<hr>
			<h2>Datos Personales</h2>
			<?php
	             if ($listado != FALSE){
					$i = 1;
	                  foreach ($listado as $row){  
	        ?>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Rut</td>
						<td><?php echo $row->rut ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Sexo</td>
						<td><?php echo $row->sexo ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Fecha de Nacimiento</td>
						<td><?php echo $row->fecha_nac ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Estado Civil</td>
						<td><?php echo $row->estado_civil ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Nacionalidad</td>
						<td><?php echo $row->nacionalidad ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>AFP</td>
						<td><?php echo $row->afp ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Sistema de Salud</td>
						<td><?php echo $row->sistema_salud ?></td>
					</tr>
				</tbody>
			</table>
			 <?php
				}
                }else{
                }
            ?>
			<br>
			<h2>Contacto de Emergencia</h2>
			<?php
	             if ($listado != FALSE){
					$i = 1;
	                  foreach ($listado as $row){  
	        ?>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Nombre</td>
						<td><?php echo $row->emerg_nombre ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Tel&eacute;fono</td>
						<td><?php echo $row->emerg_telefono ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Relaci&oacute;n</td>
						<td><?php echo $row->emerg_parentesco ?></td>
					</tr>
				</tbody>
			</table>
			 <?php
				}
                }else{
                }
            ?>
			<br>
			<h2>Datos T&eacute;cnicos</h2>
			<?php
	             if ($listado != FALSE){
					$i = 1;
	                  foreach ($listado as $row){  
	        ?>
			<table class="table">
				<tbody>
					<tr class="odd gradeX">
						<td width="350">Nivel M&aacute;ximo de Estudios</td>
						<td><?php echo $row->nivel_estudios ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Nombre de la Instituci&oacute;n</td>
						<td><?php echo (!empty($usuario->institucion))?$usuario->institucion:"&nbsp;"; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>A&ntilde;o de Egreso</td>
						<td><?php echo (!empty($usuario->ano_egreso))?$usuario->ano_egreso:"&nbsp;"; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Profesi&oacute;n</td>
						<td><?php echo $row->profesiones ?></td>
					</tr>
					<?php if($row->especialidad_1 != '0'){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Especialidad</td>
						<td><?php echo ucwords(mb_strtolower($row->especialidad_1,"UTF-8")); ?></td>
					</tr>
					<?php }else{} ?>
					<?php if($row->especialidad_2 != '0'){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Segunda Especialidad</td>
						<td><?php echo ucwords(mb_strtolower($row->especialidad_2,"UTF-8")); ?></td>
					</tr>
					<?php }else{} ?>
					<?php if($row->especialidad_3 != '0'){ ?> <!-- no obligatoria -->
					<tr class="odd gradeX">
						<td>Tercera Especialidad</td>
						<td><?php echo ucwords(mb_strtolower($row->especialidad_3,"UTF-8")); ?></td>
					</tr>
					<?php }else{} ?>
					<tr class="odd gradeX">
						<td>A&ntilde;os de Experiencia</td>
						<td><?php echo (!empty($usuario->ano_experiencia))?$usuario->ano_experiencia:"&nbsp;"; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Cursos relevantes</td>
						<td><?php echo (!empty($usuario->cursos))?$usuario->cursos:"&nbsp;"; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Equipos que maneja</td>
						<td><?php echo (!empty($usuario->equipos))?$usuario->equipos:"&nbsp;"; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Software que maneja</td>
						<td><?php echo (!empty($usuario->software))?$usuario->software:"&nbsp;"; ?></td>
					</tr>
					<tr class="odd gradeX">
						<td>Idiomas</td>
						<td><?php echo (!empty($usuario->idiomas))?$usuario->idiomas:"&nbsp;"; ?></td>
					</tr>
				</tbody>
			</table>
			 <?php
				}
                }else{
                }
            ?>
			<br />
		</div>
		<div id="contact_profile">
			<h2>Experiencia (XX a&ntilde;os)</h2>
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
					<?php
			            if ($experiencias != FALSE){
						    foreach ($experiencias as $row){  
	        		?>
        			<tr class="odd gradeX">
						<td><?php echo $row->desde ?></td>
						<td><?php echo $row->hasta ?></td>
						<td><?php echo $row->cargo ?></td>
						<td><?php echo $row->area ?></td>
						<td><?php echo $row->empresa_c ?></td>
						<td><?php echo $row->empresa_m ?></td>
						<td><?php echo $row->funciones ?></td>
						<td><?php echo $row->referencias ?></td>
					</tr>
						 <?php
						}
		                }else{
		                }
		            ?>
				</tbody>
			</table>
			<br>
		</div>
		<?php
             if ($listado != FALSE){
				$i = 1;
                  foreach ($listado as $row){  
        ?>
		<div id="archivos" >
			<h2>Examenes Preocupacionales</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Examenes</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Fecha Vigencia</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td>EXAMEN PRECOUPACIONAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><?php echo $row->fecha_eval_preocup ?></td>
					<td><?php echo $row->fecha_vigencia_preocup ?></td>
					<td>
						<?php
							if ($row->archivo_preocup == "0"){
						?>
						<a href="#" style="color:red;"><i class="fa fa-thumbs-up"></i></a>

						<?php
							}else{
						 ?>
						<a href="<?php echo base_url() ?><?php echo $row->archivo_preocup ?>" style="color:green;" target="_blank"><i class="fa fa-thumbs-up"></i></a>
						<?php
							}
						?>
					</td>
				</tr>
			</tbody>
			</table>
			<br>
		</div>
		<div id="archivos" >
			<h2>Charla Masso</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Charla Masso</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Fecha Vigencia</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td>INDUCCI&Oacute;N MASSO CELULOSA ARAUCO</td>
					<td><?php echo $row->fecha_eval_masso ?></td>
					<td><?php echo $row->fecha_vigencia_masso ?></td>
					<td>
						<?php
							if ($row->archivo_masso == "0"){
						?>
						<a style="color:red;"><i class="fa fa-thumbs-up"></i></a>

						<?php
							}else{
						 ?>
						<a href="<?php echo base_url() ?><?php echo $row->archivo_masso ?>" style="color:green;" target="_blank"><i class="fa fa-thumbs-up"></i></a>
						<?php
							}
						?>
					</td>
				</tr>
			</tbody>
			</table>
			<br>
		</div>
		<div id="archivos" >
			<h2>Examen Psicol&oacute;gico</h2>
			<table class="table">
				<thead>
					<tr>
						<th>Examenes</th>
						<th>Fecha Evaluaci&oacute;n</th>
						<th>Descarga</th>
					</tr>
				</thead>
				<tbody>
				<tr class="odd gradeX">
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
			</table>
			<br>
		</div>
		<?php
			}
            }else{
            }
        ?>
	</div>
</div>