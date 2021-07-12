<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title"><b>TRABAJADORES INGRESADOS</b><?php if($datos_req){ ?><span id="cont_add"> <?php echo $datos_req->agregados ?></span>/<?php echo $datos_req->cantidad; } ?></h2>
		<div class="panel-tools">
			<div class="dropdown">
				<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
					<i class="fa fa-cog"></i>
				</a>
				<ul class="dropdown-menu dropdown-light pull-right" role="menu">
					<li>
						<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
					</li>
					<li>
						<a class="panel-refresh" href="#">
							<i class="fa fa-refresh"></i> <span>Refresh</span>
						</a>
					</li>
					<li>
						<a class="panel-config" href="#panel-config" data-toggle="modal">
							<i class="fa fa-wrench"></i> <span>Configurations</span>
						</a>
					</li>
					<li>
						<a class="panel-expand" href="#">
							<i class="fa fa-expand"></i> <span>Fullscreen</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row" >
			<div class="col-md-9" >
				<?php if($datos_req){ ?>
					<h4><b>REQUERIMIENTO: </b> <?php echo $datos_req->nombre ?> <b>AREA: </b> <?php echo $datos_req->area ?> <b>CARGO: </b> <?php echo $datos_req->cargo ?></h4>
				<?php } ?>
			</div>
			<div class="col-md-3" >
				<?php if($datos_req){ ?>
					<a href="#" class="btn btn-blue btn-block add_req">Agregar a Requerimiento</a>
				<?php } else{ ?>
				<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>usuarios/perfil/crear/3">Agregar Trabajador</a>
				<a data-style="slide-right" class="btn btn-green" id="exportar" href="#">Exportar</a>
				<?php } ?>
			</div>
		</div>
		<table id="sample_1">
			<thead>
				<tr role="row">
					<th>#</th>
					<th>Rut</th>
					<th>Nombre</th>
					<th>Telefono</th>
					<th>Ciudad</th>
					<th>Especialidad</th>
					<th class="uk-date-html">Masso</th>
					<th class="uk-date-html">Examen Preo</th>
					<th class="uk-date-column">Fecha Nacimiento</th>
					<th>Documentos</th>
					<th>Herramienta</th>
					<th>Eval</th>
				</tr>
			</thead>
		</table>
	</div>
</div>











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