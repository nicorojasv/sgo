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
</li>
<li><a href="<?php echo base_url() ?>est/solicitud_psicologia"><i class="fa fa-home"></i> <span class="title">Solicitud Evaluaciones <span class="badge"> NEW</span></span></a> </li>
<?php if( $this->session->userdata('id') == 120 ) { ?>
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
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'wood_contratos_y_anexos')echo "active"; }?> " data="6.5-wood_contratos_y_anexos">
			<a class="WoodColor" href="<?php echo base_url() ?>wood/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--3.6-->
		
	</ul>
</li>
		<!--3.5-->
		

<?php } ?>