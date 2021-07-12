<div class="panel panel-white">
	<div class="panel-body">
		<div class="row">
	        <div class="col-md-8" align="rigth">
				<h5><b>Area - Cargo:</b> <?php echo ucwords(mb_strtolower($area,'UTF-8')) ?> - <?php echo ucwords(mb_strtolower($cargo->nombre,'UTF-8')) ?></h5>
			</div>
	        <div class="col-md-3"></div>
	        <div class="col-md-1" style="text-align:center">
				<a href="<?php echo base_url() ?>mandante/planilla_pgp/<?php echo $id_requerimiento ?>/<?php echo $id_planta ?>"><i class="fa fa-reply"><br><b>Volver a Detalle Requerimiento</b></i></a>
			</div>
	     </div>
		<?php if($personas){ ?>
			<table id="example1">
				<thead>
			        <th style="text-align:center;">Nombre</th>
					<th style="text-align:center;">Referido</th>
					<th style="text-align:center;">Cargo</th>
					<!--<th style="text-align:center;">Contacto</th>
					<th style="text-align:center;">Disponiblidad</th>-->
					<th style="text-align:center;">Examen Preocupacional</th>
					<th style="text-align:center;">MASSO</th>
					<th style="text-align:center;">Doc. Contractuales</th>
					<th style="text-align:center;">Status General</th>
					<th style="text-align:center;">Jefe de Area</th>
			        <!--<th style="text-align:center;">Comentario Integra</th>
			        <th style="text-align:center;">Recomienda?</th>
					<th style="text-align:center;">Comentarios</th>-->
				</thead>
				<tbody>
					<?php foreach ($personas as $p) { ?>
						<tr>
				            <td><b><a target='_blank' href='<?php echo base_url() ?>mandante/perfil2/<?php echo $p->id_usuario ?>'><?php echo $p->nombre ?></a><b/></td>
							<td style="text-align:center;"><b><?php echo $p->referido ?><b/></td>
							<td style="text-align:center;"><a href="<?php echo base_url() ?>mandante/perfil_cargo/<?php echo $cargo->id ?>" target="_blank"><?php echo $cargo->nombre ?></a></td>
							<!--<td style="text-align:center;"><?php //echo $p->contacto ?></td>
							<td style="text-align:center;"><?php //echo $p->disponibilidad ?></td>-->
							<td style="text-align:center;">
								<?php if($p->preocupacional == 'Si'){ ?>
								<a target="_blank" style="color:green;" href='<?php echo base_url().$p->preocupacional_url ?>'>
									<i class="fa fa-thumbs-up"></i>
								</a>
								<?php } else{ ?>
								<a target="_blank" style="color:red;" href='#'>
									<i class="fa fa-thumbs-down"></i>
								</a>
								<?php } ?>
							</td>
							<td style="text-align:center;">
								<?php if($p->masso == 'Si'){ ?>
								<a target="_blank" style="color:green;" href='<?php echo base_url().$p->masso_url ?>'>
									<i class="fa fa-thumbs-up"></i>
								</a>
								<?php } else{ ?>
								<a target="_blank" style="color:red;" href='#'>
									<i class="fa fa-thumbs-down"></i>
								</a>
								<?php } ?>
							</td>
							<td style="text-align:center;">
								<a class="sv-callback-list" data-usuario='<?php echo $p->id_usuario ?>' href="<?php echo base_url().'mandante/mandante/callback_view_documentos/'.$p->id_usuario ?>/<?php echo $p->id ?>" style="color:blue;">
									<i class="fa fa-book" ></i>
								</a>
							</td>
							<td style="text-align:center;"><b><?php echo $p->status ?></b></td>
							<td style="text-align:center;"><b><?php echo $p->jefe_area ?></b></td>
				            <!--<td style="text-align:center;">
				            	<?php //if($p->comentario){ ?>
				            		<a data-toggle="modal" href="<?php //echo base_url() ?>mandante/mandante/modal_comentario_integra /<?php //echo $p->id ?>" data-target="#myModal2">Ver Comentario</a>
				            	<?php //}else{ } ?>
				            </td>
							<td style="text-align:center;">si<input type='radio' name='r_<?php //echo $p->id ?>' checked /> no<input type='radio' name='r_<?php //echo $p->id ?>' /></td>
				            <td style="text-align:center;"><a href="<?php //echo base_url() ?>mandante/mandante/modal_comentario/<?php //echo $p->id ?>" data-toggle="modal" data-target="#myModal">Comentar</a></td>-->
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } else{ ?>
		<h5><b>No se han ingresado trabajadores</b></h5>
		<?php } ?>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Comentario</h2>
      </div>
      	<form action="" method="POST" class="guardar_modal" >
		    <div class="modal-body">

		    </div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        		<button type="submit" class="btn btn-primary">Guardar</button>
      		</div>
  		</form>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Comentario</h2>
      </div>
      <div class="modal-body">
        <form class="">
         <textarea rows="5" style="width: 515px;" READONLY></textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>