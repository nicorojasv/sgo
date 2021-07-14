
<div id="modal">
  <form action="<?php echo base_url() ?>carrera/requerimientos/subir_anexo/<?php echo $datosAnexo->id ?>/<?php echo  $datosAnexo->id_requerimiento_area_cargo ?>" role="form" id="form2" method='post' name="f2" enctype="multipart/form-data">
  <input type='hidden' name="datos_extras" id="datos_extras" value="SI"/> 
  <input type="hidden" name="fechaHoy" id="fechaHoy" value="<?php echo date('Y-m-d') ?>">
          <div class="clearfix"></div>
                <div class="control-form col-md-2"></div> 
          <div class="clearfix"></div>
          <div class="control-form col-md-2"></div>
          <div class="control-form col-md-10">
            <?php
                   // $wenats =  $diaqlo->format('Y-m-d');
                $diaqlo2 =explode('-', $datosAnexo->fecha_termino_nuevo_anexo);
                $dia = $diaqlo2[2];
                $mes = $diaqlo2[1];
                $ano = $diaqlo2[0];

                switch($mes){
                   case 1: $mesTermino="Enero"; break;
                   case 2: $mesTermino="Febrero"; break;
                   case 3: $mesTermino="Marzo"; break;
                   case 4: $mesTermino="Abril"; break;
                   case 5: $mesTermino="Mayo"; break;
                   case 6: $mesTermino="Junio"; break;
                   case 7: $mesTermino="Julio"; break;
                   case 8: $mesTermino="Agosto"; break;
                   case 9: $mesTermino="Septiembre"; break;
                   case 10: $mesTermino="Octubre"; break;
                   case 11: $mesTermino="Noviembre"; break;
                   case 12: $mesTermino="Diciembre"; break;
                }
                $fechaTermino = $dia." de ".$mesTermino." de ".$ano;
            ?>
            <label><?php echo $datosAnexo->nombres?></label><br>
            <label>Fecha de termino Anexo: <?php echo $fechaTermino?></label><br>

            <input type="file" name="documento" id="documento" class="form-control">
          </div>
            <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" name="actualizar" id="agregarContrato" class="btn btn-primary" >Subir</button>
      </div>
    </form>
</div>
