<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/evaluaciones.js" type="text/javascript"></script>
<div class='col-xs-8' >
	<h2>Evaluaciones creadas</h2>
	<table class="table">
		<thead>
			<th>#</th>
			<th>ID</th>
			<th>Nombre</th>
			<th>Tipo Evaluación</th>
			<th>Tipo Resultado</th>
		</thead>
		<tbody>
			<?php if(isset($listado_eval)){ ?>
			<?php foreach($listado_eval as $c){ ?>
			<tr>
				<td><input type="radio" name="select" value="<?php echo $c->id ?>" /></td>
				<td><?php echo $c->id ?></td>
				<td><?php echo ucwords(mb_strtolower($c->nombre,'UTF-8')) ?></td>
				<td><?php echo ucwords(mb_strtolower($this->Evaluacionestipo_model->get($c->id_tipo)->nombre,'UTF-8')) ?></td>
				<td><?php echo ($c->tipo_resultado == 1) ? "Numérico": "Cualitativo"; ?></td>
			</tr>
			<?php } ?>
			<?php } else{ ?>
			<tr><td colspan="3">No existen evaluaciones creadas</td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class='col-xs-4'>
	<a href="<?php echo base_url() ?>administracion/evaluaciones/modal_editar_evaluacion" id="editar" class="btn xlarge primary dashboard_add"><span></span>Editar</a>
	<a href="<?php echo base_url() ?>administracion/evaluaciones/eliminar" id="eliminar" class="btn xlarge secondary dashboard_add">Eliminar</a>
	<div class="box">
		<h3>Tipo de evaluaciones</h3>
		<ul class="contact_details">
			<?php if(!empty($listado_tipos)){ ?>
			<?php foreach($listado_tipos as $l){ ?>
			<li>- <?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?><a class="eliminar_categoria" title="Eliminar" style="position: absolute;margin-top: -8px" href=""><img src="<?php echo base_url() ?>extras/img/delete-2.png" /></a></li>
			<?php } ?>
			<?php }else{ ?>
			<li>No existen tipos de evaluaciones</li>
			<?php } ?>
		</ul>
		<h4><a href="#modal" class="dialog">Agregar un nuevo tipo de evaluación</a></h4>
	</div>
</div>
<!-- OVERLAY OCULTO PARA AGREGAR UN TIPO DE EVALUACION -->
<div id="eval" style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de evaluación</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor asigne nombre a evaluacion
			</p>
			<form action="<?php echo base_url() ?>administracion/evaluaciones/guardar_categoria" method="post" class="form">
				<div class="field select">
					<label for="email">Tipo</label>
					<div class="fields">
						<select name="tipo_eval">
							<?php if(!empty($listado_tipos)){ ?>
							<option value="">Seleccione...</option>
							<?php foreach($listado_tipos as $l){ ?>
							<option value="<?php echo $l->id ?>"><?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')) ?></option>
							<?php } ?>
							<?php }else{ ?>
							<option value="">No existen tipos de evaluaciones</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="field">
					<label for="email">Nombre</label>
					<div class="fields">
						<input type="text" name="eval" value="" id="cat" size="30" tabindex="1">
					</div>
				</div>
				<div class="field">
					<label for="email">Abreviación</label>
					<div class="fields">
						<input type="text" name="abre" value="" id="abr" size="5" tabindex="1">
					</div>
				</div>
				<div class="fields">
					<label for="email">Tipo de resultado</label>
					<div class="fields">
						<input type="radio" name="resultado" value="1" /> Numérico &nbsp; <input type="radio" name="resultado" value="2" /> Cualitativo
					</div>
				</div>
				<div class="actions">
					<br />
					<button type="submit" class="btn primary" tabindex="1">
						Crear
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--  -->
<!-- OVERLAY OCULTO PARA AGREGAR UN NOMBRE DE EVALUACION -->
<div id="modal" style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de tipo de evaluación</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese un nuevo tipo.
			</p>
			<form action="<?php echo base_url() ?>administracion/evaluaciones/guardar_tipo" method="post" class="form">
				<div class="field">
					<label for="email">Nombre</label>
					<div class="fields">
						<input type="text" name="cat" value="" id="cat" size="30" tabindex="1">
					</div>
				</div>
				<div class="actions">
					<button type="submit" class="btn primary" tabindex="1">
						Crear
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--  -->