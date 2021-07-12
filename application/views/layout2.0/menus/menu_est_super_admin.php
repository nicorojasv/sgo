<?php 
$activo = $this->session->userdata('activo');
		  $this->session->unset_userdata('activo');
		if (!empty($activo)) {
			$a = explode("-", $activo);
			$menu = $a[0];
			$nombre = $a[1];
			$b = explode('.', $activo);
			$numMenu = $b[0];
		}
	
?>
<!--1.1-->
<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'home')echo "active"; }?> " data="1.1-home">
	<a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a>
</li>
<?php 
	if($this->session->userdata('id') == 10){ 
?>
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title">  Contratos & Anexos</span> </a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.14')echo "style='display: block;'"; }?> >

				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completas')echo "active"; }?> " data="1.14-est_solicitudes_completas">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Contratos Aprobados </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Anexos Aprobados </span></a>
			</ul>
		</li>
<?php 
	} 
?>
<!--1.2-->
<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'abastecimiento')echo "active"; }?> " data="1.2-abastecimiento">
	<a href="<?php echo base_url() ?>abastecimiento"><i class="fa fa-user"></i> <span class="title"> Abastecimientos </span></a>
</li>
<li><a href="<?php echo base_url() ?>est/solicitud_psicologia"><i class="fa fa-home"></i> <span class="title">Solicitud Evaluaciones <span class="badge"> NEW</span></span></a> </li>
<!--1.3-->
<?php 
	if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 3 or $this->session->userdata('id') == 106){ 
?>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'asignar')echo "active"; }?> " data="1.3-asignar">
			<a href="<?php echo base_url() ?>abastecimiento/asignar"><i class="fa fa-user"></i> <span class="title"> Asignación Abastecimiento </span></a>
		</li>
<?php 
	} 
?>
<!--1.4-->
<?php 
	if($this->session->userdata('id') == 10){ 
?>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'horarios')echo "active"; }?> " data="1.4-horarios">
			<a href="<?php echo base_url() ?>est/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
<?php 
	} 
?>
<!--1.5-->
<?php 
	if($this->session->userdata('id') == 2 or $this->session->userdata('id') == 10 or $this->session->userdata('id') == 106){ 
?>
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Analista) </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.5')echo "style='display: block;'"; }?>>
				<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'listado_sol_revi_exam')echo "active"; }?> " data="1.5-listado_sol_revi_exam">
					<a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solici_revi_exam_comp')echo "active"; }?> " data="1.5-solici_revi_exam_comp">
					<a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>
<?php 
	}
?>

<li>
	<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes </span></a>
	<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.6')echo "style='display: block;'"; }?>>
		<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitudes_revision_examenes')echo "active"; }?> " data="1.6-solicitudes_revision_examenes">
			<a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
		</li>
		<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'listado_solicitudes_completas_sre')echo "active"; }?> " data="1.6-listado_solicitudes_completas_sre">
			<a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_completas_sre"><i class="fa fa-user"></i> <span class="title"> Solicitudes Realizadas </span></a>
		</li>
	</ul>
</li>

<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'perfil_index')echo "active"; }?> " data="1.7-perfil_index">
	<a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a>
</li>
<!--1.8-->
<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'noticias_index')echo "active"; }?> " data="1.8-noticias_index">
	<a href="<?php echo base_url() ?>noticias/noticias/index"><i class="fa fa-rss-square"></i> <span class="title"> Publicaciones </span></a>
</li>

<!--1.9-->
<li>
	<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Personal </span></a>
	<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.9')echo "style='display: block;'"; }?>>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'perfil_crear')echo "active"; }?> " data="1.9-perfil_crear">
			<a href="<?php echo base_url() ?>usuarios/perfil/crear"><i class="fa fa-user"></i> <span class="title"> Crear Personal Trabajadores </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'crear_mandante')echo "active"; }?> " data="1.9-crear_mandante">
			<a href="<?php echo base_url() ?>usuarios/perfil/crear_mandante"><i class="fa fa-user"></i> <span class="title"> Crear Usuario Mandante </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'crear_est_externo')echo "active"; }?> " data="1.9-crear_est_externo">
			<a href="<?php echo base_url() ?>usuarios/perfil/crear_est_externo"><i class="fa fa-user"></i> <span class="title"> Crear Usuario EST </span></a>
		</li>
	</ul>
</li>
<!--1.10-->
<li>
	<a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Usuarios </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.10')echo "style='display: block;'"; }?> >
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'buscar_js')echo "active"; }?> " data="1.10-buscar_js">
			<a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><span class="title"> Trabajadores Activos </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'trabajadores_inactivos')echo "active"; }?> " data="1.10-trabajadores_inactivos">
			<a href="<?php echo base_url() ?>est/trabajadores/listado_trabajadores_inactivos"><span class="title"> Trabajadores Inactivos </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'gestion_usuarios')echo "active"; }?> " data="1.10-gestion_usuarios">
			<a href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios"><span class="title"> Usuarios EST/MANDANTE </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'usuarios_psicologos')echo "active"; }?> " data="1.10-usuarios_psicologos">
			<a href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios_psicologos"><span class="title"> Usuarios Examen Psicologico </span></a>
		</li>
	</ul>
