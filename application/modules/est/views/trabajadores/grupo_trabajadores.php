<link href="<?php echo base_url() ?>extras/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>extras/js/jquery.dataTables.min.js" type="text/javascript"></script>

<div class="span11">
	<?php echo @$aviso; ?>
	<h2>Grupo de Trabajadores</h2>
	<div class='span2'>
		<a data-target="#modal_nuevo" data-toggle="modal" data-backdrop="false" href="" class="btn primary">Agregar Grupo</a>
	</div>

	<?php if(count($listado) > 0){ ?>
	<table class="data display">
		<thead>
			<th></th>
			<th>Nombre</th>
			<th>Usuarios Asignados</th>
			<th></th>
		</thead>
		<tbody>
			<?php foreach($listado as $l){ ?>
			<tr>
				<td><input type="checkbox" name="edicion" value="<?php echo $l->grupo_id ?>" class="check_edit" /></td>
				<td><?php echo $l->grupo_name ?></td>
				<td><a href='<?php echo base_url() ?>administracion/trabajadores/listado_grupo_asignados/<?php echo $l->grupo_id ?>'>listado(<?php echo $l->cantidad ?>)</a></td>
				<td><a href='<?php echo base_url() ?>administracion/trabajadores/listado_grupo?id=<?php echo $l->grupo_id ?>'> eliminar</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php //echo $paginado ?>
	<?php } else{ ?>
		<p>No existen grupos ingresados</p>
	<?php } ?>
</div>



<!-- MODAL -->
<div class="modal hide" id="modal_nuevo" role="dialog">
	<form action='' method='post' >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3 id="myModalLabel">Nuevo Grupo</h3>
    </div>
    <div class="modal-body">
        Nombre: <input type='text' name='ngrupo'> 
    </div>
  	<div class="modal-footer">
    	<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    	<button class="btn btn-primary" id="save_btn">Guardar</button>
  	</div>
  </form>
</div>