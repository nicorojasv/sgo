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
<style type="text/css">
	.AramarkColor:hover {
        background: #5d717c !important;
}
	.EnjoyColor:hover {
        background: #5d717c !important;
}
	.blueColor:hover {
        background: #5d717c !important;
}
	.AraucoColor:hover {
        background: #5d717c !important;
}
	.Marina:hover {
		background: #5d717c !important;
}
.WoodColor:hover {
        background: #5d717c !important;
}

</style>

<li>
	<a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a>
</li>

<li <?php if(isset($numMenu)){if ($numMenu == 1)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title"  style="color: #ffffff"> ARAUCO </span></a>
	<ul class="sub-menu"  <?php if(isset($numMenu)){if ($numMenu == 1)echo "style='display: block;'"; }?> >
		<!--1.1-->
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_horarios')echo "active"; }?> " data="1.1-est_horarios">
			<a class="AraucoColor" href="<?php echo base_url() ?>est/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--1.2-->
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'abastecimiento')echo "active"; }?> " data="1.2-abastecimiento">
			<a class="AraucoColor" href="<?php echo base_url() ?>abastecimiento"><i class="fa fa-user"></i> <span class="title"> Abastecimiento </span></a>
		</li>
		<!--1.3-->
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'abastecimiento_asignar')echo "active"; }?> " data="1.3-abastecimiento_asignar">
			<a class="AraucoColor" href="<?php echo base_url() ?>abastecimiento/asignar"><i class="fa fa-user"></i> <span class="title"> Asignación Abastecimiento </span></a>
		</li>
		<!--1.4-->
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Analista) </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.4')echo "style='display: block;'"; }?>>

				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_pendiente')echo "active"; }?> " data="1.4-solicitud_pendiente">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_completa')echo "active"; }?> " data="1.4-solicitud_completa">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>
		<!--1.5-->
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Admin) </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.5')echo "style='display: block;'"; }?>>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'revision_examen')echo "active"; }?> " data="1.5-revision_examen">
					<a class="AraucoColor" href="<?php echo base_url() ?>esffit/trabajadores/solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'listado_solicitudes_completas_sre')echo "active"; }?> " data="1.5-listado_solicitudes_completas_sre">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_completas_sre"><i class="fa fa-user"></i> <span class="title"> Solicitudes Realizadas </span></a>
				</li>
			</ul>
		</li>
		<!--1.6-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'noticias')echo "active"; }?> " data="1.6-noticias">
			<a class="AraucoColor" href="<?php echo base_url() ?>noticias/noticias/index"><i class="fa fa-rss-square"></i> <span class="title"> Publicaciones </span></a>
		</li>
		<!--1.7-->
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Usuarios </span><i class="icon-arrow"></i> </a>	
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.7')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'buscar_js')echo "active"; }?> " data="1.7-buscar_js">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/buscar_js"><span class="title"> Trabajadores Activos </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_trabajadores_inactivos')echo "active"; }?> " data="1.7-est_trabajadores_inactivos">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/listado_trabajadores_inactivos"><span class="title"> Trabajadores Inactivos </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_psicologos')echo "active"; }?> " data="1.7-est_psicologos">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/psicologos"><i class="fa fa-user"></i> <span class="title"> Listado Psicologos </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_gestion_usuarios')echo "active"; }?> " data="1.7-est_gestion_usuarios">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios"><span class="title"> Usuarios EST/MANDANTE </span></a></li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_gestion_usuarios_psicologos')echo "active"; }?> " data="1.7-est_gestion_usuarios_psicologos">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/gestion_usuarios_psicologos"><span class="title"> Usuarios Examen Psicologico </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_crear')echo "active"; }?> " data="1.7-est_crear">
					<a class="AraucoColor" href="<?php echo base_url() ?>usuarios/perfil/crear"><i class="fa fa-user"></i> <span class="title"> Crear Personal Trabajadores </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_crear_mandante')echo "active"; }?> " data="1.7-est_crear_mandante">
					<a class="AraucoColor" href="<?php echo base_url() ?>usuarios/perfil/crear_mandante"><i class="fa fa-user"></i> <span class="title"> Crear Usuario Mandante </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_crear_est_externo')echo "active"; }?> " data="1.7-est_crear_est_externo">
					<a class="AraucoColor" href="<?php echo base_url() ?>usuarios/perfil/crear_est_externo"><i class="fa fa-user"></i> <span class="title"> Crear Usuario EST </span></a>
				</li>
			</ul>
		</li>
		<!--1.8-->
		<?php 
		//var_dump($menu);
		?>
		<li>
			<a class="AraucoColor" href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Requerimientos </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.8' || $menu == '1.81')echo "style='display: block;'"; }?> >
				<!--1.81-->
				<li>
					<a class="AraucoColor" href="javascript:void(0)" ><i class="fa fa-gears"></i> <span class="title"> Administrar Requerimiento </span></a>
					<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.81')echo "style='display: block;'"; }?>>
						<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_listado')echo "active"; }?> " data="1.81-est_listado">
							<a class="AraucoColor" href="<?php echo base_url() ?>est/empresas/listado"> Empresa Mandante </a>
						</li>
						<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_buscar_plantas')echo "active"; }?> " data="1.81-est_buscar_plantas">
							<a class="AraucoColor" href="<?php echo base_url() ?>est/plantas/buscar"> Unidad de Negocio </a>
						</li>
						<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_buscar_areas')echo "active"; }?> " data="1.81-est_buscar_areas">
							<a class="AraucoColor" href="<?php echo base_url() ?>est/areas/buscar"> Areas </a>
						</li>
						<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_buscar_cargos')echo "active"; }?> " data="1.81-est_buscar_cargos">
							<a class="AraucoColor" href="<?php echo base_url() ?>est/cargos/buscar"> Cargos </a>
						</li>
					</ul>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_agregar_requerimiento')echo "active"; }?> " data="1.8-est_agregar_requerimiento">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/requerimiento/agregar"><i class="fa fa-bullhorn"></i> <span class="title"> Crear Requerimiento </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_listado')echo "active"; }?> " data="1.8-est_listado">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a>
				</li>
			</ul>
		</li>
		<!--1.9-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_liberacion_ex_psicologico')echo "active"; }?> " data="1.9-est_liberacion_ex_psicologico">
			<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/liberacion_examen_psicologico"><i class="fa fa-bullhorn"></i> <span class="title"> Liberacion Solicitudes Examenes Psicologicos </span></a>
		</li>
		<!--1.10-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_examen_psicologico')echo "active"; }?> " data="1.10-est_examen_psicologico">
			<a class="AraucoColor" href="<?php echo base_url() ?>est/examen_psicologico"><i class="fa fa-home"></i> <span class="title"> Examenes Psicologicos Trabajadores </span></a>
		</li>
		<!--111-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_bd_eval_ccosto')echo "active"; }?> " data="1.11-est_bd_eval_ccosto">
			<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Centro de Costo </span></a>
		</li>
		<!--1.12-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_bd_eval_propio_sin_ccosto')echo "active"; }?> " data="1.12-est_bd_eval_propio_sin_ccosto">
			<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_propios_sin_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Propios sin Centro de Costo </span></a>
		</li>
		<!--1.13-->
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Pensiones </span><i class="icon-arrow"></i> </a>	
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.13')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_pensiones')echo "active"; }?> " data="1.13-est_pensiones">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/pensiones"><i class="fa fa-user"></i> <span class="title"> Administración </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_informe_pensiones')echo "active"; }?> " data="1.13-est_informe_pensiones">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/pensiones/informe_pensiones"><i class="fa fa-home"></i> <span class="title"> Informe </span></a>
				</li>
			</ul>
		</li>
		<!--1.14-->
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos Arauco </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.14')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendi')echo "active"; }?> " data="1.14-est_cont_soli_pendi">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completas')echo "active"; }?> " data="1.14-est_solicitudes_completas">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pen_baj')echo "active"; }?> " data="1.14-est_sol_pen_baj">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_compl_baj')echo "active"; }?> " data="1.14-est_sol_compl_baj">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos Arauco </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_pendientes_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pen_bajAnexo')echo "active"; }?> " data="1.16-est_sol_pen_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_pendientes_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_compl_bajAnexo')echo "active"; }?> " data="1.16-est_sol_compl_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--1.15-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_trbjadores_contratos_y_anexos')echo "active"; }?> " data="1.15-est_trbjadores_contratos_y_anexos">
			<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-file-text-o"></i><span class="title"> Contratos & Anexos </span></a>
		</li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/historico_carta_termino"><i class="fa fa-home"></i> <span class="title">Cartas Termino generadas </span></a></li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/generar_dt"><i class="fa fa-home"></i> <span class="title">Generar DT </span></a> </li>
		<li><a href="<?php echo base_url() ?>est/solicitud_psicologia"><i class="fa fa-home"></i> <span class="title">Solicitud Evaluaciones <span class="badge"> NEW</span></span></a> </li>
		<!--FIRMATEC-->
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title">Firmatec</span> <span class="badge"> NEW</span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>firmatec/firmatec/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Contratos Firmados</span></a>
				</li>
				<!--<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>firmatec/firmatec/apiConsultaHoldingDocumento/1"><i class="fa fa-user"></i> <span class="title"> Contratos Firmados</span></a>
				</li>-->
			</ul>
		</li>
	</ul>
