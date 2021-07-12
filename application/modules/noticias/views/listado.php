<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Publicaciones</h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-2">
				<a href="<?php echo base_url() ?>noticias/crear" class="btn btn-primary">Crear Publicaci&oacute;n</a>
			</div>
			<div class="col-sm-4">
				<i style="color:green" class="fa fa-envelope-o"></i> Publicaci&oacute;n Enviada<br>
				<i style="color:red" class="fa fa-envelope-o"></i> Publicaci&oacute;n No Enviada
			</div>
		</div>
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-10">
				<table id="example1">
					<thead>
						<th>/</th>
						<th>Titulo</th>
						<th>Fecha</th>
						<th>Herramientas</th>
					</thead>
					<tbody>
						<?php $i = 0; foreach ($listado as $n){ $i += 1; ?>
						<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $n->titulo ?></td>
							<td>
								<?php echo $dias[date('N', strtotime($n->fecha))] ?>, <?php echo $n->dia ?>
								<?php
									foreach ($meses as $k => $m) {
										if( ($k+1) == $n->mes ){
											echo $m.' '.$n->ano;
										}
									}
								?>
							</td>
							<td class="center">
								<a class='' href="<?php echo base_url() ?>noticias/envio_noticias/<?php echo $n->id ?>" title="Visualizar y enviar noticias a correos electronicos"><i style="color:<?php if($n->estado_envio == 1) echo "green"; else echo "red"; ?>" class="fa fa-envelope-o"></i></a>
								<!--<a class='' href="<?php echo base_url() ?>noticias/envio_noticias/<?php echo $n->id ?>" title="Ver mas detalles de la noticia"><i class="fa fa-search"></i></a>-->
								<a class='eliminar' href="<?php echo base_url() ?>noticias/eliminar_noticia/<?php echo $n->id ?>" title="Eliminar noticia"><i class="fa fa-trash-o"></i></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>