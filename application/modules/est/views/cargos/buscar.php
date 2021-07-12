<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Cargos ingresados</h4>
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
					<a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
				</li>
				<li>
					<a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
				</li>
				<li>
					<a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
				</li>										
			</ul>
			</div>
			<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-10" align="center"></div>
			<div class="col-md-2" align="center">
          		<input type="button" title="Agregar Cargo" value="Agregar" name ="Agregar" class="btn btn-blue" data-toggle="modal" data-target="#ModalAgregar">&nbsp;

  			</div>
		</div>
		<?php if(count($listado) > 0){ ?>
		<table class="table">
			<thead>
				<th>#</th>
				<th>Nombre</th>
				<th></th>
			</thead>
			<tbody>
				<?php
					$i = 1;
					foreach($listado as $l){
				?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo ucwords( mb_strtolower( $l->nombre, 'UTF-8' ) ) ?></td>
					<td class="center">
						<div class="visible-md visible-lg hidden-sm hidden-xs">
                        	<a data-toggle="modal" href="<?php echo base_url() ?>est/cargos/modal_editar_cargo/<?php echo $l->id ?>" class="btn btn-xs btn-blue tooltips editar" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>
			              	<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
								<a href="<?php echo base_url() ?>est/cargos/eliminar/<?php echo $l->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
							<?php } ?>
						</div>
					</td>
				</tr>
				<?php
				   	$i++;
				}
				?>
			</tbody>
		</table>
		<br />
		<br />
		<?php echo @$paginado ?>
		<?php } else{ ?>
			<p>No existen cargos agregados o asociados a la busqueda</p>
		<?php } ?>
	</div>
</div>

<!-- Modal Editar Cargo-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Cargo</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Agregar Cargo-->
<div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nuevo Cargo</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>est/cargos/guardar_cargo_nuevo" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-4"></div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Nombre Cargo</label>
              <div class="controls">
              	<input type='text' class="input-mini" name="nombre_cargo" id="nombre_cargo" onkeypress='return valida_abecedario(event)' maxlength='60' required/>
              </div>
            </div>
          </div><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>