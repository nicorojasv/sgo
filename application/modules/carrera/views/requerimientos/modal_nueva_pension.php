<script>
  function calcularDias1(){
    var dia_fi = document.getElementById("dia_fi").value;
    var mes_fi = document.getElementById("mes_fi").value;
    var ano_fi = document.getElementById("ano_fi").value;
    var dia_ft = document.getElementById("dia_ft").value;
    var mes_ft = document.getElementById("mes_ft").value;
    var ano_ft = document.getElementById("ano_ft").value;
    var separador = "/";
    var fecha_inicio = ano_fi + separador + mes_fi + separador + dia_fi;
    var fecha_termino = ano_ft + separador + mes_ft + separador + dia_ft;
    var date1 = new Date(fecha_inicio);
    var date2 = new Date(fecha_termino);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24) + 1);
    var mensaje = "Numero de dias: ";
    var mensaje_fecha_menor = "La fecha de inicio es menor a la fecha de termino";

    if(date1 > date2){
      alert(mensaje_fecha_menor);
    }else{
      alert(mensaje + diffDays);
    }
  }

  function multiplica_dos_valores(a, b, sb) {
    var valor1 = parseInt(document.getElementById(a).value);
    var valor2 = parseInt(document.getElementById(b).value);
    document.getElementById(sb).value = valor1 * valor2;
  }

  function suma_cuatro_valores(a, b, c, d, sb) {
    var valor1 = parseInt(document.getElementById(a).value);
    var valor2 = parseInt(document.getElementById(b).value);
    var valor3 = parseInt(document.getElementById(c).value);
    var valor4 = parseInt(document.getElementById(d).value);
    document.getElementById(sb).value = valor1 + valor2 + valor3 + valor4;
  }

  function buscar_pension(){
    var pension = $('#pension').val();
    $.ajax({
      type: "POST",
      url:base_url+"carrera/requerimiento/buscar_detalles_pension/"+pension,
      contentType: "application/x-www-form-urlencoded",
      dataType: "json",
      success: function(data){
        $("#id_registro_valores").val(data['id']);
        $("#valor_pension_c").val(data['pension_completa']);
        $("#dias_pension_c").val(0);
        $("#total_pension_c").val(0);
        $("#valor_almuerzo_c").val(data['almuerzo']);
        $("#dias_almuerzo_c").val(0);
        $("#total_almuerzo_c").val(0);
        $("#valor_reserva_c").val(data['reserva']);
        $("#dias_reserva_c").val(0);
        $("#total_reserva_c").val(0);
        $("#valor_otros_valores_c").val(data['otros_valores']);
        $("#dias_otros_valores_c").val(0);
        $("#total_otros_valores_c").val(0);
        $("#total_c").val(0);
      }
    });
  }

</script>

