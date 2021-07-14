<div id="modal">
	<div class="modal-header">
    <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel" align="center">Actualizaci&oacute;n Datos Solicitud</h4>
  </div>
  <div id="modal_content">
    <form  action="#"  role="form" id="form2" method='post' name="f2" enctype="multipart/form-data" autocomplete="off">
      <?php
        if ($lista_aux != FALSE){
          foreach ($lista_aux as $row){
      ?>
      <br><br>
      <div class="col-md-6">
        <input type='hidden' value="<?php echo $row->id ?>" name="id_registro" id="id_registro"/>
        <div class="control-group">
          <label class="control-label" for="inputTipo">Estado</label>
          <div class="controls">
            <select name="estado" class="input-mini" id="seleccion<?php echo $row->id  ?>"  required <?php if($estado_bloqueo == "SI") echo "disabled"; ?> >
              <option value="">[Seleccione]</option>
              <option value="0" <?php if($row->estado == 0) echo "selected" ?> >En Proceso</option>
              <option value="1" <?php if($row->estado == 1) echo "selected" ?> >Aprobado</option>
              <option value="2" <?php if($row->estado == 2) echo "selected" ?> >Rechazado</option>
              <option value="3" <?php if($row->estado == 3) echo "selected" ?> >No Asiste</option>
            </select>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="control-group">
          <label class="control-label" for="inputTipo">Observaciones</label>
          <div class="controls">
            <textarea name="observaciones" id="observaciones" class="input-mini"  <?php if($estado_bloqueo == "SI") echo "disabled"; ?> ><?php echo $row->observaciones ?></textarea>
          </div>
          <input type="hidden" name="tipoExamen" value="<?php echo $id_tipo_eval ?>">
        </div>
      </div>
             <?php
                if (isset($examenPsicologico)) {
                  foreach ($datos_examen as $row5) {
            ?>

                        <div class="col-md-6" id="psicologoJs">
                            <div class="form-group">
                                    <label class="control-label" for="inputTipo">Fecha Evaluacion</label>
                                <div class="controls">
                                        <?php
                                  $f = explode('-', $row5->fecha_evaluacion);
                                  $dia_e = $f[2];
                                  $mes_e = $f[1];
                                  $ano_e = $f[0];
                                ?>
                                        <select name="dia_e" style="width: 60px;" required>
                                  <option value="" >Dia</option>
                                  <?php for($i=1;$i<32;$i++){ ?>
                                  <option value="<?php echo $i ?>" <?php echo ($dia_e == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                                  <?php } ?>
                                </select>
                                <select name="mes_e" style="width: 108px;" required>
                                  <option value="">Mes</option>
                                  <option value='01' <?php echo ($mes_e == '1')? "selected='selected'" : '' ?> >Enero</option>
                                  <option value='02' <?php echo ($mes_e == '2')? "selected='selected'" : '' ?> >Febrero</option>
                                  <option value='03' <?php echo ($mes_e == '3')? "selected='selected'" : '' ?> >Marzo</option>
                                  <option value='04' <?php echo ($mes_e == '4')? "selected='selected'" : '' ?> >Abril</option>
                                  <option value='05' <?php echo ($mes_e == '5')? "selected='selected'" : '' ?> >Mayo</option>
                                  <option value='06' <?php echo ($mes_e == '6')? "selected='selected'" : '' ?> >Junio</option>
                                  <option value='07' <?php echo ($mes_e == '7')? "selected='selected'" : '' ?> >Julio</option>
                                  <option value='08' <?php echo ($mes_e == '8')? "selected='selected'" : '' ?> >Agosto</option>
                                  <option value='09' <?php echo ($mes_e == '9')? "selected='selected'" : '' ?> >Septiembre</option>
                                  <option value='10' <?php echo ($mes_e == '10')? "selected='selected'" : '' ?> >Octubre</option>
                                  <option value='11' <?php echo ($mes_e == '11')? "selected='selected'" : '' ?> >Noviembre</option>
                                  <option value='12' <?php echo ($mes_e == '12')? "selected='selected'" : '' ?> >Diciembre</option>
                                </select>
                                <select name="ano_e" style="width: 70px;" required>
                                  <option value="">Año</option>
                                  <?php $tope_f = (date('Y')-2); ?>
                                  <?php for($i=$tope_f;$i < (date('Y') + 4); $i++){ ?>
                                    <option value="<?php echo $i ?>" <?php echo ($ano_e == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                                  <?php } ?>
                                </select>
                                    </div>
                            </div>
                          </div>
                            <div class="col-md-6">  
                            <div class="form-group">
                                  <label class="control-label" for="inputTipo">Fecha Vigencia</label>
                                  <div class="controls">
                                        <?php
                                          $g = explode('-', $row5->fecha_vigencia);
                                          $dia_v = $g[2];
                                          $mes_v = $g[1];
                                          $ano_v = $g[0];
                                        ?>
                                        <select name="dia_v" style="width: 60px;">
                                          <option value="" >Dia</option>
                                          <?php for($i=1;$i<32;$i++){ ?>
                                          <option value="<?php echo $i ?>" <?php echo ($dia_v == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                                          <?php } ?>
                                       </select>
                                       <select name="mes_v" style="width: 108px;">
                                          <option value="">Mes</option>
                                          <option value='01' <?php echo ($mes_v == '1')? "selected='selected'" : '' ?> >Enero</option>
                                          <option value='02' <?php echo ($mes_v == '2')? "selected='selected'" : '' ?> >Febrero</option>
                                          <option value='03' <?php echo ($mes_v == '3')? "selected='selected'" : '' ?> >Marzo</option>
                                          <option value='04' <?php echo ($mes_v == '4')? "selected='selected'" : '' ?> >Abril</option>
                                          <option value='05' <?php echo ($mes_v == '5')? "selected='selected'" : '' ?> >Mayo</option>
                                          <option value='06' <?php echo ($mes_v == '6')? "selected='selected'" : '' ?> >Junio</option>
                                          <option value='07' <?php echo ($mes_v == '7')? "selected='selected'" : '' ?> >Julio</option>
                                          <option value='08' <?php echo ($mes_v == '8')? "selected='selected'" : '' ?> >Agosto</option>
                                          <option value='09' <?php echo ($mes_v == '9')? "selected='selected'" : '' ?> >Septiembre</option>
                                          <option value='10' <?php echo ($mes_v == '10')? "selected='selected'" : '' ?> >Octubre</option>
                                          <option value='11' <?php echo ($mes_v == '11')? "selected='selected'" : '' ?> >Noviembre</option>
                                          <option value='12' <?php echo ($mes_v == '12')? "selected='selected'" : '' ?> >Diciembre</option>
                                       </select>
                                      <select name="ano_v" style="width: 70px;">
                                        <option value="">Año</option>
                                        <?php $tope_f = (date('Y')-2); ?>
                                        <?php for($i=$tope_f;$i < (date('Y') + 4 ); $i++){ ?>
                                          <option value="<?php echo $i ?>" <?php echo ($ano_v == $i)? "selected='selected'" : '' ?> ><?php echo $i ?></option>
                                        <?php } ?>
                                      </select>
                                  </div>
                            </div>
                          </div>

                            <div class="col-md-12">
                                  <div class="form-group">
                                    <label class="control-label" for="inputTipo">Resultado</label>
                                    <div class="controls">
                                        <select name="resultado" id="resultado" required>
                                          <option value="">[Seleccione]</option>
                                          <option value="A" <?php if($row5->resultado == "A") echo "selected" ?> >A</option>
                                          <option value="B" <?php if($row5->resultado == "B") echo "selected" ?> >B</option>
                                          <option value="C" <?php if($row5->resultado == "C") echo "selected" ?> >C</option>
                                          <option value="NA" <?php if($row5->resultado == "NA") echo "selected" ?> >No Aprueba</option>
                                        </select>
                                      </div>
                                  </div>
                                
                                  <div class="form-group">
                                    <label class="control-label" for="inputTipo">Psicologo/a Evaluador</label>
                                    <div class="controls">
                                        <select name="psicologo" id="psicologo" required>
                                          <option value="">[Seleccione]</option>
                                         <?php foreach ($psicologos as $key){ ?>
                                        <option value="<?php echo $key->id ?>" <?php if($row5->psicologo_id == $key->id) echo "selected" ?>  ><?php echo $key->nombres." ".$key->paterno." ".$key->materno ?></option>
                                        <?php } ?>
                                        </select>
                                      </div>
                                  </div>
                            </div>     
            <?php 
                      }
                    }
          ?>
      <?php
        }
        }else{
      ?>
        <p style='color:#088A08; font-weight: bold;'>OCURRIO UN ERROR EN LA CONSULTA.</p>
      <?php
        }
      ?>
      <br><br>
      <?php if($id_tipo_eval == 2){ ?>
      <table class="table">
        <thead>
          <tr>
            <th class="center">Cargos Aptos</th>
          </tr>
        </thead>
        <tbody>
          <?php $a = 0; foreach ($cargos_aptos as $key2){ $a += 1; ?>
          <tr>
            <td class="center"><?php echo $a ?></td>
            <td class="center"><?php echo $key2->nombre_cargo ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php }else{
        echo "<br><br><br>";
      } ?>
      <?php 
        if (isset($idExamen)) {
      ?>
        <input type='hidden' value="<?php echo $idExamen ?>" name="idExamen" id="idExamen"/>

      <?php
        }
      ?>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" class="btn btn-primary actualizar" <?php if($estado_bloqueo == "SI") echo "disabled"; ?> >Actualizar</button>
      </div>
    </form>
	</div>
</div>
<?php /*
if($sre_eval_req_estado == 0){
            $aux->color_estado_eval_sre_preo = "#D7DF01";
            $aux->letra_estado_eval_sre_preo = "EP";
            $proceso_completo += 1;
          }elseif($sre_eval_req_estado == 1){
            $aux->color_estado_eval_sre_preo = "green";
            $aux->letra_estado_eval_sre_preo = "A";
          }elseif($sre_eval_req_estado == 2){
            $aux->color_estado_eval_sre_preo = "red";
            $aux->letra_estado_eval_sre_preo = "R";
          }elseif($sre_eval_req_estado == 3){
            $aux->color_estado_eval_sre_preo = "#886A08";
            $aux->letra_estado_eval_sre_preo = "NA";
          }*/
?>
<script type="text/javascript">

$(document).ready(function() {/*20-09-2018 g.r.m */
$( "form" ).submit(function( event ) {
 console.log(( $( this ).serializeArray() ));

  var formulario =( $( this ).serializeArray() );
  idSolicitud = formulario[0].value; //indice 0 por el primer elemento del formulario
  //console.log(idSolicitud);
  tipoExamen = formulario[3].value; //obtengo 1 si es masso- 2 si es preocupacional- 3 si es psicologico
  if ( document.getElementById( "psicologoJs" )) {
      dia=formulario[7].value;
      mes=formulario[8].value;
      ano=formulario[9].value;
      if (dia<10) {
        dia =0+dia;
     }
  }
  var opcionSeleccionada = document.getElementById("seleccion"+idSolicitud).value;
                      $.ajax({
                        type: "POST",
                        url: base_url+"carrera/trabajadores/actualizar_sre_eval_req/",
                        data: formulario,
                        dataType: "json",
                        success: function(data) {    
                          if (data == 1) {
                              if (opcionSeleccionada == 0) {//en proceso
                                  if (tipoExamen == 1) {//masso
                                    alertify.warning('Maso En Proceso');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-1').empty();
                                    $('#jsbadge'+idSolicitud+'-1').append(' <span class="badge jsbadge'+idSolicitud+'-1" style="background-color:#D7DF01">EP</span>');
                                  }else if (tipoExamen == 2) {
                                    alertify.warning('Examen Preocupacional En Proceso');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-2').empty();
                                    $('#jsbadge'+idSolicitud+'-2').append(' <span class="badge jsbadge'+idSolicitud+'-2" style="background-color:#D7DF01">EP</span>');
                                  }else if (tipoExamen == 3) {
                                    alertify.warning('Examen Psicologico En Proceso');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-3').empty();
                                    $('#jsbadge'+idSolicitud+'-3').append(' <span class="badge jsbadge'+idSolicitud+'-3" style="background-color:#D7DF01">EP</span>');
                                    $('#jsbadge2'+idSolicitud+'-3').empty();
                                    $('#jsbadge2'+idSolicitud+'-3').append(ano+"-"+mes+"-"+dia);
                                  }
                              }else if(opcionSeleccionada == 1){// Aprobada
                                  if (tipoExamen == 1) {//masso
                                    alertify.success('Maso Aprobada');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-1').empty();
                                    $('#jsbadge'+idSolicitud+'-1').append(' <span class="badge jsbadge'+idSolicitud+'-1" style="background-color:green">A</span>');
                                  }else if (tipoExamen == 2) {//Preocupacional
                                    alertify.success('Examen Preocupacional Aprobado');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-2').empty();
                                    $('#jsbadge'+idSolicitud+'-2').append(' <span class="badge jsbadge'+idSolicitud+'-2" style="background-color:green">A</span>');
                                  }else if (tipoExamen == 3) {//Psicologico
                                    alertify.success('Examen Psicologico Aprobado');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-3').empty();
                                    $('#jsbadge'+idSolicitud+'-3').append(' <span class="badge jsbadge'+idSolicitud+'-3" style="background-color:green">A</span>');
                                    $('#jsbadge2'+idSolicitud+'-3').empty();
                                    $('#jsbadge2'+idSolicitud+'-3').append(ano+"-"+mes+"-"+dia);
                                  }
                              }else if (opcionSeleccionada == 2) {//Rechazado
                                  if (tipoExamen == 1) {//masso
                                    alertify.error('Maso Rechazada');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-1').empty();
                                    $('#jsbadge'+idSolicitud+'-1').append(' <span class="badge jsbadge'+idSolicitud+'-1" style="background-color:red">R</span>');
                                  }else if (tipoExamen == 2) {//Preocupacional
                                    console.log(idSolicitud);
                                    alertify.error('Examen Preocupacional Rechazado');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-2').empty();
                                    $('#jsbadge'+idSolicitud+'-2').append(' <span class="badge jsbadge'+idSolicitud+'-2" style="background-color:red">R</span>');
                                  }else if (tipoExamen == 3) {//Psicologico
                                    console.log("entre");
                                    alertify.error('Examen Psicologico Rechazado');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-3').empty();
                                    $('#jsbadge'+idSolicitud+'-3').append(' <span class="badge jsbadge'+idSolicitud+'-3" style="background-color:red">R</span>');
                                    $('#jsbadge2'+idSolicitud+'-3').empty();
                                    $('#jsbadge2'+idSolicitud+'-3').append(ano+"-"+mes+"-"+dia);
                                  }
                              }else if (opcionSeleccionada == 3) {//No Asiste
                                  if (tipoExamen == 1) {//masso
                                    alertify.error('Maso Rechazada');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-1').empty();
                                    $('#jsbadge'+idSolicitud+'-1').append(' <span class="badge jsbadge'+idSolicitud+'-1" style="background-color:#886A08">NA</span>');
                                  }else if (tipoExamen == 2) {//Preocupacional
                                    alertify.error('Examen Preocupacional Rechazado');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-2').empty();
                                    $('#jsbadge'+idSolicitud+'-2').append(' <span class="badge jsbadge'+idSolicitud+'-2" style="background-color:#886A08">NA</span>');
                                  }else if (tipoExamen == 3) {//Psicologico
                                    alertify.error('Examen Psicologico Rechazado');
                                    $("#closeModal").click();
                                    $('#jsbadge'+idSolicitud+'-3').empty();
                                    $('#jsbadge'+idSolicitud+'-3').append(' <span class="badge jsbadge'+idSolicitud+'-3" style="background-color:#886A08">NA</span>');
                                    $('#jsbadge2'+idSolicitud+'-3').empty();
                                    $('#jsbadge2'+idSolicitud+'-3').append(ano+"-"+mes+"-"+dia);
                                  }
                              }           
                          }else{
                            alertify.error('un error a ocurrido intente actualizar la pagina');
                          }
                        }
                    });
      event.preventDefault();
      });
});

     /* function remove(value){
        if (value == 0) {
          alertify.warning('En Proceso');
        }else if(value == 1){
          alertify.success('Aprobado');
        }else if(value == 2){
          alertify.error('Rechazado');
        }else if(value == 3){
          alertify.error('No Asiste');
        }
    }*/
</script>