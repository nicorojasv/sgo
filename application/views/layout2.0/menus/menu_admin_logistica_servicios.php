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
<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'home')echo "active"; }?> " data="1.1-home">
	<a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a>
</li>

<?php 
	if($this->session->userdata('id') == 105 ){ 
?>
<!--	<li>
		<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: blue"> Blue </span></a>
		<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.2' || $menu =='1.3')echo "style='display: block;'"; }?>>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'trabajadores')echo "active"; }?> " data="1.2-trabajadores">
				<a href="<?php echo base_url() ?>logistica_servicios/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
			</li>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'listado')echo "active"; }?> " data="1.2-listado">
				<a href="<?php echo base_url() ?>logistica_servicios/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
			</li>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'horarios')echo "active"; }?> " data="1.2-horarios">
				<a href="<?php echo base_url() ?>logistica_servicios/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios Blue </span></a>
			</li>
			<li>
				<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos </span></a>
				<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.3')echo "style='display: block;'"; }?>>
					<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitudes_pendientes')echo "active"; }?> " data="1.3-solicitudes_pendientes">
						<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
					</li>
					<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitudes_validadas')echo "active"; }?> " data="1.3-solicitudes_validadas">
						<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_validadas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Validadas </span></a>
					</li>
					<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitudes_completas')echo "active"; }?> " data="1.3-solicitudes_completas">
						<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
					</li>
				</ul>
			</li>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'cont_blue')echo "active"; }?> " data="1.2-cont_blue">
				<a href="<?php echo base_url() ?>logistica_servicios/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span><span class="badge"> NEW</span></a>
			</li>
		</ul>
	</li>-->
 
	<li>
		<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #10ecce"> Enjoy </span></a>
		<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '1.4' || $menu =='1.5')echo "style='display: block;'"; }?>>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_trab')echo "active"; }?> " data="1.4-enjoy_trab">
				<a href="<?php echo base_url() ?>enjoy/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
			</li>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_lista')echo "active"; }?> " data="1.4-enjoy_lista">
				<a href="<?php echo base_url() ?>enjoy/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
			</li>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_horas')echo "active"; }?> " data="1.4-enjoy_horas">
				<a href="<?php echo base_url() ?>enjoy/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios Enjoy </span></a>
			</li>
			<li>
				<a href="javascript:void(0)"><i class="fa fa-book"></i> <span class="title"> Solicitudes de Contratos </span></a>
				<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.5')echo "style='display: block;'"; }?>>
					<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sp')echo "active"; }?> " data="1.5-enjoy_sp">
						<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
					</li>

					<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sc')echo "active"; }?> " data="1.5-enjoy_sc">
						<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
					</li>

					<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_pen_baj')echo "active"; }?> " data="1.5-enjoy_sol_pen_baj">
						<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
					</li>
					<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_compl_baj')echo "active"; }?> " data="1.5-enjoy_sol_compl_baj">
						<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
					</li>

				</ul>
			</li>
			<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_contr')echo "active"; }?> " data="1.4-enjoy_contr">
				<a href="<?php echo base_url() ?>enjoy/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a> 
			</li>
			<!--1.5-->
			<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_asistencia')echo "active"; }?> " data="1.5-enjoy_asistencia">
				<a href="<?php echo base_url() ?>enjoy/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span> </a>
			</li>
			<!--1.6-->
			<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_bonos')echo "active"; }?> " data="1.6-enjoy_bonos">
				<a href="<?php echo base_url() ?>enjoy/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span> <span class="badge"> NEW</span></a>
			</li>
		</ul>
	</li>
	<!--########### 	Aramark	########### -->


