
<div class="panel panel-white">
  <div class="panel-body">
      <div class="row">
         <form  method="post">
          <div class="row">
              <div class="col-md-2"></div>
              <div class="col-md-7"></div>

              <div class="col-md-3" align="center">
                <button id="myButtonControlID" class="btn btn-green">Exportar a Excel</button>
              </div>
       </div>
    <div id="content" align="center"></div>
          <div class="col-md-12" align="center">
            <table id="example1">
              <thead>
                 <th style="text-align:center; width:6%"><input type="checkbox" onchange="togglecheckboxes(this,'solicitudes[]')" style="width:12px;"/><br>Todos</th>
                <th style="text-align:center">Nombre Trabajador</th>
                <th style="text-align:center">Rut</th>
                <th style="text-align:center">F. Inicio Contrato</th>
                <th style="text-align:center">F. termino</th>
                <th style="text-align:center; color: blue">F. Termino Anexo</th>
                <th style="text-align:center">Causal</th>
                <th style="text-align:center">Centro Costo</th>
                <th style="text-align:center">Opcion</th>
              </thead>
              <tbody>
                <?php 
                $i=1; foreach($trabajadores as $rm){ 
                 ?>
                <tr id="<?php echo $rm->idAnexo.'tr'; ?>">
                   <td><input type="checkbox" name="solicitudes[]" value="<?php echo $rm->idAnexo ?>"></td>
                    <td><?php echo $rm->nombreTrabajador; ?></td>
                    <td><?php echo $rm->rutTrabajador ?></td>
                    <td><?php echo $rm->fechaInicioContrato ?></td>
                    <td><?php echo $rm->fechaTerminoContratoAnterior ?></td>
                    <td><?php echo $rm->fechaTerminoAnexo ?></td>
                    <td><?php echo $rm->causalTrabajador ?></td>
                    <td><?php echo $rm->centroTrabajador ?></td>
                    <td align="center">
                        <a href="<?php echo base_url()?>carrera/contratos/descargar_anexo/<?php echo $rm->idAnexo; ?>" title="Descargar"><i style="color: blue;" class="fa fa-download" aria-hidden="true"></i></a>
                    </td>
                  </tr>
                  <?php  $i++; } ?>
                </tbody>
            </table>
          </div>
        </form>
      </div>
  </div>
</div>
<!------Exportacion----------->
  <div id="divTableDataHolder" style="display:none">
    <meta charset="UTF-8">
    <table>
        <thead>
          <th style="text-align:center">Nombre Trabajador</th>
          <th style="text-align:center">Rut</th>
          <th style="text-align:center">Nacionalidad</th>
          <th style="text-align:center">F. Nacimiento</th>
          <th style="text-align:center">E. Civil</th>
          <th style="text-align:center">Domicilio</th>
          <th style="text-align:center">Comuna</th>
          <th style="text-align:center">AFP</th>
          <th style="text-align:center">Salud</th>
          <th style="text-align:center">F. Inicio Contrato</th>
          <th style="text-align:center">F. Termino Anexo</th>
          <th style="text-align:center">Causal</th>
          <th style="text-align:center">telefono</th>
          <th style="text-align:center">Centro Costo</th>
          <th style="text-align:center">Nombre Planta</th>
        </thead>
        <tbody>
          <?php 
          $i=1; foreach($trabajadores as $rm){ 
           ?>
          <tr>
              <td><?php echo $rm->nombreTrabajador; ?></td>
              <td><?php echo $rm->rutTrabajador ?></td>
              <td><?php echo $rm->nacionalidadTrabajador ?></td>
              <td><?php echo $rm->nacimientoTrabajador ?></td>
              <td><?php echo $rm->civilTrabajador ?></td>
              <td><?php echo $rm->direccionTrabajador ?></td>
              <td><?php echo $rm->ciudadTrabajador?></td>
              <td><?php echo $rm->afpTrabajador ?></td>
              <td><?php echo $rm->saludTrabajador ?></td>
              <td><?php echo $rm->fechaInicioContrato ?></td>
              <td><?php echo $rm->fechaTerminoAnexo ?></td>
              <td><?php  echo $rm->causalTrabajador ?></td>
              <td><?php echo $rm->telefonoTrabajador ?></td>
              <td><?php echo $rm->centroTrabajador ?></td>
              <td><?php echo $rm->nombre_planta  ?></td>
            </tr>
            <?php  $i++; } ?>
          </tbody>

    </table>
  </div>
