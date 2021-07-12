<script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer1", {
		theme: "theme2",
		animationEnabled: false,
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Causal A",  y: 4  },
				{ label: "Causal B", y: 4  },
				{ label: "Causal C", y: 3  },
				{ label: "Causal D",  y: 4  },
				{ label: "Causal E",  y: 5  }
			]
		}
		]
	});
	chart.render();

	var chart = new CanvasJS.Chart("chartContainer2", {
		theme: "theme1",
		animationEnabled: false,
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Causal A",  y: 12  },
				{ label: "Causal B", y: 11 },
				{ label: "Causal C", y: 10  },
				{ label: "Causal D",  y: 9  },
				{ label: "Causal E",  y: 8  }
			]
		}
		]
	});
	chart.render();

	var chart = new CanvasJS.Chart("chartContainer3", {
		theme: "theme3",
		animationEnabled: false,
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Causal A",  y: 14 },
				{ label: "Causal B", y: 13 },
				{ label: "Causal C", y: 14 },
				{ label: "Causal D",  y: 12  },
				{ label: "Causal E",  y: 11 }
			]
		}
		]
	});
	chart.render();
}
</script>
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
					  	<option title="INFORME ACTUAL: REPORTABILIDAD CAUSALES DE CONTRATOS" value="#">Reportabilidad Causales</option>
					  	<option title="TRAZABILIDAD DOTACION POR PLANTAS" value="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $id_planta ?>">Avance de Contrataciones</option>
					  	<option title="BASE DE DATOS DE CONTRATOS EXPORTACION A EXCEL" value="<?php echo base_url() ?>mandante/base_datos_contratos/<?php echo $id_planta ?>">Base de Datos de Contratos</option>
					  	<option title="REPORTABILIDAD DOTACION EQUIVALENTE/CANTIDAD CONTRATOS/POR TRABAJADOR" value="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $id_planta ?>">Reportabilidad Dotaci&oacute;n</option>
					  	<option title="INDICADOR DE PERMANENCIA" value="<?php echo base_url() ?>mandante/indicador_permanencia/<?php echo $id_planta ?>">Indicador de Permanencia</option>
					</select>
	  				<br><br>
				</div>
			</div>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>DOTACION EQUIVALENTE <?php echo date('Y') ?></b></h5>
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
									<td>Causal A</td>
									<td><?php echo $d_equiv1A ?></td>
									<td><?php echo $d_equiv2A ?></td>
									<td><?php echo $d_equiv3A ?></td>
									<td><?php echo $d_equiv4A ?></td>
									<td><?php echo $d_equiv5A ?></td>
									<td><?php echo $d_equiv6A ?></td>
									<td><?php echo $d_equiv7A ?></td>
									<td><?php echo $d_equiv8A ?></td>
									<td><?php echo $d_equiv9A ?></td>
									<td><?php echo $d_equiv10A ?></td>
									<td><?php echo $d_equiv11A ?></td>
									<td><?php echo $d_equiv12A ?></td>
								</tr>
								<tr>
									<td>Causal B</td>
									<td><?php echo $d_equiv1B ?></td>
									<td><?php echo $d_equiv2B ?></td>
									<td><?php echo $d_equiv3B ?></td>
									<td><?php echo $d_equiv4B ?></td>
									<td><?php echo $d_equiv5B ?></td>
									<td><?php echo $d_equiv6B ?></td>
									<td><?php echo $d_equiv7B ?></td>
									<td><?php echo $d_equiv8B ?></td>
									<td><?php echo $d_equiv9B ?></td>
									<td><?php echo $d_equiv10B ?></td>
									<td><?php echo $d_equiv11B ?></td>
									<td><?php echo $d_equiv12B ?></td>
								</tr>
								<tr>
									<td>Causal C</td>
									<td><?php echo $d_equiv1C ?></td>
									<td><?php echo $d_equiv2C ?></td>
									<td><?php echo $d_equiv3C ?></td>
									<td><?php echo $d_equiv4C ?></td>
									<td><?php echo $d_equiv5C ?></td>
									<td><?php echo $d_equiv6C ?></td>
									<td><?php echo $d_equiv7C ?></td>
									<td><?php echo $d_equiv8C ?></td>
									<td><?php echo $d_equiv9C ?></td>
									<td><?php echo $d_equiv10C ?></td>
									<td><?php echo $d_equiv11C ?></td>
									<td><?php echo $d_equiv12C ?></td>
								</tr>
								<tr>
									<td>Causal D</td>
									<td><?php echo $d_equiv1D ?></td>
									<td><?php echo $d_equiv2D ?></td>
									<td><?php echo $d_equiv3D ?></td>
									<td><?php echo $d_equiv4D ?></td>
									<td><?php echo $d_equiv5D ?></td>
									<td><?php echo $d_equiv6D ?></td>
									<td><?php echo $d_equiv7D ?></td>
									<td><?php echo $d_equiv8D ?></td>
									<td><?php echo $d_equiv9D ?></td>
									<td><?php echo $d_equiv10D ?></td>
									<td><?php echo $d_equiv11D ?></td>
									<td><?php echo $d_equiv12D ?></td>
								</tr>
								<tr>
									<td>Causal E</td>
									<td><?php echo $d_equiv1E ?></td>
									<td><?php echo $d_equiv2E ?></td>
									<td><?php echo $d_equiv3E ?></td>
									<td><?php echo $d_equiv4E ?></td>
									<td><?php echo $d_equiv5E ?></td>
									<td><?php echo $d_equiv6E ?></td>
									<td><?php echo $d_equiv7E ?></td>
									<td><?php echo $d_equiv8E ?></td>
									<td><?php echo $d_equiv9E ?></td>
									<td><?php echo $d_equiv10E ?></td>
									<td><?php echo $d_equiv11E ?></td>
									<td><?php echo $d_equiv12E ?></td>
								</tr>
								<tr>
									<input type="hidden" id="d_equiv1A" value="<?php echo $d_equiv1A ?>">
									<input type="hidden" id="d_equiv1B" value="<?php echo $d_equiv1B ?>">
									<input type="hidden" id="d_equiv1C" value="<?php echo $d_equiv1C ?>">
									<input type="hidden" id="d_equiv1D" value="<?php echo $d_equiv1D ?>">
									<input type="hidden" id="d_equiv1E" value="<?php echo $d_equiv1E ?>">
									<input type="hidden" id="d_equiv2A" value="<?php echo $d_equiv2A ?>">
									<input type="hidden" id="d_equiv2B" value="<?php echo $d_equiv2B ?>">
									<input type="hidden" id="d_equiv2C" value="<?php echo $d_equiv2C ?>">
									<input type="hidden" id="d_equiv2D" value="<?php echo $d_equiv2D ?>">
									<input type="hidden" id="d_equiv2E" value="<?php echo $d_equiv2E ?>">
									<input type="hidden" id="d_equiv3A" value="<?php echo $d_equiv3A ?>">
									<input type="hidden" id="d_equiv3B" value="<?php echo $d_equiv3B ?>">
									<input type="hidden" id="d_equiv3C" value="<?php echo $d_equiv3C ?>">
									<input type="hidden" id="d_equiv3D" value="<?php echo $d_equiv3D ?>">
									<input type="hidden" id="d_equiv3E" value="<?php echo $d_equiv3E ?>">
									<input type="hidden" id="d_equiv4A" value="<?php echo $d_equiv4A ?>">
									<input type="hidden" id="d_equiv4B" value="<?php echo $d_equiv4B ?>">
									<input type="hidden" id="d_equiv4C" value="<?php echo $d_equiv4C ?>">
									<input type="hidden" id="d_equiv4D" value="<?php echo $d_equiv4D ?>">
									<input type="hidden" id="d_equiv4E" value="<?php echo $d_equiv4E ?>">
									<input type="hidden" id="d_equiv5A" value="<?php echo $d_equiv5A ?>">
									<input type="hidden" id="d_equiv5B" value="<?php echo $d_equiv5B ?>">
									<input type="hidden" id="d_equiv5C" value="<?php echo $d_equiv5C ?>">
									<input type="hidden" id="d_equiv5D" value="<?php echo $d_equiv5D ?>">
									<input type="hidden" id="d_equiv5E" value="<?php echo $d_equiv5E ?>">
									<input type="hidden" id="d_equiv6A" value="<?php echo $d_equiv6A ?>">
									<input type="hidden" id="d_equiv6B" value="<?php echo $d_equiv6B ?>">
									<input type="hidden" id="d_equiv6C" value="<?php echo $d_equiv6C ?>">
									<input type="hidden" id="d_equiv6D" value="<?php echo $d_equiv6D ?>">
									<input type="hidden" id="d_equiv6E" value="<?php echo $d_equiv6E ?>">
									<input type="hidden" id="d_equiv7A" value="<?php echo $d_equiv7A ?>">
									<input type="hidden" id="d_equiv7B" value="<?php echo $d_equiv7B ?>">
									<input type="hidden" id="d_equiv7C" value="<?php echo $d_equiv7C ?>">
									<input type="hidden" id="d_equiv7D" value="<?php echo $d_equiv7D ?>">
									<input type="hidden" id="d_equiv7E" value="<?php echo $d_equiv7E ?>">
									<input type="hidden" id="d_equiv8A" value="<?php echo $d_equiv8A ?>">
									<input type="hidden" id="d_equiv8B" value="<?php echo $d_equiv8B ?>">
									<input type="hidden" id="d_equiv8C" value="<?php echo $d_equiv8C ?>">
									<input type="hidden" id="d_equiv8D" value="<?php echo $d_equiv8D ?>">
									<input type="hidden" id="d_equiv8E" value="<?php echo $d_equiv8E ?>">
									<input type="hidden" id="d_equiv9A" value="<?php echo $d_equiv9A ?>">
									<input type="hidden" id="d_equiv9B" value="<?php echo $d_equiv9B ?>">
									<input type="hidden" id="d_equiv9C" value="<?php echo $d_equiv9C ?>">
									<input type="hidden" id="d_equiv9D" value="<?php echo $d_equiv9D ?>">
									<input type="hidden" id="d_equiv9E" value="<?php echo $d_equiv9E ?>">
									<input type="hidden" id="d_equiv10A" value="<?php echo $d_equiv10A ?>">
									<input type="hidden" id="d_equiv10B" value="<?php echo $d_equiv10B ?>">
									<input type="hidden" id="d_equiv10C" value="<?php echo $d_equiv10C ?>">
									<input type="hidden" id="d_equiv10D" value="<?php echo $d_equiv10D ?>">
									<input type="hidden" id="d_equiv10E" value="<?php echo $d_equiv10E ?>">
									<input type="hidden" id="d_equiv11A" value="<?php echo $d_equiv11A ?>">
									<input type="hidden" id="d_equiv11B" value="<?php echo $d_equiv11B ?>">
									<input type="hidden" id="d_equiv11C" value="<?php echo $d_equiv11C ?>">
									<input type="hidden" id="d_equiv11D" value="<?php echo $d_equiv11D ?>">
									<input type="hidden" id="d_equiv11E" value="<?php echo $d_equiv11E ?>">
									<input type="hidden" id="d_equiv12A" value="<?php echo $d_equiv12A ?>">
									<input type="hidden" id="d_equiv12B" value="<?php echo $d_equiv12B ?>">
									<input type="hidden" id="d_equiv12C" value="<?php echo $d_equiv12C ?>">
									<input type="hidden" id="d_equiv12D" value="<?php echo $d_equiv12D ?>">
									<input type="hidden" id="d_equiv12E" value="<?php echo $d_equiv12E ?>">
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-8" align="rigth">
						<div id="chartContainer1" style="height: 300px; width: 100%;"></div>
					</div>
				</div>
			</div><br><br>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>CANTIDAD CONTRATOS VIGENTES EN EL MES <?php echo date('Y') ?></b></h5>
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
									<td>Causal A</td>
									<td><?php echo $c_contratos1A ?></td>
									<td><?php echo $c_contratos2A ?></td>
									<td><?php echo $c_contratos3A ?></td>
									<td><?php echo $c_contratos4A ?></td>
									<td><?php echo $c_contratos5A ?></td>
									<td><?php echo $c_contratos6A ?></td>
									<td><?php echo $c_contratos7A ?></td>
									<td><?php echo $c_contratos8A ?></td>
									<td><?php echo $c_contratos9A ?></td>
									<td><?php echo $c_contratos10A ?></td>
									<td><?php echo $c_contratos11A ?></td>
									<td><?php echo $c_contratos12A ?></td>
								</tr>
								<tr>
									<td>Causal B</td>
									<td><?php echo $c_contratos1B ?></td>
									<td><?php echo $c_contratos2B ?></td>
									<td><?php echo $c_contratos3B ?></td>
									<td><?php echo $c_contratos4B ?></td>
									<td><?php echo $c_contratos5B ?></td>
									<td><?php echo $c_contratos6B ?></td>
									<td><?php echo $c_contratos7B ?></td>
									<td><?php echo $c_contratos8B ?></td>
									<td><?php echo $c_contratos9B ?></td>
									<td><?php echo $c_contratos10B ?></td>
									<td><?php echo $c_contratos11B ?></td>
									<td><?php echo $c_contratos12B ?></td>
								</tr>
								<tr>
									<td>Causal C</td>
									<td><?php echo $c_contratos1C ?></td>
									<td><?php echo $c_contratos2C ?></td>
									<td><?php echo $c_contratos3C ?></td>
									<td><?php echo $c_contratos4C ?></td>
									<td><?php echo $c_contratos5C ?></td>
									<td><?php echo $c_contratos6C ?></td>
									<td><?php echo $c_contratos7C ?></td>
									<td><?php echo $c_contratos8C ?></td>
									<td><?php echo $c_contratos9C ?></td>
									<td><?php echo $c_contratos10C ?></td>
									<td><?php echo $c_contratos11C ?></td>
									<td><?php echo $c_contratos12C ?></td>
								</tr>
								<tr>
									<td>Causal D</td>
									<td><?php echo $c_contratos1D ?></td>
									<td><?php echo $c_contratos2D ?></td>
									<td><?php echo $c_contratos3D ?></td>
									<td><?php echo $c_contratos4D ?></td>
									<td><?php echo $c_contratos5D ?></td>
									<td><?php echo $c_contratos6D ?></td>
									<td><?php echo $c_contratos7D ?></td>
									<td><?php echo $c_contratos8D ?></td>
									<td><?php echo $c_contratos9D ?></td>
									<td><?php echo $c_contratos10D ?></td>
									<td><?php echo $c_contratos11D ?></td>
									<td><?php echo $c_contratos12D ?></td>
								</tr>
								<tr>
									<td>Causal E</td>
									<td><?php echo $c_contratos1E ?></td>
									<td><?php echo $c_contratos2E ?></td>
									<td><?php echo $c_contratos3E ?></td>
									<td><?php echo $c_contratos4E ?></td>
									<td><?php echo $c_contratos5E ?></td>
									<td><?php echo $c_contratos6E ?></td>
									<td><?php echo $c_contratos7E ?></td>
									<td><?php echo $c_contratos8E ?></td>
									<td><?php echo $c_contratos9E ?></td>
									<td><?php echo $c_contratos10E ?></td>
									<td><?php echo $c_contratos11E ?></td>
									<td><?php echo $c_contratos12E ?></td>
								</tr>
								<tr>
									<input type="hidden" id="c_contratos1A" value="<?php echo $c_contratos1A ?>">
									<input type="hidden" id="c_contratos1B" value="<?php echo $c_contratos1B ?>">
									<input type="hidden" id="c_contratos1C" value="<?php echo $c_contratos1C ?>">
									<input type="hidden" id="c_contratos1D" value="<?php echo $c_contratos1D ?>">
									<input type="hidden" id="c_contratos1E" value="<?php echo $c_contratos1E ?>">
									<input type="hidden" id="c_contratos2A" value="<?php echo $c_contratos2A ?>">
									<input type="hidden" id="c_contratos2B" value="<?php echo $c_contratos2B ?>">
									<input type="hidden" id="c_contratos2C" value="<?php echo $c_contratos2C ?>">
									<input type="hidden" id="c_contratos2D" value="<?php echo $c_contratos2D ?>">
									<input type="hidden" id="c_contratos2E" value="<?php echo $c_contratos2E ?>">
									<input type="hidden" id="c_contratos3A" value="<?php echo $c_contratos3A ?>">
									<input type="hidden" id="c_contratos3B" value="<?php echo $c_contratos3B ?>">
									<input type="hidden" id="c_contratos3C" value="<?php echo $c_contratos3C ?>">
									<input type="hidden" id="c_contratos3D" value="<?php echo $c_contratos3D ?>">
									<input type="hidden" id="c_contratos3E" value="<?php echo $c_contratos3E ?>">
									<input type="hidden" id="c_contratos4A" value="<?php echo $c_contratos4A ?>">
									<input type="hidden" id="c_contratos4B" value="<?php echo $c_contratos4B ?>">
									<input type="hidden" id="c_contratos4C" value="<?php echo $c_contratos4C ?>">
									<input type="hidden" id="c_contratos4D" value="<?php echo $c_contratos4D ?>">
									<input type="hidden" id="c_contratos4E" value="<?php echo $c_contratos4E ?>">
									<input type="hidden" id="c_contratos5A" value="<?php echo $c_contratos5A ?>">
									<input type="hidden" id="c_contratos5B" value="<?php echo $c_contratos5B ?>">
									<input type="hidden" id="c_contratos5C" value="<?php echo $c_contratos5C ?>">
									<input type="hidden" id="c_contratos5D" value="<?php echo $c_contratos5D ?>">
									<input type="hidden" id="c_contratos5E" value="<?php echo $c_contratos5E ?>">
									<input type="hidden" id="c_contratos6A" value="<?php echo $c_contratos6A ?>">
									<input type="hidden" id="c_contratos6B" value="<?php echo $c_contratos6B ?>">
									<input type="hidden" id="c_contratos6C" value="<?php echo $c_contratos6C ?>">
									<input type="hidden" id="c_contratos6D" value="<?php echo $c_contratos6D ?>">
									<input type="hidden" id="c_contratos6E" value="<?php echo $c_contratos6E ?>">
									<input type="hidden" id="c_contratos7A" value="<?php echo $c_contratos7A ?>">
									<input type="hidden" id="c_contratos7B" value="<?php echo $c_contratos7B ?>">
									<input type="hidden" id="c_contratos7C" value="<?php echo $c_contratos7C ?>">
									<input type="hidden" id="c_contratos7D" value="<?php echo $c_contratos7D ?>">
									<input type="hidden" id="c_contratos7E" value="<?php echo $c_contratos7E ?>">
									<input type="hidden" id="c_contratos8A" value="<?php echo $c_contratos8A ?>">
									<input type="hidden" id="c_contratos8B" value="<?php echo $c_contratos8B ?>">
									<input type="hidden" id="c_contratos8C" value="<?php echo $c_contratos8C ?>">
									<input type="hidden" id="c_contratos8D" value="<?php echo $c_contratos8D ?>">
									<input type="hidden" id="c_contratos8E" value="<?php echo $c_contratos8E ?>">
									<input type="hidden" id="c_contratos9A" value="<?php echo $c_contratos9A ?>">
									<input type="hidden" id="c_contratos9B" value="<?php echo $c_contratos9B ?>">
									<input type="hidden" id="c_contratos9C" value="<?php echo $c_contratos9C ?>">
									<input type="hidden" id="c_contratos9D" value="<?php echo $c_contratos9D ?>">
									<input type="hidden" id="c_contratos9E" value="<?php echo $c_contratos9E ?>">
									<input type="hidden" id="c_contratos10A" value="<?php echo $c_contratos10A ?>">
									<input type="hidden" id="c_contratos10B" value="<?php echo $c_contratos10B ?>">
									<input type="hidden" id="c_contratos10C" value="<?php echo $c_contratos10C ?>">
									<input type="hidden" id="c_contratos10D" value="<?php echo $c_contratos10D ?>">
									<input type="hidden" id="c_contratos10E" value="<?php echo $c_contratos10E ?>">
									<input type="hidden" id="c_contratos11A" value="<?php echo $c_contratos11A ?>">
									<input type="hidden" id="c_contratos11B" value="<?php echo $c_contratos11B ?>">
									<input type="hidden" id="c_contratos11C" value="<?php echo $c_contratos11C ?>">
									<input type="hidden" id="c_contratos11D" value="<?php echo $c_contratos11D ?>">
									<input type="hidden" id="c_contratos11E" value="<?php echo $c_contratos11E ?>">
									<input type="hidden" id="c_contratos12A" value="<?php echo $c_contratos12A ?>">
									<input type="hidden" id="c_contratos12B" value="<?php echo $c_contratos12B ?>">
									<input type="hidden" id="c_contratos12C" value="<?php echo $c_contratos12C ?>">
									<input type="hidden" id="c_contratos12D" value="<?php echo $c_contratos12D ?>">
									<input type="hidden" id="c_contratos12E" value="<?php echo $c_contratos12E ?>">
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-8" align="rigth">
						<div id="chartContainer2" style="height: 300px; width: 100%;"></div>
					</div>
				</div>
			</div><br><br>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>POR TRABAJADOR O RUT <?php echo date('Y') ?></b></h5>
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
									<td>Causal A</td>
									<td><?php echo $por_trabajador1A ?></td>
									<td><?php echo $por_trabajador2A ?></td>
									<td><?php echo $por_trabajador3A ?></td>
									<td><?php echo $por_trabajador4A ?></td>
									<td><?php echo $por_trabajador5A ?></td>
									<td><?php echo $por_trabajador6A ?></td>
									<td><?php echo $por_trabajador7A ?></td>
									<td><?php echo $por_trabajador8A ?></td>
									<td><?php echo $por_trabajador9A ?></td>
									<td><?php echo $por_trabajador10A ?></td>
									<td><?php echo $por_trabajador11A ?></td>
									<td><?php echo $por_trabajador12A ?></td>
								</tr>
								<tr>
									<td>Causal B</td>
									<td><?php echo $por_trabajador1B ?></td>
									<td><?php echo $por_trabajador2B ?></td>
									<td><?php echo $por_trabajador3B ?></td>
									<td><?php echo $por_trabajador4B ?></td>
									<td><?php echo $por_trabajador5B ?></td>
									<td><?php echo $por_trabajador6B ?></td>
									<td><?php echo $por_trabajador7B ?></td>
									<td><?php echo $por_trabajador8B ?></td>
									<td><?php echo $por_trabajador9B ?></td>
									<td><?php echo $por_trabajador10B ?></td>
									<td><?php echo $por_trabajador11B ?></td>
									<td><?php echo $por_trabajador12B ?></td>
								</tr>
								<tr>
									<td>Causal C</td>
									<td><?php echo $por_trabajador1C ?></td>
									<td><?php echo $por_trabajador2C ?></td>
									<td><?php echo $por_trabajador3C ?></td>
									<td><?php echo $por_trabajador4C ?></td>
									<td><?php echo $por_trabajador5C ?></td>
									<td><?php echo $por_trabajador6C ?></td>
									<td><?php echo $por_trabajador7C ?></td>
									<td><?php echo $por_trabajador8C ?></td>
									<td><?php echo $por_trabajador9C ?></td>
									<td><?php echo $por_trabajador10C ?></td>
									<td><?php echo $por_trabajador11C ?></td>
									<td><?php echo $por_trabajador12C ?></td>
								</tr>
								<tr>
									<td>Causal D</td>
									<td><?php echo $por_trabajador1D ?></td>
									<td><?php echo $por_trabajador2D ?></td>
									<td><?php echo $por_trabajador3D ?></td>
									<td><?php echo $por_trabajador4D ?></td>
									<td><?php echo $por_trabajador5D ?></td>
									<td><?php echo $por_trabajador6D ?></td>
									<td><?php echo $por_trabajador7D ?></td>
									<td><?php echo $por_trabajador8D ?></td>
									<td><?php echo $por_trabajador9D ?></td>
									<td><?php echo $por_trabajador10D ?></td>
									<td><?php echo $por_trabajador11D ?></td>
									<td><?php echo $por_trabajador12D ?></td>
								</tr>
								<tr>
									<td>Causal E</td>
									<td><?php echo $por_trabajador1E ?></td>
									<td><?php echo $por_trabajador2E ?></td>
									<td><?php echo $por_trabajador3E ?></td>
									<td><?php echo $por_trabajador4E ?></td>
									<td><?php echo $por_trabajador5E ?></td>
									<td><?php echo $por_trabajador6E ?></td>
									<td><?php echo $por_trabajador7E ?></td>
									<td><?php echo $por_trabajador8E ?></td>
									<td><?php echo $por_trabajador9E ?></td>
									<td><?php echo $por_trabajador10E ?></td>
									<td><?php echo $por_trabajador11E ?></td>
									<td><?php echo $por_trabajador12E ?></td>
								</tr>
								<tr>
									<input type="hidden" id="por_trabajador1A" value="<?php echo $por_trabajador1A ?>">
									<input type="hidden" id="por_trabajador1B" value="<?php echo $por_trabajador1B ?>">
									<input type="hidden" id="por_trabajador1C" value="<?php echo $por_trabajador1C ?>">
									<input type="hidden" id="por_trabajador1D" value="<?php echo $por_trabajador1D ?>">
									<input type="hidden" id="por_trabajador1E" value="<?php echo $por_trabajador1E ?>">
									<input type="hidden" id="por_trabajador2A" value="<?php echo $por_trabajador2A ?>">
									<input type="hidden" id="por_trabajador2B" value="<?php echo $por_trabajador2B ?>">
									<input type="hidden" id="por_trabajador2C" value="<?php echo $por_trabajador2C ?>">
									<input type="hidden" id="por_trabajador2D" value="<?php echo $por_trabajador2D ?>">
									<input type="hidden" id="por_trabajador2E" value="<?php echo $por_trabajador2E ?>">
									<input type="hidden" id="por_trabajador3A" value="<?php echo $por_trabajador3A ?>">
									<input type="hidden" id="por_trabajador3B" value="<?php echo $por_trabajador3B ?>">
									<input type="hidden" id="por_trabajador3C" value="<?php echo $por_trabajador3C ?>">
									<input type="hidden" id="por_trabajador3D" value="<?php echo $por_trabajador3D ?>">
									<input type="hidden" id="por_trabajador3E" value="<?php echo $por_trabajador3E ?>">
									<input type="hidden" id="por_trabajador4A" value="<?php echo $por_trabajador4A ?>">
									<input type="hidden" id="por_trabajador4B" value="<?php echo $por_trabajador4B ?>">
									<input type="hidden" id="por_trabajador4C" value="<?php echo $por_trabajador4C ?>">
									<input type="hidden" id="por_trabajador4D" value="<?php echo $por_trabajador4D ?>">
									<input type="hidden" id="por_trabajador4E" value="<?php echo $por_trabajador4E ?>">
									<input type="hidden" id="por_trabajador5A" value="<?php echo $por_trabajador5A ?>">
									<input type="hidden" id="por_trabajador5B" value="<?php echo $por_trabajador5B ?>">
									<input type="hidden" id="por_trabajador5C" value="<?php echo $por_trabajador5C ?>">
									<input type="hidden" id="por_trabajador5D" value="<?php echo $por_trabajador5D ?>">
									<input type="hidden" id="por_trabajador5E" value="<?php echo $por_trabajador5E ?>">
									<input type="hidden" id="por_trabajador6A" value="<?php echo $por_trabajador6A ?>">
									<input type="hidden" id="por_trabajador6B" value="<?php echo $por_trabajador6B ?>">
									<input type="hidden" id="por_trabajador6C" value="<?php echo $por_trabajador6C ?>">
									<input type="hidden" id="por_trabajador6D" value="<?php echo $por_trabajador6D ?>">
									<input type="hidden" id="por_trabajador6E" value="<?php echo $por_trabajador6E ?>">
									<input type="hidden" id="por_trabajador7A" value="<?php echo $por_trabajador7A ?>">
									<input type="hidden" id="por_trabajador7B" value="<?php echo $por_trabajador7B ?>">
									<input type="hidden" id="por_trabajador7C" value="<?php echo $por_trabajador7C ?>">
									<input type="hidden" id="por_trabajador7D" value="<?php echo $por_trabajador7D ?>">
									<input type="hidden" id="por_trabajador7E" value="<?php echo $por_trabajador7E ?>">
									<input type="hidden" id="por_trabajador8A" value="<?php echo $por_trabajador8A ?>">
									<input type="hidden" id="por_trabajador8B" value="<?php echo $por_trabajador8B ?>">
									<input type="hidden" id="por_trabajador8C" value="<?php echo $por_trabajador8C ?>">
									<input type="hidden" id="por_trabajador8D" value="<?php echo $por_trabajador8D ?>">
									<input type="hidden" id="por_trabajador8E" value="<?php echo $por_trabajador8E ?>">
									<input type="hidden" id="por_trabajador9A" value="<?php echo $por_trabajador9A ?>">
									<input type="hidden" id="por_trabajador9B" value="<?php echo $por_trabajador9B ?>">
									<input type="hidden" id="por_trabajador9C" value="<?php echo $por_trabajador9C ?>">
									<input type="hidden" id="por_trabajador9D" value="<?php echo $por_trabajador9D ?>">
									<input type="hidden" id="por_trabajador9E" value="<?php echo $por_trabajador9E ?>">
									<input type="hidden" id="por_trabajador10A" value="<?php echo $por_trabajador10A ?>">
									<input type="hidden" id="por_trabajador10B" value="<?php echo $por_trabajador10B ?>">
									<input type="hidden" id="por_trabajador10C" value="<?php echo $por_trabajador10C ?>">
									<input type="hidden" id="por_trabajador10D" value="<?php echo $por_trabajador10D ?>">
									<input type="hidden" id="por_trabajador10E" value="<?php echo $por_trabajador10E ?>">
									<input type="hidden" id="por_trabajador11A" value="<?php echo $por_trabajador11A ?>">
									<input type="hidden" id="por_trabajador11B" value="<?php echo $por_trabajador11B ?>">
									<input type="hidden" id="por_trabajador11C" value="<?php echo $por_trabajador11C ?>">
									<input type="hidden" id="por_trabajador11D" value="<?php echo $por_trabajador11D ?>">
									<input type="hidden" id="por_trabajador11E" value="<?php echo $por_trabajador11E ?>">
									<input type="hidden" id="por_trabajador12A" value="<?php echo $por_trabajador12A ?>">
									<input type="hidden" id="por_trabajador12B" value="<?php echo $por_trabajador12B ?>">
									<input type="hidden" id="por_trabajador12C" value="<?php echo $por_trabajador12C ?>">
									<input type="hidden" id="por_trabajador12D" value="<?php echo $por_trabajador12D ?>">
									<input type="hidden" id="por_trabajador12E" value="<?php echo $por_trabajador12E ?>">
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-8" align="rigth">
						<div id="chartContainer3" style="height: 300px; width: 100%;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>