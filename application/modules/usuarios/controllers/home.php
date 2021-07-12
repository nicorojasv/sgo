<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Home extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
    	$this->load->library('encrypt');
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$this->load->model('Requerimiento_Asc_Trabajadores_model');
		

		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 3)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 5)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 6)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_contabilidad','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 7)
			$this->menu = $this->load->view('layout2.0/menus/menu_mandante','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 9)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_solo_abastecimiento','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 13)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios_supervisor','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 14)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 15)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin_supervisor','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 16)
			$this->menu = $this->load->view('layout2.0/menus/menu_marina_supervisor','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 17)
			$this->menu = $this->load->view('layout2.0/menus/menu_marina_chillan','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 18)
			$this->menu = $this->load->view('layout2.0/menus/menu_sanatorio','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

   	function reqla(){
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$query = $this->Requerimiento_Usuario_Archivo_model->reqla();

		var_dump($query);
   	}
   	function prueba(){
		$this->load->model('Requerimiento_Usuario_Archivo_model');
		$this->load->model('Requerimiento_Asc_Trabajadores_model');
		$fecha_hoy = date('Y-m-d');
		$listado_usuarios = $this->Requerimiento_Usuario_Archivo_model->listar_usuarios_contrato_vencido();
		var_dump($listado_usuarios);
		echo "finalizado";
	}

   	function graficos(){
   		$this->load->model("Usuarios_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'js' => array('js/avance_pgp.js'),
			'css' => array("css/avance_pgp.css"),
			'menu' => $this->menu
		);
		$pagina = "";
		$base['cuerpo'] = $this->load->view('home/graficos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
   	}

   	function graficos2(){
   		$this->load->model("Usuarios_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);
		$pagina = "";
		$base['cuerpo'] = $this->load->view('home/graficos2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
   	}

   	function actualizar(){
		$this->load->model("Usuarios2_model");
   		//$this->Usuarios2_model->limpiar_mongo();
   		$xd =$this->Usuarios2_model->llenar_mongo_otro();
   		echo "Finalizado Correctamente";
   	}

	function index(){
		$this->load->model("Usuarios_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'js' => array('plugins/bootstrap-progressbar/bootstrap-progressbar.min.js','plugins/nvd3/lib/d3.v3.js','plugins/nvd3/nv.d3.min.js','plugins/nvd3/src/models/historicalBar.js','plugins/nvd3/src/models/historicalBarChart.js','plugins/nvd3/src/models/stackedArea.js','plugins/nvd3/src/models/stackedAreaChart.js','plugins/jquery.sparkline/jquery.sparkline.js','plugins/easy-pie-chart/dist/jquery.easypiechart.min.js', 'js/index.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);
		$pagina = "";
		$msg = 'integra';
		$pagina['mensaje'] = $this->encrypt->encode($msg);
		$base['cuerpo'] = $this->load->view('home/home',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function examen_preo(){
		$this->load->model("Usuarios_model");
		foreach ($this->Usuarios_model->listar_usuarios_evaluaciones_preo() as $rm){
			$get_cantidad = $this->Usuarios_model->contar_evaluaciones_preo($rm->id_usuarios);
			$total_examenes = isset($get_cantidad->total)?$get_cantidad->total:0;
			if($total_examenes >= 1){
				$get_ultimo = $this->Usuarios_model->id_maximo_examenes_preo($rm->id_usuarios);
				$this->Usuarios_model->actualizar_desactivo_estado_preo($rm->id_usuarios);
				$this->Usuarios_model->actualizar_activo_estado_preo($get_ultimo->ultimo);
			}
		}
		echo "Foreach Finalizado Exitosamente";
	}

	function masso(){
		$this->load->model("Usuarios_model");
		foreach ($this->Usuarios_model->listar_usuarios_evaluaciones_masso() as $rm){
			$get_cantidad = $this->Usuarios_model->contar_evaluaciones_masso($rm->id_usuarios);
			$total_examenes = isset($get_cantidad->total)?$get_cantidad->total:0;
			if($total_examenes >= 1){
				$get_ultimo = $this->Usuarios_model->id_maximo_examenes_masso($rm->id_usuarios);
				$this->Usuarios_model->actualizar_desactivo_estado_masso($rm->id_usuarios);
				$this->Usuarios_model->actualizar_activo_estado_masso($get_ultimo->ultimo);
			}
		}
			echo "Foreach Finalizado Exitosamente";
	}

	function archivos_examenes(){
		$this->load->model('evaluacionesarchivo_model');
		$evaluaciones_archivos = $this->evaluacionesarchivo_model->result_group();
		foreach ($evaluaciones_archivos as $key){
			$get_cantidad = $this->evaluacionesarchivo_model->contar_cantidad_archivo_eval($key->id_evaluacion);
			//echo "ID Evaluacion: ".$key->id_evaluacion." - Cantidad: ".$get_cantidad->total."<br>";
			if($get_cantidad->total > 1){
				echo "ID Evaluacion: ".$key->id_evaluacion." - Cantidad: ".$get_cantidad->total."<br>";
			}
			
		}

	}

	function revisar_rut_examenes(){
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'js' => array('plugins/bootstrap-progressbar/bootstrap-progressbar.min.js','plugins/nvd3/lib/d3.v3.js','plugins/nvd3/nv.d3.min.js','plugins/nvd3/src/models/historicalBar.js','plugins/nvd3/src/models/historicalBarChart.js','plugins/nvd3/src/models/stackedArea.js','plugins/nvd3/src/models/stackedAreaChart.js','plugins/jquery.sparkline/jquery.sparkline.js','plugins/easy-pie-chart/dist/jquery.easypiechart.min.js', 'js/index.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);
		$pagina = "";
		$base['cuerpo'] = $this->load->view('home/revisar_rut',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function formulario_revisar_rut_existe(){
		$this->load->library('PHPExcel');
		$this->load->model('Usuarios_model');
		$_archivo = "extras/revisar_rut.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(1);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$listado = array();
		$listado_rut_correcto = array();
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1){
				$aux = new stdClass();
				$rut = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();

				if(!empty($rut)){
					$get_rut = $this->Usuarios_model->get_rut($rut);
					if($get_rut == NULL){
						$aux->rut = $rut;
						array_push($listado,$aux);
						unset($aux);
					}else{
						$aux->rut = $rut;
						array_push($listado_rut_correcto,$aux);
						unset($aux);

					}
				}
			}
		}
		echo "Proceso Finalizado Exitosamente";
		var_dump($listado);

		echo "<h4>Rut Correctos</h4>";
		var_dump($listado_rut_correcto);
	}

	function formulario_revisar_rut_examenes_psicologicos(){
		$this->load->library('PHPExcel');
		$this->load->model('Examenes_Psicologicos_model');
		$this->load->model('Usuarios_model');
		$_archivo = "extras/revisar_rut.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(1);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$listado = array();
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1){
				$aux = new stdClass();
				$fecha_evaluacion = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$fecha_vigencia = $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
				$rut = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$lugar_trabajo_id = $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
				$cargo_postulacion_id = $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
				$tecnico_supervisor = $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				$psicolo_evaluador = $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
				$resultado = $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();

				//fecha_evaluacion
				if (empty($fecha_evaluacion)) {
					$fecha_evaluacion = "000-00-00";
				}else{
					$timestamp2 = PHPExcel_Shared_Date::ExcelToPHP($fecha_evaluacion);
					$fecha_evaluacion = date('Y-m-d', $timestamp2);
				}

				//fecha_vigencia
				if (empty($fecha_vigencia)) {
					$fecha_vigencia = "000-00-00";
				}else{
					$timestamp = PHPExcel_Shared_Date::ExcelToPHP($fecha_vigencia);
					$fecha_vigencia = date('Y-m-d', $timestamp);
				}

				if(!empty($rut)){
					$get_rut = $this->Usuarios_model->get_rut($rut);
					$id_usuario = isset($get_rut->id)?$get_rut->id:NULL;

					$existe_examen_psicologico = $this->Examenes_Psicologicos_model->existe_usuario($id_usuario);					

					if($existe_examen_psicologico != "NADA"){							
						//ACTUALIZAR DATOS EN LA TABLE EXAMEN PSICOLOGICO
						$id_examen_psicologico = $existe_examen_psicologico->id;
						//$aux->id_usuario_existe = $id_usuario;
						$actualizar_examen_psicologico = array(
							//'id_usuario_registrado' => $id_examen_psicologico,
							'fecha_evaluacion' => $fecha_evaluacion,
							'fecha_vigencia' => $fecha_vigencia,
							'lugar_trabajo_id' => $lugar_trabajo_id,
							'cargo_postulacion_id' => $cargo_postulacion_id,
							'tecnico_supervisor' => $tecnico_supervisor,
							'psicologo_evaluador' => $psicolo_evaluador,
							'resultado' => $resultado,
							'estado' => 1,
							'liberacion' => 1,
							'estado_ultimo_examen' => 1
						);
						//var_dump($actualizar_examen_psicologico);
						$this->Examenes_Psicologicos_model->actualizar_examen_psicologico($actualizar_examen_psicologico, $id_examen_psicologico);
					}else{						
						//INGRESAR NUEVO REGISTRO		
						//$id_examen_psicologico = $existe_examen_psicologico->id;
						//$aux->id_usuario_existe = $id_usuario;
						$nuevo_examen_psicologico = array(
							'usuario_id' => $id_usuario,
							'fecha_evaluacion' => $fecha_evaluacion,
							'fecha_vigencia' => $fecha_vigencia,
							'lugar_trabajo_id' => $lugar_trabajo_id,
							'cargo_postulacion_id' => $cargo_postulacion_id,
							'tecnico_supervisor' => $tecnico_supervisor,
							'psicologo_evaluador' => $psicolo_evaluador,
							'resultado' => $resultado,
							'estado' => 1,
							'liberacion' => 1,
							'estado_ultimo_examen' => 1
						);
						//var_dump($nuevo_examen_psicologico);
						$this->Examenes_Psicologicos_model->nuevo_examen_psicologico($nuevo_examen_psicologico);
					}
				}
				array_push($listado,$aux);
				unset($aux);
			}
		}
		echo "Proceso Finalizado Exitosamente";
		//var_dump($listado);
	}

	function revisar_examenes(){
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'js' => array('plugins/bootstrap-progressbar/bootstrap-progressbar.min.js','plugins/nvd3/lib/d3.v3.js','plugins/nvd3/nv.d3.min.js','plugins/nvd3/src/models/historicalBar.js','plugins/nvd3/src/models/historicalBarChart.js','plugins/nvd3/src/models/stackedArea.js','plugins/nvd3/src/models/stackedAreaChart.js','plugins/jquery.sparkline/jquery.sparkline.js','plugins/easy-pie-chart/dist/jquery.easypiechart.min.js', 'js/index.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);
		$pagina = "";
		$base['cuerpo'] = $this->load->view('home/revisar_examenes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function formulario_revisar_examenes(){
		$this->load->library('PHPExcel');
		$this->load->model('Evaluaciones_model');
		$_archivo = "extras/masso.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$listado = array();
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1){
				$aux = new stdClass();
				$id_evaluacion = $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
				$centro_costo = $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

				if(!empty($id_evaluacion)){
					$get_examen = $this->Evaluaciones_model->get($id_evaluacion);
					$centrocosto = isset($get_examen->ccosto)?$get_examen->ccosto:"ND";

					if($centro_costo != NULL and $centro_costo != "TERCEROS"){
						$datos = array(
							'ccosto' => $centrocosto,
						);
						$this->Evaluaciones_model->editar($id_evaluacion, $datos);
					}elseif($centro_costo == "TERCEROS"){
						$datos_terceros = array(
							'ccosto' => NULL,
							'pago' => 1,
						);
						$this->Evaluaciones_model->editar($id_evaluacion, $datos_terceros);
					}
				}
				array_push($listado,$aux);
				unset($aux);
			}
		}
		echo "Proceso Finalizado Exitosamente";
	}

	function formulario_revisar_examenes_preocupacional(){
		$this->load->library('PHPExcel');
		$this->load->model('Evaluaciones_model');
		$_archivo = "extras/preocupacional.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$listado = array();
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1 and $i != 2){
				$aux = new stdClass();
				$id_evaluacion = $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
				$centro_costo = $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();

				if(!empty($id_evaluacion)){
					$get_examen = $this->Evaluaciones_model->get($id_evaluacion);
					$centrocosto = isset($get_examen->ccosto)?$get_examen->ccosto:"ND";

					if($centro_costo != NULL and $centro_costo != "TERCEROS"){
						$datos = array(
							'ccosto' => $centrocosto,
						);
						$this->Evaluaciones_model->editar($id_evaluacion, $datos);
					}elseif($centro_costo == "TERCEROS"){
						$datos_terceros = array(
							'ccosto' => NULL,
							'pago' => 1,
						);
						$this->Evaluaciones_model->editar($id_evaluacion, $datos_terceros);
					}
				}
				array_push($listado,$aux);
				unset($aux);
			}
		}
		echo "Proceso Finalizado Exitosamente";
	}


	function actualizar_examenes(){
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> Empresa de Servicios Transitorios',
			'side_bar' => true,
			'js' => array('plugins/bootstrap-progressbar/bootstrap-progressbar.min.js','plugins/nvd3/lib/d3.v3.js','plugins/nvd3/nv.d3.min.js','plugins/nvd3/src/models/historicalBar.js','plugins/nvd3/src/models/historicalBarChart.js','plugins/nvd3/src/models/stackedArea.js','plugins/nvd3/src/models/stackedAreaChart.js','plugins/jquery.sparkline/jquery.sparkline.js','plugins/easy-pie-chart/dist/jquery.easypiechart.min.js', 'js/index.js'),
			'css' => array('plugins/nvd3/nv.d3.min.css'),
			'lugar' => array(array('url' => '', 'txt' => 'Inicio') ),
			'menu' => $this->menu
		);
		$pagina = "";
		$base['cuerpo'] = $this->load->view('home/actualizar_examenes',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function formulario_actualizar_examenes_preocupacional(){
		$this->load->library('PHPExcel');
		$this->load->model('Evaluaciones_model');
		$_archivo = "extras/preocupacional_actualizar.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$listado = array();
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1 and $i != 2){
				$aux = new stdClass();
				$id_evaluacion = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$centro_costo = $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
				$referido = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$asiste_examen = $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$valor = $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();

				if(!empty($id_evaluacion)){
					$datos = array(
						'ccosto' => $centro_costo,
						'examen_referido' => $referido,
						'asistencia_examen' => $asiste_examen,
						'valor_examen' => $valor,
					);
					$this->Evaluaciones_model->editar($id_evaluacion, $datos);
				}
				array_push($listado,$aux);
				unset($aux);
			}
		}
		echo "Proceso Finalizado Exitosamente";
	}



	function guardar_trabajadores_enjoy(){
		$this->load->library('PHPExcel');
		$this->load->model('enjoy/Usuarios_model');
		$_archivo = "extras/BBDDEnjoy.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1){
				$nombre_trabajador = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$rut_trabajador = $obj_excel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
				$nacionalidad = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$fecha_nacimiento = $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$estado_civil = $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
				$domicilio = $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
				$comuna = $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				$afp = $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
				$salud = $obj_excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();

				if (empty($fecha_nacimiento)) {
					$fecha_nacimiento = "000-00-00";
				}else{
					$timestamp2 = PHPExcel_Shared_Date::ExcelToPHP($fecha_nacimiento);
					$get_fecha_nacimiento = date('Y-m-d', $timestamp2);
					$nuevafecha = strtotime('+1 day' , strtotime ($get_fecha_nacimiento));
					$fecha_nacimiento = date('Y-m-d' , $nuevafecha);
				}

				if(!empty($rut_trabajador)){
					$datos = array(
						'nombres' => $nombre_trabajador,
						'rut_usuario' => $rut_trabajador,
						'nacionalidad' => $nacionalidad,
						'fecha_nac' => $fecha_nacimiento,
						'id_estado_civil' => $estado_civil,
						'direccion' => $domicilio,
						'id_ciudad' => $comuna,
						'id_afp' => $afp,
						'id_salud' => $salud,
					);
					$this->Usuarios_model->ingresar($datos);
				}
			}
		}
		echo "Proceso Finalizado Exitosamente";
	}



	function proceso_activacion(){
		$this->load->library('PHPExcel');
		$this->load->model('Usuarios_model');
		$_archivo = "extras/usuariosFINAL.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$datos_activos = array('estado' => 1, );
		$datos_inactivos = array('estado' => 0, );

		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			if ($i != 1){
				$id = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$estado = $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();

				if(!empty($id)){
					if($estado == "2")
						$this->Usuarios_model->editar($id, $datos_inactivos);
					elseif($estado == "1")
						$this->Usuarios_model->editar($id, $datos_activos);
				}
			}
		}
		echo "Proceso Finalizado Exitosamente";
	}

	function go(){
		//inicio contratos_finalizados();
		$fecha_hoy = date('Y-m-d');
		$total=0;
		$monal = 0 ;
		$listado_usuarios = $this->Requerimiento_Usuario_Archivo_model->listar_contratos_y_anexos();
		if(!empty($listado_usuarios)){
			foreach ($listado_usuarios as $key ) {
				if ($key->tipo_archivo_requerimiento_id == 1 || $key->tipo_archivo_requerimiento_id == 2) {
					if ($key->fecha_termino> $fecha_hoy) {
						$id_asc_req = $key->requerimiento_asc_trabajadores_id;
						$datos = array(
							'status' => 3,
						);
						$this->Requerimiento_Asc_Trabajadores_model->editar($id_asc_req, $datos);
					}else{
						$id_asc_req = $key->requerimiento_asc_trabajadores_id;
						$datos = array(
							'status' => 6,
						);
						$this->Requerimiento_Asc_Trabajadores_model->editar($id_asc_req, $datos);
					}

				}
			}
		}
		//fin contratos_finalizados();
	}

	function menuclick($menu){
		$this->session->set_userdata('activo',$menu);
		echo json_encode(1);
	}

	function actualizando_usuarios(){
		$this->load->library('PHPExcel');
		$this->load->model('Usuarios_model');
		$_archivo = "extras/codigoCiudad.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();

		$cont = 0;
		for ($i=1; $i <= $numRows ; $i++){
			if ($i != 1){
					$id = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
					$codigo = $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
					echo $cont;
					$cont++;
					$data = array(
						'codigo' => $codigo,
						);
					$this->Usuarios_model->agregarCodigoCiudad($id, $data);
			}
		
		}
		echo "Proceso Finalizado Exitosamente";
	}
	// 17A A $21.000 X CAJA, tAMBORES COMPRAR X $36.000+IVA

	function guardar_trabajadores_marina(){
		
		 //ini_set('memory_limit', '4096M');
		$this->load->library('PHPExcel');
		$this->load->model('Usuarios_model');
		$_archivo = "extras/cora.xlsx";
		$obj_excel = PHPExcel_IOFactory::load(BASE_URL2.$_archivo);
		$obj_excel->setActiveSheetIndex(0);
		$numRows = $obj_excel->setActiveSheetIndex(0)->getHighestRow();
		//var_dump($numRows);
		//return false;
		$cont = 0;
		for ($i=1; $i < $numRows ; $i++){
			//if ($i != 1){
				$producto_id = $obj_excel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
				$precio = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$cantidad = $obj_excel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
				/*$paterno_trabajador = $obj_excel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
				$materno_trabajador = $obj_excel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
				$sexo_trabajador = $obj_excel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
				$telefono_trabajador = $obj_excel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
				$fecha_nacimiento = $obj_excel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
				$direccion = $obj_excel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
				$ciudad = $obj_excel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
				$nacionalidad = $obj_excel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
				$estadoCivil = $obj_excel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
				$salud = $obj_excel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
				$afp = $obj_excel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
				$cargo = $obj_excel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
				$banco = $obj_excel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
				$tipoCuenta = $obj_excel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
				$numeroCuenta = $obj_excel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
				//$correo = $obj_excel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
				//var_dump($fecha_nacimiento);
			
					//var_dump($fecha_nacimiento);
				//return false;
				//var_dump($fecha_nacimiento);
				if (empty($fecha_nacimiento)) {
					$fecha_nacimiento = "1900-01-01";
				}else{
				/*	$fn = explode("-", $fecha_nacimiento);
					$ano = $fn[2];
					$mes = $fn[1];
					$dia = $fn[0];
					$fecha_nacimiento= $ano.'-'.$mes.'-'.$dia;*/
				/*	$timestamp2 = PHPExcel_Shared_Date::ExcelToPHP($fecha_nacimiento);
					$get_fecha_nacimiento = date('Y-m-d', $timestamp2);
					$nuevafecha = strtotime('+1 day' , strtotime ($get_fecha_nacimiento));
					$fecha_nacimiento = date('Y-m-d' , $nuevafecha);*/
					//var_dump($fecha_nacimiento);
				//}
				/*$cciudad =0;
				if ($ciudad == 'Chillan' || $ciudad == 'Chiilán' || $ciudad == 'Chillán' ) {
					$cciudad = 82;
				}elseif ($ciudad == 'Chillán Viejo') {
					$cciudad = 300;
				}elseif ($ciudad == 'Los Ángeles') {
					$cciudad = 74;
				}elseif ($ciudad == 'Portezuelo') {
					$cciudad = 306;
				}elseif ($ciudad == 'San Carlos') {
					$cciudad = 310;
				}elseif ($ciudad == 'San Gregorio') {
					$cciudad = 367;
				}elseif ($ciudad == 'San Ignacio') {
					$cciudad = 312;
				}elseif ($ciudad == 'San Nicolás') {
					$cciudad = 313;
				}elseif ($ciudad == 'Talcahuano') {
					$cciudad =19;
				}elseif ($ciudad == 'Hualqui') {
					$cciudad =277;
				}
				if ($sexo_trabajador == 'Femenino') {
					$sexo_trabajador =1;
				}else{
					$sexo_trabajador =0;
				}
				if (empty($direccion)) {
					$direccion='';
				}*/

				//if(!empty($rut_trabajador)){
				if ($cantidad>0) {
				
					$datos = array(
						'parte_entrada_id'=>1,
						'producto_id' => $producto_id,
						//'bodega_id' => 1,
						//'estanteria' => 0,
						'precio' => $precio,
						'cantidad' =>$cantidad,
						/*'materno' => $materno_trabajador,
						'sexo' => $sexo_trabajador,
						'fono' => $telefono_trabajador,
						'fecha_nac' => $fecha_nacimiento,
						'direccion' => $direccion,
						'especialidad'=> $cargo,
						'id_ciudad' => $cciudad,
						'nacionalidad' => $nacionalidad,
						'id_estado_civil' => $estadoCivil,
						'id_salud' => $salud,
						'id_afp' => $afp,
						'id_bancos' => $banco,
						'tipo_cuenta' => $tipoCuenta,
						'cuenta_banco' => $numeroCuenta,
						'rut_usuario' => $rut_trabajador,
					//	'email'=> $correo,
						'estado'=>1,*/
					);
					$this->Usuarios_model->ingresar($datos);
				}
				//}
			//}
		}
		echo "Proceso Finalizado Exitosamente";
	}

	function revisarSolicitudContrato(){
		$notificaciones = $this->Requerimiento_Usuario_Archivo_model->verificar();

		//var_dump($notificaciones);
		//echo json_encode($notificaciones);

		$listado = array();
		foreach ($notificaciones as $key) {     
			$this->Requerimiento_Usuario_Archivo_model->cambiarEstadoNotificacion($key->id);                  
			if ($key->tipoSolicitud == 1) {//contrato
				$tipo= "Nueva Solicitud Contrato";
			}else{//anexo
				$tipo= "Nueva Solicitud Anexo de Contrato";
			} 
			$hola = array(
				"tipoSolicitud"=>$tipo,
				"quienSolicita"=>$key->nombreSolicitante." a solicitado un contrato para: ".$key->nombreTrabajador,
				"archivo"=>$key->id_usu_archivo,
				);
			array_push($listado,$hola);
		}
	    echo json_encode($listado); 
	}
}
?>