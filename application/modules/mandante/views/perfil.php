<link href="<?php echo base_url() ?>extras/css/imprimir_perfil.css" rel="stylesheet" type="text/css" media="print" />
<div id="contact_profile" class="grid grid_17 append_1">
	<table>
		<tbody>
			<tr>
				<td class="td_avatar">
					<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
						<img src="<?php echo base_url() . $this -> session -> userdata('imagen');?>" class="avatar" alt="Imagen Perfil">
					</a>
				</td>
				<td class="td_info"><h1 class="contact_name">Nombre Trabajador</h1>
				<p class="contact_company">
					<a href="#">Trabajador</a>
				</p>
				<p class="contact_tags">
					<?php if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No se ha actualizado el perfil";
						else{
							 $act = explode("-",$usuario->fecha_actualizacion);
							$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
						} ?>
					<span>Ultima actualizacion: <?php echo $actualizacion ?></span>
				</p></td>
			</tr>
		</tbody>
	</table>
	<hr>
	<h2>Datos Personales</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Rut</td>
				<td>12.345.678-9</td>
			</tr>
			<tr class="odd gradeX">
				<td>Sexo</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Fecha de Nacimiento</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="odd gradeX">
				<td>Estado Civil</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Nacionalidad</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>AFP</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Sistema de Salud</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<br>
	<h2>Contacto de Emergencia</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Nombre</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Direcci&oacute;n</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Comuna</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="odd gradeX">
				<td>Cuidad</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Regi&oacute;n</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Telefono</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<br>
	<h2>Datos Tecnicos</h2>
	<table class="data display">
		<tbody>
			<tr class="odd gradeX">
				<td width="350">Nivel Máximo de Estudios</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Nombre de la Institución</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Año de Egreso</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Profesión</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Especialidad</td>
				<td></td>
			</tr>
			<?php if(isset($especialidad2)){ ?> <!-- no obligatoria -->
			<tr class="odd gradeX">
				<td>Segunda Especialidad</td>
				<td></td>
			</tr>
			<?php } ?>
			<?php if(isset($especialidad3)){ ?> <!-- no obligatoria -->
			<tr class="odd gradeX">
				<td>Tercera Especialidad</td>
				<td><?php echo ucwords(mb_strtolower($especialidad3->desc_especialidad,"UTF-8")); ?></td>
			</tr>
			<?php } ?>
			<tr class="odd gradeX">
				<td>Años de Experiencia</td>
				<td><?php echo (!empty($usuario->ano_experiencia)) ? $usuario->ano_experiencia:"&nbsp;"; ?></td>
			</tr>
			<tr class="odd gradeX">
				<td>Cursos relevantes</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Equipos que maneja</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Software que maneja</td>
				<td></td>
			</tr>
			<tr class="odd gradeX">
				<td>Idiomas</td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<br />
</div>
<div class="grid grid_6">
	<a href="javascript:;" id="btn_imprimir" onclick="window.print();" class="btn primary xlarge block">Imprimir</a>
</div>
<div id="contact_profile" class="grid grid_24 append_1">
	<h2>Datos Familiares</h2>
	<table class="data display">
		<thead>
			<tr>
				<th>Parentesco</th>
				<th>Apellido Paterno</th>
				<th>Apellido Materno</th>
				<th>Nombres</th>
				<th>Sexo</th>
				<th>Fecha de Nacimiento</th>
				<th>Rut</th>
				<th>Carga</th>
			</tr>
		</thead>
		<tbody>
		<tr class="odd gradeX">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
</div>
<div id="contact_profile" class="grid grid_24 append_1">
	<h2>Experiencia (XX años)</h2>
	<table class="data display">
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
		<tr class="odd gradeX">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Informaci&oacute;n General</h2>
	<table class="data display">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Tipo</th>
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
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Calificaciones y Examenes</h2>
	<table class="data display">
		<thead>
			<tr>
				<th>Documentos</th>
				<th>Fecha Contrataci&oacute;n</th>
				<th>Fecha Caducidad</th>
				<th>Descarga</th>
			</tr>
		</thead>
		<tbody>
		<tr class="odd gradeX">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Contratos y Finiquitos</h2>
	<table class="data display">
		<thead>
			<tr>
				<th>Contratos</th>
				<th>Fecha Contrataci&oacute;n</th>
				<th>Fecha Caducidad</th>
				<th>Descarga</th>
			</tr>
		</thead>
		<tbody>
		<tr class="odd gradeX">
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Examenes Preocupacionales</h2>
	<table class="data display">
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
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Charlas Masso</h2>
	<table class="data display">
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
			<td></td>
			<td></td>
		</tr>
	</tbody>
	</table>
</div>
<div id="archivos" class="grid grid_24 append_1">
	<h2>Examen Psicol&oacute;gico</h2>
	<table class="data display">
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
</div>