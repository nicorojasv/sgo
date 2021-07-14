<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Horarios carrera</h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-9"></div>
			<div class="col-md-2">
				<input type="button" title="Agregar Horario" value="Agregar Nuevo Horario" name ="Agregar" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar">&nbsp;
			</div>
		</div>
		<br>
		<?php if(count($listado) > 0){ ?>
		<table id="example1">
			<thead>
				<th>#</th>
				<th>Titulo</th>
				<th>Descripción</th>
				<th></th>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach($listado as $l){
				?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $l->nombre_horario; ?></td>
						<td><?php echo $l->descripcion; ?></td>
						<td class="center">
							<a data-toggle="modal" href="<?php echo base_url() ?>carrera/horarios/modal_editar/<?php echo $l->id ?>" class="btn btn-xs btn-blue tooltips editar" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>
							<!--
							<a href="<?php echo base_url() ?>carrera/horarios/eliminar/<?php echo $l->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
							-->
						</td>
					</tr>
				<?php
					$i++;
				}
				?>
			</tbody>
		</table>
		<?php } else{ ?>
		<p>No existen horarios agregados o asociados a la busqueda</p>
		<?php } ?>
	</div>
</div>

<!-- Modal Editar Areas-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align:center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Editar Datos Horario</h4>
			</div>
			<div class="modal-body"></div>
		</div>
	</div>
</div>
<!-- End Modal -->

<!-- Modal Agregar Horario-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align:center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Horario</h2>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url() ?>carrera/horarios/guardar_nuevo_horario" method='post'>
					<div class="col-md-12">
						<div class="control-form">
							<label class="control-label" for="titulo">Titulo</label>
							<div class="controls">
								<input type='text' class="form-control" name="titulo" id="titulo" onkeypress='return valida_abecedario(event)' maxlength='100' required/>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="control-form">
							<label class="control-label" for="descripcion">Descripción</label>
							<div class="controls">
								<textarea class="form-control" name="descripcion" id="descripcion" rows="6" required></textarea>
							</div>
						</div>
					</div>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>