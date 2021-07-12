<script type="text/javascript">
	$(document).ready(function() {
    var table = $('#ejemplo').DataTable();
} );



</script>
<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores</h4>
	</div>
	<div class="panel-body">
		<div class="row" >
			<div class="col-md-7">
			</div>
			<div class="col-md-2">
				<a data-style="slide-right" class="btn btn-blue" href="<?php echo  base_url() ?>marina/trabajadores/crear" target="_blank"> Agregar Trabajador </a>
				<br><br>
			</div>
			<div class="col-md-3" align="center">
            <form action="<?php echo base_url() ?>marina/trabajadores/exportar_excel_contratos_y_anexos" method="post" target="_blank" id="FormularioExportacion">
              <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="image" src="<?php echo base_url() ?>extras/imagenes/Excel-Export.jpg" class="botonExcelmarinaTrabajadores " value="Exportar a Excel">
              <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
            </form>
            <br>
        </div>
		</div>
		<table id="ejemplo" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
			
					<th>Rut</th>
					<th>Nombres y Apellidos</th>
					<th>Telefono</th>
					<!--<th>Fecha<br>Nacim.</th>
					<th>Direccion</th>
					<th>Ciudad</th>
					<th>Salud</th>
					<th>Afp</th>
					<th>Correo</th>-->
					<th>especialidad</th>
					<th>Observacion</th>
					<th >Herram.</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
				<tr>
					
					<td style="width: 12%;"><?php echo $row->rut_usuario ?></td>
					<td><?php echo $row->nombres." ". $row->paterno." ". $row->materno ?></td>
					<td><?php echo $row->fono ?></td>
					<td><?php echo $row->especialidad?></td>
					<td style="width: 30%;overflow: auto;" id="<?php echo $row->id_usuario ?>">
						<div class="col-md-10">
							<textarea type="text" style="display: block; width: 100%;"  class="edit" name="observacion" onblur="myFunction(<?php echo $row->id_usuario ?>, this.value)"><?php echo isset($row->observacion)?$row->observacion:NULL;?></textarea>
						</div>
						<div class="col-md-2">
							<?php 
							//var_dump($row->usuario_observacion);
								if ($row->usuario_observacion) {
							?>
								<a class="EliminarObservacionMarina" title="Eliminar Observacion" data-id="<?php echo $row->id_usuario ?>" style="cursor:pointer;" data-delete="<?php echo $row->id_usuario ?>" ><i class="fa fa-times " style="font-size: 10px; color: red;" aria-hidden="true"></i></a>
							<?php		
								}
							?>
							 
						</div>
					</td>
					<td>
						<a title="Editar Trabajador" href="<?php echo base_url() ?>marina/trabajadores/detalle/<?php echo $row->id_usuario ?>" target="_blank" ><i class="fa fa-pencil fa-fw"></i></a>
						<a href="<?php echo base_url() ?>marina/trabajadores/anotaciones/<?php echo $row->id_usuario ?>" title="<?php if(empty($row->listaNegra))echo "agregar a lista negra / anotacion"; else echo "en lista negra" ?>"><?php if(empty($row->listaNegra)){ ?><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><?php }else{?><i class="fa fa-thumbs-o-down" style="color:red" aria-hidden="true"></i> <?php }?></a>
						<!--
						<a title="Eliminar Trabajador" class="eliminar" href="<?php echo base_url() ?>marina/trabajadores/eliminar_trabajador/<?php echo $row->id_usuario ?>"><i class="fa fa-trash-o"></i></a>
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
		<th>correo</th>
		<th>Nombre Banco</th>
		<th>Tipo Cuenta</th>
		<th>Cuenta Banco</th>
		<th>Nacionalidad</th>
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
					<td><?php echo $row->correo ?></td>
					<td><?php echo $row->nombreBanco?></td>
					<td><?php echo $row->tipo_cuenta?></td>
					<td><?php echo $row->cuenta_banco?></td>
					<td><?php echo $row->nacionalidad?></td>
				</tr>
				<?php } ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  function myFunction(id,value) {
  //	console.log(value)
                  var datos= value;
                  	if (!datos) {
                  		return false;
                  	}
                    $.ajax({
                      type:"post",
                      url: base_url+"marina/trabajadores/guardarObservacion/"+id,
                      data: {"datos": datos, "id": id},
                      success:function(data){
                      	console.log(data)
                          if (data == 1) {
                            alertify.success('Observacion Registrada ');
                          }else{
                            alertify.error('Sin Modificaciones');
                          }
                      }
                    });
    return false;              
}

	$(document).ready(function() {
  //  $('.EliminarObservacionMarina').click(function(){
    	$(document).on("click",".EliminarObservacionMarina",function(){ 
    	var idUsuario = $(this).attr('data-id');
    	var idBorrar = $(this).attr('data-delete');
		alertify.confirm('Esta seguro de eliminar Observacion', '', function(){ 
	    		$.ajax({
	            type: "POST",
	            url: base_url+"marina/trabajadores/eliminar_observacion/"+idUsuario,
	            data: idUsuario,
	            dataType: "json",
		            success: function(data) {  
		            	if (data == 1) {
							 alertify.success('Observacion Eliminada') 
			    			 $("#"+idBorrar).empty();
			    			 $("#"+idBorrar).append('<div class="col-md-10" ><textarea  type="text" style="display: block; width: 100%;" class="edit" name="observacion" onblur="myFunction('+idUsuario+' , this.value)"></textarea></div>');
		           		 }

		            }         
					
	      		});
			}
	        , function(){ 
	         	alertify.error('Cancelado')}
	         	);               
	});
});

</script>