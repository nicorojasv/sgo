<?php
echo @$aviso;
?>
<?php if( count($listado_noticias) > 0 ){ ?>
<table id="inbox-table">
	<tbody>
		<?php foreach($listado_noticias as $ln){ ?>
		<tr>
			<td class="td_info"><a href="javascript:;">Administrador</a>
			<br>
			<?php $fecha1 = explode(" ", $ln->fecha); ?>
			<?php $fecha = explode("-", trim($fecha1[0])); ?>
			<?php /* CALCULO DE DIAS ATRAS */ ?>
			<?php diferencia_fechas($fecha1[0],date("Y-m-d")); ?>
			</td>
			<td class="td_message" style="width: 100%;padding-left: 20px;">
			<p class="subject">
				<a href="<?php echo base_url().$this->uri->segment(1) ?>/publicaciones/detalle/<?php echo $ln->idpr ?>/<?php echo $id_area ?>"><?php echo $ln->titulo ?></a>
			</p>
			<p>
				<?php echo $ln->texto ?>
			</p>
			<div class="ver-mas"><a href="<?php echo base_url().$this->uri->segment(1) ?>/publicaciones/detalle/<?php echo $ln->idpr ?>/<?php echo $id_area ?>">Leer todo...</a></div>
			</td>
			<td>&nbsp;&nbsp;</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php }else{ ?>
	<p>No existen anuncios actualmente.</p>
<?php } ?>