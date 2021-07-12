<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Trabajadores extends CI_Controller{
	public $requerimiento;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
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
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 11)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_rrhh','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		//redirect('administracion/trabajadores/agregar', 'refresh');
	}

	function base_datos_contratos($id_planta){
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Evaluaciones_model');
		$base = array(
			'head_titulo' => "Reportabilidad Trabajadores ".$this->Empresa_planta_model->get($id_planta)->nombre,
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$this->Empresa_planta_model->get($id_planta)->nombre,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Reportabilidad Base de Datos Excel')),
			'side_bar' => false,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$trabajadores = $this->Evaluaciones_model->listar_trabajadores_cc_planta($id_planta);
		$listado = array();
		foreach($trabajadores as $rm){
			$aux = new stdClass();
			$aux->id_usuario = $rm->usuario_id;
			$get_usu = $this->Usuarios_model->get($rm->usuario_id);
			$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
			$aux->nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
			$aux->paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
			$aux->materno = (isset($get_usu->materno)?$get_usu->materno:"");

			$datos_req = $this->Requerimientos_model->requerimientos_planta_usuario($rm->usuario_id, $id_planta);
			$aux->datos_req = array();
			if (!empty($datos_req)){
				foreach ($datos_req as $d) {
					$archivo = new StdClass();
					$archivo->nombre_req = $d->nombre;
					$archivo->referido = $d->referido;
					array_push($aux->datos_req, $archivo);
				}
				unset($archivo);
			}

			$masso = $this->Evaluaciones_model->get_all_masso2($rm->usuario_id, $id_planta);
			$aux->datos_masso = array();
			if (!empty($masso)){
				foreach ($masso as $dd){
					$archivo1 = new StdClass();
					$archivo1->id_eval = $dd->id;
					$archivo1->fecha_e = $dd->fecha_e;
					$archivo1->fecha_v = $dd->fecha_v;
					$archivo1->valor_examen = $dd->valor_examen;
					$archivo1->estado_cobro = $dd->estado_cobro;
					$archivo1->examen_referido = $dd->examen_referido;
					$archivo1->asiste_examen = $dd->asistencia_examen;
					array_push($aux->datos_masso, $archivo1);
				}
				unset($archivo1);
			}

			$examen_pre = $this->Evaluaciones_model->get_all_preo2($rm->usuario_id, $id_planta);
			$aux->datos_preo = array();
			if (!empty($examen_pre)){
				foreach ($examen_pre as $dx){
					$archivo2 = new StdClass();
					$archivo2->id_eval = $dx->id;
					$archivo2->fecha_e = $dx->fecha_e;
					$archivo2->fecha_v = $dx->fecha_v;
					$archivo2->valor_examen = $dx->valor_examen;
					$archivo2->estado_cobro = $dx->estado_cobro;
					$archivo2->examen_referido = $dx->examen_referido;
					$archivo2->asiste_examen = $dx->asistencia_examen;
					array_push($aux->datos_preo, $archivo2);
				}
				unset($archivo2);
			}

			$examen_ps = $this->Examenes_psicologicos_model->get_result_usu($rm->usuario_id, $id_planta);
			$aux->datos_examen_ps = array();
			if (!empty($examen_ps)){
				foreach ($examen_ps as $ep){
					$archivo3 = new StdClass();

					if($ep->tecnico_supervisor == 1)
						$tecnico_supervisor = "Tecnico";
					elseif($ep->tecnico_supervisor == 2)
						$tecnico_supervisor = "Supervisor";
					else
						$tecnico_supervisor = "";

					$archivo3->id_evaluacion = $ep->id;
					$archivo3->resultado = $ep->resultado;
					$archivo3->tecnico_supervisor = $tecnico_supervisor;
					$archivo3->fecha_evaluacion = $ep->fecha_evaluacion;
					$archivo3->estado_cobro = $ep->estado_cobro;
					$archivo3->fecha_cobro = $ep->fecha_cobro;
					$archivo3->valor_examen = $ep->valor_examen;
					
					array_push($aux->datos_examen_ps, $archivo3);
				}
				unset($archivo3);
			}

			array_push($listado, $aux);
			unset($aux);
		}

		$pagina['listado'] = $listado;
		$pagina['id_planta'] = $id_planta;
		$pagina['empresa_planta'] = $this->Empresa_planta_model->get($id_planta);
		$base['cuerpo'] = $this->load->view('trabajadores/base_datos_contratos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function exportar_excel_contratos_y_anexos(){
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $_POST['datos_a_enviar'];
	}

	function exportar_excel_evaluaciones(){
		header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $_POST['datos_a_enviar'];
	}

	function base_datos_evaluaciones_ccosto(){
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Evaluaciones_model');

		if (!empty($_POST['centro_costo'])){
			$id_centro_costo = $_POST['centro_costo'];
			$get_planta = $this->Empresa_planta_model->get($id_centro_costo);
			$planta = isset($get_planta->nombre)?$get_planta->nombre:"";

			if($id_centro_costo == "todos")
				$planta = "Todos los centro de costos";
		}else{
			$id_centro_costo = NULL;
			$planta = "";
		}

		if (!empty($_POST['estado_examen'])){
			$estado_examen = $_POST['estado_examen'];
		}else{
			$estado_examen = NULL;
		}

		if (!empty($_POST['radio_f_cobro'])){
			$radio_f_cobro = $_POST['radio_f_cobro'];
			
			if (!empty($_POST['fecha_cobro_inicio']))
				$fecha_cobro_inicio = $_POST['fecha_cobro_inicio'];
			else
				$fecha_cobro_inicio = NULL;

			if (!empty($_POST['fecha_cobro_termino']))
				$fecha_cobro_termino = $_POST['fecha_cobro_termino'];
			else
				$fecha_cobro_termino = NULL;
		}else{
			$radio_f_cobro = NULL;
			$fecha_cobro_inicio = NULL;
			$fecha_cobro_termino = NULL;
		}

		if (!empty($_POST['radio_f_evaluacion'])){
			$radio_f_evaluacion = $_POST['radio_f_evaluacion'];
			
			if (!empty($_POST['fecha_eval_inicio']))
				$fecha_eval_inicio = $_POST['fecha_eval_inicio'];
			else
				$fecha_eval_inicio = NULL;

			if (!empty($_POST['fecha_eval_termino']))
				$fecha_eval_termino = $_POST['fecha_eval_termino'];
			else
				$fecha_eval_termino = NULL;

		}else{
			$radio_f_evaluacion = NULL;
			$fecha_eval_inicio = NULL;
			$fecha_eval_termino = NULL;
		}

		if (!empty($_POST['eval_masso'])){
			$eval_masso = $_POST['eval_masso'];
		}else{
			$eval_masso = NULL;
		}

		if (!empty($_POST['eval_preocupacional'])){
			$eval_preocupacional = $_POST['eval_preocupacional'];
		}else{
			$eval_preocupacional = NULL;
		}

		if (!empty($_POST['eval_psicologico'])){
			$eval_psicologico = $_POST['eval_psicologico'];
		}else{
			$eval_psicologico = NULL;
		}

		$base = array(
			'head_titulo' => "Reportabilidad Trabajadores ".$planta,
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$planta,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Reportabilidad Base de Datos Excel')),
			'side_bar' => false,
			'js' => array('js/si_validaciones.js','js/si_datepicker_evaluaciones_cc.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel_jquery.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$get_id_planta = $id_centro_costo;
		$get_estado_examen = $estado_examen;
		$get_radio_fecha_eval = $radio_f_evaluacion;
		$get_fecha_inicio = $fecha_eval_inicio;
		$get_fecha_termino = $fecha_eval_termino;
		$get_radio_fecha_cobro = $radio_f_cobro;
		$get_fecha_cobro_inicio = $fecha_cobro_inicio;
		$get_fecha_cobro_termino = $fecha_cobro_termino;
		$get_eval_masso = $eval_masso;
		$get_eval_preo = $eval_preocupacional;
		$get_eval_psico = $eval_psicologico;

		if (!empty($get_id_planta)){
			if($get_eval_masso != NULL)
				$trabajadores_eval_masso = $this->Evaluaciones_model->listar_trabajadores_cc_planta_segun_eval($get_id_planta, 4, $get_estado_examen);
			else
				$trabajadores_eval_masso = array();

			if($get_eval_preo != NULL)
				$trabajadores_eval_preocu = $this->Evaluaciones_model->listar_trabajadores_cc_planta_segun_eval($get_id_planta, 3, $get_estado_examen);
			else
				$trabajadores_eval_preocu = array();

			if($get_eval_psico != NULL)
				$trabajadores_examen_psicologicos = $this->Examenes_psicologicos_model->listar_trabajadores_cc_planta($get_id_planta, $get_estado_examen);
			else
				$trabajadores_examen_psicologicos = array();			

			$get_trabajadores = array_merge($trabajadores_eval_masso, $trabajadores_eval_preocu, $trabajadores_examen_psicologicos);
			$trabajadores = array_map("unserialize", array_unique(array_map("serialize", $get_trabajadores)));

			$listado = array();
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$cumple_examenes = 0;//si el trabajador tiene algun examen que cumple con el filtro
				$aux->id_usuario = $rm->usuario_id;
				$get_usu = $this->Usuarios_model->get($rm->usuario_id);
				$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
				$aux->nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
				$aux->paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
				$aux->materno = (isset($get_usu->materno)?$get_usu->materno:"");

				$datos_req = $this->Requerimientos_model->requerimientos_planta_usuario($rm->usuario_id, $id_centro_costo);
				$aux->datos_req = array();
				if (!empty($datos_req)){
					foreach ($datos_req as $d) {
						$archivo = new StdClass();
						$get_ccosto = $this->Empresa_planta_model->get($d->planta_id);
						$archivo->nombre_req = $d->nombre;
						$archivo->referido = $d->referido;
						$archivo->ccosto = isset($get_ccosto->nombre)?$get_ccosto->nombre:"";
						array_push($aux->datos_req, $archivo);
						unset($archivo);
					}
				}

				if($get_eval_masso != NULL)
					$masso = $this->Evaluaciones_model->get_all_masso2($rm->usuario_id, $id_centro_costo, $get_estado_examen);
				else
					$masso = array();

				$aux->datos_masso = array();
				if (!empty($masso)){
					foreach ($masso as $dd){
						$archivo1 = new StdClass();
						$get_ccosto = $this->Empresa_planta_model->get($dd->ccosto);
						$archivo1->id_eval = $dd->id;
						$archivo1->fecha_e = $dd->fecha_e;
						$archivo1->fecha_v = $dd->fecha_v;
						$archivo1->valor_examen = $dd->valor_examen;
						$archivo1->estado_cobro = $dd->estado_cobro;
						$archivo1->fecha_cobro = $dd->fecha_cobro;
						$archivo1->examen_referido = $dd->examen_referido;
						$archivo1->asiste_examen = $dd->asistencia_examen;
						$archivo1->pago = $dd->pago;
						$archivo1->ccosto = isset($get_ccosto->nombre)?$get_ccosto->nombre:"";
						
						if($get_radio_fecha_eval == "todos"){
							$si_cumple_eval = 1;
						}elseif($get_radio_fecha_eval == "rango_fecha"){
							if($dd->fecha_e > $get_fecha_inicio and $dd->fecha_e < $get_fecha_termino)
								$si_cumple_eval = 1;
							else
								$si_cumple_eval = 0;
						}

						if($get_radio_fecha_cobro == "todos"){
							$si_cumple_cobro = 1;
						}elseif($get_radio_fecha_cobro == "rango_fecha"){
							if($dd->fecha_cobro > $get_fecha_cobro_inicio and $dd->fecha_cobro < $get_fecha_cobro_termino)
								$si_cumple_cobro = 1;
							else
								$si_cumple_cobro = 0;
						}

						if($si_cumple_eval == 1 and $si_cumple_cobro == 1){
							$cumple_examen = 1;
							$cumple_examenes += 1;
						}else{
							$cumple_examen = 0;
						}

						if($cumple_examen == 1){
							array_push($aux->datos_masso, $archivo1);
							unset($archivo1);
						}
					}
				}

				if($get_eval_preo != NULL)
					$examen_pre = $this->Evaluaciones_model->get_all_preo2($rm->usuario_id, $id_centro_costo, $get_estado_examen);
				else
					$examen_pre = array();
				
				$aux->datos_preo = array();
				if (!empty($examen_pre)){
					foreach ($examen_pre as $dx){
						$archivo2 = new StdClass();
						$get_ccosto = $this->Empresa_planta_model->get($dx->ccosto);
						$archivo2->id_eval = $dx->id;
						$archivo2->fecha_e = $dx->fecha_e;
						$archivo2->fecha_v = $dx->fecha_v;
						$archivo2->valor_examen = $dx->valor_examen;
						$archivo2->estado_cobro = $dx->estado_cobro;
						$archivo2->fecha_cobro = $dx->fecha_cobro;
						$archivo2->examen_referido = $dx->examen_referido;
						$archivo2->asiste_examen = $dx->asistencia_examen;
						$archivo2->pago = $dx->pago;
						$archivo2->ccosto = isset($get_ccosto->nombre)?$get_ccosto->nombre:"";

						if($get_radio_fecha_eval == "todos"){
							$si_cumple_eval = 1;
						}elseif($get_radio_fecha_eval == "rango_fecha"){
							if($dx->fecha_e > $get_fecha_inicio and $dx->fecha_e < $get_fecha_termino)
								$si_cumple_eval = 1;
							else
								$si_cumple_eval = 0;
						}

						if($get_radio_fecha_cobro == "todos"){
							$si_cumple_cobro = 1;
						}elseif($get_radio_fecha_cobro == "rango_fecha"){
							if($dx->fecha_cobro > $get_fecha_cobro_inicio and $dx->fecha_cobro < $get_fecha_cobro_termino)
								$si_cumple_cobro = 1;
							else
								$si_cumple_cobro = 0;
						}

						if($si_cumple_eval == 1 and $si_cumple_cobro == 1){
							$cumple_examen = 1;
							$cumple_examenes += 1;
						}else{
							$cumple_examen = 0;
						}

						if($cumple_examen == 1){
							array_push($aux->datos_preo, $archivo2);
							unset($archivo2);
						}
					}
				}

				if($get_eval_psico != NULL)
					if($get_id_planta == "sin_cc")
						$examen_ps = array();
					else
						$examen_ps = $this->Examenes_psicologicos_model->get_result_usu($rm->usuario_id, $id_centro_costo, $get_estado_examen);
				else
					$examen_ps = array();
					
				$aux->datos_examen_ps = array();
				if (!empty($examen_ps)){
					foreach ($examen_ps as $ep){
						$archivo3 = new StdClass();
						$get_ccosto = $this->Empresa_planta_model->get($ep->lugar_trabajo_id);

						if($ep->tecnico_supervisor == 1)
							$tecnico_supervisor = "Tecnico";
						elseif($ep->tecnico_supervisor == 2)
							$tecnico_supervisor = "Supervisor";
						else
							$tecnico_supervisor = "";

						$archivo3->id_evaluacion = $ep->id;
						$archivo3->resultado = $ep->resultado;
						$archivo3->tecnico_supervisor = $tecnico_supervisor;
						$archivo3->fecha_evaluacion = $ep->fecha_evaluacion;
						$archivo3->estado_cobro = $ep->estado_cobro;
						$archivo3->fecha_cobro = $ep->fecha_cobro;
						$archivo3->valor_examen = $ep->valor_examen;
						$archivo3->ccosto = isset($get_ccosto->nombre)?$get_ccosto->nombre:"";

						if($get_radio_fecha_eval == "todos"){
							$si_cumple_eval = 1;
						}elseif($get_radio_fecha_eval == "rango_fecha"){
							if($ep->fecha_evaluacion > $get_fecha_inicio and $ep->fecha_evaluacion < $get_fecha_termino)
								$si_cumple_eval = 1;
							else
								$si_cumple_eval = 0;
						}

						if($get_radio_fecha_cobro == "todos"){
							$si_cumple_cobro = 1;
						}elseif($get_radio_fecha_cobro == "rango_fecha"){
							if($ep->fecha_cobro > $get_fecha_cobro_inicio and $ep->fecha_cobro < $get_fecha_cobro_termino)
								$si_cumple_cobro = 1;
							else
								$si_cumple_cobro = 0;
						}

						if($si_cumple_eval == 1 and $si_cumple_cobro == 1){
							$cumple_examen = 1;
							$cumple_examenes += 1;
						}else{
							$cumple_examen = 0;
						}

						if($cumple_examen == 1){
							array_push($aux->datos_examen_ps, $archivo3);
							unset($archivo3);
						}
					}
				}

				if($cumple_examenes >= 1){
					array_push($listado, $aux);
					unset($aux);
				}
			}
			$pagina['listado'] = $listado;
			$pagina['id_planta'] = $id_centro_costo;
			$pagina['empresa_planta'] = $planta;
		}else{
			$pagina['listado'] = array();
			$pagina['id_planta'] = "";
			$pagina['empresa_planta'] = "";
		}

		$pagina['eval_masso'] = $eval_masso;
		$pagina['eval_preocupacional'] = $eval_preocupacional;
		$pagina['eval_psicologico'] = $eval_psicologico;
		$pagina['fecha_cobro_inicio'] = $fecha_cobro_inicio;
		$pagina['fecha_cobro_termino'] = $fecha_cobro_termino;
		$pagina['fecha_eval_inicio'] = $fecha_eval_inicio;
		$pagina['fecha_eval_termino'] = $fecha_eval_termino;
		$pagina['radio_f_evaluacion'] = $radio_f_evaluacion;
		$pagina['radio_f_cobro'] = $radio_f_cobro;
		$pagina['id_centro_costo'] = $id_centro_costo;
		$pagina['estado_examen'] = $estado_examen;
		$pagina['centro_de_costos'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('trabajadores/base_datos_evaluaciones_ccosto',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function base_datos_evaluaciones_propios_sin_ccosto(){
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Evaluaciones_model');

		if (!empty($_POST['centro_costo'])){
			$id_centro_costo = $_POST['centro_costo'];
			$get_planta = $this->Empresa_planta_model->get($id_centro_costo);
			$planta = isset($get_planta->nombre)?$get_planta->nombre:"";

			if($id_centro_costo == "todos")
				$planta = "Todos los centro de costos";
		}else{
			$id_centro_costo = NULL;
			$planta = "";
		}

		if (!empty($_POST['estado_examen'])){
			$estado_examen = $_POST['estado_examen'];
		}else{
			$estado_examen = NULL;
		}

		if (!empty($_POST['radio_f_cobro'])){
			$radio_f_cobro = $_POST['radio_f_cobro'];
			
			if (!empty($_POST['fecha_cobro_inicio']))
				$fecha_cobro_inicio = $_POST['fecha_cobro_inicio'];
			else
				$fecha_cobro_inicio = NULL;

			if (!empty($_POST['fecha_cobro_termino']))
				$fecha_cobro_termino = $_POST['fecha_cobro_termino'];
			else
				$fecha_cobro_termino = NULL;
		}else{
			$radio_f_cobro = NULL;
			$fecha_cobro_inicio = NULL;
			$fecha_cobro_termino = NULL;
		}

		if (!empty($_POST['radio_f_evaluacion'])){
			$radio_f_evaluacion = $_POST['radio_f_evaluacion'];
			
			if (!empty($_POST['fecha_eval_inicio']))
				$fecha_eval_inicio = $_POST['fecha_eval_inicio'];
			else
				$fecha_eval_inicio = NULL;

			if (!empty($_POST['fecha_eval_termino']))
				$fecha_eval_termino = $_POST['fecha_eval_termino'];
			else
				$fecha_eval_termino = NULL;

		}else{
			$radio_f_evaluacion = NULL;
			$fecha_eval_inicio = NULL;
			$fecha_eval_termino = NULL;
		}

		if (!empty($_POST['tipo_examen'])){
			if($_POST['tipo_examen'] == 'eval_masso')
				$eval_masso = 'eval_masso';
			else
				$eval_masso = NULL;

			if($_POST['tipo_examen'] == 'eval_preocupacional')
				$eval_preocupacional = 'eval_preocupacional';
			else
				$eval_preocupacional = NULL;

			if($_POST['tipo_examen'] == 'eval_psicologico')
				$eval_psicologico = 'eval_psicologico';
			else
				$eval_psicologico = NULL;

		}else{
			$eval_masso = NULL;
			$eval_preocupacional = NULL;
			$eval_psicologico = NULL;
		}

		$base = array(
			'head_titulo' => "Reportabilidad Trabajadores ".$planta,
			'titulo' => "Empresas: Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: '.$planta,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Reportabilidad Base de Datos Excel')),
			'side_bar' => false,
			'js' => array('js/si_validaciones.js','js/si_datepicker_evaluaciones_cc.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/si_exportar_excel_jquery.js', 'plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$get_id_planta = $id_centro_costo;
		$get_estado_examen = $estado_examen;
		$get_radio_fecha_eval = $radio_f_evaluacion;
		$get_fecha_inicio = $fecha_eval_inicio;
		$get_fecha_termino = $fecha_eval_termino;
		$get_radio_fecha_cobro = $radio_f_cobro;
		$get_fecha_cobro_inicio = $fecha_cobro_inicio;
		$get_fecha_cobro_termino = $fecha_cobro_termino;
		$get_eval_masso = $eval_masso;
		$get_eval_preo = $eval_preocupacional;
		$get_eval_psico = $eval_psicologico;

		if (!empty($get_id_planta)){
			if($get_eval_masso != NULL)
				$trabajadores_eval_masso = $this->Evaluaciones_model->listar_trabajadores_cc_planta_segun_eval($get_id_planta, 4, $get_estado_examen);
			else
				$trabajadores_eval_masso = array();

			if($get_eval_preo != NULL)
				$trabajadores_eval_preocu = $this->Evaluaciones_model->listar_trabajadores_cc_planta_segun_eval($get_id_planta, 3, $get_estado_examen);
			else
				$trabajadores_eval_preocu = array();

			$get_trabajadores = array_merge($trabajadores_eval_masso, $trabajadores_eval_preocu);
			$trabajadores = array_map("unserialize", array_unique(array_map("serialize", $get_trabajadores)));

			$listado = array();
			foreach($trabajadores as $rm){
				$aux = new stdClass();
				$cumple_examenes = 0;//si el trabajador tiene algun examen que cumple con el filtro
				$aux->id_usuario = $rm->usuario_id;
				$get_usu = $this->Usuarios_model->get($rm->usuario_id);
				$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
				$aux->nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
				$aux->paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
				$aux->materno = (isset($get_usu->materno)?$get_usu->materno:"");

				if($get_eval_masso != NULL)
					$masso = $this->Evaluaciones_model->get_all_masso2($rm->usuario_id, $id_centro_costo, $get_estado_examen);
				else
					$masso = array();

				$aux->datos_masso = array();
				if (!empty($masso)){
					foreach ($masso as $dd){
						$archivo1 = new StdClass();
						$get_ccosto = $this->Empresa_planta_model->get($dd->ccosto);
						$archivo1->id_eval = $dd->id;
						$archivo1->fecha_e = $dd->fecha_e;
						$archivo1->fecha_v = $dd->fecha_v;
						$archivo1->valor_examen = $dd->valor_examen;
						$archivo1->estado_cobro = $dd->estado_cobro;
						$archivo1->fecha_cobro = $dd->fecha_cobro;
						$archivo1->examen_referido = $dd->examen_referido;
						$archivo1->asiste_examen = $dd->asistencia_examen;
						$archivo1->pago = $dd->pago;
						$archivo1->ccosto = isset($get_ccosto->nombre)?$get_ccosto->nombre:"";
						
						if($get_radio_fecha_eval == "todos"){
							$si_cumple_eval = 1;
						}elseif($get_radio_fecha_eval == "rango_fecha"){
							if($dd->fecha_e > $get_fecha_inicio and $dd->fecha_e < $get_fecha_termino)
								$si_cumple_eval = 1;
							else
								$si_cumple_eval = 0;
						}

						if($get_radio_fecha_cobro == "todos"){
							$si_cumple_cobro = 1;
						}elseif($get_radio_fecha_cobro == "rango_fecha"){
							if($dd->fecha_cobro > $get_fecha_cobro_inicio and $dd->fecha_cobro < $get_fecha_cobro_termino)
								$si_cumple_cobro = 1;
							else
								$si_cumple_cobro = 0;
						}

						if($si_cumple_eval == 1 and $si_cumple_cobro == 1){
							$cumple_examen = 1;
							$cumple_examenes += 1;
						}else{
							$cumple_examen = 0;
						}

						if($cumple_examen == 1){
							array_push($aux->datos_masso, $archivo1);
							unset($archivo1);
						}
					}
				}

				if($get_eval_preo != NULL)
					$examen_pre = $this->Evaluaciones_model->get_all_preo2($rm->usuario_id, $id_centro_costo, $get_estado_examen);
				else
					$examen_pre = array();
				
				$aux->datos_preo = array();
				if (!empty($examen_pre)){
					foreach ($examen_pre as $dx){
						$archivo2 = new StdClass();
						$get_ccosto = $this->Empresa_planta_model->get($dx->ccosto);
						$archivo2->id_eval = $dx->id;
						$archivo2->fecha_e = $dx->fecha_e;
						$archivo2->fecha_v = $dx->fecha_v;
						$archivo2->valor_examen = $dx->valor_examen;
						$archivo2->estado_cobro = $dx->estado_cobro;
						$archivo2->fecha_cobro = $dx->fecha_cobro;
						$archivo2->examen_referido = $dx->examen_referido;
						$archivo2->asiste_examen = $dx->asistencia_examen;
						$archivo2->pago = $dx->pago;
						$archivo2->ccosto = isset($get_ccosto->nombre)?$get_ccosto->nombre:"";

						if($get_radio_fecha_eval == "todos"){
							$si_cumple_eval = 1;
						}elseif($get_radio_fecha_eval == "rango_fecha"){
							if($dx->fecha_e > $get_fecha_inicio and $dx->fecha_e < $get_fecha_termino)
								$si_cumple_eval = 1;
							else
								$si_cumple_eval = 0;
						}

						if($get_radio_fecha_cobro == "todos"){
							$si_cumple_cobro = 1;
						}elseif($get_radio_fecha_cobro == "rango_fecha"){
							if($dx->fecha_cobro > $get_fecha_cobro_inicio and $dx->fecha_cobro < $get_fecha_cobro_termino)
								$si_cumple_cobro = 1;
							else
								$si_cumple_cobro = 0;
						}

						if($si_cumple_eval == 1 and $si_cumple_cobro == 1){
							$cumple_examen = 1;
							$cumple_examenes += 1;
						}else{
							$cumple_examen = 0;
						}

						if($cumple_examen == 1){
							array_push($aux->datos_preo, $archivo2);
							unset($archivo2);
						}
					}
				}

				if($cumple_examenes >= 1){
					array_push($listado, $aux);
					unset($aux);
				}
			}
			$pagina['listado'] = $listado;
			$pagina['id_planta'] = $id_centro_costo;
			$pagina['empresa_planta'] = $planta;
		}else{
			$pagina['listado'] = array();
			$pagina['id_planta'] = "";
			$pagina['empresa_planta'] = "";
		}

		$pagina['eval_masso'] = $eval_masso;
		$pagina['eval_preocupacional'] = $eval_preocupacional;
		$pagina['fecha_cobro_inicio'] = $fecha_cobro_inicio;
		$pagina['fecha_cobro_termino'] = $fecha_cobro_termino;
		$pagina['fecha_eval_inicio'] = $fecha_eval_inicio;
		$pagina['fecha_eval_termino'] = $fecha_eval_termino;
		$pagina['radio_f_evaluacion'] = $radio_f_evaluacion;
		$pagina['radio_f_cobro'] = $radio_f_cobro;
		$pagina['id_centro_costo'] = $id_centro_costo;
		$pagina['estado_examen'] = $estado_examen;
		$pagina['centro_de_costos'] = $this->Empresa_planta_model->listar();
		$base['cuerpo'] = $this->load->view('trabajadores/base_datos_evaluaciones_propios_sin_ccosto',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	###### agregar mantenedor de preguntas 


	function contratos_y_anexos(){
		$this->load->model('Requerimientos_model');
		$base = array(
			'head_titulo' => "EST - Contratos y Anexos de Todas las Plantas",
			'titulo' => "Empresas: Arauco S.A.",
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Contratos y Anexos')),
			'side_bar' => true,
			'js' => array('js/si_exportar_excel_jquery.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js','plugins/bootstrap-daterangepicker/daterangepicker.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/datePickerParaContratosAnexos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);
		$fecha_hoy = date('Y-m-d');
		$listado = $this->Requerimientos_model->todos_los_contratos();
		$listadoOpcion = array();
		if (isset($_POST['vigencia'])) {
			$pagina['inptradio'] = $_POST['vigencia'];
		}

		if (isset($_POST['nombrePlantaSeleccionada'])) {

			$pagina['plantaSeleccionada']= $_POST['nombrePlantaSeleccionada'];
			if ($_POST['nombrePlantaSeleccionada'] == 'todasLasPlantas') {
				foreach ($listado as $key) {
					if (!empty($_POST['fecha_inicio']) && !empty($_POST['fecha_termino'])) {
						$fechaFiltroInicio  = $_POST['fecha_inicio'];
						$pagina['fechaFiltroInicio'] = $fechaFiltroInicio;
						$fechaFiltroTermino = $_POST['fecha_termino'];
						$pagina['fechaFiltroTermino'] = $fechaFiltroTermino;
						$obtengoLosAnexos = $this->Requerimientos_model->todos_los_anexos($key->usuario_id, $key->idRequerimientoAsociado);
						if (!empty($obtengoLosAnexos)) {//si tiene anexo
							$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
							$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
							$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
						}else{//si no tiene  anexo
							$url = isset($key->url)?$key->url:'';
							$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
							$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
						}
						if ($fecha_termino >= $fechaFiltroInicio && $fecha_termino <= $fechaFiltroTermino) {
							$aux = new stdClass();
								$aux->tipo_archivo = $tipo_archivo;
								$aux->usuario_id = $key->usuario_id;
								$aux->url = $url; // varia si tiene anexo
								$aux->causal = $key->causal;
								$aux->motivo = $key->motivo;
								$aux->fecha_inicio = $key->fecha_inicio;
								$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
								$aux->jornada = $key->jornada;
								$aux->renta_imponible = $key->renta_imponible;
								$aux->bono_responsabilidad = $key->bono_responsabilidad;
								$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
								$aux->asignacion_colacion = $key->asignacion_colacion;
								$aux->otros_no_imponibles = $key->otros_no_imponibles;
								$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
								$aux->nombre_usuario = $key->nombre_usuario;
								$aux->paterno = $key->paterno;
								$aux->materno = $key->materno;
								$aux->email = $key->email;
								$aux->rut_usuario = $key->rut_usuario;
								$aux->referido = $key->referido;
								$aux->codigo_requerimiento = $key->codigo_requerimiento;
								$aux->nombre_req = $key->nombre_req;
								$aux->f_solicitud = $key->f_solicitud;
								$aux->fecha_inicio_req = $key->fecha_inicio_req;
								$aux->f_fin_req = $key->f_fin_req;
								$aux->nombre_empresa = $key->nombre_empresa;
								$aux->nombre_area = $key->nombre_area;
								$aux->nombre_cargo = $key->nombre_cargo;
								array_push($listadoOpcion,$aux);
								unset($aux);
						}
						
					}
					if (isset($_POST['estado'])) {
						$pagina['estado'] = $_POST['estado'];

						if($_POST['estado'] =='vigente'){	
							$obtengoLosAnexos = $this->Requerimientos_model->todos_los_anexos($key->usuario_id, $key->idRequerimientoAsociado);
							if (!empty($obtengoLosAnexos)) {//si tiene anexo
								$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
								$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
								$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
							}else{//si no tiene  anexo
								$url = isset($key->url)?$key->url:'';
								$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
								$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
							}
							if ($fecha_termino >= $fecha_hoy) {
								$aux = new stdClass();
									$aux->tipo_archivo = $tipo_archivo;
									$aux->usuario_id = $key->usuario_id;
									$aux->url = $url; // varia si tiene anexo
									$aux->causal = $key->causal;
									$aux->motivo = $key->motivo;
									$aux->fecha_inicio = $key->fecha_inicio;
									$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
									$aux->jornada = $key->jornada;
									$aux->renta_imponible = $key->renta_imponible;
									$aux->bono_responsabilidad = $key->bono_responsabilidad;
									$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
									$aux->asignacion_colacion = $key->asignacion_colacion;
									$aux->otros_no_imponibles = $key->otros_no_imponibles;
									$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
									$aux->nombre_usuario = $key->nombre_usuario;
									$aux->paterno = $key->paterno;
									$aux->materno = $key->materno;
									$aux->email = $key->email;
									$aux->rut_usuario = $key->rut_usuario;
									$aux->referido = $key->referido;
									$aux->codigo_requerimiento = $key->codigo_requerimiento;
									$aux->nombre_req = $key->nombre_req;
									$aux->f_solicitud = $key->f_solicitud;
									$aux->fecha_inicio_req = $key->fecha_inicio_req;
									$aux->f_fin_req = $key->f_fin_req;
									$aux->nombre_empresa = $key->nombre_empresa;
									$aux->nombre_area = $key->nombre_area;
									$aux->nombre_cargo = $key->nombre_cargo;
									array_push($listadoOpcion,$aux);
									unset($aux);
							}
						}

						if($_POST['estado'] =='no_vigente'){
							$obtengoLosAnexos = $this->Requerimientos_model->todos_los_anexos($key->usuario_id,  $key->idRequerimientoAsociado);
							if (!empty($obtengoLosAnexos)) {//si tiene anexo
									$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
									$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
									$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
							}else{//si no tiene  anexo
									$url = isset($key->url)?$key->url:'';
									$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
									$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
							}
							if ($fecha_termino < $fecha_hoy) { // NO VIGENTE Fecha termino contrato inferior a la fecha actual
								$aux = new stdClass();
									$aux->tipo_archivo = $tipo_archivo;
									$aux->usuario_id = $key->usuario_id;
									$aux->url = $url; // varia si tiene anexo
									$aux->causal = $key->causal;
									$aux->motivo = $key->motivo;
									$aux->fecha_inicio = $key->fecha_inicio;
									$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
									$aux->jornada = $key->jornada;
									$aux->renta_imponible = $key->renta_imponible;
									$aux->bono_responsabilidad = $key->bono_responsabilidad;
									$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
									$aux->asignacion_colacion = $key->asignacion_colacion;
									$aux->otros_no_imponibles = $key->otros_no_imponibles;
									$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
									$aux->nombre_usuario = $key->nombre_usuario;
									$aux->paterno = $key->paterno;
									$aux->materno = $key->materno;
									$aux->email = $key->email;
									$aux->rut_usuario = $key->rut_usuario;
									$aux->referido = $key->referido;
									$aux->codigo_requerimiento = $key->codigo_requerimiento;
									$aux->nombre_req = $key->nombre_req;
									$aux->f_solicitud = $key->f_solicitud;
									$aux->fecha_inicio_req = $key->fecha_inicio_req;
									$aux->f_fin_req = $key->f_fin_req;
									$aux->nombre_empresa = $key->nombre_empresa;
									$aux->nombre_area = $key->nombre_area;
									$aux->nombre_cargo = $key->nombre_cargo;
									array_push($listadoOpcion,$aux);
									unset($aux);
							}	
						}
					}

				}
			}else{

				$nombrePlantaSeleccionada = $_POST['nombrePlantaSeleccionada']; //faena ?
				foreach ($listado as $key ) {
					if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_termino'])) {
							$fechaFiltroInicio  = $_POST['fecha_inicio'];
						if (!empty($_POST['fecha_inicio'])) {
									$pagina['fechaFiltroInicio'] = $fechaFiltroInicio;
						}
						
			
						$fechaFiltroTermino = $_POST['fecha_termino'];
						$pagina['fechaFiltroTermino'] = $fechaFiltroTermino;
						if ($key->nombre_empresa == $nombrePlantaSeleccionada ) { // aqui muestro solo los de la planta seleccionada
							$obtengoLosAnexos = $this->Requerimientos_model->todos_los_anexos($key->usuario_id,  $key->idRequerimientoAsociado);
							if (!empty($obtengoLosAnexos)) {//si tiene anexo
								$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
								$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
								$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
							}else{//si no tiene  anexo
								$url = isset($key->url)?$key->url:'';
								$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
								$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
							}
							if ($fecha_termino >= $fechaFiltroInicio && $fecha_termino <= $fechaFiltroTermino) {
								$aux = new stdClass();
									$aux->tipo_archivo = $tipo_archivo;
									$aux->usuario_id = $key->usuario_id;
									$aux->url = $url; // varia si tiene anexo
									$aux->causal = $key->causal;
									$aux->motivo = $key->motivo;
									$aux->fecha_inicio = $key->fecha_inicio;
									$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
									$aux->jornada = $key->jornada;
									$aux->renta_imponible = $key->renta_imponible;
									$aux->bono_responsabilidad = $key->bono_responsabilidad;
									$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
									$aux->asignacion_colacion = $key->asignacion_colacion;
									$aux->otros_no_imponibles = $key->otros_no_imponibles;
									$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
									$aux->nombre_usuario = $key->nombre_usuario;
									$aux->paterno = $key->paterno;
									$aux->materno = $key->materno;
									$aux->email = $key->email;
									$aux->rut_usuario = $key->rut_usuario;
									$aux->referido = $key->referido;
									$aux->codigo_requerimiento = $key->codigo_requerimiento;
									$aux->nombre_req = $key->nombre_req;
									$aux->f_solicitud = $key->f_solicitud;
									$aux->fecha_inicio_req = $key->fecha_inicio_req;
									$aux->f_fin_req = $key->f_fin_req;
									$aux->nombre_empresa = $key->nombre_empresa;
									$aux->nombre_area = $key->nombre_area;
									$aux->nombre_cargo = $key->nombre_cargo;
									array_push($listadoOpcion,$aux);
									unset($aux);
							}
						}
					}
					if (isset($_POST['estado'])) {
						$pagina['estado'] = $_POST['estado'];
						if($_POST['estado'] =='vigente'){	
							if ($key->nombre_empresa == $nombrePlantaSeleccionada ) { // aqui muestro solo los de la planta seleccionada
								$obtengoLosAnexos = $this->Requerimientos_model->todos_los_anexos($key->usuario_id,  $key->idRequerimientoAsociado);
								if (!empty($obtengoLosAnexos)) {//si tiene anexo
									$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
									$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
									$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
								}else{//si no tiene  anexo
									$url = isset($key->url)?$key->url:'';
									$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
									$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
								}
								if ($fecha_termino >= $fecha_hoy) { // VIGENTE Fecha termino contrato Superior a la fecha actual
									$aux = new stdClass();
										$aux->tipo_archivo = $tipo_archivo;
										$aux->usuario_id = $key->usuario_id;
										$aux->url = $url; // varia si tiene anexo
										$aux->causal = $key->causal;
										$aux->motivo = $key->motivo;
										$aux->fecha_inicio = $key->fecha_inicio;
										$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
										$aux->jornada = $key->jornada;
										$aux->renta_imponible = $key->renta_imponible;
										$aux->bono_responsabilidad = $key->bono_responsabilidad;
										$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
										$aux->asignacion_colacion = $key->asignacion_colacion;
										$aux->otros_no_imponibles = $key->otros_no_imponibles;
										$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
										$aux->nombre_usuario = $key->nombre_usuario;
										$aux->paterno = $key->paterno;
										$aux->materno = $key->materno;
										$aux->email = $key->email;
										$aux->rut_usuario = $key->rut_usuario;
										$aux->referido = $key->referido;
										$aux->codigo_requerimiento = $key->codigo_requerimiento;
										$aux->nombre_req = $key->nombre_req;
										$aux->f_solicitud = $key->f_solicitud;
										$aux->fecha_inicio_req = $key->fecha_inicio_req;
										$aux->f_fin_req = $key->f_fin_req;
										$aux->nombre_empresa = $key->nombre_empresa;
										$aux->nombre_area = $key->nombre_area;
										$aux->nombre_cargo = $key->nombre_cargo;
										array_push($listadoOpcion,$aux);
										unset($aux);
								}
							}
						}
				
						if($_POST['estado'] =='no_vigente'){
							if ($key->nombre_empresa ==  $nombrePlantaSeleccionada) {
								$obtengoLosAnexos = $this->Requerimientos_model->todos_los_anexos($key->usuario_id, $key->idRequerimientoAsociado);
								if (!empty($obtengoLosAnexos)) {//si tiene anexo
										$url = isset($obtengoLosAnexos->url)?$obtengoLosAnexos->url:'';
										$fecha_termino = isset($obtengoLosAnexos->fecha_termino)?$obtengoLosAnexos->fecha_termino:'';
										$tipo_archivo = isset($obtengoLosAnexos->tipo_archivo_requerimiento_id)?$obtengoLosAnexos->tipo_archivo_requerimiento_id:'';
								}else{//si no tiene  anexo
										$url = isset($key->url)?$key->url:'';
										$fecha_termino = isset($key->fecha_termino)?$key->fecha_termino:'';
										$tipo_archivo = isset($key->tipo_archivo)?$key->tipo_archivo:'';
								}
								if ($fecha_termino < $fecha_hoy) { // NO VIGENTE Fecha termino contrato inferior a la fecha actual
									$aux = new stdClass();
										$aux->tipo_archivo = $tipo_archivo;
										$aux->usuario_id = $key->usuario_id;
										$aux->url = $url; // varia si tiene anexo
										$aux->causal = $key->causal;
										$aux->motivo = $key->motivo;
										$aux->fecha_inicio = $key->fecha_inicio;
										$aux->fecha_termino = $fecha_termino; // varia si tiene anexo
										$aux->jornada = $key->jornada;
										$aux->renta_imponible = $key->renta_imponible;
										$aux->bono_responsabilidad = $key->bono_responsabilidad;
										$aux->sueldo_base_mas_bonos_fijos = $key->sueldo_base_mas_bonos_fijos;
										$aux->asignacion_colacion = $key->asignacion_colacion;
										$aux->otros_no_imponibles = $key->otros_no_imponibles;
										$aux->seguro_vida_arauco = $key->seguro_vida_arauco;
										$aux->nombre_usuario = $key->nombre_usuario;
										$aux->paterno = $key->paterno;
										$aux->materno = $key->materno;
										$aux->email = $key->email;
										$aux->rut_usuario = $key->rut_usuario;
										$aux->referido = $key->referido;
										$aux->codigo_requerimiento = $key->codigo_requerimiento;
										$aux->nombre_req = $key->nombre_req;
										$aux->f_solicitud = $key->f_solicitud;
										$aux->fecha_inicio_req = $key->fecha_inicio_req;
										$aux->f_fin_req = $key->f_fin_req;
										$aux->nombre_empresa = $key->nombre_empresa;
										$aux->nombre_area = $key->nombre_area;
										$aux->nombre_cargo = $key->nombre_cargo;
										array_push($listadoOpcion,$aux);
										unset($aux);
								}
							}
						}
					}//Fin de si seleccione vigente o no vigente;
				}
			}
		}

		$pagina['plantas']= $this->Requerimientos_model->getFaenas();
		$pagina['listado']= $listadoOpcion;	
		$base['cuerpo'] = $this->load->view('trabajadores/base_datos_contratos_y_anexos',$pagina,TRUE);
	 	$this->load->view('layout2.0/layout',$base);
	}


	function editar_estado_examen($id_eval, $id_planta){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Usuarios_model");

		$listado = array();
		foreach($this->Evaluaciones_model->get_evaluacion_result($id_eval) as $r){
			$get_usu = $this->Usuarios_model->get($r->id_usuarios);
			$get_ccosto = $this->Empresa_planta_model->get($id_planta);
			
			$aux = new stdClass();
			$nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
			$ap_paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
			$ap_materno = (isset($get_usu->materno)?$get_usu->materno:"");
			$aux->id_eval = $r->id;
			$aux->nombres = $nombres." ".$ap_paterno." ".$ap_materno;
			$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
			$aux->fecha_e = (isset($r->fecha_e)?$r->fecha_e:"");
			$aux->fecha_v = (isset($r->fecha_v)?$r->fecha_v:"");
			$aux->observaciones = (isset($r->observaciones)?$r->observaciones:"");
			$aux->valor_examen = (isset($r->valor_examen)?$r->valor_examen:"");
			$aux->estado_cobro = (isset($r->estado_cobro)?$r->estado_cobro:"0");
			$aux->id_tipo_evaluacion = (isset($r->id_evaluacion)?$r->id_evaluacion:"");
			$aux->comentario_pago = (isset($r->comentario_pago)?$r->comentario_pago:"");
			$aux->ccosto = (isset($get_ccosto->nombre)?$get_ccosto->nombre:"NULL");

			$fecha_cobro = $r->fecha_cobro;
			$f = explode("-", $fecha_cobro);
			$aux->ano_c = $f[0];
			$aux->mes_c = $f[1];
			$aux->dia_c = $f[2];
			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$pagina['id_planta'] = $id_planta;
		$this->load->view('trabajadores/modal_editar_datos_estado_examen', $pagina);
	}

	function editar_estado_examen_ccosto($id_eval, $id_planta){
		$this->load->model("Evaluaciones_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Usuarios_model");

		$listado = array();
		foreach($this->Evaluaciones_model->get_evaluacion_result($id_eval) as $r){
			$get_usu = $this->Usuarios_model->get($r->id_usuarios);
			$get_ccosto = $this->Empresa_planta_model->get($r->ccosto);
			
			$aux = new stdClass();
			$nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
			$ap_paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
			$ap_materno = (isset($get_usu->materno)?$get_usu->materno:"");
			$aux->id_eval = $r->id;
			$aux->nombres = $nombres." ".$ap_paterno." ".$ap_materno;
			$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
			$aux->fecha_e = (isset($r->fecha_e)?$r->fecha_e:"");
			$aux->fecha_v = (isset($r->fecha_v)?$r->fecha_v:"");
			$aux->observaciones = (isset($r->observaciones)?$r->observaciones:"");
			$aux->valor_examen = (isset($r->valor_examen)?$r->valor_examen:"");
			$aux->estado_cobro = (isset($r->estado_cobro)?$r->estado_cobro:"0");
			$aux->id_tipo_evaluacion = (isset($r->id_evaluacion)?$r->id_evaluacion:"");
			$aux->comentario_pago = (isset($r->comentario_pago)?$r->comentario_pago:"");
			$aux->ccosto = (isset($get_ccosto->nombre)?$get_ccosto->nombre:"NULL");

			$fecha_cobro = $r->fecha_cobro;
			$f = explode("-", $fecha_cobro);
			$aux->ano_c = $f[0];
			$aux->mes_c = $f[1];
			$aux->dia_c = $f[2];
			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$pagina['id_planta'] = $id_planta;
		if( $this->session->userdata('tipo_usuario') == 6)
			$this->load->view('trabajadores/modal_editar_datos_estado_examen', $pagina);
		else
			$this->load->view('trabajadores/modal_mostrar_datos_estado_examen', $pagina);
	}

	function mostrar_estado_examen_ps_ccosto($id_eval, $id_planta){
		$this->load->model("Examenes_psicologicos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Usuarios_model");

		$listado = array();
		foreach($this->Examenes_psicologicos_model->get_result($id_eval) as $r){
			$get_usu = $this->Usuarios_model->get($r->usuario_id);
			$get_ccosto = $this->Empresa_planta_model->get($id_planta);

			if($r->tecnico_supervisor == 1)
				$tecnico_supervisor = "Tecnico";
			elseif($r->tecnico_supervisor == 2)
				$tecnico_supervisor = "Supervisor";
			else
				$tecnico_supervisor = "";
			
			$aux = new stdClass();
			$nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
			$ap_paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
			$ap_materno = (isset($get_usu->materno)?$get_usu->materno:"");

			$aux->id_eval = $r->id;
			$aux->nombres = $nombres." ".$ap_paterno." ".$ap_materno;
			$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
			$aux->fecha_e = (isset($r->fecha_evaluacion)?$r->fecha_evaluacion:"");
			$aux->tecnico_supervisor = $tecnico_supervisor;
			$aux->observaciones = (isset($r->observaciones)?$r->observaciones:"");	
			$aux->ccosto = (isset($get_ccosto->nombre)?$get_ccosto->nombre:"NULL");
			$aux->estado_cobro = $r->estado_cobro;
			$aux->fecha_cobro = $r->fecha_cobro;
			$aux->valor_examen = $r->valor_examen;
			$aux->comentario_cobro = $r->comentario_cobro;
			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$pagina['id_planta'] = $id_planta;
		if( $this->session->userdata('tipo_usuario') == 6)
			$this->load->view('trabajadores/modal_editar_datos_estado_examen_ps', $pagina);
		else
			$this->load->view('trabajadores/modal_mostrar_datos_estado_examen_ps', $pagina);
	}

	function editar_estado_examen_ps_ccosto($id_eval, $id_planta){
		$this->load->model("Examenes_psicologicos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("Usuarios_model");

		$listado = array();
		foreach($this->Examenes_psicologicos_model->get_result($id_eval) as $r){
			$get_usu = $this->Usuarios_model->get($r->usuario_id);
			$get_ccosto = $this->Empresa_planta_model->get($id_planta);

			if($r->tecnico_supervisor == 1)
				$tecnico_supervisor = "Tecnico";
			elseif($r->tecnico_supervisor == 2)
				$tecnico_supervisor = "Supervisor";
			else
				$tecnico_supervisor = "";
			
			$aux = new stdClass();
			$nombres = (isset($get_usu->nombres)?$get_usu->nombres:"");
			$ap_paterno = (isset($get_usu->paterno)?$get_usu->paterno:"");
			$ap_materno = (isset($get_usu->materno)?$get_usu->materno:"");

			$aux->id_eval = $r->id;
			$aux->nombres = $nombres." ".$ap_paterno." ".$ap_materno;
			$aux->rut_usuario = (isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"");
			$aux->fecha_e = (isset($r->fecha_evaluacion)?$r->fecha_evaluacion:"");
			$aux->tecnico_supervisor = $tecnico_supervisor;
			$aux->observaciones = (isset($r->observaciones)?$r->observaciones:"");	
			$aux->ccosto = (isset($get_ccosto->nombre)?$get_ccosto->nombre:"NULL");
			$aux->estado_cobro = $r->estado_cobro;
			$aux->valor_examen = $r->valor_examen;
			$aux->comentario_cobro = $r->comentario_cobro;

			$fecha_cobro = $r->fecha_cobro;
			$f = explode("-", $fecha_cobro);
			$aux->ano_c = $f[0];
			$aux->mes_c = $f[1];
			$aux->dia_c = $f[2];

			array_push($listado,$aux);
		}
		$pagina['listado'] = $listado;
		$pagina['id_planta'] = $id_planta;
		$this->load->view('trabajadores/modal_editar_datos_estado_examen_ps', $pagina);
	}

	function actualizar_datos_estado_examen(){
		$this->load->model('Evaluaciones_model');
		$id_planta = $_POST['id_planta'];
		$id_eval = $_POST['id_eval'];
		$dia_c = $_POST['dia_cobro'];
		$mes_c = $_POST['mes_cobro'];
		$ano_c = $_POST['ano_cobro'];

		$fecha_cobro = $ano_c."-".$mes_c."-".$dia_c;

		$datos = array(
			'estado_cobro' => $_POST['select_cobro'],
			'fecha_cobro' => $fecha_cobro,
			'comentario_pago' => $_POST['comentario_pago'],
		);
		$this->Evaluaciones_model->editar($id_eval, $datos);
		echo "<script>alert('Examen Actualizado Exitosamente')</script>";
		redirect('est/trabajadores/base_datos_evaluaciones_ccosto', 'refresh');
	}

	function actualizar_datos_estado_examen_ps(){
		$this->load->model('Examenes_psicologicos_model');
		$id_planta = $_POST['id_planta'];
		$id_eval = $_POST['id_eval'];
		$dia_c = $_POST['dia_cobro'];
		$mes_c = $_POST['mes_cobro'];
		$ano_c = $_POST['ano_cobro'];

		$fecha_cobro = $ano_c."-".$mes_c."-".$dia_c;

		$datos = array(
			'valor_examen' => $_POST['valor_examen'],
			'estado_cobro' => $_POST['select_cobro'],
			'fecha_cobro' => $fecha_cobro,
			'comentario_cobro' => $_POST['comentario_pago']
		);
		$this->Examenes_psicologicos_model->actualizar($id_eval, $datos);
		echo "<script>alert('Estado Examen Psicologico Actualizado Exitosamente')</script>";
		redirect('est/trabajadores/base_datos_evaluaciones_ccosto', 'refresh');
	}

	function agregar($msg = FALSE) {
		$this->load->model('Region_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Afp_model');
		$this->load->model('Bancos_model');
		$this->load->model('Salud_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');	

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url'=>'administracion/trabajadores','txt' => 'Trabajadores'), array('url'=>'','txt'=>'Agregar' )),
			'js' => array('plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js','js/form-wizard.js'),
			'menu' => $this->menu
		);
		
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Algunos datos estan vacios, favor enviar nuevamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_pass"){
			$aviso['titulo'] = "Las contraseñas no coinciden,favor corregir";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_rut"){
			$aviso['titulo'] = "El rut existe en nuestros sistemas";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_email_valid"){
			$aviso['titulo'] = "El email ingresado es invalido";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "El usuario a sido guardado exitosamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		$pagina['listado_regiones'] = $this->Region_model->listar();
		$pagina['listado_civil'] = $this->Estadocivil_model->listar();
		$pagina['listado_afp'] = $this->Afp_model->listar();
		$pagina['listado_bancos'] = $this->Bancos_model->listar();
		$pagina['listado_salud'] = $this->Salud_model->listar();
		$pagina['listado_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['listado_profesiones'] = $this->Profesiones_model->listar();
		$pagina['listado_especialidades'] = $this->Especialidadtrabajador_model->listar();
		$pagina['texto_anterior'] = $this->session->flashdata('ingreso');
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$base['cuerpo'] = $this->load->view('trabajadores/agregar2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	
	function provincia($id_region){
		$this->load->model('Provincia_model');
		if(isset($id_region)){
			foreach ($this->Provincia_model->listar_region($id_region) as $prov ){
				echo "<option value=".$prov->id.">".$prov->desc_provincias."</option>";
			}
		}
	}
	
	function ciudad($id_region){
		$this->load->model('Ciudad_model');
		if(isset($id_region)){
			foreach ($this->Ciudad_model->listar_region($id_region) as $ciu ){
				echo "<option value=".$ciu->id.">".$ciu->desc_ciudades."</option>";
			}
		}
	}
	
	function subir_archivo() {
		$base['titulo'] = "Subir archivo de trabajadores";
		$base['lugar'] = "Agregar Trabajador";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/subir',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function buscar() {
		$this->load->library('encrypt');
		$this->load->library('pagination');

		if(isset($_POST['head_buscar']))
			redirect('/est/trabajadores/buscar/filtro/'.$_POST['head_buscar'].'/pagina/', 'refresh');

		$filtro = FALSE;

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url'=>'administracion/trabajadores','txt' => 'Trabajadores'), array('url'=>'','txt'=>'Listado' )),
			'menu' => $this->menu,
			'js' => array('js/table-data.js','js/ui-subview.js','plugins/select2/select2.min.js','js/listado_trabajadores.js'),
			'css' => array('plugins/select2/select2.css'),
			'head_buscar' => array('method' => 'post', 'url' => base_url().'est/trabajadores/buscar')
		);
		
		$this->load->model("Usuarios2_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Listanegra_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");

		if($this->uri->segment(4) === FALSE){
			$pag_actual = 0;
			$config['uri_segment'] = 4;
			$config['base_url'] = base_url().'/administracion/trabajadores/buscar/pagina/';
			$asociacion[0]['nombre'] = FALSE;
			$asociacion[0]['rut'] = FALSE;
			$asociacion[0]['profesion'] = FALSE;
			$asociacion[0]['especialidad'] = FALSE;
			$asociacion[0]['ciudad'] = FALSE;
			$asociacion[0]['clave'] = FALSE;
		}
		else{
			$asc = $this->uri->uri_to_assoc(4);

			if($this->uri->uri_to_assoc(4) == 'pagina'){
				$config['uri_segment'] = 5;
				$config['base_url'] = base_url().'/administracion/trabajadores/buscar/pagina/';
				$filtro = FALSE;
				$pag_actual = $this->uri->segment(5);
			}
			else{//si existe el filtro entonces........
				$config['uri_segment'] = 7;
				$config['base_url'] = base_url().'/administracion/trabajadores/buscar/filtro/'.$this->uri->segment(5).'/pagina/';
				$filtro = $this->uri->segment(5);
				$pag_actual = $this->uri->segment(7);
			}
		}
		
		$config['per_page'] = 100;
		$config['total_rows'] = $this->Usuarios2_model->total_filtro($filtro,FALSE );
		$config['full_tag_open'] = "<div class='dataTables_paginate paging_full_numbers'>";
		$config['full_tag_close'] = '</div>';
		$config['next_link'] = 'Siguiente';
		$config['next_tag_open'] = '<span class="next paginate_button">';
		$config['next_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span class="paginate_button">';
		$config['num_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<span class="paginate_active">';
		$config['cur_tag_close'] = '</span>';
		$config['last_link'] = 'Ultimo';
		$config['last_tag_open'] = '<span class="next paginate_button">';
		$config['last_tag_close'] = '</span>';
		$config['first_link'] = 'Primero';
		$config['first_tag_open'] = '<span class="previous paginate_button">';
		$config['first_tag_close'] = '</span>';
		$config['prev_link'] = 'Anterior';
		$config['prev_tag_open'] = '<span class="previous paginate_button">';
		$config['prev_tag_close'] = '</span>';
		$this->pagination->initialize($config);
		
		$pagina['paginado']	= $this->pagination->create_links();

		$listado = array();
		foreach($this->Usuarios2_model->listar_filtro($filtro,FALSE,$config['per_page'],$pag_actual) as $l ){
			$aux = new stdClass();
			$l->id = $l->id_user;
			$m = $this->Evaluaciones_model->get_una_masso($l->id);
			$p = $this->Evaluaciones_model->get_una_preocupacional($l->id);
			$n = $this->Listanegra_model->listar_trabajador($l->id);
			$c = $this->Ciudad_model->get($l->id_ciudades);
			if ($l->id_especialidad_trabajador){
				$e1 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador);
				$aux->especilidad1 = ($e1->desc_especialidad)? ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')) : FALSE;	
			}
			else
				$aux->especilidad1 = false;

			if ($l->id_especialidad_trabajador_2){
				$e2 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_2);
				$aux->especilidad2 = (!empty($e2->desc_especialidad))? ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')) : FALSE;
			}
			else
				$aux->especilidad2 = false;

			if ($l->id_especialidad_trabajador_3){
				$e3 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_3);
				$aux->especilidad3 =  (!empty($e3->desc_especialidad))? $e3->desc_especialidad : FALSE;
			}
			else
				$aux->especilidad3 = false;

			$aux->id_user = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->fono = $l->fono;
			if (isset($l->fecha_nac)){
				$fa = explode('-',$l->fecha_nac);
				$aux->fecha_nacimiento = $fa[2].'/'.$fa[1].'/'.$fa[0];
			}
			else $aux->fecha_nacimiento = '00/00/0000';

			$aux->afp = $this->Archivos_trab_model->get_archivo($l->id,11);
			$aux->salud = $this->Archivos_trab_model->get_archivo($l->id,12);
			$aux->estudios = $this->Archivos_trab_model->get_archivo($l->id,9);
			$aux->cv = $this->Archivos_trab_model->get_archivo($l->id,13);

			$aux->desc_ciudades = (!empty($c->desc_ciudades))? ucfirst(strtolower($c->desc_ciudades)):'No Ingresada';
			$aux->nombres = ucwords(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8'));
			if (isset($m->fecha_v)){
				$m_fecha = explode('-',$m->fecha_v);
				$m_fecha = $m_fecha[2].'/'.$m_fecha[1].'/'.$m_fecha[0];
			}
			else
				$m_fecha = "no tiene";

			if (isset($p->fecha_v)){
				$p_fecha = explode('-',$p->fecha_v);
				$p_fecha = $p_fecha[2].'/'.$p_fecha[1].'/'.$p_fecha[0];
			}
			else
				$p_fecha = "no tiene";

			$aux->masso =  $m_fecha;
			$aux->examen_pre =  $p_fecha;

			$fecha_actual = date("m-d-Y");
			$fecha_actual = explode('-', $fecha_actual);
			$fecha_actual = mktime(0,0,0,$fecha_actual[0],$fecha_actual[1],$fecha_actual[2]); 
			$aux->estado_masso = "";
			$aux->estado_examen = "";
			if ($aux->masso != "no tiene"){
				$fecha_entrada = explode('-', $m->fecha_v);
				$fecha_entrada = mktime(0,0,0,$fecha_entrada[1],$fecha_entrada[2],$fecha_entrada[0]); 
				$segundos_diferencia = $fecha_entrada - $fecha_actual;
				$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
				$dias_diferencia = floor($dias_diferencia);
				
				if($dias_diferencia <= 30 && $dias_diferencia > 0 ){
					$aux->estado_masso = "falta";
				}
				else if($dias_diferencia <= 0){
					$aux->estado_masso = "vencida";
				}
				else if($dias_diferencia > 30){
					$aux->estado_masso = "vigente";
				}
				//$aux->estado_masso = $dias_diferencia;
			}

			if ($aux->examen_pre != "no tiene"){
				$fecha_entrada = explode('-', $p->fecha_v);
				$fecha_entrada = mktime(0,0,0,$fecha_entrada[1],$fecha_entrada[2],$fecha_entrada[0]); 
				$segundos_diferencia = $fecha_entrada - $fecha_actual;
				$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
				$dias_diferencia = floor($dias_diferencia);
				
				if($dias_diferencia <= 30 && $dias_diferencia > 0){
					$aux->estado_examen = "falta";
				}
				else if($dias_diferencia <= 0){
					$aux->estado_examen = "vencida";
				}
				else if($dias_diferencia > 30){
					$aux->estado_examen = "vigente";
				}
			}

			if(empty($n)){
				$aux->ln = 0;
			}
			else{
				$cont_g = 0;
				$cont_ln = 0;
				$cont_lnp = 0;
				foreach ($n as $n) {
					if($n->tipo == "-"){
						$cont_g += 1;
					}
					if($n->tipo == "LNP"){
						$cont_lnp += 1;
					}
					if($n->tipo == "LN"){
						$cont_ln += 1;
					}
				}

				if ( $cont_g <=3 ) $aux->ln = 1;
				if ( $cont_g >= 4 || $cont_ln >= 1) $aux->ln = 2;
				if ( ($cont_g <= 3 && $cont_ln >= 1) || $cont_lnp >= 1) $aux->ln = 3;
			}
			
			array_push($listado,$aux);
			unset($aux,$usr);
		}

		$z = 0;
		$areas_cargos = "";
		foreach ($this->Requerimientos_model->r_listar() as $r) {
			$areas_cargos[$z] = array('id' => $r->id, 'nombre' => $r->nombre);
			foreach( $this->Requerimiento_area_cargo_model->get_requerimiento($r->id) as $a ){
				$n_area = $this->Areas_model->r_get($a->areas_id);
				$n_cargo = $this->Cargos_model->r_get($a->cargos_id);
				$areas_cargos[$z]['data'][] = array('id'=> $a->id, 'nombre' => $n_area->nombre.'-'.$n_cargo->nombre);
			}
			$z++;
		}

		$pagina['areas_cargo'] = $areas_cargos;
		$pagina['listado'] = $listado;

		$base['cuerpo'] = $this->load->view('trabajadores/listado2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function buscar_js_req($id_area_cargo = FALSE){
		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Trabajadores' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/listado_trabajadores2.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			//'head_buscar' => array('method' => 'post', 'url' => base_url().'est/trabajadores/buscar')
		);
		
		$this->load->model("Usuarios2_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Listanegra_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresa_planta_model");

		/* SI EXISTE EL REQUERIMIENTO */
		if( $id_area_cargo ){
			$area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
			$req = $this->Requerimientos_model->get($area_cargo->requerimiento_id);
			$planta = $this->Empresa_planta_model->get($req->planta_id);
			$area = $this->Areas_model->r_get($area_cargo->areas_id);
			$cargo = $this->Cargos_model->r_get($area_cargo->cargos_id);
			$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
			$aux_req = new stdClass();
			$aux_req->nombre = $req->nombre;
			$aux_req->planta = $planta->nombre;
			$aux_req->version = $req->version;
			$aux_req->area = $area->nombre;
			$aux_req->cargo = $cargo->nombre;
			$aux_req->cantidad = $r_area_cargo->cantidad;
			$aux_req->agregados = $this->Requerimiento_asc_trabajadores_model->contador($id_area_cargo);
			$pagina['datos_req'] = $aux_req;
		} 
		else
			$pagina['datos_req'] = FALSE;


		$z = 0;
		$areas_cargos = "";
		foreach ($this->Requerimientos_model->r_listar() as $r){
			$areas_cargos[$z] = array('id' => $r->id, 'nombre' => $r->nombre);
			foreach( $this->Requerimiento_area_cargo_model->get_requerimiento($r->id) as $a ){
				$n_area = $this->Areas_model->r_get($a->areas_id);
				$n_cargo = $this->Cargos_model->r_get($a->cargos_id);
				$areas_cargos[$z]['data'][] = array('id'=> $a->id, 'nombre' => $n_area->nombre.'-'.$n_cargo->nombre);
			}
			$z++;
		}
		$pagina['areas_cargo'] = $areas_cargos;
		$pagina['listado'] = "";
		$pagina['paginado'] = "";
		$base['cuerpo'] = $this->load->view('trabajadores/listado2_req',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function ver_datos(){
		$this->load->model('Usuarios_model');
		$pagina['datos_vista'] = $this->Usuarios_model->ver_datos_vista();
		$base['cuerpo'] = $this->load->view('trabajadores/listado2_req',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function buscar_js($id_area_cargo = FALSE){
		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Trabajadores' )),
			'menu' => $this->menu,
			'js' => array('js/si_validaciones.js','js/qrcode.js', 'js/examen_preo_masso.js', 'plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js','js/listado_trabajadores2.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css'),
			//'head_buscar' => array('method' => 'post', 'url' => base_url().'est/trabajadores/buscar')
		);
		
		$this->load->model("Usuarios2_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Listanegra_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Requerimientos_model");
		$this->load->model("Requerimiento_area_cargo_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		$this->load->model("Areas_model");
		$this->load->model("Cargos_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Empresa_planta_model");

		/* SI EXISTE EL REQUERIMIENTO */
		if( $id_area_cargo ){
			$area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
			$req = $this->Requerimientos_model->get($area_cargo->requerimiento_id);
			$planta = $this->Empresa_planta_model->get($req->planta_id);
			$area = $this->Areas_model->r_get($area_cargo->areas_id);
			$cargo = $this->Cargos_model->r_get($area_cargo->cargos_id);
			$r_area_cargo = $this->Requerimiento_area_cargo_model->get($id_area_cargo);
			$aux_req = new stdClass();
			$aux_req->nombre = $req->nombre;
			$aux_req->planta = $planta->nombre;
			$aux_req->version = $req->version;
			$aux_req->area = $area->nombre;
			$aux_req->cargo = $cargo->nombre;
			$aux_req->cantidad = $r_area_cargo->cantidad;
			$aux_req->agregados = $this->Requerimiento_asc_trabajadores_model->contador($id_area_cargo);
			$pagina['datos_req'] = $aux_req;
		} 
		else
			$pagina['datos_req'] = FALSE;

		$z = 0;
		$areas_cargos = "";
		foreach ($this->Requerimientos_model->r_listar() as $r) {
			$areas_cargos[$z] = array('id' => $r->id, 'nombre' => $r->nombre);
			foreach( $this->Requerimiento_area_cargo_model->get_requerimiento($r->id) as $a ){
				$n_area = $this->Areas_model->r_get($a->areas_id);
				$n_cargo = $this->Cargos_model->r_get($a->cargos_id);
				$areas_cargos[$z]['data'][] = array('id'=> $a->id, 'nombre' => $n_area->nombre.'-'.$n_cargo->nombre);
			}
			$z++;
		}

		$pagina['areas_cargo'] = $areas_cargos;
		$pagina['listado'] = "";
		$pagina['paginado'] = "";
		$pagina['permiso_examen_psicologico'] = $this->Usuarios_model->consultar_permiso_exam_psic($this->session->userdata('id'));
		$base['cuerpo'] = $this->load->view('trabajadores/listado2',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function listado_desactivar_trabajadores(){
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Examenes_psicologicos_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Usuarios_desactivar_previos_model');
		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Trabajadores' )),
			'menu' => $this->menu,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		if($this->session->flashdata('usuario_req')){
			foreach($this->session->flashdata('usuario_req') as $r){
				$existe = $this->Usuarios_desactivar_previos_model->consultar_si_existe($r);
				$datos = array(
					'id_usuario' => $r,
					'id_solicitante' => $this->session->userdata('id')
				);
				if($existe == "NA"){
					$this->Usuarios_desactivar_previos_model->guardar($datos);
				}else{
					$this->Usuarios_desactivar_previos_model->actualizar($existe->id, $datos);
				}
			}
		}

		$usuarios_desactivar = $this->Usuarios_desactivar_previos_model->get_result();
		$listado = array();
		if($usuarios_desactivar != NULL){
			foreach($usuarios_desactivar as $row){
				$aux = new stdClass();
				$id_usuario = isset($row->id_usuario)?$row->id_usuario:0;
				$get_usu = $this->Usuarios_model->get($id_usuario);
				$id_ciudad = isset($get_usu->id_ciudades)?$get_usu->id_ciudades:0;
				$get_ciudad = $this->Ciudad_model->get($id_ciudad);

				$aux->id_usuario = isset($row->id_usuario)?$row->id_usuario:0;
				$aux->rut_usuario = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
				$aux->nombres = isset($get_usu->nombres)?$get_usu->nombres:"";
				$aux->paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
				$aux->materno = isset($get_usu->materno)?$get_usu->materno:"";
				$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
				$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
				$aux->ciudad = isset($get_ciudad->desc_ciudades)?$get_ciudad->desc_ciudades:"";

				$id_espec1 = isset($get_usu->id_especialidad_trabajador)?$get_usu->id_especialidad_trabajador:NULL;
				if($id_espec1 != NULL){
					$e1 = $this->Especialidadtrabajador_model->get($id_espec1);
					$aux->especilidad1 = ($e1->desc_especialidad)? ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')) : FALSE;	
				}else
					$aux->especilidad1 = false;

				$id_espec2 = isset($get_usu->id_especialidad_trabajador_2)?$get_usu->id_especialidad_trabajador_2:NULL;

				if ($id_espec2 != NULL){
					$e2 = $this->Especialidadtrabajador_model->get($id_espec2);
					$aux->especilidad2 = (!empty($e2->desc_especialidad))? ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')) : FALSE;
				}else
					$aux->especilidad2 = false;


				$masso = $this->Evaluaciones_model->get_una_masso($id_usuario);
				$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:"";

				if(!$estado_masso){
					$aux->masso = 0;
					$aux->color_masso = "";
				}else{
					if($estado_masso >= 0 && $estado_masso <= 30){
						$color_masso = "#FF8000";
					}elseif($estado_masso < 0){
						$color_masso = "red";
					}elseif($estado_masso > 30){
						$color_masso = "green";
					}
					$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"";
					$aux->color_masso = $color_masso;
				}

				$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($id_usuario);
				$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:"";

				if(!$estado_preo){
					$aux->examen_pre = 0;
					$aux->color_preo = "";
				}else{
					if($estado_preo >= 0 && $estado_preo <= 30){
						$color_preo = "#FF8000";
					}elseif($estado_preo < 0){
						$color_preo = "red";
					}elseif($estado_preo > 30){
						$color_preo = "green";
					}
					$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"";
					$aux->color_preo = $color_preo;
				}

				$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($id_usuario);
				$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
				$aux->eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;
				$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

				if($estado_psic == NULL){
					$aux->examen_psic = "N/D";
					$aux->color_psic = "";
				}else{
					if($estado_psic >= 0 && $estado_psic <= 30){
						$color_psic = "#FF8000";
					}elseif($estado_psic < 0){
						$color_psic = "red";
					}elseif($estado_psic > 30){
						$color_psic = "green";
					}
					$aux->examen_psic = isset($examen_psic->fecha_vigencia)?$examen_psic->fecha_vigencia:"N/D";
					$aux->color_psic = $color_psic;
				}
				array_push($listado,$aux);
				unset($aux);
			}
		}
		$pagina['listado'] = $listado;
		$base['cuerpo'] = $this->load->view('trabajadores/listado_desactivar_trabajadores',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function desactivar_trabajadores(){
		$this->load->model('Usuarios_model');
		$this->load->model('Usuarios_desactivar_previos_model');

		if(!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c=>$valores){
				$this->Usuarios_model->desactivar_trabajador($valores);
				$this->Usuarios_desactivar_previos_model->eliminar($valores);
			}
		}
		echo '<script>alert("Trabajador(es) desactivado(s) exitosamente");</script>';
		redirect('usuarios/home', 'refresh');
	}

	function trabajadores_est(){
		$this->load->model('Usuarios2_model');
		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Trabajadores' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			//'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/ui-subview.js','plugins/select2/select2.min.js'),
			//'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/select2/select2.css')
		);
		$pagina['listado'] = $this->Usuarios2_model->todos_los_trabajadores_est();
		$base['cuerpo'] = $this->load->view('trabajadores/listado_trabajadores_est',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function psicologos(){
		$base = array(
			'head_titulo' => "Lista de Psicologos - Sistema EST",
			'titulo' => "Listado de Psicologos",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Psicologos Activos y/o Inactivos' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model('Requerimiento_asc_trabajadores_model');

		$lista = array();
		foreach ($this->Usuarios_model->listar_psicologos() as $l){
			$aux = new stdClass();
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombre = $l->nombres;
			$aux->ap_paterno = $l->paterno;
			$aux->ap_materno = $l->materno;
			$aux->direccion = $l->direccion;
			$aux->email = $l->email;
			$aux->fono = $l->fono;
			$aux->fecha_nac = $l->fecha_nac;
			$aux->estado = $l->estado;
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('trabajadores/listado_psicologos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_trabajador_psicologo(){
		$this->load->model("Usuarios_model");

		if(isset($_POST['ano_fn']) && isset($_POST['mes_fn']) && isset($_POST['dia_fn'])){
			$fecha_nac = $_POST['ano_fn'].'-'.$_POST['mes_fn'].'-'.$_POST['dia_fn'];
		}else{
			$fecha_nac = '0000-00-00';
		}

		$data = array(
			"rut_usuario" => $_POST['rut'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			"materno" => $_POST['materno'],
			"direccion" => $_POST['direccion'],
			"email" => $_POST['email'],
			"fono" => $_POST['fono'],
			"fecha_nac" => $fecha_nac,
			"estado" => 1,
		);
		$this->Usuarios_model->ingresar_psicologo($data);
		echo '<script>alert("Psicologo/a Registrado Exitosamente");</script>';
		redirect('est/trabajadores/psicologos', 'refresh');
	}

	function listado_trabajadores_inactivos(){
		$base = array(
			'head_titulo' => "Lista de Trabajadores - Sistema EST",
			'titulo' => "Listado de Trabajadores",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Trabajadores Activos y/o Inactivos' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model('Requerimiento_asc_trabajadores_model');

		$lista = array();
		foreach ($this->Usuarios_model->listar_trabajadores_con_id_especialidad() as $l){
			$aux = new stdClass();
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombre = $l->nombres;
			$aux->ap_paterno = $l->paterno;
			$aux->ap_materno = $l->materno;
			$aux->estado = $l->estado;
			$aux->fecha_actualizacion = isset($l->fecha_actualizacion)?$l->fecha_actualizacion:"";
			$get_espec1 = isset($l->id_especialidad_trabajador)?$l->id_especialidad_trabajador:"";
			$get_espec2 = isset($l->id_especialidad_trabajador_2)?$l->id_especialidad_trabajador_2:"";
			$get_espec3 = isset($l->id_especialidad_trabajador_3)?$l->id_especialidad_trabajador_3:"";

			if(!$get_espec1){
				$aux->especialidad = "";
			}else{
				$get_especialidad_1 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador);
				$aux->especialidad = isset($get_especialidad_1->desc_especialidad)?$get_especialidad_1->desc_especialidad:"";
			}

			if(!$get_espec2){
				$aux->especialidad2 = "";
			}else{
				$get_especialidad_2 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_2);
				$aux->especialidad2 = isset($get_especialidad_2->desc_especialidad)?$get_especialidad_2->desc_especialidad:"";
			}

			if(!$get_espec3){
				$aux->especialidad3 = "";
			}else{
				$get_especialidad_3 = $this->Especialidadtrabajador_model->get($l->id_especialidad_trabajador_3);
				$aux->especialidad3 = isset($get_especialidad_3->desc_especialidad)?$get_especialidad_3->desc_especialidad:"";
			}

			$masso = $this->Evaluaciones_model->get_una_masso($l->id);
			$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:"";

			if(!$estado_masso){
				$aux->masso = "";
				$aux->color_masso = "";
			}else{
				if($estado_masso >= 0 && $estado_masso <= 30){
					$color_masso = "#FF8000";
				}elseif($estado_masso < 0){
					$color_masso = "red";
				}elseif($estado_masso > 30){
					$color_masso = "green";
				}

				$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"";
				$aux->color_masso = $color_masso;
			}

			$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($l->id);
			$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:"";

			if(!$estado_preo){
				$aux->examen_pre = "";
				$aux->color_preo = "";
			}else{
				if($estado_preo >= 0 && $estado_preo <= 30){
					$color_preo = "#FF8000";
				}elseif($estado_preo < 0){
					$color_preo = "red";
				}elseif($estado_preo > 30){
					$color_preo = "green";
				}

				$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"";
				$aux->color_preo = $color_preo;
			}
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('trabajadores/listado_trabajadores_inactivos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function actualizar_trabajador($id){
		$this->load->model("Usuarios_model");
		$data = array('estado' => 1, );
		$this->Usuarios_model->editar($id, $data);
		echo "<script>alert('Usuario Activado Exitosamente')</script>";
		redirect('est/trabajadores/listado_trabajadores_inactivos', 'refresh');
	}

	function editar_usuarios_activos(){
		$this->load->model("Usuarios_model");

		$data = json_decode($_POST['json']);
		foreach ($data as $k => $v) {
			if ($k == 'id') $id = $v;
			if( $k == 'opcion_estado') $opcion_estado = $v;
		}
		$salida = array( 
			'estado' => $opcion_estado
		);
		$this->Usuarios_model->editar($id,$salida);
	}

	function eliminar_trabajador_listado($id_usuario){
		$this->load->model("Usuarios_model");
		$this->Usuarios_model->eliminar($id_usuario);
		echo "<script>alert('Usuarios Eliminado Exitosamente')</script>";
		redirect('est/trabajadores/listado_trabajadores', 'refresh');
	}

	function eliminar_psicologo($id_usuario){
		$this->load->model("Usuarios_model");
		$this->Usuarios_model->eliminar_psicologo($id_usuario);
		echo "<script>alert('Usuarios Eliminado Exitosamente')</script>";
		redirect('est/trabajadores/psicologos', 'refresh');
	}

	function cambiar_estados_trabajadores(){
		$this->load->model("Usuarios_model");

		if (!empty($_POST['usuarios'])?$_POST['usuarios']:false){
			foreach($_POST['usuarios'] as $c){
				$data = array(
					"estado" => '0',
				);
				$this->Usuarios_model->actualizar_estado_activo_trabajador($c, $data);
			}
		}

		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c){
				$data = array(
					"estado" => '1',
				);
				$this->Usuarios_model->actualizar_estado_activo_trabajador($c, $data);
			}
		}
		echo "<script>alert('Usuarios Actualizados Exitosamente')</script>";
		redirect('est/trabajadores/listado_trabajadores', 'refresh');
	}

	function cambiar_estados_psicologos(){
		$this->load->model("Usuarios_model");

		if (!empty($_POST['usuarios'])?$_POST['usuarios']:false){
			foreach($_POST['usuarios'] as $c){
				$data = array(
					"estado" => '0',
				);
				$this->Usuarios_model->actualizar_estado_activo_psicologos($c, $data);
			}
		}

		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $z){
				$data2 = array(
					"estado" => '1',
				);
				$this->Usuarios_model->actualizar_estado_activo_psicologos($z, $data2);
			}
		}
		echo "<script>alert('Usuarios Actualizados Exitosamente')</script>";
		redirect('est/trabajadores/psicologos', 'refresh');
	}

	function gestion_usuarios($usuarios = FALSE){
		$this->load->model("Usuarios/usuarios_general_model");
		$base = array(
			'head_titulo' => "Sistema EST - Listado Usuarios",
			'titulo' => "Listado Usuarios",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Usuarios' )),
			'menu' => $this->menu,
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'js' => array('js/si_gestion_usuarios.js', 'js/confirm.js'),
		);

		$usuario_defecto = "mandantes";
		if (empty($usuarios)){
			$usuario_trabajar = $usuario_defecto;
		}else{
			$usuario_trabajar = $usuarios;
		}

		if($usuario_trabajar == "mandantes"){
			$listado = $this->usuarios_general_model->listar_tipo_usuario(7);
			$nombre_usuario = "Mandantes";
		}elseif($usuario_trabajar == "est_externo"){
			$listado = $this->usuarios_general_model->listar_tipo_usuario(4);
			$nombre_usuario = "EST Externos";
		}
		
		$lista_aux = array();
		if (!empty($listado)){
			foreach ($listado as $rm){
				$aux = new stdClass();
				$aux->id_usuario = $rm->usuarios_id;
				$aux->rut_usuario = $rm->rut_usuario;
				$aux->paterno = $rm->paterno;
				$aux->materno = $rm->materno;
				$aux->nombres = $rm->nombres;
				$aux->fono = $rm->fono;
				$aux->email = $rm->email;
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$pagina['usuario'] = $usuario_trabajar;
		$pagina['nombre_usuario'] = $nombre_usuario;
		$base['cuerpo'] = $this->load->view('trabajadores/listado_gestion_usuarios',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function gestion_usuarios_psicologos(){
		$this->load->model("Usuarios/usuarios_general_model");
		$this->load->model("Usuarios_model");
		$base = array(
			'head_titulo' => "Sistema EST - Listado Usuarios",
			'titulo' => "Listado Usuarios",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Usuarios' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$listado = $this->usuarios_general_model->listar(); 
		$lista_aux = array();
		if (!empty($listado)){
			foreach ($listado as $rm){
				$aux = new stdClass();
				$aux->id = $rm->id;
				$aux->rut_usuario = $rm->rut_usuario;
				$aux->paterno = $rm->paterno;
				$aux->materno = $rm->materno;
				$aux->nombres = $rm->nombres;
				$aux->fono = $rm->fono;
				$aux->email = $rm->email;
				$aux->estado = $this->Usuarios_model->consultar_permiso_exam_psic($rm->id);
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}

		$pagina['lista_aux'] = $lista_aux;
		$base['cuerpo'] = $this->load->view('trabajadores/listado_gestion_exam_psicologos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_estado_permiso_examen_psicologico(){
		$this->load->model("Usuarios_model");

		if (!empty($_POST['usuarios'])?$_POST['usuarios']:false){
			foreach($_POST['usuarios'] as $c){
				$this->Usuarios_model->eliminar_permiso_exam_psic($c);
			}
		}

		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c){
				$data = array(
					"usuario_id" => $c,
				);
				$this->Usuarios_model->ingresar_permiso_exam_psic($data);
			}
		}
		echo "<script>alert('Usuarios Actualizados Exitosamente')</script>";
		redirect('est/trabajadores/gestion_usuarios_psicologos', 'refresh');
	}

	function eliminar($tipo_usuario, $id){
		$this->load->model('General_model');
		$this->General_model->eliminar($id);
		redirect(base_url().'est/trabajadores/gestion_usuarios/'.$tipo_usuario, 'refresh');
	}

	function modal_editar_usuarios($tipo_usuario,$id_usuario){
		$this->load->model("general_model");
		$listado = $this->general_model->get_result($id_usuario);
		$lista_aux = array();
		if (!empty($listado)){
			foreach ($listado as $rm){
				$aux = new stdClass();
				$aux->id_usuario = $rm->id;
				$aux->rut_usuario = $rm->rut_usuario;
				$aux->paterno = $rm->paterno;
				$aux->materno = $rm->materno;
				$aux->nombres = $rm->nombres;
				$aux->fono = $rm->fono;
				$aux->email = $rm->email;
				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$pagina['tipo_usuario'] = $tipo_usuario;
		$this->load->view('trabajadores/modal_editar_usuarios', $pagina);
	}

	function modal_editar_psicologo($id_usuario){
		$this->load->model("Usuarios_model");
		$pagina['lista_aux'] = $this->Usuarios_model->get_datos_psicologo($id_usuario);
		$this->load->view('trabajadores/modal_editar_psicologo', $pagina);
	}

	function modal_permiso_planta_usuarios($tipo_usuario,$id_usuario){
		$this->load->model("general_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("relacion_usuario_planta_model");
		$listado = $this->general_model->get_result($id_usuario);
		$lista_aux = array();
		if (!empty($listado)){
			foreach ($listado as $rm){
				$empresas_celulosas = $this->Empresa_planta_model->listar_centro_costo(2);
				$empresas_paneles_maderas = $this->Empresa_planta_model->listar_centro_costo(4);
				$empresas_forestal = $this->Empresa_planta_model->listar_centro_costo(5);
				$empresas_camanchaca = $this->Empresa_planta_model->listar_centro_costo(6);
				$empresas_cargill = $this->Empresa_planta_model->listar_centro_costo(7);

				$aux = new stdClass();
				$aux->id_usuario = $rm->id;
				$aux->rut_usuario = $rm->rut_usuario;
				$aux->paterno = $rm->paterno;
				$aux->materno = $rm->materno;
				$aux->nombres = $rm->nombres;
				$aux->fono = $rm->fono;
				$aux->email = $rm->email;

				$aux->plantas_celulosas = array();
				if (!empty($empresas_celulosas)){
					foreach ($empresas_celulosas as $d){
						$archivo1 = new StdClass();
						$get_usu_planta = $this->relacion_usuario_planta_model->get_usuario($rm->id, $d->id);
						$archivo1->si_existe = $get_usu_planta;
						$archivo1->id_planta = $d->id;
						$archivo1->nombre = urldecode($d->nombre);
						array_push($aux->plantas_celulosas, $archivo1);
					}
					unset($archivo1);
				}

				$aux->plantas_maderas = array();
				if (!empty($empresas_paneles_maderas)){
					foreach ($empresas_paneles_maderas as $d) {
						$archivo2 = new StdClass();
						$get_usu_planta = $this->relacion_usuario_planta_model->get_usuario($rm->id, $d->id);
						$archivo2->si_existe = $get_usu_planta;
						$archivo2->id_planta = $d->id;
						$archivo2->nombre = urldecode($d->nombre);
						array_push($aux->plantas_maderas, $archivo2);
					}
					unset($archivo2);
				}

				$aux->plantas_camanchacas = array();
				if (!empty($empresas_camanchaca)){
					foreach ($empresas_camanchaca as $d){
						$archivo3 = new StdClass();
						$get_usu_planta = $this->relacion_usuario_planta_model->get_usuario($rm->id, $d->id);
						$archivo3->si_existe = $get_usu_planta;
						$archivo3->id_planta = $d->id;
						$archivo3->nombre = urldecode($d->nombre);
						array_push($aux->plantas_camanchacas, $archivo3);
					}
					unset($archivo3);
				}

				$aux->plantas_forestal = array();
				if (!empty($empresas_forestal)){
					foreach ($empresas_forestal as $d){
						$archivo4 = new StdClass();
						$get_usu_planta = $this->relacion_usuario_planta_model->get_usuario($rm->id, $d->id);
						$archivo4->si_existe = $get_usu_planta;
						$archivo4->id_planta = $d->id;
						$archivo4->nombre = urldecode($d->nombre);
						array_push($aux->plantas_forestal, $archivo4);
					}
					unset($archivo4);
				}

				$aux->plantas_cargill = array();
				if (!empty($empresas_cargill)){
					foreach ($empresas_cargill as $d){
						$archivo5 = new StdClass();
						$get_usu_planta = $this->relacion_usuario_planta_model->get_usuario($rm->id, $d->id);
						$archivo5->si_existe = $get_usu_planta;
						$archivo5->id_planta = $d->id;
						$archivo5->nombre = urldecode($d->nombre);
						array_push($aux->plantas_cargill, $archivo5);
					}
					unset($archivo5);
				}

				array_push($lista_aux, $aux);
				unset($aux);
			}
		}
		$pagina['lista_aux'] = $lista_aux;
		$pagina['tipo_usuario'] = $tipo_usuario;
		$this->load->view('trabajadores/modal_asignar_permisos_planta', $pagina);
	}

	function guardar_relacion_planta_usuario(){
		$this->load->model("relacion_usuario_planta_model");
        $id_usuario = $_POST['id_usuario'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $this->relacion_usuario_planta_model->eliminar_relacion_planta_usuario($id_usuario);

		if($_POST['rut_ingresar1']){
			foreach($_POST['rut_ingresar1'] as $c=>$valores){
				if(!empty($_POST['planta_ingresar_camanchaca'][$c]) ){
					$data = array(
						'usuario_id' => $id_usuario,
						'empresa_planta_id' => (!empty($_POST['planta_ingresar_camanchaca'][$c]))?$_POST['planta_ingresar_camanchaca'][$c]:false,
					);
					$asistencia = $this->relacion_usuario_planta_model->ver_relacion_planta_usuario($id_usuario, $_POST['planta_ingresar_camanchaca'][$c]);
					if ($asistencia == 1){
						$this->relacion_usuario_planta_model->actualizar_relacion($id_usuario, $data);
					}elseif ($asistencia == 0){
						$this->relacion_usuario_planta_model->guardar_relacion($data);
					}
				}else{
					echo "";
				}
			}
		}

		if($_POST['rut_ingresar2']){
			foreach($_POST['rut_ingresar2'] as $c=>$valores){
				if(!empty($_POST['planta_ingresar_celulosa'][$c]) ){
					$data2 = array(
						'usuario_id' => $id_usuario,
						'empresa_planta_id' => (!empty($_POST['planta_ingresar_celulosa'][$c]))?$_POST['planta_ingresar_celulosa'][$c]:false,
					);
					$asistencia = $this->relacion_usuario_planta_model->ver_relacion_planta_usuario($id_usuario, $_POST['planta_ingresar_celulosa'][$c]);
					if ($asistencia == 1){
						$this->relacion_usuario_planta_model->actualizar_relacion($id_usuario, $data2);
					}elseif ($asistencia == 0){
						$this->relacion_usuario_planta_model->guardar_relacion($data2);
					}


				}else{
					echo "";
				}
			}
		}

		if($_POST['rut_ingresar3']){
			foreach($_POST['rut_ingresar3'] as $c=>$valores){
				if(!empty($_POST['planta_ingresar_maderas'][$c]) ){
					$data3 = array(
						'usuario_id' => $id_usuario,
						'empresa_planta_id' => (!empty($_POST['planta_ingresar_maderas'][$c]))?$_POST['planta_ingresar_maderas'][$c]:false,
					);

					$asistencia2 = $this->relacion_usuario_planta_model->ver_relacion_planta_usuario($id_usuario, $_POST['planta_ingresar_maderas'][$c]);
					if ($asistencia2 == 1){
						$this->relacion_usuario_planta_model->actualizar_relacion($id_usuario, $data3);
					}elseif ($asistencia2 == 0){
						$this->relacion_usuario_planta_model->guardar_relacion($data3);
					}
				}else{
					echo "";
				}
			}
		}

		if($_POST['rut_ingresar4']){
			foreach($_POST['rut_ingresar4'] as $c=>$valores){
				if(!empty($_POST['planta_ingresar_forestal'][$c]) ){
					$data4 = array(
						'usuario_id' => $id_usuario,
						'empresa_planta_id' => (!empty($_POST['planta_ingresar_forestal'][$c]))?$_POST['planta_ingresar_forestal'][$c]:false,
					);

					$asistencia3 = $this->relacion_usuario_planta_model->ver_relacion_planta_usuario($id_usuario, $_POST['planta_ingresar_forestal'][$c]);
					if ($asistencia3 == 1){
						$this->relacion_usuario_planta_model->actualizar_relacion($id_usuario, $data4);
					}elseif ($asistencia3 == 0){
						$this->relacion_usuario_planta_model->guardar_relacion($data4);
					}
				}else{
					echo "";
				}
			}
		}

		if($_POST['rut_ingresar5']){
			foreach($_POST['rut_ingresar5'] as $c=>$valores){
				if(!empty($_POST['planta_ingresar_cargill'][$c]) ){
					$data5 = array(
						'usuario_id' => $id_usuario,
						'empresa_planta_id' => (!empty($_POST['planta_ingresar_cargill'][$c]))?$_POST['planta_ingresar_cargill'][$c]:false,
					);

					$asistencia3 = $this->relacion_usuario_planta_model->ver_relacion_planta_usuario($id_usuario, $_POST['planta_ingresar_cargill'][$c]);
					if ($asistencia3 == 1){
						$this->relacion_usuario_planta_model->actualizar_relacion($id_usuario, $data5);
					}elseif ($asistencia3 == 0){
						$this->relacion_usuario_planta_model->guardar_relacion($data5);
					}
				}else{
					echo "";
				}
			}
		}

		echo "<script>alert('Permisos Registrados Exitosamente')</script>";
		redirect('est/trabajadores/gestion_usuarios/'.$tipo_usuario.'', 'refresh');
	}

	function actualizar_datos_usuario(){
		$this->load->model("general_model");
		$id_usuario = $_POST['id_usuario'];
		$tipo_usuario = $_POST['tipo_usuario'];

		$data = array(
			"rut_usuario" => $_POST['rut_usuario'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			"materno" => $_POST['materno'],
			"fono" => $_POST['fono'],
			"email" => $_POST['email'],
			);

		$this->general_model->editar_usuario($id_usuario, $data);
		echo '<script>alert("Usuario Modificado Exitosamente");</script>';
		redirect('est/trabajadores/gestion_usuarios/'.$tipo_usuario, 'refresh');
	}

	function actualizar_datos_psicologo(){
		$this->load->model("Usuarios_model");
		$id_usuario = $_POST['usuario_id'];

		if(isset($_POST['ano_fn']) && isset($_POST['mes_fn']) && isset($_POST['dia_fn'])){
			$fecha_nac = $_POST['ano_fn'].'-'.$_POST['mes_fn'].'-'.$_POST['dia_fn'];
		}else{
			$fecha_nac = '0000-00-00';
		}

		$data = array(
			"rut_usuario" => $_POST['rut_usuario'],
			"nombres" => $_POST['nombres'],
			"paterno" => $_POST['paterno'],
			"materno" => $_POST['materno'],
			"direccion" => $_POST['direccion'],
			"email" => $_POST['email'],
			"fono" => $_POST['fono'],
			"fecha_nac" => $fecha_nac
		);

		$this->Usuarios_model->editar_psicologo($id_usuario, $data);
		echo '<script>alert("Usuario Modificado Exitosamente");</script>';
		redirect('est/trabajadores/psicologos', 'refresh');
	}

	function listado_gente(){
		$this->load->model("Usuarios2_model");

		$requestData= $_REQUEST;

		$data = $this->Usuarios2_model->listar_filtro2($requestData['start'],$requestData['length'],$requestData['search']['value']);

		$totalData = $this->Usuarios2_model->total_usuarios();
		$totalFiltered = $this->Usuarios2_model->total_usuarios();

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
		);

		header('Content-Type: application/json');
		echo json_encode($json_data);
	}

	function leer_json(){
		//$this->load->model("Usuarios2_model");
		$this->load->library('cimongo');
		/*
		$n_file = 'trabajadores.json';
		if (!file_exists($n_file)){
			$dd = $this->Usuarios2_model->listar_filtro2();
			$dd = array('data'=> $dd);
			file_put_contents($n_file, json_encode($dd));
		}

		$datos_trabajador = file_get_contents($n_file);*/

		$datos_trabajador = $this->cimongo->get("est")->result();
		//var_dump($datos_trabajador);
		header('Content-Type: application/json');
		echo json_encode($datos_trabajador[0]);
	}

	function llenar_mongo(){
		$this->load->model("Usuarios2_model");
		echo $this->Usuarios2_model->llenar_mongo();
	}



	function solicitudes_revision_examenes(){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Solicitud_revision_examenes_previos_model');
		$this->load->model('Solicitud_revision_examenes_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Cargos_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimientos_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Trabajadores a enviar revision de examenes",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes' ) ),
			'menu' => $this->menu,
			'js' => array('js/si_datepicker_solicitudes_revision_examenes.js','js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);
		//var_dump($_POST['seleccionar_todos']);
		//return false;

		if($this->session->flashdata('usuario_req')){
			foreach($this->session->flashdata('usuario_req') as $r){
				$existe = $this->Solicitud_revision_examenes_previos_model->consultar_si_existe($r);
				$datos = array(
					'id_usuario' => $r,
					'id_solicitante' => $this->session->userdata('id'),
					'estado' => 1,
				);
				if($existe == "NA"){
					$this->Solicitud_revision_examenes_previos_model->guardar($datos);
				}else{
					$this->Solicitud_revision_examenes_previos_model->actualizar($existe->id, $datos);
				}
			}
		}

		if(!empty($_POST['seleccionar_todos'])){
			foreach($_POST['seleccionar_todos'] as $c=>$valores){
				$existe = $this->Solicitud_revision_examenes_previos_model->consultar_si_existe($valores);
				$datos = array(
					'id_usuario' => $valores,
					'id_solicitante' => $this->session->userdata('id'),
					'estado' => 1,
				);
				if($existe == "NA"){
					$this->Solicitud_revision_examenes_previos_model->guardar($datos);
				}else{
					$this->Solicitud_revision_examenes_previos_model->actualizar($existe->id, $datos);
				}
			}
		}

		$usuarios = $this->Solicitud_revision_examenes_previos_model->get_result($this->session->userdata('id'));
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->id_usuario);
			$ciudad = $this->Ciudad_model->get($get_usu->id_ciudades);
			$get_req_activos = $this->Requerimiento_asc_trabajadores_model->get_usuarios_area_cargo_req_activos_result($l->id_usuario);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud_previa = $l->id;
			$aux->usuario_id = $l->id_usuario;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";

			$req_activos = 0;
			$aux->requerimientos_activos = array();
			if (!empty($get_req_activos)){
				foreach ($get_req_activos as $req){
					$archivo = new StdClass();
					$req_activos += 1;

					if($req->referido == 0)
						$referido = "No";
					elseif($req->referido == 1)
						$referido = "Si";
					else
						$referido = "";

					$archivo->id_req = $req->id_req;
					$archivo->empresa_planta = $req->empresa_planta;
					$archivo->nombre_req = $req->nombre_req;
					$archivo->nombre_area = $req->nombre_area;
					$archivo->nombre_cargo = $req->nombre_cargo;
					$archivo->referido = $referido;
					array_push($aux->requerimientos_activos, $archivo);
					unset($archivo);
				}
			}
			$aux->req_activos = $req_activos;
			//$id_asc_trab = isset($get_ultimo_req->id_asc_trab)?$get_ultimo_req->id_asc_trab:"";
			//$id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			//$get_solicitud = $this->Solicitud_revision_examenes_model->get_usu_req($l->id_usuario, $id_req, $id_asc_trab);

			//$aux->envio_masso = isset($get_solicitud->exam_masso)?$get_solicitud->exam_masso:NULL;
			$aux->envio_masso = NULL;
			//$aux->envio_preo = isset($get_solicitud->exam_preo)?$get_solicitud->exam_preo:NULL;
			$aux->envio_preo = NULL;
			//$aux->envio_psic = isset($get_solicitud->exam_psicologico)?$get_solicitud->exam_psicologico:NULL;
			$aux->envio_psic = NULL;
			//$aux->id_asc_trab = isset($get_ultimo_req->id_asc_trab)?$get_ultimo_req->id_asc_trab:"";
			//$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:0;
			//$aux->id_cargo = isset($get_ultimo_req->id_cargo)?$get_ultimo_req->id_cargo:"";
			//$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			//$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			//$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			//$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			//$aux->planta_id = isset($get_ultimo_req->planta_id)?$get_ultimo_req->planta_id:"";
			//$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			//$aux->fecha_nac = isset($get_ultimo_req->fecha_nac)?$get_ultimo_req->fecha_nac:"";

			if ($get_usu->id_especialidad_trabajador){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			if ($get_usu->id_especialidad_trabajador_2){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;

			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2)
			$pagina['tipo_usuario'] = "analista";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "NO";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('trabajadores/listado_envio_solicitud_revision_examen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function enviar_solicitud_revision_examenes(){
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Solicitud_revision_examenes_previos_model");
		$this->load->model("Examenes_psicologicos_model");
		$this->load->model("Examenes_psicologicos_previos_model");
		$this->load->model("Usuarios_model");
		$this->load->model("usuarios/Usuarios_general_model");
		$this->load->model("Requerimiento_asc_trabajadores_model");
		
		if(!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c=>$valores){
				$examen_preo = ((!empty($_POST['examen_preo'][$c]))?1:0);
				$examen_masso = ((!empty($_POST['examen_masso'][$c]))?1:0);
				$examen_psicologico = ((!empty($_POST['examen_psicologico'][$c]))?1:0);
				$id_requerimiento = (!empty($_POST['requerimiento_asociado'][$c]))?$_POST['requerimiento_asociado'][$c]:false;
				$get_req_asc_usu = $this->Requerimiento_asc_trabajadores_model->get_usuarios_area_cargo_asc_req_usu_row($valores, $id_requerimiento);
				$id_asc_trabajador = isset($get_req_asc_usu->id_asc_trab)?$get_req_asc_usu->id_asc_trab:null;

				$preo = array(
					'exam_preo' => $examen_preo,
				);

				$masso = array(
					'exam_masso' => $examen_masso,
				);

				$psic = array(
					'exam_psicologico' => $examen_psicologico,
				);

				$data = array(
					"usuario_id" => $valores,
					"solicitante_id" => $this->session->userdata('id'),
					"id_requerimiento" => $id_requerimiento,
					"id_asc_trabajador" => $id_asc_trabajador,
					"fecha_solicitud" => date('Y-m-d'),
					"fecha_esperada_ingreso" => (!empty($_POST['fecha_ingreso_esperado'][$c]))?$_POST['fecha_ingreso_esperado'][$c]:false,
					"observaciones" => (!empty($_POST['observaciones'][$c]))?$_POST['observaciones'][$c]:false,
					"estado" => '0',
				);

				$todos_los_datos = array_merge($data, $preo, $masso, $psic);

				$get_solicitudes = $this->Solicitud_revision_examenes_model->get_usu_req($valores, $id_requerimiento, $id_asc_trabajador);
				$id_solicitud_anterior = isset($get_solicitudes->id)?$get_solicitudes->id:NULL;

				if($id_solicitud_anterior == NULL){
					$this->Solicitud_revision_examenes_model->guardar($todos_los_datos);
					$id_solicitud = $this->db->insert_id();
				}else{
					$this->Solicitud_revision_examenes_model->actualizar($id_solicitud_anterior, $todos_los_datos);
					$id_solicitud = $id_solicitud_anterior;
				}

				if($examen_psicologico == 1){
					$existe_examen = $this->Examenes_psicologicos_model->existe_usuario($valores);
					if($existe_examen == "NADA"){
						$datos_psic = array(
							"usuario_id" => $valores,
							"solicitante_id" => $this->session->userdata('id'),
							"cargo_postulacion_id" => isset($get_req_asc_usu->id_cargo)?$get_req_asc_usu->id_cargo:false,
							"lugar_trabajo_id" => isset($get_req_asc_usu->planta_id)?$get_req_asc_usu->planta_id:false,
							"tecnico_supervisor" => (!empty($_POST['superv_tecnico'][$c]))?$_POST['superv_tecnico'][$c]:false,
							"sueldo_definido" => (!empty($_POST['sueldo_definido'][$c]))?$_POST['sueldo_definido'][$c]:false,
							"referido" => isset($get_req_asc_usu->referido)?$get_req_asc_usu->referido:false,
							"observaciones" => (!empty($_POST['observaciones'][$c]))?$_POST['observaciones'][$c]:false,
							"fecha_solicitud" => date('Y-m-d'),
							"fecha_evaluacion" => '1991-01-01',
							"fecha_vigencia" => '1991-01-01',
							"estado" => '0',
							"liberacion" => '1'
						);
						$this->Examenes_psicologicos_model->guardar($datos_psic);
						$this->Examenes_psicologicos_previos_model->eliminar($valores);
					}
				}
				$this->Solicitud_revision_examenes_previos_model->eliminar($valores);
			}
		}

		//avisar via email cuando se crea la solicitud
		$get_solicitud = $this->Solicitud_revision_examenes_model->get_row($id_solicitud);
		$id_solicitante = isset($get_solicitud->solicitante_id)?$get_solicitud->solicitante_id:'';
		$id_trabajador = isset($get_solicitud->usuario_id)?$get_solicitud->usuario_id:'';

		$get_usuario = $this->Usuarios_model->get($id_trabajador);
		$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
		$nombres_trabajador = isset($get_usuario->nombres)?$get_usuario->nombres:'';
		$ap_paterno_trabajador = isset($get_usuario->paterno)?$get_usuario->paterno:'';
		$ap_materno_trabajador = isset($get_usuario->materno)?$get_usuario->materno:'';
		$rut_trabajador = isset($get_usuario->rut_usuario)?$get_usuario->rut_usuario:'';
		$nombre_completo_trabajador = $nombres_trabajador.' '.$ap_paterno_trabajador.' '.$ap_materno_trabajador;

		$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
		$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
		$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
		$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

		$destinatarios_uno = array('gmaldonado@empresasintegra.cl','psicologos@empresasintegra.cl','jcruces@empresasintegra.cl','vmatamala@empresasintegra.cl');
		//$destinatarios_uno = array('gramirez@empresasintegra.cl');

		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);
	    $this->email->from('informaciones@empresasintegra.cl', 'Informacion Evaluaciones Integra');
	    $this->email->to($destinatarios_uno);
	    //$this->email->cco('soporte@empresasintegra.cl');
	    $this->email->subject("SE-SGO");
	    $this->email->message('Estimados el administrador(a) '.$nombre_completo_solicitante.' ha realizado una solicitud de revision de examenes del trabajdor: '.$nombre_completo_trabajador.' con el siguiente Rut: '.$rut_trabajador.'.<br>Saludos');
	    $this->email->send();
	    $this->session->set_userdata('exito',2);
		//echo "<script>alert('Solicitud/es de Revision Enviada/s Exitosamente')</script>";
		redirect('usuarios/home', 'refresh');
	}

	function listado_solicitudes_revision_examenes(){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Solicitud_revision_examenes_model');
		$this->load->model('Solicitud_revision_examenes_previos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Cargos_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Sre_evaluacion_req_model');
		$this->load->model('Sre_evaluacion_req_agenda_model');
		$this->load->model('Examenes_psicologicos_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Solicitudes revision de examenes pendientes",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes Pendientes' ) ),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$usuarios = $this->Solicitud_revision_examenes_model->get_result_en_proceso();
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();

			$proceso_completo = 0;

			$get_usu = $this->Usuarios_model->get($l->usuario_id);
			$ciudad = $this->Ciudad_model->get($get_usu->id_ciudades);
			$get_ultimo_req = $this->Requerimiento_asc_trabajadores_model->get_area_cargo_req_row($l->id_asc_trabajador);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud = $l->id;
			$aux->usuario_id = $l->usuario_id;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";
			$aux->id_asc_trab = isset($l->id_asc_trabajador)?$l->id_asc_trabajador:"";
			$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:NULL;
			$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_esperada_ingreso = isset($l->fecha_esperada_ingreso)?$l->fecha_esperada_ingreso:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";
			$aux->examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$aux->examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$aux->examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			//Inicio validacion examen masso
			if($examen_masso != 0){
				$masso = $this->Evaluaciones_model->get_una_masso($l->usuario_id);
				$aux->masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:NULL;

				if($masso_id != ""){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $masso_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 1,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$aux->sre_eval_req_id_masso = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_masso = "#D7DF01";
						$aux->letra_estado_eval_sre_masso = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_masso = "green";
						$aux->letra_estado_eval_sre_masso = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_masso = "red";
						$aux->letra_estado_eval_sre_masso = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_masso = "#886A08";
						$aux->letra_estado_eval_sre_masso = "NA";
					}else{
						$aux->color_estado_eval_sre_masso = "";
						$aux->letra_estado_eval_sre_masso = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_masso = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 1);
					$aux->id_sre_agenda_masso = isset($get_agenda_masso->id)?$get_agenda_masso->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_masso == NULL){
					$aux->masso = "N/D";
					$aux->color_masso = "";
					$aux->estado_masso = "N/D";
				}else{
					if($estado_masso >= 0 && $estado_masso <= 30){
						$color_masso = "#FF8000";
					}elseif($estado_masso < 0){
						$color_masso = "red";
					}elseif($estado_masso > 30){
						$color_masso = "green";
					}
					$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"N/D";
					$aux->color_masso = $color_masso;
					$aux->estado_masso = $estado_masso;
				}
			}else{
				$aux->sre_eval_req_id_masso = NULL;
				$aux->masso = "";
				$aux->color_masso = "";
				$aux->color_estado_eval_sre_masso = "";
				$aux->letra_estado_eval_sre_masso = "";
			}
			//Fin validacion examen masso
			//Inicio validacion examen preocupacional
			if($examen_preo != 0){
				$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($l->usuario_id);
				$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:NULL;
				$aux->preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;
				$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

				if($preo_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $preo_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 2,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_preo = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_preo = "#D7DF01";
						$aux->letra_estado_eval_sre_preo = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_preo = "green";
						$aux->letra_estado_eval_sre_preo = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_preo = "red";
						$aux->letra_estado_eval_sre_preo = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_preo = "#886A08";
						$aux->letra_estado_eval_sre_preo = "NA";
					}else{
						$aux->color_estado_eval_sre_preo = "";
						$aux->letra_estado_eval_sre_preo = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_preo = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 2);
					$aux->id_sre_agenda_preo = isset($get_agenda_preo->id)?$get_agenda_preo->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_preo == NULL){
					$aux->examen_pre = "N/D";
					$aux->color_preo = "";
					$aux->estado_preo = "N/D";
				}else{
					if($estado_preo >= 0 && $estado_preo <= 30){
						$color_preo = "#FF8000";
					}elseif($estado_preo < 0){
						$color_preo = "red";
					}elseif($estado_preo > 30){
						$color_preo = "green";
					}
					$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"N/D";
					$aux->color_preo = $color_preo;
					$aux->estado_preo = $estado_preo;
				}
			}else{
				$aux->sre_eval_req_id_preo = "";
				$aux->examen_pre = "";
				$aux->color_preo = "";
				$aux->color_estado_eval_sre_preo = "";
				$aux->letra_estado_eval_sre_preo = "";
			}
			//Fin validacion examen preocupacional
			//Inicio validacion examen psicologico
			if($examen_psicologico != 0){
				$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($l->usuario_id);
				$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
				$aux->eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;
				$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

				if($eval_psic_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $eval_psic_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 3,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_psic = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado_psic == 0){
						$aux->color_estado_eval_sre_psic = "#D7DF01";
						$aux->letra_estado_eval_sre_psic = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado_psic == 1){
						$aux->color_estado_eval_sre_psic = "green";
						$aux->letra_estado_eval_sre_psic = "A";
					}elseif($sre_eval_req_estado_psic == 2){
						$aux->color_estado_eval_sre_psic = "red";
						$aux->letra_estado_eval_sre_psic = "R";
					}elseif($sre_eval_req_estado_psic == 3){
						$aux->color_estado_eval_sre_psic = "#886A08";
						$aux->letra_estado_eval_sre_psic = "NA";
					}else{
						$aux->color_estado_eval_sre_psic = "";
						$aux->letra_estado_eval_sre_psic = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_psic = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 3);
					$aux->id_sre_agenda_psic = isset($get_agenda_psic->id)?$get_agenda_psic->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_psic == NULL){
					$aux->examen_psic = "N/D";
					$aux->color_psic = "";
					$aux->estado_psic = "N/D";
				}else{
					if($estado_psic >= 0 && $estado_psic <= 30){
						$color_psic = "#FF8000";
					}elseif($estado_psic < 0){
						$color_psic = "red";
					}elseif($estado_psic > 30){
						$color_psic = "green";
					}
					$aux->examen_psic = isset($examen_psic->fecha_vigencia)?$examen_psic->fecha_vigencia:"N/D";
					$aux->color_psic = $color_psic;
					$aux->estado_psic = $estado_psic;
				}
			}else{
				$aux->sre_eval_req_id_psic = "";
				$aux->examen_psic = "";
				$aux->color_psic = "";
				$aux->color_estado_eval_sre_psic = "";
				$aux->letra_estado_eval_sre_psic = "";
			}
			//Fin validacion examen psicologico

			if ($get_usu->id_especialidad_trabajador){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			if ($get_usu->id_especialidad_trabajador_2){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;

			$aux->proceso_completo = $proceso_completo;
			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 8 or $this->session->userdata('tipo_usuario') == 2 or $this->session->userdata('id') == 10)
			$pagina['tipo_usuario'] = "analista";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "SI";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('trabajadores/listado_solicitudes_revision_examen',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function solicitudes_revision_examenes_completas($fecha= false){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Solicitud_revision_examenes_model');
		$this->load->model('Solicitud_revision_examenes_previos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Cargos_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Sre_evaluacion_req_model');
		$this->load->model('Sre_evaluacion_req_agenda_model');
		$this->load->model('Examenes_psicologicos_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Solicitudes revision de examenes completas",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes Completas' ) ),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);
		if ($fecha =='historico') {
			//$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2();
			$usuarios = $this->Solicitud_revision_examenes_model->get_result_completas();
			$pagina['mes'] = 'historico';
		}elseif($fecha){
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			$usuarios = $this->Solicitud_revision_examenes_model->get_result_completas($fechaInicio, $fechaTermino);
			//$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2($fechaInicio, $fechaTermino);
			$f= explode("-", $fecha);
				$mes =$f[1];
			setlocale(LC_TIME, 'spanish');// para que los meses sean escritos en español
			$monthNum  = $mes;
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}else{

			$fecha = date('Y-m-d');
			$fechaI = new DateTime($fecha);
				$fechaI->modify('first day of this month');
				$fechaInicio = $fechaI->format('Y-m-d'); // imprime por ejemplo: 2018-08-01
			$fechaT = new DateTime($fecha);
				$fechaT->modify('last day of this month');
				$fechaTermino= $fechaT->format('Y-m-d'); // imprime por ejemplo: 2018-08-31
			//$trabajadores = $this->Requerimiento_Usuario_Archivo_model->listar_solicitudes_completas2($fechaInicio, $fechaTermino);
			$usuarios = $this->Solicitud_revision_examenes_model->get_result_completas($fechaInicio, $fechaTermino);
			setlocale(LC_TIME, 'spanish');
			$monthNum  = date('m');
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$nombreDelMes = strftime('%B', $dateObj->getTimestamp());
			$pagina['mes']= $nombreDelMes;
		}
		//$usuarios = $this->Solicitud_revision_examenes_model->get_result_completas();
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->usuario_id);
			$idCiudad = isset($get_usu->id_ciudades)?$get_usu->id_ciudades:false;
			$ciudad = $this->Ciudad_model->get($idCiudad);
			$get_ultimo_req = $this->Requerimiento_asc_trabajadores_model->get_area_cargo_req_row($l->id_asc_trabajador);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud = $l->id;
			$aux->usuario_id = $l->usuario_id;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";

			$aux->id_asc_trab = isset($l->id_asc_trabajador)?$l->id_asc_trabajador:"";
			$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:NULL;
			$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_esperada_ingreso = isset($l->fecha_esperada_ingreso)?$l->fecha_esperada_ingreso:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";
			$aux->examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$aux->examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$aux->examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$proceso_completo = 0;
			//Inicio validacion examen masso
			if($examen_masso != 0){
				$masso = $this->Evaluaciones_model->get_una_masso($l->usuario_id);
				$aux->masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:"";

				if($masso_id != ""){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $masso_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 1,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$aux->sre_eval_req_id_masso = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_masso = "#D7DF01";
						$aux->letra_estado_eval_sre_masso = "EP";
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_masso = "green";
						$aux->letra_estado_eval_sre_masso = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_masso = "red";
						$aux->letra_estado_eval_sre_masso = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_masso = "#886A08";
						$aux->letra_estado_eval_sre_masso = "NA";
					}else{
						$aux->color_estado_eval_sre_masso = "";
						$aux->letra_estado_eval_sre_masso = "";
					}
				}else{
					$get_agenda_masso = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 1);
					$aux->id_sre_agenda_masso = isset($get_agenda_masso->id)?$get_agenda_masso->id:NULL;
				}

				if(!$estado_masso){
					$aux->masso = "N/D";
					$aux->color_masso = "";
				}else{
					if($estado_masso >= 0 && $estado_masso <= 30){
						$color_masso = "#FF8000";
					}elseif($estado_masso < 0){
						$color_masso = "red";
					}elseif($estado_masso > 30){
						$color_masso = "green";
					}
					$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"";
					$aux->color_masso = $color_masso;
				}
			}else{
				$aux->sre_eval_req_id_masso = NULL;
				$aux->masso = "N/D";
				$aux->color_masso = "";
				$aux->color_estado_eval_sre_masso = "";
				$aux->letra_estado_eval_sre_masso = "";
			}
			//Fin validacion examen masso
			//Inicio validacion examen preocupacional
			if($examen_preo != 0){
				$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($l->usuario_id);
				$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:"";
				$aux->preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;
				$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

				if($preo_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $preo_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 2,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_preo = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_preo = "#D7DF01";
						$aux->letra_estado_eval_sre_preo = "EP";
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_preo = "green";
						$aux->letra_estado_eval_sre_preo = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_preo = "red";
						$aux->letra_estado_eval_sre_preo = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_preo = "#886A08";
						$aux->letra_estado_eval_sre_preo = "NA";
					}else{
						$aux->color_estado_eval_sre_preo = "";
						$aux->letra_estado_eval_sre_preo = "";
					}
				}else{
					$get_agenda_preo = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 2);
					$aux->id_sre_agenda_preo = isset($get_agenda_preo->id)?$get_agenda_preo->id:NULL;
				}

				if(!$estado_preo){
					$aux->examen_pre = "N/D";
					$aux->color_preo = "";
				}else{
					if($estado_preo >= 0 && $estado_preo <= 30){
						$color_preo = "#FF8000";
					}elseif($estado_preo < 0){
						$color_preo = "red";
					}elseif($estado_preo > 30){
						$color_preo = "green";
					}
					$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"";
					$aux->color_preo = $color_preo;
				}
			}else{
				$aux->sre_eval_req_id_preo = "";
				$aux->examen_pre = "N/D";
				$aux->color_preo = "";
				$aux->color_estado_eval_sre_preo = "";
				$aux->letra_estado_eval_sre_preo = "";
			}
			//Fin validacion examen preocupacional
			//Inicio validacion examen psicologico
			if($examen_psicologico != 0){
				$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($l->usuario_id);
				$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
				$aux->eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;
				$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

				if($eval_psic_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $eval_psic_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 3,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_psic = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado_psic == 0){
						$aux->color_estado_eval_sre_psic = "#D7DF01";
						$aux->letra_estado_eval_sre_psic = "EP";
						$proceso_completo += 1;
					}elseif($sre_eval_req_estado_psic == 1){
						$aux->color_estado_eval_sre_psic = "green";
						$aux->letra_estado_eval_sre_psic = "A";
					}elseif($sre_eval_req_estado_psic == 2){
						$aux->color_estado_eval_sre_psic = "red";
						$aux->letra_estado_eval_sre_psic = "R";
					}elseif($sre_eval_req_estado_psic == 3){
						$aux->color_estado_eval_sre_psic = "#886A08";
						$aux->letra_estado_eval_sre_psic = "NA";
					}else{
						$aux->color_estado_eval_sre_psic = "";
						$aux->letra_estado_eval_sre_psic = "";
						$proceso_completo += 1;
					}
				}else{
					$get_agenda_psic = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 3);
					$aux->id_sre_agenda_psic = isset($get_agenda_psic->id)?$get_agenda_psic->id:NULL;
					$proceso_completo += 1;
				}

				if($estado_psic == NULL){
					$aux->examen_psic = "N/D";
					$aux->color_psic = "";
					$aux->estado_preo = "N/D";
				}else{
					if($estado_psic >= 0 && $estado_psic <= 30){
						$color_psic = "#FF8000";
					}elseif($estado_psic < 0){
						$color_psic = "red";
					}elseif($estado_psic > 30){
						$color_psic = "green";
					}
					$aux->examen_psic = isset($examen_psic->fecha_vigencia)?$examen_psic->fecha_vigencia:"N/D";
					$aux->color_psic = $color_psic;
					$aux->estado_psic = $estado_psic;
				}
			}else{
				$aux->sre_eval_req_id_psic = "";
				$aux->examen_psic = "";
				$aux->color_psic = "";
				$aux->color_estado_eval_sre_psic = "";
				$aux->letra_estado_eval_sre_psic = "";
			}
			//Fin validacion examen psicologico

			$id_espec = isset($get_usu->id_especialidad_trabajador)?$get_usu->id_especialidad_trabajador:NULL;
			if($id_espec != NULL){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			$id_espec2 = isset($get_usu->id_especialidad_trabajador_2)?$get_usu->id_especialidad_trabajador_2:NULL;
			if($id_espec2 != NULL){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;
		
			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2)
			$pagina['tipo_usuario'] = "analista";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "SI";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('trabajadores/listado_solicitudes_revision_examen_visualizacion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function liberar_solicitud_revision($id_solicitud){
		$this->load->model('Solicitud_revision_examenes_model');

		$datos = array(
			'estado' => 1,
		);

		$this->Solicitud_revision_examenes_model->actualizar($id_solicitud, $datos);
		echo "<script>alert('Solicitud de Revision Actualizada Exitosamente')</script>";
		redirect('est/trabajadores/listado_solicitudes_revision_examenes', 'refresh');
	}

	function listado_solicitudes_completas_sre(){
		$this->load->model('Requerimiento_asc_trabajadores_model');
		$this->load->model('Solicitud_revision_examenes_model');
		$this->load->model('Solicitud_revision_examenes_previos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Cargos_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Empresa_planta_model');
		$this->load->model('Requerimientos_model');
		$this->load->model('Evaluaciones_model');
		$this->load->model('Sre_evaluacion_req_model');
		$this->load->model('Sre_evaluacion_req_agenda_model');
		$this->load->model('Examenes_psicologicos_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Solicitudes revision de examenes",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores Revision Examenes' ) ),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$usuarios = $this->Solicitud_revision_examenes_model->get_result_solicitudes_usu($this->session->userdata('id'));
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->usuario_id);
			$ciudad = $this->Ciudad_model->get($get_usu->id_ciudades);
			$get_ultimo_req = $this->Requerimiento_asc_trabajadores_model->get_area_cargo_req_row($l->id_asc_trabajador);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_solicitud = $l->id;
			$aux->usuario_id = $l->usuario_id;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";

			$aux->id_asc_trab = isset($l->id_asc_trabajador)?$l->id_asc_trabajador:"";
			$aux->referido = isset($get_ultimo_req->referido)?$get_ultimo_req->referido:NULL;
			$aux->nombre_cargo = isset($get_ultimo_req->nombre_cargo)?$get_ultimo_req->nombre_cargo:"";
			$aux->nombre_area = isset($get_ultimo_req->nombre_area)?$get_ultimo_req->nombre_area:"";
			$aux->id_req = isset($get_ultimo_req->id_req)?$get_ultimo_req->id_req:"";
			$aux->nombre_req = isset($get_ultimo_req->nombre_req)?$get_ultimo_req->nombre_req:"";
			$aux->empresa_planta = isset($get_ultimo_req->empresa_planta)?$get_ultimo_req->empresa_planta:"";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
			$aux->fecha_esperada_ingreso = isset($l->fecha_esperada_ingreso)?$l->fecha_esperada_ingreso:"";
			$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";
			$aux->examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$aux->examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$aux->examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			$examen_masso = isset($l->exam_masso)?$l->exam_masso:0;
			$examen_preo = isset($l->exam_preo)?$l->exam_preo:0;
			$examen_psicologico = isset($l->exam_psicologico)?$l->exam_psicologico:0;

			//Inicio validacion examen masso
			if($examen_masso != 0){
				$masso = $this->Evaluaciones_model->get_una_masso($l->usuario_id);
				$aux->masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
				$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:"";

				if($masso_id != ""){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $masso_id,
							'fecha_revision' => date('Y-m-d'),
							'tipo_examen' => 1,
							'estado' => 0,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $masso_id);
					$aux->sre_eval_req_id_masso = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_masso = "#D7DF01";
						$aux->letra_estado_eval_sre_masso = "EP";
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_masso = "green";
						$aux->letra_estado_eval_sre_masso = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_masso = "red";
						$aux->letra_estado_eval_sre_masso = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_masso = "#886A08";
						$aux->letra_estado_eval_sre_masso = "NA";
					}else{
						$aux->color_estado_eval_sre_masso = "";
						$aux->letra_estado_eval_sre_masso = "";
					}
				}else{
					$get_agenda_masso = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 1);
					$aux->id_sre_agenda_masso = isset($get_agenda_masso->id)?$get_agenda_masso->id:NULL;
				}

				if(!$estado_masso){
					$aux->masso = "N/D";
					$aux->color_masso = "";
				}else{
					if($estado_masso >= 0 && $estado_masso <= 30){
						$color_masso = "#FF8000";
					}elseif($estado_masso < 0){
						$color_masso = "red";
					}elseif($estado_masso > 30){
						$color_masso = "green";
					}
					$aux->masso = isset($masso->fecha_v)?$masso->fecha_v:"";
					$aux->color_masso = $color_masso;
				}
			}else{
				$aux->sre_eval_req_id_masso = NULL;
				$aux->masso = "N/D";
				$aux->color_masso = "";
				$aux->color_estado_eval_sre_masso = "";
				$aux->letra_estado_eval_sre_masso = "";
			}
			//Fin validacion examen masso
			//Inicio validacion examen preocupacional
			if($examen_preo != 0){
				$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($l->usuario_id);
				$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:"";
				$aux->preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;
				$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

				if($preo_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $preo_id,
							'fecha_revision' => date('Y-m-d'),
							'tipo_examen' => 2,
							'estado' => 0,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $preo_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_preo = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado == 0){
						$aux->color_estado_eval_sre_preo = "#D7DF01";
						$aux->letra_estado_eval_sre_preo = "EP";
					}elseif($sre_eval_req_estado == 1){
						$aux->color_estado_eval_sre_preo = "green";
						$aux->letra_estado_eval_sre_preo = "A";
					}elseif($sre_eval_req_estado == 2){
						$aux->color_estado_eval_sre_preo = "red";
						$aux->letra_estado_eval_sre_preo = "R";
					}elseif($sre_eval_req_estado == 3){
						$aux->color_estado_eval_sre_preo = "#886A08";
						$aux->letra_estado_eval_sre_preo = "NA";
					}else{
						$aux->color_estado_eval_sre_preo = "";
						$aux->letra_estado_eval_sre_preo = "";
					}
				}else{
					$get_agenda_preo = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 2);
					$aux->id_sre_agenda_preo = isset($get_agenda_preo->id)?$get_agenda_preo->id:NULL;
				}

				if(!$estado_preo){
					$aux->examen_pre = "N/D";
					$aux->color_preo = "";
				}else{
					if($estado_preo >= 0 && $estado_preo <= 30){
						$color_preo = "#FF8000";
					}elseif($estado_preo < 0){
						$color_preo = "red";
					}elseif($estado_preo > 30){
						$color_preo = "green";
					}
					$aux->examen_pre = isset($examen_pre->fecha_v)?$examen_pre->fecha_v:"";
					$aux->color_preo = $color_preo;
				}
			}else{
				$aux->sre_eval_req_id_preo = "";
				$aux->examen_pre = "N/D";
				$aux->color_preo = "";
				$aux->color_estado_eval_sre_preo = "";
				$aux->letra_estado_eval_sre_preo = "";
			}
			//Fin validacion examen preocupacional
			//Inicio validacion examen psicologico
			if($examen_psicologico != 0){
				$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($l->usuario_id);
				$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
				$aux->eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;
				$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

				if($eval_psic_id != NULL){
					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

					if($id_sre_eval_req == NULL){
						$datos_sre_eval_req = array(
							'id_solicitud_revision' => $l->id,
							'id_evaluacion' => $eval_psic_id,
							'fecha_revision' => date('Y-m-d'),
							'estado' => 0,
							'tipo_examen' => 3,
						);
						$this->Sre_evaluacion_req_model->guardar($datos_sre_eval_req);
					}

					$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($l->id, $eval_psic_id);
					$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$aux->sre_eval_req_id_psic = isset($get_eval_sre->id)?$get_eval_sre->id:'';
					$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

					if($sre_eval_req_estado_psic == 0){
						$aux->color_estado_eval_sre_psic = "#D7DF01";
						$aux->letra_estado_eval_sre_psic = "EP";
					}elseif($sre_eval_req_estado_psic == 1){
						$aux->color_estado_eval_sre_psic = "green";
						$aux->letra_estado_eval_sre_psic = "A";
					}elseif($sre_eval_req_estado_psic == 2){
						$aux->color_estado_eval_sre_psic = "red";
						$aux->letra_estado_eval_sre_psic = "R";
					}elseif($sre_eval_req_estado_psic == 3){
						$aux->color_estado_eval_sre_psic = "#886A08";
						$aux->letra_estado_eval_sre_psic = "NA";
					}else{
						$aux->color_estado_eval_sre_psic = "";
						$aux->letra_estado_eval_sre_psic = "";
					}
				}else{
					$get_agenda_psic = $this->Sre_evaluacion_req_agenda_model->get_tipo($l->id, 3);
					$aux->id_sre_agenda_psic = isset($get_agenda_psic->id)?$get_agenda_psic->id:NULL;
				}

				if($estado_psic == NULL){
					$aux->examen_psic = "N/D";
					$aux->color_psic = "";
					$aux->estado_preo = "N/D";
				}else{
					if($estado_psic >= 0 && $estado_psic <= 30){
						$color_psic = "#FF8000";
					}elseif($estado_psic < 0){
						$color_psic = "red";
					}elseif($estado_psic > 30){
						$color_psic = "green";
					}
					$aux->examen_psic = isset($examen_psic->fecha_vigencia)?$examen_psic->fecha_vigencia:"N/D";
					$aux->color_psic = $color_psic;
					$aux->estado_psic = $estado_psic;
				}
			}else{
				$aux->sre_eval_req_id_psic = "";
				$aux->examen_psic = "";
				$aux->color_psic = "";
				$aux->color_estado_eval_sre_psic = "";
				$aux->letra_estado_eval_sre_psic = "";
			}
			//Fin validacion examen psicologico

			$id_espec = isset($get_usu->id_especialidad_trabajador)?$get_usu->id_especialidad_trabajador:NULL;
			if($id_espec != NULL){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			$id_espec2 = isset($get_usu->id_especialidad_trabajador_2)?$get_usu->id_especialidad_trabajador_2:NULL;
			if($id_espec2 != NULL){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;
		
			array_push($lista,$aux);
			unset($aux);
		}

		if($this->session->userdata('tipo_usuario') == 5)
			$pagina['tipo_usuario'] = "psicologo";
		elseif($this->session->userdata('tipo_usuario') == 1 or $this->session->userdata('tipo_usuario') == 2)
			$pagina['tipo_usuario'] = "analista";
		elseif($this->session->userdata('tipo_usuario') == 4)
			$pagina['tipo_usuario'] = "est_externo";
		else
			$pagina['tipo_usuario'] = "error";

		$pagina['listado'] = $lista;
		$pagina['usuario_analista'] = "NO";
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['lista_requerimientos'] = $this->Requerimientos_model->r_listar_activos();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('trabajadores/listado_solicitudes_revision_examen_visualizacion',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_agendar_examen($id_solicitud, $tipo_examen, $estado = FALSE){
		$this->load->model('Sre_evaluacion_req_agenda_model');
		if($tipo_examen == 1)
			$examen = "Masso";
		elseif ($tipo_examen == 2)
			$examen = "Preocupacional";
		elseif($tipo_examen == 3)
			$examen = "Psicologico";

		if($estado == 1)
			$pagina['estado_bloqueo'] = "SI";
		else
			$pagina['estado_bloqueo'] = "NO";

		$pagina['id_solicitud'] = $id_solicitud;
		$pagina['tipo_examen'] = $examen;
		$pagina['id_tipo_examen'] = $tipo_examen;
		$pagina['agendado'] = $this->Sre_evaluacion_req_agenda_model->get_tipo($id_solicitud, $tipo_examen);
		$this->load->view('trabajadores/modal_agendar_solicitud_examen',$pagina);
	}

	function modal_editar_sre_eval_req($id_registro, $estado = FALSE, $idExamen = false){
		$this->load->model("Sre_evaluacion_req_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionescargos_model");
		$this->load->model("Cargos_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Examenes_psicologicos_model");

		if($estado == 1)
			$pagina['estado_bloqueo'] = "SI";
		else
			$pagina['estado_bloqueo'] = "NO";

		$get_registro = $this->Sre_evaluacion_req_model->get_registro($id_registro);
		$id_eval = isset($get_registro->id_evaluacion)?$get_registro->id_evaluacion:"";
		$id_tipo_eval = isset($get_registro->tipo_examen)?$get_registro->tipo_examen:"";
		$get_eval = $this->Evaluaciones_model->get($id_eval);
		$get_cargos_aptos_eval = $this->Evaluacionescargos_model->get_eval($id_eval);
		if($id_tipo_eval == 2){
			$cargos_aptos = array();
			if (!empty($get_cargos_aptos_eval)){
				foreach ($get_cargos_aptos_eval as $cg) {
					$get_cargo = $this->Cargos_model->r_get($cg->id_r_cargo);
					$archivo = new StdClass();
					$archivo->nombre_cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
					array_push($cargos_aptos, $archivo);
				}
				unset($archivo);
			}
		}else{
			$cargos_aptos = array();
		}
		if ($idExamen) {// #08-01-2018 si vengo desde el perfil psicologo consultar sobre las fecha de vigencia del examen
			$this->load->model('Usuarios_model');
			$this->load->model('Examenes_psicologicos_model');
			$this->load->model('Examenes_psicologicos_archivos_model');
			$this->load->model('usuarios/Usuarios_general_model');
			$this->load->model('Empresa_planta_model');
			$this->load->model('Cargos_model');
			$this->load->model('Especialidadtrabajador_model');
			$get_id_examen = $this->Examenes_psicologicos_model->get_result($idExamen);
			$listado = array();
			foreach ($get_id_examen as $l){
				$aux = new stdClass();
				$get_usuario = $this->Usuarios_model->get($l->usuario_id);
				$get_cargo_postulacion = $this->Cargos_model->r_get($l->cargo_postulacion_id);
				$get_lugar_trabajo = $this->Empresa_planta_model->get($l->lugar_trabajo_id);
				$get_solicitante = $this->Usuarios_general_model->get($l->solicitante_id);
				$get_psicologo_evaluador = $this->Usuarios_model->get_datos_psicologo_row($l->psicologo_evaluador);

				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:"";
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:"";
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:"";

				$nombre_usu = isset($get_usuario->nombres)?$get_usuario->nombres:"";
				$paterno_usu = isset($get_usuario->paterno)?$get_usuario->paterno:"";
				$materno_usu = isset($get_usuario->materno)?$get_usuario->materno:"";

				$nombre_psicologo = isset($get_psicologo_evaluador->nombres)?$get_psicologo_evaluador->nombres:"";
				$ap_psicologo = isset($get_psicologo_evaluador->paterno)?$get_psicologo_evaluador->paterno:"";
				$am_psicologo = isset($get_psicologo_evaluador->materno)?$get_psicologo_evaluador->materno:"";
				$aux->usuario_id = $l->usuario_id;
				$aux->nombres_usuario = $nombre_usu." ".$paterno_usu." ".$materno_usu;
				$aux->lugar_trabajo = isset($get_lugar_trabajo->nombre)?$get_lugar_trabajo->nombre:"";
				$aux->solicitante = $nombre_solicitante." ".$paterno_solicitante." ".$materno_solicitante;
				$aux->psicologo = $nombre_psicologo." ".$ap_psicologo." ".$am_psicologo;
				$aux->psicologo_id = isset($get_psicologo_evaluador->id)?$get_psicologo_evaluador->id:"";
				$aux->especialidad_post = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:"";

				if($l->tecnico_supervisor == 1){
					$aux->tecnico_supervisor = "Tecnico";
				}elseif($l->tecnico_supervisor == 2){
					$aux->tecnico_supervisor = "Supervisor";
				}else{
					$aux->tecnico_supervisor = "";
				}

				$aux->sueldo_definido = isset($l->sueldo_definido)?$l->sueldo_definido:"0";
				$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
				$aux->fecha_evaluacion = isset($l->fecha_evaluacion)?$l->fecha_evaluacion:"";
				$aux->fecha_vigencia = isset($l->fecha_vigencia)?$l->fecha_vigencia:"0000-00-00";
				$aux->resultado = isset($l->resultado)?$l->resultado:"";
				$aux->referido = isset($l->referido)?$l->referido:"";
				$aux->observaciones = isset($l->observaciones)?$l->observaciones:"";

				$get_archivo_informe = $this->Examenes_psicologicos_archivos_model->get_archivo_informe($idExamen);
				$aux->url_informe = isset($get_archivo_informe->id)?$get_archivo_informe->url:"NE";
				$aux->id_archivo_examen = isset($get_archivo_informe->id)?$get_archivo_informe->id:"0";

				$id_espec = isset($get_usuario->id_especialidad_trabajador)?$get_usuario->id_especialidad_trabajador:NULL;
				if($id_espec != NULL){
					$e1 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador);
					$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
				}else
					$aux->especialidad1 = false;

				$id_espec2 = isset($get_usuario->id_especialidad_trabajador_2)?$get_usuario->id_especialidad_trabajador_2:NULL;
				if($id_espec2 != NULL){
					$e2 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_2);
					$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
				}else
					$aux->especialidad2 = false;

				$id_espec3 = isset($get_usuario->id_especialidad_trabajador_3)?$get_usuario->id_especialidad_trabajador_3:NULL;
				if($id_espec3 != NULL){
					$e3 = $this->Especialidadtrabajador_model->get($get_usuario->id_especialidad_trabajador_3);
					$aux->especialidad3 = (!empty($e3->desc_especialidad))?$e3->desc_especialidad:FALSE;
				}else
					$aux->especialidad3 = false;

				array_push($listado,$aux);
				unset($aux);
			}
			$pagina['datos_examen'] = $listado;
			$pagina['idExamen'] = $idExamen;
			$pagina['psicologos'] = $this->Usuarios_model->listar_psicologos_activos();
			$pagina['examenPsicologico']= true;
		}
		//var_dump($id_tipo_eval);
		//$pagina['id_tipo_eval'] = $id_tipo_eval;
		$pagina['cargos_aptos'] = $cargos_aptos;
		$pagina['id_tipo_eval'] = $id_tipo_eval;
		$pagina['lista_aux'] = $this->Sre_evaluacion_req_model->get_result($id_registro);
		$this->load->view('est/trabajadores/modal_editar_sre_evaluacion_req', $pagina);
	}

	function actualizar_sre_eval_req(){
		$this->load->model("Sre_evaluacion_req_model");
		$this->load->model("Solicitud_revision_examenes_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Examenes_psicologicos_model");
		$this->load->model("Usuarios_model");
		$this->load->model("usuarios/Usuarios_general_model");

		$id_registro = $_POST['id_registro'];
		$datos = array(
			'fecha_gestion' => date('Y-m-d'),
			'estado' => $_POST['estado'],
			'observaciones' => $_POST['observaciones'],
		);
		$this->Sre_evaluacion_req_model->actualizar($id_registro, $datos);
		/*$arrayAuditoria= array(
			'estado'=>$_POST['estado'],
			'id_personal' => $this->session->userdata('id'),
			);
		$this->Sre_evaluacion_req_model->auditoriaSave($arrayAuditoria);*/
		$get_registro = $this->Sre_evaluacion_req_model->get_registro($id_registro);
		$id_solicitud_revision = isset($get_registro->id_solicitud_revision)?$get_registro->id_solicitud_revision:"";
		$get_solicitud = $this->Solicitud_revision_examenes_model->get_row($id_solicitud_revision);

		$proceso_completo = 0;
		$examen_masso = isset($get_solicitud->exam_masso)?$get_solicitud->exam_masso:0;
		$examen_preo = isset($get_solicitud->exam_preo)?$get_solicitud->exam_preo:0;
		$examen_psicologico = isset($get_solicitud->exam_psicologico)?$get_solicitud->exam_psicologico:0;
		$usuario_id = isset($get_solicitud->usuario_id)?$get_solicitud->usuario_id:0;

		//Inicio validacion examen masso
		if($examen_masso != 0){
			$masso = $this->Evaluaciones_model->get_una_masso($usuario_id);
			$masso_id = isset($masso->id_masso)?$masso->id_masso:NULL;
			$estado_masso = isset($masso->estado_masso)?$masso->estado_masso:NULL;

			if($masso_id != ""){
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $masso_id);
				$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $masso_id);
				$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
				$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

				if($sre_eval_req_estado == 0){
					$proceso_completo += 1;
				}elseif($sre_eval_req_estado == 1){
				}elseif($sre_eval_req_estado == 2){
				}elseif($sre_eval_req_estado == 3){
				}else{
					$proceso_completo += 1;
				}
			}else{
				$proceso_completo += 1;
			}
		}
		//Fin validacion examen masso
		//Inicio validacion examen preocupacional
		if($examen_preo != 0){
			$examen_pre = $this->Evaluaciones_model->get_una_preocupacional($usuario_id);
			$estado_preo = isset($examen_pre->estado_preo)?$examen_pre->estado_preo:NULL;
			$preo_id = isset($examen_pre->preo_id)?$examen_pre->preo_id:NULL;

			if($preo_id != NULL){
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $preo_id);
				$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $preo_id);
				$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
				$sre_eval_req_estado = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

				if($sre_eval_req_estado == 0){
					$proceso_completo += 1;
				}elseif($sre_eval_req_estado == 1){
				}elseif($sre_eval_req_estado == 2){
				}elseif($sre_eval_req_estado == 3){
				}else{
					$proceso_completo += 1;
				}
			}else{
				$proceso_completo += 1;
			}
		}
		//Fin validacion examen preocupacional
		//Inicio validacion examen psicologico
		if($examen_psicologico != 0){
			$examen_psic = $this->Examenes_psicologicos_model->get_ultimo_examen($usuario_id);
			$estado_psic = isset($examen_psic->estado_psic)?$examen_psic->estado_psic:NULL;
			$eval_psic_id = isset($examen_psic->eval_psic_id)?$examen_psic->eval_psic_id:NULL;

			if($eval_psic_id != NULL){
				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $eval_psic_id);
				$id_sre_eval_req = isset($get_eval_sre->id)?$get_eval_sre->id:NULL;

				$get_eval_sre = $this->Sre_evaluacion_req_model->get_row($id_solicitud_revision, $eval_psic_id);
				$sre_eval_req_id = isset($get_eval_sre->id)?$get_eval_sre->id:'';
				$sre_eval_req_estado_psic = isset($get_eval_sre->estado)?$get_eval_sre->estado:'';

				if($sre_eval_req_estado_psic == 0){
					$proceso_completo += 1;
				}elseif($sre_eval_req_estado_psic == 1){
				}elseif($sre_eval_req_estado_psic == 2){
				}elseif($sre_eval_req_estado_psic == 3){
				}else{
					$proceso_completo += 1;
				}
			}else{
				$proceso_completo += 1;
			}
			#07-01-2019
			if (isset($_POST['idExamen'])) {
				$this->load->model('Examenes_psicologicos_model');
				$this->load->model('Examenes_psicologicos_archivos_model');
				$id_examen = $_POST['idExamen'];
				//$usuario_id = $_POST['usuario_id'];

				if(isset($_POST['ano_v']) && isset($_POST['mes_v']) && isset($_POST['dia_v'])){
					$fecha_v = $_POST['ano_v'].'-'.$_POST['mes_v'].'-'.$_POST['dia_v'];
				}else{
					$fecha_v = '0000-00-00';
				}

				if(isset($_POST['ano_e']) && isset($_POST['mes_e']) && isset($_POST['dia_e'])){
					$fecha_e = $_POST['ano_e'].'-'.$_POST['mes_e'].'-'.$_POST['dia_e'];
				}else{
					$fecha_e = '0000-00-00';
				}

				$datos_examen = array(
					'psicologo_evaluador' => $_POST['psicologo'],
					'fecha_evaluacion' => $fecha_e,
					'fecha_vigencia' => $fecha_v,
					'resultado' => $_POST['resultado'],
					'observaciones' => $_POST['observaciones'],
				/*	'estado' => 1,*/
					'estado_ultimo_examen' => 0
				);

				$estado_cero = array('estado_ultimo_examen' => '0');
			//	$this->Examenes_psicologicos_model->actualizar_estado_ultimo_examen($usuario_id, $estado_cero);
				$this->Examenes_psicologicos_model->actualizar($id_examen, $datos_examen);
			}
		}
		//Fin validacion examen psicologico

		if($proceso_completo == 0){
			$proceso_completo_array = array(
				'estado' => 1,
			);
			$this->Solicitud_revision_examenes_model->actualizar($id_solicitud_revision, $proceso_completo_array);
			
			//avisar via email cuando se completa la revision de la solicitud
			$id_solicitante = isset($get_solicitud->solicitante_id)?$get_solicitud->solicitante_id:'';
			$id_trabajador = isset($get_solicitud->usuario_id)?$get_solicitud->usuario_id:'';

			$get_usuario = $this->Usuarios_model->get($id_trabajador);
			$get_solicitante = $this->Usuarios_general_model->get($id_solicitante);
			$nombres_trabajador = isset($get_usuario->nombres)?$get_usuario->nombres:'';
			$ap_paterno_trabajador = isset($get_usuario->paterno)?$get_usuario->paterno:'';
			$ap_materno_trabajador = isset($get_usuario->materno)?$get_usuario->materno:'';
			$rut_trabajador = isset($get_usuario->rut_usuario)?$get_usuario->rut_usuario:'';
			$nombre_completo_trabajador = $nombres_trabajador.' '.$ap_paterno_trabajador.' '.$ap_materno_trabajador;

			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
			$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
			$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

			/*$this->load->library('email');
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'informaciones@empresasintegra.cl';
			$config['smtp_pass'] = '%SYkNLH1';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Informacion Evaluaciones Integra');
		    $this->email->to($email_solicitante);
		    $this->email->cc('jcruces@empresasintegra.cl','vmatamala@empresasintegra.cl');
	    	//$this->email->cco('soporte@empresasintegra.cl');
		    $this->email->subject("RE-SGO");
		    $this->email->message('Estimado(a) '.$nombre_completo_solicitante.' su solicitud de revision de examenes del trabajador '.$nombre_completo_trabajador.' con el siguiente Rut: '.$rut_trabajador.' ha sido finalizado con exito.<br>Saludos');
		    $this->email->send();*/
		}
		//echo "<script>alert('Solicitud/es de Revision Enviada/s Exitosamente')</script>";
		//redirect('est/trabajadores/listado_solicitudes_revision_examenes', 'refresh');
		echo json_encode(1);
	}
	function pruebaqla(){
		echo json_encode(1);
	}

	function ingresar_agenda_de_examen(){
		$this->load->model('Sre_evaluacion_req_agenda_model');

		$id_agendado = $_POST['id_agendado'];
		$id_solicitud_sre = $_POST['id_solicitud'];
		$id_tipo_examen = $_POST['id_tipo_examen'];
		$lugar = $_POST['lugar'];
		$hora = $_POST['hora'];
		$observaciones = $_POST['observaciones'];

		if(isset($_POST['ano_fn']) && isset($_POST['mes_fc']) && isset($_POST['dia_fc'])){
			$fecha_citacion = $_POST['ano_fn'].'-'.$_POST['mes_fc'].'-'.$_POST['dia_fc'];
		}else {
			$fecha_citacion = '0000-00-00';
		}

		$datos = array(
			'id_sre' => $id_solicitud_sre,
			'id_tipo_examen' => $id_tipo_examen,
			'fecha_citacion' => $fecha_citacion,
			'lugar' => $lugar,
			'hora' => $hora,
			'observaciones' => $observaciones,
		);

		if($id_agendado == NULL)
			$this->Sre_evaluacion_req_agenda_model->guardar($datos);
		else
			$this->Sre_evaluacion_req_agenda_model->actualizar($id_agendado, $datos);

		//faltar enviar a administrador de contrato datos de la agenda

		echo "<script>alert('Agenda ingresada exitosamente')</script>";
		redirect('est/trabajadores/listado_solicitudes_revision_examenes', 'refresh');
	}

	function examen_psicologico(){
		$this->load->model('Examenes_psicologicos_previos_model');
		$this->load->model('Usuarios_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Cargos_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model('Empresa_planta_model');

		$base = array(
			'head_titulo' => "Sistema EST - Listado trabajadores",
			'titulo' => "Listado trabajadores a examen psicologico",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt'=>'Listado Trabajadores' ), array('url'=>'','txt'=>'Listado Trabajadores a Examen Psicologico' ) ),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		if( $this->session->flashdata('usuario_req') ){
			foreach ($this->session->flashdata('usuario_req') as $r){
				$existe = $this->Examenes_psicologicos_previos_model->consultar_si_existe($r);
				$datos = array(
					'id_usuario' => $r,
					'id_solicitante' => $this->session->userdata('id'),
					'estado' => 1,
				);

				$id_consulta = isset($existe->id)?$existe->id:NULL;

				if($id_consulta != NULL){
					$this->Examenes_psicologicos_previos_model->actualizar($id_consulta, $datos);
				}else{
					$this->Examenes_psicologicos_previos_model->guardar($datos);
				}
			}
		}

		$usuarios = $this->Examenes_psicologicos_previos_model->get_result($this->session->userdata('id'));
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->id_usuario);
			$ciudad = $this->Ciudad_model->get($get_usu->id_ciudades);

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->usuario_id = $l->id_usuario;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->fono = isset($get_usu->fono)?$get_usu->fono:"";
			$aux->fecha_nac = isset($get_usu->fecha_nac)?$get_usu->fecha_nac:"";
			$aux->desc_ciudades = isset($ciudad->desc_ciudades)?ucwords(mb_strtolower($ciudad->desc_ciudades,'UTF-8')):"";

			if ($get_usu->id_especialidad_trabajador){
				$e1 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador);
				$aux->especialidad1 = ($e1->desc_especialidad)?ucwords(mb_strtolower($e1->desc_especialidad,'UTF-8')):FALSE;	
			}else
				$aux->especialidad1 = false;

			if ($get_usu->id_especialidad_trabajador_2){
				$e2 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_2);
				$aux->especialidad2 = (!empty($e2->desc_especialidad))?ucwords(mb_strtolower($e2->desc_especialidad,'UTF-8')):FALSE;
			}else
				$aux->especialidad2 = false;

			if ($get_usu->id_especialidad_trabajador_3){
				$e3 = $this->Especialidadtrabajador_model->get($get_usu->id_especialidad_trabajador_3);
				$aux->especialidad3 = (!empty($e3->desc_especialidad))?$e3->desc_especialidad:FALSE;
			}else
				$aux->especialidad3 = false;
		
			array_push($lista,$aux);
			unset($aux);
		}

		$pagina['listado'] = $lista;
		$pagina['empresas_plantas'] = $this->Empresa_planta_model->listar();
		$pagina['r_cargos'] = $this->Cargos_model->r_listar();
		$base['cuerpo'] = $this->load->view('trabajadores/listado_examen_psicologico',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	#/Edit 26-12-2018 para saltarse liberacion de jose cruces pasa directo  a psicologos
	function enviar_solicitud_examen_psicologico(){
		$this->load->model("Examenes_psicologicos_model");
		$this->load->model("Examenes_psicologicos_previos_model");
		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c=>$valores){
				$data = array(
					"usuario_id" => $valores,
					"solicitante_id" => $this->session->userdata('id'),
					"cargo_postulacion_id" => (!empty($_POST['cargo_postulacion'][$c]))?$_POST['cargo_postulacion'][$c]:false,
					"lugar_trabajo_id" => (!empty($_POST['lugar_trabajo'][$c]))?$_POST['lugar_trabajo'][$c]:false,
					"tecnico_supervisor" => (!empty($_POST['superv_tecnico'][$c]))?$_POST['superv_tecnico'][$c]:false,
					"sueldo_definido" => (!empty($_POST['sueldo_definido'][$c]))?$_POST['sueldo_definido'][$c]:false,
					"referido" => (!empty($_POST['referido'][$c]))?$_POST['referido'][$c]:false,
					"fecha_solicitud" => date ("Y-m-d H:i:s"),
					"fecha_evaluacion" => '1991-01-01',
					"fecha_vigencia" => '1991-01-01',
					"estado" => '0',
					"liberacion" => '1'
				);
				$this->Examenes_psicologicos_model->guardar($data);
				$this->Examenes_psicologicos_previos_model->eliminar($valores);
			}
		}
		echo "<script>alert('Solicitud/es Enviada/s Exitosamente')</script>";
		redirect('usuarios/home', 'refresh');
	}

	function liberacion_examen_psicologico(){
		$this->load->model("Examenes_psicologicos_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Cargos_model");
		$this->load->model("Empresa_planta_model");
		$this->load->model("usuarios/Usuarios_general_model");
		
		$base = array(
			'head_titulo' => "Lista de Trabajadores a Examen Psicologico - Sistema EST",
			'titulo' => "Listado de trabajadores",
			'subtitulo' => '',
			'side_bar' => false,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'','txt'=>'Listado Trabajadores' )),
			'menu' => $this->menu,
			'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_req.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
		);

		$usuarios = $this->Examenes_psicologicos_model->usuarios_pendiente_aprobacion();
		$lista = array();
		foreach ($usuarios as $l){
			$aux = new stdClass();
			$get_usu = $this->Usuarios_model->get($l->usuario_id);
			$get_solicitante = $this->Usuarios_general_model->get($l->solicitante_id);
			$get_lugar_trabajo = $this->Empresa_planta_model->get($l->lugar_trabajo_id);
			$get_cargo_postulacion = $this->Cargos_model->r_get($l->cargo_postulacion_id);
			$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
			$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
			$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';

			$nombre = isset($get_usu->nombres)?$get_usu->nombres:"";
			$paterno = isset($get_usu->paterno)?$get_usu->paterno:"";
			$materno = isset($get_usu->materno)?$get_usu->materno:"";
			$aux->id_registro = $l->id;
			$aux->usuario_id = $l->usuario_id;
			$aux->rut = isset($get_usu->rut_usuario)?$get_usu->rut_usuario:"";
			$aux->nombres = $nombre." ".$paterno." ".$materno;
			$aux->solicitante = $nombre_solicitante." ".$paterno_solicitante." ".$materno_solicitante;
			$aux->lugar_trabajo = isset($get_lugar_trabajo->nombre)?$get_lugar_trabajo->nombre:"";
			$aux->especialidad_post = isset($get_cargo_postulacion->nombre)?$get_cargo_postulacion->nombre:"";
			$aux->referido = isset($l->referido)?$l->referido:"";

			if($l->tecnico_supervisor == 1){
				$aux->tecnico_supervisor = "Tecnico";
			}elseif($l->tecnico_supervisor == 2){
				$aux->tecnico_supervisor = "Supervisor";
			}else{
				$aux->tecnico_supervisor = "";
			}
			$aux->sueldo_definido = isset($l->sueldo_definido)?$l->sueldo_definido:"0";
			$aux->fecha_solicitud = isset($l->fecha_solicitud)?$l->fecha_solicitud:"";
		
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;		
		$base['cuerpo'] = $this->load->view('trabajadores/listado_liberacion_exam_psicologico',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar_solicitud_previa_revision_examen($id){
		$this->load->model("Solicitud_revision_examenes_previos_model");
		$this->Solicitud_revision_examenes_previos_model->eliminar_segun_id($id);
		$this->session->set_userdata('exito',1);
		//echo "<script>alert('Solicitud Eliminada Exitosamente')</script>";
		redirect('est/trabajadores/solicitudes_revision_examenes', 'refresh');
	}

	function eliminar_solicitud_examen_psicologico($id){
		$this->load->model("Examenes_psicologicos_model");
		$this->Examenes_psicologicos_model->eliminar_solicitud($id);
		echo "<script>alert('Solicitud Eliminada Exitosamente')</script>";
		redirect('est/trabajadores/liberacion_examen_psicologico', 'refresh');
	}

	function enviar_aprobacion_examen_psicologico(){
		$this->load->model("Examenes_psicologicos_model");

		if (!empty($_POST['check_estado'])?$_POST['check_estado']:false){
			foreach($_POST['check_estado'] as $c){
				$data = array(
					"liberacion" => 1,
					"fecha_liberacion" => date('Y-m-d')
				);
				$this->Examenes_psicologicos_model->actualizar($c, $data);
			}
		}
		echo "<script>alert('Solicitudes Aprobadas Exitosamente')</script>";
		redirect('est/trabajadores/liberacion_examen_psicologico', 'refresh');
	}

	function exportar_excel(){
		if( $this->session->flashdata('usuario_req') ){
			$this->load->model("Usuarios2_model");
			$campos = array();
			if ( !empty($_POST['id']) )
				$campos[] = "id";
			if ( !empty($_POST['nb']) ){
				$campos[] = "nombres";
				$campos[] = "paterno";
				$campos[] = "materno";
			}
			if ( !empty($_POST['rut']) )
				$campos[] = "rut_usuario";
			if ( !empty($_POST['fono']) )
				$campos[] = "fono";
			if ( !empty($_POST['email']) )
				$campos[] = "email";
			if ( !empty($_POST['fn']) )
				$campos[] = "fecha_nac";
			if ( !empty($_POST['dire']) )
				$campos[] = "direccion";
			if ( !empty($_POST['esp']) )
				$campos[] = "id_especialidad_trabajador";
			if ( !empty($_POST['civil']) )
				$campos[] = "id_estadocivil";
			if ( !empty($_POST['ciudad']) )
				$campos[] = "id_ciudades";
			if ( !empty($_POST['afp']) )
				$campos[] = "id_afp";
			if ( !empty($_POST['salud']) )
				$campos[] = "id_salud";
			
			$this->load->library('PHPExcel');
		
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			//$objReader = PHPExcel_IOFactory::createReader('Excel2007');

			$col = 1;
			foreach ($this->session->flashdata('usuario_req') as $r) {
				$s = $this->Usuarios2_model->seleccionar_campos($campos,$r);
				
				foreach ($s as $key => $val){
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(($key), $col, $val);
				}
				$col++;
			}
			$objPHPExcel->getActiveSheet()->setTitle('Report');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			header("Content-Disposition: attachment; filename=exportacion_personal_est.xlsx");
			$objWriter->save('php://output');
		}
		else
			echo "No a seleccionado ningun trabajador, intente nuevamente!!!";
	}

	function modal_requerimiento(){
		$this->load->model("Grupo_model");
		$this->load->model("Requerimiento_origen_model");
		$id = 2;
		$listado_grupo['grupo'] = $this->Grupo_model->listar();
		$listado_grupo['origen'] = $this->Requerimiento_origen_model->listar();
		$this->load->view('trabajadores/modal_requerimiento',$listado_grupo);
	}

	function req_ajax(){
		$id = $_POST['id'];
		$this->load->model("Requerimientos_model");
		$salida = $this->Requerimientos_model->listar_grupo($id);
		echo json_encode($salida);
	}
	function asign_ajax(){
		$id = $_POST['id'];
		$this->load->model("Requerimientos_model");
		$salida = $this->Requerimientos_model->get($id);
		echo json_encode($salida);
	}
	function trabajadores_ajax(){
		$id = $_REQUEST['id'];
		$this->load->model("Usuarios_model");
		foreach ($id as $v) {
			$salida[] = $this->Usuarios_model->get($v);
		}
		
		echo json_encode($salida);
	}

	function origen_ajax(){
		$this->load->model("Requerimiento_origen_model");
		$salida = $this->Requerimiento_origen_model->listar();
		
		echo json_encode($salida);
	}

	function sesion_usuarios_req(){
		$this->load->library('session');
		$tipo = $_GET['tipo']; //agrega o quita usuario
		$usr = $_GET['usuario']; //ID usuario
		$listado = array();
		$data = array(
			'tipo' => $tipo,
			'id' => $usr
		);
		if( is_array($this->session->flashdata('usr_req')) ){
			$this->session->keep_flashdata('usr_req');
			array_push($listado,$this->session->flashdata('usr_req') );
			array_push($listado,$data);
			//$data = array_merge( $data , $this->session->flashdata('usr_req'));
			$this->session->set_flashdata('usr_req', $listado);
		}
		else{
			$this->session->set_flashdata('usr_req', $data);
		}

		print_r($this->session->flashdata('usr_req'));

	}

	function rut_existe(){
		$this->load->model("Usuarios_model");
		$rut = $_GET['rut'];

		$salida = $this->Usuarios_model->get_rut($rut);

		if(is_array($salida))
			echo false;
		else
			echo true;

	}

	function requerimiento_ajax(){
		$trab = $_POST['trabajadores'];
		$idre = $_POST['id'];
		$origen = $_POST['origen'];
		$this->load->model("Asignarrequerimiento_model");
		$this->load->model("Requerimientos_model");

		$r = $this->Requerimientos_model->get($idre);

		foreach ($trab as $v) {
			$data = array(
				'id_r_requerimiento' => $idre, 
				'id_usuarios' => $v,
				'id_requerimiento_origen' => $origen,
				'f_inicio' => $r->f_inicio,
				'f_fin' => $r->f_fin
			);
			$this->Asignarrequerimiento_model->ingresar($data);
		}
		//$this->session->set_flashdata('req_guardado', 'true');
		echo "guardado";
	}
	function filtrar(){
		$this->load->library('encrypt');
		
		if(empty($_POST['nombre']) ) $_POST['nombre'] = FALSE;
		if(empty($_POST['rut']) ) $_POST['rut'] = FALSE;
		if(empty($_POST['profesion']) ) $_POST['profesion'] = FALSE;
		if(empty($_POST['especialidad']) ) $_POST['especialidad'] = FALSE;
		if(empty($_POST['ciudad']) ) $_POST['ciudad'] = FALSE;
		if(empty($_POST['clave']) ) $_POST['clave'] = FALSE;
		$url = "nombre/".$_POST['nombre']."/rut/".$_POST['rut']."/profesion/".$_POST['profesion']."/especialidad/".$_POST['especialidad']."/ciudad/".$_POST['ciudad']."/clave/".$_POST['clave'];
		$enc = urlencode($this->encrypt->encode($url));
		redirect('/administracion/trabajadores/buscar/filtro/'.$enc, 'refresh');
	}

	function evaluar() {
		$base['titulo'] = "Evaluar trabajador";
		$base['lugar'] = "Evaluaciones";
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function editar($id,$msg = FALSE){
		$this->load->model('Usuarios_model');
		$this->load->model('Estadocivil_model');
		$this->load->model('Bancos_model');
		$this->load->model('Afp_model');
		$this->load->model('Excajas_model');
		$this->load->model('Region_model');
		$this->load->model('Provincia_model');
		$this->load->model('Ciudad_model');
		$this->load->model('Salud_model');
		$this->load->model('Nivelestudios_model');
		$this->load->model('Profesiones_model');
		$this->load->model('Especialidadtrabajador_model');
		$this->load->model("Tipoarchivos_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Experiencia_model");
		
		$base['titulo'] = "Editar mi perfil";
		$base['lugar'] = "Editar Perfil";
		
		/**** AVISOS Y MENSAJES ****/
		if($msg == "personal_vacio"){
			$aviso['titulo'] = "No olvide datos con asterisco son obligatorios";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "tecnico_vacio"){
			$aviso['titulo'] = "No olvide datos con asterisco son obligatorios";
			$pagina['aviso_tecnico'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_vacio"){
			$aviso['titulo'] = "Uno o más campos estan vacios, todos son obligatorios";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "extra_vacio"){
			$aviso['titulo'] = "Uno o más campos estan vacios, todos son obligatorios";
			$pagina['aviso_extra'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_error1"){
			$aviso['titulo'] = "La nueva contraseña no coincide al repetirla";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_error2"){
			$aviso['titulo'] = "La contraseña original no es la misma";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "img_error"){
			$aviso['titulo'] = "Hubo un error al subir la imagen, intentelo nuevamente";
			$pagina['aviso_imagen'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "personal_exito"){
			$aviso['titulo'] = "Los datos han sido actualizados correctamente";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "pass_exito"){
			$aviso['titulo'] = "La contraseña ah sido cambiada exitosamente";
			$pagina['aviso_pass'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "img_exito"){
			$aviso['titulo'] = "La imagen ah sido cambiada exitosamente";
			$pagina['aviso_imagen'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_exito"){
			$aviso['titulo'] = "El archivo fue guardado exitosamente";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_vacio"){
			$aviso['titulo'] = "Tiene que adjuntar un archivo, esta vacio";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_error0"){
			$aviso['titulo'] = "El archivo tiene una extención no soportada";;
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_error1"){
			$aviso['titulo'] = "No se pudo guardar el archivo, intente nuevamente";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_borrar_exito"){
			$aviso['titulo'] = "El archivo fue borrardo exitosamente";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "archivo_repetido"){
			$aviso['titulo'] = "El curriculum no puede ser ingresado 2 veces, favor borrar el archivo anterior";
			$pagina['aviso_archivo'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "email_invalido"){
			$aviso['titulo'] = "El email ingresado es invalido";
			$pagina['aviso_personal'] = $this->load->view('avisos',$aviso,TRUE);
		}
		/***************************/

		$arch = $this->Archivos_trab_model->get_usuario($id);
		$listado = array();
		foreach ($arch as $a) {
			$aux = new stdClass();
			$aux->id = $a->id_archivo;
			$aux->nb_tipo = $a->desc_tipoarchivo;
			$aux->url = $a->url;
			$aux->fecha = $a->fecha;
			$aux->nb_archivo = $a->nombre;
			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['listado_archivo'] = $listado;
		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['civil'] = $this->Estadocivil_model->listar();
		$pagina['bancos'] = $this->Bancos_model->listar();
		$pagina['salud'] = $this->Salud_model->listar();
		$pagina['afp'] = $this->Afp_model->listar();
		$pagina['excajas'] = $this->Excajas_model->listar();
		$pagina['lvl_estudios'] = $this->Nivelestudios_model->listar();
		$pagina['profesiones'] = $this->Profesiones_model->listar();
		$pagina['esp_trab'] = $this->Especialidadtrabajador_model->listar();
		$pagina['regiones'] = $this->Region_model->listar();
		$pagina['ciudades'] = $this->Ciudad_model->listar();
		$pagina['provincias'] = $this->Provincia_model->listar();
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$pagina['listado_tipo'] = $this->Tipoarchivos_model->listar();
		$pagina['listado_archivos'] = $this->Archivos_trab_model->get_usuario($id);
		$pagina['experiencia'] = $this->Experiencia_model->get_usuario($id);
		$pagina['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Novienbre","Diciembre");
		$base['cuerpo'] = $this->load->view('trabajadores/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	public function ajax_modal_experiencia($id_usr, $id_exp = false){
		$this->load->model("Experiencia_model");
		$base['meses'] = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$base['form_url'] = 'administracion/trabajadores/guardar_experiencia/'.$id_usr;
		if( $id_exp ) {
			$base['exp'] = $this->Experiencia_model->get($id_exp);
			$base['form_url'] = 'administracion/trabajadores/editar_experiencia/'.$id_usr;
		}
		$this->load->view('trabajadores/modal_experiencia',$base);
	}
	
	function eliminar_experiencia($id_usr,$id_exp){
		$this->load->model("Experiencia_model");
		$this->Experiencia_model->borrar($id_exp);
		redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
	}
	
	function guardar_experiencia($id_usr) {
		if( empty( $_POST['select_dia_desde'] ) || empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_dia_hasta'] ) || empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'];
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'];
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			else{
				$this->load->model("Experiencia_model");
				$data = array(
					'id_usuarios' => $id_usr,
					'desde' => $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'],
					'hasta' => $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'],
					'cargo' => $_POST['cargo'],
					'area' => $_POST['area'],
					'empresa_c' => $_POST['contratista'],
					'empresa_m' => $_POST['mandante'],
					'funciones' => $_POST['funciones'],
					'referencias' => $_POST['referencias']
				);
				$this->Experiencia_model->ingresar($data);
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			}
		}
	}

	function editar_experiencia($id_usr, $id_exp){
		if( empty( $_POST['select_dia_desde'] ) || empty( $_POST['select_mes_desde'] ) || empty( $_POST['select_ano_desde'] ) || 
		empty( $_POST['select_dia_hasta'] ) || empty( $_POST['select_mes_hasta'] ) || empty( $_POST['select_ano_hasta'] ) ||
		empty( $_POST['cargo'] ) || empty( $_POST['area'] ) || empty( $_POST['contratista'] ) || empty( $_POST['funciones'] ) ){
			redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
		}
		else{
			$fecha1 = $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'];
			$fecha2 = $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'];
			
			if( (strtotime($fecha2) - strtotime($fecha1)) < 0 )
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			else{
				$this->load->model("Experiencia_model");
				$data = array(
					'desde' => $_POST['select_ano_desde'].'-'.$_POST['select_mes_desde'].'-'.$_POST['select_dia_desde'],
					'hasta' => $_POST['select_ano_hasta'].'-'.$_POST['select_mes_hasta'].'-'.$_POST['select_dia_hasta'],
					'cargo' => $_POST['cargo'],
					'area' => $_POST['area'],
					'empresa_c' => $_POST['contratista'],
					'empresa_m' => $_POST['mandante'],
					'funciones' => $_POST['funciones'],
					'referencias' => $_POST['referencias']
				);
				$this->Experiencia_model->editar($id_exp,$data);
				redirect('administracion/trabajadores/editar/'.$id_usr.'#datos-experiencia', 'refresh');
			}
		}
	}

	function guardar(){
		$data = array(
			'nombres' => trim($_POST['nombres']),
			'paterno' => trim($_POST['paterno']),
			'materno' => trim($_POST['materno']),
			'rut_usuario' => trim($_POST['rut']),
			'fono1' => trim($_POST['fono1']),
			'fono2' => trim($_POST['fono2']),
			'fono3' => trim($_POST['fono3']),
			'fono4' => trim($_POST['fono4']),
			'direccion' => trim($_POST['direccion']),
			'email' => trim($_POST['email']),
			'id_regiones' => $_POST['select_region'],
			'id_provincias' => $_POST['select_provincia'],
			'id_ciudades' => $_POST['select_ciudad'],
			'nacionalidad' => trim($_POST['nacionalidad']),
			'nac_dia' => $_POST['select_nac_dia'],
			'nac_mes' => $_POST['select_nac_mes'],
			'nac_ano' => $_POST['select_nac_ano'],
			'id_afp' => $_POST['select_afp'],
			'id_salud' => $_POST['select_salud'],
			'sexo' => $_POST['select_sexo'],
			'id_estadocivil' => $_POST['select_civil'],
			'id_profesiones' => $_POST['select_profesion'],
			'id_bancos' => $_POST['select_banco'],
			'id_especialidad_trabajador' => $_POST['select_especialidad'],
			'id_especialidad_trabajador_2' => $_POST['select_especialidad2'],
			'tipo_cuenta' => trim($_POST['t_cuenta']),
			'cuenta_banco' => trim($_POST['n_cuenta']),
			'talla_buzo' => trim($_POST['select_talla']),
			'num_zapato' => trim($_POST['n_zapato']),
			'licencia' => trim($_POST['licencia']),
			'id_estudios' => $_POST['select_estudios'],
			'institucion' => trim($_POST['institucion']),
			'ano_egreso' => trim($_POST['a_egreso']),
			'ano_experiencia' => trim($_POST['a_experiencia']),
			'cursos' => trim($_POST['cursos']),
			'equipos' => trim($_POST['equipos']),
			'software' => trim($_POST['software']),
			'idiomas' => trim($_POST['idiomas'])
		);
		$this->session->set_flashdata('ingreso', $data);
		
		if(empty($_POST['nombres']) || empty($_POST['paterno']) || empty($_POST['materno']) || empty($_POST['rut']) || empty($_POST['fono1'])  || empty($_POST['fono2'])
		|| empty($_POST['direccion']) || empty($_POST['pass1']) || empty($_POST['pass2']) || empty($_POST['select_region']) || empty($_POST['select_provincia']) || 
		 empty($_POST['select_ciudad']) ){
		 	redirect('administracion/trabajadores/agregar/error_vacio', 'refresh');
		 }
		else{
			if($_POST['pass1'] != $_POST['pass2']){
				redirect('administracion/trabajadores/agregar/error_pass', 'refresh');
			}
			else{
				if(!empty($_POST['email'])){
					if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
						redirect('administracion/trabajadores/agregar/error_email_valid', 'refresh');
					}
				}
				$this->load->model("Usuarios_model");
				if($this->Usuarios_model->get_rut(mb_strtoupper($_POST['rut'], 'UTF-8')))
					redirect('administracion/trabajadores/agregar/error_rut', 'refresh');
				else{
					if(empty($_POST['select_banco'])) $_POST['select_banco'] = NULL;
					if(empty($_POST['fono1'])|| empty($_POST['fono2'])) $fono1 = NULL;
					else $fono1 = trim($_POST['fono1']).'-'.trim($_POST['fono2']);
					if(empty($_POST['fono3'])|| empty($_POST['fono4'])) $fono2 = NULL;
					else $fono2 = trim($_POST['fono3']).'-'.trim($_POST['fono4']);
					if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) )
						$nacimiento = NULL;
					else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];
					$_POST['t_cuenta'] = trim($_POST['t_cuenta']);
					if(empty($_POST['email'])) $_POST['email'] = NULL;
					if(empty($_POST['nacionalidad'])) $_POST['nacionalidad'] = NULL;
					if(empty($_POST['select_afp'])) $_POST['select_afp'] = NULL;
					if(empty($_POST['select_salud'])) $_POST['select_salud'] = NULL;
					if(empty($_POST['select_civil'])) $_POST['select_civil'] = NULL;
					if(empty($_POST['select_profesion'])) $_POST['select_profesion'] = NULL;
					if(empty($_POST['select_especialidad'])) $_POST['select_especialidad'] = NULL;
					if(empty($_POST['select_especialidad2'])) $_POST['select_especialidad2'] = NULL;
					if(empty($_POST['t_cuenta'])) $_POST['t_cuenta'] = NULL;
					if(empty($_POST['n_cuenta'])) $_POST['n_cuenta'] = NULL;
					if(empty($_POST['select_talla'])) $_POST['select_talla'] = NULL;
					if(empty($_POST['n_zapato'])) $_POST['n_zapato'] = NULL;
					if(empty($_POST['licencia'])) $_POST['licencia'] = NULL;
					if(empty($_POST['select_estudios'])) $_POST['select_estudios'] = NULL;
					if(empty($_POST['institucion'])) $_POST['institucion'] = NULL;
					if(empty($_POST['a_egreso'])) $_POST['a_egreso'] = NULL;
					if(empty($_POST['a_experiencia'])) $_POST['a_experiencia'] = NULL;
					if(empty($_POST['cursos'])) $_POST['cursos'] = NULL;
					if(empty($_POST['equipos'])) $_POST['equipos'] = NULL;
					if(empty($_POST['software'])) $_POST['software'] = NULL;
					if(empty($_POST['idiomas'])) $_POST['idiomas'] = NULL;
					
					$data2 = array(
					'id_tipo_usuarios' => 2,
					'nombres' => mb_strtoupper(trim($_POST['nombres']), 'UTF-8'),
					'paterno' => mb_strtoupper(trim($_POST['paterno']), 'UTF-8'),
					'materno' => mb_strtoupper(trim($_POST['materno']), 'UTF-8'),
					'rut_usuario' => mb_strtoupper(trim($_POST['rut']), 'UTF-8'),
					'fono' => $fono1,
					'telefono2' => $fono2,
					'direccion' => mb_strtoupper(trim($_POST['direccion']), 'UTF-8'),
					'email' => mb_strtoupper(trim($_POST['email']), 'UTF-8'),
					'clave' => hash("sha512", trim($_POST['pass1'])),
					'id_regiones' => $_POST['select_region'],
					'id_provincias' => $_POST['select_provincia'],
					'id_ciudades' => $_POST['select_ciudad'],
					'nacionalidad' => trim($_POST['nacionalidad']),
					'fecha_nac' => $nacimiento,
					'id_afp' => $_POST['select_afp'],
					'id_salud' => $_POST['select_salud'],
					'sexo' => $_POST['select_sexo'],
					'id_estadocivil' => $_POST['select_civil'],
					'id_profesiones' => $_POST['select_profesion'],
					'id_bancos' => $_POST['select_banco'],
					'id_especialidad_trabajador' => $_POST['select_especialidad'],
					'id_especialidad_trabajador_2' => $_POST['select_especialidad2'],
					'tipo_cuenta' => mb_strtoupper(trim($_POST['t_cuenta']), 'UTF-8'),
					'cuenta_banco' => trim($_POST['n_cuenta']),
					'talla_buzo' => $_POST['select_talla'],
					'num_zapato' => trim($_POST['n_zapato']),
					'licencia' => mb_strtoupper(trim($_POST['licencia']), 'UTF-8'),
					'id_estudios' => $_POST['select_estudios'],
					'institucion' => trim($_POST['institucion']),
					'ano_egreso' => trim($_POST['a_egreso']),
					'ano_experiencia' => trim($_POST['a_experiencia']),
					'cursos' => trim($_POST['cursos']),
					'equipos' => trim($_POST['equipos']),
					'software' => trim($_POST['software']),
					'idiomas' => trim($_POST['idiomas'])
					);
					$id_salida = $this->Usuarios_model->ingresar($data2);
					redirect('administracion/trabajadores/editar/'.$id_salida.'#datos-personales', 'refresh');
				}
			}
		}
	}

	function guardar_personales($id){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		if(empty($_POST['nombres'])) $_POST['nombres'] = NULL;
		if(empty($_POST['paterno'])) $_POST['paterno'] = NULL;
		if(empty($_POST['direccion'])) $_POST['direccion'] = NULL;
		if(empty($_POST['select_sexo'])) $_POST['select_sexo'] = NULL;
		if(empty($_POST['email'])) $_POST['email'] = NULL;
		if(empty($_POST['select_civil'])) $_POST['select_civil'] = NULL;
		if(empty($_POST['select_nacionalidad'])) $_POST['select_nacionalidad'] = NULL;
		if(empty($_POST['select_nac_ano']) || empty($_POST['select_nac_mes']) || empty($_POST['select_nac_dia']) ) $nacimiento = FALSE;
		else $nacimiento = $_POST['select_nac_ano'].'-'.$_POST['select_nac_mes'].'-'.$_POST['select_nac_dia'];
		if( empty($_POST['fono_1']) || empty($_POST['fono_2']) ) $fono1 = NULL;
		else $fono1 = trim($_POST['fono_1'])."-".trim($_POST['fono_2']);
		if( empty($_POST['fono_3']) || empty($_POST['fono_3']) ) $fono2 = NULL;
		else $fono2 = trim($_POST['fono_3'])."-".trim($_POST['fono_4']);

		if(!empty($_POST['email'])){
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				redirect('administracion/trabajadores/editar/'.$id.'/email_invalido#datos-personales', 'refresh');
			}
		}
		
		$data = array(
			'nombres' => trim($_POST['nombres']),
			'paterno' => trim($_POST['paterno']),
			'materno' => trim($_POST['materno']),
			'fecha_nac' => $nacimiento,
			'direccion' => trim($_POST['direccion']),
			'sexo' => $_POST['select_sexo'],
			'fono' => $fono1,
			'telefono2' => $fono2,
			'email' => trim($_POST['email']),
			'id_estadocivil' => $_POST['select_civil'],
			'id_ciudades' => $_POST['select_ciudad'],
			'nacionalidad' => $_POST['select_nacionalidad'],
			'fecha_actualizacion' => date('Y-m-d')
		);
		$this->Usuarios_model->editar($id,$data);
		redirect('administracion/trabajadores/editar/'.$id.'#datos-personales', 'refresh');
	}

	function guardar_tecnicos($id){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		if( empty($_POST['select_nivelestudios']) ) $_POST['select_nivelestudios'] = NULL;
		if( empty($_POST['nb_institucion']) ) $_POST['nb_institucion'] = NULL;
		if( empty($_POST['ano_egreso']) ) $_POST['ano_egreso'] = NULL;
		if( empty($_POST['select_profesion']) ) $_POST['select_profesion'] = NULL;
		if( empty($_POST['select_especialidad1']) ) $_POST['select_especialidad1'] = NULL;
		if( empty($_POST['select_especialidad2']) ) $_POST['select_especialidad2'] = NULL;
		if( empty($_POST['ano_experiencia']) ) $_POST['ano_experiencia'] = NULL;
		if( empty($_POST['cursos']) ) $_POST['cursos'] = NULL;
		if( empty($_POST['equipos']) ) $_POST['equipos'] = NULL;
		if( empty($_POST['software']) ) $_POST['software'] = NULL;
		if( empty($_POST['idiomas']) ) $_POST['idiomas'] = NULL;
		
		$data = array(
			'id_estudios' => $_POST['select_nivelestudios'],
			'institucion' => trim($_POST['nb_institucion']),
			'ano_egreso' => trim($_POST['ano_egreso']),
			'id_profesiones' => $_POST['select_profesion'],
			'id_especialidad_trabajador' => $_POST['select_especialidad1'],
			'id_especialidad_trabajador_2' => $_POST['select_especialidad2'],
			'ano_experiencia' => trim($_POST['ano_experiencia']),
			'cursos' => trim($_POST['cursos']),
			'equipos' => trim($_POST['equipos']),
			'software' => trim($_POST['software']),
			'idiomas' => trim($_POST['idiomas']),
			'fecha_actualizacion' => date('Y-m-d')
		);
		$this->Usuarios_model->editar($id,$data);
		redirect('administracion/trabajadores/editar/'.$id.'#datos-tecnicos', 'refresh');
	}

	function guardar_extras($id){
		$this->load->model('Usuarios_model');
		date_default_timezone_set('America/Santiago');
		
		if(empty($_POST['tipo_cuenta'])) $_POST['tipo_cuenta'] = NULL;
		if(empty($_POST['n_cuenta'])) $_POST['n_cuenta'] = NULL;
		if(empty($_POST['select_afp'])) $_POST['select_afp'] = NULL;
		if(empty($_POST['select_salud'])) $_POST['select_salud'] = NULL;
		if(empty($_POST['licencia'])) $_POST['licencia'] = NULL;
		if(empty($_POST['zapato'])) $_POST['zapato'] = NULL;
		if(empty($_POST['select_talla'])) $_POST['select_talla'] = NULL;
		
		$data = array(
			'tipo_cuenta' => trim($_POST['tipo_cuenta']),
			'cuenta_banco' => trim($_POST['n_cuenta']),
			'id_afp' => $_POST['select_afp'],
			'id_salud' => $_POST['select_salud'],
			'licencia' => trim($_POST['licencia']),
			'num_zapato' => trim($_POST['zapato']),
			'talla_buzo' => $_POST['select_talla'],
			'fecha_actualizacion' => date('Y-m-d')
		);
		if(!empty($_POST['select_excaja']))
			$data = array_merge($data, array('id_excajas' => $_POST['select_excaja']));
		if(!empty($_POST['select_banco']))
			$data = array_merge($data,array('id_bancos' => $_POST['select_banco']));
		//print_r($data);			
		$this->Usuarios_model->editar($id,$data);
		redirect('administracion/trabajadores/editar/'.$id.'#datos-extras', 'refresh');
	}

	function guardar_archivo($id){
		if($_FILES['documento']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Tipoarchivos_model");
			$this->load->model("Archivos_trab_model");
			$this->load->model("Usuarios_model");

			if($_POST['select_archivo'] == 13){
				$la = $this->Archivos_trab_model->get_usuario($id);
				foreach ($la as $l) {
				 	if( $l->id_tipoarchivo == 13)
				 		redirect('administracion/trabajadores/editar/'.$id.'/archivo_repetido#datos-archivo', 'refresh');
				}
			}
			
			$tipo = $this->Tipoarchivos_model->get($_POST['select_archivo'])->desc_tipoarchivo;
			$tipo = str_replace(" ", "_", $tipo);
			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = normaliza($aux)."_".normaliza($usuario->paterno).'_'.normaliza($usuario->materno);
			$nb_archivo = strtolower($id."_".trim($ape));
			$nb_archivo = urlencode($nb_archivo);
			$salida = subir($_FILES,"documento","extras/docs/",$nb_archivo);
			if($salida == 1)
				redirect('administracion/trabajadores/editar/'.$id.'/archivo_error0#datos-archivo', 'refresh');
			elseif($salida==2)
				redirect('administracion/trabajadores/editar/'.$id.'/archivo_error1#datos-archivo', 'refresh');
			else{
				$data = array(
					'id_usuarios' => $id,
					'nombre' => $nb_archivo,
					'id_tipoarchivo' => $_POST['select_archivo'],
					'url' => $salida
 				);
				$this->Archivos_trab_model->ingresar($data);
				redirect('administracion/trabajadores/editar/'.$id.'/archivo_exito#datos-archivo', 'refresh');
			}
		}
		else redirect('administracion/trabajadores/editar/'.$id.'/archivo_vacio#datos-archivo', 'refresh');
	}
	
	function guardar_imagen($id){
		$this->load->model('Fotostrab_model');
		$this->load->model('Usuarios_model');
		$this->load->helper("imagen");
		date_default_timezone_set('America/Santiago');
		
		if($_FILES['imagen']['error'] == 0){
			$salida = subir($_FILES, 'imagen', 'extras/img/perfil/','440','440');
			$salida_thumb = subir($_FILES, 'imagen', 'extras/img/perfil/thumb/','72','72');
			$salida_media = subir($_FILES, 'imagen', 'extras/img/perfil/thumb/','104','104');
			$foto_existe = $this->Fotostrab_model->get_usuario($id);
			if( count($foto_existe) > 0 ){
				$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
				$ruta_prin = $ruta_prin[0];
				$imagen = $foto_existe->nombre_archivo;
				$thumb = $foto_existe->thumb;
				$media = $foto_existe->media;
				unlink($ruta_prin.$imagen);
				unlink($ruta_prin.$thumb);
				unlink($ruta_prin.$media);
				$this->Fotostrab_model->borrar($id);
			}
			
			$data = array(
				'id_usuarios' => $id,
				'nombre_archivo' => $salida,
				'thumb' => $salida_thumb,
				'media' => $salida_media,
				'fecha' => strftime( "%Y-%m-%d %H-%M-%S", time())
			);
			$this->Fotostrab_model->ingresar($data);
			$this->session->set_userdata('imagen', $salida_thumb);
			$data2 = array('fecha_actualizacion' => date('Y-m-d'));
			$this->Usuarios_model->editar($id,$data2);
			redirect('administracion/trabajadores/editar/'.$id.'/img_exito#datos-imagen', 'refresh');
		}
		else{
			redirect('administracion/trabajadores/editar/'.$id.'/img_error#datos-imagen', 'refresh');
		}
	}

	function cambiar_contrasena($id){
		if( empty($_POST['pass_nueva1']) || empty($_POST['pass_nueva2']) ){
			redirect('administracion/trabajadores/editar/'.$id.'/pass_vacio#datos-pass', 'refresh');
		}
		else{
			if(trim($_POST['pass_nueva1']) == trim($_POST['pass_nueva2'])){
				$this->load->model('Usuarios_model');
				$data = array("clave" => hash("sha512", $_POST['pass_nueva1']));
				$this->Usuarios_model->editar($id,$data);
				redirect('administracion/trabajadores/editar/'.$id.'/pass_exito#datos-pass', 'refresh');
			}
			else
				redirect('administracion/trabajadores/editar/'.$id.'/pass_error1#datos-pass', 'refresh');
		}
	}
	
	function eliminar_trabajador($id){
		$this->load->model('Usuarios_model');
		$this->Usuarios_model->eliminar($id);
	}
	
	function desactivar($id){
		$this->load->model('Usuarios_model');
		$u = $this->Usuarios_model->get($id);
		if ($u->activo == 0){
			$data = array(
				'activo' => 1,
			);
			$s = 1;
		}
		else{
			$data = array(
				'activo' => 0,
			);
			$s = 0;
		}
		
		$this->Usuarios_model->editar($id,$data);
		return $s;
	}

	function eliminar_archivo($id_usuario,$id_archivo){
		$this->load->model("Archivos_trab_model");
		$arch = $this->Archivos_trab_model->get($id_archivo);
		unlink(getcwd().'/'.$arch->url);
		$this->Archivos_trab_model->eliminar($id_archivo);
		redirect('administracion/trabajadores/editar/'.$id_usuario.'/archivo_borrar_exito#datos-archivo', 'refresh');
	}
	
	function subir(){
		$this->load->model("Usuarios_model");
		$this->load->model("Bancos_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Afp_model");
		$this->load->model("Excajas_model");
		$this->load->model("Salud_model");
		$this->load->model("Nivelestudios_model");
		
		$this->load->helper("archivo");
		$this->load->helper("excel");
		$base['titulo'] = "Log de Subida de Trabajador";
		$base['lugar'] = "Log Trabajador";
		
		if($_FILES['archivo']['error'] == 0){
			$salida = trabajadores($_FILES, 'archivo', 'extras/docs_temp/','trabajadores');
			if($salida == 1)
				redirect('administracion/trabajadores/subir_archivo/error_formato', 'refresh');
			elseif($salida == 2)
				redirect('administracion/trabajadores/subir_archivo/error_copiar', 'refresh');
			else{
				
				$lista_texto = array('RUT','NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','DIRECCIÓN','CORREO ELECTRÓNICO','TELÉFONO','TELÉFONO 2','REGIÓN','PROVINCIA','CIUDAD','FECHA NACIMIENTO','NACIONALIDAD','SEXO','ESTADO CIVIL','PROFESION','BANCO','TIPO DE CUENTA','NUMERO DE CUENTA','ESPECIALIDAD 1','ESPECIALIDAD 2','ESPECIALIDAD 3','AFP','EXCAJA','SALUD','NUMERO DE ZAPATO','TALLA DE BUZO','LICENCIA','ESTUDIOS','INSTIUCIÓN','AÑO DE EGRESO','AÑOS DE EXPERIENCIA','CURSOS','EQUIPOS','SOFTWARE','IDIOMAS');
				$lista_asoc = array('rut_usuario','nombres','paterno','materno','direccion','email','fono','telefono2','id_regiones','id_provincias','id_ciudades','fecha_nac','nacionalidad','sexo','id_estadocivil','id_profesiones','id_bancos','tipo_cuenta','cuenta_banco','id_especialidad_trabajador','id_especialidad_trabajador_2','id_especialidad_trabajador_3','id_afp','id_excajas','id_salud','num_zapato','talla_buzo','licencia','id_estudios','institucion','ano_egreso','ano_experiencia','cursos','equipos','software','idiomas');
				//$loadPHPExcel->load($ruta_prin.$salida);
				//echo $salida;
				$salida = importar_trabajadores($salida, $lista_texto, $lista_asoc);
				
				//validar si la table contiene datos llenos y/o sin los nombres correctos
				
				
			}
		}
		else{
			redirect('administracion/trabajadores/subir_archivo/error', 'refresh');
		}
		if(count($salida['correcto']) > 0){
			$consulta = $salida['consulta'];
			$totales = count($salida['correcto']);
			$i = 0;
			foreach($salida['correcto'] as $c){
				$i++;
				$consulta.= $c;
				if( $totales > $i ) $consulta.=',';
			}
			$consulta.=";";
			$this->Usuarios_model->manual($consulta);
		}
		
		$pagina['resultados'] = $salida;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/subir_errores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function generar_excel(){
		$this->load->model("Usuarios_model");
		$this->load->model("Bancos_model");
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Afp_model");
		$this->load->model("Excajas_model");
		$this->load->model("Salud_model");
		$this->load->model("Nivelestudios_model");
		
		
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		
		$ruta_prin = explode("index.php",$_SERVER['SCRIPT_FILENAME']);
		$ruta_prin = $ruta_prin[0];
		
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();
		$styleArray = array(
			'font' => array('bold' => true)
		);
		$lista_celdas = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1','T1','U1','V1','W1','X1','Y1','Z1','AA1','AB1','AC1','AD1','AE1','AF1','AG1','AH1','AI1','AJ1');
		$lista_texto = array('RUT','NOMBRES','APELLIDO PATERNO','APELLIDO MATERNO','DIRECCIÓN','CORREO ELECTRÓNICO','TELÉFONO','TELÉFONO 2','REGIÓN','PROVINCIA','CIUDAD','FECHA NACIMIENTO','NACIONALIDAD','SEXO','ESTADO CIVIL','PROFESION','BANCO','TIPO DE CUENTA','NUMERO DE CUENTA','ESPECIALIDAD 1','ESPECIALIDAD 2','ESPECIALIDAD 3','AFP','EXCAJA','SALUD','NUMERO DE ZAPATO','TALLA DE BUZO','LICENCIA','ESTUDIOS','INSTIUCIÓN','AÑO DE EGRESO','AÑOS DE EXPERIENCIA','CURSOS','EQUIPOS','SOFTWARE','IDIOMAS');
		for($i=0;$i<count($lista_celdas);$i++){ //llenar los titulos del excel, la primera fila
			$sheet->setCellValue($lista_celdas[$i], $lista_texto[$i]);
			$sheet->getStyle($lista_celdas[$i])->applyFromArray($styleArray);
		}
		$l = 2;
		foreach($this->Bancos_model->listar() as $b){ //llenar el listado de bancos en una celda
			$sheet->setCellValue('Q'.$l, $b->desc_bancos);
			$l++;
		}
		$sheet->setCellValue('G2', '041-123456'); //ejemplo de telefono
		$sheet->setCellValue('H2', '09-87654321'); //ejemplo de celular
		$r = 2;
		foreach($this->Region_model->listar() as $b){ //llenar el listado de regiones en una celda
			$sheet->setCellValue('I'.$r, $b->desc_regiones);
			$r++;
		}
		$p = 2;
		foreach($this->Provincia_model->listar() as $b){ //llenar el listado de provincias en una celda
			$sheet->setCellValue('J'.$p, $b->desc_provincias);
			$p++;
		}
		$c = 2;
		foreach($this->Ciudad_model->listar() as $b){ //llenar el listado de ciudades en una celda
			$sheet->setCellValue('K'.$c, $b->desc_ciudades);
			$c++;
		}
		$sheet->setCellValue('L2', '30-01-1970'); //ejemplo de fecha de nacimiento
		$sheet->setCellValue('M2', 'CHILENA'); //ejemplo de nacionalidad
		$sheet->setCellValue('M3', 'EXTRANJERA'); //ejemplo de nacionalidad
		$sheet->setCellValue('N2', 'MASCULINO'); //ejemplo de sexo
		$sheet->setCellValue('N3', 'FEMENINO'); //ejemplo de sexo
		$e = 2;
		foreach($this->Estadocivil_model->listar() as $b){ //llenar el listado de estados civiles en una celda
			$sheet->setCellValue('O'.$e, $b->desc_estadocivil);
			$e++;
		}
		$p = 2;
		foreach($this->Profesiones_model->listar() as $b){ //llenar el listado de profesiones en una celda
			$sheet->setCellValue('P'.$p, $b->desc_profesiones);
			$p++;
		}
		$e = 2;
		foreach($this->Especialidadtrabajador_model->listar() as $b){ //llenar el listado de especialidades en una celda
			$sheet->setCellValue('T'.$e, $b->desc_especialidad);
			$e++;
		}
		$a = 2;
		foreach($this->Afp_model->listar() as $b){ //llenar el listado de afp's en una celda
			$sheet->setCellValue('W'.$a, $b->desc_afp);
			$a++;
		}
		$e = 2;
		foreach($this->Excajas_model->listar() as $b){ //llenar el listado de afp's en una celda
			$sheet->setCellValue('X'.$e, $b->desc_excaja);
			$e++;
		}
		$s = 2;
		foreach($this->Salud_model->listar() as $b){ //llenar el listado de sistemas de salud en una celda
			$sheet->setCellValue('Y'.$s, $b->desc_salud);
			$s++;
		}
		$s = 2;
		foreach($this->Nivelestudios_model->listar() as $b){ //llenar el listado de niveles de estudios en una celda
			$sheet->setCellValue('AC'.$s, $b->desc_nivelestudios);
			$s++;
		}
		
		$objWriter = IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save($ruta_prin.'extras/docs_temp/excel_trabajador_tmp.xls');
		header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename=excel_trabajador_tmp.xls');
	    header('Content-Transfer-Encoding: binary');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($ruta_prin.'extras/docs_temp/excel_trabajador_tmp.xls'));
	    ob_clean();
	    flush();
		readfile($ruta_prin.'extras/docs_temp/excel_trabajador_tmp.xls');
	}

	function anotaciones($id){
		$this->load->model('Usuarios_model');
		$this->load->model('Fotostrab_model');
		$this->load->model('Tipousuarios_model');
		$this->load->model("Listanegra_model");

		$base = array(
			'head_titulo' => "Sistema EST - Anotaciones de Trabajador",
			'titulo' => "Anotaciones de Trabajador",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url'=>'est/trabajadores/buscar_js','txt' => 'Trabajadores'), array('url'=>'','txt'=>'Listado Anotaciones' )),
			'js' => array('js/ui-subview.js','js/confirm.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/anotaciones.js'),
			'menu' => $this->menu
		);

		if($id == FALSE)
			redirect('/error/error404', 'refresh');
		if(count($this->Usuarios_model->get($id)) < 1)
			redirect('/error/error404', 'refresh');

		$pagina['usuario'] = $this->Usuarios_model->get($id);
		$pagina['tipo_usuario'] = $this->Tipousuarios_model->get($pagina['usuario']->id_tipo_usuarios);
		if( $this->Fotostrab_model->get_usuario($pagina['usuario']->id) )
			$img_grande = $this->Fotostrab_model->get_usuario($pagina['usuario']->id);
		else{
			$img_grande = new stdClass();
			$img_grande->nombre_archivo = 'extras/layout2.0/img_perfil/default_thumb.jpg';
			$img_grande->thumb = 'extras/layout2.0/img_perfil/default_thumb.jpg';
		}
		$pagina['imagen_grande'] = $img_grande;
		$pagina['listado'] = $this->Listanegra_model->listar_trabajador($id);
		$pagina['id'] = $id;

		$base['cuerpo'] = $this->load->view('trabajadores/anotaciones',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_anotacion($id){
		$tipo = $_POST['tipo'];
		$fecha = $_POST['fecha'];
		$fecha = explode('-', $fecha);
		$fecha = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		$texto = $_POST['texto'];
		$quien = $_POST['quien'];
		$archivo = $_FILES['attach'];

		if($_FILES['attach']['error'] == 0){
			$this->load->helper("archivo");
			$this->load->helper("acento");
			$this->load->model("Listanegra_model");
			$this->load->model("Usuarios_model");
			
			$usuario = $this->Usuarios_model->get($id);
			$aux = str_replace(" ", "_", $usuario->nombres);
			$ape = $aux."_".$usuario->paterno.'_'.$usuario->materno;
			$nb_archivo = strtolower($ape);
			$nb_archivo = normaliza($nb_archivo);
			$salida = subir($_FILES,"attach","extras/lista/",$nb_archivo);

			if($salida == 1)
				redirect('est/trabajadores/anotaciones/'.$id, 'refresh');
			elseif($salida==2)
				redirect('est/trabajadores/anotaciones/'.$id, 'refresh');
			else{
				$data = array(
					'id_usuario' => $id,
					'archivo' => $salida,
					'tipo' => $tipo,
					'fecha' => $fecha,
					'anotacion' => $texto,
					'quien' => $quien,
 				);
				$this->Listanegra_model->ingresar($data);
				redirect('est/trabajadores/anotaciones/'.$id, 'refresh');
			}
		}
		else redirect('est/trabajadores/anotaciones/'.$id, 'refresh');
	}

	function editar_anotaciones(){
		$this->load->model("Listanegra_model");

		print_r($_POST);

		if ($_POST['name'] == "tipo"){
			$id = $_POST['pk'];

			$data = array(
				'tipo' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}

		if ($_POST['name'] == "fecha"){
			$id = $_POST['pk'];

			$data = array(
				'fecha' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}

		if ($_POST['name'] == "anotacion"){
			$id = $_POST['pk'];

			$data = array(
				'anotacion' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}


		if ($_POST['name'] == "quien"){
			$id = $_POST['pk'];

			$data = array(
				'quien' => $_POST['value'],
			);

			$this->Listanegra_model->editar($id,$data);
		}
	}

	function eliminar_anotacion($id_usuario,$id_anotacion){
		$this->load->model("Listanegra_model");
		$this->Listanegra_model->eliminar($id_anotacion);
		redirect('est/trabajadores/anotaciones/'.$id_usuario, 'refresh');
	}

	function subview_anotacion($id){
		echo $id;
	}

	function buscar_nuevo(){
		$this->load->library('encrypt');
		$this->load->helper('url');
		
		$base['titulo'] = "Listado trabajadores";
		$base['lugar'] = "Listado trabajadores";
		
		$this->load->model("Usuarios_model");
		$this->load->model("Profesiones_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Listanegra_model");
		
		$por_pag = 15;
		$num_pagina = $this->uri->segment(5, 0);
		
		if ($num_pagina == 0 || empty($num_pagina)){
			$comienzo = 0;
			$num_pagina = 1;
		}
		else{
			$comienzo = ($num_pagina - 1) * $por_pag;
		}

		if( isset($_GET['filtro']) ){
			$pagina['filtro'] = $_GET['filtro'];
			$listado_trabajadores = $this->Usuarios_model->listar_trabajadores_paginado_filtrado($_GET['filtro'],$comienzo,$por_pag);
			$total_registros = $this->Usuarios_model->listar_trabajadores_paginado_filtrado_totales($_GET['filtro']);

			$total_paginas = ceil($total_registros / $por_pag);

			if(($num_pagina - 1) > 0) $num_ant = $num_pagina - 1;
			else $num_ant = 1;
			if(($num_pagina + 1) <= $total_paginas) $num_sig = $num_pagina + 1;
			else $num_sig = $total_paginas;

			$num_ant = $num_ant.'?filtro='.$_GET['filtro'];
			$num_sig = $num_sig.'?filtro='.$_GET['filtro'];
		}
		else{
			$pagina['filtro'] = "";
			$listado_trabajadores = $this->Usuarios_model->listar_trabajadores_paginado($comienzo,$por_pag);	
			$total_registros = $this->Usuarios_model->listar_trabajadores_totales();

			$total_paginas = ceil($total_registros / $por_pag);

			if(($num_pagina - 1) > 0) $num_ant = $num_pagina - 1;
			else $num_ant = 1;
			if(($num_pagina + 1) <= $total_paginas) $num_sig = $num_pagina + 1;
			else $num_sig = $total_paginas;
		}

		$pagina['ant'] = $num_ant;
		$pagina['sig'] = $num_sig;

		$lista2 = array();
		if (isset($listado_trabajadores )){
			foreach($listado_trabajadores as $l ){
				$aux = new stdClass();
				//$usr = $this->Usuarios_model->get($r->id_usuarios);
				$m = $this->Evaluaciones_model->get_una_masso($l->id_user);
				$p = $this->Evaluaciones_model->get_una_preocupacional($l->id_user);
				$n = $this->Listanegra_model->listar_trabajador($l->id_user);
				$aux->id_user = $l->id_user;
				$aux->rut_usuario = $l->rut_usuario;
				$aux->fono = $l->fono;
				$aux->fecha_actualizacion = $l->fecha_actualizacion;
				$aux->desc_ciudades = ($l->desc_ciudades)? ucfirst(strtolower($l->desc_ciudades)):'No Ingresada';
				$aux->nombres = ucwords(mb_strtolower($l->nombres.' '.$l->paterno.' '.$l->materno,'UTF-8'));
				if (isset($m->fecha_v)){
					$m_fecha = explode('-',$m->fecha_v);
					$m_fecha = $m_fecha[2].'-'.$m_fecha[1].'-'.$m_fecha[0];
				}
				else
					$m_fecha = "No Tiene";

				if (isset($p->fecha_v)){
					$p_fecha = explode('-',$p->fecha_v);
					$p_fecha = $p_fecha[2].'-'.$p_fecha[1].'-'.$p_fecha[0];
				}
				else
					$p_fecha = "No Tiene";

				$aux->masso =  $m_fecha;
				$aux->examen_pre =  $p_fecha;

				if(empty($n)){
					$aux->ln = 0;
				}
				else{
					$cont_g = 0;
					$cont_ln = 0;
					$cont_lnp = 0;
					foreach ($n as $n) {
						if($n->tipo == "-"){
							$cont_g += 1;
						}
						if($n->tipo == "LNP"){
							$cont_lnp += 1;
						}
						if($n->tipo == "LN"){
							$cont_ln += 1;
						}
					}

					if ( $cont_g <=3 ) $aux->ln = 1;
					if ( $cont_g >= 4 || $cont_ln >= 1) $aux->ln = 2;
					if ( ($cont_g <= 3 && $cont_ln >= 1) || $cont_lnp >= 1) $aux->ln = 3;
				}
				$aux->especilidad1 = $l->desc_especialidad1;
				$aux->especilidad2 = $l->desc_especialidad2;
				$aux->especilidad3 = $l->desc_especialidad3;
				array_push($lista2,$aux);
				unset($aux,$usr);
			}
		}

		//print_r($lista);

		$pagina['listado'] = $lista2;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/listado3',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function listado_grupo(){
		$base['titulo'] = "Listado grupos";
		$base['lugar'] = "Listado grupos";

		$this->load->model("Grupo_trabajadores_model");
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");


		if(isset($_POST['ngrupo'])){
			$data = array(
				'name' => $_POST['ngrupo'],
				);
			$this->Grupo_trabajadores_model->ingresar($data);
		}
		if(isset($_GET['id'])){
			$this->Grupo_trabajadores_model->eliminar($_GET['id']);
		}
		$pagina['listado'] = $this->Grupo_trabajadores_model->listar();

		$listado = array();

		foreach ( $this->Grupo_trabajadores_model->listar() as $g) {
			$aux = new stdClass();
			$gt = $this->Grupo_trabajadores_asc_usuarios_model->cantidad_usuarios($g->id);
			$aux->grupo_id = $g->id;
			$aux->grupo_name = $g->name;
			$aux->cantidad = $gt;
			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['listado'] = $listado;
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/grupo_trabajadores',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function listado_grupo_asignados($id){
		$base['titulo'] = "Listado trabajadores asignados a grupo";
		$this->load->model("Grupo_trabajadores_model");
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Archivos_trab_model");
		$this->load->model("Estadocivil_model");
		$this->load->model("Afp_model");
		$this->load->model("Salud_model");

		$grupo = $this->Grupo_trabajadores_model->get($id);
		$base['lugar'] = $grupo->name;

		$listado = array();

		foreach ( $this->Grupo_trabajadores_asc_usuarios_model->usuarios_grupo($id) as $g) {
			$u = $this->Usuarios_model->get( $g->usuarios_id );
			
			$aux = new stdClass();
			$aux->id = $g->id;
			$aux->grupo_id = $g->grupo_trabajadores_id;
			$aux->usuario_id = $g->usuarios_id;
			$aux->usuario_nb = $u->nombres;
			$aux->usuario_app = $u->paterno;
			$aux->usuario_apm = $u->materno;
			$aux->usuario_rut = $u->rut_usuario;
			$aux->usuario_dire = $u->direccion;
			$aux->usuario_afp = $this->Afp_model->get($u->id_afp)->desc_afp;
			$aux->usuario_salud = $this->Salud_model->get($u->id_salud)->desc_salud;
			$aux->civil = $this->Estadocivil_model->get($u->id_estadocivil)->desc_estadocivil;
			$aux->nacionalidad = $u->nacionalidad;

			$aux->afp = $this->Archivos_trab_model->get_archivo($g->usuarios_id,11);
			$aux->salud = $this->Archivos_trab_model->get_archivo($g->usuarios_id,12);
			$aux->estudios = $this->Archivos_trab_model->get_archivo($g->usuarios_id,9);
			$aux->cv = $this->Archivos_trab_model->get_archivo($g->usuarios_id,13);

			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['listado'] = $listado;

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('trabajadores/grupo_trabajadores_asignados',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function eliminar_usuario_listado_grupo_asignados($id,$id_grupo){
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");

		$this->Grupo_trabajadores_asc_usuarios_model->eliminar($id);

		redirect('administracion/trabajadores/listado_grupo_asignados/'.$id_grupo, 'refresh');
	}

	function usuarios_listado_session(){
		@$id = $_POST['id'];
		@$id_rem = $_POST['id_rem'];
		$sesion = array($id);
		if( isset($id) ){
			if( $this->session->flashdata('listado_trabajadores_grupo') ){
				$sesion2 = array_merge( $this->session->flashdata('listado_trabajadores_grupo'), $sesion );
				$this->session->set_flashdata('listado_trabajadores_grupo', $sesion2);
			}
			else{
				$this->session->set_flashdata('listado_trabajadores_grupo', $sesion);
			}
		}
		if( isset($id_rem) ){
			$arreglo = $this->session->flashdata('listado_trabajadores_grupo');
			$clave = array_search($id_rem, $arreglo);
			unset($arreglo[$clave]);
			$arr = array_values($arreglo);
			$this->session->set_flashdata('listado_trabajadores_grupo', $arr);
		}
		if( !isset($id) && !isset($id_rem) )
			echo json_encode( $this->session->flashdata('listado_trabajadores_grupo') );
	}

	function guardar_usuarios_listado_session(){
		$id_grupo = $_POST['id_grupo'];
		$usuarios = json_decode($_POST['usuarios']);
		$this->load->model("Grupo_trabajadores_asc_usuarios_model");

		
		foreach ($usuarios as $u) {
			
			$arr_guardar = array(
				'grupo_trabajadores_id' => $id_grupo,
				'usuarios_id'  => $u,
			);
			$this->Grupo_trabajadores_asc_usuarios_model->ingresar($arr_guardar);
		}

		echo $usuarios;
		//var_dump($usuarios);
		
	}

	function modal_baterias($id_usu, $id_evaluacion = FALSE){
		if (!empty($id_evaluacion)){
			$this->load->model('Usuarios_model');
			$this->load->model('Cargos_model');
			$this->load->model('Evaluaciones_model');
			$this->load->model('Evaluacionesbaterias_model');
			$this->load->model('Evaluacionescargos_model');
			$lista = array();
			foreach ($this->Usuarios_model->get_datos_trabajador($id_usu) as $l){
				$aux = new stdClass();
				$get_bat_evaluaciones = $this->Evaluacionesbaterias_model->get_eval($id_evaluacion);
				$get_evaluacion = $this->Evaluaciones_model->get($id_evaluacion);
				$get_cargos_aptos_eval = $this->Evaluacionescargos_model->get_eval($id_evaluacion);

				$aux->rut_usuario = $l->rut_usuario;
				$aux->nombres = $l->nombres;
				$aux->paterno = $l->paterno;
				$aux->materno = $l->materno;

				$aux->baterias = array();
				if (!empty($get_bat_evaluaciones)){
					foreach ($get_bat_evaluaciones as $d) {
						$archivo = new StdClass();
						$archivo->nombre = urldecode($d->nombre);
						array_push($aux->baterias, $archivo);
					}
					unset($archivo);
				}

				$aux->cargos_aptos = array();
				if (!empty($get_cargos_aptos_eval)){
					foreach ($get_cargos_aptos_eval as $cg) {
						$get_cargo = $this->Cargos_model->r_get($cg->id_r_cargo);
						$archivo1 = new StdClass();
						$archivo1->nombre_cargo = isset($get_cargo->nombre)?$get_cargo->nombre:'';
						array_push($aux->cargos_aptos, $archivo1);
					}
					unset($archivo1);
				}
				
				array_push($lista,$aux);
				unset($aux);
			}
			$pagina['lista_aux'] = $lista;
		}else{
			$pagina['lista_aux'] = array();
		}
		$this->load->view('trabajadores/modal_baterias', $pagina);
	}

		function contratos_y_anexos_est(){// la vieja
		$this->load->model('Requerimientos_model');
		$base = array(
			'head_titulo' => "EST - Contratos y Anexos de Todas las Plantas",
			'titulo' => "Empresas: Arauco S.A.",
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Contratos y Anexos')),
			'side_bar' => true,
			'js' => array('js/si_exportar_excel_jquery.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','plugins/bootstrap-modal/js/bootstrap-modal.js', 'plugins/bootstrap-modal/js/bootstrap-modalmanager.js', 'js/main.js','js/evaluar_pgp.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css','plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css', 'plugins/bootstrap-modal/css/bootstrap-modal.css'),
			'menu' => $this->menu
		);

		$pagina['listado'] = $this->Requerimientos_model->todos_los_contratos_y_anexos_est();
		$base['cuerpo'] = $this->load->view('trabajadores/base_datos_contratos_y_anexos_vieja',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function restriccion_de_contratacion($rutTrabajador = FALSE){
		if ($rutTrabajador) {
			$this->session->set_userdata('searchInTable',$rutTrabajador);
			//var_dump($rutTrabajador);return false;
			
		}
		if($this->session->userdata('tipo_usuario') == 8 || $this->session->userdata('id')==10){
			$this->load->model("Usuarios_model");
			$base = array(
				'head_titulo' => "Sistema EST",
				'titulo' => "Empresas Integra Ltda.",
				'subtitulo' => '',
				'side_bar' => true,
				'js' => array('js/confirm.js','plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/searchInTable.js'),
				'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
				'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado Trabajadores') ),
				'menu' => $this->menu
			);
			$lista = array();
			$trabajadorListaNegra =  $this->Usuarios_model->getAllListaNegra();
			foreach ($trabajadorListaNegra as $t) {
				$usuario = $this->Usuarios_model->get($t->id_usuario);
				$t->nombreTrabajador = titleCase($usuario->nombres).' '.titleCase($usuario->paterno).' '.titleCase($usuario->materno);
				$t->rutTrabajador = $usuario->rut_usuario;
			}
	//return false;
			$pagina['listado'] = $trabajadorListaNegra;
			$base['cuerpo'] = $this->load->view('trabajadores/listado_lista_negra',$pagina,TRUE);
			$this->load->view('layout2.0/layout',$base);
		}else{
			redirect(base_url(), 'refresh');
		}
	}

	#yayo 21-01-2020
	function liberar_lista_negra($id){
		$this->load->model('Usuarios_model');
		$data = array(
			'estado'=>1,
			'fecha_eliminacion'=>date('Y-m-d H:i:s'),
			);
		$resultado =$this->Usuarios_model->updateListaNegra($id, $data);
		echo json_encode($resultado);
	}
	#yayo 23-01-2020
	function solicitar_liberar_lista_negra(){
		$nombre = $_POST['nombreTrabajador'];
		$rut = $_POST['rutTrabajador'];
		$this->load->library('email');
			$config['smtp_host'] = 'mail.empresasintegra.cl';
			$config['smtp_user'] = 'informaciones@empresasintegra.cl';
			$config['smtp_pass'] = '%SYkNLH1';
			$config['mailtype'] = 'html';
			$config['smtp_port']    = '2552';
			$this->email->initialize($config);
		    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Liberación - Arauco');
		    $this->email->to('jcruces@empresasintegra.cl');
		    $this->email->cc('soporte@empresasintegra.cl');
		    $this->email->subject("Restricción de Trabajador");
		    $this->email->message('Estimado se solicita liberación de trabajador: <b>'.$nombre.'</b> con rut: <b>'.$rut.'</b>, <a href="'.base_url().'est/trabajadores/restriccion_de_contratacion/'.$rut.'"> ir a liberar</a>');
		    $this->email->send();
		echo json_encode(1);
	}

}
?>