<!--<li  <?php if(isset($numMenu)){if ($numMenu == 4)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #eb3b34"> Aramark</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 4)echo "style='display: block;'"; }?>>
		<!--3.1- ->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_horarios')echo "active"; }?> " data="4.1-aramark_horarios">
			<a href="<?php echo base_url() ?>aramark/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--4.2- ->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_trabajadores')echo "active"; }?> " data="4.2-aramark_trabajadores">
			<a href="<?php echo base_url() ?>aramark/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--4.4- ->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_listado')echo "active"; }?> " data="4.3-aramark_listado">
			<a href="<?php echo base_url() ?>aramark/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--4.4- ->
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos aramark </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '4.41')echo "style='display: block;'"; }?>>
				<!--4.41- ->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_pendie')echo "active"; }?> " data="4.41-aramark_sol_pendie">
					<a href="<?php echo base_url() ?>aramark/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--4.41- ->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_compl')echo "active"; }?> " data="4.41-aramark_sol_compl">
					<a href="<?php echo base_url() ?>aramark/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_pen_baj')echo "active"; }?> " data="4.41-aramark_sol_pen_baj">
					<a href="<?php echo base_url() ?>aramark/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_compl_baj')echo "active"; }?> " data="4.41-aramark_sol_compl_baj">
					<a href="<?php echo base_url() ?>aramark/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--4.5- ->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_contratos_y_anexos')echo "active"; }?> " data="4.5-aramark_contratos_y_anexos">
			<a href="<?php echo base_url() ?>aramark/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--4.6- ->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_asistencia')echo "active"; }?> " data="4.6-aramark_asistencia">
			<a href="<?php echo base_url() ?>aramark/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--4.7- ->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_bonos')echo "active"; }?> " data="4.7-aramark_bonos">
			<a href="<?php echo base_url() ?>aramark/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>-->

	<!--########### 	Marina del sol  	########### -->


<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #fdcc3c"> Marina del Sol </span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 5)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_horarios')echo "active"; }?> " data="5.1-marina_horarios">
			<a href="<?php echo base_url() ?>marina/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--5.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_trabajadores')echo "active"; }?> " data="5.2-marina_trabajadores">
			<a href="<?php echo base_url() ?>marina/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--5.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_listado')echo "active"; }?> " data="5.3-marina_listado">
			<a href="<?php echo base_url() ?>marina/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--5.5-->
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos marina </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '5.51')echo "style='display: block;'"; }?>>
				<!--5.51-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_pendie')echo "active"; }?> " data="5.51-marina_sol_pendie">
					<a href="<?php echo base_url() ?>marina/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--5.51-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_compl')echo "active"; }?> " data="5.51-marina_sol_compl">
					<a href="<?php echo base_url() ?>marina/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_pen_baj')echo "active"; }?> " data="5.51-marina_sol_pen_baj">
					<a href="<?php echo base_url() ?>marina/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_compl_baj')echo "active"; }?> " data="5.51-marina_sol_compl_baj">
					<a href="<?php echo base_url() ?>marina/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			</ul>
		</li>
		<!--5.5-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_contratos_y_anexos')echo "active"; }?> " data="5.5-marina_contratos_y_anexos">
			<a href="<?php echo base_url() ?>marina/trabajadores/contratos_y_anexos"><i class="fa fa-home"></i> <span class="title"> Contratos & Anexos </span> </a>
		</li>
		<!--5.6-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_asistencia')echo "active"; }?> " data="5.6-marina_asistencia">
			<a href="<?php echo base_url() ?>marina/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--5.7-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_bonos')echo "active"; }?> " data="5.7-marina_bonos">
			<a href="<?php echo base_url() ?>marina/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>
<!--########### Marina Chillan	########### -->
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #e6a614bf"> Marina Chillán</span></a>
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

<?php 
	}else{ 
?>
<li>
	<a href="<?php echo base_url() ?>logistica_servicios/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
</li>
<li>
	<a href="<?php echo base_url() ?>logistica_servicios/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
</li>
<li>
	<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos </span></a>
	<ul class="sub-menu">
		<li>
			<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_validadas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Validadas </span></a>
		</li>
		<li>
			<a href="<?php echo base_url() ?>logistica_servicios/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
		</li>
	</ul>
</li>

<?php } ?>