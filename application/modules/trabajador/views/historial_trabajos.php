<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
			<div class="col-md-1" style="align:center">
				<img src="<?php echo base_url().$this->session->userdata('imagen_barra'); ?>" style="width:80px; height:80px">
			</div>
			<div class="col-md-6" style="align:center">
				<h3><b><?php echo ucwords(mb_strtolower($usuario->nombres.' '.$usuario->paterno.' '.$usuario->materno, 'UTF-8')) ?></b></h3>
				<h5><a>Trabajador</a></h5>
				<p class="contact_tags">
					<?php
						if($usuario->fecha_actualizacion == "0000-00-00"){
							$actualizacion = "No se ha actualizado el perfil";
						}else{
							 $act = explode("-",$usuario->fecha_actualizacion);
							$actualizacion = $act[2]."-".$act[1].'-'.$act[0];
						}
					?>
					<span>Ultima actualización: <?php echo $actualizacion ?></span>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<h3>Trabajos Asignados</h3>
				<table class="table">
					<thead>
						<tr>
							<th>Area</th>
							<th>Cargo</th>
							<th>Fecha Inicio*</th>
							<th>Fecha Termino*</th>
							<th>Motivo</th>
						</tr>
					</thead>
					<tbody>
						<?php if($trabajos){ ?>
						<?php foreach ($trabajos as $t) { ?>
							<tr class="odd gradeX">
								<td><?php echo $t->area; ?></td>
								<td><?php echo $t->cargo; ?></td>
								<td>
									<?php $fi = ($t->inicio)?explode('-',$t->inicio):false; ?>
									<?php echo $fi[2].'-'.$fi[1].'-'.$fi[0]; ?>
								</td>
								<td>
									<?php $ff = ($t->fin)?explode('-',$t->fin):false; ?>
									<?php echo $ff[2].'-'.$ff[1].'-'.$ff[0]; ?>
								</td>
								<td><?php echo $t->motivo; ?></td>
							</tr>
							<?php } ?>
						<?php }else{
							echo "<tr style='text-align:center'><td colspan='7'>No se encuentran registros de trabajos en nuestras base de datos</td></tr>";
						} ?>
					</tbody>
				</table>
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