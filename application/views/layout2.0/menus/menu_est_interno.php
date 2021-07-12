<li><a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a></li>
<li><a href="<?php echo base_url() ?>abastecimiento"><i class="fa fa-user"></i> <span class="title"> Abastecimiento </span></a></li>
		<li>
			<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Mis Solicitudes de Contratos  </span></a>
			<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.14')echo "style='display: block;'"; }?> >
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_cont_soli_pendi')echo "active"; }?> " data="1.14-est_cont_soli_pendi">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/requerimiento/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Contratos</span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_solicitudes_completas')echo "active"; }?> " data="1.14-est_solicitudes_completas">
					<a class="AraucoColor" href="<?php echo base_url() ?>est/requerimiento/solicitudes_completas_anexo"><i class="fa fa-user"></i> <span class="title"> Anexos </span></a>
				</li>

			</ul>
		</li>
<li><a href="<?php echo base_url() ?>est/solicitud_psicologia"><i class="fa fa-home"></i> <span class="title">Solicitud Evaluaciones <span class="badge"> NEW</span></span></a> </li>
<?php if($this->session->userdata('id') == 39){ ?>
<!-- Recepcion solicitudes de revision de examenes -->
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes (Analista) </span></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a></li>
	</ul>
</li>
<?php } ?>

<?php if($this->session->userdata('id') == 16){ ?>
<li><a href="<?php echo base_url() ?>est/trabajadores/liberacion_examen_psicologico"><i class="fa fa-bullhorn"></i> <span class="title"> Liberacion Solicitudes Psicologicas </span></a></li>
<?php } ?>

<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes </span></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_completas_sre"><i class="fa fa-user"></i> <span class="title"> Solicitudes Realizadas </span></a></li>
	</ul>
</li>
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
				<li><a href="<?php echo base_url() ?>est/cargos/buscar"> Cargos </a></li>
			</ul>
		</li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/agregar"><i class="fa fa-bullhorn"></i> <span class="title"> Crear Requerimiento </span></a></li>
		<li><a href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a></li>
	</ul>
</li>
<li><a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Centro de Costo </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span></a></li>
<li><a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_propios_sin_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Propios sin Centro de Costo </span></a></li>

<!-- Usuario Admin Pensiones -->
<?php if($this->session->userdata('id') == 6){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Pensiones </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/pensiones"><i class="fa fa-user"></i> <span class="title"> Administraci¨®n </span></a></li>
		<li><a href="<?php echo base_url() ?>est/pensiones/informe_pensiones"><i class="fa fa-home"></i> <span class="title"> Informe </span></a></li>
	</ul>
</li>
<?php } ?>

<!-- Usuario Admin Pensiones -->
<?php if($this->session->userdata('id') == 81){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Filtro </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/pensiones"><i class="fa fa-user"></i> <span class="title"> Administraci¨®n </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos"><i class="fa fa-file-text-o"></i><span class="title"> Contratos & Anexos </span> </a></li>
	</ul>
</li>
<?php } ?>
<li><a href="<?php echo base_url() ?>est/requerimiento/historico_carta_termino"><i class="fa fa-home"></i> <span class="title">Cartas Termino generadas </span> <span class="badge"> NEW</span></a></li>

<!--########### 	wood	########### -->
<?php /*
<?php if( $this->session->userdata('id') == 39 or $this->session->userdata('id') == 102) { ?>

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
		<?php if( $this->session->userdata('id') == 39 ) { ?>
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
		<?php } ?>

		<li>
			<a class="WoodColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos wood </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '6.41')echo "style='display: block;'"; }?>>
				<!--6.41-->
				
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
		
		<!--3.6-->
		
	</ul>
</li>

<?php } */ ?>

<?php  if( $this->session->userdata('id') == 39 or $this->session->userdata('id') == 10 or $this->session->userdata('id') == 122 or $this->session->userdata('id') == 159 )  { ?>
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
			<a class="terramarColor" href="<?php echo base_url() ?>terramar/trabajadores"><i class="fa fa-group"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--3.3-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_listado')echo "active"; }?> " data="6.3-terramar_listado">
			<a class="terramarColor" href="<?php echo base_url() ?>terramar/requerimientos/listado"><i class="fa fa-gears"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--3.4-->
		<?php if( $this->session->userdata('id') == 39){ ?>
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
		<?php } ?>
	

		<!--3.6-->
		
	</ul>
</li>


<?php
}
 ?>