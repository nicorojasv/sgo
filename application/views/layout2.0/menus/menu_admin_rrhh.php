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
        background: #ca7677c2 !important;
}
	.EnjoyColor:hover {
        background: #b18957c7 !important;
}
	.blueColor:hover {
        background: #728bd4bd !important;
}
	.AraucoColor:hover {
        background: #427617c4 !important;
}
	.Marina:hover {
		background: #fdcc3cab !important;
}
.WoodColor:hover {
        background: #FFA233 !important;
}

</style>
<li>
	<a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title" style="color: #44790f"> ARAUCO </span></a>

	<ul class="sub-menu" class="sub-menu" <?php if(isset($menu)){if($menu == '1.6')echo "style='display: block;'"; }?>>
	<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'home')echo "active"; }?> " data="1.1-home">
		<a class="AraucoColor" href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a>
	</li>

	<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'buscar_js')echo "active"; }?> " data="1.2-buscar_js">
		<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/buscar_js"><i class="fa fa-user"></i> <span class="title"> Listado Trabajadores </span></a>
	</li>

	<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'listado')echo "active"; }?> " data="1.3-listado">
		<a class="AraucoColor" href="<?php echo base_url() ?>est/requerimiento/listado"><i class="fa fa-bullhorn"></i> <span class="title"> Listado de Requerimientos </span></a>
	</li>

	<!--<li class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'con_est')echo "active"; }?> " data="1.4-con_est">
		<a class="AraucoColor" href="<?php echo base_url() ?>est/trabajadores/contratos_y_anexos_est"><i class="fa fa-bullhorn"></i> <span class="title"> Informe Contratos y Anexos </span>
		</a>
	</li>-->

	<li>
		<a class="AraucoColor" href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Solicitudes de Contratos Integra </span></a>
		<ul class="sub-menu" <?php if(isset($menu)){if($menu == '1.5')echo "style='display: block;'"; }?>>
			<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_pend')echo "active"; }?> " data="1.5-est_sol_pend">
				<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
			</li>
			<li  class="clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'est_sol_comp')echo "active"; }?> " data="1.5-est_sol_comp">
				<a class="AraucoColor" href="<?php echo base_url() ?>est/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
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
			</ul>
		</li>
	</ul>
</li>


<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #fdcc3c"> Marina Del Sol </span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 5)echo "style='display: block;'"; }?>>
		<li>		
				<li  class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_pendie')echo "active"; }?> " data="5.41-marina_sol_pendie">
					<a class="marinaColor" href="<?php echo base_url() ?>marina/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--5.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_compl')echo "active"; }?> " data="5.41-marina_sol_compl">
					<a class="marinaColor" href="<?php echo base_url() ?>marina/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_pen_baj')echo "active"; }?> " data="5.41-marina_sol_pen_baj">
					<a class="marinaColor" href="<?php echo base_url() ?>marina/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_sol_compl_baj')echo "active"; }?> " data="5.41-marina_sol_compl_baj">
					<a class="marinaColor" href="<?php echo base_url() ?>marina/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			<?php if ($this->session->userdata('id')==24) { ?>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_listado')echo "active"; }?> " data="5.41-marina_listado">
					<a href="<?php echo base_url() ?>marina/requerimientos/listado"><i class="fa fa-home"></i> <span class="title"> Requerimientos </span></a>
				</li>
				<li><a href="<?php echo base_url() ?>est/requerimiento/generar_dt"><i class="fa fa-home"></i> <span class="title">Generar DT </span></a> <span class="badge"> NEW</span></li>
			<?php }?>
		</li>
	</ul>
</li>
<!--########### Marina Chillan	########### -->
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #e6a614bf"> Marina Chillán</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<li>
			
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
			
		</li>
	</ul>
</li>



<!---Terramar-->
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" style="color: #FF8633"> Terramar</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<li>
			
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'marina_chillan_sol_pendie')echo "active"; }?> " data="6.41-wood_sol_pendie">
					<a class="WoodColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_pendientes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a>
				</li>
				<!--6.41-->
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_compl')echo "active"; }?> " data="6.41-terramar_sol_compl">
					<a class="terramarColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas"><i class="fa fa-user"></i> <span class="title"> Solicitudes Completas </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_pen_baj')echo "active"; }?> " data="6.41-terramar_sol_pen_baj">
					<a class="terramarColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_pendientes_baja"><i class="fa fa-user"></i> <span class="title"> Solicitud en proceso de baja </span></a>
				</li>
				<li class=" clickButtonMenu <?php if(isset($nombre)){ if($nombre === 'terramar_sol_compl_baj')echo "active"; }?> " data="6.41-terramar_sol_compl_baj">
					<a class="terramarColor" href="<?php echo base_url() ?>terramar/contratos/solicitudes_completas_baja"><i class="fa fa-user"></i> <span class="title"> Solicitudes Bajadas </span></a>
				</li>
			
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
	</ul>
</li>
<li  <?php if(isset($numMenu)){if ($numMenu == 5)echo "class='open'"; }?>>
	<a href="javascript:void(0)"><i class="fa fa-home"></i> <span class="title" >SANATORIO ALEMAN</span></a>
	<ul class="sub-menu" <?php if(isset($numMenu)){if ($numMenu == 6)echo "style='display: block;'"; }?>>
		<!--3.1-->
		
		<!--3.2-->
		
		<!--3.3-->
	
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