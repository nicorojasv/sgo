<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Visualiaci&oacute;n Datos Estado de Examen Psicologico</h4>
  </div>
  <div id="modal_content">
    <?php
      if ($listado != FALSE){
        foreach ($listado as $row){
    ?>
		<div class="modal-header">
      <div class="col-md-7">
        <h5><b>Trabajador:</b></h5>
        <p>Nombre:<br> <?php echo $row->nombres ?></p>
        <p>Rut:<br> <?php echo $row->rut_usuario ?></p>
      </div>
      <div class="col-md-5">
        <h5><b>Dato Examen:</b></h5>
        <p>Fecha Eval: <?php echo $row->fecha_e ?></p>
        <p>Centro Costo: <?php echo $row->ccosto ?></p>
        <p>Tipo Examen: <?php echo $row->tecnico_supervisor ?></p>
      </div>
      <br><br><br><br><br><br><br><br>
    </div><br>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Valor Examen</b></label>
            <div class="controls">
               <input type="text" value="<?php echo $row->valor_examen ?>" disabled>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Estado Cobro</b></label>
            <div class="controls">
              <select name="select_cobro" id="select_cobro" class="form-control" disabled>
                <option value="0" <?php if($row->estado_cobro == 0) echo "selected"; ?> >NO COBRADO</option>
                <option value="1" <?php if($row->estado_cobro == 1) echo "selected"; ?> >SI COBRADO</option>
                <option value="2" <?php if($row->estado_cobro == 2) echo "selected"; ?> >NO INFORMADO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Fecha Cobro</b></label>
            <div class="controls">
              <input type="text" value="<?php echo $row->fecha_cobro ?>" disabled>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Comentario</b></label>
            <div class="controls">
              <textarea class="form-control" name="comentario_pago" disabled><?php echo $row->comentario_cobro ?></textarea>
            </div>
          </div>
        </div>
        <?php
          }
            }else{
        ?>
          <p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
        <?php
          }
        ?> <br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
	</div>
</div>