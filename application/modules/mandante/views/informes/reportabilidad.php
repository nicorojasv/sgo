<div class="panel panel-white">
  <div class="panel-body">
		<div class="row-fluid">
			<div class="row">
		        <div class="col-md-7" align="center">
		          	<h4 style='text-align:center;float:left;'><b>PLANTA: </b><?php echo $empresa_planta->nombre ?></h4>
		          	<input type="hidden" name="id_empresa" id="id_empresa" value="<?php echo $id_planta ?>">
		        </div>
		    </div>
			<div class="row">
				<div class="col-md-6" align="rigth"><b>Reportabilidad Dotaci&oacute;n</b>
					<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
					  	<option title="INFORME ACTUAL: REPORTABILIDAD DOTACION EQUIVALENTE/CANTIDAD CONTRATOS/POR TRABAJADOR" value="#">Reportabilidad Dotaci&oacute;n</option>
					  	<option title="TRAZABILIDAD DOTACION POR PLANTAS" value="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $id_planta ?>">Avance de Contrataciones</option>
					  	<option title="BASE DE DATOS DE CONTRATOS EXPORTACION A EXCEL" value="<?php echo base_url() ?>mandante/base_datos_contratos/<?php echo $id_planta ?>">Base de Datos de Contratos</option>
					  	<option title="REPORTABILIDAD CAUSALES DE CONTRATOS" value="<?php echo base_url() ?>mandante/reporte_causales/<?php echo $id_planta ?>">Reportabilidad Causales</option>
					  	<option title="INDICADOR DE PERMANENCIA" value="<?php echo base_url() ?>mandante/indicador_permanencia/<?php echo $id_planta ?>">Indicador de Permanencia</option>
					</select>
	  				<br><br>
				</div>
				<div class="col-md-6" align="rigth">
					<b>Año Consolidado</b>
					<input type="radio" name="ano_consolidad" id="ano_consolidad" class="ano_consolidad" value="2016" <?php if($fecha == "2016") echo "checked" ?> > 2016 
					<input type="radio" name="ano_consolidad2" id="ano_consolidad2" class="ano_consolidad2" value="2017" <?php if($fecha == "2017") echo "checked" ?> > 2017
					<input type="radio" name="ano_consolida2" id="ano_consolida2" class="ano_consolida2" value="2018" <?php if($fecha == "2018") echo "checked" ?> > 2018
					<input type="radio" name="ano_consolida3" id="ano_consolida3" class="ano_consolida3" value="2019" <?php if($fecha == "2019") echo "checked" ?> > 2019
				</div>
			</div>
			<?php //var_dump($listado) ?>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>DOTACION EQUIVALENTE AÑO <?php echo $fecha ?></b></h5>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-7" align="rigth">
						<table class="table">
							<thead>
								<tr>
								<th>Meses</th>
								<th>Enero</th>
								<th>Febrero</th>
								<th>Marzo</th>
								<th>Abril</th>
								<th>Mayo</th>
								<th>Junio</th>
								<th>Julio</th>
								<th>Agosto</th>
								<th>Septiembre</th>
								<th>Octubre</th>
								<th>Noviembre</th>
								<th>Diciembre</th>
							</tr>
							</thead>
							<tbody>
								<tr>
									<td>Cantidad</td>
									<td><?php echo $d_equiv1 ?></td>
									<td><?php echo $d_equiv2 ?></td>
									<td><?php echo $d_equiv3 ?></td>
									<td><?php echo $d_equiv4 ?></td>
									<td><?php echo $d_equiv5 ?></td>
									<td><?php echo $d_equiv6 ?></td>
									<td><?php echo $d_equiv7 ?></td>
									<td><?php echo $d_equiv8 ?></td>
									<td><?php echo $d_equiv9 ?></td>
									<td><?php echo $d_equiv10 ?></td>
									<td><?php echo $d_equiv11 ?></td>
									<td><?php echo $d_equiv12 ?></td>
									<input type="hidden" id="d_equiv1" value="<?php echo $d_equiv1 ?>">
									<input type="hidden" id="d_equiv2" value="<?php echo $d_equiv2 ?>">
									<input type="hidden" id="d_equiv3" value="<?php echo $d_equiv3 ?>">
									<input type="hidden" id="d_equiv4" value="<?php echo $d_equiv4 ?>">
									<input type="hidden" id="d_equiv5" value="<?php echo $d_equiv5 ?>">
									<input type="hidden" id="d_equiv6" value="<?php echo $d_equiv6 ?>">
									<input type="hidden" id="d_equiv7" value="<?php echo $d_equiv7 ?>">
									<input type="hidden" id="d_equiv8" value="<?php echo $d_equiv8 ?>">
									<input type="hidden" id="d_equiv9" value="<?php echo $d_equiv9 ?>">
									<input type="hidden" id="d_equiv10" value="<?php echo $d_equiv10 ?>">
									<input type="hidden" id="d_equiv11" value="<?php echo $d_equiv11 ?>">
									<input type="hidden" id="d_equiv12" value="<?php echo $d_equiv12 ?>">
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1" align="rigth"></div>
					<div class="col-md-8" align="rigth">
						<div id="chartContainer1" style="height:250px; width:1000px;"></div>
					</div>
				</div>
			</div><br><br>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>CANTIDAD CONTRATOS VIGENTES POR MES AÑO <?php echo $fecha ?></b></h5>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-7" align="rigth">
						<table class="table">
							<thead>
								<tr>
								<th>Meses</th>
								<th>Enero</th>
								<th>Febrero</th>
								<th>Marzo</th>
								<th>Abril</th>
								<th>Mayo</th>
								<th>Junio</th>
								<th>Julio</th>
								<th>Agosto</th>
								<th>Septiembre</th>
								<th>Octubre</th>
								<th>Noviembre</th>
								<th>Diciembre</th>
							</tr>
							</thead>
							<tbody>
								<tr>
									<td>Cantidad</td>
									<td><?php echo $c_contratos1 ?></td>
									<td><?php echo $c_contratos2 ?></td>
									<td><?php echo $c_contratos3 ?></td>
									<td><?php echo $c_contratos4 ?></td>
									<td><?php echo $c_contratos5 ?></td>
									<td><?php echo $c_contratos6 ?></td>
									<td><?php echo $c_contratos7 ?></td>
									<td><?php echo $c_contratos8 ?></td>
									<td><?php echo $c_contratos9 ?></td>
									<td><?php echo $c_contratos10 ?></td>
									<td><?php echo $c_contratos11 ?></td>
									<td><?php echo $c_contratos12 ?></td>
									<input type="hidden" id="c_contratos1" value="<?php echo $c_contratos1 ?>">
									<input type="hidden" id="c_contratos2" value="<?php echo $c_contratos2 ?>">
									<input type="hidden" id="c_contratos3" value="<?php echo $c_contratos3 ?>">
									<input type="hidden" id="c_contratos4" value="<?php echo $c_contratos4 ?>">
									<input type="hidden" id="c_contratos5" value="<?php echo $c_contratos5 ?>">
									<input type="hidden" id="c_contratos6" value="<?php echo $c_contratos6 ?>">
									<input type="hidden" id="c_contratos7" value="<?php echo $c_contratos7 ?>">
									<input type="hidden" id="c_contratos8" value="<?php echo $c_contratos8 ?>">
									<input type="hidden" id="c_contratos9" value="<?php echo $c_contratos9 ?>">
									<input type="hidden" id="c_contratos10" value="<?php echo $c_contratos10 ?>">
									<input type="hidden" id="c_contratos11" value="<?php echo $c_contratos11 ?>">
									<input type="hidden" id="c_contratos12" value="<?php echo $c_contratos12 ?>">
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1" align="rigth"></div>
					<div class="col-md-8" align="rigth">
						<div id="chartContainer2" style="height:250px; width:1000px;"></div>
					</div>
				</div>
			</div><br><br>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>POR TRABAJADOR O RUT AÑO <?php echo $fecha ?></b></h5>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-7" align="rigth">
						<table class="table">
							<thead>
								<tr>
								<th>Meses</th>
								<th>Enero</th>
								<th>Febrero</th>
								<th>Marzo</th>
								<th>Abril</th>
								<th>Mayo</th>
								<th>Junio</th>
								<th>Julio</th>
								<th>Agosto</th>
								<th>Septiembre</th>
								<th>Octubre</th>
								<th>Noviembre</th>
								<th>Diciembre</th>
							</tr>
							</thead>
							<tbody>
								<tr>
									<td>Cantidad</td>
									<td><?php echo $por_trabajador1 ?></td>
									<td><?php echo $por_trabajador2 ?></td>
									<td><?php echo $por_trabajador3 ?></td>
									<td><?php echo $por_trabajador4 ?></td>
									<td><?php echo $por_trabajador5 ?></td>
									<td><?php echo $por_trabajador6 ?></td>
									<td><?php echo $por_trabajador7 ?></td>
									<td><?php echo $por_trabajador8 ?></td>
									<td><?php echo $por_trabajador9 ?></td>
									<td><?php echo $por_trabajador10 ?></td>
									<td><?php echo $por_trabajador11 ?></td>
									<td><?php echo $por_trabajador12 ?></td>
									<input type="hidden" id="por_trabajador1" value="<?php echo $por_trabajador1 ?>">
									<input type="hidden" id="por_trabajador2" value="<?php echo $por_trabajador2 ?>">
									<input type="hidden" id="por_trabajador3" value="<?php echo $por_trabajador3 ?>">
									<input type="hidden" id="por_trabajador4" value="<?php echo $por_trabajador4 ?>">
									<input type="hidden" id="por_trabajador5" value="<?php echo $por_trabajador5 ?>">
									<input type="hidden" id="por_trabajador6" value="<?php echo $por_trabajador6 ?>">
									<input type="hidden" id="por_trabajador7" value="<?php echo $por_trabajador7 ?>">
									<input type="hidden" id="por_trabajador8" value="<?php echo $por_trabajador8 ?>">
									<input type="hidden" id="por_trabajador9" value="<?php echo $por_trabajador9 ?>">
									<input type="hidden" id="por_trabajador10" value="<?php echo $por_trabajador10 ?>">
									<input type="hidden" id="por_trabajador11" value="<?php echo $por_trabajador11 ?>">
									<input type="hidden" id="por_trabajador12" value="<?php echo $por_trabajador12 ?>">
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-1" align="rigth"></div>
					<div class="col-md-8" align="rigth">
						<div id="chartContainer3" style="height:250px; width:1000px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
