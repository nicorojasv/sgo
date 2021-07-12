<div class="col-md-6 col-md-offset-2">
	<h3>Listado de Documentos de <b><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></b></h3>
	<table class='table'>
		<thead>
			<th class="center">Archivos Requirimientos</th>
			<th class="center">Estado</th>
			<th class="center">#</th>
		</thead>
		<tbody>
			<?php foreach ($archivos as $a) { ?>
				<tr>
					<td><?php echo $a->archivo ?></td>
					<td class="center">
						<?php if( $a->datos ){ ?>
							<?php foreach($a->datos as $ar){ ?>
								<a href="<?php echo base_url().$ar->url ?>" style="color:green" target="_blank"><?php echo $ar->nombre ?></a>
								<br/>
							<?php } ?>
						<?php } else { ?>
						<a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<table class='table'>
		<thead>
			<th class="center">Archivos Generales</th>
			<th class="center">Estado</th>
		</thead>
		<tbody>
			<tr>
				<td>EXAMEN PREOCUPACIONAL</td>
				<td class="center">
					<?php if(!empty($preocupacional)){ ?>
					<a target="_blank" style="color:green" href="<?php echo base_url().$preocupacional->url ?>"><i class="fa fa-thumbs-up"></i></a>
					<?php } else{ ?>
					<a target="_blank" style="color:red" href="#"><i class="fa fa-thumbs-down"></i></a>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>EXAMEN MASSO</td>
				<td class="center">
					<?php if(!empty($masso)){ ?>
					<a target="_blank" style="color:green" href="<?php echo base_url().$masso->url ?>"><i class="fa fa-thumbs-up"></i></a>
					<?php } else{ ?>
					<a target="_blank" style="color:red" href="#"><i class="fa fa-thumbs-down"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php foreach ($archivos_trab as $a) { ?>
				<tr>
					<td><?php echo $a->nombre ?></td>
					<td class="center">
						<?php if( $a->archivo_trabaj ){ ?>
							<a href="<?php echo base_url().$a->archivo_trabaj ?>" target="_blank" style="color:green" ><?php echo $a->nombre_archivo_trabaj ?></a><br/>
						<?php } else { ?>
						<a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>