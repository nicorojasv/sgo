<!-- OVERLAY CON LA EDICION  -->
<div id="modal_contratos" >
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3><?php echo $titulo ?></h3>
	</div>
	<div id="modal_content">
		<div style="width: 370px;">
				<form class="form" method="post" action="<?php echo base_url().$action ?>">
					<div class="field input">
						<label>Nombre de variable:</label>
						<div class="fields">
							<input type="text" name="nb_var" value="<?php echo (isset($nb_var))? $nb_var: ''; ?>" style="width: 235px;" />
						</div>
						<!-- .fields -->
					</div>
					<div class="field input">
						<label>Valor de variable:</label>
						<div class="fields">
							<input type="text" name="val_var" value="<?php echo (isset($val_var))? $val_var: ''; ?>" style="width: 235px;" />
						</div>
						<!-- .fields -->
					</div>
					<div class="actions">
					<button type="submit" class="btn primary" id="guardar_nuevo_examen">
						Guardar
					</button>
				</div>
				</form>
		</div>
	</div>
	   
</div>
<!-- -->