</li>

<!--########### 	BLUE	########### -->
<?php /* 
<li <?php if(isset($numMenu)){if ($numMenu == 2)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: blue"> BLUE </span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 2)echo "style='display: block;'"; }?>>
		<!--2.1-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_horarios')echo "active"; }?> " data="2.1-blue_horarios">
			<a class="blueColor" href="<?php echo base_url() ?>logistica_servicios/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--2.1-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_trabajadores')echo "active"; }?> " data="2.1-blue_trabajadores">
			<a class="blueColor" href="<?php echo base_url() ?>logistica_servicios/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--2.1-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_listado')echo "active"; }?> " data="2.1-blue_listado">
			<a class="blueColor" href="<?php echo base_url() ?>logistica_servicios/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--2.2-->
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos (Admin) </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '2.21')echo "style='display: block;'"; }?>>
				<!--2.21-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_solicitudes_pendientes')echo "active"; }?> " data="2.21-blue_solicitudes_pendientes">
					<a class="blueColor"  href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--2.21-->
				<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_solicitudes_validadas')echo "active"; }?> " data="2.21-blue_solicitudes_validadas">
					<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_validadas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Validadas </span></a>
				</li>
				<!--2.21-->
				<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_solicitudes_completas')echo "active"; }?> " data="2.21-blue_solicitudes_completas">
					<a class="blueColor"  href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>
		<!--2.3-->
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos Blue (RRHH) </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '2.31')echo "style='display: block;'"; }?>>
			<!--2.31-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_rh_soli_pendi')echo "active"; }?> " data="2.31-blue_rh_soli_pendi">
					<a class="blueColor"  href="<?php echo base_url() ?>est/contratos_log/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_rh_solicitudes_completas')echo "active"; }?> " data="2.31-blue_rh_solicitudes_completas">
					<a class="blueColor"  href="<?php echo base_url() ?>est/contratos_log/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>
		<!--2.4-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'blue_contratos_y_anexos')echo "active"; }?> " data="2.4-blue_contratos_y_anexos">
			<a class="blueColor"  href="<?php echo base_url() ?>logistica_servicios/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span></a>
		</li>
	</ul>
</li>
*/ ?>
<!--########### 	ENJOY	########### -->


