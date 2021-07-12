<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Mensajes extends CI_Controller {
	public $requerimiento;
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		/*if ($this->session->userdata('logged') == FALSE)
			 redirect('/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');
		
		elseif($this->session->userdata('tipo') != 3){
			redirect('/login/index', 'refresh');
		}*/
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
		redirect('administracion/mensajes/bandeja/', 'refresh');
	}
	function bandeja() {
		$this->load->model("Mensajes_model");
		$this->load->model("Mensajesresp_model");
		$this->load->model("Usuarios_model");
		$this->load->helper('text');
		//$this->load->library('encrypt');
		$base['titulo'] = "Mensajes";
		$base['lugar'] = "Mensajes";
		$base['lugar_aux'] = "<a href='".base_url()."administracion/mensajes/crear' class='dialog tab'>Nuevo mensaje</a>";
		$base['class_subheader'] = "toolbar";
		
		$pagina['listado_mensajes'] = $this->Mensajes_model->listar_admin($this->session->userdata("id"));
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($pagina['listado_mensajes'] as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$pagina['noleidas'] = $suma;
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('mensajes/mensajes',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function detalle($id) {
		//$this->load->library('encrypt');
		$id = base64_decode(urldecode($id)); 
		$this->load->model("Mensajes_model");
		$this->load->model("Usuarios_model");
		$this->load->model("Mensajesresp_model");
		$base['titulo'] = "Mensajes";
		$base['lugar'] = "Mensajes";
		$base['lugar_aux'] = "<a href='".base_url()."administracion/mensajes/crear' class='dialog tab'>Nuevo mensaje</a>";
		$base['class_subheader'] = "toolbar";
		
		$pagina['mensaje'] = $this->Mensajes_model->get($id);
		$lista = array();
		$comento_respuesta = FALSE;
		foreach($this->Mensajesresp_model->listar_respuestas($id) as $x){
			$validar = $this->Usuarios_model->get($x->id_usuarios);
			if($validar->id == $this->session->userdata("id"))
				$comento_respuesta = TRUE;
		}
		foreach($this->Mensajesresp_model->listar_respuestas($id) as $r){
			$aux = new stdClass();
			$validar = $this->Usuarios_model->get($r->id_usuarios);
			
			if( ($validar->id != $this->session->userdata("id")) && ($validar->id != $pagina['mensaje']->id_usuario_envio ) && ($validar->id != $pagina['mensaje']->id_usuario_resp)){
				if(!$this->session->flashdata('ver') && !$comento_respuesta){
					$pagina['admin_resp'] = $validar->nombres." ".$validar->paterno." ".$validar->materno;
					$pagina['no_mostrar'] = TRUE;
					break;
				}
			}
			$aux->id = $r->id;
			$aux->id_usuarios = $r->id_usuarios;
			$aux->texto = $r->texto;
			$aux->fecha = $r->fecha;
			
			array_push($lista,$aux);
			unset($aux);
		}
		$pagina['respuestas'] = $lista;
		$pagina['listado_mensajes'] = $this->Mensajes_model->listar_admin($this->session->userdata("id"));
		$suma = 0;
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_envio($this->session->userdata("id"));
		$suma = $suma + $this->Mensajes_model->cantidad_noleidas_resp($this->session->userdata("id"));
		foreach($pagina['listado_mensajes'] as $lr){
			$suma = $suma + $this->Mensajesresp_model->cantidad_noleidas($lr->id,$this->session->userdata("id"));
		}
		$pagina['noleidas'] = $suma;
		$de = $this->Usuarios_model->get($pagina['mensaje']->id_usuario_envio);
		if($de->id_tipo_usuarios != 3)
			$pagina['de'] = $de->nombres." ".$de->paterno." ".$de->materno;
		else $pagina['de'] = "Administrador";
		$this->Mensajesresp_model->leido($id,$this->session->userdata("id")); //updatear las respuestas leidas
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('mensajes/mensajes_mensaje',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	function crear(){
		$base['disable'] = FALSE;
		$this->load->view('mensajes/crear',$base);
	}
	
	function guardar(){
		$this->load->model("Mensajes_model");
		date_default_timezone_set('America/Santiago');
		$data = array(
			'asunto' => $_POST['asunto'],
			'id_usuario_envio' => $this->session->userdata("id"),
			'id_usuario_resp' => $_POST['id_usuario'],
			'texto' => $_POST['mensaje'],
			'fecha' => date('Y-m-d H:i:s')
		);
		$this->Mensajes_model->ingresar($data);
		redirect($_POST['url'], 'refresh');
	}
	
	function responder(){
		$this->load->model("Mensajesresp_model");
		$this->load->model("Mensajes_model");
		//$this->load->library('encrypt');
		date_default_timezone_set('America/Santiago');
		$data = array(
			'id_mensaje' => $_POST['id'],
			'id_usuarios' => $this->session->userdata("id"),
			'texto' => $_POST['note'],
			'fecha' => date('Y-m-d H:i:s')
		);
		$this->Mensajesresp_model->ingresar($data);
		$mensaje = $this->Mensajes_model->get($_POST['id']);
		$no_leido = "visto_resp";
		if( $mensaje->id_usuario_envio == $this->session->userdata("id"))
			$no_leido = "visto_resp";
		if( $mensaje->id_usuario_resp == $this->session->userdata("id"))
			$no_leido = "visto_envio";

		$d = array(
			$no_leido => 0,
		);
		$this->Mensajes_model->editar($_POST['id'],$d);
		redirect(base_url()."administracion/mensajes/detalle/".urlencode(base64_encode($_POST['id'])), 'refresh');
	}
	
	function desbloquear($id){
		$this->session->set_flashdata('ver', TRUE);
		redirect(base_url()."administracion/mensajes/detalle/".urlencode(base64_encode($id)), 'refresh');
	}

	function eliminar_msj($id = FALSE){
		//$this->load->library('encrypt');
		$id = base64_decode(urldecode($id));
		$this->load->model("Mensajes_model");
		$this->Mensajes_model->eliminar($id);
		redirect(base_url()."trabajador/mensajes/bandeja/", 'refresh');
	}

}
?>