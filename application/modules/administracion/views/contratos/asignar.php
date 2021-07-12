<script src="<?php echo base_url() ?>extras/js/contrato.js" type="text/javascript"></script> 
<div class="span8">
	<table class="data display">
		<thead>
			<tr>
				<th><input type="checkbox" name="all" title="Chequear todos"></th>
				<th style="text-align: center;">Nombre</th>
				<th style="width: 73px;text-align: center;">sueldo</th>
				<?php if(isset($lista_bonos)){?>
					<?php foreach($lista_bonos as $lb){ ?>
						<th style="text-align: center;"><?php echo $lb->nombre ?></th>
					<?php } ?>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<form name="asignacion_contratos" action="#" method="post" id="form_asignacion_contratos">
			<?php $z = 0; ?>
			<?php foreach($lista_trabajadores as $lt){ ?>
			<tr>
				<td><input type="checkbox" name="check[<?php echo $z ?>]" value="<?php echo $lt->id_usuario ?>"></td>
				<td><a target="_blank" href="#" title="<?php echo $lt->rut_usuario ?>"><?php echo ucwords( mb_strtolower($lt->nombres.' '.$lt->paterno. ' '. $lt->materno,'UTF-8' ) ) ?></a></td>
				<td>$&nbsp;<input type="text" name="sueldo[]" style="width: 52px" /></td>
				<?php if(isset($lista_bonos)){?>
					<?php $i=0; ?>
					<?php foreach($lista_bonos as $lb){ ?>
						<td>$&nbsp;<input type="text" name="bono_<?php echo $i ?>[]" style="width: 52px" />
							<input type="hidden" name="contrato_<?php echo $i ?>[]" value='<?php echo $lb->id ?>' /></td>
						<?php $i++; ?>
					<?php } ?>
				<?php } ?>
			</tr>
			<?php $z++; ?>
			<?php } ?>
			<input type="hidden" name="cantidad_bonos" value="<?php echo (isset($lista_bonos)) ? count($lista_bonos): '0' ?>" />
			<input type="hidden" name="id_subreq" value="<?php echo $id_subreq ?>" />
			</form>
		</tbody>
	</table>
</div>
<div class='span3'>
	<div class="box">
		<p>Contrato</p>
		<select name="tipo_contrato" class="listado_contratos" title="<?php echo $id_subreq ?>" style="width: 220px">
			<option value="">Tipo de Contrato</option>
			<?php foreach($lista_contratos as $lc){ ?>
				<option value="<?php echo $lc->id ?>" <?php if(isset($id_contrato)){ echo ($id_contrato == $lc->id)? 'selected': ''; } ?>><?php echo ucwords( mb_strtolower($lc->nombre, 'UTF-8')) ?></option>
			<?php } ?>
		</select>
	</div>
	<a href="#" id="guardar" class="btn xlarge primary dashboard_add">Guardar</a>
	<a href="#" id="imprimir" class="btn xlarge primary dashboard_add">Imprimir</a>
	<a href="#" id="word" class="btn xlarge secondary dashboard_add">Generar Word</a>
</div>
<!-- OVERLAY CON LA EDICION  -->
<div id="modal_contratos" style="display: none" >
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Sueldos y contrato</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				
			</p>
			
		</div>
	</div>
	   
</div>
<!-- -->