<li  <?php if(isset($numMenu)){if ($numMenu == 2)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #ffffff"> ENJOY </span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 3)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_horarios')echo "active"; }?> " data="3.1-enjoy_horarios">
			<a class="EnjoyColor" href="<?php echo base_url() ?>enjoy/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_trabajadores')echo "active"; }?> " data="3.2-enjoy_trabajadores">
			<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_listado')echo "active"; }?> " data="3.3-enjoy_listado">
			<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		<li>
			<a class="EnjoyColor"  href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos Enjoy </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '3.41')echo "style='display: block;'"; }?>>
				<!--3.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_pendie')echo "active"; }?> " data="3.41-enjoy_sol_pendie">
					<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--3.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_compl')echo "active"; }?> " data="3.41-enjoy_sol_compl">
					<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_pen_baj')echo "active"; }?> " data="3.41-enjoy_sol_pen_baj">
					<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_compl_baj')echo "active"; }?> " data="3.41-enjoy_sol_compl_baj">
					<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_contratos_y_anexos')echo "active"; }?> " data="3.5-enjoy_contratos_y_anexos">
			<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_asistencia')echo "active"; }?> " data="3.6-enjoy_asistencia">
			<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--3.7-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_bonos')echo "active"; }?> " data="3.7-enjoy_bonos">
			<a class="EnjoyColor"  href="<?php echo base_url() ?>enjoy/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>

