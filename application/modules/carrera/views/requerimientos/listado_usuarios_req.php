<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<div class="panel panel-white">
	<div class="panel-heading">
		<h2 class="panel-title" style="text-align:center"><b>Trabajadores Ingresados</b><?php if($datos_req){ ?><span id="cont_add"> <?php echo $datos_req->agregados ?></span>/<?php echo $datos_req->cantidad; } ?></h2>
		<h2 class="panel-title" style="text-align:center" id="log"></h2>
	</div>
	<div class="panel-body">
  		<form action="<?php echo base_url() ?>carrera/requerimientos/agregar_usuarios_requerimiento" role="form" id="form" method='post' autocomplete="off">
		<div class="row" >
			<div class="col-md-1"></div>
			<div class="col-md-7" >
				<?php if($datos_req){ ?>
					<h4><b>Requerimiento: </b> <?php echo $datos_req->nombre ?> <b>Area: </b> <?php echo $datos_req->area ?> <b>Cargo: </b> <?php echo $datos_req->cargo ?></h4>
				<?php } ?>
			</div>
			<div class="col-md-3" >
				<input type="submit" class="btn btn-blue btn-block add_req" value="Agregar a Requerimiento">
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
								<th>Nombre </th>
								<th>Especialidad</th>
								<th>observaciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($lista_aux as $r){ ?>
							<tr class="odd gradeX">
								<td><input type='checkbox' name='check_usuario[]' value='<?php echo $r->id_usuario ?>'></td>
			                    <td><?php echo $r->rut_usuario ?></td>
								<td><?php echo $r->nombre." ".$r->ap_paterno." ".$r->ap_materno ?></td>
								<td><?php echo $r->especialidad ?></td>
								<td><?php echo $r->observacion ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
	    	</div>
	    </form>
		<?php }else{ ?>
		<p>No existen trabajadores.</p>
		<?php } ?>
	</div>
</div>