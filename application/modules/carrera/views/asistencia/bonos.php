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
}

input[type=number] { -moz-appearance:textfield; }
</style>
<div class="panel panel-white"> 
<div class="row">
<br>
  <div class="col-md-8">
           <label for="datepickerBono">Mes A trabajar: </label>
       <input name="datepicker" type="text" id="datepickerBono" style="border: 1px solid #ccc;" class="datepicker" value="<?php echo $fecha_mostrar ?>" size="10" readonly="true" title="Fecha a Gestionar Asistencia">
  </div>
  <div class="col-md-2">
     <a href="<?php echo base_url() ?>carrera/asistencia/listado_activo_personal/2" class="btn btn-col btn-primary">Listado de Personal</a>
  </div>
    <div class="col-md-2" align="center">
          <form action="<?php echo base_url() ?>carrera/asistencia/exportar_excel_bono_anticipo" method="post" target="_blank" id="FormularioExportacionBono">
            <input title="EXPORTAR DATOS A ARCHIVO EXCEL" type="submit" class="botonExcelEnjoyBono btn btn-info btn-block" value="Exportar"><br>
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
       <form action="<?php echo base_url() ?>carrera/asistencia/guardar_bono" method="post" role="form" enctype="multipart/form-data"><br>

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
                      <th style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Bono</th>
                      <th style="text-align:center; color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Anticipo</th>
                  <?php } ?>
                </tr>       
            </thead>
            <tbody>  
            <?php 
                $j=1;
              foreach ($listado as $key) {
            ?>  
                <tr>
                        <td style="background: #ccc"><?php echo $key->rut_usuario?></td>
                        <!--<td style="background: #ccc;"><?php echo $key->rut_usuario ?></td>-->
                        <td style="background: #ccc"><?php echo $key->paterno.' '.$key->materno; ?></td>
                        <td style="background: #ccc"><?php echo $key->nombres ?></td>
                        <input type="hidden" name="persona[<?php echo $j ?>]" value="<?php echo  $key->id_usuario?>">  
                  <?php 
                      for ($i=1; $i <= 31; $i++) { 
                        if (isset($key->bono[$i])) {
                              $bono = $key->bono[$i];
                        }else{
                          $bono ='';
                        }

                        if (isset($key->anticipo[$i])) {
                              $anticipo = $key->anticipo[$i];
                        }else{
                          $anticipo ='';
                        }
                  ?>
                        <td>
                            <input size="1" type="number" onkeypress="if(this.value.length>=6) { return false;}" oninput="if(this.value.length>=6) { this.value = this.value.slice(0,6); }" name="bono[<?php echo $j ?>][<?php echo $i ?>]" value="<?php echo $bono; ?>">
                        </td>
                        <td >
                            <input onkeypress="if(this.value.length>=6) { return false;}" oninput="if(this.value.length>=6) { this.value = this.value.slice(0,6); }" size="1" type="number"  name="anticipo[<?php echo $j ?>][<?php echo $i ?>]" value="<?php echo $anticipo; ?>">
                        </td>
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
          <input type="hidden" name="mesParaGuardarAsistencia" value="<?php echo $fecha_guardar ?>">
          <div class="btn-col" id="blw">
                <input type="submit" class="btn btn-success btn-block" id="aceptar" value="Guardar" > 
          </div>
          </form>
      </div>
<div id="divTableDataHolder" style="display:none">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1 "  charset="utf-8">

 <table id="Exportar_Excel_Bono" style="border-collapse:collapse;">
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
                      <th style="text-align:center;color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Bono</th>
                      <th style="text-align:center; color:<?php if ($i%2==0){echo '#0C970D';}else{ echo '#0174DF'; } ?>">Anticipo</th>
                  <?php } ?>
                </tr>       
            </thead>
            <tbody>  
            <?php 
                $j=1;
              foreach ($listado as $key) {
            ?>  
                <tr>
                        <td style="background: #ccc"><?php echo $key->rut_usuario?></td>
                        <!--<td style="background: #ccc;"><?php echo $key->rut_usuario ?></td>-->
                        <td style="background: #ccc"><?php echo titleCase($key->paterno.' '.$key->materno); ?></td>
                        <td style="background: #ccc"><?php echo $key->nombres ?></td>
                  <?php 
                      for ($i=1; $i <= 31; $i++) { 
                        if (isset($key->bono[$i])) {
                              $bono = $key->bono[$i];
                        }else{
                          $bono ='';
                        }

                        if (isset($key->anticipo[$i])) {
                              $anticipo = $key->anticipo[$i];
                        }else{
                          $anticipo ='';
                        }
                  ?>
                        <td>
                            <?php echo $bono; ?>
                        </td>
                        <td >
                            <?php echo $anticipo; ?>
                        </td>
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