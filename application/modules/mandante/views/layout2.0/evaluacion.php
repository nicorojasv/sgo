<div class="panel panel-white">
  <div class="panel-body">
    <div class="row">
          <div class="col-md-8" align="rigth">
        <h4><b>REQUERIMIENTO:</b> <?php echo $requerimiento->nombre ?> <b>PLANTA: </b><?php echo $empresa_planta->nombre ?></h4>
      </div>
          <div class="col-md-3"></div>
          <div class="col-md-1" style="text-align:center">
        <a href="<?php echo base_url() ?>mandante/planilla_pgp/<?php echo $id ?>/<?php echo $id_planta ?>"><i class="fa fa-reply"><br><b>Volver a Planilla de Suministro de Personal</b></i></a>
      </div>
    </div>
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
          <td><b><a><?php echo ucwords(mb_strtolower($l->nombre,'UTF-8')) ?></a><b/></td>
    			<td style="text-align:center;"><?php echo ucwords(mb_strtolower($l->cargo,'UTF-8')) ?></td>
    			<td style="text-align:center;"><?php echo ucwords(mb_strtolower($l->area,'UTF-8')) ?></td>
    			<td style="text-align:center;">Por Defecto</a></td>
          <td style="text-align:center;"><b><?php 
                if ($l->status){
                  if($l->status == 1) echo "No Disponible";
                  if($l->status == 2) echo "En Proceso";
                  if($l->status == 3) echo "En Servicio";
                  if($l->status == 4) echo "Renuncia";
                  if($l->status == 5) echo "Contrato Firmado";
                }
                else echo "No Contactado";
                ?></b></td>
          <td style="text-align:center;">
            <a class="sv-callback-list" data-usuario='<?php echo $l->usuario_id ?>' href="<?php echo base_url().'mandante/mandante/callback_view_documentos/'.$l->usuario_id ?>/<?php echo $l->asc_trabajadores ?>" style="color:blue;">
              <i class="fa fa-book" ></i>
            </a>
          </td>
          <td style="text-align:center;"><a class="sv-callback-list" href="<?php echo base_url() ?>mandante/mandante/modal_ingresar_evaluacion/<?php echo $l->usuario_id ?>/<?php echo $area_cargo_id ?>/<?php echo $id_planta ?>">Evaluar</a></td>
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