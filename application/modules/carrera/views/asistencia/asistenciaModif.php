<style type="text/css">
  input[type=number] {
   width: 70px;
      background-color: white;
   border: 1px dotted #999;

}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
   border: 1px dotted #999;

}

input[type=number] { -moz-appearance:textfield; }
</style>
<div class="panel panel-white"> 
<div class="row">


<br>
  <div class="col-md-8">
           <label for="datepickerBono">Mes A trabajar: </label>
       <input name="datepicker" type="text" id="datepickerAsistencia" style="border: 1px solid #ccc;" class="datepicker" value="<?php echo $fecha_mostrar ?>" size="10" readonly="true" title="Fecha a Gestionar Asistencia">
  </div>
  <div class="col-md-2">
     <a href="<?php echo base_url() ?>carrera/asistencia/listado_activo_personal" class="btn btn-col btn-primary">Listado de Personal</a>
  </div>
    <div class="col-md-2" align="center">
          <form action="<?php echo base_url() ?>carrera/asistencia/exportar_excel_bono_anticipo" method="post" target="_blank" id="FormularioExportacionAsistencia">
            <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="submit" class="botonExcelEnjoyAsistencia btn btn-info btn-block" value="Exportar"><br>
            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
          </form>
          <!--<input title="EXPORTAR DATOS A ARCHIVO EXCEL" id="myButtonControlID" type="button" class="btn btn-primary btn-block" value="Exportar a Excel">--><br>
    </div>

  <br>
  </div>
  <?php 
  if ($this->session->userdata('exito')==1) {
  ?>
    <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Guardado!</strong> Asistencia Guardada exitosamente.
  </div>
  <?php 
  $this->session->unset_userdata('exito');
}
  ?>
       <form action="<?php echo base_url() ?>carrera/asistencia/guardar_asistencia" method="post" role="form" enctype="multipart/form-data"><br>

        <table id="exampleAsistencia" class="table">
            <thead style="background-color: #F2F2F2;">
                <tr>
                      <th rowspan="2" style="text-align:center;">Rut</th>
                      <th rowspan="2" style="text-align:center">Apellidos</th>
                      <th rowspan="2" style="text-align:center">Nombres</th>
                    <?php 
                      $f = explode('-', $fecha_guardar);//fecha traida desde el controlador
                      $mes = $f[1];
                            $mesActual = date('m');
                            $diaActual = 4;
                if ($mesActual == $mes) {
                    for ($i=1; $i <= $diaActual; $i++) { ?>
                        <th colspan="2" style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Dia <?php echo $i?></th>
                    <?php }

                }else{
                      for ($i=1; $i <= 31; $i++) { ?>
                        <th colspan="2" style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Dia <?php echo $i?></th>
                <?php 
                      }

                    }
                ?>
                </tr>
                <tr style="text-align:center">
                  <?php 
                  if ($mesActual == $mes) {
                      for ($i=1; $i <= $diaActual; $i++) {  ?>
                      <th style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Asiste</th>
                      <th style="text-align:center; color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">he</th>
                  <?php 
                        }
                  }else{ 
                    for ($i=1; $i <= 31; $i++) {  ?>
                      <th style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Asiste</th>
                      <th style="text-align:center; color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">he</th>
                                                 
                  <?php 
                      }
                    }
                  ?>
                </tr>       
            </thead>
            <tbody>  
            <?php 
                $j=1;
              foreach ($listado as $key) {
            ?>  
                <tr>
                      <!--  <td style="background: #ccc"><?php echo $key->id_usuario?></td>-->
                        <td style="background: #ccc;"><?php echo $key->rut_usuario ?></td>
                        <td style="background: #ccc"><?php echo $key->paterno.' '.$key->materno; ?></td>
                        <td style="background: #ccc"><?php echo $key->nombres ?></td>
                        <input type="hidden" name="persona[<?php echo $j ?>]" value="<?php echo  $key->id_usuario?>">  
                  <?php 
                    if ($mesActual == $mes) {
                      for ($i=1; $i <= $diaActual; $i++) { 
                        if (isset($key->asistencia[$i])) {
                              $correcto = $key->asistencia[$i];
                        }else{
                          $correcto =0;
                        }

                        if (isset($key->horaExtra[$i])) {
                              $horaExtra = $key->horaExtra[$i];
                        }else{
                          $horaExtra ='';
                        }
                  ?>
                        <td>
                          <?php 
                            if ($correcto ==1) {
                              $color = "#b9e1b9";//verde
                            }else if($correcto ==2){
                              $color = "#c4b8f3";//azul
                            }else if($correcto ==3){
                              $color = "#f9efbc";
                            }else if($correcto ==4){
                              $color = "#ebbaaf";
                            }else if($correcto ==5){
                              $color = "#56766630";
                            }
                          ?>
                          <select name="asiste[<?php echo $j ?>][<?php echo $i ?>]" style="background: <?php echo isset($color)?$color:''; ?>" >
                            <option value="1" <?php if($correcto==1)echo 'selected'; ?> >Presente</option>
                            <option value="2" <?php if($correcto==2)echo 'selected'; ?> >Permiso</option>
                            <option value="3" <?php if($correcto==3)echo 'selected'; ?> >Licencia</option>
                            <option value="4" <?php if($correcto==4)echo 'selected'; ?> >Falta</option>
                            <option value="5" <?php if($correcto==5)echo 'selected'; ?> >Descanso</option>
                          </select>
                        </td>
                        <td ><input size="1" type="number" min="0" max="12" name="horaExtra[<?php echo $j ?>][<?php echo $i ?>]" value="<?php echo $horaExtra; ?>"></td>
                  <?php 
                    } 
                  ?>      
                  </tr>
            <?php
            $j++;
               }else{//finmesactual
            ?> 
                  <?php 
                      for ($i=1; $i <= 31; $i++) { 
                        if (isset($key->asistencia[$i])) {
                              $correcto = $key->asistencia[$i];
                        }else{
                          $correcto =0;
                        }

                        if (isset($key->horaExtra[$i])) {
                              $horaExtra = $key->horaExtra[$i];
                        }else{
                          $horaExtra ='';
                        }
                  ?>
                        <td>
                          <?php 
                            if ($correcto ==1) {
                              $color = "#b9e1b9";//verde
                            }else if($correcto ==2){
                              $color = "#c4b8f3";//azul
                            }else if($correcto ==3){
                              $color = "#f9efbc";
                            }else if($correcto ==4){
                              $color = "#ebbaaf";
                            }else if($correcto ==5){
                              $color = "#56766630";
                            }
                          ?>
                          <select name="asiste[<?php echo $j ?>][<?php echo $i ?>]" style="background: <?php echo isset($color)?$color:''; ?>" >
                            <option value="1" <?php if($correcto==1)echo 'selected'; ?> >Presente</option>
                            <option value="2" <?php if($correcto==2)echo 'selected'; ?> >Permiso</option>
                            <option value="3" <?php if($correcto==3)echo 'selected'; ?> >Licencia</option>
                            <option value="4" <?php if($correcto==4)echo 'selected'; ?> >Falta</option>
                            <option value="5" <?php if($correcto==5)echo 'selected'; ?> >Descanso</option>
                          </select>
                        </td>
                        <td ><input size="1" type="number" min="0" max="12" name="horaExtra[<?php echo $j ?>][<?php echo $i ?>]" value="<?php echo $horaExtra; ?>"></td>
                  <?php 
                    } 
                  }
                  ?>  

                  </tr>
            <?php
            $j++;
               }
            ?>    
                        
           
            </tbody>
          </table>
          <input type="hidden" name="mesParaGuardarAsistencia" value="<?php echo $fecha_guardar ?>">
          <?php 
     
              if (date('m')>$mes){
            ?>


          <div class="btn-col" id="blw" style="border: 1px dotted #999; ">
             <input  disabled  class="btn btn-default btn-block"  id="aceptar" value="Guardar" > 

          

          </div>

            <?php
              }else{
            ?>
          <div class="btn-col" id="blw" >
           <input type="submit" class="btn btn-success btn-block" id="aceptar" value="Guardar" > 

          

          </div>


            <?php 
            }
            ?>
          </form>
          </div>



