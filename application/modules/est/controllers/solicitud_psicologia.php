<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Solicitud_psicologia extends CI_Controller{
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		$this->load->model("Empresa_planta_model");
		$this->load->model("Solicitud_psicologia_model");
		$this->load->model("usuarios/Usuarios_general_model");
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 4)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_externo','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 5)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_psicologo','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
		$base = array(
			'head_titulo' => "Solicitud Evaluaciones Psicológicas",
			'titulo' => "Solicitud Evaluaciones Psicológicas",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Solicitud Evaluaciones Psicológicas')),
			'menu' => $this->menu,
			'js' => array('js/validar_rut_psicologiajs.js','js/confirm.js','js/lista_req.js','plugins/flatpickr/flatpickr.js','js/crud_agregar_usuario.js'),
			'css' => array('plugins/DataTables/media/css/jquery.dataTables.min.css','plugins/flatpickr/flatpickr.min.css','css/buttons.dataTables.min.css'),
		);
		//var_dump($this->session->userdata('id'));return false;
		$this->session->set_userdata('listado_psicologia',true);
		if ($this->session->userdata('tipo_usuario') == 8 || $this->session->userdata('tipo_usuario')==5) {
			//puede ver todo
			$solicitudes =$this->Solicitud_psicologia_model->getAllSolicitud();
			foreach ($solicitudes as $key ) {
				$get_solicitante = $this->Usuarios_general_model->get($key->id_administrador);
				$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
				$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
				$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
				$key->solicitado = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
			}
			$pagina['listado']= $solicitudes;
		}else{
			$id = $this->session->userdata('id');
			$solicitudes =$this->Solicitud_psicologia_model->getMiSolicitud($id);
			foreach ($solicitudes as $key ) {
				$key->solicitado= $this->session->userdata('nombres');
			}
			$pagina['listado']= $solicitudes;
		}
		$pagina['listado_empresas_planta'] = $this->Empresa_planta_model->listar();
		//$pagina['listado'] = false;
		$base['cuerpo'] = $this->load->view('solicitud_psicologia/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function modal_editar($id){
		$pagina['listado_empresas_planta'] = $this->Empresa_planta_model->listar();
		$pagina['datos_horario'] = $this->Descripcion_horarios_model->get_result($id);
		$this->load->view('est/horarios/modal_editar_horario', $pagina);
	}

	function guardar_solicitud(){

		$idSolicitud =$this->Solicitud_psicologia_model->getIdTtrabajador($_POST['rut']);
		$data = array(
			"rut" => $_POST['rut'],
			"id_trabajador" => $idSolicitud->id,
			"id_administrador"=> $this->session->userdata('id'),
			"nombre_evaluado" => $_POST['nombre_evaluado'],
			"fono" => $_POST['fono'],
			"residencia" => $_POST['residencia'],
			"especialidad" => $_POST['especialidad'],
			"tipo_cargo" => $_POST['tipo_cargo'],
			"lugar_trabajo" => $_POST['lugar_trabajo'],
			"referido" => $_POST['referido'],
			"fecha_ingreso" => $_POST['fecha_ingreso'],
			"hal" => $_POST['hal'],
			"comentario" => $_POST['comentario'],
			"estado" => 1,
		);
		$get_solicitante = $this->Usuarios_general_model->get($this->session->userdata('id'));
		$nombre_solicitante = isset($get_solicitante->nombres)?$get_solicitante->nombres:'';
		$paterno_solicitante = isset($get_solicitante->paterno)?$get_solicitante->paterno:'';
		$materno_solicitante = isset($get_solicitante->materno)?$get_solicitante->materno:'';
		$nombre_completo_solicitante = $nombre_solicitante.' '.$paterno_solicitante.' '.$materno_solicitante;
		$email_solicitante = isset($get_solicitante->email)?$get_solicitante->email:'';

		$idSolicitud =$this->Solicitud_psicologia_model->guardar_solicitud($data);
		$this->load->library('email');
		$config['smtp_host'] = 'mail.empresasintegra.cl';
		$config['smtp_user'] = 'informaciones@empresasintegra.cl';
		$config['smtp_pass'] = '%SYkNLH1';
		$config['mailtype'] = 'html';
		$config['smtp_port']    = '2552';
		$this->email->initialize($config);

	    $this->email->from('informaciones@empresasintegra.cl', 'Solicitud Evaluaciones Psicológicas');
	    $this->email->to('psicologos@empresasintegra.cl');
		//$this->email->cc('contratos@empresasintegra.cl');
		$this->email->subject("Nueva Solicitud de evaluación");
	    $this->email->message('Una nueva solicitud de evaluación ha sido generada por el administrador:'.$nombre_completo_solicitante.'.<br><br> Trabajador: '.$_POST['nombre_evaluado'].'<br>Fecha de ingreso estimada: '.$_POST['fecha_ingreso'].'<br> Referido: '.$_POST['referido'].'<br> Fono: '.$_POST['fono'].'<br> Hal: '.$_POST['hal'].'<br> '.$_POST['comentario'].' ');
	    $this->email->send();
		$this->session->set_userdata('exito',true);
		redirect('est/solicitud_psicologia', 'refresh');
	}



}

?>