<!DOCTYPE html>
<!-- Template Name: Rapido - Responsive Admin Template build with Twitter Bootstrap 3.x Version: 1.2 Author: ClipTheme -->
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	<head>
		<title>Integra EST - V2.0</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/animate.css/animate.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/skins/all.css">
		<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login">
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo">
					<img src="<?php echo base_url() ?>extras/layout2.0/assets/images/logo2.png">
				</div>
				<!-- start: LOGIN BOX -->
				<div class="box-login">
					<h3>Descarga de Liquidación</h3>
					<p>
						Ingrese su rut en el formulario.
					</p>
					<form class="form-login" action="#" method='POST'>
						<div class="errorHandler alert alert-danger no-display">
							<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
						</div>
						<fieldset>
							<div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="rut" placeholder="RUT">
									<i class="fa fa-user"></i> </span>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-green pull-right">
									Descargar <i class="fa fa-download"></i>
								</button>
							</div>
						</fieldset>
					</form>
					<!-- start: COPYRIGHT -->
					<div class="copyright">
						2015 &copy; Empresas Integra Ltda.
					</div>
					<!-- end: COPYRIGHT -->
				</div>
				<!-- end: LOGIN BOX -->
			</div>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/respond.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jQuery/jquery-1.11.1.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
		<!--<![endif]-->
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery.transit/jquery.transit.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/main.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/login.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	</body>
	<!-- end: BODY -->
</html>