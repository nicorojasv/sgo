<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores</h4>
	</div>
	<div class="panel-body">
		<div class="row" >
			<div class="col-md-9">
			</div>
			<div class="col-md-3">
				<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>logistica_servicios/trabajadores/crear" target="_blank"> Agregar Trabajador </a>
				<br><br>
			</div>
		</div>
		<table id="example1">
			<thead>
				<tr>
					<th style="width:1%">#</th>
					<th>Rut</th>
					<th>Nombres y Apellidos</th>
					<th>Telefono</th>
					<th>Fecha<br>Nacim.</th>
					<th>Direccion</th>
					<th>Ciudad</th>
					<th>Salud</th>
					<th>Afp</th>
					<th style="width:5%">Herram.</th>
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
					<td><?php echo $row->direccion ?></td>
					<td><?php echo $row->ciudad ?></td>
					<td><?php echo $row->salud ?></td>
					<td><?php echo $row->afp ?></td>
					<td>
						<a title="Editar Trabajador" href="<?php echo base_url() ?>logistica_servicios/trabajadores/detalle/<?php echo $row->id_usuario ?>" target="_blank" ><i class="fa fa-pencil fa-fw"></i></a>
						<!--
						<a title="Eliminar Trabajador" class="eliminar" href="<?php echo base_url() ?>logistica_servicios/trabajadores/eliminar_trabajador/<?php echo $row->id_usuario ?>"><i class="fa fa-trash-o"></i></a>
						-->
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>