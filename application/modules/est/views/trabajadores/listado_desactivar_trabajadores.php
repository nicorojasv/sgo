<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores a Desactivar</h4>
	</div>
	<div class="panel-body">
  		<form action="<?php echo base_url() ?>est/trabajadores/desactivar_trabajadores" method='post'>
			<table id="example1">
				<thead>
					<tr>
						<th style="width:1%">#</th>
						<th style="width:5%">Rut</th>
						<th style="width:8%">Nombres y Apellidos</th>
						<th style="width:6%">Telefono</th>
						<th style="width:5%">Fecha<br>Nacim.</th>
						<th style="width:5%">Ciudad</th>
						<th style="width:5%">Especialidad</th>
						<th style="width:5%" class="uk-date-html">Masso</th>
						<th style="width:5%" class="uk-date-html">Examen Preo</th>
						<th style="width:5%" class="uk-date-html">Examen<br>Psic.</th>
						<th style="width:5%">Desactivar</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row->rut_usuario ?></td>
						<td><?php echo $row->nombres." ". $row->paterno." ". $row->materno ?></td>
						<td><?php echo $row->fono ?></td>
						<td><?php echo $row->fecha_nac ?></td>
						<td><?php echo $row->ciudad ?></td>
						<td><?php echo $row->especilidad1."<br>".$row->especilidad2 ?></td>
						<td style="text-align:center">
							<?php if($row->masso != 0){ ?>
								<span class='badge' style='background-color:<?php echo $row->color_masso ?>'><?php echo $row->masso ?></span><br>
							<?php } ?>
						</td>
						<td style="text-align:center">
							<?php if($row->examen_pre != 0){ ?>
								<span class='badge' style='background-color:<?php echo $row->color_preo ?>'><?php echo $row->examen_pre ?></span><br>
							<?php } ?>
						</td>
						<td style="text-align:center">
							<?php if($row->examen_psic != 0){ ?>
								<span class='badge' style='background-color:<?php echo $row->color_psic ?>'><?php echo $row->examen_psic ?></span><br>
							<?php } ?>
						</td>
						<td style="text-align:center">
							<input type="checkbox" name="check_estado[<?php echo $i ?>]" id="check_estado[<?php echo $i ?>]" value="<?php echo $row->id_usuario ?>">
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="row">
	  		    <div class="col-md-9"></div>
	      		<div class="col-md-3">
	      			<button class="btn btn-green btn-block" type="submit" name="enviar" value="enviar" title="Enviar solicitudes para revision de examenes de los trabajadores">
						Desactivar Trabajadores
					</button>
	      		</div>
	    	</div>
	    </form>
	</div>
</div>