<?php if(!$resultados){ ?>
	<p>Error al subir el archivo, no coincide las celdas con lo que se necesita guardar.</p>
<?php } else{ ?>
	<p>
		Guardados correctamente: <?php echo count($resultados['correcto']) ?>, 
		Errores encontrados: <?php echo $resultados['total_errores'] ?>, 
		<?php if($resultados['total_repetidos'] > 0){ ?>
			Se encontraron <?php echo $resultados['total_repetidos'] ?> valor(es) repetido(s), 
		<?php } ?>
		De un total de: <?php echo $resultados['totales'] ?> fila(s)
	</p>
	<?php if($resultados['total_errores'] > 0){ ?>
		<p><b>Errores:</b></p>
		<?php foreach($resultados['erroneos'] as $e){ ?>
			<p>Fila con problemas: <?php echo $e['fila'] ?></p>
			<p><b>Detalles:</b></p>
			<?php foreach($e['motivo'] as $m){ ?>
				<p>Columna: <?php echo $m['columna'] ?></p>
				<p>Motivo: <?php echo $m['texto'] ?></p>
				<hr />
			<?php } ?>
		<?php } ?>
	<?php } ?> 
	<?php if($resultados['total_errores'] < 1 && $resultados['total_repetidos'] < 1 ){ ?>
		<p>Se han ingresado los trabajadores correctamente, no existen errores </p>
	<?php } ?>
<?php } ?>