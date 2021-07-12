<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<META name="robots" content="NOINDEX,NOFOLLOW,NOARCHIVE,NOODP,NOSNIPPET">
		<link href="<?php echo base_url() ?>extras/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() ?>extras/css/editor.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() ?>extras/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/bootstrap-modal.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jhtml/jHtmlArea-0.7.0.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/jhtml/jHtmlArea.ColorPickerMenu-0.7.0.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>extras/js/editor-texto.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="cabecera navbar navbar-fixed-top">
				<div id="menu-prin">
					<div id='cont-menu-prin'>
						<div title="Guardar Pagina" class="botones-principales">
							<a id="menu-guardar" data-toggle="modal" href="#opGuardar"><em class="guardar">Guardar</em></a>
						</div>
						<div title="Previsualizar Pagina" class="botones-principales">
							<em class="revisar">Revisar</em>
						</div>
						<hr class="separador">
						<div title="Deshacer" class="botones-principales">
							<em class="deshacer">Deshacer</em>
						</div>
						<div title="Rehacer" class="botones-principales">
							<em class="rehacer">Rehacer</em>
						</div>
						<hr class="separador">
						<div title="Link" class="botones-principales">
							<a href="#" id="menu-link" ><em class="link">Link</em></a>
						</div>
						<div title="Media" class="botones-principales">
							<em class="media">Media</em>
						</div>
						<div title="Tabla" class="botones-principales">
							<em class="table">Tabla</em>
						</div>
						<div title="Carácter" class="botones-principales">
							<em class="caracter">Carácter</em>
						</div>
						<hr class="separador">
						<div title="Pegar" class="botones-principales">
							<a href="#" id="menu-pegar"><em class="pegar">Pegar</em></a>
						</div>
					</div>
				</div>
				<div id="menu-secun">
					<div id="cont-menu-secun">
						<div class="menu-secun-group">
							<div title="Estilo" class="botones-secundarios">
								<em class="estilo">Estilo</em>
							</div>
							<hr class="separador2">
							<div title="Formato" class="botones-secundarios">
								<em class="formato">Formato</em>
							</div>
							<hr class="linea-separador">
						</div>
						<div class="menu-secun-group">
							<div title="Negrita" class="botones-secundarios bold-button">
								<a href="#" id="menu-negrita" >&nbsp;<em class="hide-em">Negrita</em></a>
							</div>
							<div title="Italica" class="botones-secundarios italic-button">
								<a href="#" id="menu-italica" >&nbsp;<em class="hide-em">Italica</em></a>
							</div>
							<div title="OverLine" class="botones-secundarios over-button">
								<a href="#" id="menu-overline" >&nbsp;<em class="hide-em">OverLine</em></a>
							</div>
							<div title="Tachado" class="botones-secundarios tachado-button">
								<a href="#" id="menu-tachado" >&nbsp;<em class="hide-em">Tachado</em></a>
							</div>
							<div title="UnderLine" class="botones-secundarios under-button">
								<a href="#" id="menu-under" >&nbsp;<em class="hide-em">Subrrayado</em></a>
							</div>
							<hr class="linea-separador">
						</div>
						<div class="menu-secun-group">
							<div title="Subindice" class="botones-secundarios sub-button">
								<a href="#" id="menu-sub" >&nbsp;<em class="hide-em">sub</em></a>
							</div>
							<div title="Superindice" class="botones-secundarios super-button">
								<a href="#" id="menu-super" >&nbsp;<em class="hide-em">super</em></a>
							</div>
							<hr class="linea-separador">
						</div>
						<div class="menu-secun-group">
							<div title="Alinear Izquierda" class="botones-secundarios left-button">
								<a href="#" id="menu-left" >&nbsp;<em class="hide-em">Izquierda</em></a>
							</div>
							<div title="Alinear centro" class="botones-secundarios center-button">
								<a href="#" id="menu-center" >&nbsp;<em class="hide-em">Centrado</em></a>
							</div>
							<div title="Alinear derecha" class="botones-secundarios right-button">
								<a href="#" id="menu-right" >&nbsp;<em class="hide-em">Derecha</em></a>
							</div>
							<hr class="linea-separador">
						</div>
						<div class="menu-secun-group">
							<div title="Alinear Izquierda" class="botones-secundarios listNo-button">
								<a href="#" id="menu-listNo" >&nbsp;<em class="hide-em">lista</em></a>
							</div>
							<div title="Alinear centro" class="botones-secundarios listNu-button">
								<a href="#" id="menu-listNu" >&nbsp;<em class="hide-em">lista</em></a>
							</div>
							<hr class="linea-separador">
						</div>
						<div class="menu-secun-group">
							<div title="Margen Derecho" class="botones-secundarios margenDer-button">
								<a href="#" id="menu-margenDer">&nbsp;<em class="hide-em">margen</em></a>
							</div>
							<div title="Margen Izquierdo" class="botones-secundarios margenIzq-button">
								<a href="#" id="menu-margenIzq">&nbsp;<em class="hide-em">margen</em></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="container-fluid cuerpo">
			<p style="height: 60px;"></p>
			<textarea class="hoja-carta"></textarea>
			<!-- <div class="aux"></div>
			<textarea class="hoja-carta"></textarea> -->
		</div>
		<div class="modal hide" id="opGuardar">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Guardar Contrato</h3>
			</div>
				<div class="modal-body">
					<form>
						<label>Nombre de Contrato</label>
					    	<input type="text" class="span3">
					    	<span class="help-block">Escriba el nombre del contrato que va a guardar.</span>
					    <button type="submit" class="btn">Guardar Cambios</button>
				    </form>
			 	</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">Cerrar</a>
		  		</div>
		</div>
	</body>
</html>