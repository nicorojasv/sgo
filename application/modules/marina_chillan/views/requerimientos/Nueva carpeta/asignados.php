<!-- OVERLAY CON EL INGRESO DE UN AREA -->
<div id="modal" style="z-index: 9999;">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Usuarios asignados</h3>
	</div>
	<div id="modal_content">
		<form name="asignado" method="post" action="<?php echo base_url() ?>administracion/requerimiento/form_requerimiento">
		<div style="width: 780px;">
			<p>
				Listado de usuarios asignados al requerimiento.
			</p>
			<table class="data display">
				<tbody>
					<?php $i=0; ?>
					<?php if( is_array($listado_asignados) && count($listado_asignados) > 0 ){ ?>
					<?php //print_r($reemplazos); ?>
					<?php foreach($listado_asignados as $la){ ?>
					<input type="hidden" name="trabajador_original[]" value="<?php echo $la->id ?>" />
					<?php $encontrado = false; $i=0; ?>
					<?php if(is_array($reemplazos)): ?>
						<?php foreach($reemplazos as $k => $v): ?>
							<?php if($reemplazos[$i]['usuario'] == $la->id): ?>
								<?php $encontrado = true; ?>
								<?php $nvo_usuario = $reemplazos[$i]['reemplazo']['usuario_r'] ?>
								<?php $nvo_motivo = $reemplazos[$i]['reemplazo']['motivo'] ?>
								<?php $nvo_obs = $reemplazos[$i]['reemplazo']['observacion'] ?>
							<?php endif; ?>
							<?php $i++; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if(!$encontrado): ?>
					<tr class="odd gradeX">
						<td>
							<?php echo $la->rut ?>
						</td>
						<td>
							<?php echo $la->nombres ?>
						</td>
						<td>
							<?php echo $la->paterno ?>
						</td>
						<td>
							<?php echo $la->materno ?>
						</td>
						<td><input type="text" name="f_inicio[]" class="i_fecha" style="width: 75px;text-align: center;" value="<?php if (!empty($la->fecha_inicio)) { $fini = explode('-',$la->fecha_inicio); echo $fini[2].'-'.$fini[1].'-'.$fini[0]; } else{ echo 'inicio'; } ?>" /></td>
						<td><input type="text" name="f_termino[]" class="i_fecha" style="width: 75px;text-align: center;" value="<?php if (!empty($la->fecha_termino)) { $fter = explode('-',$la->fecha_termino); echo $fter[2].'-'.$fter[1].'-'.$fter[0]; } else{ echo 'término'; } ?>" /></td>
						<td>
							<select name="origen[]" style="width: 90px;">
								<option value="">Origen...</option>
								<?php foreach($lista_origen as $lor){ ?>
									<option value="<?php echo $lor->id ?>" <?php if(!empty($la->origen)){ echo ($la->origen == $lor->id)?'SELECTED':''; } ?>><?php echo ucwords(mb_strtolower( $lor->nombre, 'UTF-8' )); ?></option>
								<?php } ?>
							</select>
						</td>
						<td><a class="quitar" rel="<?php echo $la->id ?>" href="#">Quitar</a></td>
						<td><a class="reemplazo" rel="<?php echo $la->id ?>" title="<?php echo $id_req ?>"  href="<?php echo base_url() ?>administracion/requerimiento/ajax_reemplazo/<?php echo $id_req ?>">Reemplazar</a></td>
					</tr>
					<?php else: ?>
					<?php $usuario_nuevo = $this->Usuarios_model->get($nvo_usuario); ?>
					<tr class="odd gradeX">
						<td>
							<?php echo $usuario_nuevo->rut_usuario ?>
						</td>
						<td>
							<?php echo ucwords(mb_strtolower($usuario_nuevo->nombres, 'UTF-8')) ?>
						</td>
						<td>
							<?php echo ucwords(mb_strtolower($usuario_nuevo->paterno, 'UTF-8')) ?>
						</td>
						<td>
							<?php echo ucwords(mb_strtolower($usuario_nuevo->materno, 'UTF-8')) ?>
						</td>
						<td><input type="text" name="f_inicio[]" class="i_fecha" style="width: 75px;text-align: center;" value="inicio" /></td>
						<td><input type="text" name="f_termino[]" class="i_fecha" style="width: 75px;text-align: center;" value="término" /></td>
						<td>
							<select name="origen[]">
								<option value="">Origen</option>
								<?php foreach($lista_origen as $lo){ ?>
								<option value="<?php echo $lo->id ?>"><?php echo ucwords( mb_strtolower($lo->nombre, 'UTF-8')) ?></option>
								<?php } ?>
							</select>
						</td>
						<td><a class="quitar_reemplazo" rel="<?php echo $usuario_nuevo->id ?>" href="<?php echo $la->id ?>/<?php echo $id_req ?>/<?php echo $usuario_nuevo->id ?>/<?php echo $nvo_motivo ?>/<?php echo $nvo_obs ?>">Quitar</a></td>
						<td>&nbsp;</td>
					</tr>
					<input type="hidden" name="trabajador_reemplazo[<?php echo $i ?>]" value="<?php echo $usuario_nuevo->id ?>" />
					<?php endif; ?>
					<?php $i++; ?>
					<?php } ?>
					<?php }else{ ?>
					<tr class="odd gradeX">
						<td>No hay usuarios agregados</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<br />
		<input type="hidden" name="id_requerimiento" value="<?php echo $id_req ?>" />
		<button id="boton_envio" type="submit" class="btn primary">
			Guardar
		</button>
		</form>
	</div>
	<form id='aux_form'>
		<input type="hidden" name="id_req" value="<?php echo $id_req ?>" />
	</form>
</div>
<!-- -->