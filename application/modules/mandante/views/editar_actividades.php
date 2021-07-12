<!DOCTYPE html>
<html>
	<head>
		<link href="<?php echo base_url() ?>extras/css/reseter_v2.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/base.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="modal2">
			<div class="closeClass"></div>
			<div id="modal_header">
				<h3>Editar <?php echo $titulo ?></h3>
			</div>
			<div id="modal_content">
				<div style="width: 370px;">
					<p>
						Acontinuación favor edite nombre <?php echo $subtitulo; ?>.
					</p>
					<form action="<?php echo base_url() ?>mandante/<?php echo $url_form ?>" method="post" class="form">
						<div class="field">
							<label for="email">Nombre</label>
							<div class="fields">
								<input type="text" name="nuevo" value="<?php echo $nombre; ?>" id="area" size="30" tabindex="1">
								<input type="hidden" name="id" value="<?php echo $id; ?>" >
							</div>
						</div>
						<div class="actions">
							<button type="submit" class="btn primary" tabindex="1">
								Editar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>