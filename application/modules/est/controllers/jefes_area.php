<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Jefes_area extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('/usuarios/login/index', 'refresh');
		elseif($this->session->userdata('tipo_usuario') == 1)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin','',TRUE);
		elseif($this->session->userdata('tipo_usuario') == 2)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_interno','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 8)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_super_admin_dios','',TRUE);
		elseif( $this->session->userdata('tipo_usuario') == 10)
			$this->menu = $this->load->view('layout2.0/menus/menu_est_visualizador_general','',TRUE);
		else
			redirect('/usuarios/login/index', 'refresh');
   	}

	function index(){
	}

	function agregar($msg = FALSE){
		$base = array(
			'head_titulo' => "Sistema EST - Jefes de Area",
			'titulo' => "Aregar Jefe de Area",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Agregar')),
			'menu' => $this->menu
		);
		
		if($msg == "obligatorio"){
			$aviso['titulo'] = "Error, algún dato obligatorio esta vacio";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha guardado correctamente el cargo";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		
		if($msg == "repetido"){
			$aviso['titulo'] = "Error, este nombre ya existe para la empresa en la base de datos";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model("Requerimiento_representante_model");
			if( empty($_POST['nombre']) ){
				redirect( base_url().'est/jefes_area/agregar', 'refresh');
			}
			else{
				$data = array(
					'nombre' => trim(mb_strtoupper($_POST['nombre'] , 'UTF-8'))
				);
				$this->Requerimiento_representante_model->ingresar($data);
				redirect( base_url().'est/jefes_area/agregar/exito', 'refresh');
			}
		}

		$pagina = "";
		$base['cuerpo'] = $this->load->view('jefes_area/agregar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}
	
	function listado(){
		$this->load->library('encrypt');

		$base = array(
			'head_titulo' => "Sistema EST - Jefes de Area",
			'titulo' => "Listado de Jefes de Area",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->menu,
			'js' => array('js/confirm.js')
		);
		
		$this->load->model("Requerimiento_representante_model");
		$listado = array();
		foreach($this->Requerimiento_representante_model->listar() as $r ){
			$aux = new stdClass();
			$aux->id = $r->id;
			$aux->nombre = $r->nombre;
			array_push($listado,$aux);
			unset($aux);
		}
		$pagina['representante'] = $listado;
		$base['cuerpo'] = $this->load->view('jefes_area/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);

	}

	function guardar(){
		$this->load->model("Requerimiento_representante_model");

		if( $_POST['planta'] != 0 && !empty($_POST['representante']) ){
			$data = array(
				'nombre' => trim($_POST['representante'])
			);
			$this->Requerimiento_representante_model->ingresar($data);
			redirect('/administracion/jefes_area/listado/', 'refresh');
		}
		else
			redirect('/administracion/jefes_area/listado/', 'refresh');
	}

	
	function editar($id){
		$this->load->library('encrypt');
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Cargos";

		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);

		$this->load->model("Cargos_model");

		$pagina['cargo'] = $this->Cargos_model->r_get($id);

		$base['cuerpo'] = $this->load->view('cargos/editar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function eliminar($id){
		//$this->load->library('encrypt');
		$this->load->model("Requerimiento_representante_model");
		$this->Requerimiento_representante_model->eliminar($id);
		//$url = $this->encrypt->decode( urldecode($url) );
		//redirect( $url, 'refresh');
		redirect( base_url().'est/jefes_area/listado', 'refresh');
	}
	
	function ajax_validar_eliminar($id){
		$this->load->model("Planta_model");
		$this->load->model("Requerimiento_model");
		$this->load->model("Usuarios_model");
		$listado = array();
		$l_planta = $this->Usuarios_model->get_planta($id);
		if( count($l_planta) > 0 ){
			foreach($l_planta as $p){
				$listado['usuarios'][] = $p->nombres.' '.$p->paterno.' '.$p->materno;
			}
		}
		else
			$listado['usuarios'] = false;
		
		$l_req = $this->Requerimiento_model->get_planta($id);
		
		if( count($l_req) > 0 ){
			foreach($l_req as $r){
				$listado['requerimientos'][] = $r->nombre;
			}
		}
		else
			$listado['requerimientos'] = false;
		
		echo json_encode($listado);
	}
}

?>