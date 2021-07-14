<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores</h4>
	</div>
	<div class="panel-body">
		<div class="row" >
			<div class="col-md-7">
			</div>
			<div class="col-md-2">
				<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>carrera/trabajadores/crear" target="_blank"> Agregar Trabajador </a>
				<br><br>
			</div>
			<div class="col-md-3" align="center">
            <form action="<?php echo base_url() ?>carrera/trabajadores/exportar_excel_contratos_y_anexos" method="post" target="_blank" id="FormularioExportacion">
              <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="image" src="<?php echo base_url() ?>extras/imagenes/Excel-Export.jpg" class="botonExcelcarreraTrabajadores " value="Exportar a Excel">
              <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
            </form>
            <br>
        </div>
		</div>
		<table id="example1">
			<thead>
				<tr>
					<th style="width:1%">#</th>
					<th>Rut</th>
					<th>Nombres y Apellidos</th>
					<th>Telefono</th>
					<th>Fecha<br>Nacim.</th>
					<th>Direccion</th>
					<th>Ciudad</th>
					<th>Salud</th>
					<th>Afp</th>
					<th style="width:5%">Herram.</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $row->rut_usuario ?></td>
					<td><?php echo $row->nombres." ". $row->paterno." ". $row->materno ?></td>
					<td><?php echo $row->fono ?></td>
					<td><?php echo $row->fecha_nac ?></td>
					<td><?php echo $row->direccion ?></td>
					<td><?php echo $row->ciudad ?></td>
					<td><?php echo $row->salud ?></td>
					<td><?php echo $row->afp ?></td>
					<td>
						<a title="Editar Trabajador" href="<?php echo base_url() ?>carrera/trabajadores/detalle/<?php echo $row->id_usuario ?>" target="_blank" ><i class="fa fa-pencil fa-fw"></i></a>
						<a href="<?php echo base_url() ?>carrera/trabajadores/anotaciones/<?php echo $row->id_usuario ?>" title="<?php if(empty($row->listaNegra))echo "agregar a lista negra / anotacion"; else echo "en lista negra" ?>"><?php if(empty($row->listaNegra)){ ?><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><?php }else{?><i class="fa fa-thumbs-o-down" style="color:red" aria-hidden="true"></i> <?php }?></a>
						<!--
						<a title="Eliminar Trabajador" class="eliminar" href="<?php echo base_url() ?>carrera/trabajadores/eliminar_trabajador/<?php echo $row->id_usuario ?>"><i class="fa fa-trash-o"></i></a>
						-->
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>


<div id="divTableDataHolder" style="display:none">
   <meta content="charset=UTF-8"/>
  <table id="Exportar_a_Excel" style="border-collapse:collapse;">
    <thead>
		<th>#</th>
		<th>Rut</th>
		<th>Nombres y Apellidos</th>
		<th>Telefono</th>
		<th>Fecha<br>Nacim.</th>
		<th>Direccion</th>
		<th>Ciudad</th>
		<th>Salud</th>
		<th>Afp</th>
    </thead>
    <tbody>
     <?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $row->rut_usuario ?></td>
					<td><?php echo $row->nombres." ". $row->paterno." ". $row->materno ?></td>
					<td><?php echo $row->fono ?></td>
					<td><?php echo $row->fecha_nac ?></td>
					<td><?php echo $row->direccion ?></td>
					<td><?php echo $row->ciudad ?></td>
					<td><?php echo $row->salud ?></td>
					<td><?php echo $row->afp ?></td>

				</tr>
				<?php } ?>
    </tbody>
  </table>
</div>