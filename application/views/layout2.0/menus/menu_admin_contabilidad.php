<?php
/*$this->load->model('Empresa_planta_model');
$plantas_celulosas = $this->Empresa_planta_model->plantas_celulosas();
$plantas_paneles = $this->Empresa_planta_model->plantas_paneles();
$plantas_forestal = $this->Empresa_planta_model->plantas_forestal();*/
?>
<li>
	<a href="<?php echo base_url() ?>usuarios/home"><i class="fa fa-home"></i> <span class="title"> Inicio </span></a>
</li>

<li>
	<a href="<?php echo base_url() ?>est/trabajadores/base_datos_evaluaciones_ccosto"><i class="fa fa-home"></i> <span class="title"> Visualizacion Evaluacion Centro de Costo </span></a>
</li>

<!--<li><a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i> <span class="title"> Celulosa Arauco y Constitución S.A. </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php
			/*if (!empty($plantas_celulosas)){
				foreach ($plantas_celulosas as $row) {*/
		?>
			<li><a href="<?php //echo base_url() ?>est/trabajadores/base_datos_contratos/<?php //echo $row->id ?>"><i class="fa fa-user"></i> <span class="title"> <?php //echo $row->nombre ?></span></a></li>
		<?php
				//}
			//}
		?>
	</ul>
</li>
<li><a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i> <span class="title"> Paneles Arauco S.A. </span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php
			/*if (!empty($plantas_paneles)){
				foreach ($plantas_paneles as $row) {*/
		?>
			<li><a href="<?php //echo base_url() ?>est/trabajadores/base_datos_contratos/<?php //echo $row->id ?>"><i class="fa fa-user"></i> <span class="title"> <?php //echo $row->nombre ?></span></a></li>
		<?php
				//}
			//}
		?>
	</ul>
</li>
<li><a href="javascript:void(0)"><i class="fa fa-book" aria-hidden="true"></i> <span class="title"> Forestal Arauco S.A.</span><i class="icon-arrow"></i></a>
	<ul class="sub-menu">
		<?php
			/*if (!empty($plantas_forestal)){
				foreach ($plantas_forestal as $row) {*/
		?>
			<li><a href="<?php //echo base_url() ?>est/trabajadores/base_datos_contratos/<?php //echo $row->id ?>"><i class="fa fa-user"></i> <span class="title"> <?php //echo $row->nombre ?></span></a></li>
		<?php
				//}
			//}
		?>
	</ul>
</li>-->
<li>
	<a href="<?php echo base_url() ?>est/pensiones/informe_pensiones"><i class="fa fa-home"></i> <span class="title"> Informe Pensiones </span></a>
</li>