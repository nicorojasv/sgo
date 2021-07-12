<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Empresas extends CI_Controller {
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
		//redirect('administracion/empresas/agregar', 'refresh');
	}

	function agregar($msg = false) {
		$base = array(
			'head_titulo' => "Sistema EST - Listado de empresas",
			'titulo' => "Agregar empresa",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'est/empresas/listado', 'txt' => 'Empresas'), array('url' => '', 'txt' => 'Agregar Empresa')),
			'menu' => $this->menu,
		);
		
		if($msg == "error_vacio"){
			$aviso['titulo'] = "Tiene que agregar los datos obligatorios";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "error_rut"){
			$aviso['titulo'] = "El rut existe en nuestros sistemas";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}
		if($msg == "exito"){
			$aviso['titulo'] = "Se ha ingresado la empresa correctamente";
			$pagina['aviso'] = $this->load->view('avisos',$aviso,TRUE);
		}

		if($_SERVER['REQUEST_METHOD'] == 'POST'){ //si se envia el post se guarda acá
			$this->load->model('Empresas_model');

			if(empty($_POST['razon']) || empty($_POST['rut']) || empty($_POST['dir']) ){
				redirect( base_url().'est/empresas/agregar', 'refresh');
			}
			else{
				$data = array(
					'rut' => $_POST['rut'],
					'razon_social' => mb_strtoupper($_POST['razon'], 'UTF-8'),
					'giro' =>  mb_strtoupper($_POST['giro'], 'UTF-8'),
					'direccion' => mb_strtoupper($_POST['dir'], 'UTF-8'),
					'web' => $_POST['web']
				);
				$this->Empresas_model->ingresar($data);
				redirect( base_url().'est/empresas/agregar/exito', 'refresh');
			}
		}

		$pagina = "";
		$base['cuerpo'] = $this->load->view('empresas/agregar',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function listado() {
		$base = array(
			'head_titulo' => "Sistema EST - Listado de empresas",
			'titulo' => "Listado de empresas",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'usuarios/home', 'txt' => 'Inicio'), array('url' => 'est/empresas/listado', 'txt' => 'Empresas'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->menu,
			'js' => array('js/confirm.js')
		);
		
		$this->load->model('Empresas_model');
		$pagina['listado_empresas'] = $this->Empresas_model->listar();
		$base['cuerpo'] = $this->load->view('empresas/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

	function eliminar($id){
		$this->load->model('Empresas_model');
		$this->Empresas_model->eliminar($id);
		//$url = $this->encrypt->decode( urldecode($url) );
		//redirect( $url, 'refresh');
		redirect( base_url().'est/empresas/listado', 'refresh');
	}

}
?>