<div class="panel panel-white" style="height: 800px;">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores a Gestionar Examen Psicologico</h4>
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

		<div class="row">
	  		<div class="col-md-4">
	  			<label>Estado Trabajadores:</label>
	  			<select onChange="estado_examenes" name="milista" id="milista">
	  				<option value="pendientes" <?php if($estado == "pendientes") echo "selected"; ?> >Pendientes</option>
	  				<option value="aprobados" <?php if($estado == "aprobados") echo "selected"; ?> >Aprobados</option>
	  				<option value="desaprobados" <?php if($estado == "desaprobados") echo "selected"; ?> >Desaprobados</option>
	  			</select>
	  			<input type="hidden" name="estado" id="estado" value="<?php echo $estado ?>">
	  		</div>
		</div>
		<br>
<div class="row">
<div class="col-md-6">
  <div class="col-lg-4">
    <div class="input-group">
       <span class="input-group-addon">
       	<i class="fa fa-search"></i>
       </span>
	   <input type="text" class="form-control aa" name="busqueda" id="busqueda"  autocomplete="off" onPaste="var e=this; setTimeout(function(){buscar();}, 4);"  onKeyUp="buscar();"  placeholder="RUT" />
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-4">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-search"></i></span>
		<input type="text" class="form-control aa" name="searchNombre" id="searchNombre"  autocomplete="off" onPaste="var e=this; setTimeout(function(){buscarNombre();}, 4);" onKeyUp="buscarNombre();" placeholder="Nombres"/>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-4">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-search"></i></span>
		 <input type="text" class="form-control aa" name="searchApellido" id="searchApellido"  autocomplete="off" onPaste="var e=this; setTimeout(function(){buscarApellido();}, 4);" onKeyUp="buscarApellido();" placeholder="Apellido Paterno"/>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</div><!-- /.row -->
		<div class="row">

	  		<div class="col-md-12">
				<table id="examplePsi">
					<thead>
						<tr>
							<th>Rut</th>
							<th>Nombres</th>
							<th>Fono</th>
							<th>Residencia</th>
							<th>Referido</th>
							<th>Lugar de Trabajo</th>
							<th>Solicitante</th>
							<th>Psicologo/a</th>
							<th>Cargo Anterior</th>
							<th>Cargo Postulacion</th>
							<th>Tecnico/Supervisor</th>
							<th>Sueldo Definido</th>
							<th>Resultado</th>
							<th>Fecha Solicitud EST</th>
							<th>Fecha P. Psicologica</th>
							<th>Fecha Vigencia</th>
							<th>Observacion</th>
							<th>Herramientas</th>
							
						</tr>
					</thead>
					<tbody id="resultadoBusqueda">
				
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>