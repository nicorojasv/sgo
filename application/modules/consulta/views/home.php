<div class="span5">
<h2 style="margin-left:25px"><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno, 'UTF-8')) ?></h2>
</div>
<div class="span11">
	<div class="span5">
		<br />
		<div class="dato_escritorio imagen"><img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="imagen de perfil"></div>
		<div class="dato_escritorio foto">
			<p>Rut: <b><?php echo $usuario->rut_usuario; ?></b><br/>
			</p>
		</div>
	</div>
	<div class="span6">
		<h3>Ofertas de Trabajo</h3>
		<?php if(count($ofertas) > 0){ ?>
		<table id="inbox-table">
			<tbody>
				<?php foreach($ofertas as $o){ ?>
				<tr>
					<td class="td_message">
					<p class="subject">
						<a href="<?php echo base_url() ?>consulta/ofertas/detalle/<?php echo urlencode(base64_encode($o->oferta_id)) ?>"><?php echo ucwords(mb_strtolower($o->titulo , 'UTF-8')) ?></a>
					</p>
					<p style="width:380px; word-wrap: break-word;">
						<?php echo substr(strip_tags($o->desc_oferta), 0, 64); ?>...<br/>
						<?php if( $o->activo == 0 ){ echo "<span style='color:green;font-weight:bold;'>Vigente</span>";} 
							else{ echo "<span style='color:red;font-weight:bold;'>No Vigente</span>"; } ?>
						<a href="<?php echo base_url() ?>consulta/ofertas/detalle/<?php echo urlencode(base64_encode($o->oferta_id)) ?>">Leer todo...</a>
					</p>
					</td>
					<td>&nbsp;&nbsp;</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php }else{ ?>
		<p>No Existen Ofertas Actualmente.</p>
		<?php } ?>
	</div>
</div>
<div class="clear span11">
	<div class="span4">
		<h3>Últimas Noticias</h3>
		<?php if(count($noticias) > 0){ ?>
		<table id="inbox-table">
			<tbody>
				<?php foreach($noticias as $n){ ?>
				<tr>
					<td class="td_message">
					<p class="subject">
						<a href="<?php echo base_url() ?>consulta/noticias/detalle/<?php echo urlencode(base64_encode($n->noticia_id)) ?>"><?php echo ucwords(mb_strtolower($n->titulo , 'UTF-8')) ?></a>
					</p>
					<p style="width:380px; word-wrap: break-word;">
						<?php echo substr(strip_tags($n->desc_noticia), 0, 64); ?>...<br/>
						<a href="<?php echo base_url() ?>consulta/noticias/detalle/<?php echo urlencode(base64_encode($n->noticia_id)) ?>">Leer todo...</a>
					</p>
					</td>
					<td>&nbsp;&nbsp;</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } else{ ?>
		<p>No Existen Noticias Actualmente.</p>
		<?php  } ?>
	</div>
	<div class="span4">
		<h3>Capacitación</h3>
		<?php if( count($capacitacion) > 0){ ?>
		<table id="inbox-table">
			<tbody>
				<?php foreach($capacitacion as $c){ ?>
				<tr>
					<td class="td_message">
					<p class="subject">
						<a href="<?php echo base_url() ?>consulta/capacitaciones/detalle/<?php echo urlencode(base64_encode($c->noticia_id)) ?>"><?php echo ucwords(mb_strtolower($c->titulo , 'UTF-8')) ?></a>
					</p>
					<p style="width:380px; word-wrap: break-word;">
						<?php echo substr(strip_tags($c->desc_noticia), 0, 64); ?>...<br/>
						<a href="<?php echo base_url() ?>consulta/capacitaciones/detalle/<?php echo urlencode(base64_encode($c->noticia_id)) ?>">Leer todo...</a>
					</p>
					</td>
					<td>&nbsp;&nbsp;</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } else{ ?>
		<p>No Existen Anuncios de Capacitación Actualmente.</p>
		<?php  } ?>
	</div>
	<div class="span4">
		<h3>Eventos</h3>
		<p>No Existen Eventos Actualmente.</p>
	</div>
</div>