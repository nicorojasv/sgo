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

<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'trabajadores')echo "active"; }?> " data="1.2-trabajadores">
	<a href="<?php echo base_url() ?>enjoy/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
</li>

<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'listado')echo "active"; }?> " data="1.3-listado">
	<a href="<?php echo base_url() ?>enjoy/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
</li>

<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'horarios')echo "active"; }?> " data="1.4-horarios">
	<a href="<?php echo base_url() ?>enjoy/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
</li>

<li>
	<a href="javascript:void(0)"><i class="fa fa-book"></i> <span class="title"> Solicitudes de Contratos </span></a>
	<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.5')echo "style='display: block;'"; }?>>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitudes_pendientes')echo "active"; }?> " data="1.5-solicitudes_pendientes">
			<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
		</li>
		<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'solicitudes_completas')echo "active"; }?> " data="1.5-solicitudes_completas">
			<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
		</li>
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_pen_baj')echo "active"; }?> " data="1.5-enjoy_sol_pen_baj">
			<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span><span class="badge"> NEW</span></a>
		</li>
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_sol_compl_baj')echo "active"; }?> " data="1.5-enjoy_sol_compl_baj">
			<a href="<?php echo base_url() ?>enjoy/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span><span class="badge"> NEW</span></a>
		</li>
	</ul>
</li>
<!--1.6-->
<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_asistencia')echo "active"; }?> " data="1.6-enjoy_asistencia">
	<a href="<?php echo base_url() ?>enjoy/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span> </a>
</li>
<!--1.7-->
<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'enjoy_bonos')echo "active"; }?> " data="1.7-enjoy_bonos">
	<a href="<?php echo base_url() ?>enjoy/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span> </a>
</li>


<!--########### 	Aramark	########### -->


<li  <?php if(isset($numMenu)){if ($numMenu == 4)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title"> ARAMARK </span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 4)echo "style='display: block;'"; }?>>
		<!--3.1-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_horarios')echo "active"; }?> " data="4.1-aramark_horarios">
			<a href="<?php echo base_url() ?>aramark/horarios"><i class="fa fa-home"></i> <span class="title"> Gestion de Horarios </span></a>
		</li>
		<!--4.2-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_trabajadores')echo "active"; }?> " data="4.2-aramark_trabajadores">
			<a href="<?php echo base_url() ?>aramark/trabajadores"><i class="fa fa-home"></i> <span class="title"> Listado Trabajadores </span></a>
		</li>
		<!--4.4-->
		<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_listado')echo "active"; }?> " data="4.3-aramark_listado">
			<a href="<?php echo base_url() ?>aramark/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
		</li>
		<!--4.4-->
		<li>
			<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos aramark </span></a>
			<ul class="sub-menu"  <?php if(isset($menu)){if($menu == '4.41')echo "style='display: block;'"; }?>>
				<!--4.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_sol_pendie')echo "active"; }?> " data="4.41-aramark_sol_pendie">
					<a href="<?php echo base_url() ?>aramark/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--4.41-->
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
		<!--4.6-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_asistencia')echo "active"; }?> " data="4.6-aramark_asistencia">
			<a href="<?php echo base_url() ?>aramark/asistencia"><i class="fa fa-home"></i> <span class="title"> Asistencia </span></a>
		</li>
		<!--4.7-->
		<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'aramark_bonos')echo "active"; }?> " data="4.7-aramark_bonos">
			<a href="<?php echo base_url() ?>aramark/asistencia/bonos"><i class="fa fa-home"></i> <span class="title"> Bonos </span></a>
		</li>
	</ul>
</li>