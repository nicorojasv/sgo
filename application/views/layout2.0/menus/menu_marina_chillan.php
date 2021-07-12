<!--########### 	Marina Chillan	########### -->
<li  >

	
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

	</ul>
</li>