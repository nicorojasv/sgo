<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> REGISTRAR</h4>
	</div>
	<div class="panel-body">
	<hr>
	<form action="<?php echo base_url() ?>carrera/trabajadores/guardar_nuevo_trabajador" method='post'>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">
						Rut <span class="symbol required"></span>
					</label>
					<input type="text" placeholder="Ingrese el rut" class="form-control" id="rut" name="rut" value="<?php if(!empty($texto_anterior['rut_usuario'])) ?>" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Nombres <span class="symbol required"></span>
					</label>
					<input type="text" placeholder="Ingrese sus nombres" class="form-control" id="firstname" name="nombres" value="<?php if(!empty($texto_anterior['nombres'])) ?>" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Apellido Paterno <span class="symbol required"></span>
					</label>
					<input type="text" placeholder="Ingrese su apellido Paterno" class="form-control" id="lastname" name="paterno" value="<?php if(!empty($texto_anterior['paterno'])) ?>" required>
				</div>
				<div class="form-group">
					<label class="control-label">
						Apellido Materno 
					</label>
					<input type="text" placeholder="Ingrese su apellido Materno" class="form-control" id="lastname" name="materno" value="<?php if(!empty($texto_anterior['materno'])) ?>" >
				</div>
				<div class="form-group">
					<label class="control-label">
						Correo Electr&oacute;nico
					</label>
					<input type="email" placeholder="Ingrese el correo" class="form-control" id="email" name="email" value="<?php if(!empty($texto_anterior['email'])) ?>" >
				</div>
				<br><br><br>
				<div class="form-group">
					<label class="control-label">
						<b>DATOS DE EMERGENCIA</b><br>Nombre<span class="symbol required"></span>
					</label>
					<input type="text" class="form-control" id="emerg_nombre" name="emerg_nombre" required>
					<label class="control-label">
						Telefono<span class="symbol required"></span>
					</label>
					<input type="text" class="form-control" id="emerg_telefono" name="emerg_telefono" required>
					<label class="control-label">
						Parentesco<span class="symbol required"></span>
					</label>
					<select name="emerg_parentesco" id="emerg_parentesco" class="form-control" required>
						<option value="0" >Seleccionar</option>
						<?php foreach ($lista_parentesco as $l) { ?>
							<option value="<?php echo $l->id ?>"><?php echo $l->nombre ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group connected-group">
					<label class="control-label">
						Tel&eacute;fono <span class="symbol required"></span>
					</label>
					<div class="row">
						<div class="col-md-9">
							<input type="phone" class="form-control" name="fono1" id="phone" value="<?php if(!empty($texto_anterior['fono1'])) ?>" required>
						</div>
					</div>
				</div>
				<div class="form-group connected-group">
					<label class="control-label">
						Fecha de Nacimiento <span class="symbol required"></span>
					</label>
					<div class="row">
						<div class="col-md-3">
							<select name="select_nac_dia" id="dd" class="form-control" required>
								<option value="">DD</option>
								<option value="01">1</option>
								<option value="02">2</option>
								<option value="03">3</option>
								<option value="04">4</option>
								<option value="05">5</option>
								<option value="06">6</option>
								<option value="07">7</option>
								<option value="08">8</option>
								<option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select>
						</div>
						<div class="col-md-3">
							<select name="select_nac_mes" id="mm" class="form-control" required>
								<option value="">MM</option>
								<option value="01">1</option>
								<option value="02">2</option>
								<option value="03">3</option>
								<option value="04">4</option>
								<option value="05">5</option>
								<option value="06">6</option>
								<option value="07">7</option>
								<option value="08">8</option>
								<option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" placeholder="YYYY" id="yyyy" name="select_nac_ano" maxlength="4" class="form-control" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label">
						Genero
					</label>
					<div>
						<label class="radio-inline">
							<input type="radio" class="grey" value="1" name="genero" id="gender_female" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
							Femenino
						</label>
						<label class="radio-inline">
							<input type="radio" class="grey" value="0" name="genero" id="gender_male" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);">
							Masculino
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div>
					<span class="symbol required"></span>Campos Obligatorios
					<hr>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
			</div>
			<div class="col-md-4">
				<button class="btn btn-yellow btn-block" type="submit">
					Registrar <i class="fa fa-arrow-circle-right"></i>
				</button>
			</div>
		</div>
	</form>
</div>
</div>