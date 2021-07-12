<div class="panel panel-white">
  <div class="panel-body">
		<div class="row-fluid">
			<div class="row">
		        <div class="col-md-7" align="center">
		          	<h4 style='text-align:center;float:left;'><b>PLANTA: </b><?php echo $empresa_planta->nombre ?></h4>
		        </div>
		     </div>
			<div class="row">
				<div class="col-md-4" align="rigth"><b>Reporte de Gesti&oacute;n</b>
					<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
					  	<option title="INFORME ACTUAL: TRAZABILIDAD DOTACION POR PLANTAS" value="#">Avance de Contrataciones</option>
					  	<option title="BASE DE DATOS DE CONTRATOS EXPORTACION A EXCEL" value="<?php echo base_url() ?>mandante/base_datos_contratos/<?php echo $id_planta ?>">Base de Datos de Contratos</option>
					  	<option title="REPORTABILIDAD DOTACION EQUIVALENTE/CANTIDAD CONTRATOS/POR TRABAJADOR" value="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $id_planta ?>">Reportabilidad Dotaci&oacute;n</option>
					  	<option title="REPORTABILIDAD CAUSALES DE CONTRATOS" value="<?php echo base_url() ?>mandante/reporte_causales/<?php echo $id_planta ?>">Reportabilidad Causales</option>
					  	<option title="INDICADOR DE PERMANENCIA" value="<?php echo base_url() ?>mandante/indicador_permanencia/<?php echo $id_planta ?>">Indicador de Permanencia</option>
					</select>
	  				<br><br>
				</div>
				<div class="col-md-6" align="center"></div>
				<div class="col-md-2" align="center">
					<a href="<?php echo base_url() ?>mandante/detalle_requerimientos/<?php echo $id_planta ?>" title="DETALLE POR REQUERIMIENTOS <?php echo $empresa_planta->nombre ?>">Ver Detalle Requerimientos</a>
				</div>
			</div>
			<div class="span8 offset2" >
				<div title="PERSONAL EN SERVICIO EN PLANTA V/S DOTACION REQUERIDA" style='border: 1px solid black;padding-top:20px;padding-bottom:20px;padding-left:10px; padding-right:10px'>
					<div class='pgp-left' style='float:left' >
						<div class='pgp-title'>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					</div>
					<div class='pgp-center' style='float:left; margin-left:140px' >
						<span class='' style='float:left'>Personal en Planta con Contrato Firmado</span>
						<div class="progressBar progressBar1" style='margin-left:10px;float:left'><div></div></div>
					</div>
					<div class='pgp-right' style='float:right' >
						<div class=''><span class='circulito verde'></span>Personal en Planta: <?php echo $servicio ?> <span class='circulito rojo'></span>Dotaci&oacute;n Requerida: <?php echo $dotacion_total ?></div>
					</div>
					<div class='clear'></div>
					<div id="porcentaje_total" style="display: none;"><?php echo $porcentaje ?></div>
					<br>
				</div>
			</div>
			<div class="span10 offset1" style="margin-top:20px;">
				<div class='span12'>
					<table class='table table-hover table-condensed table-striped'>
						<thead style="background-color:#D7D7D7">
							<th style="text-align:center;width:220px"><b>Item</b></th>
							<th style="text-align:center;"><b>Cantidad</b></th>
							<th style="text-align:center;"><b>Total</b></th>
							<th style="text-align:center;" colspan="2"><b>Porcentaje</b></th>
						</thead>
						<tbody>
							<tr title="NO CONTACTADOS (SIN CONTACTO - NO RESPONDE - TELEFONO APAGADO - SIN LLAMAR - ETC)">
								<td><b>No Contactado</b></td>
								<td style="text-align:center;"><?php echo $no_contactado ?></td>
								<td style="text-align:center;"><?php echo $dotacion_total ?></td>
								<td style="text-align:center;" id="porcentaje_contactados"><?php echo $porcentaje_no_contactado ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar2" style=''><div></div></div></td>
							</tr>
							<tr title="EN PROCESO DE EVALUACION (PRUEBA CONOCIMIENTO, EXAMEN MEDICO, CHARLAS DE SEGURIDAD, ETC)">
								<td><b>Proceso de Contratacion</b></td>
								<td style="text-align:center;"><?php echo $contratos_en_proceso ?></td>
								<td style="text-align:center;"><?php echo $dotacion_total ?></td>
								<td style="text-align:center;" id="porcentaje_disponibilidad"><?php echo $porcentaje_contratos_en_proceso ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar3" style=''><div></div></div></td>
							</tr>
							<tr title="CONTRATOS FIRMADOS SIN LA NECESIDAD DE ESTAR EN PLANTA">
								<td><b>Contratos Firmados sin Ingreso a Planta</b></td>
								<td style="text-align:center;"><?php echo $contratos_firmados ?></td>
								<td style="text-align:center;"><?php echo $dotacion_total ?></td>
								<td style="text-align:center;" id="porcentaje_certificacion"><?php echo $porcentaje_contratos_firmados ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar4" style=''><div></div></div></td>
							</tr>
						</tbody>
					</table>
					<br>
					<table class='table table-hover table-condensed table-striped'>
						<thead style="background-color:#D7D7D7">
							<th style="text-align:center;width:220px"><b>Datos Adicional</b></th>
							<th style="text-align:center;">Cantidad</th>
							<th style="text-align:center;">Total</th>
							<th style="text-align:center;" colspan="2">Porcentaje</th>
						</thead>
						<tbody>
							<tr title="CONTRATOS FINALIZADOS">
								<td><b>Contratos Finalizados</b></td>
								<td style="text-align:center;"><?php echo $contratos_finalizados ?></td>
								<td style="text-align:center;"><?php echo $dotacion_total_total ?></td>
								<td style="text-align:center;" id="porcentaje_examenes"><?php echo $porcentaje_contratos_finalizados ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar5" style=''><div></div></div></td>
							</tr>
							<tr title="PERSONAL SOLICITADO POR EMPRESA MANDANTE">
								<td><b>Referidos</b></td>
								<td style="text-align:center;"><?php echo $referidos ?></td>
								<td style="text-align:center;"><?php echo $dotacion_total_total ?></td>
								<td style="text-align:center;" id="porcentaje_masso"><?php echo $porcentaje_referidos ?></td>
								<td style="text-align:center;width:210px;"><div class="progressBar progressBar6" style=''><div></div></div></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="span10 offset1" style="margin-top:20px;"></div>
		</div>
	</div>
</div>