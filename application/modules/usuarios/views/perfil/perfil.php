<div class="tabbable">
	<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
		<li class="active">
			<a data-toggle="tab" href="#panel_overview">
				Vista Previa
			</a>
		</li>
		<li class="">
			<a data-toggle="tab" href="#panel_edit_account">
				Editar Cuenta
			</a>
		</li>
		<li>
			<a href="#datos-pass" data-toggle="tab">
				Cambiar Contrase&ntilde;a
			</a>
		</li>
	</ul>
	<div class="tab-content">
		<div id="panel_overview" class="tab-pane fade active in">
			<div class="row">
				<div class="col-sm-5 col-md-4">
					<div class="user-left">
						<div class="center">
							<h4><?php echo $nombre ?></h4>
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="user-image">
									<div class="fileupload-new thumbnail"><img src="<?php echo base_url().$imagen ?>" alt="">
									</div>
									<div class="fileupload-preview fileupload-exists thumbnail"></div>
									<div class="user-image-buttons"></div>
								</div>
							</div>
							<hr>
						</div>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th colspan="3">Informaci&oacute;n de Contacto</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>RUT</td>
									<td><?php echo $datos->rut_usuario; ?></td>
								</tr>
								<tr>
									<td>Genero</td>
									<td><?php echo ($datos->sexo)?'Femenino':'Masculino'; ?></td>
								</tr>
								<tr>
									<td>email:</td>
									<td>
										<a href="mail:<?php echo $datos->email; ?>">
											<?php echo $datos->email; ?>
										</a>
									</td>
								</tr>
								<tr>
									<td>Telefono:</td>
									<td><?php echo $datos->fono; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-sm-7 col-md-8">
					<div class="panel panel-white space20">
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th colspan="3">Informaci&oacute;n General</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Estado Civil</td>
									<td></td>
								</tr>
								<tr>
									<td>Regi&oacute;n</td>
									<td></td>
								</tr>
								<tr>
									<td>Provincia</td>
									<td></td>
								</tr>
								<tr>
									<td>Ciudad</td>
									<td></td>
								</tr>
								<tr>
									<td>Direcci&oacute;n</td>
									<td><?php echo $datos->direccion; ?></td>
								</tr>
							</tbody>
						</table>
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th colspan="3">Informaci&oacute;n Adicional</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>F. Nacimiento</td>
									<td><?php echo $datos->fecha_nac; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="panel_edit_account" class="tab-pane fade">
			<form action="<?php echo base_url() ?>usuarios/perfil/guardar_datos_perfil_general" role="form" id="form" method='post' enctype="multipart/form-data" >
				<input type="hidden" name="id" value="<?php echo $datos->id ?>">
				<div class="row">
					<div class="col-md-12">
						<h3>Informaci&oacute;n</h3>
						<hr>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">
								RUT
							</label>
							<input type="text" class="form-control" id="firstname" name="rut" value="<?php echo $datos->rut_usuario ?>" disabled="disabled">
						</div>
						<div class="form-group">
							<label class="control-label">
								Nombres <span class="symbol required"></span>
							</label>
							<input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $datos->nombres ?>" required>
						</div>
						<div class="form-group">
							<label class="control-label">
								Apellido Paterno <span class="symbol required"></span>
							</label>
							<input type="text" class="form-control" id="paterno" name="paterno" value="<?php echo $datos->paterno ?>" required>
						</div>
						<div class="form-group">
							<label class="control-label">
								Apellido Materno
							</label>
							<input type="text" class="form-control" id="materno" name="materno" value="<?php echo $datos->materno ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Email
							</label>
							<input type="email" class="form-control" id="email" name="email" value="<?php echo $datos->email ?>">
						</div>
						<div class="form-group">
							<label class="control-label">
								Telefono
							</label>
							<div class="row">
								<?php $fono = ($datos->fono)?explode("-", $datos->fono):false; ?>
								<div class="col-md-2">
									<input type="text" class="form-control" id="fono1" name="fono1" value="<?php echo $fono[0] ?>">
								</div>
								<div class="col-md-10">
									<input type="text" class="form-control" id="fono2" name="fono2" value="<?php echo $fono[1] ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group connected-group">
							<label class="control-label">
								Fecha de Nacimiento
							</label>
							<div class="row">
								<?php $nacimiento = ($datos->fecha_nac)?explode("-", $datos->fecha_nac):false; ?>

								<div class="col-md-3">
									<select name="nac_dia" id="nac_dia" class="form-control">
										<option value="">DD</option>
										<?php for( $i=1;$i<32;$i++ ){ ?>
										<option value="<?php echo $i ?>" <?php echo ($i==$nacimiento[2])?'SELECTED':''; ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3">
									<select name="nac_mes" id="nac_mes" class="form-control">
										<option value="">MM</option>
										<option value="">DD</option>
										<?php for( $i=1;$i<13;$i++ ){ ?>
										<option value="<?php echo $i ?>" <?php echo ($i==$nacimiento[1])?'SELECTED':''; ?>><?php echo $i ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-md-3">
									<input type="text" id="nac_ano" name="nac_ano" placeholder="YYYY" value="<?php echo $nacimiento[0] ?>" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">
								Genero
							</label>
							<div>
								<label class="radio-inline">
									<input type="radio" class="grey" value="1" name="select_sexo" id="gender_female" <?php echo ($datos->sexo==1)?"checked='checked'":''; ?>>
									Femenino
								</label>
								<label class="radio-inline">
									<input type="radio" class="grey" value="0" name="select_sexo" id="gender_male" <?php echo ($datos->sexo==0)?"checked='checked'":''; ?>>
									Masculino
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label">
								Estado Civil <span class="symbol required"></span>
							</label>
							<select name="select_civil" id="select_civil" class="form-control" required>
								<option value="">Seleccione...</option>
								<?php foreach ($estadocivil as $e) { ?>
									<option value="<?php echo $e->id ?>" <?php echo ($datos->estadocivil_id==$e->id)?'SELECTED':''; ?>><?php echo $e->desc_estadocivil ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="control-label">
								Nacionalidad <span class="symbol required"></span>
							</label>
							<select name="select_nacionalidad" id="select_nacionalidad" class="form-control" required>
								<option value="">Seleccione...</option>
								<option value="chilena" <?php echo ($datos->nacionalidad=='chilena')?'SELECTED':''; ?>>Chilena</option>
								<option value="extranjera" <?php echo ($datos->nacionalidad=='extranjera')?'SELECTED':''; ?>>Extranjera</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div>
							<hr>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7"></div>
					<div class="col-md-4">
						<button class="btn btn-green btn-block" type="submit">
							Actualizar <i class="fa fa-arrow-circle-right"></i>
						</button><br>
					</div>
				</div>
			</form>
		</div>
		<div class="tab-pane fade" id="datos-pass">
			<form action="<?php echo base_url() ?>usuarios/perfil/cambiar_contrasena_general" method="post" class="form-horizontal" >
				<h2>Modificar contraseña</h2>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-5">
						Contraseña Actual
					</label>
					<div class="col-sm-9">
						<input type="password" name="pass_original" id="pass_original" class="form-control" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-5">
						Nueva Contraseña
					</label>
					<div class="col-sm-9">
						<input type="password" name="pass_nueva1" id="pass_nueva1" class="form-control" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-5">
						Confirme Contraseña
					</label>
					<div class="col-sm-9">
						<input type="password" name="pass_nueva2" id="pass_nueva2" class="form-control" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form-field-1"></label>
					<div class="col-sm-9">
						<button type="submit" class="btn btn-primary">
						Editar contraseña
						</button>
					</div>
				</div>
			</form>
			<br><br><br><br><br><br><br><br>
		</div>
	</div>
</div>