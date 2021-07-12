<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Observaciones extends CI_Controller {

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
		$base['titulo'] = "Reportes de Trabajadores con Observaciones";
		$base['lugar'] = "Reportes";

		$this->load->model("Listanegra_model");

		$pagina['listado'] = $this->Listanegra_model->listado_usuario();


   		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$base['cuerpo'] = $this->load->view('observaciones/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

	function anotaciones($id){
		$base['titulo'] = "Reportes de Trabajadores con Observaciones";
		$base['lugar'] = "Reportes";

		$this->load->model("Listanegra_model");

		$pagina['listado'] = $this->Listanegra_model->listar_trabajador($id);


   		$pagina['menu'] = $this->load->view('menus/menu_consulta','',TRUE);
		$base['cuerpo'] = $this->load->view('observaciones/listado',$pagina,TRUE);
		$this->load->view('layout',$base);
	}

}
?>