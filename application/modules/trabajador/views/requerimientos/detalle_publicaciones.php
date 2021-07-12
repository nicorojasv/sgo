<div id="support_answer" class="grid grid_16 append_1">
	<h1 class=""><?php echo ucwords(strtolower($publicacion->titulo)) ?></h1>
	<p class="updated">
		<?php $fecha = explode("-", $publicacion->fecha) ?>
		Creado: <?php echo $fecha[2].'&nbsp;'.$meses[$fecha[1]-1].'&nbsp;'.$fecha[0] ?>
	</p>
	<?php echo $publicacion->desc_publicacion ?>
	<br /><br />
	<?php if(count($adjuntos) > 0){ ?>
		<h4>Documentos adjuntos:</h4>
		<?php foreach($adjuntos as $a){ ?>
			<a target="_blank" href="<?php echo base_url().$a->url ?>"><?php echo $a->nombre ?></a><br/>
		<?php } ?>
	<?php } ?>
	<div></div>
</div>
<div class="grid grid_7">
	<a href="javascript:history.back()" id="question_button" class="btn primary xlarge block">Noticias</a>
	<br>
	<div class="box">
		<h3>Ultimas noticias</h3>
		<?php if( count($publicaciones_limite) > 0 ){ ?>
		<ul>
			<?php foreach($publicaciones_limite as $nt){ ?>
			<li>
				<a href="javascript:;"><?php echo ucwords(mb_strtolower($nt->titulo, 'UTF-8')); ?></a>
			</li>
			<?php } ?>
		</ul>
		<?php } else{ ?>
		<p>No existen noticias ingresadas.</p>
		<?php } ?>
	</div>
	<!-- .box -->
</div>