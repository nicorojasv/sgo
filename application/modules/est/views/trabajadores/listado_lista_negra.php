<script type="text/javascript">
	$(document).ready(function() {
	    var table = $('#ejemplo').DataTable();
	});
</script>
<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title">Listado de Trabajadores con restriccion de trabajar</h4>
	</div>
	<div class="panel-body">
		<?php 
			if($this->session->userdata('searchInTable')){
		?>
				<input type="hidden" name="searchInTable" id="searchInTable" value="<?php echo $this->session->userdata('searchInTable'); ?>">
		<?php 
			$this->session->unset_userdata('searchInTable');
			}
		?>
		<div class="row" >
			<div class="col-md-7">
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-3" align="center">

            <br>
        </div>
		</div>
		<table id="ejemplo" class="table table-striped table-bordered" style="width:100%">
			<thead>
				<tr>
			
					<th>Rut</th>
					<th>Nombre</th>
					<th>Observacion</th>
					<th>Liberar</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; foreach ($listado as $row){ $i += 1; ?>
				<tr class="trLista<?php echo $row->id ?>">
					<td style="width: 12%;"><?php echo $row->rutTrabajador ?></td>
					<td><?php echo $row->nombreTrabajador ?></td>
					<td><?php echo $row->anotacion?></td>
					<td align="center"><a href="javascript:void(0);" class="liberar" data-id="<?php echo $row->id ?>" data-nombre="<?php echo $row->nombreTrabajador ?>" data-anotacion="<?php echo $row->anotacion?>"><i class="fa fa-check-circle text-success  " aria-hidden="true"></i></a></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
		$(document).ready(function() {
			    	$(document).on("click",".liberar",function(){ 
			    	var idListaNegra = $(this).attr('data-id');
			    	var nombre = $(this).attr('data-nombre');
			    	var anotacion = $(this).attr('data-anotacion');
					alertify.confirm('Esta seguro de quitar restriccion a '+nombre, anotacion, function(){ 
				    		$.ajax({
				            type: "POST",
				            url: base_url+"est/trabajadores/liberar_lista_negra/"+idListaNegra,
				            data: idListaNegra,
				            dataType: "json",
					            success: function(data) {  
					            	if (data == 1) {
										 alertify.success('Restricción Eliminada') 
					           		 }
					           		$('.trLista'+idListaNegra).fadeOut('9000')
					            } 
				      		});
						}, function(){ 
				         	alertify.notify('Cancelado')}
				        ).set('labels', {ok:'Liberar', cancel:'Cerrar'});                
				});
			});

</script>

