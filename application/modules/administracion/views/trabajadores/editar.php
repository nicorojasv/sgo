<script src="<?php echo base_url() ?>extras/js/jquery.simplemodal.1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/administracion/jquery.Rut.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/editar_perfil.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>extras/js/administracion/editar_trabajador.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/qtip/jquery.qtip.min.js" type="text/javascript"></script>


<div class="grid grid_6">
	<div class="tabs-side">
        <ul class="tab-nav">
            <li class="current">
                <a href="#datos-personales">
                	Datos Personales
                	<span>datos basicos</span>	   
                	                     
            	</a>
            </li>
            <li class="">
                <a href="#datos-imagen">
                	Imagen
                	<span>ella se mostrara en el perfil</span>	   
                	                     
            	</a>
            </li>
            <li class="">
                <a href="#datos-tecnicos">
                	Datos Tecnicos
                	<span>profesión, especialidad, etc</span>	                        	
            	</a>
            </li>
            <li class="">
                <a href="#datos-extras">
                	Datos Extras
                	<span>banco, afp, licencia, etc</span>	                        	
            	</a>
            </li>
			<li class="">
                <a href="#datos-pass">
                	Cambiar contraseña
                	<span>acceso al sistema</span>	                        	
            	</a>
            </li>
            <li class="">
                <a href="#datos-archivo">
                	Subir archivos
                	<span>certificados, curriculums, etc</span>
            	</a>
            </li>
            <li class="">
                <a href="#datos-experiencia">
                	Experiencia
                	<span>editar y agregar experiencia</span>	                        	
            	</a>
            </li>
        </ul>
    </div>
