<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-7">
				<h1 class=""><?php echo ucwords(strtolower($noticia->titulo)) ?></h1>
				<p class="updated">
					<?php $fecha = explode("-", $noticia->fecha) ?>
					Creado: <?php echo $fecha[2].'&nbsp;'.$meses[$fecha[1]-1].'&nbsp;'.$fecha[0] ?>
				</p>
				<?php echo $noticia->desc_noticia ?>
				<br /><br />
				<?php if(count($adjuntos) > 0){ ?>
					<h4>Documentos adjuntos:</h4>
					<?php foreach($adjuntos as $a){ ?>
						<a target="_blank" href="<?php echo base_url().$a->url ?>"><?php echo $a->nombre ?></a><br/>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="col-md-4">
				<a href="<?php echo base_url() ?>trabajador/noticias_laborales" id="question_button" class="btn primary xlarge block"><?php echo $pag_lugar ?></a>
				<br>
				<div class="box">
					<h3>Ultimas <?php echo $pag_lugar ?></h3>
					<?php if( count($noticia_limite) > 0 ){ ?>
					<ul>
						<?php foreach($noticia_limite as $nt){ ?>
						<li>
							<a href="<?php echo base_url() ?>trabajador/noticias_laborales/detalle/<?php echo urlencode(base64_encode($nt->noticia_id )) ?>"><?php echo ucwords(mb_strtolower($nt->titulo, 'UTF-8')); ?></a>
						</li>
						<?php } ?>
					</ul>
					<?php } else{ ?>
					<p>No existen noticias ingresadas.</p>
					<?php } ?>
				</div>

			</div>
		</div>
		<br><br><br>
	</div>
</div>