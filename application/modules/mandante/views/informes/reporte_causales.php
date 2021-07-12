<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/canvasjs.min.js"></script>
<script type="text/javascript">

window.onload = function () {
	var c_contratosA = document.getElementById("c_contratosA").value;
	var c_contratosB = document.getElementById("c_contratosB").value;
	var c_contratosC = document.getElementById("c_contratosC").value;
	var c_contratosD = document.getElementById("c_contratosD").value;
	var c_contratosE = document.getElementById("c_contratosE").value;
	var por_trabajadorA = document.getElementById("por_trabajadorA").value;
	var por_trabajadorB = document.getElementById("por_trabajadorB").value;
	var por_trabajadorC = document.getElementById("por_trabajadorC").value;
	var por_trabajadorD = document.getElementById("por_trabajadorD").value;
	var por_trabajadorE = document.getElementById("por_trabajadorE").value;

	var chart = new CanvasJS.Chart("chartContainer2", {
		theme: "theme1",
		animationEnabled: false,
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Causal A",  y: Number(c_contratosA)  },
				{ label: "Causal B", y: Number(c_contratosB) },
				{ label: "Causal C", y: Number(c_contratosC) },
				{ label: "Causal D",  y: Number(c_contratosD) },
				{ label: "Causal E",  y: Number(c_contratosE) }
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
				{ label: "Causal A",  y: Number(por_trabajadorA) },
				{ label: "Causal B", y: Number(por_trabajadorB) },
				{ label: "Causal C", y: Number(por_trabajadorC) },
				{ label: "Causal D",  y: Number(por_trabajadorD) },
				{ label: "Causal E",  y: Number(por_trabajadorE) }
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
		          	<h4 style='text-align:center;float:left;'><b>PLANTA: </b><?php echo isset($empresa_planta->nombre)?$empresa_planta->nombre:"ND" ?></h4>
		          	<input type="hidden" name="id_empresa" id="id_empresa" value="<?php echo $id_planta ?>">
		        </div>
		      </div>
			<div class="row">
				<div class="col-md-6" align="rigth"><b>Reporte de Gesti&oacute;n</b>
					<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
					  	<option title="INFORME ACTUAL: REPORTABILIDAD CAUSALES DE CONTRATOS" value="#">Reportabilidad Causales</option>
					  	<option title="TRAZABILIDAD DOTACION POR PLANTAS" value="<?php echo base_url() ?>mandante/trazabilidad/<?php echo $id_planta ?>">Avance de Contrataciones</option>
					  	<option title="BASE DE DATOS DE CONTRATOS EXPORTACION A EXCEL" value="<?php echo base_url() ?>mandante/base_datos_contratos/<?php echo $id_planta ?>">Base de Datos de Contratos</option>
					  	<option title="REPORTABILIDAD DOTACION EQUIVALENTE/CANTIDAD CONTRATOS/POR TRABAJADOR" value="<?php echo base_url() ?>mandante/reportabilidad/<?php echo $id_planta ?>">Reportabilidad Dotaci&oacute;n</option>
					  	<option title="INDICADOR DE PERMANENCIA" value="<?php echo base_url() ?>mandante/indicador_permanencia/<?php echo $id_planta ?>">Indicador de Permanencia</option>
					</select>
	  				<br><br>
				</div>
				<div class="col-md-6" align="rigth">
					<b>Año Consolidado</b>
					<input type="radio" name="ano_consolidad3" id="ano_consolidad3" class="ano_consolidad3" value="2016" <?php if($fecha == "2016") echo "checked" ?> > 2016 
					<input type="radio" name="ano_consolidad4" id="ano_consolidad4" class="ano_consolidad4" value="2017" <?php if($fecha == "2017") echo "checked" ?> > 2017
					<input type="radio" name="ano_causales2018" id="ano_causales2018" class="ano_causales2018" value="2018" <?php if($fecha == "2018") echo "checked" ?> > 2018
					<input type="radio" name="ano_causales2019" id="ano_causales2019" class="ano_causales2019" value="2019" <?php if($fecha == "2019") echo "checked" ?> > 2019
				</div>
			</div>
			<div class="span10 offset1" style="margin-top:20px; text-align:center">
				<h5><b>CANTIDAD CONTRATOS VIGENTES AÑO <?php echo $fecha ?></b></h5>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-7" align="rigth">
						<table class="table">
							<thead>
								<th style="text-align:center">Causal A</th>
								<th style="text-align:center">Causal B</th>
								<th style="text-align:center">Causal C</th>
								<th style="text-align:center">Causal D</th>
								<th style="text-align:center">Causal E</th>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $c_contratosA ?></td>
									<td><?php echo $c_contratosB ?></td>
									<td><?php echo $c_contratosC ?></td>
									<td><?php echo $c_contratosD ?></td>
									<td><?php echo $c_contratosE ?></td>
								</tr>
								<tr>
									<input type="hidden" id="c_contratosA" value="<?php echo $c_contratosA ?>">
									<input type="hidden" id="c_contratosB" value="<?php echo $c_contratosB ?>">
									<input type="hidden" id="c_contratosC" value="<?php echo $c_contratosC ?>">
									<input type="hidden" id="c_contratosD" value="<?php echo $c_contratosD ?>">
									<input type="hidden" id="c_contratosE" value="<?php echo $c_contratosE ?>">
								</tr>
							</tbody>
						</table><br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-7" align="rigth">
						<div id="chartContainer2" style="height: 300px; width: 100%;"></div>
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
								<th style="text-align:center">Causal A</th>
								<th style="text-align:center">Causal B</th>
								<th style="text-align:center">Causal C</th>
								<th style="text-align:center">Causal D</th>
								<th style="text-align:center">Causal E</th>
							</thead>
							<tbody>
								<tr>
									<td><?php echo $por_trabajadorA ?></td>
									<td><?php echo $por_trabajadorB ?></td>
									<td><?php echo $por_trabajadorC ?></td>
									<td><?php echo $por_trabajadorD ?></td>
									<td><?php echo $por_trabajadorE ?></td>
								</tr>
								<tr>
									<input type="hidden" id="por_trabajadorA" value="<?php echo $por_trabajadorA ?>">
									<input type="hidden" id="por_trabajadorB" value="<?php echo $por_trabajadorB ?>">
									<input type="hidden" id="por_trabajadorC" value="<?php echo $por_trabajadorC ?>">
									<input type="hidden" id="por_trabajadorD" value="<?php echo $por_trabajadorD ?>">
									<input type="hidden" id="por_trabajadorE" value="<?php echo $por_trabajadorE ?>">
								</tr>
							</tbody>
						</table><br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2" align="rigth"></div>
					<div class="col-md-7" align="rigth">
						<div id="chartContainer3" style="height: 300px; width: 100%;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
