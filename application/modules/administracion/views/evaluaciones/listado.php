<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>extras/css/date.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/listado_evaluaciones.js" type="text/javascript"></script>
<div class="span8">
	<h2>Examenes de <?php echo ucwords( mb_strtolower($tipo, 'UTF-8')) ?></h2>
	<?php if(count($listado) > 0){ ?>
	<p>Resultados totales: <?php echo $totales ?> resultados.</p>
	<table class="data display">
		<thead>
			<tr>
				<th>&nbsp;</th>
				<?php if(empty($sin_planta)){ ?><th>Planta</th><?php } ?>
				<th>Rut Trabajador</th>
				<th>Nombre Trabajador</th>
				<th>Nombre Evaluacion</th>
				<th>Fecha Evaluacion</th>
				<?php if($con_vigencia){ ?><th>Fecha Vigencia</th><?php } ?>
				<th>Resultado</th>
				<th>Archivo</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr class="odd gradeX">
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>><?php if(!empty($l->id)){ ?><input type="radio" name="asignar" value="<?php echo @$l->id ?>"><?php }else{ echo '';} ?></td>
				<?php if(empty($sin_planta)){ ?><td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>><?php echo (empty($l->planta))? 'Sin Planta' : ucfirst(mb_strtolower($l->planta,'UTF-8')); ?></td><?php } ?>
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>><?php echo $l->rut ?></td>
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>><a href="javascript:;"><?php echo ucfirst(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8')) ?></a></td>
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>><?php echo (!empty($l->n_eval))? ucfirst(mb_strtolower($l->n_eval,'UTF-8')):'' ?></td>
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>>
					<?php 
						if(!empty($l->fecha_e)){
						$f = explode('-',$l->fecha_e); 
						echo $f[2].'-'.$f[1].'-'.$f[0];
						}
						else echo "Sin Fecha"; 
					?>
				</td>
				<?php if(!empty($con_vigencia)){ ?>
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>>
					<?php 
						if(!empty($l->fecha_v)){
						$f = explode('-',$l->fecha_v); 
						echo $f[2].'-'.$f[1].'-'.$f[0];
						}
						else echo "Sin Fecha"; 
					?>
				</td>
				<?php } ?>
				<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>>
					<?php 
					if(empty($l->resultado)){
						echo "Sin resultados";
					}
					else{
						if($l->t_eval == "MEDICA" ){
							if($l->tipo_resultado == 2){
								if($l->resultado == 0) echo "Sin Contraindicaciones";
								if($l->resultado == 1) echo "Con Contraindicaciones";
							}
							elseif($l->tipo_resultado == 1){
								echo $l->resultado;
							}
						}
						elseif($l->t_eval == "CONOCIMIENTO" ){
							if($l->tipo_resultado == 2){
								if($l->resultado == 0) echo "Aprobado";
								if($l->resultado == 1) echo "Rechazado";
							}
							elseif($l->tipo_resultado == 1){
								echo $l->resultado;
							}
						}
						// elseif($l->t_eval == "SEGURIDAD" ){
							// if($l->tipo_resultado == 2){
								// if($l->resultado == 0) echo "Aprobado";
								// if($l->resultado == 1) echo "Rechazado";
							// }
							// elseif($l->tipo_resultado == 1){
								// echo $l->resultado;
							// }
						// }
						else{
							echo @$l->resultado;
						}
					}
				?></td>
				<td><?php if(empty($l->archivo)){ ?> <img title="no disponible" alt="no disponible" src="<?php echo base_url() ?>extras/img/del.png" /> <?php }
					else { ?> <a target="_blank" href="<?php echo base_url(). $l->archivo ?>"><img title="disponible" alt="disponible" src="<?php echo base_url() ?>extras/img/correct.png" /></a> <?php } ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
		<p>No se han agregado evaluaciones al sistema</p>
	<?php } ?>
	<br />
	<div style="width: 100%;height: 1px;position: relative;clear: both;"></div>
	<?php echo $paginado ?>
	<br>
	<br>
</div>
<div class="span3">
	<div id="gallery_filter" class="box">
		<h3>Filtros</h3>
		<p>
			Para nueva busqueda, favor seleccione uno o mas filtros.
		</p>
		<form method="post" action="<?php echo base_url() ?>administracion/evaluaciones/filtrar/<?php echo $id_tipo ?>">
		<ul class="filters">
			<li>
				<input type="radio" name="radio_eval" value="1" /> Vigentes
			</li>
			<li>
				<input type="radio" name="radio_eval" value="2" /> No vigentes
			</li>
			<li>
				<input type="radio" name="radio_eval" value="3" /> Sin evaluación
			</li>
			<li>
				<input type="radio" name="radio_eval" value="4" /> Todos
			</li>
			<li>
				<a href="#">Nombre</a><br />
				<input type="text" name="nombre" value="<?php if(@$input_nombre) echo @$input_nombre; ?>" style="<?php if(!@$input_nombre) echo 'display: none;'; ?>" />
			</li>
			<li>
				<a href="#">Rut</a><br />
				<input type="text" name="rut" value="<?php if(@$input_rut) echo @$input_rut; ?>" style="<?php if(!@$input_rut) echo 'display: none;'; ?>" />
			</li>
			<?php if(!$sin_planta){ ?><li>
				<a href="#">Planta</a><br />
				<select name="planta" style="<?php if(!@$input_planta) echo 'display: none;'; ?> width: 188px;">
					<option value="">Seleccione...</option>
					<?php foreach($listado_planta as $ip){ ?>
						<option value="<?php echo $ip->id ?>" <?php if((isset($input_planta)) && ($input_planta==$ip->id)) echo 'selected="true"'; ?>><?php echo ucwords( mb_strtolower($ip->nombre,'UTF-8')) ?></option>
					<?php } ?>
				</select>
			</li><?php } ?>
			<li>
				<a href="#">Tipo evaluación</a><br />
				<select name="tipo" style="<?php if(!@$input_tipo) echo 'display: none;'; ?> width: 188px;">
				<option value="">Seleccionar</option>
				<?php foreach($listar_tipo as $lt){ ?>
				<option value="<?php echo $lt->id ?>" <?php if((isset($input_tipo)) && ($input_tipo==$lt->id)) echo 'selected="true"'; ?>><?php echo ucwords(mb_strtolower($lt->nombre, 'UTF-8')) ?></option>
				<?php } ?>
				</select>
			</li>
			<li>
				<a class="dos" href="#">Rango evaluaciones</a><br />
				<input type="text" name="rango_1" class="rango" value="<?php if(@$input_rango1) echo @$input_rango1; ?>" style="<?php if(!$input_rango1) echo 'display: none;width: 140px;'; ?>" /><br/>
				<input type="text" name="rango_2" class="rango" value="<?php if(@$input_rango2) echo @$input_rango2; ?>" style="<?php if(!$input_rango1) echo 'display: none;width: 140px;'; ?>" />
			</li>
		</ul>
		<br />
		<button id="btn_filtrar" type="submit" class="btn primary">
			Filtrar
		</button>
		</form>
	</div>
	<a href="<?php echo base_url() ?>administracion/evaluaciones/editar/" id="editar_eval" class="btn xlarge primary dashboard_add">Editar Evaluación</a>
	<a href="<?php echo base_url() ?>administracion/evaluaciones/eliminar/" id="del_eval" class="btn xlarge secondary dashboard_add">Eliminar</a>
</div>