<!--########### 	Aramark	########### -->

<?php /*
<li  <?php if(isset($numMenu)){if ($numMenu == 4)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #eb3b34"> ARAMARK </span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 4)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_horarios')echo "active"; }?> " data="4.1-aramark_horarios">
			<a class="AramarkColor" href="<?php echo base_url() ?>aramark/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--4.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_trabajadores')echo "active"; }?> " data="4.2-aramark_trabajadores">
			<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--4.4-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_listado')echo "active"; }?> " data="4.3-aramark_listado">
			<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--4.4-->
		<li>
			<a class="AramarkColor"  href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos aramark </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '4.41')echo "style='display: block;'"; }?>>
				<!--4.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_pendie')echo "active"; }?> " data="4.41-aramark_sol_pendie">
					<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--4.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_compl')echo "active"; }?> " data="4.41-aramark_sol_compl">
					<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_pen_baj')echo "active"; }?> " data="4.41-aramark_sol_pen_baj">
					<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_compl_baj')echo "active"; }?> " data="4.41-aramark_sol_compl_baj">
					<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--4.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_contratos_y_anexos')echo "active"; }?> " data="4.5-aramark_contratos_y_anexos">
			<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--4.6-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_asistencia')echo "active"; }?> " data="4.6-aramark_asistencia">
			<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--4.7-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_bonos')echo "active"; }?> " data="4.7-aramark_bonos">
			<a class="AramarkColor"  href="<?php echo base_url() ?>aramark/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>
  */ ?>
<!--########### 	Marina	########### -->


<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #ffffff"> MARINA TALCAHUANO</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_horarios')echo "active"; }?> " data="6.1-marina_horarios">
			<a class="Marina"  href="<?php echo base_url() ?>marina/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_trabajadores')echo "active"; }?> " data="6.2-marina_trabajadores">
			<a class="Marina" href="<?php echo base_url() ?>marina/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_listado')echo "active"; }?> " data="6.3-marina_listado">
			<a class="Marina" href="<?php echo base_url() ?>marina/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		<li>
			<a class="Marina" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos marina </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_pendie')echo "active"; }?> " data="6.41-marina_sol_pendie">
					<a class="Marina" href="<?php echo base_url() ?>marina/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_compl')echo "active"; }?> " data="6.41-marina_sol_compl">
					<a class="Marina" href="<?php echo base_url() ?>marina/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_pen_baj')echo "active"; }?> " data="6.41-marina_sol_pen_baj">
					<a class="Marina" href="<?php echo base_url() ?>marina/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_compl_baj')echo "active"; }?> " data="6.41-marina_sol_compl_baj">
					<a class="Marina" href="<?php echo base_url() ?>marina/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_contratos_y_anexos')echo "active"; }?> " data="6.5-marina_contratos_y_anexos">
			<a class="Marina" href="<?php echo base_url() ?>marina/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_asistencia')echo "active"; }?> " data="6.6-marina_asistencia">
			<a class="Marina" href="<?php echo base_url() ?>marina/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--3.7-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_bonos')echo "active"; }?> " data="6.7-marina_bonos">
			<a class="Marina" href="<?php echo base_url() ?>marina/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>
