<div class="span8">
	<?php echo @$aviso; ?>
	<h2>Categorias de usuarios</h2>
	<table class="data display">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
		</thead>
		<tbody>
			<?php if(isset($categorias)){ ?>
			<?php foreach($categorias as $c){ ?>
			<tr>
				<td><?php echo $c->id ?></td>
				<td><?php echo ucwords(mb_strtolower($c->desc_tipo_usuarios,'UTF-8')) ?></td>
			</tr>
			<?php } ?>
			<?php } else{ ?>
			<tr><td colspan="6">No existen categorias de usuario</td></tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="span3">
	
</div>

<!-- OVERLAY CON EL INGRESO DE UNA CATEGORIA -->
<div id="modal"style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Creación de nueva categoria</h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
			<p>
				Acontinuación favor ingrese una nueva categoria.
			</p>
			<form action="<?php echo base_url() ?>administracion/internos/ingresar_categoria" method="post" class="form">
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
<!-- -->