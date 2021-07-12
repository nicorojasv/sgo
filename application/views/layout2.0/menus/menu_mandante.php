<?php
$this->load->model('relacion_usuario_planta_model');
$plantas_celulosa = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 2);
$plantas_paneles_maderas = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 4);
$plantas_forestal = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 5);
$plantas_camanchacas = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 6);
$plantas_cargill = $this->relacion_usuario_planta_model->get_usuario_plantas($this->session->userdata('id'), 7);
?>
<li><a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a></li>
<?php if(!empty($plantas_celulosa)){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Celulosa Arauco y Constitución S.A. </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php foreach($plantas_celulosa as $row){ ?>
		<li><a href="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $row->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row->nombre ?></span></a></li>
		<?php } ?>
	</ul>
</li>
<?php } ?>
<?php if(!empty($plantas_paneles_maderas)){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Paneles Arauco S.A. </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php foreach ($plantas_paneles_maderas as $row2){ ?>
			<li><a href="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $row2->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row2->nombre ?></span></a></li>
		<?php } ?>
	</ul>
</li>
<?php } ?>
<?php if (!empty($plantas_forestal)){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Forestal Arauco S.A. </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php foreach($plantas_forestal as $row3){ ?>
			<li><a href="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $row3->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row3->nombre ?></span></a></li>
		<?php } ?>
	</ul>
</li>
<?php } ?>
<?php if (!empty($plantas_camanchacas)){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Camanchaca Pesca Sur S.A. </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php foreach($plantas_camanchacas as $row4){ ?>
			<li><a href="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $row4->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row4->nombre ?></span></a></li>
		<?php } ?>
	</ul>
</li>
<?php } ?>
<?php if (!empty($plantas_cargill)){ ?>
<li><a href="javascript:void(0)"><i class="fa fa-user"></i> <span class="title"> Cargill </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php foreach($plantas_cargill as $row5){ ?>
			<li><a href="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $row5->empresa_planta_id ?>"><i class="fa fa-user"></i> <span class="title"> <?php echo $row5->nombre ?></span></a></li>
		<?php } ?>
	</ul>
</li>
<?php } ?>
<li><a href="<?php echo base_url() ?>usuarios/perfil/documentos"><i class="fa fa-inbox"></i> <span class="title"> Documentos </span></a></li>
<li><a href="<?php echo base_url() ?>usuarios/perfil/contacto"><i class="fa fa-envelope"></i> <span class="title"> Contacto </span></a></li>