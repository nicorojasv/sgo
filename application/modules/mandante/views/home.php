<?php 
	echo @$avisos;
?>
<!--
<h2><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno, 'UTF-8')) ?></h2>
<div class="grid grid_12">
	<div class="dato_escritorio imagen"><img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="imagen de perfil"></div>
	<div class="dato_escritorio foto">
		<p>Codigo ingreso: <b><?php echo $usuario->codigo_ingreso; ?></b><br/>
		<?php if(!empty($usuario->direccion)){ ?>
		Dirección: <b><?php echo ucwords(mb_strtolower($usuario->direccion, 'UTF-8')); ?></b><br />
		<?php } ?>
		<?php if(!empty($usuario->cargo_mandante)){ ?>
		Cargo: <b><?php echo ucwords(mb_strtolower($usuario->cargo_mandante, 'UTF-8')); ?></b><br />
		<?php } ?>
		<?php if(!empty($usuario->email)){ ?>
		Email: <b><?php echo ucwords(mb_strtolower($usuario->email, 'UTF-8')); ?></b>
		<?php } ?>
		<br />
		</p>
	</div>
</div>
<!-- <div class="abs right grid_12"> </div> -->
<!--
<div class="grid grid_12">
	<div id="gallery_filter" class="box">
		<h3>Ultimos requerimientos</h3>
		<?php if( count($req) > 0){ ?>
			<table>
				<?php foreach($req as $r){ ?>
				<tr>
				<td style="width:335px;"><?php echo ucwords(mb_strtolower($r->nombre, 'UTF-8')) ?></td>
				<td><a class='dialog' href="<?php echo base_url() ?>mandante/requerimiento/estado_subreq/<?php echo $r->id?>"><?php echo $r->cantidad.'/'.$r->cantidad_ok; ?></a></td>
				</tr>
				<?php } ?>
			</table>
		<?php } ?>
	</div>
</div>
<div class="grid grid_24">
	<h3>Ultimos Anuncios</h3>
	<?php if(count($noticias) > 0){ ?>
	<table id="inbox-table">
		<tbody>
			<?php foreach($noticias as $n){ ?>
			<tr>
				<td class="td_message">
				<p class="subject">
					<a href="<?php echo base_url() ?>trabajador/noticias/detalle/<?php echo urlencode(base64_encode($n->id)) ?>"><?php echo ucwords(mb_strtolower($n->titulo , 'UTF-8')) ?></a>
				</p>
				<p>
					<?php echo word_limiter($n->desc_noticia, 22); ?>
				</p>
				<div class="ver-mas"><a href="<?php echo base_url() ?>trabajador/noticias/detalle/<?php echo urlencode(base64_encode($n->id)) ?>">Leer todo...</a></div>
				</td>
				<td>&nbsp;&nbsp;</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else{ ?>
	<p>No existen anuncios actualmente.</p>
	<?php  } ?>
</div>
-->
<div class="grid grid_12">
	<ul style='font-size:21px;margin-left:80px;'>
		<li><a style='color:#444444;' href="#">Regimen Normal - Caldera Recuperadora R1</a></li>
		<li><a style='color:#444444;' href="#">Regimen Normal - Pulpa L1</a></li>
		<li><a style='color:#444444;' href="<?php echo base_url() ?>mandante/planilla_pgp2">Regimen Normal - Pulpa L2</a></li>
		<li><a style='color:#444444;' href="<?php echo base_url() ?>mandante/planilla_pgp">Regimen PGP - Mayo 2015</a></li>
	</ul>
</div>