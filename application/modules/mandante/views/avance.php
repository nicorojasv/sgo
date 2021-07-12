<?php 
	echo @$avisos;
?>
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/jqwidgets/jqxdraw.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/jqwidgets/jqxchart.core.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>extras/js/jqwidgets/jqxdata.js"></script>

<div class="row-fluid">
	<div class="span8 offset2" >
		<div style='border: 1px solid black;padding-top:20px;padding-bottom:20px;padding-left:10px; padding-right:10px'>
			<div class='pgp-left' style='float:left' >
				<div class='pgp-title'>PGP XXXXX año XXXX</div>
				<div class='pgp-subtitle'><small>Periodo xx/xx/xxxx al xx/xx/xxxx</small></div>
			</div>
			<div class='pgp-center' style='float:left; margin-left:140px' >
				<span class='' style='float:left'>Dotaci&oacute;n: 340</span>
				<div class="progressBar" style='margin-left:10px;float:left'><div></div></div>
			</div>
			<div class='pgp-right' style='float:right' >
				<div class=''><span class='circulito verde'></span>Contactados: 40 <span class='circulito rojo'></span>No Contactados: 300</div>
			</div>
			<div class='clear'></div>
		</div>
		<div style='position:relative;float:right;margin-right: -83px;'><a href='<?php echo base_url() ?>mandante/planilla_pgp'>Ver Planilla <i class="icon-hand-left"></i></a></div>
	</div>
	<div class="span10 offset1" style="margin-top:20px;">
		<div class='span12'>
			<table class='table table-hover table-condensed table-striped'>
				<thead style="background-color:#D7D7D7">
					<th style="text-align:center;width:220px"><b>Item</b></th>
					<th style="text-align:center;"><b>Si</b></th>
					<th style="text-align:center;"><b>No</b></th>
					<th style="text-align:center;"><b>Avance(%)</b></th>
					<th style="text-align:center;"><b>Progreso</b></th>
				</thead>
				<tbody>
					<tr>
						<td><b>Contactados</b></td>
						<td style="text-align:center;">340</td>
						<td style="text-align:center;">-60</td>
						<td style="text-align:center;">98</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
					<tr>
						<td><b>Diponibilidad</b></td>
						<td style="text-align:center;">250</td>
						<td style="text-align:center;">50</td>
						<td style="text-align:center;">74</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
					<tr>
						<td><b>Certificaci&oacute;n</b></td>
						<td style="text-align:center;">200</td>
						<td style="text-align:center;">140</td>
						<td style="text-align:center;">59</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
					<tr>
						<td><b>Examenes</b></td>
						<td style="text-align:center;">300</td>
						<td style="text-align:center;">40</td>
						<td style="text-align:center;">88</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
					<tr>
						<td><b>Charla Masso</b></td>
						<td style="text-align:center;">240</td>
						<td style="text-align:center;">100</td>
						<td style="text-align:center;">71</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
					<tr>
						<td><b>Contratos</b></td>
						<td style="text-align:center;">200</td>
						<td style="text-align:center;">140</td>
						<td style="text-align:center;">159</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
					<tr style="border-bottom:1px solid #DDD">
						<td><b>En Planta</b></td>
						<td style="text-align:center;">0</td>
						<td style="text-align:center;">340</td>
						<td style="text-align:center;">0</td>
						<td style="text-align:center;width:210px;"><div class="progressBar" style=''><div></div></div></td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
	<div class="span10 offset1" style="margin-top:20px;">
		<!--<div id="chartContainer" style="height: 500px;"></div>-->
	</div>
</div>

<script type="text/javascript">
function progressBar(percent, $element) {
var progressBarWidth = percent * $element.width() / 100;
$element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
}
</script>

<script>
progressBar(20, $('.progressBar'));
</script>
<!--
<script type="text/javascript">
Morris.Bar({
element: 'myfirstchart',
//axes: false,
data: [
{x: 'Contactados', y: 340},
{x: 'Disponibilidad', y: 250},
{x: 'Certificación', y: 200},
{x: 'Examenes', y: 300},
{x: 'Charla Masso', y: 240},
{x: 'Contratos', y: 200},
{x: 'En Planta', y: 0}
],
xkey: 'x',
ykeys: ['y', 'z'],
labels: ['Contactados', 'Disponibilidad','Certificación','Examenes','Charla Masso','Contratos','En Planta']
}).on('click', function(i, row){
console.log(i, row);
});
</script>
-->
<script type="text/javascript">
        $(document).ready(function () {
            // prepare chart data as an array            
            var source =
            {
                datatype: "csv",
                datafields: [
                    { name: 'Country' },
                    { name: 'GDP' },
                    { name: 'DebtPercent' },
                    { name: 'wea' }
                ],
                url: '<?php echo base_url() ?>extras/js/jqwidgets/gdp_dept_2010.txt'
            };
            var dataAdapter = new $.jqx.dataAdapter(source, { async: false, autoBind: true, loadError: function (xhr, status, error) { alert('Error loading "' + source.url + '" : ' + error);} });
            // prepare jqxChart settings
            var settings = {
                title: "Avance PGP",
                description: "PGP xxxxx 2014",
                showLegend: true,
                enableAnimations: true,
                padding: { left: 40, top: 40, right: 40, bottom: 40 },
                titlePadding: { left: 90, top: -30, right: 0, bottom: 10 },
                source: dataAdapter,
                xAxis:
                    {
                        dataField: 'Country',
                        showGridLines: true
                    },
                colorScheme: 'scheme01',
                seriesGroups:
                    [
                        {
                            type: 'column',
                            columnsGapPercent: 50,
                            valueAxis:
                            {
                                unitInterval: 50,
                                displayValueAxis: true,
                                description: 'GDP & Debt per Capita($)'
                            },
                            series: [
                                    { dataField: 'GDP', displayText: 'GDP per Capita'}
                                ]
                        },
                        {
                            type: 'line',
                            valueAxis:
                            {
                                unitInterval: 200,
                                displayValueAxis: true,
                                description: 'Personal Solicitado'
                            },
                            series: [
                                    { dataField: 'DebtPercent', displayText: 'Personal Solicitado: 350' }
                                ]
                        }
                    ]
            };
            // setup the chart
            $('#chartContainer').jqxChart(settings);
        });
    </script>