<!--########### 	Marina Chillan	########### -->
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #ffffff"> MARINA CHILLAN</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_horarios')echo "active"; }?> " data="6.1-marina_chillan_horarios">
			<a class="Marina_chillan"  href="<?php echo base_url() ?>marina_chillan/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_trabajadores')echo "active"; }?> " data="6.2-marina_chillan_trabajadores">
			<a class="Marina_chillan" href="<?php echo base_url() ?>marina_chillan/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_listado')echo "active"; }?> " data="6.3-marina_chillan_listado">
			<a class="Marina_chillan" href="<?php echo base_url() ?>marina_chillan/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		<li>
			<a class="Marina_chillan" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos marina_chillan </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_sol_pendie')echo "active"; }?> " data="6.41-marina_chillan_sol_pendie">
					<a class="Marina_chillan" href="<?php echo base_url() ?>marina_chillan/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_sol_compl')echo "active"; }?> " data="6.41-marina_chillan_sol_compl">
					<a class="Marina_chillan" href="<?php echo base_url() ?>marina_chillan/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_sol_pen_baj')echo "active"; }?> " data="6.41-marina_chillan_sol_pen_baj">
					<a class="Marina_chillan" href="<?php echo base_url() ?>marina_chillan/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_sol_compl_baj')echo "active"; }?> " data="6.41-marina_chillan_sol_compl_baj">
					<a class="Marina_chillan" href="<?php echo base_url() ?>marina_chillan/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_contratos_y_anexos')echo "active"; }?> " data="6.5-marina_contratos_y_anexos">
			<a class="Marina_chillan" href="<?php echo base_url() ?>marina/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_asistencia')echo "active"; }?> " data="6.6-marina_asistencia">
			<a class="Marina_chillan" href="<?php echo base_url() ?>marina/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--3.7-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_bonos')echo "active"; }?> " data="6.7-marina_bonos">
			<a class="Marina_chillan" href="<?php echo base_url() ?>marina/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>
<!--########### 	wood	########### -->
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

				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_pendiente')echo "active"; }?> " data="1.4-solicitud_pendiente">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_completa')echo "active"; }?> " data="1.4-solicitud_completa">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>

		<li>
			<a class="WoodColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos wood </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_pendie')echo "active"; }?> " data="6.41-wood_sol_pendie">
					<a class="wood" href="<?php echo base_url() ?>wood/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl')echo "active"; }?> " data="6.41-wood_sol_compl">
					<a class="wood" href="<?php echo base_url() ?>wood/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_pen_baj')echo "active"; }?> " data="6.41-wood_sol_pen_baj">
					<a class="wood" href="<?php echo base_url() ?>wood/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl_baj')echo "active"; }?> " data="6.41-wood_sol_compl_baj">
					<a class="wood" href="<?php echo base_url() ?>wood/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<li>
			<a class="WoodColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/contratos/solicitudes_pendientes_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pen_bajAnexo')echo "active"; }?> " data="1.16-est_sol_pen_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/contratos/solicitudes_pendientes_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_compl_bajAnexo')echo "active"; }?> " data="1.16-est_sol_compl_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>wood/contratos/solicitudes_completas_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_contratos_y_anexos')echo "active"; }?> " data="6.5-wood_contratos_y_anexos">
			<a class="WoodColor" href="<?php echo base_url() ?>wood/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		
	</ul>
</li>

*/ ?>

<!--########### 	terramar	########### -->
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color:#ffffff">TERRAMAR</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_horarios')echo "active"; }?> " data="6.1-terramar_horarios">
			<a class="terramarColor"  href="<?php echo base_url() ?>terramar/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
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

				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_pendiente')echo "active"; }?> " data="1.4-solicitud_pendiente">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitud_completa')echo "active"; }?> " data="1.4-solicitud_completa">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
			</ul>
		</li>

		<li>
			<a class="terramarColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos terramar </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_pendie')echo "active"; }?> " data="6.41-terramar_sol_pendie">
					<a class="terramar" href="<?php echo base_url() ?>terramar/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_compl')echo "active"; }?> " data="6.41-terramar_sol_compl">
					<a class="terramar" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_pen_baj')echo "active"; }?> " data="6.41-terramar_sol_pen_baj">
					<a class="terramar" href="<?php echo base_url() ?>terramar/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_compl_baj')echo "active"; }?> " data="6.41-terramar_sol_compl_baj">
					<a class="terramar" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<li>
			<a class="terramarColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_pendientes_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pen_bajAnexo')echo "active"; }?> " data="1.16-est_sol_pen_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_pendientes_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_compl_bajAnexo')echo "active"; }?> " data="1.16-est_sol_compl_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_contratos_y_anexos')echo "active"; }?> " data="6.5-terramar_contratos_y_anexos">
			<a class="terramarColor" href="<?php echo base_url() ?>terramar/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		
	</ul>
