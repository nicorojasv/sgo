<style type="text/css">
  input[type=number] {
   width: 70px;
   background-color: #E9E9E9;

}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

input[type=number] { -moz-appearance:textfield; }
</style>
<div class="panel panel-white"> 

       <form action="<?php echo base_url() ?>carrera/asistencia/guardar_asistencia" method="post" role="form" enctype="multipart/form-data"><br>
       <label for="datepickerAsistencia">Mes A trabajar: </label>
       <input name="datepicker" type="text" id="datepickerAsistencia" style="border: 1px solid #ccc;" class="datepicker" value="<?php echo $fecha_mostrar ?>" size="10" readonly="true" title="Fecha a Gestionar Asistencia"/>
        <table id="exampleAsistencia" class="table">
            <thead style="background-color: #F2F2F2;">
                <tr>
       
                      
                      <th rowspan="2" style="text-align:center;">Rut</th>
                      <th rowspan="2" style="text-align:center">Apellidos</th>
                      <th rowspan="2" style="text-align:center">Nombres</th>
                  <?php for ($i=1; $i <= 31; $i++) { ?>
                      <th colspan="2" style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Dia <?php echo $i?></th>
                  <?php } ?>
                </tr>
                <tr style="text-align:center">
                  <?php for ($i=1; $i <= 31; $i++) {  ?>
                      <th style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Asiste</th>
                      <th style="text-align:center; color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">hh</th>
                  <?php } ?>
                </tr>       
            </thead>
            <tbody>  
            <?php 
                $j=1;
              foreach ($listado as $key) {
            ?>  
                <tr>
                        <td style="background: #ccc"><?php echo $key->id_usuario?></td>
                        <!--<td style="background: #ccc;"><?php echo $key->rut_usuario ?></td>-->
                        <td style="background: #ccc"><?php echo $key->paterno.' '.$key->materno; ?></td>
                        <td style="background: #ccc"><?php echo $key->nombres ?></td>
                        <input type="hidden" name="persona[<?php echo $j ?>]" value="<?php echo  $key->id_usuario?>">  
                  <?php 
                      for ($i=1; $i <= 31; $i++) { 
                        if (isset($key->asistencia[$i])) {
                              $correcto = true;
                        }else{
                           if (isset($key->asistencia[$i-1])) {
                              $correcto = true;
                           }else{
                              $correcto = false;
                           }
                        }

                  ?>
                        <td><input type="checkbox" name="asiste[<?php echo $j ?>][<?php echo $i ?>]" <?php if($correcto == true)echo "checked";?>></td>
                        <td ><input size="1" type="number" min="0" max="12" name="horaExtra[<?php echo $i ?>]"></td>
                  <?php 
                    } 
                  ?>      
                  </tr>
            <?php
            $j++;
               }
            ?>    
                        
           
            </tbody>
          </table>
          <div class="btn-col" id="blw">
                                    <input type="submit" id="aceptar" value="Guardar" > 
          </div>
          </form>
          </div>