<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<h3>Noticias Laborales</h3>
				<?php if( count($listado_noticias) > 0 ){ ?>
				<table id="inbox-table">
					<tbody>
						<?php foreach($listado_noticias as $ln){ ?>
						<tr <?php if(!$ln->leido){ ?> class="unread" <?php } ?> >
							<td class="td_info"><a>Administrador</a>
							<br>
							<?php $fecha = explode("-", $ln->fecha); ?>
							<?php diferencia_fechas($ln->fecha,date("Y-m-d")); ?>
							</td>
							<td class="td_message" style="width: 100%;padding-left: 20px;padding-right: 20px;">
							<p class="subject">
								<a href="<?php echo base_url().$this->uri->segment(1) ?>/<?php echo $pag_lugar ?>/detalle/<?php echo $ln->id ?>"><?php echo $ln->titulo ?></a>
							</p>
							<p>
								<?php echo $ln->texto ?>
							</p>
							<div class="ver-mas"><a href="<?php echo base_url().$this->uri->segment(1) ?>/<?php echo $pag_lugar ?>/detalle/<?php echo $ln->id ?>">Leer todo...</a></div>
							</td>
							<td>&nbsp;&nbsp;</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php }else{ ?>
					<p>No existen anuncios actualmente.</p>
				<?php } ?>
			</div>
		</div><br><br><br>
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-5">
				<b>* Fechas de Referencia</b>
			</div>
		</div>
		<br><br>
	</div>
</div>