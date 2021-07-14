<script>
function calcularDias(){
var date1 = new Date(document.getElementById("fecha_inicio").value);
var date2 = new Date(document.getElementById("fecha_termino").value);
var timeDiff = Math.abs(date2.getTime() - date1.getTime());
var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1);
//alert(diffDays);
document.getElementById("resultado").value = diffDays;
}
    </script>
<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimiento/actualizar_doc_contractual_general/<?php echo $id_usu_arch?>/<?php echo $id_area_cargo?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <div id="modal_content">
		<div class="modal-header">
      <h5>Instrucciones:</h5>
      <p>* Todos los campos sus obligatorios.</p>
    </div><br>
        <?php
          if ($datos_usu_arch != FALSE){
            foreach ($datos_usu_arch as $row){
        ?>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="inputTipo">Causal</label>
            <div class="controls">
              <select name="causal" id="causal" required>
                <option value="<?php echo $row->causal ?>"><?php echo $row->causal ?></option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Motivo</label>
            <div class="controls">
              <input type='text' class="input-mini" name="motivo" id="motivo" value="<?php echo $row->motivo?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Documento</label>
            <div class="controls">
              <a href="<?php echo base_url().$row->url ?>" style="color:green" target="_blank"><?php echo $row->nombre ?></a><br>
              <span class="btn btn-file btn-light-grey"><i class="fa fa-folder-open-o"></i>
                <input type="file" name="documento">
              </span>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Fecha Inicio</label>
            <div class="controls">
              <?php if($row->fecha_inicio){
                $f = explode('-', $row->fecha_inicio);
                $dia_fi = $f[2];
                $mes_fi = $f[1];
                $ano_fi = $f[0];
              }else{
                $dia_fi = false;
                $mes_fi = false;
                $ano_fi = false;
              } ?>
              <select name="dia_fi" style="width: 60px;" required>
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_fi" style="width: 108px;" required>
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_fi == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php echo ($mes_fi == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php echo ($mes_fi == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php echo ($mes_fi == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php echo ($mes_fi == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php echo ($mes_fi == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php echo ($mes_fi == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php echo ($mes_fi == '8')? "selected='selected'" : '' ?>>Agosto</option>
                <option value='09' <?php echo ($mes_fi == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php echo ($mes_fi == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php echo ($mes_fi == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php echo ($mes_fi == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <select name="ano_fi" style="width: 70px;" required>
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Fecha Termino</label>
            <div class="controls">
              <?php if($row->fecha_termino){
                $f = explode('-', $row->fecha_termino);
                $dia_ft = $f[2];
                $mes_ft = $f[1];
                $ano_ft = $f[0];
              }else{
                $dia_ft = false;
                $mes_ft = false;
                $ano_ft = false;
              } ?>
              <select name="dia_ft" style="width: 60px;">
                <option value="" >Dia</option>
                <?php for($i=1;$i<32;$i++){ ?>
                <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
              <select name="mes_ft" style="width: 108px;">
                <option value="">Mes</option>
                <option value='01' <?php echo ($mes_ft == '1')? "selected='selected'" : '' ?>>Enero</option>
                <option value='02' <?php echo ($mes_ft == '2')? "selected='selected'" : '' ?>>Febrero</option>
                <option value='03' <?php echo ($mes_ft == '3')? "selected='selected'" : '' ?>>Marzo</option>
                <option value='04' <?php echo ($mes_ft == '4')? "selected='selected'" : '' ?>>Abril</option>
                <option value='05' <?php echo ($mes_ft == '5')? "selected='selected'" : '' ?>>Mayo</option>
                <option value='06' <?php echo ($mes_ft == '6')? "selected='selected'" : '' ?>>Junio</option>
                <option value='07' <?php echo ($mes_ft == '7')? "selected='selected'" : '' ?>>Julio</option>
                <option value='08' <?php echo ($mes_ft == '8')? "selected='selected'" : '' ?>>Augosto</option>
                <option value='09' <?php echo ($mes_ft == '9')? "selected='selected'" : '' ?>>Septiembre</option>
                <option value='10' <?php echo ($mes_ft == '10')? "selected='selected'" : '' ?>>Octubre</option>
                <option value='11' <?php echo ($mes_ft == '11')? "selected='selected'" : '' ?>>Noviembre</option>
                <option value='12' <?php echo ($mes_ft == '12')? "selected='selected'" : '' ?>>Diciembre</option>
              </select>
              <select name="ano_ft" style="width: 70px;">
                <option value="">Año</option>
                <?php $tope_f = (date('Y') - 5 ); ?>
                <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
                  <option value="<?php echo $i ?>" <?php echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
           </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo"><b>Dias Duración Contrato</b></label>
            <div class="controls">
              <input type="text" name="resultado" id="resultado" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
         <div class="control-group">
            <label class="control-label" for="inputTipo">Jornada</label>
            <div class="controls">
              <select name="jornada" id="jornada" required>
                <option value="<?php echo $row->jornada ?>"><?php echo $row->jornada ?></option>
                <option value="Administrativa">Administrativa</option>
                <option value="Turno">Turno</option>
                <option value="Otra Opcion">Otra Opcion</option>
              </select>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="inputTipo">Sueldo Base de la Liquidación</label>
            <div class="controls">
              <input type='text' class="input-mini" name="renta_imponible" id="renta_imponible" value="<?php echo $row->renta_imponible?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Bono Responsabilidad</label>
            <div class="controls">
              <input type='text' class="input-mini" name="bono_responsabilidad" id="bono_responsabilidad" value="<?php echo $row->bono_responsabilidad ?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Sueldo Base + Bonos Fijos</label>
            <div class="controls">
              <input type='text' class="input-mini" name="sueldo_base_mas_bonos_fijos" id="sueldo_base_mas_bonos_fijos" value="<?php echo $row->sueldo_base_mas_bonos_fijos ?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Asignación Colación</label>
            <div class="controls">
              <input type='text' class="input-mini" name="asignacion_colacion" id="asignacion_colacion" value="<?php echo $row->asignacion_colacion?>" required/>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputTipo">Otros no Imponibles</label>
            <div class="controls">
              <input type='text' class="input-mini" name="otros_no_imponibles" id="otros_no_imponibles" value="<?php echo $row->otros_no_imponibles?>" required/>
            </div>
          </div>
        </div>
        <?php
            }
          }
        ?>
      </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <div class="modal_content">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary">Agregar</button>
      </div>
    </form>
</div>