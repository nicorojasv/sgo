<form class="form-horizontal" method='post' action="<?php echo base_url() ?>administracion/requerimiento/jefe_area_guardar">
  <div class="control-group">
    <label class="control-label" for="inputPassword">Jefe de Area</label>
    <div class="controls">
      <input type="text" name="jefe_area" placeholder="Nombre">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn">Agregar</button>
    </div>
  </div>
</form>
<h5>Listado de Representantes</h5>
<?php if($representante){ ?>
<table>
  <thead>
    <th>Representante</th>
  </thead>
  <tbody>
    <?php foreach($representante as $r){ ?>
    <tr>
      <td><?php echo $r->nombre; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php } else{ ?>
<p>No existen representantes agregados</p>
<?php } ?>