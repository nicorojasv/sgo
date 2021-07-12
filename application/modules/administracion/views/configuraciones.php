<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<h2>Listado de <?php echo $subtitulo; ?></h2>
<table class="data display">
	<thead>
		<tr>
			<th>Codigo</th>
			<th>Nombre</th>
			<th colspan="2">Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listados as $ls) { ?>
		<tr class="odd gradeX">
			<td><?php echo $ls->id ?></td>
			<td><?php echo ucwords( mb_strtolower($ls->nombre , 'UTF-8')) ?></td>
			<td class="center"><a href="<?php echo $url_editar_modal.'/'.$ls->id ?>" class="dialog">editar</a></td>
			<td class="center"><a href="#">eliminar</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>


<!-- OVERLAY CON EL INGRESO DE UN AREA -->
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
<!-- -->