<div id="divTableDataHolder" style="display:none">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1 "  charset="utf-8">
        <table id="Exportar_Excel_Asistencia" class="table">
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
                      <th style="text-align:center; color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">horas extras</th>
                  <?php } ?>
                </tr>       
            </thead>
            <tbody>  
            <?php 
                $j=1;
              foreach ($listado as $key) {

            ?>  
                <tr>
                      <!--  <td style="background: #ccc"><?php echo $key->id_usuario?></td>-->
                        <td style="background: #ccc;"><?php echo $key->rut_usuario ?></td>
                        <td style="background: #ccc"><?php echo $key->paterno.' '.$key->materno; ?></td>
                        <td style="background: #ccc"><?php echo $key->nombres ?></td>
                  <?php 
                      for ($i=1; $i <= 31; $i++) { 
                        if (isset($key->asistencia[$i])) {
                              $correcto = $key->asistencia[$i];
                        }else{
                          $correcto =0;
                        }

                        if (isset($key->horaExtra[$i])) {
                              $horaExtra = $key->horaExtra[$i];
                        }else{
                          $horaExtra ='';
                        }
                  ?>
                        <td>
                          <?php 
                            if ($correcto ==1) {
                              $color = "Presente";//verde
                            }else if($correcto ==2){
                              $color = "Permiso";//azul
                            }else if($correcto ==3){
                              $color = "Licencia";
                            }else if($correcto ==4){
                              $color = "Falta";
                            }else if($correcto ==5){
                              $color = "Descanso";
                            }
                            echo $color;
                          ?>
                          
                        </td>
                        <td ><?php echo $horaExtra; ?></td>
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
          </div>