<div class="span2"></div>
<?php @$aviso ?>
<div class="span11">
	<h2>Trabajos anteriores</h2>
	<?php if(count($listado_trabajos) > 0){ ?>
	<table class="data display">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Fecha inicio</th>
				<th>Fecha termino</th>
				<th>Empresa</th>
				<th>Area</th>
				<th>Cargo</th>
				<th>Lugar de trabajo</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($listado_trabajos as $l){ ?>
			<tr class="odd gradeX">
				<?php $f1 = explode('-', $l->f_inicio) ?>
				<?php $f2 = explode('-', $l->f_termino) ?>
				<td><a href="" title="Ir a publicaciones de este requerimiento"><?php echo ucwords(mb_strtolower($l->nombre, 'UTF-8')) ?></a></td>
				<td><?php echo $f1[2].'-'.$f1[1].'-'.$f1[0] ?></td>
				<td><?php echo $f2[2].'-'.$f2[1].'-'.$f2[0] ?></td>
				<td><?php echo ucwords(mb_strtolower($l->empresa, 'UTF-8')) ?></td>
				<td><?php echo ucwords(mb_strtolower($l->area, 'UTF-8')) ?></td>
				<td><?php echo ucwords(mb_strtolower($l->cargo, 'UTF-8')) ?></td>
				<td><?php echo ucwords(mb_strtolower($l->lugar, 'UTF-8')) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
		<p>No existen trabajos anteriores</p>
	<?php } ?>
</div>