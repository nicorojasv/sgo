<?php
$this->load->model('relacion_usuario_planta_model');
$plantas_celulosa = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 2);
$plantas_paneles_maderas = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 4);
$plantas_forestal = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 5);
$plantas_camanchacas = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 6);
$plantas_cargill = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 7);
?>
<li><a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a></li>
<li><a href="<?php echo base_url() ?>abastecimiento"><i class="fa fa-user"></i> <span class="title"> Abastecimiento </span> </a></li>
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
<li><a href="<?php echo base_url() ?>usuarios/perfil/index"><i class="fa fa-user"></i> <span class="title"> Perfil </span></a></li>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Trabajadores </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>usuarios/perfil/crear"><i class="fa fa-user"></i> <span class="title"> Crear Personal Trabajadores</span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/buscar_js"><i class="fa fa-group"></i> <span class="title"> Listado Trabajadores Activos </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_trabajadores_inactivos"><i class="fa fa-group"></i> <span class="title"> Listado Trabajadores Inactivos </span></a></li>
	</ul>
</li>
<li><a href="javascript:void(0)"><i class="fa fa-group"></i> <span class="title"> Requerimientos </span><i class="icon-arrow"></i> </a>	
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/requerimiento/agregar"><i class="fa fa-bullhorn"></i> <span class="title"> Crear Requerimiento </span></a></li>
		<?php if(!empty($plantas_celulosa)){ ?>
		<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Celulosa Arauco y Constitución S.A. </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<?php foreach($plantas_celulosa as $row){ ?>
				<li><a href="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $row->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row->nombre ?></span></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		<?php if(!empty($plantas_paneles_maderas)){ ?>
		<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Paneles Arauco S.A. </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<?php foreach ($plantas_paneles_maderas as $row2){ ?>
					<li><a href="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $row2->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row2->nombre ?></span></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		<?php if (!empty($plantas_forestal)){ ?>
		<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Forestal Arauco S.A. </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<?php foreach($plantas_forestal as $row3){ ?>
					<li><a href="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $row3->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row3->nombre ?></span></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		<?php if (!empty($plantas_camanchacas)){ ?>
		<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Camanchaca Pesca Sur S.A. </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<?php foreach($plantas_camanchacas as $row4){ ?>
					<li><a href="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $row4->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row4->nombre ?></span></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
		<?php if (!empty($plantas_cargill)){ ?>
		<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Camanchaca Pesca Sur S.A. </span><i class="icon-arrow"></i></a>
			<ul class="sub-menu">
				<?php foreach($plantas_cargill as $row5){ ?>
					<li><a href="<?php echo base_url() ?>est/requerimiento/listado/<?php echo $row5->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row5->nombre ?></span></a></li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
	</ul>
</li>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Revision Examenes </span></a>
	<ul class="sub-menu">
		<li><a href="<?php echo base_url() ?>est/trabajadores/solicitudes_revision_examenes"><i class="fa fa-user"></i> <span class="title"> Solicitudes Pendientes </span></a></li>
		<li><a href="<?php echo base_url() ?>est/trabajadores/listado_solicitudes_completas_sre"><i class="fa fa-user"></i> <span class="title"> Solicitudes Realizadas </span></a></li>
	</ul>
</li>
<li><a href="<?php echo base_url() ?>est/requerimiento/historico_carta_termino"><i class="fa fa-home"></i> <span class="title">Cartas Termino generadas </span></a></li>
<li><a href="<?php echo base_url() ?>est/solicitud_psicologia"><i class="fa fa-home"></i> <span class="title">Solicitud Evaluaciones <span class="badge"> NEW</span></span></a> </li>

<!--########### 	wood	########### -->
<?php if( $this->session->userdata('id') == 145 or  $this->session->userdata('id') == 42 or $this->session->userdata('id') == 25 ) { ?>
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
		<!--3.5-->
		

<?php } ?>