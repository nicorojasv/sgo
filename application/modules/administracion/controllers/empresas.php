<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Empresas extends CI_Controller {
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
		redirect('administracion/empresas/agregar', 'refresh');
	}
	function agregar($msg = false) {
		
		$base['titulo'] = "Agregar Empresa";
		$base['lugar'] = "Agregar Empresa";
		
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
		
		$pagina['menu'] = $this->load->view('menus/menu_admin',$this->requerimiento,TRUE);
		$base['cuerpo'] = $this->load->view('empresas/agregar',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
	
	function guardar(){
		if(empty($_POST['razon']) || empty($_POST['rut']) || empty($_POST['dir']) ){
			redirect('administracion/empresas/agregar/error_vacio', 'refresh');
		}
		else{
			$this->load->model('Empresas_model');
			if($this->Empresas_model->get_rut($_POST['rut']))
				redirect('administracion/empresas/agregar/error_rut', 'refresh');
			else{
				$data = array(
					'rut' => $_POST['rut'],
					'razon_social' => mb_strtoupper($_POST['razon'], 'UTF-8'),
					'giro' =>  mb_strtoupper($_POST['giro'], 'UTF-8'),
					'direccion' => mb_strtoupper($_POST['dir'], 'UTF-8'),
					'web' => $_POST['web']
				);
				$this->Empresas_model->ingresar($data);
				redirect('administracion/empresas/agregar/exito', 'refresh');
			}
		}
	}
	
	function buscar() {
		$base = array(
			'head_titulo' => "Sistema EST - Listado de empresas",
			'titulo' => "Listado de empresas",
			'subtitulo' => '',
			'side_bar' => true,
			'lugar' => array(array('url' => 'administracion/index', 'txt' => 'Inicio'), array('url' => 'administracion/empresas/index', 'txt' => 'Empresas'), array('url' => '', 'txt' => 'Listado')),
			'menu' => $this->load->view('layout2.0/menus/menu_admin','',TRUE)
		);
		
		$this->load->model('Empresas_model');
		$pagina['listado_empresas'] = $this->Empresas_model->listar();
		$base['cuerpo'] = $this->load->view('empresas/listado',$pagina,TRUE);
		$this->load->view('layout2.0/layout',$base);
	}

}
?>