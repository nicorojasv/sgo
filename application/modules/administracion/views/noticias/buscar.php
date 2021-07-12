<script src="<?php echo base_url() ?>extras/js/administracion/noticias.js" type="text/javascript"></script>
<div class="grid grid_17">
	<?php echo @$aviso; ?>
	<h2>Listado de noticias</h2>
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
			<?php foreach ($noticias as $n) { ?>
			<tr class="odd gradeX">
				<td><?php echo $n->titulo ?></td>
				<td><?php echo word_limiter($n->texto,23) ?>
				<div><a href="<?php echo base_url() ?>administracion/noticia/detalle/<?php echo urlencode(base64_encode($n->id)) ?>">Ver noticia</a></div>
				</td>
				<td><?php echo $n->tipo_usuario ?></td>
				<td class="center"><a href="#">editar</a></td>
				<td class="center"><a class="eliminar-noticia" href="<?php echo base_url() ?>administracion/noticia/eliminar/<?php echo $n->id ?>">eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="grid grid_7">
	<a href="<?php echo base_url() ?>administracion/publicaciones/publicar" class="btn xlarge secondary dashboard_add"><span></span>Publicar Noticia</a>
	<a href="<?php echo base_url() ?>administracion/noticia/buscar" class="btn xlarge primary dashboard_add">Noticias Publicadas</a>
</div>