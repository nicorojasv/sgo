<div class="col-md-6 col-md-offset-2">
	<h3>Listado de Documentos de <b><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></b></h3>
	<table class='table'>
		<thead>
			<th class="center">Archivos Requirimientos</th>
			<th class="center">Estado</th>
			<th class="center">#</th>
		</thead>
		<tbody>
			<?php foreach ($archivos as $a) { ?>
				<tr>
					<td><?php echo $a->archivo ?></td>
					<td class="center">
						<?php if( $a->datos ){ ?>
							<?php foreach($a->datos as $ar){ ?>
								<a href="<?php echo base_url().$ar->url ?>" style="color:green" target="_blank"><?php echo $ar->nombre ?></a>
								<a class="confirm" href="<?php echo base_url().'est/requerimiento/eliminar_documento_contractual/'.$ar->id ?>"><i class="fa fa-times"></i></a>
								<br/>
							<?php } ?>
						<?php } else { ?>
						<a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
						<?php } ?>
					</td>
					<td>
						<form method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>est/requerimiento/guardar_doc_contractual/<?php echo $a->usuario_id ?>/<?php echo $a->id ?>/<?php echo $asc_area ?>" >
							<?php
							if ($a->id == "1"  or $a->id == "2"){
							?>
							<?php foreach($a->datos as $ar){ ?>
    	                    	<a data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/modal_administrar_archivo_usu/<?php echo $ar->id ?>/<?php echo $a->id_requerimiento ?>" data-target="#ModalEditar"><input type="button" class="btn btn-xs btn-primary" value="Administrar"></a><br>
							<?php } ?>
							<?php
								}elseif($a->id == "13"){
							?>
							<?php foreach($a->datos as $ar){ ?>
    	                    	<a data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/modal_administrar_archivo_usu_renuncia_voluntaria/<?php echo $ar->id ?>/<?php echo $a->id_requerimiento ?>" data-target="#ModalEditar"><input type="button" class="btn btn-xs btn-primary" value="Administrar"></a><br>
							<?php } ?>
							<?php
								}else{
							?>
							<span data-provides="fileupload" class="fileupload fileupload-new">
								<span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i>
									<input type="file" name="documento" required>
								</span>
								<span class="fileupload-preview"></span>
								<a data-dismiss="fileupload" class="close fileupload-exists float-none" href="#">
									×
								</a>
							</span>
							<input type="submit" class="btn btn-xs btn-primary" value="Agregar">
							<?php
								}
							?>
						</form>
					</td>
					<?php
						if ($a->id == "1"  or $a->id == "2"){
					?>
					<td>
                        <a data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/modal_agregar_doc/<?php echo $a->usuario_id ?>/<?php echo $a->id ?>/<?php echo $asc_area ?>/<?php echo $a->id_requerimiento ?>" data-target="#ModalEditar"><input type="button" class="btn btn-xs btn-primary" value="Agregar"></a>
					</td>
					<?php }elseif($a->id == "13"){
					?>
					<td>
                        <a data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/modal_agregar_doc_renuncia_voluntaria/<?php echo $a->usuario_id ?>/<?php echo $a->id ?>/<?php echo $asc_area ?>/<?php echo $a->id_requerimiento ?>" data-target="#ModalEditar"><input type="button" class="btn btn-xs btn-primary" value="Agregar"></a>
					</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	<br>
	<table class='table'>
		<thead>
			<th class="center">Pensiones</th>
			<th class="center">Estado</th>
			<th class="center">#</th>
			<th class="center"><a data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/modal_nueva_pension/<?php echo $a->usuario_id ?>/<?php echo $asc_area ?>/<?php echo $a->id_requerimiento ?>" data-target="#ModalNuevaPension"><input type="button" class="btn btn-xs btn-primary" value="Nueva Pension"></a></th>
		</thead>
		<tbody>
			<?php
				if (!empty($datos_pension)){
					foreach ($datos_pension as $p1){
			?>
			<tr>
				<td><?php echo $p1->nombre_pension ?></td>
				<td class="center"><a target='_blank' style='color:green'><i class='fa fa-thumbs-up'></i></a></td>
				<td class="center">
                	<a data-toggle="modal" href="<?php echo base_url() ?>est/requerimiento/modal_admin_pension/<?php echo $p1->id_pension_req ?>/<?php echo $asc_area ?>/<?php echo $a->id_requerimiento ?>" data-target="#ModalAdminPension"><input type="button" class="btn btn-xs btn-primary" value="Administrar"></a>
				</td>
				<td></td>
			</tr>
			<?php
					}
				}else{
					echo "<tr><td colspan='4' class='center'>No existen pensiones registradas en nuestras base de datos para este usuario en esta area</td></tr>";
				}
			?>
		</tbody>
	</table>
	<br>
	<table class='table'>
		<thead>
			<th class="center">Archivos Generales</th>
			<th class="center">Estado</th>
		</thead>
		<tbody>
			<tr>
				<td>EXAMEN PREOCUPACIONAL</td>
				<td class="center">
					<?php if(!empty($preocupacional)){ ?>
					<a target="_blank" style="color:green" href="<?php echo base_url().$preocupacional->url ?>"><i class="fa fa-thumbs-up"></i></a>
					<?php } else{ ?>
					<a target="_blank" style="color:red" href="#"><i class="fa fa-thumbs-down"></i></a>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>EXAMEN MASSO</td>
				<td class="center">
					<?php if(!empty($masso)){ ?>
					<a target="_blank" style="color:green" href="<?php echo base_url().$masso->url ?>"><i class="fa fa-thumbs-up"></i></a>
					<?php } else{ ?>
					<a target="_blank" style="color:red" href="#"><i class="fa fa-thumbs-down"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php foreach ($archivos_trab as $a) { ?>
				<tr>
					<td><?php echo $a->nombre ?></td>
					<td class="center">
						<?php if( $a->archivo_trabaj ){ ?>
							<a href="<?php echo base_url().$a->archivo_trabaj ?>" target="_blank" style="color:green" ><?php echo $a->nombre_archivo_trabaj ?></a><br/>
						<?php } else { ?>
						<a href="#" style="color:red" ><i class="fa fa-thumbs-down"></i></a>
						<?php } ?>
					</td>
					<td>
						<form method="post" enctype="multipart/form-data" action="<?php echo base_url() ?>est/requerimiento/guardar_archivo_general/<?php //echo $a->usuario_id ?>/<?php //echo $a->id ?>/<?php //echo $asc_area ?>" >
							<input type="hidden" name="id_archivo" id="id_archivo" value="<?php echo $a->id_archivo_trabaj ?>">
							<input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $a->id_usuario ?>">
							<input type="hidden" name="id_requerimiento" id="id_requerimiento" value="<?php echo $a->id_requerimiento ?>">
							<span data-provides="fileupload" class="fileupload fileupload-new">
								<span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i>
									<input type="file" name="documento" required>
								</span>
								<span class="fileupload-preview"></span>
								<a data-dismiss="fileupload" class="close fileupload-exists float-none" href="#">×</a>
							</span>
							<input type="submit" class="btn btn-xs btn-primary" value="Agregar">
						</form>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>


<!-- Modal Agregar Doc. Contractuales-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Administrar Documento</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Administrar Pensiones-->
<div class="modal fade" id="ModalNuevaPension" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Registrar Nueva Pension</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Administrar Pensiones-->
<div class="modal fade" id="ModalAdminPension" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Administrar Pension</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->