<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Revisar rut ingresados a examanes psicologicos</h4>
	</div>
	<div class="panel-body">
		<form action="<?php echo base_url() ?>usuarios/home/formulario_revisar_rut_existe" method='post'>
			<h3>Revisar si ecisten rut</h3>
            <input type="submit">
	    </form>
  		<form action="<?php echo base_url() ?>usuarios/home/formulario_revisar_rut_examenes_psicologicos" method='post'>
  			<h3>Actualizar información de examenes</h3>
            <input type="submit">
	    </form>
	</div>
</div>