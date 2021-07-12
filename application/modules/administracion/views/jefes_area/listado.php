<h5>Listado de Jefes de Area</h5>
<?php if($representante){ ?>
<table class='table'>
  <thead>
      <th>Jefe de Area</th>
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