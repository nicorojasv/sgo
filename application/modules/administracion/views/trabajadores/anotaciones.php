<script src="<?php echo base_url() ?>extras/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/bootstrap-editable.min.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>extras/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>extras/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
<div id="contact_profile" class="grid grid_17 append_1">
	<table>
		<tbody>
			<tr>
				<td class="td_avatar">
					<a href="<?php echo base_url().@$imagen_grande->nombre_archivo ?>" class="lightbox">
						<img src="<?php echo base_url().$imagen_grande->thumb ?>" class="avatar" alt="Imagen Perfil">
					</a> 
				</td>
				<td class="td_info"><h1 class="contact_name"><?php echo ucwords(mb_strtolower($usuario -> nombres . ' ' . $usuario -> paterno . ' ' . $usuario -> materno,"UTF-8"));?></h1>
				<p class="contact_company">
					<?php if($this -> session -> userdata('tipo') == 3) $url = base_url().'administracion/trabajadores/buscar'; else $url = 'javascript:;'; ?>
					<a href="<?php echo $url ?>"><?php echo ucwords(mb_strtolower($tipo_usuario->desc_tipo_usuarios,"UTF-8")); ?></a>
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
	<a href="#myModal" role="button" class="btn" data-toggle="modal">Agregar Anotación</a>
	<button id="enable" class="btn">Editar</button>
</div>
<div class="span10">
	<?php if(empty($listado)){ ?>
	<p>El usuario no tiene anotaciones</p>
	<?php } else{ ?>
	<table style="width:100%" class="table table-striped">
		<thead>
			<th style="text-align:center;width:50px">Tipo</th>
			<th style="text-align:center;width:100px">Fecha</th>
			<th style="text-align:center;width:300px">Anotaciones</th>
			<th style="text-align:center;width:300px">¿Quién solicitó la Anotación?</th>
			<th style="text-align:center;width:100px">Archivo</th>
		</thead>
		<tbody>
			<?php foreach ($listado as $l) { ?>
				<tr>
					<td style="text-align:center">
						<a href="#" id="tipo<?php echo $l->id ?>" class="editable" data-name="tipo" data-type="select" data-pk="<?php echo $l->id ?>" data-url="<?php echo base_url() ?>administracion/trabajadores/editar_anotaciones" data-original-title="Seleccione tipo" data-placement="right"><?php echo $l->tipo; ?></a>
						<script type="text/javascript">
						$(function(){
							$('#tipo<?php echo $l->id ?>').editable({
						        source: [
						            {value: '-', text: '-'},
						            {value: 'LNP', text: 'LNP'},
						            {value: 'LN', text: 'LN'}
						        ]
						    }); 
						});
						</script>
					</td>
					<td style="text-align:center">
						<a href="#" id="vacation" data-name="fecha" data-type="date" data-viewformat="yyyy-mm-dd" data-pk="<?php echo $l->id ?>" data-placement="right" data-original-title="Fecha de la anotación" class="editable" data-url="<?php echo base_url() ?>administracion/trabajadores/editar_anotaciones"><?php echo $l->fecha; ?></a>
					</td>
					<td style="text-align:left">
						<a href="#" data-type="textarea" data-name="anotacion" data-pk="<?php echo $l->id ?>" data-original-title="Detalle la anotación" class="editable" data-url="<?php echo base_url() ?>administracion/trabajadores/editar_anotaciones">
							<?php echo $l->anotacion; ?>
						</a>
					</td>
					<td style="text-align:center">
						<a href="#" data-type="text" data-name="quien" data-pk="<?php echo $l->id ?>" data-original-title="Detalle quien solicito la anotación" class="editable editable-click" data-url="<?php echo base_url() ?>administracion/trabajadores/editar_anotaciones"><?php echo $l->quien ?></a>
					</td>
					<td><a href="<?php echo base_url().$l->archivo; ?>" target="_blank">Descargar</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
</div>
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Nueva Anotación</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" method="post" action="<?php echo base_url() ?>administracion/trabajadores/guardar_anotacion/<?php echo $id; ?>" enctype="multipart/form-data">
  <div class="control-group">
    <label class="control-label" for="inputTipo">Tipo</label>
    <div class="controls">
      	<select name="tipo">
      		<option value='0'>Seleccione</option>
			<option> - </option>
			<option>LNP</option>
			<option>LN</option>
		</select>
    </div>
  </div>
  <div class="control-group">
  	<?php $fecha_actual = date("d-m-Y"); ?>
    <label class="control-label" for="inputFecha">Fecha</label>
    <div class="controls">
      <div class="input-append date" id="dp3" data-date="<?php echo $fecha_actual; ?>" data-date-format="dd-mm-yyyy">
		<input type="text" value="<?php echo $fecha_actual; ?>" readonly="" name="fecha" style="width: 180px;">
		<span class="add-on"><i class="icon-calendar"></i></span>
	  </div>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputFecha">Anotación</label>
    <div class="controls">
      <textarea rows="3" name="texto"></textarea>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputFecha">¿Quién solicitó?</label>
    <div class="controls">
      <input type="text" name="quien" id="inputQuien" placeholder="Quién?">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputFecha">Archivo</label>
    <div class="controls">
     	<div class="fileupload fileupload-new" data-provides="fileupload">
		  <span class="btn btn-file"><span class="fileupload-new">Seleccione archivo</span><span class="fileupload-exists">Cambiar</span><input type="file" name="attach" /></span>
		  <span class="fileupload-preview"></span>
		  <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
		</div>
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
  </div>
</form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#dp3').datepicker();
	$('.editable').editable();
	$('.editable').editable('toggleDisabled');
	$('#enable').click(function() {
       $('.editable').editable('toggleDisabled');
   });
});
</script>