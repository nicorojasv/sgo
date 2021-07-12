<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Consulta extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		if ($this->session->userdata('logged') == FALSE)
			redirect('usuarios/login/index', 'refresh');
		/*elseif( $this->session->userdata('cargo') == 9 and $this->session->userdata('centro_costo') == 7 and $this->session->userdata('departamento') == 2 and $this->session->userdata('sucursal') == 11)
			redirect('/usuarios/login/index', 'refresh');
		elseif( $this->session->userdata('cargo') == 2 and $this->session->userdata('centro_costo') == 2 and $this->session->userdata('departamento') == 4 and $this->session->userdata('sucursal') == 10)
			redirect('/usuarios/login/index', 'refresh');*/
		elseif ($this->session->userdata('tipo') != 7) {
			redirect('usuarios/login/index', 'refresh');
		}else{
			redirect('usuarios/login/index', 'refresh');
		}
	}

	function index() {
		$base['titulo'] = "Sistema EST";
		$base['lugar'] = "Escritorio";

		$this->load->model("Usuarios_model");
		$this->load->model('Profesiones_model');
		$this->load->model('Noticias_model');
		$this->load->model('Ofertas_model');
		$this->load->model("Region_model");
		$this->load->model("Provincia_model");
		$this->load->model("Ciudad_model");
		$this->load->model("Evaluaciones_model");
		$this->load->model("Evaluacionesevaluacion_model");
		$this->load->model("Evaluacionestipo_model");
		$this->load->model("Especialidadtrabajador_model");
		$this->load->library('encrypt');
		$this->load->helper('encrypt');
		$this->load->helper('text');
		
		//$pagina['avisos'] = $this -> load -> view('avisos',$aviso,TRUE);
		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$pagina['usuario'] = $this->Usuarios_model->get($this->session->userdata('id'));
		$pagina['noticias'] = $this->Noticias_model->listar_limite(3,2);
		$pagina['capacitacion'] = $this->Noticias_model->listar_limite_cap(3,2);
		$pagina['ofertas'] = $this->Ofertas_model->listar_limite(3,2);
		
		$base['cuerpo'] = $this->load->view('home',$pagina,TRUE);
		$this->load->view('layout',$base);
	}
}

?>