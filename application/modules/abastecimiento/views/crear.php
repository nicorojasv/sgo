<div class="panel panel-white">
	<div class="panel-heading">
		<h4 class="panel-title"></h4>
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
						<a class="panel-refresh" href="#">
							<i class="fa fa-refresh"></i> <span>Refresh</span>
						</a>
					</li>
					<li>
						<a class="panel-config" href="#panel-config" data-toggle="modal">
							<i class="fa fa-wrench"></i> <span>Configurations</span>
						</a>
					</li>
					<li>
						<a class="panel-expand" href="#">
							<i class="fa fa-expand"></i> <span>Fullscreen</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<form action="<?php echo base_url() ?>abastecimiento/enviar" method="post" role="form">
			<div class="col-md-12">
				<div class="col-md-8">
					<table class='table table-condensed'>
						<tbody>
							<tr>
								<td style="width: 122px;">Solicitante:</td>
								<td><?php echo $usuario->nombres.' '.$usuario->paterno ?></td>
							</tr>
							<tr>
								<td style="width: 122px;">Centro de Negocio:</td>
								<td>
									<select name="centro_costo" required>
										<option value="">Seleccione...</option>
										<?php foreach($centro_costo as $cc ){ ?>
										<option value="<?php echo $cc->id_centro_costo ?>"><?php echo $cc->nombre_centro_costo ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 122px;">Sucursal:</td>
								<td>
									<select name="sucursal" required>
										<option value="">Seleccione...</option>
										<?php foreach($sucursales as $ss ){ ?>
										<option value="<?php echo $ss->id_sucursal ?>"><?php echo $ss->nombre_sucursal ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 122px;">Fecha Pedido:</td>
								<td><?php echo $fecha ?><input type="hidden" name="fecha" value="<?php echo $fecha ?>"></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-md-4">
					<table class='table table-condensed'>
						<tbody>
							<tr>
								<td>Folio:</td>
								<td><b><?php echo $folio ?></b><input type="hidden" name="folio" value="<?php echo $folio ?>"></td>
							</tr>
							<tr>
								<td>Tipo Solicitud:</td>
								<td><input type="radio" name="t_solicitud" value="NH"> NH - <input type="radio" name="t_solicitud" value="H" checked="checked"> H</td>
							</tr>
							<tr>
								<td>Régimen:</td>
								<td><input type="radio" name="regimen" value="RN" checked="checked"> Régimen Normal - <input type="radio" name="regimen" value="RPGP"> Régimen PGP</td>
							</tr>
							<tr>
								<td>Insumos:</td>
								<td><input type="radio" name="insumos" value="EPP" checked="checked"> EPP - <input type="radio" name="insumos" value="CE"> Caja de Herramientas</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-12">
				<table class='table table-condensed'>
					<thead>
						<tr>
							<th class="center">N°</th>
							<th class="center">Descripci&oacute;n</th>
							<th class="center">Cantidad</th>
							<th class="center">Talla</th>
						</tr>
					</thead>
					<tbody>
						<?php for($i=1;$i<=20;$i++){ ?>
						<tr>
							<td class="center"><?php echo $i; ?></td>
							<td><textarea style="color: black;border: #5f8295 solid 1px;" name="descripcion[]" class="form-control"></textarea></td>
							<td style="width:80px;"><input style="color: black;border: #5f8295 solid 1px;" type="number" min="1" max="1000" name="cantidad[]" class="form-control" ></td>
							<td style="width:80px;"><input style="color: black;border: #5f8295 solid 1px;" type="text" name="talla[]" class="form-control" ></td>
						</tr>
						<?php } ?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><input type="submit" class="btn btn-primary" ></td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>