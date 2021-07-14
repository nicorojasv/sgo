<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Lista de Requerimientos</h4>
	</div>
	<div class="panel-body">
		<div class="col-md-5">
			          <div class="col-md-8" align="left">
              <label for="datepickerMarinaRequerimientos">Mes A Consultar: </label>
              <input name="datepicker" type="text" id="datepickerMarinaRequerimientos" style="border: 1px solid #ccc;" class="datepicker" value="<?php if(isset($mes)) echo $mes ?>" size="10" readonly="true" title="Fecha a Gestionar Asistencia"><br>
              <input style="cursor: pointer;"  type="radio" id="historico" name="historico" value="historico"<?php if($mes == 'historico')echo "checked" ?>  onclick="historicoRequerimiento()">
              <label for="historico" style="cursor: pointer;" >Historico</label>
          </div>
			
		</div>
		<div class="col-md-5">
		</div>
		<div class="col-md-2">
			<a href="<?php echo  base_url() ?>wood/requerimientos/agregar" class="btn btn-blue btn-block" target="_blank">Agregar</a>
		</div>
		<br><br><br>
		<?php if( count($listado) > 0){ ?>
  		<form action="<?php echo base_url() ?>wood/requerimientos/cambiar_estados_requerimientos" method='post'>
			<table id="example1">
				<thead>
					<tr>
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
						<td><?php echo $r->nombre ?></td>
						<td><?php echo $r->f_solicitud; ?></td>
						<td><?php echo $r->empresa ?></td>
						<td><?php echo $r->planta ?></td>
						<td><?php if($r->regimen == "NL") echo "Normal"; elseif($r->regimen == "CTG") echo "Contingencia"; elseif($r->regimen == "URG") echo "Urgencia"; ?></td>
						<td><?php echo $r->f_inicio; ?></td>
						<td><?php echo $r->f_fin; ?></td>
						<td><?php echo $r->causal; ?></td>
						<td><?php echo $r->motivo; ?></td>
						<td><?php echo $r->comentario; ?></td>
						<td><?php echo $r->dotacion; ?></td>
						<td style="text-align:center">
		                    <input type="hidden" name="requerimientos[]" value="<?php echo $r->id ?>">
		                    <input type="checkbox" name="check_estado[]" value="<?php echo $r->id ?>" <?php echo ($r->estado)?"checked='checked'":""; ?> > <?php echo ($r->estado)?"<span class='badge' style='background-color:#3E9610'>A</span>":"<span class='badge' style='background-color:#DAAA08'>I</span>"; ?>
		                </td>
						<td style="width:47px; text-align:center">
							<a title="Asignar Areas-Cargos al Requerimiento" href="<?php echo base_url() ?>wood/requerimientos/asignacion/<?php echo $r->id ?>"><i class="fa fa-cogs" aria-hidden="true"></i></a>
							<a title="Editar datos Requerimiento" data-target="#ModalEditar" data-toggle="modal" href="<?php echo base_url() ?>wood/requerimientos/editar_requerimiento/<?php echo $r->id ?>"><i class="fa fa-pencil fa-fw"></i></a>
							<!--
							<a title="Eliminar Requerimiento" class="eliminar" href="<?php echo base_url() ?>wood/requerimientos/eliminar/<?php echo $r->id ?>"><i class="fa fa-trash-o"></i></a>

							-->
							
							<a href="<?php echo base_url() ?>wood/requerimientos/descargar_puesta_disposicion/<?php echo $r->id ?>"><i class="fa fa-download" aria-hidden="true"></i></a>
						
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="row">
	  		    <div class="col-md-9"></div>
	      		<div class="col-md-3">
				<button class="btn btn-yellow btn-block" type="submit" name="enviar" value="enviar" title="Guardar y/o Actualizar estado Activo/Inactivo de los Requerimientos">
					Guardar y Procesar Estados
				</button>	
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