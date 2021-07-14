<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Asistencia extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
    	$this->load->library('encrypt');
		$this->load->model("carrera/Asistencia_model");

		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 12)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin_logistica_servicios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 14)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 15)
			$this->menu = $this->load->view('layout2.0/menus/enjoy_menu_admin_supervisor','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index($fecha = false){
		/* se modifico php.ini el valor de max_input_vars* */
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> carrera',
			'side_bar' => true,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/exportarExcelEnjoy.js'),
			//'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Asistencia Trabajadores') ),
			'menu' => $this->menu
		);
		if ($fecha == false) {
			$Mes_a_trabajar = date('m');
			$anio_a_trabajar = date('Y');
			if ($Mes_a_trabajar =='01') {
				$mes = 'Enero';
			}else if ($Mes_a_trabajar == '02') {
				$mes = 'Febrero';
			}
			else if ($Mes_a_trabajar == '03') {
				$mes = 'Marzo';
			}
			else if ($Mes_a_trabajar == '04') {
				$mes = 'Abril';
			}
			else if ($Mes_a_trabajar == '05') {
				$mes = 'Mayo';
			}
			else if ($Mes_a_trabajar == '06') {
				$mes = 'Junio';
			}
			else if ($Mes_a_trabajar == '07') {
				$mes = 'Julio';
			}
			else if ($Mes_a_trabajar == '08') {
				$mes = 'Agosto';
			}
			else if ($Mes_a_trabajar == '09') {
				$mes = 'Septiembre';
			}
			else if ($Mes_a_trabajar == '10') {
				$mes = 'Octubre';
			}
			else if ($Mes_a_trabajar == '11') {
				$mes = 'Noviembre';
			}
			else if ($Mes_a_trabajar == '12') {
				$mes = 'Diciembre';
			}
			$pagina['fecha_mostrar']  = $mes;
			$pagina['fecha_guardar'] =  $anio_a_trabajar.'-'.$Mes_a_trabajar.'-01';
		}else{
			$f = explode('-', $fecha);
				$anio_a_trabajar = $f[0];
				$Mes_a_trabajar = $f[1];
			if ($Mes_a_trabajar =='01') {
				$mes = 'Enero';
			}else if ($Mes_a_trabajar == '02') {
				$mes = 'Febrero';
			}
			else if ($Mes_a_trabajar == '03') {
				$mes = 'Marzo';
			}
			else if ($Mes_a_trabajar == '04') {
				$mes = 'Abril';
			}
			else if ($Mes_a_trabajar == '05') {
				$mes = 'Mayo';
			}
			else if ($Mes_a_trabajar == '06') {
				$mes = 'Junio';
			}
			else if ($Mes_a_trabajar == '07') {
				$mes = 'Julio';
			}
			else if ($Mes_a_trabajar == '08') {
				$mes = 'Agosto';
			}
			else if ($Mes_a_trabajar == '09') {
				$mes = 'Septiembre';
			}
			else if ($Mes_a_trabajar == '10') {
				$mes = 'Octubre';
			}
			else if ($Mes_a_trabajar == '11') {
				$mes = 'Noviembre';
			}
			else if ($Mes_a_trabajar == '12') {
				$mes = 'Diciembre';
			}
			$pagina['fecha_mostrar'] = $mes;
			$pagina['fecha_guardar'] =  $anio_a_trabajar.'-'.$Mes_a_trabajar.'-01';
		}

		$lista = array();
		foreach($this->Asistencia_model->get_trabajadores_activo_asistencia() as $l){
			$aux = new stdClass();
			$verificandoAsistencia = $this->Asistencia_model->getAsistenciaPersona($l->id, $pagina['fecha_guardar']);
			if ($verificandoAsistencia) {
				$aux->asistencia = unserialize($verificandoAsistencia->asistencia);
				$aux->horaExtra = unserialize($verificandoAsistencia->horaExtra);
			}
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombres = $l->nombres;
			$aux->paterno = $l->paterno;
			$aux->materno = $l->materno; 
			$aux->estado = $l->estado;
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('asistencia/asistencia',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}



	function guardar_asistencia(){
		$this->load->model("carrera/Asistencia_model");
		$asistencia = isset($_POST['asiste'])?$_POST['asiste']:'vacio';
		$horaExtra = $this->input->post('horaExtra');
		$totalCantidadPersonas = $_POST['persona'];
		$totalPersonas = count($totalCantidadPersonas);
		$fechaSeleccionada = $_POST['mesParaGuardarAsistencia'];
		$f = explode('-', $fechaSeleccionada);
		$anio = $f[0];
		$mes = $f[1];
		$fechaTrabajando = $anio.'-'.$mes;
		$listado = array();
		if ($this->Asistencia_model->verificarSiYaGuardadoAsistenciaDelMes($fechaSeleccionada)) {
			for ($i=1; $i <= $totalPersonas; $i++) { 
				if(!empty($_POST['asiste'][$i])){
					$idTrabajador = $_POST['persona'][$i];
					$diasPresente = serialize($_POST['asiste'][$i]);
					$horaExtra = serialize($_POST['horaExtra'][$i]);
					//echo "del trabajador".$idTrabajador;
					$data = array(
							'asistencia'=>$diasPresente,
							'horaExtra'=>$horaExtra,
							);
					$this->Asistencia_model->actualizarAsistenciaTrabajador($idTrabajador, $data, $fechaSeleccionada);
				}
			}
		}else{
			for ($i=1; $i <= $totalPersonas; $i++) { 
				if(!empty($_POST['asiste'][$i])){
					$idTrabajador = $_POST['persona'][$i];
					$diasPresente = serialize($_POST['asiste'][$i]);
					$horaExtra = serialize($_POST['horaExtra'][$i]);
					$data = array(
							'id_usuario'=>$idTrabajador,
							'asistencia'=>$diasPresente,
							'horaExtra'=>$horaExtra,
							'fecha'=> $fechaSeleccionada,
							);
					$this->Asistencia_model->guardarAsistenciaTrabajador($data);
				}
			}
		}
		$this->session->set_userdata('exito',1);
		redirect('carrera/asistencia/index/'.$fechaTrabajando,'refresh');
	}

	function listado_activo_personal($siVengoDesdeBono = false){//Listado Para activar personal  para el mes
		$this->load->model("carrera/Asistencia_model");
		$this->load->model("carrera/Salud_model");
		$this->load->model("carrera/Afp_model");
		$this->load->model("carrera/Ciudades_model");
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> carrera',
			'side_bar' => true,
			//'js' => array('tabla/stacktable.js','tabla/asistenciaEnjoy.js'),
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'),
			'css' => array('tabla/stacktable.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado Trabajadores') ),
			'menu' => $this->menu
		);

		$lista = array();
		foreach($this->Asistencia_model->listar_activos() as $l){
			$aux = new stdClass();
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombres = $l->nombres;
			$aux->paterno = $l->paterno;
			$aux->materno = $l->materno; 
			$aux->estado = $l->estadoAsistencia;
			array_push($lista,$aux);
			unset($aux);
		}
		if ($siVengoDesdeBono) {
			$pagina['volverBono']= true;
		}else{
			$pagina['volverBono']= false;
		}

		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('asistencia/listado_activo_personal',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_estado_asistencia(){// guardando estado de los trabajadores activos
		$trabajadores = $this->input->post('trabajadores');
		foreach ($trabajadores as $key => $value) {
			if (!empty($_POST['estado'][$key])) {
				$data =array(
					'estadoAsistencia'=>$_POST['estado'][$key]
					);
				$this->Asistencia_model->cambiarEstadoAsistencia($value,$data);
			}
		}
		redirect('carrera/asistencia/listado_activo_personal','refresh');
	}

	//************************BONOS********************************\\
	function bonos($fecha = false){
		/* se modifico php.ini el valor de max_input_vars* */
		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresas Integra Ltda.",
			'subtitulo' => '<b>Unidad de Negocio:</b> carrera',
			'side_bar' => true,
			'js' => array('plugins/DataTables/media/js/jquery.dataTables.min.js','plugins/DataTables/FixedColumns/js/dataTables.fixedColumns.min.js','js/lista_usuarios_activos.js','plugins/bootstrap-datepicker/js/bootstrap-datepicker.js','js/exportarExcelEnjoy.js'),
			//'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/DataTables/media/css/dataTables.bootstrap.min.css','plugins/DataTables/FixedColumns/css/fixedColumns.dataTables.css'),
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Bonos Trabajadores') ),
			'menu' => $this->menu
		);
		if ($fecha == false) {
			$Mes_a_trabajar = date('m');
			$anio_a_trabajar = date('Y');
			if ($Mes_a_trabajar =='01') {
				$mes = 'Enero';
			}else if ($Mes_a_trabajar == '02') {
				$mes = 'Febrero';
			}
			else if ($Mes_a_trabajar == '03') {
				$mes = 'Marzo';
			}
			else if ($Mes_a_trabajar == '04') {
				$mes = 'Abril';
			}
			else if ($Mes_a_trabajar == '05') {
				$mes = 'Mayo';
			}
			else if ($Mes_a_trabajar == '06') {
				$mes = 'Junio';
			}
			else if ($Mes_a_trabajar == '07') {
				$mes = 'Julio';
			}
			else if ($Mes_a_trabajar == '08') {
				$mes = 'Agosto';
			}
			else if ($Mes_a_trabajar == '09') {
				$mes = 'Septiembre';
			}
			else if ($Mes_a_trabajar == '10') {
				$mes = 'Octubre';
			}
			else if ($Mes_a_trabajar == '11') {
				$mes = 'Noviembre';
			}
			else if ($Mes_a_trabajar == '12') {
				$mes = 'Diciembre';
			}
			$pagina['fecha_mostrar']  = $mes;
			$pagina['fecha_guardar'] =  $anio_a_trabajar.'-'.$Mes_a_trabajar.'-01';
		}else{
			$f = explode('-', $fecha);
				$anio_a_trabajar = $f[0];
				$Mes_a_trabajar = $f[1];
			if ($Mes_a_trabajar =='01') {
				$mes = 'Enero';
			}else if ($Mes_a_trabajar == '02') {
				$mes = 'Febrero';
			}
			else if ($Mes_a_trabajar == '03') {
				$mes = 'Marzo';
			}
			else if ($Mes_a_trabajar == '04') {
				$mes = 'Abril';
			}
			else if ($Mes_a_trabajar == '05') {
				$mes = 'Mayo';
			}
			else if ($Mes_a_trabajar == '06') {
				$mes = 'Junio';
			}
			else if ($Mes_a_trabajar == '07') {
				$mes = 'Julio';
			}
			else if ($Mes_a_trabajar == '08') {
				$mes = 'Agosto';
			}
			else if ($Mes_a_trabajar == '09') {
				$mes = 'Septiembre';
			}
			else if ($Mes_a_trabajar == '10') {
				$mes = 'Octubre';
			}
			else if ($Mes_a_trabajar == '11') {
				$mes = 'Noviembre';
			}
			else if ($Mes_a_trabajar == '12') {
				$mes = 'Diciembre';
			}
			$pagina['fecha_mostrar'] = $mes;
			$pagina['fecha_guardar'] =  $anio_a_trabajar.'-'.$Mes_a_trabajar.'-01';
		}

		$lista = array();
		foreach($this->Asistencia_model->get_trabajadores_activo_asistencia() as $l){
			$aux = new stdClass();
			$verificandoAsistencia = $this->Asistencia_model->getBonoPersona($l->id, $pagina['fecha_guardar']);
			if ($verificandoAsistencia) {
				//var_dump("entre");
				$aux->bono = unserialize($verificandoAsistencia->bono);
				$aux->anticipo = unserialize($verificandoAsistencia->anticipo);
			}
			$aux->id_usuario = $l->id;
			$aux->rut_usuario = $l->rut_usuario;
			$aux->nombres = $l->nombres;
			$aux->paterno = $l->paterno;
			$aux->materno = $l->materno; 
			$aux->estado = $l->estado;
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['listado'] = $lista;
		$base['cuerpo'] = $this->load->view('asistencia/bonos',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function guardar_bono(){
		$this->load->model("carrera/Asistencia_model");
		$asistencia = isset($_POST['asiste'])?$_POST['asiste']:'vacio';
		$horaExtra = $this->input->post('horaExtra');
		$totalCantidadPersonas = $_POST['persona'];
		$totalPersonas = count($totalCantidadPersonas);
		$fechaSeleccionada = $_POST['mesParaGuardarAsistencia'];
		$f = explode('-', $fechaSeleccionada);
		$anio = $f[0];
		$mes = $f[1];
		$fechaTrabajando = $anio.'-'.$mes;
		$listado = array();
		if ($this->Asistencia_model->verificarSiYaGuardadoBonoDelMes($fechaSeleccionada)) {
			for ($i=1; $i <= $totalPersonas; $i++) { 
				if(!empty($_POST['bono'][$i])){
					$idTrabajador = $_POST['persona'][$i];
					$bono = serialize($_POST['bono'][$i]);
					$anticipo = serialize($_POST['anticipo'][$i]);
					//echo "del trabajador".$idTrabajador;
					$data = array(
							'bono'=>$bono,
							'anticipo'=>$anticipo,
							);
					$this->Asistencia_model->actualizarBonoTrabajador($idTrabajador, $data, $fechaSeleccionada);
				}
			}
		}else{
			for ($i=1; $i <= $totalPersonas; $i++) { 
				if(!empty($_POST['bono'][$i])){
					$idTrabajador = $_POST['persona'][$i];
					$bono = serialize($_POST['bono'][$i]);
					$anticipo = serialize($_POST['anticipo'][$i]);
					$data = array(
							'id_usuario'=>$idTrabajador,
							'bono'=>$bono,
							'anticipo'=>$anticipo,
							'fecha'=> $fechaSeleccionada,
							);
					$this->Asistencia_model->guardarBonoTrabajador($data);
				}
			}
		}
		$this->session->set_userdata('exito',1);
		redirect('carrera/asistencia/bonos/'.$fechaTrabajando,'refresh');
	}

	function exportar_excel_bono_anticipo(){
		header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
		//header("Content-type: application/vnd.ms-excel; name='excel'");
		header("Content-Disposition: filename=ficheroExcel.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo utf8_decode($_POST['datos_a_enviar']);
	}


}
?>