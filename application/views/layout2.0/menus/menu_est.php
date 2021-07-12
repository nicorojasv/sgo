<li>
	<a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a>
</li>
<li>
	<a href="<?php echo base_url() ?>abastecimiento"><i class="fa fa-user"></i> <span class="title"> Abastecimiento </span></a>
</li>

<?php 
	if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 3 or $this->session->userdata('id') == 5){ 
?>
		<li>
			<a href="<?php echo base_url() ?>abastecimiento/asignar"><i class="fa fa-user"></i> <span class="title"> Asignación Abastecimiento </span></a>
		</li>
<?php 
	} 
?>

<?php 
	if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 39){ 
?>
		<!-- Recepcion solicitudes de revision de examenes -->
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Analista) </span></a>
			<ul class="sub-menu">
				<li>
					<a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li>
					<a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>
<?php 
	} 
?>

<li>
	<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes </span></a>
	<ul class="sub-menu">
		<li>
			<a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_completas_sre"><i class="fa fa-user"></i> <span class="title"> Solicitudes Realizadas </span></a>
		</li>
	</ul>
</li>

<!-- Usuario Super Admin -->
<?php 
	if($this->session->userdata('tipo_usuario') == 1){ 
?>
<li><a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a></li>
<li><a href="<?php echo base_url() ?>noticias/noticias/index"><i class="fa fa-rss-square"></i> <span class="title"> Publicaciones </span></a></li>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Personal </span></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear"><i class="fa fa-user"></i> <span class="title"> Crear Personal Trabajadores </span></a></li>
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear_mandante"><i class="fa fa-user"></i> <span class="title"> Crear Usuario Mandante </span></a></li>
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear_est_externo"><i class="fa fa-user"></i> <span class="title"> Crear Usuario EST </span></a></li>
	</ul>
</li>
<li><a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Usuarios </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><span class="title"> Trabajadores Activos </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_trabajadores_inactivos"><span class="title"> Trabajadores Inactivos </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios"><span class="title"> Usuarios EST/MANDANTE </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios_psicologos"><span class="title"> Usuarios Examen Psicologico </span></a></li>
	</ul>
</li>
<li><a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Requerimientos </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<li><a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Administrar Requerimiento </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<li><a href="<?php echo base_url() ?>est/empresas/listado"> Empresa Mandante </a></li>
				<li><a href="<?php echo base_url() ?>est/plantas/buscar"> Unidad de Negocio </a></li>
				<li><a href="<?php echo base_url() ?>est/areas/buscar"> Areas </a></li>
				<!--<li><a href="<?php echo base_url() ?>est/jefes_area/listado"> Jefe de Area </a></li>-->
				<li><a href="<?php echo base_url() ?>est/cargos/buscar"> Cargos </a></li>
			</ul>
		</li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/agregar"><i class="fa fa-bullhorn"></i> <span class="title"> Crear Requerimiento </span></a></li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a></li>
	</ul>
</li>
<li><a href="<?php echo base_url() ?>est/trabajadores/liberacion_examen_psicologico"><i class="fa fa-bullhorn"></i> <span class="title"> Liberacion Solicitudes Examenes </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span></a></li>
<li><a href="<?php echo base_url() ?>est/examen_psicologico"><i class="fa fa-home"></i> <span class="title"> Examenes Psicologicos Trabajadores </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Centro de Costo </span></a></li>
<?php } ?>

<!-- Usuario Est Interno -->
<?php if($this->session->userdata('tipo_usuario') == 2){ ?>
<li><a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a></li>
<li><a href="<?php echo base_url() ?>noticias/noticias/index"><i class="fa fa-rss-square"></i> <span class="title"> Publicaciones </span></a></li>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Personal </span></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear"><i class="fa fa-user"></i> <span class="title"> Crear Personal Trabajadores </span></a></li>
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear_mandante"><i class="fa fa-user"></i> <span class="title"> Crear Usuario Mandante </span></a></li>
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear_est_externo"><i class="fa fa-user"></i> <span class="title"> Crear Usuario EST </span></a></li>
	</ul>
</li>
<li><a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Usuarios </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><span class="title">Trabajadores Activos </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_trabajadores_inactivos"><span class="title">Trabajadores Inactivos </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios"><span class="title">Gestion Usuarios EST/MANDANTE </span></a></li>
	</ul>
</li>
<li><a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Requerimientos </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<li><a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Administrar Requerimiento </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<li><a href="<?php echo base_url() ?>est/empresas/listado"> Empresa Mandante </a></li>
				<li><a href="<?php echo base_url() ?>est/plantas/buscar"> Unidad de Negocio </a></li>
				<li><a href="<?php echo base_url() ?>est/areas/buscar"> Areas </a></li>
				<!--<li><a href="<?php echo base_url() ?>est/jefes_area/listado"> Jefe de Area </a></li>-->
				<li><a href="<?php echo base_url() ?>est/cargos/buscar"> Cargos </a></li>
			</ul>
		</li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/agregar"><i class="fa fa-bullhorn"></i> <span class="title"> Crear Requerimiento </span></a></li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a></li>
	</ul>
</li>
<li><a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Centro de Costo </span></a></li>
<?php } ?>

<?php if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 3 or $this->session->userdata('id') == 6 or $this->session->userdata('id') == 10){ ?>
<li><a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_propios_sin_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Propios sin Centro de Costo </span></a></li>
<?php } ?>

<!-- Usuario Est Visualizador -->
<?php if($this->session->userdata('tipo_usuario') == 3){ ?>
<li><a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><i class="fa fa-user"></i> <span class="title"> Listado Trabajadores </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span></a>
<?php } ?>

<!-- Usuario Admin Pensiones -->
<?php if($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('id') == 6){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Pensiones </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/pensiones"><i class="fa fa-user"></i> <span class="title"> Administración </span></a></li>
		<li><a href="<?php echo base_url() ?>est/pensiones/informe_pensiones"><i class="fa fa-home"></i> <span class="title"> Informe </span></a></li>
	</ul>
</li>
<?php } ?>

<!-- Usuario Visualizador General -->
<?php if($this->session->userdata('tipo_usuario') == 10){ ?>
<li><a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><i class="fa fa-user"></i> <span class="title"> Trabajadores </span></a></li>
<li><a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Requerimientos </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a></li>
	</ul>
</li>
<li><a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span></a>
<?php } ?>