</div>
<div class="grid grid_18">
	<div title="#datos-personales" class="contenido-tab">
		<form action="<?php echo base_url() ?>administracion/trabajadores/guardar_personales/<?php echo $usuario->id ?>" method="post" class="form">
			<h2>Datos Personales</h2>
			<?php echo @$aviso_personal; ?>
			<div class="field input">
				<label>RUT:</label>
				<div class="fields">
					<input type="text" name="field" value="<?php echo $usuario->rut_usuario; ?>" id="input_rut" size="22" disabled="true" >
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nombres: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="nombres" value="<?php echo $usuario->nombres; ?>" id="input_nombres" size="39">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Apellidos: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="paterno" value="<?php echo $usuario->paterno; ?>" id="input_paterno" size="15" style="width: 120px;">
					&nbsp;&nbsp;
					<input type="text" name="materno" value="<?php echo $usuario->materno; ?>" id="input_materno" size="15" style="width: 120px;">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Fecha nacimiento: <span class="required">*</span></label>
				<div class="fields">
					<?php if(!empty($usuario->fecha_nac)){ ?>
					<?php $fecha = explode("-",$usuario->fecha_nac); ?>
					<?php $dia = $fecha[2]; ?>
					<?php $mes = $fecha[1]; ?>
					<?php $ano = $fecha[0]; ?>
					<?php }else{
						$dia = 0;
						$mes = 0;
						$ano = 0;
					} ?>
					
					<select name="select_nac_dia" id="select_nac_dia" style="width: 55px">
						<option value="">Dia</option>
						<?php for($d=1;$d<=31;$d++){ ?>
						<option <?php echo ($dia == $d) ? "selected='true'" : ''; ?> ><?php echo $d; ?></option>
						<?php } ?>
					</select>
					<select name="select_nac_mes" id="select_nac_mes" style="width: 90px">
						<option value="">Mes</option>
						<?php for($m=0;$m<=11;$m++){ ?>
						<option value="<?php echo $m+1; ?>" <?php echo ($mes == $m+1) ? "selected='true'" : ''; ?>><?php echo $meses[$m]; ?></option>
						<?php } ?>
					</select>
					<select name="select_nac_ano" id="select_nac_ano" style="width: 68px">
						<option value="">Año</option>
						<?php for($a=1936;$a<=2000;$a++){ ?>
						<option <?php echo ($ano == $a) ? "selected='true'" : ''; ?>><?php echo $a; ?></option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Región: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_region" id="select_region">
						<option value="">Seleccione una región...</option>
						<?php foreach ($regiones as $rg) { ?>
						<option value="<?php echo $rg->id ?>" <?php echo ($usuario->id_regiones == $rg->id) ? "selected='true' ": '' ?> > <?php echo $rg->desc_regiones ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Provincia: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_provincia" id="select_provincia">
						<option value="">Seleccione una provincia...</option>
						<?php foreach($provincias as $p){ ?>
						<option value="<?php echo $p->id ?>" <?php echo ($usuario->id_provincias == $p->id) ? "selected='true' ": '' ?> > <?php echo $p->desc_provincias ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Ciudad: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_ciudad" id="select_ciudad">
						<option value="">Seleccione una ciudad...</option>
						<?php foreach($ciudades as $c){ ?>
						<option value="<?php echo $c->id ?>" <?php echo ($usuario->id_ciudades == $c->id) ? "selected='true' ": '' ?> > <?php echo $c->desc_ciudades ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Dirección: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="direccion" value="<?php echo $usuario->direccion; ?>" id="input_direccion" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Sexo: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_sexo" id="select_sexo">
						<option value="">Seleccione...</option>
						<option value="0" <?php echo ($usuario->sexo == 0) ? "selected='true' ": ''; ?>>Masculino</option>
						<option value="1" <?php echo ($usuario->sexo == 1) ? "selected='true' ": ''; ?>>Femenino</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Telefono: <span class="required">*</span></label>
				<div class="fields">
					<?php if(isset($usuario->fono)){ ?>
					<?php $fono = explode("-",$usuario->fono); ?>
					<?php $fono1 = $fono[0]; $fono2 = $fono[1]; ?>
					<?php } ?>
					<input type="text" name="fono_1" value="<?php echo @$fono1; ?>" id="phone1" size="2" style="width:20px" >
					-
					<input type="text" name="fono_2" value="<?php echo @$fono2; ?>" id="phone2" size="19" style="width:166px;">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Telefono:</label>
				<div class="fields">
					<?php if(isset($usuario->telefono2)){ ?>
					<?php $telefono = explode("-",$usuario->telefono2); ?>
					<?php $telefono1 = $telefono[0]; $telefono2 = $telefono[1]; ?>
					<?php } ?>
					<input type="text" name="fono_3" value="<?php echo @$telefono1; ?>" id="phone3" size="2" style="width:20px;">
					-
					<input type="text" name="fono_4" value="<?php echo @$telefono2; ?>" id="phone4" size="19" style="width:166px;">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Email:</label>
				<div class="fields">
					<input type="text" name="email" value="<?php echo $usuario->email; ?>" id="fname" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Estado civil: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_civil" id="select_civil">
						<option value="">Seleccione...</option>
						<?php foreach ($civil as $c) { ?>
						<option value="<?php echo $c->id ?>" <?php echo ($usuario->id_estadocivil == $c->id) ? "selected='true' ": ''; ?>> <?php echo $c->desc_estadocivil ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Nacionalidad: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_nacionalidad" id="select_nacionalidad">
						<option value="">Seleccione... </option>
						<option value="chilena" <?php echo ($usuario->nacionalidad == "chilena") ? "selected='true'" : ''; ?> >Chilena </option>
						<option value="extranjera" <?php echo ($usuario->nacionalidad == "extranjera") ? "selected='true'" : ''; ?>>Extranjera </option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar mis datos
				</button>
			</div>
			<!-- .actions -->
		</form>
		</div>
		<div title="#datos-tecnicos"  class="contenido-tab">
			<form action="<?php echo base_url() ?>administracion/trabajadores/guardar_tecnicos/<?php echo $usuario->id ?>" method="post" class="form">
			<h2>Datos Tecnicos</h2>
			<?php echo @$aviso_tecnico; ?>
			<div class="field select">
				<label>Nivel de estudios: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_nivelestudios" id="select_nivelestudios" class="cortar_select">
						<option value="">Seleccione un nivel...</option>
						<?php foreach ($lvl_estudios as $lvl) { ?>
						<option value="<?php echo $lvl->id ?>" <?php echo ($lvl->id == $usuario->id_estudios)? "selected='true'" :''; ?> > <?php echo $lvl->desc_nivelestudios ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nombre institución:<span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="nb_institucion" value="<?php echo ucwords(mb_strtolower($usuario->institucion, 'UTF-8')); ?>" id="input_intitucion" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Año egreso: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="ano_egreso" value="<?php echo $usuario->ano_egreso; ?>" id="input_egreso" size="5">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Titulo/Profesion: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_profesion" id="select_profesion" class="cortar_select">
						<option value="">Seleccione...</option>
						<?php foreach ($profesiones as $p) { ?>
						<option value="<?php echo $p->id ?>" <?php echo ($p->id == $usuario->id_profesiones)? "selected='true'" :''; ?> > <?php echo $p->desc_profesiones ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Especialidad: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_especialidad1" id="select_especialidad1">
						<option value="">Seleccione especialidad...</option>
						<?php foreach ($esp_trab as $et) { ?>
						<option value="<?php echo $et->id ?>" <?php echo ($et->id == $usuario->id_especialidad_trabajador)? "selected='true'" :''; ?> > <?php echo $et->desc_especialidad ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Especialidad:</label>
				<div class="fields">
					<select name="select_especialidad2" id="select_especialidad2">
						<option value="">Seleccione especialidad...</option>
						<?php foreach ($esp_trab as $et) { ?>
						<option value="<?php echo $et->id ?>" <?php echo ($et->id == $usuario->id_especialidad_trabajador_2)? "selected='true'" :''; ?> > <?php echo $et->desc_especialidad ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Años experiencia: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="ano_experiencia" value="<?php echo $usuario->ano_experiencia; ?>" id="input_experiencia" size="5">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Cursos relevantes:</label>
				<div class="fields">
					<textarea name="cursos" style="width: 540px;height:160px"><?php echo $usuario->cursos; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Equipos que maneja:</label>
				<div class="fields">
					<textarea name="equipos" style="width: 540px;height:160px"><?php echo $usuario->equipos; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Software que maneja:</label>
				<div class="fields">
					<textarea name="software" style="width: 540px;height:160px"><?php echo $usuario->software; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Idiomas:</label>
				<div class="fields">
					<textarea name="idiomas" style="width: 540px;height:160px"><?php echo $usuario->idiomas; ?></textarea>
				</div> <!-- .fields -->
			</div>
			<!-- .field -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar mis datos
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
	<div title="#datos-extras"  class="contenido-tab">
		<form action="<?php echo base_url() ?>administracion/trabajadores/guardar_extras/<?php echo $usuario->id ?>" method="post" class="form">
			<h2>Datos Extras</h2>
			<?php echo @$aviso_extra; ?>
			<div class="field select">
				<label>Banco:</label>
				<div class="fields">
					<select name="select_banco" id="select_banco">
						<option value="">Seleccione un banco...</option>
						<?php foreach ($bancos as $b) { ?>
						<option value="<?php echo $b->id ?>" <?php echo ($b->id == $usuario->id_bancos) ? "selected='true'" :''; ?> > <?php echo $b->desc_bancos ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Tipo de cuenta:</label>
				<div class="fields">
					<input type="text" name="tipo_cuenta" value="<?php echo $usuario->tipo_cuenta ?>" id="fname" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nº de cuenta:</label>
				<div class="fields">
					<input type="text" name="n_cuenta" value="<?php echo $usuario->cuenta_banco ?>" id="n_cuenta" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>AFP: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_afp" id="select_afp">
						<option value="">Seleccione una afp...</option>
						<?php foreach ($afp as $a) { ?>
						<option value="<?php echo $a->id ?>" <?php echo ($a->id == $usuario->id_afp)? "selected='true'" :''; ?> > <?php echo $a->desc_afp ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select excajas" <?php if(!$usuario->id_excajas){ ?> style="display: none;" <?php } ?> >
				<label>IPS - EX CAJA: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_excaja" id="select_excaja">
						<option value="">Seleccione...</option>
						<?php foreach ($excajas as $ex) { ?>
						<option value="<?php echo $ex->id ?>" <?php echo ($ex->id == $usuario->id_excajas)? "selected='true'" :''; ?> > <?php echo $ex->desc_excaja ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Sistema de salud: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_salud" id="select_salud">
						<option value="">Seleccione un sistema de salud...</option>
						<?php foreach ($salud as $s) { ?>
						<option value="<?php echo $s->id ?>" <?php echo ($s->id == $usuario->id_salud)? "selected='true'" :''; ?> > <?php echo $s->desc_salud ?> </option>
						<?php } ?>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Licencia conducir:</label>
				<div class="fields">
					<input type="text" name="licencia" maxlength="2" value="<?php echo $usuario->licencia ?>" id="fname" size="5">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Nº zapato: <span class="required">*</span></label>
				<div class="fields">
					<input type="text" name="zapato" value="<?php echo $usuario->num_zapato ?>" id="fname" size="14">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field select">
				<label>Talla de buzo: <span class="required">*</span></label>
				<div class="fields">
					<select name="select_talla" id="select_talla">
						<option value="">Selecione...</option>
						<option <?php echo ($usuario->talla_buzo == 'S')? "selected='true'" :''; ?> >S</option>
						<option <?php echo ($usuario->talla_buzo == 'M')? "selected='true'" :''; ?> >M</option>
						<option <?php echo ($usuario->talla_buzo == 'L')? "selected='true'" :''; ?> >L</option>
						<option <?php echo ($usuario->talla_buzo == 'XL')? "selected='true'" :''; ?> >XL</option>
						<option <?php echo ($usuario->talla_buzo == 'XXL')? "selected='true'" :''; ?> >XXL</option>
						<option <?php echo ($usuario->talla_buzo == 'XXXL')? "selected='true'" :''; ?> >XXXL</option>
					</select>
				</div>
				<!-- .fields -->
			</div>
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar mis datos
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
	<div title="#datos-imagen" class="contenido-tab">
		<form enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/trabajadores/guardar_imagen/<?php echo $usuario->id ?>" method="post" class="form">
			<h2>Modificar imagen</h2>
			<?php echo @$aviso_imagen; ?>
			<p>Favor seleccione que tipo de imagen desea subir. La extencion de los archivos soportados son .png y .jpg, el tamaño maximo del archivo es de 2MB.</p>
			<!-- .fields -->
			<div class="field file">
				<label>Imagen:</label>
				<div class="fields">
					<input type="file" name="imagen" id="file">
				</div>
				<!-- .fields -->
			</div>
			<!-- .fields -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar imagen
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
	<div title="#datos-pass" class="contenido-tab">
		<form action="<?php echo base_url() ?>administracion/trabajadores/cambiar_contrasena/<?php echo $usuario->id ?>" method="post" class="form">
			<h2>Modificar contraseña</h2>
			<?php echo @$aviso_pass; ?>
			<!-- .field -->
			<div class="field input">
				<label>Nueva contraseña:</label>
				<div class="fields">
					<input type="password" name="pass_nueva1" value="" id="fname" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="field input">
				<label>Repetir contraseña:</label>
				<div class="fields">
					<input type="password" name="pass_nueva2" value="" id="fname" size="29">
				</div>
				<!-- .fields -->
			</div>
			<!-- .field -->
			<div class="actions">
				<button type="submit" class="btn primary">
					Editar contraseña
				</button>
			</div>
			<!-- .actions -->
		</form>
	</div>
	<div title="#datos-archivo" class="contenido-tab">
		<?php echo @$aviso_archivo; ?>
		<h2>Subir un archivo al sistema</h2>
	<p>
		Favor seleccione que <b>tipo de archivo</b> desea subir. La extencion de los archivos soportados son <b>Word (.doc) y Pdf (.pdf)</b>, el <b>tamaño maximo</b> de cada 
		archivo es de <b>5MB</b>. Usted puede ingresar un <strong>maximo</strong> de 7 archivos.
	</p>
	<!--<p>
		<a href="#modal" class="dialog">Ver archivos adjuntados</a>
	</p>-->
	<form enctype="multipart/form-data" action="<?php echo base_url() ?>administracion/trabajadores/guardar_archivo/<?php echo $usuario->id ?>" method="post" class="form">
		<div class="field select">
			<label>Tipo de archivo:</label>
			<div class="fields">
				<select name="select_archivo" id="select_archivo">
					<option value="">Seleccione el tipo de archivo...</option>
					<?php foreach($listado_tipo as $lt){ ?>
					<option value="<?php echo $lt->id; ?>"><?php echo $lt->desc_tipoarchivo; ?></option>
					<?php } ?>
				</select>
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="field file">
			<label>Documento:</label>
			<div class="fields">
				<input type="file" name="documento" id="documento">
			</div>
			<!-- .fields -->
		</div>
		<!-- .field -->
		<div class="actions">
			<button type="submit" class="btn primary">
				Subir archivo
			</button>
		</div>
		<!-- .actions -->
	</form>
	<table class="data display">
			<?php foreach($listado_archivo as $la){ ?>
			<tr>
				<td><b><?php echo $la->nb_tipo; ?></b></td>
				<td><a target="_blank" href="<?php echo base_url().$la->url; ?>"><?php echo $la->nb_archivo; ?></a></td>
				<td>
					<a href="<?php echo base_url() ?>administracion/trabajadores/eliminar_archivo/<?php echo $usuario->id; ?>/<?php echo $la->id; ?>" onclick="return confirm('¿Está seguro?');" title="Eliminar">
						<i class="icon-trash"></i>
					</a>
				</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<div title="#datos-experiencia" class="contenido-tab">
		<h2>Listado de experiencias</h2>
		<?php if( count($experiencia) > 0 ){ ?>
			
			<a class="btn btn-primary dialog" href="<?php echo base_url() ?>administracion/trabajadores/ajax_modal_experiencia/<?php echo $usuario->id ?>" >Agregar</a>&nbsp;
			<a class="btn btn-info" id="editar_exp" href="<?php echo base_url() ?>administracion/trabajadores/ajax_modal_experiencia/<?php echo $usuario->id ?>">Editar</a>&nbsp;
			<a class="btn btn-danger" id="eliminar_exp" href="<?php echo base_url() ?>administracion/trabajadores/eliminar_experiencia/<?php echo $usuario->id ?>/">Eliminar</a>
		<table class="data display" style="margin-top: 5px;">
			<thead>
				<tr>
					<th>#</th>
					<th>Desde</th>
					<th>Hasta</th>
					<th>Cargo</th>
					<th>Area</th>
					<th>Empresa contratista</th>
					<th>Empresa mandante/planta</th>
					<th>Principales funciones</th>
					<th>Referencias</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($experiencia as $ex) { ?>
				<tr class="odd gradeX">
					<td><input type="radio" value="<?php echo $ex->id ?>" name="radio_experiencia" /></td>
					<?php $f_desde = explode("-", $ex->desde) ?>
					<td><?php echo $f_desde[2].'-'.$f_desde[1].'-'.$f_desde[0] ?></td>
					<?php $f_hasta = explode("-", $ex->hasta) ?>
					<td><?php echo $f_hasta[2].'-'.$f_hasta[1].'-'.$f_hasta[0] ?></td>
					<td><?php echo $ex->cargo ?></td>
					<td><?php echo $ex->area ?></td>
					<td><?php echo $ex->empresa_c ?></td>
					<td><?php echo $ex->empresa_m ?></td>
					<td>
					<?php $funciones = explode(";", $ex->funciones); ?>
					<?php for($i=0;$i<(count($funciones)-1);$i++){
						echo ucwords(strtolower($funciones[$i]));
						if($i < (count($funciones)-2)) echo ", ";
					} ?>
					</td>
					<td>
					<?php $referencia = explode(";", $ex->referencias); ?>
					<?php for($i=0;$i<(count($referencia)-1);$i++){
						echo ucwords(strtolower($referencia[$i]));
						if($i < (count($referencia)-2)) echo ", ";
					} ?>
					</td>
					<!-- <td class="center"><a class="dialog" href="<?php echo base_url()?>mandante/areas/html_editar/areas/<?php echo $ex->id ?>">editar</a></td>
					<td class="center"><a class="eliminar ajax" href="<?php echo base_url() ?>trabajador/experiencia/eliminar/<?php echo $ex->id ?>">eliminar</a></td> -->
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } else{ ?>
			Aun no existen experiencias agregadas <br/>
			<a class="btn btn-primary dialog" href="<?php echo base_url() ?>administracion/trabajadores/ajax_modal_experiencia/<?php echo $usuario->id ?>" >Agregar</a>&nbsp;
		<?php } ?>
	</div>
</div>
<!-- <div class="grid grid_7">
	<a href="<?php echo base_url() ?>trabajador/perfil" class="btn xlarge secondary dashboard_add"><span></span>Perfil</a>
	<a href="<?php echo base_url() ?>trabajador/perfil/editar" class="btn xlarge primary dashboard_add">Editar Perfil</a>
	<a href="<?php echo base_url() ?>trabajador/perfil/cambiar_contrasena" class="btn xlarge tertiary dashboard_add">Cambiar Contraseña</a>
</div> -->
<!-- MODAL PARA ARCHIVOS ADJUNTADOS DEL USUARIO -->
<div id="modal" style="display: none">
	<div class="closeClass"></div>
	<div id="modal_header">
		<h3>Archivos adjuntados</h3>
	</div>
	<div id="modal_content">
		<div style="width: 590px;">
			<?php if(count($listado_archivos) > 0){ ?>
			<table class="data display">
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Nombre</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($listado_archivos as $l){ ?>
					<tr class="odd gradeX">
						<td><?php echo ucfirst(mb_strtolower($l->desc_tipoarchivo,'UTF-8')) ?></td>
						<td><?php echo ucfirst(mb_strtolower($l->nombre,'UTF-8')) ?></td>
						<td><a href="<?php echo base_url() ?>administracion/trabajadores/eliminar_archivo/<?php echo $usuario->id .'/'. $l->id_archivo ?>" class="eliminar_archivo">eliminar</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php } else{ ?>
				<p>No existen archivos adjuntados</p>
			<?php } ?>
		</div>
	</div>
</div>
<!-- -->