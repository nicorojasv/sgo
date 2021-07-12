<div id="modal">
  <div class="modal-header" style="text-align:center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Baterias que contiene el examen</h4>
  </div>
  <div id="modal_content">
    <?php
      if ($lista_aux != FALSE){
        foreach ($lista_aux as $row){
    ?>
    <br>
    <h4>Usuario: <?php echo "<b>".$row->nombres." ".$row->paterno." ".$row->materno."</b>"; ?></h4>
    <table class="table">
      <thead>
        <tr>
          <th class="center">/</th>
          <th class="center">Nombres de la Baterias</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; foreach ($row->baterias as $key){ $i += 1; ?>
        <tr>
          <td class="center"><?php echo $i ?></td>
          <td class="center"><?php echo $key->nombre ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <br><br>
    <table class="table">
      <thead>
        <tr>
          <th class="center">Cargos Aptos</th>
        </tr>
      </thead>
      <tbody>
        <?php $a = 0; foreach ($row->cargos_aptos as $key2){ $a += 1; ?>
        <tr>
          <td class="center"><?php echo $a ?></td>
          <td class="center"><?php echo $key2->nombre_cargo ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php
        }
      }else{
    ?>
      <p style="color:#088A08; font-weight: bold;">NO EXISTEN REGISTROS EN NUESTRA BASE DE DATOS</p>
    <?php
      }
    ?>
    <div class="modal-footer">
      <button type="button" name="cancelar" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
  </div>
</div>