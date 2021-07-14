
<div class="panel panel-white">
	<div class="panel-body">
		<div id="contact_profile" class="col-md-12">
			<table>
				<tbody>
					<tr>
						<td class="td_avatar">
							<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
								<img src="https://sgo2.integraest.cl/extras/layout2.0/img_perfil/default_thumb.jpg" class="avatar" alt="Imagen Perfil">
							</a> 
						</td>
						<td class="td_info"><h1 class="contact_name"><?php echo $usuario->nombres." ".$usuario->paterno." ".$usuario->materno ?></h1>
						<p class="contact_company">
							<?php $url = 'javascript:;'; ?>
							<a href="<?php echo $url ?>">desc tipo usuario</a>
						</p>
						<p class="contact_tags">
							
							<span>Ultima actualizacion: hoy</span>
						</p></td>
					</tr>
				</tbody>
			</table>
			<hr>
			<a href="#sv-listado" role="button" class="btn btn-primary show-sv" data-startfrom="right">Agregar Anotación</a>
		</div>
	</div>
	<!---->
	<div class="panel-body">
	<div class="col-md-12">
		<?php if(empty($listado)){ ?>
		<p>El usuario no tiene anotaciones</p>
		<?php } else{ ?>
		<table style="width:100%" class="table table-striped">
			<thead>
				<th style="text-align:center;width:50px">Tipo</th>
				<th style="text-align:center;width:100px">Fecha</th>
				<th style="text-align:center;width:300px">Anotaciones</th>
				<!--<th style="text-align:center;width:100px">Acciones</th>-->
			</thead>
			<tbody>
				<?php foreach ($listado as $l) { ?>
					<tr>
						<td style="text-align:center">
							<a href="#" id="tipo<?php echo $l->id ?>" class="editable" data-name="tipo" data-type="select" data-pk="<?php echo $l->id ?>" data-url="<?php echo base_url() ?>carrera/trabajadores/editar_anotaciones" data-original-title="Seleccione tipo" data-placement="right"><?php echo $l->tipo; ?></a>
						</td>
						<td class="center">
							<a href="#" id="vacation" data-name="fecha" data-type="date" data-viewformat="yyyy-mm-dd" data-pk="<?php echo $l->id ?>" data-placement="right" data-original-title="Fecha de la anotación" class="editable" data-url="<?php echo base_url() ?>carrera/trabajadores/editar_anotaciones"><?php echo $l->fecha; ?></a>
						</td>
						<td class="center">
							<a href="#" data-type="textarea" data-name="anotacion" data-pk="<?php echo $l->id ?>" data-original-title="Detalle la anotación" class="editable" data-url="<?php echo base_url() ?>carrera/trabajadores/editar_anotaciones">
								<?php echo $l->anotacion; ?>
							</a>
						</td>
						
						<!--<td class="center">
								<a class="eliminar" href="<?php //echo base_url() ?>carrera/trabajadores/eliminar_anotacion/<?php // echo $usuario->id ?>/<?php //echo $l->lista_id; ?>"><i class="fa fa-trash-o"></i></a>
						
						</td>-->
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } ?>
	</div>
	</div>
<!---->
</div>

<script type="text/javascript">
	$(document).ready(function(){
	$(".eliminar").on('click',function(event){
		event.preventDefault();
		link = $(this).attr('href');;
		bootbox.confirm("Esta seguro que desea eliminar este elemento??", function(result) {
			if(result){
				window.location=link;
			}
		}); 
	});
});
</script>

<div id="sv-listado" class="no-display">
	<div class="col-md-12">
		<br />
		<form class="form-horizontal" method="post" role="form" action="<?php echo base_url() ?>carrera/trabajadores/guardar_anotacion/<?php echo $usuario->id; ?>" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputTipo">Tipo</label>
				<div class="col-sm-9">
				  	<select name="tipo" class="form-control">
				  		<option value='grave'>Grave</option>
				  		<option value='leve'>Leve</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<?php $fecha_actual = date("d-m-Y"); ?>
				<label class="col-sm-2 control-label" for="inputFecha">Fecha</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input type="text" id="dp3" data-date-format="dd-mm-yyyy" name="fecha" data-date-viewmode="years" value="<?php echo $fecha_actual; ?>" class="form-control date-picker">
						<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputFecha">Anotación</label>
				<div class="col-sm-9">
					<textarea rows="3" name="texto" class="form-control"></textarea>
				</div>
			</div>
			<!--<div class="form-group">
				<label class="col-sm-2 control-label" for="inputFecha">¿Quién solicitó?</label>
				<div class="col-sm-9">
					<input type="text" name="quien" id="inputQuien" class="form-control" placeholder="Quién?">
				</div>
			</div>-->
			<!---<div class="form-group">
				<label class="col-sm-2 control-label" for="inputFecha">Archivo</label>
				<div class="col-sm-9">
				 	<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-group">
							<div class="form-control uneditable-input">
								<i class="fa fa-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<div class="input-group-btn">
								<div class="btn btn-light-grey btn-file">
									<span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Seleccionar archivo</span>
									<span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Cambiar</span>
									<input type="file" class="file-input" name="attach">
								</div>
								<a href="form_elements.html#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
									<i class="fa fa-times"></i> Eliminar
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>-->
			<div class="form-group">
				<div class="col-sm-2"></div>
				<div class="col-sm-9">
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>