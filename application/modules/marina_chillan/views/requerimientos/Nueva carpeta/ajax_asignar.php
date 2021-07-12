<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<META name="robots" content="NOINDEX,NOFOLLOW,NOARCHIVE,NOODP,NOSNIPPET">
		<title><?php echo $titulo; ?></title>
		<link href="<?php echo base_url() ?>extras/css/reseter_v2.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/base.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.maskedinput.min.js" type="text/javascript"></script>
		<link href="<?php echo base_url() ?>extras/js/lightbox/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/lightbox/jquery.lightbox-0.5.min.js" type="text/javascript"></script>
		<link href="<?php echo base_url() ?>extras/js/msgbox/jquery.msgbox.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/msgbox/jquery.msgbox.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/DD_roundies_0.0.2a-min.js"></script>
		<!-- -->
		<link href="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/date.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/js/colorbox/colorbox.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jquery.tools.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/requerimiento_admin.js" type="text/javascript"></script>
		<!-- -->
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		DD_roundies.addRule('.btn', '4px');
		DD_roundies.addRule('.notify' , '100px');
		</script>
		<script src="<?php echo base_url() ?>extras/js/base.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="contenido">
			<div class="contenido">
<div class="grid grid_18">
	<ul class="gallery cf ui-sortable">
		<?php if(count($listado_usuarios) > 0){ ?>
		<?php foreach($listado_usuarios as $u){?>
			<?php if(!$u->check){ ?>
				<li title="<?php echo $u->id_otro_req; ?>" class="<?php if($u->otro_req) echo 'opaco'; ?>">
					<input type="checkbox" name="<?php echo $u->id ?>" class="check-reemplazo" alt="<?php echo $id_subreq ?>" />
					<input type="hidden" name="req_anterior" value="<?php echo @$u->id_otro_req_padre ?>" />
					<input type="hidden" name="id_usuario" value="<?php echo $u->id ?>" />
					<img alt="" src="<?php echo base_url().$u->foto ?>">
					<a class="tooltip" href="#" rel="<?php echo base_url()?>administracion/requerimiento/tooltip/<?php echo $u->id ?>">
					<div><?php echo ucwords(mb_strtolower($u->nombres." ".$u->paterno." ".$u->materno,"UTF-8")) ?></div>
					<div><?php echo $u->rut ?></div>
					</a>
				</li>
			<?php } ?>
		<?php } ?>
		<?php } else{ ?>
		<p>No existen usuarios para este criterio.</p>
		<?php }?>
	</ul>
	<br />
	<div style="width: 100%;height: 1px;position: relative;clear: both;"></div>
	<div style="position:relative;float:left;width:150px;margin-top: 17px;margin-left: 10px;">
		<?php if(count($listado_usuarios) > 0){ ?>
		<button id="boton_reemplazo" type="submit" class="btn primary">
			Reemplazar
		</button>
		<?php } ?>
	</div>
	<?php echo $paginado ?>
	<br>
	<br>
</div>
<div class="grid grid_6">
	<div id="gallery_filter" class="box">
		<h3>Filtros</h3>
		<p>
			Para nueva busqueda, favor seleccione uno o mas filtros.
		</p>
		<form method="post" action="<?php echo base_url() ?>administracion/requerimiento/filtrar/2">
		<ul class="filters">
			<li>
				<a href="#">Nombre</a><br />
				<input type="text" name="nombre" value="<?php if($input_nombre) echo $input_nombre; ?>" style="<?php if(!$input_nombre) echo 'display: none;'; ?>" />
			</li>
			<li>
				<a href="#">Rut</a><br />
				<input type="text" name="rut" value="<?php if($input_rut) echo $input_rut; ?>" style="<?php if(!$input_rut) echo 'display: none;'; ?>" />
			</li>
			<li>
				<a href="#">Profesión</a><br />
				<select name="profesion" style="<?php if(!$input_profesion) echo 'display: none;'; ?>width: 188px;" >
					<option value="">Seleccione...</option>
					<?php foreach($listado_profesiones as $p){ ?>
					<option value="<?php echo $p->id ?>" <?php if((isset($input_profesion)) && ($input_profesion==$p->id)) echo 'selected="true"'; ?> ><?php echo $p->desc_profesiones ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<a href="#">Especialidad</a><br />
				<select name="especialidad" style="<?php if(!$input_especialidad) echo 'display: none;'; ?> width: 188px;">
					<option value="">Seleccione...</option>
					<?php foreach($listado_especialidad as $e){ ?>
					<option value="<?php echo $e->id ?>" <?php if((isset($input_especialidad)) && ($input_especialidad==$e->id)) echo 'selected="true"'; ?>><?php echo $e->desc_especialidad ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<a href="#">Ciudad</a><br />
				<select name="ciudad" style="<?php if(!$input_ciudad) echo 'display: none;'; ?> width: 188px;">
					<option value="">Seleccione...</option>
					<?php foreach($listado_ciudades as $c){ ?>
					<option value="<?php echo $c->id ?>" <?php if((isset($input_ciudad)) && ($input_ciudad==$c->id)) echo 'selected="true"'; ?>><?php echo $c->desc_ciudades ?></option>
					<?php } ?>
				</select>
			</li>
			<li>
				<a href="#">Estado</a><br />
				<select name="estado" style="<?php if(!$input_estado) echo 'display: none;'; ?>">
					<option value="">Ambos...</option>
					<option value="1" <?php if((isset($input_estado)) && ($input_estado==1)) echo 'selected="true"'; ?>>Activo</option>
					<option value="2" <?php if((isset($input_estado)) && ($input_estado==2)) echo 'selected="true"'; ?>>Inactivo</option>
				</select>
			</li>
		</ul>
		<br />
		<input type="hidden" name="id" value="<?php echo $id ?>" />
		<input type="hidden" name="id_req" value="<?php echo $id_req ?>" />
		<button id="btn_filtrar" type="submit" class="btn primary">
			Filtrar
		</button>
		</form>
	</div>
</div>
</div>
</div>
<script src="<?php echo base_url() ?>extras/js/reemplazo.js" type="text/javascript"></script>
</body>
</html>