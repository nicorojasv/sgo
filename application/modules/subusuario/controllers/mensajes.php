<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Mensajes extends CI_Controller {
	//public $noticias;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo') != 6){
			redirect('/login/index', 'refresh');
		}*/
		redirect('usuarios/login/index', 'refresh');

		// $this -> load -> model("Noticias_model");
		// $this->noticias['noticias_noleidas'] = $this -> Noticias_model -> cont_noticias_noleidas($this -> session -> userdata('id'));
		// $this->load->model("Mensajes_model");
		// $this->load->model("Mensajesresp_model");
		// $suma = 0;
		// $suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		// $suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		// foreach($this->Mensajes_model->listar_admin($this->session->userdata("id")) as $lr){
			// $suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		// }
		// $this->noticias['mensajes_noleidos'] = $suma;
   	}
	function index(){
		redirect('subusuario/mensajes/bandeja/', 'refresh');
	}
	function bandeja() {
		$this->load->model("Mensajes_model");
		$this->load->model("Usuarios_model");
		$this->load->helper('text');
		$this->load->library('encrypt');
		
		$base['titulo'] = "Mensajes";
		$base['lugar'] = "Mensajes";
		$base['lugar_aux'] = "<a href='".base_url()."subusuario/mensajes/crear' class='dialog tab'>Nuevo mensaje</a>";
		$base['class_subheader'] = "toolbar";
		
		$pagina['listado_mensajes'] = $this->Mensajes_model->listar_trabajador($this->session->userdata("id"));
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($pagina['listado_mensajes'] as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$pagina['noleidas'] = $suma;
		
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$base['cuerpo'] = $this->load->view('mensajes/mensajes',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function detalle($id) {
		$this->load->library('encrypt');
		$id = $this->encrypt->decode(urldecode($id));
		$this->load->model("Mensajes_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Mensajesresp_model");
		
		$base['titulo'] = "Mensajes";
		$base['lugar'] = "Mensajes";
		$base['lugar_aux'] = "<a href='".base_url()."subusuario/mensajes/crear' class='tab dialog'>Nuevo mensaje</a>";
		$base['class_subheader'] = "toolbar";
		
		$pagina['mensaje'] = $this->Mensajes_model->get($id);
		$pagina['respuestas'] = $this->Mensajesresp_model->listar_respuestas($id);
		$de = $this->Usuarios_model->get($pagina['mensaje']->id_usuario_envio);
		if($de->id_tipo_usuarios != 3)
			$pagina['de'] = $de->nombres." ".$de->paterno." ".$de->materno;
		else $pagina['de'] = "Administrador";
		
		if($de->id != $this->session->userdata("id")){
			$arr = array('visto_resp' => 1);
			$this->Mensajes_model->editar($id,$arr);
		}
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($pagina['listado_mensajes'] as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$pagina['noleidas'] = $suma;
		$this->Mensajesresp_model->leido($id,$this->session->userdata("id")); //updatear las respuestas leidas
		$pagina['menu'] = $this->load->view('menus/menu_subusuario','',TRUE);
		$base['cuerpo'] = $this->load->view('mensajes/mensajes_mensaje',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function crear(){
		$base['disable'] = TRUE;
		$base['para'] = "Administrador";
		$this->load->view('mensajes/crear',$base);
	}

	function responder(){
		$this->load->model("Mensajesresp_model");
		$this->load->library('encrypt');
		date_default_timezone_set('America/Santiago');
		$data = array(
			'id_mensaje' => $_POST['id'],
			'id_usuarios' => $this->session->userdata("id"),
			'texto' => $_POST['note'],
			'fecha' => date('Y-m-d H:i:s')
		);
		$this->Mensajesresp_model->ingresar($data);
		redirect(base_url()."subusuario/mensajes/detalle/".urlencode($this->encrypt->encode($_POST['id'])), 'refresh');
	}
	
	function eliminar_msj($id = FALSE){
		$this->load->library('encrypt');
		$id = $this->encrypt->decode(urldecode($id));
		$this->load->model("Mensajes_model");
		$this->Mensajes_model->eliminar($id);
		redirect(base_url()."subusuario/mensajes/bandeja/", 'refresh');
	}
}
?>