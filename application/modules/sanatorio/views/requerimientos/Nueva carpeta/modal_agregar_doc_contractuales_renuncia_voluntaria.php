<div id="modal">
  <form action="<?php echo base_url() ?>est/requerimiento/guardar_doc_contractual_renuncia_voluntaria/<?php echo $usuario?>/<?php echo $tipo?>/<?php echo $asc_area?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
        <div class="col-md-12">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Documento</label>
            <div class="controls">
              <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i>
                <input type="file" name="documento" required>
              </span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Fecha Renuncia</label>
            <div class="controls">
              <select name="dia_ft" style="width: 60px;" required>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_ft" style="width: 108px;" required>
                <option value="">Mes</option>
                <option value='01'>Enero</option>
                <option value='02'>Febrero</option>
                <option value='03'>Marzo</option>
                <option value='04'>Abril</option>
                <option value='05'>Mayo</option>
                <option value='06'>Junio</option>
                <option value='07'>Julio</option>
                <option value='08'>Augosto</option>
                <option value='09'>Septiembre</option>
                <option value='10'>Octubre</option>
                <option value='11'>Noviembre</option>
                <option value='12'>Diciembre</option>
              </select>
              <select name="ano_ft" style="width: 70px;" required>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php } ?>
              </select>
           </div>
          </div>
        </div>
      </div>
      <br><br><br><br><br><br><br><br><br>
      <div class="modal_content">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Agregar</button>
      </div>
    </form>
</div>