<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimiento/guardar_nueva_pension_requerimiento" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <div id="modal_content">
		<div class="modal-header">
      <h5><u>Datos del Contrato y/o Anexo:</u></h5>
      <div class="row">
        <div class="col-md-6">
          <?php foreach ($datos_contrato as $dc) {
            echo "Fecha Inicio Contrato: ".$dc->fecha_inicio;
            echo "<br>";
            echo "Fecha Termino Contrato: ".$dc->fecha_termino;
          } ?>
        </div>
        <div class="col-md-6">
          <?php foreach ($datos_anexo as $da) {
            echo "Fecha Inicio Anexo: ".$da->fecha_inicio;
            echo "<br>";
            echo "Fecha Termino Anexo: ".$da->fecha_termino;
          } ?>
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
          <input type="hidden" name="id_req_area_cargo" id="id_req_area_cargo" value="<?php echo $id_req_area_cargo ?>">
        </div>
      </div>
    </div><br>
    <?php
      if ($datos_pension != FALSE){
        foreach ($datos_pension as $p1){
    ?>
    <div class="col-md-12">
      <div class="control-group">
        <label class="control-label" for="inputTipo"><b>Datos de la Pensión</b></label>
        <div class="controls">
          <select name="pension" id="pension" style="width:50%" required>
            <option value="">[Seleccione]</option>
            <?php foreach ($pensiones as $key){ ?>
            <option value="<?php echo $key->id ?>" <?php if($p1->id_pension1 == $key->id) echo "selected"; ?> ><?php echo $key->razon_social ?></option>
            <?php } ?>
          </select>
          <input type="button" class="btn btn-xs btn-primary" value="Cargar Datos" onclick="buscar_pension()">
          <input type="text" name="id_registro_valores" id="id_registro_valores" readonly="readonly" style="width:5%; border:1px solid red;" required>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="control-group">
        <label class="control-label" for="inputTipo"><b>Desde:</b></label>
        <div class="controls">
          <?php if($p1->fecha_inicio1){
            $f = explode('-', $p1->fecha_inicio1);
            $dia_fi = $f[2];
            $mes_fi = $f[1];
            $ano_fi = $f[0];
          }else{
            $dia_fi = false;
            $mes_fi = false;
            $ano_fi = false;
          } ?>
          <select name="dia_fi" id="dia_fi" required>
            <option value="" >Dia</option>
            <?php for($i=1;$i<32;$i++){ ?>
            <option <?php echo ($dia_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
            <?php } ?>
          </select>
          <select name="mes_fi" id="mes_fi" required>
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
          <select name="ano_fi" id="ano_fi" required>
            <option value="">Año</option>
            <?php $tope_f = (date('Y') - 5 ); ?>
            <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
              <option value="<?php echo $i ?>" <?php echo ($ano_fi == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="control-group">
        <label class="control-label" for="inputTipo"><b>Hasta:</b></label>
        <div class="controls">
          <?php if($p1->fecha_termino1){
            $f = explode('-', $p1->fecha_termino1);
            $dia_ft = $f[2];
            $mes_ft = $f[1];
            $ano_ft = $f[0];
          }else{
            $dia_ft = false;
            $mes_ft = false;
            $ano_ft = false;
          } ?>
          <select name="dia_ft" id="dia_ft" required>
            <option value="" >Dia</option>
            <?php for($i=1;$i<32;$i++){ ?>
            <option <?php echo ($dia_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
            <?php } ?>
          </select>
          <select name="mes_ft" id="mes_ft" required>
            <option value="">Mes</option>
            <option value='01' <?php echo ($mes_ft == '1')? "selected='selected'" : '' ?>>Enero</option>
            <option value='02' <?php echo ($mes_ft == '2')? "selected='selected'" : '' ?>>Febrero</option>
            <option value='03' <?php echo ($mes_ft == '3')? "selected='selected'" : '' ?>>Marzo</option>
            <option value='04' <?php echo ($mes_ft == '4')? "selected='selected'" : '' ?>>Abril</option>
            <option value='05' <?php echo ($mes_ft == '5')? "selected='selected'" : '' ?>>Mayo</option>
            <option value='06' <?php echo ($mes_ft == '6')? "selected='selected'" : '' ?>>Junio</option>
            <option value='07' <?php echo ($mes_ft == '7')? "selected='selected'" : '' ?>>Julio</option>
            <option value='08' <?php echo ($mes_ft == '8')? "selected='selected'" : '' ?>>Agosto</option>
            <option value='09' <?php echo ($mes_ft == '9')? "selected='selected'" : '' ?>>Septiembre</option>
            <option value='10' <?php echo ($mes_ft == '10')? "selected='selected'" : '' ?>>Octubre</option>
            <option value='11' <?php echo ($mes_ft == '11')? "selected='selected'" : '' ?>>Noviembre</option>
            <option value='12' <?php echo ($mes_ft == '12')? "selected='selected'" : '' ?>>Diciembre</option>
          </select>
          <select name="ano_ft" id="ano_ft" required>
            <option value="">Año</option>
            <?php $tope_f = (date('Y') - 5 ); ?>
            <?php for($i=$tope_f;$i < (date('Y') + 6 ); $i++){ ?>
              <option value="<?php echo $i ?>" <?php echo ($ano_ft == $i)? "selected='selected'" : '' ?>><?php echo $i ?></option>
            <?php } ?>
          </select>
          <input type="button" value="Calcular N° dias" onclick="calcularDias1()" >
        </div>
      </div>
    </div>
    <br><br><br><br>
    <div class="col-md-12">
      <div class="control-group">
        <br>
        <label class="control-label" for="inputTipo"><b>Pensión Completa</b></label>
        <div class="controls">
          Valor: <input type="text" name="valor_pension_c" id="valor_pension_c" value="<?php echo $p1->valor_pension_completa ?>" style="width:20%" readonly="readonly">
          N° Dias: <input type="text" name="dias_pension_c" id="dias_pension_c" value="<?php echo $p1->n_dias_pension_completa1 ?>" style="width:10%" onkeyup="javascript:multiplica_dos_valores('valor_pension_c', 'dias_pension_c', 'total_pension_c');javascript:suma_cuatro_valores('total_pension_c', 'total_almuerzo_c', 'total_reserva_c','total_otros_valores_c','total_c');">
          Total: <input type="text" name="total_pension_c" id="total_pension_c" value="<?php echo $p1->total_pension_completa ?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="control-group">
        <br>
        <label class="control-label" for="inputTipo"><b>Almuerzo</b></label>
        <div class="controls">
          Valor: <input type="text" name="valor_almuerzo_c" id="valor_almuerzo_c" value="<?php echo $p1->valor_almuerzo ?>" style="width:20%" readonly="readonly">
          N° Dias: <input type="text" name="dias_almuerzo_c" id="dias_almuerzo_c" value="<?php echo $p1->n_dias_almuerzo1 ?>" style="width:10%" onkeyup="javascript:multiplica_dos_valores('valor_almuerzo_c', 'dias_almuerzo_c', 'total_almuerzo_c');javascript:suma_cuatro_valores('total_pension_c', 'total_almuerzo_c', 'total_reserva_c','total_otros_valores_c','total_c');">
          Total: <input type="text" name="total_almuerzo_c" id="total_almuerzo_c" value="<?php echo $p1->total_almuerzo ?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="control-group">
        <br>
        <label class="control-label" for="inputTipo"><b>Reserva</b></label>
        <div class="controls">
          Valor: <input type="text" name="valor_reserva_c" id="valor_reserva_c" value="<?php echo $p1->valor_reserva ?>" style="width:20%" readonly="readonly">
          N° Dias: <input type="text" name="dias_reserva_c" id="dias_reserva_c" value="<?php echo $p1->n_dias_reserva1 ?>" style="width:10%" onkeyup="javascript:multiplica_dos_valores('valor_reserva_c', 'dias_reserva_c', 'total_reserva_c');javascript:suma_cuatro_valores('total_pension_c', 'total_almuerzo_c', 'total_reserva_c','total_otros_valores_c','total_c');">
          Total: <input type="text" name="total_reserva_c" id="total_reserva_c" value="<?php echo $p1->total_reserva ?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="control-group">
        <br>
        <label class="control-label" for="inputTipo"><b>Otros Valores</b></label>
        <div class="controls">
          Valor: <input type="text" name="valor_otros_valores_c" id="valor_otros_valores_c" value="<?php echo $p1->valor_otros_valores ?>" style="width:20%" readonly="readonly">
          N° Dias: <input type="text" name="dias_otros_valores_c" id="dias_otros_valores_c" value="<?php echo $p1->n_dias_otros_valores1 ?>" style="width:10%" onkeyup="javascript:multiplica_dos_valores('valor_otros_valores_c', 'dias_otros_valores_c', 'total_otros_valores_c');javascript:suma_cuatro_valores('total_pension_c', 'total_almuerzo_c', 'total_reserva_c','total_otros_valores_c','total_c');">
          Total: <input type="text" name="total_otros_valores_c" id="total_otros_valores_c" value="<?php echo $p1->total_otros_valores ?>" readonly="readonly">
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="control-group">
        <br>
        <div class="controls">
          <label class="control-label" for="inputTipo"><b>Totales</b></label><input type="text" name="total_c" id="total_c" value="<?php echo $p1->total_totales ?>" readonly="readonly">
        </div>
      </div>
    </div>
    <?php
      }
    }else{}
    ?>
  </div>
  <div class="modal_content">
    <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" name="guardar" class="btn btn-primary">Guardar</button>
  </div>
  </form>
</div>