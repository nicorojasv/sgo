<!DOCTYPE html>
<html lang="es">
	<head>
		<title><?php echo $head_titulo ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/emails/hover-min.css">
		<!--<meta http-equiv="Refresh" content="1;url=http://sgo2.integraest.cl/extras/mantencion.html">-->
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,200,100,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/animate.css/animate.min.css">
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR SUBVIEW CONTENTS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.theme.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.transitions.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/summernote/dist/summernote.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/fullcalendar/fullcalendar/fullcalendar.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/toastr/toastr.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-select/bootstrap-select.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/css/DT_bootstrap.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/plugins/x-editable/css/bootstrap-editable.css">
		<!-- end: CSS REQUIRED FOR THIS SUBVIEW CONTENTS-->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<?php 
		if (isset($css)){
			foreach( $css as $file ){ ?>
				<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/<?php echo $file; ?>">
		<?php }
		} ?>
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE CSS -->
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/styles-responsive.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/plugins.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/themes/theme-default.css" type="text/css" id="skin_color">
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/css/print.css" type="text/css" media="print"/>
		<!-- end: CORE CSS -->
		<link rel="shortcut icon" href="<?php echo base_url() ?>extras/images/favicon.ico" />
		<script type='text/javascript' src="<?php echo base_url() ?>extras/layout2.0/assets/js/Push.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>extras/layout2.0/assets/alerta/alertify.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/alerta/alertify.min.css" />
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/alerta/default.min.css"/>
		<link rel="stylesheet" href="<?php echo base_url() ?>extras/layout2.0/assets/alerta/semantic.css"/>
<?php 
	if (isset($soloParaHoraFecha)) {
?>
		<link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet"/>
		<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<?php
	}
	if (isset($soloParaMarina)) {
?>
	    <link rel="stylesheet" href="<?php echo base_url()?>extras/layout2.0/assets/js/jquery/jquery-ui.css">
	 	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php
	}
	if (isset($soloCargo)) {
?>
<link href="<?php echo base_url()?>extras/layout2.0/assets/jsjquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>extras/layout2.0/assets/js/multiselect/popper.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>extras/layout2.0/assets/js/multiselect/amsify-suggestags.css">
<script type="text/javascript" src="<?php echo base_url()?>extras/layout2.0/assets/js/multiselect/jquery.amsify.suggestags.js"></script>
<script> 
function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
} 
</script> 
<?php
	}
