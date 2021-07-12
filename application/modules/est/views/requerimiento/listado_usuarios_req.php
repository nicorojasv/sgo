<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title" style="text-align:center"><b>Trabajadores Ingresados: </b><?php if($datos_req){ ?><span id="cont_adda"> <?php echo $datos_req->agregados ?></span>/<?php echo $datos_req->cantidad; } ?></h2>
		<?php 
					if (!isset($desabilitar)) {
				?>
		<h2 class="panel-title" style="text-align:center" id="log"></h2>
	<?php } ?>
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
  		<form action="<?php echo base_url() ?>est/requerimiento/agregar_usuarios_requerimiento" role="form" id="form" method='post' autocomplete="off">
		<div class="row" >
			<div class="col-md-1"></div>
			<div class="col-md-7" >
				<?php if($datos_req){ ?>
					<h4><b>Requerimiento: </b> <?php echo $datos_req->nombre ?><br> <b>Area: </b> <?php echo $datos_req->area ?> <br> <b>Cargo: </b> <?php echo $datos_req->cargo ?></h4>
				<?php } ?>
			</div>
			<div class="col-md-3" >
				<?php 
					if (isset($desabilitar)) {
				?>
					<a href="<?php echo  base_url()?>est/requerimiento/usuarios_requerimiento/<?php echo $id_area_cargo ?>" class="btn btn-blue btn-block add_req">Volver </a>
					<a href="<?php echo  base_url()?>est/requerimiento/usuarios_requerimientos_listado/<?php echo $id_area_cargo ?>">Cargar Version Anterior</a>
				<?php
					}else{
				?>
				<input type="submit" class="btn btn-blue btn-block add_req" value="Agregar a Requerimiento">
				<?php } ?>
			</div>
			<div class="col-md-1"></div>
		</div><br>
		<?php if( count($lista_aux) > 0){ ?>
			<div class="row">
	  		    <div class="col-md-1"></div>
	      		<div class="col-md-10">
	      			<input type="hidden" id="id_area_cargo" name="id_area_cargo" value="<?php echo $id_area_cargo ?>">
					<table id="example1">
						<thead>
							<tr>
								<th>Agregar</th>
								<th>Rut</th>
								<th>Nombre</th>
								<th>Apellido Paterno</th>
								<th>Apellido Materno</th>
								<th>Especialidad</th>
								<th>Estado</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($lista_aux as $r){ ?>
							<tr class="odd gradeX">
								<td><input type='checkbox' name='check_usuario[]' value='<?php echo $r->id_usuario ?>'></td>
			                    <!--<td><?php //echo ($r->estado_usu_req)?"<input type='checkbox' name='check_usuario[]' value='' disabled>":"<input type='checkbox' name='check_usuario[]' value='".$r->id_usuario."'>" ?></td>-->
			                    <!--<td><?php //echo ($r->estado_usu_req)?"<input type='checkbox' name='check_usuario[]' value='' disabled>":"<input type='checkbox' name='check_usuario[]' value='".$r->id_usuario."'>" ?></td>-->
								<td><?php echo $r->rut_usuario ?></td>
								<td><?php echo $r->nombre ?></td>
								<td><?php echo $r->ap_paterno ?></td>
								<td><?php echo $r->ap_materno ?></td>
								<td><?php echo $r->especialidad ?> <?php if(!$r->especialidad2){}else echo " / ".$r->especialidad2 ?></td>
								<td style="text-align:left">
									<?php
										if($r->anotaciones == 0) $anotacion = base_url().'extras/images/circle_green_16_ns.png';
										elseif($r->anotaciones == 1) $anotacion = base_url().'extras/images/circle_yellow_16_ns.png';
										elseif($r->anotaciones == 2) $anotacion = base_url().'extras/images/circle_red-yellow_16.png';
										elseif($r->anotaciones >= 3) $anotacion = base_url().'extras/images/circle_red_16_ns.png';
									?>
									<img src="<?php echo $anotacion ?>">
									<?php echo ($r->estado_usu_req)?"<i style='color:green' class='fa fa-flag' title='".$r->nombre_requerimiento."'></i>":""; ?>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
	    	</div>
	    </form>
		<?php }else{ ?>
		<p>
	<style type="text/css">
		input .aa {
			display: block !important; 
			padding: 0 !important; 
			margin: 0 !important; 
			border: 0 !important; 
			width: 100% !important; 
			border-radius: 0 !important; 
			line-height: 1 !important;
		}
	
	</style>	
<input type="hidden" id="id_area_cargo" name="id_area_cargo" value="<?php echo $id_area_cargo ?>">
	<form accept-charset="utf-8" method="POST">
		</form>
		<table class="table table-bordered table-condensed">
			<thead>
				<tr>
					<tr>
						
						<th>
							  <div class="input-group">
							    <span class="input-group-addon"><i class="fa fa-search"></i></span>
							    <input type="text" class="form-control aa" name="busqueda" id="busqueda"  autocomplete="off" onKeyUp="buscar();" placeholder="RUT" />
							  </div>
						</th>
						<th>
							<div class="input-group">
							    <span class="input-group-addon"><i class="fa fa-search"></i></span>
							    <input type="text" class="form-control aa" name="searchNombre" id="searchNombre"  autocomplete="off" onKeyUp="buscarNombre();" placeholder="Nombres"/>
							 </div>
						</th>
						<th>
							<div class="input-group">
							    <span class="input-group-addon"><i class="fa fa-search"></i></span>
							    <input type="text" class="form-control aa" name="searchApellido" id="searchApellido"  autocomplete="off" onKeyUp="buscarApellido();" placeholder="Apellido Paterno"/>
							</div>
						</th>
						<th> Apellido Materno</th>
						<th>Especialidad</th>
						<th>Estado</th>
					</tr>
					
				</tr>
			</thead>
			<tbody id="resultadoBusqueda">
				
			</tbody>
		</table>
		</p>
		<?php } ?>
	</div>
</div>

