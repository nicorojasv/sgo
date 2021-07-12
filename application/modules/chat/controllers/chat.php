<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Chat extends CI_Controller {
	public $requerimiento;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif($this->session->userdata('chat') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_admin','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');*/
		redirect('usuarios/login/index', 'refresh');

		$this->load->model("Requerimiento_model");
		$this->requerimiento['requerimiento_noleidos'] = $this->Requerimiento_model->noleidas();
		$this->requerimiento['requerimiento_eliminacion'] = $this->Requerimiento_model->pet_eliminacion();
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$this->load->model("Evaluacionestipo_model");
		$this->requerimiento['listado_evaluaciones'] = $this->Evaluacionestipo_model->listar(); 
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$this->requerimiento['mensajes_noleidos'] = $suma;
   	}
	function index(){
		$this->load->model("Noticias_model");

		$base = array(
			'head_titulo' => "Sistema EST",
			'titulo' => "Empresa: Celulosa Arauco S.A.",
			'subtitulo' => 'Unidad de Negocio: Celulosa Nueva Aldea',
			'side_bar' => true,
			'js' => array(),
			'css' => array(),
			'lugar' => array(array('url' => 'home/index', 'txt' => 'Inicio'),array('url' => '', 'txt' => 'Noticias')),
			'menu' => $this->menu
		);

		$pagina['listado'] = $this->Noticias_model->listar();

		$base['cuerpo'] = $this->load->view('listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function listado(){
		$this->load->model("Chat_model");
		$data['listado'] = $this->Chat_model->listar_usuario($this->session->userdata('id'));
		$this->load->view('listado',$data);
	}

	function conversacion($to_id){
		$this->load->model("Chat_model");
		$data['to_id'] = $to_id;
		$data['conversa'] = $this->Chat_model->conversacion($to_id,$this->session->userdata('id'));
		$this->load->view('contenido',$data);
	}

	function enviar_msj(){
		$this->load->model("Chat_model");

		$from = $this->session->userdata('id');
		$to = $_POST['to_id'];
		$message = $_POST['message'];

		$data = array(
			"from_id" => $from,
			"to_id" => $to,
			"message" => mysql_real_escape_string($message),
			"sent" => date('Y-m-d H:i:s', time()),
		);

		if($this->Chat_model->ingresar($data)){
			return true;
		}
	}

}
?>