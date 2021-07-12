<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>Trabajadores Ingresados</b></h2>
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
			<div class="col-md-10">
				<font color="green"><b>Tecnicos</b></font><br>
				<font color="blue"><b>Supervisor</b></font> 
			</div>
			<div class="col-md-2" >
				<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>usuarios/perfil/crear/3">Agregar Trabajador</a>
			</div>
		</div><br>
		<table id="example1">
			<thead>
				<tr role="row">
					<th style="width:5%">Rut</th>
					<th style="width:8%">Nombres y Apellidos</th>
					<th style="width:6%">Telefono</th>
					<th style="width:5%">Ciudad</th>
					<th style="width:5%">Especialidad</th>
					<th style="width:5%">Nota<br>Conoc.</th>

					<th style="width:5%" class="uk-date-html">Masso</th>
					<th style="width:5%" class="uk-date-html">Examen Preo</th>
					<th style="width:5%" class="uk-date-html">Examen<br>Psic.</th>
					<th style="width:5%" class="uk-date-column">Fecha<br>Nacim.</th>
					<th style="width:5%">Documentos</th>
					<th style="width:5%">Herramientas</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($listado as $row){
					if($row->estado_masso == 'vigente')
						$color_masso = 'color:green';
					elseif ($row->estado_masso == 'vencida')
						$color_masso = 'color:red';
					elseif ($row->estado_masso == 'falta')
						$color_masso = 'color:#FF8000';

					if($row->estado_examen == 'vigente')
						$color_eval = 'color:green';
					elseif ($row->estado_examen == 'vencida')
						$color_eval = 'color:red';
					elseif ($row->estado_examen == 'falta')
						$color_eval = 'color:#FF8000';

					if ($row->resultado_pisocologico == 'NA')
						$color_tecnico_sup = 'color:red';
					elseif($row->tecnico_supervisor == '1')
						$color_tecnico_sup = 'color:green';
					elseif ($row->tecnico_supervisor == '2')
						$color_tecnico_sup = 'color:blue';
					else
						$color_tecnico_sup = 'color:#000000';

					if($row->ln == 0) $anotacion = base_url().'extras/images/circle_green_16_ns.png';
					elseif($row->ln == 1) $anotacion = base_url().'extras/images/circle_yellow_16_ns.png';
					elseif($row->ln == 2) $anotacion = base_url().'extras/images/circle_red_16_ns.png';
					elseif($row->ln == 3) $anotacion = base_url().'extras/images/circle_red-yellow_16.png';

					$color_cv = ($row->cv)?'color:green':'color:red';
					$color_afp = ($row->afp)?'color:green':'color:red';
					$color_salud = ($row->salud)?'color:green':'color:red';
					$color_estu = ($row->estudios)?'color:green':'color:red';
					$url_cv = ($row->cv)?base_url().$row->cv:'#';
					$url_afp = ($row->afp)?base_url().$row->afp:'#';
					$url_salud = ($row->salud)?base_url().$row->salud:'#';
					$url_estu = ($row->estudios)?base_url().$row->estudios:'#';
				?>
				<tr>
					<td><?php echo $row->rut_usuario ?></td>
					<td><?php echo "<a target='_blank' href='".base_url()."usuarios/perfil/listar_trabajador/".$row->id_user."'>".$row->nombres.' '.$row->paterno.' '.$row->materno."</a>"; ?></td>
					<td><?php echo $row->fono ?></td>
					<td><?php echo $row->desc_ciudades ?></td>
					<td><?php echo $row->especialidad1." ".$row->especialidad2 ?></td>
					<td><?php echo $row->nota_conocimiento ?></td>
					<td><?php echo "<a id='masso_".$row->id_user."' target='_blank' href='".base_url()."est/evaluaciones/informe/".$row->id_user."' style='".$color_masso."'>".$row->masso."</a>"; ?></td>
					<td><?php echo "<a id='examen_".$row->id_user."' target='_blank' href='".base_url()."est/evaluaciones/informe/".$row->id_user."' style='".$color_eval."'>".$row->examen_pre."</a>"; ?></td>
					<td><?php echo "<a style='".$color_tecnico_sup."'>".$row->vigencia_psicologico."<br>".$row->resultado_pisocologico."</a>"; ?></td>
					<td><?php echo $row->fecha_nacimiento ?></td>
					<td><?php echo "<a target=_'blank' style='".$color_cv."' href='".$url_cv."' >CV</a> - <a target=_'blank' style='".$color_afp."' href='".$url_afp."' >AFP</a> - <a target=_'blank' style='".$color_salud."' href='".$url_salud."' >SALUD</a> - <a target=_'blank' style='".$color_estu."' href='".$url_estu."' >ESTU</a>"; ?></td>
					<td>
						<?php
							echo "<a href='".base_url()."est/trabajadores/anotaciones/".$row->id_user."' target='_blank'><img src='".$anotacion."'></a>";
						
							if($row->requerimiento)
								echo "<a style='color:red;' target='_blank' title='".$row->nombre_req."' href='".base_url()."est/requerimiento/usuarios_requerimiento/".$row->requerimiento_area_cargo."/".$row->id_user."'><i class='fa fa-flag'></i></a>";
							else 
								echo "<i style='color:green;' class='fa fa-flag'></i>";

							echo "<a href='".base_url()."est/evaluaciones/informe/".$row->id_user."' target='_blank'><i class='fa fa-eye'></i></a>";
							echo "<a href='".base_url()."usuarios/perfil/trabajador_est/".$row->id_user."#datos-personales' target='_blank'><i class='fa fa-edit'></i></a>";
							//echo "<a data-usuario='".$row->id_user."' href='".base_url()."est/evaluaciones/listado_usuario/".$row->id_user."' class='sv-callback-list'><i class='fa fa-book'></i></a>";
						?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>











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
				<input type="checkbox" name="email" value="1" class="grey">
				Email
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