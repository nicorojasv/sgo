<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/requerimiento_admin.js" type="text/javascript"></script>
<div class="span11" style="width:95%;">
	<?php echo @$aviso; ?>
	<h2>Nuevos requerimientos</h2>
	<form method="get" action="">
	<div>Plantas: 
		<select name="planta" id="grupo_asc_planta">
			<option value='0'>Ver Todas</option>
			<?php foreach ($l_plantas as $p) { ?>
				<option value='<?php echo $p->id ?>' <?php echo ($s_planta == $p->id)?' SELECTED': ''; ?>><?php echo $p->nombre ?></option>
			<?php } ?>
		</select>
		&nbsp;
		Grupos:
		<select name="grupo" id="grupo_asc">
			<option value='0'>Ver Todas</option>
			<?php foreach ($l_grupos as $g) { ?>
				<option value='<?php echo $g->id ?>' <?php echo ($s_grupo == $g->id)?' SELECTED': ''; ?>><?php echo $g->nombre ?></option>
			<?php } ?>
		</select>
		&nbsp;
		<input type="submit" value="Filtrar" class="btn btn-info">
	</div>
	</form>
	<?php if( count($requerimientos) > 0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>#</th>
				<th>Fecha Solicitud</th>
				<th>Cargo</th>
				<th>Cant.</th>
				<th>Inicio</th>
				<th>Fin</th>
				<th>Causal</th>
				<th>Motivo</th>
				<th>Planta</th>
				<th>Area</th>
				<th>Solicitante</th>
				<th>Grupo</th>
				<th>Comentarios</th>
				<th>Archivo</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($requerimientos as $r) { ?>
			<tr class="odd gradeX">
				<td><input type="radio" name="asignar" value="<?php echo $r->id ?>" /></td>
				<td><?php echo $r->f_solicitud; ?></td>
				<td><?php echo $r->cargo; ?></td>
				<td><?php echo $r->cantidad; ?></td>
				<td><?php echo $r->f_inicio; ?></td>
				<td><?php echo $r->f_termino; ?></td>
				<td><?php echo $r->causal; ?></td>
				<td><?php echo $r->motivo; ?></td>
				<td><?php echo $r->planta; ?></td>
				<td><?php echo $r->area; ?></td>
				<td><?php echo $r->solicitante; ?></td>
				<td><?php echo $r->grupo; ?></td>
				<td><?php echo $r->comentario; ?></td>
				<td></td>
				<td><a href="<?php echo base_url(); ?>administracion/requerimiento/usr_asignados/<?php echo $r->id; ?>"><?php echo $r->agregados; ?>/<?php echo $r->cantidad; ?></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
	<p>No existen nuevos requerimientos.</p>
	<?php } ?>
</div>
<!--<div class="span3">
	<a href="<?php echo base_url() ?>administracion/requerimiento/detalles" id="ver-detalles" class="btn xlarge primary dashboard_add"><span></span>Ver detalles</a>
	<a href="<?php echo base_url() ?>administracion/requerimiento/editar" id="editar_req" class="btn xlarge secondary dashboard_add">Editar</a>
	<a href="<?php echo base_url() ?>administracion/requerimiento/eliminar" id="eliminar_req" class="btn xlarge tertiary dashboard_add">Eliminar</a>
</div>-->

<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de <?php echo $modal_subtitulo; ?></h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese <?php echo $modal_subtitulo; ?>.
			</p>
			<form action="<?php echo base_url() ?>administracion/configuracion/<?php echo $url_guardar ?>" method="post" class="form">
				<?php if(isset($aux_regiones)){ ?>
				<div class="field select">
					<label for="region">Region:</label>
					<div class="fields">
						<select name="select_region" name="select_region">
							<option>Seleccione una región...</option>
							<?php foreach ($regiones as $r) { ?>
								<option value="<?php echo $r->id ?>"><?php echo $r->desc_regiones ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<?php } ?>
				<div class="field">
					<label for="nombre">Nombre:</label>
					<div class="fields">
						<input type="text" name="nombre" value="" id="nombre" size="30" tabindex="1">
					</div>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary" tabindex="1">
						Crear
					</button>
				</div>
			</form>
		</div>
	</div>
	   
</div>