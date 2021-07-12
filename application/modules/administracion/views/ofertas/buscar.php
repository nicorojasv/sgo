<script src="<?php echo base_url() ?>extras/js/administracion/noticias.js" type="text/javascript"></script>
<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Listado</h2>
	<?php if( count($listado) > 0 ){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Titulo</th>
				<th>Texto</th>
				<th>Para</th>
				<th style="width:61px;">Estado</th>
				<th colspan="3">Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($listado as $n) { ?>
			<tr class="odd gradeX">
				<td><?php echo $n->titulo ?></td>
				<?php $texto = preg_replace('/(<\/[^>]+?>)(<[^>\/][^>]*?>)/', '$1 $2', $n->texto); ?>
				<td><?php echo word_limiter(strip_tags($texto),23) ?>
				<div><a href="<?php echo base_url() ?>administracion/ofertas/detalle/<?php echo encrypt($n->id) ?>">Ver Oferta</a></div>
				</td>
				<td><?php echo $n->tipo_usuario ?></td>
				<td>
					<?php 
					if( $n->activo == 0 ){ echo "<div style='color:green'>Vigente</div>";} 
					else{ echo "<div style='color:red'>No Vigente</div>"; } ?>
				</td>
				<td class="center">
					<a href="<?php echo base_url() ?>administracion/ofertas/editar/<?php echo encrypt($n->id) ?>" title="Editar">
						<i class="icon-edit"></i>
					</a>
				</td>
				<td class="center"><a class="eliminar-noticia" href="<?php echo base_url() ?>administracion/ofertas/eliminar_publicacion/<?php echo encrypt($n->id) ?>" title="Eliminar">
					<i class="icon-trash"></i>
				</a></td>
				<td class="center">
					<?php if( $n->activo == 0 ){ ?>
					<a class="" onclick="return confirm('Va a cambiar a no vigente, ¿Está seguro?');" href="<?php echo base_url() ?>
						administracion/ofertas/des_activar/<?php echo encrypt($n->id) ?>/1" title="No Vigente">
						<i class="icon-ban-circle"></i>
					</a>
					<?php } else{ ?>
					<a class="" onclick="return confirm('Va a cambiar a vigente, ¿Está seguro?');" href="<?php echo base_url() ?>
						administracion/ofertas/des_activar/<?php echo encrypt($n->id) ?>/vig/0" title="Vigente">
						<i class="icon-ok-circle"></i>
					</a>
					<?php } ?>
				</td>
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
	<a href="<?php echo base_url() ?>administracion/ofertas/publicar" class="btn xlarge primary dashboard_add"><span></span>Nueva Oferta</a>
</div>