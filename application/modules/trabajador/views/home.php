<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-6">
				<h3 style="margin-left:25px"><b><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno, 'UTF-8')) ?></b></h3>
				<br>
				<div class="row">
					<div class="col-md-2">
						<img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="imagen de perfil" style="width:100px">
					</div>
					<div class="col-md-9">
						<p>Rut: <b><?php echo $usuario->rut_usuario; ?></b><br/>
						Profesión: <b><?php echo @ucwords(mb_strtolower($this->Profesiones_model->get($usuario->id_profesiones)->desc_profesiones, 'UTF-8')); ?></b><br/>
						<?php if(isset($usuario->id_especialidad_trabajador)){ ?>
						Especialidad: <b><?php echo @ucwords(mb_strtolower($this->Especialidadtrabajador_model->get($usuario->id_especialidad_trabajador)->desc_especialidad, 'UTF-8')); ?></b><br/>
						<?php } ?>
						<?php if(isset($usuario->id_especialidad_trabajador_2)){ ?>
						Especialidad 2: <b><?php echo @ucwords(mb_strtolower($this->Especialidadtrabajador_model->get($usuario->id_especialidad_trabajador_2)->desc_especialidad, 'UTF-8')); ?></b><br/>
						<?php } ?>
						<?php if(isset($usuario->id_regiones)){ ?>
						Región:  <b><?php echo ucwords(mb_strtolower($this->Region_model->get($usuario->id_regiones)->desc_regiones, 'UTF-8')); ?></b><br />
						<?php } ?>
						<?php if(isset($usuario->id_ciudades)){ ?>
						Ciudad:  <b><?php echo ucwords(mb_strtolower($this->Ciudad_model->get($usuario->id_ciudades)->desc_ciudades, 'UTF-8')); ?></b><br />
						<?php } ?>
						Dirección: <b><?php echo ucwords(mb_strtolower($usuario->direccion, 'UTF-8')); ?>
						<?php if(isset($usuario->id_provincias)){ ?>
						<?php echo ", "; echo ucwords(mb_strtolower($this->Provincia_model->get($usuario->id_provincias)->desc_provincias, 'UTF-8')); ?>
						<?php } ?></b><br>
						<?php foreach ($evaluaciones as $e){
							echo ucwords(mb_strtolower( $e->nombre , 'UTF-8')) .': ' ;
							$fv = explode('-', $e->fecha_v);
							echo '<b>'. $fv[2].'-'.$fv[1].'-'.$fv[0] .'</b><br/>';
						} ?>
						<br />
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<p>Ultima actualización de su perfil:
				<?php if($usuario->fecha_actualizacion == "0000-00-00") $actualizacion = "No ha actualizado su perfil";
					else{ $act = explode("-",$usuario->fecha_actualizacion ); 
					$actualizacion = $act[2]."-".$act[1]."-".$act[0]; 
					} ?>
				<b><?php echo $actualizacion; ?></b>
				¿Desea actualizarlo? <a href="<?php echo base_url() ?>trabajador/perfil/editar">si</a> / <a href="javascript:;">no</a></p>
				<br>
				<h4><a style="color:inherit;" href="<?php echo base_url() ?>trabajador/ofertas"><b>Ofertas de Trabajo</b></a></h4>
				<br>
				<?php if(count($ofertas) > 0){ ?>
				<table id="inbox-table">
					<tbody>
						<?php foreach($ofertas as $o){ ?>
						<tr>
							<td class="td_message">
								<p class="subject">
									<a href="<?php echo base_url() ?>trabajador/ofertas/detalle/<?php echo urlencode(base64_encode($o->oferta_id)) ?>"><b><?php echo ucwords(mb_strtolower($o->titulo , 'UTF-8')) ?></b></a>
								</p>
								<p style="width:380px; word-wrap: break-word;">
									<?php echo substr(strip_tags($o->desc_oferta), 0, 64); ?>...<br/>
									<?php if( $o->activo == 0 ){ echo "<span style='color:green;font-weight:bold;'>Vigente</span>";} 
										else{ echo "<span style='color:red;font-weight:bold;'>No Vigente</span>"; } ?>
									<a href="<?php echo base_url() ?>trabajador/ofertas/detalle/<?php echo urlencode(base64_encode($o->oferta_id)) ?>">Leer todo...</a>
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
		<div class="row">
			<div class="col-md-4">
				<h4><b>Últimas Noticias</b></h4>
				<?php if(count($noticias) > 0){ ?>
				<table id="inbox-table">
					<tbody>
						<?php foreach($noticias as $n){ ?>
						<tr>
							<td class="td_message">
							<p class="subject">
								<a href="<?php echo base_url() ?>trabajador/noticias/detalle/<?php echo urlencode(base64_encode($n->noticia_id)) ?>"><?php echo ucwords(mb_strtolower($n->titulo , 'UTF-8')) ?></a>
							</p>
							<p style="width:380px; word-wrap: break-word;">
								<?php echo substr(strip_tags($n->desc_noticia), 0, 64); ?>...<br/>
								<a href="<?php echo base_url() ?>trabajador/noticias/detalle/<?php echo urlencode(base64_encode($n->noticia_id)) ?>">Leer todo...</a>
							</p>
							</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } else{ ?>
				<p>No Existen Noticias Actualmente...</p>
				<?php  } ?>
			</div>
			<div class="col-md-4">
				<h4><b>Capacitación</b></h4>
				<?php if( count($capacitacion) > 0){ ?>
				<table id="inbox-table">
					<tbody>
						<?php foreach($capacitacion as $c){ ?>
						<tr>
							<td class="td_message">
							<p class="subject">
								<a href="<?php echo base_url() ?>trabajador/capacitaciones/detalle/<?php echo urlencode(base64_encode($c->noticia_id)) ?>"><?php echo ucwords(mb_strtolower($c->titulo , 'UTF-8')) ?></a>
							</p>
							<p style="width:380px; word-wrap: break-word;">
								<?php echo substr(strip_tags($c->desc_noticia), 0, 64); ?>...<br/>
								<a href="<?php echo base_url() ?>trabajador/capacitaciones/detalle/<?php echo urlencode(base64_encode($c->noticia_id)) ?>">Leer todo...</a>
							</p>
							</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } else{ ?>
				<p>No Existen Anuncios de Capacitación Actualmente...</p>
				<?php  } ?>
			</div>
			<div class="col-md-4">
				<h4><b>Eventos</b></h4>
				<?php //if( count($requerimientos) > 0){ ?>
				<!--<table id="inbox-table">
					<tbody>
						<?php foreach($requerimientos as $r){ ?>
						<tr>
							<td class="td_message">
							<p class="subject">
								<a href="<?php echo base_url() ?>trabajador/publicaciones/detalle/<?php echo urlencode(encode_to_url($this->encrypt->encode($r->id))) ?>/<?php echo urlencode(encode_to_url($this->encrypt->encode($r->id_area))) ?>"><?php echo ucwords(mb_strtolower($r->titulo , 'UTF-8')) ?></a>
							</p>
							<p style="width:380px; word-wrap: break-word;">
								<?php echo substr(strip_tags($r->texto), 0, 64); ?>...<br>
								<a href="<?php echo base_url() ?>trabajador/publicaciones/detalle/<?php echo urlencode(encode_to_url($this->encrypt->encode($r->id))) ?>/<?php echo urlencode(encode_to_url($this->encrypt->encode($r->id_area))) ?>">Leer todo...</a>
							</p>
							</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>-->
				<?php //} else{ ?>
				<p>No Existen Eventos Actualmente...</p>
				<?php  //} ?>
			</div>
		</div>
		<br><br>
	</div>
</div>