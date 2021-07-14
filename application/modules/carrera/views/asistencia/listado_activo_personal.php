<div class="row">
<div class="panel panel-white"> 
<div class="col-md-1">
	
</div>
<div class="col-md-10">
	<h3> Listado Personal</h3>
	<p>En esta seccion se establece el estado de los trabajadores para fijar en la lista de asistencia,<br> Siendo Activo Aparecera en el listado a completar asistencia,<br>  Siendo Inactivo no pertenecera al listado a completar asistencia</p>
</div>

<div class="col-md-1">
<br>
		<?php 
			if ($volverBono) {
		?>
			<a href="<?php echo base_url() ?>carrera/asistencia/bonos"  class="btn  btn-row btn-default">volver</a>

		<?php 
			}else{
		?>
				<a href="<?php echo base_url() ?>carrera/asistencia"  class="btn  btn-row btn-default">volver</a>
		<?php 
			}
		?>
</div>
	<form action="<?php echo base_url() ?>carrera/asistencia/guardar_estado_asistencia" method="post" role="form" enctype="multipart/form-data">
	<table id="exampleListadoAsistencia" class="table " border="0">

            <thead >
                <tr style="background: #ccc">
                      <th style="text-align:center;">Rut</th>
                      <th style="text-align:center">Nombres</th>
                      <th style="text-align:center;">estado </th>

                </tr>     
            </thead>
            <tbody>  
            	<?php 
            		$i=0;
					foreach ($listado as $key) {
				?> 
                	<tr>
                        <td ><?php echo $key->rut_usuario ?></td>
                        <td ><?php echo $key->paterno." ".$key->materno.' '.$key->nombres; ?></td>
                        <input type="hidden" name="trabajadores[<?php echo $i; ?>]" value="<?php echo $key->id_usuario;?>">
                        <td style="text-align:center;" >
                        	<select name="estado[<?php echo $i ?>]" style="background: <?php if ($key->estado==1)echo "#98d298"; else echo "#e7a090" ?> ;">
								<option value="2" style="color: red;" value="2" <?php if($key->estado == 2)echo "selected" ?>>Inactivo</option>
								<option value="1" style="color: green;"<?php if($key->estado == 1)echo "selected" ?>>Activo</option>
							</select>
						</td>
                  </tr>
				<?php
				$i++;
					}
				?>
            </tbody>
	</table>
	<div class="row">
	<div class="col-md-10"></div>
	<div class="col-md-2">
		<button type="submit" name="Guardar" class="btn  btn-row btn-primary">Guardar</button>
	</div>
	<br>
	</div>
</form>
</div>
</div>