?>
<!--INTYROJS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/introjs-rtl.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/introjs.min.css" />
<!--Fin IntroJS-->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="<?php if (!$side_bar) echo 'sidebar-close'; ?>">
		<div class="main-wrapper">
			<!-- start: TOPBAR -->
			<header class="topbar navbar navbar-inverse navbar-fixed-top inner">
				<!-- start: TOPBAR CONTAINER -->
				<div class="container">
					<div class="navbar-header">
						<a class="sb-toggle-left hidden-md hidden-lg" href="pages_blank_page.html#main-navbar">
							<i class="fa fa-bars"></i>
						</a>
						<!-- start: LOGO -->
						<a class="navbar-brand">
							<font>Integra - EST</font>
						</a>
						<!-- end: LOGO -->
					</div>
					<div class="topbar-tools">
						<!-- start: TOP NAVIGATION MENU -->
						<ul class="nav navbar-right">
							<!-- start: USER DROPDOWN -->
							<li class="dropdown current-user">
								<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
									<img src="<?php echo base_url().$this->session->userdata('imagen_barra'); ?>" class="img-circle" alt=""> <span class="username hidden-xs"><?php echo $this->session->userdata('nombres'); ?></span> <i class="fa fa-caret-down "></i>
								</a>
								<ul class="dropdown-menu dropdown-dark">
									<li>
										<a href="<?php echo base_url() ?>usuarios/perfil/index">
											Mi Perfil
										</a>
									</li>
									<li>
										<a href="<?php echo base_url() ?>usuarios/login/salir">
											Salir
										</a>
									</li>
								</ul>
							</li>
						</ul>
						<!-- end: TOP NAVIGATION MENU -->
					</div>
				</div>
				<!-- end: TOPBAR CONTAINER -->
			</header>
			<!-- end: TOPBAR -->
			<!-- start: PAGESLIDE LEFT -->
			<a class="closedbar inner hidden-sm hidden-xs <?php if (!$side_bar) echo 'open'; ?>" href="javascript:void(0)">
			</a>
			<nav id="pageslide-left" class="pageslide inner">
				<div class="navbar-content">
					<!-- start: SIDEBAR -->
					<div class="main-navigation left-wrapper transition-left">
						<div class="navigation-toggler hidden-sm hidden-xs">
							<a href="javascript:void(0)" class="sb-toggle-left">
							</a>
						</div>
						<div class="user-profile border-top padding-horizontal-10 block">
							<div class="inline-block">
								<img src="<?php echo base_url().$this->session->userdata('imagen'); ?>" alt="">
							</div>
							<div class="inline-block">
								<h5 class="no-margin"> Bienvenido </h5>
								<h4 class="no-margin"> <?php echo $this->session->userdata('nombres'); ?> </h4>
								<!--<a class="btn user-options sb_toggle">
									<i class="fa fa-cog"></i>
								</a>-->
							</div>
						</div>
						<!-- start: MAIN NAVIGATION MENU -->
						<ul class="main-navigation-menu">
							<?php echo $menu ?>
						</ul>
						<!-- end: MAIN NAVIGATION MENU -->
					</div>
					<!-- end: SIDEBAR -->
				</div>
				<div class="slide-tools">
				</div>
			</nav>
			<div class="main-container inner">
				<!-- start: PAGE -->
				<div class="main-content">
					<!-- end: SPANEL CONFIGURATION MODAL FORM -->
					<div class="container">
						<!-- start: PAGE HEADER -->
						<!-- start: TOOLBAR -->
						<div class="toolbar row">
							<div class="col-sm-8 hidden-xs">
								<div class="page-header">
									<h1><?php echo $titulo; ?> <small><?php echo @$subtitulo; ?></small></h1>
								</div>
							</div>
							<div class="col-sm-4 col-xs-12">
								<a href="#" class="back-subviews">
									<i class="fa fa-chevron-left"></i> Volver
								</a>
								<a href="#" class="close-subviews">
									<i class="fa fa-times"></i> Cerrar
								</a>
								<div class="toolbar-tools pull-right">
									<!-- start: TOP NAVIGATION MENU -->
									<ul class="nav navbar-right">
										<?php if(isset($head_buscar)){ ?>
										<li class="menu-search">
											<a href="pages_blank_page.html#">
												<i class="fa fa-search"></i> BUSCAR
											</a>
											<!-- start: SEARCH POPOVER -->
											<div class="popover bottom search-box transition-all">
												<div class="arrow"></div>
												<div class="popover-content">
													<!-- start: SEARCH FORM -->
													<form class="" action="<?php echo $head_buscar['url'] ?>" method="<?php echo $head_buscar['method'] ?>" >
														<div class="input-group">
															<input type="text" class="form-control" placeholder="Buscar" name='head_buscar'> 
															<span class="input-group-btn">
																<button class="btn btn-main-color btn-squared" type="button" >
																	<i class="fa fa-search"></i>
																</button> </span>
														</div>
													</form>
													<!-- end: SEARCH FORM -->
												</div>
											</div>
											<!-- end: SEARCH POPOVER -->
										</li>
										<?php } ?>
									</ul>

									<!-- end: TOP NAVIGATION MENU -->
								</div>
							</div>
						</div>
						<!-- end: TOOLBAR -->
						<!-- end: PAGE HEADER -->
						<!-- start: BREADCRUMB -->
						<div class="row">
							<div class="col-md-12">
								<ol class="breadcrumb">
									<?php if(!empty($lugar)){ ?>
										<?php foreach ($lugar as $l) { ?>
											<?php if(!empty($l['url'])){ ?>
											<li>
												<a href="<?php echo base_url().$l['url'] ?>">
													<?php echo $l['txt'] ?>
												</a>
											</li>
											<?php } else{ ?>
											<li class='active'>
											<?php echo $l['txt'] ?>
											</li>
											<?php } ?>
										<?php } 
									} ?>
								</ol>
							</div>
						</div>
						<!-- end: BREADCRUMB -->
						<!-- start: PAGE CONTENT -->
						<div class="row">
							<div class="col-md-12">
								<?php if ( isset($alert_tipo) ){ ?>
								<div class="alert <?php echo $alert_tipo ?>">
									<?php echo $alert_contenido; ?>
								</div>
								<?php } ?>
								<?php echo $cuerpo; ?>
							</div>
						</div>
						<!-- end: PAGE CONTENT-->
					</div>
					<div class="subviews">
						<div class="subviews-container"></div>
					</div>
					<div id="subview-eval-list" class="no-display"></div>
					<div id="subview-eval-add" class="no-display"></div>
				</div>
				<!-- end: PAGE -->
			</div>
			<!-- end: MAIN CONTAINER -->
			<!-- start: FOOTER -->
			<footer class="inner">
				<div class="footer-inner">
					<div class="pull-left">
						<?php echo date('Y') ?> &copy; Empresa de Servicios Transitorios Integra Ltda.
					</div>
					<div class="pull-right">
						<span class="go-top"><i class="fa fa-chevron-up"></i></span>
					</div>
				</div>
			</footer>

		</div>

		<!--<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jQuery/jquery-2.1.1.min.js"></script>-->

		<!--<![endif]-->
		<script type="text/javascript">
		//<![CDATA[
		base_url = '<?php echo base_url();?>';
		//]]>
		</script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/chat.js"></script>
		<!--<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>-->
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/blockUI/jquery.blockUI.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/moment/min/moment.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/perfect-scrollbar/src/jquery.mousewheel.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/perfect-scrollbar/src/perfect-scrollbar.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootbox/bootbox.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery.scrollTo/jquery.scrollTo.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/ScrollToFixed/jquery-scrolltofixed-min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery.appear/jquery.appear.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/velocity/jquery.velocity.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR SUBVIEW CONTENTS -->
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-mockjax/jquery.mockjax.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/toastr/toastr.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/js/bootstrap-modal.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-switch/dist/js/bootstrap-switch.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/DataTables/media/js/DT_bootstrap.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/truncate/jquery.truncate.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/summernote/dist/summernote.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/plugins/x-editable/js/bootstrap-editable.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/subview.js"></script>

		<!--<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/subview-examples.js"></script>-->
		<?php 
		if (isset($js)){
			foreach( $js as $file ){ ?>
				<script src="<?php echo base_url() ?>extras/layout2.0/assets/<?php echo $file; ?>"></script>
		<?php }
		} ?>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CORE JAVASCRIPTS  -->
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/main.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/examen_preo_masso.js"></script>
		<!-- end: CORE JAVASCRIPTS  -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				//SVExamples.init();
				//FormElements.init();
				//UIModals.init();
				//TableData.init();
			});
		</script>
		<script type="text/javascript">

		</script>
