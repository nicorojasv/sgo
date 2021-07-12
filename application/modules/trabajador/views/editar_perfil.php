<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> AGREGAR/MODIFICAR DATOS</h4>
	</div>
	<div class="panel-body">
		<div class="tabbable tabs-left">
			<ul id="myTab2" class="nav nav-tabs">
				<li class="active">
					<a href="#datos-personales" data-toggle="tab">
						<i class="pink fa fa-user"></i> Datos Personales
					</a>
				</li>
				<li>
					<a href="#datos-imagen" data-toggle="tab">
						<i class='pink fa fa-file-photo-o' ></i> Imagen
					</a>
				</li>
				<li>
					<a href="#datos-tecnicos" data-toggle="tab">
						<i class='pink fa fa-gears' ></i> Datos T&eacute;cnicos
					</a>
				</li>
				<li>
					<a href="#datos-extras" data-toggle="tab">
						<i class='pink fa fa-puzzle-piece' ></i> Datos Extras
					</a>
				</li>
				<li>
					<a href="#datos-pass" data-toggle="tab">
						<i class='pink fa fa-key' ></i> Cambiar Contrase&ntilde;a
					</a>
				</li>
				<li>
					<a href="#datos-experiencia" data-toggle="tab">
						<i class='pink fa fa-suitcase' ></i> Experiencia
					</a>
				</li>
				<li>
					<a href="#datos-examenes" data-toggle="tab">
						<i class='pink fa fa-suitcase' ></i> Archivos
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="datos-personales">
					<h3><b>Datos Personales</b></h3>
					<?php echo @$aviso_personal; ?>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>trabajador/perfil/guardar_personales/<?php echo $usuario->id ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								RUT:
							</label>
							<div class="col-sm-9">
								<input type="text" name="field" value="<?php echo $usuario->rut_usuario; ?>" id="input_rut" size="22" disabled="true" >
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-2">
								Nombres: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" name="nombres" id="nombres" value="<?php echo $usuario->nombres; ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-3">
								Apellidos: <span class="symbol required"></span>
							</label>
							<div class="col-sm-5">
								<input type="text" name="paterno" id="paterno" value="<?php echo $usuario->paterno ?>" class="form-control" required>
							</div>
							<div class="col-sm-4">
								<input type="text" name="materno" id="materno" value="<?php echo $usuario->materno ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-4">
								Fecha de nacimiento: <span class="symbol required"></span>
							</label>
							<div class="col-sm-3">
								<?php 
								if ($usuario->fecha_nac)
									$f_nac = explode('-',$usuario->fecha_nac); 
								else $f_nac = false;
								?>
								<select name="nac_dia" id="nac_dia" class="form-control" required>
									<option value="">DD</option>
									<?php for( $i=1;$i<32;$i++ ){ ?>
									<option <?php echo (@$f_nac[2] == $i)?'SELECTED':'' ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<select name="nac_mes" id="nac_mes" class="form-control" required>
									<option value="">MM</option>
									<?php for( $i=1;$i<13;$i++ ){ ?>
									<option <?php echo (@$f_nac[1] == $i)?'SELECTED':'' ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<input type="text" name="nac_ano" id="nac_ano" placeholder="YYYY"  value="<?php echo @$f_nac[0] ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Regi&oacute;n: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_region" id="select_region" class="form-control" required>
									<option value="">Seleccione una región...</option>
									<?php foreach ($regiones as $rg) { ?>
									<option value="<?php echo $rg->id ?>" <?php echo ($usuario->id_regiones == $rg->id) ? "selected='true' ": '' ?> > <?php echo $rg->desc_regiones ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Provincia: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_provincia" id="select_provincia" class="form-control" required>
									<option value="">Seleccione una provincia...</option>
									<?php foreach($provincias as $p){ ?>
									<option value="<?php echo $p->id ?>" <?php echo ($usuario->id_provincias == $p->id) ? "selected='true' ": '' ?> > <?php echo $p->desc_provincias ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Ciudad: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_ciudad" id="select_ciudad" class="form-control" required>
									<option value="">Seleccione una ciudad...</option>
									<?php foreach($ciudades as $c){ ?>
									<option value="<?php echo $c->id ?>" <?php echo ($usuario->id_ciudades == $c->id) ? "selected='true' ": '' ?> > <?php echo $c->desc_ciudades ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Direcci&oacute;n: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" name="direccion" id="direccion" value="<?php echo $usuario->direccion ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Sexo: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_sexo" id="select_sexo" class="form-control" required>
									<option value="">Seleccione...</option>
									<option value="0" <?php echo ($usuario->sexo == 0) ? "selected='true' ": ''; ?>>Masculino</option>
									<option value="1" <?php echo ($usuario->sexo == 1) ? "selected='true' ": ''; ?>>Femenino</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Telefono: <span class="symbol required"></span>
							</label>
							<?php if(isset($usuario->fono)){ ?>
							<?php $fono = explode("-",$usuario->fono); ?>
							<?php $fono1 = $fono[0]; $fono2 = $fono[1]; ?>
							<?php } ?>
							<div class="col-sm-1">
								<input type="text" id="fono1" name='fono1' value="<?php echo @$fono1 ?>" class="form-control" required>
							</div>
							<div class="col-sm-8">
								<input type="text" id="fono2" name='fono2' value="<?php echo @$fono2 ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Telefono 2:
							</label>
							<?php if(isset($usuario->telefono2)){ ?>
							<?php $telefono = explode("-",$usuario->telefono2); ?>
							<?php $telefono1 = $telefono[0]; $telefono2 = $telefono[1]; ?>
							<?php } ?>
							<div class="col-sm-1">
								<input type="text" id="fono3" name='fono3' value="<?php echo @$telefono ?>" class="form-control">
							</div>
							<div class="col-sm-8">
								<input type="text" id="fono4" name='fono4' value="<?php echo @$telefono2 ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Email:
							</label>
							<div class="col-sm-9">
								<input type="email" name="email" id="email" value="<?php echo $usuario->email ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Estado Civil: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_civil" id="select_civil" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($civil as $c) { ?>
									<option value="<?php echo $c->id ?>" <?php echo ($usuario->id_estadocivil == $c->id) ? "selected='true' ": ''; ?>> <?php echo $c->desc_estadocivil ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Nacionalidad: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_nacionalidad" id="select_nacionalidad" class="form-control" required>
									<option value="">Seleccione... </option>
									<option value="chilena" <?php echo ($usuario->nacionalidad == "chilena") ? "selected='true'" : ''; ?> >Chilena </option>
									<option value="extranjera" <?php echo ($usuario->nacionalidad == "extranjera") ? "selected='true'" : ''; ?>>Extranjera </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos Personales
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-imagen">
					<h3><b>Modificar imagen</b></h3>
					<?php echo @$aviso_imagen; ?>
					<p>Favor seleccione que tipo de imagen desea subir. La extencion de los archivos soportados son .png y .jpg, el tamaño maximo del archivo es de 2MB.</p>
					<form enctype="multipart/form-data" role="form" class="form-horizontal" action="<?php echo  base_url() ?>trabajador/perfil/guardar_imagen/<?php echo $usuario->id ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Imagen
							</label>
							<div class="col-sm-9">
								<input type="file" name="imagen" id="file" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar imagen
								</button>
							</div>
						</div>
					</form>
					<br><br><br><br><br><br><br><br><br><br>
				</div>
				<div class="tab-pane fade" id="datos-tecnicos">
					<h3><b>Datos T&eacute;cnicos</b></h3>
					<?php echo @$aviso_tecnico; ?>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>trabajador/perfil/guardar_tecnicos/<?php echo $usuario->id ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Nivel de estudios: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_estudios" id="select_estudios" class="form-control" required>
									<option value="">Seleccione un nivel...</option>
									<?php foreach ($lvl_estudios as $lvl) { ?>
									<option value="<?php echo $lvl->id ?>" <?php echo ($lvl->id == $usuario->id_estudios)? "selected='true'" :''; ?> > <?php echo $lvl->desc_nivelestudios ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-2">
								Nombre Instituci&oacute;n: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="institucion" name="institucion" value="<?php echo ucwords(mb_strtolower($usuario->institucion, 'UTF-8')); ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-3">
								A&ntilde;o Egreso: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="ano_egreso" name="ano_egreso" value="<?php echo $usuario->ano_egreso ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-4">
								Titulo/ Profesi&oacute;n: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_profesiones" id="select_profesiones" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($profesiones as $p) { ?>
									<option value="<?php echo $p->id ?>" <?php echo ($p->id == $usuario->id_profesiones)? "selected='true'" :''; ?> > <?php echo $p->desc_profesiones ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Especialidad: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_especialidad1" id="select_especialidad1" class="form-control" required>
									<option value="">Seleccione especialidad...</option>
									<?php foreach ($esp_trab as $et) { ?>
									<option value="<?php echo $et->id ?>" <?php echo ($et->id == $usuario->id_especialidad_trabajador)? "selected='true'" :''; ?> > <?php echo $et->desc_especialidad ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Especialidad:
							</label>
							<div class="col-sm-9">
								<select name="select_especialidad2" id="select_especialidad2" class="form-control">
									<option value="">Seleccione especialidad...</option>
									<?php foreach ($esp_trab as $et) { ?>
									<option value="<?php echo $et->id ?>" <?php echo ($et->id == $usuario->id_especialidad_trabajador_2)? "selected='true'" :''; ?> > <?php echo $et->desc_especialidad ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								A&ntilde;os de experiencia: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="anos_experiencia" name="anos_experiencia" value="<?php echo $usuario->ano_experiencia ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Cursos relevantes:
							</label>
							<div class="col-sm-9">
								<textarea id="cursos" name="cursos" class="form-control"><?php echo $usuario->cursos ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Equipos que maneja:
							</label>
							<div class="col-sm-9">
								<textarea id="equipos" name="equipos" class="form-control"><?php echo $usuario->equipos ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Software que maneja:
							</label>
							<div class="col-sm-9">
								<textarea id="software" name="software" class="form-control"><?php echo $usuario->software ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Idiomas:
							</label>
							<div class="col-sm-9">
								<textarea id="idiomas" name="idiomas" class="form-control"><?php echo $usuario->idiomas ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos T&eacute;cnicos
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-extras">
					<h3><b>Datos Extras</b></h3>
					<?php echo @$aviso_extra; ?>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>trabajador/perfil/guardar_extras/<?php echo $usuario->id ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1">
								Banco:
							</label>
							<div class="col-sm-9">
								<select name="select_bancos" id="select_bancos" class="form-control">
									<option value="">Seleccione un banco...</option>
									<?php foreach ($bancos as $b) { ?>
									<option value="<?php echo $b->id ?>" <?php echo ($b->id == $usuario->id_bancos) ? "selected" :''; ?> > <?php echo $b->desc_bancos ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-2">
								Tipo de cuenta:
							</label>
							<div class="col-sm-9">
								<input type="text" id="tipo_cuenta" name="tipo_cuenta" value="<?php echo $usuario->tipo_cuenta ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-3">
								N° de cuenta:
							</label>
							<div class="col-sm-9">
								<input type="text" id="n_cuenta" name="n_cuenta" value="<?php echo $usuario->cuenta_banco ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-4">
								AFP: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_afp" id="select_afp" class="form-control" required>
									<option value="">Seleccione una afp...</option>
									<?php foreach ($afp as $a) { ?>
									<option value="<?php echo $a->id ?>" <?php echo ($a->id == $usuario->id_afp)? "selected='true'" :''; ?> > <?php echo $a->desc_afp ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group" <?php if(!$usuario->id_excajas){ ?> style="display: none;" <?php } ?> >
							<label class="col-sm-2 control-label" for="form-field-5">
								IPS - EX CAJA:
							</label>
							<div class="col-sm-9">
								<select name="select_excaja" id="select_excaja">
									<option value="">Seleccione...</option>
									<?php foreach ($excajas as $ex) { ?>
									<option value="<?php echo $ex->id ?>" <?php echo ($ex->id == $usuario->id_excajas)? "selected='true'" :''; ?> > <?php echo $ex->desc_excaja ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Sistema de Salud: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_salud" id="select_salud" class="form-control" required>
									<option value="">Seleccione un sistema de salud...</option>
									<?php foreach ($salud as $s) { ?>
									<option value="<?php echo $s->id ?>" <?php echo ($s->id == $usuario->id_salud)? "selected='true'" :''; ?> > <?php echo $s->desc_salud ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Licencia de conducir:
							</label>
							<div class="col-sm-9">
								<input type="text" id="licencia" name="licencia" value="<?php echo $usuario->licencia ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								N° de Zapato: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="n_zapato" name="n_zapato" value="<?php echo $usuario->num_zapato ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Talla de buzo: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_talla" id="select_talla" required>
									<option value="">Selecione...</option>
									<option <?php echo ($usuario->talla_buzo == 'S')? "selected='true'" :''; ?> >S</option>
									<option <?php echo ($usuario->talla_buzo == 'M')? "selected='true'" :''; ?> >M</option>
									<option <?php echo ($usuario->talla_buzo == 'L')? "selected='true'" :''; ?> >L</option>
									<option <?php echo ($usuario->talla_buzo == 'XL')? "selected='true'" :''; ?> >XL</option>
									<option <?php echo ($usuario->talla_buzo == 'XXL')? "selected='true'" :''; ?> >XXL</option>
									<option <?php echo ($usuario->talla_buzo == 'XXXL')? "selected='true'" :''; ?> >XXXL</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-1"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos Extras
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-pass">
					<form action="<?php echo base_url() ?>trabajador/perfil/cambiar_contrasena/<?php echo $usuario->id ?>" method="post" class="form-horizontal" >
						<h3><b>Modificar contraseña</b></h3>
						<?php echo @$aviso_pass; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Contraseña actual: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="password" name="pass_original" id="pass_original" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Nueva Contraseña: <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="password" name="pass_nueva1" id="pass_nueva1" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="form-field-5">
								Confirme Contraseña: <span class="symbol required"></span>
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
				<div class="tab-pane fade" id="datos-experiencia">
					<h3><b>Listado de experiencias</b></h3>
					<p>En esta sección usted podrá ingresar la experiencia que ha tenido como trabajador.</p>
					<a data-toggle="modal" data-target="#ModalAgregarExperiencia" class="btn btn-primary dialog" href="#">Agregar Nueva Experiencia</a>
					<br><br>
					<table class="table">
						<thead>
							<tr>
								<th style="width: 40px;">Desde</th>
								<th style="width: 40px;">Hasta</th>
								<th>Cargo</th>
								<th>Area</th>
								<th>Empresa contratista</th>
								<th>Empresa mandante/planta</th>
								<th>Principales funciones</th>
								<th>Referencias</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php if( count($experiencia) > 0 ){ ?>
							<?php foreach ($experiencia as $ex) { ?>
							<tr class="odd gradeX">
								<?php $f_desde = explode("-", $ex->desde) ?>
								<td><?php echo $f_desde[2].'-'.$f_desde[1].'-'.$f_desde[0] ?></td>
								<?php $f_hasta = explode("-", $ex->hasta) ?>
								<td><?php echo $f_hasta[2].'-'.$f_hasta[1].'-'.$f_hasta[0] ?></td>
								<td><?php echo $ex->cargo ?></td>
								<td><?php echo $ex->area ?></td>
								<td><?php echo $ex->empresa_c ?></td>
								<td><?php echo $ex->empresa_m ?></td>
								<td>
									<?php echo $ex->funciones; ?>
								<?php $funciones = explode(";", $ex->funciones); ?>
								<?php for($i=0;$i<(count($funciones)-1);$i++){
									echo ucwords(strtolower($funciones[$i]));
									if($i < (count($funciones)-2)) echo ", ";
								} ?>
								</td>
								<td>
									<?php echo $ex->referencias; ?>
								<?php $referencia = explode(";", $ex->referencias); ?>
								<?php for($i=0;$i<(count($referencia)-1);$i++){
									echo ucwords(strtolower($referencia[$i]));
									if($i < (count($referencia)-2)) echo ", ";
								} ?>
								</td>
								<td class="center">
                  					<a data-toggle="modal" href="<?php echo base_url() ?>trabajador/perfil/editar_exp/<?php echo $ex->id ?>" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>
									<a class="eliminar" href="<?php echo base_url() ?>trabajador/perfil/eliminar_exp/<?php echo $ex->id ?>" title="Eliminar"><i class="fa fa-trash-o"></i></a>
								</td>
							</tr>
							<?php }
								}else{
							?>
							<tr class="odd gradeX" style="text-align:center">
								<td colspan="10">no existen experiencias agregadas</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<br><br><br><br><br><br><br><br>
				</div>
				<div class="tab-pane fade" id="datos-examenes">
					<h3><b>Subir un Archivo al Sistema</b></h3>
					<p>
						Favor seleccione que <b>tipo de archivo</b> desea subir. La extencion de los archivos soportados son <b>Word (.doc - .docx) y Pdf (.pdf)</b>, el <b>tamaño maximo</b> de cada 
						archivo es de <b>5MB</b>.
						<br>Usted puede ingresar un <strong>maximo</strong> de 7 archivos.
					</p>
					<form enctype="multipart/form-data" action="<?php echo base_url() ?>trabajador/perfil/guardar_archivos" method="post" class="form">
						<div class="field select">
							<label>Tipo de archivo:</label>
							<div class="fields">
								<select name="select_archivo" id="select_archivo" required>
									<option value="">Seleccione el tipo de archivo...</option>
									<?php foreach($listado_tipo as $lt){ ?>
									<option value="<?php echo $lt->id; ?>"><?php echo $lt->desc_tipoarchivo; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="field file">
							<label>Documento:</label>
							<div class="fields">
								<input type="file" name="documento" id="documento" required>
							</div>
						</div>
						<div class="actions">
							<button type="submit" class="btn primary">
								Subir Archivo
							</button>
						</div>
					</form>
					<table class="data display">
						<?php foreach($listado_archivo as $la){ ?>
						<tr>
							<td><b><?php echo $la->nb_tipo; ?></b></td>
							<td><a target="_blank" href="<?php echo base_url().$la->url; ?>"><?php echo $la->nb_archivo; ?></a></td>
							<td>
								<a href="<?php echo base_url() ?>trabajador/perfil/eliminar_archivo/<?php echo $la->id; ?>" onclick="return confirm('¿Está seguro?');" title="Eliminar">
									<i class="icon-trash"></i>
								</a>
							</td>
						</tr>
						<?php } ?>
					</table>
					<br><br><br><br>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Editar Examen-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<!-- Modal Agregar Experiencia-->
<div class="modal fade" id="ModalAgregarExperiencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Ingreso Nueva Experiencia</h2>
      </div>
      <div class="modal-body">
        <div style="text-align:center">
          <h5>Instrucciones:</h5>
          <p>* Todos los campos sus obligatorios.</p>
        </div>
        <form action="<?php echo base_url() ?>trabajador/perfil/guardar_experiencia" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Desde</label>
              <div class="controls">
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario->id ?>"/>
            	<select name="select_dia_desde" style="width:48px" required>
					<option value="">Dia</option>
					<?php for ($i=1; $i < 32 ; $i++) { ?> 
					<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="select_mes_desde" style="width:60px" required>
					<option value="">Mes</option>
					<?php for ($i=1; $i < 13 ; $i++) { ?>
					<option value="<?php echo $i ?>"><?php echo $meses[$i-1] ?></option>
					<?php } ?>
				</select>
				<?php
				$ano_inicio = date('Y') - 40;
				$ano_fin = date('Y') + 1;
				?>
				<select name="select_ano_desde" style="width:64px" required>
					<option value="">Año</option>
					<?php for ($ano_inicio; $i < $ano_fin ; $i++) { ?> 
					<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
				</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Hasta</label>
              <div class="controls">
              	<select name="select_dia_hasta" style="width:48px" required>
					<option value="">Dia</option>
					<?php for ($i=1; $i < 32 ; $i++) { ?> 
					<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
				</select>
				<select name="select_mes_hasta" style="width:60px" required>
					<option value="">Mes</option>
					<?php for ($i=1; $i < 13 ; $i++) { ?>
					<option value="<?php echo $i ?>"><?php echo $meses[$i-1] ?></option>
					<?php } ?>
				</select>
				<?php
				$ano_inicio = date('Y') - 40;
				$ano_fin = date('Y') + 1;
				?>
				<select name="select_ano_hasta" style="width:64px" required>
					<option value="">Año</option>
					<?php for ($ano_inicio; $i < $ano_fin ; $i++) { ?> 
					<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
				</select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Cargo</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="cargo" id="cargo" onkeypress='return valida_abecedario(event)' placeholder="Cargo" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Area</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="area" id="area" onkeypress='return valida_abecedario(event)' placeholder="Area" required/>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Empresa Contratista</label>
              <div class="controls">
                <input type="text" name="empresa_c" id="empresa_c" onkeypress='return valida_abecedario(event)' placeholder="Empresa Contratista"  required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Empresa Mandante/Planta</label>
                <div class="controls">
	                <input type="text" name="empresa_m" id="empresa_m" onkeypress='return valida_abecedario(event)' placeholder="Empresa Mandante"  required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Principales Funciones</label>
                <div class="controls">
                	<input type="text" name="funciones" id="funciones" onkeypress='return valida_abecedario(event)' placeholder="Principales Funciones"  required>
				</div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Referencias</label>
                <div class="controls">
                	<input type="text" name="referencias" id="referencias" onkeypress='return valida_abecedario(event)' placeholder="Referencias"  required>
				</div>
            </div>
          </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>