</li>
<!--1.11 , 1.12-->
<li>
	<a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Requerimientos </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.11' || $menu == '1.12'){echo "style='display: block;'";} }?>>
		<li>
			<a href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Administrar Requerimiento </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.11')echo "style='display: block;'"; }?>>
				<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'empresas_listado')echo "active"; }?> " data="1.11-empresas_listado">
					<a href="<?php echo base_url() ?>est/empresas/listado"> Empresa Mandante </a>
				</li>
				<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'plantas_buscar')echo "active"; }?> " data="1.11-plantas_buscar">
					<a href="<?php echo base_url() ?>est/plantas/buscar"> Unidad de Negocio </a>
				</li>
				<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'areas_buscar')echo "active"; }?> " data="1.11-areas_buscar">
					<a href="<?php echo base_url() ?>est/areas/buscar"> Areas </a>
				</li>
				<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'cargos_buscar')echo "active"; }?> " data="1.11-cargos_buscar">
					<a href="<?php echo base_url() ?>est/cargos/buscar"> Cargos </a>
				</li>
			</ul>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'empresas_listado')echo "active"; }?> " data="1.12-empresas_listado">
			<a href="<?php echo base_url() ?>est/requerimiento/agregar"><i class="fa fa-bullhorn"></i> <span class="title"> Crear Requerimiento </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'empresas_listado')echo "active"; }?> " data="1.12-empresas_listado">
			<a href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a>
		</li>
	</ul>
</li>
<!--1.13-->
<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'liberacion_examen_psic')echo "active"; }?> " data="1.13-liberacion_examen_psic">
	<a href="<?php echo base_url() ?>est/trabajadores/liberacion_examen_psicologico"><i class="fa fa-bullhorn"></i> <span class="title"> Liberacion Solicitudes Examenes </span></a>
</li>
<!--1.14-->
<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'contratos_y_anexos')echo "active"; }?> " data="1.14-contratos_y_anexos">
	<a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span></a>
</li>
<!--1.15-->
<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'examen_psicologico')echo "active"; }?> " data="1.15-examen_psicologico">
	<a href="<?php echo base_url() ?>est/examen_psicologico"><i class="fa fa-home"></i> <span class="title"> Examenes Psicologicos Trabajadores </span></a>
</li>
<!--1.16-->
<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'bd_eval_ccosto')echo "active"; }?> " data="1.16-bd_eval_ccosto">
	<a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Centro de Costo </span></a>
</li>
<!--1.17-->
<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'bd_eval_sin_cc')echo "active"; }?> " data="1.17-bd_eval_sin_cc">
	<a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_propios_sin_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Propios sin Centro de Costo </span></a>
</li>
<!--1.18-->
<li>
	<a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Pensiones </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.18')echo "style='display: block;'"; }?>>
		<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'pensiones')echo "active"; }?> " data="1.18-pensiones">
			<a href="<?php echo base_url() ?>est/pensiones"><i class="fa fa-user"></i> <span class="title"> Administración </span></a>
		</li>
		<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'infor_pensiones')echo "active"; }?> " data="1.18-infor_pensiones">
			<a href="<?php echo base_url() ?>est/pensiones/informe_pensiones"><i class="fa fa-home"></i> <span class="title"> Informe </span></a>
		</li>
	</ul>
</li>
<!-- Usuario Admin Pensiones -->
<?php 
	if($this->session->userdata('id') == 10 || $this->session->userdata('id') == 106 || $this->session->userdata('id') == 81){
 ?>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'contratos_y_anexosx')echo "active"; }?> " data="1.19-contratos_y_anexosx">
			<a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-file-text-o"></i><span class="title"> Contratos & Anexos </span> </a>
		</li>
<?php 
	} 
?>
<?php /*
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #FF8633">WOOD</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_horarios')echo "active"; }?> " data="6.1-wood_horarios">
			<a class="WoodColor"  href="<?php echo base_url() ?>wood/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_trabajadores')echo "active"; }?> " data="6.2-wood_trabajadores">
			<a class="WoodColor" href="<?php echo base_url() ?>wood/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_listado')echo "active"; }?> " data="6.3-wood_listado">
			<a class="WoodColor" href="<?php echo base_url() ?>wood/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		<li>
			<a class="WoodColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Analista) </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.4')echo "style='display: block;'"; }?>>

				
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_completa')echo "active"; }?> " data="1.4-solicitud_completa">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>

		<li>
			<a class="WoodColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos wood </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl')echo "active"; }?> " data="6.41-wood_sol_compl">
					<a class="wood" href="<?php echo base_url() ?>wood/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				
			</ul>
		</li>
		<li>
			<a class="WoodColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				
			</ul>
		</li>
	</ul>
</li>
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #FF8633">Terramar</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_horarios')echo "active"; }?> " data="6.1-wood_horarios">
			<a class="WoodColor"  href="<?php echo base_url() ?>terramar/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_trabajadores')echo "active"; }?> " data="6.2-terramar_trabajadores">
			<a class="terramarColor" href="<?php echo base_url() ?>terramar/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_listado')echo "active"; }?> " data="6.3-terramar_listado">
			<a class="terramarColor" href="<?php echo base_url() ?>terramar/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		<li>
			<a class="terramarColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Analista) </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.4')echo "style='display: block;'"; }?>>

				
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_completa')echo "active"; }?> " data="1.4-solicitud_completa">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>
		*/ ?>

		<li>
			<a class="terramarColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos terramar </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_compl')echo "active"; }?> " data="6.41-terramar_sol_compl">
					<a class="terramar" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				
			</ul>
		</li>
		<li>
			<a class="terramarColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				
			</ul>
		</li>

