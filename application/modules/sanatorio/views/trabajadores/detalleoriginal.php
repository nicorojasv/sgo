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
					<a href="#contacto-emergencia" data-toggle="tab">
						<i class="pink fa fa-warning"></i> Contacto de Emergencia
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
			</ul>
			<div class="tab-content">
				<div class="tab-pane fade in active" id="datos-personales">
					<h2>Datos Personales</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>wood/trabajadores/guardar_personales" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="rut">
								RUT <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" name="rut" id="rut" value='<?php echo $datos_usuario->rut_usuario ?>' class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="nombres">
								Nombres <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" name="nombres" value="<?php echo $datos_usuario->nombres ?>" id="nombres" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="paterno">
								Apellidos <span class="symbol required"></span>
							</label>
							<div class="col-sm-5">
								<input type="text" name="paterno" value="<?php echo $datos_usuario->paterno ?>" id="paterno" class="form-control" required>
							</div>
							<div class="col-sm-4">
								<input type="text" name="materno" value="<?php echo $datos_usuario->materno ?>" id="materno" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="nac_dia">
								Fecha de nacimiento 
							</label>
							<div class="col-sm-3">
								<?php 
								if ($datos_usuario->fecha_nac)
									$f_nac = explode('-',$datos_usuario->fecha_nac); 
								else $f_nac = false;
								?>
								<select name="nac_dia" id="nac_dia" class="form-control">
									<option value="">DD</option>
									<?php for( $i=1;$i<32;$i++ ){ ?>
									<option <?php echo (@$f_nac[2] == $i)?'SELECTED':'' ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<select name="nac_mes" id="nac_mes" class="form-control">
									<option value="">MM</option>
									<?php for( $i=1;$i<13;$i++ ){ ?>
									<option <?php echo (@$f_nac[1] == $i)?'SELECTED':'' ?>><?php echo $i ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<input type="text" name="nac_ano" placeholder="YYYY" id="nac_ano" value="<?php echo @$f_nac[0] ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_ciudad">
								Ciudad <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_ciudad" id="select_ciudad" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_ciudad as $lc) { ?>
										<option value="<?php echo $lc->id ?>" <?php echo ($datos_usuario->id_ciudad == $lc->id)?'SELECTED':'' ?> ><?php echo $lc->desc_ciudades ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="direccion">
								Direcci&oacute;n 
							</label>
							<div class="col-sm-9">
								<input type="text" name="direccion" id="direccion" value="<?php echo $datos_usuario->direccion ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_sexo">
								Sexo <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_sexo" id="select_sexo" class="form-control" required>
									<option value="">Seleccione...</option>
									<option value="0" <?php echo ($datos_usuario->sexo == 0)?'SELECTED':'' ?> >Masculino</option>
									<option value="1" <?php echo ($datos_usuario->sexo == 1)?'SELECTED':'' ?> >Femenino</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="fono1">
								Telefono <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" id="fono1" name='fono1' value="<?php echo $datos_usuario->fono ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="email">
								Email
							</label>
							<div class="col-sm-9">
								<input type="email" name="email" id="email" value="<?php echo $datos_usuario->email ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_civil">
								Estado Civil <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_civil" id="select_civil" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_civil as $lc) { ?>
										<option value="<?php echo $lc->id ?>" <?php echo ($datos_usuario->id_estado_civil == $lc->id)?'SELECTED':'' ?> ><?php echo $lc->desc_estadocivil ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_nacionalidad">
								Nacionalidad <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_nacionalidad" id="select_nacionalidad" class="form-control" required>
									<option value="">Seleccione... </option>
									<option value="chilena" <?php echo ($datos_usuario->nacionalidad == "chilena")?'SELECTED':'' ?> > Chilena </option>
									<option value="extranjera" <?php echo ($datos_usuario->nacionalidad == "extranjera")?'SELECTED':'' ?> > Extranjera </option>
									<option value="peruana" <?php echo ($datos_usuario->nacionalidad == "peruana")?'SELECTED':'' ?> > Peruana </option>
									<option value="venezolana" <?php echo ($datos_usuario->nacionalidad == "venezolana")?'SELECTED':'' ?> > Venezolana </option>
									<option value="ecuatoriana" <?php echo ($datos_usuario->nacionalidad == "ecuatoriana")?'SELECTED':'' ?> > Ecuatoriana </option>
									<option value="colombiana" <?php echo ($datos_usuario->nacionalidad == "colombiana")?'SELECTED':'' ?> > Colombiana </option>
									<option value="boliviana " <?php echo ($datos_usuario->nacionalidad == "boliviana ")?'SELECTED':'' ?> > Boliviana </option>
									<option value="cubana " <?php echo ($datos_usuario->nacionalidad == "cubana ")?'SELECTED':'' ?> > Cubana </option>
									<option value="argentina " <?php echo ($datos_usuario->nacionalidad == "argentina ")?'SELECTED':'' ?> > Argentina </option>
									<option value="brasileña " <?php echo ($datos_usuario->nacionalidad == "brasileña ")?'SELECTED':'' ?> > Brasileña </option>
									<option value="costarricense " <?php echo ($datos_usuario->nacionalidad == "costarricense ")?'SELECTED':'' ?> > Costarricense </option>
									<option value="española " <?php echo ($datos_usuario->nacionalidad == "española ")?'SELECTED':'' ?> > Española </option>
									<option value="estadounidense " <?php echo ($datos_usuario->nacionalidad == "estadounidense ")?'SELECTED':'' ?> > Estadounidense </option>
									<option value="mexicana " <?php echo ($datos_usuario->nacionalidad == "mexicana ")?'SELECTED':'' ?> > Mexicana </option>
									<option value="paraguaya " <?php echo ($datos_usuario->nacionalidad == "paraguaya ")?'SELECTED':'' ?> > Paraguaya </option>
									<option value="uruguaya " <?php echo ($datos_usuario->nacionalidad == "uruguaya ")?'SELECTED':'' ?> > Uruguaya </option>
									<option value="dominicana " <?php echo ($datos_usuario->nacionalidad == "dominicana ")?'SELECTED':'' ?> > Dominicana </option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="contacto-emergencia" >
					<h2>Contacto de Emergencia</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>wood/trabajadores/guardar_datos_de_emergencia/<?php echo $id_usuario ?>" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="nombres_emergencia">
								Nombres
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="nombres_emergencia" id="nombres_emergencia" value="<?php echo $datos_usuario->emerg_nombre ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="fono_emergencia">
								Telefono
							</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="fono_emergencia" id="fono_emergencia" value="<?php echo $datos_usuario->emerg_telefono ?>" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="emerg_parentesco">
								Parentesco
							</label>
							<div class="col-sm-9">
								<select name="emerg_parentesco" id="emerg_parentesco" class="form-control" required>
									<option value="">Seleccione... </option>
									<?php foreach ($lista_parentesco as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->emerg_parentesco_id == $le->id)?'SELECTED':'' ?> ><?php echo $le->nombre ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
						<br><br><br><br><br><br>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-tecnicos">
					<h2>Datos T&eacute;cnicos</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>wood/trabajadores/guardar_tecnicos" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_estudios">
								Nivel de estudios
							</label>
							<div class="col-sm-9">
								<select name="select_estudios" id="select_estudios" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_estudios as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_nivel_estudios == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_nivelestudios ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="institucion">
								Nombre Instituci&oacute;n
							</label>
							<div class="col-sm-9">
								<input type="text" id="institucion" name="institucion" value="<?php echo $datos_usuario->institucion ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="ano_egreso">
								A&ntilde;o egreso
							</label>
							<div class="col-sm-9">
								<input type="text" id="ano_egreso" name="ano_egreso" value="<?php echo $datos_usuario->ano_egreso ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_profesiones">
								Titulo/ Profesi&oacute;n
							</label>
							<div class="col-sm-9">
								<select name="select_profesiones" id="select_profesiones" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_profesiones as $lp) { ?>
										<option value="<?php echo $lp->id ?>" <?php echo ($datos_usuario->id_profesion == $lp->id)?'SELECTED':'' ?> ><?php echo $lp->desc_profesiones ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="datos-extras">
					<h2>Datos Extras</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>wood/trabajadores/guardar_extra" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >

						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_bancos">
								Banco
							</label>
							<div class="col-sm-9">
								<select name="select_bancos" id="select_bancos" class="form-control">
									<?php foreach ($lista_bancos as $lb) { ?>
										<option value="<?php echo $lb->id ?>" <?php echo ($datos_usuario->id_bancos == $lb->id)?'SELECTED':'' ?> ><?php echo $lb->desc_bancos ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="tipo_cuenta">
								Tipo de cuenta
							</label>
							<div class="col-sm-9">
								<input type="text" id="tipo_cuenta" name="tipo_cuenta" value="<?php echo $datos_usuario->tipo_cuenta ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="n_cuenta">
								N° de cuenta
							</label>
							<div class="col-sm-9">
								<input type="text" id="n_cuenta" name="n_cuenta" value="<?php  echo $datos_usuario->cuenta_banco ?>" class="form-control">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_afp">
								AFP
							</label>
							<div class="col-sm-9">
								<select name="select_afp" id="select_afp" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_afp as $la) { ?>
										<option value="<?php echo $la->id ?>" <?php echo ($datos_usuario->id_afp == $la->id)?'SELECTED':'' ?> ><?php echo $la->desc_afp ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_salud">
								Sistema de Salud
							</label>
							<div class="col-sm-9">
								<select name="select_salud" id="select_salud" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_salud as $ls) { ?>
										<option value="<?php echo $ls->id ?>" <?php echo ($datos_usuario->id_salud == $ls->id)?'SELECTED':'' ?> ><?php echo $ls->desc_salud ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="n_zapato">
								N° de Zapato
							</label>
							<div class="col-sm-9">
								<input type="text" id="n_zapato" name="n_zapato" value="<?php echo $datos_usuario->talla_zapato ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="talla_buzo">
								Talla de buzo
							</label>
							<div class="col-sm-9">
								<input type="text" id="talla_buzo" name="talla_buzo" value="<?php echo $datos_usuario->talla_buzo ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="talla_polera">
								Talla de Polera
							</label>
							<div class="col-sm-9">
								<input type="text" id="talla_polera" name="talla_polera" value="<?php echo $datos_usuario->talla_polera ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>