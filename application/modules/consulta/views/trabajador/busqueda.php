<script src="<?php echo base_url() ?>extras/js/bootstrap-typeahead.min.js" type="text/javascript"></script>
<div class="span9 offset1">
	<div class='span6'>
		<form action="#" method='post'>
		 	<fieldset>
		    	<legend>Busqueda de Trabajador</legend>
		    	<label>RUT</label>
		    	<input type="text" name='rut' value="<?php if(isset($value)){ echo $value; } ?>">
		    	<span class="help-block">Ejemplo: 12.345.678-9</span>
		    	<label>Nombre</label>
		    	<!--<input type="text" name='nombre' value="<?php if(isset($val_nb)){ echo $val_nb; } ?>">-->
		    	<select name='nombre' data-provide="typeahead" data-items="15">
		    		<option value=""></option>
		    		<?php foreach ($trab as $t) { ?>
		    			<option value="<?php echo $t->id ?>" <?php if(isset($val_nb)){ if($t->id == $val_nb) echo "SELECTED"; } ?>><?php echo $t->nombres.' '.$t->paterno.' '.$t->materno; ?></option>
		    		<?php } ?>
  				</select><br/>
		    	<!--<span class="help-block">Ejemplo: 12.345.678-9</span>-->
		    	<button type="submit" class="btn">Buscar</button>
		  	</fieldset>
		</form>
	</div>
	<div class="span5">
		<br/>
		<?php if (isset($id)){ ?>
		<h4><b><?php echo $nombre; ?></b>
			<a href="<?php echo base_url() ?>consulta/observaciones/anotaciones/<?php echo $id ?>" target="_blank"><img src="<?php 
				if ($ln == 0 ) echo base_url().'extras/images/circle_green_16_ns.png';
				if ($ln == 1 ) echo base_url().'extras/images/circle_yellow_16_ns.png';
				if ($ln == 2 ) echo base_url().'extras/images/circle_red_16_ns.png';
				if ($ln == 3 ) echo base_url().'extras/images/circle_red-yellow_16.png';
			?>"></a>
		</h4>
		<h5><b><?php echo $rut; ?></b></h5>
		<a target='_blank' href="<?php echo base_url() ?>consulta/trabajador/informe_eval/<?php echo $id ?>">Informe de Evaluaciones</a><br/>
		<a target='_blank' href="<?php echo base_url() ?>consulta/trabajador/perfil/<?php echo $id ?>">Perfil del Trabajador</a><br/>
		<a target='_blank' href="<?php echo base_url() ?>consulta/trabajador/trabajos/<?php echo $id ?>">Historial de Trabajador</a><br/>
		<?php } ?>
	</div>
</div>
