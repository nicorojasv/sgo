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
    <div class='clear'></div>
    <table id="example1">
    	<thead>
        <th style="text-align:center;">Nombre</th>
    		<th style="text-align:center;">Cargo</th>
    		<th style="text-align:center;">Area</th>
    		<th style="text-align:center;">Evaluador</th>
        <th style="text-align:center;">Status General</th>
    		<th style="text-align:center;">Doc. Contractuales</th>
        <th style="text-align:center;">Evaluar</th>
    		<th style="text-align:center;">Calificaci&oacute;n Final</th>
    	</thead>
    	<tbody>
        <?php foreach($listado as $l){ ?>
    		<tr>
          <td><b><a href='#'><?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?></a><b/></td>
    			<td style="text-align:center;"><?php echo ucwords(mb_strtolower($l->cargo,'UTF-8')) ?></td>
    			<td style="text-align:center;"><?php echo ucwords(mb_strtolower($l->area,'UTF-8')) ?></td>
    			<td style="text-align:center;">Por Defecto</a></td>
          <td style="text-align:center;"><b><?php 
                if ($l->status){
                  if($l->status == 1) echo "No Disponible";
                  if($l->status == 2) echo "En Proceso";
                  if($l->status == 3) echo "En Servicio";
                  if($l->status == 4) echo "Renuncia";
                }
                else echo "No Contactado";
                ?></b></td>
          <td style="text-align:center;">
            <a class="sv-callback-list" data-usuario='<?php echo $l->usuario_id ?>' href="<?php echo base_url().'carrera/requerimiento/callback_view_documentos2/'.$l->usuario_id ?>/<?php echo $l->asc_trabajadores ?>" style="color:blue;">
              <i class="fa fa-book" ></i>
            </a>
          </td>
          <td style="text-align:center;"><a class="sv-callback-list" href="<?php echo base_url() ?>carrera/requerimiento/modal_ingresar_evaluacion/<?php echo $l->usuario_id ?>/<?php echo $area_cargo_id ?>">Detalle Evaluacion</a></td>
          <td style="text-align:center;" class="col-xs-1"><input type="text" class="form-control" value='<?php echo $l->calificacion_final ?>' disabled></td>
    		</tr>
        <?php } ?>
    	</tbody>
    </table>

<!-- Modal Ingresar Evaluacion-->
<div class="modal fade" id="ModalEvaluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
<!-- End Modal -->