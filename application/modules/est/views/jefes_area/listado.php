<div class="panel panel-white">
  <div class="panel-heading">
    <h4 class="panel-title">Listado de Jefes de Area</h4>
    <div class="panel-tools">                   
      <div class="dropdown">
      <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
        <i class="fa fa-cog"></i>
      </a>
      <ul class="dropdown-menu dropdown-light pull-right" role="menu">
        <li>
          <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
        </li>
        <li>
          <a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a>
        </li>
        <li>
          <a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span></a>
        </li>
        <li>
          <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span></a>
        </li>                   
      </ul>
      </div>
      <a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
    </div>
  </div>
  <div class="panel-body">
    <a href="<?php echo base_url().'est/jefes_area/agregar' ?>" class="btn btn-primary">Agregar</a>
    <?php if($representante){ ?>
    <table class='table'>
      <thead>
          <th>Nombres</th>
          <th></th>
      </thead>
      <tbody>
        <?php foreach($representante as $r){ ?>
        <tr>
          <td><?php echo $r->nombre; ?></td>
          <td class="center">
            <div class="visible-md visible-lg hidden-sm hidden-xs">
              <a href="#" class="btn btn-xs btn-blue tooltips editar" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a>
              <a href="<?php echo base_url() ?>est/jefes_area/eliminar/<?php echo $r->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } else{ ?>
    <p>No existen representantes agregados</p>
    <?php } ?>
  </div>
</div>