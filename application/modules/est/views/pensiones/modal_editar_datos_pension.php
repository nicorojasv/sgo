<div id="modal">
	<div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Actualizaci&oacute;n Datos de la Pensión</h4>
  </div>
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
    <form action="<?php echo base_url() ?>est/pensiones/actualizar_pension" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($pension != FALSE){
        foreach ($pension as $row){
      ?>
      <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Rut</label>
              <div class="controls">
                <input type="hidden" name="id_pension" id="id_pension" value="<?php echo $row->id_pension  ?>">
                <input type='text' class="input-mini" name="rut" id="rut" value="<?php echo $row->rut ?>" maxlength='12' onkeypress='return valida_letras_rut(event)' placeholder="11.111.111-1" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Razón Social</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="razon_social" id="razon_social" value="<?php echo $row->razon_social ?>" onkeypress='return valida_abecedario(event)' maxlength='200' required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">telefono</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="telefono" id="telefono" value="<?php echo $row->telefono ?>" required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Datos de la cuenta</label>
              <div class="controls">
                  <input type='text' class="input-mini" name="cuenta" id="cuenta" value="<?php echo $row->n_cuenta ?>" maxlength='500' required/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Documento del Contrato</label>
              <div class="controls">
                <?php if($row->doc_contrato != NULL){ ?>
                Archivo Anterior: <a href="<?php echo base_url().$row->doc_contrato ?>" target='_blank'>Contrato</a>
                <?php } ?>
                <input type="file" name="doc_contrato" id="doc_contrato">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Documento de la cuenta</label>
              <div class="controls">
                <?php if($row->doc_cuenta != NULL){ ?>
                Archivo Anterior: <a href="<?php echo base_url().$row->doc_cuenta ?>" target='_blank'>Cuenta</a>
                <?php } ?>
                <input type="file" name="doc_cuenta" id="doc_cuenta">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="inputTipo">Fecha Contrato</label>
              <div class="controls">
                <?php if($row->fecha_contrato){
                    $f = explode('-', $row->fecha_contrato);
                    $dia_fc = $f[2];
                    $mes_fc = $f[1];
                    $ano_fc = $f[0];
                  }else{
                    $dia_fc = false;
                    $mes_fc = false;
                    $ano_fc = false;
                  } ?>
                <select name="dia_fc" style="width: 60px;" required>
                  <option value="" >Dia</option>
                  <?php for($i=1;$i<32;$i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($dia_fc == $i)?"selected='selected'":'' ?> ><?php echo $i ?></option>
                  <?php } ?>
                </select>
                <select name="mes_fc" style="width: 108px;" required>
                  <option value="">Mes</option>
                  <option value='01' <?php echo ($mes_fc == "01")?"selected='selected'":'' ?> >Enero</option>
                  <option value='02' <?php echo ($mes_fc == "02")?"selected='selected'":'' ?> >Febrero</option>
                  <option value='03' <?php echo ($mes_fc == "03")?"selected='selected'":'' ?> >Marzo</option>
                  <option value='04' <?php echo ($mes_fc == "04")?"selected='selected'":'' ?> >Abril</option>
                  <option value='05' <?php echo ($mes_fc == "05")?"selected='selected'":'' ?> >Mayo</option>
                  <option value='06' <?php echo ($mes_fc == "06")?"selected='selected'":'' ?> >Junio</option>
                  <option value='07' <?php echo ($mes_fc == "07")?"selected='selected'":'' ?> >Julio</option>
                  <option value='08' <?php echo ($mes_fc == "08")?"selected='selected'":'' ?> >Agosto</option>
                  <option value='09' <?php echo ($mes_fc == "09")?"selected='selected'":'' ?> >Septiembre</option>
                  <option value='10' <?php echo ($mes_fc == "10")?"selected='selected'":'' ?> >Octubre</option>
                  <option value='11' <?php echo ($mes_fc == "11")?"selected='selected'":'' ?> >Noviembre</option>
                  <option value='12' <?php echo ($mes_fc == "12")?"selected='selected'":'' ?> >Diciembre</option>
                </select>
                <select name="ano_fc" style="width: 70px;" required>
                  <option value="">Año</option>
                  <?php $tope_f = (date('Y') - 2 ); ?>
                  <?php for($i = $tope_f; $i < (date('Y') + 2 ); $i++){ ?>
                    <option value="<?php echo $i ?>" <?php echo ($ano_fc == $i)?"selected='selected'":'' ?> ><?php echo $i ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Pension Completa</label>
                <div class="controls">
                   <input type="text" name="pension_completa" id="pension_completa" value="<?php echo $row->pension_completa ?>" placeholder="Valor Pension Completa" required>
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Almuerzo</label>
                <div class="controls">
                   <input type="text" name="almuerzo" id="almuerzo" value="<?php echo $row->almuerzo ?>" placeholder="Valor Almuerzo de la Pension">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Reserva</label>
                <div class="controls">
                   <input type="text" name="reserva" id="reserva" value="<?php echo $row->reserva ?>" placeholder="Valor Reserva de la Pension">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Otros Valores</label>
                <div class="controls">
                   <input type="text" name="otros_valores" id="otros_valores" value="<?php echo $row->otros_valores ?>" placeholder="Otros Valores de la Pension">
                </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputTipo">Centro de Costo</label>
                <div class="controls">
                  <select name="centro_costo" id="centro_costo" required>
                    <option value="">[Seleccione]</option>
                    <?php foreach ($empresas_planta as $key) { ?>
                      <option value="<?php echo $key->id ?>" <?php if($row->id_centro_costo == $key->id) echo "selected"; ?> ><?php echo $key->nombre ?></option>
            <?php } ?>
                  </select>
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
        ?> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
	</div>
</div>