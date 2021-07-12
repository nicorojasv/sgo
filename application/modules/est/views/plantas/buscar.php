<div class="panel panel-white">
  <div class="panel-heading">
    <h4 class="panel-title">Plantas ingresadas</h4>
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
    <a href="<?php echo base_url().'est/plantas/agregar' ?>" class="btn btn-primary">Agregar</a>
	<?php if(count($listado) > 0){ ?>
	<table class="table">
		<thead>
			<th></th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Email</th>
			<th>Dirección</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><?php echo $l->id ?></td>
				<td><?php echo ucwords( mb_strtolower( $l->nombre, 'UTF-8' ) ) ?></td>
				<td><?php echo $l->fono ?></td>
				<td><?php echo $l->email ?></td>
				<td><?php echo ucwords( mb_strtolower( $l->direccion, 'UTF-8' ) ) ?></td>
				<td class="center">
		            <div class="visible-md visible-lg hidden-sm hidden-xs">
		              	<a href="#" class="btn btn-xs btn-blue tooltips editar" data-placement="top" data-original-title="Editar"><i class="fa fa-edit"></i></a>
		             	<?php if($this->session->userdata('tipo_usuario') == 1){ ?>
			              	<a href="<?php echo base_url() ?>est/plantas/eliminar/<?php echo $l->id ?>" class="btn btn-xs btn-red tooltips eliminar" data-placement="top" data-original-title="Eliminar"><i class="fa fa-times fa fa-white"></i></a>
						<?php } ?>
		           	</div>
		        </td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

<?php echo @$paginado ?>
<?php } else{ ?>
	<p>No existen trabajadores agregados o asociados a la busqueda</p>
<?php } ?>
</div>
</div>