<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
   google.load("visualization", "1", {packages:["corechart"]});
   google.setOnLoadCallback(dibujarGrafico);
   function dibujarGrafico(){

    var causalA = document.getElementById("causalA").value;
    var causalB = document.getElementById("causalB").value;
    var causalC = document.getElementById("causalC").value;
    var causalD = document.getElementById("causalD").value;
    var causalE = document.getElementById("causalE").value;

     var data = google.visualization.arrayToDataTable([
       ['Texto', 'Valores'],
       ['Causal A', Number(causalA)],
       ['Causal B', Number(causalB)],
       ['Causal C', Number(causalC)],
       ['Causal D', Number(causalD)],
       ['Causal E', Number(causalE)]
     ]);
     var options = {
       title: 'Reportabilidad Causales de Contratacion'
     }
     new google.visualization.ColumnChart(
       document.getElementById('GraficoGoogleChart-ejemplo-1')
     ).draw(data, options);
   }
 </script> 
<div class="panel panel-white">
  <div class="panel-heading">
    <h4 class="panel-title"></h4>
    <div class="panel-tools">
      <div class="dropdown">
        <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
          <i class="fa fa-cog"></i>
        </a>
        <ul class="dropdown-menu dropdown-light pull-right" role="menu">
          <li>
            <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
          </li>
          <li>
            <a class="panel-refresh" href="#">
              <i class="fa fa-refresh"></i> <span>Refresh</span>
            </a>
          </li>
          <li>
            <a class="panel-config" href="#panel-config" data-toggle="modal">
              <i class="fa fa-wrench"></i> <span>Configurations</span>
            </a>
          </li>
          <li>
            <a class="panel-expand" href="#">
              <i class="fa fa-expand"></i> <span>Fullscreen</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="panel-body">
		<div class="row-fluid">
			<div class="row">
				<div class="col-md-4" align="center"><?php echo $requerimiento->nombre ?></div>
				<div class="col-md-3" align="center">
					<select name="ordenar" id="ordenar" onChange="window.location.href=document.getElementById(this.id).value">
					  	<option value="#">Causales de Contratacion</option>
					  	<option value="<?php echo base_url() ?>mandante/avance_pgp/<?php echo $id_requerimiento ?>">Avance Contratacion</option>
					</select>
	  				<br><br>
				</div>
			</div>
			<div class="span8 offset2" >
				<input type="hidden" id="causalA" name="causalA" value="<?php echo $causalA ?>">
				<input type="hidden" id="causalB" name="causalB" value="<?php echo $causalB ?>">
				<input type="hidden" id="causalC" name="causalC" value="<?php echo $causalC ?>">
				<input type="hidden" id="causalD" name="causalD" value="<?php echo $causalD ?>">
				<input type="hidden" id="causalE" name="causalE" value="<?php echo $causalE ?>">
				<div id="GraficoGoogleChart-ejemplo-1" style="width: 800px; height: 600px"></div>
			</div>
			<div class="span10 offset1" style="margin-top:20px;"></div>
		</div>
	</div>
</div>
