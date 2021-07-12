<!--<link href="<?php echo base_url() ?>extras/css/date.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.js" type="text/javascript"></script>-->
<div class='col-xs-8'>
	<div class='panel'>
		<div class="panel-heading">
			<h4 class="panel-title">Examenes de <span class="text-bold"><?php echo ucwords( mb_strtolower($tipo, 'UTF-8')) ?></span></h4>
			<div class="panel-tools">
				<div class="dropdown">
					<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
						<i class="fa fa-cog"></i>
					</a>
					<ul class="dropdown-menu dropdown-light pull-right" role="menu">
						<li>
							<a class="panel-collapse collapses" href="ui_panels.html#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
						</li>
						<li>
							<a class="panel-refresh" href="ui_panels.html#">
								<i class="fa fa-refresh"></i> <span>Refresh</span>
							</a>
						</li>
						<li>
							<a class="panel-config" href="ui_panels.html#panel-config" data-toggle="modal">
								<i class="fa fa-wrench"></i> <span>Configurations</span>
							</a>
						</li>
						<li>
							<a class="panel-expand" href="ui_panels.html#">
								<i class="fa fa-expand"></i> <span>Fullscreen</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class='panel-body'>
			<?php if(count($listado) > 0){ ?>
			<p>Resultados totales: <?php echo $totales ?> resultados.</p>
			<a class="btn btn-green show-sv" href="#example-subview-1" data-startFrom="right">Show Right Subview <i class="fa fa-chevron-right"></i></a>
			<table class="table">
				<thead>
					<tr>
						<th>#</th><!-- style="width: 10px;" -->
						<th>Rut Trabajador</th><!-- style="width: 95px;" -->
						<th>Nombre Trabajador</th><!-- style="width: 210px;" -->
						<th>Examenes</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($listado as $l){ ?>
					<tr class="odd gradeX">
						<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>><input type="radio" name="asignar" value="<?php echo $id_tipo ?>/<?php echo $l->id_usr ?>"></td>
						<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>>
							<?php echo $l->rut ?>
						</td>
						<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>>
							<a href="javascript:;"><?php echo ucfirst(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8')) ?></a>
						</td>
						<td <?php if(@$l->resultado == 1) echo "style='background-color:#EBEBEB;'"; ?>>
							<?php if(isset($l->id_usr) && isset($l->id_tipo) ){ ?>
							<?php foreach($this->Evaluaciones_model->ob_usuario($l->id_usr,$id_tipo) as $ob){ ?>
								<?php if( isset($ob->url)) { ?>
									<?php if( strtolower(end(explode(".", $ob->url))) == 'pdf' ){ ?>
										<div style="float: left;margin-left: 5px;">
											<a style="display: block;color:#0A1E9F;" class="popovers" href='#' rel="<?php echo base_url()?>administracion/evaluaciones/tooltip/<?php echo $ob->id_evaluacion ?>">
												<i class="fa fa-2x fa-file-pdf-o"></i><br />
											<span style="float: left"><?php echo mb_strtolower($ob->abreviacion , 'UTF-8') ?></span></a>
										</div>
									<?php } elseif( strtolower(end(explode(".", $ob->url))) == 'doc' || strtolower(end(explode(".", $ob->url))) == 'docx'){ ?>
										<div style="float: left;margin-left: 5px;">
											<a style="display: block;color:#0A1E9F;" href="#" rel="<?php echo base_url()?>administracion/evaluaciones/tooltip/<?php echo $ob->id_evaluacion ?>">
												<i class="fa fa-2x fa-file-word-o"></i><br />
											<span style="float: left"><?php echo mb_strtolower($ob->abreviacion , 'UTF-8') ?></span></a>
										</div>
									<?php } ?>
								<?php } else { ?>
										<div style="float: left;margin-left: 5px;">
											<a style="display: block;color:red;" href='#' rel="<?php echo base_url()?>administracion/evaluaciones/tooltip/<?php echo $ob->id_evaluacion ?>">
											<i class="fa fa-2x fa-slack"></i><br />
											<span style="float: left"><?php echo mb_strtolower($ob->abreviacion , 'UTF-8') ?></span></a>
										</div>
								<?php } ?>
							<?php } ?>
							<?php } ?>
						</td>
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
	</div>
</div>
<div class='col-xs-4'>
	<div id="gallery_filter" class="box">
		<h3>Filtros</h3>
		<p>
			Para nueva busqueda, favor seleccione uno o mas filtros.
		</p>
		<form method="post" action="<?php echo base_url() ?>administracion/evaluaciones/filtrar/<?php echo $id_tipo ?>">
		<ul class="filters">
			<li>
				<input type="radio" name="radio_eval" value="1" <?php echo (@$input_radio == 1) ? 'checked':''; ?> /> Vigentes
			</li>
			<li>
				<input type="radio" name="radio_eval" value="2" <?php echo (@$input_radio == 2) ? 'checked' : ''; ?> /> No vigentes
			</li>
			<li>
				<input type="radio" name="radio_eval" value="3" <?php echo (@$input_radio == 3) ? 'checked':''; ?> /> Sin evaluación
			</li>
			<li>
				<input type="radio" name="radio_eval" value="4" <?php echo (@$input_radio == 4) ? 'checked': ''; ?> /> Todos
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
	<br />
	<a data-toggle="modal" href="<?php echo base_url() ?>administracion/evaluaciones/agregar/" data-target="#myModal" id="add_eval" class="btn btn-dark-blue">Agregar</a>
	<a data-toggle="modal" href="<?php echo base_url() ?>administracion/evaluaciones/editar/" id="editar_eval" data-target="#myModal" class="btn btn-dark-blue">Editar Evaluación</a>
	<a href="<?php echo base_url() ?>administracion/evaluaciones/eliminar/" id="del_eval" class="btn btn-danger">Eliminar</a>


	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="exampleModalLabel">Evaluaci&oacute;n</h4>
		      </div>
		      <div class="modal-body">
		        
		      </div>
		    </div>
		  </div>
		</div>
	<!-- End Modal -->
</div>
