<h4 class="StepTitle"><?php echo $nombre; ?></h4>
<?php //echo $id_requerimiento ?>
<table id="datatable" class='table table-condensed' cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="font-size:11px">Especialidad</th>
			<?php foreach ($areas as $a) { ?>
				<th class="center" style="font-size:11px"><?php echo $this->Areas_model->r_get($a)->nombre; ?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($cargos as $c) { ?>
			<tr>
				<td style="font-size:11px"><?php echo $this->Cargos_model->r_get($c)->nombre; ?></td>
				<?php for( $i=0;$i<$cant_areas;$i++ ) { ?>
					<!--<td><input type="text" class="center" style="font-size:11px;font-weight:bold;" name="areas_cargos[]" data-val='<?php echo $c.'-'.$areas[$i].'-'.$id_requerimiento ?>' value='0' ></td>-->
						<td><input type="text" class="center" style="font-size:11px;font-weight:bold;" name="areas_cargos[]" data-val='<?php echo $c.'-'.$areas[$i] ?>' value='0' ></td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>