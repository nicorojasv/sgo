<?php 
	if ($this->session->userdata('error')==1) {//al guardar requerimiento
?>
			<script type="text/javascript">
			alertify.alert('Anexo de trabajo no creado', 'Olvido ingresar fecha de termino para Anexo de Contrato');

			</script>
		<?php
			$this->session->unset_userdata('error');		
	}else if($this->session->userdata('error')==2) {
?>
			<script type="text/javascript">
				alertify.success('Anexo de Trabajo Creado Exitosamente');
			</script>
<?php
			$this->session->unset_userdata('error');		
	}else if ($this->session->userdata('error')==3) {
?>
			<script type="text/javascript">
			alertify.alert('Anexo de trabajo no creado', 'Al parecer faltan datos del contrato, contactese con el administrador del sistema');
			</script>
<?php
		$this->session->unset_userdata('error');
	}else if ($this->session->userdata('error')==4) {
?>
			<script type="text/javascript">
				alertify.success('Anexo de Trabajo Actualizado Exitosamente');
			</script>
<?php
		$this->session->unset_userdata('error');
	}else if ($this->session->userdata('error')==5) {
?>
			<script type="text/javascript">
				alertify.success('Anexo Enviado a revision');
			</script>
<?php
		$this->session->unset_userdata('error');
	}else if ($this->session->userdata('error')==6) {
?>
			<script type="text/javascript">
				alertify.success('Anexo eliminado exitosamente');
			</script>
<?php
		$this->session->unset_userdata('error');
	}
?>

