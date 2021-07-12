<div class="panel panel-white">
  <div class="panel-body">
		<div class="row-fluid">
			<div class="row">
		        <div class="col-md-1"></div>
		        <div class="col-md-7" align="center">
		          	<h4 style='text-align:center;float:left;'><b>PLANTA: </b><?php echo $empresa_planta->nombre ?></h4>
		        </div>
		    </div>
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-4" align="rigth"><b>Reportabilidad Dotaci&oacute;n</b>
					<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
					  	<option title="INDICADOR DE PERMANENCIA" value="#">Indicador de Permanencia</option>
					  	<option title="TRAZABILIDAD DOTACION POR PLANTAS" value="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $id_planta ?>">Avance de Contrataciones</option>
					  	<option title="BASE DE DATOS DE CONTRATOS EXPORTACION A EXCEL" value="<?php echo base_url() ?>mandante/base_datos_contratos/<?php echo $id_planta ?>">Base de Datos de Contratos</option>
					  	<option title="INFORME ACTUAL: REPORTABILIDAD DOTACION EQUIVALENTE/CANTIDAD CONTRATOS/POR TRABAJADOR" value="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $id_planta ?>">Reportabilidad Dotaci&oacute;n</option>
					  	<option title="REPORTABILIDAD CAUSALES DE CONTRATOS" value="<?php echo base_url() ?>mandante/reporte_causales/<?php echo $id_planta ?>">Reportabilidad Causales</option>
					</select>
	  				<br><br>
				</div>
		        <div class="col-md-4" align="center"></div>
		        <div class="col-md-2" align="center">
		          <input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel"><br>
		        </div>
			</div>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-3" style="text-align:left">
						<span class='badge' style='background-color:#DF0101'>&nbsp;</span> Entre 100% - 70%<br>
						<span class='badge' style='background-color:#DAAA08'>&nbsp;</span> Entre 69% - 40%<br>
						<span class='badge' style='background-color:green'>&nbsp;</span> Entre 39% - 00%
					</div>
					<div class="col-md-3">
						<h5><b>DETALLE TRABAJADORES</b></h5>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" align="rigth">
						<table id="example1">
					    	<thead>
					    		<tr>
							        <th>N°</th>
						    		<th style="text-align:center;">Rut</th>
						    		<th style="text-align:center;">Nombre Trabajador</th>
						    		<th style="text-align:center;">Area</th>
						    		<th style="text-align:center;">Cargo</th>
							        <th style="text-align:center;">Fecha Primer Contrato</th>
							        <th style="text-align:center;">Dias Trabajados</th>
							        <th style="text-align:center;">Dias Corridos<br>(fecha actual)</th>
							        <th style="text-align:center;">% Permanencia</th>
							    </tr>
					    	</thead>
					    	<tbody>
					    		<?php
					    			$i = 0;
					    			foreach ($listado as $row){
					    			$i += 1;
					    		?>
					    		<tr>
							        <td><?php echo $i ?></td>
						    		<td><?php echo $row->rut_usuario ?></td>
						    		<td><?php echo $row->nombres." ".$row->paterno." ".$row->materno ?></td>
						    		<td><?php echo $row->nombre_area ?></td>
						    		<td><?php echo $row->nombre_cargo ?></td>
							        <td><?php echo $row->fecha_primer_contrato ?></td>
							        <td><?php echo $row->dias_trabajados ?></td>
							        <td><?php echo $row->dias_corridos_trabajados ?></td>
							        <td><?php echo "<span class='badge' style='background-color:".$row->color_permanencia."'>".$row->permanencia." %</span>" ?></td>
							    </tr>
							    <?php
					    			}
					    		?>
					    	</tbody>
					    </table>
					</div>
				</div>
			</div><br><br>
		</div>
	</div>
</div>


<div id="divTableDataHolder" style="display:none">
	<meta content="charset=UTF-8"/>
	<table>
    	<thead>
    		<tr>
		        <th style="text-align:center">/</th>
	    		<th style="text-align:center">Rut</th>
	    		<th style="text-align:center">Nombre Trabajador</th>
	    		<th style="text-align:center">Area</th>
	    		<th style="text-align:center">Cargo</th>
		        <th style="text-align:center">Fecha Primer Contrato</th>
		        <th style="text-align:center">Dias Trabajados</th>
		        <th style="text-align:center">Dias Corridos (fecha actual)</th>
		        <th style="text-align:center">% Permanencia</th>
		        <th style="text-align:center">Semaforo</th>
		    </tr>
    	</thead>
    	<tbody>
    		<?php
    			$i = 0;
    			foreach ($listado as $row){
    			$i += 1;
    		?>
    		<tr style="text-align:center">
		        <td><?php echo $i ?></td>
	    		<td><?php echo $row->rut_usuario ?></td>
	    		<td><?php echo $row->nombres." ".$row->paterno." ".$row->materno ?></td>
		        <td><?php echo $row->nombre_area ?></td>
		        <td><?php echo $row->nombre_cargo ?></td>
		        <td><?php echo $row->fecha_primer_contrato ?></td>
		        <td><?php echo $row->dias_trabajados ?></td>
		        <td><?php echo $row->dias_corridos_trabajados ?></td>
		        <td><?php echo $row->permanencia ?></td>
		        <td>
		        	<?php
		        		if($row->color_permanencia == "green"){
		        			echo "Verde";
		        		}elseif($row->color_permanencia == "#DAAA08"){
		        			echo "Amarillo";
		        		}elseif($row->color_permanencia == "##DF0101"){
		        			echo "Rojo";
		        		}
			        ?>
			    </td>
		    </tr>
		    <?php
    			}
    		?>
    	</tbody>
    </table>

</div>