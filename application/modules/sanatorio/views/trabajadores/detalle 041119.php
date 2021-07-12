<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"><i class="fa fa-pencil-square"></i> AGREGAR/MODIFICAR DATOS</h4>
	</div>
	<div class="panel-body">
	<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2 or $this->session->userdata('tipo_usuario') == 4 or $this->session->userdata('tipo_usuario') == 8){ ?>
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
						<i class='pink fa fa-suitcase' ></i> Examenes
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
								<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('id') == 39 or $this->session->userdata('id') == 81){ ?>
								<input type="text" name="rut" id="rut" value='<?php echo $datos_usuario->rut_usuario ?>' class="form-control">
								<?php }else{ ?>
								<input type="text" name="rut" id="rut" value='<?php echo $datos_usuario->rut_usuario ?>' class="form-control" disabled="disabled">
								<?php } ?>
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
						<div class="form-group row">
							<label class="col-sm-2 control-label">
								Fecha de Nacimiento <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<input type="text" v-model="fecha_nacimiento" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" data-input>
							</div>
						</div>

							</div>
							<div class="col-sm-3">
								<input type="text" name="nac_ano" placeholder="YYYY" id="nac_ano" value="<?php echo @$f_nac[0] ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_region">
								Regi&oacute;n <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_region" id="select_region" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_region as $lr) { ?>
										<option value="<?php echo $lr->id ?>" <?php echo ($datos_usuario->id_regiones == $lr->id)?'SELECTED':'' ?> ><?php echo $lr->desc_regiones ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_provincia">
								Provincia <span class="symbol required"></span>
							</label>
							<div class="col-sm-9">
								<select name="select_provincia" id="select_provincia" class="form-control" required>
									<option value="">Seleccione...</option>
									<?php foreach ($lista_provincia as $lp) { ?>
										<option value="<?php echo $lp->id ?>" <?php echo ($datos_usuario->id_provincias == $lp->id)?'SELECTED':'' ?> ><?php echo $lp->desc_provincias ?></option>
									<?php } ?>
								</select>
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
										<option value="<?php echo $lc->id ?>" <?php echo ($datos_usuario->id_ciudades == $lc->id)?'SELECTED':'' ?> ><?php echo $lc->desc_ciudades ?></option>
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
							<?php $fono1 = explode('-', $datos_usuario->fono ); ?>
							<div class="col-sm-2">
								<input type="text" id="fono1" name='fono1' value="<?php echo @$fono1[0] ?>" class="form-control" required>
							</div>
							<div class="col-sm-7">
								<input type="text" id="fono2" name='fono2' value="<?php echo @$fono1[1] ?>" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="fono3">
								Telefono
							</label>
							
							<div class="col-sm-2">
								<input type="text" id="fono3" name='fono3'  class="form-control">
							</div>
							<div class="col-sm-7">
								<input type="text" id="fono4" name='fono4' class="form-control">
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
										<option value="<?php echo $lc->id ?>" <?php echo ($datos_usuario->id_estadocivil == $lc->id)?'SELECTED':'' ?> ><?php echo $lc->desc_estadocivil ?></option>
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
									<option value="Haitiana" <?php echo ($datos_usuario->nacionalidad == "Haitiana")?'SELECTED':'' ?> > Haitiana </option>
									<option value="mexicana" <?php echo ($datos_usuario->nacionalidad == "mexicana")?'SELECTED':'' ?> > Mexicana </option>
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
				<div class="tab-pane fade" id="datos-imagen">
					<h2>Modificar imagen</h2>
					<p>
						Favor seleccione que tipo de imagen desea subir. La extencion de los archivos soportados son .png y .jpg, el tamaño maximo del archivo es de 2MB.
					</p>
					<form enctype="multipart/form-data" role="form" class="form-horizontal" action="<?php echo  base_url() ?>wood/trabajadores/guardar_imagen/<?php echo $id_usuario ?>" method="post" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="file">
								Imagen
							</label>
							<div class="col-sm-9">
								<input type="file" name="imagen" id="file" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
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
					<h2>Datos T&eacute;cnicos</h2>
					<form role="form" class="form-horizontal" action="<?php echo  base_url() ?>wood/trabajadores/guardar_tecnicos" method="post" >
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_estudios">
								Nivel de estudios
							</label>
							<div class="col-sm-9">
								<select name="select_estudios" id="select_estudios" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_estudios as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_estudios == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_nivelestudios ?></option>
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
								<select name="select_profesiones" id="select_profesiones" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_profesiones as $lp) { ?>
										<option value="<?php echo $lp->id ?>" <?php echo ($datos_usuario->id_profesiones == $lp->id)?'SELECTED':'' ?> ><?php echo $lp->desc_profesiones ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_especialidad1">
								Especialidad
							</label>
							<div class="col-sm-9">
								<select name="select_especialidad1" id="select_especialidad1" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_especialidades as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_especialidad_trabajador == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_especialidad ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_especialidad2">
								Especialidad
							</label>
							<div class="col-sm-9">
								<select name="select_especialidad2" id="select_especialidad2" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_especialidades as $le) { ?>
										<option value="<?php echo $le->id ?>" <?php echo ($datos_usuario->id_especialidad_trabajador_2 == $le->id)?'SELECTED':'' ?> ><?php echo $le->desc_especialidad ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="anos_experiencia">
								A&ntilde;os de experiencia
							</label>
							<div class="col-sm-9">
								<input type="text" id="anos_experiencia" name="anos_experiencia" value="<?php echo $datos_usuario->ano_experiencia ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="cursos">
								Cursos relevantes
							</label>
							<div class="col-sm-9">
								<textarea id="cursos" name="cursos" class="form-control"><?php echo $datos_usuario->cursos ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="equipos">
								Equipos que maneja
							</label>
							<div class="col-sm-9">
								<textarea id="equipos" name="equipos" class="form-control"><?php echo $datos_usuario->equipos ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="software">
								Software que maneja
							</label>
							<div class="col-sm-9">
								<textarea id="software" name="software" class="form-control"><?php echo $datos_usuario->software ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="idiomas">
								Idiomas
							</label>
							<div class="col-sm-9">
								<textarea id="idiomas" name="idiomas" class="form-control"><?php echo $datos_usuario->idiomas ?></textarea>
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
								<input type="text" id="n_cuenta" name="n_cuenta" value="<?php echo $datos_usuario->cuenta_banco ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_afp">
								AFP
							</label>
							<div class="col-sm-9">
								<select name="select_afp" id="select_afp" class="form-control">
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
								<select name="select_salud" id="select_salud" class="form-control">
									<option value="">Seleccione...</option>
									<?php foreach ($lista_salud as $ls) { ?>
										<option value="<?php echo $ls->id ?>" <?php echo ($datos_usuario->id_salud == $ls->id)?'SELECTED':'' ?> ><?php echo $ls->desc_salud ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="uf_pactada">
								Uf Pactada
							</label>
							<div class="col-sm-9">
								<input type="text" id="uf_pactada" name="uf_pactada" value="<?php echo $datos_usuario->uf_pactada ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="licencia">
								Licencia de conducir
							</label>
							<div class="col-sm-9">
								<input type="text" id="licencia" name="licencia" value="<?php echo $datos_usuario->licencia ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="n_zapato">
								N° de Zapato
							</label>
							<div class="col-sm-9">
								<input type="text" id="n_zapato" name="n_zapato" value="<?php echo $datos_usuario->num_zapato ?>" class="form-control">
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
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Editar Datos
								</button>
							</div>
						</div>
					</form>
					<h2>Subir un archivo al sistema</h2>
					<form enctype="multipart/form-data" action="<?php echo  base_url() ?>wood/trabajadores/guardar_archivo/<?php echo $id_usuario ?>" method="post" class="form-horizontal" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="select_archivo">
								Tipo de archivo
							</label>
							<div class="col-sm-9">
								<select name="select_archivo" id="select_archivo" required>
									<option value="">Seleccione el tipo de archivo...</option>
									<?php foreach ($lista_archivos as $la) { ?>
										<option value="<?php echo $la->id ?>"><?php echo $la->desc_tipoarchivo ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="documento">
								Documento
							</label>
							<div class="col-sm-9">
								<input type="file" name="documento" id="documento" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary">
								Subir Archivo
								</button>
							</div>
						</div>
					</form>
					<div>
						<h4>Documentos Subidos</h4>
						<?php if($lista_archivos_subidos){ ?>
						<table class="table">
						<?php foreach ($lista_archivos_subidos as $a) { ?>
							<tr>
								<td><?php echo $a->fecha ?></td>
								<td><?php echo $a->nombre ?></td>
								<td><?php echo $a->desc_tipoarchivo ?></td>
								<td>
									<a title="Descargar" href='<?php echo base_url().$a->url ?>' target='_blank'><i class="fa fa-download"></i></a> 
									&nbsp;&nbsp;
									<a title="Eliminar" class="eliminar" href="<?php echo base_url() ?>wood/trabajadores/eliminar_archivo/<?php echo $a->id_archivo ?>/<?php echo $id_usuario ?>"><i class="fa fa-trash-o"></i></a> 
								</td>
							</tr>
						<?php } ?>
						</table>
						<?php } else {?>
						No existen archivos para este usuario
						<?php } ?>
					</div>
				</div>
				<div class="tab-pane fade" id="datos-pass">
					<form action="<?php echo base_url() ?>wood/trabajadores/renovar_pass" method="post" class="form-horizontal" >
						<h2>Modificar contraseña</h2>
						<input type="hidden" name="id" value="<?php echo $id_usuario ?>" >
						<div class="form-group">
							<label class="col-sm-2 control-label" for="pass_nueva1">
								Nueva Contraseña
							</label>
							<div class="col-sm-9">
								<input type="password" name="pass_nueva1" id="pass_nueva1" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="pass_nueva2">
								Confirme Contraseña
							</label>
							<div class="col-sm-9">
								<input type="password" name="pass_nueva2" id="pass_nueva2" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
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
					<h2>Listado de experiencias</h2>
					<a data-toggle="modal" data-target="#ModalAgregarExperiencia" class="btn btn-primary dialog" href="#">Agregar</a>
					<?php
					 if(empty($lista_experiencia)){ ?>
					Aun no existen experiencias agregadas <br>
					<?php } else { ?>
					<table class="table">
						<thead>
							<th>Desde</th>
							<th>Hasta</th>
							<th>Cargo</th>
							<th>Area</th>
							<th>Empresa Contratista</th>
							<th>Empresa Mandante/Planta</th>
							<th>Principales Funciones</th>
							<th>Referencias</th>
						</thead>
						<tbody>
							<?php foreach ($lista_experiencia as $l) { ?>
								<tr>
									<td><?php echo $l->desde ?></td>
									<td><?php echo $l->hasta ?></td>
									<td><?php echo $l->cargo ?></td>
									<td><?php echo $l->area ?></td>
									<td><?php echo $l->empresa_c ?></td>
									<td><?php echo $l->empresa_m ?></td>
									<td><?php echo $l->funciones ?></td>
									<td><?php echo $l->referencias ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php } ?>
					<br><br><br><br>
				</div>
				<div class="tab-pane fade" id="datos-examenes">
					<h3>Listado de Examenes de <b><?php echo ucwords(mb_strtolower($nombre,'UTF-8')); ?></b></h3>
					
					<a data-toggle="modal" data-target="#ModalAgregarConocimiento" style="margin-left:10px;" class="btn btn-blue pull-right" href="#">Examen Conocimiento</a>
					<a data-toggle="modal" data-target="#ModalAgregarDesempeño" style="margin-left:10px;" class="btn btn-blue pull-right" href="#">Desempeño</a>
					<a class="btn btn-blue pull-right" style="margin-left:10px;" href="<?php echo base_url() ?>wood/trabajadores/crear_examen/<?php echo $id ?>">Nuevo Examen</a>
					<a class="btn btn-blue pull-right" href="<?php echo base_url() ?>wood/trabajadores/crear_masso/<?php echo $id ?>">Nuevo Masso</a>
					<table class='table'>
						<thead>
							<th>Tipo Examen</th>
							<th>Nombre Evaluaci&oacute;n</th>
							<th>Fecha Evaluaci&oacute;n</th>
							<th>Fecha Vigencia</th>
							<th>Calificaci&oacute;n</th>
							<th>Observaci&oacute;n</th>
							<th>Valor</th>
							<th>Archivo</th>
							<th>#</th>
						</thead>
						<tbody>
							<?php foreach ($listado as $l) { ?>
								<tr>
									<td><?php echo $l->nombre_tipo; ?></td>
									<td><?php echo $l->nombre_eval; ?></td>
									<td>
										<?php if($l->fecha_e) { $f_e = explode('-',$l->fecha_e); $f_e = $f_e[2].'-'.$f_e[1].'-'.$f_e[0]; } ?>
										<?php echo ($l->fecha_e) ? $f_e : '-' ; ?>
									</td>
									<td>
										<?php if($l->fecha_v) { $f_v = explode('-',$l->fecha_v); $f_v = $f_v[2].'-'.$f_v[1].'-'.$f_v[0]; } ?>
										<?php echo ($l->fecha_v) ? $f_v : '-' ; ?>
									</td>
									<td>
										<?php
											if($l->tipo_resultado == 2){
												if($l->asistencia_examen == 0 and $l->resultado == 2)
													echo "No Asiste";
												else
													echo ($l->resultado == 1) ? 'Rechazado' : 'Aprobado';
											}else{
												echo $l->resultado;
											}
										?>
									</td>
									<td><?php echo $l->observaciones; ?></td>
									<td class="center"><?php echo $l->valor_examen; ?></td>
									<td class="center">
										<?php $href = (isset($l->url)) ? base_url().$l->url : '#'; ?>
										<?php $color = (isset($l->url)) ? "color:green":"color:red"; ?>
										<a target='_blank' href='<?php echo $href; ?>' style='<?php echo $color; ?>' ><i class='fa fa-download'></i></a>
									</td>
									<td class="center" style="width:66px;">
										<?php 
											if($this->session->userdata('id') == 39 || $this->session->userdata('tipo_usuario')==8 || $this->session->userdata('id') == 99 || $this->session->userdata('id') == 10){
										?>
										<div class="visible-md visible-lg hidden-sm hidden-xs">
											<a href="<?php echo base_url() ?>wood/trabajadores/eliminar_examen/<?php echo $id ?>/<?php echo $l->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-id="<?php echo $l->id ?>" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
											<?php if($l->id_tipo == 1){ ?>
                  							<a data-toggle="modal" href="<?php echo base_url() ?>wood/trabajadores/modal_editar_desempeno/<?php echo $l->id ?>/<?php echo $id ?>" class="btn btn-xs btn-blue pull-right editar" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>
											<?php }elseif($l->id_tipo == 3){ ?>
                  							<a data-toggle="modal" href="<?php echo base_url() ?>wood/trabajadores/modal_editar_conocimiento/<?php echo $l->id ?>/<?php echo $id ?>" class="btn btn-xs btn-blue pull-right editar" data-target="#ModalEditar"><i class="fa fa-edit"></i></a>
											<?php }else{ ?>
											<a href="<?php echo ($l->id_tipo == 4)? base_url().'wood/trabajadores/crear_masso/'.$id.'/'.$l->id : base_url().'wood/trabajadores/crear_examen/'.$id.'/'.$l->id; ?>" class="btn btn-xs btn-blue pull-right editar" data-original-title="Editar"><i class="fa fa-edit"></i></a>
											<?php } ?>
										</div>
									<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<br><br><br><br>
				</div>
			</div>
		</div>
	<?php }else{
			echo "Usted no tiene permiso para realizar acciones en esta sesion!!!";
		}
	?>
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

<!-- Modal Agregar Desempeño-->
<div class="modal fade" id="ModalAgregarDesempeño" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Registro de Nuevo Examen de Desempeño</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>wood/trabajadores/guardar_exam_desempeno" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="control-group">
            	<label class="control-label" for="id_tipo_eval">Tipo de Examen de Desempeño</label>
              	<div class="controls">
	                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id ?>"/>
	                <select name="id_tipo_eval" id="id_tipo_eval" style="width:260px" required>
	                	<option value="">[Seleccione]</option>
	                	<?php foreach ($exam_desempeno as $key1) {	?>
	                	<option value="<?php echo $key1->id ?>"><?php echo $key1->nombre ?></option>
	                	<?php }	?>
	                </select>
               	</div>
            </div>
            <div class="control-group">
              <label class="control-label" for="fecha_eval_d">Fecha Evaluacion</label>
              	<div class="controls">
              		<select name="fecha_eval_d" id="fecha_eval_d" style="width:60px" required>
	                	<option value="">DD</option>
	                	<?php for ($i=1; $i < 32 ; $i++) { ?>
	                	<option value="<?php echo $i ?>"><?php echo $i ?></option>
	                	<?php }	?>
	                </select>
	                <select name="fecha_eval_m" id="fecha_eval_m" style="width:110px" required>
	                	<option value="">MM</option>
	                	<option value="1">Enero</option>
	                	<option value="2">Febrero</option>
	                	<option value="3">Marzo</option>
	                	<option value="4">Abril</option>
	                	<option value="5">Mayo</option>
	                	<option value="6">Junio</option>
	                	<option value="7">Julio</option>
	                	<option value="8">Agosto</option>
	                	<option value="9">Septiembre</option>
	                	<option value="10">Octubre</option>
	                	<option value="11">Noviembre</option>
	                	<option value="12">Diciembre</option>
	                </select>
	                <select name="fecha_eval_a" id="fecha_eval_a" style="width:70px" required>
	                	<option value="">AAAA</option>
	                	<?php 
		                	$a_inicio = (date('Y') - 6);
		                	$a_fin = (date('Y') + 6);
		                	for ($k=$a_inicio; $k < $a_fin ; $k++){
		                ?>
		                	<option value="<?php echo $k ?>"><?php echo $k ?></option>
		                <?php }	?>
	                </select>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="fecha_vig_d">Fecha Vigencia</label>
              	<div class="controls">
              		<select name="fecha_vig_d" id="fecha_vig_d" style="width:60px">
	                	<option value="00">DD</option>
	                	<?php for ($i=1; $i < 32 ; $i++) { ?>
	                	<option value="<?php echo $i ?>"><?php echo $i ?></option>
	                	<?php }	?>
	                </select>
	                <select name="fecha_vig_m" id="fecha_vig_m" style="width:110px">
	                	<option value="00">MM</option>
	                	<option value="1">Enero</option>
	                	<option value="2">Febrero</option>
	                	<option value="3">Marzo</option>
	                	<option value="4">Abril</option>
	                	<option value="5">Mayo</option>
	                	<option value="6">Junio</option>
	                	<option value="7">Julio</option>
	                	<option value="8">Agosto</option>
	                	<option value="9">Septiembre</option>
	                	<option value="10">Octubre</option>
	                	<option value="11">Noviembre</option>
	                	<option value="12">Diciembre</option>
	                </select>
	                <select name="fecha_vig_a" id="fecha_vig_a" style="width:70px">
	                	<option value="0000">AAAA</option>
	                	<?php 
		                	$a_inicio = (date('Y') - 6);
		                	$a_fin = (date('Y') + 6);
		                	for ($k=$a_inicio; $k < $a_fin ; $k++){
		                ?>
		                	<option value="<?php echo $k ?>"><?php echo $k ?></option>
		                <?php }	?>
	                </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          	<div class="control-group">
              <label class="control-label" for="documento">Archivo</label>
              	<div class="controls">
              		<input type="file" name="documento" id="documento" required>
            	</div>
            </div>
            <div class="control-group">
              <label class="control-label" for="resultado">Resultado</label>
              <div class="controls">
                <input type="text" name="resultado" id="resultado" onkeypress='return valida1al7(event)' maxlength="4" placeholder="1-7"  required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="observacion">Observaciones</label>
                <div class="controls">
                	<textarea name="observacion" id="observacion"></textarea>
	            </div>
            </div>
          </div><br><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Conocimiento-->
<div class="modal fade" id="ModalAgregarConocimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Registro de Nuevo Examen de Conocimiento</h2>
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url() ?>wood/trabajadores/guardar_exam_conocimientos" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="control-group">
            	<label class="control-label" for="id_tipo_eval">Tipo de Examen de Conocimiento</label>
              	<div class="controls">
	                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id ?>" size="1"/>
	                <select name="id_tipo_eval" id="id_tipo_eval" style="width:260px" required>
	                	<option value="">[Seleccione]</option>
	                	<?php foreach ($exam_conocimientos as $key2) {	?>
	                	<option value="<?php echo $key2->id ?>"><?php echo $key2->nombre ?></option>
	                	<?php }	?>
	                </select>
               	</div>
            </div>
            <div class="control-group">
              <label class="control-label" for="fecha_eval_d">Fecha Evaluacion</label>
              <div class="controls">
              		<select name="fecha_eval_d" id="fecha_eval_d" style="width:60px" required>
	                	<option value="">DD</option>
	                	<?php for ($i=1; $i < 32 ; $i++) { ?>
	                	<option value="<?php echo $i ?>"><?php echo $i ?></option>
	                	<?php }	?>
	                </select>
	                <select name="fecha_eval_m" id="fecha_eval_m" style="width:110px" required>
	                	<option value="">MM</option>
	                	<option value="1">Enero</option>
	                	<option value="2">Febrero</option>
	                	<option value="3">Marzo</option>
	                	<option value="4">Abril</option>
	                	<option value="5">Mayo</option>
	                	<option value="6">Junio</option>
	                	<option value="7">Julio</option>
	                	<option value="8">Agosto</option>
	                	<option value="9">Septiembre</option>
	                	<option value="10">Octubre</option>
	                	<option value="11">Noviembre</option>
	                	<option value="12">Diciembre</option>
	                </select>
	                <select name="fecha_eval_a" id="fecha_eval_a" style="width:70px" required>
	                	<option value="">AAAA</option>
	                	<?php 
		                	$a_inicio = (date('Y') - 6);
		                	$a_fin = (date('Y') + 6);
		                	for ($k=$a_inicio; $k < $a_fin ; $k++){
		                ?>
		                	<option value="<?php echo $k ?>"><?php echo $k ?></option>
		                <?php }	?>
	                </select>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="fecha_vig_d">Fecha Vigencia</label>
              	<div class="controls">
              		<select name="fecha_vig_d" id="fecha_vig_d" style="width:60px">
	                	<option value="00">DD</option>
	                	<?php for ($i=1; $i < 32 ; $i++) { ?>
	                	<option value="<?php echo $i ?>"><?php echo $i ?></option>
	                	<?php }	?>
	                </select>
	                <select name="fecha_vig_m" id="fecha_vig_m" style="width:110px">
	                	<option value="00">MM</option>
	                	<option value="1">Enero</option>
	                	<option value="2">Febrero</option>
	                	<option value="3">Marzo</option>
	                	<option value="4">Abril</option>
	                	<option value="5">Mayo</option>
	                	<option value="6">Junio</option>
	                	<option value="7">Julio</option>
	                	<option value="8">Agosto</option>
	                	<option value="9">Septiembre</option>
	                	<option value="10">Octubre</option>
	                	<option value="11">Noviembre</option>
	                	<option value="12">Diciembre</option>
	                </select>
	                <select name="fecha_vig_a" id="fecha_vig_a" style="width:70px">
	                	<option value="0000">AAAA</option>
	                	<?php 
		                	$a_inicio = (date('Y') - 6);
		                	$a_fin = (date('Y') + 6);
		                	for ($k=$a_inicio; $k < $a_fin ; $k++){
		                ?>
		                	<option value="<?php echo $k ?>"><?php echo $k ?></option>
		                <?php }	?>
	                </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          	<div class="control-group">
              <label class="control-label" for="documento">Archivo</label>
              	<div class="controls">
              		<input type="file" name="documento" id="documento" required>
            	</div>
            </div>
            <div class="control-group">
              <label class="control-label" for="resultado">Resultado</label>
              <div class="controls">
                <input type="text" name="resultado" id="resultado" onkeypress='return valida1al7(event)' maxlength="4" placeholder="1-7"  required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="observacion">Observaciones</label>
                <div class="controls">
                	<textarea name="observacion" id="observacion"></textarea>
	            </div>
            </div>
          </div>
          <br><br><br><br><br><br><br><br><br><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

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
        <form action="<?php echo base_url() ?>wood/trabajadores/guardar_experiencia" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="desde">Desde</label>
              <div class="controls">
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id ?>" size="1"/>
                <input type='text' class="input-mini" name="desde" id="desde" onkeypress='return validafecha(event)' maxlength="10" placeholder="1999-12-31" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="hasta">Hasta</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="hasta" id="hasta" onkeypress='return validafecha(event)' maxlength="10" placeholder="1999-12-31" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="cargo">Cargo</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="cargo" id="cargo" onkeypress='return valida_abecedario(event)' placeholder="Cargo" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="area">Area</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="area" id="area" onkeypress='return valida_abecedario(event)' placeholder="Area" required/>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="empresa_c">Empresa Contratista</label>
              <div class="controls">
                <input type="text" name="empresa_c" id="empresa_c" onkeypress='return valida_abecedario(event)' placeholder="Empresa Contratista"  required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="empresa_m">Empresa Mandante/Planta</label>
                <div class="controls">
	                <input type="text" name="empresa_m" id="empresa_m" onkeypress='return valida_abecedario(event)' placeholder="Empresa Mandante"  required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="funciones">Principales Funciones</label>
                <div class="controls">
                	<input type="text" name="funciones" id="funciones" onkeypress='return valida_abecedario(event)' placeholder="Principales Funciones"  required>
				</div>
            </div>
            <div class="control-group">
              <label class="control-label" for="referencias">Referencias</label>
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