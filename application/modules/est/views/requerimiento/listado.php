<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Lista de Requerimientos <?php echo $planta; ?></h4>
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
		<div class="col-md-3">
			Activos: <span class='badge' style='background-color:#3E9610'>A</span> Inactivos: <span class='badge' style='background-color:#DAAA08'>I</span>
		</div>
		<div class="col-md-4">
			<?php
				if( $this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2){
			?>
				Centro de costo:
				<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
				  	<option value="<?php echo base_url() ?>est/requerimiento/listado/todas/<?php echo $estado ?>" <?php if($id_planta == NULL or $id_planta == "todas") echo "selected"; ?> >Todas las plantas</option>
				  	<?php foreach ($empresa_planta as $key){ ?>
				  		<option value="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $key->id ?>/<?php echo $estado ?>" <?php if($id_planta == $key->id) echo "selected"; ?> ><?php echo $key->nombre ?></option>
				  	<?php } ?>
				</select>
			<?php } ?>
		</div>
		<div class="col-md-3">
			Estado:
			<select name="ordenar2" id="ordenar2" onChange="window.location.href=document.getElementById(this.id).value">
			  	<option value="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $id_planta ?>/todos" <?php if($estado == "todos") echo "selected"; ?> >Todos</option>
			  	<option value="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $id_planta ?>/activos" <?php if($estado == "activos") echo "selected"; ?> >Activos</option>
			  	<option value="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $id_planta ?>/inactivos" <?php if($estado == "inactivos") echo "selected"; ?> >Inactivos</option>
			</select>
		</div>
		<div class="col-md-2">
			<?php
				if( $this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2){
			?>
				<a href="<?php echo  base_url() ?>est/requerimiento/agregar" class="btn btn-blue btn-block">Agregar</a>
			<?php } ?>
		</div>
		<br><br><br>
		<?php if( count($listado) > 0){ ?>
  		<form action="<?php echo base_url() ?>est/requerimiento/cambiar_estados_requerimientos" role="form" id="form" method='post' autocomplete="off">
			<table id="example1">
				<thead>
					<tr>
						<th>id</th>
						<th>Nombre</th>
						<th>Solicitud</th>
						<th>Empresa</th>
						<th>Planta</th>
						<th>Regimen</th>
						<th>Inicio</th>
						<th>Fin</th>
						<th>Causal</th>
						<th>Motivo</th>
						<th>Comentarios</th>
						<th>Dotaci&oacute;n</th>
						<th style="text-align:center">Activo</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($listado as $r) { ?>
					<tr class="odd gradeX">
						<td><?php echo $r->id ?></td>
						<td><?php echo $r->nombre ?></td>
						<td><?php echo $r->f_solicitud; ?></td>
						<td><?php echo $r->empresa ?></td>
						<td><?php echo $r->planta ?></td>
						<td><?php echo $r->regimen ?></td>
						<td><?php echo $r->f_inicio; ?></td>
						<td><?php echo $r->f_fin; ?></td>
						<td><?php echo $r->causal; ?></td>
						<td><?php echo $r->motivo; ?></td>
						<td><?php echo $r->comentario; ?></td>
						<td><?php echo $r->dotacion; ?></td>
						<td style="text-align:center">
				            <?php if($this->session->userdata('tipo_usuario') == 1){ ?>
		                    	<input type="hidden" name="requerimientos[]" value="<?php echo $r->id ?>">
		                    	<input type="checkbox" name="check_estado[]" value="<?php echo $r->id ?>" <?php echo ($r->estado)?"checked='checked'":""; ?> > <?php echo ($r->estado)?"<span class='badge' style='background-color:#3E9610'>A</span>":"<span class='badge' style='background-color:#DAAA08'>I</span>"; ?>
							<?php
							 	}else{
							 ?>
		                    <?php echo ($r->estado)?"<span class='badge' style='background-color:#3E9610'>A</span>":"<span class='badge' style='background-color:#DAAA08'>I</span>"; ?>
		                    <?php } ?>
	                	</td>
						<td style="width:47px; text-align:center">
							<a title="Asignar Areas-Cargos al Requerimiento" href="<?php echo base_url() ?>est/requerimiento/asignacion/<?php echo $r->id ?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
							<a title="Editar datos Requerimiento" data-target="#ModalEditar" data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/editar_requerimiento/<?php echo $r->id ?>"><i class="fa fa-pencil fa-fw"></i></a>
							<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
								<a title="Eliminar Requerimiento" class="eliminar" href="<?php echo base_url() ?>est/requerimiento/eliminar/<?php echo $r->id ?>"><i class="fa fa-trash-o"></i></a>
							<?php } ?>
							
							<a href="<?php echo base_url() ?>est/requerimiento/descargar_puesta_disposicion/<?php echo $r->id ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
							<a title="Agregar Adendum" data-target="#ModalAdendum" data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/adendum/<?php echo $r->id ?>"><i class="fa fa-file-text-o"></i></a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="row">
	  		    <div class="col-md-10"></div>
	      		<div class="col-md-2">
				<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
				<button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo de los Requerimientos">
					Guardar Estados Requerimientos
				</button>	
				<?php } ?>
	      		</div>
	    	</div>
	    </form>
		<?php } else{ ?>
		<p>No existen nuevos requerimientos.</p>
		<?php } ?>
	</div>
</div>


<!-- Modal Editar Datos del Requerimiento-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal adendum -->
<div class="modal fade" id="ModalAdendum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->