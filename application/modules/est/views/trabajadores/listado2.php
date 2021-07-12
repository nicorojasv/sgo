<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores Activos</h4>
		<!--<h2 class="panel-title"><b>Trabajadores Ingresados</b><?php if($datos_req){ ?><span id="cont_add"> <?php echo $datos_req->agregados ?></span>/<?php echo $datos_req->cantidad; } ?></h2>-->
	</div>
	<div class="panel-body">
		<div class="row" >
			<div class="col-md-7">
				<font color="green"><b>Tecnicos</b></font><br>
				<font color="blue"><b>Supervisor</b></font> 
			</div>
			<div class="col-md-5">
				<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2 ){ ?>
					<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>usuarios/perfil/crear/3"> Agregar Trabajador </a>
				<?php } ?>
					<a data-style="slide-right" class="btn btn-green" id="exportar" href="#"> Exportar </a>
				<?php //if($permiso_examen_psicologico == 1){ ?>
					<a data-style="slide-right" class="btn btn-green add_psicologico" href="<?php echo base_url() ?>est/trabajadores/examen_psicologico" > Enviar Ex. Psicologico </a>
				<?php //} ?>
				<?php if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 10 or $this->session->userdata('id') == 16 or $this->session->userdata('id') == 39 or $this->session->userdata('id') == 81){ ?>
					<a data-style="slide-right" class="btn btn-green add_revision_examen" href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes" > Enviar Revisión Examenes </a>
				<?php } ?>
				<?php if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 10 or $this->session->userdata('id') == 102 or $this->session->userdata('id') == 39 or $this->session->userdata('id') == 81){ ?>
					<a data-style="slide-right" class="btn btn-green" href="<?php echo base_url() ?>est/trabajadores/listado_desactivar_trabajadores"> Desactivar Trabajadores </a>
				<?php } ?>
					<!--<a data-style="slide-right" class="btn btn-green" href="<?php echo base_url() ?>usuarios/home/actualizar" target="_blank">Refrescar Listado</a>-->
					
			</div>
		</div>
		<div id=qr></div>
		<br>
		<table id="sample_1">
			<thead>
				<tr role="row">
					<th style="width:1%">#</th>
					<th style="width:5%">Rut</th>
					<th style="width:8%">Nombres y Apellidos</th>
					<th style="width:6%">Telefono</th>
					<th style="width:5%">Ciudad</th>
					<th style="width:5%">Especialidad</th>
					<th style="width:5%">Nota<br>Conoc.</th>
					<th style="width:5%" class="uk-date-html">Masso</th>
					<th style="width:5%" class="uk-date-html">Examen Preo</th>
					<th style="width:5%" class="uk-date-html">Examen<br>Psic.</th>
					<th style="width:5%" class="uk-date-column">Fecha<br>Nacim.</th>
					<th style="width:5%">Documentos</th>
					<th style="width:5%">Herramientas</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<!-- Modal Baterias-->
<div class="modal fade" id="ModalBaterias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- MODAL -->
<div class="modal hide" id="modal_nuevo" role="dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3 id="myModalLabel">Asignación de Personal</h3>
    </div>
    <div class="modal-body">
    </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    	<button class="btn btn-primary" id="save_btn">Asignar</button>
  	</div>
</div>

<div class="modal fade" id="exportar_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Seleccionar Registros</h4>
      </div>
      <form method="post" action="<?php echo base_url() ?>est/trabajadores/exportar_excel">
      <div class="modal-body">
      	<h4>Seleccionar Elementos a Exportar</h4>
        <div class="checkbox">
			<label class="">
				<input type="checkbox" name="id" value="1" class="grey">
				ID
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="nb" value="1" class="grey">
				Nombres
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="rut" value="1" class="grey">
				Rut
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="fono" value="1" class="grey">
				Teléfono
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="email" value="1" class="grey">
				Email
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="fn" value="1" class="grey">
				Fecha de Nacimiento
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="dire" value="1" class="grey">
				Dirección
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="ciudad" value="1" class="grey">
				Ciudad
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="civil" value="1" class="grey">
				Estado Civil
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="esp" value="1" class="grey">
				Especialidad
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="afp" value="1" class="grey">
				AFP
			</label>
		</div>
		<div class="checkbox">
			<label class="">
				<input type="checkbox" name="salud" value="1" class="grey">
				Salud
			</label>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <input type="submit" class="btn btn-primary" value="Generar">
      </div>
  	</form>
    </div>
  </div>
</div>