<!--		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/tags/bootstrap-tagsinput.min.js"></script>
		<script src="<?php echo base_url() ?>extras/layout2.0/assets/js/tags/bootstrap-tagsinput-angular.min.js"></script>-->
<script >
  $("#seleccion_planta").change(function(){
  	if($("#seleccion_planta").val() != ''){
      $("#tipoSeleccion").show(800);
  	}
});

  $(document).ready(function(){
        $(".seleccionFiltro").click(function(evento){
        	var valor = $(this).val();

            if(valor == 'vigencia'){
          	    document.getElementById("datepicker").value = null;
          	    document.getElementById("datepicker2").value = null;

                $("#divContratacion").show(800);
                $("#divRangoFecha").hide(800);
            }else{
          	    document.getElementById("vigencia").selectedIndex = 0;
                $("#divContratacion").hide(800);
                $("#divRangoFecha").show(800);
            }
    });
});
</script>

<?php 
if (isset($soloCargo)) {
	$hola = "";
	foreach ($cargos as $key ) {
		$hola .= "'".$key->nombre."', ";
	}
?>
	<script type="text/javascript">
		$('input[name="especialidades"]').amsifySuggestags({
			suggestions: [ <?php echo $hola ?>],
			whiteList: true
		});
	</script>
<?php 
}
?>
<script>
	$(document).ready(function(){
	$(".clickButtonMenu").on('click',function(event){
		//event.preventDefault();
		link = $(this).attr('data');
        $.ajax({
          type:"POST",
          url: base_url+"usuarios/home/menuclick/"+link,
          data:link,
          dataType: "json",
          success:function(data){
               //alert(data);
          }
        });
	});
	//alertify.alert('Ready!');
}); // 415628 Factura  Dimacofi
//Push.create('Hello World!')
// eceace
</script> 
<?php 
	if ( $this->session->userdata('tipo_usuario') == 8) {
?>
<script type="text/javascript">/*
$(document).ready(function() {	
    function revisarSolicitudContrato() {
    	$.ajax({
          type:"POST",
          url: base_url+"usuarios/home/revisarSolicitudContrato/",
          //data:link,
          dataType: "json",
          success:function(data){
          	for(var i=0; i<data.length ; i++){
          		var avisoCookiesMostrado = window.localStorage.getItem(data[i]['archivo']);
				if(!avisoCookiesMostrado) {
	          		Push.create(data[i]['tipoSolicitud'], { //Titulo de la notificación
						body: data[i]['quienSolicita'], //Texto del cuerpo de la notificación
						icon: 'https://sgo2.integraest.cl/extras/layout2.0/img_perfil/integra1.png', //Icono de la notificación
						timeout: 18000, //Tiempo de duración de la notificación
						onClick: function () {//Función que se cumple al realizar clic sobre la notificación
							window.location = base_url+"est/contratos/solicitudes_pendientes"; //Redirige a la siguiente web
							//this.close(); //Cierra la notificación
						}
					});
					 window.localStorage.setItem(data[i]['archivo'], true);
				}
          	}
          }
        });
    }
    setInterval(revisarSolicitudContrato, 3000);
});*/
</script>
<?php 
	}
?>
<?php  if ($this->session->userdata('listado_psicologia',true)) { ?>


<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<?php 
$this->session->unset_userdata('listado_psicologia');
} 
?>
<script>
	/*	//Todo el código que se encuentra aquí se auto explica 
		Push.create("Gerardo Ramirez", { //Titulo de la notificación
			body: "Desarrollador front-end.", //Texto del cuerpo de la notificación
			icon: 'https://sgo2.integraest.cl/extras/layout2.0/img_perfil/default_thumb.jpg', //Icono de la notificación
			//timeout: 6000, //Tiempo de duración de la notificación
			onClick: function () {//Función que se cumple al realizar clic cobre la notificación
				window.location = "https://01luisrene.com"; //Redirige a la siguiente web
				this.close(); //Cierra la notificación
			}
		});*/
	</script>
	</body>
	<!-- end: BODY -->
</html>