<div class="panel panel-white">
	<div class="panel-heading">
		<?php if($datos_generales != FALSE){ ?>
			<?php foreach ($datos_generales as $usu){ ?>
				<div class="row">
					<div class="col-md-6 col-sd-6">
						<h5><b><u>Datos trabajador:</u></b></h5>
						<table class="table">
							<tbody>
								<tr>
									<td><b>Nombres </b></td>
									<td><?php echo $nombres=$usu->nombres_apellidos ?></td>
								</tr>
								<tr>
									<td><b>Rut</b></td>
									<td><?php echo $usu->rut ?></td>
								</tr>
								<tr>
									<td><b>Estado Civil</b></td>
									<td><?php echo $usu->estado_civil ?></td>
								</tr>
								<tr>
									<td><b>Fecha Nacimiento</b></td>
									<td><?php echo $usu->fecha_nac ?></td>
								</tr>
								<tr>
									<td><b>Domicilio</b></td>
									<td><?php echo $usu->domicilo ?></td>
								</tr>
								<tr>
									<td><b>Ciudad</b></td>
									<td><?php echo $usu->ciudad ?></td>
								</tr>
								<tr>
									<td><b>Previsión</b></td>
									<td><?php echo $usu->prevision ?></td>
								</tr>
								<tr>
									<td><b>Salud</b></td>
									<td><?php echo $usu->salud ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6  col-sd-6">
						<h5><b><u>Datos adicionales:</u></b></h5>
						<table class="table">
							<tbody>
								<tr>
									<td><b>Nombre Requerimiento</b></td>
									<td><font color="#0101DF"><?php echo $usu->nombre_req ?></font></td>
								</tr>
								<tr>
									<td><b>Referido</b></td>
									<td><?php if($usu->referido == 1) echo "SI"; else echo "NO";  ?></td>
								</tr>
								<tr>
									<td><b>Puesto de trabajo/Cargo</b></td>
									<td><?php echo $usu->cargo ?></td>
								</tr>
								<tr>
									<td><b>Area Trabajo</b></td>
									<td><?php echo $usu->area ?></td>
								</tr>
								<tr>
									<td><b>Centro de Costo</b></td>
									<td><?php echo $usu->nombre_centro_costo ?></td>
								</tr>
								<tr>
									<td><b>Nivel Educacional</b></td>
									<td><?php echo $usu->nivel_estudios ?></td>
								</tr>
								
								<tr>
									<td><b>Teléfono</b></td>
									<td><?php echo $usu->telefono ?></td>
								</tr>
								<tr>
									<td><b>Nacionalidad</b></td>
									<td><?php echo $usu->nacionalidad ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<h5><b><u>Datos empresa:</u></b></h5>
				<div class="row">
					<div class="col-md-6  col-sd-6">
						<table class="table">
							<tbody>
								<tr>
									<td><b>Razón Social</b></td>
									<td><?php echo $usu->nombre_centro_costo ?></td>
								</tr>
								<tr>
									<td><b>Rut</b></td>
									<td><?php echo $usu->rut_centro_costo ?></td>
								</tr>
								<tr>
									<td><b>Planta</b></td>
									<td><?php echo $usu->nombre_planta ?></td>
								</tr>
								<tr>
									<td><b>Id </b></td>
									<td><?php echo $usu->id_empresa ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-6  col-sd-">
						<table class="table">
							<tbody>
								<tr>
									<td><b>Dirección Planta</b></td>
									<td><?php echo $usu->direccion_planta ?></td>
								</tr>
								<tr>
				                  <td><b>Comuna Planta</b></td>
				                  <td>
				                    <?php echo $usu->ciudad_planta ?>
				                  </td>
				                </tr>
								<tr>
									<td><b>Región Planta</b></td>
									<td><?php echo $usu->region_planta ?></td>
								</tr>
								<tr>
									<td><b>Tipo Gratificación Planta</b></td>
									<td><?php echo $usu->tipo_gratificacion ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>

	<div class="panel-body">
		
		<div class="col-md-12" align="right">
			<?php 
				if (empty($contratos)) {
			?>
          	<a data-toggle="modal" href="<?php echo base_url() ?>carrera/requerimientos/modal_agregar_contrato_anexo/<?php echo $id_usuario ?>/1/<?php echo $id_asc_area_req ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalEditar"><input type="button" class='btn btn-blue' value="Agregar Contrato"></a>

          	<?php 
          		}
				if (empty($contratos)) {
			?>
					<a data-toggle="modal" data-target="#ModalAnexoSIN" ><input  type="button" class='btn btn-default' value="Agregar Anexo"></a>
			<?php
				}else{
					if ($noCrear == true) {
			?>
						<a data-toggle="modal" data-target="#ModalAnexoNoCrear"><input type="button" class='btn btn-warning' value="Agregar Anexo"></a>
			<?php 
					}else{
			?>
          				<a data-toggle="modal" href="<?php echo base_url() ?>carrera/requerimientos/modal_agregar_anexo/<?php echo $id_usuario ?>/2/<?php echo $id_asc_area_req ?>/<?php echo $id_area_cargo_req ?>" id="AgregarAnexo" data-target="#ModalAnexo"><input type="button" class='btn btn-green' value="Agregar Anexo"></a>

          	<?php
          			}
          		}
          			$idArchivo = isset($cartaTermino[0])?$cartaTermino[0]:null;
          			$fechaTerminoContrato = isset($cartaTermino[1])?$cartaTermino[1]:null;
          			$tipoArchivo = isset($cartaTermino[2])?$cartaTermino[2]:null;
          			//$dosDiasAntesDeTerminoContrato = date("Y-m-d",strtotime($fechaTerminoContrato."- 3 days")); 
          			//echo $dosDiasAntesDeTerminoContrato;
          			//echo $fechaTerminoContrato;
          			if ($idArchivo != null) {
          	?>
						<a  href="<?php echo base_url() ?>carrera/requerimientos/descargar_carta_termino/<?php echo $id_usuario ?>/<?php echo $idArchivo ?>/<?php echo $tipoArchivo ?>"><i title="Descargar Carta Termino" class="btn fa fa-envelope" aria-hidden="true"></i></a>
          	<?php
          			}
          	?>
			<br><br>
		</div>
		<div id="content" align="center">
			
		</div>
		<div class="col-md-12">
			<table id='example1'>
				<thead>
					<th class="col-sm-2">ID</th>
					<th class="col-sm-2">Tipo Archivo</th>
					<th class="col-sm-2">Causal</th>
					<th class="col-sm-2">Motivo</th>
					<th class="col-sm-2">Fecha Inicio</th>
					<th class="col-sm-2">Fecha Termino</th>
					<th class="col-sm-2">Jornada</th>
					<th class="col-sm-2">Renta Imponible</th>
					<th class="col-sm-2">opciones</th>
				</thead>
				<tbody>
					<?php 
					//var_dump($contratos);
						foreach ($contratos as $row) {
					?>
						<tr>
							<td ><?php echo $row->id_req_usu_arch ?> </td>
							<td>Contrato</td>
							<td><?php echo $row->causal ?></td>
							<td><?php echo substr($row->motivo, 0, 40)."...."; ?></td>
							<td><?php echo $row->fecha_inicio ?></td>
							<td><?php echo $row->fecha_termino ?></td>
							<td><?php echo "<label title='".str_replace("<w:br/>","\n", $row->descripcion_jornada)."'>".$row->jornada."</label>" ?></td>
							<td><?php echo $row->renta_imponible ?></td>
    	                    <td align="center">
    	                    	<a data-toggle="modal" href="<?php echo base_url() ?>carrera/requerimientos/modal_administrar_contrato_anexo_doc_general/<?php echo $row->id_req_usu_arch ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalEditar2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    	                    <?php 
    	                    	if ($row->url) {
    	                    ?>
    	                    | <a title="Descargar Contrato Firmado"  href="<?php echo base_url().$row->url ?>"><i style="color: green" class="fa fa-cloud-upload" aria-hidden="true"></i></a>
    	                    <?php	
    	                    	}else{
    	                    ?>
    	                    |	<a title="Subir Contrato Firmado"  data-toggle="modal" href="<?php echo base_url() ?>carrera/requerimientos/modal_administrar_archivo_usu/<?php echo $row->id_req_usu_arch ?>/<?php echo $row->idAreaCargo ?>" data-target="#ModalEditar2"><i style="color: black" class="fa fa-cloud-upload" aria-hidden="true"></i></a>
    	                    <?php
    	                    	}
    	                    	if ($row->fecha_termino2>= date('Y-m-d')) {
    	                    ?>
    	                    <content class="btnFiniquito">| <a href="javascript:void(0)" class="finiquitar" data-idarchivo="<?php echo $row->id_req_usu_arch ?>"  data-termino="<?php echo $row->fecha_termino ?>" data-tipo="1" data-inicio="<?php echo $row->fecha_inicio ?>" data-trabajador="<?php echo $row->usuario_id ?>" title="Finiquitar"><i style="color:red;" class="fa fa-minus-square" aria-hidden="true"></i></a></content>
    	                     <?php 
    	                     	}
    	                     ?>
    	                    </td>

						</tr>
					<?php 
					if ($this->session->userdata('tipo_usuario') == 8) {
						//var_dump($anexos);
					}
							if (isset($row->estadoContrato)) {
								$contrato = $row->estadoContrato;
							}
						
						} ?>
					<?php foreach ($anexos as $row) { ?>
						<tr id="<?php echo $row->id_req_usu_arch.'tr'; ?>">
							<td><?php echo $row->id_req_usu_arch ?></td>
							<td>Anexo</td>
							<td><?php echo $row->causal ?></td>
							<td></td>
							<td><?php echo $row->fecha_inicio ?></td>
							<td><?php echo $row->fecha_termino ?></td>
							<td></td>
							<td></td>
							<td align="center"  id="<?php echo $row->id_req_usu_arch.'td'; ?>"<?php if ($row->estado == 6) { ?> style=" border: 1px solid #ff0000; " title="Rechazado " <?php }?>>
					
    	                    	<?php 
    	                    		if ($row->estado == 0) { //creado
    	                    	?>
    	                    			<a data-toggle="modal" title="Modificar Fecha Termino" href="<?php echo base_url() ?>carrera/requerimientos/modal_administrar_anexo/<?php echo $row->id_req_usu_arch ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalAnexo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> |
    	                    		<?php if ($contrato ==1) { ?>
    	                    			<a onclick="enviar_revision(this)" data-id="<?php echo $row->id_req_usu_arch ?>" data-nombre="<?php echo $nombres ?>" data-fecha="<?php echo $row->fecha_termino?>"  title="Enviar a revision"><i style="cursor: pointer;" class="fa fa-arrow-up" aria-hidden="true"></i></a> |
    	                    		<?php }else{?>
    	                    			<a  title="No es posible enviar a revision si no hay contrato validado"><i style="cursor: pointer;color: black" class="fa fa-arrow-up" aria-hidden="true"></i></a> |
    	                    		<?php }?>
    	                    			<!--<a href="<?php echo base_url() ?>carrera/requerimientos/eliminar_anexo/<?php echo $row->id_req_usu_arch ?>" title="Eliminar Anexo"><i style="color:red;" class="fa fa-times" aria-hidden="true"></i></a>-->
    	                    			<a onclick="confirmar(this)" data-id="<?php echo $row->id_req_usu_arch ?>" data-nombre="<?php echo $nombres ?>" data-fecha="<?php echo $row->fecha_termino?>" title="Eliminar Anexo"><i style="color:red; cursor: pointer;" class="fa fa-times" aria-hidden="true"></i></a>
    	                    	<?php	
    	                    		}elseif ($row->estado == 1) {// en espera de revision
    	                    	?>
    	                    			<a href="javascript:void(0)" title="En espera de revision"><i style="color: yellow" class="fa fa-pause" aria-hidden="true"></i></a>
    	                    	<?php 
    	                    		}elseif ($row->estado == 2) {// ya revisado
    	                    	?>
    	                    			<a href="<?php echo base_url() ?>carrera/requerimientos/descargar_anexo/<?php echo $row->id_req_usu_arch ?>" title="Descargar Anexo"><i style="color: green" class="fa fa-download" aria-hidden="true"></i></a>
    	                    		<?php 
			    	                    	if ($row->url) {
			    	                    ?>
			    	                    | <a title="Descargar Anexo Firmado"  href="<?php echo base_url().$row->url ?>"><i style="color: green" class="fa fa-cloud-upload" aria-hidden="true"></i></a>
			    	                    <?php	
			    	                    	}else{
			    	                    ?>
			    	                    |	<a title="Subir Anexo Firmado"  data-toggle="modal" href="<?php echo base_url() ?>carrera/requerimientos/modal_cargar_anexo/<?php echo $row->id_req_usu_arch ?>" data-target="#ModalEditar2"><i style="color: black" class="fa fa-cloud-upload" aria-hidden="true"></i></a>
			    	                <?php
			    	                    	}
			    	                ?>
    	                    	<?php
    	                    		}elseif ($row->estado == 6) {// ya revisado
    	                    	?>
									<a data-toggle="modal" title="Modificar Fecha Termino" href="<?php echo base_url() ?>carrera/requerimientos/modal_administrar_anexo/<?php echo $row->id_req_usu_arch ?>/<?php echo $id_area_cargo_req ?>" data-target="#ModalAnexo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> | 
    	                    			<a onclick="enviar_revision(this)" data-id="<?php echo $row->id_req_usu_arch ?>" data-nombre="<?php echo $nombres ?>" data-fecha="<?php echo $row->fecha_termino?>"  title="Enviar a revision"><i style="cursor: pointer;" class="fa fa-arrow-up" aria-hidden="true"></i></a> |
    	                    			<a onclick="confirmar(this)" data-id="<?php echo $row->id_req_usu_arch ?>" data-nombre="<?php echo $nombres ?>" data-fecha="<?php echo $row->fecha_termino?>" title="Eliminar Anexo"><i style="color:red; cursor: pointer;" class="fa fa-times" aria-hidden="true"></i></a>
    	                    	<?php 
    	                    	}
    	                    	if ($row->fecha_termino2> date('Y-m-d')) {
    	                    	?>
    	                    	<content class="btnFiniquito">| <a href="javascript:void(0)" class="finiquitar" data-idarchivo="<?php echo $row->id_req_usu_arch ?>"  data-termino="<?php echo $row->fecha_termino ?>" data-tipo="2" data-inicio="<?php echo $row->fecha_inicio ?>" data-trabajador="<?php echo $row->usuario_id ?>" title="Finiquitar"><i style="color:red;" class="fa fa-minus-square" aria-hidden="true"></i></a></content>
    	                    	<?php 
    	                    		}
    	                    	?>
    	                    </td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<br>
		</div>
	</div>
</div>

<!-- Modal Agregar/Editar Doc. Contractuales-->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Modal Agregar/Editar Doc. Contractuales-->
<div class="modal fade" id="ModalAnexo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->
<div class="modal fade" id="ModalAnexoSIN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-body">
      	    <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Imposible crear <b>Anexos de contrato</b> si trabajador no posee Contrato de Trabajo</h4>
      </div>

      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
<div class="modal fade" id="ModalAnexoNoCrear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-body">
      	    <div class="modal-header" style="text-align:center">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Imposible crear <b>Anexo</b>, ya que la fecha de hoy <?php echo date('d-m-Y')?> es mayor a la fecha de termino del Contrato</h4>
      </div>

      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Doc. Contractuales-->
<div class="modal fade" id="ModalEditar2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-body"></div>
    </div>
  </div>
</div>
<!-- End Modal -->

<script type="text/javascript">
	//$(this).attr('data');
	base_url = '<?php echo base_url();?>';
	function confirmar(e){//Funcion de confirmar eliminacion de Anexo
		var id = $(e).attr('data-id');
		var nombre = $(e).attr('data-nombre');
		var fechaTermino = $(e).attr('data-fecha');
		  	fecha= fechaTermino.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
		  	alertify.confirm('¿Esta seguro de eliminar este anexo?', 'El anexo de '+nombre+' con fecha de termino: <b>'+fecha+'</b> sera eliminado.', 
		  	function(){ //Si confirmo 
		  		        $.ajax({
				            type: "POST",
				            url: base_url+"carrera/requerimientos/eliminar_anexo/"+id,
				            data: id,
				            dataType: "json",
				            success: function(data) {   
					            if (data ==1) {
					            	$('#'+id+'tr').fadeOut('3000'), function(){
	                                	$(this).remove();
	                            	}
	                            		alertify.success('Ya esta, el anexo fue eliminado exitosamente')
					            }else{
					            	alertify.error('no fue posible eliminar')
					            }  
				            }
				        });
				 }
            , function(){ //Si cancelo
            	alertify.error('OK, en otro momento lo eliminamos')}).set('labels', {ok:'Si, seguro!', cancel:'No, en otro momento!'});;
	}
	function enviar_revision(e){//Funcion de confirmar eliminacion de Anexo
		
		var id = $(e).attr('data-id');
		var nombre = $(e).attr('data-nombre');
		var fechaTermino = $(e).attr('data-fecha');
		  	fecha= fechaTermino.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3-$2-$1');
		  	alertify.confirm('¿Enviar anexo a revision?', 'El anexo de '+nombre+' con fecha de termino: <b>'+fecha+'</b> sera enviado a revision.', 
		  	function(){ //Si confirmo 
		  		$('#content').html("<div class='loading'><img src='"+base_url+"extras/img/loader2.gif' alt='loading' /><br/>Un momento, por favor...</div>");
		  		        $.ajax({
				            type: "POST",
				            url: base_url+"carrera/requerimientos/enviar_revision/"+id,
				            data: id,
				            dataType: "json",
				            success: function(data) {  
					            if (data ==1) {
					            	$('#'+id+'td').empty();
                        			$('#'+id+'td').append('<a href="javascript:void(0)" title="En espera de revision"><i style="color: yellow" class="fa fa-pause" aria-hidden="true"></i></a>');
	                            		alertify.success('Ok, ya informamos de tu solicitud')
	                            		$('#content').fadeIn(1000).html("");
					            }else{
					            	alertify.error('no fue posible enviar');
					            	$('#content').fadeIn(1000).html("");
					            }  
				            },
				            error: function() {
			                    $('#content').fadeIn(1000).html("");
			                    $('#content').html("<div class='loading'><img src='"+base_url+"extras/img/no.gif' alt='loading' /><br/>A ocurrido algo inoportuno, favor recargar pagina...</div>");
			                    alertify.error('Ocurrio un problema , intente recargar la pagina')
			                }
				        });
				 }
            , function(){ //Si cancelo
            	alertify.error('OK, no lo enviaremos por ahora')
            }
            ).set('labels', {ok:'Si, enviar!', cancel:'No, en otro momento!'});;
	}
	/*#yayo 25-09-2019*/
	$(document).on('click', '.finiquitar', function() {
		$('.miFormulario').trigger("reset"); 
		var termino = $(this).data('termino');
		var inicio = $(this).data('inicio');
		var idarchivo = $(this).data('idarchivo');
		var idTrabajador = $(this).data('trabajador');
		var tipo = $(this).data('tipo');
		$('#idArchivo').val(idarchivo);
		$('#idTrabajador').val(idTrabajador);
		$('#tipo').val(tipo);
		$( "#datepicker" ).datepicker( "destroy" );
		$("#datepicker").datepicker({ minDate:inicio, maxDate: termino  });
		$('#myModal').modal('show');
	});

</script>
<?php
	if ($this->session->userdata('abrirModalAnexo')) {
?>
		<script>
			$(document).ready(function(){
				document.getElementById("AgregarAnexo").click();
				//alert('entre');
			});
			// $('#AgregarAnexo').click();
		</script>
<?php
		$this->session->unset_userdata('abrirModalAnexo');
	}
?>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog ">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Finiquitando Contrato </h4>
        </div>
        <form class="miFormulario"  onsubmit="return false;">
        <div class="modal-body">
        	<input type="hidden" name="idArchivo" id="idArchivo">
        	<input type="hidden" name="idTrabajador" id="idTrabajador">
        	<input type="hidden" name="tipo" id="tipo">
        	<div class="form-group row">
                <label for="curso_add" class="col-sm-3 col-form-label">Fecha de Finiquito:</label>
                <div class="col-sm-9">
                	<input type="" name="datepicker" id="datepicker" autocomplete="off" readonly class="form-control" style="cursor: pointer;">
                </div>
            </div>
            <div class="form-group row">
                <label for="curso_add" class="col-sm-3 col-form-label">Comentario:</label>
                <div class="col-sm-9">
                	<textarea class="form-control" name="comentario" id="comentario"></textarea>
                </div>
            </div>         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary enviarFechaFiniquito" data-dismiss="modal">Aceptar</button>
        </div>
   		 </form>
      </div>
      
    </div>
  </div>
  

 <script>
 $.datepicker.regional['es'] = {
 closeText: 'Cerrar',
 prevText: '< Ant',
 nextText: 'Sig >',
 currentText: 'Hoy',
 monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
 dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
 dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
 dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
 weekHeader: 'Sm',
 //dateFormat: 'dd-mm-yy',
 dateFormat: 'yy-mm-dd',
 firstDay: 1,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ''
 };
$.datepicker.setDefaults($.datepicker.regional['es']);

$(document).on('click', '.enviarFechaFiniquito', function() {
	    $.ajax({
            type: 'POST',
            url: base_url+'carrera/requerimientos/guardar_fecha_finiquito',
            data: {
                'fecha_termino2': $('#datepicker').val(),
                'comentario': $('#comentario').val(),
                'tipo_archivo': $('#tipo').val(),
                'id_archivo': $('#idArchivo').val(),
                'id_trabajador': $('#idTrabajador').val(),
            },
            beforeSend: function () {
		        $('#content').html("<div class='loading'><img src='"+base_url+"extras/img/loader2.gif' alt='loading' /><br/>Un momento, por favor...</div>");
		    },
		    complete: function () {
		        $('#content').html("");
		    },
            success: function(data) { 
            	console.log(data.trim())
	            if (data.trim() == 0) {
	            	setTimeout(function () {
                            $('#myModal').modal('show');
                            alertify.error('Ambos campos son requeridos');
                        }, 500);
	            	

	            }else{
	            	if (data.trim()==1) {
	            		$('.btnFiniquito').fadeOut('9000');
	            		alertify.success('Se a finiquitado el contrato');
	            	}else if (data.trim()==2) {
	            		$('.btnFiniquito').fadeOut('9000');
	            		alertify.success('Se a finiquitado el Anexo');
	            	}
	            	console.log(data)
	            }
            },
            error: function() {
            	console.log(data)
            }
        });
});


</script>