</li>
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" >SANATORIO ALEMAN</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_horarios')echo "active"; }?> " >
			<a   href="<?php echo base_url() ?>sanatorio/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_trabajadores')echo "active"; }?> " data="6.2-wood_trabajadores">
			<a  href="<?php echo base_url() ?>sanatorio/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_listado')echo "active"; }?> " data="6.3-wood_listado">
			<a  href="<?php echo base_url() ?>sanatorio/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		
		<li>
			<a  href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_pendie')echo "active"; }?> " data="6.41-wood_sol_pendie">
					<a class="wood" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl')echo "active"; }?> " data="6.41-wood_sol_compl">
					<a class="wood" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_pen_baj')echo "active"; }?> " data="6.41-wood_sol_pen_baj">
					<a class="wood" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl_baj')echo "active"; }?> " data="6.41-wood_sol_compl_baj">
					<a  href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<li>
			<a  href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_pendientes_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pen_bajAnexo')echo "active"; }?> " data="1.16-est_sol_pen_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_pendientes_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_compl_bajAnexo')echo "active"; }?> " data="1.16-est_sol_compl_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>sanatorio/contratos/solicitudes_completas_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_contratos_y_anexos')echo "active"; }?> " data="6.5-wood_contratos_y_anexos">
			<a  href="<?php echo base_url() ?>sanatorio/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		
	</ul>
</li>

<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" >CLINICAS LOS CARRERAS</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_horarios')echo "active"; }?> " >
			<a   href="<?php echo base_url() ?>carrera/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--3.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_trabajadores')echo "active"; }?> " data="6.2-wood_trabajadores">
			<a  href="<?php echo base_url() ?>carrera/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_listado')echo "active"; }?> " data="6.3-wood_listado">
			<a  href="<?php echo base_url() ?>carrera/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		
		<li>
			<a  href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_pendie')echo "active"; }?> " data="6.41-wood_sol_pendie">
					<a class="wood" href="<?php echo base_url() ?>carrera/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl')echo "active"; }?> " data="6.41-wood_sol_compl">
					<a class="wood" href="<?php echo base_url() ?>carrera/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_pen_baj')echo "active"; }?> " data="6.41-wood_sol_pen_baj">
					<a class="wood" href="<?php echo base_url() ?>carrera/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_sol_compl_baj')echo "active"; }?> " data="6.41-wood_sol_compl_baj">
					<a  href="<?php echo base_url() ?>carrera/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<li>
			<a  href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Anexos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.16')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendiAnexo')echo "active"; }?> " data="1.16-est_cont_soli_pendiAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>carrera/contratos/solicitudes_pendientes_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completasAnexo')echo "active"; }?> " data="1.16-est_solicitudes_completasAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>carrera/contratos/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pen_bajAnexo')echo "active"; }?> " data="1.16-est_sol_pen_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>carrera/contratos/solicitudes_pendientes_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_compl_bajAnexo')echo "active"; }?> " data="1.16-est_sol_compl_bajAnexo">
					<a class="AraucoColor" href="<?php echo base_url() ?>carrera/contratos/solicitudes_completas_baja_anexo"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--3.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_contratos_y_anexos')echo "active"; }?> " data="6.5-wood_contratos_y_anexos">
			<a  href="<?php echo base_url() ?>carrera/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		
	</ul>
</li>


	
<!--
<li><a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a></li>
<li><a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/psicologos"><i class="fa fa-user"></i> <span class="title"> Listado Psicologos </span></a></li>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Trabajadores </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><i class="fa fa-group"></i> <span class="title"> Listado Trabajadores Activos </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_trabajadores_inactivos"><i class="fa fa-group"></i> <span class="title"> Listado Trabajadores Inactivos </span></a></li>
	</ul>
</li>
<li><a href="<?php echo base_url() ?>est/examen_psicologico"><i class="fa fa-home"></i> <span class="title"> Examen Psicologico </span></a></li>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes </span></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a></li>
	</ul>
</li>-->