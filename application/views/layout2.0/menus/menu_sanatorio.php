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
		
		
		
		
		<!--3.5-->
		
		<!--3.6-->
		
	</ul>
</li>