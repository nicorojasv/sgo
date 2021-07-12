<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos Examen Conocimiento</h4>
  </div>
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>usuarios/perfil/modificar_exam_conocimientos_desempeno" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
      ?>
      <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Tipo de Examen de Conocimiento</label>
                <div class="controls">
                  <input type="hidden" name="id_eval" id="id_eval" value="<?php echo $row->id_eval ?>"/>
                  <input type="hidden" name="id_usu" id="id_usu" value="<?php echo $id_usu ?>"/>
                  <select name="id_tipo_eval" id="id_tipo_eval" style="width:260px" required>
                    <?php foreach ($exam_conocimientos as $key2) {  ?>
                    <option value="<?php echo $key2->id ?>" <?php if($row->id_tipo_eval == $key2->id) echo "selected" ?> ><?php echo $key2->nombre ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Evaluacion</label>
              <div class="controls">
                  <select name="fecha_eval_d" id="fecha_eval_d" style="width:60px" required>
                    <?php for ($i=1; $i < 32 ; $i++) { ?>
                    <option value="<?php echo $i ?>" <?php if($row->fecha_eval_d == $i) echo "selected" ?> ><?php echo $i ?></option>
                    <?php } ?>
                  </select>
                  <select name="fecha_eval_m" id="fecha_eval_m" style="width:110px" required>
                    <option value="1" <?php if($row->fecha_eval_m == "1") echo "selected" ?> >Enero</option>
                    <option value="2" <?php if($row->fecha_eval_m == "2") echo "selected" ?> >Febrero</option>
                    <option value="3" <?php if($row->fecha_eval_m == "3") echo "selected" ?> >Marzo</option>
                    <option value="4" <?php if($row->fecha_eval_m == "4") echo "selected" ?> >Abril</option>
                    <option value="5" <?php if($row->fecha_eval_m == "5") echo "selected" ?> >Mayo</option>
                    <option value="6" <?php if($row->fecha_eval_m == "6") echo "selected" ?> >Junio</option>
                    <option value="7" <?php if($row->fecha_eval_m == "7") echo "selected" ?> >Julio</option>
                    <option value="8" <?php if($row->fecha_eval_m == "8") echo "selected" ?> >Agosto</option>
                    <option value="9" <?php if($row->fecha_eval_m == "9") echo "selected" ?> >Septiembre</option>
                    <option value="10" <?php if($row->fecha_eval_m == "10") echo "selected" ?> >Octubre</option>
                    <option value="11" <?php if($row->fecha_eval_m == "11") echo "selected" ?> >Noviembre</option>
                    <option value="12" <?php if($row->fecha_eval_m == "12") echo "selected" ?> >Diciembre</option>
                  </select>
                  <select name="fecha_eval_a" id="fecha_eval_a" style="width:70px" required>
                    <?php 
                      $a_inicio = (date('Y') - 6);
                      $a_fin = (date('Y') + 6);
                      for ($k=$a_inicio; $k < $a_fin ; $k++){
                    ?>
                      <option value="<?php echo $k ?>" <?php if($row->fecha_eval_a == $k) echo "selected" ?> ><?php echo $k ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Vigencia</label>
                <div class="controls">
                  <select name="fecha_vig_d" id="fecha_vig_d" style="width:60px">
                    <option value="00" <?php if($row->fecha_vig_d == "00") echo "selected" ?> >DD</option>
                    <?php for ($j=1; $j < 32 ; $j++) { ?>
                    <option value="<?php echo $j ?>" <?php if($row->fecha_vig_d == $j) echo "selected" ?> ><?php echo $j ?></option>
                    <?php } ?>
                  </select>
                  <select name="fecha_vig_m" id="fecha_vig_m" style="width:110px">
                    <option value="00" <?php if($row->fecha_vig_m == "00") echo "selected" ?> >MM</option>
                    <option value="1" <?php if($row->fecha_vig_m == "1") echo "selected" ?> >Enero</option>
                    <option value="2" <?php if($row->fecha_vig_m == "2") echo "selected" ?> >Febrero</option>
                    <option value="3" <?php if($row->fecha_vig_m == "3") echo "selected" ?> >Marzo</option>
                    <option value="4" <?php if($row->fecha_vig_m == "4") echo "selected" ?> >Abril</option>
                    <option value="5" <?php if($row->fecha_vig_m == "5") echo "selected" ?> >Mayo</option>
                    <option value="6" <?php if($row->fecha_vig_m == "6") echo "selected" ?> >Junio</option>
                    <option value="7" <?php if($row->fecha_vig_m == "7") echo "selected" ?> >Julio</option>
                    <option value="8" <?php if($row->fecha_vig_m == "8") echo "selected" ?> >Agosto</option>
                    <option value="9" <?php if($row->fecha_vig_m == "9") echo "selected" ?> >Septiembre</option>
                    <option value="10" <?php if($row->fecha_vig_m == "10") echo "selected" ?> >Octubre</option>
                    <option value="11" <?php if($row->fecha_vig_m == "11") echo "selected" ?> >Noviembre</option>
                    <option value="12" <?php if($row->fecha_vig_m == "12") echo "selected" ?> >Diciembre</option>
                  </select>
                  <select name="fecha_vig_a" id="fecha_vig_a" style="width:70px">
                    <option value="00" <?php if($row->fecha_vig_a == "00") echo "selected" ?> >AAAA</option>
                    <?php 
                      $a_inicio = (date('Y') - 6);
                      $a_fin = (date('Y') + 6);
                      for ($k=$a_inicio; $k < $a_fin ; $k++){
                    ?>
                      <option value="<?php echo $k ?>" <?php if($row->fecha_vig_a == $k) echo "selected" ?> ><?php echo $k ?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Archivo Anterior</label>
                <div class="controls"><a href="<?php echo base_url().$row->url_archivo ?>" target="_blank">VISUALIZAR</a></div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Archivo</label>
                <div class="controls">
                  <input type="file" name="documento" id="documento">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Resultado</label>
              <div class="controls">
                <input type="text" name="resultado" id="resultado" value="<?php echo $row->resultado ?>" onkeypress='return valida1al7(event)' maxlength="4" placeholder="1-7"  required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Observaciones</label>
                <div class="controls">
                  <textarea name="observacion" id="observacion"><?php echo $row->observaciones ?></textarea>
              </div>
            </div>
          </div>
        <?php
          }
            }else{
        ?>
          <p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
        <?php } ?>
        <br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>