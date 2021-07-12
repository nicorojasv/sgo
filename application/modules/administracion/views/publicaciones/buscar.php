<script src="<?php echo base_url() ?>extras/js/administracion/noticias.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Listado</h2>
	<select name="tipo" id="tipo">
		<option value="1" <?php if( empty($tipo) || $tipo ==  1){ echo "selected='selected'"; } ?> >Noticias</option>
		<!--<option value="2" <?php if( $tipo ==  2){ echo "selected='selected'"; } ?> >Avisos</option>
		<option value="3" <?php if( $tipo ==  3){ echo "selected='selected'"; } ?> >Requerimientos</option>-->
		<option value="4" <?php if( $tipo ==  4){ echo "selected='selected'"; } ?> >Capacitación</option>
	</select>
	<?php if( count($listado) > 0 ){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Titulo</th>
				<th>Texto</th>
				<th>Para</th>
				<th colspan="2">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($listado as $n) { ?>
			<tr class="odd gradeX">
				<td><?php echo $n->titulo ?></td>
				<?php $texto = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2', $n->texto); ?>
				<td><?php echo word_limiter(strip_tags($texto),23) ?>
				<div><a href="<?php echo base_url() ?>administracion/publicaciones/detalle/<?php echo $tipo ?>/<?php echo encrypt($n->id) ?>">Ver publicación</a></div>
				</td>
				<td><?php echo $n->tipo_usuario ?></td>
				<td class="center"><a href="<?php echo base_url() ?>administracion/publicaciones/editar/<?php echo $tipo ?>/<?php echo encrypt($n->id) ?>">editar</a></td>
				<td class="center"><a class="eliminar-noticia" href="<?php echo base_url() ?>administracion/publicaciones/eliminar_publicacion/<?php echo $tipo ?>/<?php echo encrypt($n->id) ?>">eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php }
	else { ?>
		<p>No existen datos para lo requerido</p>
	<?php } ?>
</div>
<div class="span3">
	<a href="<?php echo base_url() ?>administracion/publicaciones/publicar" class="btn xlarge primary dashboard_add"><span></span>Publicar</a>
</div>