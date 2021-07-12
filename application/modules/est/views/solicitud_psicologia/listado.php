<script src="<?php echo base_url() ?>extras/js/administracion/areas.js" type="text/javascript"></script>
<div class="panel panel-white">
	<div class="panel-heading">
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-9"></div>
			<div class="col-md-2">
				<input type="button" title="Agregar Horario" value="Agregar Solicitud" name ="Agregar" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar">&nbsp;
			</div>
		</div>
		<br>
		<?php if($listado){ ?>
		<table id="tblPsicologo">
			<thead>
				<th>Fecha Creación</th>
				<th>Rut</th>
				<th>Nombre Evaluado</th>
				<th>Fono</th>
				<th>Residencia</th>
				<th>Especialidad</th>
				<th>Tipo Cargo</th>
				<th>Lugar Trabajo</th>
				<th>Referido</th>
				<th>Fecha Ingreso</th>
				<th>Hal2</th>
				<th>Comentario</th>
				<th>Solicitado por</th>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach($listado as $l){
				?>
					<tr>
						<td><?php echo $l->fecha_creacion ?></td>
						<td><?php echo $l->rut; ?></td>
						<td><?php echo $l->nombre_evaluado; ?></td>
						<td><?php echo $l->fono; ?></td>
						<td><?php echo $l->residencia; ?></td>
						<td><?php echo $l->especialidad; ?></td>
						<td><?php echo $l->tipo_cargo; ?></td>
						<td><?php echo $l->lugar_trabajo; ?></td>
						<td><?php echo $l->referido; ?></td>
						<td><?php echo $l->fecha_ingreso; ?></td>
						<td><?php echo $l->hal; ?></td>
						<td><?php echo $l->comentario; ?></td>
						<td><?php echo $l->solicitado; ?></td>
						
					</tr>
				<?php
					$i++;
				}
				?>
			</tbody>
		</table>
		<?php } else{ ?>
		<p>Sin solicitudes</p>
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
				<h2 class="modal-title" id="myModalLabel">Ingrese nueva solicitud</h2>
				<span> Si desea ver calendario click <a href="https://calendar.google.com/calendar/embed?src=88b2975gn5f596b2jk51g2cv1o@group.calendar.google.com&ctz=America/Santiago&pli=1" target="blank">Aqui</a></span>
			</div>
			<form action="<?php echo base_url() ?>est/solicitud_psicologia/guardar_solicitud" method='post'>
			<div class="modal-body ">
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Rut</label>
			              <input class="form-control" v-model="rut" name="rut" id="rut" data-submit="crear_trabajador" type="text" maxlength="9" onkeypress="return soloRUT(event)" onblur="checkRutGenerico(this, false, 2)" onfocus="limpiaPuntoGuion(this,2)" onpaste="return false" ondrag="return false" required ondrop="return false" oncopy="return false" oncut="return false" autocomplete="off">
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Nombre Evaluado</label>
			              <input type="text" name="nombre_evaluado" class="form-control" id="nombre_evaluado" required>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Fono</label>
			              <input type="text" name="fono" maxlength="9" class="form-control" id="fono" required>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Residencia</label>
			              <input type="text" name="residencia" class="form-control" id="residencia" required>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Especialidad</label>
			              <input type="text" name="especialidad" class="form-control" id="especialidad" required>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">OP / Tec / Sup</label>
			              <select class="form-control" name="tipo_cargo" required>
			              	<option selected disabled value="">Seleccione</option>
			              	<option value="Op">OP</option>
			              	<option value="Tec">Tec</option>
			              	<option value="Sup">Sup</option>
			              </select>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Lugar de trabajo</label>
			              <input type="text" name="lugar_trabajo" class="form-control" id="lugar_trabajo" required>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Referido</label>
			              <select class="form-control" name="referido" required>
			              	<option selected disabled value="">Seleccione</option>
			              	<option value="si">Si</option>
			              	<option value="no">No</option>
			              </select>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Fecha de ingreso estimada</label>
			              <input type="text" name="fecha_ingreso" class="form-control" id="fecha_ingreso" required>
			          </div>
					</div>
					<div class="col-md-6">
						<div class="control-form">
			            <label class="control-label">Hal2</label>
			              <select class="form-control" name="hal" required>
			              	<option selected disabled value="">Seleccione</option>
			              	<option value="realizado">Realizado</option>
			              	<option value="prcitado">PR Citado</option>
			              	<option value="prcitar">PR Citar</option>
			              </select>
			          </div>
					</div>
					<div class="col-md-12">
				            <label class="control-label">Comentarios</label>
							<textarea class="form-control" name="comentario"></textarea>
					</div>
					<br><br><br><br>
			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary">Guardar</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
<?php 
if ($this->session->userdata('exito') == true) {
?>
 exito =true;
<?php 
$this->session->unset_userdata('exito');
}else{
?>
 exito =false;
<?php 
}
?>
</script>